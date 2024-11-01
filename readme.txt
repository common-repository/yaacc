=== Plugin Name ===
Contributors: kenji.baheux
Donate link: http://www.commecadujapon.com/
Tags: currency,converter,rate,exchange,ajax,widget,e-commerce
Requires at least: 2.0.2
Tested up to: 2.5.1
Stable tag: 1.1.1

A currency converter widget for WordPress.

== Description ==

YAACC: Yet Another AJAX Currency Converter widget for WordPress features a intuitive UI and advanced caching of currency rates.


== Installation ==

Upgrade from a previous version (< 1.0):

1. Save a copy of your existing yaacc.php and delete everything under the wp-content/plugins/yaacc/ directory.
2. Open your copy of the old yaacc.php so that you can see your previous currencies settings. Follow the installation steps below.


Fresh install:

1. Open the currencies.php file under 'yaacc/settings/' in a text editor and comment the currencies you don't need (by adding // at the beginning of the line) and uncomment the currencies you need (by removing the '//'). Save the file.

2. Upload the whole 'yaacc' directory to the `/wp-content/plugins/` directory. Important: Make sure that you have a 'conversions' directory under 'yaacc' and that it is writable.

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Go to the 'Presentation' menu in WordPress and then go to the 'Sidebar Widgets' menu in WordPress. Drag and drop the yaacc widget in one of your sidebar

5. Click on the option icon and fill up a title (optional), the initial currencies for each input fields and the initial amount of money. Validate the option dialog (type the enter key after you input the initial amount of money).


== Frequently Asked Questions ==

= How often are the conversion rate updated? =
The conversion rates are updated every 24 hours.

= The widget is not working and the spinning ball animation does not stop =
Make sure that you have a writable 'conversions' directory under 'yaacc'.

== Screenshots ==

1. This is the currency converter widget interface.
2. This is the widget option dialog. You can set a title, the initial currencies and an initial amount of money.