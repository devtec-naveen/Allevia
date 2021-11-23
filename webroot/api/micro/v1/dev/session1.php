<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
session_start();

if(isset($_REQUEST['submit'])){
$_SESSION['name'] = $_POST['name'];

header('Location:session2.php');
}

?>
<form action="" method="post">
<input type="text" name="name">
<button type="submit" name="submit">Submit</button>
</form>