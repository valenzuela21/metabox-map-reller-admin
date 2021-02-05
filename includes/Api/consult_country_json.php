<?php
include_once(dirname(__FILE__) . '/load.php');
if ( !defined( 'ABSPATH' ) ) exit;
global $wpdb;

$table = $wpdb->prefix.'makers';
$id_post = $_REQUEST['id'];
$results = $wpdb->get_results( "SELECT * FROM $table WHERE id_post = $id_post" );


header("Content-type: application/json");
echo json_encode($results) ;
die();
?>
