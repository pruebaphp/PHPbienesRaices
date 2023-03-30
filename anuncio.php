<?php 
require './includes/funciones.php';
incluirTemplate('header'); 
require 'includes/config/database.php';
$db = conectarDB();
if(!$_GET['id']){
    header('Location:'.ruta().'/anuncios.php');
    return;
}
$idPropiedad = $_GET['id'];
$query = "SELECT * FROM propiedades WHERE id=".$idPropiedad;
$resultado = mysqli_query($db,$query);
$propiedad = mysqli_fetch_assoc($resultado);

?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo']?></h1>


        <img loading="lazy" alt="Imagen de la propiedad" src="<?php echo ruta()?>/public/images/<?php echo $propiedad['imagen']?>">
      

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio']?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']?></p>
                </li>
            </ul>

            <p><?php echo $propiedad['descripcion']?></p>
        </div>
    </main>

    <?php incluirTemplate('footer')?>

 
</body>
</html>