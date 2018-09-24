<?php
require_once "classes/connect.class.php";

class Casal {
	private $pdo;
	private $conexao;
	
	public function __construct() {
		$this->conexao = new Conexao();
		$this->pdo = $this->conexao->getPdo();
	}

	public function autenticar($nome, $codigo) {
		$logado = array();

		$sql = $this->pdo->prepare("SELECT * FROM casal WHERE nome = :nome AND codigo = :codigo");
		$sql->bindValue(":nome", strtoupper($nome));
		$sql->bindValue(":codigo", md5($codigo));

		$sql->execute();

		if($sql->rowCount() > 0) {
			$logado = $sql->fetch();

			$num_login = $logado['num_login'];

			if($num_login == '0') {
				$token = md5(time().rand(0,999)).'login';

				$sql = $this->pdo->prepare("UPDATE casal SET token = :token WHERE id = :id");	
				$sql->bindValue(":token", $token);
				$sql->bindValue(":id", $logado['id']);
				$sql->execute();
			}

			$num_login = $num_login + 1;
			$sql = $this->pdo->prepare("UPDATE casal SET num_login = :num_login WHERE id = :id");
			$sql->bindValue(":num_login", $num_login);
			$sql->bindValue(":id", $logado['id']);
			$sql->execute();

		}
		return $logado;
	}

	public function getToken($id) {
		$token = null;
		$sql = $this->pdo->prepare("SELECT token FROM casal WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$t = $sql->fetch();
			$t = implode($t);
			$token = substr($t, 0, 6);
		}
		return $token;
 	}

	public function novaSenha($nSenha, $token, $id) {
		$c = new Casal();
		$t = $c->getToken($id);

		if($token == $t) {
			$sql = $this->pdo->prepare("UPDATE casal SET codigo = :nSenha WHERE id = :id");
			$sql->bindValue(":nSenha", md5($nSenha));
			$sql->bindValue(":id", $id);
			$sql->execute();
			return true;	
		} else {
			return false;
		}		
	}
}

?>