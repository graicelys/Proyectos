<?php
require_once('../db/config.php');

$name1 = $_POST['name'];
$lastName1 = $_POST['lastname'];
$email1 = $_POST['email'];
$country1 = $_POST['country'];
$phone1 = $_POST['phone'];
$message1 = $_POST['message'];
 

$sql = "INSERT INTO form_contact (Id,First_name,Last_name,email,Country,Phone,Message)
VALUES ('','$name1','$lastName1','$email1', '$country1', '$phone1','$message1')";
$mysqli->query($sql);

require_once('../form/submit_form_contacto.html');

/*$to = $_POST['email'];
$subject = 'Confirmación de Registro';
$message = 'Gracias por registrarte en nuestro sitio. Tu registro ha sido confirmado.';
$headers = "From: graicelys@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    require_once('submit_form_contacto.html');
} else {
    echo 'Registro exitoso, pero no se pudo enviar el correo de confirmación.';
}*/





