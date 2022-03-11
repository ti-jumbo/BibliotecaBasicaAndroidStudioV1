<?php
	namespace SJD\php\classes\constantes;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,
		constantes\NomesDiretorios
	};
		
	
	/*codigo*/	
	class NomesCaminhosDiretorios extends ClasseBase {		
		public const raiz = NomesDiretorios::root ;
		public const sjd = self::raiz . DIRECTORY_SEPARATOR . NomesDiretorios::base_sjd;	
		public const catalogos = self::sjd .DIRECTORY_SEPARATOR . NomesDiretorios::catalogos;	
		public const raiz_arquivos_html = self::raiz . DIRECTORY_SEPARATOR . 'arquivos' . DIRECTORY_SEPARATOR . 'html';
	}
?>