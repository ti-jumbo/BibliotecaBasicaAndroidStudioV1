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
	class TQual{
		public $comando = "";
		public $tipo_objeto = "";
		public $objeto = "";
		public $tabela = "";
		public $campo = "";
		public $valor = "";
		public $codusur = "";
		public $senha = "";
		public $condicionantes = [];
	}
	class TRequisitar{
		public $oque = "";
		public $qual;
		public function __construct() {
			$this->qual = new TQual();
		}
	}
	class TRequisicao{
		public $id = "";
		public $requisitar;
		public $sql ;
		public function __construct() {
			$this->requisitar = new TRequisitar();
			$this->sql = new TSql();
		}
	}
	class TRetorno{
		public $id = "";
		public $resultado = "";
		public $dados_retornados = [];
		public $logs = "";
		public $erros = "";
		public $numerros = 0;
		public $numerroscodigo = 0;
		public $numerrossql = 0;
	}
	class TEventos{
		public $aposretornar = "";
	}
	class TComHttp{
		public $id;
		public $idsessao;
		public $id_carregando;
		public $requisicao;
		public $retorno;
		public $eventos;
		public $opcoes_retorno;
		public function __construct() {
			$this->id = "";
			$this->idsessao = "";
			$this->id_carregando = "";
			$this->requisicao = new TRequisicao();
			$this->retorno = new TRetorno();
			$this->eventos = new TEventos();
			$this->opcoes_retorno = [
				"usar_arr_tit" => true 
			];
		}
	}	
?>