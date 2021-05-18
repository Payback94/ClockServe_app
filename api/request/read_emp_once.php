<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    require('../../includes/Database.php');
    require('../../models/leave_request.php');

    //instatiate db
    $database = new Database();
    $db = $database->connect();

    //instatiate attendance
    $request = new LeaveRequest($db);

    //get ID
    $request->emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : die();

    //get attendance
    $request->read_emp_once();

    //get single attendance array
    $request_arr = array(
        'request_id'=>$request->request_id,
                'emp_id'=>$request->emp_id,
                'request_type'=>$request->request_type,
                'request_reason'=>$request->request_reason,
                'date_leave'=>$request->date_leave,
                'date_return'=>$request->date_return,
                'request_approval'=>$request->request_approval
    );
        //make json
        print_r(json_encode($request_arr));
?>