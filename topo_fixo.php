<?php 
	session_start();
	ini_set('default_charset','UTF-8');
	include('PDO.class.php');
	$bd = new SQL;

	if(!empty($_SESSION['NOMUSER'])){
		$nome_do_usuario = explode(' ', $_SESSION['NOMUSER']);
	}

	if(isset($_GET['c']) && $_GET['c'] == 'sair'){
		session_destroy();
		header("Location: entrar.php");
	}
		
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>NF Corp</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="estilo.css">

<script type="text/javascript">
	$(document).ready(function(){
	
	$("#retratil").click(function(){

		var $this = $(this);
	    if(!$this.hasClass('panel-collapsed')) {
	    	console.log('Entrei no if');
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		} else {

			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		}
	});

	});
		    
</script>

</head>
<body>
	<div class="page-header" style="margin-bottom: 0; padding-bottom: 0; border-bottom: 0;">
    <h1>Teste</h1>      
  </div>
	<div id="total" class="container">
		<p><?php if(!empty($nome_do_usuario[0])){ echo "Olá, " . $nome_do_usuario[0] . ".&nbsp;&nbsp;<span onclick=\"window.location ='fimsessao.php';\" class=\"badge\">Sair</span>";} ?>&nbsp;</p>
		<div class="btn-group btn-group-justified">
			<a href="index.php" class="btn btn-primary">Inicio</a>
			<a href="#" class="btn btn-primary">Novidades</a>
			<a href="#" class="btn btn-primary">Pesquisa</a>
			<?php 
				if(!isset($nome_do_usuario)){
				 	echo "<a href=\"entrar.php\" class=\"btn btn-primary\">Entrar</a>";
				} else {
					echo "<a href=\"perfil.php\" class=\"btn btn-primary\">Painel</a>";
				}
			?>
			<a href="" class="btn btn-success">Anuncie!</a>
		</div>
		<br />
	
	
	
