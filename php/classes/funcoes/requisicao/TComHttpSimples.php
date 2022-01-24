<?php
	namespace SJD\php\classes\funcoes\requisicao;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			sql\TSql,
			funcoes\FuncoesIniciais
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class TComHttpSimples{
		public $a;
		public $b;
		public $c;
		public $d;
		public $r;
		public $u;
		public function __construct() {
			$this->a = "";
			$this->b = "";
			$this->c = "";
			$this->d = []; //array para dados usados nos processos do servidor
			$this->r = [];
			$this->u = []; //array para dados do usuario
		}
	}		
?>