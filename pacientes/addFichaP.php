<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/pacienteModel.php');
    require('../class/telefonoModel.php');
    require('../class/reservaModel.php');

    $session = new Session;

    if (isset($_GET['paciente'])) {
        $id = (int) $_GET['paciente'];

        $pacientes = new PacienteModel;
        $telefono = new TelefonoModel;
        $reserva = new ReservaModel;

        $paciente = $pacientes->getPacienteId($id);
        $type = 'Paciente';

        $telefonos = $telefono->getTelefonoIdType($id, $type);
        $reservas = $reserva->getReservaPaciente($id);
       // $peso = trim(strip_tags($_POST['rut']));

        /*if (strlen($peso) == 0) {
            $msg = 'Ingrese el peso del paciente';
        }*/

    }

    //print_r($roles);exit;

    $title = 'Ficha Pacientes';

?>
<?php if(isset($_SESSION['autenticado'])): ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE . $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <!-- llamada a archivo de menu -->
        <?php include('../partials/menu.php'); ?>
    </header>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                        <h4><?php echo $title; ?> </h4>
                    <?php include('../partials/mensajes.php'); ?>
                    <?php if(!empty($paciente)): ?>
                    <table>
                        <tr>
                            <th>RUT:</th>
                            <td><?php echo $paciente['rut']; ?></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td><?php echo $paciente['nombre']; ?></td>
                        </tr>
                        <tr>
                            <th>Edad:</th>
                            <td><?php echo $paciente['edad']; ?> años</td>
                        </tr>
                    </table> 
                       <!-- <tr>
                            <th>Teléfonos:</th>
                            <td>
                                <?php if ($telefonos): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach($telefonos as $telefono): ?>
                                            <a href="<?php echo SHOW_TELEFONO . $telefono['id']; ?>" class="list-group-item list-group-item-action">+56 <?php echo $telefono['numero']; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p>Sin teléfono</p>
                                <?php endif; ?>
                            </td>
                        </tr>-->
                        <table class="table table-hover">
                    </table>
                    <div class="x-small">
                        <label for="rut" style=" font-size: 90%" class="form-label">Peso<span class="text-danger" style=" font-size: 30%">*</span>  </label>
                        <input type="text" name="rut" value="<?php if(isset($_POST['rut'])) echo $_POST['rut']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger" style=" font-size: 50%">Debe Ingresar Peso </div>
                    </div>
                    <div class="mb-3">
                        <label for="altura" style=" font-size: 90%"  class="form-label">Altura<span class="text-danger" style=" font-size: 30%" >*</span>  </label>
                        <input type="text" name="altura" value="<?php if(isset($_POST['altura'])) echo $_POST['altura']; ?>" class="form-control" aria-describedby="empleadoHelpInline">
                        <div id="empleadoHelp" class="form-text text-danger" style=" font-size: 35%">Debe Ingresar Altura </div>
                    </div>
                    <div>
                        <p>
                            <label for="w3review">Datos de la Consulta:</label>
                        </p>
                        <textarea id="w3review" name="w3review" rows="30" cols="120"></textarea>
                    </div>
                    <p>
                        <?php if($_SESSION['usuario_rol'] == 'Administrador'): ?>
                            <a href="<?php echo EDIT_PACIENTE . $id ?>" class="btn btn-outline-success">agregar</a>
                        <?php endif; ?>
                        
                        <a href="<?php echo SHOW_FICHASPACIEN . $id ?>" class="btn btn-outline-primary">Volver</a>
                    </p>
                    <?php else: ?>
                        <p class="text-info">No hay datos</p>
                    <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>