<?php 
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
            // Autologin após registo
            $this->login($utilizador, $password1);
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
            $_SESSION['tipo'] = $inf['tipoUtilizador'] == 1 ? 1 : 2; // Ajustar conforme estrutura da BD
            
            // Limpar mensagens de erro
            unset($_SESSION['erro']);
            
            header("Location: index.php");
            exit;
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
        
        $_SESSION['sucesso'] = "Logout efetuado com sucesso!";
        header("Location: index.php");
        exit;
    }

    function isLoggedIn() {
        return isset($_SESSION['login']) && $_SESSION['login'] === true;
    }

    function getUserName() {
        return isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    }

    function getUserType() {
        return isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 0;
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
                <td>' . htmlspecialchars($dados['marca']) . '</td>
                <td>' . htmlspecialchars($dados['modelo']) . '</td>
                <td>' . htmlspecialchars($dados['descricao']) . '</td>
                <td>' . htmlspecialchars($dados['preco']) . '</td>
                <td>' . htmlspecialchars($dados['imagem']) . '</td>
            </tr>';
        }
    }
}
?>