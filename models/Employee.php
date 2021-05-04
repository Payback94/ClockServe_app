<?php 
    class Employee {
        //database connection
        private $conn;
        private $table='employee';

        //employee properties
        public $emp_id;
        public $emp_first_name;
        public $emp_last_name;
        public $emp_birthDate;
        public $emp_gender;
        public $emp_race;
        public $emp_email;
        public $emp_password;

        
        public function __construct($db)
        {
            $this->conn = $db;
        }

        //get employee  
        public function read(){
            //query
            $sql='SELECT * from '.$this->table.'';
            //prepare statement
            $stmt = $this->conn->prepare($sql); 
            //execute 
            $stmt->execute();
            return $stmt;
        }

        //read single user
        public function read_single(){
            //query
            $sql='SELECT * from '.$this->table.' where emp_id=? LIMIT 0,1';
            //prepare statement
            $stmt = $this->conn->prepare($sql);
            //bind parameter
            $stmt->bindParam(1, $this->emp_id);
            //execute 
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->emp_first_name = $row['emp_first_name'];
            $this->emp_last_name = $row['emp_last_name'];
            $this->emp_birthDate = $row['emp_birth_date'];
            $this->emp_email = $row['emp_email'];
            $this->emp_password = $row['emp_password'];
            $this->emp_gender = $row['emp_gender'];
            $this->emp_race = $row['emp_race'];
        }

    }
?>