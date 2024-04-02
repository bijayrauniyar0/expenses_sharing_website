<?php
session_start();
include 'partials/_dbconnect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../css/my-expenses.css">
    <title>Add Expenses</title>
</head>

<body>
    <?php
    $className = ".expenses-display";
    include 'partials/_aside.php';

    ?>
    <section id="expenses-display" class="expenses-display active">
        <h1 style="font-size: 2rem;">My Expenses for
            <?php
            $currentMonth = date('F');
            echo $currentMonth;
            ?>
        </h1>
        <div class="previously-added">
            <?php
            $currentMonthYear = date('Y_m');
            $email = $_SESSION['email'];
            $sql1 = "SELECT * FROM `expenses_${email}_${currentMonthYear}`";
            $result1 = mysqli_query($conn, $sql1);
            $num1 = mysqli_num_rows($result1);
            if ($num1 == 0) {
                echo '
                <h2>No expenses added yet</h2>
                ';
            } else {
                $food = 0;
                $rent = 0;
                $transportation = 0;
                $entertainment = 0;
                $others = 0;
                echo'<div class="expenses-cards-container">';
                while ($row = mysqli_fetch_assoc($result1)) {
                    if($row['expense_category'] == 'Food'){
                        $food += $row['expense_amount'];
                    }
                    elseif($row['expense_category'] == 'Rent'){
                        $rent += $row['expense_amount'];
                    }
                    elseif($row['expense_category'] == 'Transportation'){
                        $transportation += $row['expense_amount'];
                    }
                    elseif($row['expense_category'] == 'Entertainment'){
                        $entertainment += $row['expense_amount'];
                    }else{
                        $others += $row['expense_amount'];
                    }   
                    
                }
                $categories = ['Food', 'Rent', 'Transportation', 'Entertainment', 'Others'];
                $amounts = [$food, $rent, $transportation, $entertainment, $others];
                for($i = 0; $i < 5; $i++){
                    echo '
                    <div class="expenses-card">
                        <h2>'.$categories[$i].'</h2>
                        <p>Rs '.$amounts[$i].'</p>
                    </div>
                    ';
                }

            echo '</div>';
            }
echo"
        </div>
        <div id='chart-container'>
            <div id='chart_div'></div>
        </div>
    </section>
    <script src='../script/aside.js'></script>
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['Expenses', 'Amount',],";

      for($i = 0; $i < 5; $i++){
          echo "['".$categories[$i]."', ".$amounts[$i]."],";
      }
        echo"]);";
    $currentMonth = date('F');
      echo"

      

      var winWidth 
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
          window.addEventListener('resize', function(event) {
            if(document.body.clientWidth<992 && document.body.clientWidth>576){
                winWidth = 300;
            }else if(document.body.clientWidth<576){
                winWidth = 200;
            }
            else{
                winWidth = 850;
            }
        })
        var options = {
            title: 'Expenses for ".$currentMonth."',
            chartArea: {width: '50%'},
            hAxis: {
              title: 'Amount',
              minValue: 0,";
              $sqlAmount = "SELECT * FROM `monthly_budget_${currentMonthYear}` WHERE email = '$email'";
                $resultAmount = mysqli_query($conn, $sqlAmount);
                $rowAmount = mysqli_fetch_assoc($resultAmount);
            echo"
              maxValue: ".$rowAmount['monthly_budget']."
            },
            vAxis: {
              title: 'Categories'
            },
            width: winWidth,
            height: 400
          };

      chart.draw(data, options);
    }
    </script>
</body>

</html>";