<?php 
session_start();
include 'partials/_dbconnect.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: index.php");
    exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $currentMonthYear = date('Y_m'); // Format: YYYY_MM
    $sqlCreate = "CREATE TABLE IF NOT EXISTS `monthly_budget_${currentMonthYear}` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        monthly_budget int(10) NOT NULL
    )";
    $resultCreate = mysqli_query($conn, $sqlCreate);
    if($resultCreate){
        echo'';
    }else{
        echo'<script>
        alert("Error");
        </script>';
    }
    
    $monthly_budget = $_POST['monthly-budget'];
    $sql1 = "SELECT * FROM `monthly_budget_${currentMonthYear}` WHERE email = '$_SESSION[email]'";
    $result1 = mysqli_query($conn, $sql1);
    $numRows = mysqli_num_rows($result1);
    if($numRows == 1){
        $sql2 = "UPDATE `monthly_budget_${currentMonthYear}` SET `monthly_budget` = '$monthly_budget' WHERE email = '$_SESSION[email]'";
        $result2 = mysqli_query($conn, $sql2);
        if($result2){
            echo'<script>
            alert("Updated Successfully");
            window.location.href = "dashboard.php";
            </script>';
        }else{
            echo'<script>
            alert("Error Updating");
            </script>';
            
        }

    }else{
        $sql = "INSERT INTO `monthly_budget_${currentMonthYear}` (`email`, `monthly_budget`) VALUES ('$_SESSION[email]', '$monthly_budget')";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo'<script>
            alert("Addded Successfully");
            window.href.location = "dashboard.php";
            </script>';
        }else{
            echo'<script>
            alert("Error");
            </script>';
            
        }
    }
    
}
?>