<?php

/**
 * Mailer
 */
require_once __DIR__ . '/../lib/phpmailer/src/Exception.php';
require_once __DIR__ . '/../lib/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../lib/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../lib/phpmailer/language/phpmailer.lang-fr.php';
require_once __DIR__ . '/../lib/config/parser.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Process
 */

$config = new ConfigLoader();

try {
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=mariage;charset=utf8', $config->getDatabaseConfig()["username"], $config->getDatabaseConfig()["password"]);
} catch (Exception $e) {
	// En cas d'erreur, on affiche un message et on arrête tout
	header("HTTP/1.0 400 Error " . $e->getMessage() . ": " . $e->getCode());
	throw new Exception($e->getMessage(), $e->getCode());
}

if (isset($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
	
	$query = 'INSERT INTO REPONSE_PRESENT (NOM, TELEPHONE, EMAIL, NB_PRESENTS, PRESENT_MAIRIE, PRESENT_EGLISE, PRESENT_REPAS) VALUES
             ("' . $data["nom"] . '", "' . $data["telephone"] . '", "' . $data["email"] . '", ' . $data["nombre"] . ', ' . (int)$data["presence"]["mairie"] . ',
             ' . (int)$data["presence"]["eglise"] . ', ' . (int)$data["presence"]["repas"] . ');';
	
	if (!$bdd->query($query)) {
		// En cas d'erreur, on affiche un message et on arrête tout
		header("HTTP/1.0 400 Error " . $bdd->errorInfo()[1] . ": " . $bdd->errorInfo()[2]);
		throw new Exception($bdd->errorInfo()[2], $bdd->errorInfo()[1]);
	} else {
		// Load Composer's autoloader
		// require 'vendor/autoload.php';
		
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
		
		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->setLanguage('fr', __DIR__ . '/../lib/phpmailer/language/phpmailer.lang-fr.php');
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host = $config->getMailerConfig()["server"];                         // Set the SMTP server to send through
			$mail->SMTPAuth = true;                                   // Enable SMTP authentication
			$mail->Username = $config->getMailerConfig()["username"];             // SMTP username
			$mail->Password = $config->getMailerConfig()["password"];                          // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
			$mail->CharSet = 'UTF-8';                                // Uses UTF-8 encoding format for the mail
			
			//Recipients
			$mail->setFrom($config->getMailerConfig()["from"]["address"], $config->getMailerConfig()["from"]["name"]);
			$mail->addAddress($data["email"], $data["nom"]);     // Add a recipient
			$mail->addReplyTo($config->getMailerConfig()["from"]["address"], $config->getMailerConfig()["from"]["name"]);
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');
			
			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			
			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = "Test mariage";
			
			// Présent à la mairie et/ou à l'église mais pas au repas
			if (($data["presence"]["mairie"] || $data["presence"]["eglise"]) && !$data["presence"]["repas"]) {
				ob_start();
				require __DIR__ . '/../assets/mariage/mail-ceremonies.php';
				$mail->Body = ob_get_contents();
				ob_end_clean();
			} // Présent à la mairie et/ou à l'église ET au repas
			elseif (($data["presence"]["mairie"] || $data["presence"]["eglise"]) && $data["presence"]["repas"]) {
				ob_start();
				require __DIR__ . '/../assets/mariage/mail-repas.php';
				$mail->Body = ob_get_contents();
				ob_end_clean();
			} else {
				header("HTTP/1.0 409 Error: Wrong conditions");
				throw new Exception("Wrong conditions", "409");
			}
			
			$mail->send();
		} catch (Exception $e) {
			header("HTTP/1.0 " . $e->getCode() . " Error: " . $e->getMessage());
			throw $e;
		}
	}
} else {
	header("HTTP/1.0 400 Error: Not correct");
	throw new Exception("Not correct", "400");
}