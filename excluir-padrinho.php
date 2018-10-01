<?php
require_once "classes/padrinhos.class.php";

if(empty($_SESSION['id'])) {	
	header("Location:index.php");
	exit;
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$p = new Padrinhos();
	$id = addslashes($_GET['id']);
	echo $id; 
	exit;
	$p->excluirPadrinho($id);
	header("Location: padrinhos.php");
} else {
	header("Location: padrinhos.php");
}

?>