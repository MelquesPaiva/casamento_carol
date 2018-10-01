<?php
require_once "classes/casal.class.php";
session_start();

$c = new Casal();

$logado = 0;
if(isset($_POST['codigoLogar']) && !empty($_POST['codigoLogar'])) {
	$nomeCasal = addslashes($_POST['nomeCasal']);
	$codigoLogar = addslashes($_POST['codigoLogar']);

	$casal = $c->autenticar($nomeCasal, $codigoLogar);

	if(!empty($casal)) {
		$_SESSION['id'] = $casal['id'];		
	} else {
		echo "<script>alert('Esse usuário e senha não tem acesso a essa página');</script>";
	}	
}
if(isset($_POST['codigoNovaSenha']) && !empty($_POST['codigoNovaSenha'])) {
	$novaSenha = addslashes($_POST['codigoNovaSenha']);
	$token = addslashes($_POST['token']);

	if($c->novaSenha($novaSenha, $token, $_SESSION['id'])) {
		echo "<script>alert('Senha alterada com sucesso!');</script>";
	} else {
		echo "<script>alert('Token digitado está errado!');</script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
	<title>Carol</title>	
</head>
<body class="bg-light">
	<div class="container">
		<nav class="navbar navbar-expand-lg menu" style="width: 100%">
			<div class="navbar-brand display-4 font-italic" style="font-size: 25px; color: #F5A9E1;">
				Carol e Rafique
			</div>
		<?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])):?>
			<button class="navbar-toggler" data-toggle="collapse" data-target="#itensMenu">
				<img src="assets/images/menu.png" height="30"/>
			</button>
			<div class="navbar-collapse collapse justify-content-end" id="itensMenu">
		<?php else:?>
			<div class="navbar-collapse justify-content-end" id="itensMenu">
		<?php endif;?>	
			
				<div class="navbar navbar-tabs">
					<a href="index.php" class="nav-item nav-link btn text-dark">Página Inicial</a>
					<!-- <a href="index.php" class="nav-item nav-link btn text-dark" style="font-size: 17px;">Perfil</a> -->
					<div class="dropdown show">
						<a class="btn nav-item nav-link btn text-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    	Perfil
					  	</a>
					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					    	<a class="dropdown-item" href="padrinhos.php">Padrinhos e Madrinhas</a>
					    	<a class="dropdown-item" href="#">Item 2</a>

				   	<?php if(empty($_SESSION['id'])):?>
					    	<button class="dropdown-item" data-toggle="modal" data-target="#modalLogin">Acesso restrito</button>
				   	<?php endif;?>
					  	</div>
					</div>
					<a href="lista-presentes.php" class="nav-item nav-link btn text-dark">Lista de Presentes</a>

				<?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])):?>
					<div class="dropdown show">
						<a class="btn nav-item nav-link btn text-dark dropdown-toggle text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opções exclusivas pra quem faz login">
					    	Mais Opções
					  	</a>
					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					    	<a class="dropdown-item" href="lista2-presentes.php">Edição/Exclusão presentes</a>
					    	<a class="dropdown-item" href="add-presentes.php">Adicionar presentes</a>
					    	<a class="dropdown-item" href="add-padrinhos.php">Adicionar Padrinhos</a>
					    	<button class="dropdown-item" data-toggle="modal" data-target="#modalAltSenha">Altere a Senha</button>
					    	<a class="dropdown-item" href="sair.php">Logout</a>
					  	</div>
					</div>
				<?php endif;?>
				</div>
			</div>
		</nav>
	</div>
<?php if(empty($_SESSION['id'])):?>
	<div id="modalLogin" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" style="font-size: 18px;">Acesso exclusivo do Casal</h5>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<form method="POST">
						<div class="form-group">
							<label>Digite seu nome</label>
							<input type="text" name="nomeCasal" id="nomeCasal" class="form-control" required="true"/>
						</div>
						<div class="form-group">
							<label>Digite o código</label>
							<input type="password" name="codigoLogar" id="codigoLogar" class="form-control" required="true"/>	
						</div>
						<hr/>
						<div class="form-group">
							<input type="submit" name="enviar" value="Acessar" class="btn btn-primary btn-block"/>
						</div>
					</form>
				</div>
			</div>
		</div>		
	</div>
<?php endif;?>

	<div id="modalAltSenha" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" style="font-size: 18px;">Altere sua senha</h5>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<form method="POST">						
						<div class="form-group">
							<label for="codigoNovaSenha">Digite a nova senha</label>
							<input type="password" name="codigoNovaSenha" id="codigoNovaSenha" class="form-control" required="true"/>	
						</div>
						<div class="form-group">
							<label for="token">Digite o código disponibilizado por Melques</label>
							<input type="password" name="token" id="token" class="form-control" required="true"/>	
						</div>
						<hr/>
						<div class="form-group">
							<input type="submit" name="alterar" value="Acessar" class="btn btn-primary btn-block"/>
						</div>
					</form>
				</div>
			</div>
		</div>		
	</div>