<?php 

if(isset($_POST['val'])){
	$valores = $_POST['val'];
	$variavel = $_POST['variavel'];
	$n = $_POST['n'];
	//colocar os valores em ordem crescente
	sort($valores);

	$tabela = [];
	//agrupa cada valor com sua respectiva quantidade que se repete
	$lista = array_count_values($valores);
	$freqacu = 0;
	$media = 0;
	$soma = 0;
	$mediana = 0;
	//encontra o valor que mais repete
	$valor_repete = max($lista);
	$moda = [];
	foreach($lista as $valor => $vezes) {
		//echo "$numero - $vezes<br />";
		//calcula a frequencia relativa e arredonda o valor para duas casas decimais
		$freqrela = round($vezes * 100 / $n, 2);
		//acumulador da frequencia acumulada de cada valor
		$freqacu += $vezes;
		//adiciona ao vetor tabela a frequencia absoluta, frequencia relatica frequencia acumulada de cada valor
		array_push($tabela, array("n" => $valor, "freqabs" => $vezes, "freqrela" => $freqrela, "freqacu" => $freqacu));
		//acumulador de soma ponderada de cada valor
		$soma += $vezes * $valor;

		//calculo da mediana
		if($n % 2 == 0){
			//calculo caso n for par
			$grupo = $n/2;
			$somaVal = $valores[$grupo-1] + $valores[$grupo];;
			$mediana = $somaVal/2;			

		}else{
			//calculo caso n for impar
			$aux = $n - 1;
			$grupo = $aux/2;
			$mediana = $valores[$grupo];	

		}

		//adiciona ao vetor moda os valores que mais se repetem
		if($valor_repete > 1){
			if($vezes == $valor_repete){
				array_push($moda, $valor);
			}			
		}



		
	}
	//calcula a media ponderada dos valores
	$media = round($soma / $n, 2);


}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Calculo Estatistico</title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
	<?php include('view/tema/topo.php'); ?>

	<form method="post">
		<div style="margin: 90px 20px 15px;" class="row">

			<div class="col-12">
				<div class="row" style="margin-bottom: 20px">
					<div class="col-6">

						<input type="text" class="form-control" placeholder="Digite a variavel" name="variavel" id="variavel" required>
					</div>
					<div class="col" style="margin-top: 1px">				
						<button type="button" class="btn btn-secondary" id="novo_fator"><i class="fas fa-plus"></i></button>
					</div>
					<div class="col-5" style="float: left;">				
						N: <label id='n_label'>1</label>
						<input type="hidden" id="n" name="n" value="1">

					</div>				
				</div>

				<div id="fatores" class="row">  
					<div class="form-row col-4" style="margin-bottom: 10px">
						<div class="col">

							<input type="text" class="form-control" id="val" name="val[]" placeholder="Digite valor 1" required>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-success">Gerar</button>
			</div>

		</div>
	</form>
	<?php if(isset($variavel)){ ?>
		<div class="row" style="padding: 20px">
			<div class="col">
				<table class="table table-hover table-sm" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col"><?php echo $variavel; ?></th>
							<th scope="col">Frequencia Absoluta</th>
							<th scope="col">Frequencia Relativa (%)</th>
							<th scope="col">Frequencia Acumulada</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($tabela as $tab){
							echo '<tr>';

							echo '<th scope="row">'.$tab['n'].'</th>';
							echo '<td>'.$tab['freqabs'].'</td>';
							echo '<td>'.$tab['freqrela'].'</td>';
							echo '<td>'.$tab['freqacu'].'</td>';

							echo '</tr>';
						}
						?>
						<tr>

							<th scope="row" colspan="4">N: <?php echo $n; ?></th>


						</tr>				
					</tbody>
				</table>
			</div>
		</div>
		<div style="padding: 20px">
			<div class="row" >
				<div class="col">
					<label style="font-weight: bold;">Media: <?php echo $media;?></label>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label style="font-weight: bold;">Mediana: <?php echo $mediana;?></label>
				</div>
			</div>	

			<div class="row">
				<div class="col">
					<label style="font-weight: bold;">Moda: <?php 

					if(!empty($moda)){
						foreach($moda as $v){
							echo $v." ";
						}						
					}else{
						echo "Sem moda";
					}
					
					
					?></label>
					
				</div>
			</div>			
		</div>
		<div class="row" style="padding: 20px">
			<div class="col">
				
				<div id="columnchart_material" style="width: 800px; height: 500px;"></div>
			</div>
		</div>
	<?php } 
	?>
	<script type="text/javascript" src="assets/js/funcoes.js"></script>

	<script type="text/javascript">
		google.charts.load('current', {'packages':['bar']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['N', '<?php echo $variavel;?>'],
				<?php 
				foreach ($tabela as $val) {
					echo "['".$val['n']."', ".$val['freqrela']."],";
				}


				?>

				]);

			var options = {
				chart: {
					title: 'Grafico de <?php echo $variavel;?> em %',
					subtitle: 'Frequencia Relativa',
				}
			};

			var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>
</body> 
</html>