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

		public const opcoes_tab_reg_uni = [];

		public const opcoes_rotulos_box = self::opcoes_padrao_retorno + [
			"tipoelemento" => "rotulos_box_editaveis",
			"grid" => "linha"
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

		public const classe_padrao_botao = "btn-dark";
		
		private static $tiposels = [];
		
		
		
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
		private static function obter_tpel_html_arquivo($nome) {
			$retorno = null;
			$retorno = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_tipos_elementos_html"),["filtro"=>strtolower(trim($nome)),"traduzir_apos_filtro"=>true,"preparar_string_antes"=>false]);
			return $retorno;		
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
				
		public static function montar_html_tabela_simples_corpo($dados,$celsinilin) {
			$retorno = "<tbody>";
			if (count($dados) > 0) {
				foreach($dados as $linha) {
					$retorno .= "<tr>" . $celsinilin;
					foreach($linha as $cel) {
						$retorno .= "<td>".$cel."</td>";
					}
					$retorno .= "</tr>";
				}
			} 
			$retorno .= "</tbody>";
			return $retorno;
		}			
			
		public static function mont_abert_elem_html($elem_html = null,$fechar_abertura = true, $propriedades = []) {
			$texto_html = "";
			$tipo_elem_html = gettype($elem_html);
			$props = [];
			$fechamento_abertura = "";
			if (isset($elem_html)) {
				switch($tipo_elem_html) {
					case "array":
						$texto_html = $elem_html["aberturahtml"];
						foreach($elem_html as $prop => $valor) {
							if (in_array($prop,array_keys(self::trad_prop_html))) {
								$props[self::trad_prop_html[$prop]] = '"' . $valor . '"';
							}
							}
						if (count($propriedades) > 0) {
							foreach($propriedades as $propriedade => $valor) {
								if (isset($props[$propriedade])) {
									switch($propriedade) {
										case "class":
											$props[$propriedade] = '"' . str_replace('"','',$props[$propriedade]) . ' ' . str_replace('"','',$valor) . '"';
											break;
										case "style": 
										case "onclick":
											$props[$propriedade] .= '"' . $valor . '"';
										default:
											FuncoesErro::erro(null,8,__file__,__function__,__LINE__,null,"Erro na requisicao: propriedade nao suportado pela funcao: " . $propriedade,true,true);
											break;
									}
								} else {
									if (in_array($propriedade,array_keys(self::trad_prop_html))){
										if (isset($props[self::trad_prop_html[$propriedade]])){
											switch(self::trad_prop_html[$propriedade]){
												case "class":
													$props[self::trad_prop_html[$propriedade]] = '"' . str_replace('"','',$props[self::trad_prop_html[$propriedade]]) . ' ' . str_replace('"','',$valor) . '"';
													break;
												case "style":
												case "onclick":
													$props[self::trad_prop_html[$propriedade]] .= '"' . $valor . '"';
													break;
												default:
													FuncoesErro::erro(null,8,__file__,__function__,__LINE__,null,"Erro na requisicao: propriedade nao suportado pela funcao: " . $propriedade,true,true);
													break;
											}
										} else {
											$props[self::trad_prop_html[$propriedade]] = '"' . $valor . '"';
										}
									} else {
										$props[$propriedade] = '"' . $valor . '"';
									}
								}
							}
						}
						if ($fechar_abertura === true) {
							if (isset($elem_html["fechamentoaberturahtml"])) {
								if (strlen(trim($elem_html["fechamentoaberturahtml"])) > 0) {
									$fechamento_abertura = $elem_html["fechamentoaberturahtml"];
								}
							}										
						}
						if (count($props) > 0) {
							foreach($props as $prop => $valor) {
								$texto_html .= " " . $prop . "=" . $valor;
							}
						}
						$texto_html .= $fechamento_abertura;
						break;
					default:
						FuncoesErro::erro(null,8,__file__,__function__,__LINE__,null,"Erro na requisicao: tipo elemento não definido: " . $tipo_elem_html,true,true);
						break;
				}
			}	
			return $texto_html;
		}
		public static function mont_fech_abert_elem_html($elem_html = null) {
			$texto_html = "";
			$tipo_elem_html = gettype($elem_html);
			$props = [];
			$fechamento_abertura = "";
			if (isset($elem_html)) {
				switch($tipo_elem_html) {
					case "array":
						if (isset($elem_html["fechamentoaberturahtml"])) {
							if (strlen(trim($elem_html["fechamentoaberturahtml"])) > 0) {
								$fechamento_abertura = $elem_html["fechamentoaberturahtml"];
							}
						}										
						$texto_html .= $fechamento_abertura;
						break;
					default:
						FuncoesErro::erro(null,8,__FILE__,__FUNCTION__,__LINE__,null,"Erro na requisicao: tipo elemento não definido: " . $tipo_elem_html,true,true);
						break;
				}
			}	
			return $texto_html;
		}
		public static function mont_fech_elem_html($elem_html=null) {
			$texto_html = "";
			$tipo_elem_html = gettype($elem_html);
			if (isset($elem_html)) {
				switch($tipo_elem_html) {
					case "array":
						$texto_html = $elem_html["fechamentohtml"];
						break;
					default:
						FuncoesErro::erro(null,8,__file__,__function__,__LINE__,null,"Erro na requisicao: tipo elemento não definido: " . $tipo_elem_html,true,true);
						break;
				}
			}	
			return $texto_html;
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
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo elemento html nao encontrado: " . $params->tag,__FILE__,__FUNCTION__,__LINE__);
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
									} else {
										echo "tipo de propriedade ou situacao nao esperada: ";
										echo $prop;
										print_r($val); exit();
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
							$retorno .= self::montar_elemento_html($sub_el);							
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
				}
			}			
			return $retorno;
		}


		/**
		 * Monta a string html de elemento html com seus filhos representando um combobox (dropdown-menu com botao)
		 * conforme parametros passados
		 * @created 28/09/2021
		 * @param {array} $params_combobox - o array de parametros
		 * @param {boolean} $forcar_selecao_por_valores=false - se a selecao ira buscar as correspondencias em valores
		 * @return {string} a string html montada
		 */
		public static function montar_combobox(?array $params_combobox=[],?bool $forcar_selecao_por_valores=false):string {
			$params_combobox["placeholder"] = $params_combobox["placeholder"] ?? "(Selecione)";		
			$selecionar_todos = false;
			$selecionar_conforme_valor = false;
			$params_combobox["filtro"] = $params_combobox["filtro"] ?? 0;
			$params_combobox["itens"] = $params_combobox["itens"] ?? [];
			if (count($params_combobox["itens"]) > 0) {
				foreach($params_combobox["itens"] as $chave => &$item) {
					if (gettype($item) !== "array") {
						$item = [
							"opcoes_texto_opcao" => $item
						];
					}
					$item["opcoes_texto_botao"] = $item["opcoes_texto_botao"] ?? $item["opcoes_texto_opcao"];
					$item["opcoes_valor_opcao"] = $item["opcoes_valor_opcao"] ?? $item["opcoes_texto_opcao"];
				}
			}
			$params_combobox["classe_botao"] = $params_combobox["classe_botao"] ?? $params_combobox["classe_btn"] ?? self::classe_padrao_botao;
			$params_combobox["tem_inputs"] = $params_combobox["tem_inputs"] ?? false;
			$params_combobox["tipo_inputs"] = $params_combobox["tipo_inputs"] ?? $params_combobox["tipo"] ?? "checkbox";						
			$params_combobox["multiplo"] = $params_combobox["multiplo"] ?? 1;

			if (!isset($params_combobox["selecionar_todos"])) {				
				if (isset($params_combobox["multiplo"]) && in_array($params_combobox["multiplo"],Constantes::array_verdade)) {
					$params_combobox["selecionar_todos"] = 1;
				} else {
					$params_combobox["selecionar_todos"] = 0;
					$selecionar_todos = false;				
				}
			} 	
			if ($params_combobox["tem_inputs"] && $params_combobox["tipo_inputs"] === "radio") {
				$params_combobox["name_inpus"] = $params_combobox["name_inpus"] ?? '_'.mt_rand();
			}			
			if (isset($params_combobox["selecionados"])) {
				if (gettype($params_combobox["selecionados"]) !== "array") {
					$params_combobox["selecionados"] = explode(",",$params_combobox["selecionados"]);
				}
			} else {
				$params_combobox["selecionados"] = [];
			}		
			if (isset($params_combobox["selecionados"][0])) {
				if (strcasecmp(trim($params_combobox["selecionados"][0]),"todos") == 0) {
					if (isset($params_combobox["multiplo"]) && in_array($params_combobox["multiplo"],Constantes::array_verdade)) {
						$selecionar_todos = true;
					} else {
						$selecionar_todos = false;
						$params_combobox["selecionados"] = array_keys($params_combobox["opcoes_texto_opcao"]);
					}
				} else {
					if (strcasecmp(trim($params_combobox["selecionados"][0]),"__campo__=__valor__") == 0) {
						$selecionar_conforme_valor = true;
					}
					$selecionar_todos = false;
				}
			}
			$params_combobox["num_max_texto_botao"] = $params_combobox["num_max_texto_botao"] ?? 5;
			$classe_combobox = "";
			$params_combobox["tag"] = "div";
			$params_combobox["class"] = "div_combobox " . ($params_combobox["class"] ?? "");
			$params_combobox["sub"] = [];
			$params_combobox["sub"][] = [
				"tag" => "button",
				"type" => "button",
				"class" => "btn dropdown-toggle ".($params_combobox["classe_botao"] ?? ""),
				"data-bs-toggle" => "dropdown",
				"aria-expanded" => "false",
				"num_max_texto_botao" => $params_combobox["num_max_texto_botao"],
				"data-bs-auto-close" => "outside"				
			];			

			/*monta o texto do botao se houverem selecionados*/
			$texto_botao = [];
			if ($selecionar_todos) {				
				$texto_botao[] = "Todos (" . count($params_combobox["itens"]).")";			
			} else {
				if (!$selecionar_conforme_valor) {
					foreach($params_combobox["selecionados"] as &$selecionado) {
						if (isset($params_combobox["itens"][$selecionado]) && !$forcar_selecao_por_valores) {
							$texto_botao[] = $params_combobox["itens"][$selecionado]["opcoes_texto_botao"];
						} else {
							$selecionado = strtolower(trim(str_replace("'","",$selecionado)));
							$encontrado = false;
							foreach($params_combobox["itens"] as $chave=>$iten) {
								if (strcasecmp(trim(str_replace("'","",$iten["opcoes_valor_opcao"])),$selecionado) == 0) {
									$encontrado = true;
									$selecionado = $chave;
									$texto_botao[] = $iten["opcoes_texto_botao"];
									break;
								}
							}
							if (!$encontrado) {
								foreach($params_combobox["itens"] as $chave=>$iten) {
									if (strcasecmp(trim(str_replace("'","",$iten["opcoes_texto_opcao"])),$selecionado) == 0) {
										$encontrado = true;
										$selecionado = $chave;
										$texto_botao[] = $iten["opcoes_texto_botao"];
										break;
									}
								}					
							}
							if (!$encontrado) {
								foreach($params_combobox["itens"] as $chave=>$iten) {
									if (strcasecmp(trim(str_replace("'","",$iten["opcoes_texto_botao"])),$selecionado) == 0) {
										$encontrado = true;
										$selecionado = $chave;
										$texto_botao[] = $iten["opcoes_texto_botao"];
										break;
									}
								}					
							}
							if (!$encontrado) {
								foreach($params_combobox["itens"] as $chave=>$iten) {
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
				$texto_botao = $params_combobox["placeholder"];
			} else {
				if (count($texto_botao) === count($params_combobox["itens"]) && count($texto_botao) > 1) {
					$texto_botao = "Todos (" . count($texto_botao) . ")";
				} else {
					if (count($texto_botao) > $params_combobox["num_max_texto_botao"]) {
						$texto_botao = count($texto_botao) . " Selecionados";
					} else {	
						$texto_botao = implode(",",$texto_botao);
					}
				}
			}
			$params_combobox["sub"][0]["text"] = $texto_botao;
			$params_combobox["sub"][] = [
				"tag" => "ul",
				"class" => "dropdown-menu ".($params_combobox["classe_dropdown"] ?? ""),
				"onclick" => "window.fnhtml.fndrop.clicou_dropdown(event,this)"
			];
			if (isset($params_combobox["aoselecionaropcao"])) {
				$params_combobox["sub"][1]['aoselecionaropcao']=$params_combobox["aoselecionaropcao"];
			}	
			if (isset($params_combobox["permite_selecao"])) {
				$params_combobox["sub"][1]["permite_selecao"] = ((bool)$params_combobox["permite_selecao"]?"true":"false");
			}			
			$params_combobox["sub"][1]["sub"] = [];
			if (isset($params_combobox["selecionar_todos"]) && in_array($params_combobox["selecionar_todos"],Constantes::array_verdade)) {				
				$params_combobox["sub"][1]["sub"][] = [
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
			if (isset($params_combobox["filtro"]) && in_array($params_combobox["filtro"],Constantes::array_verdade)) {
				$params_combobox["sub"][1]["sub"][] = [
					"tag" => "input",
					"type" => "text",
					"class" => "input_filtro_dropdown rounded",
					"placeholder" => "(filtro)",
					"onkeyup" =>"window.fnhtml.fndrop.filtrar_dropdown(this)"
				];
			}

			/*parametros dos li do combobox*/
			foreach($params_combobox["itens"] as $chave_opcao => $iten) {
				$params_label = [
					"tag" => "label",
					"text" => $iten["opcoes_texto_opcao"],
					"textodepois" => true
				];
				if ($params_combobox["tem_inputs"]) {
					$params_input = [
						"tag" => "input",
						"type" => $params_combobox["tipo_inputs"]
					];
					if (isset($params_combobox["name_inpus"]) && $params_combobox["name_inpus"] !== null) {
						$params_input["name"] = $params_combobox["name_inpus"];
					}
					if ($selecionar_todos || in_array($chave_opcao,$params_combobox["selecionados"])) {
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
				
				if (isset($params_combobox["dados_extras"])) {
					if (count($params_combobox["dados_extras"]) > 0) {
						foreach($params_combobox["dados_extras"] as $nome_dado=>$valor) {
							$params_li[$nome_dado] = $valor[$chave_opcao];
						}
					}
				}
				
				$params_combobox["sub"][1]["sub"][] = $params_li;
			}			
			unset($params_combobox["tipo"]);
			unset($params_combobox["itens"]);
			unset($params_combobox["selecionados"]);
			return self::montar_elemento_html($params_combobox);
		}

		/**
		 * monta uma string html de um div com dois inputs para um periodo de inicio e fim
		 * @created 28/09/2021
		 * @param {?array} $params - os parametros para montar o elemento
		 * @return {string} a string html montada
		 */
		public static function montar_combo_periodo(?array $params = []):string{
			$params = $params ?? [];
			$params["tag"] = $params["tag"] ?? "div";
			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "row",
				"sub" => [
					[
						"tag" => "div",
						"class" => "col-auto",
						"sub"=>[
							[
								"tag" => "input",
								"type" => "date",
								"class" => "componente_data controle_input_texto",
								"title" => "Clique para abrir o calendario",
								"value" => FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>0
									?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][0])
									:FuncoesData::data_primeiro_dia_mes_atual())
								)
							]
						]
					],
					[
						"tag" => "div",
						"class" => "col-auto",
						"sub"=>[
							[
								"tag" => "input",
								"type" => "date",
								"class" => "componente_data controle_input_texto",
								"title" => "Clique para abrir o calendario",
								"value" => FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>1
									?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][1])
									:FuncoesData::data_atual())
								)
							]
						]
					]
				]
			];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "row align-items-center",
				"sub" => [
					[
						"tag" => "div",
						"class" => "col",
						"sub" => [
							[
								"tag" => "div",
								"class" => "w-100 text-center",
								"sub" => [
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/jan.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/fev.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/mar.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/abr.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/mai.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/jun.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/jul.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/ago.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/set.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/out.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/nov.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "img",
										"class" => "imagem_mes_calendario item_destaque100pct_hover",
										"src" => NomesCaminhosRelativos::sis . "/images/calendario/dez.png",
										"title" =>"Preenche as datas com este mes inteiro",
										"onclick" => "window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
									],
									[
										"tag" => "input",
										"type" => "number",
										"class" => "inputano",
										"value" => FuncoesData::ano_atual(),
										"title" =>"Preenche as datas com este mes inteiro",
										"title" => "Ano para preenchimento do mes inteiro",
										"step" => "1",
										"min" => "0"
									]
								]
							]
						]
					]
				]
			];
			return self::montar_elemento_html($params);
		}

		/**
		 * monta a div onde os resultados de consultas sao colocados na pagina
		 * @created 28/09/2021
		 * @param {?array} $params - os parametros para montar o elemento
		 * @return {string} a string html montada
		 */
		public static function montar_div_resultado_padrao(?array $params = []) : string {
			$params = $params ?? [];
			$params["tag"] = $params["tag"] ?? "div";
			$params["class"] = "div_resultado_l2 row " . ($params["class"] ?? "");
			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "div_resultado col"
			];
			return self::montar_elemento_html($params);
		}

		/**
		 * Monta a string html de card (bootstrap) conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_card_padrao(?array $params = []) : string {
			$params = $params ?? [];
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["title"] ?? "(titulo)";
			$params["tag"] = $params["tag"] ?? "div";
			$params["class"] = "card " . ($params["class"] ?? "");
			$params["conteudo"] = $params["conteudo"] ?? $params["content"] ?? $params["text"] ?? $params["corpo"] ?? $params["body"];
			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "card-header",
				"text" => $params["titulo"]
			];
			$params["sub"][] = [
				"tag" => "div",
				"class" => "card-body",
				"text" => $params["conteudo"]
			];
			unset($params["titulo"]);
			unset($params["conteudo"]);
			return self::montar_elemento_html($params);
		}


		/**
		 * Monta a string html de drop-down (bootstrap) visoes conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_combobox_visao(?array $params=[]) : string {
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
			return self::montar_combobox($params);
		}

		/**
		 * Monta a string html de drop-down (bootstrap) dos itens de condicionantes conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_combobox_condicionante(?array $params = []) : string { 
			$params = $params ?? [];			
			$params["visao"] = $params["visao"] ?? "Origem de Dados";
			$params["itens"] = FuncoesSisJD::valores_para_condicionante($params["visao"]);
			$params["tipo_inputs"] = "checkbox";
			$params["selecionar_todos"] = 1;
			$params["multiplo"] = 1;
			$params["filtro"] = 1;
			$params["propriedades_html"] = [];
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;
			$params["propriedades_html"][] = ["propriedade" => "class" ,"valor" => "condicionante"];
			return self::montar_combobox($params);
		}

		/**
		 * Monta a string html do combo de drop-down3 (bootstrap) de condicionante (visao+operacao+valores)
		 * conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_combobox_condicionantes(?array $params = []) : string { 
			$params = $params ?? [];
			$params["visoes"] = $params["visoes"] ?? [];
			$opcoes_combobox_visao["itens"] = (gettype($params["visoes"])==="array"?$params["visoes"]:explode(",",$params["visoes"]));
			$opcoes_combobox_visao["selecionados"] = $opcoes_combobox_visao["selecionados"] ?? [(gettype($params["visoes"])==="array"?count($params["visoes"])-1:count(explode(",",$params["visoes"]))-1)];
			$visao = $opcoes_combobox_visao["itens"][$opcoes_combobox_visao["selecionados"][0]];
			$html_combobox_visao = self::montar_combobox_visao($opcoes_combobox_visao);
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
			$comhttpnull = null;
			$html_comparador = self::montar_combobox($opcoes_combobox_operacao);		
			$html_dados_condicionante = self::montar_combobox_condicionante([
				"visao"=>$visao,
				"selecionados"=>$opcoes_combobox_visao["selecionados"]
			]);
			return $html_combobox_visao . $html_comparador . $html_dados_condicionante;		
		}

		/**
		 * Monta a string html de drop-down (bootstrap) de campos avulsos conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_combobox_campos_avulsos(?array $params=[]) : string{
			$params = $params ?? [];
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
			return self::montar_combobox($params);
		}


		/**
		 * Monta a string html de card (bootstrap) de visao conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_card_combobox_visao(?array $params = []) : string {
			$params = $params ?? [];
			$params["tag"] = $params["tag"] ?? "div";			
			$params["class"] = $params["class"] ?? "";
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "window.fnsisjd.inserir_visao_pesquisa({elemento:this})";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";

			/*criacao da html do combobox visao*/
			$params["params_combobox"] = $params["params_combobox"] ?? [];
			$params["params_combobox"]["itens"] = $params["params_combobox"]["itens"] ?? Constantes::$visoes;
			$params["params_combobox"]["tem_inputs"] = $params["params_combobox"]["tem_inputs"] ?? true;
			$params["params_combobox"]["tipo_inputs"] = $params["params_combobox"]["tipo_inputs"] ?? "radio";
			$params["params_combobox"]["multiplo"] = $params["params_combobox"]["multiplo"] ?? 0;
			$params["params_combobox"]["selecionar_todos"] = $params["params_combobox"]["selecionar_todos"] ?? 0;
			$params["params_combobox"]["filtro"] = $params["params_combobox"]["filtro"] ?? 1;
			$html_combobox = self::montar_combobox($params["params_combobox"]);
			
			/*parametros dos botoes de controle*/
			$params_botoes = [
				"tag" => "div",
				"class" => "div_opcao_controles_btns_img col-md-auto w-auto",
				"sub" => []
			];
			if ($params["permite_incluir"]) {
				$params_botoes["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_add_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/maisverde32.png",
					"onclick" => $params["funcao_inclusao"],
					"title" => "Acrescentar ao lado deste"
				];
			}
			if ($params["permite_excluir"]) {
				$params_botoes["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_excl_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/img_del.png",
					"onclick" => $params["funcao_exclusao"],
					"title" => "Excluir este controle"
				];
			}

			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag"=>"div",
				"class"=>"card",
				"sub" => [
					[
						"tag" => "div",
						"class" => "card-header",
						"text" => $params["titulo"]
					],[
						"tag" => "div",
						"class" => "card-body",
						"sub" => [
							[
								"tag"=>"div",
								"class"=>"row",
								"sub"=>[
									[
										"tag"=>"div",
										"class"=>"col",
										"text" => $html_combobox
									],
									$params_botoes
								]
							]
						]
					]				
				]							
			];
			unset($params["params_combobox"]);
			return self::montar_elemento_html($params);
		}


		/**
		 * Monta a string html de um array de cards (bootstrap) de visao conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_cards_combobox_visao(?array $params = []) : string {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? $params["visoes"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			foreach($params["itens"] as $iten){
				$retorno[] = self::montar_card_combobox_visao([
					"class"=>"col-auto mt-2 div_visao",
					"titulo"=>$iten["titulo"] ?? $iten["cabecalho"] ?? $iten["label"] ?? "",
					"params_combobox"=>$iten,
					"permite_incluir" => $params["permite_incluir"],
					"permite_excluir" => $params["permite_excluir"],
					"funcao_inclusao" => $params["funcao_inclusao"],
					"funcao_exclusao" => $params["funcao_exclusao"]
				]);
			}
			return implode("",$retorno);
		}


		/**
		 * Monta a string html de card (bootstrap) de periodo conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_card_periodo(?array $params = []) : string {
			$params = $params ?? [];
			$params["tag"] = $params["tag"] ?? "div";			
			$params["class"] = $params["class"] ?? "";
			$params["titulo"] = $params["titulo"] ?? $params["cabecalho"] ?? $params["label"] ?? $params["title"] ?? "";
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "window.fnsisjd.inserir_periodo_pesquisa({elemento:this})";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "window.fnsisjd.deletar_controles({elemento:this})";
			$params["dtini"] = $params["dtini"] ?? FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>0
				?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][0])
				:FuncoesData::data_primeiro_dia_mes_atual())
			);
			$params["dtfim"] = $params["dtfim"] ?? FuncoesData::dataUSA((isset($params["datas"])&&count($params["datas"])>1
				?FuncoesVariaveis::como_texto_ou_funcao($params["datas"][1])
				:FuncoesData::data_atual())
			);

			/*parametros dos botoes de controle*/
			$params_botoes = [
				"tag" => "div",
				"class" => "div_opcao_controles_btns_img col-md-auto w-auto",
				"sub" => []
			];
			if ($params["permite_incluir"]) {
				$params_botoes["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_add_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/maisverde32.png",
					"onclick" => $params["funcao_inclusao"],
					"title" => "Acrescentar ao lado deste"
				];
			}
			if ($params["permite_excluir"]) {
				$params_botoes["sub"][] = [
					"tag" => "img",
					"class" => "btn_img_excl_ctrl mousehover clicavel rounded",
					"src" => "/sjd/images/img_del.png",
					"onclick" => $params["funcao_exclusao"],
					"title" => "Excluir este controle"
				];
			}

			$params["sub"] = $params["sub"] ?? [];
			$params["sub"][] = [
				"tag"=>"div",
				"class"=>"card",
				"sub" => [
					[
						"tag" => "div",
						"class" => "card-header",
						"text" => $params["titulo"]
					],[
						"tag" => "div",
						"class" => "card-body",
						"sub" => [
							[
								"tag"=>"div",
								"class"=>"row",
								"sub"=>[
									[
										"tag"=>"div",
										"class"=>"col",
										"sub" => [
											[
												"tag" => "div",
												"class" => "row",
												"sub" => [
													[
														"tag" => "div",
														"class" => "col-auto",
														"sub" => [
															[
																"tag" => "input",
																"type" => "date",
																"class" => "componente_data",
																"value" => $params["dtini"]
															]
														]
													],[
														"tag" => "div",
														"class" => "col-auto",
														"sub" => [
															[
																"tag" => "input",
																"type" => "date",
																"class" => "componente_data",
																"value" => $params["dtfim"]
															]
														]
													]

												]
											],
											[
												"tag"=>"div",
												"class"=>"row align-items-center",
												"sub"=>[
													[
														"tag"=>"div",
														"class"=>"col",
														"sub"=>[
															[
																"tag"=>"div",
																"class"=>"w-100 text-center",
																"sub"=>[
																	[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/jan.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/fev.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/mar.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/abr.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/mai.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/jun.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/jul.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/ago.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/set.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/out.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/nov.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"img",
																		"class"=>"imagem_mes_calendario item_destaque100pct_hover",
																		"title"=>"Preenche as datas com este mes inteiro",
																		"src"=>"/sjd/images/calendario/dez.png",
																		"onclick"=>"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
																	],[
																		"tag"=>"input",
																		"type"=>"number",
																		"class"=>"inputano",
																		"value"=>"2021",
																		"title"=>"Ano para preenchimento do mes inteiro",
																		"step"=>"1",
																		"min"=>"0"
																	]
																]
															]
														]
													]
												]
											]
										]
									],
									$params_botoes
								]
							]
						]
					]				
				]							
			];
			return self::montar_elemento_html($params);
		}


		/**
		 * Monta a string html de um array de cards (bootstrap) de periodo conforme parametros
		 * @created 29/09/2021
		 * @param {?array} $params - o array com as opcoes para montagem
		 * @return {string} - a string html montada
		 */
		public static function montar_cards_periodo(?array $params = []) : string {
			$retorno = [];
			$params = $params ?? [];
			$params["itens"] = $params["itens"] ?? $params["periodos"] ?? [];
			$params["permite_incluir"] = $params["permite_incluir"] ?? false;
			$params["permite_excluir"] = $params["permite_excluir"] ?? false;
			$params["funcao_inclusao"] = $params["funcao_inclusao"] ?? "";
			$params["funcao_exclusao"] = $params["funcao_exclusao"] ?? "";
			
			foreach($params["itens"] as $iten){
				$retorno[] = self::montar_card_periodo([
					"class"=>"col-auto mt-2 div_periodo",
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
			return implode("",$retorno);
		}


		public static function montar_div_box_opcao_padrao($opcao = []) {
			$retorno = '';
			$opcao["class"] = $opcao["class"] ?? "";
			$opcao["titulo"] = $opcao["titulo"] ?? "Titulo";
			$opcao["tipo"] = $opcao["tipo"] ?? "visao";
			$opcao["retratil"] = $opcao["retratil"] ?? [];
			$opcao["retratil"]["ativo"] = $opcao["retratil"]["ativo"] ?? false;
			$opcao["retratil"]["status"] = $opcao["retratil"]["status"] ?? "fechado";
			$opcao["permite_incluir"] = $opcao["permite_incluir"] ?? false;
			$opcao["permite_excluir"] = $opcao["permite_excluir"] ?? false;		
			$opcao["itens"] = $opcao["itens"] ?? [];
			$retorno .= '<div class="div_opcoes '.$opcao["class"].' row">';
				$retorno .= '<div class="div_opcoes_col m-1 col">';
					$retorno .= '<div class="div_opcoes_corpo row" data-ind="'.count($opcao["itens"]).'">';
						
						/*monta as visoes conforme parametros passados ou padrao estabelecido no inicio da funcao*/
						foreach($opcao["itens"] as &$item) {
							$item["classe_botao"] = $item["classe_botao"] ?? self::classe_padrao_botao;							
							$tipo = strtolower(trim((isset($item["tipo"])?$item["tipo"]:(isset($opcao["tipo"])?$opcao["tipo"]:""))));
							if ($tipo === "periodos") {
								$tipo = "periodo";
							}
							$retorno .= '<div class="div_container_combobox div_container_combobox_'.$tipo.' col-md-auto w-auto mb-1">';
								$retorno .= '<div class="div_opcao container border rounded">';
									$retorno .= '<div class="div_opcao_tit row">';
										$retorno .= $item["label"];
									$retorno .= '</div>';
									$retorno .= '<div class="div_opcao_controles row">';
										$retorno .= '<div class="div_opcao_controles_comp col">';
											switch($tipo) {								
												case "periodo": case "periodos":
													$retorno .= self::montar_combo_periodo($item);
													break;
												case "condicionante":
													$retorno .= self::montar_combobox_condicionante($item);
													break;
												case "condicionantes":
													$retorno .= self::montar_combobox_condicionantes($item);
													break;
												case "campo_avulso": case "campos_avulsos":
													$retorno .= self::montar_combobox_campos_avulsos($item);
													break;
												case "mes":
													$retorno .= self::montar_combobox_meses($item);
													break;
												case "ano":
													$item["tem_inputs"] = $item["tem_inputs"] ?? true;
													$item["tipo_inputs"] = $item["tipo_inputs"] ?? "checkbox";
													$retorno .= self::montar_combobox($item);
													break;
												default: //case "visao":
													//print_r($item); exit();
													$retorno .= self::montar_combobox_visao($item);
													break;
											}
										$retorno .= '</div>';								
										$retorno .= '<div class="div_opcao_controles_btns_img col-md-auto w-auto">';
											if ((isset($item["permite_incluir"]) && $item["permite_incluir"] === true) || (!isset($item["permite_incluir"]) && $opcao["permite_incluir"] === true)) {
												$retorno .= '<img class="btn_img_add_ctrl mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcao["funcao_inclusao"].'" title="Acrescentar ao lado deste" />';
											}
											if ((isset($item["permite_excluir"]) && $item["permite_excluir"] === true) || (!isset($item["permite_excluir"]) && $opcao["permite_excluir"] === true)) {
												$retorno .= '<img class="btn_img_excl_ctrl mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/img_del.png" onclick="'.$opcao["funcao_exclusao"].'" title="Excluir esse controle" />';
											}
										$retorno .= '</div>';
									$retorno .= '</div>';
								$retorno .= '</div>';
							$retorno .= '</div>';
						}					
					$retorno .= '</div>';
				$retorno .= '</div>';
			$retorno .= '</div>';
			return $retorno;
		}


		public static function montar_opcoes_pesquisa_padrao($opcoes = []){
			$retorno = '';
			/*opcoes padrao para construcao das opcoes de pesquisa que vai no topo das paginas de relatorios, podem ser passados parametros diferentes no parametro $opcoes*/
			//print_r($opcoes); exit();
			/*checagem das opcoes que foram passadas e atribuicao das opcoes padrao*/
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
							$retorno .= '<h2 class="accordion-header">';
								$retorno .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">';
									$retorno .= 'Opções de Pesquisa';
								$retorno .= '</button>';
							$retorno .= '</h2>';
							$retorno .= '<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
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
														$retorno .= '<h2 class="accordion-header">';
															$retorno .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#visoes" aria-expanded="true" aria-controls="visoes">';
																$retorno .= $opcoes["visoes"]["titulo"];
															$retorno .= '</button>';
														$retorno .= '</h2>';
														$retorno .= '<div id="visoes" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																if ($opcoes["visoes"]["permite_incluir"]) {
																	$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["visoes"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																}
																$retorno .= '<div class="row">';
																	$retorno .= self::montar_cards_combobox_visao($opcoes["visoes"]);						
																$retorno .= '</div>';
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
														$retorno .= '<h2 class="accordion-header">';
															$retorno .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#visoes2" aria-expanded="true" aria-controls="visoes2">';
																$retorno .= $opcoes["visoes2"]["titulo"];
															$retorno .= '</button>';
														$retorno .= '</h2>';
														$retorno .= '<div id="visoes2" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["visoes2"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																$retorno .= self::montar_cards_combobox_visao($opcoes["visoes2"]);																						
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
														$retorno .= '<h2 class="accordion-header">';
															$retorno .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#periodos" aria-expanded="true" aria-controls="periodos">';
																$retorno .= 'Períodos';
															$retorno .= '</button>';
														$retorno .= '</h2>';
														$retorno .= '<div id="periodos" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																if ($opcoes["periodos"]["permite_incluir"] === true) {
																	$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["periodos"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																}
																$retorno .= '<div class="row">';
																	$retorno .= self::montar_cards_periodo($opcoes["periodos"]);	
																$retorno .= '</div>';
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
														$retorno .= '<h2 class="accordion-header">';
															$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#avancada" aria-expanded="false" aria-controls="avancada">';
																$retorno .= 'Avançado';
															$retorno .= '</button>';
														$retorno .= '</h2>';
														$retorno .= '<div id="avancada" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
															$retorno .= '<div class="accordion-body">';
																$opcoes["avancado"]["classe_corpo"] = $opcoes["avancado"]["classe_corpo"] ?? "div_opcoes_pesquisa_avancada";
																$retorno .= '<div class="div_opcoes_pesquisa_avancada row ">';
																	$retorno .= '<div class="div_opcoes_pesquisa_avancada_col col">';			

																	$retorno .= '<div class="accordion">';

																		if ($opcoes["avancado"]["ver_vals_de"]["ativo"] === true) {	
																			$retorno .= '<div class="accordion-item">';
																				$retorno .= '<h2 class="accordion-header">';
																					$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#painel_ver_vals_de" aria-expanded="false" aria-controls="painel_ver_vals_de">';
																						$retorno .= 'Ver Valores de';
																					$retorno .= '</button>';
																				$retorno .= '</h2>';
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
																				$retorno .= '<h2 class="accordion-header">';
																					$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#painel_ver_vals_zero" aria-expanded="false" aria-controls="painel_ver_vals_zero">';
																						$retorno .= 'Ver Valores Zero';
																					$retorno .= '</button>';
																				$retorno .= '</h2>';
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
																				$retorno .= '<h2 class="accordion-header">';
																					$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#painel_considerar_vals_de" aria-expanded="false" aria-controls="painel_considerar_vals_de">';
																						$retorno .= 'Considerar Valores de';
																					$retorno .= '</button>';
																				$retorno .= '</h2>';
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
																				$retorno .= '<h2 class="accordion-header">';
																					$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#painel_condicionantes" aria-expanded="false" aria-controls="painel_condicionantes">';
																						$retorno .= 'Condicionantes';
																					$retorno .= '</button>';
																				$retorno .= '</h2>';
																				$retorno .= '<div id="painel_condicionantes" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';
																						if ($opcoes["avancado"]["condicionantes"]["permite_incluir"] === true) {
																							$retorno .= '<img class="btn_img_add_geral mousehover clicavel rounded" src="' . NomesCaminhosRelativos::sis . '/images/maisverde32.png" onclick="'.$opcoes["avancado"]["condicionantes"]["funcao_inclusao"].'" title="Acrescentar um item" />';
																						}
																						$retorno .= self::montar_div_box_opcao_padrao($opcoes["avancado"]["condicionantes"]);	
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
																				$retorno .= '<h2 class="accordion-header">';
																					$retorno .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#painel_campos_avulsos" aria-expanded="false" aria-controls="painel_campos_avulsos">';
																						$retorno .= 'Campos Avulsos';
																					$retorno .= '</button>';
																				$retorno .= '</h2>';
																				$retorno .= '<div id="painel_campos_avulsos" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">';
																					$retorno .= '<div class="accordion-body">';
																						$retorno .= self::montar_div_box_opcao_padrao($opcoes["avancado"]["campos_avulsos"]);	
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

		

		/**
		 * @created 19/07/2021
		 */
		public static function montar_card($params) {
			$params = $params ?? [];
			$params["content"] = $params["content"] ?? '';
			$retorno = '';
			$retorno .= '<div class="card ' . ($params["class"] ?? '') . '">';
				if (isset($params["header"])) {
					$retorno.= '<div class="card-header">';
						$retorno .= $params["header"];
					$retorno.= '</div>';
				}
				$retorno .= '<div class="card-body">';
					$retorno .= $params["content"];
				$retorno .= '</div>';
			$retorno .= '</div>';
			return $retorno;
		}

		/**
		 * @created 19/07/2021
		 */
		public static function montar_card_valor($params) {
			$params = $params ?? [];
			$params["content"] = '';
			$params["titulo"] = $params["titulo"] ?? '(titulo)';
			$params["valor"] = $params["valor"] ?? '(valor)';			
			$params["unidade"] = $params["unidade"] ?? '(UN)';
			$params["variacao"] = $params["variacao"] ?? '(variacao)';
			$params["content"] .= '<div class="row align-items-center gx-0">';
				$params["content"] .= '<div class="col">';
					$params["content"] .= '<h6 class="text-uppercase text-muted mb-2">';
						$params["content"] .= $params["titulo"];
					$params["content"] .= '</h6>';
					$params["content"] .= '<spam class="h4 mb-0">';
						$params["content"] .= $params["valor"];
					$params["content"] .= '</spam>';
					/*$params["content"] .= '<spam class="badge bg-success-soft mt-n1">';
						$params["content"] .= $params["variacao"];
					$params["content"] .= '</spam>';*/
				$params["content"] .= '</div>';
				$params["content"] .= '<div class="col-auto">';
					$params["content"] .= '<spam class="h4 fe fe-dollar-sign text-muted mb-0">';
						$params["content"] .= $params["unidade"];
					$params["content"] .= '</spam>';
				$params["content"] .= '</div>';
			$params["content"] .= '</div>';
			$retorno = self::montar_card($params);
			return $retorno;
		}


		/**
		 * @created 19/07/2021
		 */
		public static function montar_spinner(?array $params = []) {
			$params = $params ?? [];
			$retorno = '';
			$retorno .= '<div class="spinner-border" role="status">';
				$retorno.= '<span class="visually-hidden">Loading...</span>';
			$retorno .= '</div>';
			return $retorno;
		}
		
		public static function montar_combobox_meses(?array $params = []) : string{
			$retorno = "";
			if (isset($params)) {
				if (count($params) > 0) {
				} else {
				}
			} else {
				$params = [];
			}
			$params["tem_inputs"] = $params["tem_inputs"] ?? true;
			$params["itens"] = $params["itens"] ?? $params["meses"] ?? Constantes::meses;			
			if (!isset($params["selecionados"])) {
				$params["selecionados"] = null;
			}
			if ($params["selecionados"] === null) {
				$params["selecionados"] = [((date('m')*1)-1)];
			}
			if (!isset($params["multiplo"])) {
				$params["multiplo"] = 1;
			}
			if (isset($params["multiplo"]) && in_array($params["multiplo"],Constantes::array_verdade)) {
				$params["tipo"] = "checkbox";
				$params["multiplo"] = 1;
				$params["num_max_texto_botao"] = 2;
			} else {
				$params["tipo"] = "radio";
				$params["multiplo"] = 0;
			}
			$params["classe_botao"] = $params["classe_botao"] ?? self::classe_padrao_botao;
			$comhttpnull = null;
			unset($params["meses"]);
			$retorno = self::montar_combobox($params);
			return $retorno;
		}
		public static function montar_input_combobox(&$comhttp,$opcoes=[]) {
			$html_div_drop = "";
			$html_linha_filtros = "";
			$placeholder = "(Selecione)";		
			$selecionar_todos = false;
			$class_random='_'.mt_rand();
			$comhttp->requisicao->requisitar->qual->condicionantes["classe_random_tabelaest"]=$class_random;		
			$opcoes["selecao_ativa"] = $opcoes["selecao_ativa"] ?? true;
			$opcoes["filtro_ativo"] = $opcoes["filtro_ativo"] ?? true;
			$opcoes["tem_filtro_geral"] = $opcoes["tem_filtro_geral"] ?? true;
			if (!isset($opcoes["opcoes_texto_opcao"])) {		
				$opcoes_texto_opcao = [];
				foreach($opcoes as $chaveopcao => $opcao) {
					$opcoes_texto_opcao[$chaveopcao] = $opcao;
				}
				$opcoes = [];
				$opcoes["opcoes_texto_opcao"] = $opcoes_texto_botao;			
			}		
			if (!isset($opcoes["opcoes_texto_botao"])) {		
				$opcoes_texto_botao = [];
				foreach($opcoes["opcoes_texto_opcao"] as $chaveopcao => $opcao) {
					$opcoes_texto_botao[$chaveopcao] = $opcao;
				}
				$opcoes["opcoes_texto_botao"] = $opcoes_texto_botao;			
			}
			if (!isset($opcoes["opcoes_valor_opcao"])) {		
				$opcoes_valor_opcao = [];
				foreach($opcoes["opcoes_texto_opcao"] as $chaveopcao => $opcao) {
					$opcoes_valor_opcao[$chaveopcao] = $opcao;
				}
				$opcoes["opcoes_valor_opcao"] = $opcoes_valor_opcao;			
			}
			$opcoes["tipo"] = $opcoes["tipo"] ?? "checkbox";
			if (!isset($opcoes["multiplo"])) {
				$opcoes["multiplo"] = 1;
			}
			if (!isset($opcoes["selecionar_todos"])) {
				$opcoes["selecionar_todos"] = 1;
			}		
			if (!isset($opcoes["placeholder"])) {
				$opcoes["placeholder"] = $placeholder;
			}
			if ($opcoes["tipo"] === "radio") {
				$imagem_selecao =  NomesCaminhosRelativos::sjd . "/images/radio.png";
				$imagem_selecionado =  NomesCaminhosRelativos::sjd . "/images/radio_checked.png";
			} else {
				$imagem_selecao =  NomesCaminhosRelativos::sjd . "/images/checkbox.png";
				$imagem_selecionado =  NomesCaminhosRelativos::sjd . "/images/checkbox_checked.png";
			}			
			if (isset($opcoes["selecionados"])) {
				if (gettype($opcoes["selecionados"]) !== "array") {
					$opcoes["selecionados"] = explode(",",$opcoes["selecionados"]);
				}
			} else {
				$opcoes["selecionados"] = [];
			}		
			if (isset($opcoes["selecionados"][0])) {
				if (strcasecmp(trim($opcoes["selecionados"][0]),"todos") == 0) {
					if (isset($opcoes["multiplo"]) && in_array($opcoes["multiplo"],Constantes::array_verdade)) {
						$selecionar_todos = true;
					} else {
						$selecionar_todos = false;
						$opcoes["selecionados"] = array_keys($opcoes["opcoes_texto_opcao"]);
					}
				} else {
					$selecionar_todos = false;
				}
			}
			if (!isset($opcoes["num_max_texto_botao"])) {
				$opcoes["num_max_texto_botao"] = 5;
			}		
			$html_div_drop = '<div class="div_input_combobox_dropdown div_input_combobox_dropdown_aberto" onclick="window.fninputcombobox.clicou_input_combobox_dropdown(this)">';
			$propriedades = [];
			$propriedades[] = 'tem_filtro_geral="'.FuncoesConversao::como_boleano($opcoes["tem_filtro_geral"],"string").'"';
			$propriedades[] = 'id_filtro_geral="'.$opcoes["id_input_combobox"].'"';
			$propriedades[] = 'selecao_tipo="'.$opcoes["tipo"].'"';
			$propriedades[] = 'selecionar_pela_linha="true"';
			$propriedades[] = 'multiplo="' . $opcoes["multiplo"] . '"';
			$propriedades[] = 'selecao_ativada="'.FuncoesConversao::como_boleano($opcoes["selecao_ativa"],"string").'"';
			$propriedades[] = 'aoselecionaropcao="' . $opcoes["aoselecionaropcao"] . '"';
			if (isset($opcoes["aoclicarlinha"])) {
				$propriedades[] = 'aoclicarlinha="' . $opcoes["aoclicarlinha"] . '"';
			}
			$classe_tab = "";
			if (isset($opcoes["classe_tabela"])) {
				$classe_tab = ' '. $opcoes["classe_tabela"] . ' ';
			}
			$propriedades = ' ' . implode(' ',$propriedades) . ' ';
			$html_tab_drop = '<table class="tabela_est tabela_inputcombobox '.$classe_tab . ' ' . $comhttp->requisicao->requisitar->qual->condicionantes["classe_random_tabelaest"].'" ' . $propriedades . '>';
			$html_tab_drop .= '<thead class="tabelaestcab">';
			$html_tab_drop .= '<tr class="linhacabecalho"><th>';
			$html_tab_drop .= '<table class="tabcab"><thead>';
			$cnj_linhas_tit = [];
			if (isset($opcoes["selecionar_todos"]) && in_array($opcoes["selecionar_todos"],Constantes::array_verdade)) {
				$cnj_linhas_tit["linhatitulos"] = '<tr class="linhatitulos" ';
				$html_linha_titulos = '<th class="col_sel">';
				$html_linha_titulos .= '<img src=';
				$status_selecao = "";
				if ($selecionar_todos) {
					$html_linha_titulos .= '"'. NomesCaminhosRelativos::sjd . '/images/checkbox_checked.png"';
					$status_selecao = "selecionado";
				} else {
					$html_linha_titulos .= '"'. NomesCaminhosRelativos::sjd . '/images/checkbox.png"';
					$status_selecao = "nao selecionado";
				}
				$html_linha_titulos .= ' style="background-color:white;"/></th><th>Selecionar todos</th>';
				$cnj_linhas_tit["linhatitulos"] .= ' selecao_status="' . $status_selecao . '">' . $html_linha_titulos . '</tr>';
			}
			$html_linhas = [];
			if (count($opcoes["opcoes_texto_opcao"]) > 0) {
				if (gettype($opcoes["opcoes_texto_opcao"][array_keys($opcoes["opcoes_texto_opcao"])[0]]) === "array") {
					if ($opcoes["filtro_ativo"] === true) {
						$html_linha_filtros .= '<tr class="linhafiltros"><th></th>';
						$html_linha_filtros .= str_repeat('<th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" /><img class="imglimparfiltro clicavel invisivel" src="' . NomesCaminhosRelativos::sjd . '/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)" /></th>',count($opcoes["opcoes_texto_opcao"][0]));
						$html_linha_filtros .= '</tr>';
						$cnj_linhas_tit["linhafiltros"] = $html_linha_filtros;
					}
					if ($opcoes["selecao_ativa"] === true) {
						foreach($opcoes["opcoes_texto_opcao"] as $chave_opcao => $texto_opcao) {
							$html_linha = "";
							$html_linha .= '<tr data-valor_opcao="' . $opcoes["opcoes_valor_opcao"][$chave_opcao] . '" data-texto_botao="' . $opcoes["opcoes_texto_botao"][$chave_opcao] . '" ';
							$html_celula_sel = '<td class="cel_selecao">';
							$html_img_sel = '<img src="';
							$status_selecao="";
							if ($selecionar_todos) {
								$html_img_sel .= $imagem_selecionado;
								$status_selecao = "selecionado";
							} else {
								if (in_array($chave_opcao,$opcoes["selecionados"])) {
									$html_img_sel .= $imagem_selecionado;
									$status_selecao = "selecionado";
								} else {
									$html_img_sel .= $imagem_selecao;
									$status_selecao = "nao selecionado";
								}
							}
							$html_img_sel .= '" />';
							$html_celula_sel .= $html_img_sel . '</td>';
							$html_celula_opcao = '<td>' . implode('</td><td>' , $texto_opcao ) . '</td>';
							$html_linha .= ' selecao_status="' . $status_selecao . '">'; 
							$html_linha .= $html_celula_sel . $html_celula_opcao ;
							$html_linha .= '</tr>';
							$html_linhas[] = $html_linha;
						}
					} else {				
						foreach($opcoes["opcoes_texto_opcao"] as $chave_opcao => $texto_opcao) {
							$html_linha = "";
							$html_linha .= '<tr data-valor_opcao="' . $opcoes["opcoes_valor_opcao"][$chave_opcao] . '" data-texto_botao="' . $opcoes["opcoes_texto_botao"][$chave_opcao] . '" ';
							$status_selecao="";
							if ($selecionar_todos) {
								$status_selecao = "selecionado";
							} else {
								if (in_array($chave_opcao,$opcoes["selecionados"])) {
									$status_selecao = "selecionado";
								} else {
									$status_selecao = "nao selecionado";
								}
							}
							$html_celula_opcao = '<td>' . implode('</td><td>' , $texto_opcao ) . '</td>';
							$html_linha .= ' selecao_status="' . $status_selecao . '">'; 
							$html_linha .= $html_celula_opcao ;
							$html_linha .= '</tr>';
							$html_linhas[] = $html_linha;
						}
					}				
				} else {
					if ($opcoes["filtro_ativo"] === true) {
						$html_linha_filtros .= '<tr class="linhafiltros">';
						$html_linha_filtros .= '<th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" /><img class="imglimparfiltro clicavel invisivel" src="' . NomesCaminhosRelativos::sjd . '/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)" /></th>';
						$html_linha_filtros .= '</tr>';
						$cnj_linhas_tit["linhafilstros"] = $html_linha_filtros;
					}
					if ($opcoes["selecao_ativa"] === true) {
						foreach($opcoes["opcoes_texto_opcao"] as $chave_opcao => $texto_opcao) {
							$html_linha = "";
							$html_linha .= '<tr data-valor_opcao="' . $opcoes["opcoes_valor_opcao"][$chave_opcao] . '" data-texto_botao="' . $opcoes["opcoes_texto_botao"][$chave_opcao] . '" ';
							$html_celula_sel = '<td class="cel_selecao">';
							$html_img_sel = '<img src="';
							$status_selecao="";
							if ($selecionar_todos) {
								$html_img_sel .= $imagem_selecionado;
								$status_selecao = "selecionado";
							} else {
								if (in_array($chave_opcao,$opcoes["selecionados"])) {
									$html_img_sel .= $imagem_selecionado;
									$status_selecao = "selecionado";
								} else {
									$html_img_sel .= $imagem_selecao;
									$status_selecao = "nao selecionado";
								}
							}
							$html_img_sel .= '" />';
							$html_celula_sel .= $html_img_sel . '</td>';
							$html_celula_opcao = '<td>' . $texto_opcao . '</td>';
							$html_linha .= ' selecao_status="' . $status_selecao . '">'; 
							$html_linha .= $html_celula_sel . $html_celula_opcao ;
							$html_linha .= '</tr>';
							$html_linhas[] = $html_linha;
						}
					} else {
						foreach($opcoes["opcoes_texto_opcao"] as $chave_opcao => $texto_opcao) {
							$html_linha = "";
							$html_linha .= '<tr data-valor_opcao="' . $opcoes["opcoes_valor_opcao"][$chave_opcao] . '" data-texto_botao="' . $opcoes["opcoes_texto_botao"][$chave_opcao] . '" ';					
							$status_selecao="";
							if ($selecionar_todos) {
								$status_selecao = "selecionado";
							} else {
								if (in_array($chave_opcao,$opcoes["selecionados"])) {
									$status_selecao = "selecionado";
								} else {
									$status_selecao = "nao selecionado";
								}
							}					
							$html_celula_opcao = '<td>' . $texto_opcao . '</td>';
							$html_linha .= ' selecao_status="' . $status_selecao . '">'; 
							$html_linha .= $html_celula_opcao ;
							$html_linha .= '</tr>';
							$html_linhas[] = $html_linha;
						}
					}
				}
			}
			$html_tab_drop .= implode("",$cnj_linhas_tit);
			$html_tab_drop .= '</thead></table>';
			$html_tab_drop .= '</th></tr></thead>';
			$html_tab_drop .= '<tbody class="tabelaestcorpo">';
			$html_tab_drop .= '<tr class="linhacorpo"><td>';		
			$html_tab_drop .= '<table class="tabcorpo">';
			$html_tab_drop .= '<tbody>';
			$html_tab_drop .= implode("",$html_linhas);
			$html_tab_drop .= '</tbody>';
			$html_tab_drop .= '</table>';
			$html_tab_drop .= '</td></tr>';
			$html_tab_drop .= '</tbody>';
			$html_tab_drop .= '</table>';
			$html_div_drop .= $html_tab_drop;
			$html_div_drop .= '</div>';
			return $html_div_drop;
		}		
		public static function pesquisar_tipo_elemento_html($nome_tipo_elemento_html,$forcar_pesquisa_banco_dados=false){
			$tipo_elemento=null;
			if($forcar_pesquisa_banco_dados!==true){
				$tipo_elemento=FuncoesSisJD::pesquisar_dado_global(["tipos_elementos_html",$nome_tipo_elemento_html]);
			}
			if(isset($tipo_elemento)!==true){
				$comando_sql="select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "tiposelementoshtml where tag='".$nome_tipo_elemento_html."'";
				$tipo_elemento = 
					FuncoesSisJD::setar_dado_global(
							[
								"tipos_elementos_html",
								$nome_tipo_elemento_html
							],
							FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC)
					);
			}
			return $tipo_elemento;	
		}
		public static function obter_ligcamposis($comhttp,$aliascamposis){
			$retorno = null;
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"])) {
				foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["ligscamposis"] as &$ligcamposis) {
					if (strcasecmp(trim($ligcamposis["alias"]),trim($aliascamposis)) == 0 || 
						strcasecmp(trim($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["camposis"][$ligcamposis["codcamposis"]]["alias"]),trim($aliascamposis)) == 0 ||
						strcasecmp(trim($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["conjuntos_dados"]["camposis"][$ligcamposis["codcamposis"]]["nomecamposis"]),trim($aliascamposis)) == 0) {
						$retorno = $ligcamposis;
						break;
					}
				}
			}
			return $retorno;
		}
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
					} else if (FuncoesString::str_contem($texto_celula,["qt","qtd","qtde","quantid"])) {
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
		public static function montar_linhas_tit_tabela_est_html(&$comhttp,$usar_dados_opcoes,$ignorar_multidimens = false) {
			$opcoes = &$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"];
			$origem_dados = [];
			$colgroups = [];
			$texto_html_titulo = "";
			$celulas_linha_calculos = [];
			$valores_celulas_linhas_calculos = [];
			$texto_html_linha_titulos = "";
			$texto_html_linha_filtros = "";
			$html_ord_tit = "";
			$classe_cel_tit = "cel_tit_campodb";
			$onclick_cel_tit = "";
			$arr_linhas = [];
			$arr_linhas_html = [];
			$texto_html_linhas = [];
			$texto_html_linha = "";
			$texto_img_ocultar_coluna = "";
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
				array_unshift($celulas_linha_filtros,'<th class="cel_sub_tit_filtro"></th>');
				array_unshift($celulas_linha_calculos,'<th class="cel_sub_rod">');
				array_unshift($valores_celulas_linhas_calculos,"");
				array_unshift($colgroups,'<col class="cel_sub"/>');
			}
			if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho"],0,"quantidade","maior") === true) {
				if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ativo"]) === true) {
					/*cria o txto inicial do cabecalho*/
					/*$texto_html_titulo .= '<thead class="tabelaestcab" ';
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["visivel"]) !== true) {
						$texto_html_titulo .= ' style="display:none" ' ;
					}
					$texto_html_titulo .= '><tr class="linhacabecalho"><th>';
					$texto_html_titulo .= '<table class="tabcab">*/
					$texto_html_titulo .= '<thead>';
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
						$texto_html_titulo .= '<tr class="linhacomandos"><th class="col_comandos" colspan="999" style="background-color:black;text-align:left;padding:2px;">';
						if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["comandos"],0,"quantidade","maior")) {
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["inclusao","ativo"],true)) {
								$texto_html_titulo .= '<button class="btncomandos item_destaque_hover btn btn-secondary '.$classe_botao.'" onclick="window.fnhtml.fntabdados.acrescentar_registro(this)" title="Acrescentar"><img class="imgbtncomandos '.$classe_imgs.'" src="' . NomesCaminhosRelativos::sjd . '/images/maisverde32.png"  />Acrescentar</button>';
							}		
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["exportacao","ativo"],true)) {			
								$texto_html_titulo .= '<button class="btncomandos item_destaque_hover btn btn-secondary '.$classe_botao.'" onclick="window.fnhtml.fntabdados.exportar_dados(this)"  title="Exportar"><img class="imgbtncomandos '.$classe_imgs.'" src="' . NomesCaminhosRelativos::sjd . '/images/exportar1_32.png" />Exportar</button>';
							}
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["compartilhar","ativo"],true)) {			
								$texto_html_titulo .= '<button class="btncomandos item_destaque_hover btn btn-secondary '.$classe_botao.'" onclick="window.fnhtml.fntabdados.compartilhar_dados(event,this)"  title="Compartilhar esta tabela"><img class="imgbtncomandos '.$classe_imgs.'" src="'. NomesCaminhosRelativos::sjd . '/images/tabela_est/compartilhar.png" />Compartilhar</button>';
							}
							/*if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["mostrarcolunasocultas","ativo"],true)) {			
								$texto_html_titulo .= '<button class="btncomandos item_destaque_hover '.$classe_botao.'" onclick="window.fnhtml.fntabdados.mostrar_colunas_ocultas(event,this)"  title="Mostrar colunas ocultas"><img class="imgbtncomandos '.$classe_imgs.'" src="'. NomesCaminhosRelativos::sjd . '/images/olho.png" />Mostrar Colunas</button>';
							}*/
							if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"]["comandos"],["outroscomandos"],0,"quantidade","maior") === true) {
								foreach($opcoes["cabecalho"]["comandos"]["outroscomandos"] as $outrocomando) {
									$texto_html_titulo .= '<button class="btncomandos item_destaque_hover btn btn-secondary '.$classe_botao.'" onclick="'.$outrocomando["onclick"].'"  title="'.$outrocomando["title"].'"><img class="imgbtncomandos '.$classe_imgs.'" src="'.$outrocomando["imagem"].'" />'.$outrocomando["texto"].'</button>';				
								}
							}
						}
						$texto_html_titulo .= '</th></tr>';				
					}
					/*fim montagem da linha de botoes de comandos*/

					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["linhas_adicionais"],0,"contagem","maior")===true) {			
						$texto_html_titulo .= implode('',$opcoes["cabecalho"]["linhas_adicionais"]);
					}
					if (!isset($opcoes["campos_visiveis"])) {
						$opcoes["campos_visiveis"] = ["todos"];
					}
					if (gettype($opcoes["campos_visiveis"]) !== "array") {
						$opcoes["campos_visiveis"] = explode(",",$opcoes["campos_visiveis"]);
					}
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ordenacao","ativo"],true)) {
						$html_ord_tit = '<img class="imgord item_destaque50pct_hover" src="' . NomesCaminhosRelativos::sjd . '/images/green-unsorted.gif" />';
						$classe_cel_tit .= " clicavel";
						$onclick_cel_tit = ' onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" ';
					}
					if (FuncoesArray::verif_valor_chave($opcoes["cabecalho"],["ocultarcolunas","ativo"],true)) {
						$texto_img_ocultar_coluna = '<img class="img_ocultar_col item_destaque50pct_hover" src="'.NomesCaminhosRelativos::sjd.'/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna" />';
					}
					$tem_processo_estruturado = FuncoesConversao::como_boleano(isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"])?true:false);

					/*separa os campos conforme a indicacao da linha*/
					$arr_linhas = [];

					/*corrige o colspan superior se houver celula invisivel como sub com sup com colspan > 1*/
					$origem_campos_temp = $origem_campos;
					$ligcamposis = [];
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
								$arr_linhas_html[$chave_lin][$chave_cel] = 	'<th ' .
									(isset($celula["colspan"])?' colspan="' . $celula["colspan"] . '" ':'') . 
									(isset($celula["rowspan"])?' rowspan="' . $celula["rowspan"] . '" ':'') . 
									' visivel="'.$visivel.'" visivel_inclusao="'.$visivel_inclusao.'" '.
									' class="'.$classe_cel_tit. " celula_final_tit " . $classe_nao_mostrar . $classe_bloqueio .$opcoes["classes_cels"][$celula["coluna"]].'" '.
									' data-campodb="' . strtolower($texto_celula) . '"'.$onclick_cel_tit.' title="'.$title.'" cod="'.$celula["cod"].'" codsup="'.$celula["codsup"].'" '.
									' indexreal="'.(isset($celula["indexreal"])?$celula["indexreal"]:"").'" cnj_nomes_campos_db="'.(isset($cnj_nomes_campos_db) && $cnj_nomes_campos_db!== null?strtolower(implode(",",$cnj_nomes_campos_db)):"").'" ' .
									implode(' ',$propriedades_html) . ' ' .
									'><div class="div_conteudo_celula_titulo d-flex">' .
									'<text class="txttit w-auto m-auto">' . strtoupper($texto_celula) . '</text>' .  $html_ord_tit . $texto_img_ocultar_coluna . 						
									'</div></th>';
								$celulas_linha_filtros[] = '<th class="cel_tit_filtro ' . $classe_nao_mostrar . '">'.	
									'<input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro" /><img class="imglimparfiltro clicavel invisivel" src="' . NomesCaminhosRelativos::sjd . '/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)" />' .
									'</th>';							
								$colgroups[] = '<col class="'.$opcoes["classes_cels"][$celula["coluna"]].'"/>';
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
								$celulas_linha_calculos[$celula["coluna"]] = '<th class="cel_linha_calc '.$classe_nao_mostrar.$opcoes["classes_cels"][$celula["coluna"]].' '.$classe_cel_cont.'">';									
							} else {
								if (strcasecmp(trim($texto_celula),"cmd") == 0) {
									$arr_linhas_html[$chave_lin][$chave_cel] = 	'<th ' .
										(isset($celula["colspan"])?' colspan="' . $celula["colspan"] . '" ':'') . 
										(isset($celula["rowspan"])?' rowspan="' . $celula["rowspan"] . '" ':'') . 
										' class="cel_cmd_tit" '.
										(isset($celula["cod"])?' cod="'.$celula["cod"].'" ':'') .
										(isset($celula["codsup"])?' codsup="'.$celula["codsup"].'" ':'') .
										(isset($celula["indexreal"])?' indexreal="'.$celula["indexreal"].'" ':'') .
										'>' .
										'<text class="txttit item_destaque_hover  w-auto m-auto">' . strtoupper($texto_celula) . '</text>'  .						
										'</th>';
								} else if (strcasecmp(trim($texto_celula),"sub") == 0) {
									$arr_linhas_html[$chave_lin][$chave_cel] = 	'<th ' .
										(isset($celula["colspan"])?' colspan="' . $celula["colspan"] . '" ':'') . 
										(isset($celula["rowspan"])?' rowspan="' . $celula["rowspan"] . '" ':'') . 
										' class="cel_sub_tit" '.
										(isset($celula["cod"])?' cod="'.$celula["cod"].'" ':'') .
										(isset($celula["codsup"])?' codsup="'.$celula["codsup"].'" ':'') .
										(isset($celula["indexreal"])?' indexreal="'.$celula["indexreal"].'" ':'') .
										'>' .
										'<text class="txttit item_destaque_hover  w-auto m-auto">' . strtoupper($texto_celula) . '</text>'  .						
										'</th>';
								} else {
									$arr_linhas_html[$chave_lin][$chave_cel] = 	'<th ' .
										(isset($celula["colspan"])?' colspan="' . $celula["colspan"] . '" ':'') . 
										(isset($celula["rowspan"])?' rowspan="' . $celula["rowspan"] . '" ':'') . 
										' class="'.$classe_cel_tit .'" '.
										(isset($celula["cod"])?' cod="'.$celula["cod"].'" ':'') .
										(isset($celula["codsup"])?' codsup="'.$celula["codsup"].'" ':'') .
										(isset($celula["indexreal"])?' indexreal="'.$celula["indexreal"].'" ':'') .
										'>' .
										'<text class="txttit item_destaque_hover  w-auto m-auto">' . strtoupper($texto_celula) . '</text>'  .						
										'</th>';
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
							$celulas_linha_filtros[] = '<th class="cel_tit_filtro">'.	
									'<input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro" /><img class="imglimparfiltro clicavel invisivel" src="' . NomesCaminhosRelativos::sjd . '/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)" />' .
									'</th>';							
							$celulas_linha_calculos[] = '<th>';
							$valores_celulas_linhas_calculos[] = 0;
						}
					}
					if (FuncoesArray::verif_valor_chave($opcoes,["corpo","linhas","comandos","ativo"],true)) {
						$celulas_linha_filtros[] = '<th class="cel_tit_cmd_filtro"></th>';
						$celulas_linha_calculos[] = '<th class="cel_sub_rod">';
						$valores_celulas_linhas_calculos = "";
					}
					if (FuncoesArray::verif_valor_chave($opcoes,["cabecalho","filtro","ativo"],true)) {			
						$arr_linhas_html["linhafiltros"] = $celulas_linha_filtros;
					}
					foreach($arr_linhas_html as $chave_lin => &$linha_html) {
						if ($chave_lin === "linhafiltros") {
							$linha_html = '<tr class="linhafiltros">'.
								implode('',$linha_html) . 
								'</tr>';
						} else if ($chave_lin === $ult_chave_lin) {
							$linha_html = '<tr class="linhatitulos">'.
								implode('',$linha_html) . 
								'</tr>';
						} else {
							$linha_html = '<tr>'.
								implode('',$linha_html) . 
								'</tr>';
						}
					}
					$texto_linhas_titulo = implode('',$arr_linhas_html);
					$texto_html_titulo .= $texto_linhas_titulo;
					$texto_html_titulo .= '</thead>';
					//</table></th></tr></thead>';		
				}
				$opcoes["valores_celulas_linhas_calculos"] = $valores_celulas_linhas_calculos;		
				$opcoes["celulas_linha_calculos"] = $celulas_linha_calculos;
				$opcoes["indices_campos_ocultos"] = $ind_campos_ocultos;
				$opcoes["indices_campos_bloqueados"] = $ind_campos_bloqueados;
			}
			$texto_html_titulo = '<colgroup>' . implode("",$colgroups). '</colgroup>' . $texto_html_titulo;
			return $texto_html_titulo;
		}

		public static function montar_rodape_tabela_est_html(&$comhttp,$usar_dados_opcoes) {
			$opcoes = &$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"];
			$texto_html_rod = null;
			if(FuncoesArray::verif_valor_chave($opcoes,["rodape","ativo"]) === true){
				$texto_html_rod = '<tfoot><tr class="linhacalculos linhatotais">';
				foreach($opcoes["celulas_linha_calculos"] as $chave=>&$cel_calc) {
					if (strcasecmp(trim($chave),"sub") != 0) {
						if ($opcoes["campo_contador"] === $chave && $opcoes["campo_totais"] !== $chave ) {
							$opcoes["celulas_linha_calculos"][$chave] .= /*number_format($opcoes["valores_celulas_linhas_calculos"][$chave],0,",",".") . */'</th>';			
						} else if ((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"") === "") {
							$opcoes["celulas_linha_calculos"][$chave] .= '</th>';
						} else if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_quant","cel_valor","cel_peso","cel_perc","cel_perc_med","cel_quantdec_med"]) && $opcoes["campo_totais"] !== $chave) {			
							if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_perc_med","cel_quantdec_med"])) {
								if ($opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]] === 0) {							
									$opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]] = 1;
								}
								$opcoes["celulas_linha_calculos"][$chave] .= number_format($opcoes["valores_celulas_linhas_calculos"][$chave] / $opcoes["valores_celulas_linhas_calculos"][$opcoes["campo_contador"]],2,",",".") . '</th>';			
							} else {
								if (isset($opcoes["valores_celulas_linhas_calculos"][$chave])) {
									$opcoes["celulas_linha_calculos"][$chave] .= number_format($opcoes["valores_celulas_linhas_calculos"][$chave],2,",",".") . '</th>';			
								}
							}
						} else if (in_array((isset($opcoes["classes_cels"][$chave])?$opcoes["classes_cels"][$chave]:"X"),["cel_quantdec"]) && $opcoes["campo_totais"] !== $chave) {
							$qtdec = (strpos($opcoes["valores_celulas_linhas_calculos"][$chave],".") !== false?strlen($opcoes["valores_celulas_linhas_calculos"][$chave]) - strpos($opcoes["valores_celulas_linhas_calculos"][$chave],".") - 1:0);
							$opcoes["celulas_linha_calculos"][$chave] .= number_format($opcoes["valores_celulas_linhas_calculos"][$chave],0,",",".") . '</th>';			
						} else {
							$opcoes["celulas_linha_calculos"][$chave] .= (isset($opcoes["valores_celulas_linhas_calculos"][$chave])?$opcoes["valores_celulas_linhas_calculos"][$chave]:'') . '</th>';			
						}
					}
				}
				$texto_html_rod .= implode('',$opcoes["celulas_linha_calculos"]);
				$texto_html_rod .= '</tr>';
				if (count($opcoes["rodape"]["linhasextras"]) > 0) {
					$texto_html_rod .= implode('',$opcoes["rodape"]["linhasextras"]);
				}
				$texto_html_rod .= '</tfoot>';
			}
			return $texto_html_rod;
		}
		

		/**
		 * montar um json com as propriedades (html) a serem interpretadas pelo lado cliente
		 * @created 21/07/2021
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


		public static function montar_rotulos_boxs_editaveis(&$comhttp,$opcoes){
			$texto_html="";
			$tipo_elemento_rotulo=self::pesquisar_tipo_elemento_html("rotulo");
			$tipo_elemento_caixa_texto=self::pesquisar_tipo_elemento_html("caixa_texto");
			if (isset($comhttp->retorno->dados_retornados["dados"]["tabela"])) {
				foreach($comhttp->retorno->dados_retornados as $texto_rotulo=>$valor_box){
					$cnjprops=[];
					switch($opcoes["grid"]){
						case "linha":
							$cnjprops["style"]="display:table-cell;";
							break;
						default:
							$cnjprops["style"]="display:grid;";
							break;
					}
					if(isset($opcoes["campos_visiveis"])){
						if(in_array($texto_rotulo,$opcoes["campos_visiveis"])!==true&&$opcoes["campos_visiveis"][0]!=="TODOS"){
							$cnjprops["style"]="display:none;";
						}			
					} 
					if(isset($opcoes["campos_ocultos"])){
						if (in_array($campo,$opcoes["campos_ocultos"])||in_array($campo,$opcoes["indices_campos_ocultos"])) {
							$cnjprops["style"]="display:none;";
						}
					} 		
					if(isset($opcoes["campos_editaveis"])){
						if(in_array($texto_rotulo,$opcoes["campos_editaveis"])!==true){
							$cnjprops["disabled"]="disabled";
						}
					} 		
					if(isset($opcoes["campos_bloqueados"])){
						if(in_array($texto_rotulo,$opcoes["campos_bloqueados"])){
							$cnjprops["disabled"]="disabled";
						}
					} 
					$cnjpropsinput=$cnjprops;
					$cnjpropslabel=$cnjprops;
					$cnjpropslabel["style"].="border:1px solid black; padding:2px; margin:3px;font-weight:bolder";
					$cnjpropsinput["value"]=$valor_box;
					$cnjpropsinput["style"].="width:95%";
					$texto_html.=self::mont_abert_elem_html($tipo_elemento_rotulo,true,$cnjpropslabel);
					$texto_html.=$texto_rotulo;
					$texto_html.=self::mont_abert_elem_html($tipo_elemento_caixa_texto,true,$cnjpropsinput);
					$texto_html.=self::mont_fech_elem_html($tipo_elemento_caixa_texto);
					$texto_html.=self::mont_fech_elem_html($tipo_elemento_rotulo);
				}
			} else {
				foreach($comhttp->retorno->dados_retornados[0] as $texto_rotulo=>$valor_box){
					$cnjprops=[];
					switch($opcoes["grid"]){
						case "linha":
							$cnjprops["style"]="display:table-cell;";
							break;
						default:
							$cnjprops["style"]="display:grid;";
							break;
					}
					if(isset($opcoes["campos_visiveis"])){
						if(in_array($texto_rotulo,$opcoes["campos_visiveis"])!==true&&$opcoes["campos_visiveis"][0]!=="TODOS"){
							$cnjprops["style"]="display:none;";
						}			
					} 
					if(isset($opcoes["campos_ocultos"])){
						if (in_array($campo,$opcoes["campos_ocultos"])||in_array($campo,$opcoes["indices_campos_ocultos"])) {
							$cnjprops["style"]="display:none;";
						}
					} 		
					if(isset($opcoes["campos_editaveis"])){
						if(in_array($texto_rotulo,$opcoes["campos_editaveis"])!==true){
							$cnjprops["disabled"]="disabled";
						}
					} 		
					if(isset($opcoes["campos_bloqueados"])){
						if(in_array($texto_rotulo,$opcoes["campos_bloqueados"])){
							$cnjprops["disabled"]="disabled";
						}
					} 
					$cnjpropsinput=$cnjprops;
					$cnjpropslabel=$cnjprops;
					$cnjpropslabel["style"].="border:1px solid black; padding:2px; margin:3px;font-weight:bolder";
					$cnjpropsinput["value"]=$valor_box;
					$cnjpropsinput["style"].="width:95%";
					$texto_html.=self::mont_abert_elem_html($tipo_elemento_rotulo,true,$cnjpropslabel);
					$texto_html.=$texto_rotulo;
					$texto_html.=self::mont_abert_elem_html($tipo_elemento_caixa_texto,true,$cnjpropsinput);
					$texto_html.=self::mont_fech_elem_html($tipo_elemento_caixa_texto);
					$texto_html.=self::mont_fech_elem_html($tipo_elemento_rotulo);
				}		
			}
			return $texto_html;
		}
		public static function montar_area_texto_html(&$comhttp,$opcoes){
			$texto_html="";
			$tipo_elemento_texto=self::pesquisar_tipo_elemento_html("area_texto");
			$texto_html.=self::mont_abert_elem_html($tipo_elemento_texto,true,["style"=>"width:99%;height:90%"]);
			if(count($comhttp->retorno->dados_retornados)>0){
				foreach($comhttp->retorno->dados_retornados[0] as $dado_retornado){
					$texto_html.=$dado_retornado;
				}	
			}
			$texto_html.=self::mont_fech_elem_html($tipo_elemento_texto);	
			return $texto_html;
		}

		public static function preparar_params_comboboxes_condicionante(?array $params=[]) : string {
			$retorno = [];
			$params = $params ?? [];
			$html_combobox_condicionantes = "";
			$html_condicionante = "";
			$contcond = 0;
			if (in_array(gettype($params["dados"]),["object","resource"])) {
				$params["dados"] = stream_get_contents($params["dados"]);
			}
			$dados_condicionantes = FuncoesRequisicao::preparar_condicionantes_processo($params["dados"]);
			unset($params["dados"]);
			$params["num_max_texto_botao"] = 5;
			$visoes = Constantes::$visoes ?? FuncoesSisJD::obter_visoes_relatorio_venda();
			if (gettype($visoes) === "array") {
				$visoes = implode(",",$visoes);				
			}			
			$visoes = explode(",",strtolower(trim($visoes)));			
			foreach($dados_condicionantes as $chave_condic=>&$condicionante) {
				$contcond++;
				$html_condicionante = "";
				$html_condicionante .= '<div class="div_container_combobox div_container_combobox_condicionante col-md-auto w-auto mb-1">';
				$html_condicionante .= '<div class="div_opcao container border rounded movivel">';
				$html_condicionante .= '<div class="div_opcao_tit row">Condicionante '.$contcond . '</div>';
				$html_condicionante .= '<div class="div_opcao_controles row">';
				$visao = $chave_condic;
				$selecionados = array_search($visao,$visoes);
				$opcoes_combobox_visao = $params;
				$opcoes_combobox_visao["tem_inputs"] = $opcoes_combobox_visao["tem_inputs"] ?? true;
				$opcoes_combobox_visao["itens"] = (gettype($visoes)==="array"?$visoes:explode(",",$visoes));
				$opcoes_combobox_visao["selecionados"] = (gettype($selecionados)==="array"?$selecionados:explode(",",$selecionados));		
				$opcoes_combobox_visao["aoselecionaropcao"]="selecionado_condicionante(this)";				
				$html_combobox_visao = self::montar_combobox_visao($opcoes_combobox_visao);
				$opcoes_combobox_operacao = [];
				$opcoes_combobox_operacao["tem_inputs"] = true;
				$opcoes_combobox_operacao["itens"] = ["Igual a","Diferente de"];
				if ($condicionante[0]["op"] === "!=") {
					$opcoes_combobox_operacao["selecionados"] = [1];
				} else {
					$opcoes_combobox_operacao["selecionados"] = [0];
				}
				$opcoes_combobox_operacao["tipo"] = "radio";
				$opcoes_combobox_operacao["multiplo"] = 0;
				$opcoes_combobox_operacao["selecionar_todos"] = 0;
				$opcoes_combobox_operacao["filtro"] = 0;		
				$opcoes_combobox_operacao["propriedades_html"] = [];
				$opcoes_combobox_operacao["propriedades_html"][] = ["propriedade" => "class" ,"valor" => "operacao"];
				$opcoes_combobox_operacao["permite_selecao"] = $params["permite_selecao"] ?? true;
				$comhttpnull = null;
				$html_comparador = self::montar_combobox($opcoes_combobox_operacao);	
				$selecionados = [];
				foreach($condicionante as $condic) {
					$selecionados[] = $condic["valor"];
				}
				$forcar_selecao_por_valores = true;
				//print_r($selecionados);exit();
				$html_dados_condicionante = self::montar_combobox_condicionante([
					"visao"=>$visao,
					"selecionados"=>$selecionados,
					"forcar_selecao_por_valores"=>$forcar_selecao_por_valores,
					"permite_selecao"=>$params["permite_selecao"]
				]);
				$html_condicionante .= '<div class="div_opcao_controles_comp col-auto">';
					$html_condicionante .= '<div class="row">';
						$html_condicionante .= '<div class="col-auto">';
						$html_condicionante .= $html_combobox_visao ;
						$html_condicionante .= '</div>';
						$html_condicionante .= '<div class="col-auto">';
						$html_condicionante .= $html_comparador;
						$html_condicionante .= '</div>';
						$html_condicionante .= '<div class="col-auto">';
						$html_condicionante .= $html_dados_condicionante;
						$html_condicionante .= '</div>';
					$html_condicionante .= '</div>';
				$html_condicionante .= '</div>';
				$html_condicionante .= '<div class="div_opcao_controles_btns_img col-md-auto w-auto">';
				if (FuncoesArray::verif_valor_chave($params,["permite_incluir"])) {
					$html_condicionante .= '<img class="btn_img_add_ctrl mousehover clicavel rounded" src="/'.NomesDiretorios::base_sis.'/images/maisverde32.png" onclick="inserir_condicionante_pesquisa({elemento:this,forcar_quebra:true})" title="Acrescenta ao lado deste">';		
				}
				if (FuncoesArray::verif_valor_chave($params,["permite_incluir"])&&FuncoesArray::verif_valor_chave($params,["permite_excluir"])) {
					$html_condicionante .= '<br />';
				}
				if (FuncoesArray::verif_valor_chave($params,["permite_excluir"])) {
					$html_condicionante .= '<img class="btn_img_excl_ctrl mousehover clicavel rounded" src="/'.NomesDiretorios::base_sis.'/images/delete.png" onclick="deletar_controles(this)" title="Exclui este controle">';
				}
				$html_condicionante .= '</div>';
				$html_condicionante .= '</div></div></div>';
				$html_combobox_condicionantes .= $html_condicionante . '<br />';
			}
			$retorno = $html_combobox_condicionantes;
			return $retorno;			
		}

		public static function montar_navs($params = []) {
			$retorno = '';
			$params["type_navs"] = $params["type_navs"] ?? "tab";		
			$params["navs"] = $params["navs"] ?? [];		
			$retorno .= '<div class="div_container_abas">';
				switch(strtolower(trim($params["type_navs"]))) {
					case "pill": case "pills":
						$retorno .= '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="display:inline-block !important;white-space: nowrap !important">';
						$contnav = 0;
						foreach($params["navs"] as $nav) {
							$retorno .= '<li class="nav-item" style="display:inline-block !important">';
							$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
							$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
							$navname = 'pills-' . $contnav;						
							$retorno .= '<a class="nav-link '. $active . '" id="'.$navname.'-tab" data-bs-toggle="pill" href="#'. $navname .'" role="tab" aria-controls="'.$navname.'" aria-selected="'.$selected.'">'.(isset($nav["title"])?$nav["title"]:'').'</a>';
							$retorno .= '</li>';
							$contnav++;
						}
						$retorno .= '</ul>';	
						$retorno .= '<div class="tab-content" id="pills-tabContent">';
						$contnav = 0;
						foreach($params["navs"] as $nav) {
							$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
							$show = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"show":"");
							$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
							$navname = 'pills-' . $contnav;
							$retorno .= '<div class="tab-pane fade '. $show .' '. $active .' ' . (isset($nav["class"])?$nav["class"]:'') . '" id="'.$navname.'" role="tabpanel" aria-labelledby="'.$navname.'-tab">'.(isset($nav["data"])?$nav["data"]:'').'</div>';
							$contnav++;
						}
						$retorno .= '</div>';					
						break;
					default: //case "tab": case "tabs": case "tabbed":
						$retorno .= '<nav>';
							$retorno .= '<div class="nav nav-tabs" id="nav-tab" role="tablist">';
							$contnav = 0;
							foreach($params["navs"] as $nav) {
								$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
								$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
								$navname = 'nav-' . $contnav;
								$retorno .= '<a class="nav-item nav-link '. $active . '" id="'.$navname.'-tab" data-bs-toggle="tab" href="#'. $navname .'" role="tab" aria-controls="'.$navname.'" aria-selected="'.$selected.'">'.(isset($nav["title"])?$nav["title"]:'').'</a>';
								$contnav++;
							}
							$retorno .= '</div>';				
						$retorno .= '</nav>';
						$retorno .= '<div class="tab-content" id="nav-tabContent">';
						$contnav = 0;
						foreach($params["navs"] as $nav) {
							$active = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"active":"");
							$show = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"show":"");
							$selected = ((isset($nav["active"]) && ($nav["active"] === true || $nav["active"] === "active"))?"true":"false");
							$navname = 'nav-' . $contnav;
							$retorno .= '<div class="tab-pane fade ' . $show . ' '. $active .' ' . (isset($nav["class"])?$nav["class"]:'') . '" id="'.$navname.'" role="tabpanel" aria-labelledby="'.$navname.'-tab">'.(isset($nav["data"])?$nav["data"]:'').'</div>';
							$contnav++;
						}
						$retorno .= '</div>';
						break;
				}			
			$retorno .= '</div>';
			return $retorno;
		}

		public static function montar_estrutura_master_detail($params = []) {
			$retorno = '';			
			$params["master"] = $params["master"] ?? [];
			$params["detail"] = $params["detail"] ?? [];
			$params["master"]["title"] = $params["master"]["title"] ?? "master";
			$params["master"]["data"] = $params["master"]["data"] ?? "data";
			$params["master"]["cols"] = $params["master"]["cols"] ?? "3";
			$params["detail"]["title"] = $params["detail"]["title"] ?? "detail";
			$params["detail"]["data"] = $params["detail"]["data"] ?? "data";
			
			$retorno .= '<div class="row">';
				$retorno .= '<div class="col-'.$params["master"]["cols"].' m-1 resize">';
					$retorno .= '<div class="card w-100 h-100">';
						$retorno .= '<div class="card-header">';
							$retorno .= $params["master"]["title"];
						$retorno .= '</div>';
						$retorno .= '<div class="card-body '.(isset($params["master"]["class"])?$params["master"]["class"]:'').'">';
							$retorno .= $params["master"]["data"];
						$retorno .= '</div>';
					$retorno .= '</div>';
				$retorno .= '</div>';
				$retorno .= '<div class="col-'.(11 - $params["master"]["cols"]).' m-1 resize">';
					$retorno .= '<div class="card w-100 h-100">';
						$retorno .= '<div class="card-header">';
							$retorno .= $params["detail"]["title"];
						$retorno .= '</div>';
						$retorno .= '<div class="card-body '.(isset($params["detail"]["class"])?$params["detail"]["class"]:'').'">';
							$retorno .= $params["detail"]["data"];
						$retorno .= '</div>';
					$retorno .= '</div>';
				$retorno .= '</div>';
			$retorno .= '</div>';
			return $retorno;
		}

		public static function montar_inputgroup_mes_ano($params = []) {
			$params = $params ?? [];
			$retorno = '';
			$params["mes"] = FuncoesConversao::como_numero($params["mes"] ?? (FuncoesData::mes_atual() - 1));
			$params["ano"] = $params["ano"] ?? FuncoesData::ano_atual();
			$retorno .= '<div class="input-group input_group_mes_ano '.($params["class"] ?? "").'" style="'.($params["style"] ?? "").'">';
				$retorno .= self::montar_combobox_meses(["multiplo"=>0,"selecionados"=>$params["mes"]]);
				$retorno .= '<input class="form-control input_ano" type="number" step="1" value="'.$params["ano"].'" />';
			$retorno .= '</div>';
			return $retorno;
		}

		public static function montar_card_inputgroup_mes_ano($params = []) {
			$params = $params ?? [];
			$retorno = '';			
			$retorno .= '<div class="card ' . ($params["class"] ?? "") . '">';
				$retorno .= '<div class="card-header">';
				$retorno .= '</div>';
				$retorno .= '<div class="card-body">';
					$retorno .= self::montar_inputgroup_mes_ano($params);
				$retorno .= '</div>';
			$retorno .= '</div>';
			return $retorno;
		}

		public static function montar_elemento_html_sisjd(?array $params = []) : string{
			$retorno="";
			switch($params["tipoelemento"]){
				case "comboboxes_condicionante":
					$params_combobox_condicionantes = self::preparar_params_comboboxes_condicionante($params);
					print_r($params_combobox_condicionantes); exit();
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
		public static function obter_condicionantes_restritivas($condicionantes,$retorno = []) {
			if (isset($condicionantes)) {
				$condtemp = $condicionantes;
				if (gettype($condtemp) !== "array") {
					$condtemp = explode(strtolower(Constantes::sepn1),strtolower($condtemp));
				}
				foreach($condtemp as &$condt) {
					if (stripos($condt,Constantes::sepn2) !== false) {
						$condt = explode(strtolower(Constantes::sepn2),strtolower($condt));
					}
				}
				foreach($condtemp as $chave=>&$val) {
					if (gettype($val) === "array") {
						foreach($val as &$subval) {
							if (strpos($subval,"[") !== false) {
								$subval = substr($subval,strpos($subval,"[")+1);
								$subval = substr($subval,0,strpos($subval,"]"));
							}
							$subval = explode(" and ",$subval);
						}
					} else {
						if (strpos($val,"[") !== false) {
							$val = substr($val,strpos($val,"[")+1);
							$val = substr($val,0,strpos($val,"]"));
						}
						$val = explode(" and ",$val);
					}
					foreach($val as $ch=>&$vl) {
						if (gettype($vl) === "array") {
							foreach($vl as $v) {
								$v = trim(str_replace(".","",substr($v,strpos($v,"."))));
								$resultados_regex = [];
								preg_match('/\w*\=\w*/',$v,$resultados_regex);
								if (count($resultados_regex) > 0) {
									$retorno[] = $v;
								}	
							}
						} else {
							$vl = trim(str_replace(".","",substr($vl,strpos($vl,"."))));
							$resultados_regex = [];
							preg_match('/\w*\=\w*/',$vl,$resultados_regex);
							if (count($resultados_regex) > 0) {
								$retorno[] = $vl;
							}
						}
					}
				}
				$retorno = FuncoesArray::chaves_associativas($retorno);
			}
			return $retorno;
		}
		public static function montar_dados_linha_padrao(&$comhttp,&$opcoes){
			/*constroi os dados da linha padrao, que e invisivel e serve de base para inclusoes*/
			$arrtit = [];
			if (FuncoesArray::verif_valor_chave($opcoes,["usar_dados_opcoes"],true)) {		
				$arrtit = $opcoes["dados"]["tabela"]["titulo"]["arr_tit"];
			} else {
				$arrtit = $comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"] ;
			}
			$qtcels_ini = 0;
			if(FuncoesArray::verif_valor_chave($opcoes,["subregistros","ativo"],true)){
				$qtcels_ini += 1;
			}
			$ind_linha_titulos = FuncoesArray::maior_valor_chave($arrtit,"linha");
			$ind_real_col = 0;
			/*prepara as condicionantes a serem usadas como valores padrao caso nao existam dados*/
			$condtemp = null;
			$cnj_cond_restritivas = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"])) {
				$cnj_cond_restritivas = self::obter_condicionantes_restritivas($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]);
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$cnj_cond_restritivas = self::obter_condicionantes_restritivas($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"],$cnj_cond_restritivas);
			}
			foreach($arrtit as $cel_tit){
				if (!isset($cel_tit["linha"]) || $cel_tit["linha"] === $ind_linha_titulos) {
					if (FuncoesArray::verif_valor_chave($comhttp->opcoes_retorno,["associativo"],true)) {				
						if (strlen(trim($cel_tit["valor"])) > 0) {
							if (!isset($opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["valor"]])) {
								if(isset($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0])) {							
									$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"] = $comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0];
									break;
								} else {	
									if (in_array(strtolower(trim($cel_tit["valor"])),explode(",",strtolower(trim(implode(",",array_keys($opcoes["corpo"]["linhas"]["valores_padrao"]))))))) {
										$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["valor"]]=$opcoes["corpo"]["linhas"]["valores_padrao"][$cel_tit["valor"]];
									} else {
										if (count($cnj_cond_restritivas) > 0) {
											if (isset($cnj_cond_restritivas[trim(strtolower($cel_tit["valor"]))])) {
												$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["valor"]]=$cnj_cond_restritivas[trim(strtolower($cel_tit["valor"]))];
											} else {											
												$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["valor"]]="";
											}
										} else {															
											$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["valor"]]="";
										}
									}
								}
							}
						}
					} else {				
						if (!isset($opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["coluna"] - $qtcels_ini])) {
							if(isset($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0])) {
								$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"] = $comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0];
							} else {
								if (in_array(strtolower(trim($cel_tit["coluna"] - $qtcels_ini)),explode(",",strtolower(trim(implode(",",array_keys($opcoes["corpo"]["linhas"]["valores_padrao"]))))))) {
									$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["coluna"] - $qtcels_ini]=$opcoes["corpo"]["linhas"]["valores_padrao"][$cel_tit["coluna"] - $qtcels_ini];
								} else {
									if (count($cnj_cond_restritivas) > 0) {
										if (isset($cnj_cond_restritivas[trim(strtolower($cel_tit["valor"]))])) {
											$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["coluna"] - $qtcels_ini]=$cnj_cond_restritivas[trim(strtolower($cel_tit["valor"]))];
										} else {										
											$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["coluna"] - $qtcels_ini]="";
										}
									} else {									
										$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"][$cel_tit["coluna"] - $qtcels_ini]="";
									}
								}
							}
						}		
					}
				}
			}	
			return $opcoes;
		}
		public static function montar_tit_tab_reg_uni(&$comhttp,&$opcoes) {
			$retorno = '';
			$retorno = '<thead>';
			$retorno .= '<th>Campo</th><th>Valor</th>';
			$retorno .= '</thead>';
			return $retorno;
		}
		public static function montar_linhas_tab_reg_uni(&$comhttp,&$opcoes) {
			$retorno = '';
			$retorno .= '<tbody>';
			foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"] as $ind => $tit) {
				if ($tit["linha"] === 1) {
					$retorno .= '<tr>';
					$retorno .= '<td>' . $tit["valor"] . '</td>';
					$retorno .= '<td>';
					$retorno .= '<input class="input_edicao_tab_reg_uni" value="';
					if (isset($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0])) {
						if (isset($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0][$tit["coluna"]])) {
							$retorno .= $comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][0][$tit["coluna"]];
						}
					}
					$retorno .= '" />';
					$retorno .= '</td>';
					$retorno .= '</tr>';
				}
			}
			$retorno .= '</tbody>';
			return $retorno;
		}
		public static function montar_rodape_tab_reg_uni($comhttp,$opcoes){
			$retorno = '';
			$retorno .= '<tfoot>';
			$retorno .= '<tr>';
			$retorno .= '<th colspan=2>';
			$retorno .= '<img onclick="window.fntabreguni.salvar_edicao_tab_reg_uni(event,this)" class="clicavel" src="' . NomesCaminhosRelativos::sjd . '/images/salvar.png" style="width:16px" />';
			$retorno .= '</th>';
			$retorno .= '</tr>';
			$retorno .= '</tfoot>';
			return $retorno;
		}
		public static function montar_tabela_reg_uni(&$comhttp,&$opcoes) {
			$retorno = '';
			$retorno = '<table class="tab_reg_uni">';
			$retorno .= self::montar_tit_tab_reg_uni($comhttp,$opcoes);
			$retorno .= self::montar_linhas_tab_reg_uni($comhttp,$opcoes);
			$retorno .= self::montar_rodape_tab_reg_uni($comhttp,$opcoes);
			$retorno .= '</table>';
			return $retorno;
		}

		/**
		 * Funcao para ser chamada na parte final de obtencao de dados sql
		 */
		public static function montar_retorno_tabdados(&$comhttp,$params_sql=[]){			
			
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
					$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $params_sql["fields"];
				} 
				FuncoesSql::getInstancia()->fechar_cursor($resultset);
			} else {
				$comhttp->retorno->dados_retornados["dados"] = $resultset;
			}	
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = self::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = self::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = self::montar_rodape_tabela_est_html($comhttp,false);			
		}
	
	}
?>