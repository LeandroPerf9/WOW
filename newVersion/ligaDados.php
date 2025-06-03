<?php 
class ligaDados {
    private $servidor = 'localhost';
    private $dbnome = 'dbwow';
    private $user = 'root';
    private $pass = '';

    public $liga;

    public function __construct() {
        // Iniciar sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            $this->liga = new PDO(
                'mysql:host=' . $this->servidor . ';dbname=' . $this->dbnome,
                $this->user,
                $this->pass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
            die();
        }
    }

    // ========== FUNÇÕES DE AUTENTICAÇÃO ==========
    
    function registo($utilizador, $password1) {
        $tipo = 2;

        // Verificar se o utilizador já existe
        $sqlVerificaEmail = "SELECT COUNT(*) FROM utilizadores WHERE nome = :nome";
        $stmtVerificaEmail = $this->liga->prepare($sqlVerificaEmail);
        $stmtVerificaEmail->bindParam(':nome', $utilizador);
        $stmtVerificaEmail->execute();
        $emailExistente = $stmtVerificaEmail->fetchColumn();

        if ($emailExistente > 0) {
            $_SESSION['erro'] = "Este utilizador já está registado!";
            return false;
        }

        // Criptografar a password
        $hash = password_hash($password1, PASSWORD_DEFAULT);

        // Inserir utilizador
        $sql = "INSERT INTO utilizadores VALUES(null, :nome, :pass, :tipo)";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':nome', $utilizador);
        $stmt->bindParam(':pass', $hash);
        $stmt->bindParam(':tipo', $tipo);
        
        if ($stmt->execute()) {
            // Autologin após registo bem-sucedido
            $_SESSION['login'] = true;
            $_SESSION['sucesso'] = "Registo efetuado com sucesso! Bem-vindo!";
            $_SESSION['nome'] = $utilizador;
            $_SESSION['tipo'] = $tipo;
            
            // Limpar mensagens de erro
            unset($_SESSION['erro']);
            return true;
        } else {
            $_SESSION['erro'] = "Erro ao registar utilizador!";
            return false;
        }
    }

    function login($user, $password1) {
        $sql = "SELECT * FROM utilizadores WHERE nome = :nome";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':nome', $user);
        $stmt->execute();
        $inf = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inf) {
            $_SESSION['erro'] = "Utilizador não encontrado!";
            return false;
        }

        if (password_verify($password1, $inf['pass'])) {
            $_SESSION['login'] = true;
            $_SESSION['sucesso'] = "Login efetuado com sucesso!"; 
            $_SESSION['nome'] = $inf['nome'];
            // Ajustar conforme a estrutura da tua base de dados
            $_SESSION['tipo'] = isset($inf['tipoUtilizador']) ? $inf['tipoUtilizador'] : 
                              (isset($inf['id_tipo']) ? $inf['id_tipo'] : 2);
            
            // Limpar mensagens de erro
            unset($_SESSION['erro']);
            return true;
        } else {
            $_SESSION['erro'] = "Palavra-passe incorreta!";
            return false;
        }
    }

    function logout() {
        // Limpar todas as variáveis de sessão relacionadas com login
        unset($_SESSION['login']);
        unset($_SESSION['sucesso']);
        unset($_SESSION['erro']);
        unset($_SESSION['nome']);
        unset($_SESSION['tipo']);
        unset($_SESSION['loginMsg']);
        
        $_SESSION['sucesso'] = "Logout efetuado com sucesso!";
        return true;
    }

    // ========== FUNÇÕES DE VERIFICAÇÃO ==========
    
    function isLoggedIn() {
        return isset($_SESSION['login']) && $_SESSION['login'] === true;
    }

    function getUserName() {
        return isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    }

    function getUserType() {
        return isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 0;
    }

    // ========== FUNÇÕES DE MENSAGENS ==========
    
    function getMensagem($tipo) {
        if (isset($_SESSION[$tipo])) {
            $msg = $_SESSION[$tipo];
            unset($_SESSION[$tipo]);
            return $msg;
        }
        return '';
    }

    function setMensagem($tipo, $mensagem) {
        $_SESSION[$tipo] = $mensagem;
    }

    // ========== FUNÇÕES DE PROCESSAMENTO DE FORMULÁRIOS ==========
    
    function processarLogin($dados) {
        if (!isset($dados['utilizador']) || !isset($dados['passe'])) {
            $this->setMensagem('erro', 'Preencha todos os campos!');
            return false;
        }

        if (empty($dados['utilizador']) || empty($dados['passe'])) {
            $this->setMensagem('erro', 'Preencha todos os campos!');
            return false;
        }

        return $this->login($dados['utilizador'], $dados['passe']);
    }

    function processarRegisto($dados) {
        if (!isset($dados['utilizador']) || !isset($dados['passe1']) || !isset($dados['passe2'])) {
            $this->setMensagem('erro', 'Preencha todos os campos!');
            return false;
        }

        if (empty($dados['utilizador']) || empty($dados['passe1']) || empty($dados['passe2'])) {
            $this->setMensagem('erro', 'Preencha todos os campos!');
            return false;
        }

        if ($dados['passe1'] !== $dados['passe2']) {
            $this->setMensagem('erro', 'As passwords não coincidem!');
            return false;
        }

        return $this->registo($dados['utilizador'], $dados['passe1']);
    }

    // ========== FUNÇÕES DE NAVEGAÇÃO ==========
    
    function renderNavegador() {
        ob_start();
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
              <?php if ($this->isLoggedIn()): ?>
                <span style="color: aliceblue;">Olá, <?php echo htmlspecialchars($this->getUserName()); ?>!</span><br>
                <a href="logout.php" style="color: aliceblue;"> &nbsp Logout &nbsp </a>
              <?php else: ?>
                <a href="login.php" style="color: aliceblue;"> &nbsp Login &nbsp </a><br>
                <a href="criarlogin.php" style="color: aliceblue;"> &nbsp Sign Up &nbsp </a>
              <?php endif; ?>
            </div>
          </div>
        </nav>
        <?php
        return ob_get_clean();
    }

    function renderMensagens() {
        ob_start();
        
        $sucesso = $this->getMensagem('sucesso');
        $erro = $this->getMensagem('erro');
        
        if (!empty($sucesso)): ?>
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">
                <?php echo htmlspecialchars($sucesso); ?>
            </div>
        <?php endif;
        
        if (!empty($erro)): ?>
            <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif;
        
        return ob_get_clean();
    }

    // ========== FUNÇÕES DE BASE DE DADOS ==========
    
    function listar_trotinetes($id) {
        $sql = "SELECT * FROM trotinetes, modelos 
                WHERE trotinetes.id_marca = modelos.id_marca 
                AND trotinetes.id_trotinete = :id";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $inf = $stmt->fetchAll();

        foreach ($inf as $dados) {
            echo '
            <tr>
                <td>' . htmlspecialchars($dados['marca']) . '</td>
                <td>' . htmlspecialchars($dados['modelo']) . '</td>
                <td>' . htmlspecialchars($dados['descricao']) . '</td>
                <td>' . htmlspecialchars($dados['preco']) . '</td>
                <td>' . htmlspecialchars($dados['imagem']) . '</td>
            </tr>';
        }
    }

    function listar_marcas() {
        $sql = "SELECT * FROM modelos ORDER BY marca";
        $stmt = $this->liga->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function obter_trotinetes_por_marca($id_marca) {
        $sql = "SELECT t.*, m.marca FROM trotinetes t 
                JOIN modelos m ON t.id_marca = m.id_marca 
                WHERE t.id_marca = :id_marca";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>