<?php 

$modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);

$modulos= ["usuario","categoria","producto"];

if(in_array($modulo_buscador, $modulos)){

    $modulos_url=[
        "usuario"=>"user_search",
        "categoria"=>"categoria_search",
        "producto"=>"productos_search"
    ];

    $modulos_url=$modulos_url[$modulo_buscador];

    $modulo_buscador="busqueda_".$modulo_buscador;

    #iniciar busqueda
    if(isset($_POST['txt_buscador'])){
        $txt= limpiar_cadena($_POST['txt_buscador']);
        
            if($txt==""){
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    datos vacios
                </div>';

            }else{ 
                    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)){
                        echo '
                        <div class="notification is-danger is-light">
                            <strong>¡Ocurrio un error inesperado!</strong><br>
                            datos erroneos, no coinciden con formato solicitado
                        </div>';

                    }else{
                        $_SESSION["$modulo_buscador"]=$txt;
                        header("location: index.php?vista=$modulos_url",true,303);
                        exit();

                    }
                
            }

    }
    
    #eliminar busqueda
    if(isset($_POST['eliminar_buscador'])){ 

        unset($_SESSION["$modulo_buscador"]);
        header("location: index.php?vista=$modulos_url",true,303);
        exit();


    }


}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se puede procesar la peticion
    </div>';


}

