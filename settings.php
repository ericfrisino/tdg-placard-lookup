<?php
/**
 * Created by PhpStorm.
 * User: holmes
 * Date: 10/22/18
 * Time: 5:18 PM
 */


class tdgp_settings_page {

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_settings'  ) );

	}

	public function add_admin_menu() {

		add_options_page(
			esc_html__( 'TDG Placard Lookup Settings', 'tdgp' ),
			esc_html__( 'TDG Placard Lookup', 'tdgp' ),
			'manage_options',
			'tdgp-settings',
			array( $this, 'tdgp_page_layout' )
		);

	}

	public function init_settings() {

	}

	public function tdgp_page_layout() {

		// Check required user capability
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'tdgp' ) );
		}

		// Grab the current Setting for the Database Version.
		$current_db_version = get_option( 'tdgp_db_version' );

		global $tdgp_db_new_version;
		global $tdgp_db_updated_on;

		// Admin Page Layout
		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . get_admin_page_title() . '</h1>' . "\n";
		echo '	<form action="" method="post">' . "\n";


		echo '  <table class="form-table">';
		echo '    <tbody>';
		echo '      <tr>';
		echo '        <th style="width:200px;"> Current Database Version : </th>';
		echo '        <td>' . $current_db_version . ' - Updated by Transport Canada on ' . $tdgp_db_updated_on . '</td>';
		echo '      </tr>';
		if ( ! is_null( $tdgp_db_new_version ) ) {
			echo '      <tr>';
			echo '        <th style="width:200px;"> Updated Database Version : </th>';
			echo '        <td>' . $tdgp_db_new_version . '</td>';
			echo '      </tr>';
			echo '      <tr>';
			echo '        <th style="width:200px;"> Update the Database? </th>';
			echo '        <td>' . $tdgp_db_new_version . '</td>';
			echo '      </tr>';
		}
		echo '    </tbody>';
		echo '  </table>';

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}

	function render_tdgp_update_database_field() {

		// Retrieve data from the database.
		$options = get_option( 'tdgp_setting' );

		// Set default value.
		$value = isset( $options['tdgp_update_database'] ) ? $options['tdgp_update_database'] : array();

		// Field output.
		echo '<input type="checkbox" name="tdgp_setting[tdgp_update_database][]" class="tdgp_update_database_field" value="' . esc_attr( 'Update Database' ) . '" ' . ( in_array( 'Update Database', $value )? 'checked="checked"' : '' ) . '> ' . __( '', 'tdgp' ) . '<br>';

	}

}

new tdgp_settings_page;