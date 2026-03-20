<?php

class MailerController {

    public function enviarEmailEvaluacion() {
        // Ruta al autoload de Composer
        require_once __DIR__ . '/../vendor/autoload.php';

        // Obtener datos del POST
        $recipient_email = $_POST['email'] ?? null;
        $report_html = $_POST['report_html'] ?? null;
        $subject = $_POST['subject'] ?? "Informe de Necesidades - Maquina Virtual SPA";

        if (!$recipient_email || !$report_html) {
            http_response_code(400);
            echo json_encode(['error' => 'Email y contenido del reporte son requeridos.']);
            return;
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "mail.agenciagaby.com";
            $mail->Port = 587; // Cambiado a 587 que es común para TLS (antes era 465)
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            // Obtenemos las credenciales del entorno de forma segura. 

            $mail->Username = $_ENV['SMTP_USER'] ?? 'hola@agenciagaby.com';
            $mail->Password = $_ENV['SMTP_PASSWORD'] ?? '';
            $mail->SetFrom("hola@agenciagaby.com", "Maquina Virtual SpA");
            $mail->Subject = $subject;
            
            // Estilo básico para el email
            $email_body = "
                <html>
                <head>
                    <style>
                        body { font-family: sans-serif; color: #333; }
                        .header { background: #101e22; padding: 20px; text-align: center; color: #fff; }
                        .content { padding: 20px; }
                        .footer { font-size: 12px; color: #777; padding: 20px; border-top: 1px solid #eee; }
                    </style>
                </head>
                <body>
                    <div class='header'>
                        <h1>Maquina Virtual SpA</h1>
                    </div>
                    <div class='content'>
                        $report_html
                    </div>
                    <div class='footer'>
                        Este informe fue generado automáticamente por el Consultor IA de Maquina Virtual SPA.
                    </div>
                </body>
                </html>
            ";
            
            $mail->Body = $email_body;
            $mail->addAddress($recipient_email);
            
            if ($mail->send()) {
                echo json_encode(['success' => true, 'message' => 'Correo enviado correctamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo enviar el correo: ' . $mail->ErrorInfo]);
            }
            
            // --- INICIO: Código para anexar a la carpeta "Enviados" en IMAP ---
            $imapHost = "mail.agenciagaby.com";
            $imapUser = $_ENV['SMTP_USER'] ?? null;
            $imapPass = $_ENV['SMTP_PASSWORD'] ?? null;

            if ($imapUser && $imapPass) {
                $imapConnectionPath = "{" . $imapHost . ":993/imap/ssl/novalidate-cert}";
                $imap_stream = @imap_open($imapConnectionPath, $imapUser, $imapPass);
                if ($imap_stream) {
                    $folderToAppend = $imapConnectionPath . "INBOX";
                    imap_append($imap_stream, $folderToAppend, $mail->getSentMIMEMessage(), "\\Seen");
                    imap_close($imap_stream);
                }
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('PHPMailer Error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error de servidor al enviar el correo.']);
        }
    }
}