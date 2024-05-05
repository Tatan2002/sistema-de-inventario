<?php 

require_once "main.php";

#almacenar datos

$categoria= limpiar_cadena($_POST['categoria_nombre']); 
$location= limpiar_cadena($_POST['categoria_ubicacion']);

#verificar campos obligatorios

if($categoria==""){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    
    ';
    exit();
    

}

#verificar la integridad de los datos

if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$categoria)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El NOMBRE no coincide con el formato solicitado
    </div>
';
exit();

}

if($location!="") {
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$location)) {

        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
    
    }

}

#verificar categoria
$check_categoria=conexion();
$check_categoria=$check_categoria->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$categoria'");
if($check_categoria->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El nombre ya existe, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_categoria=null; 




#guardar datos 

$guardar_categoria= conexion();
$guardar_categoria= $guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre,categoria_ubicacion) VALUES (:nombre,:ubicacion)");

$marcadores= [
    ":nombre"=>$categoria,
    ":ubicacion"=>$location
];

$guardar_categoria->execute($marcadores);

if($guardar_categoria->rowCount()==1){
    echo '
    <div class="notification is-info is-light">
        <strong>¡Aviso!</strong><br>
        Datos insertados correctamente
    </div>
';

}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La categoria ya existe, por favor elija otra
    </div>
';

}
$guardar_categoria=null;