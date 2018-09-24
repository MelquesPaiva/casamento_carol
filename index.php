<?php require_once "pages/header.php";?>

<div class="mb-5 container-fluid" style="min-width: 400px;">
	<div class="imgPrincipal rounded">
		<div class="foto1 text-center d-flex justify-content-center align-items-center flex-column">
			<h2 class="display-3 text-light font-italic text-center titulo">CAROL E RAFIQUE</h2>
			<p class="text-light font-weight-bold mt-3">Eu sei que a foto é minha e de nanda, mas é só para um exemplo</p>
			<a href="lista-presentes.php" class="btn btn-outline-info btn-lg text-white mt-4 linkLista">Lista de Presentes</a>
		</div>	
	</div>	
</div>


<div class="container d-flex justify-content-center align-items-center flex-column mb-3">
	<h4 class="display-4 mt-3 text-center font-italic subTitulo">Bem vindo ao nosso casório</h4>
	<p class="font-italic mt-3">Aqui entraria alguma frase simples</p>
	<hr style="width: 200px;" />
</div>
<div class="container mb-5 d-flex justify-content-center align-items-center">
	<div id="slideFotos" class="slide carousel" data-ride="carousel" data-interval="5000" data-pause="false">
		<ol class="carousel-indicators">
			<li data-target="#slideFotos" data-slide-to="0" class="active"></li>
			<li data-target="#slideFotos" data-slide-to="1"></li>
			<li data-target="#slideFotos" data-slide-to="2"></li>
			<li data-target="#slideFotos" data-slide-to="3"></li>
			<li data-target="#slideFotos" data-slide-to="4"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div class="imagem imagem1 img-thumbnail"></div>
			</div>
			<div class="carousel-item">
				<div class="imagem imagem2 img-thumbnail"></div>
			</div>
			<div class="carousel-item">
				<div class="imagem imagem3 img-thumbnail"></div>
			</div>
			<div class="carousel-item">
				<div class="imagem imagem4 img-thumbnail"></div>
			</div>
			<div class="carousel-item">
				<div class="imagem imagem5 img-thumbnail"></div>
			</div>
		</div>		
	</div>
</div>
<hr style="width: 200px;" />
<div class="container mt-5">
	<p class="text-center" style="font-size: 15px;">Aqui entraria um texto maior, que fica a critério de vcs. Eu estou mais é enrolado nesse texto, para vizualizar como fica a estrutura em um texto grande. É teile e zaga, é zaga e teile. Aqui entraria um texto maior, que fica a critério de vcs. Eu estou mais é enrolado nesse texto, para vizualizar como fica a estrutura em um texto grande. É teile e zaga, é zaga e teile</p>
</div>

<?php require_once "pages/footer.php";?>