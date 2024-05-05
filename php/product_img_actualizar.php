<?php

require "main.php";

$product_id=($_POST['img_up_id']);
$check_producto=conexion();
$check_producto_img=$check_producto->query("SELECT * FROM producto WHERE producto_id=$product_id");


$datos=$check_producto_img->fetch();

 if(!isset($datos["producto_pic"])){

    echo '
         <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
             La imagen del PRODUCTO que intenta actualizar no existe
         </div>
   ';
    exit();
    
    var_dump($datos);
}

$check_producto=null;


  /* Directorios de imagenes */
  $img_dir='../img/producto/';
	
#comprobar si se selecciono una imagen

if($_FILES['producto_foto']['name']=="" || $_FILES['producto_foto']['size']==0){

    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se ha seleccionado una imagen
        </div>
    ';
    exit();

}

  #verificar directorio

  if(!file_exists($img_dir)){
    if(!mkdir($img_dir,0777)){
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            no se puede crear el directorio
        </div>
    ';
    exit();
}

} 

    chmod($img_dir,0777);


     
      #verificar formato de las imagenes
      if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado es de un formato que no está permitido
            </div>
        ';
        exit();
    }

        #verificar peso de imagen
      if(($_FILES['producto_foto']['size']/1024)>3072){
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La imagen supera el peso permitido
        </div>
    ';
    exit();

      }


       #verificar formato de imagen
       switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
        case 'image/jpeg':
          $img_ext=".jpg";
        break;
        case 'image/png':
          $img_ext=".png";
        break;
    }

    $img_name=renombrar_fotos($datos['producto_nombre']);
    $foto=$img_name.$img_ext;


    if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$foto)){
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            no podemos subir/cargar imagen
        </div>
    ';
    exit();
            
    }


    if(is_file($img_dir.$datos['producto_nombre']) && $img_dir.$datos['producto_foto']!=$foto){
        chmod($img_dir.$datos['producto_nombre'],0777);
        unlink($img_dir.$datos['producto_nombre']);
    }



    #actualizar foto

$eliminar_imagen=conexion();
$eliminar_imagen=$eliminar_imagen->prepare("UPDATE producto SET producto_pic=:foto  WHERE producto_id=:id");

#marcadores

$marcadores=[
    ":foto"=>$foto,
    ":id"=>$product_id
];

if($eliminar_imagen->execute($marcadores)){

    echo '<div class="notification is-info is-light">
   <strong>Enhorabuena</strong><br>
   Imagen actualizada, recarge para aplicar cambios

   <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=productos_img&product_id_up='.$product_id.'" class="button is-info">recarge aqui</a>
    </p?
   </div>';

}else{

    if($is_file($img_dir.$foto)){

        chmod($img_dir.$foto,0777);
        unlink($img_dir.$foto);

    }

    echo '<div class="notification is-warning is-danger">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La imagen fue eliminada, dele al boton para recargar los cambios
    </div>';
}

$eliminar_imagen=null;