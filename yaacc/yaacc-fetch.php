<?php
header("Content-type: text/xml");
/*
Filename: 		yaacc-fetch.php
Date: 			2007-08-05
Copyright: 		Kenji Baheux
Author: 		Kenji Baheux
Version:        1.1
Last modified:  2008-06-12
Changelog:
1.1: division by zero bug when invalid response (invalid currency...)
1.0: code cleaning, added cache optimization with computation of reverse rate
0.9.3: fixed bug, added version, referer check
0.9:   Initial release
Description: 	PHP Back-end to fetch and cache currency conversion rates. 
*/

/*  Copyright 2008  Kenji BAHEUX (webmestre 'AT' commecadujapon 'DOT' com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Exit if parameters are not specified
if((!isset($_GET['from']) || '' == $_GET['from']) || (!isset($_GET['to']) || '' == $_GET['to']))
{
    echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
    ?>
    <response>
    <conversion-rate>0.0</conversion-rate>
    <date>:-(</date>
    </response>	
    <?
    exit();
}

$cache_conversion = dirname(__FILE__) . "/conversions/";
$cache_tolerance = 60*60*24;
$webServiceURL = "http://www.commecadujapon.com/php/conversion-rate.php";
define ('YAACC_VERSION', "1.1");

// Last resort function
// Source : http://www.php-mysql-tutorial.com/php-tutorial/php-read-remote-file.php
function getRemoteFile($url)
{
   // get the host name and url path
   $parsedUrl = parse_url($url);
   $host = $parsedUrl['host'];
   if (isset($parsedUrl['path'])) {
      $path = $parsedUrl['path'];
   } else {
      // the url is pointing to the host like http://www.mysite.com
      $path = '/';
   }

   if (isset($parsedUrl['query'])) {
      $path .= '?' . $parsedUrl['query'];
   }

   if (isset($parsedUrl['port'])) {
      $port = $parsedUrl['port'];
   } else {
      // most sites use port 80
      $port = '80';
   }

   $timeout = 10;
   $response = '';

   // connect to the remote server
   $fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

   if($fp )
   {
      $referer = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
      // send the necessary headers to get the file
      fputs($fp, "GET $path HTTP/1.0\r\n" .
                 "Host: $host\r\n" .
                 "User-Agent: YAACC/" . YAACC_VERSION . "\r\n" .
                 "Accept: */*\r\n" .
                 "Accept-Language: en-us,en;q=0.5\r\n" .
                 "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
                 "Keep-Alive: 300\r\n" .
                 "Connection: keep-alive\r\n" .
                 "Referer: ".$referer."\r\n\r\n");

      // retrieve the response from the remote server
      while ( $line = fread( $fp, 4096 ) ) {
         $response .= $line;
      }

      fclose( $fp );

      // strip the headers
      $pos      = strpos($response, "\r\n\r\n");
      $response = substr($response, $pos + 4);
   }

   // return the file content
   return $response;
}

function isCacheValid($cache_file, $cache_tolerance_s)
{
    $cache_is_valid = FALSE;
    
    flush();
    // check how old the cache file is
    if (file_exists($cache_file))
    {
        clearstatcache();  // filemtime info gets cached so we must ensure that the cache is empty
        $cache_age_s = time() - filemtime($cache_file);
        $cache_is_valid = $cache_age_s <= $cache_tolerance_s;
    }

    return $cache_is_valid;
}

function contactWebService($webServiceURL)
{
    $failed = TRUE;
    $response = "";
    
    if (function_exists('curl_init'))
    {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $webServiceURL);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_USERAGENT, "YAACC/" . YAACC_VERSION);
       curl_setopt ($ch, CURLOPT_REFERER, "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);

       $response = curl_exec($ch);

       curl_close($ch);
       $failed = ($response === FALSE);
    }
    else
    {
       $url = $webServiceURL . "&ref=" . urlencode($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
       $response = getRemoteFile($url);
       $failed = empty($response);
    }

    if ($failed)
    {
        if (ini_get('allow_url_fopen') == '1')
        {
            $url = $webServiceURL . "&ver=" . YAACC_VERSION . "&ref=" . urlencode($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']); 

            if ($fp = @fopen($url, 'r')) {
               while ($line = fread($fp, 1024)) {
                  $response .= $line;
               }
            }
            else
            {
               $response = @file_get_contents($url);
               $failed = ($response === false);
            }
        }
    }
    
    return $response;
}

function writeCache($cache_file, $cache_contents)
{
    $handle = fopen($cache_file, "w");
    if ($handle)
    {
       fwrite($handle, $cache_contents);
       fclose($handle);
    }
}


function getReverseResponse($rate_response)
{
    $reverse_response = '';
    $pattern = '/(.*<conversion-rate>)((\.[0-9]+)|([0-9]+(\.[0-9]*)?))(<\/conversion-rate>.*)/is';
    $matched = preg_match($pattern, $rate_response, $matches);
    if ($matched && $matches[2] > 0.0)
    {
        $reverse_response = $matches[1] . 1.0 / floatval($matches[2]) . $matches[6];
    }    
    
    return $reverse_response;
}

function updateCache($cache_file, $webserviceURL)
{
    $response = contactWebService($webserviceURL);
    if (strlen($response) > 0) // write the cache
    {
        writeCache($cache_file, $response);
    }
    
    return $response;
}

function getConversionRate($from, $to)
{
    global $cache_tolerance, $cache_conversion, $webServiceURL;
    $cache_file = $cache_conversion . md5($from) . "-" . md5($to);
    
    if  (isCacheValid($cache_file, $cache_tolerance))
    {
        return file_get_contents($cache_file);
    }
    
    $url = $webServiceURL . "?from=" . $from . "&to=" . $to;
    $cache_contents = updateCache($cache_file, $url);
    
    if (strlen($cache_contents) > 0)
    {
        $cache_file_reverse = $cache_conversion . md5($to) . "-" . md5($from);
        $reverse_response = getReverseResponse($cache_contents);
        if (strlen($reverse_response) > 0)
        {
            writeCache($cache_file_reverse, $reverse_response);
        }
    }
    else
    {
        $cache_contents = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<response>\n<conversion-rate>0.0</conversion-rate>\n<date>:-(</date>\n</response>";
    }

    return $cache_contents;
}

$from = substr($_GET['from'],0,3);
$to = substr($_GET['to'],0,3);
// If from and to are the same then don't bother calling the remote web service
if (strcmp($from, $to) == 0)
{
    $response = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<response>\n<conversion-rate>1.0</conversion-rate>\n<date>:-D</date>\n</response>";
}
else
{
    $response = getConversionRate($from, $to);
}

echo($response);
?>