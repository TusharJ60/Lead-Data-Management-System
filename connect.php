<?php
//connecting to the database
$servername = "localhost";
$username = "root";
$password = "";

//230058 se lead master data chalu hai aur 89 se calling status

//create a connection
$conn = mysqli_connect($servername, $username, $password);

$sql="CREATE DATABASE IF NOT EXISTS kalam_test";
// I ADDED THE IF NOT EXISTS PART TO THE SQL QUERY BECAUSE I FIRSTLY EXECUTED THE CODE WITH THE 'IF NOT EXISTS' QUERY WHICH CREATED IT AND TO PREVENT FULL CODE GIVING ERROR I ADDED THIS STATEMENT
$result=mysqli_query($conn,$sql);
// echo"the result is";
// echo var_dump($result);
// echo"<br>";

// if (!$conn) {
//     die("Sorry we failed to connect: " . mysqli_connect_error());
// }
// else{
//     echo "Connection was successful<br>";
// }
// ini_set('max_execution_time', 10000000); 

// Reconnect to MySQL
// mysqli_ping($conn);
// SQL file to import

$filepath = 'data_test.sql';
if(file_exists($filepath)){
    importDatabaseTables($servername, $username, $password,  $filepath);
}
else{
    echo "file does not exist";
}
function importDatabaseTables($servername, $username, $password, $filepath){
    // Connect & select the database
    $db = new mysqli($servername, $username, $password, "kalam_test"); 
 
    // Temporary variable, used to store current query
    $templine = '';
    
    // Read in entire file
    $lines = file($filepath);
    
    $error = '';
    
    // Loop through each line
    foreach ($lines as $line){
        // Skip it if it's a comment
        if(substr($line, 0, 2) == '--' || $line == ''){
            continue;
        }
        
        // Add this line to the current segment
        $templine .= $line;
        
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';'){
            // Perform the query
            if(!$db->query($templine)){
                $error .= 'Error importing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
            }
            
            // Reset temp variable to empty
            $templine = '';
        }
    }
    return !empty($error)?$error:true;
}
// $filename = file_get_contents("data_test.sql"); 
// $sql2 = mysqli_connect($servername, $username, $password, "kalam_test");
// $sql2->multi_query($filename);

// // Read the SQL file
// $sql2 = file_get_contents($sqlFile);

// // Execute multiple queries (if the SQL file contains multiple queries)
// if ($conn->multi_query($sql2)) {
//     echo "SQL file imported successfully";
// } else {
//     echo "Error importing SQL file: " . $conn->error;
// }


?>
