=== Pagination by BestWebSoft ===
Contributors: bestwebsoft
Donate link: http://bestwebsoft.com/donate/
Tags: pagination, pagination block, custom pagination block, multiple navigation, multiple pages, navigation, next page, post pagination, pagination buttons, pagination plugin, improve pages navigation, paginate plugin
Requires at least: 3.8
Tested up to: 4.5.3
Stable tag: 1.0.5
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add customizable pagination to WordPress website. Split long content to multiple pages for better navigation.

== Description ==

The Pagination plugin allows you to add a custom pagination block to your webpages. The block is added automatically on the following pages: blog, search, archive, category, tags, author. All you have to do is to choose the position of the pagination block and configure its appearance on the plugin settings page.

http://www.youtube.com/watch?v=TwAd3DWLGr8

<a href="http://www.youtube.com/watch?v=Xh0LjOSgxzs" target="_blank">Pagination by BestWebSoft Video instruction on Installation</a>

<a href="http://wordpress.org/plugins/pagination/faq/" target="_blank">Pagination by BestWebSoft FAQ</a>

<a href="http://support.bestwebsoft.com" target="_blank">Pagination by BestWebSoft Support</a>

= Features =

* Add pagination to templates where it is absent or replace the standard pagination.
* Configure custom pagination block to fit your theme.
* Choose block position on the page.
* Display custom pagination block for chosen post types only.

If you have a feature, suggestion or idea you'd like to see in the plugin, we'd love to hear about it! <a href="http://support.bestwebsoft.com/hc/en-us/requests/new" target="_blank">Suggest a Feature</a>

= Recommended Plugins =

The author of the Pagination also recommends the following plugins:

* <a href="http://wordpress.org/plugins/updater/">Updater</a> - This plugin updates WordPress core and the plugins to the recent versions. You can also use the auto mode or manual mode for updating and set email notifications.
There is also a premium version of the plugin <a href="http://bestwebsoft.com/products/updater/">Updater Pro</a> with more useful features available. It can make backup of all your files and database before updating. Also it can forbid some plugins or WordPress Core update.

= Translation =

* Russian (ru_RU)
* Ukrainian (uk)

If you create your own language pack or update the existing one, you can send <a href="http://codex.wordpress.org/Translating_WordPress" target="_blank">the text in PO and MO files</a> for <a href="http://support.bestwebsoft.com/hc/en-us/requests/new" target="_blank">BestWebSoft</a> and we'll add it to the plugin. You can download the latest version of the program for work with PO and MO files <a href="http://www.poedit.net/download.php" target="_blank">Poedit</a>.

= Technical support =

Dear users, our plugins are available for free download. If you have any questions or recommendations regarding the functionality of our plugins (existing options, new options, current issues), please feel free to contact us. Please note that we accept requests in English only. All messages in other languages won't be accepted.

If you notice any bugs in the plugins, you can notify us about it and we'll investigate and fix the issue then. Your request should contain URL of the website, issues description and WordPress admin panel credentials.
Moreover we can customize the plugin according to your requirements. It's a paid service (as a rule it costs $40, but the price can vary depending on the amount of the necessary changes and their complexity). Please note that we could also include this or that feature (developed for you) in the next release and share with the other users then. 
We can fix some things for free for the users who provide translation of our plugin into their native language (this should be a new translation of a certain plugin, you can check available translations on the official plugin page).

== Installation ==

1. Upload the `pagination` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin using the 'Plugins' menu in your WordPress admin panel.
3. You can adjust the necessary settings using your WordPress admin panel in "BWS Panel" > "Pagination".

<a href="https://docs.google.com/document/d/1FIQaZEt0xVZkCXKh2DxVkjcHdrVDGlGSUjQE-qxzbKk/edit" target="_blank">View a Step-by-step Instruction on Pagination Installation</a>.

http://www.youtube.com/watch?v=Xh0LjOSgxzs

== Frequently Asked Questions ==

= Where can I find the settings to adjust the plugin work after activation? =

In the 'Plugin' menu you can find a link to the settings page.

= Can I replace the standard pagination in my theme? =

Yes, in the HIde pagination block you can choose any pagination to be displayed as well as to hide your theme`s standard pagination.

= How can I remove the custom pagination? =

In order to hide it, type a block class or block id into the text field in the Hide pagination block and check the "Custom" checkbox.

= I filled up all necessary settings, save the changes, but the custom pagination block did not appeared on some (or all) necessary pages. How can I fix it? =

Most likely that your theme was created uncorrectly and it does not provide the needed functionality to display custom pagination block. Please, contact your support service (<a href="http://support.bestwebsoft.com" target="_blank">http://support.bestwebsoft.com</a>) and we will help you to solve this issue.

= I have custom post types where I output the information via custom query to the database. How can I add the pagination block to this custom post type? =

It is necessary to add function <?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'custom', $second_query ); ?> to the necessary place. In this function, specify the name of your custom query to the database instead of $second_query.

= I have some problems with the plugin's work. What Information should I provide to receive proper support? =

Please make sure that the problem hasn't been discussed yet on our forum (<a href="http://support.bestwebsoft.com" target="_blank">http://support.bestwebsoft.com</a>). If no, please provide the following data along with your problem's description:

1. the link to the page where the problem occurs
2. the name of the plugin and its version. If you are using a pro version - your order number.
3. the version of your WordPress installation
4. copy and paste into the message your system status report. Please read more here: <a href="https://docs.google.com/document/d/1Wi2X8RdRGXk9kMszQy1xItJrpN0ncXgioH935MaBKtc/edit?pli=1" target="_blank">Instruction on System Status</a>

== Screenshots ==

1. Custom pagination block in the front-end - shorthand output.
2. Custom pagination block in the front-end with all page numbers.
3. Plugin settings in WordPress admin panel.
4. Appearance settings in WordPress admin panel.

== Changelog ==

= V1.0.5 - 20.07.2016 =
* NEW : Ability to disable plugin styles.
* Update : Color Picker was updated.
* Update : BWS panel section was updated.

= V1.0.4 - 19.04.2016 =
* NEW : Ability to use for custom post types with custom queries to the dababase.
* NEW : Ability to add custom styles.
* Bugfix : The conflict in the RSS feed was fixed.

= V1.0.3 - 30.12.2015 =
* Bugfix : Displaying pagination block on the archive page and multipages was fixed.
* Bugfix : The bug with plugin menu duplicating was fixed.

= V1.0.2 - 30.10.2015 =
* Update : BWS plugins section is updated.
* Update : We updated all functionality for wordpress 4.3.1.

= V1.0.1 - 09.07.2015 =
* NEW : Ability to restore settings to defaults.

= V1.0.0 - 20.05.2015 =
* NEW : We added the ability to configure the custom pagination block.
* NEW : The Russian and Ukrainian language files were added.
* Update : We updated all functionality for wordpress 4.2.2.

== Upgrade Notice ==

= V1.0.5 =
* Functionality expanded.
* Usability improved.

= V1.0.4 =
Ability to use for custom post types with custom queries to the dababase. Ability to add custom styles. The conflict in the RSS feed was fixed.

= V1.0.3 =
Displaying pagination block on the archive page and multipages was fixed. The bug with plugin menu duplicating was fixed.

= V1.0.2 =
BWS plugins section is updated. We updated all functionality for wordpress 4.3.1.

= V1.0.1 =
Ability to restore settings to defaults.

= V1.0.0 =
We added the ability to configure the custom pagination block. The Russian and Ukrainian language files were added. We updated all functionality for wordpress 4.2.2.
