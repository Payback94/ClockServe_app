<?php 
    class Attendance{
        private $conn;
        private $table="attendance";

        //attendance properties
        public $attendance_id;
        public $attendance_string;
        public $emp_id;
        public $day;
        public $date;
        public $time_in;
        public $lunch_out;
        public $lunch_in;
        public $time_out;

        public function __construct($db)
        {
            $this->conn =$db;
        }
        //read all attendance
        public function read(){
            //query
            $sql = 'SELECT 
                e.emp_first_name as emp_first_name,
                a.attendance_id,
                a.attendance_string,
                a.emp_id,
                a.attendance_day,
                a.attendance_date,
                a.attendance_timeIn,
                a.Lunch_Out,
                a.Lunch_In,
                a.attendance_timeOut
            FROM 
                '.$this->table.' a
            LEFT JOIN
                employee e on a.emp_id = e.emp_id
            ORDER BY
                e.emp_first_name';
            //prepared statement
            $stmt = $this->conn->prepare($sql);
            //execute
            $stmt->execute();
            return $stmt;
        }

        public function read_all_day_emp(){
            //query
            $sql = 'SELECT 
                a.attendance_id,
                a.attendance_string,
                a.emp_id,
                a.attendance_day,
                a.attendance_date,
                a.attendance_timeIn,
                a.Lunch_Out,
                a.Lunch_In,
                a.attendance_timeOut
            FROM 
                '.$this->table.' a
            WHERE
                a.emp_id=?
            ORDER BY
                a.attendance_date DESC';
            //prepared statement

            $stmt=$this->conn->prepare($sql);

            $stmt->bindparam(1,$this->emp_id);
            //execute
            $stmt->execute();
            return $stmt;
        }

        public function read_single_day_emp(){
            //query
            $sql = 'SELECT 
                a.attendance_id,
                a.attendance_string,
                a.emp_id,
                a.attendance_day,
                a.attendance_date,
                a.attendance_timeIn,
                a.Lunch_Out,
                a.Lunch_In,
                a.attendance_timeOut
            FROM 
                attendance a
            where
                a.emp_id=? 
            LIMIT 
                0,1';

            //prepared statement
            $stmt = $this->conn->prepare($sql);
            //bind param
            $stmt->bindparam(1, $this->emp_id);

            //execute
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->attendance_id    = $row['attendance_id'];
            $this->attendance_string = $row['attendance_string'];
            $this->emp_id           = $row['emp_id'];
            $this->day              = $row['attendance_day'];
            $this->date             = $row['attendance_date'];
            $this->lunch_out        = $row['Lunch_Out'];
            $this->lunch_in         = $row['Lunch_In'];
            $this->time_in          = $row['attendance_timeIn'];
            $this->time_out         = $row['attendance_timeOut'];
        }

        //clock in attendance
        public function timeIn(){
            $sql = 'INSERT INTO '.$this->table.' SET
            attendance_string=:attendance_string,
            emp_id=:emp_id,
            attendance_day=:attendance_day, 
            attendance_date=:attendance_date, 
            attendance_timeIn=:attendance_timeIn';

            $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));
            $this->attendance_string = htmlspecialchars(strip_tags($this->attendance_string));
            $this->day = htmlspecialchars(strip_tags($this->day));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->time_in = htmlspecialchars(strip_tags($this->time_in));

            $stmt = $this->conn->prepare($sql);

            $stmt->bindparam(':attendance_string', $this->attendance_string);
            $stmt->bindparam(':emp_id', $this->emp_id);
            $stmt->bindparam(':attendance_day', $this->day);
            $stmt->bindparam(':attendance_date', $this->date);
            $stmt->bindparam(':attendance_timeIn', $this->time_in);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
        
        //clock out attendance
        public function timeOut(){
            $sql = 'UPDATE '.$this->table.' SET attendance_timeOut=:attendance_timeOut Where emp_id=:emp_id and attendance_date=:attendance_date';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindparam(':emp_id', $this->emp_id);
            $stmt->bindparam(':attendance_date', $this->date);
            $stmt->bindparam(':attendance_timeOut', $this->time_out);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        public function lunchOut(){
            $sql = 'UPDATE '.$this->table.' SET Lunch_Out=:Lunch_Out Where emp_id=:emp_id and attendance_date=:attendance_date';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindparam(':emp_id', $this->emp_id);
            $stmt->bindparam(':attendance_date', $this->date);
            $stmt->bindparam(':Lunch_Out', $this->lunch_out);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        public function lunchIn(){
            $sql = 'UPDATE '.$this->table.' SET Lunch_In=:Lunch_In Where emp_id=:emp_id and attendance_date=:attendance_date';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindparam(':emp_id', $this->emp_id);
            $stmt->bindparam(':attendance_date', $this->date);
            $stmt->bindparam(':Lunch_In', $this->lunch_in);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        public function delete(){
            $sql = 'DELETE '.$this->table.' where emp_id=:emp_id';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindparam(':emp_id',$this->emp_id);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
    }

?>