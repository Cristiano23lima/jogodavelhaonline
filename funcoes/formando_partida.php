<?php 
	if($_POST){
		session_start();
		$id = (isset($_SESSION['id'])?$_SESSION['id']:null);
		$id_jog_adv = (isset($_POST['id_j'])?$_POST['id_j']:null);

		include 'classes/dados.php';
		$crud = new Crud();
		sleep(4);

		$param = array(":id"=>$id);
		$select  = $crud->select("SELECT id FROM tb_partida WHERE (id_jogador1 = :id OR id_jogador2 = :id) AND status = 1", $param);
		$cont = sizeof($select);
		if($cont > 0){
			echo $select[0][0];
		}else{
			$param = array(":id"=>$id_jog_adv);
			$select  = $crud->select("SELECT id FROM tb_partida WHERE (id_jogador1 = :id OR id_jogador2 = :id) AND status = 1", $param);
			$cont = sizeof($select);
			if($cont > 0){
				echo "Não tem jogador disponivel no momento.";
			}else{
				$param = array(":id"=>$id, ":id2"=>$id_jog_adv);
				$insert = $crud->crud("INSERT INTO tb_partida(id_jogador1, id_jogador2, status) VALUES(:id, :id2, 1)", $param);
				if($insert){
					$select = $crud->select("SELECT id FROM tb_partida ORDER BY id DESC LIMIT 1", NULL);
					$cont = sizeof($select);
					if($cont > 0){
						$jogada = array(":id"=>$id, ":id2"=>$id_jog_adv, ":partida"=>$select[0][0], ":status"=>0);
						$insert2 = $crud->crud("INSERT INTO tb_jogadas(id_partida, id_jogador1, id_jogador2, status) VALUES(:partida, :id, :id2, :status)", $jogada);
						$param = array(":partida"=>$select[0][0]);
						$insert = $crud->crud("INSERT INTO tb_jogo(id_partida, vez) VALUES(:partida, 0)", $param);
						$r2 = $crud->crud("INSERT INTO tb_rodadas(id_partida, rvj1, rvj2, re, quant_rodada) VALUES(:partida, 0, 0, 0, 3)", $param);
						if($insert){
							echo $select[0][0];
						}else{
							echo "Erro ao tentar criar o jogo";
						}
					}else{
						echo "Erro ao tentar começar a partida";
					}
				}else{
					echo "Erro! Houve um problema ao tentar encontrar jogador";
				}
			}
		}
	}
 ?>