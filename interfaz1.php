<?php
include "conexion.php";

// Si se han enviado datos a través del formulario, procesarlos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = $_POST['nombre'] ?? null;
    $apellidos = $_POST['apellido'] ?? null;
    $edad = $_POST['edad'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $encargado = $_POST['ne'] ?? null;
    $tel_encargado = $_POST['numero'] ?? null;

    if ($nombres && $apellidos && $edad && $direccion && $encargado && $tel_encargado) {
        // Preparar y vincular
        $stmt = $conn->prepare("INSERT INTO ur (nombres, apellidos, edad, direccion, encargado, tel_encargado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombres, $apellidos, $edad, $direccion, $encargado, $tel_encargado);

        // Ejecutar
        if ($stmt->execute()) {
            // Redirigir a listar.php después de un registro exitoso
            header('Location: listar.php');
            exit(); // Asegurarse de que el script se detenga después de la redirección
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }
}

// Mostrar los registros
$sql = $conn->query("SELECT * FROM ur");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>6to Compu</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Real</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Gustavo</a>
                </div>
            </div>
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                        
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="registro.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../../index2.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <center> <h1>Registros de los Estudiantes</h1></center>
                       
                    </div>
                </div>
            </div>
        
        <a href="index.html" class="btn btn-block btn-outline-primary">Deseas Registrar un Nuevo Usuario?</a>    
        <section class="content">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Encargado</th>
                            <th scope="col">Tel de Encargado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($dat = $sql->fetch_object()): ?>
                            <tr>
                                <td><?php echo $dat->id; ?></td>
                                <td><?php echo $dat->nombres; ?></td>
                                <td><?php echo $dat->apellidos; ?></td>
                                <td><?php echo $dat->edad; ?></td>
                                <td><?php echo $dat->direccion; ?></td>
                                <td><?php echo $dat->encargado; ?></td>
                                <td><?php echo $dat->tel_encargado; ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-warning"><i class="fas fa-wrench"></i></a>
                                    <a href="eliminar.php?id=<?php echo $dat->id; ?>" class="btn btn-small btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>

<?php $conn->close(); ?>
