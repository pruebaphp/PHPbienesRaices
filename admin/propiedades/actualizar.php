<?php 
$inicio = false;
require '../../includes/config/database.php';
$db = conectarDB();
require '../../includes/templates/header.php';

    // echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";

    //Obtener los vendedores
    $query_vendedores = 'SELECT * FROM vendedores';

    $resultado_vendedores = mysqli_query($db,$query_vendedores);
    

    //obtener los datos de la propiedad segun su id
    if(!$_GET['id']){
        header('Location:'.ruta().'/admin');
        return;
    }
    //obteniendo el id de la propiedad
    $idPropiedad = intval($_GET['id']);



    //validando que sea un numero el id

    if(!filter_var($idPropiedad,FILTER_VALIDATE_INT)){
        header('Location:'.ruta().'/admin');
        return;
    }

    $query_propiedad = 'SELECT * FROM propiedades WHERE id='.$idPropiedad;

    $resultado_propiedad = mysqli_query($db,$query_propiedad);

    $propiedad = mysqli_fetch_assoc($resultado_propiedad);

    
    echo "<pre>";
    print_r(mysqli_fetch_assoc($resultado_propiedad));
    echo "</pre>";

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];

    $errores = [];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";


        $titulo = mysqli_real_escape_string($db,$_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db,$_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db,$_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db,$_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db,$_POST['estacionamiento']);
        $creado = date('Y/m/d');
        $vendedorId = mysqli_real_escape_string($db,$_POST['vendedor']);

        //asignar files a una variable

        $imagen = $_FILES['imagen'];


        if(!$titulo){
            array_push($errores,'El título es obligatorio');
        }

        if(!$precio){
            array_push($errores,'El precio es obligatorio');
        }

        //validar por tamaño (100 Kb máximo)
        if($imagen['name']){
        if($imagen['size']>1000000){
            array_push($errores,'El tamaño de imagen debe ser máximo de 1000 kb');
        }
        }



        if(strlen($descripcion)<1 ){
            array_push($errores,'La descripción es obligatoria y debe tener almenos 50 caracteres');
        }

        if(!$habitaciones){
            array_push($errores,'El número de baños es obligatorio');
        }

        if(!$estacionamiento){
            array_push($errores,'El número de estacionamiento es obligatorio');
        }

        if(!$vendedorId){
            array_push($errores,'Seleccione un vendedor');
        }



        // echo "<pre>";
        // print_r($errores);
        // echo "</pre>";

        //return;
        //Revisar que el arreglo de errores esté vacio

        if(empty($errores)){

            //SUBIDA DE ARCHIVOS
            //$carpetaImagenes = ruta().'/imagenes/';
            if($imagen['name']){
            $carpetaImagenes = '../../public/images';

            echo ruta().'/imagenes';
            
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes, 0777, true);
            }

            //Generar un nombre unico

            $nombreImagen = md5(uniqid(rand(),true)).".jpg";
            //Eliminar imagen anterior
            unlink($carpetaImagenes.'/'.$imagenPropiedad);

            //Subir imagen
            move_uploaded_file($imagen['tmp_name'],$carpetaImagenes."/".$nombreImagen);
        }else{
            $nombreImagen = $imagenPropiedad;
        }

        //Insertar en la base de datos

        $query = "UPDATE propiedades SET titulo='$titulo',precio='$precio',imagen='$nombreImagen',descripcion='$descripcion',habitaciones='$habitaciones',wc='$wc',estacionamiento='$estacionamiento',creado='$creado',vendedores_id='$vendedorId' WHERE id='$idPropiedad'";

        echo $query;

        $resultado = mysqli_query($db,$query);

        if($resultado){
          header('Location:'.ruta().'/admin?resultado=2');
        }
        }





    }

?>

    <main class="contenedor seccion">
    <h1>Actualizar</h1>
    <a href="../../../bienesRaicesPHP/admin/" class="boton boton-verde">Volver</a>
        <!-- <p><?php echo ruta().'/admin/propiedades/crear.php'?></p> -->
        <?php foreach($errores as $error){ ?>
            <div class="alerta error">
                <?= $error ?>
            </div>
        <?php } ?>
        <form action="<?= ruta() ?>/admin/propiedades/actualizar.php?id=<?php echo $idPropiedad?>" class="formulario" id="formCrearPropiedad" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información general</legend>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la propiedad" value="<?php echo $titulo?>">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad"  value="<?php echo $precio?>">
                <label for="imagen">Precio:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
                <img src="<?php echo ruta();?>/public/images/<?php echo $imagenPropiedad?>" class="imagen-small" alt="Imagen de propiedad">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" cols="30" rows="10"><?php echo $descripcion?></textarea>
                
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ingrese el número de habitaciones" min="1" max="9"  value="<?php echo $habitaciones?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ingrese el número de baños" min="1" max="9" value="<?php echo $wc?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ingrese el número de estacionamientos" min="1" max="9"  value="<?php echo $estacionamiento?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select id="vendedor" name="vendedor" >
                    <option value="0" selected='true'>-- Seleccione un vendedor --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado_vendedores)){?>
                    <option value="<?php echo $vendedor['id'] ?>" <?php echo $vendedorId === $vendedor['id'] ? 'selected' : '' ?>><?php echo $vendedor['nombre']?></option>
                    <?php }?>
                </select>
            </fieldset>

            <input type="submit" id="btnCrearPropiedad" value="Actualizar propiedad" class="boton boton-verde">


        </form>
    </main>

    <?php require '../../includes/templates/footer.php';?>

    
</body>
</html>