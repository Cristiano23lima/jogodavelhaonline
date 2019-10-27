<?php 
	include "funcoes/classes/verif.php"; 

	$pagina = isset($_GET['pagina'])?$_GET['pagina']:null; 
	if(!empty($pagina)){
		$link = '../';
	}else{
		$link = '';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jogo da Velha</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>plugins/bootstrap/css/bootstrap-grid.min.css">
	<link rel="shortcut icon" href="<?php echo $link; ?>img/logo/icon.ico">
	<?php 
		$pg = isset($_GET['pg'])?$_GET['pg']:null;
		if($pg == "rank"){
			echo '<link rel="stylesheet" type="text/css" href="'.$link.'plugins/datatables/datatables.min.css"/>';
		}
	 ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>css/style.css">
	<script src="<?php echo $link; ?>plugins/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="content">
		<?php 
			$pg = (isset($_GET['pg'])?$_GET['pg']:null);
			$nome = 'cristiano';
		 ?>
		<div id="menu">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			  <a class="navbar-brand" href="#">
			    <img src="<?php echo $link; ?>img/logo/ico.png" width="35" height="35" class="d-inline-block align-top" alt="Logo">
			  </a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item <?php if($pg=='tabuleiro' or $pg == null){ echo 'active'; } ?>">
			        <a class="nav-link" href="<?php echo $link; ?>tabuleiro">Jogo <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item <?php if($pg=='rank'){ echo 'active'; } ?>">
			        <a class="nav-link" href="<?php echo $link; ?>rank/1">Rank</a>
			      </li>
			      <li class="nav-item dropdown <?php if($pg=='amigos' || $pg=='meusamigos'){ echo 'active'; } ?>">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          Amigos
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item <?php if($pg=='amigos'){ echo 'active'; } ?>" href="<?php echo $link; ?>amigos">Procurar novos amigos</a>
			          <a class="dropdown-item <?php if($pg=='meusamigos'){ echo 'active'; } ?>" href="<?php echo $link; ?>meusamigos">Meus amigos</a>
			        </div>
			      </li>
			      <li class="nav-item dropdown <?php if($pg=='status'){ echo 'active'; } ?>">
			        <a class="nav-link dropdown-toggle profile" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          <img src="<?php echo $link; ?>img/logo/cats.jpg" class="image-profile">
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item <?php if($pg=='status'){ echo 'active'; } ?>" href="<?php echo $link; ?>status">Meu Dados</a>
			          <a class="dropdown-item" href="#sair" data-toggle="modal">Sair</a>
			        </div>
			      </li>
			    </ul>
			  </div>
			</nav>
			<!-- modal de confirmação de saida -->
			<div class="modal fade" id="sair" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Deseja realmente sair?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			        <a href="<?php echo $link; ?>logout" class="btn btn-primary">Sair</a>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		<div id="conteudo">
			<?php 
				$pg = (isset($_REQUEST['pg'])?$_REQUEST['pg']: null);

				if (file_exists("pages/$pg.php")) {
					include "pages/$pg.php";
				}else{
					include "pages/tabuleiro.php";
				}
			 ?>
		</div>
		<div id="rodape">
			
		</div>
	</div>
 	<script type="text/javascript" src="<?php echo $link; ?>plugins/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>