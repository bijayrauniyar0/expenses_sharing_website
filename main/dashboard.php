<?php 
session_start();
include 'partials/_dbconnect.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://kit.fontawesome.com/2f01e0402b.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <title>Document</title>
</head>
<body>
    <?php 
    $className = '.dashboard';
    include 'partials/_aside.php'; 
    ?>
    <section class="dashboard active">
        <div class="container-flexer">
            <div id="piechart"></div>
            <div class="monthly-budget">
                <form action="">
                    <div class="form-group">
                        <label for="monthly-budget">Monthly Budget</label>
                        <span id="adder">
                            <input type="text" id="monthly-budget" name="monthly-budget" placeholder="Enter your monthly budget">
                            <button type="submit" id="add-budget">Set</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../script/aside.js"></script>
    <?php 
    $sql = "SELECT * FROM `expenses` where email = '$_SESSION[email]'";
    $result = mysqli_query($conn, $sql);
    echo'
    <script type="text/javascript">
        // Load google charts
        google.charts.load("current", {"packages":["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        
       
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
          ["Task", "Hours per Day"], ';
          while($row = mysqli_fetch_assoc($result)){
            echo'
              ["'.$row['expense_category'].'", '.$row['expense_amount'].'],';
            }
        echo'
          
        ]);
        
          // Optional; add a title and set the width and height of the chart
          var options = {"title":"My Monthy Expenses(Rs)", "padding": 0,"width":850, "height":500, "backgroundColor":"transparent" ,"legend":"left", is3D: true};
        
          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(document.getElementById("piechart"));
          chart.draw(data, options);
        }
        </script>';
    ?>
</body>
</html>