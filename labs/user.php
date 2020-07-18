<?php
    include "crud.php";
    include "authenticate.php";
    include_once "DBConnector.php";

    class User implements Crud, Authenticator{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        private $username;
        private $password;
        private $offset;
	    private $utc_timestamp;

       public function __construct($first_name, $last_name, $user_city, $username, $password){
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->user_city = $user_city;
    
      $this->username = $username;
      $this->password = $password;
 }  

    
  public static function create(){
    $instance = new ReflectionClass(__CLASS__);

    return $instance->newInstanceWithoutConstructor();
  }

  public function setUsername($username){
      $this->username = $username;
  }

  public function getUsername(){
      return $this->username;
  }
  
  public function setPassword($password){
    $this->password = $password;
  }

  public function getPassword(){
      return $this->password;
  }


  public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /* Setters and Getters for the time_zone_offset and utc_timestamp */


    public function getTimezoneOffset()
    {
        return $this->tmzn_off;
    }

    public function setTimezoneOffset($tMzOffset)
    {
        $this->tmzn_off = $tMzOffset;
    }


    //Utc_timestamp (Set and Get)
    public function getUtcTimestamp()
    {
        return $this->utc_timestamp;
    }

    public function setUtcTimestamp($utc_timestamp)
    {
        $this->utc_timestamp = $utc_timestamp;
    }

    public function save(){
     $connect = new DBConnector();
     $fn = $this->first_name;
     $ln = $this->last_name;
     $city = $this->user_city;
     $tMzOffset = $this->getTimezoneOffset();
     $utc_tmstp = $this->getUtcTimestamp();
     
     $this->hashPassword();
     $uname = $this->username;
     $pass_wrd = $this->password;
    
     $res = mysqli_query($connect->conn,"INSERT INTO users (first_name, last_name, user_city, username, password, created_time, offset) VALUES ('$fn', '$ln', '$city', '$uname', '$pass_wrd', 'utc_tmstp', '$tMzOffset')");
     return $res;
     
     $connect->closeDatabase();

     return $res;
    }

      public function readAll()
    { 
      $connect = new DBConnector();
      $res_set = mysqli_query($connect->conn,"SELECT * FROM users");
      
      if(mysqli_num_rows($res_set) > 0)
      {
        echo "<table align='center' border='1px' style='width:600px; line-height:40px;'>";
          echo "<t>";
              echo "<th>"; echo "ID"; echo "</th>";
              echo "<th>"; echo "First Name"; echo "</th>";
              echo "<th>"; echo "Last Name"; echo "</th>";
              echo "<th>"; echo "City"; echo "</th>";
              echo "<th>"; echo "Username"; echo "</th>";
              echo "<th>"; echo "Password"; echo "</th>";
        while($row= mysqli_fetch_assoc($res_set))
        {
          
          echo "</t>";
            echo "<tr>";
                echo "<td>";
                    echo $row['id'];
                echo "</td>";
                echo "<td>";
                    echo $row['first_name'];
                echo "</td>";
                echo "<td>";
                    echo $row['last_name'];
                echo "</td>";
                echo "<td>";
                    echo $row['user_city'];
                echo "</td>";
                 echo "<td>";
                    echo $row['username'];
                echo "</td>";
                 echo "<td>";
                    echo substr($row['password'], 0,10);
                echo "</td>";
            echo "</tr>";
          
          
        }
      echo "</table>";
        
      }else{
          echo "0 results";
      }  
        
    }

     public function readUnique()
    {
        // readUnique() method.
    }

    public function search()
    {
        // search() method.
    }

    public function update()
    {
        // update() method.
    }

    public function removeOne()
    {
        //removeOne() method.
    }

    public function removeAll()
    {
        // removeAll() method.
    }

    public function validateForm(){
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->user_city;
        $username = $this->username;
        $password= $this->password;

        if($fn == "" || $ln == "" || $city == "" || $password =="" || $username=="" ||$this->isUserExist()){
            return false;
        }

        return true;
    }

    public function createFormErrorSessions(){
        session_start();
                
        $_SESSION['form_errors'] = "All Fields are required"; 
        
        if($this->isUserExist()){
             $_SESSION['exists'] = "This Username is already in use";
        }
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isPasswordCorrect(){
        $con = new DBConnector;
        $found  = false;
        $res = mysqli_query($con->conn, "SELECT * FROM users" );

        while($row=mysqli_fetch_assoc($res))
        {
            if (password_verify($this->password, $row['password']) && $this->getUsername()==$row['username']){
                $found = true;
            }
        }

        $con->closeDatabase();

        return $found;
    }

    public function login(){
       if($this->isPasswordCorrect())
       {
           header("Location: private_page.php");
       }
    }

    public function createUserSession(){
        session_start();
        $_SESSION['username'] = $this->getUsername();

    }

    public function logout(){
        session_start();
        unset($_SESSION['username']);
        session_destroy();
        header("Location: lab1.php");
    }

    public function isUserExist(){
        $con =new  DBConnector;
        $found = false;
        $username = $this->username;

        $res_set = mysqli_query($con->conn, "SELECT * FROM users "); 

        while($row = mysqli_fetch_assoc($res_set)){
            if($username == $row['username']){
                $found = true;
                $_SESSION['exists'] = "This Username is already in use";
                break;
            }
        
        }
        $con->closeDatabase();

        return $found;
    }

 }