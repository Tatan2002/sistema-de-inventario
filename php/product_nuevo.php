<?php
require_once "../inc/sesiones.php";
require_once "main.php";

#almacenar datos

$codigo=limpiar_cadena($_POST['producto_codigo']);
	$nombre=limpiar_cadena($_POST['producto_nombre']);

	$precio=limpiar_cadena($_POST['producto_precio']);
	$stock=limpiar_cadena($_POST['producto_stock']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);


	/*== Verificando campos obligatorios ==*/
    if($codigo=="" || $nombre=="" || $precio=="" || $stock=="" || $categoria==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }




#verificando codigo 

$check_codigo=conexion();
$check_codigo=$check_codigo->query("SELECT producto_codigoDB FROM producto WHERE producto_codigoDB='$codigo'");
if($check_codigo->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El codigo de barras ya existe, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_codigo=null; 


        #verificar nombre de producto

$check_nombre=conexion();
$check_nombre=$check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
if($check_nombre->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El producto ya existe, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_productoo=null;
        
    
    #directorio de imagenes
    
  $img_dir="../img/producto/"; 

    #comprobar si se selecciono una imagen

    if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

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


    chmod($img_dir,0777);
    
    $img_name=renombrar_fotos($nombre);
    $foto=$img_name.$img_ext;


    #mover imagen

    if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$foto)){
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            no podemos subir/cargar imagen
        </div>
    ';
    exit();
            
    }

    }else{
    $foto="";
    }

    #guardar producto
    $guardar_producto=conexion();
    $guardar_producto=$guardar_producto->prepare("INSERT INTO producto(producto_codigoDB,producto_nombre,producto_precio,producto_stock,producto_pic,categoria_id,usuario_id) VALUES(:codigo,:nombre,:precio,:stock,:foto,:categoria,:usuario)");

    $marcadores=[
        ":codigo"=>$codigo,
        ":nombre"=>$nombre,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":foto"=>$foto,
        ":categoria"=>$categoria,
        ":usuario"=>$_SESSION['id']
    ];

       $guardar_producto->execute($marcadores);

       if($guardar_producto->rowCount()==1){
           echo '<div class="notification is-info is-light">
           <strong>Enhorabuena</strong><br>
           Producto guardado
           </div>';
   
       }else{

        if(is_file($img_dir.$foto)){
            chmod($img_dir,0777);
            unlink();

        }

           echo '<div class="notification is-danger is-light">
           <strong>¡Ocurrio un error inesperado!</strong><br>
           El producto no se pudo registrar, por favor elija otro
           </div>';
           
   }
   
   $guardar_producto=null;














