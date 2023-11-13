<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
require_once ('vendor/autoload.php');



if (isset($_POST['name']) && isset($_POST['email'])) {
    if($_POST['name'] !='' && $_POST['email'] !=''){
        $result = [];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $text = $_POST['text'];
        $title = "Заголовок листа";
        $body = "<h2>Новий лист</h2><b>Iм'я:</b>" . $name. "<br><b>Email:</b>" . $email . "<br><br><b>Текcт:</b><br>" . $text;
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->SMTPAuth   = true;
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'martinborman1991@gmail.com';
            $mail->Password   = 'jbxfazigoklhlwre';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            $mail->setFrom('martinborman1991@gmail.com', 'Martin');
            $mail->addAddress('martinborman1991@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $body;
            if ($mail->send()) {
                $result['success'] = "Лист відправлений";
            }
        } catch (Exception $e) {
            $result['error']['warning'] = "'Помилка. Дані не надіслано. Спробуйте відправлення пізніше. Причина помилки: {$mail->ErrorInfo}";
        }
    }else{
        if($_POST['name'] == ''){
            $result['error']['name'] = 'Поле ім\'я є обов\'язковим для заповнення.';
        }
        if($_POST['email'] == ''){
            $result['error']['email'] = 'Поле email є обов\'язковим для заповнення.';
        }
        if(isset($result['error'])){
            $result['error']['warning'] = 'Помилка. Не всі обов\'язкові дані заповнені.';
        }
    }
    echo json_encode($result);
}