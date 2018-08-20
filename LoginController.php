<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
   
    public function index()
    {
		session_start();
		echo view('header');
		echo view('home');
	    echo view('footer');
    }
    public function checkIn_vehicle()
    {
        echo view('header');
        echo view('checkIn_vehicle');
        echo view('footer');
    }

   
    public function addvehicle(Request $request)
    { 
	session_start();
	  if(isset($_POST['marca'])&& isset($_POST['placa']) &&!empty($_POST['marca']) && !empty($_POST['placa'])){
		$ocupados=array();
		  $disponibles=array();
		foreach($_SESSION['puestos'] as $puesto){
			if($puesto['status']==="vacio"){
				$disponibles[]=$puesto['puesto'];
			}
		}
		$_SESSION['disponibles']=$disponibles;
		$tamano=count($_SESSION['disponibles']);
		if($tamano>0){
			/*****************select puesto disponible****************************/
		        $indice=array_rand($_SESSION['disponibles']);
		          $posicion=$_SESSION['disponibles'][$indice];
				  /************End select***************/
		/********************update puesto to acupado**********************/
		    $puestos=array();
			foreach($_SESSION['puestos'] as $puesto){
	             if($puesto['puesto']===$posicion){
		                 $puesto['status']="ocupado"; 
	                }
	                array_push($puestos,$puesto);
            }
                   $_SESSION['puestos']=$puestos;
	    /********************end update to ocupado****************************/
		/*********************addvehicle*************************/	  					 
				   if(isset($_SESSION['vehicles'])){
                   $vehicles=$_SESSION['vehicles'];				   
			$vehicle=array("marca"=>$_POST['marca'],"placa"=>$_POST['placa'],"puesto"=>$posicion,"timing"=>$_POST['timing'],"h_entrada"=>$_POST['hentrada'],"acumulado"=>0);
		array_push($vehicles,$vehicle);
		$_SESSION['vehicles']=$vehicles;
		}else{
		$_SESSION['vehicles']=array();	
		$vehicles=array();
		$vehicle=array("marca"=>$_POST['marca'],"placa"=>$_POST['placa'],"puesto"=>$posicion,"timing"=>$_POST['timing'],"h_entrada"=>$_POST['hentrada'],"acumulado"=>0);
		array_push($vehicles,$vehicle);
		$_SESSION['vehicles']=$vehicles;
		}   
		/************************end addvehicle*****************************/		   
         /**********************save service to parking today Table**************************/         
		 include('./conectionDB.php');
		 
                $marca=$_POST['marca'];
                  $placa=$vehicle['placa'];
                      $h_entrada=$_POST['hentrada'];
                         $pos_inicial=$posicion;
						   $pos_final=$posicion;
                            $status="open";
                                $qry="insert into parking_today (marca,placa,h_entrada,pos_inicial,pos_final,status)values('$marca','$placa','$h_entrada','$pos_inicial','$pos_inicial','$status')";
                                    $result=$con->query($qry);
                    if($result){
	                  echo "<script>alert('Vehiculo parqueado');</script>";
                    }else{
	                         echo "<script>alert('No se pudo guardar la informacion');</script>";
	                      }	
		 /***********************End conect DB**********************************/
		/************************verify puestos disponibles******************************/
		$disponibles=array();
             foreach($_SESSION['puestos'] as $puesto){
		               if($puesto['status']==="vacio"){
			                $disponibles[]=$puesto['puesto'];
		                }
	                }
		/********************End verify if puestos disponibles is true******************/
		/**********************update puestos disponibles*****************************/
			$_SESSION['disponibles']=$disponibles;
		/*********************End update puestos disponibles*************************/
		 /**********************Mark puesto asignado******************************/         
				 $_SESSION['asignado']=$posicion;
	    /******************End Mark Puesto asignado*************************/
		 
		 echo "<script> window.load = './'</script>";
		 sleep(1);
		}else{
			 echo "<script>alert(\"Estacionamiento lleno\");</script>";
		 echo "<script>document.body.innerHTML='<div class=\"alert alert-danger\">lleno</div>'</script>";
		}
	 echo "<script>window.location='./'</script>";
	  }else{
		 echo "<script>window.location='./'</script>";
	  }
    }
    public function close_parking()
    {
		session_start();
        unset($_SESSION['vehicles']);
        unset($_SESSION['puestos']);
		session_destroy();
		 echo "<script>window.location='./'</script>";
    }
	public function login(Request $request)
	{
		if(isset($_POST['campo1'])){
		echo "se recibio el siguiente dato por medio de POST:<br>";
	}
	}
	public function vehicles()
	{
		
		if (isset($_POST['puesto']) && isset($_POST['acumulado'])){
		  session_start();
		  $vehicles=$_SESSION['vehicles'];
		   $newvehicle=array();
		  $patron=$_POST['puesto'];
		   $i=0;
		   foreach($vehicles as $vehicle){
			   $newvehicle[]=$vehicle;
			    if($newvehicle[$i]['puesto']=$patron){
					$newvehicle[$i]['acumulado']=$_POST['acumulado'];
				break;
				}
			   $i++;
		   }
		 $_SESSION['vehicles']=$newvehicle;
		 echo $newvehicle[$i]['puesto'];
		 
		}else{
			session_start();
			echo view('header');
			echo view('parking');
			echo view('footer');
		}
	}
	public function update_parking()
	{ session_start();
	   if (isset($_SESSION['vehicles'])){
		    if(isset($_POST['puesto']) && isset($_POST['acumulado'])){
				  $patron=$_POST['puesto'];
	           $i=0;
			   $encontrado=false;
			   $newvehicle=array();
			   foreach($_SESSION['vehicles'] as $vehicle){
				        $newvehicle[]=$vehicle;
		                    if($vehicle['puesto']=$patron){
							  $newvehicle[$i]['acumulado']=$_POST['acumulado'];
							  $newvehicle[$i]['timing']=$_POST['timing'];
						    break;
							}
						      $i++;
	            }
				    $_SESSION['vehicles']=$newvehicle;
            }else{
		              echo "No data GET or POST received";
             }
	    }else{
	               echo "<script>alert('El estacionamiento esta vacio');</script>";
	               echo "<script>window.location='./';</script>";
				   
                }
	}
    
	public function vehicle()
	{
		session_start();
		echo view('header');
		echo view('vehicle');
		echo view('footer');
	}
	
	public function CheckOut_vehicle()
	{
		 session_start();
		 if (isset($_POST['placa'])){
			 include('./conectionDB.php');
			 $horasalida=$_POST['horasalida'];
			 $puestofinal=$_POST['puestofinal'];
			 $segundos=$_POST['segundos'];
			 $monto=$_POST['monto'];
			 $placa=$_POST['placa'];
			 $qry="update parking_today set h_salida='$horasalida',pos_final='$puestofinal',duration='$segundos',pagado='$monto' where placa=$placa ";
			 $result=$con->query($qry);
			 echo "<script>alert('Operacion exitosa')</script>";
			 //echo "<script>window.load='./'</script>";
			 
		 }else{
			  echo "<script>window.load='./'</script>";
		 }
		 
		
	}
	
	
}
