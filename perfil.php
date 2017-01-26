<?php 

	function toCPF($val){
		$val = substr($val, 0,3). '.' . substr($val, 3,3) . '.' . substr($val, 6,3) . '-' . substr($val, 9,2);
		return $val;
	}

	function toTelefone($val){
		
		return $val;
	}

 ?>


<style type="text/css">

.panel-heading .btn-clickable{
display: inline-block;
margin-top: -25px;
font-size: 15px;
margin-right: -10px;
padding: 4px 10px;
border-radius: 4px;
}

.detalhes{
	display: none;
	padding: 10px;
}

</style>
<?php 
	include("topo_fixo.php"); //Último iclude, necessariamente
?>

<?php 
	
	if(!isset($_SESSION['CODUSER'])){
		header("Location: entrar.php");
	}
	


 ?>

<div class="col-md-2">
	<div class="list-group">
		<a class="list-group-item active" data-toggle="tab" href="#perfil"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Perfil</a>
		<a class="list-group-item" data-toggle="tab" href="#pedidos"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Pedidos</a>
		<a class="list-group-item" data-toggle="tab" href="#relatorios"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Relatório</a>
		<a class="list-group-item" data-toggle="tab" href="#adm"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> Adminstrativo</a>
	</div>
</div>
<div class="col-md-10">
	<div class="tab-content">
		<div id="perfil" class="tab-pane fade in active">

		<?php 
			$x = "SELECT DISTINCT
					A.NOMUSER,
				    A.CPFUSER,
				   	DATE_FORMAT(A.DATCADUSER, '%d/%m/%Y') AS DATCADUSER,
				    CONCAT(A.NIVPERFIL, ' - ', B.DESPERFIL) AS NIVPERFIL,
				    C.DESCRICAO,
				    DATE_FORMAT(A.DATNASCIMENTO, '%d/%m/%Y') AS DATNASCIMENTO,
				    A.EMAUSER,
				    A.NUMTELUSER,
				    A.CIDUSER,
				    A.ESTUSER
				    
				FROM us01 A
				INNER JOIN US02 B ON A.NIVPERFIL = B.CODNIVPERFIL
				INNER JOIN US03 C ON C.STATUS = A.STAUSER
				WHERE A.CODUSER = '".$_SESSION['CODUSER']."'";

			$x = $bd->query($x);

		 ?>

		<div class="row">
			<div class="col-md-8">
					<div class="form-group">
						<label>Nome:</label>
						<input type="text" class="form-control" <?php echo "value=\"".utf8_encode($x[0]['NOMUSER'])."\"";  ?> disabled="true">
					</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
						<label>CPF:</label>
						<input type="text" class="form-control" <?php echo "value=\"".toCPF($x[0]['CPFUSER'])."\"";  ?> disabled="true">
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
					<div class="form-group">
						<label>Endereço:</label>
						<input type="text" class="form-control" <?php echo "value=\"".utf8_encode($x[0]['CIDUSER']). ' - ' .$x[0]['ESTUSER'] ."\"";  ?> disabled="true">
					</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
						<label>E-mail:</label>
						<input type="text" class="form-control" <?php echo "value=\"".$x[0]['EMAUSER']."\"";  ?> disabled="true">
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
						<label>Membro desde:</label>
						<input type="text" class="form-control" <?php echo "value=\"".$x[0]['DATCADUSER']."\"";  ?> disabled="true">
					</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
						<label>Nascimento:</label>
						<input type="text" class="form-control" <?php echo "value=\"".$x[0]['DATNASCIMENTO']."\"";  ?> disabled="true">
					</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
						<label>Perfil:</label>
						<input type="text" class="form-control" <?php echo "value=\"".$x[0]['NIVPERFIL']."\"";  ?> disabled="true">
					</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
						<label>Status:</label>
						<input type="text" class="form-control" <?php echo "value=\"".utf8_encode($x[0]['DESCRICAO'])."\"";  ?> disabled="true">
					</div>
			</div>
		</div>
		</div> <!-- Perfil -->
		<div id="pedidos" class="tab-pane fade">
			<!-- Montado dinamicamente pelos php com os dados dos pedidos -->

				<?php 
					$a = "SELECT 
							A.CODPEDIDO AS 'PEDIDO',
							A.DATCADASTRO AS 'DATA',
							SUM(C.VLRPRODUTO) AS 'VALOR',
							CASE A.STAPEDIDO
								WHEN 'PN' THEN 'PENDENTE'
								WHEN 'AP' THEN 'AGUARDANDO PAGAMENTO'
								WHEN 'PG' THEN 'FINALIZADO'
								WHEN 'CA' THEN 'CANCELADO'
								ELSE 'INCONSISTENTE'
							END AS 'STATUS'

							FROM pedido_sintetico A 
							INNER JOIN pedido_analitico B ON A.CODPEDIDO = B.CODPEDIDO
							INNER JOIN produto C ON B.CODPRODUTO = C.CODPRODUTO
							WHERE A.CODUSER = '".$_SESSION['CODUSER']."'
							GROUP BY A.CODPEDIDO";
					$a = $bd->query($a);

					if(count($a) == 0){
						echo "<div class=\"alert alert-info\"><span class=\"glyphicon glyphicon-flag\" aria-hidden=\"true\"></span><strong> Você ainda não tem nenhum pedido cadastrado</strong></div>";
					}

					for($i = 0; $i < count($a); $i++){
						$b = "SELECT DISTINCT
								A.CODPRODUTO AS 'CODIGO',
								C.NOMPRODUTO AS 'NOME',
								C.VLRPRODUTO AS 'VALOR',
								D.NOMEMPRESA AS 'FORNECEDOR'

							FROM pedido_analitico A 
							INNER JOIN pedido_sintetico B ON A.CODPEDIDO = B.CODPEDIDO
							INNER JOIN produto C ON A.CODPRODUTO = C.CODPRODUTO
							INNER JOIN empresas D ON C.CODEMPRESA = D.CODEMPRESA
							WHERE A.CODPEDIDO = ".$a[$i]['PEDIDO'];

						$b = $bd->query($b);
						$statusPedido = utf8_encode($a[$i]['STATUS']);
						$corcomponente = '';

						if ($statusPedido == 'CANCELADO'){
							$corcomponente = 'danger';

						} else if($statusPedido == 'PENDENTE'){
							$corcomponente = 'primary';	

						} else if($statusPedido == 'FINALIZADO'){
							$corcomponente = 'success';	
						}

						echo "<div class=\"row\">" .
						"<div class=\"col-md-12\">" .
						"<div class=\"panel panel-".$corcomponente."\" id=\"componente\">".
						"<div class=\"panel-heading\">".
						"<h3 class=\"panel-title\">Pedido ".$a[$i]['PEDIDO']." modelo - Status: ".utf8_encode($a[$i]['STATUS'])."</h3>".
						"<button class=\"btn btn-".$corcomponente." btn-clickable pull-right\" id=\"btnMais\" style=\"width:30px;height:30px; padding: 0;\"><span class=\"glyphicon glyphicon-chevron-down\" aria-hidden=\"true\"></span></button>".
						"</div>".
						"<div class=\"detalhes\" id=\"detalhes\">".
						"<div class=\"row\">".
						"<div class=\"col-md-6\">".
						"<p>Data de processamento: ".$a[$i]['DATA']."</p>".
						"<p>Data de pagamento: 00/00/0000</p>".
						"<p>Forma de pagamento: INCONSISTENTE</p>".
						"</div>".
						"<div class=\"col-md-6\">".
						"<p>Valor total: R$ ".str_replace('.', ',',$a[$i]['VALOR'])."</p>".
						"<p>Situação: ".utf8_encode($a[$i]['STATUS'])."</p>".
						"</div>".
						"</div>".
							"<table class=\"table table-bordered\">".
							"<thead>".
								"<tr>".
								"<th>Código</th>".
								"<th>Nome</th>".
								"<th>Fornecedor</th>".
								"</tr>".
							"</thead>".
							"<tbody>";

								for($j=0; $j < count($b); $j++) { 
									echo "<tr>".
									"<td>".utf8_encode($b[$j]['CODIGO'])."</td>".
									"<td>".utf8_encode($b[$j]['NOME'])."</td>".
									"<td>".utf8_encode($b[$j]['FORNECEDOR'])."</td>".
									"</tr>";
								}

							echo "</tbody>".
							"</table>".
						"</div>".
						"</div>".
						"</div>".
						"</div>";

					}

				 ?>

		</div>
		<div id="relatorios" class="tab-pane fade">
			Painel para relatórios
		</div>
		<div id="adm" class="tab-pane fade">
			Painel administrativo de empresas
		</div>
	</div>



</div>

<script type="text/javascript">
	$("#detalhes").css("display", "none");

	$(".btn-clickable").click(function(){
		var me = $(this).parents('#componente').find('#detalhes');

		if(me.css('display') == 'none'){
			me.css("display", "block");
			//me.slideDown();
			$(this).find('span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');

		} else {
			me.css("display", "none");
			//me.slideUp();
			$(this).find('span').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		}


	});


	$(".list-group-item").click(function(){
		//console.log($(this).parents('.list-group').find('.active'));
		$(this).parents('.list-group').find('.active').removeClass('active');
		$(this).addClass('active');
	});

</script>


<?php include("fim_fixo.php"); ?>