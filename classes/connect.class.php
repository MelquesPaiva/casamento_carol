<?php
class Conexao {
	private $pdo;

	public function __construct() {
		$dsn = "mysql:dbname=casamento_carol;host=localhost";
		$dbuser = "root";
		$dbpass = "";
		try {			
			$this->pdo = new PDO($dsn,$dbuser,$dbpass);				
		} catch(PDOException $e) {
			echo "Falhou a conexão:" .$e->getMessage();
		}	
	}

	public function getPdo() {
		return $this->pdo;
	}
}

?>