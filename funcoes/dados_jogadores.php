<?php 
	if($_POST){
		session_start();
		$id_adv = isset($_POST['id_adv'])?$_POST['id_adv']:null;
		$id = isset($_SESSION['id'])?$_SESSION['id']:null;

		include "classes/dados.php";

		$crud = new Crud();
		$param = array(":id_adv"=>$id_adv, ":id"=>$id);
		$res = $crud->select("SELECT id, nome FROM tb_usuario WHERE id = :id_adv OR id = :id", $param);

		$data = array();
		for($i = 0; $i < sizeof($res); $i++){
			$data_array = array();
			$data_array['id'] = $res[$i][0];
			$data_array['nome'] = $res[$i][1];
			
			
			$data[] = $data_array;
		}
		echo json_encode($data);
	}
 ?>