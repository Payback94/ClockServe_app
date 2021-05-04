<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once('../includes/Database.php');
    include_once('../models/Employee.php');

    //instantiate db
    $database = new Database();
    $db = $database->connect();

    //instantiate employee
    $employee = new Employee($db);


    //employee list query
    $result = $employee->read();
    //get count 
    $num = $result->rowCount();

    //check if any employee 
    if($num>0){
        //employee array
        $emp_arr = array();
        $emp_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $emp_person = array(
                'emp_id'=>$emp_id,
                'emp_first_name'=>$emp_first_name,
                'emp_last_name'=>$emp_last_name,
                'emp_birth_date'=>$emp_birth_date,
                'emp_email'=>$emp_email,
                'emp_password'=>$emp_password,
                'emp_gender'=>$emp_gender,
                'emp_race'=>$emp_race
            );
            //push to "data"
            array_push($emp_arr['data'], $emp_person);
        }
        //turn to json
        echo json_encode($emp_arr);
    } else {
        echo json_encode(array('message'=>'No emp found'));
    }
?>