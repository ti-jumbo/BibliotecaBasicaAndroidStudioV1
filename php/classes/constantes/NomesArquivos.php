<?php
	namespace SJD\php\classes\constantes;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\NomesExtensoes,
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
	class NomesArquivos extends ClasseBase {
		public  const carregar_utilidades_basicas_js = "carregar_utilidades_basicas" . NomesExtensoes::js;
		public  const catalogo_textos_base_sql = "catalogo_textos_base_sql" . NomesExtensoes::json;	
		public const base_html_recurso = "base_html_recurso" . NomesExtensoes::txt;	
		public const base_html_recurso2 = "base_html_recurso2" . NomesExtensoes::txt;	
		public const base_html_inclusoes = "base_html_inclusoes" . NomesExtensoes::txt;	
		public const base_html_inclusoes_finais = "base_html_inclusoes_finais" . NomesExtensoes::txt;			
		public const catalogo_atualizacoes_db = "catalogo_atualizacoes_db" . NomesExtensoes::json;			
		public const catalogo_opcoes_sistema = "catalogo_opcoes_sistema" . NomesExtensoes::json;			
		public const catalogo_tipos_elementos_html = "catalogo_tipos_elementos_html" . NomesExtensoes::json;			
		public const catalogo_elementos_opcoes_sistema = "catalogo_elementos_opcoes_sistema" . NomesExtensoes::json;	
		public const catalogo_conteudo_executavel_opcoes_sistema = "catalogo_conteudo_executavel_opcoes_sistema" . NomesExtensoes::json;			
		public const catalogo_informacoes_banco_dados = "catalogo_informacoes_banco_dados" . NomesExtensoes::json;			
		public const catalogo_usuarios_sistema = "catalogo_usuarios_sistema" . NomesExtensoes::json;	
		public const catalogo_usuarios_sis = "catalogo_usuarios_sis" . NomesExtensoes::json;			
		public const catalogo_tabelas_campos = "catalogo_tabelas_campos" . NomesExtensoes::json;	
		public const catalogo_usuarios_db = "catalogo_usuarios_db" . NomesExtensoes::json;	
		public const catalogo_corpo_comandos = "catalogo_corpo_comandos" . NomesExtensoes::json;	
		public const catalogo_funcoes_sql = "catalogo_funcoes_sql" . NomesExtensoes::json;	
		public const catalogo_db = "catalogo_db" . NomesExtensoes::json;	
		public const catalogo_tipos_sql = "catalogo_tipos_sql" . NomesExtensoes::json;	
		public const catalogo_procedimentos_sql = "catalogo_procedimentos_sql" . NomesExtensoes::json;	
		public const catalogo_packages_sql = "catalogo_packages_sql" . NomesExtensoes::json;	
		public const catalogo_triggers_sql = "catalogo_triggers_sql" . NomesExtensoes::json;	
		public const catalogo_configuracoes_sistema = "catalogo_configuracoes_sistema" . NomesExtensoes::json;	
		public const catalogo_conteudo_opcoes_sistema = "catalogo_conteudo_opcoes_sistema" . NomesExtensoes::json;	
		public const catalogo_processos = "catalogo_processos" . NomesExtensoes::json;			
		public const catalogo_opcoes_dados_sql = "catalogo_opcoes_dados_sql" . NomesExtensoes::json;	
		public const catalogo_tabelas_campos_sistema = "catalogo_tabelas_campos_sistema" . NomesExtensoes::json;	
		public const catalogo_lig_tabelasis = "catalogo_lig_tabelasis" . NomesExtensoes::json;	
		public const catalogo_lig_camposis = "catalogo_lig_camposis" . NomesExtensoes::json;	
		public const catalogo_lig_tabeladb = "catalogo_lig_tabeladb" . NomesExtensoes::json;	
		public const catalogo_lig_campodb = "catalogo_lig_campodb" . NomesExtensoes::json;	
		public const catalogo_relacionamentos = "catalogo_relacionamentos" . NomesExtensoes::json;	
		public const catalogo_lig_relacionamento = "catalogo_lig_relacionamento" . NomesExtensoes::json;	
		public const catalogo_niveis_acesso_dados = "catalogo_niveis_acesso_dados" . NomesExtensoes::json;					
		public const catalogo_criterios_acesso_dados = "catalogo_criterios_acesso_dados" . NomesExtensoes::json;			
		public const catalogo_origem_dados = "catalogo_origem_dados" . NomesExtensoes::json;	
		public const catalogo_visoes = "catalogo_visoes" . NomesExtensoes::json;	
		public const catalogo_tabelas_campos_celular = "catalogo_tabelas_campos_celular" . NomesExtensoes::json;	
		public const catalogo_processos_celular = "catalogo_processos_celular" . NomesExtensoes::json;	
		public const catalogo_comandossql_celular = "catalogo_comandossql_celular" . NomesExtensoes::json;	
		public const catalogo_itenssinc_celular = "catalogo_itenssinc_celular" . NomesExtensoes::json;		
		public  const estilos_basicos = "estilos_basicos" . NomesExtensoes::css;	
		public  const estilos_padrao = "estilos_padrao" . NomesExtensoes::css;	
		public  const abas_css = "abas" . NomesExtensoes::css;	
		public  const login_css = "login" . NomesExtensoes::css;	
		public  const barra_sup = "barra_sup" . NomesExtensoes::css;	
		public  const menu_esquerdo = "menu_esquerdo" . NomesExtensoes::css;	
		public  const combobox = "combobox" . NomesExtensoes::css;	
		public  const calendario = "calendario" . NomesExtensoes::css;	
		public  const tabela_est = "tabela_est" . NomesExtensoes::css;		
		public  const tab_reg_uni = "tab_reg_uni" . NomesExtensoes::css;	
		public  const input_combobox = "input_combobox" . NomesExtensoes::css;	
		public  const sjd_css = "sisjd" . NomesExtensoes::css;
		public  const funcoes_erro_javascript = "funcoes_erro" . NomesExtensoes::js;
		public  const FuncoesBasicasJS = "FuncoesBasicas" . NomesExtensoes::js;
		public  const variaveis_javascript = "variaveis_javascript" . NomesExtensoes::js;
		public  const jquery = "jquery-3.5.1.min" . NomesExtensoes::js;		
		public  const funcoes_javascript = "funcoes_javascript" . NomesExtensoes::js;
		public  const requisicao_php = "requisicao" . NomesExtensoes::php;
	}
?>