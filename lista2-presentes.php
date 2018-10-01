<?php require_once "pages/header.php";?>
<?php require_once "classes/presentes.class.php";?>
<?php require_once "classes/categoria.class.php";?>

<?php
$p = new Presentes();
$c = new Categoria();
$categorias = $c->getCategorias();
$totalPresentes = $p->getQtdPresentes();
$nCategoria = 0;
$salvo = 0;

if(empty($_SESSION['id'])) {
	unset($categorias);
	unset($totalPresentes);
	header("Location:index.php");
	exit;
}

if(isset($_GET['categoria']) && !empty($_GET['categoria'])) {
	$nCategoria = $_GET['categoria'];
	$presentes = $p->getPresentes($nCategoria);
} else {
	$presentes = $p->getPresentes();
}

if(isset($_POST['nomeConvidado']) && !empty($_POST['nomeConvidado'])) {
	$nomeConvidado = $_POST['nomeConvidado'];
	$idPresente = $_POST['idPresente'];
	$p->inserirNomeConvidado($idPresente, $nomeConvidado);
	$salvo = 1;
}

?>

<div class="jumbotron imgPrincipal rounded text-center d-flex justify-content-center align-items-center flex-column" style="min-height: 400px;">
	<h2 class="display-3 text-light font-italic text-center titulo">CAROL E RAFIQUE</h2>
</div>

<div class="container">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h3 class="display-4 font-italic mt-5 subTitulo subTituloLista text-center">Edição de presentes</h3>
		<p class="font-italic mt-4 text-center" style="font-size: 18px;">Página para excluir ou editar presentes.</p>
		<a href="add-presentes.php" class="btn btn-primary">Adicionar Presente</a>
		<form method="GET" class="mt-5">
			<div class="form-group d-flex">
				<label for="categoria">
					Filtre por categoria:
				</label>
				<select class="form-control" name="categoria" onchange="this.form.submit()">
					<option value="" selected="selected">Todos os presentes</option>
					<?php
					foreach ($categorias as $categoria) {
					?>
					<option value="<?php echo $categoria['id'];?>" <?php echo ($nCategoria==$categoria['id'])?'selected="selected"':''; ?>>
						<?php echo utf8_encode($categoria['nome_categoria']);?>					
					</option>
					<?php
					}
					?>
				</select>
			</div>
		</form>		
	</div>
	<div class="row mt-4">
	<?php
	if($salvo == 1) {
	?>
		<div class="col-md-12 alert alert-success text-center">
			<h5>Presente escolhido com Sucesso!!</h5>
		</div>
	<?php	
	}
	?>	
	<?php foreach ($presentes as $presente):?>		
		<div class="col-md-4">
			<div class="card mt-2 lista2" style="height: 400px;">
				<div class="card-header">
					<h5><?php echo utf8_encode($presente['categoria']);?></h5>
				</div>
				<div class="card-body presentes d-flex align-items-center flex-column">
					<img src="assets/images/presentes/<?php echo $presente['url_foto'];?>" class="img-thumbnail" border="0"/>
					<h5 class="mt-2" style="font-size: 16px;"><?php echo $presente['nome'];?></h5>
					<div class="d-flex flex-column justify-content-center align-items-center">
					<?php if(empty($presente['nome_convidado'])):?>		<!-- Verificando se presente não foi escolhido -->
						<a href="edit-presentes.php?id=<?php echo $presente['id']?>" class="btn btn-warning btn-sm mt-2 font-weight-bold">
							Editar Presente
						</a>			
						<a href="excluir-presente.php?id=<?php echo $presente['id'];?>" class="btn btn-danger btn-sm mt-2 font-weight-bold"
							onclick="return window.confirm('Deseja mesmo excluir?');">
								Excluir Presente
						</a>						
					<?php else:?>										<!-- Caso tenha sido escolhido -->
						<p class="text-center text-muted mt-2">Não é possível excluir ou editar, pois o presente <strong>foi escolhido</strong>	</p>					
					<?php endif;?>	
					</div>					
				</div>				
			</div>			
		</div>
	<?php endforeach;?>	
	<?php if(empty($presentes)):?>
		<div class="col-md-12 alert alert-warning text-center">
			<h5>Não existem presentes nessa categoria!</h5>
		</div>	
	<?php endif;?>
	</div>		
</div>

<?php require_once "pages/footer.php";?>