<?php 
    //grab database connection
    include_once('../includes/Database.php');
    //headers
    header("Access-Control-Allow-Origin: * ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //properties
    $first_name ='';
    $last_name ='';
    $email ='';
    $password ='';
    $password2 ='';
    $gender = '';
    $race = '';

    //connection
    $conn = null;

    $database = new Database();
    $conn = $database->connect();

    //this shit is weird and I don't know why it doesn't work sometimes
    //this basically grabs whatever input its hooked up to a json array
    $data = file_get_contents("php://input");
    //this converts it
    $json_data = json_decode($data, true);

    var_dump($data);
    var_dump($json_data);

    $first_name =$json_data['first_name'];
    $last_name =$json_data['last_name'];
    $email =$json_data['email'];
    $password =$json_data['password'];
    $password2 =$json_data['password2'];
    $gender = $json_data['gender'];
    $race = $json_data['race'];


    $table = 'employee';

    $sql = "INSERT INTO ".$table." SET 
    emp_first_name=:firstname, 
    emp_last_name=:lastname, 
    emp_email=:email,
    emp_password=:password,
    emp_gender=:gender,
    emp_race=:race";

   

    if($password == $password2){
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $first_name);
        $stmt->bindParam(':lastname', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':race', $race);

        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $passHash);

        if($stmt->execute()){
            http_response_code(200);
            echo json_encode(array("message"=>"Successfully registered"));
        }
        else {
            http_response_code(400);
            echo json_encode(array("message"=>"Unable to register."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message"=>"Password mismatch try again."));
    }

    

?>
