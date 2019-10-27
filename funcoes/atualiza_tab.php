<?php 
	include "classes/dados.php";
	$crud = new Crud();
	$jogada = new Jogadas();

	//fica atualizando o tabuleiro

	$jogada->setId_partida(isset($_POST['partida'])?$_POST['partida']:null);

	$param = array(":partida"=>$jogada->getId_partida());
	$dados = $crud->select("SELECT id_partida, id_jogador, posicao, peca FROM tb_jogadas_realizada WHERE id_partida = :partida", $param);
	$r = sizeof($dados);
	$tab = array();
	//vai preenchendo o array com as colunas do tabuleiro preenchidas
	for($i = 0; $i < $r; $i++){
		$tab_array = array();
		$tab_array['partida'] = $dados[$i][0];
		$tab_array['jogador'] = $dados[$i][1];
		$tab_array['posicao'] = $dados[$i][2];
		$tab_array['peca'] = $dados[$i][3];

		$tab[] = $tab_array;
	}
	echo json_encode($tab);
 ?>