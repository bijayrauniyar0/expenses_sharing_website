<?php
session_start();
include 'partials/_dbconnect.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: index.php");
    exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $expense_name = $_POST['expense-name'];
    $expense_amount = $_POST['expense-amount'];
    $expense_date = $_POST['expense-date'];
    $expense_category = $_POST['expense-category'];
    $expense_shared_with = $_POST['expense-shared-with'];
    $expense_note = $_POST['expense-note'];

    $sql = "INSERT INTO expenses ( `email` ,`expense_name`, `expense_amount`, `expense_date`, `expense_category`, `expense_shared_with`, `expense_note`) VALUES ('".$_SESSION['email']."','''$expense_name', '$expense_amount', '$expense_date', '$expense_category', '$expense_shared_with', '$expense_note')";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo '
        <script>
            alert("Expense added successfully");
        </script>
        ';
    }else{
        echo '
        <script>
            alert("Error in adding expense. Please try again.");
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2f01e0402b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/add-expenses.css">
    <title>Add Expenses</title>
</head>
<body>
    <?php include 'partials/_aside.php'; ?>
    <section id="expenses-adder" class="expenses-adder">
        <h1>Add Expenses</h1>
        <form action="add-expenses.php" class="form" method="POST">
            <div class="input-group">
                <label for="expense-name">Expense Name</label>
                <input type="text" name="expense-name" id="expense-name" required>
            </div>
            <div class="input-group">
                <label for="expense-amount">Expense Amount</label>
                <input type="number" name="expense-amount" id="expense-amount" required>
            </div>
            <div class="input-group">
                <label for="expense-date">Expense Date</label>
                <input type="date" name="expense-date" id="expense-date" required>
            </div>
            <div class="input-group">
                <label for="expense-category">Expense Category</label>
                <select name="expense-category" id="expense-category" required>
                    <option value="food">Food</option>
                    <option value="rent">Rent</option>
                    <option value="transport">Transport</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="others">Others</option>
                </select>
            </div>
            <div class="input-group">
                <label for="expense-shared-with">Shared With</label>
                <input type="text" name="expense-shared-with" id="expense-shared-with">
            </div>
            <div class="input-group">
                <label for="expense-note">Note</label>
                <textarea name="expense-note" id="expense-note" cols="30" rows="5"></textarea>
            </div>
            <button type="submit">Add Expense</button>
        </form>
        <div class="previously-added">
            <h1>Previously Added</h1>
            <?php
            $sql1 = "SELECT * FROM expenses WHERE email='{$_SESSION['email']}' ORDER BY created_at DESC LIMIT 3;";            
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
                                    <p>Shared with: '.$row['expense_shared_with'].'</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
            ?>
            </div>
            
        </div>
    </section>
    <script src="../script/aside.js"></script>
</body>
</html>