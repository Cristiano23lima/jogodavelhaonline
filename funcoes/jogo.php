<?php 
	if($_POST){
		include "classes/dados.php";
		session_start();
		$crud = new Crud();
		$jogada = new Jogadas();

		$jogada->setPosicao(isset($_POST['posicao'])?$_POST['posicao']:null);
		$jogada->setId_jogador(isset($_SESSION['id'])?$_SESSION['id']:null);
		$jogada->setId_partida(isset($_POST['id_partida'])?$_POST['id_partida']:null);
		$jogada->setPeca(isset($_POST['peca'])?$_POST['peca']:null);

		$param = array(":id_p"=>$jogada->getId_partida(), ':id_j'=>$jogada->getId_jogador(), ':po'=>$jogada->getPosicao(), ':pe'=>$jogada->getPeca());

		$resposta = $crud->crud("INSERT INTO tb_jogadas_realizada(id_partida, id_jogador, posicao, peca) VALUES(:id_p, :id_j, :po, :pe)", $param);
		if($resposta){
			$param = array(":partida"=>$jogada->getId_partida());
			
			$r = $crud->select("SELECT vez FROM tb_jogo WHERE id_partida = :partida", $param);
			$vez_j = ($r[0][0] == 0)?1:0;

			$param = array(":vez"=>$vez_j, ":partida"=>$jogada->getId_partida());
			$res = $crud->crud("UPDATE tb_jogo SET vez = :vez WHERE id_partida = :partida", $param);
			if($res){
				echo 1;
			}else{
				echo "Erro ao passar a vez";
			}			
		}else{
			echo 0;
		}

		//tem que inserir a jogada que o jogador fez para puder mostrar o tabuleiro preenchido com as respectivas valores inseridos  
		
	}
 ?>