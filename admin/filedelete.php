<?php

$fontneu = $_POST['fontneu'];




unlink($fontneu);

$u = $_SERVER['HTTP_REFERER'];
header("Location: $u");



?>
