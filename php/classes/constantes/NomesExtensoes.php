<?php
	namespace SJD\php\classes\constantes;	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase
	};
	
	/*codigo*/
	class NomesExtensoes extends ClasseBase{
		public const css = '.css';		
		public const js = '.js';
        public const json = '.json';
		public const php = '.php';
		public const txt = '.txt';
	}
?>