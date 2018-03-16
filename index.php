<!DOCTYPE html>
<html lang="ru">
  <head>
      <title>GoSay</title>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <?php
         require_once('main_templates/basic_styles.php');
      ?>
  </head>
  <body style="background-color: #f5f5f5; padding: 70px 70px;">

    <?php
      $page = '0';
      require_once('main_templates/navbar.php');
    ?>

   <div class="container">

      <div class="jumbotron">
         <h1>We are the best engineers in the SP641!</h1>
         <p class="lead">We provide System Analysis and Program Development services.</p>
         <p><a class="btn btn-lg btn-success" href="/schedule" role="button">Try our schedule!</a></p>
      </div>

   </div>

   <?php
     require_once('main_templates/footer.php');

     require_once('main_templates/basic_scripts.php');
   ?>

  </body>
</html>
