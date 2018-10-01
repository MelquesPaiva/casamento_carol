<?php require_once "pages/header.php";?>
<?php require_once "classes/padrinhos.class.php";?>

<?php
$p = new Padrinhos();

$madrinhas = $p->getPadrinhos(0);
$padrinhos = $p->getPadrinhos(1);

?>

<div class="jumbotron imgPrincipal rounded text-center d-flex justify-content-center align-items-center flex-column" style="min-height: 400px;">
	<h2 class="display-3 text-light font-italic text-center titulo">CAROL E RAFIQUE</h2>
</div>

<div class="container p-5">
	<h3 class="display-4 font-italic subTitulo subTituloLista text-center">Nossos Padrinhos e Madrinhas</h3>
	<ul class="nav nav-tabs mt-5 mb-3" role="tablist">
		<li class="active">
			<a href="#madrinhas" class="btn" style="font-size: 20px;" data-toggle="tab" role="tab" aria-controls="madrinhas">Madrinhas</a>
		</li>
		<li class="active">
			<a href="#padrinhos" class="btn ml-5" style="font-size: 20px;" data-toggle="tab" role="tab" aria-controls="padrinhos">Padrinhos</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="padrinhos tab-pane active in fade" id="madrinhas">
		<?php foreach($madrinhas as $madrinha):?>
			<div class="row mb-3">			
				<div class="col-md-4">
					<img src="assets/images/padrinhos/<?php echo $madrinha['url_foto'];?>" class="img-thumbnail" />
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h5 class="display-4 text-center" style="font-size: 30px;"><?php echo $madrinha['nome'];?></h5>
						</div>
						<div class="card-body">
							<p><?php echo $madrinha['descricao'];?></p>
						<?php if(!empty($_SESSION['id'])):?>	
							<hr/>
							<div class="d-flex justify-content-center align-items-center">							
								<a href="edit-padrinho.php?id=<?php echo $madrinha['id'];?>" class="btn btn-warning btn-sm mt-2 font-weight-bold">
									Editar
								</a>			
								<a href="excluir-padrinho.php?id=<?php echo $madrinha['id'];?>" class="btn btn-danger btn-sm ml-2 mt-2 font-weight-bold" onclick="return window.confirm('Deseja mesmo excluir?');">
									Excluir
								</a>								
							</div>	
						<?php endif;?>			
						</div>
					</div> 			
				</div>
			
			</div>
		<?php endforeach;?>
		</div>	
		<div class="padrinhos tab-pane fade" id="padrinhos">
		<?php foreach($padrinhos as $padrinho):?>	
			<div class="row">			
				<div class="col-md-4">
					<img src="assets/images/padrinhos/<?php echo $padrinho['url_foto'];?>" class="img-thumbnail"/>
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h5 class="display-4 text-center" style="font-size: 30px;"><?php echo $padrinho['nome'];?></h5>
						</div>
						<div class="card-body">
							<p><?php echo $padrinho['descricao'];?></p>
						<?php if(!empty($_SESSION['id'])):?>
							<hr/>	
							<div class="d-flex justify-content-center align-items-center">							
								<a href="edit-padrinho.php?id=<?php echo $padrinho['id'];?>" class="btn btn-warning btn-sm mt-2 font-weight-bold">
									Editar Presente
								</a>			
								<a href="excluir-padrinho.php?id=<?php echo $padrinho['id'];?>" class="btn btn-danger btn-sm ml-2 mt-2 font-weight-bold"
									onclick="return window.confirm('Deseja mesmo excluir?');">
										Excluir Presente
								</a>								
							</div>	
						<?php endif;?>			
						</div>
					</div> 			
				</div>			
			</div>
		<?php endforeach;?>		
		</div>
	</div>	
</div>

<?php require_once "pages/footer.php";?>