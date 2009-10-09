<?php

$dfr_tabelle = DFR_TABELLE;
$schema = get_option('dfr_schema');


function dfr_admin_listings() {

$update = $_GET['update'];
$delete = $_GET['delete'];
$newtag = $_GET['newtag'];
$dfr_tabelle = DFR_TABELLE;
$schema = get_option('dfr_schema');

if ($update) {
$update = $_POST['update'];
$id = $_POST['id'];
$font = $_POST['font'];
$fontname = $_POST['fontname'];
$tag = $_POST['tag'];
$fontsize = $_POST['fontsize'];

//$aendern = "UPDATE `$dfr_tabelle` SET `FONT` = '$fontname', `TAG` = '$tag', `FONTSIZE` = '$fontsize' WHERE `ID` = $id";

$aendern = "UPDATE `$dfr_tabelle` SET `FONT` = '$fontname', `TAG` = '$tag', `FONTSIZE` = '$fontsize' WHERE `ID` = $id";

mysql_query($aendern);

}

if ($delete) {
$delete = $_POST['delete'];
$id = $_POST['id'];
$loeschen = "DELETE FROM `$dfr_tabelle` WHERE `ID` = $id";
mysql_query($loeschen);

}

if ($newtag) {
$newtag = $_POST['newtag'];
$schema = $_POST['schema'];
$tag = $_POST['tag'];

$neuertag = "INSERT INTO `$dfr_tabelle` (SCHEMA, TAG, FONTSIZE) VALUES ('$schema', '$tag', 'px')";
mysql_query($neuertag);

}



?>

<div class="wrap">

<table align="left" border="0" cellpadding="4" cellspacing="4" width="100%">
	<tbody>
		<tr>
			<td class="widefat" align="left" style="height: 60px; width: 100%;" valign="top">
				<img alt="Dynamic Font Replacement" src="http://www.thorstengoerke.de/dfr.png" style="float: left;" />
				<h2>Dynamic Font Replacement 4WP - TagList</h2>
			</td>
		</tr>
		<tr>
			<td class="widefat" align="left" valign="top">
				<table border="0" cellpadding="1" cellspacing="1" style="width: 100%; height: 104px;">
					<tbody>
						<tr>
							<td align="left" style="width: 600px;" valign="top">
							<img src="<?php echo DFR_URLPATH; ?>/admin/linie1.png">
								<table border="0" align="left" border="1px" cellpadding="1" cellspacing="1">
									<tbody>
										<tr>
											<td align="left" valign="top">
												<form action="?page=dfr4wp-tags&newtag=y" method="post" enctype="multipart/form-data" name="NEWTAG">
												<input type="hidden" name="schema" value="<?php echo "$schema"; ?>">
												<input type="text" style="width:140px" name="tag" value="Tag">
												<input type="submit" style="width:256px" name="submit" value="Add CSS/HTML-tag">
												</form>
											</td>
										</tr>
									</tbody>
								</table>
<br>
<br>
<br>
<br>
<br>

<?php
$abfrage = "SELECT * FROM $dfr_tabelle WHERE `SCHEMA` = '$schema'";
$ergebnis = mysql_query($abfrage) or die(mysql_error());

while($row = mysql_fetch_object($ergebnis))
{
$row->ID;
$id = $row->ID;
$schemaaktiv = $row->SCHEMA;
$tag= $row->TAG;
$font = $row->FONT;
$fontsize = $row->FONTSIZE;
?>



								<table border="0" cellpadding="1" cellspacing="1" >
									<tbody>
										<tr>
											<td align="left">
												<form action="?page=dfr4wp-tags&update=y" method="post" enctype="multipart/form-data" name="UPDATE">
												<input type="hidden" name="id" value="<?php echo "$id"; ?>">
												<input type="text"  style="width:140px"  name="tag" value="<?php echo "$tag"; ?>">
											</td>
											<td align="left">
												<select align="left" style="width:150px; height: 25px" name="fontname">
													<option name="fontname" value="<?php echo "$font"; ?>"><?php echo "$font"; ?></option>

													<?php
													foreach (glob(DFR_FOLDER_FONTS . "*.js") as $filename) {
													$short_filename = basename($filename);
													$filename_content = file_get_contents ($filename); // echo substr($filename_content, 0, 110);
													$namen = $filename_content;
													$array = explode("\"",$namen);
													$fontname = $array[7];
													?>

													<option name="fontname" value="<?php echo "$fontname"; ?>"><?php echo "$fontname"; ?></option>

													<?php
													}
													?>

												</select>
											</td>
											<td align="left">
											<input type="text"  style="width:30px"  name="fontsize" value="<?php echo "$fontsize"; ?>">
											</td>
											<td align="left">
											<input type="submit" name="submit" value="Upd">
											</form>
											</td>
											<td align="left">
											<form action="?page=dfr4wp-tags&delete=y" method="post" enctype="multipart/form-data" name="DELETE">
											<input type="hidden" name="id" value="<?php echo "$id"; ?>">
											<input type="submit" name="submit" value="Del">
											</form>
											</td>
										</tr>
									</tbody>
								</table>



<?php
	}
?>




							</td>
							<td class="widefat" align="left" valign="top" background-color="#a77">

<?php include("text_tags.txt"); ?>




							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

</div>


<?php
}
?>