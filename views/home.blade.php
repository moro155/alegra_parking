<script src="./reloj.js"></script>
<div class="container">
<div class="col-md-12 col-xs-12">
<div class="rayado">
</div>
<center><h3>Parking Service</h3></center>
<div class="reloj" type="text" size="11" id="reloj" name="reloj" disabled></div>
<div class="pull-right" name="Tick">
</div>
<p id="sendin"></p>
</div>
<ul class="nav nav-tabs">
<li class="nav-item">
<div class="dropdown">
<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Check-In</button>
<ul class=" dropdown-menu">
<li style="padding:15px;">
<form role="form" enctype="multipart/form-data" action="./checkIn_vehicle" method="POST">
<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
<span>Hora entrada</span>
<input type="text" class="form-control" name="hentrada" id="hentrada" contenteditable="false"></input>
<input type="hidden" id="timing" name="timing" value="0"></input>
<div class="form-group">
<span>Marca:</span>
<select id="marca" name="marca"  class="form-control">
<option>FORD</option>
<option>CHEVROLET</option>
<option>HIUNDAY</option>
<option>DODGE</option>
<option>TOYOTA</option>
<option>GMC</option>
<option>REANULT</option>
<option>WOLKVAGEN</option>
</select>
</div>
<div class="form-group">
<span>Placa:</span><input id="placa" name="placa" type="text" class="form-control"></input>
</div>
<div class="form-group">
<input  id="btnAdd" name="btnAdd" class="btn btn-success" type="submit" value="Check-In"></input>
</div>
</form>
</li>
<li>
<div class="col-md-12"><a href="./close_parking">Cerrar</a></div></li>
</ul>
<span id="reloj" name="reloj" class="reloj"></span>
</div>
</li>
<li class="nav-item">
<div class="dropdown">
<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Check-Out</button>
<ul class=" dropdown-menu">
<li style="padding:15px;">
<form role="form" enctype="multipart/form-data" action="./vehicle" method="POST">
<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
<span> Hora salida</span><input class="form-control" name="horasalida" id="horasalida"></input>
<input type="hidden" class="form-control" name="hsalida" id="hsalida"></input>
<input type="hidden" name="timed" id="timed" value="0"></input>
<div class="form-group">
<span>Placa:</span><input id="placa" name="placa" type="text" class="form-control"></input>
</div>
<div class="form-group">
<input  id="btnOut" name="btnOut" class="btn btn-success" type="submit" value="Check-Out"></input>
</div>
</form>
</li>
</ul>
</div>
</li>
<li class="nav-item">
<div>
<div><a href="./vehicles" class="btn btn-default" target="_blank">Vehicles <span class="glyphicon glyphicon-eye-open"></span></a></div>
</div>
</div>
</li>
</ul>
<br>
<?php
		echo "<div class=\"container \"> ";
$logo="./";
$puesto=array();
if(isset($_SESSION['puestos'])){
	$i=1;
	$puestos=$_SESSION['puestos'];
	foreach($puestos as $puesto){
		if($puesto['status']==='ocupado'){
			$logo="./media/images/carblue.png";
		}else{
			$logo="./media/images/cell-empty.png";
		}
	?>
	<div class="areavehicle col-md-1 col-xs-2">
	<label><?php echo "".$i ; ?></label>
	<span>Time</span><span class="form-control" id="segundero<?php echo $puesto['puesto'] ;?>"><?php echo $puesto['timing'] ;?></span>
	<input id="timer<?php echo $puesto['puesto'] ;?>" name="timer<?php echo $puesto['puesto'] ;?>" type="hidden" class="form-control" value=""></input>
	<image class="vehicle" src="<?php echo $logo ; ?>"></image>
	<input id="status<?php echo $puesto['puesto'] ;?>" name="status<?php echo $puesto['puesto'] ;?>" type="hidden" class="form-control"  value="<?php echo $puesto['status'] ;?>"></input>
	<input id="puesto" name="puesto" type="hidden" class="form-control"  value="<?php echo $puesto['puesto'] ;?>"></input>
	<span>Monto</span><input id="monto<?php echo $i;?>"  name="monto<?php echo $i ;?>" type="text" class="form-control" value="<?php echo $puesto['monto'];?>" disabled></input>
	</div>
	<?php
	$i++;
   }
   echo "<script type=\"text/javascript\" src=\"./timer.js\"></script>";
}else{
	$_SESSION['puestos']=array();
	$newpuestos=array();
	$i=1;
	for($i=1;$i<=20;$i++){
		$puesto=array("puesto"=>$i,"status"=>'vacio',"timing"=>'00:00:00',"monto"=>0);
		$newpuestos[]=$puesto;
	}
$_SESSION['puestos']=$newpuestos;
$logo="./media/images/cell-empty.png";
foreach($_SESSION['puestos'] as $puesto){
	?>
	<div class="areavehicle col-md-1 col-xs-2">
	<label><?php echo $puesto['puesto'] ?></label>
	<span>Time</span><span class="form-control" id="segundero<?php echo $puesto['puesto'] ;?>"><?php echo $puesto['timing'] ;?></span>
	<input id="timer<?php echo $puesto['puesto'] ;?>" name="timer<?php echo $puesto['puesto'] ;?>" type="hidden" class="form-control" value=""></input>
	<image class="vehicle" src="<?php echo $logo ; ?>"></image>
	<input id="status<?php echo $puesto['puesto'] ;?>" name="status<?php echo $puesto['puesto'] ;?>" type="hidden" class="form-control" value="<?php echo $puesto['status'] ;?>"></input>
	<input id="puesto" name="puesto" type="hidden" class="form-control"  value="<?php echo $puesto['puesto'] ;?>"></input>
	<span>Monto</span><input id="monto<?php echo $i;?>"  name="monto<?php echo $i ;?>" type="text" class="form-control" value="<?php echo $puesto['monto'];?>" disabled></input>
	</div>
	<?php
}
echo "<script type=\"text/javascript\" src=\"./timer.js\"></script>";
}
echo "</div>";
echo "<br>";
$vp=0;
echo "<div class=\"col-md-12 col-xs-12\">";
if(isset($_SESSION['vehicles'])){
	$vp=count($_SESSION['vehicles']);
	$vacios=20-$vp;
	echo "";
	echo "<div class=\"alert alert-info\"><span>Vehiculos parqueados:<strong>".$vp."</strong></span></br><br><span>Puestos disponibles:<strong>".$vacios."</strong></span></div>";
}else{
	$vp=0;
	echo "<div class=\"alert alert-warning\">Vehiculos parqueados:<strong>".$vp."</strong></div>";
}
echo "</div>";
?>
</div>