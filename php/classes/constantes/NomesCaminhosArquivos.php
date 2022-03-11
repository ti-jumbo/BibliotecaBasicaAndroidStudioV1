<?php
	namespace SJD\php\classes\constantes;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,		
		constantes\NomesCaminhosDiretorios,
		constantes\NomesArquivos
	};
	
	
	/*codigo*/
	class NomesCaminhosArquivos extends ClasseBase {
		public const catalogo_textos_base_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_textos_base_sql;	
		public const base_html_recurso = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::base_html_recurso;	
		public const base_html_recurso2 = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::base_html_recurso2;	
		public const base_html_inclusoes = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::base_html_inclusoes;	
		public const base_html_inclusoes_finais = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::base_html_inclusoes_finais;			
		public const catalogo_atualizacoes_db = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_atualizacoes_db;			
		public const catalogo_opcoes_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_opcoes_sistema;			
		public const catalogo_tipos_elementos_html = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_tipos_elementos_html;			
		public const catalogo_elementos_opcoes_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_elementos_opcoes_sistema;	
		public const catalogo_conteudo_executavel_opcoes_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_conteudo_executavel_opcoes_sistema;			
		public const catalogo_informacoes_banco_dados = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_informacoes_banco_dados;			
		public const catalogo_usuarios_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_usuarios_sistema;	
		public const catalogo_usuarios_sis = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_usuarios_sis;			
		public const catalogo_tabelas_campos = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_tabelas_campos;	
		public const catalogo_usuarios_db = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_usuarios_db;	
		public const catalogo_corpo_comandos = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_corpo_comandos;	
		public const catalogo_funcoes_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_funcoes_sql;	
		public const catalogo_db = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_db;	
		public const catalogo_tipos_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_tipos_sql;	
		public const catalogo_procedimentos_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_procedimentos_sql;	
		public const catalogo_packages_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_packages_sql;	
		public const catalogo_triggers_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_triggers_sql;	
		public const catalogo_configuracoes_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_configuracoes_sistema;	
		public const catalogo_conteudo_opcoes_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_conteudo_opcoes_sistema;	
		public const catalogo_processos = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_processos;			
		public const catalogo_opcoes_dados_sql = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_opcoes_dados_sql;	
		public const catalogo_tabelas_campos_sistema = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_tabelas_campos_sistema;	
		public const catalogo_lig_tabelasis = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_lig_tabelasis;	
		public const catalogo_lig_camposis = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_lig_camposis;	
		public const catalogo_lig_tabeladb = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_lig_tabeladb;	
		public const catalogo_lig_campodb = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_lig_campodb;	
		public const catalogo_relacionamentos = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_relacionamentos;	
		public const catalogo_lig_relacionamento = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_lig_relacionamento;	
		public const catalogo_niveis_acesso_dados = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_niveis_acesso_dados;					
		public const catalogo_criterios_acesso_dados = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_criterios_acesso_dados;			
		public const catalogo_origem_dados = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_origem_dados;	
		public const catalogo_visoes = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_visoes;	
		public const catalogo_tabelas_campos_celular = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_tabelas_campos_celular;	
		public const catalogo_processos_celular = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_processos_celular;	
		public const catalogo_comandossql_celular = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_comandossql_celular;	
		public const catalogo_itenssinc_celular = NomesCaminhosDiretorios::catalogos. DIRECTORY_SEPARATOR . NomesArquivos::catalogo_itenssinc_celular;			
	}
?>