<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "sis_venta");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$descripcion = $_POST['descripcion'];

// Insertar los datos en la tabla "reclamos"
$query = "INSERT INTO reclamos (nombre, correo, telefono,fecha,descripcion) VALUES ('$nombre', '$correo', '$telefono',CURDATE(),'$descripcion')";

if (mysqli_query($conexion, $query)) {
    
    // Si se realizó la inserción correctamente, redirigir al usuario a una página de confirmación
    header("Location: reclamos.php");
} else {
    // Si hubo un error al insertar los datos, mostrar un mensaje de error
    echo "Error al agregar el registro: " . mysqli_error($conexion);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

?>
