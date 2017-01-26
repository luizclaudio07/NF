<?php 

	include("topo_fixo.php"); //Último iclude, necessariamente
?>


<?php 
	
	if(isset($_SESSION['CODUSER'])){
		header("Location: perfil.php");
	}


	if(isset($_POST['btnEntrar'])){

		$error = "";

		if(empty($_POST['txtemail'])){
			$error = "Para entrar informe o e-mail ou nome de usuário.";
		}

		if(empty($_POST['txtemail'])){
			$error = "Para entrar informe a senha.";
		}

		if(empty($erro)){
			

			$result = "SELECT NOMUSER, CODUSER, CPFUSER, STAUSER FROM US01 WHERE CODUSER = '".trim($_POST['txtuser'])."' AND PSWUSER = '".trim($_POST['txtsenha'])."'";

			$result = $bd->query($result);
			
			if($result){

				if($result[0]['STAUSER'] == 'I'){

					$error = "Sua conta ainda não foi ativada. Verifique o seu e-mail ou peça a chave novamente.";
				} else {

					session_start();
					$_SESSION['NOMUSER'] = $result[0]['NOMUSER'];
					$_SESSION['CODUSER'] = $result[0]['CODUSER'];
					$_SESSION['CPFUSER'] = $result[0]['CPFUSER'];
					$_SESSION['STAUSER'] = $result[0]['STAUSER'];

					header("Location:perfil.php");
				}

			} else {
				$error = "Usuário e/ou senha incorretos.";
			}
		}
	} elseif(isset($_POST['btnCadastrar'])){
		header("Location: cadastro.php");
	}

 ?>

<div class="col-md-4">
</div>
<div class="col-md-4">

	<form method="POST" action="entrar.php">
		<div id="msgRetorno"></div>
		<div class="form-group">
			Usuário ou E-mail:
			<input type="text" class="form-control" id="txtuser" name="txtuser" autocomplete="off"  />
		</div>
		<div class="form-group">
			Senha:
			<input type="password" class="form-control" id="txtsenha" name="txtsenha" />
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="btnEntrar" value="Entrar" />
			<input type="submit" class="btn btn-primary" name="btnCadastrar" value="Cadastrar" />
		</div>
		<?php if(!empty($error)){ echo "<br /><div class=\"alert alert-warning\">".$error."</div>"; } ?>
	</form>


</div>
<div class="col-md-4">
<?php include("fim_fixo.php"); ?>