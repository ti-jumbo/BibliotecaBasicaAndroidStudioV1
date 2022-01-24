<?php
	namespace SJD\php\classes\sql;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\funcoes\FuncoesIniciais;
	
	
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class TSql{
		public $comando_sql="";
	}
?>