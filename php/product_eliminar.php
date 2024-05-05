<?php
    require_once "main.php";
    
    $producto_id_del= limpiar_cadena($_GET['product_id_del']);

    #verificar producto

$check_producto=conexion();
$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$producto_id_del'");

if($check_producto->rowCount()==1){
    $datos=$check_producto->fetch();

    $eliminar_producto= conexion();
    $eliminar_producto=$eliminar_producto->prepare("DELETE FROM producto WHERE producto_id=:id");

    $eliminar_producto->execute([":id"=>$producto_id_del]);


    if($eliminar_producto->rowCount()==1){

        if(is_file("./img/producto/".$datos['producto_pic'])){
            chmod("./img/producto/".$datos['producto_pic'],0777);
            unlink("./img/producto/".$datos['producto_pic']);
        }


        echo '
        <div class="notification is-info is-light">
            <strong>Producto eliminado</strong><br>
            El producto se ha eliminado con exito
        </div>
    ';


     }else{

        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto no se pudo eliminar
        </div>
    ';

     }   
     $eliminar_producto=null;    



     }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto que desea eliminar no existe
        </div>
    ';


     }

     $eliminar_producto=null;    