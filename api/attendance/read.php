<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once('../../includes/Database.php');
    include_once('../../models/Attendance.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();
    
    $attendance = new Attendance($db);
    $result = $attendance->read();
    $num = $result->rowCount();

    if($num>0){
        //employee array
        $attendance_arr = array();
        $attendance_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $attendance_list = array(
                'attendance_id'=>$attendance_id,
                'attendance_string'=>$attendance_string,
                'emp_id'=>$emp_id,
                'emp_first_name'=>$emp_first_name,
                'attendance_day'=>$attendance_day,
                'attendance_date'=>$attendance_date,
                'attendance_timeIn'=>$attendance_timeIn,
                'attendance_timeOut'=>$attendance_timeOut
            );
            //push to "data"
            array_push($attendance_arr['data'], $attendance_list);
        }
        //turn to json
        echo json_encode($attendance_arr);
    } else {
        echo json_encode(array('message'=>'No attendance found'));
    }

?>
