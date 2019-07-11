<?php
session_start();
if (!isset($_SESSION['id']))
	    header('location:login.php');

//if (!$_POST['name'] || !$_POST['date'] || !$_POST['start'] || !$_POST['city'] || !$_POST['address'] || !$_POST['state'] || !$_POST['ticket'])
//{
//	exit(1);
//}

require_once('config.php');

$event_id = $_GET['event_id'];
$action = $_GET['action'];
$band_id = $_SESSION['id'];

$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
if ($mysqli->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

$stmt = $mysqli->prepare("delete from members where event_id = ? and band_id = ?");
$stmt->bind_param('ii', $event_id,$band_id);
$stmt->execute();

if ($action == 'pending')
{
	$stmt = $mysqli->prepare("insert into members (band_id,event_id,state) values (?, ?, ?)");
	$stmt->bind_param('iis', $band_id,$event_id,$action);
	$stmt->execute();
}

$stmt->close();
$mysqli->close();

header('location:index.php');

?>


