/********Reloj************/
	function timer(){
	var tiempo = new Date();
	var hora = tiempo.getHours()
	turno="am";
	if(hora>12){
		hora=hora-12;
		turno="pm";
	}
	var minuto = tiempo.getMinutes()
	if(minuto<10){
		minuto="0"+minuto;
	}
	var  segundo = tiempo.getSeconds()
	var hsalida=new Date().getTime();
	$("#reloj").html(hora+":"+minuto+":"+segundo+" "+turno);
	$("#horasalida").val(hora+":"+minuto+":"+segundo+" "+turno);
	$("#hentrada")[0].value=hora+":"+minuto+":"+segundo+" "+turno;
	$("#hsalida")[0].value=hsalida;
	}
setInterval("timer()", 1000);
	/*********End reloj***********/