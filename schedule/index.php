<?php
require_once('../db/connect_to_DB.php');

$groups =  R::findAll('groups', 'ORDER BY group_name');
?>


<!DOCTYPE html>
<html lang="ru">
<head>
<title>Search group</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php
$page = '1';
require_once('../main_templates/basic_styles.php');
?>
</head>

<body style="background-color: #f5f5f5; padding: 60px 0px 60px 0px;">
<?php
require_once('../main_templates/navbar.php');
?>

<div class="container">

   <form>
     <div class="form-group row mr-0 ml-0">
       <label for="inputNameGroup" class="col-form-label" style="width: 265px;">Введите название группы:</label>
       <input type="text" class="form-control" style="width: 240px;" id="input_name_group" maxlength="5"  placeholder="ИТ777">
     </div>
   </form>

   <table class="table">
     <tbody id="table_groups">
       <?php
       foreach ($groups as $group) {

         echo '<tr>';
           echo '<td class="pl-0 pr-0">';
               echo '<h4>'.$group->group_name.'</h4>';
           echo '</td>';
           echo '<td class="pl-0 pr-0">';
               echo '<a class="btn btn-info mr-1 mb-1" href="schedule.php?idgroup='.$group->id.'&amp;subgroup=1">Подгруппа 1</a>';
               echo '<a class="btn btn-warning mb-1" href="schedule.php?idgroup='.$group->id.'&amp;subgroup=2">Подгруппа 2</a>';
           echo '</td>';
         echo '</tr>';
       }
       ?>
     </tbody>
   </table>

</div>

<?php
  require_once('../main_templates/footer.php');

  require_once('../main_templates/basic_scripts.php');
?>

<script src="js/ajax.js"></script>
<script src="js/index.js"></script>
</body>
</html>
