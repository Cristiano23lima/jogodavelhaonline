<?php 
	if($_POST){
		include "classes/dados.php";
		$nome = isset($_POST['nome'])?$_POST['nome']:null;
		$email = isset($_POST['email'])?$_POST['email']:null;
		$senha = isset($_POST['senha'])?$_POST['senha']:null;

		$usuarios = new Usuarios();
		$usuarios->setNome($nome);
		$usuarios->setEmail($email);
		$usuarios->setSenha($senha);

		$sql2 = "SELECT * FROM tb_usuario WHERE email = :email";
		$vetor2 = array(':email'=>$usuarios->getEmail());
		$result = $usuarios->select_multiplo($sql2, $vetor2);//verifica se o email que vai ser cadastrado já existe no sistema
		if($result == 2){ ?>
			<div class="alert alert-danger alert-dismissible fade show col-md-9" role="alert">
			  Email já existente no sistema. Por favor tente com outro email.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
		<?php }else if($result == 1){
			$sql = "INSERT INTO tb_usuario(nome, email, senha) VALUES(:nome, :email, :senha)";
			$vetor = array(':nome' => $usuarios->getNome(), ':email' => $usuarios->getEmail(), ':senha' => md5($usuarios->getSenha()));
			if($usuarios->inserir($sql, $vetor)){ 
				$crud = new Crud();
				$r = $crud->select("SELECT id FROM tb_usuario ORDER BY id DESC LIMIT 1", NULL);
				$param = array(":usuario"=>$r[0][0], ":pontos"=>0);
				$param2 = array(":usuario"=>$r[0][0], ":v"=>0, ":e"=>0, ":d"=>0);
				$param3 = array(":usuario"=>$r[0][0], ":p"=>0);
				$crud->crud("INSERT INTO tb_rank(id_usuario, pontos) VALUES(:usuario, :pontos)", $param);//inserir o usuario cadastrado no rank
				$crud->crud("INSERT INTO tb_status(id_usuario, vitorias, empates, derrotas) VALUES(:usuario, :v, :e, :d)", $param2);//insere o status inicial do usuario
				$crud->crud("INSERT INTO tb_procura_jog(id_jogador, procura) VALUES(:usuario, :p)", $param3);//insere o status inicial do usuario
				?>
				<div class="alert alert-success alert-dismissible fade show col-md-9" role="alert">
				  Cadastro efetuado com sucesso.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
	<?php	
			}else{ ?>
				<div class="alert alert-danger alert-dismissible fade show col-md-9" role="alert">
				  Erro ao tentar cadastra-lo no sistema.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
	<?php		}
		}else{ ?>
			<div class="alert alert-danger alert-dismissible fade show col-md-9" role="alert">
			  Erro ao tentar verificar email.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
	<?php	}
	}
 ?>