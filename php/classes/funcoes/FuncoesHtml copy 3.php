<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\Constantes,
			constantes\NomesDiretorios,
			constantes\NomesCaminhosRelativos,
			constantes\NomesCaminhosArquivos,
			variaveis\VariaveisSql
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesArray,
			requisicao\FuncoesBasicasRetorno,
			FuncoesArquivo,
			FuncoesSql,
			FuncoesVariaveis,
			requisicao\FuncoesRequisicao
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesHtml extends ClasseBase{
		private static $tiposels = [];
		private const trad_prop_html =[
			"idelemento" => "id",
			"id" => "id",
			"nomeelemento" => "name",
			"name" => "name",
			"classe" => "class",
			"class" => "class",
			"valor" => "value",
			"value" => "value",
			"imagem" => "src",
			"src" => "src",
			"aoclicar" => "onclick",
			"onclick" => "onclick",
			"informacaosuspensa" => "title",
			"title" => "title",
			"tipo" => "type",
			"estilo" => "style",
			"estilos" => "style",
			"style" => "style"
		];
		public const opcoes_padrao_retorno=[
			"tabeladb"=>"",
			"campos_visiveis"=>[],
			"campos_ocultos"=>[]
		];
		public const opcoes_tabela_est = self::opcoes_padrao_retorno + [
			"usar_arr_tit"=> true,
			"tipoelemento"=> "tabela_est",
			"tb2"=> "false",
			"cabecalho"=>[
				"ativo"=>true,
				"visivel"=>true,
				"filtro"=>["ativo"=>false],
				"ordenacao"=>["ativo"=>false],
				"ocultarcolunas"=>["ativo"=>false],
				"comandos"=>[
					"ativo"=>false,
					"exportacao"=>["ativo"=>true],
					"inclusao"=>["ativo"=>false],
					"compartilhar"=>["ativo"=>true],
					"mostrarcolunasocultas"=>["ativo"=>true],
					"outroscomandos"=> []
				],
				"celulasextras"=> []
			],
			"corpo" => [
				"ativo"=>true,
				"linhas"=>[
					"aoclicar"=>"",
					"aoduploclicar"=>"",
					"comandos"=>[
						"ativo"=>false,
						"exclusao"=>["ativo"=>false],
						"edicao"=>["ativo"=>false],
						"salvar"=>[
							"ativo"=>false,
							"aosalvarnovalinha"=> "",
							"aosalvaredicaolinha"=> "",
							"aosalvaredicaocelula"=> ""
						],
						"copiar"=>[
							"ativo"=>false,
							"aocopiar"=> ""
						],
						"anexos"=>[
							"ativo"=> false,
							"aoclicar"=> ""
						]
					],
					"linha_padrao"=>["dados"=>[]],
					"valores_padrao"=> [],
					"marcar"=> true,
					"marcarmultiplo"=> true,
					"classemarcacao"=> "marcada",
					"campos_combobox"=> [],
					"campos_combobox"=> []
				],
				"subelementos_colunas"=> [],				
				"classe_colunas"=> [],
				"subelementos_linhas_colunas"=> [],
				"branco_se_zero"=> false,
				"celulasextras"=> [],
				"propriedades_colunas"=> []
			],
			"valores_celulas_linhas_calculos"=> [],
			"celulas_linhas_calculos"=> [],
			"campo_contador"=> null,
			"rodape" => [
				"ativo"=>true,
				"linhasextras"=>[],
				"celulasextras"=>[]
			],
			"selecao"=>[
				"ativo"=>false,
				"tipo"=>"checkbox",
				"selecionar_pela_linha"=>true,
				"selecionar_todos"=>true
			],
			"subregistros"=>[
				"ativo"=>false,
				"aoabrir"=>"",
				"campo_subregistro"=>"",
				"campo_subregistro_pai"=>""
			],
			"inclusao"=>["ativo"=>false],
			"campos_visiveis"=>["todos"],
			"campos_chaves_primaria"=>[],
			"campos_chaves_unica"=>[],
			"aoincluirregistro"=> [],
			"mantercombobox"=> false,
			"numlinhaslimitrecursos"=> 30000,
			"usar_condicionantes_arr_tit"=> true
		];
		public const classe_padrao_botao = "btn-dark";
		private static function obter_tpel_html_arquivo($nome) {
			$retorno = null;
			$retorno = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_tipos_elementos_html"),["filtro"=>strtolower(trim($nome)),"traduzir_apos_filtro"=>true,"preparar_string_antes"=>false]);
			return $retorno;		
		}
		private static function obter_tpel_html_tabela($nome) {
			try {
				$retorno = null;
				if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "tiposelementoshtml")) {
					$comando_sql="select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "tiposelementoshtml where lower(trim(taghtml)) = '" . strtolower(trim($nome)) . "'" ;
					$tipos_elementos = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					$tipos_elementos_temp=[];
					foreach($tipos_elementos as $chave=>$tipoel){
						$tipos_elementos_temp[$tipoel["taghtml"]]=$tipoel;
					}
					$tipos_elementos=$tipos_elementos_temp;			
					$retorno = $tipos_elementos;
				} elseif (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd). "tiposelementoshtml")) {
					$comando_sql="select * from " . VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd) . "tiposelementoshtml where lower(trim(taghtml)) = '" . strtolower(trim($nome)) . "'" ;
					$tipos_elementos = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					$tipos_elementos_temp=[];
					foreach($tipos_elementos as $chave=>$tipoel){
						$tipos_elementos_temp[$tipoel["taghtml"]]=$tipoel;
					}
					$tipos_elementos=$tipos_elementos_temp;			
					$retorno = $tipos_elementos;
				}
				return $retorno;		
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 
		}

		private static function obter_tpel_html($nome) {
			$retorno = [];
			if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "tiposelementoshtml")) {
				$retorno = self::obter_tpel_html_tabela($nome);
				if (count($retorno) <= 0) {
					$retorno = self::obter_tpel_html_arquivo($nome);
				}
			} elseif (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd) . "tiposelementoshtml")) {
				$retorno = self::obter_tpel_html_tabela($nome);
				if (count($retorno) <= 0) {
					$retorno = self::obter_tpel_html_arquivo($nome);
				}
			} else {
				$retorno = self::obter_tpel_html_arquivo($nome);
				if ($retorno === null) {
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo elemento html nao localizado: " . $nome, __FILE__ , __FUNCTION__ , __LINE__ );
				}
			}
			return $retorno;
		}

		public static function obter_tipo_elemento_html($nome,$obter_de_globals=false) {
			$retorno = [];
			$nome = strtolower(trim($nome));
			if ($obter_de_globals) {
				if (isset(self::$tiposels[$nome])) {
					$retorno = self::$tiposels[$nome];
				} else {
					$retorno = self::obter_tpel_html($nome);
					if ($retorno !== null) {
						if (gettype($retorno) === "array") {
							if (isset($retorno[$nome])) {
								$retorno = $retorno[$nome];
							} elseif (isset($retorno[strtoupper($nome)])) {
								$retorno = $retorno[strtoupper($nome)];
							} elseif (isset($retorno[strtolower($nome)])) {
								$retorno = $retorno[strtolower($nome)];
							}
						} else {
							if (property_exists($retorno,$nome)) {
								$retorno = $retorno->{$nome};
							}
						}
						self::$tiposels[$nome] = $retorno;
					}
				}
			} else {
				$retorno = self::obter_tpel_html($nome);
				if ($retorno !== null) {
					if (gettype($retorno) === "array") {
						if (isset($retorno[$nome])) {
							$retorno = $retorno[$nome];
						} elseif (isset($retorno[strtoupper($nome)])) {
							$retorno = $retorno[strtoupper($nome)];
						} elseif (isset($retorno[strtolower($nome)])) {
							$retorno = $retorno[strtolower($nome)];
						}
					} else {
						if (property_exists($retorno,$nome)) {
							$retorno = $retorno->{$nome};
						}
					}
					//self::$tiposels[$nome] = $retorno;
				}
			}		
			return $retorno;
		}

		/**
		 * Inicializa/complementa o array de params para montagem de elemento html
		 * @created 01/10/2021
		 * @param {?array} $params - os parametros de criacao ou nulo para criar
		 * @param {?string} $tag - a tag html
		 * @param {?string} $class - a class html
		 * @return {array} - o array de parametros criado
		 */
		public static function inicializar_params_criar_elemento(?array $params = [], ?string $tag = null, ?string $class = null) : array {
			$params = $params ?? [];
			if (isset($tag) && $tag !== null) {
				$params["tag"] = $params["tag"] ?? $tag;
			}
			if (isset($class) && $class !== null) {
				if (strlen($class) > 0) {					
					$params["class"] = $params["class"] ?? "";
					$params["class"] = str_replace("  "," ",$params["class"]);
					$params["class"] = explode(" ", $params["class"]);
					if (!in_array($class,$params["class"])) {
						$params["class"][] = $class;	
					}
					$params["class"] = implode(" ",$params["class"]);
				} else {					
					$params["class"] = $params["class"] ?? "";
				}
			}
			$params["sub"] = $params["sub"] ?? [];
			return $params;
		}

		/**
		 * Cria/complementa o array de params para montagem de elemento html
		 * @created 01/10/2021
		 * @param {?array} $params - os parametros de criacao ou nulo para criar
		 * @param {?string} $tag - a tag html
		 * @param {?string} $class - a class html
		 * @return {array} - o array de parametros criado
		 */
		public static function criar_elemento(?array $params = [],?string $tag = null, ?string $class = null) : array {
			return self::inicializar_params_criar_elemento($params,$tag,$class);
		}

		/**
		 * cria/complementa o array de parametros para criacao de elemnto html do tipo row (bootstrap)
		 * @create 01/10/2021
		 * @param {?array} $params - o array de parametros a complmenetar
		 * @param {array} o array de parametros criado
		 */
		public static function criar_row(?array $params = []) : array {
			return self::criar_elemento($params,"div","row");
		}

		/**
		 * cria/complementa o array de parametros para criacao de elemnto html do tipo col (bootstrap)
		 * @create 01/10/2021
		 * @param {?array} $params - o array de parametros a complmenetar
		 * @param {array} o array de parametros criado
		 */
		public static function criar_col(?array $params = []) : array {
			return self::criar_elemento($params,"div","col");
		}



		/**
		 * seta as propriedades padrao para inclusao e exclusao de controles html (visoes, periodos, condic, etc)
		 * @created 30/09/2021
		 * @param {array} &$params - o array de params do controle
		 * @return void - nao retorna nada
		 */
		public static function setar_propriedades_padrao_controles(array &$params) : void{			
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? null; //definir antes
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? null; //definir antes

			/*parametros dos botoes de controle*/
			$params["params_botoes_controle"] = $params["params_botoes_controle"] ?? [];
			$params["params_botoes_controle"]["tag"] = $params["params_botoes_controle"]["tag"] ?? "div";
			$params["params_botoes_controle"]["class"] = $params["params_botoes_controle"]["class"] ?? "div_opcao_controles_btns_img col-md-auto w-auto";
			$params["params_botoes_controle"]["sub"] = $params["params_botoes_controle"]["sub"] ?? [];			
			if ($params["permite_incluir"]) {
				$params["params_botoes_controle"]["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_add_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/maisverde32.png",
					"onclick" => $params["funcao_inclusao"],
					"title" => "Acrescentar ao lado deste"
				];
			}
			if ($params["permite_excluir"]) {
				$params["params_botoes_controle"]["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_excl_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/img_del.png",
					"onclick" => $params["funcao_exclusao"],
					"title" => "Excluir este controle"
				];
			}
		}


		/**
		 * monta string html de elementos e seus subs conforme parametros
		 * @created 27/09/2021
		 * @param {array} $params - o array de parametros
		 * @return {string} a string html montada
		 */
		public static function montar_elemento_html(?array $params = []) : string {
			$params = $params ?? [];
			$retorno = '';
			if (FuncoesArray::valor_elemento_array($params,"tag") !== null) {			
				$tipo_el = self::obter_tipo_elemento_html(strtolower(trim(FuncoesArray::valor_elemento_array($params,"tag"))),true);
				if ($tipo_el === null) {
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo elemento html nao encontrado: " . $params["tag"],__FILE__,__FUNCTION__,__LINE__);
				}
				$retorno .= (gettype($tipo_el) === "array"?$tipo_el["aberturahtml"]:$tipo_el->aberturahtml);

				/*monta o array de propriedades, pois propriedades iguais podem aparecer em lugares diferentes nas opcoes, 
				assim serao concatenadas ao final conforme separador apropriado*/
				$props = [];
				foreach($params as $prop=>$val) {
					$prop = strtolower(trim($prop));
					if ($prop !== "" && !in_array($prop,["codelemento","codelementosup","tag","codops"])) {
						
						if (
							(gettype($val) === "array" && count($val) > 0) 
							|| (in_array(gettype($val),["string","number","integer","numeric","bool","boolean"]) && strlen((string)$val)>0)
						) {
							if (in_array($prop,["propriedades_html","props","propriedades"])) {
								foreach($val as $prop_html) {
									if (!isset($prop_html["propriedade"])) {
										print_r($prop_html); exit();
									}
									if (!isset($props[$prop_html["propriedade"]])) {
										$props[$prop_html["propriedade"]] = [];
									}
									$props[$prop_html["propriedade"]][] = $prop_html["valor"];
								}
							} else if (!in_array($prop,["text","sub"])) {
								if (in_array($prop,array_keys(self::trad_prop_html))) {
									if (!isset($props[self::trad_prop_html[$prop]])) {
										$props[self::trad_prop_html[$prop]] = [];
									}
									$props[self::trad_prop_html[$prop]][] = FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao($val));
								} else {
									if ($prop === "camposdata") {
										$campos_data = explode(Constantes::sepn1,$val);
										foreach($campos_data as $campo_data) {
											$chave = substr($campo_data,0,strpos($campo_data,"="));
											$valor = substr($campo_data,strpos($campo_data,"=")+1);
											if (!isset($props[$chave])) {
												$props[$chave] = [];
											}
											$props[$chave][] = $valor;
										}
									} else if ($prop === "demaiscampos") {																	
										$demais_campos = explode(Constantes::sepn1,$val);
										foreach($demais_campos as $demais_campo) {
											$chave = strtolower(trim(substr($demais_campo,0,strpos($demais_campo,"="))));
											$valor = substr($demais_campo,strpos($demais_campo,"=")+1);																			
											if ($chave !== "") {
												if (in_array($chave,array_keys(self::trad_prop_html))) {
													if (!isset($props[self::trad_prop_html[$chave]])) {
														$props[self::trad_prop_html[$chave]] = [];
													}
													$props[self::trad_prop_html[$chave]][] = FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao($valor));
												} else {
													if (!isset($props[$chave])) {
														$props[$chave] = [];
													}
													$props[$chave][] =FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao($valor));
												}
											}
										}
									} else if (gettype($val) !== "array") {										
										if (!isset($props[$prop])) {
											$props[$prop] = [];
										}
										$props[$prop][] = $val;
									} else if (!in_array($prop,["sup"])) {
										print_r($val);
										FuncoesBasicasRetorno::mostrar_msg_sair("tipo de propriedade ou situacao nao esperada: ".$prop,__FILE__,__FUNCTION__,__LINE__);																				
									}
								}
							}
						}
					}
				}	

				/*monta as propriedades html*/
				if (count($props) > 0) {
					foreach($props as $prop => $val) {
						switch(strtolower(trim($prop))) {
							case "class":
								$retorno .= ' ' . $prop . '="'.implode(" ",$val).'" ';
								break;
							default:
								$retorno .= ' ' . $prop . '="'.implode(";",$val).'" ';
								break;
						}
					}
				}
				$retorno .= (gettype($tipo_el) === "array"?$tipo_el["fechamentoaberturahtml"]:$tipo_el->fechamentoaberturahtml);
				if (FuncoesArray::valor_elemento_array($params,"text") !== null) {
					if (FuncoesArray::valor_elemento_array($params,"textodepois") !== null) {
						if (in_array(strtolower(trim(FuncoesArray::valor_elemento_array($params,"textodepois"))) , Constantes::array_falsidade)) {
							$retorno .= FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao(FuncoesArray::valor_elemento_array($params,"text")));
						} 
					} else {
						$retorno .= FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao(FuncoesArray::valor_elemento_array($params,"text")));
					}
				}
				if (FuncoesArray::valor_elemento_array($params,"sub") !== null) {
					if (count($params["sub"]) > 0) {
						foreach($params["sub"] as $chave_sub_el => $sub_el) {							
							switch(gettype($sub_el)) {
								case "array": $retorno .= self::montar_elemento_html($sub_el); break;
								case "string":case "number": case "integer": $retorno .= $sub_el; break;
								case "boolean":case "bool": $retorno .= (string)$sub_el; break;
								default: FuncoesBasicasRetorno::mostrar_msg_sair("tipo nao esperado: " . gettype($sub_el),__FILE__,__FUNCTION__,__LINE__); break;
							}							
						}						
					}						
				}
				if (FuncoesArray::valor_elemento_array($params,"text") !== null) {
					if (in_array(strtolower(trim(FuncoesArray::valor_elemento_array($params,"textodepois"))) , Constantes::array_verdade)) {
						$retorno .= FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao(FuncoesArray::valor_elemento_array($params,"text")));					
					}
				}			
				$retorno .= (gettype($tipo_el) === "array"?$tipo_el["fechamentohtml"]:$tipo_el->fechamentohtml);
			} else {
				if (FuncoesArray::valor_elemento_array($params,"sub") !== null) {
					if (count($params["sub"]) > 0) {
						foreach($params["sub"] as $chave_sub_el => $sub_el) {
							$retorno .= self::montar_elemento_html($sub_el);
						}
					}
				}  elseif (count($params) > 0 ) {						
					foreach($params as $chave_sub_el => $sub_el) {
						if (gettype($sub_el) === "array") {
							$retorno .= self::montar_elemento_html($sub_el);
						}
					}
				}
			}

			/*se o elemento for envolto em outro, isso pode vir configurado como "sup" no array de params*/
			if (isset($params["sup"]) && gettype($params["sup"]) === "array") {
				if (count($params["sup"]) === 1) {
					$params["sup"][0]["text"] = ($params["sup"][0]["text"] ?? "") . $retorno;
					$params = $params["sup"][0];
					$retorno = self::montar_elemento_html($params);
				} else {
					print_r($params_sup);
					FuncoesBasicasRetorno::mostrar_msg_sair("sup nao pode conter mais de um elemento",__FILE__,__FUNCTION__,__LINE__);
				}
			}
			return $retorno;
		}



		/**
		 * cria/complementa um array para criacao de elemento html do tipo spinner
		 * @created 01/10/2021
		 * @params {?array} $params - o array para criacao
		 * @return {array} o array criado/complementado
		 */
		public static function criar_span(?array $params = []) :array {
			return self::criar_elemento($params,"span","");
		}


		/**
		 * cria/complementa um array para criacao de elemento html do tipo spinner
		 * @created 01/10/2021
		 * @params {?array} $params - o array para criacao
		 * @return {array} o array criado/complementado
		 */
		public static function criar_spinner(?array $params = []) :array {
			$params = self::criar_elemento($params,"div","spinner-border");
			$params["role"] = "status";
			$params["sub"][] = self::criar_span(["class" => "visually-hidden","text"=>"Carregando..."]);
			return $params;
		}



		/*DROPDOWN (BOOTSTRAP)*/

		/**
		 * Criar os parametros para montagem de elemento html do tipo combobox dropdown
		 * @created 28/09/2021
		 * @param {array} $params - o array de parametros
		 * @return {array} os parametros criados
		 */
		public static function criar_combobox(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","div_combobox");
			$params["placeholder"] = $params["placeholder"] ?? "(Selecione)";		
			$params["forcar_selecao_por_valores"] = $params["forcar_selecao_por_valores"] ?? false;
			$selecionar_todos = false;
			$selecionar_conforme_valor = false;
			$params["filtro"] = $params["filtro"] ?? 0;
			$params["itens"] = $params["itens"] ?? [];
			if (count($params["itens"]) > 0) {
				foreach($params["itens"] as $chave => &$item) {
					if (gettype($item) !== "array") {
						$item = [
							"opcoes_texto_opcao" => $item
						];
					}
					$item["opcoes_texto_botao"] = $item["opcoes_texto_botao"] ?? $item["opcoes_texto_opcao"];
					$item["opcoes_valor_opcao"] = $item["opcoes_valor_opcao"] ?? $item["opcoes_texto_opcao"];
				}
			}
			$params["classe_botao"] = $params["classe_botao"] ?? $params["classe_btn"] ?? self::classe_padrao_botao;
			$params["tem_inputs"] = $params["tem_inputs"] ?? false;
			$params["tipo_inputs"] = $params["tipo_inputs"] ?? $params["tipo"] ?? "checkbox";						
			$params["multiplo"] = $params["multiplo"] ?? 1;

			if (!isset($params["selecionar_todos"])) {				
				if (isset($params["multiplo"]) && in_array($params["multiplo"],Constantes::array_verdade)) {
					$params["selecionar_todos"] = 1;
				} else {
					$params["selecionar_todos"] = 0;
					$selecionar_todos = false;				
				}
			} 	
			if ($params["tem_inputs"] && $params["tipo_inputs"] === "radio") {
				$params["name_inpus"] = $params["name_inpus"] ?? '_'.mt_rand();
			}			
			if (isset($params["selecionados"])) {
				if (gettype($params["selecionados"]) !== "array") {
					$params["selecionados"] = explode(",",$params["selecionados"]);
				}
			} else {
				$params["selecionados"] = [];
			}		
			if (isset($params["selecionados"][0])) {
				if (strcasecmp(trim($params["selecionados"][0]),"todos") == 0) {
					if (isset($params["multiplo"]) && in_array($params["multiplo"],Constantes::array_verdade)) {
						$selecionar_todos = true;
					} else {
						$selecionar_todos = false;
					}
				} else {
					if (strcasecmp(trim($params["selecionados"][0]),"__campo__=__valor__") == 0) {
						$selecionar_conforme_valor = true;
					}
					$selecionar_todos = false;
				}
			}
			$params["num_max_texto_botao"] = $params["num_max_texto_botao"] ?? 5;
			$classe_combobox = "";			
			$params["sub"] = [];
			$params["sub"][] = [
				"tag" => "button",
				"type" => "button",
				"class" => "btn dropdown-toggle ".($params["classe_botao"] ?? ""),
				"data-bs-toggle" => "dropdown",
				"aria-expanded" => "false",
				"num_max_texto_botao" => $params["num_max_texto_botao"],
				"data-bs-auto-close" => "outside"				
			];			

			/*monta o texto do botao se houverem selecionados*/
			$texto_botao = [];
			if ($selecionar_todos) {				
				$texto_botao[] = "Todos (" . count($params["itens"]).")";			
			} else {
				if (!$selecionar_conforme_valor) {
					foreach($params["selecionados"] as &$selecionado) {
						if (isset($params["itens"][$selecionado]) && !$params["forcar_selecao_por_valores"]) {
							$texto_botao[] = $params["itens"][$selecionado]["opcoes_texto_botao"];
						} else {
							$selecionado = strtolower(trim(str_replace("'","",$selecionado)));
							$encontrado = false;
							foreach($params["itens"] as $chave=>$iten) {
								if (strcasecmp(trim(str_replace("'","",$iten["opcoes_valor_opcao"])),$selecionado) == 0) {
									$encontrado = true;
									$selecionado = $chave;
									$texto_botao[] = $iten["opcoes_texto_botao"];
									break;
								}
							}
							if (!$encontrado) {
								foreach($params["itens"] as $chave=>$iten) {
									if (strcasecmp(trim(str_replace("'","",$iten["opcoes_texto_opcao"])),$selecionado) == 0) {
										$encontrado = true;
										$selecionado = $chave;
										$texto_botao[] = $iten["opcoes_texto_botao"];
										break;
									}
								}					
							}
							if (!$encontrado) {
								foreach($params["itens"] as $chave=>$iten) {
									if (strcasecmp(trim(str_replace("'","",$iten["opcoes_texto_botao"])),$selecionado) == 0) {
										$encontrado = true;
										$selecionado = $chave;
										$texto_botao[] = $iten["opcoes_texto_botao"];
										break;
									}
								}					
							}
							if (!$encontrado) {
								foreach($params["itens"] as $chave=>$iten) {
									$valor = strtolower(trim(str_replace("'","",$iten["opcoes_valor_opcao"])));
									$valor = trim(substr($valor,strpos("=",$valor)+1));
									if ($valor === $selecionado) {
										$encontrado = true;
										$selecionado = $chave;
										$texto_botao[] = $iten["opcoes_texto_botao"];
										break;
									}
								}					
							}
						}
					}
				} 
			}
			if (count($texto_botao) <= 0 ) {
				$texto_botao = $params["placeholder"];
			} else {
				if (count($texto_botao) === count($params["itens"]) && count($texto_botao) > 1) {
					$texto_botao = "Todos (" . count($texto_botao) . ")";
				} else {
					if (count($texto_botao) > $params["num_max_texto_botao"]) {
						$texto_botao = count($texto_botao) . " Selecionados";
					} else {	
						$texto_botao = implode(",",$texto_botao);
					}
				}
			}
			$params["sub"][0]["text"] = $texto_botao;
			$params["sub"][] = [
				"tag" => "ul",
				"class" => "dropdown-menu ".($params["classe_dropdown"] ?? ""),
				"onclick" => "window.fnhtml.fndrop.clicou_dropdown(event,this)"
			];
			if (isset($params["aoselecionaropcao"])) {
				$params["sub"][1]['aoselecionaropcao']=$params["aoselecionaropcao"];
			}	
			if (isset($params["permite_selecao"])) {
				$params["sub"][1]["permite_selecao"] = ((bool)$params["permite_selecao"]?"true":"false");
			}			
			$params["sub"][1]["sub"] = [];
			if (isset($params["selecionar_todos"]) && in_array($params["selecionar_todos"],Constantes::array_verdade)) {				
				$params["sub"][1]["sub"][] = [
					"tag" => "label",
					"class" => "label_selecionar_todos",
					"sub"=>[
						[
							"tag"=>"input",
							"type" => "checkbox",
							"class" => "input_selecionar_todos", 
							"onchange" => "window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)"
						]
					],
					"text" => "Selecionar Todos",
					"textodepois" => true
				];
			}
			if (isset($params["filtro"]) && in_array($params["filtro"],Constantes::array_verdade)) {
				$params["funcao_filtro"] = $params["funcao_filtro"] ?? "window.fnhtml.fndrop.filtrar_dropdown(this)";
				$params["sub"][1]["sub"][] = [
					"tag" => "input",
					"type" => "text",
					"class" => "input_filtro_dropdown rounded",
					"placeholder" => "(filtro)",
					"onkeyup" =>$params["funcao_filtro"]
				];
			}

			/*parametros dos li do combobox*/
			foreach($params["itens"] as $chave_opcao => $iten) {
				$params_label = [
					"tag" => "label",
					"text" => $iten["opcoes_texto_opcao"],
					"textodepois" => true
				];
				if ($params["tem_inputs"]) {
					$params_input = [
						"tag" => "input",
						"type" => $params["tipo_inputs"]
					];
					if (isset($params["name_inpus"]) && $params["name_inpus"] !== null) {
						$params_input["name"] = $params["name_inpus"];
					}
					if ($selecionar_todos || in_array($chave_opcao,$params["selecionados"])) {
						$params_input["checked"] = true;
					}
					$params_label["sub"] = [
						$params_input
					];
				}
				$params_li = $iten;
				$params_li["tag"] = $params_li["tag"] ?? "li";
				$params_li["class"] = "dropdown-item " . ($params_li["tag"] ?? "");
				$params_li["data-valor_opcao"] = $params_li["data-valor_opcao"] ?? $iten["opcoes_valor_opcao"];
				$params_li["data-texto_botao"] = $params_li["data-texto_botao"] ?? $iten["opcoes_texto_botao"];
				$params_li["sub"] = $params_li["sub"] ?? [];
				$params_li["sub"][] = $params_label;
				
				if (isset($params["dados_extras"])) {
					if (count($params["dados_extras"]) > 0) {
						foreach($params["dados_extras"] as $nome_dado=>$valor) {
							$params_li[$nome_dado] = $valor[$chave_opcao];
						}
					}
				}
				
				$params["sub"][1]["sub"][] = $params_li;
			}			
			unset($params["tipo"]);
			unset($params["itens"]);
			unset($params["selecionados"]);
			return $params;
		}

		/**
		 * cria o array de params de drop-down (bootstrap) visoes conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - os parametros criados
		 */
		public static function criar_combobox_visao(?array $params = [] ) : array {
			$params = $params ?? [];
			if (count($params) === 0) {			
				$params["itens"] = Constantes::getInstancia()::$visoes;
			} else {
				if (!isset($params["itens"])) {
					$params["itens"] = Constantes::getInstancia()::$visoes;
				} else {
					if (count($params["itens"]) === 0) {
						$params["itens"] = $params["visoes"] ?? Constantes::getInstancia()::$visoes;
					}
				}
			}
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;	
			$params["tipo_inputs"] = "radio";
			$params["multiplo"] = 0;
			$params["selecionar_todos"] = 0;
			$params["filtro"] = 1;
			$params["selecionados"] = (isset($params["selecionados"])?$params["selecionados"]:[]);
			$params["classe_botao"] = $params["classe_botao"] ?? self::classe_padrao_botao;			
			$params["classe_dropdown"] = "dropdown-visao " . ($params["classe_dropdown"] ?? "");
			$comhttpnull = null;
			unset($params["visoes"]);
			return self::criar_combobox($params);
		}


		/**
		 * cria/complementa o array de parametros para criacao de elemento html do tipo combobox capmo avulso
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_combobox_campos_avulsos(?array $params=[]) : array{
			$params = self::criar_elemento($params,"div","");
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;	
			$params["itens"] = $params["itens"] ?? [];
			$params["tipo"] = "checkbox";
			$params["multiplo"] = 1;
			$params["selecionar_todos"] = 1;
			$params["filtro"] = 1;
			$params["selecionados"] = [];
			$params["propriedades_html"] = [];
			$params["propriedades_html"][] = ["propriedade" => "data-visao" ,"valor" => ""];
			$params["propriedades_html"][] = ["propriedade" => "data-visao_atual", "valor" => "campos_avulsos"];
			$params["aoabrir"] = "window.fnsisjd.incluir_options_campo_avulso(this)";
			return self::criar_combobox($params);
		}

		public static function criar_combobox_meses(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","");			
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;
			$params["itens"] = $params["itens"] ?? $params["meses"] ?? Constantes::meses;						
			$params["selecionados"] = $params["selecionados"] ?? [((date('m')*1)-1)];			
			$params["multiplo"] = $params["multiplo"] ?? 0;
			if (isset($params["multiplo"]) && in_array($params["multiplo"],Constantes::array_verdade)) {
				$params["tipo_inputs"] = $params["tipo_inputs"] ?? "checkbox";
				$params["multiplo"] = $params["multiplo"] ?? 1;
				$params["num_max_texto_botao"] = $params["num_max_texto_botao"] ?? 2;
			} else {
				$params["tipo_inputs"] = $params["tipo_inputs"] ?? "radio";
				$params["multiplo"] = $params["multiplo"] ?? 0;
			}
			$params["classe_botao"] = $params["classe_botao"] ?? self::classe_padrao_botao;
			unset($params["meses"]);
			return self::criar_combobox($params);
		}





		

		/*CARD (BOOTSTRAP)*/

		/**
		 * cria/complementa o array para criar elemento html do tipo card (bootstrap)
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para criacao
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_card(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","card");			
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["title"] ?? "(titulo)";
			$params["conteudo"] = $params["conteudo"] ?? $params["content"] ?? $params["text"] ?? $params["corpo"] ?? $params["body"] ?? null;

			/*se sub vier, quer dizer que sao os elemento sdo body do card*/
			if (isset($params["sub"]) && $params["sub"] !== null && gettype($params["sub"]) === "array" && count($params["sub"]) > 0) {
				$params["elementos_body"] = array_merge(($params["elementos_body"] ?? []),$params["sub"]);
				$params["sub"] = [];
			}
			//print_r($params); exit();
			if (($params["tem_header"] ?? true) == true) {
				$params["sub"][0] = [
					"tag" => "div",
					"class" => "card-header",
					"text" => $params["titulo"],
					"sub" => []
				];
				if (isset($params["elementos_header"])) {
					$params["sub"][0]["sub"] = $params["elementos_header"];
					unset($params["elementos_header"]);
				}
			}
			$params["sub"][1] = [
				"tag" => "div",
				"class" => "card-body",
				"text" => $params["conteudo"],
				"sub" => []
			];
			if (isset($params["elementos_body"])) {
				$params["sub"][1]["sub"] = $params["elementos_body"];
				unset($params["elementos_body"]);
			}

			unset($params["titulo"]);
			unset($params["conteudo"]);
			return $params;
		}


		/**
		 * cria/complementa o arrya de parametros para criar elemento html do tipo card (bootstrap) de visao
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array de parametros
		 */
		public static function criar_card_combobox_visao(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","");
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";
			self::setar_propriedades_padrao_controles($params);

			/*criacao da html do combobox visao*/
			$params["params_combobox"] = $params["params_combobox"] ?? [];
			$params["params_combobox"]["itens"] = $params["params_combobox"]["itens"] ?? Constantes::getInstancia()::$visoes;
			$params["params_combobox"]["tem_inputs"] = $params["params_combobox"]["tem_inputs"] ?? true;
			$params["params_combobox"]["tipo_inputs"] = $params["params_combobox"]["tipo_inputs"] ?? "radio";
			$params["params_combobox"]["multiplo"] = $params["params_combobox"]["multiplo"] ?? 0;
			$params["params_combobox"]["selecionar_todos"] = $params["params_combobox"]["selecionar_todos"] ?? 0;
			$params["params_combobox"]["filtro"] = $params["params_combobox"]["filtro"] ?? 1;			
			$params["elementos_body"] = [
				self::criar_row([
					"sub"=>[
						self::criar_col([
							"sub" => [
								self::criar_combobox_visao($params["params_combobox"])
							]
						]),
						$params["params_botoes_controle"]
					]
				])
			];
			unset($params["params_combobox"]);
			unset($params["params_botoes_controle"]);
			return self::criar_card($params);
		}


		/**
		 * criar/complementa um array de parametors para criacao de elementos html do tipo cards (bootstrap) de visao
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array de arrays de parametros
		 */
		public static function criar_cards_combobox_visao(?array $params = []) : array {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? $params["visoes"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			foreach($params["itens"] as $iten){
				$retorno[] = self::criar_card_combobox_visao([
					"sup"=>[
						self::criar_col(["class"=>"col-auto mt-2 div_visao"])
					],
					"titulo"=>$iten["titulo"] ?? $iten["cabecalho"] ?? $iten["label"] ?? "",
					"params_combobox"=>$iten,
					"permite_incluir" => $params["permite_incluir"],
					"permite_excluir" => $params["permite_excluir"],
					"funcao_inclusao" => $params["funcao_inclusao"],
					"funcao_exclusao" => $params["funcao_exclusao"]
				]);
			}
			return $retorno;
		}



		/**
		 * cria/complementa o array de parametros de criacao de elemento html do tipo card periodo
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_card_periodo(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","");
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "window.fnsisjd.inserir_periodo_pesquisa({elemento:this})";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";
			self::setar_propriedades_padrao_controles($params);

			$params["dtini"] = $params["dtini"] ?? FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>0
				?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][0])
				:FuncoesData::data_primeiro_dia_mes_atual())
			);
			$params["dtfim"] = $params["dtfim"] ?? FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>1
				?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][1])
				:FuncoesData::data_atual())
			);

			$array_imgs_meses = [];
			for($i = 0; $i < 12; $i++) {
				$array_imgs_meses[] = [
					"tag"=>"img",
					"class"=>"imagem_mes_calendario item_destaque100pct_hover",
					"title"=>"Preenche as datas com este mes inteiro",
					"src"=>"/sjd/images/calendario/".Constantes::meses_abrev[$i].".png",
					"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
				];
			};
			$array_imgs_meses[] = [
				"tag"=>"input",
				"type"=>"number",
				"class"=>"inputano",
				"value"=>"2021",
				"title"=>"Ano para preenchimento do mes inteiro",
				"step"=>"1",
				"min"=>"0"
			];

			$params["elementos_body"] = [
				self::criar_row([
					"sub"=>[
						self::criar_col([
							"sub" => [
								self::criar_row([
									"sub" => [
										self::criar_col([
											"class" => "col-auto",
											"sub" => [
												[
													"tag" => "input",
													"type" => "date",
													"class" => "componente_data",
													"value" => $params["dtini"]
												]
											]
										]),self::criar_col([
											"class" => "col-auto",
											"sub" => [
												[
													"tag" => "input",
													"type" => "date",
													"class" => "componente_data",
													"value" => $params["dtfim"]
												]
											]
										])

									]
								]),
								self::criar_row([
									"class"=>"align-items-center",
									"sub"=>[
										self::criar_col([
											"sub"=>[
												[
													"tag"=>"div",
													"class"=>"w-100 text-center",
													"sub"=>$array_imgs_meses
												]
											]
										])
									]
								])
							]
						]),
						$params["params_botoes_controle"]
					]
				])
			];
			unset($params["params_botoes_controle"]);
			return self::criar_card($params);
		}


		/**
		 * Cria/complementa array de arrays de parametros de criacao de elementos html do tipo card
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_cards_periodo(?array $params = []) : array {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? $params["periodos"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			
			foreach($params["itens"] as $iten){
				$retorno[] = self::criar_card_periodo([
					"sup" => [
						self::criar_col(["class"=>"col-auto mt-2 div_periodo"])
					],
					"titulo"=>$iten["titulo"] ?? $iten["cabecalho"] ?? $iten["label"] ?? "",
					"dtini"=>$iten["dtini"] ?? FuncoesData::dataUSA((isset($iten["datas"])&&count($iten["datas"])>0
						?FuncoesVariaveis::como_texto_ou_funcao($iten["datas"][0])
						:FuncoesData::data_primeiro_dia_mes_atual())
					),
					"dtfim"=>$iten["dtfim"] ?? FuncoesData::dataUSA((isset($iten["datas"])&&count($iten["datas"])>1
						?FuncoesVariaveis::como_texto_ou_funcao($iten["datas"][1])
						:FuncoesData::data_atual())
					),
					"permite_incluir" => $params["permite_incluir"],
					"permite_excluir" => $params["permite_excluir"],
					"funcao_inclusao" => $params["funcao_inclusao"],
					"funcao_exclusao" => $params["funcao_exclusao"]
				]);
			}
			return $retorno;
		}


		/**
		 * cria/complementa o array de arrays de parametros para criar elementos html do tipo cards do combo de drop-down3 (bootstrap) de condicionante (visao+operacao+valores)
		 * conforme parametros
		 * @created 30/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function criar_cards_comboboxs_condicionante(?array $params = []) : array {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? $params["condicionantes"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["permite_selecao"] = $params["permite_selecao"] ?? true;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			$ind = 1;
			foreach($params["itens"] as $iten){								
				$iten["titulo"] = $iten["titulo"] ?? "Condicionante " . $ind;
				$iten["sup"]=[
					[
						"tag"=>"div",
						"class"=>"col-auto mt-2 div_condicionante"
					]
				];
				$iten["permite_incluir"] = $params["permite_incluir"];
				$iten["permite_excluir"] = $params["permite_excluir"];
				$iten["funcao_inclusao"] = $params["funcao_inclusao"];
				$iten["funcao_exclusao"] = $params["funcao_exclusao"];
				$iten["permite_selecao"] = $iten["permite_selecao"] ?? $params["permite_selecao"];
				//print_r($iten); exit();
				$retorno[] = self::criar_card_comboboxs_condicionante($iten);
				$ind++;
			}
			return $retorno;
		}


		/**
		 * cria/complementa o array de parametros de criacao de elemtno html do tipo card campo avulso
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_card_combobox_campo_avulso(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","");
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			self::setar_propriedades_padrao_controles($params);

			/*criacao da html do combobox visao*/
			$params["params_combobox"] = $params["params_combobox"] ?? [];
			$params["params_combobox"]["itens"] = $params["params_combobox"]["itens"] ?? [];
			$params["params_combobox"]["tem_inputs"] = $params["params_combobox"]["tem_inputs"] ?? true;
			$params["params_combobox"]["tipo_inputs"] = $params["params_combobox"]["tipo_inputs"] ?? "checkbox";
			$params["params_combobox"]["multiplo"] = $params["params_combobox"]["multiplo"] ?? 1;
			$params["params_combobox"]["selecionar_todos"] = $params["params_combobox"]["selecionar_todos"] ?? 1;
			$params["params_combobox"]["filtro"] = $params["params_combobox"]["filtro"] ?? 1;
			//print_r($params["params_combobox"]); exit();
			$params["elementos_body"] = [
				self::criar_row([
					"sub"=>[
						self::criar_col([
							"sub"=> [
								self::criar_combobox_campos_avulsos($params["params_combobox"])
							]
						]),
						$params["params_botoes_controle"]
					]
				])
			];
			unset($params["params_combobox"]);
			unset($params["params_botoes_controle"]);
			return self::criar_card($params);
		}

		/**
		 * cria/complementa o array de criacao de elemento html do tipo card 
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_cards_combobox_campo_avulso(?array $params = []) : array {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			$params["permite_selecao"] = $params["permite_selecao"] ?? "";
			$params["aoabrir"] = $params["aoabrir"] ?? "window.fnsisjd.incluir_options_condicionante(this)";
			foreach($params["itens"] as $iten){
				$iten["aoabrir"] = $params["aoabrir"] ?? "";
				$iten["data-visao"] = $params["data-visao"] ?? "";
				$iten["data-visao_atual"] = $params["data-visao_atual"] ?? "";
				$retorno[] = self::criar_card_combobox_campo_avulso([
					"sup"=>[
						[
							"tag"=>"div",
							"class"=>"col-auto mt-2 div_visao"
						]
					],
					"titulo"=>$iten["titulo"] ?? $iten["cabecalho"] ?? $iten["label"] ?? "",
					"params_combobox"=>$iten,
					"permite_incluir" => $params["permite_incluir"],
					"permite_excluir" => $params["permite_excluir"],
					"permite_selecao" => $params["permite_selecao"],
					"funcao_inclusao" => $params["funcao_inclusao"],
					"funcao_exclusao" => $params["funcao_exclusao"]
				]);
			}
			return $retorno;
		}


		/**
		 * cria/complementa o array de criacao de elemento html do tipo card 
		 * @created 02/10/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_card_valor(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","");
			$params["content"] = '';
			$params["titulo"] = $params["titulo"] ?? '(titulo)';
			$params["valor"] = $params["valor"] ?? '(valor)';			
			$params["unidade"] = $params["unidade"] ?? '(UN)';
			$params["variacao"] = $params["variacao"] ?? '(variacao)';
			$params["sub"][] = self::criar_row([
				"class"=>"align-items-center gx-0",
				"sub"=>[
					self::criar_col([
						"sub"=>[
							self::criar_elemento([
								"tag"=>"h6",
								"class"=>"text-uppercase text-muted mb-2",
								"text"=>$params["titulo"]
							]),
							self::criar_span([
								"class"=>"h4 mb-0",
								"text"=>$params["valor"]
							])
						]
					]),
					self::criar_col([
						"class"=>"col-auto",
						"sub"=>[
							self::criar_span([
								"class"=>"h4 fe fe-dollar-sign text-muted mb-0",
								"text"=>$params["unidade"]
							])
						]
					])
				]
			]);
			unset($params["valor"]);
			$params["tem_header"] = false;
			return self::criar_card($params);
		}





		/*ACCORDION BOOSTRAP*/

		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo accordion button header (bootstrap)
		 * @created 01/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_accordion_button(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","accordion-button");
			$params["type"]  = $params["type"] ?? "button";
			$params["data-bs-toggle"]  = $params["data-bs-toggle"] ?? "collapse";
			$params["data-bs-target"]  = $params["data-bs-target"] ?? "";
			$params["aria-expanded"]  = $params["aria-expanded"] ?? "true";
			$params["aria-controls"]  = $params["aria-controls"] ?? str_replace("#","",($params["data-bs-target"] ?? ""));
			$params["text"]  = $params["text"] ?? "";
			if (isset($params["aberto"]) && FuncoesConversao::como_boleano($params["aberto"]) === false) {
				if (!in_array("collapsed",explode(" ",$params["class"]))) {
					$params["class"] .= " collapsed";
				}
				$params["aria-expanded"] = "false";
			}			
			return $params;
		}


		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo accordion header (bootstrap)
		 * @created 01/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_accordion_header(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","accordion-header");
			$params_button = $params["params_button"] ?? [];
			$params_button["text"] = $params_button["text"] ?? $params["text"] ?? $params["titulo"] ?? "";
			$params_button["data-bs-toggle"] = $params_button["data-bs-toggle"] ?? $params["data-bs-toggle"] ?? "collapse";
			$params_button["data-bs-target"] = $params_button["data-bs-target"] ?? $params["data-bs-target"] ?? $params_button["target"] ?? $params["target"]?? "";
			$params_button["aberto"] = $params_button["aberto"] ?? $params["aberto"] ?? true;
			array_unshift($params["sub"],self::criar_accordion_button($params_button));
			unset($params["params_button"]);
			return $params;
		}


		/**
		 * cria/complementa o arrya de parametros para criacao de elemento html do tipo div, div_resultado
		 * @created 28/09/2021
		 * @param {?array} $params - os parametros para montar o elemento
		 * @return {array} o array criado/complementado
		 */
		public static function criar_div_resultado_padrao(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","div_resultado_l2 row ");
			$params["sub"][] = [
				"tag" => "div",
				"class" => "div_resultado col"
			];
			return $params;
		}

		public static function criar_opcoes_pesquisa_padrao(?array $params = []) : array{
			$retorno = '';
			$opcoes["titulo"] = $opcoes["titulo"] ?? "Opcoes de Pesquisa";
			$opcoes["height"] = $opcoes["height"] ?? "25px";
			$opcoes["retratil"] = $opcoes["retratil"] ?? [];
			$opcoes["retratil"]["ativo"] = $opcoes["retratil"]["ativo"] ?? true;
			$opcoes["retratil"]["status"] = $opcoes["retratil"]["status"] ?? "aberto";
			$opcoes["visoes"] = $opcoes["visoes"] ?? [];
			$opcoes["visoes2"] = $opcoes["visoes2"] ?? [];/*visoes2 eh para relatorios que tem positivacao, geralmente feita por pivot, onde precisa definir visoes das linhas e visoes das colunas*/
			$opcoes["periodos"] = $opcoes["periodos"] ?? [];
			$opcoes["avancado"] = $opcoes["avancado"] ?? [];
			$opcoes["pesquisar"] = $opcoes["pesquisar"] ?? [];		
			$opcoes["visoes"]["ativo"] = $opcoes["visoes"]["ativo"] ?? true;
			$opcoes["visoes2"]["ativo"] = $opcoes["visoes2"]["ativo"] ?? false;
			$opcoes["periodos"]["ativo"] = $opcoes["periodos"]["ativo"] ?? true;						
			$opcoes["avancado"]["ativo"] = $opcoes["avancado"]["ativo"] ?? true;		
			$opcoes["pesquisar"]["ativo"] = $opcoes["pesquisar"]["ativo"] ?? true;		
			
			
			/*construcao da string html que sera devolvida (a identacao eh para facilitar a identificacao e hierarquia dos elementos html)*/
			$retorno .= '<div class="div_opcoes_pesquisa_l1 row">';
				$retorno .= '<div class="div_opcoes_pesquisa col m-1">';
					$retorno .= '<div class="accordion">';
						$opcoes["classe_corpo"] = $opcoes["classe_corpo"] ?? "div_opcoes_pesquisa_simples";
						$retorno .= '<div class="accordion-item">';
							$retorno .= self::montar_elemento_html(self::criar_accordion_header([
								"titulo" => "Opções de Pesquisa",
								"target" =>  "#painel_div_opcoes_pesquisa_corpo"
							]));
							$retorno .= '<div id="painel_div_opcoes_pesquisa_corpo" class="accordion-collapse collapse show" aria-labelledby="painel_div_opcoes_pesquisa_corpo">';
								$retorno .= '<div class="accordion-body">';
									$retorno .= '<div class="div_opcoes_pesquisa_simples row">';
										$retorno .= '<div class="div_opcoes_pesquisa_simples_col col">';
											$retorno .= '<div class="accordion">';

												/*se houver a opcao de visoes*/
												if ($opcoes["visoes"]["ativo"] === true) {
													$opcoes["visoes"]["titulo"] = $opcoes["visoes"]["titulo"] ?? "Visualizar";
													$opcoes["visoes"]["class"] = $opcoes["visoes"]["class"] ?? "" . " div_visoes";
													$opcoes["visoes"]["permite_incluir"] = $opcoes["visoes"]["permite_incluir"] ?? true;
													$opcoes["visoes"]["permite_excluir"] = $opcoes["visoes"]["permite_excluir"] ?? true;
													$opcoes["visoes"]["itens"] = $opcoes["visoes"]["itens"] ?? [
														[
															"tipo"=>"visao",
															"label"=>"Visao 01",
															"selecionados"=>9,
															"classe_botao"=>self::classe_padrao_botao
														]
													];													
													$opcoes["visoes"]["funcao_inclusao"] = $opcoes["visoes"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
													$opcoes["visoes"]["funcao_exclusao"] = $opcoes["visoes"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						
													$retorno .= '<div class="accordion-item '.$opcoes["visoes"]["class"].'">';
														$retorno .= self::montar_elemento_html(self::criar_accordion_header([
															"titulo" => $opcoes["visoes"]["titulo"],
															"target" =>  "#visoes"
														]));

														$retorno .= '<div id="visoes" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																if ($opcoes["visoes"]["permite_incluir"]) {
																	$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["visoes"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																}
																$retorno .= self::montar_elemento_html(self::criar_row([
																	"sub"=>[
																		self::criar_cards_combobox_visao($opcoes["visoes"])
																	]
																]));
															$retorno .= '</div>';
														$retorno .= '</div>';
													$retorno .= '</div>';
												}



												/*se houver a opcao de visoes*/
												if ($opcoes["visoes2"]["ativo"] === true) {
													$opcoes["visoes2"]["titulo"] = $opcoes["visoes2"]["titulo"] ?? "Visualizar";
													$opcoes["visoes2"]["class"] = $opcoes["visoes2"]["class"] ?? "" . " div_visoes2";
													$opcoes["visoes2"]["permite_incluir"] = $opcoes["visoes2"]["permite_incluir"] ?? true;
													$opcoes["visoes2"]["permite_excluir"] = $opcoes["visoes2"]["permite_excluir"] ?? true;
													$opcoes["visoes2"]["itens"] = $opcoes["visoes2"]["itens"] ?? [
														[
															"tipo"=>"visao",
															"label"=>"Visao 01",
															"selecionados"=>9
														]
													];
													$opcoes["visoes2"]["funcao_inclusao"] = $opcoes["visoes2"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
													$opcoes["visoes2"]["funcao_exclusao"] = $opcoes["visoes2"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						
													$retorno .= '<div class="accordion-item '.$opcoes["visoes2"]["class"].'">';
														$retorno .= self::montar_elemento_html(self::criar_accordion_header([
															"titulo" => $opcoes["visoes2"]["titulo"],
															"target" =>  "#visoes2"
														]));
														$retorno .= '<div id="visoes2" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["visoes2"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																$retorno .= self::montar_elemento_html(self::criar_row([
																	"sub"=>[
																		self::criar_cards_combobox_visao($opcoes["visoes2"])
																	]
																]));	
															$retorno .= '</div>';
														$retorno .= '</div>';
													$retorno .= '</div>';
												}



												if ($opcoes["periodos"]["ativo"] === true) {
													$opcoes["periodos"]["titulo"] = $opcoes["periodos"]["titulo"] ?? "Periodos";
													$opcoes["periodos"]["tipo"] = $opcoes["periodos"]["tipo"] ?? "periodos";
													$opcoes["periodos"]["class"] = $opcoes["periodos"]["class"] ?? "" . " div_periodos";
													$opcoes["periodos"]["permite_incluir"] = $opcoes["periodos"]["permite_incluir"] ?? true;
													$opcoes["periodos"]["permite_excluir"] = $opcoes["periodos"]["permite_excluir"] ?? true;		
													$opcoes["periodos"]["itens"] = $opcoes["periodos"]["itens"] ?? [
														[
															"tipo"=>"periodo",
															"label"=>"Periodo 01"
														]
													];
													$opcoes["periodos"]["funcao_inclusao"] = $opcoes["periodos"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_periodo_pesquisa({elemento:this})";
													$opcoes["periodos"]["funcao_exclusao"] = $opcoes["periodos"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";
													$retorno .= '<div class="accordion-item '.$opcoes["periodos"]["class"].'">';
														$retorno .= self::montar_elemento_html(self::criar_accordion_header([
															"titulo" => "Períodos",
															"target" =>  "#periodos"
														]));
														$retorno .= '<div id="periodos" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																if ($opcoes["periodos"]["permite_incluir"] === true) {
																	$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["periodos"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																}
																$retorno .= self::montar_elemento_html(self::criar_row([
																	"sub"=>[
																		self::criar_cards_periodo($opcoes["periodos"])
																	]
																]));	
																
															$retorno .= '</div>';
														$retorno .= '</div>';
													$retorno .= '</div>';
												}
											

												/*se houver a opcao avancada*/	
												if ($opcoes["avancado"]["ativo"] === true) {	
													$opcoes["avancado"]["titulo"] = $opcoes["avancado"]["titulo"] ?? "Avancado";
													$opcoes["avancado"]["class"] = $opcoes["avancado"]["class"] ?? "avancado div_avancado";
													$opcoes["avancado"]["retratil"] = $opcoes["avancado"]["retratil"] ?? [];
													$opcoes["avancado"]["retratil"]["ativo"] = $opcoes["avancado"]["retratil"]["ativo"] ?? true;
													$opcoes["avancado"]["retratil"]["status"] = $opcoes["avancado"]["retratil"]["status"] ?? "fechado";
													
													$opcoes["avancado"]["ver_vals_de"] = $opcoes["avancado"]["ver_vals_de"] ?? [];
													$opcoes["avancado"]["ver_vals_de"]["ativo"] = $opcoes["avancado"]["ver_vals_de"]["ativo"] ?? true;						
													$opcoes["avancado"]["considerar_vals_de"] = $opcoes["avancado"]["considerar_vals_de"] ?? [];
													$opcoes["avancado"]["considerar_vals_de"]["ativo"] = $opcoes["avancado"]["considerar_vals_de"]["ativo"] ?? true;
													
													
													/*geralmente utilizado em relatorios do tipo positivacao (com sql pivot)*/
													$opcoes["avancado"]["ver_vals_zero"] = $opcoes["avancado"]["ver_vals_zero"] ?? [];
													$opcoes["avancado"]["ver_vals_zero"]["ativo"] = $opcoes["avancado"]["ver_vals_zero"]["ativo"] ?? false;
													$opcoes["avancado"]["condicionantes"] = $opcoes["avancado"]["condicionantes"] ?? [];
													$opcoes["avancado"]["condicionantes"]["ativo"] = $opcoes["avancado"]["condicionantes"]["ativo"] ?? true;
													$opcoes["avancado"]["campos_avulsos"] = $opcoes["avancado"]["campos_avulsos"] ?? [];
													$opcoes["avancado"]["campos_avulsos"]["ativo"] = $opcoes["avancado"]["campos_avulsos"]["ativo"] ?? true;
												
													$retorno .= '<div class="accordion-item '.$opcoes["avancado"]["class"].'">';
														$retorno .= self::montar_elemento_html(self::criar_accordion_header([
															"titulo" => "Avançado",
															"target" =>  "#avancada",
															"aberto"=>false,
														]));
														$retorno .= '<div id="avancada" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																$opcoes["avancado"]["classe_corpo"] = $opcoes["avancado"]["classe_corpo"] ?? "div_opcoes_pesquisa_avancada";
																$retorno .= '<div class="div_opcoes_pesquisa_avancada row ">';
																	$retorno .= '<div class="div_opcoes_pesquisa_avancada_col col">';			

																	$retorno .= '<div class="accordion">';

																		if ($opcoes["avancado"]["ver_vals_de"]["ativo"] === true) {	
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= self::montar_elemento_html(self::criar_accordion_header([
																					"titulo" => "Ver Valores de",
																					"target" =>  "#painel_ver_vals_de",
																					"aberto"=>false,
																				]));
																				$retorno .= '<div id="painel_ver_vals_de" class="accordion-collapse collapse painel_ver_vals_de" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';

																						$retorno .= '<div class="div_opcoes_corpo row">';
																							$retorno .= '<div class="div_opcoes_corpo_opcoes col">';
																								$retorno .= '<div class="div_opcao">';														
																								$opcoes["avancado"]["ver_vals_de"]["itens"] = $opcoes["avancado"]["ver_vals_de"]["itens"] ?? [
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>0,
																										"label"=>"Qtde",				
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>1,
																										"label"=>"Unidade",
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>2,
																										"label"=>"Peso UN",
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>3,
																										"label"=>"Peso Total",
																										"checked"=>true,
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>4,
																										"label"=>"Valor UN",
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>5,
																										"label"=>"Valor Total",
																										"checked"=>true,
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>6,
																										"label"=>"Produtos com Objetivo",
																										"checked"=>true,
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>7,
																										"label"=>"Produtos sem Objetivo",
																										"checked"=>true,
																										"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"
																									],
																									[
																										"class"=>"checkbox_ver_valores_de",
																										"type"=>"checkbox",
																										"value"=>10,
																										"label"=>"Todos",
																										"onchange"=>"window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)"
																									]
																								];														
																								foreach($opcoes["avancado"]["ver_vals_de"]["itens"] as $opcao) {														
																									$retorno .= '<label class="rotulo_ver_vals_de width_33pc">';																	
																										$retorno .= '<input type="'.(isset($opcao["type"])?$opcao["type"]:"checkbox").'" class="'.(isset($opcao["class"])?$opcao["class"]:"").'" value="'.(isset($opcao["value"])?$opcao["value"]:(isset($opcao["valor"])?$opcao["valor"]:"")).'" ';
																										/*para o componente do tipo radio funcionar corretamente (selecao unica) precisa de name atribuido*/
																										if (isset($opcao["name"]) && ($opcao["name"] !== null && strlen(trim($opcao["name"])) > 0)) {
																											$retorno .= ' name="'.$opcao["name"].'" ';
																										}
																										if (isset($opcao["onchange"]) && ($opcao["onchange"] !== null && strlen(trim($opcao["onchange"])) > 0)) { 
																											$retorno .= ' onchange="'.$opcao["onchange"].'" ';
																										}
																										if (isset($opcao["checked"]) && ($opcao["checked"] === true || $opcao["checked"] === "checked")) {
																											$retorno .= " checked ";
																										}
																										$retorno .= '/>';
																										$retorno .= $opcao["label"];
																									$retorno .= '</label>';															
																								}
																								$retorno .= '</div>';
																							$retorno .= '</div>';													
																						$retorno .= '</div>';
																					$retorno .= '</div>';
																				$retorno .= '</div>';
																			$retorno .= '</div>';
																		}
																		
																		
																		
																		if ($opcoes["avancado"]["ver_vals_zero"]["ativo"] === true) {
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= self::montar_elemento_html(self::criar_accordion_header([
																					"titulo" => "Ver Valores Zero",
																					"target" =>  "#painel_ver_vals_zero",
																					"aberto"=>false,
																				]));
																				$retorno .= '<div id="painel_ver_vals_zero" class="accordion-collapse collapse painel_ver_vals_zero" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';
																						$retorno .= '<div class="div_opcoes_corpo row">';
																							$retorno .= '<div class="div_opcoes_corpo_opcoes col">';
																								$retorno .= '<div class="div_opcao">';
																								foreach($opcoes["avancado"]["ver_vals_zero"]["itens"] as $opcao) {														
																									$retorno .= '<label class="rotulo_ver_valores_zero1">';																	
																										$retorno .= '<input type="'.$opcao["type"].'" class="'.$opcao["class"].'" value="'.$opcao["value"].'" ';
																										/*para o componente do tipo radio funcionar corretamente (selecao unica) precisa de name atribuido*/
																										if (isset($opcao["name"]) && ($opcao["name"] !== null && strlen(trim($opcao["name"])) > 0)) {
																											$retorno .= ' name="'.$opcao["name"].'" ';
																										}
																										if (isset($opcao["onchange"]) && ($opcao["onchange"] !== null && strlen(trim($opcao["onchange"])) > 0)) { 
																											$retorno .= ' onchange="'.$opcao["onchange"].'" ';
																										}
																										if (isset($opcao["checked"]) && ($opcao["checked"] === true || $opcao["checked"] === "checked")) {
																											$retorno .= " checked ";
																										}
																										$retorno .= '/>';
																										$retorno .= $opcao["label"];
																									$retorno .= '</label>';															
																								}
																								$retorno .= '</div>';
																							$retorno .= '</div>';													
																						$retorno .= '</div>';
																					$retorno .= '</div>';
																				$retorno .= '</div>';
																			$retorno .= '</div>';
																		}
																		
																		if ($opcoes["avancado"]["considerar_vals_de"]["ativo"] === true) {	
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= self::montar_elemento_html(self::criar_accordion_header([
																					"titulo" => "Considerar Valores de",
																					"target" =>  "#painel_considerar_vals_de",
																					"aberto"=>false,
																				]));
																				$retorno .= '<div id="painel_considerar_vals_de" class="accordion-collapse collapse painel_considerar_vals_de" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';	
																						$retorno .= '<div class="div_opcoes_corpo row">';
																							$retorno .= '<div class="div_opcoes_corpo_opcoes col">';
																								$retorno .= '<div class="div_opcao">';
																									$retorno .= '<label class="rotulo_considerar_vals_de width_33pc">';																	
																										$retorno .= '<input type="checkbox" class="checkbox_considerar_valores_de" value="0" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked/>';
																										$retorno .= 'Vendas Normais';
																									$retorno .= '</label>';
																									$retorno .= '<label class="rotulo_considerar_vals_de width_33pc">';																	
																										$retorno .= '<input type="checkbox" class="checkbox_considerar_valores_de" value="1" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked/>';
																										$retorno .= 'Devolucoes Normais';
																									$retorno .= '</label>';
																									$retorno .= '<label class="rotulo_considerar_vals_de width_33pc">';																	
																										$retorno .= '<input type="checkbox" class="checkbox_considerar_valores_de" value="2" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked/>';
																										$retorno .= 'Devolucoes Avulsas';
																									$retorno .= '</label>';
																									$retorno .= '<label class="rotulo_considerar_vals_de width_33pc">';																	
																										$retorno .= '<input type="checkbox" class="checkbox_considerar_valores_de" value="3" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)"/>';
																										$retorno .= 'Bonificacoes';
																									$retorno .= '</label>';
																									$retorno .= '<label class="rotulo_considerar_vals_de width_33pc">';																	
																										$retorno .= '<input type="checkbox" class="checkbox_considerar_valores_de" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_considerar_vals_de(this)"/>';
																										$retorno .= 'Todos';
																									$retorno .= '</label>';
																								$retorno .= '</div>';
																							$retorno .= '</div>';													
																						$retorno .= '</div>';
																					$retorno .= '</div>';
																				$retorno .= '</div>';
																			$retorno .= '</div>';
																		}
																			
																		if ($opcoes["avancado"]["condicionantes"]["ativo"] === true) {	
																			$opcoes["avancado"]["condicionantes"]["titulo"] = $opcoes["avancado"]["condicionantes"]["titulo"] ?? "Condicionantes";
																			$opcoes["avancado"]["condicionantes"]["class"] = $opcoes["avancado"]["condicionantes"]["class"] ?? "" . " div_condicionantes";
																			$opcoes["avancado"]["condicionantes"]["permite_incluir"] = $opcoes["avancado"]["condicionantes"]["permite_incluir"] ?? true;
																			$opcoes["avancado"]["condicionantes"]["permite_excluir"] = $opcoes["avancado"]["condicionantes"]["permite_excluir"] ?? true;
																			$opcoes["avancado"]["condicionantes"]["itens"] = $opcoes["avancado"]["condicionantes"]["itens"] ?? [];
																			$opcoes["avancado"]["condicionantes"]["funcao_inclusao"] = $opcoes["avancado"]["condicionantes"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})";
																			$opcoes["avancado"]["condicionantes"]["funcao_exclusao"] = $opcoes["avancado"]["condicionantes"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						
																			$opcoes["avancado"]["condicionantes"]["funcao_inclusao"] = str_replace('"',"'",$opcoes["avancado"]["condicionantes"]["funcao_inclusao"]);


																		
																			$opcoes["classe_corpo"] = $opcoes["classe_corpo"] ?? "div_opcoes_pesquisa_simples";
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= self::montar_elemento_html(self::criar_accordion_header([
																					"titulo" => "Condicionantes",
																					"target" =>  "#painel_condicionantes",
																					"aberto"=>false,
																				]));
																				$retorno .= '<div id="painel_condicionantes" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';
																						if ($opcoes["avancado"]["condicionantes"]["permite_incluir"] === true) {
																							$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["avancado"]["condicionantes"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																						}
																						$retorno .= self::montar_elemento_html(self::criar_row([
																							"sub"=>[
																								self::criar_cards_comboboxs_condicionante($opcoes["avancado"]["condicionantes"])
																							]
																						]));																							
																					$retorno .= '</div>';
																				$retorno .= '</div>';
																			$retorno .= '</div>';
																		$retorno .= '</div>';
																		}	
																	
																	
																		if ($opcoes["avancado"]["campos_avulsos"]["ativo"] === true) {
																			$opcoes["avancado"]["campos_avulsos"]["titulo"] = $opcoes["avancado"]["campos_avulsos"]["titulo"] ?? "Campos Avulsos";
																			$opcoes["avancado"]["campos_avulsos"]["class"] = $opcoes["avancado"]["campos_avulsos"]["class"] ?? "" . " div_campos_avulsos";
																			$opcoes["avancado"]["campos_avulsos"]["permite_incluir"] = false;
																			$opcoes["avancado"]["campos_avulsos"]["permite_excluir"] = false;
																			$opcoes["avancado"]["campos_avulsos"]["retratil"] = ["ativo"=>true];
																			$opcoes["avancado"]["campos_avulsos"]["itens"] = [
																				[
																					"label"=>"Campos Avulsos",
																					"tipo"=>"campo_avulso",
																					"classe_botao"=>self::classe_padrao_botao
																				]
																			];
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= self::montar_elemento_html(self::criar_accordion_header([
																					"titulo" => "Campos Avulsos",
																					"target" =>  "#painel_campos_avulsos",
																					"aberto"=>false,
																				]));
																				$retorno .= '<div id="painel_campos_avulsos" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';
																						$retorno .= self::montar_elemento_html(self::criar_row([
																							"sub"=>[
																								self::criar_cards_combobox_campo_avulso($opcoes["avancado"]["campos_avulsos"])
																							]
																						]));
																						
																					$retorno .= '</div>';
																				$retorno .= '</div>';
																			$retorno .= '</div>';																					
																		}
																	$retorno .= '</div>';
																$retorno .= '</div>';
															$retorno .= '</div>';
														$retorno .= '</div>';
													$retorno .= '</div>';
												}
											$retorno .= '</div>';
										if ($opcoes["pesquisar"]["ativo"] === true ) {
											$opcoes["pesquisar"]["metodo_pesquisar"] = str_replace('"',"'",$opcoes["pesquisar"]["metodo_pesquisar"] ?? "window.fnsisjd.pesquisar_dados(this)");
											$retorno .= '<div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3">';
												$retorno .= '<button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="'.$opcoes["pesquisar"]["data-visao"].'" '.(isset($opcoes["pesquisar"]["visao"])?' visao="'.$opcoes["pesquisar"]["visao"].'" ':'').' ' . (isset($opcoes["pesquisar"]["codprocesso"])?' codprocesso="'.$opcoes["pesquisar"]["codprocesso"].'" ':'') . ' onclick="'.$opcoes["pesquisar"]["metodo_pesquisar"].'">';
													$retorno .= 'Pesquisar';
												$retorno .= '</button>';
											$retorno .= '</div>';
										}							
										$retorno .= '</div>';
									$retorno .= '</div>';
								$retorno .= '</div>';
							$retorno .= '</div>';
						$retorno .= '</div>';
					$retorno .= '</div>';
				$retorno .= '</div>';
			$retorno .= '</div>';
			return $retorno;
		}
	}
?>