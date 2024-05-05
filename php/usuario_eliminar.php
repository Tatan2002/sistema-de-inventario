<?php 
    require_once "main.php";

    $user_id_del= limpiar_cadena ($_GET['user_id_del']);

    // verificarndo usuario

    $check_usuario= conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");
    if($check_usuario->rowCount()==1){

        //verificando 
        $check_productos= conexion();
        $check_productos=$check_productos->query("SELECT usuario_id FROM producto WHERE usuario_id='$user_id_del' LIMIT 1");

        if($check_productos->rowCount()<=0){

            $eliminar_usuario= conexion();
            $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");

            $eliminar_usuario->execute([":id"=>$user_id_del]);

         if($eliminar_usuario->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>usuario eliminado</strong><br>
                los datos del usuario se han eliminado con exito
            </div>
        ';


         }else{

            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                no podemos eliminar el usuario, intente de nuevo
            </div>
        ';

         }   
         $eliminar_usuario=null;

        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                no podemos eliminar el usuario, tiene un producto registrado
            </div>
        ';


        }
        $check_productos=null;


    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            el usuario que desea eliminar no existe
        </div>
    ';

    }

    $check_usuario=null;