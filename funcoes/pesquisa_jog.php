<?php 
	if ($_POST) {
		include "classes/dados.php";
		$id = (isset($_POST['id_jogador'])?$_POST['id_jogador']:null);

		$crud = new Crud();
		$param = array(':id_jogador'=>$id);
		sleep(3);
		$r = $crud->crud("UPDATE tb_procura_jog SET procura = 1 WHERE id_jogador = :id_jogador", $param);
		if($r){
			sleep(6);
			$res = $crud->select("SELECT id_jogador FROM tb_procura_jog WHERE id_jogador != :id_jogador and procura = 1 LIMIT 1", $param);//puxa o id de algum jogador que esteja procurando uma partida online
			$cont = sizeof($res);
			if($cont >= 0){ //verifica se o valor do res retornou algo, se nao ele passa para msg de erro
				if($cont > 0){//verifica se encontrou algum jogador
					sleep(6);
					$param = array(":id1"=>$id, ":id2"=>$res[0][0]);
					$r = $crud->crud("UPDATE tb_procura_jog SET procura = 0 WHERE id_jogador = :id1 || id_jogador = :id2", $param);//quando dar tudo ok, os jogadores começam uma nova partida
					if($r){
						$cont = sizeof($res);
						if($cont > 0){
							echo $res[0][0];//retorna o id do jogador
						}else{
							$vet = array(":id"=>$id);
							$select = $crud->select("SELECT id_jogador1, id_jogador2 FROM tb_partida WHERE (id_jogador1 = :id OR id_jogador2 = :id) AND status = 1", $vet);
							$cont = sizeof($select);
							if($cont > 0){
								$rest = ($select[0][0] == $id)? $select[0][1]: $select[0][0];
								echo $rest;
							}else{
								echo "Não possui jogador disponivel no momento. Tente novamente mais tarde";
							}
						}
					}else{
						echo "Erro ao se conectar com o jogador";
					}
				}else{//se nao retorna as msgs de erro
					$param = array(":id1"=>$id);
					$r = $crud->crud("UPDATE tb_procura_jog SET procura = 0 WHERE id_jogador = :id1", $param);//quando dar tudo ok, os jogadores começam uma nova partida
					if($r){
						$vet = array(":id"=>$id);
						$select = $crud->select("SELECT id_jogador1, id_jogador2 FROM tb_partida WHERE (id_jogador1 = :id OR id_jogador2 = :id) AND status = 1", $vet);
						$cont = sizeof($select);
						if($cont > 0){
							$rest = ($select[0][0] == $id)? $select[0][1]: $select[0][0];
							echo $rest;
						}else{
							echo "Não possui jogador disponivel no momento. Tente novamente mais tarde";
						}
					}else{
						echo "Erro na procura de jogador";
					}
				}
			}else{
				echo "Erro na busca de jogadores";
			}			
		}else{
			echo "Erro ao tentar procurar jogador. Tente novamente mais tarde";
		}
	}

 ?>