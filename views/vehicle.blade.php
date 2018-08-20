<div id="factura" class="col-md-1">
</div>
<div class="col-md-11">
<?php
$serie1=array(12,25,82,96,34,82,15,65,61,47,1,5,9,7);
$serie2=array('A0D1','A5A8','F2E3','F7H9','6XA0','4ZE05','7TQ4','0K3D2');
$indice1=array_rand($serie1);
$indice2=array_rand($serie2);
$numfactura=$serie1[$indice1].$serie2[$indice2];
    if(isset($_POST['placa'])){
        if (isset($_SESSION['vehicles'])){
	         $placa=$_POST['placa'];
	         $vehicle=array();
	         $encontrado=false;
	         $vehicles=$_SESSION['vehicles'];
	        foreach($vehicles as $vh){
		       if($vh['placa']===$placa){
			        $vehicle=$vh;
			        $encontrado=true;
		        }
	        }
	        if($encontrado==true){
				include('./conectionDB.php');
				$hsalida=$_POST['hsalida'];
				$horasalida=$_POST['horasalida'];
				$puestofinal=$vehicle['puesto'];
				$placa=$_POST['placa'];
		          echo "<div class=\"col-md-3\">";
				  echo "<form role=\"form\"  action=\"./CheckOut_vehicle\" method=\"POST\">";
		          ?>
		<input type="hidden" name="_token"value="{{csrf_token()}}"></input>;
		<?php
				  echo "<h3>Factura: <span id=\"idfactura\">#$numfactura</span></h3><br>";
		          echo "Puesto: ".$vehicle['puesto']."<br>";
		          echo "Marca: ".$vehicle['marca']."<br>";
		          echo "Placa: <span id=\"placa\">".$vehicle['placa']."</span><br>";
		          echo "Entrada: ".$vehicle['h_entrada']."<br>";
		          echo "Salida: ".$horasalida."<br>";
		          echo "Tiempo: <span id=\"timed".$vehicle['puesto']."\"></span> Seconds.<br>";
		          echo "Monto a pagar: <span id=\"deuda".$vehicle['puesto']."\"></span><br>";
		          echo "<input id=\"hsalida\" name=\"hsalida\" type=\"hidden\" value=\"$hsalida\"></input>";
		          echo "<input id=\"segundos\" name=\"segundos\" type=\"hidden\" value=\"\"></input>";
				  echo "<input id=\"monto\" name=\"monto\" type=\"hidden\"></input>";
				  echo "<input id=\"horasalida\" name=\"horasalida\" type=\"hidden\" value=\"$horasalida\"></input>";
				  echo "<input id=\"puestofinal\" name=\"puestofinal\" type=\"hidden\" value=\"$puestofinal\"></input>";
				  echo "<input id=\"placa\" name=\"placa\" type=\"hidden\" value=\"$placa\"></input>";
		          echo "<input type=\"submit\" class=\"btn btn-default\" value=\"CheckOut\"></input>";
				  echo "</form>";
				  echo "</div>";
	            
                 
	        }else{
	                echo "<script>alert('Numero de placa invalido, intente de nuevo'); window.location='./' ;</script>";
	                echo "<script>window.location='./' ;</script>";
                 }
	


        }else{
	           echo "<script>alert('Estacionamiento vacio.')</script>";
			   echo "<script>window.location='./'</script>";
             }
	}else{
	           echo "<script>window.location='./'</script>";
        }


?>
<!--<form role="form" action="./vehicles" method="POST">
<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
<input name="puesto" type="text"></input>
<input name="acumulado" type="text"></input>
<input type="submit" value="enviar"></input>
</form>-->
</div>
<div class="col-md-12">
<br>
<button id="checkout" class="btn btn-default .sr-only " media="screen">CheckOut</button>
<a id="cancel" class="btn btn-default .sr-only" href="./">Cancel</a>

</div>
<script>
$("#checkout").click(function(){
	window.print($("#factura").html());
});
</script>
<script src="./vehicles.js"></script>