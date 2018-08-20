<script src="./vehicles.js"></script>
<?php
if (isset($_SESSION['vehicles'])){
	$vehicles=array();
	$vehicles=$_SESSION['vehicles'];
	foreach($vehicles as $vehicle){
		echo "<div class=\"col-md-3\">";
		echo "<image class=\"img img-thumbnail\" src=\"./media/images/carblue.png\"></image><br>";
		echo "Puesto: ".$vehicle['puesto']."<br>";
		echo "Marca:".$vehicle['marca']."<br>";
		echo "Placa: ".$vehicle['placa']."<br>";
		echo "Entrada: ".$vehicle['h_entrada']."<br>";
		echo "Timing:<span id=\"timed".$vehicle['puesto']."\"></span><br>";
		echo "Monto:<span id=\"deuda".$vehicle['puesto']."\"></span><br>";
		echo "</div>";
	}
	$_SESSION['vehicles']=$vehicles;
}else{
	//print_r($_SESSION['puestos']);
	echo "El estacionamiento esta vacio";
}
?>
<!--<form role="form" action="./vehicles" method="POST">
<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
<input name="puesto" type="text"></input>
<input name="acumulado" type="text"></input>
<input type="submit" value="enviar"></input>
</form>-->
<div class="col-md-12">
<br>
</div>
<script>
</script>