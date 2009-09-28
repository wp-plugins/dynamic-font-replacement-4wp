<?php

// Zeigt die Seite über den Autor an

function dfr_admin_about() {

?>

<div class="wrap">

<table align="left" border="0" cellpadding="4" cellspacing="4" width="100%">
	<tbody>
		<tr>
			<td class="widefat" align="left" style="height: 60px; width: 100%;" valign="top">
				<img alt="Dynamic Font Replacement" src="http://www.thorstengoerke.de/dfr.png" style="float: left;" />
				<h2>Dynamic Font Replacement 4WP - FAQ</h2>
			</td>
		</tr>
		<tr>
			<td class="widefat" align="left" valign="top">
				<table border="0" cellpadding="1" cellspacing="1" style="width: 100%; height: 104px;">
					<tbody>
						<tr>
							<td align="left" style="width: 600px;" valign="top">
							<img src="<?php echo DFR_URLPATH; ?>/admin/linie1.png">
								<?php include("text_faq.txt"); ?>
							</td>
							<td class="widefat" align="left" valign="top" background-color="#a77">
<?php include("text_author.txt"); ?>
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
