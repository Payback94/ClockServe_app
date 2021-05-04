<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once('../../includes/Database.php');
    include_once('../../models/Attendance.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();

    //instatiate attendance
    $attendance = new Attendance($db);

    //get ID
    $attendance->emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : die();

    //get attendance
    $attendance->read_single_day_emp();

    //get single attendance array
    $attendance_arr = array(
        'attendance_id'=>$attendance->attendance_id,
        'attendance_string'=>$attendance->attendance_string,
                'emp_id'=>$attendance->emp_id,
                'attendance_day'=>$attendance->day,
                'attendance_date'=>$attendance->date,
                'attendance_timeIn'=>$attendance->time_in,
                'attendance_timeOut'=>$attendance->time_out
    );

        //make json
        print_r(json_encode($attendance_arr));
?>