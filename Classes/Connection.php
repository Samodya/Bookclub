<?php
    class Connection{
        public static function GetConnection(){
            try {
                $server="localhost";
                $db="authors";
                $un="Books";
                $pw="Password123";
                $conn = new PDO("mysql:host=$server;dbname=$db",$un,$pw);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $conn; 
            } catch (PDOException $th) {
                throw $th;
            }
        }
    }
    
?>