<?php
/*
Plugin Name: Pagination by BestWebSoft
Plugin URI: http://bestwebsoft.com/products/wordpress/plugins/pagination/
Description: Add customizable pagination to WordPress website. Split long content to multiple pages for better navigation.
Author: BestWebSoft
Text Domain: pagination
Domain Path: /languages
Version: 1.0.6
Author URI: http://bestwebsoft.com/
License: GPLv3 or later
*/

/*  © Copyright 2016  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Add Wordpress page 'bws_panel' and sub-page of this plugin to admin-panel.
* @return void
 */
 if ( ! function_exists( 'pgntn_add_admin_menu' ) ) {
	function pgntn_add_admin_menu() {
		bws_general_menu();
		/* add plugin page */
		$settings = add_submenu_page( 'bws_panel', __( 'Pagination Settings', 'pagination' ), 'Pagination', 'manage_options', 'pagination.php', 'pgntn_settings_page' );
		add_action( 'load-' . $settings, 'pgntn_add_tabs' );
	}
}

/**
 * Internationalization
 */
if ( ! function_exists( 'pgntn_plugins_loaded' ) ) {
	function pgntn_plugins_loaded() {
		load_plugin_textdomain( 'pagination', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/**
 * Plugin initialization and language localization on backend and front end
 * @return void
 */
if ( ! function_exists ( 'pgntn_init' ) ) {
	function pgntn_init() {
		global $bws_plugin_info, $pgntn_plugin_info;

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		/* Add variable for bws_menu */
		if ( empty( $pgntn_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$pgntn_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version */
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $pgntn_plugin_info, '3.8' );

		pgntn_settings();
		pgntn_display();
	}
}

/**
 * Plugin initialization on backend
 * @return void 
 */
if ( ! function_exists ( 'pgntn_admin_init' ) ) {
	function pgntn_admin_init() {
		global $bws_plugin_info, $pgntn_plugin_info, $pagenow;

		if ( empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '212', 'version' => $pgntn_plugin_info["Version"] );
	}
}

/**
 * Write plugin settings in to database
 * @return void
 */
if ( ! function_exists( 'pgntn_settings' ) ) {
	function pgntn_settings() {
		global $pgntn_options, $pgntn_plugin_info, $pgntn_option_defaults;
		
		if ( ! $pgntn_plugin_info )
			$pgntn_plugin_info = get_plugin_data( __FILE__ );

		$pgntn_option_defaults = array(
			'plugin_option_version'			=> $pgntn_plugin_info["Version"],
			'display_settings_notice'		=> 1,
			'suggest_feature_banner'		=> 1,
			'first_install'            		=> strtotime( "now" ),
			'where_display'					=> array( 'everywhere' ),
			'loop_position'					=> 'bottom',
			'display_info'					=> 1,
			'display_next_prev'				=> 1,
			'prev_text'						=> __( '« Previous', 'pagination' ),
			'next_text'						=> __( 'Next »', 'pagination' ),
			'show_all'						=> 0,
			'display_count_page'			=> 2,
			'display_standard_pagination'	=> array( 'posts', 'multipage' , 'comments' ),
			'additional_pagination_style'	=> '',
			'display_custom_pagination'		=> 1,
			'add_appearance'				=> 1,
			'width'							=> '60',
			'align'							=> 'center',
			'background_color'				=> '#ffffff',
			'current_background_color'		=> '#efefef',
			'text_color'					=> '#1e14ca',
			'current_text_color'			=> '#000',
			'border_color'					=> '#cccccc',
			'border_width'					=> 1,
			'border_radius'					=> 0,
			'margin_left'					=> 0,
			'margin_right'					=> 0			
		);
	
		if ( ! get_option( 'pgntn_options' ) )
			add_option( 'pgntn_options', $pgntn_option_defaults );

		$pgntn_options = get_option( 'pgntn_options' );
		
		if ( ! isset( $pgntn_options['plugin_option_version'] ) || $pgntn_options['plugin_option_version'] != $pgntn_plugin_info["Version"] ) {
			$pgntn_option_defaults['display_settings_notice'] = 0;
			$pgntn_options = array_merge( $pgntn_option_defaults, $pgntn_options );
			/* show pro features */
			$pgntn_options['hide_premium_options'] = array();

			$pgntn_options['plugin_option_version'] = $pgntn_plugin_info["Version"];
			update_option( 'pgntn_options', $pgntn_options );
		}
	}
}

/**
 * Display settings page
 * @return void
 */
if ( ! function_exists( 'pgntn_settings_page' ) ) {
	function pgntn_settings_page() {
		global $pgntn_options, $pgntn_plugin_info, $title, $pgntn_option_defaults, $wp_version;
		$message = $error  = "";
		$array_classes     = array();
		$plugin_basename = plugin_basename( __FILE__ );
		
		if ( isset( $_REQUEST['pgntn_form_submit'] ) && check_admin_referer( $plugin_basename, 'pgntn_nonce_name' ) ) {
			if ( isset( $_POST['bws_hide_premium_options'] ) ) {
				$hide_result = bws_hide_premium_options( $pgntn_options );
				$pgntn_options = $hide_result['options'];
			}
			/* Takes all the changed settings on the plugin's admin page and saves them in array 'pgntn_options'. */
			if ( ! isset( $_GET['action'] ) ) {
				if ( isset( $_REQUEST['pgntn_where_display'] ) ) {
					$pgntn_options['where_display'] = array();
					foreach( $_REQUEST['pgntn_where_display'] as $pgntn_position ) 
						$pgntn_options['where_display'][] = $pgntn_position;
				} else {
					$pgntn_options['where_display'] = array();
				}
				if ( isset( $_REQUEST['pgntn_display_standard_pagination'] ) ) {
					$pgntn_options['display_standard_pagination'] = array();
					foreach( $_REQUEST['pgntn_display_standard_pagination'] as $pgntn_position ) 
						$pgntn_options['display_standard_pagination'][] = $pgntn_position;
				} else {
					$pgntn_options['display_standard_pagination'] = array();
				}
				$pgntn_options['loop_position']					= isset( $_REQUEST['pgntn_loop_position'] ) ? $_REQUEST['pgntn_loop_position'] : 'bottom';
				$pgntn_options['display_count_page']			= isset( $_REQUEST['pgntn_display_count_page'] ) ? intval( $_REQUEST['pgntn_display_count_page'] ) : $pgntn_options['display_count_page'];
				if ( 1 > $pgntn_options['display_count_page'] )
					$pgntn_options['display_count_page']		= 1;
				$pgntn_options['display_info']					= isset( $_REQUEST['pgntn_display_info'] ) ? 1 : 0;
				$pgntn_options['display_next_prev']				= isset( $_REQUEST['pgntn_display_next_prev'] ) ? 1 : 0;
				$pgntn_options['prev_text']						= isset( $_REQUEST['pgntn_prev_text'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_prev_text'] ) ) : $pgntn_options['prev_text'];
				$pgntn_options['next_text']						= isset( $_REQUEST['pgntn_next_text'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_next_text'] ) ) : $pgntn_options['next_text'];
				$pgntn_options['show_all']						= isset( $_REQUEST['pgntn_show_all'] ) ? intval( $_REQUEST['pgntn_show_all'] ) : 0;
				$pgntn_options['additional_pagination_style']	= isset( $_REQUEST['pgntn_additional_pagination_style'] ) ? stripslashes( esc_html($_REQUEST ['pgntn_additional_pagination_style'] ) ) : $pgntn_options['additional_pagination_style'];
				$pgntn_options['display_custom_pagination']		= isset( $_REQUEST['pgntn_display_custom_pagination'] ) ? 1 : 0;
				$pgntn_options['margin_left']					= isset( $_REQUEST['pgntn_margin_left'] ) ? intval( $_REQUEST['pgntn_margin_left'] ) : $pgntn_options['margin_left'];
				$pgntn_options['margin_right']					= isset( $_REQUEST['pgntn_margin_right'] ) ? intval( $_REQUEST['pgntn_margin_right'] ) : $pgntn_options['margin_right'];
			} else {
				$pgntn_options['add_appearance']				= isset( $_REQUEST['pgntn_add_appearance'] ) ? 1 : 0;				
				$pgntn_options['width']							= isset( $_REQUEST['pgntn_width'] ) ? intval( $_REQUEST['pgntn_width'] ) : $pgntn_options['width'];
				$pgntn_options['align']							= isset( $_REQUEST['pgntn_align'] ) ? $_REQUEST['pgntn_align'] : $pgntn_options['align'];
				$pgntn_options['margin_left']					= isset( $_REQUEST['pgntn_margin_left'] ) ? intval( $_REQUEST['pgntn_margin_left'] ) : $pgntn_options['margin_left'];
				$pgntn_options['margin_right']					= isset( $_REQUEST['pgntn_margin_right'] ) ? intval( $_REQUEST['pgntn_margin_right'] ) : $pgntn_options['margin_right'];
				$pgntn_options['background_color']				= isset( $_REQUEST['pgntn_background_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_background_color'] ) ) : $pgntn_options['background_color'];
				$pgntn_options['current_background_color']		= isset( $_REQUEST['pgntn_current_background_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_current_background_color'] ) ) : $pgntn_options['current_background_color'];
				$pgntn_options['text_color']					= isset( $_REQUEST['pgntn_text_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_text_color'] ) ) : $pgntn_options['text_color'];
				$pgntn_options['current_text_color']			= isset( $_REQUEST['pgntn_current_text_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_current_text_color'] ) ) : $pgntn_options['current_text_color'];
				$pgntn_options['border_color']					= isset( $_REQUEST['pgntn_border_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_border_color'] ) ) : $pgntn_options['border_color'];
				$pgntn_options['border_width']					= isset( $_REQUEST['pgntn_border_width'] ) ? intval( $_REQUEST['pgntn_border_width'] ) : $pgntn_options['border_width'];
				$pgntn_options['border_radius']					= isset( $_REQUEST['pgntn_border_radius'] ) ? intval( $_REQUEST['pgntn_border_radius'] ) : $pgntn_options['border_radius'];
			}
			update_option( 'pgntn_options', $pgntn_options );
			$message = __( 'Settings saved.', 'pagination' );
		}

		/* check banner */
		$bws_hide_premium_options_check = bws_hide_premium_options_check( $pgntn_options );

		/* Add restore function */
		if ( isset( $_REQUEST['bws_restore_confirm'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
			$pgntn_options = $pgntn_option_defaults;
			update_option( 'pgntn_options', $pgntn_options );
			$message = __( 'All plugin settings were restored.', 'pagination' );
		} 
		/* GO PRO */
		if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) {			
			$go_pro_result = bws_go_pro_tab_check( $plugin_basename, 'pgntn_options' );
			if ( ! empty( $go_pro_result['error'] ) )
				$error = $go_pro_result['error'];
			elseif ( ! empty( $go_pro_result['message'] ) )
				$message = $go_pro_result['message'];
		} ?>
		<div class="wrap" id="pgntn_settings_page">
			<h1><?php echo $title; ?></h1>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( ! isset( $_GET['action'] ) ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php"><?php _e( 'Settings', 'pagination' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php&amp;action=appearance"><?php _e( 'Appearance', 'pagination' ); ?></a>
				<a class="nav-tab <?php if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php&amp;action=custom_code"><?php _e( 'Custom code', 'pagination' ); ?></a>
				<a class="nav-tab bws_go_pro_tab<?php if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php&amp;action=go_pro"><?php _e( 'Go PRO', 'pagination' ); ?></a>
			</h2>
			<div class="updated fade below-h2" <?php if ( '' == $message || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<?php if ( isset( $_REQUEST['bws_restore_default'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
				bws_form_restore_default_confirm( $plugin_basename );
			} else { 
				bws_show_settings_notice(); ?>
				<div id="pgntn_empty_page_type" class="updated below-h2"<?php if ( ( ! empty( $pgntn_options['where_display'] ) ) || ( isset( $_GET['action'] ) && in_array( $_GET['action'], array( 'appearance', 'custom_code' ) ) ) ) echo ' style="display: none;"'; ?>>
					<p><strong><?php _e( "Notice:", 'pagination' ); ?></strong> <?php _e( 'Choose some page types to display plugin`s pagination in frontend of your site.', 'pagination' ); ?></p>
				</div>
				<div class="error below-h2"<?php if ( empty( $error ) ) echo " style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>				
				<?php if ( ! isset( $_GET['action'] ) || $_GET['action'] == 'appearance' ) { ?>
					<form class="bws_form" method="post" action="">
						<?php if ( ! isset( $_GET['action'] ) ) { ?>
							<div>
								<p><?php _e( 'If you would like to display pagination block in a different place on your site, add the following strings into the file', 'pagination' ); ?>&nbsp;<i>index.php</i>&nbsp;<?php _e( 'of your theme', 'pagination' ); ?>:<br />
									<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'posts' );</code><br/>
									<?php _e( 'If you would like to display pagination block for paginated posts or pages in a different place on your site, add the following strings into to the appropriate templates source code of your theme', 'pagination' ); ?>:<br />
									<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'multipage' );</code><br/>
									<?php _e( 'Paste this into the comments template if you want to display pagination for comments', 'pagination' ); ?>:<br>
									<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'comments' );</code>
								</p>
							</div>
							<table class="form-table"><!-- main settings -->
								<tr>
									<th scope="row"><?php _e( 'Display pagination on', 'pagination' ); ?></th>
									<td>
										<fieldset>
											<input type="checkbox" id="pgntn_everywhere" value="everywhere" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_everywhere"><strong><?php _e( 'all pages', 'pagination' ); ?></strong></label><br />
											<input type="checkbox" id="pgntn_on_home" class="pgntn_where_display" value="home" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'home', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_on_home"><?php _e( 'home page', 'pagination' ); ?></label><br />
											<input type="checkbox" id="pgntn_on_blog" class="pgntn_where_display" value="blog" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'blog', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_on_blog"><?php _e( 'blog page', 'pagination' ); ?></label><br />
											<input type="checkbox" id="pgntn_on_archives" class="pgntn_where_display" value="archives" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'archives', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_on_archives"><?php _e( 'archive pages ( by categories, date, tags etc. )', 'pagination' ); ?></label><br />
											<input type="checkbox" id="pgntn_on_search" class="pgntn_where_display" value="search" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'search', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_on_search"><?php _e( 'search results page', 'pagination' ); ?></label><br />
											<input type="checkbox" id="pgntn_on_paginated_post" class="pgntn_where_display" value="paginated_post" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'paginated_post', $pgntn_options['where_display'] ) ) echo ' checked="checked"'; ?> /><label for="pgntn_on_paginated_post"><?php _e( 'paginated posts/pages', 'pagination' ); ?></label>
										</fieldset>
									</td>
								</tr>
							</table>
							<?php if ( ! $bws_hide_premium_options_check ) { ?>
								<div class="bws_pro_version_bloc">
									<div class="bws_pro_version_table_bloc">
										<button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'pagination' ); ?>"></button>
										<div class="bws_table_bg"></div>
										<table class="form-table bws_pro_version">
											<tr valign="top">
												<th scope="row"><?php _e( 'Pagination type', 'pagination' ); ?></th>
												<td>
													<fieldset>
														<label>
															<input disabled="disabled" type="radio" value="numeric" name="pgntn_type" checked="checked" /> <?php _e( 'Numeric pagination', 'pagination' ); ?>
														</label><br />
														<label>
															<input disabled="disabled" type="radio" value="load-more" name="pgntn_type" /> <?php _e( '"Load More" button', 'pagination' ); ?>
															<span class="bws_info"> (<?php _e( 'display a single button at the bottom of the posts/pages that when clicked loads new posts/pages via ajax', 'pagination' ); ?>)</span>
														</label><br />
														<label>
															<input disabled="disabled" type="radio" value="infinite-scroll" name="pgntn_type" /> <?php _e( 'Infinite scroll', 'pagination' ); ?>
															<span class="bws_info"> (<?php _e( 'automatically loads new posts/pages as the user scrolls to the bottom of the screen', 'pagination' ); ?>)</span>
														</label>
													</fieldset>
												</td>
											</tr>
											<tr valign="top">
												<th scope="row" colspan="2">
													* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'pagination' ); ?>
												</th>
											</tr>				
										</table>	
									</div>
									<div class="bws_pro_version_tooltip">
										<div class="bws_info">
											<?php _e( 'Unlock premium options by upgrading to Pro version', 'pagination' ); ?> 
										</div>
										<a class="bws_button" href="http://bestwebsoft.com/products/wordpress/plugins/pagination/?k=5f3235c93ef4bd001abe4efd16530be0&pn=212&v=<?php echo $pgntn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Pagination Pro"><?php _e( 'Learn More', 'pagination' ); ?></a>
										<div class="clear"></div>					
									</div>
								</div>
							<?php } ?>
							<table class="form-table">
								<tr valign="top">
									<th scope="row"><?php _e( 'Pagination position', 'pagination' ); ?></th>
									<td>
										<select name="pgntn_loop_position">
											<option value="top"<?php echo "top" == $pgntn_options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'above the main content', 'pagination' ); ?></option>
											<option value="bottom"<?php echo "bottom" == $pgntn_options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'below the main content', 'pagination' ); ?></option>
											<option value="both"<?php echo "both" == $pgntn_options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'above and below the main content', 'pagination' ); ?></option>
											<option value="function"<?php echo "function" == $pgntn_options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'via function only', 'pagination' ); ?></option>
										<select>
									</td>
								</tr><!-- .pgntn_nav_position -->
								<tr>
									<th scope="row"><label for ="pgntn_display_info"><?php _e( "Display 'Page __ of __' block", 'pagination' ); ?></label></th>
									<td>
										<input type="checkbox" value="1" id="pgntn_display_info" name="pgntn_display_info"<?php echo 1 == $pgntn_options ['display_info'] ? ' checked="checked"' : ''; ?> />
									</td>
								</tr>
								<tr>
									<th scope="row"><label for ="pgntn_display_next_prev"><?php _e( 'Display Next/Previous arrows', 'pagination' ); ?></label></th>
									<td>
										<input type="checkbox" value="1" id="pgntn_display_next_prev" name="pgntn_display_next_prev"<?php echo 1 == $pgntn_options ['display_next_prev'] ? ' checked="checked"' : ''; ?> />
										<div class="pgntn_links_text">
											<input type="text" maxlength='250' value="<?php echo $pgntn_options ['prev_text']; ?>"<?php echo 0 == $pgntn_options ['display_next_prev'] ? 'disabled="disabled"' : ''; ?> name="pgntn_prev_text" id="pgntn_prev_text" /><span class="pgntn_info">&nbsp;<?php _e( 'text for previous page link', 'pagination' ); ?></span><br/>
											<input type="text" maxlength='250' value="<?php echo $pgntn_options ['next_text']; ?>"<?php echo 0 == $pgntn_options ['display_next_prev'] ? 'disabled="disabled"' : ''; ?> name="pgntn_next_text" id="pgntn_next_text" /><span class="pgntn_info">&nbsp;<?php _e( 'text for next page link', 'pagination' ); ?></span><br/>
										</div><!-- .pgntn_links_text -->
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'Type of output', 'pagination' ); ?></th>
									<td>
										<fieldset>
											<label><input type="radio" value="1" id="pgntn_show_all" name="pgntn_show_all"<?php echo 1 == $pgntn_options ['show_all'] ? ' checked="checked"' : ''; ?> /> <?php _e( 'all numbers of pages', 'pagination' ); ?></label><br />
											<label><input type="radio" value="0" id="pgntn_show_not_all" name="pgntn_show_all"<?php echo 0 == $pgntn_options ['show_all'] ? ' checked="checked"' : ''; ?> /> <?php _e( 'shorthand output', 'pagination' ); ?></label><br />
											<input type="number" min="1" step="1" value="<?php echo $pgntn_options['display_count_page']; ?>"<?php echo 1 == $pgntn_options ['show_all'] ? ' disabled="disabled"' : ''; ?> id="pgntn_display_count_page" name="pgntn_display_count_page" /><span class="pgntn_info">&nbsp;<?php _e( 'numbers to either side of current page, but not including current page.', 'pagination' ); ?></span>
										</fieldset>
									</td>
								</tr>
								<tr>
									<th scope="row"><div><?php _e( 'Hide standard pagination', 'pagination' ); ?></div></th>
									<td>
										<fieldset class="pgntn_input">
											<input id="pgntn_display_posts_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='posts' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'posts', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_posts_pagination"><?php _e( 'posts pagination', 'pagination' ); ?></label><br />
											<input id="pgntn_display_multipage_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='multipage' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'multipage', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_multipage_pagination"><?php _e( 'on paginated posts or pages', 'pagination' ); ?></label><br />
											<input id="pgntn_display_comments_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='comments' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'comments', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_comments_pagination"><?php _e( 'comments pagination', 'pagination' ); ?></label><br />
										</fieldset><!-- .pgntn_input -->
										<div class="bws_help_box dashicons dashicons-editor-help">
											<div class="bws_hidden_help_text" style="min-width: 200px;"><?php _e( 'Used for standard WordPress themes or themes, which use standard CSS-classes for displaying pagination blocks', 'pagination' ); ?></div>
										</div><!-- .pgntn_help_box -->
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'Hide custom pagination', 'pagination' ); ?></th>
									<td>
										<div class="pgntn_input">
											<input id="pgntn_display_custom_pagination" name='pgntn_display_custom_pagination' type='checkbox' value='1' <?php if ( 1 == $pgntn_options['display_custom_pagination'] ) echo 'checked="checked"'; ?> />
											<input type="text" maxlength='250' value="<?php echo $pgntn_options['additional_pagination_style']; ?>" id="pgntn_additional_pagination_style" name="pgntn_additional_pagination_style"<?php echo 0 == $pgntn_options['display_custom_pagination'] ? ' disabled="disabled"' : ''; ?> />
										</div><!-- .pgntn_input -->
										<div class="bws_help_box dashicons dashicons-editor-help">
											<div class="bws_hidden_help_text" style="min-width: 200px;">
												<?php _e( 'Enter one (or more comma-separated) CSS-classes or ID of blocks which you would like to hide.', 'pagination' );?><br />
												<?php _e( 'Example', 'pagination' ) ?>:<br />
												<code>#nav_block</code><br />
												<?php _e( "or", 'pagination' ); ?><br />
												<code>.pagination</code><br />
												<?php _e( "or", 'pagination' ); ?><br />
												<code>#nav_block, .pagination</code>
											</div>
										</div><!-- .pgntn_help_box -->
									</td>
								</tr>
							</table><!-- end of main settings -->
						<?php } else { ?>
							<table class="form-table"><!-- additional settings -->
								<tr>
									<th scope="row"><?php _e( 'Add styles', 'pagination' ); ?></th>
									<td>
										<input type="checkbox" value="1" <?php if ( 1 == $pgntn_options['add_appearance'] ) echo 'checked="checked"'; ?> name="pgntn_add_appearance" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Page pagination block width', 'pagination' ); ?></th>
									<td>
										<input type="number" step="1" min="0" max="100" value="<?php echo $pgntn_options['width']; ?>" id="pgntn_width" name="pgntn_width" />&nbsp;<span class="bws_info">%</span>
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Pagination align', 'pagination' ); ?> </th>
									<td><fieldset>
										<input type="radio" value="left" <?php echo $pgntn_options['align'] == "left" ? 'checked="checked"': ""; ?> id="pgntn_align_left" name="pgntn_align" /> <label for="pgntn_align_left"><?php _e( 'Left', 'pagination' ); ?></label><br />
										<input type="radio" value="center" <?php echo $pgntn_options['align'] == "center" ? 'checked="checked"': ""; ?> id="pgntn_align_center" name="pgntn_align" /> <label for="pgntn_align_center"><?php _e( 'Center', 'pagination' ); ?></label><br />
										<input type="radio" value="right" <?php echo $pgntn_options['align'] == "right" ? 'checked="checked"': ""; ?> id="pgntn_align_right" name="pgntn_align" /> <label for="pgntn_align_right"><?php _e( 'Right', 'pagination' ); ?></label>
									</fieldset></td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Left margin', 'pagination' ); ?> </th>
									<td>
										<input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $pgntn_options['margin_left'] ) ? $pgntn_options['margin_left'] : '0'; ?>" id="pgntn_margin_left" class="pgntn_margin" name="pgntn_margin_left"<?php echo $pgntn_options['align'] == "center" ? ' disabled="disabled"': ''; ?> />&nbsp;<span class="bws_info">px</span>
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Right margin', 'pagination' ); ?> </th>
									<td>
										<input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $pgntn_options['margin_right'] ) ? $pgntn_options['margin_right'] : '0'; ?>" id="pgntn_margin_right" class="pgntn_margin" name="pgntn_margin_right"<?php echo $pgntn_options['align'] == "center" ? ' disabled="disabled"': ''; ?> />&nbsp;<span class="bws_info">px</span>
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Background color', 'pagination' ); ?> </th>
									<td>
										<input type="text" value="<?php echo $pgntn_options['background_color']; ?>" name="pgntn_background_color" class="pgntn_color_picker" data-default-color="<?php echo $pgntn_option_defaults['background_color']; ?>" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Background color for current page', 'pagination' ); ?> </th>
									<td>
										<input type="text" value="<?php echo $pgntn_options['current_background_color']; ?>" name="pgntn_current_background_color" class="pgntn_color_picker" data-default-color="<?php echo $pgntn_option_defaults['current_background_color']; ?>" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Text color for page', 'pagination' ); ?> </th>
									<td>
										<input type="text" value="<?php echo $pgntn_options['text_color']; ?>" name="pgntn_text_color" class="pgntn_color_picker" data-default-color="<?php echo $pgntn_option_defaults['text_color']; ?>" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Text color for current page', 'pagination' ); ?> </th>
									<td>
										<input type="text" value="<?php echo $pgntn_options['current_text_color']; ?>" name="pgntn_current_text_color" class="pgntn_color_picker" data-default-color="<?php echo $pgntn_option_defaults['current_text_color']; ?>" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Border color', 'pagination' ); ?> </th>
									<td>
										<input type="text" value="<?php echo $pgntn_options['border_color']; ?>" name="pgntn_border_color" class="pgntn_color_picker" data-default-color="<?php echo $pgntn_option_defaults['border_color']; ?>" />
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Border width', 'pagination' ); ?> </th>
									<td>
										<input type="number" step="1" min="0" max="1000" value="<?php echo ! empty( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] : '0'; ?>" id="pgntn_border_width" name="pgntn_border_width" />&nbsp;<span class="bws_info">px</span>
									</td>
								</tr>
								<tr class="pgntn_add_appearance"<?php if ( 0 == $pgntn_options['add_appearance'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Border radius', 'pagination' ); ?> </th>
									<td>
										<input type="number" step="1" min="0" max="1000" value="<?php echo ! empty( $pgntn_options['border_radius'] ) ? $pgntn_options['border_radius'] : '0'; ?>" id="pgntn_border_radius" name="pgntn_border_radius" />&nbsp;<span class="bws_info">px</span>
									</td>
								</tr>
							</table><!-- end of additional settings -->
						<?php } ?>
						<p class="submit">
							<input id="bws-submit-button" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'pagination' ); ?>" />
							<input type="hidden" name="pgntn_form_submit" value="submit" />
							<?php wp_nonce_field( $plugin_basename, 'pgntn_nonce_name' ); ?>
						</p>
					</form>
					<?php bws_form_restore_default_settings( $plugin_basename );
				} elseif ( 'custom_code' == $_GET['action'] ) {
					bws_custom_code_tab();
				} elseif ( 'go_pro' == $_GET['action'] ) { 
					bws_go_pro_tab_show( $bws_hide_premium_options_check, $pgntn_plugin_info, $plugin_basename, 'pagination.php', 'pagination-pro.php', 'pagination-pro/pagination-pro.php', 'pagination', '5f3235c93ef4bd001abe4efd16530be0', '212', isset( $go_pro_result['pro_plugin_is_activated'] ) );		
				}
			}
			bws_plugin_reviews_block( $pgntn_plugin_info['Name'], 'pagination' ); ?>
		</div>
	<?php }
}

/**
 * Include necessary css- and js-files in admin panel
 * @return void
 */
if ( ! function_exists( 'pgntn_admin_head' ) ) {
	function pgntn_admin_head() {
		if ( isset( $_REQUEST['page'] ) && 'pagination.php' == $_REQUEST['page'] ) {
			wp_enqueue_style( 'pgntn_stylesheet', plugins_url( 'css/style.css', __FILE__ ), array( 'wp-color-picker' ) );
			wp_enqueue_script( 'pgntn_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
			if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] )
				bws_plugins_include_codemirror();
		}
	}
}

/**
 * Include necessary css- and js-files in front-end
 * @return void
 */
if ( ! function_exists( 'pgntn_wp_head' ) ) {
	function pgntn_wp_head() {
		wp_enqueue_style( 'pgntn_stylesheet', plugins_url( 'css/nav-style.css', __FILE__ ) );
		wp_enqueue_style( 'pgntn_styles', pgntn_print_style() );
	}
}

/**
 * Include styles for displaying block of page pagination
 * @return void
 */
if ( ! function_exists ( 'pgntn_print_style' ) ) {
	function pgntn_print_style() { 
		global $pgntn_options; ?>
		<style type="text/css">
			<?php if ( 1 == $pgntn_options['add_appearance'] ) { ?>
				.pgntn-page-pagination {
					text-align: <?php echo $pgntn_options['align']; ?> !important;
				}
				.pgntn-page-pagination-block {
					<?php if ( $pgntn_options['align'] == 'center' ) { ?>
						margin: 0 auto;
					<?php } elseif ( $pgntn_options['align'] != 'center' ) { ?>
						margin: 0 <?php echo $pgntn_options['margin_right'] != 0 ? $pgntn_options['margin_right'] . 'px' : '0'; ?> 0 <?php echo $pgntn_options['margin_left'] != 0 ? $pgntn_options['margin_left'] . 'px' : '0'; ?>;
					<? }
					if ( $pgntn_options['align'] == 'right' ) { ?>
						float: right;
					<?php } ?>
					width: <?php echo $pgntn_options['width']; ?>% !important;
				}
				.pgntn-page-pagination a {
					color: <?php echo $pgntn_options['text_color']; ?> !important;
					background-color: <?php echo $pgntn_options['background_color']; ?> !important;
					text-decoration: none !important;
					border: <?php echo 0 < intval( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] . "px solid " . $pgntn_options['border_color'] : 'none'; ?> !important;
					<?php if ( ! empty( $pgntn_options['border_radius'] ) ) { ?>
						-webkit-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						-moz-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
					<?php } ?>
				}
				.pgntn-page-pagination a:hover {
					color: <?php echo $pgntn_options['current_text_color']; ?> !important;
				}
				.pgntn-page-pagination-intro,
				.pgntn-page-pagination .current {			
					background-color: <?php echo $pgntn_options['current_background_color']; ?> !important;
					color: <?php echo $pgntn_options['current_text_color']; ?> !important;
					border: <?php echo 0 < intval( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] . "px solid " . $pgntn_options['border_color'] : 'none'; ?> !important;
					<?php if ( ! empty( $pgntn_options['border_radius'] ) ) { ?>
						-webkit-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						-moz-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
					<?php } ?>
				}
			<?php }
			$classes = ''; 
			if ( ! empty( $pgntn_options['display_standard_pagination'] ) ) {
				$hide_comments  = ( in_array( 'comments', $pgntn_options['display_standard_pagination'] ) ) ? true : false ;
				$hide_multipage = ( in_array( 'multipage', $pgntn_options['display_standard_pagination'] ) ) ? true : false ;
				$classes       .= ( in_array( 'posts', $pgntn_options['display_standard_pagination'] ) ) ? 
					'.archive #nav-above,
					.archive #nav-below,
					.search #nav-above,
					.search #nav-below,
					.blog #nav-below, 
					.blog #nav-above, 
					.navigation.paging-navigation, 
					.navigation.pagination,
					.pagination.paging-pagination, 
					.pagination.pagination, 
					.pagination.loop-pagination, 
					.bicubic-nav-link, 
					#page-nav, 
					.camp-paging, 
					#reposter_nav-pages, 
					.unity-post-pagination, 
					.wordpost_content .nav_post_link' : '';
				$classes .= ( ! empty( $classes ) ) && ( $hide_multipage ) ? ',' : '';
				$classes .= $hide_multipage ?
					'.page-link,
					.page-links' : '';
				$classes .= ( ! empty( $classes ) ) && $hide_comments ? ',' : '';
				$classes .= $hide_comments ? 
					'#comments .navigation,
					#comment-nav-above,
					#comment-nav-below,
					#nav-single,
					.navigation.comment-navigation,
					comment-pagination' : '';
			} 
			if ( ( ! empty( $pgntn_options['additional_pagination_style'] ) ) && '1' == $pgntn_options['display_custom_pagination'] ) {	
				$classes .= ! empty( $classes ) ? ',' : '';
				$classes .= $pgntn_options['additional_pagination_style']; 
			} 
			if ( ! empty( $classes ) ) {
				echo $classes . ' { 
						display: none !important; 
					}
					.single-gallery .pagination.gllrpr_pagination {
						display: block !important; 
					}';
			} ?>
		</style>
	<?php }
}

/**
 * Display block of pagination 
 * @return void
 */ 
if ( ! function_exists( 'pgntn_display' ) ) {
	function pgntn_display() {
		global $pgntn_options;
		if ( empty( $pgntn_options ) )
			$pgntn_options = get_option( 'pgntn_options' );
		if ( ! is_admin() ) {
			if ( 'top' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] )
				add_filter( 'loop_start', 'pgntn_display_with_loop' );
			if ( 'bottom' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] )
				add_filter( 'loop_end', 'pgntn_display_with_loop_bottom' );

			if ( 'function' != $pgntn_options['loop_position'] && ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'paginated_post', $pgntn_options['where_display'] ) ) )
				add_filter( 'wp_link_pages', 'pgntn_wp_link_pages', 10, 2 );
		}
	}
}

/**
 * Display pagination block in frontend above WordPress Loop
 * @param  array       $content         list with data of posts, which needs to displating in the loop
 * @return void
 */
if ( ! function_exists( 'pgntn_display_with_loop' ) ) {
	function pgntn_display_with_loop( $content ) {
        if ( is_feed() )
            return $content;
		global $wp_query, $pgntn_display_top;
		if ( is_main_query() && $content === $wp_query && ! $pgntn_display_top ) { /* make sure that we display block of pagination only with main loop */
			$pgntn_display_top = true;
			pgntn_nav_display( 'posts', 'top' );
		}
	}
}

/**
 * Display pagination block in frontend below WordPress Loop
 * @param  array       $content         list with data of posts, which needs to displating in the loop
 * @return void
 */
if ( ! function_exists( 'pgntn_display_with_loop_bottom' ) ) {
	function pgntn_display_with_loop_bottom( $content ) {
        if ( is_feed() )
            return $content;
		global $wp_query, $pgntn_display_bottom;
		if ( is_main_query() && $content === $wp_query && ! $pgntn_display_bottom ) { /* make sure that we display block of pagination only with main loop */
			$pgntn_display_bottom = true;
			pgntn_nav_display( 'posts', 'bottom' );
		}
	}
}

/**
 * Display pagination block on paginated posts or pages
 * @param string $output HTML output of paginated posts' page links.
 * @param array  $args   An array of arguments.
 * @return string $output
 */
if ( ! function_exists( 'pgntn_wp_link_pages' ) ) {
	function pgntn_wp_link_pages( $output, $args ) {
		ob_start();
		pgntn_nav_display( 'multipage', 'bottom' );
		$pagination_output = ob_get_clean();
		return $output . $pagination_output;
	}
}

/**
 * Display pagination block in the function call
 * @param    string   $what      type of pagination ( posts, multipage, comments, custom )  
 * @return void
 */
if ( ! function_exists( 'pgntn_display_pagination' ) ) {
	function pgntn_display_pagination( $what = 'posts', $custom_query = '' ) {
		pgntn_nav_display( $what, false, $custom_query );
	}
}

/**
 * Display block of pagination with the Wordpress Loop
 * @param    string   $what      type of pagination ( posts, multipage, comments )
 * @return   void
 */
if ( ! function_exists( 'pgntn_nav_display' ) ) {
	function pgntn_nav_display( $what, $position = false, $custom_query = '' ) {
		global $pgntn_options;
		if ( empty( $pgntn_options ) ) 
			$pgntn_options = get_option( 'pgntn_options' );
		$display_info = 1 == $pgntn_options['display_info'] ? true : false;
		$nav_settings = array(
			'show_all'  => '1' == $pgntn_options['show_all'] ? true : false,
			'mid_size'  => $pgntn_options['display_count_page'],
			'prev_next' => '1' == $pgntn_options['display_next_prev'] ? true : false,
			'prev_text' => $pgntn_options['prev_text'],
			'next_text' => $pgntn_options['next_text'],
		);
		$show_block = false;
		switch ( $what ) {
			case 'posts':
				global $wp_query;
				if ( 
						( in_array( 'everywhere', $pgntn_options['where_display'] ) ||
							( in_array( 'home', $pgntn_options['where_display'] ) && is_front_page() ) ||
							( in_array( 'blog', $pgntn_options['where_display'] ) && pgntn_is_blog() ) ||
							( in_array( 'archives', $pgntn_options['where_display'] ) && is_archive() ) ||
							( in_array( 'search', $pgntn_options['where_display'] ) && is_search() )
						) &&
						! empty( $wp_query->max_num_pages )
				) 
					$show_block = true;

				if ( $show_block ) {
					$nav_settings['base']      = str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) );
					$nav_settings['format']    = '?paged=%#%';
					$nav_settings['current']   = max( 1, get_query_var('paged') );
					$nav_settings['total']     = $wp_query->max_num_pages;
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination<?php if ( $position ) echo ' pgntn-' . $position; ?>'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo paginate_links( $nav_settings ); ?>
							</div>
							<div class="clear"></div>
						</div>
					<?php }
				}				
				break;
			case 'custom':
				if ( is_object( $custom_query ) && isset( $custom_query->max_num_pages ) ) {
					$nav_settings['base']      = str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) );
					$nav_settings['format']    = '?paged=%#%';
					$nav_settings['current']   = max( 1, get_query_var('paged') );
					$nav_settings['total']     = $custom_query->max_num_pages;
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination<?php if ( $position ) echo ' pgntn-' . $position; ?>'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo paginate_links( $nav_settings ); ?>
							</div>
							<div class="clear"></div>
						</div>
					<?php }
				}
				break;
			case 'multipage':
				global $page, $numpages;
				if ( $numpages > 1 )
					$show_block = true;
				if ( $show_block ) {
					$current_page = intval( $page );
					if ( empty( $current_page ) || $current_page == 0 ) 
						$current_page = 1;
					$nav_settings['current']   = $current_page;
					$nav_settings['total']     = $numpages; 
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class="pgntn-page-pagination pgntn-multipage">
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) { 
									/* display block "Page __ of __" */ ?>
									<span class='pgntn-page-pagination-intro'><?php echo __( 'Pages', 'pagination' ) . ' ( ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total'] . ' ): '; ?></span>
								<?php }
								/* display "previous" link */
								if ( $nav_settings['current'] != 1 && '1' == $pgntn_options ['display_next_prev'] ) {
									$prev_link = $nav_settings['current'] - 1;
									echo _wp_link_page( $prev_link ) . $nav_settings['prev_text'] . '</a>';
								}

								if ( $nav_settings['show_all'] ) {
									for ( $i = 1; $i <= $nav_settings['total'] ; $i++ ) {
										if ( $i == $nav_settings['current'] ) { ?>
											<span class="page-numbers current"><?php echo $nav_settings['current']; ?></span>
										<?php } else {
											echo _wp_link_page( $i ) . $i . '</a>';
										}
									}
								} else {
									$start_number = $nav_settings['current'] - $nav_settings['mid_size'];
									if ( $start_number < 1 )
										$start_number = 1;
									$end_number = $nav_settings['current'] + $nav_settings['mid_size'];
									if ( $end_number > $nav_settings['total'] ) 
										$end_number = $nav_settings['total'];									
									
									/* display first link */
									if ( $start_number >= 2 )
										echo _wp_link_page( 1 ) . 1 . '</a>';
									/* display ... */
									if ( $start_number >= 3 ) { ?> 
										<span class="pgntn-elipses">...</span>
									<?php }
									/* display precurrent links */
									for ( $i = $start_number; $i < $nav_settings['current'] ; $i++ )
										echo _wp_link_page( $i ) . $i . '</a>';
									/* display current link */ ?>
									<span class="page-numbers current"><?php echo $nav_settings['current']; ?></span>
									<?php /* display aftercurrent links */
									for ( $i = $nav_settings['current'] + 1; $i <= $end_number; $i++ )
										echo _wp_link_page( $i ) . $i . '</a>';
									/* display ... */
									if ( $end_number < $nav_settings['total'] - 1 ) { ?> 
										<span class="pgntn-elipses">...</span>
									<?php }
									/* display last link */
									if ( $end_number < $nav_settings['total'] )
										echo _wp_link_page( $nav_settings['total'] ) . $nav_settings['total'] . '</a>';									
								} 

								/* display "next" link */
								if ( $nav_settings['current'] < $nav_settings['total'] && '1' == $pgntn_options ['display_next_prev'] ) {
									$next_link = $nav_settings['current'] + 1;
									echo _wp_link_page( $next_link ) . $nav_settings['next_text'] . '</a>';
								} ?>
							</div><!-- .pgntn-page-pagination-block -->
							<div class="clear"></div>
						</div><!-- .pgntn-page-pagination -->
					<?php }
				}
				break;

			case 'comments':
				global $wp_rewrite;
				$page_comments = get_comment_pages_count();
				if ( ( is_singular() || get_option('page_comments') ) && ! empty( $page_comments )	)
					$show_block = true;
				if ( $show_block ) {
					$current_page = get_query_var('cpage');
					if ( ! $current_page )
						$current_page = 1;
					$nav_settings['base']         = $wp_rewrite->using_permalinks() ? user_trailingslashit( trailingslashit( get_permalink() ) . 'comment-page-%#%', 'commentpaged' ) : add_query_arg( 'cpage', '%#%' );
					$nav_settings['format']       = '';
					$nav_settings['current']      = $current_page;
					$nav_settings['total']        = $page_comments;
					$nav_settings['add_fragment'] = '#comments'; 
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination pgntn-comments'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Comments Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo paginate_links( $nav_settings ); ?>
							</div>
							<div class="clear"></div>
						</div><!-- .pgntn-page-pagination .pgntn-comments -->
					<?php }
				}
				break;

			default:
				break;
		}
	}
}

if ( ! function_exists( 'pgntn_is_blog' ) ) {
	function pgntn_is_blog() {
		if ( is_front_page() && is_home() ) {
			/* Default homepage */
			return false;
		} elseif ( is_front_page() ) {
			/* static homepage */
			return false;
		} elseif ( is_home() ) {
			/* blog page */
			return true;
		} else {
			return false;
		}
	}
}

/** 
 * Add link to plugin`s settings page on page with list of all installed plugins ( on table cell with plugin title )
 * @param   $links  array    links bellow plugin title 
 * @param   $file   array    relative path to the plugin`s main file 
 * @return  $links  array    links bellow plugin title
 */
if ( ! function_exists( 'pgntn_plugin_action_links' ) ) {
	function pgntn_plugin_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin ) $this_plugin = plugin_basename( __FILE__ );

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=pagination.php">' . __( 'Settings', 'pagination' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}

/**
 * Add necessary links on page with list of all installed plugins ( on table cell with plugin description )
 * @param   $links  array    links bellow plugins description 
 * @param   $file   array    relative path to the plugin`s main file  
 * @return  $links  array    links bellow plugins description
 */
if ( ! function_exists( 'pgntn_register_plugin_links' ) ) {
	function pgntn_register_plugin_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() )
				$links[] = '<a href="admin.php?page=pagination.php">' . __( 'Settings', 'pagination' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/pagination/faq/" target="_blank">' . __( 'FAQ', 'pagination' ) . '</a>';
			$links[] = '<a href="http://support.bestwebsoft.com">' . __( 'Support', 'pagination' ) . '</a>';
		}
		return $links;
	}
}

/* add help tab  */
if ( ! function_exists( 'pgntn_add_tabs' ) ) {
	function pgntn_add_tabs() {
		$screen = get_current_screen();
		$args = array(
			'id' 			=> 'pgntn',
			'section' 		=> '200995139'
		);
		bws_help_tab( $screen, $args );
	}
}

/* add admin notices */
if ( ! function_exists ( 'pgntn_admin_notices' ) ) {
	function pgntn_admin_notices() {
		global $hook_suffix, $pgntn_plugin_info, $pgntn_options;
		if ( 'plugins.php' == $hook_suffix && ! is_network_admin() ) {
			bws_plugin_banner_to_settings( $pgntn_plugin_info, 'pgntn_options', 'pagination', 'admin.php?page=pagination.php' );

			if ( ! $pgntn_options )
				$pgntn_options = get_option( 'pgntn_options' );
			if ( isset( $pgntn_options['first_install'] ) && strtotime( '-1 week' ) > $pgntn_options['first_install'] )
				bws_plugin_banner( $pgntn_plugin_info, 'pgntn', 'pagination', 'de97a6f81981229376108a33685eb703', '212', '//ps.w.org/pagination/assets/icon-128x128.png' );
		}
		if ( isset( $_REQUEST['page'] ) && 'pagination.php' == $_REQUEST['page'] ) {
			bws_plugin_suggest_feature_banner( $pgntn_plugin_info, 'pgntn_options', 'pagination' );
		}
	}
}

/**
 * Function for delete plugin options 
 * @return void
 */
if ( ! function_exists ( 'pgntn_delete_options' ) ) {
	function pgntn_delete_options() {
		global $wpdb;
		/* Delete options */
		$all_plugins = get_plugins();
		
		if ( ! array_key_exists( 'pagination-pro/pagination-pro.php', $all_plugins ) ) {
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				$old_blog = $wpdb->blogid;
				/* Get all blog ids */
				$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					delete_option( 'pgntn_options' );
				}
				switch_to_blog( $old_blog );
			} else {
				delete_option( 'pgntn_options' );
			}
		}
		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

/**
 * Add all hooks 
 */
add_action( 'admin_menu', 'pgntn_add_admin_menu' );
add_action( 'init', 'pgntn_init' );
add_action( 'admin_init', 'pgntn_admin_init' );
add_action( 'plugins_loaded', 'pgntn_plugins_loaded' );
/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'pgntn_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'pgntn_register_plugin_links', 10, 2 );
/* Include necessary css- and js-files */
add_action( 'admin_enqueue_scripts', 'pgntn_admin_head' );
add_action( 'wp_enqueue_scripts', 'pgntn_wp_head' );
/* add admin notices */
add_action( 'admin_notices', 'pgntn_admin_notices' );
register_uninstall_hook( __FILE__, 'pgntn_delete_options' );