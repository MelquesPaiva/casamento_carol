<?php
require_once "connect.class.php";

class Padrinhos {
	private $pdo;
	private $conexao;

	public function __construct() {
		$this->conexao = new Conexao();
		$this->pdo = $this->conexao->getPdo();
	}

	public function novoPadrinho($nome, $fotos, $sexo, $descricao) {
		$tmpname = null;
		if(!empty($fotos)) {
			$tipo = $fotos['type'][0];
			if(in_array($tipo, array('image/jpeg', 'image/png'))) {
				$tmpname = md5(time().rand(0,999999)).'.jpg';
				// Movendo arquivo para o assets
				move_uploaded_file($fotos['tmp_name'][0], 'assets/images/padrinhos/'.$tmpname);

				// Redimensionando imagem que acabou de ser salva
				list($width_orig, $height_orig) = getimagesize('assets/images/padrinhos/'.$tmpname);
				$ratio = $width_orig / $height_orig;

				$width = 500;
				$heigth = 500;

				if($width/$heigth > $ratio) {
					$width = $heigth * $ratio;
				} else {
					$heigth = $width / $ratio;
				}
				// Criando a imagem
				$img = imagecreatetruecolor($width, $heigth);
				if($tipo == 'image/jpeg') {
					// Pegrando imagem original
					$origi = imagecreatefromjpeg('assets/images/padrinhos/'.$tmpname);
				} elseif($tipo == 'image/png') {
					$origi = imagecreatefrompng('assets/images/padrinhos/'.$tmpname);
				}
				// Salvando imagem no servidor
				imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $heigth, $width_orig, $height_orig);
				imagejpeg($img, 'assets/images/padrinhos/'.$tmpname, 80);
			}
		}

		$sql = $this->pdo->prepare("INSERT INTO padrinhos (nome, url_foto, sexo, descricao) VALUES (:nome, :url_foto, :sexo, :descricao)");
		$sql->bindValue(":nome", strtoupper($nome));
		$sql->bindValue(":url_foto", $tmpname);
		$sql->bindValue(":sexo", $sexo);
		$sql->bindValue(":descricao", $descricao);

		$sql->execute();
	}

	public function getPadrinhos($sexo) {
		$array = array();	

		$sql = $this->pdo->prepare("SELECT * FROM padrinhos WHERE sexo = :sexo");
		$sql->bindValue(":sexo", $sexo);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function buscaPorId($id) {
		$p = null;	

		$sql = $this->pdo->prepare("SELECT * FROM padrinhos WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$p = $sql->fetch();
		}
		return $p;
	}

	public function editPadrinho($id, $nome, $foto, $sexo, $descricao) {
		$p = new Padrinhos();
		$p = $p->buscaPorId($id);
		if(!empty($fotos)) {
			$tipo = $fotos['type'][0];
			if(in_array($tipo, array('image/jpeg', 'image/png'))) {
				$p['url_foto'] = md5(time().rand(0,999999)).'.jpg';
				// Movendo arquivo para o assets
				move_uploaded_file($fotos['tmp_name'][0], 'assets/images/padrinhos/'.$p['url_foto']);

				// Redimensionando imagem que acabou de ser salva
				list($width_orig, $height_orig) = getimagesize('assets/images/padrinhos/'.$p['url_foto']);
				$ratio = $width_orig / $height_orig;

				$width = 500;
				$heigth = 500;

				if($width/$heigth > $ratio) {
					$width = $heigth * $ratio;
				} else {
					$heigth = $width / $ratio;
				}
				// Criando a imagem
				$img = imagecreatetruecolor($width, $heigth);
				if($tipo == 'image/jpeg') {
					// Pegrando imagem original
					$origi = imagecreatefromjpeg('assets/images/padrinhos/'.$p['url_foto']);
				} elseif($tipo == 'image/png') {
					$origi = imagecreatefrompng('assets/images/padrinhos/'.$p['url_foto']);
				}
				// Salvando imagem no servidor
				imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $heigth, $width_orig, $height_orig);
				imagejpeg($img, 'assets/images/padrinhos/'.$p['url_foto'], 80);
			}
		}
		$sql = $this->pdo->prepare("UPDATE padrinhos SET nome = :nome, url_foto = :url_foto, sexo = :sexo, descricao = :descricao
										WHERE id = :id");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":url_foto", $p['url_foto']);
		$sql->bindValue(":sexo", $sexo);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":id", $id);

		$sql->execute();
	}

	public function excluirPadrinho($id) {
		$sql = $this->pdo->prepare("DELETE FROM padrinhos WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}
}


?>