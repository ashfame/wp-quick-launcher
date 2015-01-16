<?php

/*
 * Plugin Name: Quick Launcher
 * Plugin URI:  https://wordpress.org/plugins/
 * Description: Quick launcher prototype for jumping in WP admin pages
 * Author:      Ashfame
 * Version:     0.1
 */


class Ashfame_Quick_Launcher {

	private $version = '0.1';
	private $registered_shortcuts;

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'in_admin_footer', array( $this, 'inject_markup' ) );
	}

	public function plugins_loaded() {
		$defined_shortcuts = array(
			'view-orders' => admin_url( 'edit.php?post_type=shop_order' ),
			'view-order-%' => admin_url( 'post.php?post=%&action=edit' )
		);
		//print_r( $defined_shortcuts );
		$this->registered_shortcuts = apply_filters( 'defined_launcher_shortcuts', $defined_shortcuts );
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'admin-quick-launcher', plugins_url( 'js/quick-launcher.js', __FILE__ ), array( 'jquery-hotkeys' ), filemtime( plugin_dir_path( 'js/quick-launcher.js', __FILE__ ) ) );
		wp_localize_script( 'admin-quick-launcher', 'adminQuickLauncher', array( 'registeredShortcuts' => $this->registered_shortcuts ) );
	}

	public function inject_markup() {
	?>
		<input style="display:none;" id="adminQuickLauncher" type="text" />
		<style>
			#adminQuickLauncher {
				position: fixed;
				top: 50%;
				left: 50%;
				/* bring your own prefixes */
				transform: translate(-50%, -50%);
				z-index: 5001;
				padding: 10px;
				min-width: 500px;
				font-weight:bold;
				font-size:32px;
				box-shadow:5px 5px 15px;
			}
		</style>
	<?php
	}
}

new Ashfame_Quick_Launcher();