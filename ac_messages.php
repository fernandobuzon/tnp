<?php
session_start();
if (!isset($_SESSION['id']))
	    header('location:login.php');

//if (!$_POST['name'] || !$_POST['date'] || !$_POST['start'] || !$_POST['city'] || !$_POST['address'] || !$_POST['state'] || !$_POST['ticket'])
//{
//	exit(1);
//}

require_once('config.php');

if (!empty($_GET['action']))
{
	$message_id = $_GET['message_id'];
	$event_id = $_GET['event_id'];

	$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
	if ($mysqli->connect_error)
	{
			die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $mysqli->prepare("SELECT band_id FROM messages where id = ?");
	$stmt->bind_param('i', $message_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	if($row['band_id'] == $_SESSION['id'])
	{
		$stmt = $mysqli->prepare("DELETE FROM messages where id = ?");
		$stmt->bind_param('i', $message_id);
		$stmt->execute();
	}
}
else
{
	$event_id = $_POST['event_id'];
	$band_id = $_SESSION['id'];
	$message = $_POST['message'];
	$date = date('Y-m-d');

	$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
	if ($mysqli->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $mysqli->prepare("insert into messages (band_id,event_id,message,date) values (?,?,?,?)");
	$stmt->bind_param('iiss', $band_id,$event_id,$message,$date);
	$stmt->execute();
}

$stmt->close();
$mysqli->close();

header("location:details.php?event_id=$event_id");

?>
