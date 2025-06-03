<?php
session_start();
require_once 'ligaDados.php';
$db = new ligaDados();

echo $db->renderNavegador();
echo $db->renderMensagens();
?>
<nav>
  <div class="navbar">
    <i class='bx bx-menu'></i>
    <div class="img-logo">
      <img src="logo1.PNG" alt="logo">
    </div>
    <div class="nav-links">
      <ul class="links">
        <li><a href="index.php">HOME</a></li>
        <li>
          <a href="marcas.php">MARCAS</a>
          <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
          <ul class="htmlCss-sub-menu sub-menu">
            <li><a href="processaForms.php?m=1">Urbanglide</a></li>
            <li><a href="processaForms.php?m=2">iScooter</a></li>
            <li><a href="processaForms.php?m=3">Segway</a></li>
            <li><a href="processaForms.php?m=4">Xiaomi</a></li>
          </ul>
        </li>
        <li>
          <a href="caracteristicas.php">CARACTERÍSTICAS</a>
          <i class='bx bxs-chevron-down js-arrow arrow'></i>
          <ul class="js-sub-menu sub-menu">
            <li><a href="autonomia.php">AUTONOMIA</a></li>
            <li><a href="mobilidade.php">MOBILIDADE</a></li>
          </ul>
        </li>
        <li><a href="fundamento.php">FUNDAMENTO</a></li>
        <li><a href="contactos.php">CONTACTOS</a></li>
      </ul>
    </div>
    <div class="search-box">
      <i class='bx bx-search'></i>
      <div class="input-box">
        <input type="text" placeholder="Search...">
      </div>
    </div>
    <!-- login/logout button -->
    <div class="login-box">
      <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
        <a href="logout.php" style="color: aliceblue;"> &nbsp Logout &nbsp </a>
      <?php else: ?>
        <a href="login.php" style="color: aliceblue;"> &nbsp Login &nbsp </a><br>
        <a href="criarlogin.php" style="color: aliceblue;"> &nbsp Sign Up &nbsp </a>
      <?php endif; ?>
    </div>
  </div>
</nav>
