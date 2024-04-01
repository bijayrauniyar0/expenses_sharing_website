<?php 
session_start();
include 'partials/_dbconnect.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $currentMonthYear = date('Y_m'); // Format: YYYY_MM
    $sqlCreate = "CREATE TABLE IF NOT EXISTS `monthly_budget_${currentMonthYear}` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        monthly_budget DECIMAL(10, 2) NOT NULL
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
    $sql = "INSERT INTO `monthly_budget_${currentMonthYear}` (`email`, `monthly_budget`) VALUES ('$_SESSION[email]', '$monthly_budget')";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo'<script>
        alert("Addded Successfully");
        </script>';
    }else{
        echo'<script>
        alert("Error");
        </script>';
        
    }
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
        <h1 style="font-size: 2rem; padding: 20px 10px;">Your Dashboard</h1>
        <div class="container-flexer">
            <div id="piechart"></div>
            <div class="monthly-budget">
                <form action="#" method="post">
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
        <div class="container-flexer-2">
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
          let winWidth 
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
          var options = {"title":"My Monthy Expenses(Rs)", "padding": 0,"width":winWidth, "height":500, "backgroundColor":"transparent" ,"legend":"left", is3D: true};
        
          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(document.getElementById("piechart"));
          chart.draw(data, options);
        }
        </script>';
    ?>

</body>
</html>