<?php

/*
Plugin Name: DFR4WP Dynamic Font Replacement
Plugin URI: http://www.dynamic-font-replacement.com/
Description: Use your own ttf- or otf-fonts with wordpress. Seo-friendly, fast and easy. The sourcecode of your site will be not modify.
Version: 1.2 EN
Author: Thorsten Goerke
Author URI: http://www.thorstengoerke.de/
*/

// STOP DIRECT CALLS
if( preg_match( '#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'] ) ) { die( 'You are not allowed to call this page directly.' ); }


global $listings;
global $wpdb, $wp_version;

if ( !defined('WP_CONTENT_URL') ) {
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
}
if ( !defined('WP_CONTENT_DIR') ) {
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
}


define( 'DFR_TABELLE', $wpdb->prefix .'dfr');
define( 'SITEURL', get_option('home') . '/');
define( 'DFR_FOLDER', WP_CONTENT_DIR . '/plugins/' . dirname(plugin_basename(__FILE__) ));
define( 'DFR_URLPATH',  WP_CONTENT_URL .'/plugins/' .  dirname(plugin_basename(__FILE__) ) . '/');
define( 'DFR_FOLDER_FONTS',  DFR_FOLDER .'/fonts/' );
define( 'DFR_FOLDER_URL',  DFR_URLPATH .'fonts/' );



$plugin_url = DFR_URLPATH;


if ( is_admin() ) {
	# ensure we have jquery available on admin screens
	# wp_enqueue_script( 'jquery' );
	require_once( dirname (__FILE__).'/admin/admin.php' );

}


// Hier wird das Plugin aktiviert und der Code ausgeführt
register_activation_hook( __FILE__, 'dfr_activate' );

function dfr_activate( ) {


	add_option( 'dfr_aktiv', '' );
	add_option( 'dfr_jsquery', '' );
	add_option( 'dfr_schema', 'cufon' );
	 table_install();

}

function dfr_add_headerincludes( ) {

	$aktiv = ( 'true' == get_option( 'dfr_aktiv' ) ) ? true : false;


	echo "\n<!-- ANFANG DFR -->\n";
	if ( $aktiv ) {
?>

<!-- Implementierung der Grunddateien -->


<?php
	$jsquery = ( 'true' == get_option( 'dfr_jsquery' ) ) ? true : false;
	if ( $jsquery ) {
?>
<script src="<?php echo DFR_URLPATH; ?>js/jquery-1.3.2.min.js" type="text/javascript"></script>
<?php
}
?>
<script src="<?php echo DFR_URLPATH; ?>js/cufon-yui.js" type="text/javascript"></script>

<?php

foreach (glob(DFR_FOLDER_FONTS . "*.js") as $dateiname) {
$shorty = basename($dateiname);
?>
<script type="text/javascript" src="<?php echo DFR_URLPATH; ?>fonts/<?php echo $shorty; ?>"></script>
<?php
}
?>


<script type="text/javascript" >
<?php

$schema = get_option('dfr_schema');
$dfr_tabelle = DFR_TABELLE;
$aa = "SELECT * FROM $dfr_tabelle WHERE `SCHEMA` = '$schema'";
$ee = mysql_query($aa) or die(mysql_error());

while($row = mysql_fetch_object($ee))
{
$row->ID;
$id = $row->ID;
$schemaaktiv = $row->SCHEMA;
$tag= $row->TAG;
$font = $row->FONT;
$fontsize = $row->FONTSIZE;

 echo "Cufon.replace('$tag', {";

 echo "fontFamily: '$font' ";

 if($fontsize > 0){
echo ", fontSize: '";
echo "$fontsize";
echo "px'";
 };
echo "}); \n";

}

}
?>
</script>
<?php
	echo "\n<!-- ENDE DFR -->\n";
}



add_action( 'wp_head', 'dfr_add_headerincludes', 90 );



function table_install() {
	global $wpdb;

	$table_name = $wpdb->prefix . "dfr";

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
		$sql = "CREATE TABLE " . $table_name . " (
  `ID` SMALLINT( 3 ) NOT NULL AUTO_INCREMENT ,
  `SCHEMA` varchar(50) NOT NULL default '',
  `TAG` varchar(50) NOT NULL,
  `FONT` varchar(50) NOT NULL default '',
  `FONTSIZE` varchar(3) NOT NULL default '',
  `FREI2` varchar(50) NOT NULL default '',
  `FREI3` varchar(50) NOT NULL default '',

  PRIMARY KEY  (`ID`)

		)TYPE=MyISAM;

INSERT INTO `$table_name` (`ID`, `SCHEMA`, `TAG`, `FONT`, `FONTSIZE`, `FREI2`, `FREI3`) VALUES
('1', 'cufon', 'h1', 'TitilliumText15L', 'px', '', ''),
('2', 'cufon', 'h2', 'TitilliumText15L', 'px', '', ''),
('3', 'cufon', 'p', 'TitilliumText15L', 'px', '', '');



		";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	}

}

function dfr_set_font() {
global $greatrealestate_db_version;
if ( current_user_can( 'manage_options' ) ) {
?>



								<table width="100%" border="0" cellpadding="1" cellspacing="1" >
									<tbody>
										<tr>




											<td align="left" valign="top">
											<form method="post" action="options.php">
											<?php wp_nonce_field('update-options'); ?>
											<input id="usecss" type="checkbox" name="dfr_aktiv" value="true" <?php echo ( 'true' == get_option('dfr_aktiv') )  ? 'checked="checked"' : ''; ?> />
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="dfr_aktiv" />
											<input type="submit" name="Submit" value="<?php _e('Activate DFR') ?>" />
											</form>
											</td>

											<td align="left" valign="top">
											<form method="post" action="options.php">
											<?php wp_nonce_field('update-options'); ?>
											<input id="usecss" type="checkbox" name="dfr_jsquery" value="true" <?php echo ( 'true' == get_option('dfr_jsquery') )  ? 'checked="checked"' : ''; ?> />
											<input type="hidden" name="action" value="update" />
											<input type="hidden" name="page_options" value="dfr_jsquery" />
											<input type="submit" name="Submit" value="<?php _e('Activate jsquery*') ?>" />
											</form>
											</td>

										</tr>
									</tbody>
								</table>
















<?php
	}
?>



<h3>Installierte Fonts</h3>

<?php
		foreach (glob(DFR_FOLDER_FONTS . "*.js") as $filename) {
		$short_filename = basename($filename);
		$filename_content = file_get_contents ($filename); // echo substr($filename_content, 0, 110);
		$namen = $filename_content;
		$array = explode("\"",$namen);
		$fontname = $array[7];
?>

<form action="<?php echo DFR_URLPATH; ?>admin/filedelete.php" method="post" enctype="multipart/form-data" name="Delete">
<table class="widefat" width="500px" border="0" cellpadding="1" cellspacing="1" >
<tr valign="top">

<td width="50">
<img src="<?php echo DFR_URLPATH; ?>/icon_ttf.gif" />
</td>

<td width="400">
<?php echo $fontname; ?> (<?php echo $short_filename; ?>)<br />
</td>

<td width="50">
<input type="hidden" name="fontneu" value="<?php echo DFR_FOLDER_FONTS; ?><?php echo $short_filename; ?>">
<input class="delete"  type="submit" name="submit" value="Delete">
</td>

</tr>
</table>

</form>
<br>

<?php

?>



		<?php
	}

	// if empty
	if(!isset($filename)){
		echo"<em>No files found!</em>";
		?><div id="message" class="updated fade"><p><strong>No files found in /wp-content/plugins/fonts/</strong></p></div><?php
	}

	?>


	<?php
}

function dfr_upload_font() {
?>

<h3>Upload a new font</h3>
<form action="<?php echo DFR_URLPATH; ?>admin/upload2.php" method="post" enctype="multipart/form-data" name="upload">

<table class="widefat" width="500px" border="0" cellpadding="1" cellspacing="1" >
<tr valign="top">
<td width="400px">
<input class="filefeld" type="file" name="file">
<input type="hidden" name="bildnameneu" value="<?php echo DFR_FOLDER_FONTS; ?><?php $zufall = rand(1,100000);
echo $zufall;
?>.js">
</td>

<td width="100px">

<input class="upload"  type="submit" name="submit" value="Upload">
</td>
</tr>
</table>
</form>

<?php
}
?>