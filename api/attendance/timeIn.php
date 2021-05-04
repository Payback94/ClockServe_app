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
    var_dump($data);
    //assign properties
    $attendance->emp_id = $data->emp_id;
    $attendance->attendance_string = $data->attendance_string;
    $attendance->day = $data->attendance_day;
    $attendance->date = $data->attendance_date;
    $attendance->time_in = $data ->attendance_timeIn;

    if($attendance->timeIn()){
        
        echo json_encode(
            array('message'=>'Clocked In'),http_response_code(200)
        );
    } else {
        echo json_encode(
            array('message'=>'Unable to Clock In')
        );
    }

?>