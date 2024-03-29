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
    $rdata = file_get_contents("php://input");
    $data = json_decode($rdata);
    //assign properties
    $attendance->emp_id = $data->emp_id;
    $attendance->attendance_string = $data->attendance_string;
    $attendance->day = $data->attendance_day;
    $attendance->date = $data->attendance_date;
    $attendance->time_in = $data ->attendance_timeIn;

    if($attendance->timeIn()){
        echo json_encode(
            array('attendance_string'=>$attendance->attendance_string,
            'emp_id'=>$attendance->emp_id,
            'attendance_day'=>$attendance->day,
            'attendance_date'=>$attendance->date,
            'attendance_timeIn'=>$attendance->time_in,
            'attendance_timeOut'=>$attendance->time_out)
        );
    } else {
        echo json_encode(
            array('message'=>'Unable to Clock In')
        );
    }

?>