<?php 

function conectarDB():mysqli{
    $db = mysqli_connect('localhost','root','','bienesraices_crud');

    if(!$db){
        echo "Error No se conecto";
        exit;
    }
       return $db;
    
}

function ruta(){
    return 'http://localhost/bienesRaicesPHP';
}

?>