<?php
/*
Plugin Name: Pagination by BestWebSoft
Plugin URI: http://bestwebsoft.com/products/
Description: Add multiple page pagination block to your WordPress website
Author: BestWebSoft
Version: 1.0.1
Author URI: http://bestwebsoft.com/
License: GPLv3 or later
*/

/*  © Copyright 2015  BestWebSoft  ( http://support.bestwebsoft.com )

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

global $pgntn_is_displayed;
$pgntn_is_displayed = false;
/**
 * Add Wordpress page 'bws_plugins' and sub-page of this plugin to admin-panel.
* @return void
 */
 if ( ! function_exists ( 'pgntn_add_admin_menu' ) ) {
	function pgntn_add_admin_menu() {
		bws_add_general_menu( plugin_basename( __FILE__ ) );		
		/* add plugin page */
		add_submenu_page( 'bws_plugins', __( 'Pagination Settings', 'pagination' ), 'Pagination', 'manage_options', 'pagination.php', 'pgntn_settings_page' );
	}
}

/**
 * Plugin initialization and language localization on backend and front end
 * @return void
 */
if ( ! function_exists ( 'pgntn_init' ) ) {
	function pgntn_init() {
		global $bws_plugin_info, $pgntn_plugin_info;

		/* Internationalization, first(!) */
		load_plugin_textdomain( 'pagination', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_functions.php' );

		/* Add variable for bws_menu */
		if ( empty( $pgntn_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$pgntn_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version */
		bws_wp_version_check( plugin_basename( __FILE__ ), $pgntn_plugin_info, "3.3" );
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
		global $bws_plugin_info, $pgntn_plugin_info;

		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '212', 'version' => $pgntn_plugin_info["Version"] );

		/* Call register settings function */
		if ( isset( $_GET['page'] ) && "pagination.php" == $_GET['page'] )
			pgntn_settings();
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
			'plugin_option_version' 		   => $pgntn_plugin_info["Version"],
			'where_display'                    => array( 'everywhere' ),
			'loop_position'                    => 'bottom',
			'display_info'                     => 1,
			'display_next_prev'                => 1,
			'prev_text'                        => __('« Previous', 'pagination' ),
			'next_text'                        => __('Next »', 'pagination' ),
			'show_all'                         => 0,
			'display_count_page'               => 2,
			'display_standard_pagination'      => array( 'posts', 'multipage' , 'comments' ),
			'additional_pagination_style'      => '',
			'display_custom_pagination'        => 1,
			'width'                            => '60',
			'align'                            => 'center',
			'background_color'                 => '#ffffff',
			'current_background_color'         => '#efefef',
			'text_color'                       => '#1e14ca',
			'current_text_color'               => '#000',
			'border_color'                     => '#cccccc',
			'border_width'                     => 1,
			'border_radius'                    => 0,
			'margin_left'                      => 0,
			'margin_right'                     => 0
		);
	
		if ( ! get_option( 'pgntn_options' ) )
			add_option( 'pgntn_options', $pgntn_option_defaults );

		$pgntn_options = get_option( 'pgntn_options' );
		
		if ( ! isset( $pgntn_options['plugin_option_version'] ) || $pgntn_options['plugin_option_version'] != $pgntn_plugin_info["Version"] ) {
			$pgntn_options = array_merge( $pgntn_option_defaults, $pgntn_options );
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
		global $pgntn_options, $pgntn_plugin_info, $title, $pgntn_option_defaults;
		$message = $error  = "";
		$array_classes     = array();
		
		if ( isset( $_REQUEST['pgntn_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'pgntn_nonce_name' ) ) {
			/* Takes all the changed settings on the plugin's admin page and saves them in array 'pgntn_options'. */
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
			$pgntn_options['loop_position']               = isset( $_REQUEST['pgntn_loop_position'] ) ? $_REQUEST['pgntn_loop_position'] : 'bottom';
			$pgntn_options['display_count_page']          = isset( $_REQUEST['pgntn_display_count_page'] ) ? intval( $_REQUEST['pgntn_display_count_page'] ) : $pgntn_options['display_count_page'];
			$pgntn_options['display_info']                = isset( $_REQUEST['pgntn_display_info'] ) ? 1 : 0;
			$pgntn_options['display_next_prev']           = isset( $_REQUEST['pgntn_display_next_prev'] ) ? 1 : 0;
			$pgntn_options['prev_text']                   = isset( $_REQUEST['pgntn_prev_text'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_prev_text'] ) ) : $pgntn_options['prev_text'];
			$pgntn_options['next_text']                   = isset( $_REQUEST['pgntn_next_text'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_next_text'] ) ) : $pgntn_options['next_text'];
			$pgntn_options['show_all']                    = isset( $_REQUEST['pgntn_show_all'] ) ? intval( $_REQUEST['pgntn_show_all'] ) : 0;
			$pgntn_options['width']                       = isset( $_REQUEST['pgntn_width'] ) ? intval( $_REQUEST['pgntn_width'] ) : $pgntn_options['width'];
			$pgntn_options['align']                       = isset( $_REQUEST['pgntn_align'] ) ? $_REQUEST['pgntn_align'] : $pgntn_options['align'];
			$pgntn_options['background_color']            = isset( $_REQUEST['pgntn_background_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_background_color'] ) ) : $pgntn_options['background_color'];
			$pgntn_options['current_background_color']    = isset( $_REQUEST['pgntn_current_background_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_current_background_color'] ) ) : $pgntn_options['current_background_color'];
			$pgntn_options['text_color']                  = isset( $_REQUEST['pgntn_text_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_text_color'] ) ) : $pgntn_options['text_color'];
			$pgntn_options['current_text_color']          = isset( $_REQUEST['pgntn_current_text_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_current_text_color'] ) ) : $pgntn_options['current_text_color'];
			$pgntn_options['border_color']                = isset( $_REQUEST['pgntn_border_color'] ) ? stripslashes( esc_html( $_REQUEST['pgntn_border_color'] ) ) : $pgntn_options['border_color'];
			$pgntn_options['border_width']                = isset( $_REQUEST['pgntn_border_width'] ) ? intval( $_REQUEST['pgntn_border_width'] ) : $pgntn_options['border_width'];
			$pgntn_options['border_radius']               = isset( $_REQUEST['pgntn_border_radius'] ) ? intval( $_REQUEST['pgntn_border_radius'] ) : $pgntn_options['border_radius'];
			$pgntn_options['additional_pagination_style'] = isset( $_REQUEST['pgntn_additional_pagination_style'] ) ? stripslashes( esc_html($_REQUEST ['pgntn_additional_pagination_style'] ) ) : $pgntn_options['additional_pagination_style'];
			$pgntn_options['display_custom_pagination']   = isset( $_REQUEST['pgntn_display_custom_pagination'] ) ? 1 : 0;
			$pgntn_options['margin_left']                 = isset( $_REQUEST['pgntn_margin_left'] ) ? intval( $_REQUEST['pgntn_margin_left'] ) : $pgntn_options['margin_left'];
			$pgntn_options['margin_right']                = isset( $_REQUEST['pgntn_margin_right'] ) ? intval( $_REQUEST['pgntn_margin_right'] ) : $pgntn_options['margin_right'];

			update_option( 'pgntn_options', $pgntn_options );
			$message = __( 'Settings saved.', 'pagination' );
		} 

		/* Add restore function */
		if ( isset( $_REQUEST['bws_restore_confirm'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'bws_settings_nonce_name' ) ) {
			$pgntn_options = $pgntn_option_defaults;
			update_option( 'pgntn_options', $pgntn_options );
			$message = __( 'All plugin settings were restored.', 'pagination' );
		} ?>
		<div class="wrap" id="pgntn_settings_page">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo $title; ?></h2>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( ! isset( $_GET['action'] ) ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php"><?php _e( 'Settings', 'pagination' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=pagination.php&amp;action=appearance"><?php _e( 'Appearance', 'pagination' ); ?></a>
				<a class="nav-tab" href="http://bestwebsoft.com/products/pagination/faq/" target="_blank"><?php _e( 'FAQ', 'pagination' ); ?></a>
			</h2>
			<div class="updated fade" <?php if ( '' == $message || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<?php if ( isset( $_REQUEST['bws_restore_default'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'bws_settings_nonce_name' ) ) {
				bws_form_restore_default_confirm( plugin_basename( __FILE__ ) );
			} else { ?>
				<div id="pgntn_settings_notice" class="updated fade" style="display:none">
					<p><strong><?php _e( "Notice:", 'pagination' ); ?></strong> <?php _e( "The plugin's settings have been changed. In order to save them, please don't forget to click the 'Save Changes' button.", 'pagination' ); ?></p>
				</div>
				<div id="pgntn_empty_page_type" class="updated fade"<?php if ( ( ! empty( $pgntn_options['where_display'] ) ) || ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) ) echo ' style="display: none;"'; ?>>
					<p><strong><?php _e( "Notice:", 'pagination' ); ?></strong> <?php echo _e( 'Choose some page types to display plugin`s pagination in frontend of your site.', 'pagination' ); ?></p>
				</div>
				<div class="error"<?php if ( empty( $error ) ) echo " style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
				<div<?php if ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) echo ' style="display: none;"'; ?>>
					<p><?php _e( 'If you would like to display pagination block in a different place on your site, add the following strings into the file', 'pagination' ); ?>&nbsp;<i>index.php</i>&nbsp;<?php _e( 'of your theme', 'pagination' ); ?>:<br />
						<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'posts' );</code><br/>
						<?php _e( 'Also you can display pagination block for paginated posts or pages. Add the following strings into to the appropriate templates source code of your theme', 'pagination' ); ?>:<br />
						<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'multipage' );</code><br/>
						<?php _e( 'Paste this into the comments template if you want to display pagination for comments', 'pagination' ); ?>:<br>
						<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'comments' );</code>
					</p>
				</div>
				<?php $form_action = ( ! isset( $_GET['action'] ) ) ? 'admin.php?page=pagination.php' : 'admin.php?page=pagination.php&amp;action=' . $_GET['action']; ?>
				<form method="post" action="<?php echo $form_action ?>" id="pgntn_settings_form">
					<div<?php if ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) echo ' style="display: none;"'; ?>>
						<table class="form-table"><!-- main settings -->
							<tr>
								<th scope="row"><?php _e( 'Display pagination', 'pagination' ); ?></th>
								<td>
									<input type="checkbox" id="pgntn_everywhere" value="everywhere" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) ) { echo ' checked="checked"'; } ?> /><label for="pgntn_everywhere"><strong><?php _e( 'everywhere', 'pagination' ); ?></strong></label><br />
									<input type="checkbox" id="pgntn_on_home" class="pgntn_where_display" value="home" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'home', $pgntn_options['where_display'] ) ) { echo ' checked="checked"'; } ?> /><label for="pgntn_on_home"><?php _e( 'on home page', 'pagination' ); ?></label><br />
									<input type="checkbox" id="pgntn_on_blog" class="pgntn_where_display" value="blog" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'blog', $pgntn_options['where_display'] ) ) { echo ' checked="checked"'; } ?> /><label for="pgntn_on_blog"><?php _e( 'on blog page', 'pagination' ); ?></label><br />
									<input type="checkbox" id="pgntn_on_archives" class="pgntn_where_display" value="archives" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'archives', $pgntn_options['where_display'] ) ) { echo ' checked="checked"'; } ?> /><label for="pgntn_on_archives"><?php _e( 'on archive pages ( by categories, date, tags etc. )', 'pagination' ); ?></label><br />
									<input type="checkbox" id="pgntn_on_search" class="pgntn_where_display" value="search" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'search', $pgntn_options['where_display'] ) ) { echo ' checked="checked"'; } ?> /><label for="pgntn_on_search"><?php _e( 'on search results page', 'pagination' ); ?></label><br />
								</td>
							</tr>
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
									<div class="pgntn_input">
										<input id="pgntn_display_posts_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='posts' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'posts', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_posts_pagination"><?php _e( 'posts pagination', 'pagination' ); ?></label><br />
										<input id="pgntn_display_multipage_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='multipage' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'multipage', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_multipage_pagination"><?php _e( 'on paginated posts or pages', 'pagination' ); ?></label><br />
										<input id="pgntn_display_comments_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='comments' <?php if ( ( ! empty( $pgntn_options['display_standard_pagination'] ) ) && in_array( 'comments', $pgntn_options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> /> <label for="pgntn_display_comments_pagination"><?php _e( 'comments pagination', 'pagination' ); ?></label><br />
									</div><!-- .pgntn_input -->
									<div class="pgntn_help_box">
										<div class="pgntn_hidden_help_text"><?php _e( 'Used for standard WordPress themes or themes, which use standard CSS-classes for displaying pagination blocks', 'pagination' ); ?></div>
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
									<div class="pgntn_help_box">
										<div class="pgntn_hidden_help_text">
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
					</div>
					<div<?php if ( ! ( isset( $_GET['action'] ) && 'appearance' == $_GET['action'] ) ) echo ' style="display: none;"'; ?>>
						<table class="form-table"><!-- additional settings -->
							<tr>
								<th scope="row"><?php _e( 'Page pagination block width', 'pagination' ); ?> </th>
								<td>
									<input type="number" step="1" min="0" max="100" value="<?php echo $pgntn_options['width']; ?>" id="pgntn_width" name="pgntn_width" />&nbsp;<span class="bws_info">%</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Pagination align', 'pagination' ); ?> </th>
								<td>
									<input type="radio" value="left" <?php echo $pgntn_options['align'] == "left" ? 'checked="checked"': ""; ?> id="pgntn_align_left" name="pgntn_align" /> <label for="pgntn_align_left"><?php _e( 'Left', 'pagination' ); ?></label><br />
									<input type="radio" value="center" <?php echo $pgntn_options['align'] == "center" ? 'checked="checked"': ""; ?> id="pgntn_align_center" name="pgntn_align" /> <label for="pgntn_align_center"><?php _e( 'Center', 'pagination' ); ?></label><br />
									<input type="radio" value="right" <?php echo $pgntn_options['align'] == "right" ? 'checked="checked"': ""; ?> id="pgntn_align_right" name="pgntn_align" /> <label for="pgntn_align_right"><?php _e( 'Right', 'pagination' ); ?></label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Left margin', 'pagination' ); ?> </th>
								<td>
									<input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $pgntn_options['margin_left'] ) ? $pgntn_options['margin_left'] : '0'; ?>" id="pgntn_margin_left" class="pgntn_margin" name="pgntn_margin_left"<?php echo $pgntn_options['align'] == "center" ? ' disabled="disabled"': ''; ?> />&nbsp;<span class="bws_info">px</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Right margin', 'pagination' ); ?> </th>
								<td>
									<input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $pgntn_options['margin_right'] ) ? $pgntn_options['margin_right'] : '0'; ?>" id="pgntn_margin_right" class="pgntn_margin" name="pgntn_margin_right"<?php echo $pgntn_options['align'] == "center" ? ' disabled="disabled"': ''; ?> />&nbsp;<span class="bws_info">px</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Background color', 'pagination' ); ?> </th>
								<td>
									<input type="text" maxlength='7' value="<?php echo $pgntn_options['background_color']; ?>" id="pgntn_background_color" name="pgntn_background_color" />
									<div class="pgntn_color_picker"></div>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Background color for current page', 'pagination' ); ?> </th>
								<td>
									<input type="text" maxlength='7' value="<?php echo $pgntn_options['current_background_color']; ?>" id="pgntn_current_background_color" name="pgntn_current_background_color" />
									<div class="pgntn_color_picker"></div>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Text color for page', 'pagination' ); ?> </th>
								<td>
									<input type="text" maxlength='7' value="<?php echo $pgntn_options['text_color']; ?>" id="pgntn_text_color" name="pgntn_text_color" />
									<div class="pgntn_color_picker"></div>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Text color for current page', 'pagination' ); ?> </th>
								<td>
									<input type="text" maxlength='7' value="<?php echo $pgntn_options['current_text_color']; ?>" id="pgntn_current_text_color" name="pgntn_current_text_color" />
									<div class="pgntn_color_picker"></div>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Border color', 'pagination' ); ?> </th>
								<td>
									<input type="text" maxlength='7' value="<?php echo $pgntn_options['border_color']; ?>" id="pgntn_border_color" name="pgntn_border_color" />
									<div class="pgntn_color_picker"></div>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Border width', 'pagination' ); ?> </th>
								<td>
									<input type="number" step="1" min="0" max="1000" value="<?php echo ! empty( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] : '0'; ?>" id="pgntn_border_width" name="pgntn_border_width" />&nbsp;<span class="bws_info">px</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Border radius', 'pagination' ); ?> </th>
								<td>
									<input type="number" step="1" min="0" max="1000" value="<?php echo ! empty( $pgntn_options['border_radius'] ) ? $pgntn_options['border_radius'] : '0'; ?>" id="pgntn_border_radius" name="pgntn_border_radius" />&nbsp;<span class="bws_info">px</span>
								</td>
							</tr>
						</table><!-- end of additional settings -->
					</div>
					<input type="hidden" name="pgntn_form_submit" value="submit" />
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'pagination' ) ?>" />
					</p>
					<?php wp_nonce_field( plugin_basename( __FILE__ ), 'pgntn_nonce_name' ); ?>
				</form>
				<?php bws_form_restore_default_settings( plugin_basename( __FILE__ ) );
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
			global $wp_version;
			wp_enqueue_style( 'pgntn_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			if ( 3.5 < $wp_version ) {
				wp_enqueue_script('farbtastic');
				wp_enqueue_style('farbtastic');
			}
			wp_enqueue_script( 'pgntn_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ), false, true );
			wp_localize_script( 'pgntn_script', 'pgntn_script_vars', array( 'wp_version' => $wp_version ) );
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
			<?php $classes = ''; 
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
		if ( ! ( is_admin() ) ) {
			if ( 'top' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] )
				add_filter( 'loop_start', 'pgntn_display_with_loop' );
			elseif ( 'bottom' == $pgntn_options['loop_position'] )
				add_filter( 'loop_end', 'pgntn_display_with_loop' );
		}
	}
}

/**
 * Display pagination block in frontend below or top WordPress Loop
 * @param  array       $content         list with data of posts, which needs to displating in the loop
 * @return void
 */
if ( ! function_exists( 'pgntn_display_with_loop' ) ) {
	function pgntn_display_with_loop( $content ) {
		global $wp_query;
		if ( is_main_query() && $content === $wp_query ) { /* make sure that we display block of pagination only  with main loop */
			pgntn_nav_display( 'posts' );
		}
	}
}

/**
 * Display pagination block in the function call
 * @param    string   $what      type of pagination ( posts, multipage, comments )  
 * @return void
 */
if ( ! function_exists( 'pgntn_display_pagination' ) ) {
	function pgntn_display_pagination( $what = 'posts' ) {
		global $pgntn_options;
		if ( empty( $pgntn_options ) )
			$pgntn_options = get_option( 'pgntn_options' );
		if ( 'function' == $pgntn_options['loop_position'] || 'comments' == $what || 'multipage' == $what )
			pgntn_nav_display( $what );
	}
}

/**
 * Display block of pagination with the Wordpress Loop
 * @param    string   $what      type of pagination ( posts, multipage, comments )
 * @return   void
 */
if ( ! function_exists( 'pgntn_nav_display' ) ) {
	function pgntn_nav_display( $what ) {
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
				global $wp_query, $pgntn_is_displayed;
				if ( ! $pgntn_is_displayed ) {
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
							<div class='pgntn-page-pagination'>
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
					/** 
					 * Preventing unnecessary display 
					 * of pagination block on archives page 
					 */
					if ( is_archive() && ( 'top' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] ) ) {
						$pgntn_is_displayed = true; 
					} elseif ( 'both' == $pgntn_options['loop_position'] ) {
						add_filter( 'loop_end', 'pgntn_display_with_loop' );
					}
					
				} else {
					if ( 'both' == $pgntn_options['loop_position'] ) {
						$pgntn_is_displayed = false;
						add_filter( 'loop_end', 'pgntn_display_with_loop' );
					}						
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
								if ( $nav_settings['show_all'] ) {
									for ( $i = 1; $i <= $nav_settings['total'] ; $i++ ) {
										if ( $i == $nav_settings['current'] ) { ?>
											<span class="page-numbers current"><?php echo $nav_settings['current'] ; ?></span>
										<?php } else {
											echo _wp_link_page( $i ) . $i . '</a>';
										}
									}
								} else {
									$start_number = $nav_settings['current'] - $nav_settings['mid_size'] ;
									if ( $start_number < 1 )
										$start_number = 1;
									$end_number = $nav_settings['current'] + $nav_settings['mid_size'] ;
										if ( $end_number >= $nav_settings['total'] ) 
											$end_number = $nav_settings['total'] - 1;
									/* display "previous" link */
									if ( $nav_settings['current'] != 1 && '1' == $pgntn_options ['display_next_prev'] ) {
										$prev_link = $nav_settings['current'] - 1;
										echo _wp_link_page( $prev_link ) . $nav_settings['prev_text'] . '</a>';
									}
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
									<span class="page-numbers current"><?php echo $nav_settings['current'] ; ?></span>
									<?php /* display aftercurrent links */
									for ( $i = $nav_settings['current'] + 1; $i <= $end_number; $i++ )
										echo _wp_link_page( $i ) . $i . '</a>';
									/* display ... */
									if ( $end_number < $nav_settings['total'] - 2 ) { ?> 
										<span class="pgntn-elipses">...</span>
									<?php }
									/* display last link */
									if ( $end_number < $nav_settings['total'] - 1 )
										echo _wp_link_page( $nav_settings['total'] ) . $nav_settings['total'] . '</a>';
									/* display "next" link */
									if ( $nav_settings['current'] < $nav_settings['total'] && '1' == $pgntn_options ['display_next_prev'] ) {
										$next_link = $nav_settings['current'] + 1;
										echo _wp_link_page( $next_link ) . $nav_settings['next_text'] . '</a>';
									} 
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
		return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && ( ! is_page() ) ) ? true : false;
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

/**
 * Function for delete plugin options 
 * @return void
 */
if ( ! function_exists ( 'pgntn_delete_options' ) ) {
	function pgntn_delete_options() {
		delete_option( 'pgntn_options' );
	}
}

/**
 * Add all hooks 
 */
add_action( 'admin_menu', 'pgntn_add_admin_menu' );
add_action( 'init', 'pgntn_init' );
add_action( 'admin_init', 'pgntn_admin_init' );
/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'pgntn_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'pgntn_register_plugin_links', 10, 2 );
/* Include necessary css- and js-files */
add_action( 'admin_enqueue_scripts', 'pgntn_admin_head' );
add_action( 'wp_enqueue_scripts', 'pgntn_wp_head' );
register_uninstall_hook( __FILE__, 'pgntn_delete_options' );