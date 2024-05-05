<?php
    
    $categoria_id_del= limpiar_cadena($_GET['categoria_id_del']);

    #verificar categoria

$check_categoria=conexion();
$check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria_id_del'");

if($check_categoria->rowCount()==1){
     //verificando productos
     $check_productos= conexion();
     $check_productos=$check_productos->query("SELECT categoria_id FROM producto WHERE categoria_id='$categoria_id_del' LIMIT 1");

     if($check_productos->rowCount()<=0){
        
        $eliminar_categoria= conexion();
        $eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id=:id");

        $eliminar_categoria->execute([":id"=>$categoria_id_del]);

        if($eliminar_categoria->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>categoria eliminada</strong><br>
                la categoria se ha eliminado con exito
            </div>
        ';


         }else{

            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                no podemos eliminar la categoria, intente de nuevo
            </div>
        ';

         }   
         $eliminar_categoria=null;

     }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            no podemos eliminar la categoria, ya tiene un producto asociado
        </div>
    ';


     }

    $check_categoria=null;

}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        la categoria que desea eliminar no existe
    </div>
';


}

$check_categoria=null;
