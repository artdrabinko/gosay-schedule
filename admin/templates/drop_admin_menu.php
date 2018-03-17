<?php
   $settingLink = '';
   if($LEVEL == 1) $settingLink = 'settings.php';
   if($LEVEL == 0) $settingLink = 'settings_staff.php';
?>
<ul class="navbar-nav navbar-right">
  <li class="nav-item dropdown">
   <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <b><?php echo $_SESSION['logged_user']['login']; ?></b>
   </a>
   <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
     <a class="dropdown-item" href="<?php echo $settingLink;?>">Настройки</a>
     <div class="dropdown-divider"></div>
     <a class="dropdown-item" href="admin.php?action=out">Выйти</a>
   </div>
   <style media="screen">
     .dropdown-menu a:hover{
       background-color: rgb(3, 102, 214);
       color: #fff;
     }
   </style>
 </li>
</ul>
