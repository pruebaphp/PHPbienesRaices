<?php

define("URL_INCLUDES",__DIR__);

require URL_INCLUDES.'/app.php';

function incluirTemplate($nombre,$inicio=false){
    include TEMPLATES_URL."/".$nombre.".php";
}

function protegerRuta(){
    $auth = $_SESSION['login'];
    if(!$auth){
        header('Location:http://localhost/bienesRaicesPHP');
        return;
    }
}


?>