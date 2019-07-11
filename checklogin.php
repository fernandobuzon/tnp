<?php
session_start();

$user = $_POST['login'];
$pass = $_POST['pass'];

if (!$user || !$pass)
{
	header("Location: login.php");
}

require_once('config.php');

$conn = new mysqli($db_host, $db_name, $db_pass, $db_name);
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, passwd FROM bands where login='$user'";
$result = $conn->query($sql);

if ($result->num_rows == 0)
{
	header("Location: login.php");
}

$row = $result->fetch_assoc();
$conn->close();

if (password_verify($pass, $row['passwd']))
{
	$_SESSION['id'] = $row['id'];
	header("Location: index.php");
}
else
{
	header("Location: login.php");
}

?>

