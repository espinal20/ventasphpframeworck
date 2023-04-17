<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "reclamos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reclamos</title>
	<style>
	h2 {
    font-size: 2rem;
    text-align: center;
    }
	form {
		width: 50%;
		margin: 0 auto;
		background-color: #f2f2f2;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0 0 10px rgba(0,0,0,0.3);
	}
	label {
		display: block;
		margin-bottom: 10px;
	}
	input[type="text"],
	input[type="email"],
	input[type="tel"],
	textarea {
		width: 100%;
		padding: 10px;
		margin-bottom: 20px;
		border-radius: 5px;
		border: none;
		box-shadow: 0 0 5px rgba(0,0,0,0.1);
	}
	input[type="submit"] {
		background-color: #4CAF50;
		color: white;
		padding: 10px 20px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}
	input[type="submit"]:hover {
		background-color: #3e8e41;
	}
</style>
<script>
		function validarFormulario() {
			var nombre = document.getElementById("nombre").value;
			var correo = document.getElementById("correo").value;
			var telefono = document.getElementById("telefono").value;
			var descripcion = document.getElementById("descripcion").value;

			if (nombre === '' || correo === '' || telefono === '' || descripcion === '') {
				alert("Por favor complete todos los campos del formulario.");
				return false;
			}

			return true;
		}

		function mostrarAlerta() {
			// Esta función se ejecutará después de enviar el formulario
			alert("¡Reclamo enviado exitosamente!");
		}
	</script>
</head>
<body>
	<form action="guardar_reclamo.php" method="POST" onsubmit="validarFormulario();mostrarAlerta();">
	<h2>Ingrese su reclamo</h2>
		<label for="nombre">Nombre:</label><br>
		<input type="text" id="nombre" name="nombre" required><br>

		<label for="correo">Correo electronico:</label><br>
		<input type="email" id="correo" name="correo" required><br>

		<label for="telefono">Telefono:</label><br>
		<input type="tel" id="telefono" name="telefono" required><br>

		<label for="descripcion">Descripcion:</label><br>
		<textarea id="descripcion" name="descripcion" required></textarea><br>

		<input type="submit" value="Enviar">
	</form>
</body>
</html>

