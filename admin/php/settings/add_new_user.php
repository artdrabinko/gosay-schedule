<?php
//require_once('/db/connect_to_DB.php');

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

function send_email($email, $pass){
   require_once('../mailer/phpmailer/PHPMailerAutoload.php');
   $mail = new PHPMailer(true);
   $mail->CharSet = 'utf-8';

   $mail->SMTPDebug = 0;                               // Enable verbose debug output

   $mail->isSMTP();                                      // Set mailer to use SMTP
   $mail->Host = 'smtp.gmail.com';  																							// Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = 'gosay.inc@gmail.com'; // Ваш логин от почты с которой будут отправляться письма
   $mail->Password = '0908gosaythebest'; // Ваш пароль от почты с которой будут отправляться письма
   $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 465;

   $mail->setFrom('gosay.inc@gmail.com'); // от кого будет уходить письмо?
   $mail->addAddress($email);     // Кому будет уходить письмо

   $mail->isHTML(true);
   $group = R::findOne('groups', 'id = ?', array( $_POST['id_group']));
   R::close();

   $mail->Subject = 'Учетная заись gosay';
   $mail->Body    = '<h4>Поздравляем!</h4><p>Ваша учетная запись была успешно добавлена!<br/>Ваш логин : '.$email.'<br/>Пароль : '.$pass.'</p><p>С уважением, команда GoSay</p>';
   $mail->AltBody = '';
   //$mail->AltBody = 'Subscribe message';

   if(!$mail->send()) {
      //echo json_encode(array('status' => 6, 'data' => 'Sorry our smpt server is sick(!'));
      return false;
   } else {
      //echo json_encode(array('status' => 0, 'data' => 'Success!'));
      return true;
   }
}

function isAddNewUser($data){
   //получаем данные из формы
   $login = $data['email'];

   $errors = array();
   $user =  R::findOne( 'users', ' login = ? OR email = ?', array($login, $login) );

   if(!$user){
      $password = getRandomPassword(10);
      $hash_password = password_hash( '1', PASSWORD_DEFAULT );

      $new_user = R::dispense('users');

      $new_user->login = $login;
      $new_user->level = $data['level'];
      $new_user->password = $hash_password;
      $new_user->email = $data['email'];

      if( $data['level'] == 0 && isset( $data['id_group'] ) ) {
         $new_user->id_group = $data['id_group'];
      }else {
         $new_user->id_group = 0;
      }

      R::store($new_user);
      R::close();
      return send_email($data['email'], $password);
   }else {
      return false;
   }


}


?>
