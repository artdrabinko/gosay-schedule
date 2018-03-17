<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  <!-- Navbar content -->
  <div class="container">
    <a class="navbar-brand" href="../index.php"><b><i>GoSay</i></b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="../schedule/schedule.php">Раписание</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/site/admin">Админ панель</a>
        </li>
      </ul>

      <?php
        require_once('templates/drop_admin_menu.php');
       ?>

    </div>
  </div>
  <!-- End Navbar content -->
</nav>
