<?php
include_once(dirname(__FILE__) . '/load.php');
if ( !defined( 'ABSPATH' ) ) exit;
$data = json_decode(file_get_contents("php://input"), true);

global $wpdb;

$table = $wpdb->prefix."makers";

$insert = $wpdb->insert( $table,
                    array(
                       'id_post' => $data['id_post'],
                       'city' => $data['country'],
                       'address' => $data['route'].' '.$data['street_number'],
                       'zip' => $data['postal_code'],
                       'country'=>$data['country'],
                       'lat'=>$data['latitude'],
                       'lng'=>$data['longitude'],
           ),
           array(
           '%d',
           '%s',
           '%s',
           '%s',
           '%s',
           '%s',
           '%s'
           )
           );




