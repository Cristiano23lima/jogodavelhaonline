<?php 
	include "funcoes/classes/dados.php";
	
	$crud = new Crud();
	$param = array(":id"=>$_SESSION['id']);
	$result = $crud->select("SELECT s.vitorias as vitorias, s.derrotas as derrotas, s.empates as empates, r.pontos as pontos, u.nome as nome, u.email as email FROM tb_usuario AS u INNER JOIN tb_status as s ON u.id = s.id_usuario INNER JOIN tb_rank as r ON u.id = r.id_usuario WHERE u.id = :id", $param);
 ?>
<div class="container d-flex justify-content-center">
	<div class="card d-flex justify-content-center">
	  <h5 class="card-header">Meus Dados</h5>
	  <div class="card-body">
	  	<div class="row">
	  		<div id="profile">
		  		<img src="<?php echo $link; ?>img/logo/cats.jpg" class="perfil">
	  		</div>
	  		<div id="description">
		  		<h5 class="card-subtitle mb-2 text-muted">Dados Pessoais</h5>
			    <div class="row">
			    	<div class="col-md-4">
						<label>Nome: </label><br>
						<b><?php echo $result[0]['nome']; ?></b>
					</div>
					<div class="col-md-4">
						<label>Email do Jogador: </label>
						<b><?php echo $result[0]['email']; ?></b>
					</div>
					<div class="col-md-4">
						<label>Senha: </label><br>
						<!-- <button class="btn btn-success" type="button" data-target="#mudarSenha" data-toggle="modal">Mudar Senha</button> -->
					</div>
			    </div>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-10 col-sm-12">
			    <h5 class="card-subtitle mb-2 text-muted">Situação</h5>
			    <div class="row">
			    	<div class="col-md-4">
			    		<label>Vitorias: </label>
			    		<b><?php echo $result[0]['vitorias']; ?></b>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Empates: </label>
			    		<b><?php echo $result[0]['empates']; ?></b>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Derrotas: </label>
			    		<b><?php echo $result[0]['derrotas']; ?></b>
			    	</div>
			    </div><br>
			    <h5 class="card-subtitle mb-2 text-muted">Pontuação</h5>
			    <div class="row">
			    	<div class="col-md-4">
			    		<label>Pontos: </label>
			    		<b><?php echo $result[0]['pontos'];  ?></b>
			    	</div>
			    </div>
	  		</div>
	  	</div>
	  </div>
	</div>
</div>
<div class="modal fade" id="mudarSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mudar a senha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="pages/conta/mudarSenha.php" method="post">
	      <div class="modal-body">
	        <div class="row">
	        	<div class="form-group">
	        		<div class="col-md-12">
	        			<label class="col-md-12">Senha Atual: </label>
	        			<div class="col-md-12">
	        				<input type="text" name="senhaAntiga" class="form-control" autocomplete="off" id="senhaAntiga">
	        				<div id="msgError"></div>
	        			</div>
	        		</div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="form-group">
	        		<div class="col-md-12">
	        			<label class="col-md-12">Nova senha: </label>
	        			<div class="col-md-12">
	        				<input type="password" name="novaSenha" class="form-control" autocomplete="off">
	        			</div>
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	        <button class="btn btn-primary" id="buttonMudar" type="submit">Mudar</button>
	      </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="script/ajax.js"></script>
