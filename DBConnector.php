<?php
define('DB_SERVER', 'localhost');
define ('DB_USER','root');
define('DB_PASS', '');
define('DB_NAME', 'btc3205');

class DBConnector{
     public $conn;
     public $link;
     function __construct()
     {
     	$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASS) or die("Error:" .mysqli_error());
       return $this->conn;

     }
      function closeDatabase(){
     	return mysqli_close($this->conn);
     }

}
 

?>