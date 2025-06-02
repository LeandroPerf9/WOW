<?php 
session_start(); // Inicia sessão no topo do ficheiro

class ligaDados {
    private $servidor = 'localhost';
    private $dbnome = 'dbwow';
    private $user = 'root';
    private $pass = '';

    public $liga;

    public function __construct() {
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

    function registo($utilizador, $password1) {
        $tipo = 2;

        // Verificar se o utilizador já existe
        $sqlVerificaEmail = "SELECT COUNT(*) FROM utilizadores WHERE nome = :nome";
        $stmtVerificaEmail = $this->liga->prepare($sqlVerificaEmail);
        $stmtVerificaEmail->bindParam(':nome', $utilizador);
        $stmtVerificaEmail->execute();
        $emailExistente = $stmtVerificaEmail->fetchColumn();

        if ($emailExistente > 0) {
            echo "Este utilizador já está registado!";
            return;
        }

        // Criptografar a password
        $hash = password_hash($password1, PASSWORD_DEFAULT);

        // Inserir utilizador
        $sql = "INSERT INTO utilizadores VALUES(null, :nome, :pass, :tipo)";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':nome', $utilizador);
        $stmt->bindParam(':pass', $hash);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();

        // Autologin após registo
        $sqlLogin = "SELECT * FROM utilizadores WHERE nome = :nome";
        $stmtLogin = $this->liga->prepare($sqlLogin);
        $stmtLogin->bindParam(':nome', $utilizador);
        $stmtLogin->execute();
        $utilizadorInfo = $stmtLogin->fetch(PDO::FETCH_ASSOC);

        if ($utilizadorInfo && password_verify($password1, $utilizadorInfo['pass'])) {
            $_SESSION['login'] = true;
            $_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso</p>"; 
            $_SESSION['nome'] = $utilizadorInfo['nome'];
            $_SESSION['tipo'] = $utilizadorInfo['tipoUtilizador'] == 1 ? 1 : 2;
            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao fazer login!";
        }
    }

    function login($user, $password1) {
        $sql = "SELECT * FROM utilizadores WHERE nome = :nome";
        $stmt = $this->liga->prepare($sql);
        $stmt->bindParam(':nome', $user);
        $stmt->execute();
        $inf = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inf) {
            echo "Utilizador não encontrado!";
            return;
        }

        if (password_verify($password1, $inf['pass'])) {
            $_SESSION['login'] = true;
            $_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso</p>"; 
            $_SESSION['nome'] = $inf['nome'];
            $_SESSION['tipo'] = $inf['id_tipo'] == 1 ? 1 : 2;
            header("Location: index.php");
            exit;
        } else {
            echo "Palavra-passe incorreta!";
        }
    }

    function logout() {
        session_start();
        unset($_SESSION['login']);
        unset($_SESSION['loginMsg']);
        unset($_SESSION['nome']);
        unset($_SESSION['tipo']);
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    // Listar trotinetes
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
                <td>' . $dados['marca'] . '</td>
                <td>' . $dados['modelo'] . '</td>
                <td>' . $dados['descricao'] . '</td>
                <td>' . $dados['preco'] . '</td>
                <td>' . $dados['imagem'] . '</td>
            </tr>';
        }
    }
}
?>
