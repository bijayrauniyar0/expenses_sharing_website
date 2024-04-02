<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
echo"
<script>
alert('You have been logged out');
window.location.href = '../index.php';
</script>
";

exit();
?>
