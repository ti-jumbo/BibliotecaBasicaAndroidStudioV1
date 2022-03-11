<?php
	namespace SJD\php\classes\constantes;	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase
	};
	
	/*codigo*/	
	if (!defined('__DIRROOT__')) {
		define('__DIRROOT__',str_replace('/',DIRECTORY_SEPARATOR,$_SERVER['DOCUMENT_ROOT']));		
	}		
	
	if (!defined('__NOMEDIRSJD__')) {
		$dirbasesjd = str_ireplace(__DIRROOT__,'',dirname(__FILE__));
		while(strpos($dirbasesjd,DIRECTORY_SEPARATOR) === 0) {
			$dirbasesjd = substr($dirbasesjd,1);
		}
		if (strpos($dirbasesjd, DIRECTORY_SEPARATOR) !== false) {
			$dirbasesjd = substr($dirbasesjd,0,strpos($dirbasesjd,DIRECTORY_SEPARATOR));
		}
		define('__NOMEDIRSJD__',$dirbasesjd);
	}	
	
	class NomesDiretorios extends ClasseBase {
		public const root = __DIRROOT__;
		public const base_sjd = __NOMEDIRSJD__;
		public const base_sis = self::base_sjd;
		public const catalogos = 'catalogos';
		public const css = 'css';
		public const erro = 'erro';
		public const funcoes = 'funcoes';
		public const javascript = 'javascript';
		public const arquivos_terceiros = 'arquivos_de_terceiros';
		public const variaveis = 'variaveis';
		public const php = 'php';
		public const requisicao = 'requisicao';	
	}	
?>