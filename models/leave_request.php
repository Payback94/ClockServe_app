<?php 
    class LeaveRequest {
        private $conn;
        private $table ="request";

        //properties
        public $request_id;
        public $emp_id;
        public $request_type;
        public $request_reason;
        public $date_leave;
        public $date_return;
        public $medical_document;
        public $request_approval;

        public function __construct($db){
            $this->conn = $db;
        }
        //read everything 
        // public function read(){
        //     //query
        //     $sql = 'SELECT * from '.$this->table.'';

        //     //prepare statement
        //     $stmt = $this->conn->prepare($sql);
        //     //execute
        //     $stmt->execute();
        //     return $stmt;
        // }

        public function read(){
            //query
            $sql = 'SELECT 
                e.emp_first_name as emp_first_name,
                r.request_id,
                r.emp_id,
                r.request_type,
                r.request_reason,
                r.date_leave,
                r.date_return,
                r.request_approval
            FROM 
                '.$this->table.' r
            LEFT JOIN
                employee e on r.emp_id = e.emp_id
            ORDER BY
                e.emp_first_name';
            //prepared statement
            $stmt = $this->conn->prepare($sql);
            //execute
            $stmt->execute();
            return $stmt;
        }

        //read one request from one employee
        public function read_once(){
            $sql = 'SELECT * from '.$this->table.' WHERE request_id=? LIMIT 0,1';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(1, $this->request_id);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->request_id = $row['request_id'];
            $this->emp_id = $row['emp_id'];
            $this->request_type = $row['request_type'];
            $this->request_reason = $row['request_reason'];
            $this->date_leave = $row['date_leave'];
            $this->date_return = $row['date_return'];
            $this->request_approval = $row['request_approval'];

        }

        public function read_emp_once(){
            $sql = 'SELECT * FROM request WHERE emp_id=?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(1, $this->emp_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->request_id = $row['request_id'];
            $this->emp_id = $row['emp_id'];
            $this->request_type = $row['request_type'];
            $this->request_reason = $row['request_reason'];
            $this->date_leave = $row['date_leave'];
            $this->date_return = $row['date_return'];
            $this->request_approval = $row['request_approval'];

        }

        public function read_emp_all(){
            $sql = 'SELECT * FROM request WHERE emp_id=?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(1, $this->emp_id);
            $stmt->execute();
            return $stmt;
        }

        public function create(){
            $sql ="INSERT INTO ".$this->table." SET 
                emp_id=:emp_id,
                request_type=:request_type,
                request_reason=:request_reason,
                date_leave=:date_leave,
                date_return=:date_return,
                request_approval='PENDING'
            ";

            $stmt = $this->conn->prepare($sql);

            $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));
            $this->request_type = htmlspecialchars(strip_tags($this->request_type));
            $this->request_reason = htmlspecialchars(strip_tags($this->request_reason));
            $this->date_leave = htmlspecialchars(strip_tags($this->date_leave));
            $this->date_return = htmlspecialchars(strip_tags($this->date_return));

            $stmt->bindparam(':emp_id',$this->emp_id);
            $stmt->bindparam(':request_type',$this->request_type);
            $stmt->bindparam(':request_reason',$this->request_reason);
            $stmt->bindparam(':date_leave',$this->date_leave);
            $stmt->bindparam(':date_return',$this->date_return);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        public function update(){
            $sql ='UPDATE '.$this->table.' 
            SET 
                request_type=:request_type,
                request_reason=:request_reason,
                date_leave=:date_leave,
                date_return=:date_return
            WHERE
                emp_id=:emp_id
            ';

            $stmt = $this->conn->prepare($sql);

            $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));
            $this->request_type = htmlspecialchars(strip_tags($this->request_type));
            $this->request_reason = htmlspecialchars(strip_tags($this->request_reason));
            $this->date_leave = htmlspecialchars(strip_tags($this->date_leave));
            $this->date_reason = htmlspecialchars(strip_tags($this->date_reason));

            $stmt->bindparam(':emp_id',$this->emp_id);
            $stmt->bindparam(':request_type',$this->request_type);
            $stmt->bindparam(':request_reason',$this->request_reason);
            $stmt->bindparam(':date_leave',$this->date_leave);
            $stmt->bindparam(':date_return',$this->date_return);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }

        }

        public function approve(){
            
            $sql ='UPDATE '.$this->table.' 
            SET 
                request_approval=:request_approval
            WHERE
                emp_id=:emp_id
            ';

            $stmt = $this->conn->prepare($sql);

            $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));
            $this->request_approval = htmlspecialchars(strip_tags($this->request_approval));

            $stmt->bindparam(':emp_id',$this->emp_id);
            $stmt->bindparam(':request_approval',$this->request_approval);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }


        }
        public function deny(){

        }

        public function delete(){

        }


    }
?>