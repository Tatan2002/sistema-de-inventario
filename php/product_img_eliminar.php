<?php
include "main.php";

$product_id=($_POST['img_del_id']);
$check_producto=conexion();

$check_producto_base=$check_producto->query("SELECT * FROM producto WHERE producto_id=$product_id");
$datos=$check_producto_base->fetch();
if(!isset($datos["producto_pic"])){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La imagen del PRODUCTO que intenta actualizar no existe
        </div>
    ';
    exit();
}
$check_producto=null;


   /* Directorios de imagenes */
	$img_dir='../img/producto/';
	
	chmod($img_dir,0777);

	if(is_file($img_dir.$datos['producto_pic'])){

		chmod($img_dir.$datos['producto_pic'],0777);

		if(!unlink($img_dir.$datos['producto_pic'])){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Error al intentar eliminar la imagen del producto, por favor intente nuevamente
	            </div>
	        ';
	        exit();
		}
	}



   #eliminar foto

$eliminar_imagen=conexion();
$eliminar_imagen=$eliminar_imagen->prepare("UPDATE producto SET producto_pic=null  WHERE producto_id=:id");

#marcadores

$marcadores=[
    ":id"=>$product_id
];

if($eliminar_imagen->execute($marcadores)){

    echo '<div class="notification is-info is-light">
   <strong>Enhorabuena</strong><br>
   Imagen eliminada
   <p class="has-text-centered pt-5 pb-5">
   <a href="index.php?vista=productos_img&product_id_up='.$product_id.'" class="button is-info">recarge aqui</a>
   </p?
   </div>';

}else{

    echo '<div class="notification is-warning is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La imagen fue eliminada, dele al boton para recargar los cambios
    <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=productos_img&product_id_up='.$product_id.'" class="button is-info">recarge aqui</a>
    </p?
    </div>';
}

$eliminar_imagen=null;


