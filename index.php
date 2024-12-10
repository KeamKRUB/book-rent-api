<?php
require_once("_system/_config.php");
$connect = new mysqli('localhost','root','','kurent');
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    header("Access-Control-Allow-Origin: *");
}
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");
if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
    $user = $_POST['user'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $image = $_POST['image'];
    $describe = $_POST['describe'];
    $contact = $_POST['contact'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $sql = "INSERT INTO item (date, user, name, price, type, image, amount, `describe`, contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssdssdsss", $date, $user, $name, $price, $type, $image, $amount, $describe, $contact);
    $stmt->execute();
    $stmt->close();
    ?>