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

	function registo($utilizador, $password1){
			$tipo = 2;
			// Verificar se o e-mail já está registado
			$sqlVerificaEmail = "SELECT COUNT(*) FROM utilizadores WHERE nome = :nome";
			$stmtVerificaEmail = $this->liga->prepare($sqlVerificaEmail);
			$stmtVerificaEmail->bindParam(':nome', $utilizador);
			$stmtVerificaEmail->execute();
			$emailExistente = $stmtVerificaEmail->fetchColumn();
			

			$hash = password_hash($password1, PASSWORD_DEFAULT);

			if ($emailExistente > 0) {
				echo "Este e-mail já está registado!";
				return;
			}
			
			$sql = "INSERT INTO utilizadores VALUES(null, :nome,:pass, :tipo)";
			
			$stmt = $this->liga->prepare($sql);
			$stmt->bindParam(':nome',$utilizador);
			$stmt->bindParam(':pass', $hash);
			$stmt->bindParam(':tipo',$tipo);
			$stmt->execute();
			
			// Login automático após o registo
			// Verificar as credenciais para login
			$sqlLogin = "SELECT * FROM utilizadores WHERE nome = :nome";
			$stmtLogin = $this->liga->prepare($sqlLogin);
			$stmtLogin->bindParam(':nome', $utilizador);
			$stmtLogin->execute();
			
			// Verificar se o utilizador foi encontrado
			$utilizadorInfo = $stmtLogin->fetch(PDO::FETCH_ASSOC);
				
			if ($utilizadorInfo && password_verify($password1, $utilizadorInfo['pass'])) {
				// Iniciar sessão e armazenar informações do utilizador
				session_start(); // Inicia a sessão
				$_SESSION['login'] = true;
				$_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso </p>  "; 
				$_SESSION['nome']=$utilizadorInfo['nome'];
			
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
	
	function login($user, $password1){

		$sql = "SELECT * FROM utilizadores WHERE nome = :nome";
		$stmt = $this->liga->prepare($sql);
		$stmt->bindParam(':nome',$user);
		$stmt->execute();
		// Verificar se o utilizador foi encontrado
		$inf = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if (!$inf) {
			echo "Utilizador não encontrado!";
			return;
		}
		echo $password1.'<br>';
		echo $inf['pass'].'<br>';	
		var_dump(password_verify($password1, $inf['pass']));
		
		if ($inf && password_verify('teste', '$2y$10$Wdnm4CX1u9wkrxMZSad3xuzeK6lBTebcmBF3tUq7JR3/Z/kthsggm')){
			echo 'teste';
			session_start();
			$_SESSION['login'] = true;
			$_SESSION['loginMsg'] = "<p align='center' style='color: blue;'>Login com sucesso </p>  "; 
			$_SESSION['nome']=$inf['nome'];

			if($inf['id_tipo']==1)
			{
				$_SESSION['tipo']=1; // Utilizador tipo admin
			} else {
				$_SESSION['tipo']=2; // Utilizador tipo autenticado não administrador
			}
	
			header("location: index.php");
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


	//listar as trotinetes
	function listar_trotinetes($id){
		$sql = "SELECT * FROM trotinetes, modelos WHERE trotinetes.id_marca = modelos.id_marca AND trotinetes.id_trotinete = :id";
		$stmt = $this->liga->prepare($sql);
		$stmt->bindParam(':id',$id);
		$stmt->execute();
		// Verificar se o utilizador foi encontrado
		$inf = $stmt->fetchAll();
		
		foreach($inf as $dados){
			echo'
			<tr>
				<td>'.$dados['marca'].'</td>
				<td>'.$dados['modelo'].'</td>
				<td>'.$dados['descricao'].'</td>
				<td>'.$dados['preco'].'</td>
				<td>'.$dados['imagem'].'</td>
			</tr>
			';
		}
	}
}	
	
?> 