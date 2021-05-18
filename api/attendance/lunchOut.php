<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../includes/Database.php');
    include_once('../../models/Attendance.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();

    //instatiate attendance
    $attendance = new Attendance($db);

    //get raw attendance data
    $data = json_decode(file_get_contents("php://input"));

    //assign properties
    $attendance->emp_id = $data->emp_id;
    $attendance->date = $data->attendance_date;
    $attendance->lunch_out = $data->lunch_out;

    if($attendance->lunchOut()){
        echo json_encode(
            array(
            'emp_id'=>$attendance->emp_id,
            'attendance_date'=>$attendance->date,
            'lunch_out'=>$attendance->lunch_out)
        );
    } else {
        echo json_encode(
            array('message'=>'Unable to Clock In')
        );
    }

?>