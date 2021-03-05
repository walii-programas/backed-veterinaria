<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmación de Correo Electrónico</title>

  <style>
    hr {
      margin-bottom: 0.5rem;
    }
    a {
      text-decoration: none;
      font-size: 1.3rem;
      font-weight: bold;
      color: #7D6B91;
    }
  </style>

</head>
<body>
  
  <div class="email-client-confirmation">
    <h1>Confirmación de Correo Electrónico</h1>
    <p>Saludos <b>{{ $dataClient['firstname'] }}</b>, se ha registrado este correo como un nuevo cliente para la <b>Veterinaria San Carlos</b></p>
    <hr>
    <p>Para que pueda continuar con el registro ingrese al siguiente enlace e ingrese su nueva contraseña</p>
    <a href="http://localhost:4201/restablecer-contrasena/{{ $dataClient['verification_token'] }}">Ir e ingresar mi contraseña</a>
  </div>

</body>
</html>