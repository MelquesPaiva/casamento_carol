<?php
require_once "classes/presentes.class.php";

if(empty($_SESSION['id'])) {	
	header("Location:index.php");
	exit;
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
	$p = new Presentes();
	$p->excluirPresente($id);
	header("Location: lista2-presentes.php");
} else {
	header("Location: lista2-presentes.php");
}
?>