<link rel="stylesheet" href="../css/aside.css">
<aside class="aside close">
    <span id="toggler" class="toggler" onclick="asideToggle('<?php echo $className ?>')">
        <i class="fa-solid fa-bars"></i>
    </span>
        <div class="user">
            <i class="fa-solid fa-user"></i>
        </div>
    <?php 
        $sql = "SELECT * FROM users WHERE email='".$_SESSION['email']."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    echo'
        <h2 class="name">'.$row['name'].' '.$row['last_name'].'</h2>';
    ?>

    <div class="side-menu">
        <span class="menu-group">
            <a href="add-expenses.php">
                <i class="fa-solid fa-wallet"></i>
                <h2>Add Expenses </h2>
            </a>
        </span>
        <span class="menu-group">
        <a href="my-expenses.php">
            <i class="fa-solid fa-clock"></i>
            <h2>My Expenses </h2>
        </a>
        </span>
        <span class="menu-group">
            <a href="dashboard.php">
            <i class="fa-solid fa-gauge"></i>
            <h2>Dashboard</h2></a>
        </span>
        <span class="menu-group">
            <a href="">
            <i class="fa-solid fa-piggy-bank"></i>
            <h2>Savings</h2></a>
        </span>
        <span class="menu-group">
            <a href="">
            <i class="fa-solid fa-user-group"></i>
            <h2>Shared Expenses</h2></a>
        </span>
    </div>
</aside>
