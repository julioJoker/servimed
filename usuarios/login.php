<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/usuarioModel.php');

    $session = new Session;
    $usuarios = new UsuarioModel;

    $title = 'Login';

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $clave = trim(strip_tags($_POST['clave']));

        if (!$email) {
           $msg = 'Ingrese un email válido';
        }elseif (!$clave) {
            $msg = 'Ingrese su password';
        }else {
            $usuario = $usuarios->getUsuarioEmailClave($email, $clave);

            if (!$usuario) {
                $msg = 'El email o la clave no están registrados';
            }else {
                $id_usuario = $usuario['id'];
                $id_empleado = $usuario['empleado_id'];
                $nom_usuario = $usuario['empleado'];
                $rol = $usuario['rol'];
                $session->login($id_usuario, $id_empleado, $nom_usuario, $rol);
                header('Location: ' . BASE_URL);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE . $title ?></title>
    <link href="../bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap.bundle.min.js" rel="stylesheet" type="text/css">
    <script src="../js/funciones.js"></script>
</head>
<style>
      html {
        background-color: #6782B8;
      }

      body {
        font-family: "Poppins", sans-serif;
        height: 10vh;
        background-color: #6782B8;
      }

      a {
        color: #92badd;
        display:inline-block;
        text-decoration: none;
        font-weight: 400;
      }

      h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display:inline-block;
        margin: 40px 8px 10px 8px; 
        color: #cccccc;
      }



      /* STRUCTURE */

      .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column; 
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 10px;
      }

      #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #3D475B;
        padding: 70px;
        width: 90%;
        max-width: 750px;
        position: relative;
        padding: 40px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        text-align: center;
      }

      #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
      }



      /* TABS */

      h2.inactive {
        color: #cccccc;
      }

      h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #5fbae9;
      }



      /* FORM TYPOGRAPHY*/

      input[type=button], input[type=submit], input[type=reset]  {
        background-color: #6782B8;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 10px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        box-shadow: 0 10px 300px 0 rgba(95,186,233,0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: 50px 20px 40px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
      }

      input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
        background-color: #2A83B1;
      }

      input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
      }

      input[type=text] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        padding: 1px 3px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 11px;
        width: 65%;
        border: 2px solid #f6f6f6;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
      }

      input[type=text]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
      }

      input[type=text]:placeholder {
        color: #cccccc;
      }


      input[type=password] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        padding: 1px 3px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 50px;
        width: 65%;
        border: 2px solid #f6f6f6;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
      }

      input[type=password]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
      }

      input[type=password]:placeholder {
        color: #cccccc;
      }


      .letter {
        font-family: "Lucida Console", "Courier New", monospace;
        background-color: #3D475B;
        color: #858585;
      }



      * {
        box-sizing: border-box;
      }
  </style>
<body style="aling-items: center" >
    <header>
        <!-- llamada a archivo de menu -->
        <?php /*include('../partials/menu.php');*/ ?>
    </header>
    <div>
        <div >
           <h4><?php /*echo $title; */?></h4>
            <!-- <p class="text-danger">Campos obligatorios *</p>-->
            <?php if(isset($msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>
        <div>
        <img src="../img/logoCentoMedico.png" width="10%"  height="10%" style="margin:10px;" >
    </div>  
    <div class="wrapper fadeInDown" >
        <div id="formContent"  >
            <h1  class="letter">Servi-MED</h1>
            <p class="inactive underlineHover"></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <input type="text" name="email" class="fadeIn second" placeholder="Usuario" >
                </div>    
                <div >
                  <input type="password" name="clave" class="fadeIn third" placeholder="contraseña">
                </div>
                <div class="form-group">
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-outline-success">Ingresar</button>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-primary">Cancelar</a>
                </div>
                </form>
        </div> 
    </div> 
    
</body>
</html>
