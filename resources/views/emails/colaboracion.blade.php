<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nueva Colaboración – Terminal FECOSA</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">

        <!-- Header -->
        <tr>
          <td style="background:#262626;padding:28px 32px;border-bottom:4px solid #cc1e37;">
            <table width="100%">
              <tr>
                <td>
                  <div style="font-family:'Segoe UI',Arial,sans-serif;font-weight:800;font-size:20px;color:#fff;letter-spacing:0.5px;">
                    TERMINAL FECOSA
                  </div>
                  <div style="font-size:11px;color:#cc1e37;font-weight:700;text-transform:uppercase;letter-spacing:2px;margin-top:2px;">
                    ¡Como Alajuela se merece!
                  </div>
                </td>
                <td align="right">
                  <span style="background:#cc1e37;color:#fff;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;white-space:nowrap;">
                    🚌 Nueva Colaboración
                  </span>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td style="padding:32px;">

            <p style="margin:0 0 24px;font-size:15px;color:#444;line-height:1.6;">
              Un vecino de Alajuela envió información de horarios a través del formulario comunitario.
            </p>

            <!-- Ruta destacada -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
              <tr>
                <td style="background:#fdeaed;border-left:4px solid #cc1e37;border-radius:0 8px 8px 0;padding:16px 20px;">
                  <div style="font-size:11px;font-weight:700;color:#cc1e37;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Ruta indicada</div>
                  <div style="font-size:18px;font-weight:800;color:#262626;">{{ $datos['ruta'] }}</div>
                </td>
              </tr>
            </table>

            <!-- Detalles -->
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee;border-radius:10px;overflow:hidden;margin-bottom:20px;">
              @if(!empty($datos['nombre']))
              <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:12px 16px;background:#fafafa;font-size:12px;font-weight:700;color:#999;text-transform:uppercase;width:35%;letter-spacing:.5px;">Colaborador</td>
                <td style="padding:12px 16px;font-size:14px;color:#262626;font-weight:600;">{{ $datos['nombre'] }}</td>
              </tr>
              @endif

              @if(!empty($datos['correo']))
              <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:12px 16px;background:#fafafa;font-size:12px;font-weight:700;color:#999;text-transform:uppercase;width:35%;letter-spacing:.5px;">Correo</td>
                <td style="padding:12px 16px;font-size:14px;color:#262626;font-weight:600;">{{ $datos['correo'] }}</td>
              </tr>
              @endif


              <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:12px 16px;background:#fafafa;font-size:12px;font-weight:700;color:#999;text-transform:uppercase;letter-spacing:.5px;">Horarios</td>
                <td style="padding:12px 16px;font-size:14px;color:#262626;line-height:1.7;white-space:pre-line;">{{ $datos['horarios'] }}</td>
              </tr>
              @if(!empty($datos['comentario']))
              <tr>
                <td style="padding:12px 16px;background:#fafafa;font-size:12px;font-weight:700;color:#999;text-transform:uppercase;letter-spacing:.5px;">Comentario</td>
                <td style="padding:12px 16px;font-size:14px;color:#444;line-height:1.6;">{{ $datos['comentario'] }}</td>
              </tr>
              @endif
            </table>

            @if($adjuntoNombre)
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
              <tr>
                <td style="background:#eff6ff;border-radius:8px;padding:12px 16px;">
                  <span style="font-size:13px;color:#2563eb;font-weight:600;">
                    📎 Adjunto incluido: <strong>{{ $adjuntoNombre }}</strong>
                  </span>
                </td>
              </tr>
            </table>
            @endif

            <!-- CTA -->
            <div style="text-align:center;margin-top:28px;">
              <p style="font-size:13px;color:#999;margin:0;">
                Revisá esta información y agregala al sistema si es correcta.
              </p>
            </div>

          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="background:#f8f8f8;padding:20px 32px;border-top:1px solid #eee;">
            <p style="margin:0;font-size:11px;color:#aaa;line-height:1.6;text-align:center;">
              Este mensaje fue generado automáticamente desde el formulario comunitario de
              <strong style="color:#cc1e37;">terminalfecosa.com</strong><br>
              Este servicio es comunitario y no tiene relación oficial con la Municipalidad de Alajuela.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
