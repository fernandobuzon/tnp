<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="index.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->

<?php
//session_start();
//if (!isset($_SESSION['id']))
//	    header('location:login.php');

//if (!$_POST['name'] || !$_POST['date'] || !$_POST['start'] || !$_POST['city'] || !$_POST['address'] || !$_POST['state'] || !$_POST['ticket'])
//{
//	exit(1);
//}

if($_POST['passwd'] != $_POST['passwd2'])
{
	echo '<div class="container">';
	echo '    <div class="row justify-content-center align-items-center" style="height:100vh">';
	echo '        <div class="col-4">';
	echo '            <div class="card">';
	echo '                <div class="card-body">';
	echo '                    <div class="form-group">';
	echo '                        <label class="form-control">As senhas n&atilde;o conferem</label>';
	echo '                    </div>';
	echo '		          <a href="f_bands.php" class="btn btn-primary">VOLTAR</a>';
	echo '                </div>';
	echo '            </div>';
	echo '        </div>';
	echo '    </div>';
	echo '</div>';
}
else
{
	$name = $_POST['name'];
	$login = $_POST['login'];
	$passwd = $_POST['passwd'];
	$city = $_POST['city'];
	$contact = $_POST['contact'];
	$email = $_POST['email'];
	$cel = $_POST['cel'];
	$obs = $_POST['obs'];

	if(empty($_POST['name']) || empty($_POST['login']) || empty($_POST['passwd']))
	{
		echo '<div class="container">';
		echo '    <div class="row justify-content-center align-items-center" style="height:100vh">';
		echo '        <div class="col-4">';
		echo '            <div class="card">';
		echo '                <div class="card-body">';
		echo '                    <div class="form-group">';
		echo '                        <label class="form-control">Dados incompletos</label>';
		echo '                    </div>';
		echo '		          <a href="f_bands.php" class="btn btn-primary">VOLTAR</a>';
		echo '                </div>';
		echo '            </div>';
		echo '        </div>';
		echo '    </div>';
		echo '</div>';
	}
	else
	{
		require_once('config.php');

		$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
		if ($mysqli->connect_error)
		{
			die("Connection failed: " . $conn->connect_error);
		} 

		$stmt = $mysqli->prepare("SELECT id FROM bands where login = ? or name = ?");
		$stmt->bind_param('ss', $login,$name);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($result->num_rows > 0)
		{
			echo '<div class="container">';
			echo '    <div class="row justify-content-center align-items-center" style="height:100vh">';
			echo '        <div class="col-4">';
			echo '            <div class="card">';
			echo '                <div class="card-body">';
			echo '                    <div class="form-group">';
			echo '                        <label class="form-control">Banda j&aacute; cadastrada!</label>';
			echo '                    </div>';
			echo '		          <a href="f_bands.php" class="btn btn-primary">VOLTAR</a>';
			echo '                </div>';
			echo '            </div>';
			echo '        </div>';
			echo '    </div>';
			echo '</div>';
		}
		else
		{
			$passwd = password_hash($passwd, PASSWORD_BCRYPT);

			$stmt = $mysqli->prepare("INSERT into bands (login,passwd,name,contact,city,email,cel,obs) values (?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param('ssssssss', $login,$passwd,$name,$contact,$city,$email,$cel,$obs);
			$stmt->execute();

			echo '<div class="container">';
			echo '    <div class="row justify-content-center align-items-center" style="height:100vh">';
			echo '        <div class="col-4">';
			echo '            <div class="card">';
			echo '                <div class="card-body">';
			echo '                    <div class="form-group">';
			echo '                        <label class="form-control">Banda cadastrada com sucesso!</label>';
			echo '                    </div>';
			echo '		          <a href="index.php" class="btn btn-primary">VOLTAR</a>';
			echo '                </div>';
			echo '            </div>';
			echo '        </div>';
			echo '    </div>';
			echo '</div>';
		}
		$stmt->close();
		$mysqli->close();
	}
}


?>


