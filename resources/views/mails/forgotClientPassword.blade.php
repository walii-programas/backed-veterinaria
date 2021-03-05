<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitud de Cambio de Contraseña</title>
</head>
<body>
  
  <div class="email-client-confirmation">
    <h1>Solicitud de cambio de contraseña</h1>
    <p>Se ha solicitado un restablecimiento de contraseña</p>
    <hr>
    <p>Para que pueda continuar con el restablecimiento ingrese al siguiente enlace e ingrese su nueva contraseña</p>
    <a href="http://localhost:4201/restablecer-contrasena/{{ $dataClient['verification_token'] }}">Ir y cambiar mi contraseña</a>
  </div>

</body>
</html>