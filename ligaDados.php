<?php // tenta estabelecer ligação com o servidor web à base de dados bdteste
	class ligaDados{
	private $servidor = 'localhost';
	private $dbnome = 'dbwow';
	private $user = 'root';
	private $pass = '';

	public $liga;
	
	//Função para fazer a ligação à base de dados
	public function __construct(){
		try{
			$this->liga = new PDO('mysql:host='.$this->servidor.';dbname='.$this->dbnome,$this->user,$this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}catch(PDOException $e){
			echo 'ERRO: '.$e->getMessage();
			die();
		}
	}

	function registo($utilizador, $nome, $password1){
			$tipo = 2;
			
			// Verificar se o e-mail já está registado
			$sqlVerificaEmail = "SELECT COUNT(*) FROM utilizadores WHERE nome = :nome";
			$stmtVerificaEmail = $this->liga->prepare($sqlVerificaEmail);
			$stmtVerificaEmail->bindParam(':nome', $email);
			$stmtVerificaEmail->execute();
			$emailExistente = $stmtVerificaEmail->fetchColumn();
			
			if ($emailExistente > 0) {
				echo "Este e-mail já está registado!";
				return;
			}
			
			$sql = "INSERT INTO utilizadores VALUES(null, :nome,:pass, :tipo)";
			
			$stmt = $this->liga->prepare($sql);
			$stmt->bindParam(':nome',$utilizador);
			$stmt->bindParam(':pass',$password1);
			$stmt->bindParam(':tipo',$tipo);
			$stmt->execute();
			
			// Login automático após o registo
			// Verificar as credenciais para login
			$sqlLogin = "SELECT * FROM utilizadores WHERE email = :email";
			$stmtLogin = $this->liga->prepare($sqlLogin);
			$stmtLogin->bindParam(':email', $email);
			$stmtLogin->execute();
			
			// Verificar se o utilizador foi encontrado
			$utilizadorInfo = $stmtLogin->fetch(PDO::FETCH_ASSOC);
				
			if ($utilizadorInfo && password_verify($password1, $utilizadorInfo['senha'])) {
				// Iniciar sessão e armazenar informações do utilizador
				session_start(); // Inicia a sessão
				$_SESSION['login'] = true;
				$_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso </p>  "; 
				$_SESSION['nome']=$utilizadorInfo['login'];
			
				if($utilizadorInfo['tipoUtilizador']==1)
				{
					$_SESSION['tipo']=1; // Utilizador tipo admin
				} else {
					$_SESSION['tipo']=2; // Utilizador tipo autenticado não administrador
				}
			
				// Redirecionar para a página interna (exemplo)
				header("Location: index.php");
				exit;
			} else {
				echo "Erro ao fazer login!";
			}
		
	}
	
	function login($email, $password1){
		
		$sql = "SELECT * FROM utilizadores WHERE nome = :nome AND pass = :pass";
		
		$stmt = $this->liga->prepare($sql);
		$stmt->bindParam(':nome',$email);
		$stmt->bindParam(':pass',$password1);
		$stmt->execute();
		
		$inf = $stmt->fetchAll();

		//verificar se houve login correto
		$total = $stmt->rowCount();
	
		if($total > 0){
			session_start();
			foreach($inf as $dados){
				$_SESSION['login'] = true;
				$_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso </p>  "; 
				$_SESSION['nome']=$dados['login'];

				if($dados['tipoUtilizador']==1)
				{
					$_SESSION['tipo']=1; // Utilizador tipo admin
				} else {
					$_SESSION['tipo']=2; // Utilizador tipo autenticado não administrador
				}
		
				header("location: index.php");
			}
		}
	}
	
	function logout(){
		session_start();
		unset($_SESSION['login']);
		unset($_SESSION['loginMsg']);
		unset($_SESSION['nome']);
		unset($_SESSION['tipo']);
		session_unset();
		session_destroy();
		header("location: index.php");
	}
}	
	
?> 