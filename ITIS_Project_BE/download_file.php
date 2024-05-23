<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$files = array(
    array("name" => "Document 1", "url" => "Files/Programming"),
    array("name" => "Document 2", "url" => "Files/Database"),
    array("name" => "Document 3", "url" => "Files/ITInfarstructure")
);

echo json_encode($files);
?>
