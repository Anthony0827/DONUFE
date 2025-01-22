<!DOCTYPE html>
<html>
<head>
    <title>Registro Exitoso</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #a51641; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0; background-color: #a51641;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin: 20px; padding: 20px;">
                    <tr>
                        <td align="center" style="padding: 10px 20px;">
                            <h1 style="color: #a51641; font-size: 24px; font-weight: bold; margin-bottom: 10px;">Registro Exitoso</h1>
                            <p style="color: #555555; font-size: 16px; margin: 0; margin-bottom: 5px;">Hola <strong>{{ $data['nombreEmpresa'] }}</strong>,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 20px;">
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; margin: 0; margin-bottom: 15px;">
                                Gracias por registrarte en Kulture. Estos son los datos de tu registro:
                            </p>
                            <ul style="color: #555555; font-size: 16px; line-height: 1.5; margin: 0; margin-bottom: 20px; padding-left: 20px;">
                                <li><strong>
                            Razón Social / Nombre:</strong> {{ $data['nombreEmpresa'] }}</li>
                                <li><strong>Teléfono:</strong> {{ $data['telefono'] }}</li>
                                <li><strong>CIF:</strong> {{ $data['cif'] }}</li>
                                <li><strong>Email:</strong> {{ $data['email'] }}</li>
                                <li><strong>Tipo de Empresa:</strong> {{ $data['tipoEmpresa'] }}</li>
                            </ul>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; margin: 0; margin-bottom: 20px;">
                                Si tienes alguna consulta, no dudes en contactarnos.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding: 20px; border-top: 1px solid #eeeeee;">
                            <p style="color: #aaaaaa; font-size: 12px; margin: 0;">©2024 Kulture</p>
                            <p style="color: #aaaaaa; font-size: 12px; margin: 0;">
                                ¿Alguna pregunta? Contáctanos a 
                                <a href="mailto:hola@kultureagility.com" style="color: #007BFF; text-decoration: none;">hola@kultureagility.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
