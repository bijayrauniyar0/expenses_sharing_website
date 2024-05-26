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
    <link rel="stylesheet" href="../css/savings.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
    <title>Savings</title>
    <style>
        #download-btn {
            padding: 10px;
            background-color: #f1356d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    $className = ".savings";
    include 'partials/_aside.php';

    ?>
    <section id="savings" class="savings active">
        <h1 class="savings-heading">
        Savings & Expenses for 
        <?php
        $currentMonth = date("F");
        echo $currentMonth;
        ?>
    </h1>
    <button id="download-btn" onclick="downloadPDF()">Download</button>
        <div class="top-cards-container">
            <?php
            $email = $_SESSION["email"];
            $currentMonthYear = date("Y_m");
            $sql6 = "SELECT * FROM `expenses_${email}_${currentMonthYear}` ";
            $result6 = mysqli_query($conn, $sql6);
            $sql7 = "SELECT * FROM `monthly_budget_${currentMonthYear}` WHERE email = '$_SESSION[email]'";
            $result7 = mysqli_query($conn, $sql7);
            if(mysqli_num_rows($result7)){
                $row7 = mysqli_fetch_assoc($result7);

                echo'
                <div class="top-cards">
                    <div class="details-holder">
                        <h2>Monthly Budget</h2>
                        <span class="budget">
                            <i class="fas fa-rupee-sign"></i>
                            <span class="budget-amount">' . $row7['monthly_budget'] . '</span>
                        </span>
                    </div>
                </div>';
            $totalExpenses = 0;
            while ($row6 = mysqli_fetch_assoc($result6)) {
                $totalExpenses = $totalExpenses + $row6['expense_amount'];
            }
            echo'
            <div class="top-cards">
                <div class="details-holder">
                    <h2>Total Expenses</h2>

                    <span class="budget">
                        <i class="fas fa-rupee-sign"></i>
                        <span class="budget-amount">' . $totalExpenses. '</span>
                    </span>
                </div>
            </div>';
            $savings = $row7['monthly_budget'] - $totalExpenses;
            echo'
            <div class="top-cards">
                <div class="details-holder">
                    <h2>Savings</h2>

                    <span class="budget">
                        <i class="fas fa-rupee-sign"></i>
                        <span class="budget-amount">' .$savings. '</span>
                    </span>
                </div>
            </div>';
            }else{
                echo'<h2>Please add expenses</h2>';
            }
            ?>
        </div>
        <div class="charts-main-container">
            <div class="chart-container">
                <div id="chart_div1"></div>
            </div>
            <div class="chart-container">
                <div id="chart_div"></div>
            </div>
        </div>
    </section>

    <script src="../script/aside.js"></script>
    <?php 
    
        $email = $_SESSION["email"];
        $currentMonthYear = date("Y_m");
        $sql3 = "SELECT * FROM `expenses_${email}_${currentMonthYear}`";
        $result3 = mysqli_query($conn, $sql3);

        echo'
        <script>
        google.charts.load("current", {packages: ["corechart", "line"]});
        google.charts.setOnLoadCallback(drawBackgroundColor);
    
        function drawBackgroundColor() {
            var data = new google.visualization.DataTable();
            data.addColumn("date", "Date");
            data.addColumn("number", "Expenses");
            data.addRows([';
            $previousAmount = 0;
            if(mysqli_num_rows($result3)){

            

            while ($row3 = mysqli_fetch_assoc($result3)) {
                // Assuming $row3['expense_date'] is in 'Y-m-d' format
                $date = date_create_from_format('Y-m-d', $row3['expense_date']);
                $formatted_date = $date->format('Y, n-1, j');
                // 'n-1' is used to convert month to monthIndex
                $previousAmount = $previousAmount + $row3['expense_amount'];
                echo "[new Date(" . $formatted_date . "), " . $previousAmount . "],";
            }
            echo ']);';

            $currentMonth = date("F");
            echo'
            var winWidth 
                window.addEventListener("resize", function(event) {
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
                title: "Expenses For '.$currentMonth.'",
                hAxis: {
                    title: "Date"
                },
                vAxis: {
                    title: "Amount",
                    viewWindow: {
                        min: 0, // minimum value on y-axis
                        max: 10000 // maximum value on y-axis
                    }
                },
                width: winWidth,
                height: 300,
                backgroundColor: "#fff",
                color: "#333" // color of the data labels
            };
    
            var chart = new google.visualization.LineChart(document.getElementById("chart_div1"));
            chart.draw(data,options);
    }
        
    </script>';
}
    
    ?>
    <?php 
    
        $email = $_SESSION["email"];
        $currentMonthYear = date("Y_m");
       
        $sql5 = "SELECT * FROM `monthly_budget_${currentMonthYear}` where email = '$email'";
        $result5 = mysqli_query($conn, $sql5);
        $row5 = mysqli_fetch_assoc($result5);
echo '
<script>
google.charts.load("current", {packages: ["corechart", "line"]});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
    var data = new google.visualization.DataTable();
    data.addColumn("date", "Date");
    data.addColumn("number", "Savings");
    data.addRows([';

$initialSavings = $row5['monthly_budget']; // Initial savings
$savings = $initialSavings;
$sql4 = "SELECT * FROM `expenses_${email}_${currentMonthYear}`";
$result4 = mysqli_query($conn, $sql4);

while ($row4 = mysqli_fetch_assoc($result4)) {
    // Assuming $row3['expense_date'] is in 'Y-m-d' format
    $date = date_create_from_format('Y-m-d', $row4['expense_date']);
    $formatted_date = $date->format('Y, n-1, j');
    
    // Decrease savings by expense amount
    $savings -= $row4['expense_amount'];
    
    echo "[new Date(" . $formatted_date . "), " . $savings . "],";
}
$currentMonth = date("F");

echo '
    ]);
    var winWidth 
        window.addEventListener("resize", function(event) {
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
            title: " Savings for '.$currentMonth.'",
            hAxis: {
                title: "Date"
            },
            vAxis: {
                title: "Savings",
                viewWindow: {
                    min: 0, // minimum value on y-axis
                    max: ' . $initialSavings . ' // maximum value on y-axis
                },
            
            },
            width: winWidth,
            height: 300,
            backgroundColor: "#fff",
            colors: ["red"]
        };

        var chart = new google.visualization.LineChart(document.getElementById("chart_div"));
        chart.draw(data, options);
    }
    </script>';
    ?>
    
    <script>
       function downloadPDF() {
       window.print();
        
}
    </script>
</body>

</html>