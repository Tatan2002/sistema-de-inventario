<?php

require_once "main.php";

$id=limpiar_cadena($_POST['categoria_id']);

#verificar categoria

$check_categoria=conexion();
$check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$id'");

if($check_categoria->rowCount()<=0) {

    echo '<div class="notification is-danger is-light">
    <strong>ERROR</strong><br>
    La categoria no existe
    </div>';
    
    exit();
}else{
    $datos=$check_categoria->fetch();
}

$check_categoria=null;

#almacenar los datos

$nombre=limpiar_cadena($_POST['categoria_nombre']);
$location= limpiar_cadena($_POST['categoria_ubicacion']);

#verificando campos obligatoria

if($categoria="") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>
';
exit();
} 

/*== Verificando integridad de los datos ==*/
if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            la categoria no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if($location!=""){
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

#verificar nombre
if($nombre!=$datos['categoria_nombre']){

    $check_category=conexion();
$check_category=$check_category->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
if($check_category->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El nombre ya existe, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_category=null; 

}


#actualizar categoria
$update_categoria=conexion();
$update_categoria= $update_categoria->prepare("UPDATE categoria SET categoria_nombre=:nombre, categoria_ubicacion=:ubicacion WHERE categoria_id=:id ")
;

#marcadores
$marcadores= [
    ":nombre"=>$nombre,
    ":ubicacion"=>$location,
    ":id"=>$id
];

$update_categoria ->execute($marcadores);

if($update_categoria->rowCount()==1){
    echo '<div class="notification is-info is-light">
    <strong>Enhorabuena</strong><br>
    Categoria actualizada con exito
    </div>';

}else{
       
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La categoria ya existe, por favor elija otro
    </div>';
    
}

$update_categoria=null;
