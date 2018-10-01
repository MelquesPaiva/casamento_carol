<?php require_once "pages/header.php";?>
<?php require_once "classes/categoria.class.php";?>
<?php require_once "classes/presentes.class.php";?>

<?php
$p = new Presentes();
$c = new Categoria();
$categorias = $c->getCategorias();
$salvo = 0;

if(empty($_SESSION['id'])) {
	unset($categorias);	
	header("Location:index.php");
	exit;
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
	$presente = $p->getPresentesPorId($id);	
	if(isset($_POST['nomeItem']) && !empty($_POST['nomeItem'])) {
		$idCategoria = addslashes($_POST['categoria']);
		$nomeItem = addslashes($_POST['nomeItem']);

		if(isset($_FILES['foto'])) {
			$foto = $_FILES['foto'];	
		} else {
			$foto = array();
		}

		$max_pessoas = addslashes($_POST['max_pessoas']);

		$p->editarPresente($id, $idCategoria, $nomeItem, $foto, $max_pessoas);
		$salvo = 1;		
	}	
		
} else {
	header("Location: lista2-presentes.php");
}


?>

<div class="container">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h1 class="display-4 font-italic" style="font-size: 35px;">Página de edição</h1>	
		<?php if($salvo == 1):?>
			<div class="alert alert-success mt-4">
				<h5>Presente editado com sucesso!!</h5>
				<a href="lista2-presentes.php">Ir para página de edição</a>
			</div>
		<?php endif;?>	
		<form method="POST" enctype="multipart/form-data" style="min-width: 300px;">			
			<div class="form-group mt-5">
				<label for="categoria">Selecione a categoria:</label>
				<select class="form-control" name="categoria" id="categoria" required="true">
				<?php foreach ($categorias as $categoria):?>
					<!-- Se o id da categoria, for igual ao do presente encontrado, categoria será selecionada -->
					<?php if($categoria['id'] == $presente['id_categoria']):?>	
					<option value="<?php echo $categoria['id']?>" selected="selected">
						<?php echo utf8_encode($categoria['nome_categoria'])?>							
					</option>
					<?php else:?>
					<option value="<?php echo $categoria['id']?>">
						<?php echo utf8_encode($categoria['nome_categoria'])?>							
					</option>
					<?php endif;?>	
				<?php endforeach;?>	
				</select>				
			</div>
			<div class="form-group">	
				<label for="nomeItem">Nome do item:</label>
				<input type="text" name="nomeItem" id="nomeItem" class="form-control" required="true"
				 		value="<?php echo $presente['nome']?>" />
			</div>		
			<div class="form-group">
				<label for="add-foto">Nova foto do presente:</label><br/>
				<input type="file" name="foto[]" multiple="false" id="add-foto" />
				<div class="card mt-3" style="height: 300px;">
					<div class="card-header">Foto do presente:</div>
					<div class="card-body presentes d-flex align-items-center flex-column">
						<img src="assets/images/presentes/<?php echo $presente['url_foto'];?>" class="img-thumbnail" border="0"/>
						<h5 class="mt-2" style="font-size: 16px;"><?php echo $presente['nome'];?></h5>
					</div>
				</div>
			</div>	
			<div class="form-group">
				<label for="max_pessoas">Máximo de pessoas</label>
				<input type="number" name="max_pessoas" id="max_pessoas" value="<?php echo $presente['max_pessoas']?>" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="submit" name="enviar" value="Atualizar Presente" class="btn btn-primary btn-block"/>
			</div>
		</form>		
	</div>	
</div>

<?php require_once "pages/footer.php";?>