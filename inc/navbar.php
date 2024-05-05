<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./img/mysql.png" width="100" height="1000">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Usuarios</a>

        <div class="navbar-dropdown">

          <a class="navbar-item" href="index.php?vista=user_new"> Nuevo</a>
          <a class="navbar-item" href="index.php?vista=user_list"> Lista</a>
          <a class="navbar-item" href="index.php?vista=user_search" > Buscar</a>
            </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Categorias</a>

        <div class="navbar-dropdown">

          <a href="index.php?vista=categoria_nuevo" class="navbar-item"> Nuevo</a>
          <a href="index.php?vista=categoria_lista" class="navbar-item"> Lista</a>
          <a href="index.php?vista=categoria_search" class="navbar-item"> Buscar</a>
            </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">productos</a>

        <div class="navbar-dropdown">

          <a href="index.php?vista=productos_new" class="navbar-item"> Nuevo</a>
          <a href="index.php?vista=productos_list" class="navbar-item"> Lista</a>
          <a href="index.php?vista=productos_categories" class="navbar-item"> Por categorias</a>
          <a href="index.php?vista=productos_search" class="navbar-item"> Buscar</a>
            </div>
        </div>

    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>"  class="button is-primary is-rounded">
            mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-danger is-rounded ">
            salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>