<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "reclamos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $id=$_POST["id"];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $alert = "";
    if (empty($id) || empty($nombre) || empty($correo) || empty($telefono) || empty($fecha) || empty($descripcion)) {
        $alert = '<div class="alert alert-danger" role="alert">
                    Todos los campos son obligatorios
                </div>';
    

    } else {
        $query = mysqli_query($conexion, "SELECT * FROM reclamos WHERE id = '$id'");
        $result = mysqli_fetch_array($query);
        if ($result != null) {
            $alert = '<div class="alert alert-warning" role="alert">
                        El código ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO reclamos(id, nombre, correo, telefono, fecha, descripcion) VALUES ('$id', '$nombre', '$correo', '$telefono', '$fecha', '$descripcion)");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                            Producto Registrado
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar el producto
                        </div>';
            }
        }
    }
}

?>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Telefeno</th>
                <th>Fecha</th>
                <th>Descripcion</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM reclamos");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['correo']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td><?php echo $data['descripcion']; ?></td>
                        
                    </tr>
            <?php }
            } ?>
        </tbody>

    </table>
</div>


<?php include_once "includes/footer.php"; ?>