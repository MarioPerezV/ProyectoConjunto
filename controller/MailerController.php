<?php

class MailerController {

    public function enviarEmailEvaluacion() {
        // Ruta al autoload de Composer
        require_once __DIR__ . '/../vendor/autoload.php';

        // Corrección: Obtener el email del POST o definir uno por defecto para evitar error de variable indefinida
        $recipient_email = $_POST['email'] ?? null;

        if (!$recipient_email) {
            error_log('Error: No se proporcionó email para la evaluación.');
            return;
        }

        $subject = "Evaluación";
        $body = "";

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "mail.agenciagaby.com";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
			// Obtenemos las credenciales del entorno de forma segura.
            $mail->Username = $_ENV['SMTP_USER'] ?? 'hola@agenciagaby.com';
            $mail->Password = $_ENV['SMTP_PASSWORD'] ?? '';
            $mail->SetFrom("hola@agenciagaby.com", "Maquina Virtual SpA");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->addAddress($recipient_email);
            
            $mail->send();
            
            // --- INICIO: Código para anexar a la carpeta "Enviados" en IMAP ---
            $imapHost = "mail.agenciagaby.com";
            $imapUser = $_ENV['SMTP_USER'] ?? null;
            $imapPass = $_ENV['SMTP_PASSWORD'] ?? null;

            // Solo intentar la conexión IMAP si AMBAS credenciales están definidas en el .env
            if ($imapUser && $imapPass) {
                $imapConnectionPath = "{" . $imapHost . ":993/imap/ssl/novalidate-cert}";
                $imap_stream = @imap_open($imapConnectionPath, $imapUser, $imapPass);
                if ($imap_stream) {
                    $folderToAppend = $imapConnectionPath . "INBOX";
                    if (imap_append($imap_stream, $folderToAppend, $mail->getSentMIMEMessage(), "\\Seen")) {
                        // error_log('Correo de confirmación guardado en carpeta Enviados...');
                    } else {
                        error_log('Error IMAP (append): ' . imap_last_error());
                    }
                    imap_close($imap_stream);
                } else {
                    error_log('Error IMAP (open): ' . imap_last_error());
                }
            } else {
                error_log('Credenciales IMAP (SMTP_USER/SMTP_PASSWORD) no configuradas en .env. Omitiendo guardado en Enviados.');
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('PHPMailer Error: ' . $e->getMessage());
        }
    }
}