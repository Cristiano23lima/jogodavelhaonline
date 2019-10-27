<?php 
	if($_POST){
		$partida = isset($_POST['partida'])?$_POST['partida']:null;
		$rodada = isset($_POST['rodada'])?$_POST['rodada']:null;
		$venc_jog1 = isset($_POST['venc_jog1'])?$_POST['venc_jog1']:null;
		$venc_jog2 = isset($_POST['venc_jog2'])?$_POST['venc_jog2']:null;
		$empate = isset($_POST['empate'])?$_POST['empate']:null;
		include "classes/dados.php";

		$crud = new Crud();

		$param = array(":partida"=>$partida);
		$param2 = array(":partida"=>$partida, ":re"=>$empate, ":rodada"=>$rodada, ":j1"=>$venc_jog1, ":j2"=>$venc_jog2);
		$r = $crud->crud("DELETE FROM tb_jogadas_realizada WHERE id_partida = :partida", $param);
		if($r){
			$resp = $crud->crud("UPDATE tb_rodadas SET re = :re, quant_rodada = :rodada, rvj1 = :j1, rvj2 = :j2 WHERE id_partida = :partida", $param2);
			if($resp){
				echo "Tabuleiro vai ser reiniciado";
			}else{
				echo "Houve um problema na reinicialização do tabuleiro";
			}
		}else{
			echo "Erro ao tentar reiniciar o tabuleiro";
		}
	}
 ?>