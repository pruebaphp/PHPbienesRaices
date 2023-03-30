<?php 
if(!isset($_SESSION)){
    session_start();
}

$auth = $_SESSION['login'] ?? false;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../../../bienesRaicesPHP/build/css/app.css">
    <link rel="stylesheet" href="../../../bienesRaicesPHP/public/css/imagenHeader.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : '' ?>">
    
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../../../bienesRaicesPHP/">
                    <img src="../../../bienesRaicesPHP/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>
                <div class="mobile-menu">
                    <img src="../../../bienesRaicesPHP/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="../../../bienesRaicesPHP/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="../../../bienesRaicesPHP/nosotros.php">Nosotros</a>
                        <a href="../../../bienesRaicesPHP/anuncios.php">Anuncios</a>
                        <a href="../../../bienesRaicesPHP/blog.php">Blog</a>
                        <a href="../../../bienesRaicesPHP/contacto.php">Contacto</a>
                        <?php if($auth){?>
                            <a href="../../../bienesRaicesPHP/cerrar-sesion.php">Cerrar sesión</a> 
                        <?php }?>
                    </nav>
                </div>
                
            </div> <!--.barra-->
        </div>
    </header>