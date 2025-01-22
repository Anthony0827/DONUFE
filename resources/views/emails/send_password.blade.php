
<!DOCTYPE html>
<html>
<head>
    <title>Registro Completado</title>
    <style>
        /* Estilos en línea para el correo electrónico */
        body {
            font-family: Arial, sans-serif;
            background-color: #a51641;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #a51641;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px 20px;
        }
        .header h1 {
            color: #a51641;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .body {
            padding: 10px 20px;
        }
        .body p {
            color: #555555;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            margin-bottom: 15px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #eeeeee;
        }
        .footer p {
            color: #aaaaaa;
            font-size: 12px;
            margin: 0;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Bienvenido</h1>
            </div>
            <div class="body">
                <p>Hola {{ $email }},</p>
                <p>Tu contraseña de acceso es: <span class="font-bold">{{ $clave }}</span></p>

<p>Por favor, cambia tu contraseña después de iniciar sesión.</p>
<p>Para iniciar sesión, haz clic en el siguiente enlace:</p>
<p style="color: #007BFF; font-size: 14px; word-break: break-word; text-align: center; margin: 0; margin-bottom: 10px;">
    <a href="{{ url('/usuarios/login') }}" target="_blank" style="color: #007BFF; text-decoration: none;">
        {{ url('/usuarios/login') }}
    </a>
</p>
          </div>
            <div class="footer">
                <p>©2024 Kulture</p>
                <p>¿Alguna pregunta? Contáctanos a 
                    <a href="mailto:hola@kultureagility.com">hola@kultureagility.com</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

