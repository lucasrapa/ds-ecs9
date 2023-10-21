<?php

require_once 'responses/nuevoResponse.php';
require_once 'request/nuevoRequest.php';
require_once '../../modelo/mediocontacto.php';
require_once '../../modelo/vehiculo.php';

header('Content-Type: application/json');


$response=new nuevoResponse ();
$response->isOK=true;
$response->Mensaje []= "";


$json = file_get_contents('php://input',true);
$request = json_decode($json);
 
if ($request->NroPoliza > 1000 || $request->NroPoliza < 0 ) {
    $response->isOK = false;
    $response->Mensaje[] = "La Poliza no existe";
}
else {
    if ($request->Vehiculo == NULL) {
        $response->isOK = false;
        $response->Mensaje[] = "debe indicar el vehiculo"; 
    } else {
        if ($request->Vehiculo->Marca== NULL 
        ||$request->Vehiculo->Modelo == NULL 
        || $request->Vehiculo->Version == NULL 
        || $request->Vehiculo->Anio == NULL ){
            $response->isOK= false;
            $response->Mensaje[] = "Debe indicar todas las propiedades del vehiculo";
        }
        
    } 
    $Cantidaddemediodecontacto=0;
    foreach ($request->ListMediosContacto as $Mediocontacto) {
        $Cantidaddemediodecontacto=$Cantidaddemediodecontacto+1;  
    }
    if ($Cantidaddemediodecontacto==0 ) {
        $response->isOK= false;
        $response->Mensaje[] = "Debe indicar al menos un medio de contacto";  
    } else {
        foreach ($request->ListMediosContacto as $Mediocontacto ) {
            if ($Mediocontacto->MedioContactoDescripcion != "Mail" 
             && $Mediocontacto->MedioContactoDescripcion != "Celular" ) {
                $response->isOK = false;
                $response->Mensaje[] ="Debe indicar medios de contacto válidos";
                break;  
            }
        }
    }



}



echo json_encode($response);
