<?php
//session_start();
//if (!isset($_SESSION['id']))
//    header('location:login.php');
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="form.js"></script>
<!------ Include the above in your HEAD tag ---------->

<form class="form-horizontal "method="post" action="ac_bands.php" enctype="multipart/form-data">

<?php
if(! empty($_GET['band_id']))
{
	if ($_GET['band_id'] != $_SESSION['id'])
		header('location:index.php');

	require_once('config.php');
	$band_id = $_GET['band_id'];

	$mysqli = new mysqli($db_host, $db_name, $db_pass, $db_name);
	$stmt = $mysqli->prepare("SELECT * FROM bands where id = ?");
	$stmt->bind_param('i', $band_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	echo '<input type="hidden" name="band_id" value="' . $band_id . '">';
}
?>

<div class="container">    
    <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
	    <div class="panel-title"><?php echo empty($band_id) ? 'Cadastro' : 'Editar'?></div>
            </div>  
            <div class="panel-body" >
		<div id="div_id_name" class="form-group required">
		    <label for="id_name" class="control-label col-md-4 requiredField"> Nome<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_name" name="name" placeholder="Nome da banda" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['name']?>" />
		    </div>
		</div>
		<div id="div_id_login" class="form-group required">
		    <label for="id_login" class="control-label col-md-4 requiredField"> Login<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md textinput textInput form-control" id="login" name="login" placeholder="Login" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['login']?>" />
		    </div>    
		</div>
		<div id="div_id_contact" class="form-group required">
		    <label for="id_contact" class="control-label col-md-4 requiredField"> Contato<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_contact" name="contact" placeholder="Contato" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['contact']?>" />
		    </div>
		</div>
		<div id="div_id_city" class="form-group required">
		    <label for="id_city" class="control-label col-md-4 requiredField"> Cidade<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_city" name="city" placeholder="Nome da cidade" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['city']?>" />
		    </div>
		</div>
		<div id="div_id_email" class="form-group required">
		    <label for="id_email" class="control-label col-md-4 requiredField"> E-mail<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_email" name="email" placeholder="E-mail" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['email']?>" />
		    </div>
		</div>
		<div id="div_id_cel" class="form-group required">
		    <label for="id_cel" class="control-label col-md-4 requiredField"> Celular<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input class="input-md  textinput textInput form-control" id="id_cel" name="cel" placeholder="Celular/WhatsApp" style="margin-bottom: 10px" type="text" value="<?php echo empty($band_id) ? null : $row['cel']?>" />
		    </div>
		</div>
		<div id="div_id_obs" class="form-group required">
		    <label for="id_obs" class="control-label col-md-4 requiredField"> Obs.<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<textarea class="textarea-md textinput textInput form-control" id="id_obs" name="obs" placeholder="Observa&ccedil;&otilde;es" style="margin-bottom: 10px" type="text" /><?php echo empty($event_id) ? null : $row['obs']?></textarea>
		    </div>
		</div>
		<div id="div_id_passwd" class="form-group required">
		    <label for="id_passwd" class="control-label col-md-4 requiredField"> Senha<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input type="password" class="input-md  textinput textInput form-control" id="id_passwd" name="passwd" placeholder="Digite uma senha" style="margin-bottom: 10px" type="text" />
		    </div>
		</div>
		<div id="div_id_passwd2" class="form-group required">
		    <label for="id_passwd2" class="control-label col-md-4 requiredField"> Confirma&ccedil;&atilde;o<span class="asteriskField"></span> </label>
		    <div class="controls col-md-8 ">
			<input type="password" class="input-md  textinput textInput form-control" id="id_passwd2" name="passwd2" placeholder="Confirme a senha" style="margin-bottom: 10px" type="text" />
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

</div>            
