<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../includes/Database.php');
    include_once('../../models/leave_request.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();

    //instatiate attendance
    $request = new LeaveRequest($db);

    
    //get raw attendance data
    $rdata = file_get_contents("php://input");
    $data = json_decode($rdata);
    //assign properties
    $request->emp_id = $data->emp_id;
    $request->request_type = $data->request_type;
    $request->request_reason = $data->request_reason;
    $request->date_leave = $data->date_leave;
    $request->date_return = $data->date_return;


    if($request->create()){
        echo json_encode(
            array(
                'emp_id'=>$request->emp_id,
                'request_type'=>$request->request_type,
                'request_reason'=>$request->request_reason,
                'date_leave'=>$request->date_leave,
                'date_return'=>$request->date_return)
        );
    } else {
        echo json_encode(
            array('message'=>'Unable to Clock In')
        );
    }

?>