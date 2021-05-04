<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once('../../includes/Database.php');
    include_once('../../models/leave_request.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();
    
    $request = new LeaveRequest($db);
    $result = $request->read();
    $num = $result->rowCount();

    if($num>0){
        //employee array
        $request_arr = array();
        $request_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $request_list = array(
                'request_id'=>$request_id,
                'emp_id'=>$emp_id,
                'emp_first_name'=>$emp_first_name,
                'request_type'=>$request_type,
                'request_reason'=>$request_reason,
                'date_leave'=>$date_leave,
                'date_return'=>$date_return,
                'request_approval'=>$request_approval
            );
            //push to "data"
            array_push($request_arr['data'], $request_list);
        }
        //turn to json
        echo json_encode($request_arr);
    } else {
        echo json_encode(array('message'=>'No request found'));
    }

?>