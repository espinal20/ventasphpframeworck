<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "almacen";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['num_lote']) || empty($_POST['fecha_caducidad']) || empty($_POST['ubicacion'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $codproducto = $_GET['id'];
    $codigo = $_POST['num_lote'];
    $producto = $_POST['fecha_caducidad'];
    $precio = $_POST['ubicacion'];
    $query_update = mysqli_query($conexion,"UPDATE almacen SET num_lote='$codigo' , fecha_caducidad='$producto' , ubicacion='$precio' WHERE id = '$codproducto';");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Producto Modificado
            </div>';
    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
  }
}

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: almacen.php");
} else {
  $id_producto = $_REQUEST['id'];
  if (!is_numeric($id_producto)) {
    header("Location: almacen.php");
  }
  $query_producto = mysqli_query($conexion, "SELECT * FROM almacen WHERE id = $id_producto");
  $result_producto = mysqli_num_rows($query_producto);

  if ($result_producto > 0) {
    $data_producto = mysqli_fetch_assoc($query_producto);
  } else {
    header("Location: almacen.php");
  }
}
?>
<div class="row">
  <div class="col-lg-6 m-auto">

    <div class="card">
      <div class="card-header bg-primary text-white">
        Modificar Almacen
      </div>
      <div class="card-body">
        <form action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <label for="num_lote">Numero de Lote</label>
            <input type="text" placeholder="Ingrese código de barras" name="num_lote" id="num_lote" class="form-control" value="<?php echo $data_producto['num_lote']; ?>">
          </div>
          <div class="form-group">
            <label for="fecha_caducidad">Fecha Caducidad</label>
            <input type="date" class="form-control" placeholder="Ingrese nombre del producto" name="fecha_caducidad" id="fecha_caducidad" value="<?php echo $data_producto['fecha_caducidad']; ?>">
            

          </div>
          <div class="form-group">
            <label for="ubicacion">Ubicacion</label>
            <input type="text" placeholder="Ingrese precio" class="form-control" name="ubicacion" id="ubicacion" value="<?php echo $data_producto['ubicacion']; ?>">

          </div>
          <input type="submit" value="Actualizar Almacen" class="btn btn-primary">
          <a href="almacen.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>