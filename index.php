<?php
// Set CORS headers to allow requests from your frontend
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // connect to the database
    $hostname = "localhost";
    $username = "fontUploader";
    $password = "";
    $database = "font-uploader";

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if(!$conn){
        $response = array(
            "status" => "error",
            "message" => "Database connection failed."
        );
    } else{
        $files = $_FILES['fonts'];
        // set content-type
        header('Content-Type : application/json');
        $response = array();

        foreach($files['name'] as $key => $name){
            $tempName = $files['tmp_name'][$key];
        }
    }
}

?>