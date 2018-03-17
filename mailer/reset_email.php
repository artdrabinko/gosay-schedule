<?php
function getRandomPassword($max){
   //$max Количество символов в пароле.
   // Символы, которые будут использоваться в пароле.
   $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

   // Определяем количество символов в $chars
   $size=StrLen($chars)-1;

   // Определяем пустую переменную, в которую и будем записывать символы.
   $password = null;

   // Создаём пароль.
   while( $max-- ){ $password.=$chars[rand(0,$size)]; }

   // Выводим созданный пароль.
   return $password;
}

function send_email($email, $password){
   require_once('phpmailer/PHPMailerAutoload.php');
   $mail = new PHPMailer(true);
   $mail->CharSet = 'utf-8';

   $mail->SMTPDebug = 0;                               // Enable verbose debug output

   $mail->isSMTP();                                      // Set mailer to use SMTP
   $mail->Host = 'smtp.gmail.com';  																							// Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = ''; // Ваш логин от почты с которой будут отправляться письма
   $mail->Password = ''; // Ваш пароль от почты с которой будут отправляться письма
   $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 465;

   $mail->setFrom('gosay.inc@gmail.com'); // от кого будет уходить письмо?
   $mail->addAddress($email);     // Кому будет уходить письмо
   //$mail->addAddress('ellen@example.com');               // Name is optional
   //$mail->addReplyTo('info@example.com', 'Information');
   //$mail->addCC('cc@example.com');
   //$mail->addBCC('bcc@example.com');
   $mail->isHTML(true);

   $mail->Subject = 'Восстановление пароля';
   $mail->Body    = '<h4>Восстановление пароля</h4><p>Ваш новый пароль : <b>'.$password.'</b></p><p>С уважением, команда GoSay</p>';
   $mail->AltBody = '';
   //$mail->AltBody = 'Subscribe message';

   if(!$mail->send()) {
      echo json_encode(array('status' => 6, 'data' => 'Sorry our smpt server is sick(!'));
   } else {
      //echo json_encode(array('status' => 0, 'data' => 'Success!'));
   }
}


/*
GoSay Schedule is a web application for scheduling in educational institutions.
Copyright (C) 2018  Drabinko Artur

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>
*/
?>
