<?php 
    session_start();
    include 'partials/_dbconnect.php';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        header("location: add-expenses.php");
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $last_name = $_POST['last-name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c-password'];
        $date = $_POST['date'];
        $gender = $_POST['gender'];

        $existsql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $existsql);
        $num = mysqli_num_rows($result);
        if($num > 0){
            echo '
            <script>
                alert("Email already exists");
            </script>
            ';
        }else{
            if($password == $c_password){
                $sql = "INSERT INTO users (`name`, `last_name`, `number`, `email`, `password`, `date_of_birth`, `gender`) VALUES ('$name', '$last_name', '$number', '$email', '$password', '$date', '$gender')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo '
                    <script>
                        alert("User added successfully");
                        window.location.href = "index.php";
                    </script>
                    ';
                }else{
                    echo '
                    <script>
                        alert("Error in adding user. Please try again.");
                    </script>';
                }
            }else{
                echo '
                <script>
                    alert("Passwords do not match");
                </script>
                ';
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registration.css">
    <script src="https://kit.fontawesome.com/2f01e0402b.js" crossorigin="anonymous"></script>
    <title>Sign Up</title>
</head>
<body>
        <main>
            <section id="form">
                <h2>Sign Up</h2>
                <form action="registration.php" method="POST">
                    <div class="form-group">
                        <input id="name" type="text" placeholder="First Name" name="name" required>
                        <input id="last-name" type="text" placeholder="Last Name"  name="last-name">
                    </div>
                    <div class="form-group">
                        <input  maxlength="10" id="number" name="number" type="tel" placeholder="Phone Number" required>
                    </div>
                    <div class="form-group">
                        <input id="email" type="email" placeholder="Email"name="email" required>
                    </div>
                    <div class="form-group">
                        <input id="pwd" type="password" placeholder="Enter password" name="password" required>
                        <input id="c-pwd" type="password" placeholder="Confirm password" name="c-password" required>
                    </div>
                    <div class="form-group">
                        <input id="date" type="date" placeholder="Date of Birth" name="date" required>
                        <select name="gender" id="gnd">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input id="terms" type="checkbox" name="terms" required> <h2 class="trm">I agree to the terms and conditions.</h2>
                    </div>
                    <button type="submit" id="sbt" class="action">Submit</button>

                </form>
                <div class="login">
                    <p class="already-login">Already have an account? <a href="index.php">Login</a></p>
                </div>
            </section>
        </main>
</body>
</html>