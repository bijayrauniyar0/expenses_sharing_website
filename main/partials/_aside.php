<link rel="stylesheet" href="../css/aside.css">
<aside class="aside close">
    <span id="toggler" class="toggler">
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
            <i class="fa-solid fa-wallet"></i>
            <h2><a href="add-expenses.php">Add Expenses </a></h2>
        </span>
        <span class="menu-group">
            <i class="fa-solid fa-clock"></i>
            <h2><a href="my-expenses.php">My Expenses </a></h2>
        </span>
        <span class="menu-group">
            <i class="fa-solid fa-gauge"></i>
            <h2><a href="">Dashboard </a></h2>
        </span>
        <span class="menu-group">
            <i class="fa-solid fa-piggy-bank"></i>
            <h2><a href="">Savings </a></h2>
        </span>
        <span class="menu-group">
            <i class="fa-solid fa-user-group"></i>
            <h2><a href="">Shared Expenses </a></h2>
        </span>
    </div>
</aside>
