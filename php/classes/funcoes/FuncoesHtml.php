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
		public const opcoes_combobox = self::opcoes_padrao_retorno + [
			"tipoelemento"=> "combobox",
			"opcoes_texto_opcao"=> [],
			"selecionados"=> [],
			"tipo"=> "radio",
			"multiplo"=> 0,
			"selecionar_todos"=> 0,
			"filtro"=> 0,		
			"propriedades_html"=> [],
			"num_max_texto_botao"=> 5
		];
		public const opcoes_comboboxes_condicionante = self::opcoes_padrao_retorno + [
			"tipoelemento" =>"comboboxes_condicionante",
			"permite_incluir" => true,
			"permite_excluir"=> true,
			"permite_selecao" => true
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
									$prop_html["propriedade"] = $prop_html["propriedade"] ?? $prop_html["prop"] ?? $prop_html["property"];
									if (!isset($prop_html["propriedade"]) || $prop_html["propriedade"] === null) {
										echo "campo propriedade nao definido";
										print_r($prop_html); exit();
									}
									if (!isset($props[$prop_html["propriedade"]])) {
										$props[$prop_html["propriedade"]] = [];
									}
									$props[$prop_html["propriedade"]][] = $prop_html["valor"] ?? $prop_html["value"] ?? $prop_html["val"];
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
		 * Monta a string html de drop-down (bootstrap) dos itens de condicionantes conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function criar_combobox_condicionante(?array $params = []) : array { 
			$params = self::criar_elemento($params,"div","condicionante");
			$params["visao"] = $params["visao"] ?? "Origem de Dados";
			$params["itens"] = FuncoesSisJD::valores_para_condicionante($params["visao"]);
			$params["tipo_inputs"] = "checkbox";
			$params["selecionar_todos"] = 1;
			$params["multiplo"] = 1;
			$params["filtro"] = 1;
			$params["propriedades_html"] = [];
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;
			return self::criar_combobox($params);
		}

		/**
		 * Monta a string html do combo de drop-down3 (bootstrap) de condicionante (visao+operacao+valores)
		 * conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function criar_comboboxs_condicionante(?array $params = []) : array { 
			$params = self::criar_elemento($params,"div","div_condicionante");

			/*monta o html do combobox visao*/
			$params["visoes"] = $params["visoes"] ?? Constantes::getInstancia()::$visoes_condic;
			if (gettype($params["visoes"]) !== "array") {
				$params["visoes"] = explode(",",$params["visoes"]);
			}
			$params["visao"] = $params["visao"] ?? $params["visoes"][0];						
			$visao = $params["visao"];
			$opcoes_combobox_visao = [];
			$opcoes_combobox_visao["itens"] = (gettype($params["visoes"])==="array"?$params["visoes"]:explode(",",$params["visoes"]));
			$opcoes_combobox_visao["selecionados"] = [array_search(trim(strtolower($params["visao"])),explode(",",trim(strtolower(implode(",",$params["visoes"])))))];
			$opcoes_combobox_visao["permite_selecao"] = $params["permite_selecao"] ?? true;
			//$html_combobox_visao = self::montar_combobox_visao($opcoes_combobox_visao);

			/*monta o html do combobox operacao*/
			$opcoes_combobox_operacao = [];
			$opcoes_combobox_operacao["itens"] = ["Igual a","Diferente de"];
			$opcoes_combobox_operacao["selecionados"] = [0];
			$opcoes_combobox_operacao["tipo_inputs"] = "radio";
			$opcoes_combobox_operacao["multiplo"] = "nao";
			$opcoes_combobox_operacao["selecionar_todos"] = "nao";
			$opcoes_combobox_operacao["filtro"] = "nao";		
			$opcoes_combobox_operacao["propriedades_html"] = [];
			$opcoes_combobox_operacao["tem_inputs"] = true;
			$opcoes_combobox_operacao["propriedades_html"][] = ["propriedade" => "class" ,"valor" => "operacao"];
			$opcoes_combobox_operacao["selecionados"] = [0];
			$opcoes_combobox_operacao["permite_selecao"] = $params["permite_selecao"] ?? true;
			$comhttpnull = null;
			//$html_comparador = self::montar_combobox($opcoes_combobox_operacao);		

			/*monta o html do combobox dos valores da condicionante*/
			/*$html_dados_condicionante = self::montar_combobox_condicionante([
				"visao"=>$visao,
				"selecionados"=>$opcoes_combobox_visao["selecionados"],
				"permite_selecao" => $params["permite_selecao"] ?? true
			]);*/


			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "row",
				"sub" => [
					[
						"tag"=>"div",
						"class" => "col-auto",
						"sub" => [
							self::criar_combobox_visao($opcoes_combobox_visao)
						]
					],[
						"tag"=>"div",
						"class" => "col-auto",
						"sub" => [
							self::criar_combobox($opcoes_combobox_operacao)
						]
					],[
						"tag"=>"div",
						"class" => "col-auto",
						"sub" => [
							self::criar_combobox_condicionante([
								"visao"=>$visao,
								"selecionados"=>$params["selecionados"],
								"permite_selecao" => $params["permite_selecao"] ?? true,
								"permite_incluir" => $params["permite_incluir"] ?? true,
								"permite_excluir" => $params["permite_excluir"] ?? true,
								"forcar_selecao_por_valores" => $params["forcar_selecao_por_valores"] ?? false
							])
						]
					]
				]
			];
			unset($params["selecionados"]);
			unset($params["params_botoes_controle"]);
			unset($params["visoes"]);
			return $params;
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


		/**
		 * cria/complementa o array de parametros para criacao de elemento html do tipo combobox meses
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
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
			if (strcasecmp($params["params_combobox"]["tipo"]??"","condicionante") == 0) {
				$combobox = self::criar_combobox_condicionante($params["params_combobox"]);
			} elseif (strcasecmp($params["params_combobox"]["tipo"]??"","mes") == 0) {
				$combobox = self::criar_combobox_meses($params["params_combobox"]);
			} elseif (strcasecmp($params["params_combobox"]["tipo"]??"","input") == 0) {
				$combobox = self::criar_elemento($params["params_combobox"]);
			} else {
				$params["params_combobox"]["itens"] = $params["params_combobox"]["itens"] ?? Constantes::getInstancia()::$visoes;
				$params["params_combobox"]["tem_inputs"] = $params["params_combobox"]["tem_inputs"] ?? true;
				$params["params_combobox"]["tipo_inputs"] = $params["params_combobox"]["tipo_inputs"] ?? "radio";
				$params["params_combobox"]["multiplo"] = $params["params_combobox"]["multiplo"] ?? 0;
				$params["params_combobox"]["selecionar_todos"] = $params["params_combobox"]["selecionar_todos"] ?? 0;
				$params["params_combobox"]["filtro"] = $params["params_combobox"]["filtro"] ?? 1;			
				$combobox = self::criar_combobox_visao($params["params_combobox"]);
			}
			$params["elementos_body"] = [
				self::criar_row([
					"sub"=>[
						self::criar_col([
							"sub" => [
								$combobox
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
					"permite_incluir" => $iten["permite_incluir"] ?? $params["permite_incluir"],
					"permite_excluir" => $iten["permite_excluir"] ?? $params["permite_excluir"],
					"funcao_inclusao" => $iten["funcao_inclusao"] ?? $params["funcao_inclusao"],
					"funcao_exclusao" => $iten["funcao_exclusao"] ?? $params["funcao_exclusao"]
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
		 * Cria/complementa o array de criacao de elemento html html de um card do combo de drop-down3 (bootstrap) de condicionante (visao+operacao+valores)
		 * conforme parametros
		 * @created 30/09/2021
		 * @lastupdated 05/10/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_card_comboboxs_condicionante(?array $params = []) : array{
			$params = self::criar_elemento($params,"div","");
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";
			self::setar_propriedades_padrao_controles($params);
			//$html_comboboxs_condicionantes = self::montar_comboboxs_condicionante($params);
			$params["elementos_body"] = [
				[
					"tag"=>"div",
					"class"=>"row",
					"sub"=>[
						[
							"tag"=>"div",
							"class"=>"col",
							"sub" => [
								self::criar_comboboxs_condicionante($params)
							]
						],
						$params["params_botoes_controle"]
					]
				]
			];
			unset($params["params_combobox"]);
			unset($params["params_botoes_controle"]);
			unset($params["selecionados"]);
			return self::criar_card($params);
		}

		/**
		 * cria/complementa o array de arrays de parametros para criar elementos html do tipo cards do combo de drop-down3 (bootstrap) de condicionante (visao+operacao+valores)
		 * conforme parametros
		 * @created 30/09/2021
		 * @lastupdated 05/10/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
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
			$el_valor = null;
			if (gettype($params["valor"]) === "array") {
				$el_valor = $params["valor"];
			} else {
				$el_valor = self::criar_span([
					"class"=>"h5 mb-0",
					"text"=>$params["valor"]
				]);
			}
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
							$el_valor
						]
					]),
					self::criar_col([
						"class"=>"col-auto",
						"sub"=>[
							self::criar_span([
								"class"=>"h5 fe fe-dollar-sign text-muted mb-0",
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
			if ($params_button["data-bs-target"][0] !== "#") {
				$params_button["data-bs-target"] = "#".$params_button["data-bs-target"];
			}
			$params_button["aberto"] = $params_button["aberto"] ?? $params["aberto"] ?? true;
			array_unshift($params["sub"],self::criar_accordion_button($params_button));
			unset($params["params_button"]);
			return $params;
		}


		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo accordion body (bootstrap)
		 * @created 02/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_accordion_body(?array $params = []) : array {
			return self::criar_elemento($params,"div","accordion-body");
		}


		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo accordion-item (bootstrap)
		 * @created 02/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_accordion_item(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","accordion-item");
			$params["titulo"] = $params["titulo"] ?? "(titulo)";
			$params["target"] = $params["target"] ?? $params["data-bs-target"] ?? '_'.mt_rand();
			$params["aberto"] = $params["aberto"] ?? true;
			$params_header = self::criar_elemento($params["params_header"] ?? [],"div","accordion-header");
			$params_body = self::criar_elemento($params["params_body"] ?? [],"div","accordion-body");
			$params_header["titulo"] = $params_header["titulo"] ?? $params["titulo"];
			$params_header["target"] = $params_header["target"] ?? $params["target"];
			$params_header["aberto"] = $params_header["aberto"] ?? $params["aberto"];
			$params_body["aberto"] = $params_body["aberto"] ?? $params["aberto"];
			
			/*se sub vier, quer dizer que sao os elemento sdo body do card*/
			if (
				(isset($params["sub"]) && $params["sub"] !== null && gettype($params["sub"]) === "array" && count($params["sub"]) > 0)
				||(isset($params["elementos_body"]) && $params["elementos_body"] !== null && gettype($params["elementos_body"]) === "array" && count($params["elementos_body"]) > 0)
			 ) {
				$params_body["sub"] = array_merge(
					($params_body["sub"] ?? []),
					($params_body["elementos_body"] ?? []),
					($params["elementos_body"] ?? []),
					($params["sub"] ?? [])
				);
				$params["sub"] = [];
				$params["elementos_body"] = [];
			}

			$params["sub"][0] = self::criar_accordion_header($params_header);
			

			$params["sub"][1] = [
				"tag"=>"div",
				"id"=>str_replace("#","",$params["target"]),
				"class"=>"collapse".($params["aberto"]?" show":""),
				"sub"=>[
					self::criar_accordion_body($params_body)
				]
			];
			unset($params["params_header"]);
			unset($params["params_body"]);
			unset($params["elementos_body"]);
			return $params;
		}

		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo accordion-item (bootstrap)
		 * @created 02/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_accordion(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","accordion");
			$params["itens"] = $params["itens"] ?? [];
			if (isset($params["sub"]) && $params["sub"] !== null && gettype($params["sub"]) === "array" && count($params["sub"]) > 0) {
				$params["itens"] = array_merge(
					($params["itens"] ?? []),
					($params["sub"] ?? []));
				$params["sub"] = [];				
			}
			foreach($params["itens"] as $iten) {
				$params["sub"][] = self::criar_accordion_item($iten);
			}
			unset($params["itens"]);
			return $params;
		}


		/**
		 * Cria/complementa os parametros de criacao de elemento html tipo navs(abas) (bootstrap)
		 * @created 02/01/2021
		 * @lastupdate 02/10/2021
		 * @param {?array} $params - o array de parametros
		 * @return {array} - os parametros criados
		 */
		public static function criar_navs(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","div_container_abas");
			$params["type_navs"] = $params["type_navs"] ?? "tab";		
			$params["navs"] = $params["navs"] ?? [];					
			$contnav = 0;
			switch(strtolower(trim($params["type_navs"]))) {
				case "pill": case "pills":					
					$ul = self::criar_elemento([],"ul","nav nav-pills mb-3");
					$ul["role"] = "tablist";
					$ul["style"] = "display:inline-block !important;white-space: nowrap !important";					
					foreach($params["navs"] as $nav) {						
						$li = self::criar_elemento([],"li","nav-item");
						$li["style"] = "display:inline-block !important";
						$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
						$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
						$navname = 'pills-' . $contnav;						
						$link = [
							"tag"=>"a",
							"class"=>"nav-link ". $active,
							"id" => $navname."-tab",
							"data-bs-toggle"=>"pill",
							"href"=>"#". $navname,
							"role"=>"tab",
							"aria-controls"=>$navname,
							"aria-selected"=>$selected,
							"text"=>(isset($nav["title"])?$nav["title"]:'')
						];						
						$li["sub"][] = $link;
						$ul["sub"][] = $li;
						$contnav++;
					}
					$params["sub"][] = $ul;
					$corpo = self::criar_elemento([],"div","tab-content");
					$corpo["id"] = "pills-tabContent";
					$contnav = 0;
					foreach($params["navs"] as $nav) {
						$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
						$show = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"show":"");
						$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
						$navname = 'pills-' . $contnav;
						$item_corpo = self::criar_elemento([],"div","tab-pane fade ". $show ." ". $active ." " . (isset($nav["class"])?$nav["class"]:""));
						$item_corpo["id"] = $navname;
						$item_corpo["role"] = "tabpanel";
						$item_corpo["aria-labelledby"] = $navname."-tab";
						$item_corpo["text"] = (isset($nav["data"])?$nav["data"]:'');
						$corpo["sub"][] = $item_corpo;
						$contnav++;
					}
					$params["sub"][] = $corpo;
					break;
				default: //case "tab": case "tabs": case "tabbed":
					$nav = self::criar_elemento([],"nav");

					$nav_tabs = self::criar_elemento([],"div","nav nav-tabs");
					$nav_tabs["id"] = "nav-tab";
					$nav_tabs["role"] = "tablist";
					$contnav = 0;
					foreach($params["navs"] as $nav) {
						$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
						$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
						$navname = 'nav-' . $contnav;
						$link = [
							"tag"=>"a",
							"class"=>"nav-item nav-link ". $active,
							"id" => $navname."-tab",
							"data-bs-toggle"=>"tab",
							"href"=>"#". $navname,
							"role"=>"tab",
							"aria-controls"=>$navname,
							"aria-selected"=>$selected,
							"text"=>(isset($nav["title"])?$nav["title"]:'')
						];						
						$nav_tabs["sub"][] = $link;
						$contnav++;
					}
					$nav["sub"][] = $nav_tabs;

					$corpo = self::criar_elemento([],"div","tab-content");
					$corpo["id"] = "nav-tabContent";
					$contnav = 0;
					foreach($params["navs"] as $nav) {
						$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
						$show = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"show":"");
						$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
						$navname = 'nav-' . $contnav;
						$item_corpo = self::criar_elemento([],"div","tab-pane fade ". $show ." ". $active ." " . (isset($nav["class"])?$nav["class"]:""));
						$item_corpo["id"] = $navname;
						$item_corpo["role"] = "tabpanel";
						$item_corpo["aria-labelledby"] = $navname."-tab";
						$item_corpo["text"] = (isset($nav["data"])?$nav["data"]:'');
						$corpo["sub"][] = $item_corpo;
						$contnav++;
					}
					$params["sub"][] = $nav;
					$params["sub"][] = $corpo;
					break;
			}
			unset($params["navs"]);
			return $params;
		}

		/**
		 * cria/complementa o arrya de parametros para criacao de elemento html do tipo master-detail
		 * @created 01/10/2020
		 * @lastupdated 02/10/2021
		 * @param {?array} $params - os parametros para montar o elemento
		 * @return {array} o array criado/complementado
		 */
		public static function criar_estrutura_master_detail(?array $params = []) :array {
			$params = self::criar_elemento($params,"div","row");
			$params["master"] = $params["master"] ?? [];
			$params["detail"] = $params["detail"] ?? [];
			$params["master"]["title"] = $params["master"]["title"] ?? "master";
			$params["master"]["data"] = $params["master"]["data"] ?? "data";
			$params["master"]["cols"] = $params["master"]["cols"] ?? "3";
			$params["detail"]["title"] = $params["detail"]["title"] ?? "detail";
			$params["detail"]["data"] = $params["detail"]["data"] ?? "data";
			$params["sub"][] = self::criar_col([
				"class"=>"col-".$params["master"]["cols"]." m-1 resize ".(isset($params["master"]["class"])?$params["master"]["class"]:''),
				"sub"=>[
					self::criar_card([
						"titulo"=>$params["master"]["title"],
						"sub"=>[
							$params["master"]["data"]
						]	
					])
				]
			]);
			$params["sub"][] = self::criar_col([
				"class"=>"col-".(11 - $params["master"]["cols"])." m-1 resize ".(isset($params["detail"]["class"])?$params["detail"]["class"]:''),
				"sub"=>[
					self::criar_card([
						"titulo"=>$params["detail"]["title"],
						"sub"=>[
							$params["detail"]["data"]
						]
					])
				]
			]);
			unset($params["master"]);
			unset($params["detail"]);
			return $params;
		}


		public static function criar_inputgroup_mes_ano(?array $params = []) : array {
			$params = self::criar_elemento($params,"div","inputgroup input_group_mes_ano");
			$retorno = '';
			$params["mes"] = FuncoesConversao::como_numero($params["mes"] ?? (FuncoesData::mes_atual() - 1));
			$params["ano"] = $params["ano"] ?? FuncoesData::ano_atual();
			$params["sub"][] = self::criar_combobox_meses([
				//"class"=>"form-control",
				"multiplo"=>0,
				"selecionados"=>$params["mes"]
			]);
			$params["sub"][] = [
				"tag"=>"input",
				"class"=>"form-control input_ano",
				"type"=>"number",
				"step"=>1,
				"value"=>$params["ano"]
			];
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

		/**
		 * cria/complementa o array de parametros para criacao de elemento html do tipo opcoes de pesquisa, utilizado em relatorios
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {array} - o array criado/complementado
		 */
		public static function criar_opcoes_pesquisa_padrao(?array $params = []) : array{
			$params = self::criar_elemento($params,"div","div_opcoes_pesquisa_l1 row");

			$itens_accordion = [];

			$params["titulo"] = $params["titulo"] ?? "Opcoes de Pesquisa";
			$params["height"] = $params["height"] ?? "25px";
			$params["retratil"] = $params["retratil"] ?? [];
			$params["retratil"]["ativo"] = $params["retratil"]["ativo"] ?? true;
			$params["retratil"]["status"] = $params["retratil"]["status"] ?? "aberto";
			$params["visoes"] = $params["visoes"] ?? [];
			$params["visoes2"] = $params["visoes2"] ?? [];/*visoes2 eh para relatorios que tem positivacao, geralmente feita por pivot, onde precisa definir visoes das linhas e visoes das colunas*/
			$params["periodos"] = $params["periodos"] ?? [];
			$params["avancado"] = $params["avancado"] ?? [];
			$params["pesquisar"] = $params["pesquisar"] ?? [];		
			$params["visoes"]["ativo"] = $params["visoes"]["ativo"] ?? true;
			$params["visoes2"]["ativo"] = $params["visoes2"]["ativo"] ?? false;
			$params["periodos"]["ativo"] = $params["periodos"]["ativo"] ?? true;						
			$params["avancado"]["ativo"] = $params["avancado"]["ativo"] ?? true;		
			$params["pesquisar"]["ativo"] = $params["pesquisar"]["ativo"] ?? true;	

			/*se houver a opcao de visoes*/
			if ($params["visoes"]["ativo"] === true) {
				$params["visoes"]["titulo"] = $params["visoes"]["titulo"] ?? "Visualizar";
				$params["visoes"]["class"] = $params["visoes"]["class"] ?? "" . " div_visoes";
				$params["visoes"]["permite_incluir"] = $params["visoes"]["permite_incluir"] ?? true;
				$params["visoes"]["permite_excluir"] = $params["visoes"]["permite_excluir"] ?? true;
				$params["visoes"]["itens"] = $params["visoes"]["itens"] ?? [
					[
						"tipo"=>"visao",
						"label"=>"Visao 01",
						"selecionados"=>9,
						"classe_botao"=>self::classe_padrao_botao
					]
				];													
				$params["visoes"]["funcao_inclusao"] = $params["visoes"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
				$params["visoes"]["funcao_exclusao"] = $params["visoes"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						
				$chave = count($itens_accordion);
				$itens_accordion[$chave] = [
					"class" => $params["visoes"]["class"],
					"titulo" => $params["visoes"]["titulo"],
					"props" => ($params["visoes"]["props"] ?? []),
					"target" =>  "#visoes",
					"sub"=>[
						self::criar_row([
							"sub"=>[
								self::criar_cards_combobox_visao($params["visoes"])
							]
						])
					]
				];
				
				
				if ($params["visoes"]["permite_incluir"]) {
					array_unshift($itens_accordion[$chave]["sub"],[
						"tag"=>"img",
						"class"=>"btn_img_add_geral mousehover clicavel rounded",
						"src"=>NomesCaminhosRelativos::sis . "/images/maisverde32.png",
						"onclick"=>$params["visoes"]["funcao_inclusao"],
						"title"=>"Acrescentar um item"
					]);
				}
			}


			/*se houver a opcao de visoes2 (visoes positivadores / como colunas)*/
			if ($params["visoes2"]["ativo"] === true) {
				$params["visoes2"]["titulo"] = $params["visoes2"]["titulo"] ?? "Visualizar";
				$params["visoes2"]["class"] = $params["visoes2"]["class"] ?? "" . " div_visoes2";
				$params["visoes2"]["permite_incluir"] = $params["visoes2"]["permite_incluir"] ?? true;
				$params["visoes2"]["permite_excluir"] = $params["visoes2"]["permite_excluir"] ?? true;
				$params["visoes2"]["itens"] = $params["visoes2"]["itens"] ?? [
					[
						"tipo"=>"visao",
						"label"=>"Visao 01",
						"selecionados"=>9
					]
				];
				$params["visoes2"]["funcao_inclusao"] = $params["visoes2"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
				$params["visoes2"]["funcao_exclusao"] = $params["visoes2"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						

				$chave = count($itens_accordion);
				$itens_accordion[$chave] = [
					"class" => $params["visoes2"]["class"],
					"titulo" => $params["visoes2"]["titulo"],
					"target" =>  "#visoes2",
					"sub"=> [
						self::criar_row([
							"sub"=>[
								self::criar_cards_combobox_visao($params["visoes2"])
							]
						])
					]
				];

				if ($params["visoes2"]["permite_incluir"]) {
					array_unshift($itens_accordion[$chave]["sub"],[
						"tag"=>"img",
						"class"=>"btn_img_add_geral mousehover clicavel rounded",
						"src"=>NomesCaminhosRelativos::sis . "/images/maisverde32.png",
						"onclick"=>$params["visoes2"]["funcao_inclusao"],
						"title"=>"Acrescentar um item"
					]);
				}
			}

			/*se hover periodos*/
			if ($params["periodos"]["ativo"] === true) {
				$params["periodos"]["titulo"] = $params["periodos"]["titulo"] ?? "Periodos";
				$params["periodos"]["tipo"] = $params["periodos"]["tipo"] ?? "periodos";
				$params["periodos"]["class"] = $params["periodos"]["class"] ?? "" . " div_periodos";
				$params["periodos"]["permite_incluir"] = $params["periodos"]["permite_incluir"] ?? true;
				$params["periodos"]["permite_excluir"] = $params["periodos"]["permite_excluir"] ?? true;		
				$params["periodos"]["itens"] = $params["periodos"]["itens"] ?? [
					[
						"tipo"=>"periodo",
						"label"=>"Periodo 01"
					]
				];
				$params["periodos"]["funcao_inclusao"] = $params["periodos"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_periodo_pesquisa({elemento:this})";
				$params["periodos"]["funcao_exclusao"] = $params["periodos"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";

				$chave = count($itens_accordion);
				$itens_accordion[$chave] = [
					"class" => $params["periodos"]["class"],
					"titulo" => $params["periodos"]["titulo"],
					"target" =>  "#periodos",
					"sub"=> [
						self::criar_row([
							"sub"=>[
								self::criar_cards_periodo($params["periodos"])
							]
						])
					]
				];

				if ($params["periodos"]["permite_incluir"]) {
					array_unshift($itens_accordion[$chave]["sub"],[
						"tag"=>"img",
						"class"=>"btn_img_add_geral mousehover clicavel rounded",
						"src"=>NomesCaminhosRelativos::sis . "/images/maisverde32.png",
						"onclick"=>$params["periodos"]["funcao_inclusao"],
						"title"=>"Acrescentar um item"
					]);
				}
			}

			/*se houver avancado*/
			if ($params["avancado"]["ativo"] === true) {	
				$params["avancado"]["titulo"] = $params["avancado"]["titulo"] ?? "Avancado";
				$params["avancado"]["class"] = $params["avancado"]["class"] ?? "avancado div_avancado";
				$params["avancado"]["aberto"] = $params["avancado"]["aberto"] ?? false;
				$params["avancado"]["retratil"] = $params["avancado"]["retratil"] ?? [];
				$params["avancado"]["retratil"]["ativo"] = $params["avancado"]["retratil"]["ativo"] ?? true;
				$params["avancado"]["retratil"]["status"] = $params["avancado"]["retratil"]["status"] ?? "fechado";
				
				$params["avancado"]["ver_vals_de"] = $params["avancado"]["ver_vals_de"] ?? [];
				$params["avancado"]["ver_vals_de"]["ativo"] = $params["avancado"]["ver_vals_de"]["ativo"] ?? true;						
				$params["avancado"]["considerar_vals_de"] = $params["avancado"]["considerar_vals_de"] ?? [];
				$params["avancado"]["considerar_vals_de"]["ativo"] = $params["avancado"]["considerar_vals_de"]["ativo"] ?? true;
				
				
				/*geralmente utilizado em relatorios do tipo positivacao (com sql pivot)*/
				$params["avancado"]["ver_vals_zero"] = $params["avancado"]["ver_vals_zero"] ?? [];
				$params["avancado"]["ver_vals_zero"]["ativo"] = $params["avancado"]["ver_vals_zero"]["ativo"] ?? false;
				$params["avancado"]["condicionantes"] = $params["avancado"]["condicionantes"] ?? [];
				$params["avancado"]["condicionantes"]["ativo"] = $params["avancado"]["condicionantes"]["ativo"] ?? true;
				$params["avancado"]["campos_avulsos"] = $params["avancado"]["campos_avulsos"] ?? [];
				$params["avancado"]["campos_avulsos"]["ativo"] = $params["avancado"]["campos_avulsos"]["ativo"] ?? true;
			

				$itens_accordion_avancado = [];

				/*se houver ver vals de*/
				if ($params["avancado"]["ver_vals_de"]["ativo"] === true) {	
					$chave2 = count($itens_accordion_avancado);
					$itens_accordion_avancado[$chave2] = [
						"class" => "painel_ver_vals_de",
						"titulo" => "Ver Valores de",
						"target" =>  "#painel_ver_vals_de",
						"aberto"=>false,
						"sub"=>[
							self::criar_row([
								"sub"=>[
									self::criar_col()
								]
							])
						]
					];


					$params["avancado"]["ver_vals_de"]["itens"] = $params["avancado"]["ver_vals_de"]["itens"] ?? [
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
						]/*,
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
						]*/,
						[
							"class"=>"checkbox_ver_valores_de",
							"type"=>"checkbox",
							"value"=>10,
							"label"=>"Todos",
							"onchange"=>"window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)"
						]
					];

					foreach($params["avancado"]["ver_vals_de"]["itens"] as $opcao) {														
						$input = [
							"tag"=>"input",
							"type"=>(isset($opcao["type"])?$opcao["type"]:"checkbox"),
							"class"=>(isset($opcao["class"])?$opcao["class"]:""),
							"value"=>(isset($opcao["value"])?$opcao["value"]:(isset($opcao["valor"])?$opcao["valor"]:""))
						];
						if (isset($opcao["name"]) && ($opcao["name"] !== null && strlen(trim($opcao["name"])) > 0)) {
							$input["name"] = $opcao["name"];
						}
						if (isset($opcao["onchange"]) && ($opcao["onchange"] !== null && strlen(trim($opcao["onchange"])) > 0)) { 
							$input["onchange"] = $opcao["onchange"];
						}
						if (isset($opcao["checked"]) && ($opcao["checked"] === true || $opcao["checked"] === "checked")) {
							$input["checked"] = "true";
						}
						$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
							"tag"=>"label",
							"text"=>$opcao["label"],
							"class"=>"rotulo_ver_vals_de width_33pc",
							"textodepois"=>true,
							"sub"=>[
								$input		
							]
						];																		
					}
				}

				/*se houver ver vals zero*/
				if ($params["avancado"]["ver_vals_zero"]["ativo"] === true) {
					$chave2 = count($itens_accordion_avancado);
					$itens_accordion_avancado[$chave2] = [
						"class" => "painel_ver_vals_zero",
						"titulo" => "Ver Valores Zero",
						"target" =>  "#painel_ver_vals_zero",
						"aberto"=>false,
						"sub"=>[
							self::criar_row([
								"sub"=>[
									self::criar_col()
								]
							])
						]
					];
					foreach($params["avancado"]["ver_vals_zero"]["itens"] as $opcao) {														
						$input = [
							"tag"=>"input",
							"type"=>(isset($opcao["type"])?$opcao["type"]:"checkbox"),
							"class"=>(isset($opcao["class"])?$opcao["class"]:""),
							"value"=>(isset($opcao["value"])?$opcao["value"]:(isset($opcao["valor"])?$opcao["valor"]:""))
						];

						if (isset($opcao["name"]) && ($opcao["name"] !== null && strlen(trim($opcao["name"])) > 0)) {
							$input["name"] = $opcao["name"];
						}
						if (isset($opcao["onchange"]) && ($opcao["onchange"] !== null && strlen(trim($opcao["onchange"])) > 0)) { 
							$input["onchange"] = $opcao["onchange"];
						}
						if (isset($opcao["checked"]) && ($opcao["checked"] === true || $opcao["checked"] === "checked")) {
							$input["checked"] = "true";
						}

						$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
							"tag"=>"label",
							"text"=>$opcao["label"],
							"class"=>"rotulo_ver_valores_zero1",
							"textodepois"=>true,
							"sub"=>[
								$input		
							]
						];
					}
				}

				/*se houver considerar vals de*/
				if ($params["avancado"]["considerar_vals_de"]["ativo"] === true) {	
					$chave2 = count($itens_accordion_avancado);
					$itens_accordion_avancado[$chave2] = [
						"class" => "painel_considerar_vals_de",
						"titulo" => "Considerar Valores de",
						"target" =>  "#painel_considerar_vals_de",
						"aberto"=>false,
						"sub"=>[
							self::criar_row([
								"sub"=>[
									self::criar_col()
								]
							])
						]
					];

					$input = [
						"tag"=>"input",
						"type"=>"checkbox",
						"class"=>"checkbox_considerar_valores_de",
						"value"=>0,
						"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)",
						"checked"=>"true"
					];
					$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
						"tag"=>"label",
						"text"=>"Vendas Normais",
						"class"=>"rotulo_considerar_vals_de width_33pc",
						"textodepois"=>true,
						"sub"=>[
							$input		
						]
					];

					$input = [
						"tag"=>"input",
						"type"=>"checkbox",
						"class"=>"checkbox_considerar_valores_de",
						"value"=>1,
						"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)",
						"checked"=>"true"
					];
					$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
						"tag"=>"label",
						"text"=>"Devolucoes Normais",
						"class"=>"rotulo_considerar_vals_de width_33pc",
						"textodepois"=>true,
						"sub"=>[
							$input		
						]
					];

					$input = [
						"tag"=>"input",
						"type"=>"checkbox",
						"class"=>"checkbox_considerar_valores_de",
						"value"=>2,
						"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)",
						"checked"=>"true"
					];
					$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
						"tag"=>"label",
						"text"=>"Devolucoes Avulsas",
						"class"=>"rotulo_considerar_vals_de width_33pc",
						"textodepois"=>true,
						"sub"=>[
							$input		
						]
					];

					$input = [
						"tag"=>"input",
						"type"=>"checkbox",
						"class"=>"checkbox_considerar_valores_de",
						"value"=>3,
						"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)"
					];
					$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
						"tag"=>"label",
						"text"=>"Bonificacoes",
						"class"=>"rotulo_considerar_vals_de width_33pc",
						"textodepois"=>true,
						"sub"=>[
							$input		
						]
					];

					$input = [
						"tag"=>"input",
						"type"=>"checkbox",
						"class"=>"checkbox_considerar_valores_de",
						"value"=>10,
						"onchange"=>"window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)",
						"checked"=>"true"
					];
					$itens_accordion_avancado[$chave2]["sub"][0]["sub"][0]["sub"][] = [
						"tag"=>"label",
						"text"=>"Todos",
						"class"=>"rotulo_considerar_vals_de width_33pc",
						"textodepois"=>true,
						"sub"=>[
							$input		
						]
					];

				}

				/*se houver condicionantes*/
				if ($params["avancado"]["condicionantes"]["ativo"] === true) {	
					$params["avancado"]["condicionantes"]["titulo"] = $params["avancado"]["condicionantes"]["titulo"] ?? "Condicionantes";
					$params["avancado"]["condicionantes"]["class"] = $params["avancado"]["condicionantes"]["class"] ?? "" . " div_condicionantes";
					$params["avancado"]["condicionantes"]["permite_incluir"] = $params["avancado"]["condicionantes"]["permite_incluir"] ?? true;
					$params["avancado"]["condicionantes"]["permite_excluir"] = $params["avancado"]["condicionantes"]["permite_excluir"] ?? true;
					$params["avancado"]["condicionantes"]["itens"] = $params["avancado"]["condicionantes"]["itens"] ?? [];
					$params["avancado"]["condicionantes"]["funcao_inclusao"] = $params["avancado"]["condicionantes"]["funcao_inclusao"] ?? "window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})";
					$params["avancado"]["condicionantes"]["funcao_exclusao"] = $params["avancado"]["condicionantes"]["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";						
					$params["avancado"]["condicionantes"]["funcao_inclusao"] = str_replace('"',"'",$params["avancado"]["condicionantes"]["funcao_inclusao"]);

					$chave2 = count($itens_accordion_avancado);
					$itens_accordion_avancado[$chave2] = [
						"class" => $params["avancado"]["condicionantes"]["class"],
						"titulo" => "Condicionantes",
						"target" =>  "#painel_condicionantes",
						"aberto"=>false,
						"sub"=>[
							self::criar_row([
								"sub"=>[
									self::criar_cards_comboboxs_condicionante($params["avancado"]["condicionantes"])
								]
							])
						]
					];

					if ($params["avancado"]["condicionantes"]["permite_incluir"]) {
						array_unshift($itens_accordion_avancado[$chave2]["sub"],[
							"tag"=>"img",
							"class"=>"btn_img_add_geral mousehover clicavel rounded",
							"src"=>NomesCaminhosRelativos::sis . "/images/maisverde32.png",
							"onclick"=>$params["avancado"]["condicionantes"]["funcao_inclusao"],
							"title"=>"Acrescentar um item"
						]);
					}
				}

				/*se houver campos avulsos*/
				if ($params["avancado"]["campos_avulsos"]["ativo"] === true) {
					$params["avancado"]["campos_avulsos"]["titulo"] = $params["avancado"]["campos_avulsos"]["titulo"] ?? "Campos Avulsos";
					$params["avancado"]["campos_avulsos"]["class"] = $params["avancado"]["campos_avulsos"]["class"] ?? "" . " div_campos_avulsos";
					$params["avancado"]["campos_avulsos"]["permite_incluir"] = false;
					$params["avancado"]["campos_avulsos"]["permite_excluir"] = false;
					$params["avancado"]["campos_avulsos"]["itens"] = [
						[
							"label"=>"Campos Avulsos",
							"tipo"=>"campo_avulso",
							"classe_botao"=>self::classe_padrao_botao
						]
					];


					$chave2 = count($itens_accordion_avancado);
					$itens_accordion_avancado[$chave2] = [
						"class" => $params["avancado"]["campos_avulsos"]["class"],
						"titulo" => "Campos Avulsos",
						"target" =>  "#painel_campos_avulsos",
						"aberto"=>false,
						"sub"=>[
							self::criar_row([
								"sub"=>[
									self::criar_cards_combobox_campo_avulso($params["avancado"]["campos_avulsos"])
								]
							])
						]
					];
				}


				$chave = count($itens_accordion);
				$itens_accordion[$chave] = [
					"class" => $params["avancado"]["class"],
					"titulo" => $params["avancado"]["titulo"],
					"target" =>  "#avancada",
					"aberto" => $params["avancado"]["aberto"],
					"sub"=> [
						self::criar_row([
							"class"=>"div_opcoes_pesquisa_avancada",
							"sub"=>[
								self::criar_col([									
									"class"=>"div_opcoes_pesquisa_avancada_col",
									"sub"=>[
										self::criar_accordion([
											"itens"=>$itens_accordion_avancado
										])
									]
								])
							]
						])
					]
				];
			}
			$div_btn_pesq = null;
			if ($params["pesquisar"]["ativo"] === true ) {
				$params["pesquisar"]["metodo_pesquisar"] = str_replace('"',"'",$params["pesquisar"]["metodo_pesquisar"] ?? "window.fnsisjd.pesquisar_dados(this)");
				$div_btn_pesq = self::criar_elemento($div_btn_pesq,"div","div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3");
				$btn_pesq = self::criar_elemento([
					"tag"=>"button",
					"class"=>"botao_pesquisar btn btn-primary",
					"value"=>"Pesquisar",
					"text"=>"Pesquisar",
					"data-visao"=>$params["pesquisar"]["data-visao"],
					 "onclick"=>$params["pesquisar"]["metodo_pesquisar"]
				]);
				if (isset($params["pesquisar"]["visao"])) {
					$btn_pesq["visao"] = $params["pesquisar"]["visao"];
				}
				if (isset($params["pesquisar"]["codprocesso"])){
					$btn_pesq["codprocesso"] = $params["pesquisar"]["codprocesso"];
				}
				$div_btn_pesq["sub"][] = $btn_pesq;
			}

			$params["sub"][] = [
				self::criar_col([
					"class"=>"div_opcoes_pesquisa m-1",
					"sub"=>[
						self::criar_accordion([
							"itens"=>[
								[
									"titulo"=>$params["titulo"],
									"target"=>"#painel_div_opcoes_pesquisa_corpo",
									"sub"=>[
										self::criar_row([
											"class"=>"div_opcoes_pesquisa_simples",
											"sub" => [
												self::criar_col([
													"class"=>"div_opcoes_pesquisa_simples_col",
													"sub"=>[
														self::criar_accordion([
															"itens"=> $itens_accordion															
														]),
														$div_btn_pesq
													]
												])
											]
										])
									]
								]
							]
						])						
					]
				])
			];
			unset($params["pesquisar"]);
			unset($params["retratil"]);
			unset($params["visoes"]);
			unset($params["visoes2"]);
			unset($params["periodos"]);
			unset($params["avancado"]);		
			
			return $params;
		}

		/**
		 * funcao auxiliar de montar_linhas_tit_tabela_est_html
		 */
		public static function vincular_formatacao_coluna(&$celula,&$opcoes,$ligcamposis){
			$texto_celula = "";
			if (isset($celula["texto"])) {
				$texto_celula = $celula["texto"];
			} else {
				$texto_celula = $celula["valor"];
			}
			$texto_celula = strtolower(trim($texto_celula));
			if (isset($celula["formatacao"])) {
				$opcoes["classes_cels"][$celula["coluna"]] = $celula["formatacao"];						
			} else if (isset($ligcamposis["formatacao"]) && strlen(trim($ligcamposis["formatacao"])) > 0) {
				$opcoes["classes_cels"][$celula["coluna"]] = $ligcamposis["formatacao"];
			} else {		
				if (
					(
						isset($ligcamposis["ignorar_format_aut"]) && !in_array($ligcamposis["ignorar_format_aut"],Constantes::array_verdade)
					) || 
					!isset($ligcamposis["ignorar_format_aut"])
				) {
					if (FuncoesString::str_contem($texto_celula,["valor","vl"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_valor";
					} else if (
						(	
							FuncoesString::str_contem($texto_celula,["peso","observado","objetivo","cota","critica","entregue","ent x crit","falta entregar","realiz"]) 
							|| in_array(trim(strtoupper($texto_celula)),Constantes::meses)
						)
						&& (!FuncoesString::str_contem($texto_celula,["perc","%"]))
					) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_peso";
					} else if (FuncoesString::str_contem($texto_celula,["qt","qtd","qtde","quantid","resultante"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_quant";									
					} else if (FuncoesString::str_contem($texto_celula,["perc_med","%"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_perc_med";							
					} else if (FuncoesString::str_contem($texto_celula,["perc","%"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_perc";								
					} else if (FuncoesString::str_contem($texto_celula,["cod","num"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_numint";
					} else if (FuncoesString::str_contem($texto_celula,["dt","data"])) {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_data";
					} else {
						$opcoes["classes_cels"][$celula["coluna"]] = "cel_texto";
					}						
				} else {
					$opcoes["classes_cels"][$celula["coluna"]] = "cel_texto";
				}
			}
		}

		/**
		 * monta a string html de titulo (thead) de table html
		 * @created 01/01/2017
		 * @param {TComHttp} &$comhttp - o objeto padrao de comunicacao
		 * @return {string} - o html montado
		 */
		public static function montar_linhas_tit_tabela_est_html(&$comhttp,$usar_dados_opcoes,$ignorar_multidimens = false) : string{			
			$opcoes = &$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"];
			$origem_dados = [];
			$colgroups = [];
			$texto_html_titulo = "";
			$celulas_linha_calculos = [];
			$valores_celulas_linhas_calculos = [];
			$texto_html_linha_titulos = "";
			$texto_html_linha_filtros = "";
			$el_ord_tit = null;
			$classe_cel_tit = "cel_tit_campodb";
			$onclick_cel_tit = "";
			$arr_linhas = [];
			$arr_linhas_html = [];
			$texto_html_linhas = [];
			$texto_html_linha = "";
			$img_ocultar_coluna = null;
			$classe_cel_cont = "";
			$texto_total = false;
			$contador = false;
			$codth=0;
			$codthsup=-1;
			$ind_campos_ocultos = [];
			$opcoes["campos_ocultos"] = $opcoes["campos_ocultos"] ?? [];
			$ind_campos_bloqueados = [];
			$opcoes["campos_bloqueados"] = [];
			$celulas_linha_filtros = [];
			$colspanini = 0;
			$cols_ini = 0;
			/*detecta a origem do array de titulos. Os campos SUB e CMD já estão presentes se existirem*/
			if (!$usar_dados_opcoes) {
				$origem_campos = $comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] ;
			} else {
				$origem_campos = $opcoes["dados"]["tabela"]["titulo"]["arr_tit"];				
			}
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]);exit();
			//print_r($origem_campos); exit();
			if (FuncoesObjeto::verif_valor_prop($comhttp->requisicao->requisitar->qual->condicionantes,["opcoes_tabela_est","subregistros","ativo"],true)) {
				if (strcasecmp(trim($origem_campos[array_keys($origem_campos)[0]]["texto"] ?? array_keys($origem_campos)[0] ?? ""),"sub") != 0) {
					$origem_campos = array("SUB"=>["texto"=>"SUB"]) + $origem_campos;					
				}
			}
			if (FuncoesObjeto::verif_valor_prop($comhttp->requisicao->requisitar->qual->condicionantes,["opcoes_tabela_est","corpo","linhas","comandos","ativo"],true)) {					
				$origem_campos["CMD"] = ["texto"=>"CMD"];
			}				
			//print_r($origem_campos); exit();
			if (!$ignorar_multidimens) {
				FuncoesArray::transf_array_em_sub($origem_campos);
				$origem_campos = $origem_campos[FuncoesArray::$keysub];
				//print_r($origem_campos); exit();
				/*variavel usada para determinar o rowspan*/
				$profun = 1;
				$profun += FuncoesArray::obter_profundidade_array_tit($origem_campos); 
				//echo $profun;
				//exit();
				$arr_tit_unidimen = [];
				$cod = -1;
				FuncoesArray::transf_arrmultdimens_arrunidimens_tit2($origem_campos,$arr_tit_unidimen,$cod,$profun) ;				
				//print_r($arr_tit_unidimen); exit();
				$origem_campos = $arr_tit_unidimen;
			}
			//print_r($origem_campos); exit();



			/*criar os registros de celulas filtro e calculo caso haja a coluna SUB*/
			if (FuncoesArray::verif_valor_chave($opcoes,["subregistros","ativo"],true) === true) {
				$cols_ini ++;		
				array_unshift($celulas_linha_filtros,self::montar_elemento_html(self::criar_elemento([
					"tag"=>"th",
					"class"=>"cel_sub_tit_filtro"
				])));
				array_unshift($celulas_linha_calculos,self::criar_elemento([
					"tag"=>"th",
					"class"=>"cel_sub_rod"
				]));
				array_unshift($valores_celulas_linhas_calculos,"");
				array_unshift($colgroups,self::montar_elemento_html(self::criar_elemento([
					"tag"=>"col",
					"class"=>"cel_sub"
				])));
			}

			if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho"],0,"quantidade","maior") === true) {
				if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ativo"]) === true) {
					/*cria o txto inicial do cabecalho*/
					$thead = self::criar_elemento([],"thead");
					/*inicio montagem da linha de botoes de comandos*/
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["comandos","ativo"],true)) {							
						$classe_botao = "";
						$classe_imgs = "";
						if (isset($opcoes["cabecalho"]["comandos"]["classe_botoes"])) {
							$classe_botao = $opcoes["cabecalho"]["comandos"]["classe_botoes"];
						}
						if (isset($opcoes["cabecalho"]["comandos"]["classe_imgs"])) {
							$classe_imgs = $opcoes["cabecalho"]["comandos"]["classe_imgs"];
						}				
						$tr_comandos = self::criar_elemento([
							"tag"=>"tr",
							"class"=>"linhacomandos"
						]);
						$th_comandos = self::criar_elemento([
							"tag"=>"th",
							"class"=>"col_comandos",
							"colspan"=>"999",
							"style"=>"background-color:black;text-align:left;padding:2px;"
						]);
						if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["comandos"],0,"quantidade","maior")) {
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["inclusao","ativo"],true)) {
								$th_comandos["sub"][] = self::criar_elemento([
									"tag"=>"button",
									"class"=>"btncomandos item_destaque_hover btn btn-secondary ".$classe_botao,
									"onclick"=>"window.fnhtml.fntabdados.acrescentar_registro(this)",
									"title"=>"Acrescentar",
									"text"=>"Acrescentar",
									"textodepois"=>true,
									"sub"=>[
										[
											"tag"=>"img",
											"class"=>"imgbtncomandos ".$classe_imgs,
											"src"=>NomesCaminhosRelativos::sjd . "/images/maisverde32.png"
										]
									]
								]);
							}		
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["exportacao","ativo"],true)) {			
								$th_comandos["sub"][] = self::criar_elemento([
									"tag"=>"button",
									"class"=>"btncomandos item_destaque_hover btn btn-secondary ".$classe_botao,
									"onclick"=>"window.fnhtml.fntabdados.exportar_dados(this)",
									"title"=>"Exportar",
									"text"=>"Exportar",
									"textodepois"=>true,
									"sub"=>[
										[
											"tag"=>"img",
											"class"=>"imgbtncomandos ".$classe_imgs,
											"src"=>NomesCaminhosRelativos::sjd . "/images/exportar1_32.png"
										]
									]
								]);	
							}
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["compartilhar","ativo"],true)) {			
								$th_comandos["sub"][] = self::criar_elemento([
									"tag"=>"button",
									"class"=>"btncomandos item_destaque_hover btn btn-secondary ".$classe_botao,
									"onclick"=>"window.fnhtml.fntabdados.compartilhar_dados(event,this)",
									"title"=>"Compartilhar esta tabela",
									"text"=>"Compartilhar",
									"textodepois"=>true,
									"sub"=>[
										[
											"tag"=>"img",
											"class"=>"imgbtncomandos ".$classe_imgs,
											"src"=>NomesCaminhosRelativos::sjd . "/images/tabela_est/compartilhar.png"
										]
									]
								]);	
							}
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["outroscomandos"],0,"quantidade","maior") === true) {
								foreach($opcoes["cabecalho"]["comandos"]["outroscomandos"] as $outrocomando) {
									$th_comandos["sub"][] = self::criar_elemento([
										"tag"=>"button",
										"class"=>"btncomandos item_destaque_hover btn btn-secondary ".$classe_botao,
										"onclick"=>$outrocomando["onclick"],
										"title"=>$outrocomando["title"],
										"text"=>$outrocomando["texto"],
										"textodepois"=>true,
										"sub"=>[
											[
												"tag"=>"img",
												"class"=>"imgbtncomandos ".$classe_imgs,
												"src"=>$outrocomando["imagem"]
											]
										]
									]);		
								}
							}
						}
						$tr_comandos["sub"][] = $th_comandos;
						$thead["sub"][] = $tr_comandos;
					}
					/*fim montagem da linha de botoes de comandos*/

					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["linhas_adicionais"],0,"contagem","maior")===true) {			
						$thead["sub"][] = implode('',$opcoes["cabecalho"]["linhas_adicionais"]);
					}
					if (!isset($opcoes["campos_visiveis"])) {
						$opcoes["campos_visiveis"] = ["todos"];
					}
					if (gettype($opcoes["campos_visiveis"]) !== "array") {
						$opcoes["campos_visiveis"] = explode(",",$opcoes["campos_visiveis"]);
					}
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ordenacao","ativo"],true)) {
						$el_ord_tit = self::criar_elemento([
							"tag"=>"img",
							"class"=>"imgord item_destaque50pct_hover",
							"src"=>NomesCaminhosRelativos::sjd . "/images/green-unsorted.gif"
						]);
						$classe_cel_tit .= " clicavel";
						$onclick_cel_tit = "window.fnhtml.fntabdados.ordenar_tabdados(event,this)";
					}
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ocultarcolunas","ativo"],true)) {
						$img_ocultar_coluna = self::criar_elemento([
							"tag"=>"img",
							"class"=>"img_ocultar_col item_destaque50pct_hover",
							"src"=>NomesCaminhosRelativos::sjd."/images/esconder.png",
							"onclick"=>"window.fnhtml.fntabdados.ocultar_coluna(event,this)",
							"style"=>"width:16px;",
							"title"=>"Ocultar esta coluna"
						]);
					}
					$tem_processo_estruturado = FuncoesConversao::como_boleano(isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"])?true:false);

					/*separa os campos conforme a indicacao da linha*/
					$arr_linhas = [];

					/*corrige o colspan superior se houver celula invisivel como sub com sup com colspan > 1*/
					$origem_campos_temp = $origem_campos;
					$ligcamposis = [];
					//print_r($origem_campos);exit();
					foreach($origem_campos as $campo) {						
						if($tem_processo_estruturado === true && isset($campo["codligcamposis"])) {
							$ligcamposis = $comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["ligscamposis"][$campo["codligcamposis"]];							
						}
						if ($ligcamposis !== null && isset($ligcamposis["visivel"]) && $ligcamposis["visivel"] == 0) {
							$cod_campo_sup = $campo["codsup"] ?? -1;
							while($cod_campo_sup > -1) {
								foreach($origem_campos_temp as $chave=>$campo_temp) {
									if ($campo_temp["cod"] == $cod_campo_sup) {										
										$cod_campo_sup = $campo_temp["codsup"] ?? -1;
										if (isset($campo_temp["colspan"]) && $campo_temp["colspan"] > 1) {
											$origem_campos[$chave]["colspan"]--;
										}
										break;
									}
								}
							}
						}
					}

					/*monta o array unidimensional e linhas conforme o $el["linha"]*/
					//print_r($origem_campos); exit()
					foreach($origem_campos as $campo) {
						if (!isset($arr_linhas[$campo["linha"]])) {
							$arr_linhas[$campo["linha"]] = [];
						}
						if (isset($arr_linhas[$campo["linha"]][$campo["coluna"]])) {
							$nova_chave = $campo["coluna"] . "_";
							$cont = 0;
							while (isset($arr_linhas[$campo["linha"]][$nova_chave.$cont])) {
								$cont++;
							}
							$arr_linhas[$campo["linha"]][$nova_chave.$cont] = $campo;
						} else {
							$arr_linhas[$campo["linha"]][$campo["coluna"]] = $campo;
						}
					}
					//print_r($origem_campos);
					//print_r($arr_linhas); exit();
					$texto_html_linhas = [];
					$rowspan_cels_ini = 0;
					$sub_atribuido = false;
					$texto_html_linha = "";
					$prim_chave_lin = null;
					$ult_chave_lin = null;
					$arr_linhas_html = [];					
					/*encontra a chave da ultima linha (linhatitulos)*/
					//print_r($arr_linhas); exit();
					//var_dump($tem_processo_estruturado);exit();
					foreach($arr_linhas as $chave_lin => &$linha) {
						if (!isset($prim_chave_lin)) {
							$prim_chave_lin = $chave_lin;
						}
						$ult_chave_lin = $chave_lin;
					}
					foreach($arr_linhas as $chave_lin => &$linha) {
						$arr_linhas_html[$chave_lin] = [];
						foreach($linha as $chave_cel => &$celula) {					
							$texto_celula = "";
							if (isset($celula["texto"])) {
								$texto_celula = $celula["texto"];
							} else {
								$texto_celula = $celula["valor"];
							}
							if (($chave_lin === $ult_chave_lin || $chave_lin + (isset($celula["rowspan"])?($celula["rowspan"]>1?$celula["rowspan"]:0):0) >= $ult_chave_lin) 
								&& strcasecmp(trim($texto_celula),"sub") != 0 && strcasecmp(trim($texto_celula),"cmd") != 0) {
								/*checagem previni quando os campos sub e cmd vem na mesma linha dos titulos (ult_chave_lin)*/
								$ligcamposis = [];
								//print_r($celula); exit();
								if($tem_processo_estruturado === true && isset($celula["codligcamposis"])) {
									$ligcamposis = $comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["ligscamposis"][$celula["codligcamposis"]];									
									//print_r($ligcamposis); exit();
								}					
								$opcoes["classes_cels"][$celula["coluna"]] = "";
								self::vincular_formatacao_coluna($celula,$opcoes,$ligcamposis);
								$propriedades_html = [];
								if (isset($ligcamposis["propriedades_html"])) {
									if (strlen(trim($ligcamposis["propriedades_html"])) > 0) {
										$ligcamposis["propriedades_html"] = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($ligcamposis["propriedades_html"])));
										foreach ($ligcamposis["propriedades_html"] as &$prop) {
											$prop = explode("=",$prop);
											$prop["propriedade"] = $prop[0];
											$prop["valor"] = $prop[1];
											unset($prop[0]);
											unset($prop[1]);
											if (strcasecmp(trim($prop["propriedade"]),"class") == 0) {
												$opcoes["classes_cels"][$celula["coluna"]] .= ' ' . $prop["valor"] . ' ';
											} else {
												$propriedades_html[$prop["propriedade"]] = ' ' . $prop["propriedade"] . '="' . $prop["valor"] . '" ';
											}
										}
									}
								}
								$classe_nao_mostrar = " ";
								$classe_bloqueio = " ";
								$cnj_nomes_campos_db = [];
								$visivel = 1;
								$visivel_inclusao = 1;
								if (isset($opcoes["campos_ocultos"])) {
									if (in_array(strtolower(trim($texto_celula)),explode(",",strtolower(trim(implode(",",$opcoes["campos_ocultos"])))))) {
										$classe_nao_mostrar = " naomostrar ";
										$ind_campos_ocultos[] = $celula["coluna"] - $cols_ini;
										$visivel=0;
									}
								}
								if (isset($opcoes["campos_visiveis"]) && count($opcoes["campos_visiveis"]) > 0) {
									if (strcasecmp(trim($opcoes["campos_visiveis"][0]),"todos") != 0) {
										if (!in_array(strtolower(trim($texto_celula)),explode(",",strtolower(trim(implode(",",$opcoes["campos_ocultos"])))))) {
											$classe_nao_mostrar = " naomostrar ";
											$ind_campos_ocultos[] = $celula["coluna"] - $cols_ini;
											$visivel=0;
										}
									}
								}
								if (isset($opcoes["campos_bloqueados"])) {
									if (in_array(strtolower(trim($texto_celula)),explode(",",strtolower(trim(implode(",",$opcoes["campos_bloqueados"])))))) {
										$classe_bloqueio = " bloqueado ";
										$ind_campos_bloqueados[] = $celula["coluna"] - $cols_ini;
									}
								}
								$cnj_nomes_campos_db = [];
								$visivel_inclusao = (isset($ligcamposis["visivel_inclusao"])?$ligcamposis["visivel_inclusao"]:1);
								if (isset($ligcamposis["cnj_nomes_campos_db"])) {
									$cnj_nomes_campos_db = $ligcamposis["cnj_nomes_campos_db"];
								}
								if (isset($ligcamposis["visivel"]) && $ligcamposis["visivel"] == 0) {
									//pritn_r($ligcamposis);exit();
									$classe_nao_mostrar = " naomostrar ";
									$opcoes["campos_ocultos"][] = strtolower(trim($texto_celula));
									$ind_campos_ocultos[] = $celula["coluna"] - $cols_ini;
									
									
									$visivel=0;
								}
								if (!isset($ligcamposis["bloqueado"])) {
									$ligcamposis["bloqueado"] = 0;
								}
								if (isset($ligcamposis["bloqueado"]) && in_array($ligcamposis["bloqueado"],Constantes::array_verdade)) {
									$classe_bloqueio = " bloqueado ";
									$opcoes["campos_bloqueados"][] = strtolower(trim($texto_celula));
									$ind_campos_bloqueados[] = $celula["coluna"]  - $cols_ini;
								}
								$title = "clique para ordenar";
								if (isset($ligcamposis["codcamposis"])) {
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["camposis"][$ligcamposis["codcamposis"]]["comentario"])) {
										if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["camposis"][$ligcamposis["codcamposis"]]["comentario"]))) {
										 $title .= "\nDescricao: " . $comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["camposis"][$ligcamposis["codcamposis"]]["comentario"];
										}
									}
								}
								$th = self::criar_elemento([
									"tag"=>"th",
									"class"=>$classe_cel_tit. " celula_final_tit " . $classe_nao_mostrar . $classe_bloqueio .$opcoes["classes_cels"][$celula["coluna"]]
								]);
								if(isset($celula["colspan"])) {
									$th["colspan"] = $celula["colspan"];
								}
								if(isset($celula["rowspan"])) {
									$th["rowspan"] = $celula["rowspan"];
								}
								$th["visivel"] = $visivel;
								$th["visivel_inclusao"] = $visivel_inclusao;
								$th["title"] = $title;
								$th["cod"] = $celula["cod"];
								$th["codsup"] = $celula["codsup"];
								$th["data-campodb"] = strtolower($texto_celula) ;
								if (strlen($onclick_cel_tit) > 0) {
									$th["onclick"] = $onclick_cel_tit;
								}
								$th["indexreal"] = (isset($celula["indexreal"])?$celula["indexreal"]:"");
								$th["cnj_nomes_campos_db"] = (isset($cnj_nomes_campos_db) && $cnj_nomes_campos_db!== null?strtolower(implode(",",$cnj_nomes_campos_db)):"");
								$th = array_merge($th,$propriedades_html);
								$div_texto = self::criar_elemento([
									"tag"=>"div",
									"class"=>"div_conteudo_celula_titulo d-flex",
									"sub"=>[
										[
											"tag"=>"text",
											"class"=>"txttit w-auto m-auto",
											"text"=>strtoupper($texto_celula)
										]
									]
								]);
								if ($el_ord_tit !== null && count($el_ord_tit) > 0) {
									$div_texto["sub"][] = $el_ord_tit;
								}

								if ($img_ocultar_coluna !== null && count($img_ocultar_coluna) > 0) {
									$div_texto["sub"][] = $img_ocultar_coluna;
								}
								$th["sub"][] = $div_texto;

								

								
								$arr_linhas_html[$chave_lin][$chave_cel] = 	self::montar_elemento_html($th);
									
								$celulas_linha_filtros[] = self::montar_elemento_html(self::criar_elemento([
									"tag"=>"th",
									"class"=>"cel_tit_filtro " . $classe_nao_mostrar,
									"sub"=>[
										[
											"tag"=>"input",
											"type"=>"text",
											"class"=>"inputfiltro",
											"placeholder"=>"(filtro)",
											"onkeyup"=>"window.fnhtml.fntabdados.filtrar_tabdados(event,this)",
											"title"=>"filtro"
										],[
											"tag"=>"img",
											"class"=>"imglimparfiltro clicavel invisivel",
											"src"=>NomesCaminhosRelativos::sjd . "/images/deletar1_32.png",
											"onclick"=>"window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"
										]
									]
								]));
								$colgroups[] = self::montar_elemento_html(self::criar_elemento([
									"tag"=>"col",
									"class"=>$opcoes["classes_cels"][$celula["coluna"]]
								]));
								$classe_cel_cont = "";
								if (in_array($opcoes["classes_cels"][$celula["coluna"]],["cel_texto","cel_numint","cel_data"])) {	
									if ($texto_total) {
										if ($contador) {
											$valores_celulas_linhas_calculos[$celula["coluna"]] = "";
										} else {								
											$valores_celulas_linhas_calculos[$celula["coluna"]] = 0;
											$opcoes["campo_contador"] = $celula["coluna"];
											$classe_cel_cont = "cel_contadora";
											$contador = true;
										}
									} else {
										$opcoes["campo_totais"] = $celula["coluna"];
										$valores_celulas_linhas_calculos[$celula["coluna"]] = "Totais";
										$texto_total = true;
									}
								} else {
									$valores_celulas_linhas_calculos[$celula["coluna"]] = 0;
								}
								$celulas_linha_calculos[$celula["coluna"]] = self::criar_elemento([
									"tag"=>"th",
									"class"=>"cel_linha_calc ".$classe_nao_mostrar.$opcoes["classes_cels"][$celula["coluna"]]." ".$classe_cel_cont
								]);
							} else {
								if (strcasecmp(trim($texto_celula),"cmd") == 0) {
									$th_cmd = self::criar_elemento([],"th","cel_cmd_tit");
									if (isset($celula["colspan"])) {
										$th_cmd["colspan"] = $celula["colspan"];
									}
									if (isset($celula["rowspan"])) {
										$th_cmd["rowspan"] = $celula["rowspan"];
									}
									if (isset($celula["cod"])) {
										$th_cmd["cod"] = $celula["cod"];
									}
									if (isset($celula["codsup"])) {
										$th_cmd["codsup"] = $celula["codsup"];
									}
									if (isset($celula["indexreal"])) {
										$th_cmd["indexreal"] = $celula["indexreal"];
									}
									$th_cmd["sub"][] = [
										self::criar_elemento([
											"tag"=>"text",
											"class"=>"txttit item_destaque_hover  w-auto m-auto",
											"text"=>strtoupper($texto_celula)
										])
									];
									$arr_linhas_html[$chave_lin][$chave_cel] = 	self::montar_elemento_html($th_cmd);
								} else if (strcasecmp(trim($texto_celula),"sub") == 0) {
									$th_sub = self::criar_elemento([],"th","cel_sub_tit");
									if (isset($celula["colspan"])) {
										$th_sub["colspan"] = $celula["colspan"];
									}
									if (isset($celula["rowspan"])) {
										$th_sub["rowspan"] = $celula["rowspan"];
									}
									if (isset($celula["cod"])) {
										$th_sub["cod"] = $celula["cod"];
									}
									if (isset($celula["codsup"])) {
										$th_sub["codsup"] = $celula["codsup"];
									}
									if (isset($celula["indexreal"])) {
										$th_sub["indexreal"] = $celula["indexreal"];
									}
									$th_sub["sub"][] = [
										self::criar_elemento([
											"tag"=>"text",
											"class"=>"txttit item_destaque_hover  w-auto m-auto",
											"text"=>strtoupper($texto_celula)
										])
									];
									$arr_linhas_html[$chave_lin][$chave_cel] = 	self::montar_elemento_html($th_sub);
								} else {
									$th = self::criar_elemento([],"th",$classe_cel_tit);
									if (isset($celula["colspan"])) {
										$th["colspan"] = $celula["colspan"];
									}
									if (isset($celula["rowspan"])) {
										$th["rowspan"] = $celula["rowspan"];
									}
									if (isset($celula["cod"])) {
										$th["cod"] = $celula["cod"];
									}
									if (isset($celula["codsup"])) {
										$th["codsup"] = $celula["codsup"];
									}
									if (isset($celula["indexreal"])) {
										$th["indexreal"] = $celula["indexreal"];
									}
									$th["sub"][] = [
										self::criar_elemento([
											"tag"=>"text",
											"class"=>"txttit item_destaque_hover  w-auto m-auto",
											"text"=>strtoupper($texto_celula)
										])
									];
									$arr_linhas_html[$chave_lin][$chave_cel] = 	self::montar_elemento_html($th);
								}
							}
						}
					}
					if (count($opcoes["cabecalho"]["celulasextras"]) > 0) {
						foreach($opcoes["cabecalho"]["celulasextras"] as $celextra) {
							if (stripos($celextra,"rowspan") !== false) {
							} else {
								$celextra = str_ireplace('<th ','<th rowspan="' . count($arr_linhas_html) . '" ',$celextra);
							}
							$arr_linhas_html[$ult_chave_lin][] = $celextra;
							$celulas_linha_filtros[] = self::montar_elemento_html(self::criar_elemento([
								"tag"=>"th",
								"class"=>"cel_tit_filtro",
								"sub"=>[
									[
										"tag"=>"input",
										"type"=>"text",
										"class"=>"inputfiltro",
										"placeholder"=>"(filtro)",
										"onkeyup"=>"window.fnhtml.fntabdados.filtrar_tabdados(event,this)",
										"title"=>"filtro"
									],[
										"tag"=>"img",
										"class"=>"imglimparfiltro clicavel invisivel",
										"src"=>NomesCaminhosRelativos::sjd . "/images/deletar1_32.png",
										"onclick"=>"window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"
									]
								]
							]));
							$celulas_linha_calculos[] = self::criar_elemento([],"th");
							$valores_celulas_linhas_calculos[] = 0;
						}
					}
					if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","ativo"],true)) {
						$celulas_linha_filtros[] = self::criar_elemento([],"th","cel_tit_cmd_filtro");
						$celulas_linha_calculos[] = self::criar_elemento([],"th","cel_sub_rod");
						$valores_celulas_linhas_calculos = "";
					}
					if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","filtro","ativo"],true)) {			
						$arr_linhas_html["linhafiltros"] = $celulas_linha_filtros;
					}
					foreach($arr_linhas_html as $chave_lin => &$linha_html) {
						$linha_html = self::criar_elemento([
							"tag"=>"tr",
							"sub"=>$linha_html
						]);
						if ($chave_lin === "linhafiltros") {
							$linha_html["class"] = "linhafiltros";
						} else if ($chave_lin === $ult_chave_lin) {
							$linha_html["class"] = "linhatitulos";							
						} 
						$linha_html = self::montar_elemento_html($linha_html);
					}
					$texto_linhas_titulo = implode('',$arr_linhas_html);
					$thead["sub"][] = $texto_linhas_titulo;
					$texto_html_titulo = self::montar_elemento_html($thead);
				}
				$opcoes["valores_celulas_linhas_calculos"] = $valores_celulas_linhas_calculos;		
				$opcoes["celulas_linha_calculos"] = $celulas_linha_calculos;
				$opcoes["indices_campos_ocultos"] = $ind_campos_ocultos;
				$opcoes["indices_campos_bloqueados"] = $ind_campos_bloqueados;
			}
			$texto_html_titulo = self::montar_elemento_html(self::criar_elemento([
				"tag"=>"colgroup",
				"text"=>implode("",$colgroups)
			])) . $texto_html_titulo;
			return $texto_html_titulo;
		}

		/**
		 * monta a string html do rodape de table html
		 * @created 01/06/2017
		 * @param {TComHttp} - o objeto padrao de comunicacao
		 * @return {string} - a string html montada
		 */
		public static function montar_rodape_tabela_est_html(&$comhttp,$usar_dados_opcoes) : string {
			$opcoes = &$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"];
			$texto_html_rod = '';
			if(FuncoesArray::verif_valor_chave($opcoes,["rodape","ativo"]) === true){
				$tfoot = self::criar_elemento([],"tfoot");
				foreach($opcoes["celulas_linha_calculos"] as $chave=>&$cel_calc) {
					if (strcasecmp(trim($chave),"sub") != 0) {
						if ($opcoes["campo_contador"] === $chave && $opcoes["campo_totais"] !== $chave ) {

						} else if ((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"") === "") {

						} else if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_quant","cel_valor","cel_peso","cel_perc","cel_perc_med","cel_quantdec_med"]) && $opcoes["campo_totais"] !== $chave) {			
							if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_perc_med","cel_quantdec_med"])) {
								if ($opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]] === 0) {							
									$opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]] = 1;
								}
								$opcoes["celulas_linha_calculos"][$chave]["text"] = number_format($opcoes["valores_celulas_linhas_calculos"][$chave] / $opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]],2,",",".");			
							} else {
								if (isset($opcoes["valores_celulas_linhas_calculos"][$chave])) {
									$opcoes["celulas_linha_calculos"][$chave]["text"] = number_format($opcoes["valores_celulas_linhas_calculos"][$chave],2,",",".");			
								}
							}
						} else if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_quantdec"]) && $opcoes["campo_totais"] !== $chave) {
							$qtdec = (strpos($opcoes["valores_celulas_linhas_calculos"][$chave],".") !== false?strlen($opcoes["valores_celulas_linhas_calculos"][$chave]) - strpos($opcoes["valores_celulas_linhas_calculos"][$chave],".") - 1:0);
							$opcoes["celulas_linha_calculos"][$chave]["text"] = number_format($opcoes["valores_celulas_linhas_calculos"][$chave],0,",",".");			
						} else {
							//print_r($opcoes["celulas_linha_calculos"]);
							$opcoes["celulas_linha_calculos"][$chave]["text"] = (isset($opcoes["valores_celulas_linhas_calculos"][$chave])?$opcoes["valores_celulas_linhas_calculos"][$chave]:'');			
						}
					}
				}
				$tfoot["sub"][] = self::criar_elemento([
					"tag"=>"tr",
					"class"=>"linhacalculos linhatotais",
					"sub"=>$opcoes["celulas_linha_calculos"]
				]);
				if (count($opcoes["rodape"]["linhasextras"]) > 0) {
					$tfoot["sub"][] = implode('',$opcoes["rodape"]["linhasextras"]);
				}
				$texto_html_rod = self::montar_elemento_html($tfoot);
			}
			return $texto_html_rod;
		}


		/**
		 * montar um json com as propriedades (html) a serem interpretadas pelo lado cliente
		 * @created 21/07/2021
		 * @param {object} $comhttp - o objeto comhttp padrao
		 * @param {bool} usar_dados_opcoes
		 */
		public static function montar_propriedades_tabdados(object &$comhttp,?bool $usar_dados_opcoes = false) : array{
			$json_props = json_decode('{"props":[]}');
			$json_prop = null;


			$opcoes = &$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"];

			/*propriedade html class*/
			$idrandom = mt_rand();
			$class_random='_'.$idrandom;			
			if (FuncoesArray::verif_valor_chave($opcoes,["propriedades_html","class"],0,"tamanho","maior") === true) {
				$class_random .= ' ' . $opcoes["propriedades_html"]["class"];
			}
			$json_prop = json_decode('{"prop":"class","value":"' . $class_random . '"}');
			$json_props->props[] = $json_prop;

			/*data-id_opcoes */
			$json_prop = json_decode('{"prop":"data-id_opcoes","value":"' . $idrandom . '"}');
			$json_props->props[] = $json_prop;

			/*data-opcoes */
			$json_prop = json_decode('{"prop":"data-opcoes","value":"' . str_replace(" ","&nbsp;",htmlspecialchars(str_replace('"',"__ASPD__",json_encode($opcoes)),ENT_QUOTES, 'UTF-8')) . '"}');
			$json_props->props[] = $json_prop;

			/*tabeladb */
			if (isset($opcoes["tabeladb"])) {
				$json_prop = json_decode('{"prop":"tabeladb","value":"' . $opcoes["tabeladb"] . '"}');
				$json_props->props[] = $json_prop;
			}

			/*codprocesso */
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"])) {
				$json_prop = json_decode('{"prop":"codprocesso","value":"' . $comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"] . '"}');
				$json_props->props[] = $json_prop;
			}

			/*condicionantestab */
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"])) {
				if (gettype($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) === "array") {
					$json_prop = json_decode('{"prop":"condicionantestab","value":"' . implode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) . '"}');
					$json_props->props[] = $json_prop;
				} else {
					$json_prop = json_decode('{"prop":"condicionantestab","value":"' . $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] . '"}');
					$json_props->props[] = $json_prop;
				}
			}	

			/*mantercombobox */
			if (isset($opcoes["mantercombobox"])) {
				$json_prop = json_decode('{"prop":"mantercombobox","value":"' . ((bool)$opcoes["mantercombobox"]?"true":"false") . '"}');
				$json_props->props[] = $json_prop;
			}
			
			/*campos_chaves_primaria */
			if (!isset($opcoes["campos_chaves_primaria"])) {		
				$opcoes["campos_chaves_primaria"]=FuncoesSql::getInstancia()->obter_campos_tabela($opcoes["tabeladb"]??"","primary");
				if (gettype($opcoes["campos_chaves_primaria"]) !== "array") {
					if ($opcoes["campos_chaves_primaria"] === null) {
						$opcoes["campos_chaves_primaria"] = "";
					}
					$opcoes["campos_chaves_primaria"] = explode(",",$opcoes["campos_chaves_primaria"]);
				}
				$json_prop = json_decode('{"prop":"campos_chaves_primaria","value":"' . strtolower(implode(",",$opcoes["campos_chaves_primaria"])) . '"}');
				$json_props->props[] = $json_prop;
			} else {				
				if (gettype($opcoes["campos_chaves_primaria"]) !== "array") {
					if ($opcoes["campos_chaves_primaria"] === null) {
						$opcoes["campos_chaves_primaria"] = "";
					}
					$opcoes["campos_chaves_primaria"] = explode(",",$opcoes["campos_chaves_primaria"]);
				}
				if (count($opcoes["campos_chaves_primaria"]) === 0) {					
					$opcoes["campos_chaves_primaria"]=FuncoesSql::getInstancia()->obter_campos_tabela($opcoes["tabeladb"],"primary"); 
					if (gettype($opcoes["campos_chaves_primaria"]) !== "array") {
						if ($opcoes["campos_chaves_primaria"] === null) {
							$opcoes["campos_chaves_primaria"] = "";
						}
						$opcoes["campos_chaves_primaria"] = explode(",",$opcoes["campos_chaves_primaria"]);
					}		
				} else {
					if (gettype($opcoes["campos_chaves_primaria"]) !== "array") {
						if ($opcoes["campos_chaves_primaria"] === null) {
							$opcoes["campos_chaves_primaria"] = "";
						}
						$opcoes["campos_chaves_primaria"] = explode(",",$opcoes["campos_chaves_primaria"]);
					}				
				}
				$json_prop = json_decode('{"prop":"campos_chaves_primaria","value":"' . strtolower(implode(",",$opcoes["campos_chaves_primaria"])) . '"}');
				$json_props->props[] = $json_prop;
			}

			/*campos_chaves_unica */
			if (!isset($opcoes["campos_chaves_unica"])) {		
				$opcoes["campos_chaves_unica"]=FuncoesSql::getInstancia()->obter_campos_tabela($opcoes["tabeladb"]??"","unique"); 				
				if (gettype($opcoes["campos_chaves_unica"]) !== "array") {
					if ($opcoes["campos_chaves_unica"] === null) {
						$opcoes["campos_chaves_unica"] = "";
					}
					$opcoes["campos_chaves_unica"] = explode(",",$opcoes["campos_chaves_unica"]);
				}
				$json_prop = json_decode('{"prop":"campos_chaves_unica","value":"' . strtolower(implode(",",$opcoes["campos_chaves_unica"])) . '"}');
				$json_props->props[] = $json_prop;
			} else {				
				if (gettype($opcoes["campos_chaves_unica"]) !== "array") {
					if ($opcoes["campos_chaves_unica"] === null) {
						$opcoes["campos_chaves_unica"] = "";
					}
					$opcoes["campos_chaves_unica"] = explode(",",$opcoes["campos_chaves_unica"]);
				}
				if (count($opcoes["campos_chaves_unica"]) === 0) {					
					$opcoes["campos_chaves_unica"]=FuncoesSql::getInstancia()->obter_campos_tabela($opcoes["tabeladb"]??"","unique"); 
					if (gettype($opcoes["campos_chaves_unica"]) !== "array") {
						if ($opcoes["campos_chaves_unica"] === null) {
							$opcoes["campos_chaves_unica"] = "";
						}
						$opcoes["campos_chaves_unica"] = explode(",",$opcoes["campos_chaves_unica"]);
					}		
				} else {
					if (gettype($opcoes["campos_chaves_unica"]) !== "array") {
						if ($opcoes["campos_chaves_unica"] === null) {
							$opcoes["campos_chaves_unica"] = "";
						}
						$opcoes["campos_chaves_unica"] = explode(",",$opcoes["campos_chaves_unica"]);
					}				
				}
				$json_prop = json_decode('{"prop":"campos_chaves_unica","value":"' . strtolower(implode(",",$opcoes["campos_chaves_unica"])) . '"}');
				$json_props->props[] = $json_prop;
			}

			/*campos_bloqueados */
			if (isset($opcoes["campos_bloqueados"])) {
				$json_prop = json_decode('{"prop":"campos_visiveis","value":"' . strtolower(implode(",",$opcoes["campos_bloqueados"])) . '"}');
				$json_props->props[] = $json_prop;
			}

			/*campos_visiveis */
			if (isset($opcoes["campos_visiveis"])) {
				$json_prop = json_decode('{"prop":"campos_visiveis","value":"' . strtolower(implode(",",$opcoes["campos_visiveis"])) . '"}');
				$json_props->props[] = $json_prop;
			}

			/*selecao */
			if (isset($opcoes["selecao"])) {
				if (isset($opcoes["selecao"]["ativo"])) {
					if ($opcoes["selecao"]["ativo"] === true) {
						$json_prop = json_decode('{"prop":"selecao_ativada","value":"true"}');						
						$json_props->props[] = $json_prop;
						if(FuncoesArray::verif_valor_chave($opcoes,["selecao","selecao_tipo"],0,"contagem","maior")) {
							$json_prop = json_decode('{"prop":"selecao_tipo","value":"' . $opcoes["selecao"]["selecao_tipo"] . '"}');
							$json_props->props[] = $json_prop;
						}
						if(FuncoesArray::verif_valor_chave($opcoes,["selecao","multiplo"],null,"setado")===true) {
							if ($opcoes["selecao"]["multiplo"] === true) {						
								$json_prop = json_decode('{"prop":"selecao_multiplo","value":"true"}');
								$json_props->props[] = $json_prop;
							} elseif ($opcoes["selecao"]["multiplo"] === false){
								$json_prop = json_decode('{"prop":"selecao_multiplo","value":"false"}');
								$json_props->props[] = $json_prop;
							} else {
								$json_prop = json_decode('{"prop":"selecao_multiplo","value":"' . $opcoes["selecao"]["multiplo"] . '"}');
								$json_props->props[] = $json_prop;
							}
						}
						if(FuncoesArray::verif_valor_chave($opcoes,["selecao","selecionar_pela_linha"],true)===true) {
							$json_prop = json_decode('{"prop":"selecionar_pela_linha","value":"' . $opcoes["selecao"]["selecionar_pela_linha"] . '"}');
							$json_props->props[] = $json_prop;
						} else {
							if (FuncoesArray::verif_valor_chave($opcoes,["selecao","selecionar_pela_linha"],false)===true) {
								$json_prop = json_decode('{"prop":"selecionar_pela_linha","value":"' . $opcoes["selecao"]["selecionar_pela_linha"] . '"}');
								$json_props->props[] = $json_prop;
							} else {
								$json_prop = json_decode('{"prop":"selecionar_pela_linha","value":"true"}');
								$json_props->props[] = $json_prop;
							}
						}
					}
				}
			}

			/*subregistros */
			if (isset($opcoes["subregistros"])) {
				$json_prop = json_decode('{"prop":"subregistros","value":"' . FuncoesConversao::como_boleano($opcoes["subregistros"]["ativo"],"string") . '"}');
				$json_props->props[] = $json_prop;
				if (isset($opcoes["subregistros"]["aoabrir"])) {
					$json_prop = json_decode('{"prop":"aoabrir","value":"' . $opcoes["subregistros"]["aoabrir"] . '"}');
					$json_props->props[] = $json_prop;
				}
				if (isset($opcoes["subregistros"]["campo_subregistro"])) {
					$json_prop = json_decode('{"prop":"campo_subregistro","value":"' . $opcoes["subregistros"]["campo_subregistro"] . '"}');
					$json_props->props[] = $json_prop;
				}
				if (isset($opcoes["subregistros"]["campo_subregistro_pai"])) {
					$json_prop = json_decode('{"prop":"campo_subregistro_pai","value":"' . $opcoes["subregistros"]["campo_subregistro_pai"] . '"}');
					$json_props->props[] = $json_prop;
				}	
				if (isset($opcoes["subregistros"]["linhasubpreexistente"])) {
					$json_prop = json_decode('{"prop":"linhasubpreexistente","value":"' . $opcoes["subregistros"]["linhasubpreexistente"] . '"}');
					$json_props->props[] = $json_prop;
				}		
				$condtemp = [];
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
					$condtemp = explode(strtolower(trim(Constantes::sepn1)) , strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])));
					$condtemp = FuncoesArray::chaves_associativas($condtemp);
				}
				if (isset($condtemp[strtolower(trim($opcoes["subregistros"]["campo_subregistro_pai"]))])) {
					$json_prop = json_decode('{"prop":"'.$opcoes["subregistros"]["campo_subregistro_pai"].'","value":"' . $condtemp[strtolower(trim($opcoes["subregistros"]["campo_subregistro_pai"]))] . '"}');
					$json_props->props[] = $json_prop;
				}
			}

			/*edicao */
			if(FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","edicao","ativo"],true)){
				$json_prop = json_decode('{"prop":"edicao_ativa","value":"true"}');
				$json_props->props[] = $json_prop;
				if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","edicao","funcao_edicao"],0,"tamanho","maior") === true) {
					$json_prop = json_decode('{"prop":"funcao_edicao","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["edicao"]["funcao_edicao"] . '"}');
					$json_props->props[] = $json_prop;
				}
				if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","edicao","aposabriredicaocelula"],0,"tamanho","maior") === true) {
					$json_prop = json_decode('{"prop":"aposabriredicaocelula","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["edicao"]["aposabriredicaocelula"] . '"}');
					$json_props->props[] = $json_prop;
				}
				if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","edicao","aposabriredicaolinha"],0,"tamanho","maior") === true) {
					$json_prop = json_decode('{"prop":"aposabriredicaolinha","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["edicao"]["aposabriredicaolinha"] . '"}');
					$json_props->props[] = $json_prop;
				}
			}

			/*salvar*/
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","salvar","aosalvarnovalinha"],0,"tamanho","maior")) {
				$json_prop = json_decode('{"prop":"aosalvarnovalinha","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] . '"}');
				$json_props->props[] = $json_prop;
			}
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","salvar","aosalvaredicaolinha"],0,"tamanho","maior")) {
				$json_prop = json_decode('{"prop":"aosalvaredicaolinha","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] . '"}');
				$json_props->props[] = $json_prop;
			}
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","salvar","aosalvaredicaocelula"],0,"tamanho","maior")) {
				$json_prop = json_decode('{"prop":"aosalvaredicaocelula","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaocelula"] . '"}');
				$json_props->props[] = $json_prop;
			}

			/*copiar*/
			if(FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","copiar","ativo"],true)){
				$json_prop = json_decode('{"prop":"copiar_ativa","value":"true"}');
				$json_props->props[] = $json_prop;
				if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","copiar","aocopiar"],0,"tamanho","maior")) {		
					$json_prop = json_decode('{"prop":"aocopiar","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["copiar"]["aocopiar"] . '"}');
					$json_props->props[] = $json_prop;
				}
			}

			/*exclusao */
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","exclusao","ativo"])) {
				$json_prop = json_decode('{"prop":"exclusao_ativa","value":"true"}');
				$json_props->props[] = $json_prop;
				if (isset($opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"])) {
					$json_prop = json_decode('{"prop":"aoexcluirlinha","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] . '"}');
					$json_props->props[] = $json_prop;
				}
				if (isset($opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aposexcluirlinha"])) {
					$json_prop = json_decode('{"prop":"aposexcluirlinha","value":"' . $opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aposexcluirlinha"] . '"}');
					$json_props->props[] = $json_prop;
				}
			}

			/*aoclicar */
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","aoclicar"],0,"tamanho","maior")) {
				$json_prop = json_decode('{"prop":"aoclicarlinha","value":"' . $opcoes["corpo"]["linhas"]["aoclicar"] . '"}');
				$json_props->props[] = $json_prop;
			}

			/*aoduploclicar */
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","aoduploclicar"],0,"tamanho","maior")) {
				$json_prop = json_decode('{"prop":"aoduploclicarlinha","value":"' . $opcoes["corpo"]["linhas"]["aoduploclicar"] . '"}');
				$json_props->props[] = $json_prop;
			}	

			/*marcar */
			if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","marcar"],true) === true) {
				$json_prop = json_decode('{"prop":"marcar","value":"true"}');
				$json_props->props[] = $json_prop;
				$json_prop = json_decode('{"prop":"classemarcacao","value":"' . $opcoes["corpo"]["linhas"]["classemarcacao"] . '"}');
				$json_props->props[] = $json_prop;
				if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","marcarmultiplo"],true) === true) {
					$json_prop = json_decode('{"prop":"marcarmultiplo","value":"true"}');
					$json_props->props[] = $json_prop;
				} else {
					$json_prop = json_decode('{"prop":"marcarmultiplo","value":"false"}');
					$json_props->props[] = $json_prop;
				}
			}

			/*dados requisicao */
			if (!$usar_dados_opcoes) {
				$json_prop = json_decode('{"prop":"classemarcrequisitaracao","value":"' . $comhttp->requisicao->requisitar->oque . '"}');
				$json_props->props[] = $json_prop;
			}
			if (!$usar_dados_opcoes && isset($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"])) {
				$json_prop = json_decode('{"prop":"tipo_dados","value":"' . $comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] . '"}');
				$json_props->props[] = $json_prop;
			}
			if (!$usar_dados_opcoes && isset($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"])) {
				$json_prop = json_decode('{"prop":"especificacao_dados","value":"' . $comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"] . '"}');
				$json_props->props[] = $json_prop;
			}

			/*inclusao */
			if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","comandos","inclusao","ativo"])) {
				$json_prop = json_decode('{"prop":"inclusao_ativa","value":"true"}');
				$json_props->props[] = $json_prop;
				$json_prop = json_decode('{"prop":"aoincluirregistro","value":"' . (gettype($opcoes["aoincluirregistro"]) !== "string"?implode(";",$opcoes["aoincluirregistro"]):$opcoes["aoincluirregistro"]) . '"}');
				$json_props->props[] = $json_prop;
				if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","comandos","inclusao","tipo"],0,"tamanho","maior") === true) {
					if (isset($opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"])) {				
						$json_prop = json_decode('{"prop":"inclusao_tipo","value":"' . $opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"] . '"}');
						$json_props->props[] = $json_prop;
					}
				}
				if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","comandos","inclusao","funcao_inclusao"],0,"tamanho","maior") === true) {
					if (isset($opcoes["cabecalho"]["comandos"]["inclusao"]["funcao_inclusao"])) {				
						$json_prop = json_decode('{"prop":"funcao_inclusao","value":"' . $opcoes["cabecalho"]["comandos"]["inclusao"]["funcao_inclusao"] . '"}');
						$json_props->props[] = $json_prop;
					}
				}
				if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","comandos","inclusao","aosalvarnovoregmodal"],0,"tamanho","maior") === true) {
					if (isset($opcoes["cabecalho"]["comandos"]["inclusao"]["aosalvarnovoregmodal"])) {				
						$json_prop = json_decode('{"prop":"aosalvarnovoregmodal","value":"' . $opcoes["cabecalho"]["comandos"]["inclusao"]["aosalvarnovoregmodal"] . '"}');
						$json_props->props[] = $json_prop;
					}
				}
			}

			/*demais propriedades passadas nas opcoes */
			if (isset($opcoes["propriedades_html"])) {
				$props = [];
				foreach ($opcoes["propriedades_html"] as $chave => $valor) {
					if ($chave !== "class") {
						$json_prop = json_decode('{"prop":"' . $chave . '","value":"' . $valor . '"}');
						$json_props->props[] = $json_prop;
					}
				}
			}
			return $json_props->props;
		}


		public static function preparar_params_comboboxes_condicionante(?array $params=[]) : array {
			$params_retorno = [];
			$params = $params ?? [];
			$html_combobox_condicionantes = "";
			$html_condicionante = "";
			$contcond = 0;
			if (in_array(gettype($params["dados"]),["object","resource"])) {
				$params["dados"] = stream_get_contents($params["dados"]);
			}
			$dados_condicionantes = FuncoesRequisicao::preparar_condicionantes_processo($params["dados"]);
			foreach($dados_condicionantes as $chave_condic=>&$condicionante) {
				$selecionados = [];
				foreach($condicionante as $condic) {
					$selecionados[] = $condic["valor"];
				}
				$forcar_selecao_por_valores = true;
				$params_retorno[] = [
					"visao" => $chave_condic,
					"selecionados"=>$selecionados,
					"forcar_selecao_por_valores"=>$forcar_selecao_por_valores,
					"permite_selecao"=>$params["permite_selecao"]
				];
			}
			return $params_retorno;			
		}


		public static function montar_elemento_html_sisjd(?array $params = []) : string{
			$retorno="";
			switch($params["tipoelemento"]){
				case "comboboxes_condicionante":
					$condicionantes = self::preparar_params_comboboxes_condicionante($params);
					$params = [
						"itens" => $condicionantes
					];
					//ver porque ainda esta permitindo selecao, imrpimir params aqui
					//print_r($params); exit();
					$retorno = self::montar_elemento_html(self::criar_row([
						"sub" => [
							self::criar_cards_comboboxs_condicionante($params)
						]
					]));
					break;						
				case "rotulos_box_editaveis":
					$retorno=self::montar_rotulos_boxs_editaveis($comhttp,$params);
					break;
				case "tabela_est":
					$retorno=[];
					$retorno["conteudo_html"]=self::montar_tabela_est_html($comhttp,$params);
					$retorno["conteudo_javascript"]='
						var tabelaest=$(".'.$comhttp->requisicao->requisitar->qual->condicionantes["classe_random_tabelaest"].'");
						var tabelaestcab=tabelaest.children("thead").find("thead").eq(0);
						var tabelaestcorpo=tabelaest.children("tbody").find("tbody").eq(0);
						var linhas_cab=tabelaestcab.children("tr");
						var numcels=0;
						var numcelslin=0;
						var linhas_corpo=tabelaestcorpo.children("tr:not(.linha_padrao)");				
						var linha_cab_maior_qt_cels={};
						var qt=0;
						var cont=0;
						var tamanho_cel_tit=0;
						var tamanho_cel_corpo=0;
						var cels_lin_tit={};
						var cels_lin_corpo={};
						var cels_lin_padrao=tabelaestcorpo.children("tr.linha_padrao").children("td").not(".cel_sub_registro");
						var tamanho_cel=0;
						var linhas_sub_superiores={};
						var tamanho_linha=0;
						qt=linhas_cab.length;
						for(cont=0; cont<qt; cont++){
							numcelslin=linhas_cab.eq(cont).children("th").length;
							if(numcelslin>numcels){
								numcels=numcelslin;
								linha_cab_maior_qt_cels=linhas_cab.eq(cont);
							}
						}
						cels_lin_tit=linha_cab_maior_qt_cels.children("th");
						cels_lin_corpo=linhas_corpo.children("td").not(".cel_sub_registro");
						qt=cels_lin_tit.length;
						cont=1;
						for(cont=1; cont<=qt; cont++){
							tamanho_cel_tit=cels_lin_tit.filter(":nth-child("+cont+")").width()||0;
							tamanho_cel_corpo=cels_lin_corpo.filter(":nth-child("+cont+")").width()||0;
							if(tamanho_cel_tit>tamanho_cel_corpo){
								tamanho_cel=tamanho_cel_tit;
							} else {
								tamanho_cel=tamanho_cel_corpo;
							}
							tamanho_cel+=5;
							cels_lin_tit.filter(":nth-child("+cont+")").width(tamanho_cel);
							cels_lin_corpo.filter(":nth-child("+cont+")").width(tamanho_cel)
							cels_lin_padrao.filter(":nth-child("+cont+")").width(tamanho_cel)
							tamanho_linha+=tamanho_cel+5;
						}
						linhas_corpo.not(".linha_sub").not(".linha_padrao").css("display","block");
						linhas_corpo.not(".linha_sub").width(tamanho_linha);
						linhas_sub_superiores=tabelaest.parents("tr.linha_sub");
						cont=1;
						if(tamanho_linha+50>tabelaest.parents("tr").eq(0).width()){
							qt=linhas_sub_superiores.length;
							$.each(linhas_sub_superiores,function(index,element){			
								tamanho_linha=tamanho_linha+50;
								linhas_sub_superiores.eq(index).width(tamanho_linha);
							});
						}';
					break;
				case "texto":
					$retorno=self::montar_area_texto_html($comhttp,$params);
					break;
				case "combobox":
					$retorno = self::montar_combobox($params);
					break;							
				case "input_combobox":
					$retorno = self::montar_input_combobox($comhttp,$params);
					break;
				default:					
					$nome_metodo = "montar_".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"];
					if (method_exists('\\' . self::getInstancia()->getInstanciaSis()::class,$nome_metodo) || 
						method_exists(self::getInstancia()->getInstanciaSis(),$nome_metodo)) {						
						$retorno = \call_user_func_array(array(self::getInstancia()->getInstanciaSis(),$nome_metodo),array(&$comhttp,&$params));
					} else {
						FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao de dados sql: tipo retorno não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"],true,true);
					}
					break;
			}
			return $retorno;
		}


		/**
		 * Funcao para ser chamada na parte final de obtencao de dados sql
		 * @created 01/09/2021
		 * @param {TComHttp} &$comhttp - o objeto padrao comhttp
		 * @param {array} $params_sql - os parametros para executar o sql
		 */
		public static function montar_retorno_tabdados(&$comhttp,$params_sql=[]) : void{			
			
			/*define valores padrao ou recebidos*/
			$params_sql["query"] = $params_sql["query"] ?? $comhttp->requisicao->sql->comando_sql;
			$params_sql["fetch"] = $params_sql["fetch"] ?? "fetchAll";
			$params_sql["fetch_mode"] = $params_sql["fetch_mode"] ?? \PDO::FETCH_ASSOC;
			$params_sql["retornar_resultset"] = FuncoesConversao::como_boleano($params_sql["retornar_resultset"] ?? false);			
			
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = FuncoesConversao::como_boleano($comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] ?? true);
			$atribuir_fields = false;

			/*decide se vai retornar result set em funcao de ter ou nao arr_tit*/
			if ($comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] === true) {
				
				if (!(
					isset($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) 
					&& $comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] !== null
					&& gettype($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) === "array" 
					&& count($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) > 0
				)) {					
					$params_sql["retornar_resultset"] = true;
					$atribuir_fields = true;
				}
			} else {
				
				$params_sql["retornar_resultset"] = true;
				$atribuir_fields = true;				
			}

			/*executa sql e monta o retorno*/
			
			$retornar_resultset = $params_sql["retornar_resultset"]; //se nao retornar resultset, essa variavel se perde
			$resultset = FuncoesSql::getInstancia()->executar_sql($params_sql);
			if ($retornar_resultset === true) {
				$comhttp->retorno->dados_retornados["dados"] = $params_sql["data"];
				if ($atribuir_fields === true) {
					//echo "ok1"; exit();
					$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $params_sql["fields"];
				} 
				FuncoesSql::getInstancia()->fechar_cursor($resultset);
			} else {
				$comhttp->retorno->dados_retornados["dados"] = $resultset;
			}	
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]); exit();
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = self::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = self::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = self::montar_rodape_tabela_est_html($comhttp,false);			
		}
	}
?>