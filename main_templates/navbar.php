
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
   <div class="container">
      <a class="navbar-brand" href="/site"><b><i>GoSay</i></b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
         <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($page == '1') echo "active"; ?>">
               <a class="nav-link " href="/site/schedule">Расписание</a>
            </li>
            <li class="nav-item  <?php if($page == '2') echo "active"; ?>">
               <a class="nav-link" href="/site/admin">Админ панель</a>
            </li>
         </ul>
      </div>
   </div>
</nav>
