<?php

require_once "main.php";

$id=($_POST['producto_id']);


#verificar producto

$check_producto=conexion();
$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id=$id");
$datos=$check_producto->fetch();
if(!isset($id)) {

    echo '<div class="notification is-danger is-light">
    <strong>ERROR</strong><br>
    El producto no existe
    </div>';
    
    exit();

   
}

$check_producto=null;

#almacenar los datos

$codigo=limpiar_cadena ($_POST['producto_codigo']);
$nombre=limpiar_cadena ($_POST['producto_nombre']);
$precio=limpiar_cadena ($_POST['producto_precio']);
$stock=limpiar_cadena ($_POST['producto_stock']);
$categoria=limpiar_cadena ($_POST['producto_categoria']);


#espacio abierto


#verificar codigo de barra
if($codigo!=$datos['producto_codigoDB'])
{$check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT producto_codigoDB FROM producto WHERE producto_codigoDB=$codigo");
    if(!isset($codigo)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El codigo de barra ya existe, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_codigo=null;
        
        
        }
     

#verificar nombre de producto
if($nombre!=$datos['producto_nombre']){$check_producto=conexion();
    $check_producto=$check_producto->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
    if($check_producto->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El nombre ya existe, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_producto=null;
        
        } 

        #verificar categoria
        if($categoria!=$datos['categoria_id']){
            $check_categoria=conexion();
            $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id=$categoria");
            if(!isset($categoria)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La categoría seleccionada no existe
                    </div>
                ';
                exit();
            }
            $check_categoria=null;
        }
    



#espacio cerrado




#verificar campos obligatorios

if($codigo=="" || $nombre=="" || $precio=="" || $stock=="" || $categoria=="") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>
';
exit();
}


#guardar datos
$actualizar_producto=conexion();
$actualizar_producto_list=$actualizar_producto->prepare("UPDATE producto SET producto_codigoDB=:codigo, producto_nombre=:nombre, producto_precio=:precio, producto_stock=:stock, categoria_id=:categoria WHERE producto_id=:id");

$marcadores=[
    ":codigo"=>$codigo,
    ":nombre"=>$nombre,
    ":precio"=>$precio,
    ":stock"=>$stock,
    "categoria"=>$categoria,
    ":id"=>$id
];

        if($actualizar_producto_list->execute($marcadores)){

            echo '<div class="notification is-info is-light">
           <strong>Enhorabuena</strong><br>
           Producto actualizado
           </div>';
   
        }else{

            echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto no se pudo registrar, por favor elija otro
            </div>';

        }

        $actualizar_producto=null;
