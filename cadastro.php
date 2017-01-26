<?php 
	
	include("topo_fixo.php"); //Último iclude, necessariamente
?>

<script type="text/javascript">
	
$(document).ready(function(){
	$("#msgvalidacao").hide();


	$("form").on('submit', function(){
		 
		if($("#txtnome").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha o nome.");
			return false;
		}


		if($("#txtemail").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha o e-mail.");
			return false;
		}

		if($("#txtuser").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha o nome de usuário.");
			return false;
		}

		if($("#txtsenha").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha a senha.");
			return false;
		}

		if($("#txtsenha2").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha a confirmação de senha.");
			return false;
		}

		if($("#txtsenha").val() != $("#txtsenha2").val()){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("As senhas não conferem.");
			return false;

		} else if($("#txtsenha").val().length < 6 || $("#txtsenha").val().length > 12) {
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("As senhas deve ter entre 6 e 12 dígitos.");
			return false;

		}

		if($("#txtcpf").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha o CPF.");
			return false;
		}

		if($("#txtdia").val() == '' || $("#txtmes").val()  == '' || $("#txtano").val() == '' ){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha a data de nascimento corretamente.");
			return false;
		}


		$("#msgvalidacao").show();
		$("#msgvalidacao").html("Passou da validação.");
		return true;
	});
});
</script>

<?php 
	if(  isset($_POST['btnCadastrar']) ){
		//Ao chegar aqui já foi validado pelo jQuery.
		//Verificar se usuário ja existe via ajax/jquery.


		include("PDO.class.php");
		$bd = new SQL;

		date_default_timezone_set('America/Sao_Paulo');
		$dtnascimento = $_POST['txtano'].'-'.$_POST['txtmes'].'-'.$_POST['txtdia'];

		$exec = "INSERT INTO US01 (
					NOMUSER,
					EMAUSER,
					CODUSER,
					PSWUSER,
					CPFUSER,
					DATNASCIMENTO,
					DATCADUSER,
					NIVPERFIL,
					STAUSER,
					NUMTELUSER
				
				) VALUES (
					'".$_POST['txtnome']."',
					'".$_POST['txtemail']."',
					'".$_POST['txtuser']."',
					'".$_POST['txtsenha']."',
					".$_POST['txtcpf'].",
					'".$dtnascimento."',
					'".date("Y-m-d H:i:s")."',
					1,
					'A',
					123456

				);";

			
		$bd->query($exec);

		

		
	}

 ?>



<form class="col-md-6" method="POST" action="cadastro.php">
	<div id="msgvalidacao" class="alert alert-warning" ></div>

	<div class="form-group">
		Nome:
		<input type="text" class="form-control" id="txtnome" name="txtnome" />
	</div>
	<div class="form-group">
		E-mail:
		<input type="text" class="form-control" id="txtemail" name="txtemail" />
	</div>
	<div class="form-group">
		Nome de usuário:
		<input type="text" class="form-control" id="txtuser"  name="txtuser" />
	</div>
	<div class="form-group">
		Senha:
		<input type="password" class="form-control" id="txtsenha" name="txtsenha" />
	</div>
	<div class="form-group">
		Confirmar senha::
		<input type="password" class="form-control" id="txtsenha2" />
	</div>
	<div class="form-group">
		CPF:
		<input type="text" class="form-control" id="txtcpf" name="txtcpf" />
	</div>
	<div class="form-group row">
		Data de nascimento:&nbsp;
		<select class="form-control col-md-2" id="txtdia"  name="txtdia">
		<option value=""></option>
		<?php 
			for ($i=1; $i <= 31; $i++) { 
				echo "<option value=\"".$i."\">".$i."</option>";
			}

		 ?>
			
		</select>&nbsp;
		<select class="form-control col-md-4" id="txtmes" name="txtmes">
		<option value=""></option>
			<?php 
				$mes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio',
						'Junho', 'Julho', 'Agosto','Setembro', 'Outubro', 
						'Novembro', 'Dezembro'];

				for ($i=0; $i < count($mes); $i++) { 
					echo "<option value=\"".($i+1)."\">".$mes[$i]."</option>";
				}
			 ?>
		</select>&nbsp;
		<select class="form-control col-md-2" id="txtano" name="txtano">
		<option value=""></option>
			<?php 
				for ($i=2017; $i >= 1900; $i--) { 
					echo "<option value=\"".$i."\">".$i."</option>";
				}
			 ?>
		</select>
	</div>

	<div class="form-group">
	<input type="submit" class="btn btn-primary" value="Cadastrar" name="btnCadastrar" />
	</div>


</form>




<?php include("fim_fixo.php"); ?>