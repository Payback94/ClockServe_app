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

    //get id
    $employee->emp_id = isset($_GET['emp_id']) ? $_GET['emp_id']: die();

    //get employee
    $employee->read_single();

    //get single array
    $emp_array = array(
        'emp_id'=>$employee->emp_id,
        'emp_first_name'=>$employee->emp_first_name,
        'emp_last_name'=>$employee->emp_last_name,
        'emp_birth_date'=>$employee->emp_birthDate,
        'emp_email'=>$employee->emp_email,
        'emp_password'=>$employee->emp_password,
        'emp_gender'=>$employee->emp_gender,
        'emp_race'=>$employee->emp_race
    );

    //make JSON
    print_r(json_encode($emp_array));
?>