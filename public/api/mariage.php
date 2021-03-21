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

switch ($_POST["action"]) {
    case "present":
        reponsePresent($bdd, $config, $_POST['data']);
        break;
    case "getgifts":
        getGifts($bdd);
        break;
    case "reservegift":
        reserveGift($bdd, $_POST["data"]);
        break;
    case "participategift":
        participateToGift($bdd, $_POST["data"]);
        break;
    default:
        header("HTTP/1.0 400 Error: Not correct");
        throw new Exception("Not correct", "400");
}

function reponsePresent($dataBase, $configManager, $postedData)
{
    if (isset($postedData)) {
        $data = json_decode($postedData, true);

        if (!$data["presence"]["mairie"] && !$data["presence"]["eglise"] && !$data["presence"]["repas"]) {
            header("HTTP/1.0 409 Error: Wrong conditions");
            throw new Exception("Wrong conditions", "409");
        }

        $query = 'INSERT INTO reponse_present (NOM, TELEPHONE, EMAIL, NB_PRESENTS, PRESENT_MAIRIE, PRESENT_EGLISE, PRESENT_REPAS) VALUES
             ("' . $data["nom"] . '", "' . $data["telephone"] . '", "' . $data["email"] . '", ' . $data["nombre"] . ', ' . (int)$data["presence"]["mairie"] . ',
             ' . (int)$data["presence"]["eglise"] . ', ' . (int)$data["presence"]["repas"] . ');';

        try {
            $dataBase->query($query);
        } catch (\Exception $exception) {
            header("HTTP/1.0 400 Error " . $dataBase->errorInfo()[1] . ": " . $dataBase->errorInfo()[2]);
            throw new Exception($dataBase->errorInfo()[2], $dataBase->errorInfo()[1]);
        }
        // Load Composer's autoloader
        // require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->setLanguage('fr', __DIR__ . '/../lib/phpmailer/language/phpmailer.lang-fr.php');
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = $configManager->getMailerConfig()["server"];                         // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = $configManager->getMailerConfig()["username"];             // SMTP username
            $mail->Password = $configManager->getMailerConfig()["password"];                          // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet = 'UTF-8';                                // Uses UTF-8 encoding format for the mail

            //Recipients
            $mail->setFrom($configManager->getMailerConfig()["from"]["address"], $configManager->getMailerConfig()["from"]["name"]);
            $mail->addAddress($data["email"], $data["nom"]);     // Add a recipient
            $mail->addReplyTo($configManager->getMailerConfig()["from"]["address"], $configManager->getMailerConfig()["from"]["name"]);
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Quelques informations | Mariage de Marion & Nicolas";

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
    } else {
        header("HTTP/1.0 400 Error: Not correct");
        throw new Exception("Not correct", "400");
    }
}

function getGifts($dataBase)
{
    header('Content-Type: application/json');
    $query = "SELECT * from liste_mariage WHERE reserve IS FALSE ORDER BY cadeau asc;";

    $results = [];

    foreach ($dataBase->query($query, PDO::FETCH_ASSOC) as $result) {
        $results[] = $result;
    }

    echo json_encode($results);
}

function reserveGift($dataBase, $postedData)
{
    if (isset($postedData)) {
        $data = json_decode($postedData, true);

        $query = "UPDATE liste_mariage SET reserve=true WHERE id = {$data['id']};";

        if (!$dataBase->query($query)) {
            // En cas d'erreur, on affiche un message et on arrête tout
            header("HTTP/1.0 400 Error " . $dataBase->errorInfo()[1] . ": " . $dataBase->errorInfo()[2]);
            throw new Exception($dataBase->errorInfo()[2], $dataBase->errorInfo()[1]);
        }
    } else {
        header("HTTP/1.0 400 Error: Not correct");
        throw new Exception("Not correct", "400");
    }
}

function participateToGift($dataBase, $postedData)
{
    if (isset($postedData)) {
        $data = json_decode($postedData, true);

        $query = "UPDATE liste_mariage SET montant_participation = {$data["montant"]} WHERE id = {$data['id']};";

        if (!$dataBase->query($query)) {
            // En cas d'erreur, on affiche un message et on arrête tout
            header("HTTP/1.0 400 Error " . $dataBase->errorInfo()[1] . ": " . $dataBase->errorInfo()[2]);
            throw new Exception($dataBase->errorInfo()[2], $dataBase->errorInfo()[1]);
        }
    } else {
        header("HTTP/1.0 400 Error: Not correct");
        throw new Exception("Not correct", "400");
    }
}