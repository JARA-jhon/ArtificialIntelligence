<!DOCTYPE html>
<html>
<head>
	<title>Consulta de imagenes</title>
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<h1>Reconocimiento de imagenes</h1>
			</div>
			<div class="card-header">
				<form method="POST">
					
							<label for="">URL</label>
						
							<input type="text" placeholder="URL" id="txt1" name="txt1" >
						
							<label for="">Api key</label>
						
							<input class="form-control" type="text" placeholder="Api key" id="txt2" name="txt2" >
						
							<input type="submit" value="Ejecutar">
							<br>
							<br>
						
				</form>
				<?php
				
				$URL = $_POST['txt1'];
				$KEY = $_POST['txt2'];
				$Comando = "";
				$Comando = 'curl -u "apikey:'.$KEY.'" "'.$URL.'&version=2020-11-03"';

				$Result = shell_exec($Comando);
				$ObjetResult = json_decode($Result);
				$Positionimages = $ObjetResult->{'images'};	
				$positionClasifier = $Positionimages[0];
				$positionClasifierId = $positionClasifier->{'classifiers'};
				$positionClases = $positionClasifierId[0];
				$positionResult = $positionClases->{'classes'};
				//var_dump($positionResult[1]);

				?>	

				<div>
					<table border="1px">
						<thead>
							<tr>
								<td>class</td>
								<td>score</td>
								<td>type_hierarchy</td>
								
							</tr>
						</thead>
						<tbody id="Result-List">
						
							<?php
							foreach ($positionResult as $obj => $value) {
								?>
								<tr>
								<?php
									foreach ($value as $obj2 => $value2) {
								?>
									<td><?php echo $value2 ?></td>
									
								<?php
									}
								?>
							
							</tr>
							
							<?php
							}
							?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>



