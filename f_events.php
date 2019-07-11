<?php
session_start();
if (!isset($_SESSION['id']))
    header('location:login.php');
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="form.js"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<!-- Bootstrap Upload Image -->
<link rel="stylesheet" href="upload.css"/>
<script type="text/javascript" src="upload.js"></script>

<!------ Include the above in your HEAD tag ---------->

<form class="form-horizontal "method="post" action="ac_events.php" enctype="multipart/form-data">

<?php
if(! empty($_GET['event_id']))
{
	require_once('config.php');
	
	$event_id = $_GET['event_id'];

	$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
	$stmt = $mysqli->prepare("SELECT * FROM events where id = ?");
	$stmt->bind_param('i', $event_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	if ($row['band_id'] != $_SESSION['id'])
		header('location:index.php');

	echo '<input type="hidden" name="event_id" value="' . $event_id . '">';
}
?>

<div class="container">    
    <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
	    <div class="panel-title"><?php echo empty($event_id) ? 'Novo evento' : 'Editar'?></div>
            </div>  
            <div class="panel-body" >
		<div id="div_id_name" class="form-group required">
		    <label for="id_name" class="control-label col-md-4 requiredField"> Nome<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_name" name="name" placeholder="Nome do evento" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['name']?>" />
		    </div>
		</div>
		<div id="div_id_date" class="form-group required">
		    <label for="id_date" class="control-label col-md-4 requiredField"> Data<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md textinput textInput form-control" id="date" name="date" placeholder="MM/DD/YYY" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['date']?>" />
		    </div>    
		</div>
		<div id="div_id_start" class="form-group required">
		    <label for="id_start" class="control-label col-md-4 requiredField"> Hor&aacute;rio<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_start" name="start" placeholder="Hor&aacute;rio de in&iacute;cio" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['start']?>" />
		    </div>
		</div>
		<div id="div_id_city" class="form-group required">
		    <label for="id_city" class="control-label col-md-4 requiredField"> Cidade<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_city" name="city" placeholder="Nome da cidade" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['city']?>" />
		    </div>
		</div>
		<div id="div_id_address" class="form-group required">
		    <label for="id_city" class="control-label col-md-4 requiredField"> Endere&ccedil;o<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_address" name="address" placeholder="Local do evento" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['address']?>" />
		    </div>
		</div>
		<div id="div_id_ticket" class="form-group required">
		    <label for="id_ticket" class="control-label col-md-4 requiredField"> Entrada<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_ticket" name="ticket" style="margin-bottom: 10px" type="text" value="<?php echo empty($event_id) ? null : $row['ticket']?>" />
		    </div>
		</div>
		<div id="div_id_obs" class="form-group required">
		    <label for="id_obs" class="control-label col-md-4 requiredField"> Obs.<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<textarea class="textarea-md textinput textInput form-control" id="id_obs" name="obs" placeholder="Observa&ccedil;&otilde;es" style="margin-bottom: 10px" type="text" /><?php echo empty($event_id) ? null : $row['obs']?></textarea>
		    </div>
		</div>
		<div id="div_id_state" class="form-group required">
		    <label for="id_state"  class="control-label col-md-4  requiredField"> Status<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 " style="margin-bottom: 10px">
<?php
if(!empty($row['state']))
{
	if($row['state'] == 'confirmed')
	{
		$statec = ' checked ';
		$statep = null;
	}
	else
	{
		$statec = null;
		$statep = ' checked ';
	}
}
else
{
	$statec = null;
	$statep = null;
}
?>
		        <label class="radio-inline"><input type="radio" <?php echo $statep ?> name="state" id="id_state_1" value="planning"  style="margin-bottom: 10px">Em planejamento</label>
			<label class="radio-inline"><input type="radio" <?php echo $statec ?> name="state" id="id_state_2" value="confirmed"  style="margin-bottom: 10px">Confirmado</label>
		    </div>
		</div>
		<div id="div_id_flyer" class="form-group">
		    <label for="id_flyer" class="control-label col-md-4 requiredField"> Flyer<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<div class="input-group">
			    <span class="input-group-btn">
				<span class="btn btn-default btn-file">
				    Procurar...<input type="file" name="flyer" id="imgInp">
				</span>
			    </span>
			    <input type="text" class="form-control" readonly>
			</div>
			<img id='img-upload'/>
		    </div>
		</div>
		<div class="form-group"> 
		    <div class="aab controls col-md-4 "></div>
		    <div class="controls col-md-8 ">
			<br>
			<a href="index.php" class="btn btn-primary btn btn-info" />Cancelar</a>&nbsp;
			<input type="submit" name="submit" value="Confirmar" class="btn btn-primary btn btn-info" id="submit-id-signup" />
		    </div>
		</div> 
            </div>
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
