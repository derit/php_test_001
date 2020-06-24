<?php
include "Form.php";

$form = new Form();
$requirement = [
'email' => "email, required",
'password' => "min7"
]; 

$form->run($_POST, $requirement, function($code,$message,array $response) {
global $form;
if(count($response) > 0 or $code!==0) {
$form->response($code, $message, $response);
} else {
$form->response(1, "Terjadi sesuatu!", []);
}
});
?>