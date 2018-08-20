
<div class="form-group col-md-6">
<form role="form" action="./checkIn_vehicle" method="POST">
<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
<div class="form-group">
Marca:<input id="marca" name="marca" type="text" class="form-control"></input>
</div>
<div class="form-group">
Placa:<input id="placa" name="placa" type="text" class="form-control"></input>
</div>
<div class="form-group">
<input class="btn btn-success" type="submit" value="Agregar"></input>
</div>
</form>
</div>
<div class="col-md-12"><a href="./close_parking">Cerrar</a></div>
