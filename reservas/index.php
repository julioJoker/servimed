<?php
    #instrucciones que nos permiten ver errores en tiempos de ejecucion
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    #llamada al archivo que contiene las rutas del sistema
    require('../class/rutas.php');
    require('../class/config.php');
    require('../class/session.php');
    require('../class/reservaModel.php');

    $session = new Session;
    $reserva = new ReservaModel;
    $reservas = $reserva->getReservas();

    //print_r($roles);exit;

    $title = 'Reservas';

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
        <div class="col-md-6 offset-md-3">
            <h4><?php echo $title; ?> <a href="<?php echo ADD_PACIENTE; ?>" class="btn btn-outline-success btn-sm">Nuevo Paciente</a> </h4>

            <?php include('../partials/mensajes.php'); ?>

            <?php if(!empty($reservas)): ?>
                <table class="table table-hover">
                    <tr>
                        <th>Fecha de Creación</th>
                        <th>Profecional</th>
                        <th>Especialidad</th>
                        <th>Fecha de Reserva</th>
                        <th>Horario</th>
                    </tr>
                    <?php foreach($reservas as $reserva): ?>
                        <tr>
                            <td>
                                <a href="<?php echo SHOW_RESERVA . $reserva['id']; ?>">
                                    <?php
                                        $fecha_creacion = new DateTime($reserva['created_at']);
                                        echo $fecha_creacion->format('d-m-Y H:i:s');
                                    ?>
                                </a>

                            </td>
                            <td>
                                <?php echo $reserva['nombreProfecional']; ?>
                            </td>
                            <td>
                                <?php echo $reserva['especialidad']; ?>
                            </td>
                            <td>
                                <?php
                                    $fecha_reserva = new DateTime($reserva['fecha']);
                                    echo $fecha_reserva->format('d-m-Y');
                                ?>
                            </td>
                            <td>
                                <?php echo $reserva['horario']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="text-info">No hay reservas registradas</p>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
<?php else: ?>
    <?php
        header('Location: ' . LOGIN);
    ?>
<?php endif; ?>