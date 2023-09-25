<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: *");

// check the request method

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = file_get_contents("php://input");
    $data = json_decode($data);
    $data = $data->apikey;
    // api key
    if(isset($data) && $data == "XKSOEUNDPQ2294SKS"){
        // connect to db
        include 'connect.php';

        // get data
        $stmt = $connect->prepare("SELECT * FROM comments");
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        print_r(json_encode($row));

    }else{
        print_r(json_encode(['msg' => 'Error: API KEY Not Found']));
    }
}else{
    print_r(json_encode(['msg' => 'Error: Bad Request']));
}