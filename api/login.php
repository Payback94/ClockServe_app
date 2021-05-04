<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    //import
    include_once('../includes/Database.php');

    //get json object into variable
    $email = '';
    $password = '';
    //instantiate db
    $database = new Database();
    $db = $database->connect();


    $data = file_get_contents("php://input");
    $json_data = json_decode($data, true);
    //assign inputs to properties;
    $email = $json_data['email'];
    $password = $json_data['password'];

    //table name
    $table = 'employee';
    //the query to get employee
    $sql = "Select emp_id, emp_first_name, emp_last_name, emp_birth_date, emp_email, emp_password, emp_gender, emp_race from ".$table." Where emp_email =?";
    //prepare statement
    $stmt = $db->prepare($sql);
    //bind query
    $stmt->bindparam(1, $email);

    //execute statement
    $stmt->execute();

    $num = $stmt->rowCount();
    if($num>0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //assign to properties
        $emp_first_name = $row['emp_first_name'];
        $emp_last_name = $row['emp_last_name'];
        $emp_birthDate = $row['emp_birth_date'];
        $emp_email = $row['emp_email'];
        $password2 = $row['emp_password'];
        $emp_gender = $row['emp_gender'];
        $emp_race = $row['emp_race'];
            if(password_verify($password,$password2) ){
                http_response_code(200);
                echo json_encode($row);
                }
            else {
            http_response_code(401);
            echo json_encode(array("message" => "Login failed.", "password" => $password));
                }
    } else {
    http_response_code(401);
    echo json_encode(array("message" => "Account not found", "json_result"=>$json_data));
    }

?>