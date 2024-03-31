<?php
session_start();
include 'partials/_dbconnect.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2f01e0402b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/my-expenses.css">
    <title>Add Expenses</title>
</head>
<body>
    <?php 
    $className = ".expenses-display";
    include 'partials/_aside.php'; 
    
    ?>
    <section id="expenses-display" class="expenses-display active">
        <div class="previously-added">
            <h1>My Expenses</h1>
            <?php
            $sql1 = "SELECT * FROM expenses WHERE email='{$_SESSION['email']}'";            
            $result1 = mysqli_query($conn, $sql1);
            $num1 = mysqli_num_rows($result1);
            if($num1 == 0){
                echo '
                <h2>No expenses added yet</h2>
                ';
            }else{
                while($row = mysqli_fetch_assoc($result1)){
                    echo'
                    <div class="history-holder">
                        <span class="expenses-title">
                            <h2 class="category-title">'.$row['expense_category'].'</h2>
                            <h3>|&nbsp;&nbsp;'.$row['expense_name'].'</h3>
                            <p class="date">'.$row['expense_date'].'</p>
                        </span>
                        <div class="history">
                            <div class="history-item">
                                <span class="amount-shared">
                                    <p>Rs. '.$row['expense_amount'].'&nbsp;&nbsp;|</p>
                                    <p>';
                                    if($row['expense_shared_with'] == ''){
                                        echo'
                                        Shared with: None</p>';
                                    }else{
                                    echo'
                                    Shared with: '.$row['expense_shared_with'].' ';
                                    }
                                    echo'</p>
                                </span>
                            </div>
                        </div>
                    </div>';
                }
            }
            ?>
            </div>
            
        </div>
    </section>
    <script src="../script/aside.js"></script>
</body>
</html>