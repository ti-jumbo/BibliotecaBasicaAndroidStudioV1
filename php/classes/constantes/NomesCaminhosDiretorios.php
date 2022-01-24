<?php
	namespace SJD\php\classes\constantes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			funcoes\FuncoesIniciais,
			constantes\NomesDiretorios
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	/*codigo*/	
	class NomesCaminhosDiretorios extends ClasseBase {		
		public const raiz = NomesDiretorios::root ;
		public const sjd = self::raiz . DIRECTORY_SEPARATOR . NomesDiretorios::base_sjd;	
		public const catalogos = self::sjd .DIRECTORY_SEPARATOR . NomesDiretorios::catalogos;	
		public const raiz_arquivos_html = self::raiz . DIRECTORY_SEPARATOR . "arquivos" . DIRECTORY_SEPARATOR . "html";
	}
?>