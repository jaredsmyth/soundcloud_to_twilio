<?php
// jared smith | http://jaredsmyth.info
//
$id = $_GET['id'];
print_r($id);

$root_server = '___ENTER_YOUR_ROOT_SERVER_PATH_HERE___';

// we delete the twill xml file since we don't need it anymore
// no server clutter FTW!
unlink($root_server . '/xmls/file-'.$id.'.xml');
?>
