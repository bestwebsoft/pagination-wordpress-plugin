<?php
/**
* Includes deprecated functions
*/

/**
 * Update options
 * @deprecated since 1.0.9
 * @todo remove after 31.10.2018
 */
if ( ! function_exists( 'pgntn_update_options' ) ) {
	function pgntn_update_options() {
		global $pgntn_options;
		if ( isset( $pgntn_options['margin_left'] ) ) {
			$pgntn_options['padding_left'] = $pgntn_options['margin_left'];
			unset( $pgntn_options['margin_left'] );
		}
		if ( isset( $pgntn_options['margin_right'] ) ) {
			$pgntn_options['padding_right'] = $pgntn_options['margin_right'];
			unset( $pgntn_options['margin_right'] );
		}
	}
}