=== Pagination by BestWebSoft - Customizable WordPress Content Splitter and Navigation Plugin ===
Contributors: bestwebsoft
Donate link: https://bestwebsoft.com/donate/
Tags: pagination, pagination block, custom pagination block, multiple navigation, multiple pages
Requires at least: 6.2
Tested up to: 6.8.2
Stable tag: 1.2.7
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add customizable WordPress pagination to your website. Easily split long posts and pages into multiple parts for improved navigation and user experience.

== Description ==

A lightweight and powerful pagination plugin for WordPress that adds fully customizable pagination to your posts, pages, blog, search results, archive, category, tags, and author pages. Choose from numeric, "Load More", or infinite scroll styles, and customize their appearance and behavior.

Perfect for WordPress users who want better content organization, enhanced SEO, and a smoother user journey.

[View Demo](https://bestwebsoft.com/demo-pagination-plugin/?ref=readme)

http://www.youtube.com/watch?v=TwAd3DWLGr8

= Free Features =

* Automatically add pagination to:
	* Home
	* Blog
	* Archive
	* Search results
	* Paginated posts/pages
* Seamless integration with:
	* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f)
	* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a)
* Insert pagination via function into:
	* Comments PHP template
	* Theme or plugin PHP files
* Flexible positioning:
	* Above content
	* Below content
	* Both above and below
	* Manual placement via function
* Customize Next/Previous arrows and add scroll to top
* Display "Page X of Y" indicator
* Choose pagination layout:
	* Full numeric (1,2,3,4,5,6)
	* Short numeric (1,2...5,6)
* Selectively hide pagination for:
	* Default themes
	* Paginated posts or pages
	* Comments
	* Custom templates
* Set width and alignment (left, center, right) with custom margins
* Customize pagination styles:
	* Hover color
	* Background color
	* Current page background color
	* Text color
	* Current page text color
	* Border color
	* Border width and radius
	* Several ready-made templates to choose from
* Add custom HTML/CSS via plugin settings
* Fully compatible with latest WordPress version
* Intuitive interface – no coding required
* Step-by-step guides and video tutorials included

> **Pro Features**
>
> All Free version features plus:
>
> * Automatically add pagination to:
>	* WooCommerce Shop
> * Select pagination type:
> 	* Numeric
> 	* "Load More" button
> 	* Infinite scroll
>	* Next/Previous only
> * "Load More" after initial content load
> * Divi theme compatibility [NEW]
> * Scroll Progress Bar option [NEW]
> * Priority support within 1 business day ([Support Policy](https://bestwebsoft.com/support-policy/))
>
> [Upgrade to Pro Now](https://bestwebsoft.com/products/wordpress/plugins/pagination/?k=beef8d83cadcb70a8565e009a280f80c)

Have a feature request? Let us know! [Suggest a Feature](https://support.bestwebsoft.com/hc/en-us/requests/new)

= Documentation & Videos =

* [[Doc] User Guide](https://bestwebsoft.com/documentation/pagination/pagination-user-guide/)
* [[Doc] Installation](https://bestwebsoft.com/documentation/how-to-install-a-wordpress-product/how-to-install-a-wordpress-plugin/)
* [[Doc] Purchase](https://bestwebsoft.com/documentation/how-to-purchase-a-wordpress-plugin/how-to-purchase-wordpress-plugin-from-bestwebsoft/)
* [[Video] Installation Instruction](http://www.youtube.com/watch?v=Xh0LjOSgxzs)

= Help & Support =

Need help? Visit our Help Center — our friendly Support Team is here for you: <https://support.bestwebsoft.com/>

= Translation =

Available languages:

* French (fr_FR)
* German (de_DE)
* Portuguese (pt_PT)
* Hebrew (he_IL)
* Russian (ru_RU)
* Ukrainian (uk)

Want to improve or add a translation? [Send us your PO/MO files](https://support.bestwebsoft.com/hc/en-us/requests/new). Use [Poedit](http://www.poedit.net/download.php) for editing translation files.

= Recommended Plugins =

* [Updater](https://bestwebsoft.com/products/wordpress/plugins/updater/?k=f471af6c58ecd7f550f0601416e4331f) – Automatically update WordPress core, plugins, and themes.
* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f) – Add responsive galleries and albums to your WordPress site.
* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a) – Create and manage portfolios to showcase your work.

== Installation ==

1. Upload the `pagination` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin via the "Plugins" menu in your WordPress dashboard.
3. Go to "Pagination" in the admin menu and configure your settings.

[Step-by-step Installation Guide](https://bestwebsoft.com/documentation/how-to-install-a-wordpress-product/how-to-install-a-wordpress-plugin/)

http://www.youtube.com/watch?v=Xh0LjOSgxzs

== Frequently Asked Questions ==

= Where are the plugin settings? =

Go to the WordPress admin area and click "Pagination" in the sidebar menu.

= Can I disable my theme's default pagination? =

Yes, in the Hide Pagination section, you can override or disable the built-in pagination of your theme.

= How do I remove the custom pagination block? =

In the Hide Pagination block, enter the CSS class or ID of the element you want to exclude and check the "Custom" box.

= Why isn't the pagination showing up on some pages? =

Your theme might not be built to support custom pagination. [Contact Support](https://support.bestwebsoft.com) and we’ll help.

= How do I use Pagination with custom post types or custom queries? =

Use:  
`<?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'custom', $second_query ); ?>`  
Replace `$second_query` with your custom WP_Query variable.

= How to enable pagination in the Divi theme? =

1. Open Pagination Settings.
2. Set "Posts selector" to `#content-area div`.

= How to enable pagination in the Avada theme? =

1. Open Pagination Settings.
2. Set "Posts selector" to `.fusion-posts-container`.

= What info should I provide for support? =

Before contacting support, make sure your issue hasn’t been addressed on our forum. Provide:

1. A link to the affected page
2. Plugin name and version
3. WordPress version
4. System status report ([how to get it](https://bestwebsoft.com/documentation/admin-panel-issues/system-status/))



== Screenshots ==

1. Custom pagination block in the front-end - shorthand output.
2. Custom pagination block in the front-end with all page numbers.
3. Plugin settings in WordPress admin panel.

== Changelog ==

= V1.2.7 - 24.10.2025 =
* Update : All functionality was updated for WordPress 6.8.2
* Update : BWS Panel section was updated.
* PRO : Ability to display pagination in the WooCommerce Shop has been added.
* NEW : Several ready-made templates to choose from has been added.

= V1.2.6 - 25.02.2025 =
* Update : All functionality was updated for WordPress 6.7
* Update : BWS Panel section was updated.
* PRO : Progress Bar option was added.
* NEW : Scroll to top option was added.

= V1.2.4 - 04.09.2023 =
* Update : All functionality was updated for WordPress 6.3
* Update : BWS Panel section was updated.
* Update : Improved compatibility with the Twenty-Three theme.

= V1.2.3 - 22.03.2023 =
* Update : All functionality was updated for WordPress 6.1.1
* Update : BWS Panel section was updated.
* Update : French translation added.
* Update : German translation added.
* Bugfix : Security issues have been fixed.

= V1.2.2 - 26.04.2022 =
* Bugfix : Deactivation Feedback fix.

= V1.2.1 - 22.03.2022 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.9.

= V1.2.0 - 02.07.2021 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.7.2
* PRO : Compatibility with Divi theme added.

= V1.1.9 - 03.03.2021 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.6.2
* Bugfix : Compatibility with Gallery by BestWebSoft updated.
* Bugfix : Compatibility with Portfolio by BestWebSoft updated.

= V1.1.8 - 20.04.2020 =
* Update : All functionality was updated for WordPress 5.4.
* Update : BWS menu has been updated.

= V1.1.7 - 04.09.2019 =
* Update: The deactivation feedback has been changed. Misleading buttons have been removed.

= V1.1.6 - 17.06.2019 =
* Bugfix : Compatibility with Gallery by BestWebSoft has been fixed.
* NEW : The German language file has been added.

= V1.1.5 - 15.05.2019 =
* Update : BWS menu has been updated.
* PRO : The bug  with the infinite scroll and "Load More" button on paginated posts/pages has been fixed.

= V1.1.4 - 19.03.2019 =
* Update : All functionality was updated for WordPress 5.1.1.
* PRO : The bug with the infinite scroll and "Load More" button has been fixed.

= V1.1.3 - 29.01.2019
* Update : All functionality for WordPress 5.0.3 was updated.
* Bugfix : Fixed small bugs. 
* PRO : Buttons for non numeric pagination was added. 

= V1.1.2 - 18.09.2018 =
* Update : All functionality for WordPress 4.9.8 was updated.
* Pro : The bug with the infinite scroll has been fixed.

= V1.1.1 - 03.05.2018 =
* NEW : Ability to choose pagination hover color has been added.
* Update : The plugin settings page has been updated.
* Update : Hebrew language file has been added.

= V1.1.0 - 28.02.2018 =
* NEW : Ability to add "nofollow" attribute has been added.
* Pro : Ability to display "Load More" button after page loading has been added.

= V1.0.9 - 20.11.2017 =
* Bugfix : Settings Page displaying has been fixed.
* Bugfix : Pagination displaying has been fixed.

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

= V1.2.7 =
* The compatibility with new WordPress version updated.
* New features added.
* Usability improved.

= V1.2.6 =
* The compatibility with new WordPress version updated.
* New features added.
* Usability improved.

= V1.2.4 =
* The compatibility with new WordPress version updated.
* Usability improved.

= V1.2.3 =
* The compatibility with new WordPress version updated.
* Usability improved.
* Bugs fixed.
* Security issues have been fixed.
* Languages added.

= V1.2.2 =
* Bug fixed.

= V1.2.1 =
* Usability improved.

= V1.2.0 =
* The compatibility with new WordPress version updated.
* New features added.
* Bugs fixed.

= V1.1.9 =
* The compatibility with new WordPress version updated.
* The compatibility with new Gallery version updated.
* The compatibility with new Portfolio version updated.
* Bugs fixed.

= V1.1.8 =
* The compatibility with new WordPress version updated.

= V1.1.7 =
* Usability improved

= V1.1.6 =
* Bugs fixed.
* New language added.

= V1.1.5 =
* Functionality  improved.
* Bugs fixed.

= V1.1.4 =
* Bugs fixed.
* The compatibility with new WordPress version updated.

= V1.1.3 =
* The compatibility with new WordPress version updated.
* New features added.
* Bugs fixed.

= V1.1.2 =
* Bugs fixed.
* The compatibility with new WordPress version updated.

= V1.1.1 =
* New features added.
* Usability improved.
* New language added.

= V1.1.0 =
* New features added.

= V1.0.9 =
* Bugs fixed.

= V1.0.8 =
* The compatibility with new WordPress version updated.

= V1.0.7 =
* New languages added.
* Bugs fixed.

= V1.0.6 =
* New features added.

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
