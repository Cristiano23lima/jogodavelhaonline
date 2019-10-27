<?php 
	class Conexao{
		private $conexao;
		public function __construct(){}//inicializa a classe
		private function __clone(){}//evita clonagem da classe

		public function __destruct(){//é chamado quando tudo da classe é processado
			$this->fechar_conexao();//chama a função de fechamento de classe
			foreach($this as $key => $value){//destroi todas as variaveis da memoria
				unset($this->$key);//destroi uma variavel
			}
		}

		public function abrir_conexao(){//abrir a conexao com o banco de dados
			try{
				$this->conexao = new pdo("mysql:host=localhost;dbname=jogo", "root", "");
			}catch(PDOException $e){
				echo "Erro ao conectar com o banco de dados";
			}
			return $this->conexao;
		}

		private function fechar_conexao(){
			$this->conexao = null;
		}
	}
 ?>