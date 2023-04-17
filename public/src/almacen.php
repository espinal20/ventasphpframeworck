<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "almacen";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (isset($_POST['codproducto'])) {
    $codproducto = $_POST['codproducto'];
    $num_lote = $_POST['num_lote'];
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $ubicacion = $_POST['ubicacion'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = $_SESSION['idUser'];
    $alert = "";
    if (empty($codproducto) || empty($num_lote) || empty($fecha_caducidad) || empty($ubicacion) || empty($cantidad) || $cantidad < 0) {
        $alert = '<div class="alert alert-danger" role="alert">
            Todos los campos son obligatorios
        </div>';
        
    } else {
        $query = mysqli_query($conexion, "SELECT * FROM almacen WHERE codproducto = '$codproducto'");
        $result = mysqli_num_rows($query);
        if (mysqli_num_rows($query) > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                El código ya existe
            </div>';
        } else {
			
            $query_insert = mysqli_query($conexion,"INSERT INTO almacen (codproducto, num_lote, fecha_caducidad, ubicacion, cantidad, usuario_id) VALUES ('$codproducto', '$num_lote', '$fecha_caducidad', '$ubicacion', '$cantidad', '$usuario_id')");

            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                    Almacen Registrado
                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar el almacen
                </div>';
            }
        }
    }
}

    ?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_almacen"><i class="fas fa-plus"></i></button>
 <?php echo isset($alert) ? $alert : ''; ?>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
         <thead class="thead-dark">
             <tr>
                 <th>CodigoProducto</th>
                 <th>Num Lote</th>
                 <th>Fecha Caducidad</th>
                 <th>Almacen</th> 
                 <th>Cantidad</th>
                 <th>Estado</th>
                 <th></th> 
             </tr>
         </thead>
         <tbody>
             <?php
                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM almacen");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        if ($data['estado'] == 1) {
                            $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                        } else {
                            $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                        }
                ?>
                     <tr>
                         <td><?php echo $data['codproducto']; ?></td>
                         <td><?php echo $data['num_lote']; ?></td>
                         <td><?php echo $data['fecha_caducidad']; ?></td>
                         <td><?php echo $data['ubicacion']; ?></td>
                         <td><?php echo $data['cantidad']; ?></td>
                         <td><?php echo $estado; ?></td>
                         <td>
                         <?php if ($data['estado'] == 1) { ?>
                                 <a href="editar_almacen.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

                                 <form action="eliminar_almacen.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                     <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                 </form>
                             <?php } ?>
                         </td>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>
 <div id="nuevo_almacen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h5 class="modal-title" id="my-modal-title">Nuevo</h5>
                 <button class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             
             <div class="modal-body">
                 <form action="" method="post" autocomplete="off">
                     <?php echo isset($alert) ? $alert : ''; ?>
                     <div class="form-group">
                         <label for="codproducto">Código de Producto</label>
                         <input type="text" placeholder="Ingrese código de barras" name="codproducto" id="codproducto" class="form-control">
                     </div>

                     <div class="form-group">
                         <label for="num_lote">Num Lote</label>
                         <input type="text" placeholder="Ingrese num lote" name="num_lote" id="num_lote" class="form-control">
                     </div>
                     <div class="form-group">
                         <label for="fecha_caducidad">Fecha Caducidad</label>
                         <input type="date" placeholder="Ingrese fecha de caducidad" class="form-control" name="fecha_caducidad" id="fecha_caducidad">
                     </div>
                     <div class="form-group">
                         <label for="ubicacion">Almacen</label>
                         <input type="text" placeholder="Ingresa almacen" class="form-control" name="ubicacion" id="ubicacion">
                     </div>
                     <div class="form-group">
                         <label for="cantidad">Cantidad</label>
                         <input type="number" placeholder="Ingresa almacen" class="form-control" name="cantidad" id="cantidad">
                     </div>
                     <input type="submit" value="Guardar Almacen" class="btn btn-primary">
                 </form>
             </div>
         </div>
     </div>
 </div>

 <?php include_once "includes/footer.php"; ?>
