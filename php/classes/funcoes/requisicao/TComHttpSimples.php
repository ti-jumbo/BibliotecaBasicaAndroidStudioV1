<?php
	namespace SJD\php\classes\funcoes\requisicao;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		sql\TSql
	};
	
	/*codigo*/
	class TComHttpSimples{
		public $a;
		public $b;
		public $c;
		public $d;
		public $r;
		public $u;
		public function __construct() {
			$this->a = '';
			$this->b = '';
			$this->c = '';
			$this->d = []; //array para dados usados nos processos do servidor
			$this->r = [];
			$this->u = []; //array para dados do usuario
		}
	}		
?>