<?php
require_once "connect.class.php";

class Presentes {
	private $pdo;
	private $conexao;

	public function __construct() {
		$this->conexao = new Conexao();
		$this->pdo = $this->conexao->getPdo();
	}

	public function inserirPresente($idCategoria, $nome, $fotos) {
		$tmpname = null;
		if(!empty($fotos)) {
			$tipo = $fotos['type'][0];
			if(in_array($tipo, array('image/jpeg', 'image/png'))) {
				$tmpname = md5(time().rand(0,999999)).'.jpg';
				// Movendo arquivo para o assets
				move_uploaded_file($fotos['tmp_name'][0], 'assets/images/presentes/'.$tmpname);

				// Redimensionando imagem que acabou de ser salva
				list($width_orig, $height_orig) = getimagesize('assets/images/presentes/'.$tmpname);
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
					$origi = imagecreatefromjpeg('assets/images/presentes/'.$tmpname);
				} elseif($tipo == 'image/png') {
					$origi = imagecreatefrompng('assets/images/presentes/'.$tmpname);
				}
				// Salvando imagem no servidor
				imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $heigth, $width_orig, $height_orig);
				imagejpeg($img, 'assets/images/presentes/'.$tmpname, 80);
			}
		}

		$sql = "INSERT INTO presentes (id_categoria, nome, url_foto) VALUES (:idCategoria, :nome, :url_foto)";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":idCategoria", $idCategoria);
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":url_foto", $tmpname);

		$sql->execute();		
	}

	public function excluirPresente($id) {
		$sql = $this->pdo->prepare("DELETE FROM presentes WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}

	public function editarPresente($idPresente, $idCategoria, $nome, $fotos) {
		$p = new Presentes();
		$presente = $p->getPresentesPorId($idPresente);

		if(!empty($fotos)) {
			$tipo = $fotos['type'][0];
			if(in_array($tipo, array('image/jpeg', 'image/png'))) {
				$presente['url_foto'] = md5(time().rand(0,999999)).'.jpg';
				// Movendo arquivo para o assets
				move_uploaded_file($fotos['tmp_name'][0], 'assets/images/presentes/'.$presente['url_foto']);

				// Redimensionando imagem que acabou de ser salva
				list($width_orig, $height_orig) = getimagesize('assets/images/presentes/'.$presente['url_foto']);
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
					$origi = imagecreatefromjpeg('assets/images/presentes/'.$presente['url_foto']);
				} elseif($tipo == 'image/png') {
					$origi = imagecreatefrompng('assets/images/presentes/'.$presente['url_foto']);
				}
				// Salvando imagem no servidor
				imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $heigth, $width_orig, $height_orig);
				imagejpeg($img, 'assets/images/presentes/'.$presente['url_foto'], 80);
			}
		}

		$sql = $this->pdo->prepare("UPDATE presentes
									 SET id_categoria = :id_categoria, nome = :nome, url_foto = :url_foto
									 WHERE id = :id_presente");
		$sql->bindValue(":id_categoria", $idCategoria);
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":url_foto", $presente['url_foto']);
		$sql->bindValue(":id_presente", $idPresente);

		$sql->execute(); 
	}

	public function getPresentesPorId($id) {
		$array = array();

		$sql = $this->pdo->prepare("SELECT * FROM presentes WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}
		return $array;
	}

	public function getPresentes($id = null) {
		$presentes = array();

		if ($id == null) {
			$sql = $this->pdo->prepare("SELECT *, (select categoria.nome_categoria from categoria where categoria.id = presentes.id_categoria) as categoria FROM presentes ORDER BY id_categoria");	
		} else {
			$sql = $this->pdo->prepare("SELECT *, (select categoria.nome_categoria from categoria where categoria.id = presentes.id_categoria) as categoria FROM presentes WHERE id_categoria = :id_categoria ORDER BY id_categoria");
			$sql->bindValue(":id_categoria", $id);	
		}
		$sql->execute();

		if($sql->rowCount() > 0) {
			$presentes = $sql->fetchAll();
		}
		return $presentes;
	}

	public function getQtdPresentes() {
		$totalPresentes = 0;
		$sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM presentes");
		$sql->execute();

		if($sql->rowCount() > 0) {
			$row = $sql->fetch();
			$totalPresentes = $row['c'];
		}
		return $totalPresentes;
	}

	public function inserirNomeConvidado($idPresente, $nomeConvidado) {
		$sql = $this->pdo->prepare("UPDATE presentes SET nome_convidado = :nome_convidado WHERE id = :id_presente");
		$sql->bindValue(":id_presente", $idPresente);
		$sql->bindValue(":nome_convidado", $nomeConvidado);
		$sql->execute();
	}
}
?>