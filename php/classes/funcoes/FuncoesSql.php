<?php    
    namespace SJD\php\classes\funcoes;	
    
    use SJD\php\classes\{
        ClasseBase,
        constantes\Constantes,
        constantes\NomesCaminhosArquivos,
        variaveis\VariaveisSql
    };

    use SJD\php\classes\funcoes\{
        FuncoesIniciais,
        requisicao\FuncoesBasicasRetorno
    };

    /*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	};
	FuncoesIniciais::processamentos_iniciais();

    class FuncoesSql extends ClasseBase {

        private function obter_dados_conexao($params = []){
            try {                
                if (isset($params["nome_conexao"])) {
                    if (isset(VariaveisSql::getInstancia()::$dados_conexoes->{$params["nome_conexao"]})) {
                        $retorno = VariaveisSql::getInstancia()::$dados_conexoes->{$params["nome_conexao"]};
                    } else {                                                                        
                        $retorno = null;
                    }                 
                } else {
                    $retorno = VariaveisSql::getInstancia()::$dados_conexoes;
                }                
                return $retorno;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            }
        }

        private function obter_meta_dado($params = []){
            try {
                $retorno = null;
                $type = gettype($params);
                if ($type === "string") {
                    $params["meta_dado"] = $params;                    
                } else if ($type !== "array") {
                    trigger_error("tipo nao esperado: " . $type, E_USER_ERROR);
                }
                $type = null;
                unset($type);
                $params["nome_conexao"] = $params["nome_conexao"] ?? VariaveisSql::nome_conexao_padrao;
                $params["dados_conexao"] = $params["dados_conexao"] ?? VariaveisSql::getInstancia()::$dados_conexoes->{$params["nome_conexao"]};
                switch(strtolower(trim($params["meta_dado"]))) {
                    case "table_schema":
                        $retorno = $params["dados_conexao"]->driver->tables->tables->name;
                        break;
                    case "lower":
                        $retorno = $params["dados_conexao"]->driver->functions->{strtolower(trim($params["meta_dado"]))};
                        break;
                    case "column_schema_name":
                    case "column_table_name":
                        $retorno = $params["dados_conexao"]->driver->tables->tables->columns->{str_ireplace("column_","",trim($params["meta_dado"]))};
                        break;
                    case "delimiter":
                        $retorno = $params["dados_conexao"]->driver->strings->{strtolower(trim($params["meta_dado"]))};
                        break;
                    case "table_exists":
                        $retorno = $params["dados_conexao"]->driver->statements->{strtolower(trim($params["meta_dado"]))};
                        break;
                    default:
                        trigger_error("meta_dado nao esperado: " . $params["meta_dado"]);
                        break;
                }                
                return $retorno;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            }
        }

        public function conectar(array|string &$params = null) : ?Object{
            try {
                $params = $params ?? [];
                $type = gettype($params);
                if ($type === "string") {
                    $params = [
                        "nome_conexao" => $params
                    ];
                } else if ($type !== "array") {
                    trigger_error("Tipo nao esperado: " . $type,E_USER_ERROR);                
                }
                $type = null;
                unset($type);
                $params["nome_conexao"] = $params["nome_conexao"] ?? VariaveisSql::nome_conexao_padrao;
                $params["conexao"] = $params["conexao"] ?? VariaveisSql::getInstancia()::$conexoes[$params["nome_conexao"]] ?? null;
                /*https://www.php.net/manual/pt_BR/pdo.setattribute.php*/
                $params["opcoes"] = $params["opcoes"] ?? [\PDO::ATTR_CASE => \PDO::CASE_LOWER];
                if (!$params["conexao"] || ($params["obter_nova"] ?? false) === true ) {
                    $params["nome_conexao"] = $params["nome_conexao"] ?? VariaveisSql::nome_conexao_padrao ?? null;
                    if ($params["nome_conexao"] === null || strlen(trim($params["nome_conexao"])) === 0) {
                        trigger_error("um nome valido de conexao constante no catalogo deve ser informado",E_USER_ERROR);
                    }
                    $dados_conexao = $this->obter_dados_conexao($params);
                    if ($dados_conexao === null) {
                        trigger_error("o nome da conexao nao foi encontrado no arquivo de informacoes de banco de dados: ". $params["nome_conexao"],E_USER_ERROR);
                    }
                    $params["driver"] = $params["driver"] ?? $dados_conexao->driver->name ?? $dados_conexao->driver; 
                    $params["address"] = $params["address"] ?? $dados_conexao->host->host ?? $dados_conexao->host;
                    $params["port"] = $params["port"] ?? $dados_conexao->port;
                    $params["user"] = $params["user"] ?? $dados_conexao->user;
                    $params["password"] = $params["password"] ?? $dados_conexao->password;
                    $params["service"] = $params["service"] ?? $dados_conexao->service ?? null;
                    $params["database"] = $params["database"] ?? $dados_conexao->default_schema->name ?? $dados_conexao->default_schema;
                    switch(strtolower(trim($params["driver"]))) {
                        case "mysqli":
                        case "mysql":
                            $params["conexao"] = new \PDO($params["driver"]. ":dbname=" . $params["database"] .";host=" . $params["address"] ,
                                $params["user"],$params["password"], $params["opcoes"]);
                            break;
                        case "oracle":
                        case "ora":
                        case "oci":
                            /*
                                    https://www.php.net/manual/pt_BR/ref.pdo-oci.connection.php
                                    Connect to a database defined in tnsnames.ora
                                    oci:dbname=mydb
                                    Connect using the Oracle Instant Client
                                    oci:dbname=//localhost:1521/mydb
                            */
                            /*$params["conexao"] = new \PDO("oci". ":dbname=//". $params["address"] . ":" . $params["port"] . "/" . $params["service"],
                                $params["user"],$params["password"], $params["opcoes"]);                            */
                            $params["conexao"] = new \PDO("oci". ":dbname=(DESCRIPTION=(ADDRESS=(HOST=". $params["address"] . ")(PROTOCOL=tcp)(PORT=" . $params["port"] . "))(CONNECT_DATA=(SID=" . $params["service"].")))",
                                $params["user"],$params["password"], $params["opcoes"]);
                            break;
                        default:
                            trigger_error("Driver nao esperado: " . $params["driver"],E_USER_ERROR);
                            break;
                    }
                    if (!$params["conexao"]) {
                        trigger_error("Erro ao conectar",E_USER_ERROR);
                    } else {
                        if (
                                ($params["setar_como_padrao"] ?? false) === true || 
                                (
                                    $params["nome_conexao"] === VariaveisSql::nome_conexao_padrao && 
                                    (
                                        ($params["obter_nova"] ?? false) !== true &&
                                        (!isset(VariaveisSql::getInstancia()::$conexoes[VariaveisSql::nome_conexao_padrao]) || !VariaveisSql::getInstancia()::$conexoes[VariaveisSql::nome_conexao_padrao])
                                    )
                                ) 
                        ) {
                            VariaveisSql::getInstancia()::$conexoes[VariaveisSql::nome_conexao_padrao] = $params["conexao"];
                        }
                        if (property_exists($dados_conexao,"scripts_iniciais")) {
                            if ($dados_conexao->scripts_iniciais !== null && count($dados_conexao->scripts_iniciais) > 0) {
                                foreach($dados_conexao->scripts_iniciais as $script) {
                                    $params_script = [
                                        "query" => $script,
                                        "func" => "exec",
                                        "conexao" => $params["conexao"]
                                    ];
                                    $this->executar_sql($params_script);
                                }
                            }
                        }
                    }
                }
                return $params["conexao"];
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            }
        }

        public function tabela_existe($params) {
            try {
                $retorno = false;
                $type = gettype($params);
                if ($type === "string") {
                    $params = [
                        "tabela"=>$params
                    ];                
                } else if ($type !== "array") {
                    trigger_error("Tipo nao esperado: " . $type,E_USER_ERROR);
                }
                $type = null;
                unset($type);
                $params["rechecar"] = $params["rechecar"] ?? false;
                
                $encontrou = false;
                if ($params["rechecar"] === false) {
                    $alvo = VariaveisSql::$existe;
                    if (isset($alvo) && $alvo !== null && gettype($alvo) === "array" && count($alvo) > 0) {
                        /*testar se o caminho dentro de existe existe (nome_conexao,driver,address,port,user,database,table,) */
                        /*se o caminho nao estiver armazenado em params, carregar da variaveissql[conexoes[conexao_padrao]], se esta nao existir, carrega-la do arquivo (fazer function, pois isso é feito em outro lugar (conectar)) */
                        echo "implementar"; exit();
                    } 
                }
                if ($encontrou === false || $params["rechecar"] === true) {
                    $params["conexao"] = $params["conexao"] ?? null;
                    $params["conexao"] = $this->conectar($params);
                    $params["meta_dado"] = "table_exists";   
                    $comando_sql = $this->obter_meta_dado($params);
                    $params["statement"] = $params["conexao"]->prepare($comando_sql);
                    $database_name = VariaveisSql::getInstancia()::$dados_conexoes->{$params["nome_conexao"]}->default_schema->name ?? VariaveisSql::getInstancia()::$dados_conexoes->{$params["nome_conexao"]}->default_schema;
                    $params["statement"]->execute([
                        "database_name"=>$database_name,
                        "table_name"=>$params["tabela"]
                    ]);
                    $params["result"] = $params["statement"]->fetchAll(\PDO::FETCH_COLUMN);
                    if ($params["result"] !== false && $params["result"] !== null) {
                        if (count($params["result"]) > 0) {
                            if ($params["result"][0] > 0) {
                                $retorno = true;
                            }
                        }                        
                    }
                    $this->fechar_cursor($params["statement"]);
				    $params["result"] = null;
                }
                return $retorno;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return false;
            } finally {
                $this->fechar_cursor($params["statement"]);
            }
        }

        public function verif_usuario_sis($usuario_sis) {
			if (gettype($usuario_sis) !== "array") {
				$usuario_sis = $this->obter_usuario_sis(["condic"=>$usuario_sis,"unico"=>true]);
			}
			return $usuario_sis;
		}

        public function verif_tabela_db($tabela_db) {
			if (gettype($tabela_db) !== "array") {
				$tabela_db = $this->obter_tabela_db(["condic"=>"lower(trim(nometabeladb)) = lower(trim('$tabela_db'))","unico"=>true]);
			}
			return $tabela_db;
		}

        public function obter_criterios_acesso($usuariosis,$tabdb) {
			$param = [];
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "criterioacessodados";
			$param["campos"] = "*";
			$param["unico"] = false;
			$retorno = [];
			$usuariosis = $this->verif_usuario_sis($usuariosis);	
			$tabdb = $this->verif_tabela_db($tabdb);	
			if (strcasecmp(trim($usuariosis["codnivelacesso"]),"0") == 0) {
				return $retorno;
			} else {	
				$param["condic"] = "codtipoente = 0 and codente = " . strtolower(trim($usuariosis["codnivelacesso"])) . " and codtabeladb = " . $tabdb["codtabeladb"];
				$retorno = $this->obter_dados_sql($param);		
			}
			return $retorno;
		}

        private function obter_campos_tabela_do_catalogo($tabela,$tipo = null) {
            try {			
                $campos_retorno = null;	
                if (strpos($tabela,".") !== false) {
                    $tabela = substr($tabela,strpos($tabela,".")+1);
                }
                $prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();
                $opcoes = ["logprocesso" => [],"objeto" => $tabela];
                $tabelacat = null;
                $tabelacat = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_tabelas_campos"),["filtro"=>$opcoes["objeto"],"traduzir_apos_filtro"=>false,"preparar_string_antes"=>true]);
                if ($tabelacat !== null) {
                    if (property_exists($tabelacat,"sub")) {
                        foreach($tabelacat->sub as $chave_campo => $campo) {
                            if (isset($tipo) && $tipo !== null) {				
                                if (strcasecmp(trim($tipo),"unique") == 0) {
                                    if (property_exists($campo,"unico")) {
                                        if ($campo->unico == 1 ) {
                                            $campos_retorno[trim(strtolower($campo->nomecampodb))] = trim(strtoupper($campo->nomecampodb));
                                        }								
                                    }
                                } elseif (stripos(trim($tipo),"primar") !== false) {
                                    if (property_exists($campo,"chaveprimaria")) {
                                        if ($campo->chaveprimaria == 1 ) {
                                            $campos_retorno[trim(strtolower($campo->nomecampodb))] = trim(strtoupper($campo->nomecampodb));
                                        }
                                    }
                                } else {													
                                    if (strcasecmp(trim($campo->tipodado),trim($tipo)) == 0) {
                                        $campos_retorno[strtolower(trim($campo->nomecampodb))] = strtoupper(trim($campo->nomecampodb));
                                    }
                                }
                            } else {				
                                $campos_retorno[strtolower(trim($campo->nomecampodb))] = strtoupper(trim($campo->nomecampodb));
                            }
                        }
                    } 
                }
                return $campos_retorno;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            }
        }

        function obter_campos_tabela($tabela,$tipo = null, $origem = "dados" , $owner = null) {
            try {			
                $campos_retorno = null;	
                $origem = strtolower(trim($origem));
                if (strpos($tabela,".") !== false) {
                    $tabela = substr($tabela,strpos($tabela,".")+1);
                }
                $prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();
                if ($origem === "dados") {
                    if ($this->tabela_existe($prefix_objects . "tabeladb")) {					
                        $comando_sql = "select * from " . $prefix_objects . "tabeladb where lower(nometabeladb) = '".strtolower(trim($tabela))."'";
                        $tabelacat = $this->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
                        if ($tabelacat !== null && $tabelacat !== false && count($tabelacat) > 0) {
                            if ($this->tabela_existe($prefix_objects . "campodb")) {
                                $comando_sql = "select * from " . $prefix_objects . "campodb where codtabeladb = ".$tabelacat["codtabeladb"] . " order by nvl(ordemcriacao,codcampodb)";
                                $campos_tabela = $this->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
                                //print_r($campos_tabela); exit();
                                if (count($campos_tabela) > 0) {
                                    $campos_retorno = [];
                                    foreach($campos_tabela as $chave_campo => $campo) {
                                        if (isset($tipo) && $tipo !== null) {
                                            if (strcasecmp(trim($tipo),"unique") == 0) {
                                                if ($campo["unico"] == 1 ) {
                                                    $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));
                                                }								
                                            } elseif (stripos(trim($tipo),"primar") !== false) {
                                                if ($campo["chaveprimaria"] == 1 ) {
                                                    $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));
                                                }
                                            } elseif (stripos(trim($tipo),"lob") !== false) {
                                                if (in_array(strtolower(trim($campo["tipodado"])),["clob","lob","blob","longtext"])) {
                                                    $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));
                                                }
                                            } else {
                                                if (strcasecmp(trim($campo["tipodado"]),trim($tipo)) == 0) {
                                                    $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));
                                                } else {
                                                    $nome_conexao = $tabelacat["nome_conexao"];
                                                    $types_driver_sql = VariaveisSql::getInstancia()::$dados_conexoes->{$nome_conexao}->driver->types;
                                                    foreach($types_driver_sql as $type) {                                                    
                                                        if (in_array(strtolower(trim($tipo)),$type->synonyms) && in_array(strtolower(trim($campo["tipodado"])),$type->synonyms)) {
                                                            $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));
                                                            break;
                                                        } 
                                                    }
                                                }
                                            }
                                        } else {
                                            $campos_retorno[trim(strtolower($campo["nomecampodb"]))] = trim(strtoupper($campo["nomecampodb"]));						
                                        }
                                    }
                                } else {
                                    $campos_retorno = self::obter_campos_tabela_do_catalogo($tabela,$tipo);
                                }
                            } else {
                                if (in_array($tabela,["sjdtabeladb","sjdcampodb"])) {
                                    $campos_retorno = self::obter_campos_tabela_do_catalogo($tabela,$tipo);
                                }
                            }
                        } else {
                            if (in_array($tabela,["sjdtabeladb","sjdcampodb"])) {
                                $campos_retorno = self::obter_campos_tabela_do_catalogo($tabela,$tipo);
                            }
                        }
                    } else  {                    
                        $campos_retorno = self::obter_campos_tabela_do_catalogo($tabela,$tipo);
                    }
                } else if ($origem === "banco") {
                    //FuncoesBasicasRetorno::mostrar_msg_sair("imlementar",__FILE__,__FUNCTION__,__LINE__);
                    $comando_sql = "
                        SELECT
                            user_tab_columns.table_name,
                            user_tab_columns.column_name,
                            user_tab_columns.data_type,
                            case when user_tab_columns.data_type = 'CLOB' then 0 else user_tab_columns.data_length end as data_length,
                            user_tab_columns.data_precision,
                            user_tab_columns.data_scale,
                            user_tab_columns.nullable,
                            user_tab_columns.column_id,
                            user_tab_columns.data_default,
                            user_tab_columns.low_value,
                            user_tab_columns.high_value,
                            constraint_unique.constraint_type,
                            constraint_notnull.search_condition
                        FROM
                            user_tab_columns    
                                LEFT OUTER JOIN ( 
                                user_cons_columns column_unique
                                JOIN user_constraints constraint_unique ON ( 
                                    constraint_unique.constraint_name = column_unique.constraint_name 
                                    and constraint_unique.constraint_type in ('U','P')
                                ) 
                            ) ON ( column_unique.table_name = user_tab_columns.table_name
                                    AND column_unique.column_name = user_tab_columns.column_name
                                )     
                            LEFT OUTER JOIN ( 
                                user_cons_columns column_notnull
                                JOIN user_constraints constraint_notnull ON ( 
                                    constraint_notnull.constraint_name = column_notnull.constraint_name 
                                    and constraint_notnull.constraint_type = 'C'
                                ) 
                            ) ON ( column_notnull.table_name = user_tab_columns.table_name
                                    AND column_notnull.column_name = user_tab_columns.column_name
                                    )
                        WHERE
                            lower(TRIM(user_tab_columns.table_name) ) = lower(TRIM('$tabela') )
                            __CONDICIONANTES__
                            
                            ";
                    if (isset($tipo) && $tipo !== null) {
                        $condicionantes = [];
                        if (strcasecmp(trim($tipo),"unique") == 0) {
                            $condicionantes[] = "constraint_unique.constraint_type = 'U'";
                        } elseif (stripos(trim($tipo),"primar") !== false) {
                            $condicionantes[] = "constraint_unique.constraint_type = 'P'";
                        } else {
                            $condicionantes[] = "lower(trim(data_type)) = lower(trim('".$tipo."'))";
                        }
                        $comando_sql = str_ireplace("__CONDICIONANTES__"," and " . implode(" and ", $condicionantes),$comando_sql);
                    } else {
                        $comando_sql = str_ireplace("__CONDICIONANTES__","",$comando_sql);
                    }
                    $tabelacat = $this->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
                    $campos_retorno = $tabelacat;
                } else {
                    FuncoesBasicasRetorno::mostrar_msg_sair("origem nao esperada: $origem",__FILE__,__FUNCTION__,__LINE__);
                }
                return $campos_retorno;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            } 
		}	

        /**
         * Executa uma query conforme parametros
         * @param array|string $param - parametros da query
         * @return object - o resultado da query
         */
         /*
            ATENCAO NA UTILIZACAO DO CURSOR RETORNADO QUANDO HOUVER LOB
            LOB - SE TIVER LOB NO RETORNO, NAO UTILIZAR FECTHALL(), BUG DO PHP RELATADO, O LOB 
            APONTARA SEMPRE PARA O ULTIMO REGISTRO. EM VEZ DISSO, UTILIZAR FETCH()
        */
        function executar_sql(array | string &$params, $fetch = null, $fetch_mode = \PDO::FETCH_ASSOC, int $numcol = 0) : object | array | int | bool | null {
            try {                
                if (gettype($params) === "string") {
                    $params = ["query"=>$params];
                }
                $params["fetch"] = $params["fetch"] ?? $fetch ?? null;
                $params["fetch_mode"] = $params["fetch_mode"] ?? $fetch_mode ?? \PDO::FETCH_ASSOC;
                $params["numcol"] = $params["numcol"] ?? $numcol ?? 0;
                $params["conexao"] = $params["conexao"] ?? $this->conectar($params);                
                $params["conexao"]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $params["func"] = strtolower(trim($params["func"] ?? "execute"));
                $params["retornar_resultset"] = $params["retornar_resultset"] ?? false;
                switch($params["func"]) {
                    case "exec":
                        $params["result"] = $params["conexao"]->exec($params["query"]);
                        break;
                    default://"prepare, execute
                        $params["result"] = $params["conexao"]->prepare($params["query"]);
                        if (!$params["result"]) {
                            throw new Exception("Erro ao executar prepare no sql");                    
                        }
                        /*se houverem parametros bind*/
                        if (isset($params["camposbind"]) && $params["camposbind"] !== null && count($params["camposbind"]) > 0) {
                            if (isset($params["valoresbind"]) && $params["valoresbind"] !== null && count($params["valoresbind"]) > 0) {
                                foreach($params["camposbind"] as $chave_campo_bind=>$campo_bind){
                                    if (isset($params["valoresbind"][$chave_campo_bind])) {
                                        if (gettype($campo_bind) === "array") {
                                            if (isset($campo_bind["parametros"])) {                                        
                                                if ($campo_bind["parametros"] === \PDO::PARAM_STR) {
                                                    $length = strlen($params["valoresbind"][$chave_campo_bind]);
                                                    $params["result"]->bindParam($campo_bind["campo"],$params["valoresbind"][$chave_campo_bind],$campo_bind["parametros"],$length);
                                                } else {
                                                    $params["result"]->bindParam($campo_bind["campo"],$params["valoresbind"][$chave_campo_bind],$campo_bind["parametros"]);
                                                }
                                            } else {
                                                $params["result"]->bindParam($campo_bind["campo"],$params["valoresbind"][$chave_campo_bind]);    
                                            }
                                        } else {
                                            $params["result"]->bindParam($campo_bind,$params["valoresbind"][$chave_campo_bind]);
                                        }
                                    }
                                }
                            } else {
                                foreach($params["camposbind"] as $chave_campo_bind=>&$campo_bind){                            
                                    if (gettype($campo_bind) === "array") {
                                        if (isset($campo_bind["parametros"])) {                                        
                                            $params["result"]->bindColumn($campo_bind["campo"],$campo_bind["retorno"],$campo_bind["parametros"]);
                                        } else {
                                            $params["result"]->bindColumn($campo_bind["campo"],$campo_bind["retorno"]);    
                                        }
                                    } 
                                }
                            }
                        }
                        
                        $params["result"]->execute();                        
                        if ($params["result"]->errorCode() != 0) {
                            $this->fechar_cursor($resultado_sql);
                            $this->rollback($conexao);
                            if ($params["lancar_excessao"] ?? true) {									
                                print_r($resultado_sql["result"]->erroInfo());
                                throw new \Exception("erro ao executar sql");
                            }
                        }

        
                        if (($params["commit"] ?? false) === true) {
                            if ($params["conexao"]->inTransaction() === true) {
                                $params["conexao"]->commit();
                            } else {
                                $params["conexao"]->query("commit");
                            }
                        }
                        if ($params["fetch"] !== null && $params["fetch"] !== false) {
                            switch(strtolower(trim($params["fetch"]))) {
                                case "fetchcolumn" :
                                    $params["data"] = $params["result"]->{$params["fetch"]}($params["numcol"]);
                                    break;
                                case "fetchclob" :
                                case "fetchlob" :
                                case "clob":
                                case "lob":
                                    $params["data"] = [];
                                    while($lin = $params["result"]->fetch($params["fetch_mode"])) {
                                        foreach($lin as &$col) {
                                            if (in_array(gettype($col),["object","resource"])) {
                                                $col = stream_get_contents($col);
                                            }
                                        }
                                        $params["data"][] = $lin;
                                    }
                                    break;
                                default:
                                    if ($params["fetch_mode"] === \PDO::FETCH_COLUMN) {
                                        $params["data"] = $params["result"]->{$params["fetch"]}($params["fetch_mode"],$params["numcol"]);
                                    } else {
                                        $params["data"] = $params["result"]->{$params["fetch"]}($params["fetch_mode"]);
                                    }
                                    break;
                            }

                            if ($params["retornar_resultset"]) {

                                /*obtem os campos caso existam*/
                                $numcols = $params["result"]->columnCount();
                                $params["fields"] = [];
                                for($i = 0; $i < $numcols; $i++) {
                                    $params["fields"][] = $params["result"]->getColumnMeta($i)["name"];
                                }
                                $this->fechar_cursor($params["result"]);

                            } else {
                                $this->fechar_cursor($params["result"]);
                                if (!self::result_as_array_data($params)) {
									$params = [];
								}
                            }
                        }
                        break;
                }
                return $params;
            } catch(\Error | \Throwable | \Exception | \PDOException $e ) {
                $this->fechar_cursor($params["result"]);
                echo "erro de sql: ";
                var_dump($e);
                exit();
                return null;
            }
        }

        public static function result_as_array_data(?array &$result) : bool {
            if (FuncoesArray::verif_valor_chave($result,["data"],0,"qt",">")) {
                $result = $result["data"];
                return true;
            } 
            return false;
        }

        function fechar_cursor(object|array|int|bool|null &$cursor) {
            try {
                if ($cursor !== null) {
                    if (gettype($cursor) === "object") {
                        $cursor->closeCursor(); 
                    } else if (gettype($cursor) === "array") {
                        if (isset($cursor["result"])) {
                            $cursor["result"]->closeCursor(); 
                        }
                    }
                }          
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
            } finally {
                $cursor = null;
            }
        }

        function rollback(?object &$param_conexao) {
            try {
                if ($param_conexao !== null) {
                    if ($param_conexao->inTransaction()) {
                        $param_conexao->rollback();                    
                    }
                }          
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
            } 
        }

        function commit(?object &$param_conexao) {
            try {
                if ($param_conexao !== null) {
                    if ($param_conexao->inTransaction()) {
                        $param_conexao->commit();
                    }
                }          
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
            } 
        }

        /**
            * Função que monta uma condicionante para ser usada num comando sql.
            * @param string $campopadrao o campo que sera usado se nao estiver presente na condic
            * @param string $condic o valor da condicionante ou a expressao (campo = valor)
            * @return string $retorno a condicionante montada
        */
        function montar_condic($campopadrao=null,$condic=null) {
			$retorno = $condic;
			if (isset($condic)) {
				if (isset($campopadrao)) {
					if (gettype($condic) === "string" || gettype($condic) === "number" || gettype($condic) === "integer") {
						if (strpos($condic,"=") === false && stripos($condic," in ") === false && stripos($condic," like ") === false) {
							$retorno = $campopadrao . " = " . $condic ;
						} 
					} 
				}
			}
			return $retorno;
		}


        /**
            * Função que executa select conforme parametros e devolve o resultado.
            * @param array $param os parametros do select (["campos","tabela","condic","ordenacao"]) 
            * @return array $dados_sql os dados obtidos
        */
        function obter_dados_sql($param=[]) {
			try {
                $dados_sql = null;
                if ($this->tabela_existe($param["tabela"]) === true) {
                    $cmd = "select ";
                    if (isset($param["campos"])) {
                        if (gettype($param["campos"]) === "array") {
                            $param["campos"] = implode(",",$param["campos"]);
                        }
                        if (strlen(trim((string)$param["campos"])) > 0) {
                            $cmd .= $param["campos"];
                        }
                        if (isset($param["tabela"])) {
                            if (gettype($param["tabela"]) === "array") {
                                $param["tabela"] = implode(",",$param["tabela"]);
                            }
                            $cmd .= " from " . $param["tabela"];
                            if (isset($param["condic"])) {
                                if (gettype($param["condic"]) === "array") {
                                    $param["condic"] = implode(" and " , $param["condic"]);
                                }
                                $cmd .= " where " . $param["condic"];
                            }
                            if (isset($param["ordenacao"])) {
                                if (gettype($param["ordenacao"]) === "array") {					
                                    $param["ordenacao"] = " order by " . implode(",",$param["ordenacao"]);
                                } else {
                                    if (strlen(trim($param["ordenacao"])) > 0) {
                                        $param["ordenacao"] = " order by " . $param["ordenacao"];
                                    }
                                }
                                $cmd .= $param["ordenacao"];
                            } 
                            if (isset($param["retornar_cmd"])) {
                                if ($param["retornar_cmd"] === true) {
                                    return $cmd;
                                }
                            }
                            $param["fetch"] = $param["fetch"] ?? "fetchAll";
                            $params_exec = [
                                "query" => $cmd,
                                "fetch" => $param["fetch"],
                                "fetch_mode" => \PDO::FETCH_ASSOC
                            ];
                            if (!isset($param["unico"])) {
                                $param["unico"] = false;
                            }                            
                            if ($param["unico"] === true && $param["fetch"] !== false) {
                                $params_exec["fetch"] = "fetch";
                            }
                            
                            $cursor_dados_sql = $this->executar_sql($params_exec);
                            if ($cursor_dados_sql !== null && count($cursor_dados_sql) > 0) {                                
                                if ($param["unico"] === true) {
                                    if ($param["fetch"] === false) {
                                        //print_r($params_exec);
                                        $dados_sql = $cursor_dados_sql["result"]->fetch(\PDO::FETCH_ASSOC);
                                        if (gettype($dados_sql) === "array") {
                                            foreach($dados_sql as &$col) {
                                                $col = FuncoesVariaveis::como_texto_ou_funcao($col);
                                            }
                                        }
                                        $this->fechar_cursor($cursor_dados_sql);
                                    } else {
                                        foreach($cursor_dados_sql as &$col) {
                                            $col = FuncoesVariaveis::como_texto_ou_funcao($col);
                                        }
                                        $dados_sql = $cursor_dados_sql;
                                    }
                                } else {
                                    if ($param["fetch"] === false) {
                                        $dados_sql = [];
                                        while($linha = $cursor_dados_sql["result"]->fetch(\PDO::FETCH_ASSOC)) {
                                            foreach($linha as &$col) {
                                                if (in_array(gettype($col),["resource","object"])) {
                                                    $col = stream_get_contents($col);
                                                }
                                                $col = FuncoesVariaveis::como_texto_ou_funcao($col);
                                            }
                                            $dados_sql[] = $linha;
                                        }
                                        $this->fechar_cursor($cursor_dados_sql);
                                    } else {
                                        foreach($cursor_dados_sql as &$linha) {
                                            foreach($linha as &$col) {
                                                $col = FuncoesVariaveis::como_texto_ou_funcao($col);
                                            }
                                        }
                                        $dados_sql = $cursor_dados_sql;
                                    }                                    
                                }
                            }
                        }
                    }
                }
                return $dados_sql;
            } catch(\Error | \Throwable | \Exception $e) {
                print_r($e);
                exit();
                return null;
            }    
		}


        /**
            * Função que obter o usuario do sistema conforme parametros
            * @param array $param os parametros do select (["condic"]) 
            * @return array $retorno os dados obtidos
        */
        function obter_usuario_sis($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codusuariosis",$param["condic"]);	 
			$retorno = $this->obter_dados_sql($param);
			return $retorno;	
		}



        /**
            * @param string $tabela nome da tabela 
            * @param string $campos campos 
            * @param string $valores valores 
            * @param string $condicionantes condicionantes 
            * @return string $retorno o resultado do processo em caso de falha ou null
        */	
        function atualizar_dados_sql_avulso($tabela,$campos,$valores,$condicionantes = [],$descricao_processo = "atualizar_dados_sql_avulso"){
			$retorno = "";
			if ($this->tabela_existe($tabela)) {
                $nome_conexao = VariaveisSql::getInstancia()->getNomeConexaoPadrao();
                $dados_conexao = VariaveisSql::$dados_conexoes->{$nome_conexao};
				$campos_sem_tabela = [];
				foreach($campos as $campo){
					if(strpos($campo,".") !== false) {
						$campos_sem_tabela[] = substr($campo,strpos($campo,".")+1);
					} else {
						$campos_sem_tabela[] = strtolower(trim($campo));
					}
				}
				$campos_sem_tabela = FuncoesArray::valores_minusculos($campos_sem_tabela);		
				$campos_chaves_primaria=$this->obter_campos_tabela($tabela,"primary");
				$campos_chaves_primaria = FuncoesArray::valores_minusculos($campos_chaves_primaria);		
				$campos_chaves_unica=$this->obter_campos_tabela($tabela,"unique");
				$campos_chaves_unica = FuncoesArray::valores_minusculos($campos_chaves_unica);		
				if (count($campos) <> count($valores)) {
					print_r($campos);
					print_r($valores);
					$retorno = "impossivel atualizar, quantidade de campos diverge da quantidade de valores";
					FuncoesBasicasRetorno::mostrar_msg_sair($retorno,__FILE__,__FUNCTION__,__LINE__);
				} else {
					$cnj_set = [];
					$campos_numerico = $this->obter_campos_tabela($tabela,"numero"); 
					$campos_data = $this->obter_campos_tabela($tabela,"date"); 
                    $campos_datatime = $this->obter_campos_tabela($tabela,"datetime"); 
					$campos_texto = $this->obter_campos_tabela($tabela,"varchar2");
					$campos_numerico = FuncoesArray::valores_minusculos($campos_numerico);		
					$campos_data = FuncoesArray::valores_minusculos($campos_data);
                    $campos_datatime = FuncoesArray::valores_minusculos($campos_datatime);
					$campos_texto = FuncoesArray::valores_minusculos($campos_texto);
					if (isset($campos_numerico) && $campos_numerico !== null && gettype($campos_numerico) === "array" && count($campos_numerico) > 0) {
						foreach($campos_numerico as $campo_num) {
							$ind = array_search(trim(strtolower($campo_num)),$campos_sem_tabela) ;
							if ($ind !== false) {
								if (trim(str_replace(" ","",$valores[$ind])) === "") {
									$valores[$ind] = "null";
								} elseif (strlen(trim(str_ireplace(["0","1","2","3","4","5","6","7","8","9",".",",",".","+","-",Constantes::subst_virg],"",$valores[$ind]))) > 0) {
									
								} elseif (trim($valores[$ind]) !== null) {
									$valores[$ind] = FuncoesConversao::como_numero(str_ireplace(Constantes::subst_virg,",",$valores[$ind]));
								}
							}
						}
					}
                    
					if (isset($campos_data) && $campos_data !== null && count($campos_data) > 0) {
						foreach($campos_data as $campo_data) {
							$ind = array_search(trim(strtolower($campo_data)),$campos_sem_tabela) ;
							if ($ind !== false) {					
                                $nome_funcao_data_corrente = $dados_conexao->driver->functions->current_datetime->name ?? $dados_conexao->driver->functions->current_datetime ?? null;                                
                                if (strcasecmp(trim($valores[$ind]),trim($nome_funcao_data_corrente)) != 0) { 
                                    if (strpos($valores[$ind],"'") === false) {
                                        $valores[$ind] = "'" . $valores[$ind] . "'";    
                                    }
                                } 
							}
						}
					}
                    
                    if (isset($campos_datatime) && $campos_datatime !== null && count($campos_datatime) > 0) {
						foreach($campos_datatime as $campo_datatime) {
							$ind = array_search(trim(strtolower($campo_datatime)),$campos_sem_tabela) ;
							if ($ind !== false) {
                                $nome_funcao_data_corrente = $dados_conexao->driver->functions->current_datetime->name ?? $dados_conexao->driver->functions->current_datetime ?? null;                                
                                if (strcasecmp(trim($valores[$ind]),trim($nome_funcao_data_corrente)) != 0) { 
                                    if (strpos($valores[$ind],"'") === false) {
                                        $valores[$ind] = "'" . $valores[$ind] . "'";    
                                    }
                                } 
							}
						}
					}
                    
					foreach($campos_sem_tabela as $ind=>$camposst) {
						if (array_search($camposst,(count($campos_numerico) > 0?$campos_numerico:[])) !== false 
							|| array_search($camposst,(isset($campos_data) && $campos_data !== null && count($campos_data) > 0?$campos_data:[])) !== false) {
						} else {
							$valores[$ind] = str_ireplace(Constantes::subst_virg,",",$valores[$ind]);
							$valores[$ind] = str_replace("'","''",$valores[$ind]) ;
							if (!in_array(strtolower(trim($valores[$ind])),["current_date","current_timestamp","sysdate"]) && strpos($valores[$ind],"'") === false) { 
								$valores[$ind] = "'" . $valores[$ind] . "'";
							}
						}
					}
					foreach($campos as $chave_campo => &$campo) {
						$cnj_set[] = $campo . "=" . $valores[$chave_campo];
					}
					foreach($condicionantes as $chave=>&$condic) {
						$condic = explode("=",$condic);
						if ((strpos($condic[1],"'") === false || strpos($condic[1],"'") != 0)) {
							if (count($campos_numerico) > 0) {
								if (array_search(strtolower(trim($condic[0])),$campos_numerico) === false) {
									$condic[1] = "'" . FuncoesString::aumentar_nivel_aspas_simples($condic[1]) . "'" ;
								}
							} else {
								$condic[1] = "'" . FuncoesString::aumentar_nivel_aspas_simples($condic[1]) . "'" ;
							}
						}
						$condic = implode("=",$condic);
						$condicionantes[$chave] = $condic;
					}
                    $params_query = [];
					$params_query["query"]="update ".$tabela." set ".implode(",",$cnj_set)." where ".implode(" and ",$condicionantes);
                    //echo $params_query["query"]; exit();
                    $params_query["commit"] = true;
					$ret_stmt = $this->executar_sql($params_query);
					$this->fechar_cursor($ret_stmt);
                    $retorno = 0;
				}
			}
			return $retorno;
		}



        function obter_processo($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "processo";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("CODPROCESSO",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("processo nao encontrado: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}	
			return $retorno;	
		}

        public function obter_tabela_sis($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "tabelasis";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codtabelasis",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("tabelasis nao encontrada: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}	
			return $retorno;
		}

        public function obter_campo_sis($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "camposis";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codcamposis",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			return $retorno;	
		}

        public function obter_tabela_db($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codtabeladb",$param["condic"]);
			$tabdb = $this->obter_dados_sql($param);
			if ($tabdb !== null && count($tabdb) > 0) {
				if ($param["unico"]) {
					$tabdb["campodb"] = [];
				} else {
					foreach($tabdb as $chave => &$tab) {
						$tab["campodb"] = [];						
					}
				}
			} else {
				FuncoesBasicasRetorno::mostrar_msg_sair("tabeladb nao encontrada: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}
			return $tabdb;
		}

        public function obter_campo_db($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "campodb";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codcampodb",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("campodb nao encontrado: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}
			return $retorno;	
		}

        function obter_relacionamento($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "relacionamentos";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codrelacionamento",$param["condic"]);
			return $this->obter_dados_sql($param);
		}

        function obter_lig_tabelasis($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "ligtabelasis";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codligtabelasis",$param["condic"]);	
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("ligtabelasis nao encontrada: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}
			return $retorno;	
		}

        function obter_lig_camposis($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "ligcamposis";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codligcamposis",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("ligcamposis nao encontrado: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}	
			return $retorno;	
		}

		function obter_lig_tabeladb($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "ligtabeladb";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codligtabeladb",$param["condic"]);
			$retorno = $this->obter_dados_sql($param);
			if (count($retorno ?? []) === 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("ligtabeladb nao encontrada: ". $param["condic"] , __FILE__,__FUNCTION__,__LINE__);
			}	
			return $retorno;	
		}

		function obter_lig_campodb($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "ligcampodb";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codligcampodb",$param["condic"]);
			$ligcampodb = $this->obter_dados_sql($param);
            if ($ligcampodb !== null && count($ligcampodb) > 0) {
                $ligcampodbtemp = [];
                if ($param["unico"]) {
                    $ligcampodbtemp = [$ligcampodb];
                } else {
                    $ligcampodbtemp = $ligcampodb;
                }
                foreach($ligcampodbtemp as &$ligcampodbt) {
                    $ligcampodbt["relacionamentos_especificos"] = [];		
                    if (!in_array(strtolower(trim($ligcampodbt["codsrelsespecificos"])),["null",""])) {
                        $param["retornar_cmd"] = (isset($param["retornar_cmd"])?$param["retornar_cmd"]:false);
                        $relespec = $this->obter_relacionamento(["condic"=>"codrelacionamento in (select column_value from table(sjdpkg_funcs_array.como_array_num('" . $ligcampodbt["codsrelsespecificos"] . "')))","unico"=>false,"retornar_cmd"=>$param["retornar_cmd"]]);
                        if (count($relespec) > 0) {
                            $ligcampodbt["relacionamentos_especificos"] = $relespec;
                        }
                    }
                }
                if ($param["unico"]) {
                    $ligcampodb = $ligcampodbtemp[0];
                } else {
                    $ligcampodb = $ligcampodbtemp;
                }
            }
			return $ligcampodb;
		}

        function obter_lig_relacionamento($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "ligrelacionamento";
			$param["campos"] = "*";
			$param["condic"] = $this->montar_condic("codligrelacionamento",$param["condic"]);
			return $this->obter_dados_sql($param);
		}

        public function montar_sql_processo_estruturado(&$comhttp) {
			return FuncoesMontarSqlEstruturado::montar_sql_processo_estruturado($comhttp);
		}

        public function traduzir_constantes_sql($texto,$aliastab=null,$nomecampo=null,$usuariodb=null){	
			$texto_traduzido = $texto;
			$texto_temp = $texto_traduzido;
			
			if ($aliastab !== null && strlen(trim($aliastab)) > 0) {
				if ($nomecampo !== null && strlen(trim($nomecampo)) > 0) {
					$texto_temp = str_replace("__TABELA__.__CAMPO__", $aliastab . "." . $nomecampo ,$texto_temp);
				}
				$texto_temp = str_replace("__TABELA__", $aliastab ,$texto_temp);		
			} else {
				if ($nomecampo !== null && strlen(trim($nomecampo)) > 0) {
					if ($aliastab !== null && strlen(trim($aliastab)) > 0) {
						$texto_temp = str_replace("__CAMPO__", $aliastab . "." . $nomecampo ,$texto_temp);
					} else {
						$texto_temp = str_replace("__CAMPO__", $nomecampo ,$texto_temp);
					}
				}
			}
			if (strpos($texto_temp,"__USUARIODB__") !== false) {
				if ($usuariodb !== null && strlen(trim($usuariodb)) > 0) {
					$texto_temp = str_replace("__USUARIODB__", $usuariodb ,$texto_temp);
				} else {
					$texto_temp = str_replace("__USUARIODB__", VariaveisSql::getInstancia()->getNomeSchema() ,$texto_temp);
				}
			}
			$texto_traduzido = $texto_temp;		
			
			
			if ($this::class !== $this->getInstanciaSis()::class) {
				if (method_exists('\\' . $this->getInstanciaSis()::class,__FUNCTION__) || 
					method_exists($this->getInstanciaSis(),__FUNCTION__)) {						
					$texto_traduzido = \call_user_func_array(array($this->getInstanciaSis(),__FUNCTION__),array($texto_traduzido,$aliastab,$nomecampo,$usuariodb));
				}
			} 
			return $texto_traduzido;
		}

        public function traduzir_criterios_acesso($usuariosis,$criterios_acesso){
			$criterios_traduzidos = [];
			$usuariosis = $this->verif_usuario_sis($usuariosis);
			$obteve_usuarios_subordinados = false;
			$usuarios_subordinados = [];
			$obteve_usuario_superior = false;
			$usuario_superior = [];
			$obteve_usuarios_filial = false;
			$usuarios_filial = [];
			$obteve_fonecs = false;
			$fornecs = [];
			$obteve_deptos = false;
			$deptos = [];
			
			
			if ($criterios_acesso !== null && count($criterios_acesso) > 0) {
                foreach ($criterios_acesso as $chave_crit => $criterio) {
                    $crit_temp = $criterio["criterios"];
                    $crit_temp = str_ireplace("__CODUSUR__", $usuariosis["codusuariosis"], $crit_temp);
                    $crit_temp = str_ireplace("__CODFILIALUSUR__", $usuariosis["codfilial"], $crit_temp);
                    
                    if (stripos($crit_temp,"__CODUSURSUBORDINADOS__") !== false) {
                        if ($obteve_usuarios_subordinados === false) { 
                            $usuarios_subordinados = FuncoesSisJD::getInstancia()->obter_usuarios_subordinados($usuariosis["codusuariosis"]);
                            $obteve_usuarios_subordinados = true; //garante que so execute uma vez dentro do loop;
                        }
                        $crit_temp = str_ireplace("__CODUSURSUBORDINADOS__", implode(",", $usuarios_subordinados), $crit_temp);				
                    }
                    
                    if (stripos($crit_temp,"__CODSUPERVUSUR__") !== false) {
                        if ($obteve_usuario_superior === false) { 
                            $usuario_superior = FuncoesSisJD::getInstancia()->obter_usuario_superior($usuariosis["codusuariosis"]);
                            $obteve_usuario_superior = true; //garante que so execute uma vez dentro do loop;
                            if (isset($usuario_superior[0]) && gettype($usuario_superior[0]) === "array") {
                                $usuario_superior = $usuario_superior[0];
                            }
                        }

                        //print_r($usuario_superior); exit();
                        $crit_temp = str_ireplace("__CODSUPERVUSUR__", implode(",", $usuario_superior), $crit_temp);
                    }
                    
                    if (stripos($crit_temp,"__CODSUSURFILIALUSUR__") !== false) {
                        if ($obteve_usuarios_filial === false) { 
                            $usuarios_filial = FuncoesSisJD::getInstancia()->obter_usuarios_filial($usuariosis["codfilial"]);
                            $obteve_usuarios_filial = true; //garante que so execute uma vez dentro do loop;
                        }
                        $crit_temp = str_ireplace("__CODSUSURFILIALUSUR__", implode(",", $usuarios_filial), $crit_temp);
                    }
                    
                    
                    if ((integer)$usuariosis["codnivelacesso"] >= 60 && (integer)$usuariosis["codnivelacesso"] <= 69) {
                        if ($obteve_fonecs === false) { 
                            $fornecs = FuncoesSisJD::getInstancia()->obter_fornecs_vinculados($usuariosis["codusuariosis"]);
                            //print_r($fornecs); exit();
                            $obteve_fonecs = true;
                        }
                        if (count($fornecs) === 0) {
                            FuncoesBasicasRetorno::mostrar_msg_sair("criterio para o nivel de acesso nao definido, obrigatorio definilo: ".$usuariosis["codnivelacesso"], __FILE__, __FUNCTION__, __LINE__);
                        }
                        $crit_temp = str_ireplace("__CODFORNECUSUR__", implode(",", $fornecs),  $crit_temp);
                    }
                    
                    
                    if (stripos($crit_temp,"__CODEPTO__") !== false) {
                        if ($obteve_deptos === false) { 
                            $deptos = FuncoesSisJD::getInstancia()->obter_deptos_vinculados($usuariosis["codusuariosis"]);
                            $obteve_deptos = true; //garante que so execute uma vez dentro do loop;
                        }
                        $crit_temp = str_ireplace("__CODEPTO__", implode(",", $deptos),  $crit_temp);
                    }
                    
                    
                    
                    if (isset($_SESSION["tipousuario"])) {
                        if ($_SESSION["tipousuario"] === "CLIENTE") {
                            $crit_temp = str_ireplace("__CODCLI__", $_SESSION["codcli"], $crit_temp);
                            $crit_temp = str_ireplace("__CNPJCLIENTE__", $_SESSION["codusur"], $crit_temp);
                        }
                    }
                    
                    if (strpos($crit_temp, "__") !== false) {
                        FuncoesBasicasRetorno::mostrar_msg_sair("criterio acesso nao traduzido: " . $crit_temp, __FILE__, __FUNCTION__, __LINE__);
                    }
                    $criterios_traduzidos[] = $crit_temp;				
                }	
            }
			return $criterios_traduzidos;
		}

        function preparar_condicionantestab($condicionantestab){	
			$retorno = [];
			if (gettype($condicionantestab) !== "array") {
				$condicionantestab = explode(strtolower(Constantes::sepn1), strtolower($condicionantestab));
				$condicionantestabtemp = [];
				foreach($condicionantestab as $condtab) {
					$condtab = str_ireplace(Constantes::subst_virg, ",", strtolower($condtab));
					if (strpos($condtab, "[") !== false) {
						$nometabcond = substr($condtab, 0, strpos($condtab, "["));
						$condtab = substr($condtab, strpos($condtab, "[") + 1, strlen($condtab) - (strpos($condtab, "[") + 1 + 1));
					} else {
						$nometabcond = count($condicionantestab);
					}
					$condicionantestabtemp[$nometabcond] = $condtab;
				}
				$retorno = $condicionantestabtemp;
			} else {
				$retorno = $condicionantestab;
			}
			return $retorno;
		}


        /**
            * Função que obtem dados de opcoes dados sql do sistema conforme parametros
            * @param array $param os parametros do select (["condic"]) 
            * @return array os dados obtidos
		*/
        function obter_opcoes_dados_sql($param=[]) {
			$param["tabela"] = VariaveisSql::getInstancia()->getPrefixObjects() . "opcoesdadossql";
			$param["campos"] = $param["campos"] ?? "*";
            $param["fetch"] = $param["fetch"] ?? false; //tem clob, campo opcoes
			$param["condic"] = $this->montar_condic("codopcdadossql",$param["condic"]);
			return $this->obter_dados_sql($param);
		}

        function tipo_como_tipo_driver(array | object $tipos_driver, string $tipo_dado) : ?object {
            $retorno = null;
            foreach($tipos_driver as $chave_tipo_dado_driver => $tipo_dado_driver) {
				if (strcasecmp(trim($chave_tipo_dado_driver),$tipo_dado) == 0 || 
					strcasecmp(trim($tipo_dado_driver->name),$tipo_dado) == 0 || 
					in_array(strtolower(trim($tipo_dado)),$tipo_dado_driver->synonyms)
				) {
					$retorno = $tipo_dado_driver;
					break;
				} 
			}
            return $retorno;
        }

        function detectar_mascara_data_oracle($data) {
			$mascara = null;
			if (strpos($data,"/") === 2) {
				$mascara = "dd/mm/yyyy";
			}
			if (strpos($data," ") === 10) {
				if (strpos($data,":") === 13) {
					$mascara .= " HH24:mi";
					if (strpos($data,":",strpos($data,":")+1) === 16) {
						$mascara .= ":ss";
					}
				}
			}
			return $mascara;
		}

        /**
            * Função que inclui dados na base sql conforme parametros do pacote TComHttp.
            * @param TComHttp $comhttp o pacote de comunicacao TComHttp
            * @return array $dados_retorno os unique keys dos registro incluidos
        */
        function incluir_dados_sql(&$comhttp){
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] = "linha_dados";
			}
			switch($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"]){
				case "linha_dados":	
					$tabela=$comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"])) {
						$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"] = $comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					}
					$campos = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["campos"]);
					$campos = FuncoesArray::valores_minusculos($campos);
					$valores = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["valores"]);
					
					$campos_sem_tabela = [];
					foreach($campos as $campo){
						if (strpos($campo,".") !== false) {
							$campos_sem_tabela[] = substr($campo,strpos($campo,".")+1);
						} else {
							$campos_sem_tabela[] = $campo;
						}
					}
					$campos_sem_tabela = FuncoesArray::valores_minusculos($campos_sem_tabela);			
					if (FuncoesArray::verif_valor_chave($comhttp->requisicao->requisitar->qual->condicionantes,["ignorar_condicionantes_tab"],true) === true) {
						//nada a fazer;
					} else {
						$condicionantestab = [];			
						if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"])) {
							$condicionantestab = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"];
						}
						$condicionantestab = $this->preparar_condicionantestab($condicionantestab);
						if (count($condicionantestab) > 0) {
							foreach($condicionantestab as $condtab) {
								$condtab = explode("and ", $condtab);
								foreach($condtab as $cond) {
									if (strpos($cond,"=") !== false && strpos($cond,"!=") === false) {
										$cond = explode("=",$cond);
										$cond[0] = strtolower(trim($cond[0]));
										if (in_array($cond[0],$campos)) {
											$valores[array_search($cond[0],$campos)] = $cond[1];
										} else if (in_array(substr($cond[0],strpos($cond[0],".")+1),$campos)) {
											$valores[array_search(substr($cond[0],strpos($cond[0],".")+1),$campos)] = $cond[1];
										} else if (in_array($cond[0],$campos_sem_tabela)) {
											$valores[array_search($cond[0],$campos_sem_tabela)] = $cond[1];
										} else if (in_array(substr($cond[0],strpos($cond[0],".")+1),$campos_sem_tabela)) {
											$valores[array_search(substr($cond[0],strpos($cond[0],".")+1),$campos_sem_tabela)] = $cond[1];	
										} else {
											$campos[] = $cond[0];
											$campos_sem_tabela[] = $cond[0];
											$valores[] = $cond[1];
										}
									}
								}
							}
						}
					}
					$campos_chaves_primaria = $this->obter_campos_tabela($comhttp->requisicao->requisitar->qual->condicionantes["tabela"],"primary"); 					
					$campos_chaves_primaria = FuncoesArray::valores_minusculos($campos_chaves_primaria);
					//print_r($campos_chaves_primaria);exit();
					$campos_chaves_unica = $this->obter_campos_tabela($comhttp->requisicao->requisitar->qual->condicionantes["tabela"],"unique"); 					
					$campos_chaves_unica = FuncoesArray::valores_minusculos($campos_chaves_unica);
					$campos_numerico = $this->obter_campos_tabela($comhttp->requisicao->requisitar->qual->condicionantes["tabela"],"numero"); 
					$campos_data = $this->obter_campos_tabela($comhttp->requisicao->requisitar->qual->condicionantes["tabela"],"date"); 
					$campos_numerico = FuncoesArray::valores_minusculos($campos_numerico);
					$campos_data = FuncoesArray::valores_minusculos($campos_data);
					$dados_retorno=[];
					$cont_campos_retorno = 0;
					if (isset($campos_chaves_primaria) && $campos_chaves_primaria !== null && gettype($campos_chaves_primaria) === "array" && count($campos_chaves_primaria) > 0) {
						foreach($campos_chaves_primaria as $ind=>$campo_chave_primaria){
							if (in_array($campo_chave_primaria,$campos_numerico)) {
								$comando_sql="select nvl(max(" .$campo_chave_primaria."),-1)+1 as ".$campo_chave_primaria." from ".$tabela;
								$valores_campos_chaves_primaria[$ind]=$this->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC)[0][$campo_chave_primaria];				
								$dados_retorno[$cont_campos_retorno]=[];
								if (in_array(strtolower(trim($campo_chave_primaria)),$campos)) {
									$valores[array_search(strtolower(trim($campo_chave_primaria)),$campos)] = $valores_campos_chaves_primaria[$ind];					
									$dados_retorno[$cont_campos_retorno]["chave"]=$campos[array_search(strtolower(trim($campo_chave_primaria)),$campos)];
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_primaria[$ind];
									
								} else if (in_array(strtolower(trim($campo_chave_primaria)),$campos_sem_tabela)) {
									$valores[array_search(strtolower(trim($campo_chave_primaria)),$campos_sem_tabela)] = $valores_campos_chaves_primaria[$ind];
									$dados_retorno[$cont_campos_retorno]["chave"]=$campos[array_search(strtolower(trim($campo_chave_primaria)),$campos)];
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_primaria[$ind];
									
								} else {
									array_unshift($campos,$campo_chave_primaria);
									array_unshift($campos_sem_tabela,$campo_chave_primaria);
									array_unshift($valores,$valores_campos_chaves_primaria[$ind]);
									$dados_retorno[$cont_campos_retorno]["chave"]=$campo_chave_primaria;
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_primaria[$ind];
									
								}
								$cont_campos_retorno ++;
							}
						}
					}
					if (isset($campos_chaves_unica) && $campos_chaves_unica !== null && gettype($campos_chaves_unica) === "array" && count($campos_chaves_unica) > 0) {
						foreach($campos_chaves_unica as $ind=>$campo_chave_unica){
							if (in_array($campo_chave_unica,$campos_numerico)) {
								$comando_sql="select nvl(max(" .$campo_chave_unica."),-1)+1 as ".$campo_chave_unica." from ".$tabela;
								$valores_campos_chaves_unica[$ind]=$this->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC)[0][$campo_chave_unica];
								$dados_retorno[$cont_campos_retorno]=[];
								if (in_array(strtolower(trim($campo_chave_unica)),$campos)) {
									$valores[array_search(strtolower(trim($campo_chave_unica)),$campos)] = $valores_campos_chaves_unica[$ind];					
									$dados_retorno[$cont_campos_retorno]["chave"]=$campos[array_search(strtolower(trim($campo_chave_unica)),$campos)];
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_unica[$ind];
									
								} else if (in_array(strtolower(trim($campo_chave_unica)),$campos_sem_tabela)) {
									$valores[array_search(strtolower(trim($campo_chave_unica)),$campos_sem_tabela)] = $valores_campos_chaves_unica[$ind];
									$dados_retorno[$cont_campos_retorno]["chave"]=$campos[array_search(strtolower(trim($campo_chave_unica)),$campos)];
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_unica[$ind];
									
								} else {
									array_unshift($campos,$campo_chave_unica);
									array_unshift($campos_sem_tabela,$campo_chave_unica);
									array_unshift($valores,$valores_campos_chaves_unica[$ind]);
									$dados_retorno[$cont_campos_retorno]["chave"]=$campo_chave_unica;
									$dados_retorno[$cont_campos_retorno]["valor"]=$valores_campos_chaves_unica[$ind];
									
								}
								$cont_campos_retorno ++;
							}
						}
					}
					if (isset($campos_numerico) && $campos_numerico !== null && gettype($campos_numerico) === "array" && count($campos_numerico) > 0) {
						foreach($campos_numerico as $campo_num) {
							$ind = array_search(trim(strtolower($campo_num)),$campos_sem_tabela) ;
							if ($ind !== false) {
								if (strtolower(trim(str_replace(" ","",$valores[$ind]))) === "") {
									$valores[$ind] = "null";
								} elseif (strtolower(trim($valores[$ind])) !== "null") {
									$valores[$ind] = FuncoesConversao::como_numero(str_replace(Constantes::subst_virg,",",$valores[$ind]));
								}
							}
						}
					}
					if (isset($campos_data) && $campos_data !== null && gettype($campos_data) === "array" && count($campos_data) > 0) {
						foreach($campos_data as $campo_data) {
							$ind = array_search(trim(strtolower($campo_data)),$campos_sem_tabela) ;
							if ($ind !== false) {					
								$mascara_oracle = $this->detectar_mascara_data_oracle($valores[$ind]);
								$valores[$ind] = str_replace("'","''",$valores[$ind]) ;
								if ($mascara_oracle !== null) {
									$valores[$ind] = "to_date('" . $valores[$ind] . "' , '" . $mascara_oracle . "')";
								} else {
									$valores[$ind] = "'" . $valores[$ind] . "'";
								}
							}
						}
					}
					if (count($campos_sem_tabela) > 0) {
						foreach($campos_sem_tabela as $ind=>$camposst) {			
							if (array_search($camposst,(isset($campos_numerico) && $campos_numerico !== null && gettype($campos_numerico) === "array" && count($campos_numerico) > 0?$campos_numerico:[])) !== false || array_search($camposst,(isset($campos_data) && $campos_data !== null && gettype($campos_data) === "array" && count($campos_data) > 0?$campos_data:[])) !== false) {
							} else {
								if (strpos(trim($valores[$ind]),"'") === 0) {
									//ja esta com aspas simples, nao precisa acrescentar mais aspas ou nivel
								} else {
									$valores[$ind] = str_replace("'","''",$valores[$ind]) ;
									$valores[$ind] = "'" . $valores[$ind] . "'";
								}
							}
						}
					}
					$valores = implode(",",$valores);
					$valores = str_replace(Constantes::subst_virg,",",$valores);
					$comando_sql="insert into ". $tabela."(".implode(",",$campos).") values (".$valores.")";
					$comhttp->retorno->dados_retornados["dados"]=$dados_retorno;					
					$this->executar_sql($comando_sql);
                    $comando_sql = "commit";
                    $this->executar_sql($comando_sql);
					$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"]='Dados incluidos com sucesso';					
					break;
				default:
					FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao de dados sql: tipo de dados nao definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"],true,true);
					break;
			}
			return $dados_retorno;
		}


        /**
            * Função que duplica um registro sql conforme parametros do pacote TComHttp.
            * @param TComHttp $comhttp o pacote de comunicacao TComHttp
        */
        function duplicar_registro(&$comhttp){
			$comhttp->requisicao->requisitar->qual->condicionantes["campos"] = implode(",",$this->obter_campos_tabela($comhttp->requisicao->requisitar->qual->condicionantes["tabela"]));
			$comando = "select ".$comhttp->requisicao->requisitar->qual->condicionantes["campos"]." from ".$comhttp->requisicao->requisitar->qual->condicionantes["tabela"]." where " . $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];            
			$dados = $this->executar_sql($comando,"fetchAll",\PDO::FETCH_ASSOC) ;
			$dados_retorno = [];
			foreach($dados as &$linha) {
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"])) {
					foreach($comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"] as $chave_subst=>$valssubst) {
						$linha[$chave_subst] = $valssubst;
					}
				}
				foreach($linha as &$cel) {
                    if (in_array(gettype($cel),["resource","object"])){
                        $cel = stream_get_contents($cel);
                    }
					$cel = str_replace(",",Constantes::subst_virg,$cel);
				}
				$comhttp->requisicao->requisitar->qual->condicionantes["valores"] = implode(",",$linha);
				$this->incluir_dados_sql($comhttp);
				$dados_retorno=FuncoesArray::acrescentar_elemento_array($dados_retorno,$comhttp->retorno->dados_retornados["dados"],false);
			}
			$comhttp->retorno->dados_retornos["dados"] = $dados_retorno;
			return ;
		}


        /**
            * Função que executa um delete conforme pacote TComHttp.
            * @param TComHttp $comhttp pacote de comunicacao TComHttp
        */	
        function excluir_dados_sql(&$comhttp){
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] = "linha_dados";
			}
			switch($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"]){
				case "linha_dados":	
					$tabela=$comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"])) {
						$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"] = $comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					}
					$condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
					$condicionantes = explode(Constantes::sepn1,$condicionantes);
					$comando_sql="delete from " . $tabela." where ".implode(" and ",$condicionantes);
                    //echo $comando_sql; exit();
					$this->executar_sql($comando_sql);
                    $comando_sql = "commit";
                    $this->executar_sql($comando_sql);
					$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"]='Dados excluidos com sucesso';					
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: tipo de dados nao definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"],__FILE__,__function__,__LINE__);
					break;
			}
			return ;
		}

        /**
            * Função que executa um update conforme pacote TComHttp.
            * @param TComHttp $comhttp pacote de comunicacao TComHttp
		*/	
        function atualizar_dados_sql(&$comhttp){
			$retorno = "";
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] = "linha_dados";
			}
			switch($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"]){
				case "linha_dados":	
					$tabela=$comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"])) {
						$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"] = $comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
					}
					$campos=explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["campos"]);
					$valores=explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["valores"]);
					$condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
					$condicionantes = $this->traduzir_constantes_sql($condicionantes);
					$condicionantes = explode(Constantes::sepn1,$condicionantes);
					$descricao_processo = $comhttp->requisicao->requisitar->oque." ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"]." ".$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"];                    
					$retorno = $this->atualizar_dados_sql_avulso($tabela,$campos,$valores,$condicionantes,$descricao_processo);
					if($retorno==0){
						$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"] = "Dados atualizados com sucesso";
					} else {
						$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"] = $retorno;
					}
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: tipo de dados nao definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"],__FILE__,__function__,__LINE__);
					break;
			}
			return ;
		}

        function obter_campos_resource($resource,$associativo = false) {
			$retorno = [];
			if ($resource !== null) {
				$num_cols = $resource->columnCount();
				$i = 0;			
				for ($i = 0 ; $i < $num_cols ; $i++) {
					$nome_campo = htmlentities($resource->getColumnMeta($i)["name"],ENT_NOQUOTES,"ISO-8859-1");
					if ($associativo === true) {
						$retorno[$nome_campo] = $nome_campo;
					} else {
						$retorno[] = $nome_campo;
					}
				};
			}
			return $retorno;
		}

    };
?>