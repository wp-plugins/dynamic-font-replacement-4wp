<?php
// Admin menu structure
add_action('admin_menu', 'dfr_add_admin_menu');
function dfr_add_admin_menu() {
	add_menu_page('Dynamic Font Replacement 4WP - Start','Dynamic Font Replacement', 'edit_pages', DFR_FOLDER, 'dfr_menu');
	add_submenu_page(DFR_FOLDER, 'Dynamic Font Replacement 4WP - Tags','Tags', 'edit_pages', 'dfr4wp-tags', 'dfr_menu');
	add_submenu_page(DFR_FOLDER, 'Dynamic Font Replacement 4WP - FAQ', 'FAQ', 'edit_pages', 'dfr4wp-faq', 'dfr_menu');
}

function dfr_menu() {
	global $wp_version;
	switch ($_GET["page"]) {

	case "dfr4wp-tags" :
		include_once (dirname (__FILE__) . '/listings.php');
		dfr_admin_listings();
		break;

	case "dfr4wp-faq" :
		include_once (dirname (__FILE__) . '/faq.php');
		dfr_admin_about();
		break;

	case "dfr4wp" :
	default :
		include_once (dirname (__FILE__) . '/start.php');
		dfr_admin_start();
		break;
	}
}
?>
