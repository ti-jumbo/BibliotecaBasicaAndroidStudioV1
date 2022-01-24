<?php
	namespace SJD\php\classes\funcoes;
	//tratar constraintcheck em campodb	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\Constantes,
			constantes\NomesExtensoes,
			constantes\NomesCaminhosArquivos,
			constantes\NomesCaminhosDiretorios,
			variaveis\VariaveisSql,
			sql\TSql
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesSql,
			FuncoesArquivo,
			FuncoesString,
			FuncoesArray,
			requisicao\FuncoesBasicasRetorno
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesAtualizacao extends ClasseBase{
		public static function criar_arquivo_recurso_todos(&$comhttp,&$opcoes) {
			try {
				if (count($opcoes) > 0) {
					switch(strtolower(trim($opcoes["atualizacao"]["tipoorigem"][0]))) {
						case "table":
							$comando_sql_temp = "select * from " . $opcoes["atualizacao"]["origem"][0];
							$dados_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp);
							if (count($dados_temp) > 0) {
								while($arquivo_rec = $dados_temp["result"]->fetch(\PDO::FETCH_ASSOC) ) {
									if (
										(
											isset($arquivo_rec["arqrecursopreexistente"]) && strcasecmp(trim($arquivo_rec["arqrecursopreexistente"]),"1") != 0
										) || !isset($arquivo_rec["arqrecursopreexistente"])
									) {
										$caminho_rec = FuncoesVariaveis::como_texto_ou_constante($arquivo_rec["caminhorecurso"]);										
										if (strlen(trim($caminho_rec)) > 0) {
											$name_space = str_ireplace(trim(NomesCaminhosDiretorios::raiz) . DIRECTORY_SEPARATOR,"",trim(pathinfo($caminho_rec)["dirname"]));
											$name_space = substr($name_space,1);
											$name_space = str_replace("\\\\","\\",$name_space);
											$caminho_rec = $_SERVER["DOCUMENT_ROOT"] . $caminho_rec;											
											$conteudo = FuncoesArquivo::ler_arquivo(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("base_html_recurso"));
											$conteudo = str_ireplace("__NAME_SPACE__",$name_space,$conteudo);
											$bloco_use = $arquivo_rec["bloco_use"] ?? "";
											$bloco_use = str_replace("\\\\","\\",$bloco_use);
											$conteudo = str_ireplace("__BLOCO_USE__",$bloco_use,$conteudo);
											$scripts = $arquivo_rec["scripts"] ?? "";
											if (gettype($scripts) === "resource") {
												$scripts = stream_get_contents($scripts);												
											}
											$conteudo = str_ireplace("__SCRIPTS__",$scripts,$conteudo);
											$caminho_rec = str_replace(["/","\\\\"],"\\",$caminho_rec);
											FuncoesArquivo::criar_arquivo($comhttp,$caminho_rec,$conteudo,true);											
										} 
									}
								}
							} else {
								FuncoesBasicasRetorno::mostrar_msg_sair("dados nao localizados para a origem: " .$opcoes["atualizacao"]["origem"][0],__FILE__,__FUNCTION__,__LINE__);
							}
							FuncoesSql::getInstancia()->fechar_cursor($dados_temp);
							break;
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair("comando vazio",__FILE__,__FUNCTION__,__LINE__);
							break;
					}
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair("comando vazio",__FILE__,__FUNCTION__,__LINE__);
				}
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e); exit();
				return null;
			} 
		}
		public static function criar_arquivo_variaveis_php_nfp(&$comhttp,&$opcoes) {
			$caminho_arquivo_variaveis_php_nfp = NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("variaveis_nomes_funcoes");
			$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "variaveisphpnfp order by 1";
			$variaveis_php_nfp = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$linhas = [];
			if (count($variaveis_php_nfp) > 0) {
				foreach($variaveis_php_nfp as $chavevar => &$var) {		
					$linhas[] = $var["objetovar"] . "=" . $var["valorvar"] . ";";
				}
			}
			$linhas = "<?php " . implode(chr(10),$linhas) . chr(10)." ?>";
			$comhttp_temp = null;
			FuncoesArquivo::criar_arquivo($comhttp_temp,$caminho_arquivo_variaveis_php_nfp,$linhas,true);
		}
		public static function criar_arquivo_variaveis_javascript(&$comhttp,&$opcoes) {
			$arquivo_variaveis = NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("variaveis_javascript");
			$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "variaveisjavascript order by 1";
			$variaveis_javascript = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($variaveis_javascript) > 0) {
				foreach($variaveis_javascript as $chavevar => &$valorvar) {		
					if (strpos($valorvar["nomevariavel"],".") !== false) {
					} else {
						$valorvar["nomevariavel"] = "var " . $valorvar["nomevariavel"];
					}
				}
			}
			FuncoesArquivo::criar_arquivo($arquivo_variaveis,$variaveis_javascript,true,["NOMEVARIAVEL","VALORVARIAVEL"],"=","",";");
		}
		public static function criar_arquivo_funcoes_javascript(&$comhttp,&$opcoes) {
			$arquivo_funcoes = NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("funcoes_javascript");
			$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "funcoesjavascript order by 1";
			$funcoes_javascript = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($funcoes_javascript) > 0) {
				FuncoesArquivo::criar_arquivo($arquivo_funcoes,$funcoes_javascript,false,["corpo"]);
				FuncoesArquivo::escrever_arquivo($arquivo_funcoes,"try{","inicio",true);
				FuncoesArquivo::escrever_arquivo($arquivo_funcoes,['} catch(e) {','     erro(e,"funcoes_javascript","bloco de funcoes avulsas");','}'],"fim",true);		
			}
		}
		public static function obter_caminho_catalogo($nome_catalogo) {
			if (strpos($nome_catalogo,".") !== false) {
				$nome_catalogo = substr($nome_catalogo,0,strpos($nome_catalogo,"."));
			}
			$caminho_catalogo = null;
			$nome_catalogo = strtolower(trim($nome_catalogo));
			if (NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis($nome_catalogo) !== null) {
				$caminho_catalogo = NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis($nome_catalogo);
			} else {				
				$caminho_catalogo = NomesCaminhosDiretorios::getInstancia()->getPropInstanciaSis("catalogos") . DIRECTORY_SEPARATOR . $nome_catalogo . NomesExtensoes::json;
			}
			return $caminho_catalogo;
		}
		public static function procurar_tabela_catalogo(&$comhttp,&$opcoes) {
			$tabela = VariaveisSql::getInstancia()->getPrefixObjects() . "TABELADB";
			$tabelas = [];
			if (FuncoesSql::getInstancia()->tabela_existe($tabela,true)) {	
				$comando_sql = "select * from ".$tabela;
				if (!in_array(strtolower(trim($opcoes["atualizacao"]["objeto"][0])),Constantes::sinonimos["todos"])) {
					$comando_sql.=" where upper(nometabeladb)='".$opcoes["atualizacao"]["objeto"][0]."'" ;
				}
				$comhttp->requisicao->sql = new TSql();
				$comhttp->requisicao->sql->comando_sql = $comando_sql;
				$dados = FuncoesSql::getInstancia()->executar_sql($comhttp,"fetchAll",\PDO::FETCH_ASSOC);
				$nometabeladb = "";
				if (count($dados) > 0) {
					foreach($dados as $lin) {
						$nometabeladb = $lin["nometabeladb"];
						$tabelas[$nometabeladb] = $lin;
						$tabelas[$nometabeladb]["campos"] = [];
						$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb where codtabeladb=".$tabelas[$nometabeladb]["codtabeladb"]." order by nvl(ordemcriacao,codcampodb)";
						$comhttp->requisicao->requisitar->qual->condicionantes["sql2"] = new TSql();
						$comhttp->requisicao->requisitar->qual->condicionantes["sql2"]->comando_sql = $comando_sql;
						$campos = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->requisitar->qual->condicionantes["sql2"]->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);		
						if (count($campos) > 0) {
							foreach($campos as $campo) {
								$tabelas[$nometabeladb]["campos"][$campo["nomecampodb"]]=$campo;
							}
						}
					}
				}
			}	
			return $tabelas;
		}
		
		public static function montar_comando_sql_criar_objetos_sql_padrao(&$comhttp,&$opcoes) {
			try {
				$comando_sql = null;
				$tabela = null;
				if (strcasecmp(trim($opcoes["atualizacao"]["tipoorigem"][0]),"table") == 0)  {
					$tabela = $opcoes["atualizacao"]["origem"][0];
				}
				if ($tabela !== null && FuncoesSql::getInstancia()->tabela_existe($tabela)) {
					$comando_sql2 = "select * from " . $tabela . " order by ordemcriacao";
					if (!in_array(strtolower(trim($opcoes["atualizacao"]["objeto"][0])),Constantes::sinonimos["todos"])){
						$comando_sql2 .= " where trim(lower(" . $opcoes["atualizacao"]["campocondicionante"][0] . ")) = '" . strtolower(trim($opcoes["atualizacao"]["objeto"][0])) . "'";
					}
					$campos_lob = FuncoesSql::getInstancia()->obter_campos_tabela($tabela,"lob");
					$params_exec_sql = [
						"query"=>$comando_sql2,
						"retornar_resultset"=>true
					];
					$cursor_dados_objetos = FuncoesSql::getInstancia()->executar_sql($params_exec_sql);
					$comando_sql = [];
					/*
						LOB - SE TIVER LOB NO RETORNO, NAO UTILIZAR FECTHALL(), BUG DO PHP RELATADO, O LOB 
						APONTARA SEMPRE PARA O ULTIMO REGISTRO. EM VEZ DISSO, UTILIZAR FETCH()
					*/
					while($dado = $cursor_dados_objetos["result"]->fetch(\PDO::FETCH_ASSOC) ) {
						switch (strtolower(trim($opcoes["atualizacao"]["tipoobjeto"][0]))) {				
							case "function":
							case "procedure":
							case "trigger":
								if (in_array(gettype($dado["corpo"]),["resource","object"])) {
									$dado["corpo"] = stream_get_contents($dado["corpo"]);
								}
								$cont_comandos = count($comando_sql);
								$comando_sql[$cont_comandos] = [];
								$comando_sql[$cont_comandos]["comandos"] = [];				
								$comando_sql[$cont_comandos]["comandos"][] = $dado["corpo"];
								break;			
							case "type":
							case "package":
								$cont_comandos = count($comando_sql);
								if (in_array(gettype($dado["cabecalho"]),["resource","object"])) {
									$dado["cabecalho"] = stream_get_contents($dado["cabecalho"]);
								}
								if (in_array(gettype($dado["corpo"]),["resource","object"])) {
									$dado["corpo"] = stream_get_contents($dado["corpo"]);
								}
								$comando_sql[$cont_comandos] = [];
								$comando_sql[$cont_comandos]["comandos"] = [];				
								$comando_sql[$cont_comandos]["comandos"][] = $dado["cabecalho"];
								if ($dado["corpo"] !== null && strlen(trim($dado["corpo"])) > 0) {
									$comando_sql[$cont_comandos]["comandos"][] = $dado["corpo"];
								}
								break;					
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("tipo_objeto não programado: " . $opcoes["atualizacao"]["tipoobjeto"][0],__FILE__,__FUNCTION__,__LINE__);
								break;
						}
					}		
				} else {
					$caminho_catalogo = self::obter_caminho_catalogo($opcoes["atualizacao"]["origem"][0]);				
					$dados_catalogo = FuncoesArquivo::ler_arquivo_catalogo_json($caminho_catalogo,["filtro"=>$opcoes["atualizacao"]["objeto"][0],"traduzir_apos_filtro"=>false,"preparar_string_antes"=>true]);
					$comando_sql = [];
					switch (strtolower(trim($opcoes["atualizacao"]["tipoobjeto"][0]))) {
						case "function":
						case "procedure":
						case "trigger":				
							$cont_comandos = count($comando_sql);
							$comando_sql[$cont_comandos] = [];
							$comando_sql[$cont_comandos]["comandos"] = [];				
							$comando_sql[$cont_comandos]["comandos"][] = $dados_catalogo->corpo;
							break;			
						case "type":
						case "package":				
							$cont_comandos = count($comando_sql);
							$comando_sql[$cont_comandos] = [];
							$comando_sql[$cont_comandos]["comandos"] = [];
							$comando_sql[$cont_comandos]["comandos"][] = $dados_catalogo->cabecalho;
							if ($dados_catalogo->corpo !== null && strlen(trim($dados_catalogo->corpo)) > 0) {
								$comando_sql[$cont_comandos]["comandos"][] = $dados_catalogo->corpo;
							}
							break;					
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair("tipo_objeto não programado: " . $opcoes["atualizacao"]["tipoobjeto"][0],__FILE__,__FUNCTION__,__LINE__);
							break;
					}
				}
				return $comando_sql;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e); exit();
				return null;
			} finally {
				FuncoesSql::getInstancia()->fechar_cursor($cursor_dados_objetos);
			}
		}
		public static function montar_comando_sql_arquivo_criar_catalogo_tabelas_campos(&$comhttp,&$opcoes) {
			
			$cont = 0;
			$qt = count($opcoes["atualizacao"]["origem"]);
			if ($qt > 0) {
				$comando_sql = [];
				$cont_comandos = 0;

				for($cont = 0; $cont < $qt; $cont++) {
					$nome_conexao = $opcoes["atualizacao"]["nome_conexao"][$cont] ?? $opcoes["atualizacao"]["nome_conexao"][0];
					$types_driver = VariaveisSql::getInstancia()::$dados_conexoes->{$nome_conexao}->driver->types;
					$tabela = null;
					$caminho_catalogo = self::obter_caminho_catalogo($opcoes["atualizacao"]["origem"][$cont]);			
					$tabela = FuncoesArquivo::ler_arquivo_catalogo_json($caminho_catalogo,[
						"filtro"=>$opcoes["atualizacao"]["objeto"][$cont],
						"traduzir_apos_filtro"=>false,
						"preparar_string_antes"=>true
					]);
					$nometabeladb = "";
					$nome_campodb = "";
					$tipo_campo = "";
					$tamanho = "";
					$precisao = "";
					$chaveprimaria = "";
					$unico = "";
					$permitenulo = "";
					$valorpadrao = "";
					$texto_campos = [];
					if ($tabela !== null) {
						$campos_tab = [];
						$valores_tab = [];
						$campos_tab = [];
						$valores_tab = [];			
						foreach ($tabela as $chave_campo=>$campo) {
							if ($chave_campo !== "sub") {
								$campos_tab[$chave_campo] = $chave_campo;
								$valores_tab[strtolower(trim($chave_campo))] = $campo;
							}
						}
						$campos_campos = [];
						$valores_campos = [];
						$texto_campos = [];
						if (property_exists($tabela,"sub")) {
							foreach($tabela->sub as $chave_campo => $campo) {
								$campos_campos[$chave_campo] = [];
								$valores_campos[$chave_campo] = [];
								foreach ($campo as $chave_campo_campo => $valor_campo) {
									$campos_campos[$chave_campo][$chave_campo_campo] = $chave_campo_campo;
									$valores_campos[$chave_campo][$chave_campo_campo] = $valor_campo;						
								}
									$nome_campodb = strtolower(trim((isset($valores_campos[$chave_campo]["nomecampodb"])?$valores_campos[$chave_campo]["nomecampodb"]:$chave_campo_campo)));
									$tipo_dado_driver = FuncoesSql::getInstancia()->tipo_como_tipo_driver($types_driver,$valores_campos[$chave_campo]["tipodado"]);									
									if (isset($tipo_dado_driver) && $tipo_dado_driver !== null) {
										$valores_campos[$chave_campo]["tipodado"] = $tipo_dado_driver->name ?? $valores_campos[$chave_campo]["tipodado"];
										if (property_exists($tipo_dado_driver,"constraintcheck")) {
											$valores_campos[$chave_campo]["constraintcheck"] = $valores_campos[$chave_campo]["constraintcheck"] ?? "";
											if (FuncoesString::strTemValor($valores_campos[$chave_campo]["constraintcheck"])) {
												$valores_campos[$chave_campo]["constraintcheck"] .= " and (".$tipo_dado_driver->constraintcheck.") ";
											} else {
												$valores_campos[$chave_campo]["constraintcheck"] = str_ireplace("__CAMPO__",$valores_campos[$chave_campo]["nomecampodb"],$tipo_dado_driver->constraintcheck);
											}
										}
										if (property_exists($tipo_dado_driver,"datasize")) {
											$valores_campos[$chave_campo]["tamanho"] = $tipo_dado_driver->datasize;
										}
										if (property_exists($tipo_dado_driver,"precision")) {
											$valores_campos[$chave_campo]["precisao"] = $tipo_dado_driver->precision;
										}
									}

									$tipo_campo = $valores_campos[$chave_campo]["tipodado"];


									$tamanho = strtolower(trim((isset($valores_campos[$chave_campo]["tamanho"])?$valores_campos[$chave_campo]["tamanho"]:"")));
									$precisao = strtolower(trim((isset($valores_campos[$chave_campo]["precisao"])?$valores_campos[$chave_campo]["precisao"]:"")));
									$chaveprimaria = strtolower(trim((isset($valores_campos[$chave_campo]["chaveprimaria"])?$valores_campos[$chave_campo]["chaveprimaria"]:"0")));
									$unico = strtolower(trim((isset($valores_campos[$chave_campo]["unico"])?$valores_campos[$chave_campo]["unico"]:"0")));
									$permitenulo = strtolower(trim((isset($valores_campos[$chave_campo]["permitenulo"])?$valores_campos[$chave_campo]["permitenulo"]:"1")));
									$valorpadrao = strtolower(trim((isset($valores_campos[$chave_campo]["valorpadrao"])?$valores_campos[$chave_campo]["valorpadrao"]:"")));
									$chaveestrangeira = strtolower(trim((isset($valores_campos[$chave_campo]["chaveestrangeira"])?$valores_campos[$chave_campo]["chaveestrangeira"]:"")));
									$constraintcheck = strtolower(trim((isset($valores_campos[$chave_campo]["constraintcheck"])?$valores_campos[$chave_campo]["constraintcheck"]:"")));

									if (in_array($tipo_campo,VariaveisSql::getInstancia()::$dados_conexoes->{$opcoes["atualizacao"]["nome_conexao"][0]}->driver->types->varchar->synonyms)) {
										if (strlen($tamanho) === 0) {
											$tamanho = 1;
										}
										$tipo_campo .= "(".$tamanho.")";
									} else if (in_array($tipo_campo,VariaveisSql::getInstancia()::$dados_conexoes->{$opcoes["atualizacao"]["nome_conexao"][0]}->driver->types->numeric->synonyms)) {
										if (strlen($tamanho) > 0) {
											$tipo_campo.="(".$tamanho;
											if (strlen($precisao) > 0) {
												$tipo_campo.=",".$precisao;
											}
											$tipo_campo.=")";
										}
									}
									if ($chaveprimaria == 1) {
										$chaveprimaria = "primary key";
										$unico = "";
									} else {
										$chaveprimaria = "";
										if ($unico == 1) {
											$unico = "unique";
										} else {
											$unico = "";
										}
									}									
									if ($permitenulo == 0) {
										$permitenulo = "not null";
									} else {
										$permitenulo = "";
									}
									if (strlen($valorpadrao) > 0) {								
										$valorpadrao = "default " . $valorpadrao;										
									}	
									if (strlen($constraintcheck) > 0) {
										$constraintcheck = " " . $constraintcheck . " ";
									}														
									if (strlen($chaveestrangeira) > 0) {
										$chaveestrangeira = " references " . $chaveestrangeira;
									}															
									$texto_campos[] = $nome_campodb." ".$tipo_campo." ".$valorpadrao." ".$chaveprimaria . " " . $unico." ".$permitenulo . " " . $constraintcheck . " " . $chaveestrangeira;
							}
							$valores_tab["preexistente"] = $valores_tab["preexistente"] ?? "1";
							/*
								Previne de acessar tabelas da pc erroneamente marcadas no cataloco como nao preexistente
							*/
							if ($valores_tab["allow_ddl"] == 1 
								&& stripos(trim($valores_tab["nometabeladb"]),"pc") !== 0 
								&& FuncoesConversao::como_numero($valores_tab["codusuariodb"]) != 0
								&& strcasecmp(trim($valores_tab["nomeschemadb"]),"jumbo") != 0) {
								if (in_array(strtolower(trim($valores_tab["preexistente"])),["nao","não","n","false","0"])) {
									if ($valores_tab["allow_drop"] == 1 && FuncoesSql::getInstancia()->tabela_existe($valores_tab["nometabeladb"],true)) {
										$comando_sql[$cont_comandos]["comandos"][]="drop table " . $valores_tab["nomeschemadb"] . "." . $valores_tab["nometabeladb"];
									} 
									if ($valores_tab["allow_create"] == 1) {
										$comando_sql[$cont_comandos]["comandos"][]="create table " . $valores_tab["nomeschemadb"] . "." . $valores_tab["nometabeladb"]."(".implode(",",$texto_campos).")";
									}
								} else {
									if (!FuncoesSql::getInstancia()->tabela_existe($valores_tab["nometabeladb"],true)) {							
										/*
											mesmo a tabela sendo marcada como preexistente no catalogo mas nao existir na base, ela sera criada
										*/
										if ($valores_tab["allow_create"] == 1) {
											$comando_sql[$cont_comandos]["comandos"][]="create table " . $valores_tab["nomeschemadb"] . "." . $valores_tab["nometabeladb"]."(".implode(",",$texto_campos).")";
										}
									} else {
										$campos_existentes = FuncoesSql::getInstancia()->obter_campos_tabela($valores_tab["nometabeladb"],null,"dados");
									}
								}
							} 
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair("campos da tabela ".$opcoes["atualizacao"]["objeto"][$cont]." nao localizados", __FILE__,__FUNCTION__,__LINE__);
						}
					} else {
					}		
					$cont_comandos++;
				}
			}
			return $comando_sql;
		}
		public static function dados_campo_como_sql($campo) {
			$campo = FuncoesArray::chaves_minusculas($campo);
			$dados_campo_como_sql = [];
			if (isset($campo["column_name"])) {
				/*
					origem das informacoes do campo eh diretamente do banco de dados (all_tab_columns)
				*/
				$dados_campo_como_sql["nomecampodb"] = strtolower(trim((isset($campo["column_name"])?$campo["column_name"]:"novocampo")));
				$dados_campo_como_sql["tipodado"] = strtolower(trim((isset($campo["data_type"])?$campo["data_type"]:"varchar2")));
				$dados_campo_como_sql["tamanho"] = strtolower(trim((isset($campo["data_length"])?$campo["data_length"]:"")));
				$dados_campo_como_sql["precisao"] = strtolower(trim((isset($campo["data_precision"])?$campo["data_precision"]:"")));
				if (strcasecmp(trim($dados_campo_como_sql["tipodado"]),"number") == 0) {
					$dados_campo_como_sql["tamanho"] = strtolower(trim((isset($campo["data_precision"])?$campo["data_precision"]:"")));
					$dados_campo_como_sql["precisao"] = strtolower(trim((isset($campo["data_scale"])?$campo["data_scale"]:"")));		
				}
				$dados_campo_como_sql["chaveprimaria"] = strtolower(trim((isset($campo["constraint_type"])?$campo["constraint_type"]:"0")));
				$dados_campo_como_sql["unico"] = strtolower(trim((isset($campo["constraint_type"])?$campo["constraint_type"]:"0")));
				$dados_campo_como_sql["permitenulo"] = strtolower(trim((isset($campo["nullable"])?$campo["nullable"]:"1")));
				$dados_campo_como_sql["valorpadrao"] = strtolower(trim((isset($campo["data_default"])?$campo["data_default"]:"")));				
				if (in_array(strtolower(trim($dados_campo_como_sql["chaveprimaria"])),["p"])) {
					$dados_campo_como_sql["chaveprimaria"] = str_ireplace(["p"],["1"],$dados_campo_como_sql["chaveprimaria"]);
					$dados_campo_como_sql["unico"] = "0";
				}		
				if (in_array(strtolower(trim($dados_campo_como_sql["unico"])),["u"])) {
					$dados_campo_como_sql["unico"] = str_ireplace(["u"],["1"],$dados_campo_como_sql["unico"]);
					$dados_campo_como_sql["chaveprimaria"] = "0";
				}		
				if (in_array(strtolower(trim($dados_campo_como_sql["permitenulo"])),["y","n"])) {
					$dados_campo_como_sql["permitenulo"] = str_ireplace(["y","n"],["1","0"],$dados_campo_como_sql["permitenulo"]);
				}
				$dados_campo_como_sql["constraintcheck"] = $campo["constraintcheck"] ?? "";
			} else {
				/*
					origem das informacoes do campo eh dos catalogos ou consulta a campodb
				*/
				$dados_campo_como_sql["nomecampodb"] = strtolower(trim($campo["nomecampodb"] ?? "novocampo"));
				$dados_campo_como_sql["tipodado"] = strtolower(trim($campo["tipodado"] ?? "varchar2"));
				$dados_campo_como_sql["tamanho"] = strtolower(trim($campo["tamanho"]  ??  ""));
				$dados_campo_como_sql["precisao"] = strtolower(trim($campo["precisao"] ?? ""));
				$dados_campo_como_sql["chaveprimaria"] = strtolower(trim($campo["chaveprimaria"] ?? "0"));
				$dados_campo_como_sql["unico"] = strtolower(trim($campo["unico"] ?? "0"));
				$dados_campo_como_sql["permitenulo"] = strtolower(trim($campo["permitenulo"] ?? "1"));
				$dados_campo_como_sql["valorpadrao"] = strtolower(trim($campo["valorpadrao"] ?? ""));	
				$dados_campo_como_sql["chaveestrangeira"] = strtolower(trim($campo["chaveestrangeira"] ?? ""));		
				$dados_campo_como_sql["constraintcheck"] = strtolower(trim($campo["constraintcheck"] ?? ""));		
			}
			if (FuncoesString::str_contem($dados_campo_como_sql["tipodado"],Constantes::sinonimos["varchar2"]) !== false) {
				$dados_campo_como_sql["tipodado"] = "varchar2";
				if (strlen($dados_campo_como_sql["tamanho"]) === 0) {
					$dados_campo_como_sql["tamanho"] = 1;
				}
			} else if (in_array(strtolower(trim($dados_campo_como_sql["tipodado"])),Constantes::sinonimos["number"]) !== false) {
				$dados_campo_como_sql["tipodado"] = "number";
			} else if (in_array(strtolower(trim($dados_campo_como_sql["tipodado"])),Constantes::sinonimos["date"]) !== false) {
				$dados_campo_como_sql["tipodado"] = "date";
			} 
			if (strlen(trim($dados_campo_como_sql["valorpadrao"])) > 0) {		
				$dados_campo_como_sql["valorpadrao"] = "default ".$dados_campo_como_sql["valorpadrao"];				
			}	
			
			if ($dados_campo_como_sql["chaveprimaria"] == 1) {
				$dados_campo_como_sql["chaveprimaria"] = "primary key";
				$dados_campo_como_sql["unico"] = "";
			} else {
				$dados_campo_como_sql["chaveprimaria"] = "";
				if ($dados_campo_como_sql["unico"] == 1) {
					$dados_campo_como_sql["unico"] = "unique";
				} else {
					$dados_campo_como_sql["unico"] = "";
				}
			}
			
			
			if ($dados_campo_como_sql["permitenulo"] == 0) {
				$dados_campo_como_sql["permitenulo"] = "not null";
			} else {
				$dados_campo_como_sql["permitenulo"] = "";
			}
			if (isset($dados_campo_como_sql["chaveestrangeira"]) && strlen(trim($dados_campo_como_sql["chaveestrangeira"])) > 0) {
				$dados_campo_como_sql["chaveestrangeira"] = " references " . $dados_campo_como_sql["chaveestrangeira"] . " ";
			}
			if (strlen(trim($dados_campo_como_sql["precisao"])) === 0) {
				$dados_campo_como_sql["precisao"] = "0";
			}
			if (strcasecmp(trim($dados_campo_como_sql["tipodado"]),"date") == 0) {
				$dados_campo_como_sql["tamanho"] = "";
				$dados_campo_como_sql["precisao"] = "";
			}
			return $dados_campo_como_sql; 
		}
		public static function montar_expressao_campo_sql($dados_campo,$opcoes) {
			$expressao_campo_sql = "";
			$expressao_campo_sql = $dados_campo["nomecampodb"] . " ";

			$nome_conexao = $opcoes["atualizacao"]["nome_conexao"][0];
			$types_driver = VariaveisSql::getInstancia()::$dados_conexoes->{$nome_conexao}->driver->types;
			$tipo_dado_driver = FuncoesSql::getInstancia()->tipo_como_tipo_driver($types_driver,$dados_campo["tipodado"]);
			if (isset($tipo_dado_driver) && $tipo_dado_driver !== null) {
				$dados_campo["tipodado"] = $tipo_dado_driver->name;
				if (property_exists($tipo_dado_driver,"constraintcheck")) {
					$dados_campo["constraintcheck"] = $dados_campo["constraintcheck"] ?? "";
					if (FuncoesString::strTemValor($dados_campo["constraintcheck"])) {
						$dados_campo["constraintcheck"] .= " and (".$tipo_dado_driver->constraintcheck.") ";
					} else {
						$dados_campo["constraintcheck"] = str_ireplace("__CAMPO__",$dados_campo["nomecampodb"],$tipo_dado_driver->constraintcheck);
					}
				}
				if (property_exists($tipo_dado_driver,"datasize")) {
					$dados_campo["tamanho"] = $tipo_dado_driver->datasize;
				}
				if (property_exists($tipo_dado_driver,"precision")) {
					$dados_campo["precisao"] = $tipo_dado_driver->precision;
				}
			}

			$expressao_campo_sql .= $dados_campo["tipodado"];

			if (in_array($dados_campo["tipodado"],$types_driver->varchar->synonyms)) {
				if (strlen($dados_campo["tamanho"]) === 0) {
					$dados_campo["tamanho"] = 1;
				}				
			} 
			if (strlen(trim($dados_campo["tamanho"])) > 0) {
				$expressao_campo_sql .= "(";
				$expressao_campo_sql .= $dados_campo["tamanho"];				
				if (in_array($dados_campo["tipodado"],$types_driver->numeric->synonyms)) {
					if (strlen(trim($dados_campo["precisao"])) > 0) {
						$expressao_campo_sql .= ",";
						$expressao_campo_sql .= $dados_campo["precisao"];
					}
				}
				$expressao_campo_sql .= ")";
			}
			$expressao_campo_sql .= " ";
			if (strlen(trim($dados_campo["valorpadrao"])) > 0) {
				$expressao_campo_sql .= $dados_campo["valorpadrao"] . " ";
			}
			if (strlen(trim($dados_campo["chaveprimaria"])) > 0) {
				$expressao_campo_sql .= $dados_campo["chaveprimaria"] . " ";
			}	
			if (strlen(trim($dados_campo["unico"])) > 0) {
				$expressao_campo_sql .= $dados_campo["unico"] . " ";
			}	
			if (strlen(trim($dados_campo["permitenulo"])) > 0) {
				$expressao_campo_sql .= $dados_campo["permitenulo"] . " ";
			}	
			if (FuncoesString::strTemValor($dados_campo["constraintcheck"])) {
				$expressao_campo_sql .= " " . $dados_campo["constraintcheck"] . " " ;
			}
			if (strlen(trim($dados_campo["chaveestrangeira"])) > 0) {
				$expressao_campo_sql .= $dados_campo["chaveestrangeira"] . " ";
			}			
			$expressao_campo_sql = str_ireplace("__CAMPO__",$dados_campo["nomecampodb"],$expressao_campo_sql);
			return $expressao_campo_sql;
		}
		public static function montar_comando_sql_tabela_criar_tabelas_campos(&$comhttp,&$opcoes) {
			try {
				$comando_sql = null;
				$cursor_tabelas = null;
				$cursor_campos = null;				
				if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb") && FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "campodb")) {
					$nome_conexao = $opcoes["atualizacao"]["nome_conexao"][0] ?? VariaveisSql::getInstancia()->getNomeConexaoPadrao();
					$comando_sql2 = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb where lower(trim(nome_conexao)) = lower(trim('".$nome_conexao."')) and trim(lower(nometabeladb)) not in (lower('".VariaveisSql::getInstancia()->getPrefixObjects()."atualizacoesdb'),lower('".VariaveisSql::getInstancia()->getPrefixObjects()."situacoesregistro'),lower('".VariaveisSql::getInstancia()->getPrefixObjects()."tabeladb'),lower('".VariaveisSql::getInstancia()->getPrefixObjects()."campodb')) ";
					if (!in_array(strtolower(trim($opcoes["atualizacao"]["objeto"][0])),Constantes::sinonimos["todos"])) {
						$comando_sql2 .= " and trim(lower(nometabeladb)) in ('" . implode("','",$opcoes["atualizacao"]["objeto"]) . "')";
					}
					$comando_sql2 .= " order by ordemcriacao,codtabeladb";
					$tabelas = FuncoesSql::getInstancia()->executar_sql($comando_sql2,"fetchAll",\PDO::FETCH_ASSOC);
					if (count($tabelas) > 0) {
						$comando_sql[0] = [];
						$comando_sql[0]["comandos"] = [];
						foreach($tabelas as $chave_tab => $tabela) {
							$comando_sql2 = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb where codtabeladb = " . $tabela["codtabeladb"] . " order by nvl(ordemcriacao,codcampodb)";
							$tabelas[$chave_tab]["campos"] = FuncoesSql::getInstancia()->executar_sql($comando_sql2,"fetchAll",\PDO::FETCH_ASSOC);							
						}
						foreach($tabelas as $chave_tab => $tabela) {
							$nometab = $tabela["nometabeladb"];
							if (count($tabela["campos"]) > 0) {
								$contcmp = 0;
								$texto_campos = [];
								foreach($tabela["campos"] as $chave_campo => $campo) {											
									$dados_campo_como_sql = self::dados_campo_como_sql($campo);
									$texto_campos[] = self::montar_expressao_campo_sql($dados_campo_como_sql,$opcoes);
								}
								/*previne de excluir/recriar tabelas da pc erroneamente catalogadas como nao preexistentes*/
								if ($tabela["allow_ddl"] == 1 
									&& VariaveisSql::getInstancia()->getAllowDDLConn($nome_conexao) 
									&& stripos(trim($tabela["nometabeladb"]),"pc") !== 0
									&& strcasecmp(trim($tabela["nomeschemadb"]),"jumbo") != 0
									&& $tabela["codusuariodb"] != 0) {
									if (in_array(strtolower(trim($tabela["preexistente"])),["nao","não","n","false","0"])) {
										if ($tabela["allow_drop"] == 1 && FuncoesSql::getInstancia()->tabela_existe($tabela["nometabeladb"],true)) {
											$comando_sql[0]["comandos"][]="drop table " . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"];
										} 
										if ($tabela["allow_create"] == 1) {
											$comando_sql[0]["comandos"][]="create table " . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "(".implode(",",$texto_campos).")";
											$comando_sql[0]["comandos"][]="update " . VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb set dtcriacao=current_date where codtabeladb = ". $tabela["codtabeladb"];
											$comando_sql[0]["comandos"][]="update " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb set dtcriacao=current_date where codtabeladb = ". $tabela["codtabeladb"];
											$comando_sql[0]["comandos"][]="commit";
											if (isset($tabela["comandos_posteriores"]) && $tabela["comandos_posteriores"] !== null && strlen(trim($tabela["comandos_posteriores"])) > 0) {
												$tabela["comandos_posteriores"] = explode(";",$tabela["comandos_posteriores"]);
												foreach($tabela["comandos_posteriores"] as $comando_posterior) {
													$comando_sql[0]["comandos"][] = $comando_posterior;
												}
											}
										}
									} else {
										if ($tabela["allow_create"] == 1 && !FuncoesSql::getInstancia()->tabela_existe($tabela["nometabeladb"],true)) {
											/*mesmo a tabela sendo marcada como preexistente no catalogo mas nao existir na base, ela sera criada*/							
											$comando_sql[0]["comandos"][]="create table " . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "(".implode(",",$texto_campos).")";
											$comando_sql[0]["comandos"][]="update " . VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb set dtcriacao=current_date where codtabeladb = ". $tabela["codtabeladb"];
											$comando_sql[0]["comandos"][]="update " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb set dtcriacao=current_date where codtabeladb = ". $tabela["codtabeladb"];
											$comando_sql[0]["comandos"][]="commit";
											if (isset($tabela["comandos_posteriores"]) && $tabela["comandos_posteriores"] !== null && strlen(trim($tabela["comandos_posteriores"])) > 0) {
												$tabela["comandos_posteriores"] = explode(";",$tabela["comandos_posteriores"]);
												foreach($tabela["comandos_posteriores"] as $comando_posterior) {
													$comando_sql[0]["comandos"][] = $comando_posterior;
												}
											}
										} else if ($tabela["allow_alter"] == 1) {
											/*se a tabela for marcada como preexistente e ja existir, checa se os campos estao conforme o catalogo ou atualiza-a*/
											
											$campos_existentes = FuncoesSql::getInstancia()->obter_campos_tabela($tabela["nometabeladb"],null,"banco",$tabela["nomeschemadb"]);
											if (count($campos_existentes) > 0) {
												$houve_alteracao = false;
												$campos_insert = [];
												$types_driver = VariaveisSql::getInstancia()::$dados_conexoes->{$nome_conexao}->driver->types ?? [];
												foreach ($campos_existentes as &$campo_existente) {
													$campos_insert[] = $campo_existente["column_name"];
													$campo_existente["encontrado"] = false;
													foreach ($tabela["campos"] as &$campo_tab) {
														if (!isset($campo_tab["encontrado"])) {
															$campo_tab["encontrado"] = false;
														}
														/*altera o campo se as caracteristicas nao forem iguais do catalogo*/
														if (strcasecmp(trim($campo_existente["column_name"]),trim($campo_tab["nomecampodb"])) == 0) {
															$campo_existente["encontrado"] = true;
															$campo_tab["encontrado"] = true;
															$dados_campo_existente = self::dados_campo_como_sql($campo_existente);
															$dados_campo_tab = self::dados_campo_como_sql($campo_tab);
															foreach ($dados_campo_existente as $chave => $valor) {
																if (
																	(
																		strcasecmp($chave,"tipodado") == 0 
																		&& strcasecmp(
																			FuncoesSql::getInstancia()->tipo_como_tipo_driver($types_driver,trim($dados_campo_tab[$chave])),
																			FuncoesSql::getInstancia()->tipo_como_tipo_driver($types_driver,trim($valor))
																		) != 0
																	) || (
																		strcasecmp($chave,"permitenulo") == 0 
																		&& (
																			(intval($dados_campo_tab[$chave]) == 0 && strcasecmp(trim($valor),"not null") != 0)
																			|| (intval($dados_campo_tab[$chave]) == 1 && strcasecmp(trim($valor),"not null") == 0)
																		)
																	)	
																	|| (
																		in_array(strtolower(trim($chave)),["precisao","tamanho"])
																		&& intval($dados_campo_tab[$chave]??'0') != intval($valor??'0')
																	)
																	|| (
																		!in_array(strtolower(trim($chave)),["tipodado","precisao","tamanho","permitenulo"])
																		&& strcasecmp(trim($dados_campo_tab[$chave]),trim($valor)) != 0 
																	) 
																) {
																	echo "verifique se essa alteração procede antes de comentar estas linhas...";
																	print_r($tabela);
																	echo $chave." | " ;
																	echo "tab=".$dados_campo_tab[$chave] . " | valor=" . $valor . " | ";
																	echo "intvaltab=" . intval($dados_campo_tab[$chave]??'0') ." | intvalvalor=" . intval($valor??'0');exit();
																	echo $chave . " " . $dados_campo_tab[$chave] . " " . $valor; exit();
																	if ($houve_alteracao === false) {
																		/*cria uma tabela temporaria em branco, espelho da original*/
																		$comando_sql[0]["comandos"][]= "create table " . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . " _ as select * from " . $tabela["nometabeladb"] . " where 1=2";
																	}
																	$expressao_campo_sql = self::montar_expressao_campo_sql($dados_campo_tab,$opcoes);
																	if (strcasecmp(trim($dados_campo_existente["chaveprimaria"]),trim($dados_campo_tab["chaveprimaria"])) == 0) {
																		$expressao_campo_sql = str_ireplace(trim($dados_campo_tab["chaveprimaria"]), "", trim($expressao_campo_sql));
																	}
																	if (strcasecmp(trim($dados_campo_existente["unico"]),trim($dados_campo_tab["unico"])) == 0) {
																		$expressao_campo_sql = str_ireplace(trim($dados_campo_tab["unico"]), "", trim($expressao_campo_sql));
																	}
																	if (strcasecmp(trim($dados_campo_existente["permitenulo"]),trim($dados_campo_tab["permitenulo"])) == 0) {
																		$expressao_campo_sql = str_ireplace(trim($dados_campo_tab["permitenulo"]), "", trim($expressao_campo_sql));
																	}
																	if (stripos(trim($dados_campo_tab["tipodado"]),"lob") !== false) {
																		/*se for lob, cria um temporario, exclui original, depois renomeia o teporario */
																		$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ add " . str_ireplace($dados_campo_tab["nomecampodb"],$dados_campo_tab["nomecampodb"] . "_" , $expressao_campo_sql);
																		$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ drop column " . $dados_campo_tab["nomecampodb"];
																		$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ rename column " . $dados_campo_tab["nomecampodb"] . "_ to " . $dados_campo_tab["nomecampodb"];
																	} else {
																		$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ modify " . $expressao_campo_sql;
																	}
																	$comando_sql[0]["comandos"][]= "update " . VariaveisSql::getInstancia()->getPrefixObjects() . "tabeladb set dtalteracao=current_date where codtabeladb = ". $campo_tab["codtabeladb"];
																	$comando_sql[0]["comandos"][]= "update " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb set dtalteracao=current_date where codcampodb = ". $campo_tab["codcampodb"];
																	print_r($comando_sql); exit();
																	$houve_alteracao = true;
																	break;
																}
															}
														}
													}
												}
												foreach ($tabela["campos"] as &$campo_tab) {
													/*insere o campo se nao encontrado na tabela*/
													if ($campo_tab["encontrado"] === false) {
														$dados_campo_tab = self::dados_campo_como_sql($campo_tab);
														$expressao_campo_sql = self::montar_expressao_campo_sql($dados_campo_tab,$opcoes);
														if ($houve_alteracao === false) {
															$comando_sql[0]["comandos"][]= "create table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ as select * from "   . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . " where 1=2";
														}	
														$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ add " .  $expressao_campo_sql;
														$comando_sql[0]["comandos"][]= "update " . VariaveisSql::getInstancia()->getPrefixObjects() . "campodb set dtcriacao=current_date where codcampodb = ". $campo_tab["codcampodb"];
														print_r($comando_sql); exit();
														$houve_alteracao = true;
													}											
												}										
												if ($houve_alteracao === true) {
													$comando_sql[0]["comandos"][]= "insert into "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_(" . implode(",",$campos_insert) . ") (select " . implode(",",$campos_insert) . " from "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . ")";
													$comando_sql[0]["comandos"][]= "commit";
													$comando_sql[0]["comandos"][]= "drop table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"];
													$comando_sql[0]["comandos"][]= "alter table "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"] . "_ rename to "  . $tabela["nomeschemadb"] . "." . $tabela["nometabeladb"];
													if (isset($tabela["comandos_posteriores"]) && $tabela["comandos_posteriores"] !== null && strlen(trim($tabela["comandos_posteriores"])) > 0) {
														$tabela["comandos_posteriores"] = explode(";",$tabela["comandos_posteriores"]);
														foreach($tabela["comandos_posteriores"] as $comando_posterior) {
															$comando_sql[0]["comandos"][] = $comando_posterior;
															print_r($comando_sql); exit();
														}
													}
												}										
											}
										}
									}	
								} else {
									trigger_error("Esta tabela nao permite criacao (allow_ddl = false): " . $tabela["nomeschemadb"] . "." .  $tabela["nometabeladb"] . " " . $tabela["codusuariodb"],E_USER_ERROR);
								}
							}
						}
					} 
				}	
				return $comando_sql;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e); exit();
				return null;
			} 
		}
		public static function montar_comando_sql_criar_tabelas_campos(&$comhttp,&$opcoes) {	
			$comando_sql = self::montar_comando_sql_tabela_criar_tabelas_campos($comhttp,$opcoes);	
			if (!($comando_sql !== null && count($comando_sql) > 0)) {
				$comando_sql = self::montar_comando_sql_arquivo_criar_catalogo_tabelas_campos($comhttp,$opcoes);
			}
			return $comando_sql;
		}
		public static function preparar_comando_sql_inserir_padrao(&$opcoes,&$campo_unique1, $nome_tabela, $obj_dados_json_registro, &$arr_dados_temp, &$excluir_todos) {
			$retorno = [];
			if (isset($arr_dados_temp["dados_tabelas"][$nome_tabela])) {
				$retorno["campos"] = $arr_dados_temp["dados_tabelas"][$nome_tabela]["campos"];
				$retorno["camposclob"] = $arr_dados_temp["dados_tabelas"][$nome_tabela]["camposclob"];
				$retorno["camposprimary_key"] = $arr_dados_temp["dados_tabelas"][$nome_tabela]["camposprimary_key"];
				$retorno["camposunique"] = $arr_dados_temp["dados_tabelas"][$nome_tabela]["camposunique"];
				$retorno["camposbit"] = $arr_dados_temp["dados_tabelas"][$nome_tabela]["camposbit"];
			} else {		
				$retorno["campos"] = FuncoesSql::getInstancia()->obter_campos_tabela($nome_tabela);
				$retorno["campos"] = FuncoesArray::arr_str_minusc($retorno["campos"]);
				if ($retorno["campos"] === null || count($retorno["campos"]) === 0) {
					trigger_error("tabela $nome_tabela sem campos",E_USER_ERROR);
				}
				$retorno["camposclob"] = FuncoesSql::getInstancia()->obter_campos_tabela($nome_tabela,"clob") ?? [];
				$retorno["camposclob"] = FuncoesArray::arr_str_minusc($retorno["camposclob"]);
				$retorno["camposunique"] = FuncoesSql::getInstancia()->obter_campos_tabela($nome_tabela,"unique") ?? [];
				$retorno["camposunique"] = FuncoesArray::arr_str_minusc($retorno["camposunique"]);
				$retorno["camposprimary_key"] = FuncoesSql::getInstancia()->obter_campos_tabela($nome_tabela,"primary key") ?? [];
				$retorno["camposprimary_key"] = FuncoesArray::arr_str_minusc($retorno["camposprimary_key"]);
				$retorno["camposbit"] = FuncoesSql::getInstancia()->obter_campos_tabela($nome_tabela,"bit") ?? [];
				$retorno["camposbit"] = FuncoesArray::arr_str_minusc($retorno["camposbit"]);
				
				$arr_dados_temp["dados_tabelas"][$nome_tabela]["campos"] = $retorno["campos"];
				$arr_dados_temp["dados_tabelas"][$nome_tabela]["camposclob"] = $retorno["camposclob"];
				$arr_dados_temp["dados_tabelas"][$nome_tabela]["camposunique"] = $retorno["camposunique"];		
				$arr_dados_temp["dados_tabelas"][$nome_tabela]["camposprimary_key"] = $retorno["camposprimary_key"];		
				$arr_dados_temp["dados_tabelas"][$nome_tabela]["camposbit"] = $retorno["camposbit"];		
			}
			$retorno["valores"] = [];
			$retorno["camposbind"] = [];
			$retorno["valoresbind"] = [];			
			foreach ($retorno["campos"] as $chave_campo => $nome_campo) {
				if (property_exists($obj_dados_json_registro,$chave_campo)) {
					if ($retorno["camposclob"] !== null && in_array($chave_campo,$retorno["camposclob"])) {
						$retorno["valores"][$chave_campo] = $obj_dados_json_registro->{$chave_campo};
					} else {
						if ($retorno["camposbit"] !== null && in_array($chave_campo,$retorno["camposbit"])) {
							$retorno["valores"][$chave_campo] = $obj_dados_json_registro->{$chave_campo}; //campo bit nao pode ter aspas (mysql)
						} else {
							if (strcasecmp(trim($obj_dados_json_registro->{$chave_campo}),"null") == 0) {
								$retorno["valores"][$chave_campo] = $obj_dados_json_registro->{$chave_campo};
							} else {
								$retorno["valores"][$chave_campo] = "'".FuncoesString::aumentar_nivel_aspas_simples($obj_dados_json_registro->{$chave_campo})."'";
							}
						}
					}
				} else {
					/*se o campo for unique e nao estiver presente nos valores, gera um valor para o campo*/
					if (in_array(strtolower(trim($chave_campo)),explode(",",strtolower(trim(implode(",",$retorno["camposunique"])))))) {
						if ($campo_unique1  === null) {
							$campo_unique1 = $chave_campo;
						}
						$retorno["valores"][$chave_campo] = "coalesce((select nextval from (select max(coalesce(".$chave_campo.",0))+1 as nextval from ".$nome_tabela.") subnextval),0)";
					} elseif (in_array(strtolower(trim($chave_campo)),explode(",",strtolower(trim(implode(",",$retorno["camposprimary_key"])))))) {
						if ($campo_unique1  === null) {
							$campo_unique1 = $chave_campo;
						}
						$retorno["valores"][$chave_campo] = "coalesce((select nextval from (select max(coalesce(".$chave_campo.",0))+1 as nextval from ".$nome_tabela.") subnextval),0)";
					} 
				}
				if (isset($retorno["valores"][$chave_campo])) {
					$retorno["valores"][$chave_campo] = FuncoesVariaveis::como_texto_ou_funcao([
						"texto" => $retorno["valores"][$chave_campo],
						"funcoes_considerar"=>["__FNV_GET_NOMESCHEMA__","__FNV_GET_NOMESCHEMAERP__","__FNV_GET_PREFIXOBJECTSDB__","__FNV_GET_NOMESCHEMAERP__","__FNV_GET_NAMECONNECTIONDEFAULT__","__FNV_GET_NAMECONNECTIONERP__","__FNV_OBTER_FUNCAO_SQL__"]
					]);
				}
			}
			if (stripos(trim($nome_tabela),"elementosopcoessistema") !== false) {
				$retorno["valores"]["camposdata"] = [];
				$retorno["valores"]["demaiscampos"] = [];
				foreach($obj_dados_json_registro as $chave => $valor) {
					if (!in_array(gettype($valor),["object","array"])) {
						if (!in_array($chave,$retorno["campos"])) {
							if (stripos($chave,"data-") !==false) {
								$retorno["valores"]["camposdata"][] = $chave . "=" . $valor;
							} else {
								$retorno["valores"]["demaiscampos"][] = $chave . "=" . $valor;
							}
						}
					}
				}
				if (count($retorno["valores"]["camposdata"]) > 0) {
					$retorno["valores"]["camposdata"] = "'" . FuncoesString::aumentar_nivel_aspas_simples(implode(Constantes::sepn1,$retorno["valores"]["camposdata"])) . "'";
				} else {
					unset($retorno["valores"]["camposdata"]);
				}
				if (count($retorno["valores"]["demaiscampos"]) > 0) {
					$retorno["valores"]["demaiscampos"] = "'" . FuncoesString::aumentar_nivel_aspas_simples(implode(Constantes::sepn1,$retorno["valores"]["demaiscampos"])) . "'";
				} else {
					unset($retorno["valores"]["demaiscampos"]);
				}
			}
			if (isset($retorno["valores"]) && $retorno["valores"] !== null && count($retorno["valores"]) > 0) {
				if ($excluir_todos === false && $campo_unique1 !== null) {
					$retorno["comandos"][] =  " delete from ". $nome_tabela . " where " . $campo_unique1 . " = " . $retorno["valores"][$campo_unique1];
				}
				if ($retorno["camposclob"] !== null && gettype($retorno["camposclob"]) === "array" && count($retorno["camposclob"]) > 0 ) {
					foreach($retorno["camposclob"] as $chave_campo_clob => $nome_campo_clob) {
						if (isset($retorno["valores"][$chave_campo_clob])) {
							$parametro_type = null;
							$dados_conexao = VariaveisSql::getInstancia()::$dados_conexoes->{$opcoes["atualizacao"]["nome_conexao"][0]};
							$nome_driver = $dados_conexao->driver->name ?? $dados_conexao->driver ?? null;
							if ($nome_driver === "oracle") {
								$parametro_type = \PDO::PARAM_STR;
							} else {
								$parametro_type = \PDO::PARAM_LOB;
							}
							$retorno["camposbind"][$chave_campo_clob] = ["campo"=>":" . $chave_campo_clob,"parametros"=>$parametro_type];
							$retorno["valoresbind"][$chave_campo_clob] = $retorno["valores"][$chave_campo_clob];							
							$retorno["valores"][$chave_campo_clob] = ":" . $chave_campo_clob;
						}
					}					
				}
				/*se houverem slaches (\) na string, e forem simples, ou seja, nao forem ja duplados (\\) torna-os duplados (\\), pois ao inserir o db retira um */
				$retorno["comandos"][] = " insert into ". $nome_tabela . "(" . implode(",",array_keys($retorno["valores"])).") values (" . preg_replace('/([^\\\])(\\\)([^\\\])/','$1$2$2$3',implode(",",$retorno["valores"])) . ")";
			}
			return $retorno;
		}
		public static function preparar_comando_sql_inserir_padrao_com_sub(&$opcoes,&$campo_unique1, $nome_tabela, $obj_dados_json_registro, &$arr_dados_temp, &$excluir_todos) {
			$retorno = [];
			if (gettype($obj_dados_json_registro) === "array") {
				foreach($obj_dados_json_registro as $ind => $elemento) {
					FuncoesArray::acrescentar_elemento_array($retorno,self::preparar_comando_sql_inserir_padrao_com_sub($opcoes,$campo_unique1,$nome_tabela,$elemento, $arr_dados_temp, $excluir_todos));
				}
			} else {	
				$retorno[] = self::preparar_comando_sql_inserir_padrao($opcoes,$campo_unique1, $nome_tabela, $obj_dados_json_registro, $arr_dados_temp, $excluir_todos);	
				if (property_exists($obj_dados_json_registro,"sub")) {
					foreach($obj_dados_json_registro->sub as $chave_cat => $dados_cat_sub) {			
						FuncoesArray::acrescentar_elemento_array($retorno,self::preparar_comando_sql_inserir_padrao_com_sub($opcoes,$campo_unique1,$nome_tabela,$dados_cat_sub, $arr_dados_temp, $excluir_todos));
					}
				}	
			}
			return $retorno;
		}
		public static function montar_comando_sql_inserir_catalogo_padrao(&$comhttp,&$opcoes) {	
			$comando_sql = null;
			$cont = 0;
			$qt = count($opcoes["atualizacao"]["destino"]);
			$arr_dados_temp = [];
			$arr_dados_temp["dados_tabelas"] = [];
			if ($qt > 0) {
				$comando_sql = [];	
				$cont_comandos = 0;
				for($cont = 0; $cont < $qt; $cont++) {
					$tabela = $opcoes["atualizacao"]["destino"][$cont];
					$caminho_catalogo = self::obter_caminho_catalogo($opcoes["atualizacao"]["origem"][$cont]);
					if (!in_array(strtolower(trim($opcoes["atualizacao"]["objeto"][$cont])),Constantes::sinonimos["todos"])) {
						$dados_catalogo = [FuncoesArquivo::ler_arquivo_catalogo_json($caminho_catalogo,["filtro"=>$opcoes["atualizacao"]["objeto"][$cont],"traduzir_apos_filtro"=>false,"preparar_string_antes"=>true])];
					} else {
						$dados_catalogo = FuncoesArquivo::ler_arquivo_catalogo_json($caminho_catalogo);
					}			
					$campounique1 = null;
					$excluir_todos = false;
					if (in_array($opcoes["atualizacao"]["objeto"][$cont], Constantes::sinonimos["todos"])) {
						$excluir_todos = true;
						$cont_comandos = count($comando_sql);
						$comando_sql[$cont_comandos] = [];
						$comando_sql[$cont_comandos]["comandos"] = [];
						if (stripos(trim($tabela),"tabela") !== false) {
							$comando_sql[$cont_comandos]["comandos"][] = "delete from ". str_ireplace("tabela","campo",$tabela);
						}
						$comando_sql[$cont_comandos]["comandos"][] = "delete from ". $tabela;
					}
					/*coloca os valores do json em array associativo pelo indice do elemento json e chave do campo da tabela*/
					foreach ($dados_catalogo as $chave_dado_catalogo => &$dado_catalogo) {
						if (!in_array(strtolower(trim($chave_dado_catalogo)),["dados_cat","versao"])) {
							if (gettype($dado_catalogo) === "array") {
								foreach($dado_catalogo as $chave2 => &$dado_catalogo2) {
									FuncoesArray::acrescentar_elemento_array($comando_sql,self::preparar_comando_sql_inserir_padrao_com_sub($opcoes,$campounique1,$tabela,$dado_catalogo2, $arr_dados_temp, $excluir_todos));
								}
							} else {								
								if (property_exists($dado_catalogo,"sub")) {									
									if (stripos($opcoes["atualizacao"]["destino"][$cont],"campo") !== false) {
										foreach($dado_catalogo->sub as $ind_campo_cat => $campo_cat) {
											$comando_sql[] = self::preparar_comando_sql_inserir_padrao($opcoes,$campounique1,$tabela,$campo_cat, $arr_dados_temp, $excluir_todos);
										}
									} else {
										if (stripos($opcoes["atualizacao"]["destino"][$cont],"tabela") !== false) {
											$comando_sql[] = self::preparar_comando_sql_inserir_padrao($opcoes,$campounique1,$tabela,$dado_catalogo, $arr_dados_temp, $excluir_todos);
										} else {
											FuncoesArray::acrescentar_elemento_array($comando_sql,self::preparar_comando_sql_inserir_padrao_com_sub($opcoes,$campounique1,$tabela,$dado_catalogo, $arr_dados_temp, $excluir_todos));
										}
									}
								} else {									
									$comando_sql[] = self::preparar_comando_sql_inserir_padrao($opcoes,$campounique1,$tabela,$dado_catalogo, $arr_dados_temp, $excluir_todos);
								}
							}
						}
					}
				}
			}	
			return $comando_sql;
		}
		public static function preparar_registro_atualizacao(&$comhttp,$atualizacao) {
			if ($atualizacao !== null) {
				if (gettype($atualizacao) === "object") {
					$atualizacao = FuncoesConversao::json_para_array($atualizacao);			
				}
				foreach($atualizacao as $chave=>&$valor) {					
					if (gettype($valor) !== "array") {
						if (strpos($valor,"__") !== false) {
							$valor = FuncoesVariaveis::como_texto_ou_funcao([
								"texto" => FuncoesVariaveis::como_texto_ou_constante($valor),
								"funcoes_considerar"=>["__FNV_GET_NOMESCHEMA__","__FNV_GET_NOMESCHEMAERP__","__FNV_GET_PREFIXOBJECTSDB__","__FNV_GET_NOMESCHEMAERP__","__FNV_GET_NAMECONNECTIONDEFAULT__","__FNV_GET_NAMECONNECTIONERP__","__FNV_OBTER_FUNCAO_SQL__"]
							]);
						}
						if (strcasecmp(trim($chave),"comandos_posteriores") != 0) {
							$valor = explode(",",$valor);
						}
					}
					if ($chave === "objeto" && strpos(strtolower($atualizacao["nomeatualizacao"][0]),"especif") !== false) {
						foreach($valor as $chaveval => $valval) {
							if (strpos($valval,"especif") !== false) {
								$comhttp->requisicao->requisitar->qual->condicionantes["selecionados"] = $comhttp->requisicao->requisitar->qual->condicionantes["selecionados"] ?? "";
								$valor[$chaveval] = $comhttp->requisicao->requisitar->qual->condicionantes["selecionados"];
							}
						}
					}

				}
			}
			return $atualizacao;
		}
		public static function procurar_comando_sql_arquivo(&$comhttp,&$opcoes) {	
			$comando_sql = null;	
			/*encontra os dados no catalogo*/	
			$atualizacao = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_atualizacoes_db"), ["filtro"=>$opcoes["nomeatualizacao"],"traduzir_apos_filtro"=>false,"preparar_string_antes"=>false]);			
			//print_r($atualizacao);exit();
			$atualizacao = self::preparar_registro_atualizacao($comhttp,$atualizacao);
			/*monta o comando com base nas opcoes e no comando encontrado*/
			if ($atualizacao !== null) {
				$opcoes["atualizacao"] = $atualizacao;
				switch(strtolower(trim($opcoes["atualizacao"]["acao"][0]))) {
					case "create":
						switch (strtolower(trim($opcoes["atualizacao"]["tipoobjeto"][0]))) {
							case "table":
								$comando_sql = self::montar_comando_sql_arquivo_criar_catalogo_tabelas_campos($comhttp,$opcoes);
								break;
							case "type":
							case "function":
							case "package": 
							case "trigger":
							case "procedure":
								$comando_sql = self::montar_comando_sql_criar_objetos_sql_padrao($comhttp,$opcoes);				
								break;
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("tipo_objeto ".$opcoes["atualizacao"]["tipoobjeto"][0]." nao implantado", __FILE__,__FUNCTION__,__LINE__);
								break;
						}
						break;
					case "insert":
						$comando_sql = self::montar_comando_sql_inserir_catalogo_padrao($comhttp,$opcoes);
						break;
					case "executar_limpar":			
						$comando_sql_temp = null;								
						$comando_sql_temp = FuncoesArquivo::ler_arquivo_catalogo_json(self::obter_caminho_catalogo($opcoes["atualizacao"]["origem"][0]), ["filtro"=>$opcoes["nomeatualizacao"],"traduzir_apos_filtro"=>true,"preparar_string_antes"=>true]);	
						$comando_sql[0] = [];
						$comando_sql[0]["comandos"] = [];
						$comando_sql[0]["camposclob"] = [];
						if ($comando_sql_temp !== null) {
							if (property_exists($comando_sql_temp,"corpo")) {
								$comando_sql[0]["comandos"][] = $comando_sql_temp->corpo;
							}
						}
						break;
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("comando ".$opcoes["nomeatualizacao"]." nao implantado", __FILE__,__FUNCTION__,__LINE__);
						break;
				}

				if (isset($opcoes["atualizacao"]["comandos_posteriores"]) && strlen(trim($opcoes["atualizacao"]["comandos_posteriores"])) > 0) {
					$comando_sql[] = [
						"comandos" => explode(";",$opcoes["atualizacao"]["comandos_posteriores"])
					];
				}
			}
			if ($comando_sql !== null && count($comando_sql) > 0) {
			} else {
				FuncoesBasicasRetorno::mostrar_msg_sair("texto nao localizado", __FILE__,__FUNCTION__,__LINE__);
			} 
			return $comando_sql;				
		}
		public static function procurar_comando_sql_tabela(&$comhttp,&$opcoes) {
			try {
				$comando_sql = null;
				$tabela = VariaveisSql::getInstancia()->getPrefixObjects() . "atualizacoesdb";
				$texto_comando = null;
				if (FuncoesSql::getInstancia()->tabela_existe($tabela,true)) {		
					$comando_sql = "	
						SELECT
							*
						FROM
							".VariaveisSql::getInstancia()->getPrefixObjects()."atualizacoesdb
						WHERE
							lower(trim('" . $opcoes["nomeatualizacao"] . "')) = lower(trim(nomeatualizacao))
							and lower(trim(tipoorigematualizacao)) = lower(trim('table'))
						";			
					$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);				
					if (count($dados) > 0) {
						$texto_comando = [];
						$texto_comando["comandos"] = [];
						$opcoes["codcomando"] = -1;
						foreach($dados as $lin) {			
							$opcoes["atualizacao"] = self::preparar_registro_atualizacao($comhttp,$lin);
							switch($opcoes["atualizacao"]["acao"][0]) {
								case "create":
									switch($opcoes["atualizacao"]["tipoobjeto"][0]) {							
										case "file":
											switch ($opcoes["atualizacao"]["objeto"][0]) {
												case "variaveisjavascript":
													self::criar_arquivo_variaveis_javascript();
													$texto_comando["comandos"][] = "commit;";								
													break;
												case "funcoesjavascript":
													self::criar_arquivo_funcoes_javascript();
													$texto_comando["comandos"][] = "commit;";								
													break;										
												case "variaveis_php_nfp":
													self::criar_arquivo_variaveis_php_nfp();
													$texto_comando["comandos"][] = "commit;";								
													break;
												case "all":
													switch (strtolower(trim($opcoes["atualizacao"]["origem"][0]))) {
														case "opcoessistema":
														case strtolower(trim(VariaveisSql::getInstancia()->getPrefixObjects()."opcoessistema")):
															self::criar_arquivo_recurso_todos($comhttp,$opcoes);
															$texto_comando["comandos"][] = "commit;";
															break;
														default:
															FuncoesBasicasRetorno::mostrar_msg_sair("origem ".$opcoes["atualizacao"]["origem"][0] ." nao implementado", __FILE__,__FUNCTION__,__LINE__);
															break;
													}
													break;										
												default:									
													FuncoesBasicasRetorno::mostrar_msg_sair("objeto ".$opcoes["atualizacao"]["objeto"][0] ." nao implementado", __FILE__,__FUNCTION__,__LINE__);
													break;
											}
											break;
										case "type":
										case "function":
										case "package":
										case "trigger":
										case "procedure":
											$texto_comando = self::montar_comando_sql_criar_objetos_sql_padrao($comhttp,$opcoes);
											break;
										case "table":
										case "field":
											$texto_comando = self::montar_comando_sql_criar_tabelas_campos($comhttp,$opcoes);
											break;
										default:
											FuncoesBasicasRetorno::mostrar_msg_sair(" tipo objeto ".$opcoes["atualizacao"]["tipoobjeto"][0]." nao implementado",__FILE__,__FUNCTION__,__LINE__);
											break;								
									}
									break;
								case "insert":				
									$texto_comando = self::montar_comando_sql_inserir_catalogo_padrao($comhttp,$opcoes);						
									break;
								default:
									FuncoesBasicasRetorno::mostrar_msg_sair("comando ".$comando." nao implementado",__FILE__,__FUNCTION__,__LINE__);
									break;
							}

							if (isset($opcoes["atualizacao"]["comandos_posteriores"]) && strlen(trim($opcoes["atualizacao"]["comandos_posteriores"])) > 0) {
								$texto_comando[] = [
									"comandos" => explode(";",$opcoes["atualizacao"]["comandos_posteriores"])
								];
							}
						}
					} 
					$dados = null;
				} 	
				return $texto_comando;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e); exit();
				return null;
			} 
		}
		public static function procurar_comando_sql(&$comhttp,&$opcoes) {
			$comando_sql = null;
			$comando_sql = self::procurar_comando_sql_tabela($comhttp,$opcoes);
			if (!($comando_sql !== null && count($comando_sql) > 0)) {
				$comando_sql = self::procurar_comando_sql_arquivo($comhttp,$opcoes);
			}		
			return $comando_sql;
		}
		public static function executar_comando_sql_padrao(&$comhttp,&$opcoes){
			try {
				$retorno = "nao executado";
				$retorno_sql = "";
				if ($opcoes["comando_sql"] !== null && count($opcoes["comando_sql"]) > 0) {
					$conexao = FuncoesSql::getInstancia()->conectar($opcoes["atualizacao"]["nome_conexao"][0]);					
					foreach($opcoes["comando_sql"] as $ind_comando => $comando) {						
						if (isset($comando["comandos"]) && $comando["comandos"] !== null && count($comando["comandos"]) > 0) {
							foreach($comando["comandos"] as $comando2) {
								if ($comando2 !== null && (
									(gettype($comando2) === "string" && strlen(trim($comando2)) > 0)
									|| (gettype($comando2) === "array" && count($comando2) > 0)
								)) {
									$comhttp->requisicao->sql->comando_sql = implode(" ",$comando["comandos"]);	
									$comando_sql = $comando2;
									$params_exec_sql = [
										"conexao" => $conexao,
										"query"=>$comando_sql
									];
									if (isset($comando["camposbind"]) && $comando["camposbind"] !== null && count($comando["camposbind"]) > 0) {
										$params_exec_sql["camposbind"] = $comando["camposbind"];
									} 
									if (isset($comando["valoresbind"]) && $comando["valoresbind"] !== null && count($comando["valoresbind"]) > 0) {
										$params_exec_sql["valoresbind"] = $comando["valoresbind"];
									} 
									$conexao->beginTransaction();
									$resultado_sql = FuncoesSql::getInstancia()->executar_sql($params_exec_sql);
									if ($resultado_sql["result"]->errorCode() != 0) {
										FuncoesSql::getInstancia()->fechar_cursor($resultado_sql);
										FuncoesSql::getInstancia()->rollback($conexao);									
										print_r($resultado_sql["result"]->erroInfo());
										throw new \Exception("erro ao executar atualizacao");
									} else {
										FuncoesSql::getInstancia()->fechar_cursor($resultado_sql);
										FuncoesSql::getInstancia()->commit($conexao);									
									}
								}
							}
						}					
					}
				} else {
					$retorno = "nao executado, comando sql em branco";
					FuncoesBasicasRetorno::mostrar_msg_sair($retorno,__FILE__,__FUNCTION__,__LINE__);
				}		
				return $retorno;	
			} catch(\Error | \Throwable | \Exception $e) {
				FuncoesSql::getInstancia()->rollback($conexao);
                print_r($e);
                exit();
                return null;
            } finally {
				FuncoesSql::getInstancia()->commit($conexao);
				FuncoesSql::getInstancia()->fechar_cursor($resultado_sql);
			}
		}
		public static function executar_atualizacao_db(&$comhttp,$nomeatualizacao) {
			$retorno = "";
			$opcoes = [];
			$opcoes["nomeatualizacao"] = $nomeatualizacao;
			$opcoes["comando_sql"] = self::procurar_comando_sql($comhttp,$opcoes);					
			if ($opcoes["comando_sql"] !== null && count($opcoes["comando_sql"]) > 0 ) {
				$retorno = self::executar_comando_sql_padrao($comhttp,$opcoes);
			} else {
				FuncoesBasicasRetorno::mostrar_msg_sair("comando ".$opcoes["comando"]." ".$opcoes["atualizacao"]["tipoobjeto"][0]." ".$opcoes["atualizacao"]["objeto"][0]." nao localizado",__FILE__,__FUNCTION__,__LINE__);
			}
			return $retorno;
		}
		public static function processar_atualizacao(&$comhttp) {
			$opc_fi = ["comando" => "","tipo_objeto" => "","objeto" => "","msgret" => "","logprocesso" => [],"temclob" => false];		
			$prefixo_objs = VariaveisSql::getInstancia()->getPrefixObjects();
			$retorno = "";
			$nomesatualizacoes = [];
			$nomesatualizacoes = explode(",",strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["nomeatualizacao"])));				
			foreach($nomesatualizacoes as $ind => $nomeatualizacao) {
				$retorno = self::executar_atualizacao_db($comhttp,$nomeatualizacao);
			}
			$comhttp->retorno->dados_retornados = implode("\n",$opc_fi["logprocesso"]);	
		}
	}
?>