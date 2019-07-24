<?php
session_start();
if (!isset($_SESSION['id']))
	    header('location:login.php');

//if (!$_POST['name'] || !$_POST['date'] || !$_POST['start'] || !$_POST['city'] || !$_POST['address'] || !$_POST['state'] || !$_POST['ticket'])
//{
//	exit(1);
//}

require_once('config.php');

$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
if ($mysqli->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
} 

if(!empty($_GET['delete']))
{
	$event_id = $_GET['delete'];

	$stmt = $mysqli->prepare("SELECT band_id FROM events where id = ?");
	$stmt->bind_param('i', $event_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	if ($row['band_id'] == $_SESSION['id'])
	{	
		$stmt = $mysqli->prepare("DELETE FROM messages where event_id = ?");
		$stmt->bind_param('i', $event_id);
		$stmt->execute();

		$stmt = $mysqli->prepare("DELETE FROM members where event_id = ?");
		$stmt->bind_param('i', $event_id);
		$stmt->execute();

		$stmt = $mysqli->prepare("DELETE from events where id = ?");
		$stmt->bind_param('i', $event_id);
		$stmt->execute();

		$img = $img_events_dir . '/' . $event_id . '.jpg';
		unlink($img);
	}
}
else
{
	$band_id = $_SESSION['id'];
	$name = $_POST['name'];
	$date = $_POST['date'];
	$start = $_POST['start'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$state = $_POST['state'];
	$ticket = $_POST['ticket'];
	$obs = $_POST['obs'];

	if(!empty($_POST['event_id']))
	{
		$event_id = $_POST['event_id'];

		$stmt = $mysqli->prepare("SELECT band_id FROM events where id = ?");
		$stmt->bind_param('i', $event_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($row['band_id'] == $_SESSION['id'])
		{
			$stmt = $mysqli->prepare("UPDATE events set band_id = ?,name = ?,date = ?,start = ?,city = ?,address = ?,state = ?,ticket = ?, obs = ? where id = ?");
			$stmt->bind_param('issssssdsi', $band_id,$name,$date,$start,$city,$address,$state,$ticket,$obs,$event_id);
			$stmt->execute();
		}
	}
	else
	{
		$stmt = $mysqli->prepare("INSERT INTO events (band_id,name,date,start,city,address,state,ticket,obs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('issssssds', $band_id,$name,$date,$start,$city,$address,$state,$ticket,$obs);
		$stmt->execute();
		$event_id = $mysqli->insert_id;
	}

	if(!empty($_FILES['flyer']))
	{

		$tmp = $_FILES['flyer']['tmp_name'];
		$dst = $img_events_dir . '/' . $event_id . '.jpg';
		move_uploaded_file($tmp,$dst);
	}
}

$stmt->close();
$mysqli->close();

header('location:index.php');

?>

