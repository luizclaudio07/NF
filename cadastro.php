<?php 
	
	include("topo_fixo.php"); //Último iclude, necessariamente
?>
<script type="text/javascript" src="jsMask.js"></script>

<script type="text/javascript">
	
$(document).ready(function($){
	
	
	$("#msgvalidacao").hide();

	$("#txttel").mask("(99) 99999-9999");
	$("#txtcpf").mask("999.999.999-99");
	
	


	$("form").on('submit', function(){
		 
		if($("#txtnome").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Preencha o nome." + $("#txtcpf").val());
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

		if($("#txttel").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Informe um telefone para contato.");
			return false;
		}

		if($("#txtestado").val() == '' || $("#txtestado").val().trim().length != 2){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Informe a sigla do seu estado. Exemplo: ES, caso for o Espírito Santo.");
			return false;
		}

		if($("#txtcidade").val() == ''){
			$("#msgvalidacao").show();
			$("#msgvalidacao").html("Informe a cidade em que mora.");
			return false;
		}

		$("#msgvalidacao").show();
		$("#msgvalidacao").html("Passou da validação.");
		return true;
	});
});
</script>

<?php 
	if( isset($_POST['btnCadastrar']) ){
		//Ao chegar aqui já foi validado pelo jQuery.
		//Verificar se usuário ja existe via ajax/jquery.


		

		date_default_timezone_set('America/Sao_Paulo');
		$dtnascimento = $_POST['txtano'].'-'.$_POST['txtmes'].'-'.$_POST['txtdia'];
		$STANOTEMAUSER = 'A';

		if(isset($_POST['chkNotfEmail'])){
			$STANOTEMAUSER = 'I';
		}

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
					NUMTELUSER,
					CIDUSER,
					ESTUSER, 
					STANOTEMAUSER
				
				) VALUES (
					'".strtoupper($_POST['txtnome'])."',
					'".strtoupper($_POST['txtemail'])."',
					'".$_POST['txtuser']."',
					'".$_POST['txtsenha']."',
					".str_replace(['.','-'], '', $_POST['txtcpf']).",
					'".$dtnascimento."',
					'".date("Y-m-d H:i:s")."',
					1,
					'A',
					".str_replace(['.','-','(',')', ' '], '', $_POST['txttel']).",
					'".strtoupper($_POST['txtcidade'])."',
					'".strtoupper($_POST['txtestado'])."',
					'".$STANOTEMAUSER."'

				);";

				$bd->toConsole('batarinha');
				//$bd->query($exec);
	}

 ?>

<div class="col-md-2"></div>

<div class="col-md-8">

<form method="POST" action="cadastro.php">
	<div class="row"><div id="msgvalidacao" class="alert alert-warning" ></div></div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Nome:</label>
				<input type="text" class="form-control" id="txtnome" name="txtnome" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>E-mail:</label>
				<input type="text" class="form-control" id="txtemail" name="txtemail" />
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Nome de usuário:</label>
				<input type="text" class="form-control" id="txtuser" name="txtuser" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>CPF:</label>
				<input type="text" class="form-control" id="txtcpf" name="txtcpf" />
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Senha:</label>
				<input type="password" class="form-control" id="txtsenha" name="txtsenha" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Confirmar senha:</label>
				<input type="password" class="form-control" id="txtsenha2" name="txtsenha2" />
			</div>
		</div>
	</div>
	

	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label>Data de nascimento:</label>
				<div class="row">
					<div class="col-md-2" style="padding-right:2px;">
						<select name="txtdia" id="txtdia" class="form-control">
							<option value=""></option>
							<?php 
								for ($i= 1; $i <= 31 ; $i++) { echo "<option value=\"".$i."\">".$i."</option>";}
							 ?>
						</select>
					</div>
					<div class="col-md-6" style="padding-right:2px;padding-left:2px">
						<select name="txtmes" id="txtmes" class="form-control">
							<option value=""></option>
							<?php 

								$mes = ['Janeiro', 'Fevereiro', 'Março', 'Abril',
										'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 
										'Outubro', 'Novembro', 'Dezembro'];

								for ($i= 0; $i < count($mes) ; $i++) { echo "<option value=\"".($i + 1)."\">".$mes[$i]."</option>";}
							 ?>
						</select>
					</div>
					<div class="col-md-4" style="padding-left:2px;">
						<select name="txtano" id="txtano" class="form-control">
							<option value=""></option>
							<?php 
								for ($i= date('Y'); $i > 1900 ; $i--) { echo "<option value=\"".$i."\">".$i."</option>";}
							 ?>
						</select>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Telefone:</label>
				<input type="text" class="form-control" id="txttel" name="txttel" data-mask="(00) 0000-0000" data-mask-selectonfocus="true" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Estado (sigla):</label>
				<input type="text" class="form-control" id="txtestado" name="txtestado" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Cidade:</label>
				<input type="text" class="form-control" id="txtcidade" name="txtcidade" />
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="checkbox">
			<label><input type="checkbox" value="" name="chkNotfEmail">Não quero receber notificações pelo e-mail sobre novidades neste sistema.</label>
		</div>
		<input type="submit" class="btn btn-primary" value="Cadastrar" name="btnCadastrar" />
	</div>
</form>

</div>

<div class="col-md-2"></div>




<?php include("fim_fixo.php"); ?>