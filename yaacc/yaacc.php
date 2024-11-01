<?php
/*
Plugin Name: YAACC
Plugin URI: http://www.commecadujapon.com/entries/20070805-convertisseur-de-devises-widget-wordpress.html
Description: Yet Another AJAX Currency Converter
Version: 1.1
Changelog: 1.1 fixed img path 
Author: Kenji Baheux
Author URI: http://www.commecadujapon.com
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

define ('YAACC_VERSION', "1.1");
define ('YAACC_OPTIONS', 'widget_yaacc');
if  (!defined('PLUGINDIR'))
{
	define('PLUGINDIR', 'wp-content/plugins');
}

require_once(ABSPATH.PLUGINDIR.'/yaacc/settings/currencies.php');

function widget_yaacc_init() {
   
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
    
	function widget_yaacc_options()
	{

		return array(
			'title' => "",
			'defaultFromCurrency' => "JPY",
			'defaultToCurrency' => "EUR2",
            'defaultAmount' => "100"
		);

	}
    
    function widget_yaacc($args)
	{
        global $currency_list;
		extract($args);

        $options = array_merge(widget_yaacc_options(), get_option(YAACC_OPTIONS));
		unset($options[0]);		
		
		echo $before_widget . $before_title . $options['title'] . $after_title;
		$yaacc_assets_url = get_option('siteurl') . "/wp-content/plugins/yaacc/assets/";
		?>
		
		<!-- Begin yaacc Code -->
		<!-- Main Widget Display Begin -->
		<style type="text/css">.yaacc-fieldset{width:160px;border:solid 1px #060;margin:3px}#ajax-working>img{vertical-align:middle}.yaacc-textfield{padding:2px 8px 0px 3px;text-align:right;height:20px;width:80px;border:solid 0 #fff;background:transparent url("<?php echo ($yaacc_assets_url . "textfield_bg.gif");?>") no-repeat;fixed}.yaacc-uniquecurrency{padding-left:10px;}.yaacc-fieldset>input.yaacc-textfield{background:transparent url("<?php echo ($yaacc_assets_url . "textfield_bg.gif");?>") no-repeat}.yaacc-selectfield{height:20px;width:55px}div#yaacc-info{text-align:right;padding-right:10px;font-size:0.8em}div#yaacc-info>#get-yaacc-widget a{color:#080}</style>
        <script type="text/javascript" src="<?php echo get_option('siteurl') . '/wp-content/plugins/yaacc/js/all.js'; ?>"></script>
        <script type="text/javascript">
            // Plugin Path
            var yaacc_plugin_path = '<?php echo get_option('siteurl'); ?>' + '/wp-content/plugins/yaacc/';
            var yaacc_plugin_assets_path = yaacc_plugin_path + 'assets/';

            // Ajax working feedback
            // Source : http://www.ajaxload.info
            var yaacc_ajax_working = '<img src="' + yaacc_plugin_assets_path + 'ajax-working.gif" alt="Ajax working" width="32" height="32" />';
            // Yaacc Icon
            // Source : http://www.beauticons.com.ar/icons.html
            var yaacc_icon = '<img src="' + yaacc_plugin_assets_path + 'money.png" alt="currency converter"  width="32" height="32" />';
            
            // Converter URL
            var yaacc_fetch = yaacc_plugin_path + 'yaacc-fetch.php';
       </script>
		<div id="yaacc">
        <form>
        <fieldset class="yaacc-fieldset">
        <legend class="yaacc-legend"><span id="ajax-working"><img src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/yaacc/assets/money.png" width="32" height="32" alt="currency converter" /></span></legend>
        <input class="yaacc-textfield" id="free-units-from" size="10" type="text" onkeyup="updateFreeUnitsFrom();" value="<?php echo($options['defaultAmount']); ?>"/>
        <select class="yaacc-selectfield" id="from-currency" onchange="getConversionRate();" <?php if (count($currency_list) <=2) { echo("style=\"display:none\""); } ?>>
        <?php 
			// Loop and add the options
			foreach($currency_list as $key => $value)
            {?><option value="<?php echo $key; ?>" <?php if ($options['defaultFromCurrency'] == $key) { echo("selected=\"selected\""); } ?>><?php _e($value,"yaacc"); ?></option><? } ?>
        </select>
        <?php if (count($currency_list) <=2) {?><span class="yaacc-uniquecurrency"><?php _e($currency_list[$options['defaultFromCurrency']],"yaacc");?></span><?php }?>

        <br />
        <input class="yaacc-textfield" id="free-units-to" size="10" type="text" onkeyup="updateFreeUnitsTo();"/>
        <select class="yaacc-selectfield" id="to-currency" onchange="getConversionRate();" <?php if (count($currency_list) <=2) { echo("style=\"display:none\""); }?>>
            <?foreach($currency_list as $key => $value)
            {?><option value="<?php echo $key; ?>" <?php if ($options['defaultToCurrency'] == $key) { echo("selected=\"selected\""); } ?>><?php _e($value,"yaacc"); ?></option><? } ?>
        </select>
        <?php if (count($currency_list) <=2) {?><span class="yaacc-uniquecurrency"><?php _e($currency_list[$options['defaultToCurrency']],"yaacc");?></span><?php }?>
        <br />
        <div id="yaacc-info">
        <span id="conversion-date"><?php _e("N/A","yaacc"); ?></span>
        <br />
        <span id="get-yaacc-widget"><?php printf(__("Get this <a href=\"%1s\" target=\"_blank\" title=\"%2s\">widget</a> !","yaacc"),__("http://www.commecadujapon.com/entries/20070805-convertisseur-de-devises-widget-wordpress.html","yaacc"), __("A free Ajax-powered currency converter widget for your WordPress blog","yaacc")); ?></span>
        </div><!-- yaacc-info div -->
        <input type="hidden" id="conversion-rate" />
        </fieldset>
        </form>
        <!-- Precaching the "Ajax working" gif -->
        <div style="display:none"><img src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/yaacc/assets/ajax-working.gif" width="32" height="32" alt="Precaching: Ajax working" />
        </div> <!-- div ajax working caching -->
        </div> <!-- div yaacc -->
		<!-- Widget Div Display End -->
		<script type="text/javascript">
        //initial update
        getConversionRate();
       </script>
        <!-- End yaacc Code -->

		<?php
	
	}
	

    function widget_yaacc_control()
	{	
        $options = array_merge(widget_yaacc_options(), get_option(YAACC_OPTIONS));
		unset($options[0]);	
		
		if ( $_POST['yaacc-submit'] )
		{

            $options['title'] = strip_tags(stripslashes($_POST['yaacc-title']));
			$options['defaultFromCurrency'] = strip_tags(stripslashes($_POST['yaacc-default-curr-from']));
			$options['defaultToCurrency'] = strip_tags(stripslashes($_POST['yaacc-default-curr-to']));
			$options['defaultAmount'] = strip_tags(stripslashes($_POST['yaacc-amount']));

			update_option(YAACC_OPTIONS, $options);

		}
		?>

		<script type="text/javascript">
			// Checks whether the value entered for Decimal Places is a 
			// number or not
			function checkDefaultAmount()
			{
				// If invalid value entered, clear field
				if(isNaN(document.getElementById('yaacc-amount').value))
					document.getElementById('yaacc-amount').value = '';
								
			} // checkDefaultAmount
		</script>
		
		<p><strong><?php printf(__("YAACC V.%s: settings", "yaacc"), YAACC_VERSION); ?></strong></p>
		
		<hr noshade />
		<?php _e("Title:","yaacc"); ?> <input type="text" id="yaacc-title" name="yaacc-title" maxlength="40"style="border: 1px solid #ece; width: 90px;" value="<?php echo htmlspecialchars($options['title'], ENT_QUOTES); ?>" />
		<br /><br />
        
		<?php _e("Default 'From currency':","yaacc"); ?> <select id="yaacc-default-curr-from" name="yaacc-default-curr-from">
			<?php global $currency_list;
				// Loop and add the options
				foreach($currency_list as $key => $value)
                {?><option value="<?php echo $key; ?>" <?php if ($options['defaultFromCurrency'] == $key) { echo("selected=\"selected\""); } ?>><?php _e($value,"yaacc"); ?></option><? } ?>
		</select>
		<br /><br />

		<?php _e("Default 'To Currency' :","yaacc");?> <select id="yaacc-default-curr-to" name="yaacc-default-curr-to">
			<?php global $currency_list;
				// Loop and add the options
				foreach($currency_list as $key => $value)
                {?><option value="<?php echo $key; ?>" <?php if ($options['defaultToCurrency'] == $key) { echo("selected=\"selected\""); } ?> ><?php _e($value,"yaacc"); ?></option><? } ?>
		</select>
		<br /><br />
		
		<?php _e("Default initial amount:","yaacc"); ?> <input type="text" id="yaacc-amount" name="yaacc-amount" maxlength="8" style="border: 1px solid #ece; width: 90px;" value="<?php echo htmlspecialchars($options['defaultAmount'], ENT_QUOTES); ?>" onkeyup="checkDefaultAmount();" />
		
		<input type="hidden" id="yaacc-submit" name="yaacc-submit" value="1" />
        <br />
        <?php _e("Note: edit the currencies.php file in the settings directory to modify the list of available currencies.","yaacc"); ?>
		<?php

	}
	
	register_sidebar_widget('yaacc', 'widget_yaacc');	
    register_widget_control('yaacc', 'widget_yaacc_control', 380, 250 );	
}


function yaacc_init() {
	load_plugin_textdomain('yaacc', PLUGINDIR.'/yaacc');
	do_action('yaacc_init');
}

add_action('init', 'yaacc_init', 5);
add_action('plugins_loaded', 'widget_yaacc_init');

?>