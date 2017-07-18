=== Pagination by BestWebSoft ===
Contributors: bestwebsoft
Donate link: https://bestwebsoft.com/donate/
Tags: pagination, pagination block, custom pagination block, multiple navigation, multiple pages, navigation, next page, post pagination, pagination buttons, pagination plugin, improve pages navigation, paginate plugin
Requires at least: 3.9
Tested up to: 4.8
Stable tag: 1.0.8
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add customizable pagination to WordPress website. Split long content to multiple pages for better navigation.

== Description ==

Simple plugin which automatically adds custom pagination to your WordPress website blog, search results, archive, category, tags, and author pages. Choose pagination type, position, and customize its appearance.

Improve navigation through your website content today!

http://www.youtube.com/watch?v=TwAd3DWLGr8

= Free Features =

* Automatically add pagination to:
	* Home
	* Blog 
	* Archive 
	* Search results
	* Paginated posts/pages
* Compatible with:
	* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f)
	* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a)
* Add pagination via function to:
	* Comments PHP template
	* PHP files
* Choose pagination position:
	* Above the main content
	* Below the main content
	* Above and below the main content
	* Via function
* Display and customize Next/Previous arrows
* Display “Page X of Y” information
* Set numeric pagination display type:
	* Full (1,2,3,4,5,6)
	* Short (1,2…5,6)
* Hide pagination for:
	* Default
		* Posts (for standard WP themes)
		* On paginated post or pages
		* Comments
	* Custom pages
* Set pagination block width
* Set pagination align:
	* Left
	* Center
	* Right
* Set margins for left and right align
* Customize pagination styles:
	* Background color
	* Current page background color
	* Text color
	* Current page text color
	* Border color
	* Border width and radius
* Add custom code via plugin settings page
* Compatible with latest WordPress version
* Incredibly simple settings for fast setup without modifying code
* Detailed step-by-step documentation and videos

> **Pro Features**
>
> All features from Free version included plus:
>
> * Choose pagination type:
> 	* Numeric (default)
> 	* Load More button
> 	* Infinite scroll
> * Get answer to your support question within one business day ([Support Policy](https://bestwebsoft.com/support-policy/))
>
> [Upgrade to Pro Now](https://bestwebsoft.com/products/wordpress/plugins/pagination/?k=beef8d83cadcb70a8565e009a280f80c)

If you have a feature suggestion or idea you'd like to see in the plugin, we'd love to hear about it! [Suggest a Feature](https://support.bestwebsoft.com/hc/en-us/requests/new)

= Documentation & Videos =

* [[Doc] Installation](https://docs.google.com/document/d/1-hvn6WRvWnOqj5v5pLUk7Awyu87lq5B_dO-Tv-MC9JQ/)
* [[Doc] Purchase](https://docs.google.com/document/d/1EUdBVvnm7IHZ6y0DNyldZypUQKpB8UVPToSc_LdOYQI/)
* [[Video] Installation Instruction](http://www.youtube.com/watch?v=Xh0LjOSgxzs)

= Help & Support =

Visit our Help Center if you have any questions, our friendly Support Team is happy to help — <https://support.bestwebsoft.com/>

= Translation =

* French (fr_FR) (thanks to [Jean-Louis Cordonnier](mailto:jlcord2@wanadoo.fr) www.labosdebabel.org)
* Portuguese (pt_PT) (thanks to [Antonio Carreira](mailto:antoniocarreira@streetdog.pt) www.streetdog.pt)
* Russian (ru_RU)
* Ukrainian (uk)

Some of these translations are not complete. We are constantly adding new features which should be translated. If you would like to create your own language pack or update the existing one, you can send [the text of PO and MO files](http://codex.wordpress.org/Translating_WordPress) to [BestWebSoft](https://support.bestwebsoft.com/hc/en-us/requests/new) and we'll add it to the plugin. You can download the latest version of the program for work with PO and MO [files Poedit](http://www.poedit.net/download.php).

= Recommended Plugins =

* [Updater](https://bestwebsoft.com/products/wordpress/plugins/updater/?k=f471af6c58ecd7f550f0601416e4331f) - Automatically check and update WordPress website core with all installed plugins and themes to the latest versions.
* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f) - Add beautiful galleries, albums & images to your Wordpress website in few clicks.
* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a) - Create and add personal portfolio to your WordPress website. Manage and showcase past projects to get more clients.

== Installation ==

1. Upload the `pagination` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin using the 'Plugins' menu in your WordPress admin panel.
3. You can adjust the necessary settings using your WordPress admin panel in "BWS Panel" > "Pagination".

[View a Step-by-step Instruction on Pagination Installation](https://docs.google.com/document/d/1-hvn6WRvWnOqj5v5pLUk7Awyu87lq5B_dO-Tv-MC9JQ/)

http://www.youtube.com/watch?v=Xh0LjOSgxzs

== Frequently Asked Questions ==

= Where can I find the settings to adjust the plugin work after activation? =

In the 'Plugin' menu you can find a link to the settings page.

= Can I replace the standard pagination in my theme? =

Yes, in the HIde pagination block you can choose any pagination to be displayed as well as to hide your theme`s standard pagination.

= How can I remove the custom pagination? =

In order to hide it, type a block class or block id into the text field in the Hide pagination block and check the "Custom" checkbox.

= I filled up all necessary settings, save the changes, but the custom pagination block did not appeared on some (or all) necessary pages. How can I fix it? =

Most likely that your theme was created incorrectly and it does not provide the needed functionality to display custom pagination block. Please, contact your support service (<https://support.bestwebsoft.com>) and we will help you to solve this issue.

= I have custom post types where I output the information via custom query to the database. How can I add the pagination block to this custom post type? =

It is necessary to add function <?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'custom', $second_query ); ?> to the necessary place. In this function, specify the name of your custom query to the database instead of $second_query.

= I have some problems with the plugin's work. What Information should I provide to receive proper support? =

Please make sure that the problem hasn't been discussed yet on our forum (<https://support.bestwebsoft.com>). If no, please provide the following data along with your problem's description:

1. the link to the page where the problem occurs
2. the name of the plugin and its version. If you are using a pro version - your order number.
3. the version of your WordPress installation
4. copy and paste into the message your system status report. Please read more here: [Instruction on System Status](https://docs.google.com/document/d/1Wi2X8RdRGXk9kMszQy1xItJrpN0ncXgioH935MaBKtc/)

== Screenshots ==

1. Custom pagination block in the front-end - shorthand output.
2. Custom pagination block in the front-end with all page numbers.
3. Plugin settings in WordPress admin panel.
4. Appearance settings in WordPress admin panel.

== Changelog ==

= V1.0.8 - 18.07.2017 =
* Update : All functionality for WordPress 4.8 was updated.

= V1.0.7 - 14.04.2017 =
* NEW : The French language file is added.
* NEW : The Portuguese language file is added.
* Bugfix : Multiple Cross-Site Scripting (XSS) vulnerability was fixed.

= V1.0.6 - 11.10.2016 =
* NEW : Ability to display pagination block automatically on paginated posts/pages has been added.
* Pro : "Load More" button pagination type.
* Pro : Infinite scroll pagination type.

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

= V1.0.8 =
* The compatibility with new WordPress version updated.

= V1.0.7 =
* New languages added.
* Bugs fixed.

= V1.0.6 =
* New features added

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
