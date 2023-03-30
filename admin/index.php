<?php 

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

session_start();

require '../includes/config/database.php';
require '../includes/funciones.php';
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// $auth = $_SESSION['login'];
// if(!$auth){
//     header('Location:'.ruta());
// }
protegerRuta();

$inicio = false;
require '../includes/templates/header.php';




$resultado = $_GET['resultado'] ?? null;

//obtener propiedades
$db = conectarDB();
$sql = 'SELECT * FROM propiedades';

$resultado_query = mysqli_query($db,$sql);

//eliminar el usuario

if($_SERVER['REQUEST_METHOD']==='POST'){
    $idPropiedad = $_POST['id'];
    $idPropiedad = filter_var($idPropiedad,FILTER_VALIDATE_INT);

    if($idPropiedad){
        //Eliminar su imagen
        $query = "SELECT * FROM propiedades WHERE id=".$idPropiedad;
        $resultado = mysqli_query($db,$query);
        $propiedad = mysqli_fetch_assoc($resultado);
        $imagenPropiedad = $propiedad['imagen'];

        //Eliminar propiedad
        $query = "DELETE FROM propiedades WHERE id=".$idPropiedad;
        echo $query;
        $resultado = mysqli_query($db,$query);
        if($resultado){
            unlink(dirname(__FILE__,2).'/public/images/'.$imagenPropiedad);
            header('Location:'.ruta().'/admin?resultado=3');
        }
    }

}


?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if($resultado==1){ ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php }else if($resultado==2){ ?>
            <p class="alerta exito">Anuncio actualizado correctamente</p>
            <?php }else if($resultado==3){ ?>
                <p class="alerta exito">Anuncio eliminado correctamente</p>
            <?php } ?>
        <a href="../../bienesRaicesPHP/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while($propiedad = mysqli_fetch_assoc($resultado_query)){?>
                <tr>
                    <td><?php echo $propiedad['id'] ?></td>
                    <td><?php echo $propiedad['titulo']?></td>
                    <td><img src="<?php echo ruta()?>/public/images/<?php echo $propiedad['imagen']?>" alt="Imagen de propiedad" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad['precio']?></td>
                    <td>
                        <form method="POST" class="w-100">
                        <input type="hidden" name="id" id="id" value="<?php echo $propiedad['id']?>">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>

                        <a href="<?php echo ruta()?>/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']?>"; class="boton-amarillo-block">Actualizar</a>
                        
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <?php require '../includes/templates/footer.php';?>

    
</body>
</html>