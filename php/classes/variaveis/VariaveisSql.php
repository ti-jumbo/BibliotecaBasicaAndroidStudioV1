<?php
	namespace SJD\php\classes\variaveis;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\NomesCaminhosArquivos,
			funcoes\FuncoesIniciais,
			funcoes\FuncoesArquivo,
			funcoes\FuncoesVariaveis
		};
		

	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class VariaveisSql extends ClasseBase {

		public const nome_conexao_padrao = "oracle_consulta_jumbo_sjd";			
		public const nome_conexao_padrao_sjd = "oracle_consulta_jumbo_sjd";
		public const nome_conexao_erp = "oracle_jumbo_sjd";
		public const cnj_chaves_tab_db_valor = ["9000000","9010000"];
		public const cods_campos_sis_valores = ["9009000","9009001","9009002","9009003","9009004","9009005"];
		public static $conexoes = [];
		public static $dados_conexoes = null;
		public static $ultimo_comando_sql = null;
		public static $ultima_requisicao_sql = null;
		public static $existe = [];

		function __construct(?object $pinstancia_sis = null) {
			try {
				parent::__construct($pinstancia_sis);
				//apcu_delete("sjd_dados_conexoes");
				/*armazena dados comuns em cache para economizar leituras em disco*/
				if (!apcu_exists("sjd_dados_conexoes")) {
					apcu_store("sjd_dados_conexoes",FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::catalogo_informacoes_banco_dados,["filtro"=>"connections","traduzir_apos_filtro"=>true,"preparar_string_antes"=>true]));
				}
				$this::$dados_conexoes = apcu_fetch("sjd_dados_conexoes");
			} catch(Exception $e) {
				print_r($e);
				exit();
			}
		}				

		public function getPrefixObjects(?string $nome_conexao = null) : ?string{
			try {
				$nome_conexao = $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_padrao");
				return $this->getPropInstanciaSis("dados_conexoes")->{$nome_conexao}->prefix_objects;			
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}
		
		public function getNomeConexaoPadrao() : ?string{
			try {
				return $this->getPropInstanciaSis("nome_conexao_padrao") ?? $this::nome_conexao_padrao;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}

		public function getNomeConexaoErp() : ?string{
			try {
				return $this->getPropInstanciaSis("nome_conexao_erp") ?? $this::nome_conexao_erp;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}

		public function getNomeSchema(?string $nome_conexao = null) : ?string{
			try {
				$nome_conexao = $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_padrao");
				$nome_conexao = FuncoesVariaveis::como_texto_ou_funcao($nome_conexao);
				return $this->getPropInstanciaSis("dados_conexoes")->{$nome_conexao}->default_schema->name ?? $this->getPropInstanciaSis("dados_conexoes")->{$nome_conexao}->default_schema;			
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}

		public function getNomeSchemaErp(?string $nome_conexao = null) : ?string{
			try {
				$nome_conexao = $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_erp");
				return $this->getPropInstanciaSis("dados_conexoes")->{$nome_conexao}->default_schema->name ?? $this->getPropInstanciaSis("dados_conexoes")->{$nome_conexao}->default_schema;			
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}		

		public function getUsuarioDB(?string $nome_conexao = null) : ?string{
			try {
				$nome_conexao = $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_padrao") ?? $this::nome_conexao_padrao;
				return $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_padrao") ?? $this::nome_conexao_padrao;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}


		public function getFuncaoSql(string $nome_funcao, ?string $nome_conexao = null) : ?string{
			try {
				$nome_conexao = $nome_conexao ?? $this->getPropInstanciaSis("nome_conexao_padrao") ?? $this::nome_conexao_padrao;
				return $this::$dados_conexoes->{$nome_conexao}->driver->functions->{$nome_funcao};
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			}
		}

		public function getAllowDDLConn(?string $nome_conexao = null) {
			$nome_conexao = $nome_conexao ?? self::nome_conexao_padrao;
			$allow_ddl = self::$dados_conexoes->{$nome_conexao}->allow_ddl ?? false;
			if ($allow_ddl === true) {
				if (property_exists(self::$dados_conexoes->{$nome_conexao},"host")) {
					if (isset(self::$dados_conexoes->{$nome_conexao}->host) && self::$dados_conexoes->{$nome_conexao}->host !== null
						&& gettype(self::$dados_conexoes->{$nome_conexao}->host) === "object"
					) {
						$allow_ddl = self::$dados_conexoes->{$nome_conexao}->host->allow_ddl ?? false;
					}
				}
				if ($allow_ddl === true) {
					if (property_exists(self::$dados_conexoes->{$nome_conexao},"default_schema")) {
						if (isset(self::$dados_conexoes->{$nome_conexao}->default_schema) && self::$dados_conexoes->{$nome_conexao}->default_schema !== null
							&& gettype(self::$dados_conexoes->{$nome_conexao}->default_schema) === "object"
						) {
							$allow_ddl = self::$dados_conexoes->{$nome_conexao}->default_schema->allow_ddl ?? false;
						}
					}				
				}
			}
			return $allow_ddl;
		}

		

	}

	/*inicializa variaveis sql */
	VariaveisSql::getInstancia();


?>