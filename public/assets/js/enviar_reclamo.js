
$(document).ready(function() {
	$('#formulario_reclamo').submit(function(e) {
		e.preventDefault(); // Evita que el formulario se envíe automáticamente
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: $(this).serialize(),
			success: function(response) {
				// Muestra una alerta si el formulario se envió correctamente
				alert('¡Su reclamo ha sido enviado correctamente!');

				// Limpia todos los campos del formulario
				$('input[type="text"], input[type="email"], input[type="tel"], textarea').val('');
			}
		});
	});
});
