<?php
require_once "connect.class.php";

class Categoria {
	private $pdo;
	private $conexao;

	public function __construct() {
		$this->conexao = new Conexao();
		$this->pdo = $this->conexao->getPdo();
	}
	public function getCategorias() {
		$categorias = array();

		$sql = $this->pdo->prepare("SELECT * FROM categoria");
		$sql->execute();

		if($sql->rowCount() > 0) {
			$categorias = $sql->fetchAll();
		}
		return $categorias;
	}
	public function novaCategoria($nome_categoria) {
		$sql = $this->pdo->prepare("INSERT INTO categoria (nome_categoria) VALUES (:nome_categoria)");
		$sql->bindValue(":nome_categoria", $nome_categoria);
		$sql->execute();
	}
}
?>