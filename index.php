<?php
session_start();
if (!isset($_SESSION['id']))
    header('location:login.php');
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="index.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->

<script type="text/javascript">
function process(id,name)
{
        var msg = "Confirma excluir o evento " + name + "?";

        var r=confirm(msg);
        if (r)
	{
		window.location.href = "ac_events.php?delete=" + id
	}
}
function process_out(id,name)
{
        var msg = "Confirma sair do evento " + name + "?";

        var r=confirm(msg);
        if (r)
	{
		window.location.href = "ac_request.php?action=out&event_id=" + id
	}
}
</script>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css' />

<div class="footer" style="text-align: center">
	<a href="f_events.php" class="Cbtn Cbtn-danger">Criar evento</a>
	<a href="ac_logoff.php" class="Cbtn Cbtn-danger">Sair</a>
</div>


<div class="container-fluid">
	<div class="row">

<?php
require_once('config.php');

$conn = new mysqli($db_host, $db_name, $db_pass, $db_name);
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
} 

$now = date('Y-m-d',strtotime("-1 days"));
$sql = "SELECT *,DATE_FORMAT(date,'%d/%m/%Y') AS date_formated FROM events where date >= $now order by date";
$result = $conn->query($sql);


if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
            echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">';
            echo '    <div class="tile">';
            echo '        <div class="wrapper">';
            echo '            <div class="header">' . $row['name'] . '<br>' . $row['city'] . '</div>';
	    echo '            <div class="banner-img">';
	    echo '                <a href="details.php?owner_id=' . $row['band_id'] . '&event_id=' . $row['id'] . '"><img src="' . $img_events_dir . '/' . $row['band_id'] . '_' . $row['date'] . '.jpg"></a>';
            echo '            </div>';
            echo '            <div class="dates">';
            echo '                <div class="start">';
            echo '                    <strong>Data</strong> ' . $row['date_formated'];
            echo '                    <span></span>';
            echo '                </div>';
            echo '                <div class="ends">';
            echo '                    <strong>Hor&aacute;rio</strong> ' . $row['start'];
            echo '                </div>';
            echo '            </div>';

	    $event_id = $row['id'];
	    $sqlm = "SELECT * FROM members where event_id = $event_id and state = 'confirmed'";
	    $resultm = $conn->query($sqlm);
  	    if ($resultm->num_rows > 0)
	    {
	        while($rowm = $resultm->fetch_assoc())
		{

	    		$sqlf = 'SELECT id,name from bands where id = ' . $rowm['band_id'];
			$resultf = $conn->query($sqlf);
			$f = $resultf->fetch_assoc();

		    	echo '            <div class="stats">';
		    	echo '                <div>';
		    	echo '                    <strong>BANDA</strong> ' . $f['name'];
		    	echo '                </div>';
		    	echo '                <div>';
		    	echo '                    <strong>STATUS</strong> CONFIRMADO';
		    	echo '                </div>';
		    	echo '                <div>';

			if ($row['band_id'] == $_SESSION['id'])
			{
		    		echo '                    <strong>AÇÕES</strong> <a href="ac_actions.php?event_id=' . $event_id . '&band_id=' . $f['id']  . '&action=rejected">REJEITAR</a>';
			}
			else
			{
		    		echo '                    <strong>&nbsp;</strong>';
			}

		    	echo '                </div>';
			echo '            </div>';

		}
	    }
	    $sqlm = "SELECT * FROM members where event_id = $event_id and state = 'pending'";
	    $resultm = $conn->query($sqlm);
  	    if ($resultm->num_rows > 0)
	    {
	        while($rowm = $resultm->fetch_assoc())
		{

	    		$sqlf = 'SELECT id,name from bands where id = ' . $rowm['band_id'];
			$resultf = $conn->query($sqlf);
			$f = $resultf->fetch_assoc();

		    	echo '            <div class="stats">';
		    	echo '                <div>';
		    	echo '                    <strong>BANDA</strong> ' . $f['name'];
		    	echo '                </div>';
		    	echo '                <div>';
		    	echo '                    <strong>STATUS</strong> AGUARDANDO APROVAÇÃO';
		    	echo '                </div>';
		    	echo '                <div>';

			if ($row['band_id'] == $_SESSION['id'])
			{
		    		echo '                    <strong>AÇÕES</strong> <a href="ac_actions.php?event_id=' . $event_id . '&band_id=' . $f['id'] . '&action=confirmed">APROVAR</a>';
		    		echo '                    <br><a href="ac_actions.php?event_id=' . $event_id . '&band_id=' . $f['id']  . '&action=rejected">REJEITAR</a>';
			}
			else
			{
		    		echo '                    <strong>&nbsp;</strong>';
			}

		    	echo '                </div>';
		    	echo '            </div>';
		}
	    }
	    $sqlm = "SELECT * FROM members where event_id = $event_id and state = 'rejected'";
	    $resultm = $conn->query($sqlm);
  	    if ($resultm->num_rows > 0)
	    {
	        while($rowm = $resultm->fetch_assoc())
		{

	    		$sqlf = 'SELECT id,name from bands where id = ' . $rowm['band_id'];
			$resultf = $conn->query($sqlf);
			$f = $resultf->fetch_assoc();

		    	echo '            <div class="stats">';
		    	echo '                <div>';
		    	echo '                    <strong>BANDA</strong><strike> ' . $f['name'] . '</strike>';
		    	echo '                </div>';
		    	echo '                <div>';
		    	echo '                    <strong>STATUS</strong> FICA PRA PRÓXIMA';
		    	echo '                </div>';
		    	echo '                <div>';

			if ($row['band_id'] == $_SESSION['id'])
			{
		    		echo '                    <strong>AÇÕES</strong> <a href="ac_actions.php?event_id=' . $event_id . '&band_id=' . $f['id'] . '&action=confirmed">APROVAR</a>';
			}
			else
			{
		    		echo '                    <strong>&nbsp;</strong>';
			}

		    	echo '                </div>';
		    	echo '            </div>';
		}
	    }

	    echo '            <div class="footer">';
	    echo '                <a href="details.php?owner_id=' . $row['band_id'] . '&event_id=' . $event_id . '" class="Cbtn Cbtn-primary">Detalhes</a>';

	    $sqlc = "SELECT id FROM members where event_id = $event_id and band_id = " . $_SESSION['id'];
	    $resultc = $conn->query($sqlc);
  	    if ($resultc->num_rows > 0)
	    {
            	//echo '                <a href="ac_request.php?action=out&event_id=' . $event_id . '" class="Cbtn Cbtn-danger">Sair</a>';
            	echo '                <a href="#" class="Cbtn Cbtn-danger" onclick="process_out(\'' . $event_id . '\',\'' . $row['name'] . '\')">Sair</a>';
	    }
	    else
	    {
            	echo '                <a href="ac_request.php?action=pending&event_id=' . $event_id . '" class="Cbtn Cbtn-danger">Participar</a>';
	    }

	    if ($row['band_id'] == $_SESSION['id'])
	    {
	    	echo '            <div class="footer" style="margin-top: 27px">';
            	echo '                <a href="f_events.php?event_id=' . $event_id . '" class="Cbtn Cbtn-primary">Editar</a>';
            	echo '                <a href="#" class="Cbtn Cbtn-danger" onclick="process(\'' . $event_id . '\',\'' . $row['name'] . '\')">Excluir</a>';
	    	echo '		  </div>';
	    }

            echo '            </div>';
            echo '        </div>';
            echo '    </div> ';
            echo '</div>';
	}
}
else
{
	echo '<h2><span class="label label-default" >Nenhum evento cadastrado.</span></h2>';
}

$conn->close();

?>

	</div>
</div>



