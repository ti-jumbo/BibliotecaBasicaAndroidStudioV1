<?php
	namespace SJD\php\classes\constantes;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase
		};
	use SJD\php\classes\constantes\{	
		NomesDiretorios,
		NomesArquivos
	};
	
	/*codigo*/		
	class NomesCaminhosRelativos extends ClasseBase {		
		public const javascript =  self::sjd . DIRECTORY_SEPARATOR . NomesDiretorios::javascript;	
		public const sjd = '\\' . NomesDiretorios::base_sjd;
		public const __CAMINHOBASESJDREL__ = self::sjd;
		public const __caminhobasesjdrel__ = self::sjd;
		public const sis = self::sjd;
		public const css =  self::sjd . DIRECTORY_SEPARATOR . NomesDiretorios::css;
		public const javascript_funcoes =  self::javascript . DIRECTORY_SEPARATOR . NomesDiretorios::funcoes;		
		public const javascript_arqs_terceiros =  self::javascript . DIRECTORY_SEPARATOR . NomesDiretorios::arquivos_terceiros;		
		public const php =  self::sjd . DIRECTORY_SEPARATOR . NomesDiretorios::php;			
		public const php_funcoes =  self::php . DIRECTORY_SEPARATOR . NomesDiretorios::funcoes;			
		public const funcoes_requisicao =  self::php_funcoes . DIRECTORY_SEPARATOR . NomesDiretorios::requisicao;
		public const javascript_variaveis =  self::javascript . DIRECTORY_SEPARATOR . NomesDiretorios::variaveis;			
		public const javascript_funcoes_javascript =  self::javascript_funcoes . DIRECTORY_SEPARATOR . NomesDiretorios::javascript;	
		public const funcoes_javascript_erro =  self::javascript_funcoes . DIRECTORY_SEPARATOR . NomesDiretorios::erro;		
		public const funcoes_javascript = self::javascript_funcoes_javascript . DIRECTORY_SEPARATOR . NomesArquivos::funcoes_javascript;
		public const variaveis_javascript = self::javascript_variaveis . DIRECTORY_SEPARATOR . NomesArquivos::variaveis_javascript;
		public const funcoes_erro_javascript = self::funcoes_javascript_erro . DIRECTORY_SEPARATOR . NomesArquivos::funcoes_erro_javascript;	
		public const carregar_utilidades_basicas_js = self::sjd . DIRECTORY_SEPARATOR . NomesArquivos::carregar_utilidades_basicas_js;
		public const estilos_padrao = self::css . DIRECTORY_SEPARATOR . NomesArquivos::estilos_padrao;
		public const estilos_basicos = self::css . DIRECTORY_SEPARATOR . NomesArquivos::estilos_basicos;
		public const login_css = self::css . DIRECTORY_SEPARATOR . NomesArquivos::login_css;
		public const abas_css = self::css . DIRECTORY_SEPARATOR . NomesArquivos::abas_css;
		public const barra_sup = self::css . DIRECTORY_SEPARATOR . NomesArquivos::barra_sup;
		public const menu_esquerdo = self::css . DIRECTORY_SEPARATOR . NomesArquivos::menu_esquerdo;
		public const combobox = self::css . DIRECTORY_SEPARATOR . NomesArquivos::combobox;
		public const calendario = self::css . DIRECTORY_SEPARATOR . NomesArquivos::calendario;
		public const tabela_est = self::css . DIRECTORY_SEPARATOR . NomesArquivos::tabela_est;
		public const tab_reg_uni = self::css . DIRECTORY_SEPARATOR . NomesArquivos::tab_reg_uni;		
		public const input_combobox = self::css . DIRECTORY_SEPARATOR . NomesArquivos::input_combobox;
		public const jquery = self::javascript_arqs_terceiros . DIRECTORY_SEPARATOR . NomesArquivos::jquery;		
		public const FuncoesBasicasJS = self::javascript_funcoes . DIRECTORY_SEPARATOR . NomesArquivos::FuncoesBasicasJS;
		public const arquivo_sistema_css = self::css . DIRECTORY_SEPARATOR . NomesArquivos::sjd_css;
		public const requisicao_php = self::funcoes_requisicao . DIRECTORY_SEPARATOR . NomesArquivos::requisicao_php;
	}
?>