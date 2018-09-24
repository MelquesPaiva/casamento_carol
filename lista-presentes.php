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


if(isset($_GET['categoria']) && !empty($_GET['categoria'])) {
	$nCategoria = addslashes($_GET['categoria']);
	$presentes = $p->getPresentes($nCategoria);
} else {
	$presentes = $p->getPresentes();
}

if(isset($_POST['nomeConvidado']) && !empty($_POST['nomeConvidado'])) {
	$nomeConvidado = addslashes($_POST['nomeConvidado']);
	$idPresente = addslashes($_POST['idPresente']);
	$p->inserirNomeConvidado($idPresente, $nomeConvidado);
	$salvo = 1;
}

?>

<div class="jumbotron imgPrincipal rounded text-center d-flex justify-content-center align-items-center flex-column" style="min-height: 400px;">
	<h2 class="display-3 text-light font-italic text-center titulo">CAROL E RAFIQUE</h2>
</div>

<div class="container">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h3 class="display-4 font-italic mt-5 subTitulo subTituloLista">Nossa Lista de Presentes</h3>
		<p class="font-italic mt-4" style="font-size: 18px;">Monte nosso novo lar, junto com a gente.</p>
		<form method="GET" class="mt-5">
			<div class="form-group d-flex filtro">
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
	<?php
	foreach ($presentes as $presente) {
	?>		
		<div class="col-md-4">
			<div class="card mt-2" style="height: 450px;">
				<div class="card-header">
					<h5><?php echo utf8_encode($presente['categoria']);?></h5>
				</div>
				<div class="card-body presentes d-flex align-items-center flex-column">
					<img src="assets/images/presentes/<?php echo $presente['url_foto'];?>" class="img-thumbnail" border="0"/>
					<h5 class="mt-2" style="font-size: 16px;"><?php echo $presente['nome'];?></h5>
					<form method="POST" class="mt-2" style="bottom: 0; position: absolute;"
					 onsubmit="return confirm('Deseja escolher este presente?')">
						<div class="form-group">
							<input type="number" name="idPresente" hidden="true" value="<?php echo $presente['id'];?>" />
							<input type="text" name="nomeConvidado" placeholder="Digite seu nome" class="form-control" required="required" />
							<input type="submit" name="enviar" value="Escolher este presente" class="mt-2 btn btn-primary btn-block"/>
						</div>
					</form>
				</div>				
			</div>			
		</div> 
	<?php	
	}
	if(empty($presentes)) {
	?>
		<div class="col-md-12 alert alert-warning text-center">
			<h5>Não existem presentes nessa categoria!</h5>
		</div>	
	<?php	
	}
	?>
	</div>		
</div>

<?php require_once "pages/footer.php";?>