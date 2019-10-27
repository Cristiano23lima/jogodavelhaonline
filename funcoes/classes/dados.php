<?php
	include "conexao.php";

	class Usuarios{
		private $id;
		private $nome;
		private $email;
		private $senha;

		public function __construct(){}


		public function getId(){
			return $this->id;
		}
		public function setId(int $id){
			$this->id = $id;
		}

		public function getNome(){
			return $this->nome;
		}
		public function setNome(string $nome){
			$this->nome = $nome;
		}

		public function getEmail(){
			return $this->email;
		}
		public function setEmail(string $email){
			$this->email = $email;
		}

		public function getSenha(){
			return $this->senha;
		}
		public function setSenha(string $senha){
			$this->senha = $senha;
		}

		public function inserir(string $sql, $param){
			$conexao = new Conexao();
			$inserir = $conexao->abrir_conexao()->prepare($sql);
			foreach ($param as $key => $value) {
				$inserir->bindValue($key, $value);
			}
			if($inserir->execute() === true){
				return 1;
			}else{
				return 0;
			}
		}

		public function select_multiplo($sql, $param){
			$conexao = new Conexao();
			$select = $conexao->abrir_conexao()->prepare($sql);
			foreach($param as $key => $value){
				$select->bindValue($key, $value);
			}
			if($select->execute() === true){
				$r = $select->fetchAll();
				$result = sizeof($r);//verifica se existe o email desejado
				if($result > 0){
					return 2;
				}else{
					return 1;
				}
			}else{
				return 0;
			}
		}

		public function __destruct(){
			$this->id = null;
			$this->nome = null;
			$this->email = null;
			$this->senha = null;
		}

	}

	class Rank extends Usuarios{
		private $id_rank;
		private $pontos;

		function __construct(){}

		public function getId_rank(){
			return $this->id_rank;
		}
		public function setId_rank($id){
			$this->id_rank = $id;
		}

		public function getPontos(){
			return $this->pontos;
		}
		public function setPontos($pontos){
			$this->pontos = $pontos;
		}

		// public function getId_user(){
		// 	return $this->id_user;
		// }
		// public function setId_user($id_user){
		// 	$this->id_user = $id_user;
		// }

		// public function getNome(){
		// 	return $this->nome;
		// }
		// public function setNome($nome){
		// 	$this->nome = $nome;
		// }

		function __destruct(){
			$this->nome = null;
			$this->id = null;
			$this->id_user = null;
			$this->pontos = null;
		}
	}

	class Crud{
		public function __construct(){}
		public function __destruct(){}

		public function crud($sql, $param){
			$conexao = new Conexao();
			$crud = $conexao->abrir_conexao()->prepare($sql);
			if($param != null){
				foreach ($param as $key => $value) {
					$crud->bindValue($key, $value);
				}
			}
			if($crud->execute() === true){
				return 1;
			}else{
				return 0;
			}
		}

		public function select($sql, $param){
			$conexao = new Conexao();
			$select = $conexao->abrir_conexao()->prepare($sql);
			if($param != null){
				foreach ($param as $key => $value) {
					$select->bindValue($key, $value);
				}
			}
			if($select->execute() === true){
				$result = $select->fetchAll();
				return $result;
			}else{
				return 0;
			}
		}
	}

	class Jogadas{
		public function __construct(){}
		public function __destruct(){
			$this->id_partida = null;
			$this->id_jogador = null;
			$this->posicao = null;
			$this->peca = null;
		}

		private $id_partida;
		private $id_jogador;
		private $posicao;
		private $peca;

		public function getId_partida(){
			return $this->id_partida;
		}
		public function setId_partida($partida){
			$this->id_partida = $partida;
		}

		public function getId_jogador(){
			return $this->id_jogador;
		}
		public function setId_jogador($jogador){
			$this->id_jogador = $jogador;
		}

		public function getPosicao(){
			return $this->posicao;
		}
		public function setPosicao($pos){
			$this->posicao = $pos;
		}

		public function getPeca(){
			return $this->peca;
		}
		public function setPeca($peca){
			$this->peca = $peca;
		}
	}


 ?>