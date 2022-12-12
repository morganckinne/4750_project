<?php

/** F22, PHP (on GCP, local XAMPP, or CS server) connect to MySQL (on CS server) **/
$username = 'sms6ss'; 
$password = 'Fall2022Sierra';
$host = 'mysql01.cs.virginia.edu';
$dbname = 'sms6ss';
$dsn = "mysql:host=$host;dbname=$dbname";

/** connect to the database **/
try 
{
   $db = new PDO($dsn, $username, $password);
   
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>