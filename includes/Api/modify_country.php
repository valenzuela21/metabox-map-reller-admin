<?php
include_once(dirname(__FILE__) . '/load.php');
if ( !defined( 'ABSPATH' ) ) exit;
$data = json_decode(file_get_contents("php://input"), true);

global $wpdb;

$table = $wpdb->prefix."makers";

$wpdb->update($table,
    array(
        'id_post' => $data['id_post'],
        'city' => $data['city'],
        'address' =>$data['address'],
        'zip' =>$data['zip'],
        'country' => $data['country'],
        'lat' =>$data['lat'],
        'lng' =>$data['lng'],
        ), array('id'=>$data['id']));






