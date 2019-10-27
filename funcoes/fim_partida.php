<?php 
	if($_POST){
		$partida = isset($_POST['partida'])?$_POST['partida']:0;
		$result = isset($_POST['result'])?$_POST['result']:null;

		include 'classes/dados.php';

		$crud = new Crud();
		$vetor = array(":id"=>$partida);
		$select = $crud->select("SELECT id_jogador1, id_jogador2 FROM tb_partida WHERE id = :id", $vetor);

		$data = array(":id"=>$partida);
		$updatePartida = $crud->crud("UPDATE tb_partida SET status = 0 WHERE id = :id", $data);
		if($updatePartida){
			session_start();
			if($result == 1){
				if($select[0]['id_jogador1'] == $_SESSION['id']){
					//update do jogador 1
					$dataUpdate = array(":id"=>$select[0]['id_jogador1']);
					$updateStatus = $crud->crud("UPDATE tb_status SET vitorias = vitorias+1 WHERE id_usuario = :id", $dataUpdate);
					$updateRank = $crud->crud("UPDATE tb_rank SET pontos = pontos+3 WHERE id_usuario = :id", $dataUpdate);

					//update do jogador 2
					$dataUpdate2 = array(":id"=>$select[0]['id_jogador2']);
					$updateStatus2 = $crud->crud("UPDATE tb_status SET derrotas = derrotas+1 WHERE id_usuario = :id", $dataUpdate2);

					$dataP = array(":id"=>$partida);
					$updateJog = $crud->crud("UPDATE tb_jogadas SET status = 1 WHERE id_partida = :id", $dataP);
					echo $select[0]['id_jogador1'];
				}else{
					echo $select[0]['id_jogador1'];
				}
			}elseif($result == 2){
				if($select[0]['id_jogador2'] == $_SESSION['id']){
					//update do jogador 2
					$dataUpdate = array(":id"=>$select[0]['id_jogador2']);
					$updateStatus = $crud->crud("UPDATE tb_status SET vitorias = vitorias+1 WHERE id_usuario = :id", $dataUpdate);
					$updateRank = $crud->crud("UPDATE tb_rank SET pontos = pontos+3 WHERE id_usuario = :id", $dataUpdate);

					//update do jogador 1
					$dataUpdate2 = array(":id"=>$select[0]['id_jogador1']);
					$updateStatus2 = $crud->crud("UPDATE tb_status SET derrotas = derrotas+1 WHERE id_usuario = :id", $dataUpdate2);

					$dataP = array(":id"=>$partida);
					$updateJog = $crud->crud("UPDATE tb_jogadas SET status = 2 WHERE id_partida = :id", $dataP);
					echo $select[0]['id_jogador2'];
				}else{
					echo $select[0]['id_jogador2'];
				}
			}else{
				$data = array(":id1"=>$_SESSION['id']);
				$update = $crud->crud("UPDATE tb_status SET empates = empates+1 WHERE id_usuario = :id1", $data);
				$updateRank = $crud->crud("UPDATE tb_rank SET pontos = pontos+1 WHERE id_usuario = :id1", $data);

				$dataP = array(":id"=>$partida);
				$updateJog = $crud->crud("UPDATE tb_jogadas SET status = 3 WHERE id_partida = :id", $dataP);
				echo 3;
			}
		}else{
			echo "Erro ao tentar finalizar a partida";
		}

	}
 ?>