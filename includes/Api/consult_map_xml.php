<?php
include_once(dirname(__FILE__) . '/load.php');

if ( !defined( 'ABSPATH' ) ) exit;

$doc = new DOMDocument('1.0', 'utf-8');
$node = $doc->createElement("markers");
$parnode = $doc->appendChild($node);

global $wpdb;

$table = $wpdb->prefix."makers";

$id_post = $_REQUEST['id'];

$answer =$wpdb->get_results( "SELECT * FROM $table WHERE id_post = $id_post" );

header("Content-type: text/xml");

foreach ($answer as $item){

    $node = $doc->createElement("marker");
    $newnode = $parnode->appendChild($node);

    $newnode->setAttribute("id",$item->idpost);
    $newnode->setAttribute("name",$item->city);
    $newnode->setAttribute("address",$item->address);
    $newnode->setAttribute("lat",$item->lat);
    $newnode->setAttribute("lng",$item->lng);
    $newnode->setAttribute("type",$item->type);


}

$xmlfile = $doc->saveXML();

echo $xmlfile;



?>
