<?php 
//obtener la instancia db
include 'includes/config/database.php';
$db = conectarDB();

$errores = [];

$email = '';
$password = '';

//Autenticar el usuario
if($_SERVER['REQUEST_METHOD']==='POST'){
    //obtener los valores
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!$email){
        array_push($errores,'Primero ingrese un email');
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        array_push($errores,'Ingrese un email válido');
    }
    if(!$password){
        array_push($errores,'El password es obligatorio');
    }

    if(empty($errores)){
        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email='$email'";
        $resultado = mysqli_query($db,$query);
        $usuario = mysqli_fetch_assoc($resultado);
        echo "<pre>";
        print_r(mysqli_fetch_assoc($resultado));
        echo "</pre>";
        if($resultado->num_rows){
            $validacionPassword = password_verify($password,$usuario['password']);
            //var_dump($validacionPassword);
            if(!$validacionPassword){
                array_push($errores,'Usuario o contraseña incorrectos');
            }else{
                session_start();

                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                

                // echo "<pre>";
                // print_r($_SESSION);
                // echo "</pre>";
                
                header('Location:'.ruta().'/admin');
            }
        }else{
            array_push($errores,'Usuario o contraseña incorrectos');
        }
       
        //$passwordHasheado = password_verify($password,mysqli_fetch_assoc($resultado)['password']);
        //array_push($errores,'Usuario o contraseña incorrectos');
        //echo $passwordHasheado;

    }





}


//incluye el header
require './includes/funciones.php';
incluirTemplate('header'); 
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>
        <?php foreach ($errores as $error) {?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
            <?php } ?>
        <form action="" method="POST" class="formulario" novalidate>
        <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" name="email" id="email" value="<?php echo $email?>">

                <label for="email">Password</label>
                <input type="password" placeholder="Tu password" name="password" id="password" value="<?php echo $password?>">

                <input type="submit" class="boton boton-verde" value="Iniciar sesión">
            </fieldset>
        </form>
    </main>

    <?php incluirTemplate('footer')?>

 
</body>
</html>