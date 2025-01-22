<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #a51641; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0; background-color: #a51641;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin: 20px; padding: 20px;">
                    <tr>
                        <td align="center" style="padding: 10px 20px;">
                            <h1 style="color: #a51641; font-size: 24px; font-weight: bold; margin-bottom: 10px;">Restablecimiento de contraseña</h1>
                            <p style="color: #555555; font-size: 16px; margin: 0; margin-bottom: 5px;">Hola <strong>En</strong>,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 20px;">
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; margin: 0; margin-bottom: 15px;">
                                Se te envía este e-mail en respuesta a tu solicitud de resetear la contraseña.
                            </p>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; margin: 0; margin-bottom: 20px;">
                                Para cambiar tu contraseña haz clic en el siguiente enlace, el cual será válido por 24 horas:
                            </p>
                            <div style="text-align: center; margin: 20px 0;">
                                <a href="{{ route('empresas.password.reset', $token) }}" 
                                   style="background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block; font-size: 16px; font-weight: bold;">
                                    Cambiar la contraseña
                                </a>
                            </div>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5; text-align: center; margin: 0; margin-bottom: 10px;">
                                Si el botón no funciona, copia y pega este enlace en tu navegador:
                            </p>
                            <p style="color: #007BFF; font-size: 14px; word-break: break-word; text-align: center; margin: 0; margin-bottom: 10px;">
                                <a href="{{ route('empresas.password.reset', $token) }}" target="_blank" style="color: #007BFF; text-decoration: none;">
                                    {{ route('empresas.password.reset', $token) }}
                                </a>
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
