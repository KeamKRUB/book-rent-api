<?php
require_once("_system/_config.php");
require_once("_system/_database.php");
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
    $records_per_page = 6;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $records_per_page;
    $user = isset($_GET['user']) ? $_GET['user'] : 1;
    $sql = "SELECT * FROM item WHERE user = ? LIMIT ?, ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sii", $user, $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $stmt->close();
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    $file_path = "C:/xampp/htdocs/Ku-Rent/data.json";
    file_put_contents($file_path, $json_data);
    header('Content-Type: application/json; charset=utf-8');
    echo $json_data;
?>