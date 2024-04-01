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
    <title>Add Expenses</title>
</head>

<body>
    <?php
    $className = ".savings";
    include 'partials/_aside.php';

    ?>
    <section id="savings" class="savings active">
        <h1 style="padding: 20px 30px; font-size: 2rem;">My Savings</h1>
        <div class="top-cards-container">
            <div class="top-cards">
                <div class="details-holder">
                    <h2>Monthly Budget</h2>
                    <span class="budget">
                        Rs 10000
                    </span>
                </div>
            </div>
            <div class="top-cards">
                <div class="details-holder">
                    <h2>Monthly Budget</h2>
                    <span class="budget">
                        Rs 10000
                    </span>
                </div>
            </div>
            <div class="top-cards">
                <div class="details-holder">
                    <h2>Monthly Budget</h2>
                    <span class="budget">
                        Rs 10000
                    </span>
                </div>
            </div>
        </div>
        <div class="charts-main-container">
            <div class="chart-container">
                <div id="chart_div"></div>
            </div>
            <div class="chart-container">
                <div id="chart_div1"></div>
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
            data.addColumn("number", "Expenses Till Date");
            data.addRows([';
            $previousAmount = 0;

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
                backgroundColor: "#f1f8e9",
                dataLabels: {
                    textStyle: {
                        color: "#333" // color of the data labels
                    },
                    alignment: "right", // position of the data labels
                    display: "inside", // display the data labels inside the bars
                    format: "currency" // format of the data labels (you can customize as needed)
                }
            };
    
            var chart = new google.visualization.LineChart(document.getElementById("chart_div1"));
            chart.draw(data, Object.assign(options, { height: 400, width: 600 }));
    }
        
    </script>';
    
    ?>
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
            data.addColumn("number", "Expenses Till Date");
            data.addRows([';
            $previousAmount = 0;

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
                backgroundColor: "#f1f8e9",
                dataLabels: {
                    textStyle: {
                        color: "#333" // color of the data labels
                    },
                    alignment: "right", // position of the data labels
                    display: "inside", // display the data labels inside the bars
                    format: "currency" // format of the data labels (you can customize as needed)
                }
            };
    
            var chart = new google.visualization.LineChart(document.getElementById("chart_div"));
            chart.draw(data, Object.assign(options, { height: 400, width: 600 }));
    }
        
    </script>';
    
    ?>
</body>

</html>