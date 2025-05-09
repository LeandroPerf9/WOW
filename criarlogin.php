<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> World On Wheels </title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<br>
  <nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="img-logo">
        <img src="logo1.PNG" height="65px"   alt="logo">
      </div>
      <!--<div class="logo"><a href="#">World On Wheels</a></div>-->
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name">World On Wheels</span>
          <i class='bx bx-x' ></i>
        </div>
        <ul class="links">
          <li><a href="./index.html">HOME</a></li>
          <li>
            <a href="#">BRANDS</a>
            <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            <ul class="htmlCss-sub-menu sub-menu">
              <li><a href="#">Urbanglide</a></li>
              <li><a href="#">iScooter</a></li>
              <li><a href="#">Segway</a></li>
              <li class="more">
                <span><a href="#">More</a>
                <i class='bx bxs-chevron-right arrow more-arrow'></i>
              </span>
                <ul class="more-sub-menu sub-menu">
                  <li><a href="#">Xiaomi</a></li>
                  <li><a href="#">Ninebot</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">CHARACTERISTICS</a>
            <i class='bx bxs-chevron-down js-arrow arrow '></i>
            <ul class="js-sub-menu sub-menu">
              <li><a href="#">Autonomy</a></li>
              <li><a href="#">Weight and portability</a></li>
              <li><a href="#">Price</a></li>
            </ul>
          </li>
          <li><a href="#">ABOUT US</a></li>
          <li><a href="#">CONTACT US</a></li>
        </ul>
      </div>
      <div class="search-box">
        <i class='bx bx-search'></i>
        <div class="input-box">
          <input type="text" placeholder="Search...">
        </div>
      </div>
      <!-- login button -->
      <div class="login-box">
        <button class="btn">Login</button>
        <button class="btn">Sign Up</button>
        <i class='bx bx-user-circle'></i>
      </div>
    </div>
  </nav>
  <!-- end of nav-->

  <section>
			<?php include('ligaDados.php'); ?>
			<div class="bloco" align="center">
				<br>
				<h2 align="center"> Registar Novo utilizador</h2>
				<form name="login" action="criarlogin.php" method="POST">
					<fieldset>
					<legend><h3>Novo Registo</h3></legend>
					<p>
					<label> Utilizador: </label>
					<input type="text" id="utilizador" name="utilizador" placeholder="Utilizador" required/>
					</p>
					<p>
					<label> Password: </label>
					<input type="password" id="passe1" name="passe1" placeholder="Palavra Passe" required/>
					</p>
					<p>
					<p>
					<label> Password: </label>
					<input type="password" id="passe2" name="passe2" placeholder="Reescrever Palavra Passe" required/>
					</p>
					<input type="submit" id="btnRegistar" value="  Registar  " style="color:#fff; background:#337ab7; padding:10px; margin-left:100px; " />
					</p>
					<p id="msg" name="msg"  style="color: red;"> </p>
					</fieldset>
				</form>
				<?php
					if(!empty($_POST['utilizador'])) {						
						$utilizador = $_POST["utilizador"];
						$password1 =MD5($_POST["passe1"]);
						$password2 =MD5($_POST["passe2"]);
						if($password1==$password2)
						{					
							$sql = "INSERT INTO utilizadores VALUES(null, '$utilizador', '$password1')";
							$resultado =mysqli_query($ligacao, $sql);
							if ($resultado) {
								echo "Dados inseridos com sucesso <br>";
							} else {
								echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
							}
						} else echo "Palavras passe diferentes";
					}
				?>
				<br><br>
			</div>	
		</section >

  <script src="script.js"></script>

  <footer>
    <p>© 2025 World On Wheels. Todos os direitos reservados</p>
    </div>
  </footer>

</body>
</html>
