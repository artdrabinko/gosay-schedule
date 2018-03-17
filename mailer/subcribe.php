<?php
require_once('../db/connect_to_DB.php');

if(!$_POST['email']){
   echo json_encode(array('status' => 2, 'data' => 'Empty email field!'));
}

if(!$_POST['g-recaptcha-response']){
   echo json_encode(array('status' => 3, 'data' => 'Error g-recaptcha!'));
} else {

   function send_email(){
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
      $mail->addAddress($_POST['email']);     // Кому будет уходить письмо
      //$mail->addAddress('ellen@example.com');               // Name is optional
      //$mail->addReplyTo('info@example.com', 'Information');
      //$mail->addCC('cc@example.com');
      //$mail->addBCC('bcc@example.com');
      $mail->isHTML(true);
      $group = R::findOne('groups', 'id = ?', array( $_POST['id_group']));
      R::close();

      $mail->Subject = 'Подписка на раcписание';
      $mail->Body    = '<h4>Поздравляем!</h4><p>Вы успешно подписались на обновления группы <b>'.$group->group_name.'-'. $_POST['subgroup'].'</b></p><br/><p>С уважением, команда GoSay</p>';
      $mail->AltBody = '';
      //$mail->AltBody = 'Subscribe message';

      if(!$mail->send()) {
         echo json_encode(array('status' => 6, 'data' => 'Sorry our smpt server is sick(!'));
      } else {
         echo json_encode(array('status' => 0, 'data' => 'Success!'));
      }
   }


   $url = 'https://www.google.com/recaptcha/api/siteverify';
   $key = '6Ld7n0QUAAAAAM1ccucOzTmLFFTWCz7Qz-4sm6wY';
   $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

   $google_answer = json_decode(file_get_contents($query));
   if($google_answer->success == true){
      $subscriber = R::findOne('subscribers', 'email = ?	AND id_group = ? AND subgroup = ? ', array($_POST['email'],  $_POST['id_group'],  $_POST['subgroup'] ));

      if(!$subscriber){
         $subscriber = R::dispense('subscribers');

         $subscriber->email = $_POST['email'];
         $subscriber->id_group =  $_POST['id_group'];
         $subscriber->subgroup = $_POST['subgroup'];

         R::store($subscriber);
         R::close();

         send_email();
      }else {
         echo json_encode(array('status' => 4, 'data' => 'Subscription already exists!'));
      }

   }else{
      echo json_encode(array('status' => 4, 'data' => 'If you are not a robot, contact the administrator!'));
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
