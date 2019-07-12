<?php
session_start();
if (!isset($_SESSION['id']))
    header('location:login.php');
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="form.js"></script>

<!------ Include the above in your HEAD tag ---------->

<?php
if(! empty($_GET['event_id']))
{
	require_once('config.php');
	
	$event_id = $_GET['event_id'];
	$owner_id = $_GET['owner_id'];

	$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
	$stmt = $mysqli->prepare("SELECT *,DATE_FORMAT(date,'%d/%m/%Y') AS date_formated FROM events where id = ?");
	$stmt->bind_param('i', $event_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$stmt->close();

	$stmt = $mysqli->prepare("SELECT name FROM bands where id = ?");
	$stmt->bind_param('i', $_GET['owner_id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$band_name = $result->fetch_assoc();
	$band_name = $band_name['name'];
	$stmt->close();

	$stmt = $mysqli->prepare("SELECT name FROM bands where id = ?");
	$stmt->bind_param('i', $_SESSION['id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$owner_band_name = $result->fetch_assoc();
	$owner_band_name = $owner_band_name['name'];
	$stmt->close();
}
else
{
	header('location:index.php');
}
?>

<div class="container">    
    <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
	    <div class="panel-title"><?php echo $row['name']?></div>
            </div>  
            <div class="panel-body" >
		<div id="div_id_band" class="form-group required">
		    <label for="id_band" class="control-label col-md-4 requiredField"> Organiza&ccedil;&atilde;o<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
		    <input class="input-md textinput textInput form-control" id="band" name="date" style="margin-bottom: 10px" type="text" value="<?php echo $band_name ?>" readonly />
		    </div>    
		</div>
		<div id="div_id_date" class="form-group required">
		    <label for="id_date" class="control-label col-md-4 requiredField"> Data<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
		    <input class="input-md textinput textInput form-control" id="date" name="date" placeholder="MM/DD/YYY" style="margin-bottom: 10px" type="text" value="<?php echo $row['date_formated'] ?>" readonly />
		    </div>    
		</div>
		<div id="div_id_start" class="form-group required">
		    <label for="id_start" class="control-label col-md-4 requiredField"> Hor&aacute;rio<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_start" name="start" placeholder="Hor&aacute;rio de in&iacute;cio" style="margin-bottom: 10px" type="text" value="<?php echo $row['start'] ?>" readonly />
		    </div>
		</div>
		<div id="div_id_city" class="form-group required">
		    <label for="id_city" class="control-label col-md-4 requiredField"> Cidade<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_city" name="city" placeholder="Nome da cidade" style="margin-bottom: 10px" type="text" value="<?php echo $row['city'] ?>" readonly />
		    </div>
		</div>
		<div id="div_id_address" class="form-group required">
		    <label for="id_city" class="control-label col-md-4 requiredField"> Endere&ccedil;o<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_address" name="address" placeholder="Local do evento" style="margin-bottom: 10px" type="text" value="<?php echo $row['address'] ?>" readonly />
		    </div>
		</div>
		<div id="div_id_ticket" class="form-group required">
		    <label for="id_ticket" class="control-label col-md-4 requiredField"> Entrada<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_ticket" name="ticket" style="margin-bottom: 10px" type="text" value="<?php echo $row['ticket'] ?>" readonly />
		    </div>
		</div>
		<div id="div_id_obs" class="form-group required">
		    <label for="id_obs" class="control-label col-md-4 requiredField"> Informa&ccedil;&otilde;es<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<textarea class="textarea-md textinput textInput form-control" id="id_obs" name="obs" placeholder="Observa&ccedil;&otilde;es" style="margin-bottom: 10px" type="text" readonly /><?php echo $row['obs'] ?></textarea>
		    </div>
		</div>
		<div id="div_id_state" class="form-group required">
		    <label for="id_state"  class="control-label col-md-4  requiredField"> Status<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 " style="margin-bottom: 10px">
		    <label class="control-label col-md-4  requiredField"><?php echo ($row['state'] == 'confirmed' ? 'CONFIRMADO' : 'EM PLANEJAMENTO') ?><span class="asteriskField"></span> </label>
		    </div>
		</div>
		<div class="form-group"> 
		    <div class="aab controls col-md-4 "></div>
		    <div class="controls col-md-8 ">
			<br>
			<a href="index.php" class="btn btn-primary btn btn-info"/>Voltar</a>
		    </div>
		</div> 
            </div>
        </div>
    </div> 
</div>

<form method="post" action="ac_messages.php">

<input type="hidden" name="event_id" value="<?php echo $event_id ?>">
<input type="hidden" name="owner_id" value="<?php echo $owner_id ?>">

	<div class="container">    
	    <div id="signupbox" style=" margin-top:10px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-info">
		    <div class="panel-heading">
		    <div class="panel-title">Mural de coment&aacute;rios</div>
		    </div>  
		    <div class="panel-body" >
			<div id="div_id_message" class="form-group">
			<label for="id_message" class="control-label col-md-4 requiredField"> <?php echo $owner_band_name ?><span class="asteriskField"></span> </label>
			    <div class="controls col-md-8 ">
				<textarea class="textarea-md textinput textInput form-control" id="id_message" name="message" placeholder="Digite sua mensagem" style="margin-bottom: 10px" type="text" /></textarea>
			    </div>
			</div>
			<div class="form-group"> 
			    <div class="aab controls col-md-4 "></div>
			    <div class="controls col-md-8 ">
				<br>
				<input type="submit" class="btn btn-primary btn btn-info" value="Postar"/>
			    </div>
			</div> 
		    </div>

<?php
$stmt = $mysqli->prepare("SELECT messages.*,bands.name FROM messages inner join bands on messages.band_id = bands.id where messages.event_id = ? order by messages.id desc;");
$stmt->bind_param('i', $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo '<div class="panel-body" >';
		echo '	<div class="form-group">';
		echo '	    <label class="control-label col-md-4">' . $row['name'] . '<br><span style="font-weight: normal;">' . $row['date'] . '</span>';
		if($row['band_id'] == $_SESSION['id'])
		{
			echo '<br><a href="ac_messages.php?owner_id=' . $owner_id . '&action=delete&event_id=' . $event_id . '&message_id=' . $row['id'] . '">Excluir</a>';
		}
		echo '      </label>';
		echo '	    <div class="controls col-md-8 ">';
		echo '		<textarea class="textarea-md textinput textInput form-control" id="id_message" name="message2" placeholder="Digite sua mensagem" style="margin-bottom: 10px" type="text" readonly/>' . $row['message'] . '</textarea>';
		echo '	    </div>';
		echo '	</div>';
		echo '</div>';
	}
}

$stmt->close();
$mysqli->close();
?>
		</div>
	    </div> 
	</div>
</form>

<script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>

</div>            
