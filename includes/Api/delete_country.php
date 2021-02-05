<?php
include_once(dirname(__FILE__) . '/load.php');
if ( !defined( 'ABSPATH' ) ) exit;
$data = json_decode(file_get_contents("php://input"), true);

global $wpdb;
$table = $wpdb->prefix."makers";

$wpdb->delete($table, array('id' => $data['id_data']));
