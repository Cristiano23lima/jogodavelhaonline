<?php 
	session_start();
	if(isset($_SESSION['id'])){
		header("location: ../tabuleiro");
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>JOGO DA VELHA ONLINE</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="../plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../plugins/bootstrap/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="../css/custom.css">
	<link rel="shortcut icon" href="../img/logo/icon.ico">
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
</head>
<body style="overflow-x: hidden;">
	<div class="">
		<div class="row" id="logo">
			<img src="../img/logo/logo3.png" class="rounded mx-auto d-block" alt="CR Sistemas">
		</div>
		<div id="login">
			<div class="row d-flex justify-content-center">
				<div class="card col-md-5 col-sm-9">
					<div class="card-body col-md-12 m-4 pl-5">
						<h5>Fazer Login na conta</h5>
						<?php include "funcoes/cadastro.php"; 
							if(isset($_SESSION['error']) && $_SESSION['error'] == 0){ ?>
								<div class="alert alert-danger alert-dismissible fade show col-md-9" role="alert">
								  ERRO! não foi possivel fazer a verificação de login.
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								  </button>
								</div>
							<?php unset($_SESSION['error']); }else if(isset($_SESSION['error']) && $_SESSION['error'] == 1){ ?>
								<div class="alert alert-danger alert-dismissible fade show col-md-9" role="alert">
								  Usuario ou senha incorretos.
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								  </button>
								</div>
							<?php unset($_SESSION['error']);	}
							?>
						<form action="../funcoes/login.php" method="post" data-parsley-validate>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 col-sm-12 col-lg-3" for="email">Email*</label>
										<div class="col-md-9 col-sm-12 col-lg-9">
											<input type="email" name="email" required maxlength="200" class="form-control" placeholder="Email da conta" id="email" data-parsley-type="email">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3" for="senha">Senha*</label>
										<div class="col-md-9">
											<input type="password" name="senha" maxlength="60" required  class="form-control" placeholder="Senha da conta">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-primary m-3">Entrar</button>
								</div>
							</div>
						</form>
						<a href="#" class="btn btn-default" id="button_cadastrar">Fazer cadastro</a>
					</div>
				</div>
			</div>
		</div>

		<!--Formulario de cadastro-->
		<div id="cadastro" class="active_form">
			<div class="row d-flex justify-content-center">
				<div class="card col-md-5 col-sm-12">
					<div class="card-body col-md-12 m-4 pl-5">
						<h5>Cadastro de Usuário</h5>
						<form action="" method="post" data-parsley-validate>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="col-md-3 col-sm-12 col-lg-3" for="nome">Nome*</label>
										<div class="col-md-9">
											<input type="text" name="nome" required maxlength="60" class="form-control" placeholder="Nome de identificação" id="nome">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="col-md-3 col-sm-12 col-lg-3" for="email">Email*</label>
										<div class="col-md-9">
											<input type="email" name="email" required maxlength="200" class="form-control" placeholder="Endereço de email" data-parsley-type="email">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="col-md-3" for="senha">Senha*</label>
										<div class="col-md-9">
											<input type="password" name="senha" maxlength="60" required  class="form-control" placeholder="senha para entrar" id="senha_c">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label class="col-md-3" for="senha">Re-digite a senha*</label>
										<div class="col-md-9">
											<input type="password" name="resenha" maxlength="60" required class="form-control" placeholder="Re-digite a senha" id="resenha">
											<div id="msg-error-senha"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<button class="btn btn-primary m-3" id="btn_cadastro">Entrar</button>
									</div>
								</div>
							</div>
						</form>
						<a href="#" class="btn btn-default" id="button_login">Voltar ao login</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	 <script src="../plugins/jquery.min.js" type="text/javascript"></script>
	 <script type="text/javascript" src="../plugins/bootstrap/js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="../plugins/parsley/dist/parsley.min.js"></script>
	 <script type="text/javascript" src="../plugins/parsley/dist/i18n/pt-br.js"></script>
	 <script type="text/javascript" src="../script/script.js"></script>
</body>
</html>