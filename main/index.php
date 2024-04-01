<?php
    session_start();
    include 'partials/_dbconnect.php';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        header("location: add-expenses.php");
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num == 1){
            $row = mysqli_fetch_assoc($result);
            if($password == $row['password']){
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("location: dashboard.php");
            }else{
                echo '
                <script>
                    alert("Invalid Credentials");
                </script>
                ';
            }
        }else{
            echo '
            <script>
                alert("Invalid Credentials");
            </script>
            ';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://kit.fontawesome.com/2f01e0402b.js" crossorigin="anonymous"></script>
    <title>Responsive Menu</title>
</head>
<body>
        <main>
            <section id="form">
                <h2>Login</h2>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <span class="form-details">
                            <label for="email"><i class="fas fa-envelope"></i></label>
                            <input id="email" type="email" placeholder="Email" name="email" required>
                        </span>
                        <span class="form-details">
                            <label for="pwd"><i class="fas fa-lock"></i></label>
                            <input id="pwd" type="password" name="password" placeholder="Enter password" required>
                        </span>
                        <p>Not A Member?<a href="registration.php">Sign Up</a></p>
                    </div>
                    <span class="btn">
                        <button type="submit" id="sbt" class="action">Login</button>
                    </span>

                </form>
            </section>
        </main>
</body>
</html>