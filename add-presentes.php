<?php require_once "pages/header.php";?>
<?php require_once "classes/categoria.class.php";?>
<?php require_once "classes/presentes.class.php";?>

<?php
$c = new Categoria();
$presente = new Presentes();
$categorias = $c->getCategorias();
$salvo = 0;

if(empty($_SESSION['id'])) {
	unset($categorias);	
	header("Location:index.php");
	exit;
}

if(isset($_POST['nomeCategoria']) && !empty($_POST['nomeCategoria'])) {
	// Enviar uma nova categoria, caso n seja setado, é para enviar um novo presente
	
	$nomeCategoria = addslashes($_POST['nomeCategoria']);
	$c->novaCategoria($nomeCategoria);
	header("Location: add-presentes.php");
} elseif(isset($_POST['nomeItem']) && !empty($_POST['nomeItem'])) {
	$idCategoria = addslashes($_POST['categoria']);
	$nomeItem = addslashes($_POST['nomeItem']);
	
	if(isset($_FILES['foto'])) {
		$foto = $_FILES['foto'];	
	} else {
		$foto = array();
	}

	$presente->inserirPresente($idCategoria, $nomeItem, $foto);
	$salvo = 1;
}

?>

<div class="container">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h1 class="display-4 font-italic" style="font-size: 35px;">Página excluiva para adição de presentes</h1>
		<button class="btn btn-warning mt-5" style="width: 300px;" data-toggle="modal" data-target="#modalCategoria">
			Nova Categoria
		</button>
		<form method="POST" enctype="multipart/form-data" style="min-width: 300px;">			
			<div class="form-group mt-5">
				<label for="categoria">Selecione a categoria:</label>
				<select class="form-control" name="categoria" id="categoria" required="true">
					<?php
					foreach ($categorias as $categoria) {
						echo '<option value="'.$categoria['id'].'">'.utf8_encode($categoria['nome_categoria']).'</option>';
					}
					?>
				</select>				
			</div>
			<div class="form-group">	
				<label for="nomeItem">Nome do item:</label>
				<input type="text" name="nomeItem" id="nomeItem" class="form-control"/>
			</div>		
			<div class="form-group">
				<label for="add-foto">Foto do presente:</label><br/>
				<input type="file" name="foto[]" multiple="false" id="add-foto" />
			</div>	
			<div class="form-group">
				<input type="submit" name="enviar" value="Salvar Presente" class="btn btn-primary btn-block"/>
			</div>
		</form>
		<?php
		if($salvo == 1) {			
		?>
			<div class="alert alert-success">
				Presente adicionado com sucesso!!
			</div>
		<?php	
		}
		?>
	</div>	
</div>

<div id="modalCategoria" class="modal fade">
	<div class="modal-dialog moda-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Adicione a nova categoria</h5>
				<button class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form method="POST">
					<div class="form-group">
						<label for="nomeCategoria">Digite o nome da categoria</label>
						<input type="text" name="nomeCategoria" id="nomeCategoria" class="form-control"/><br/>
						<input type="submit" name="enviar" value="Salvar Categoria" class="btn btn-primary btn-block"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require_once "pages/footer.php";?>