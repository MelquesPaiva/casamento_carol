<?php require_once "pages/header.php";?>
<?php require_once "classes/padrinhos.class.php";?>

<?php
if(empty($_SESSION['id'])) {
	unset($categorias);	
	header("Location:index.php");
	exit;
}

$p = new Padrinhos();

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
	$padrinho = $p->buscaPorId($id);

	if(isset($_POST['nome']) && !empty($_POST['nome'])) {
		$sexo = addslashes($_POST['pm']);
		$nome = addslashes($_POST['nome']);
		if(isset($foto)) {
			$foto = $_FILES['foto'];	
		} else {
			$foto = array();
		}		
		$descricao = addslashes($_POST['descricao']);

		$p->editPadrinho($id, $nome, $foto, $sexo, $descricao);

		$salvo = 1;
	}	
}
?>

<div class="container">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h1 class="display-4 font-italic" style="font-size: 35px;">Página para adição dos padrinhos</h1>
		<form method="POST" enctype="multipart/form-data" style="min-width: 300px;">			
			<div class="form-group mt-5">
				<label for="pm">Padrinho ou Madrinha?</label>
				<select class="form-control" name="pm" id="pm" required="true">
					<option></option>
					<option value="0" <?php echo ($padrinho['sexo'] == '0')?'selected':'';?>>Madrinha</option>
					<option value="1" <?php echo ($padrinho['sexo'] == '1')?'selected':'';?>>Padrinho</option>
				</select>				
			</div>
			<div class="form-group">	
				<label for="nome">Nome:</label>
				<input type="text" name="nome" id="nome" class="form-control" value="<?php echo $padrinho['nome'];?>" />
			</div>		
			<div class="form-group">
				<label for="add-foto">Foto da pessoa:</label><br/>
				<input type="file" name="foto[]" multiple="false" id="add-foto" />
			</div>	
			<div class="form-group">
				<label for="descricao">Diga algo sobre a(o) Madrinha/Padrinho</label>
				<textarea name="descricao" id="descricao" class="form-control"><?php echo $padrinho['descricao'];?></textarea>
			</div>
			<div class="form-group">
				<input type="submit" name="enviar" value="Salvar Pessoa" class="btn btn-primary btn-block"/>
			</div>
		</form>
	<?php if(isset($salvo)):?>
		<div class="alert alert-success">
			Edição concluida com sucesso!!
		</div>
	<?php endif;?>
	</div>	
</div>


<?php require_once "pages/footer.php";?>