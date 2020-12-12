<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>
	<title>Consulta de imagenes</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="Inteligencia_Artificial/css/bootstrap.min.css">
	<link rel="stylesheet" href="Inteligencia_Artificial/css/sweetalert.css">
	<link rel="stylesheet" href="Inteligencia_Artificial/css/custom.css">
	<link rel="stylesheet" href="Style.css">

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
					<input type="text" placeholder="URL" id="txt1" name="txt1" value="">						
						<label for="">Api key</label>						
						<input class="form-control" type="text" placeholder="Api key" id="txt2" name="txt2" >						
						<input type="submit" value="Ejecutar">
						<br>
						<br>
						<div class="col-md-6">
								<fieldset class="form-group">
									<div class="row">
										<div class="form-check radio_check">
											<input class="form-check-input" type="radio" name="radio_select" id="radiosfoto" value="1" checked>
											<label class="form-check-label" for="radiosfoto">Seleccionar Foto</label>
										</div>
										<div class="form-check radio_check">
											<input class="form-check-input" type="radio" name="radio_select" id="radiotfoto" value="0">
											<label class="form-check-label" for="radiotfoto">Tomar Foto</label>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="container_radio">
								<video id="video" autoplay="autoplay" class="video_container none"></video>
							</div>
							<canvas id = "canvas" style = "display: none;"> </canvas>
				</form>
				<form method="post" enctype="multipart/form-data">
				<?php
				if(isset($_POST['btn-save'])){
					require "api_imgbb.php";
				    $imgbb = new Api_imgbb;
				
				    if($imgbb->isImg($_FILES['archivo'])){
						$imgbb->upload();
						?>
						<b>URL Generada:</b>
						<?php
						echo $imgbb->getUrl();
				    }else{
				        echo "Este archivo no es compatible";
				    }
				}
				?>
				<div>
					<input type="file" class="form-control-file video_container" name="archivo" id="subirfoto" accept="image/*">
					<button class="btn btn-priemary btn-sm" type="submit" name="btn-save" onclick="env()">Guardar</button>
				</div>
				</form>
				<?php
				if(!empty($_POST['txt1']) && !empty($_POST['txt2'])){

				
					$URL = $_POST['txt1'];
					$KEY = $_POST['txt2'];
					$Comando = "";
					$Comando = 'curl -u "apikey:'.$KEY.'" "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?url='.$URL.'&version=2020-11-03"';

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
						}
							?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.js"></script>
	<script src="js/camara.js"></script>
</body>
</html>