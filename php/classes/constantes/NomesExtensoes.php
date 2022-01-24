<?php
	namespace SJD\php\classes\constantes;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
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
	class NomesExtensoes extends ClasseBase{
		public const css = ".css";		
		public const js = ".js";
        public const json = ".json";
		public const php = ".php";
		public const txt = ".txt";
	}
?>