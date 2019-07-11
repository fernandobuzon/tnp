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
$band_id = $_GET['band_id'];
$logged_band_id = $_SESSION['id'];

$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
if ($mysqli->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

$stmt = $mysqli->prepare("SELECT band_id FROM events where id = ?");
$stmt->bind_param('i', $event_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['band_id'] == $logged_band_id)
{
	$stmt = $mysqli->prepare("update members set state = ? where event_id = ? and band_id = ?");
	$stmt->bind_param('sii', $action,$event_id,$band_id);
	$stmt->execute();
}

$stmt->close();
$mysqli->close();

header('location:index.php');

?>


