<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,
		constantes\Constantes
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesConversao,
			FuncoesBasicasRetorno
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesArray extends ClasseBase{
		public static $keysub = "sub";
		public static function acrescentar_elemento_array(&$array,$novos_elementos,$separar_array_novo_como_elemento=true,$manter_chaves = false){
			$retfunc=[];
			$i=0;
			if(isset($novos_elementos)){
				if(is_array($novos_elementos)&&$separar_array_novo_como_elemento===true){
					foreach($novos_elementos as $chave=>$novo_elemento){
						if ($manter_chaves) {
							if (isset($array[$chave])) {
								$array[$chave . "_" . count($array)] = $novo_elemento;
							} else {
								$array[$chave] = $novo_elemento;
							}
						} else {
							$array[]=$novo_elemento;
						}
					}
				} else {
					$array[]=$novos_elementos;
				}
			}
			return $array;
		}

		/**
		 * Verifica se um caminho de chaves existe num array e adicionamlmente faz uma comparacao conforme parametros
		 */
		public static function verif_valor_chave($array=[],$array_chaves_profundas=[],$valor=true,$tipo_checagem="valor",$comparacao="igual"){
			$tipo_array="";
			$tipo_array_chaves="";
			$retorno=false;
			$cont=0;
			$alvo=null;
			if (isset($array)) {
				$tipo_array = gettype($array);
				switch($tipo_array){
					case "array":
						if (count($array) > 0) {
							if(isset($array_chaves_profundas)){
								$tipo_array_chaves=gettype($array_chaves_profundas);
								if($tipo_array_chaves==="string"){
									$array_chaves_profundas=explode(",",$array_chaves_profundas);
									$tipo_array_chaves = "array";
								}
								if($tipo_array_chaves==="array"){
									$cont=0;
									foreach($array_chaves_profundas as $chave){
										if($alvo===null&&$cont===0){
											if(isset($array[$chave])){
												$alvo=$array[$chave];
											} else {
												return false;
												break(2);
											}
										} else {
											if(gettype($alvo) === "array" && isset($alvo[$chave])) {
												$alvo=$alvo[$chave];
											} else if (gettype($alvo) === "object" && property_exists($alvo,$chave)) {
												$alvo=$alvo->{$chave};
											} else {
												return false;
												break(2);
											}
										}
										$cont++;
									}
									if(isset($alvo)){
										switch($tipo_checagem){
											case "setado":
												return true;
												break;
											case "valor":
												switch($comparacao){
													case "igual":
														if ($valor === true || $valor === false) {
															if (FuncoesConversao::como_boleano($alvo)===$valor) {
																return true;
															} else {
																return false;
															}
														} else {
															if($alvo===$valor){
																return true;
															} else {
																return false;
															}
														}
													default:
														trigger_error("Erro na requisicao: comparacao nao suportado: ".$comparacao,E_USER_ERROR);
														break;
												}									
												break;										
											case "tamanho":
											case "contagem":
											case "quantidade":
											case "qt":
											case "qtd":
											case "qtde":
											case "count":
												switch($comparacao){
													case "maior": case ">":
														if (in_array(gettype($alvo),["string","numeric","number"])) {
															if(strlen($alvo)>$valor){
																return true;
															} else {
																return false;
															}													
														} elseif (in_array(gettype($alvo),["array","object","resource"])) {
															if(count($alvo)>$valor){
																return true;
															} else {
																return false;
															}
														} else {
															return false;
														}
														break;
													case "maiorouigual": case ">=":
														if (gettype($alvo) === "string") {
															if(strlen($alvo)>=$valor){
																return true;
															} else {
																return false;
															}
														} else {
															if(count($alvo)>=$valor){
																return true;
															} else {
																return false;
															}													
														}
														break;
													default:
														trigger_error("Erro na requisicao: comparacao nao suportado: ".$comparacao,E_USER_ERROR);
														break;
												}
												break;
											default:
												trigger_error("Erro na requisicao: tipo de checagem nao suportado: ".$tipo_checagem,E_USER_ERROR);
												break;
										}
									} else {
										return false;
										break;
									}
								} else {
									trigger_error("Erro na requisicao: tipo do arr de chaves nao suportado: ".$tipo_array_chaves,E_USER_ERROR);
									break;											
								}							
							} else {
								trigger_error("Erro na requisicao: tamanho do arr de chaves nulo , nao suportado: ".$tipo_array_chaves,E_USER_ERROR);
								break;					
							}
						} else {
							return false;
							break;
						}
						break;			
					default:
						if (count($array_chaves_profundas) <= 0) {
							FuncoesBasicasRetorno::mostrar_msg_sair("Implementar",__FILE__,__FUNCTION__,__LINE__);
						} else {
							return false;
						}
						trigger_error("Erro na requisicao: tipo de arr nao suportado: ".$tipo_array,E_USER_ERROR);
						break;
				}			
			}		
			return $retorno;
		}

		/*
			Transformar as chaves de um array em associativas baseado no valor do array, tornando o que estiver antes do sinal de = 
			como sendo a chave do array
		*/
		public static function chaves_associativas($array,$separador_chave_valor="="){
			$retorno=[];
			foreach($array as $chave=>$valor){
				if (gettype($valor) === "string") {
					if (stripos($valor,$separador_chave_valor) !== false) {
						$retorno[trim(substr($valor,0,stripos($valor,$separador_chave_valor)))] = trim(substr($valor,stripos($valor,$separador_chave_valor)+1));
					} else {
						if (stripos($valor," not in ") !== false) {	
							$retorno[trim(substr($valor,0,stripos($valor," not in ")))] = trim(substr($valor,stripos($valor," not in ")+1));
						} else if (stripos($valor," in ") !== false) {	
							$retorno[trim(substr($valor,0,stripos($valor," in ")))] = trim(substr($valor,stripos($valor," in ")+1));
						} else {
							$retorno[$chave] = $valor;
						}
					}
				} else {
					$retorno[$chave] = $valor;
				}
			}
			return $retorno;
		}
		public static function procurar_array_estruturado($array,$chave = "cod",$valor = ""){
			$retorno = null;
			foreach($array as $ch=>&$el){
				if (strcasecmp(trim($el[$chave]),trim($valor)) == 0) {
					$retorno = &$el;
				} else {
					if (isset($el["sub"])){
						$retorno = self::procurar_array_estruturado($el["sub"],$chave,$valor);
					}
				}
				if ($retorno !== null) {
					return $retorno;
				}
			}
			return $retorno;
		}
		/*
			Transforma um array que nao esta aninhado, mas contem campos de ligacao de aninhamento (cod,codsup), em um array aninhado, colocando 
			os elementos que tem codsup igual a cod de um elemento existente, dentro deste elemento em um sub array "sub"
		*/
		public static function estruturar_array($array,$chaveunica="cod",$chavesup = "codsup"){
			$arr_res = [];
			$cnj_chaves_sup = [];	
			foreach($array as $ch => $el) {
				switch(gettype($el)) {
					case "array":
						if (self::valor_elemento_array($el,$chavesup) == -1) {
							$arr_res[$ch] = $el;
						} else {
							$cnj_chaves_sup[self::valor_elemento_array($el,$chaveunica)] = self::valor_elemento_array($el,$chavesup);
						}		
						break;
					case "object":
						if (property_exists($el,$chavesup) && trim($el->{$chavesup}) === "" ) {
							$cnj_chaves_sup[$el->{$chavesup}] = $el->{$chavesup};
						} else {					
							$arr_res[$ch] = $el;
						}		
						break;
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("tipo elemento nao esperado: " . gettype($el), __FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
			$cnj_chaves_sup = array_unique($cnj_chaves_sup);
			arsort($cnj_chaves_sup);
			if (count($cnj_chaves_sup) > 0) {
				$chavemax = max($cnj_chaves_sup);		
				foreach($cnj_chaves_sup as $chave => $valor){		
					foreach($array as $ch => &$el) {
						if (self::valor_elemento_array($array[$ch],$chaveunica) === $valor || strcasecmp(trim(self::valor_elemento_array($array[$ch],$chaveunica)),trim($valor)) == 0) {
							$array2 = $array;
							reset($array2);
							foreach($array2 as $ch2 => &$el2) {				
								if (self::valor_elemento_array($el2,$chavesup) === $valor || strcasecmp(trim(self::valor_elemento_array($el2,$chavesup)),trim($valor)) == 0) {
									switch(gettype($el)) {
										case "array":
											if (!isset($el["sub"])) {
												$el["sub"] = [];
											}
											$el["sub"][] = $el2;
											break;
										case "object":
											if (!property_exists($el,"sub")) {
												$el->sub = [];
											}
											$el->sub[] = $el2;
											break;
										default:
											FuncoesBasicasRetorno::mostrar_msg_sair("tipo do subelemento nao esperado: " . gettype($el),__FILE__,__FUNCTION__,__LINE__);
											break;
									}
									unset($array[$ch2]);
								}
							}
						}
					}
				}
			}
			return $array;
		}

		public static function detectar_profundidade_array( &$arr , &$profund = 0 , &$profund_max = 0){
			/*Objetivo: detectar a profundidade de um array multidimensional*/
			foreach( $arr as $el){
				if(is_array( $el )){
					$profund++;
					self::detectar_profundidade_array( $el , $profund , $profund_max) ;
				}else{
				}
			}
			if($profund > $profund_max){
				$profund_max = $profund;
			}
			$profund -- ;
			return $profund_max;
		}

		public static function detectar_profundidade_array_tit( &$arr , &$profund_max = 0 , $profund = 0){
			/*Objetivo: detectar a profundidade de um array multidimensional*/
			$dados_key_tit = null;
			if (isset($arr) && $arr !== null && gettype($arr) === "array" && count($arr) > 0) {
				$dados_key_tit = self::get_dadoskey_arrtit($arr);
				if ($dados_key_tit["qt_keys"] > $dados_key_tit["qt_keys_naosub"]) {
					$profund++;
					foreach( $arr as $el){
						self::detectar_profundidade_array_tit($el,$profund_max,$profund);
						if ($profund > $profund_max) {
							$profund_max = $profund;
						}
					}	
				}
			}
			return $profund_max;
		}
		public static function contar_qtmax_subelem_por_dimensao( $el , $contagem = 0){
			if (gettype($el) === "array" && (array_keys($el) !== ["texto","codligcamposis"] && array_keys($el) !== ["texto","codligcamposis","formatacao"])) {
				$contagem = count($el);
				$contagem_temp = 0;
				foreach($el as $item) {
					$contagem_temp += self::contar_qtmax_subelem_por_dimensao( $item , $contagem );
					if ($contagem_temp > $contagem) {
						$contagem = $contagem_temp;
					}
				}			
			} else {
				$contagem = 1;
			}
			return $contagem;
		}

		private static function get_dadoskey_arrtit($el) {
			$retorno = [];
			$retorno["texto"] = null;
			$retorno["qt_keys"] = 0;
			$retorno["qt_keys_naosub"] = 0;
			if (gettype($el) === "array" && $el !== null && count($el) > 0) {
				$retorno["keys_el"] = array_keys($el);
				$retorno["keys_el_minusc"] = explode(Constantes::subst_virg,strtolower(trim(implode(Constantes::subst_virg,$retorno["keys_el"]))));
				$retorno["qt_keys"] = count($retorno["keys_el_minusc"]);
				$retorno["ind_texto"] = array_search("texto",$retorno["keys_el_minusc"]);
				$retorno["ind_codligcamposis"] = array_search("codligcamposis",$retorno["keys_el_minusc"]);
				$retorno["ind_formatacao"] = array_search("formatacao",$retorno["keys_el_minusc"]);
				if ($retorno["ind_texto"] !== false) {
					$retorno["texto"] = $el[$retorno["keys_el"][$retorno["ind_texto"]]];
					$retorno["qt_keys_naosub"]++;
				}
				if ($retorno["ind_codligcamposis"] !== false) {
					$retorno["codligcamposis"] = $el[$retorno["keys_el"][$retorno["ind_codligcamposis"]]];
					$retorno["qt_keys_naosub"]++;
				}
				if ($retorno["ind_formatacao"] !== false) {
					$retorno["formatacao"] = $el[$retorno["keys_el"][$retorno["ind_formatacao"]]];
					$retorno["qt_keys_naosub"]++;
				}
			} else {
				$retorno["texto"] = $el;
			}
			return $retorno;
		}


		private static function transf_arrmultdimens_arrunidimens_recursivo($array, &$arr_ret, $profundidade_max = 1, $codsup = -1, $linha = 0, $coluna_ini = 0){
			if (gettype($array) === "array") {
				$coluna = $coluna_ini;
				foreach($array as $chave => $el) {
					//print_r($el); exit();
					$ind = count($arr_ret);					
					$arr_ret[ $ind ] = [];
					$arr_ret[ $ind ] [ "cod" ] = $ind ;
					$arr_ret[ $ind ] [ "codsup" ] = $codsup ;
					$arr_ret[ $ind ] [ "valor" ] = $chave ;
					$arr_ret[ $ind ] [ "linha" ] = $linha ;
					$arr_ret[ $ind ] [ "coluna" ] = $coluna ;
					$arr_ret[ $ind ] [ "indexreal" ] = $coluna;					
					if (is_array($el)) {
						/*se o el for array, verifica se realmente tem sub elementos ou se sao so colunas especificadores do titulo*/
						$dados_key_tit = self::get_dadoskey_arrtit($el);						
						$arr_ret[ $ind ] [ "texto" ] = $arr_ret[ $ind ] [ "texto" ] ?? $arr_ret[ $ind ] [ "valor" ] ?? $chave;
						if (isset($dados_key_tit["texto"]) && $dados_key_tit["texto"] !== null && gettype($dados_key_tit["texto"]) === "string" && strlen(trim($dados_key_tit["texto"])) > 0) {
							$arr_ret[$ind]["texto"] = $dados_key_tit["texto"];
						}
						if ($dados_key_tit["qt_keys"] === $dados_key_tit["qt_keys_naosub"]) {
							/*indica que ja esta na ultima linha dessas colunas*/ 							
							$arr_ret[$ind]["codligcamposis"] = (isset($dados_key_tit["codligcamposis"])?$dados_key_tit["codligcamposis"]:null);
							$arr_ret[$ind]["formatacao"] = (isset($dados_key_tit["formatacao"])?$dados_key_tit["formatacao"]:null);
							if ($linha < ($profundidade_max - 1)) {								
								$arr_ret[$ind]["rowspan"] = $profundidade_max - $linha;
							}
						} else {
							/*indica que tem mais linhas dessa coluna*/
							//print_r($dados_key_tit); exit();
							/*if (trim($arr_ret[$ind]["texto"]) == "562") {
								print_r($dados_key_tit); exit();
							}*/
							$arr_ret[$ind]["colspan"] = $dados_key_tit["qt_keys"] - $dados_key_tit["qt_keys_naosub"];
							self::transf_arrmultdimens_arrunidimens_recursivo($el, $arr_ret, $profundidade_max, $ind, $linha + 1, $coluna);
						}	
					} else {
						/*indica que esta na ultima linha dessas colunas*/ 
						$texto = $el;
						if (strlen(trim($el)) === 0) {
							$texto = $chave;
						}
						$arr_ret[$ind]["texto"] = $texto;
						if ($linha < ($profundidade_max - 1)) {
							$arr_ret[$ind] ["rowspan"] = ($profundidade_max ) - $linha;
							
							/*correcao no caso de relatorios tipo pivot (positivacao) */
							/*if ($arr_ret[ $ind ] [ "rowspan" ] === 1) {
								$arr_ret[ $ind ] [ "rowspan" ] = 2;
							}*/
						}
					}	
					$coluna++;
					if (isset($arr_ret[$ind]["colspan"])) {
						$coluna += $arr_ret[$ind]["colspan"] - 1;
					}
				}
			}
			return $arr_ret;
		}


		public static function transf_arrmultdimens_arrunidimens( &$arrmultdimens , $chaves_pular = []){
			$arrunidimens_retorno = [] ;
			$profundidade_max = 0 ;
			$profundidade_max = self::detectar_profundidade_array( $arrmultdimens )  ;
			$profundidade_max ++;
			//echo $profundidade_max; exit();
			//print_r($arrmultdimens); exit();
			self::transf_arrmultdimens_arrunidimens_recursivo( $arrmultdimens , $arrunidimens_retorno, $profundidade_max ) ;
			//print_r($arrunidimens_retorno); exit();
			return $arrunidimens_retorno;
		}

		
		/*
		
		no lugar desta, usar a 2
		public static function transf_arrmultdimens_arrunidimens_tit( &$arrmultdimens , $chaves_pular = []){
			$arrunidimens_retorno = [] ;
			$profundidade_max = 0 ;
			//print_r($arrmultdimens);exit();
			$profundidade_max = self::detectar_profundidade_array_tit( $arrmultdimens )  ;
			//$profundidade_max ++;
			//echo $profundidade_max; exit();
			//print_r($arrmultdimens); exit();
			self::transf_arrmultdimens_arrunidimens_recursivo( $arrmultdimens , $arrunidimens_retorno, $profundidade_max ) ;
			//print_r($arrunidimens_retorno); exit();
			return $arrunidimens_retorno;
		}*/

		public static function inserir_se_nao_existir($valor,&$array,$clonar=false,$incrementar=false,$tipo=""){
			$encontrado=false;
			$i=0;
			if(!in_array($valor,$array)){
				if($tipo='campo_select'){
					$als=substr($valor,stripos($valor," as "));
					$encontrado=false;
					$i='';
					foreach ($array as $arr){
						$arrals=substr($arr,stripos($arr," as "));
						if($arrals==$als){
							$encontrado=true;
							$i=0;				
						};
					};
					while ($encontrado==true){
						$encontrado=false;
						foreach ($array as $arr){
							$arrals=substr($arr,stripos($arr," as ")).$i;						
							if($arrals==$als){
								$encontrado=true;				
								$i++;							
							};
						};
					};
					if($incrementar){
						$valor=$valor.$i;
					};
					$array[]=$valor;
				}else{
					$array[]=$valor;
				};
			} elseif ($clonar) {
				$i=0;
				$encontado=true;
				while ($encontrado==true){
					if(in_array($valor.$i,$array)){
						$encontado=true;
					}else{
						$encontado=false;
					};
					$i++;
				};
				if($incrementar){
					$valor=$valor.$i;
				};
				$array[]=$valor;
			}
			return $array;
		}
		public static function arr_str_minusc($arr) {
			$retorno = null;
			if (isset($arr)) {
				if (gettype($arr) === "array") {
					$novoarr = [];
					foreach($arr as $chave => $valor) {
						$novoarr[$chave] = strtolower($valor);
					}			
					$retorno = $novoarr;
				}
			}
			return $retorno;	
		}
		public static function desestruturar_array($arr,&$arr_ret=[],&$chave_unica=-1,$chave_sup=-1,$chave_sup_ini=-1,$criar_chaves=true,$campo_grupamento_sub="sub",$campo_chave_unica="CODELEMENTO",$campo_chave_sup="CODELEMENTOSUP",$campo_chave_sup_ini="CODELEMENTOSUPINI"){
			foreach($arr as $chave=>$elemento){
				if($criar_chaves===false){
					$chave_unica=$chave;
				} else {
					$chave_unica++;
				}		
				$arr_ret[$chave_unica]=$elemento;
				$arr_ret[$chave_unica][$campo_chave_unica]=$chave_unica;
				$arr_ret[$chave_unica][$campo_chave_sup]=$chave_sup;
				if($chave_sup===-1){
					$chave_sup_ini=-1;
				}
				$arr_ret[$chave_unica][$campo_chave_sup_ini]=$chave_sup_ini;
				if(isset($arr_ret[$chave_unica][$campo_grupamento_sub])){
					if(is_array($arr_ret[$chave_unica][$campo_grupamento_sub])){
						unset($arr_ret[$chave_unica][$campo_grupamento_sub]);
						if($chave_sup===-1){
							$chave_sup_ini=$chave_unica;
						} 
						self::desestruturar_array($arr[$chave][$campo_grupamento_sub],$arr_ret,$chave_unica,$chave_unica,$chave_sup_ini,$criar_chaves,$campo_grupamento_sub,$campo_chave_unica,$campo_chave_sup,$campo_chave_sup_ini);
					}
				}
			}
			return $arr_ret;
		}
		public static function valor_elemento_array($array,$chave_elemento, $valor_padrao = null){
			$retorno = $valor_padrao;
			if (isset($array)) {
				if (gettype($array) === "array") {
					if (isset($array[$chave_elemento])) {
						$retorno = $array[$chave_elemento];
					} else if (isset($array[strtolower(trim($chave_elemento))])) {
						$retorno = $array[strtolower(trim($chave_elemento))];
					} else if (isset($array[strtoupper(trim($chave_elemento))])) {
						$retorno = $array[strtoupper(trim($chave_elemento))];
					}
				}
			}	
			return $retorno;	
		}
		public static function ordenar_por_chave($array,$chave_ordenar=["ordem"],$tipo_chave="numero") {
			$ordens = [];
			if (gettype($chave_ordenar) !== "array") {
				$chave_ordenar = [$chave_ordenar];
			}
			foreach($array as &$el) {
				$elt = $el;
				/*cria o caminho ate a chave de ordenacao, caso nao exista, e a obtem*/
				foreach($chave_ordenar as $chave_ord) {
					if (!isset($elt[$chave_ord])) {
						$elt[$chave_ord] = [];				
					}
					$elt = &$elt[$chave_ord];			
				}
				if (!isset($elt)) {
					$elt = PHP_INT_MAX;
				} else {
					if ($elt === null) {
						$elt = PHP_INT_MAX;
					}
				}
				$ordens[] = (integer)$elt;
			}
			$cnj_ordenado = [];
			if ($tipo_chave==="numero") {
				sort($ordens,SORT_NUMERIC);
				foreach($ordens as &$ordem) {
					foreach($array as $chave => &$el) {
						$elt = &$el;
						foreach($chave_ordenar as $chave_ord) {
							if (gettype($elt[$chave_ord]) === "array") {
								$elt = &$elt[$chave_ord];
							} else {
								if ((integer)$elt[$chave_ord] === (integer)$ordem) {
									$cnj_ordenado[$chave] = $el;
									unset($el);
									break;
								}
							}
						}
					}
				}
			} else {
				sort($ordens);
				foreach($ordens as &$ordem) {
					foreach($array as $chave => &$el) {
						$elt = &$el;
						foreach($chave_ordenar as $chave_ord) {
							if (gettype($elt[$chave_ord]) === "array") {
								$elt = &$elt[$chave_ord];
							} else {
								if ($elt[$chave_ord] === $ordem) {
									$cnj_ordenado[$chave] = $el;
									unset($el);
									break;
								}
							}
						}
					}
				}
			}
			return $cnj_ordenado;
		}
		public static function chaves_minusculas(&$arr) {
			if (gettype($arr) === "array") {
				foreach($arr as $ch=>&$el) {
					if (gettype($el) === "array") {				
						$el = self::chaves_minusculas($el);
					}
					if (gettype($ch) !== "integer") {
						if (strcasecmp(trim($ch),$ch) != 0) {
							$arr[strtolower(trim($ch))] = $el;
							unset($arr[$ch]);
						}
					}
				}
			}
			return $arr;
		}
		public static function chaves_string($arr) {
			if (gettype($arr) === "array") {
				foreach($arr as $ch=>&$el) {
					if (gettype($el) === "array") {				
						$el = self::chaves_string($el);
					}
					$arr[trim($ch)] = $el;
					unset($arr[$ch]);
				}
			}
			return $arr;
		}
		public static function valores_minusculos(&$arr) {
			if (gettype($arr) === "array") {
				foreach($arr as $ch=>&$el) {
					if (gettype($el) === "array") {
						$arr[$ch] = self::valores_minusculos($arr[$ch]);
					} else if (gettype($el) === "string") {
						$arr[$ch] = strtolower($el);
					}
				}
			}
			return $arr;
		}
		public static function valores_string($arr) {
			if (gettype($arr) === "array") {
				foreach($arr as $ch=>&$el) {
					if (gettype($el) === "array") {
						$arr[$ch] = self::valores_string($arr[$ch]);
					} else {
						$arr[$ch] = ($el)."";
					}
				}
			}
			return $arr;
		}
		public static function array_eliminar_elementos_vazios(&$arr,$chave_el = null) {
			if ($chave_el !== null) {
				if (gettype($arr[$chave_el]) === "array") {
					if (count($arr[$chave_el]) > 0) {
						foreach($arr[$chave_el] as $ch=>$el) {
							self::array_eliminar_elementos_vazios($arr[$chave_el],$ch);
						}
						if (count($arr[$chave_el]) <= 0) {
							unset($arr[$chave_el]);
						}
					} else {
						unset($arr[$chave_el]);
					}
				} else {
					if (in_array($arr[$chave_el],[null,""])) {
						unset($arr[$chave_el]);
					}
				}	
			} else {
				if (gettype($arr) === "array") {
					if (count($arr) > 0) {
						foreach($arr as $chave_el=>$el) {
							self::array_eliminar_elementos_vazios($arr,$chave_el);
						}
						if (count($arr) <= 0) {
							unset($arr);
						}
					} else {
						unset($arr);
					}
				} else {
					if (in_array($arr,[null,""])) {
						unset($arr);
					}
				}
			}
		}
		public static function procurar_por_chave($array,$chave,$valor,$retornar_array = true) {
			$retorno = null;
			if (isset($array)) {
				if (gettype($array) === "array") {
					if (isset($array[$chave])) {
						if ($array[$chave] === $valor) {
							if ($retornar_array === true) {
								$retorno = $array;
							} else {
								$retorno = $array[$chave];
							}
						} 
					} else {
						foreach($array as $subel) {
							$retorno = self::procurar_por_chave($subel,$chave,$valor);
							if ($retorno !== null) {
								break;
							}
						}
					}
				} 
			} 
			return $retorno;
		}
		public static function array_excluir_elementos_nulos(&$array,$considerar_vazio_nulo = true) {		
			if (gettype($array) === "array") {
				$tem_elemento = false;
				foreach ($array as $ch => &$el) {
					if ($el !== null) {
						if (gettype($el) === "array") {
							$el = self::array_excluir_elementos_nulos($array[$ch],$considerar_vazio_nulo);
							if ($el === null || count($el) === 0) {
								unset($array[$ch]);
							} else {
								$tem_elemento = true;
							}
						} else {
							if ($el === null || strlen(trim($el)) === 0) {
								unset($array[$ch]);
							} else {
								$tem_elemento = true;
							}
						}
					} else {
						unset($array[$ch]); 
					}
				}
				if ($tem_elemento === false) {			
					unset($array);
					return [];
				} else {
					return $array;
				}
			} else {
				if ($array === null || strlen(trim($array)) === 0) {
					unset($array);
					return null;
				} else {
					return $array;
				}
			}
		}
		private static function _arr_contem_parcial_casesensitive_trim_parcialinverso($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (stripos($valor,trim($el)) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_casesensitive_trim($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (stripos(trim($el),$valor) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_casesensitive_parcialinverso($valor = null, $arr = []){
			foreach($arr as $el) {
				if (stripos($valor,$el) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_casesensitive($valor = null, $arr = []){
			foreach($arr as $el) {
				if (stripos($el,$valor) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_trim_parcialinverso($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (strpos($valor,trim($el)) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_trim($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (strpos(trim($el),$valor) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial_parcialinverso($valor = null, $arr = []){
			foreach($arr as $el) {
				if (strpos($valor,$el) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcial($valor = null, $arr = []){
			foreach($arr as $el) {
				if (strpos($el,$valor) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_casesensitive_trim_parcialinverso($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (stripos($valor,trim($el)) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_casesensitive_trim($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (strcasecmp(trim($el),$valor) == 0) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_casesensitive_parcialinverso($valor = null, $arr = []){
			foreach($arr as $el) {
				if (stripos($valor,$el) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_casesensitive($valor = null, $arr = []){
			foreach($arr as $el) {
				if (strcasecmp($el,$valor) == 0) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_trim_parcialinverso($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (strpos($valor,trim($el)) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_trim($valor = null, $arr = []){
			$valor = trim($valor);
			foreach($arr as $el) {
				if (trim($el) === $valor) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem_parcialinverso($valor = null, $arr = []){
			foreach($arr as $el) {
				if (strpos($valor,$el) !== false) {
					return true;
				}
			}	
			return false;
		}
		private static function _arr_contem($valor = null, $arr = []){
			foreach($arr as $el) {
				if ($el === $valor) {
					return true;
				}
			}	
			return false;
		}
		public static function array_contem($valor = null,$arr = [],$parcial = false,$casesensitive = false,$trim = true,$parcialinverso = false) {
			$contem = false;
			if ($parcial === true) {
				if ($casesensitive === true) {
					if ($trim === true) {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_parcial_casesensitive_trim_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_parcial_casesensitive_trim($valor,$arr);
						}
					} else {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_parcial_casesensitive_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_parcial_casesensitive($valor,$arr);
						}
					}		
				} else {
					if ($trim === true) {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_parcial_trim_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_parcial_trim($valor,$arr);
						}
					} else {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_parcial_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_parcial($valor,$arr);
						}
					}
				}
			} else {
				if ($casesensitive === true) {
					if ($trim === true) {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_casesensitive_trim_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_casesensitive_trim($valor,$arr);
						}
					} else {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_casesensitive_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_casesensitive($valor,$arr);
						}
					}		
				} else {
					if ($trim === true) {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_trim_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem_trim($valor,$arr);
						}
					} else {
						if ($parcialinverso === true) {
							$contem = self::_arr_contem_parcialinverso($valor,$arr);
						} else {
							$contem = self::_arr_contem($valor,$arr);
						}
					}
				}
			}
			return $contem;
		}
		public static function maior_valor_chave($arr,$chave) {
			$maior = 0;
			$maior_sub = 0;
			foreach($arr as $ch=>$el) {
				if (gettype($el) === "array") {
					$maior_sub = self::maior_valor_chave($el,$chave);
					if ($maior_sub > $maior) {
						$maior = $maior_sub;
					}
				} else {
					if ($ch === $chave) {
						if ($el > $maior) {
							$maior = $el;
						}
					}
				}
			}
			return $maior;
		}
		public static function arrayCopy( array $array ) {
			/*
			arry por referencia & dentro do array referencindo a outro elememento do proprio array ou elemento externo mas que faca referencia a elemento interno causa estouro de memoria por recursao
			*/	
			$result = array();
			foreach( $array as $key => &$val ) {
				if( is_array( $val ) ) {
					$result[$key] = self::arrayCopy( $val );
				} elseif ( is_object( $val ) ) {
					$result[$key] = clone $val;
				} else {
					$result[$key] = $val;
				}
			}
			return $result;
		}
		public static function procurar_chave_array_recursivo(array &$array, $chave) {
			if (isset($array)) {
				if (gettype($array) === "array") {
					if (count($array) > 0) {
						foreach($array as $ch => &$el) {
							if ($ch === $chave) {						
								$retorno = &$array[$ch];
								return $retorno;
							} 
							if (gettype($array[$ch]) === "array") {
								$retorno = self::procurar_chave_array_recursivo($array[$ch],$chave);
								if ($retorno !== null) {
									return $retorno;
								}
							}
						}
					}
				}
			}
			return null;
		}
		public static function alterar_chave_array_recursivo(array &$array, $chave, $valor) {
			if (isset($array)) {
				if (gettype($array) === "array") {
					if (count($array) > 0) {
						foreach($array as $ch => &$el) {
							if ($ch === $chave) {						
								$array[$ch] = $valor;
								return true;
							} 
							if (gettype($array[$ch]) === "array") {
								$retorno = self::alterar_chave_array_recursivo($array[$ch],$chave,$valor);
								if ($retorno === true) {
									return true;
								}
							}
						}
					}
				}
			}
			return null;
		}
		public static function utf8Array( &$array ){
			array_walk_recursive( $array, function(&$item) { 
			   $item = utf8_encode( $item ); 
			});
		}

		/**
		 * transforma um array incluindo seus sub elementos em um unico subelemento "sub"
		*/
		public static function transf_array_em_sub(&$array){
			if (gettype($array) === "array") {
				foreach($array as $key => $el) {
					if (gettype($el) === "array" 
						|| !in_array($key,["texto","codligcamposis"])
					) {
						if (!isset($array[self::$keysub])) {
							$array[self::$keysub] = [];
						}
						$array[self::$keysub][$key] = $el;
						unset($array[$key]);						
						self::transf_array_em_sub($array[self::$keysub][$key]);						
					}
				}				
			}
		}

		public static function obter_profundidade_array_tit($array_tit,$nivel = 0, $profund = 0) {
			$tem_sub = false;
			if ($profund < $nivel) {
				$profund = $nivel;
			}
			if (gettype($array_tit) === "array") {				
				foreach($array_tit as $key => $el) {
					if ($key === self::$keysub) {
						$tem_sub = true;
						$nivel++;
					}
					$profund = self::obter_profundidade_array_tit($el,$nivel,$profund);
					if ($tem_sub === true) {
						$nivel--;
					}
				}				
			}
			return $profund;
		}

		public static function transf_arrmultdimens_arrunidimens_tit2(&$array_tit, &$array_unidimen, &$cod = -1, $profund,  $codsup = -1, $linha = 0, $coluna_ini = 0, $indexreal = 0) {
			if (gettype($array_tit) === "array") {
				foreach($array_tit as $key => $el) {

					/*se for sub, recursa*/
					if ($key === self::$keysub) {						
						$indexreal = self::transf_arrmultdimens_arrunidimens_tit2(
							array_tit: $array_tit[$key],
							array_unidimen: $array_unidimen,							
							cod: $cod,
							profund: $profund,
							codsup: $codsup,
							linha: $linha,
							coluna_ini: $coluna_ini,
							inexreal: $indexreal
						);
					} else {

						/*se nao for array, verifica se eh um campo e transforma em array*/
						if (gettype($array_tit[$key]) !== "array") {
							if (!in_array($key,["texto","codligcamposis"])) {
								$array_tit[$key] = [
									"texto"=>$array_tit[$key]
								];
							}
						}

						if (gettype($array_tit[$key]) === "array") {						
							$cod++;						
							$array_tit[$key]["texto"] = $array_tit[$key]["texto"] ?? $array_tit[$key]["valor"] ?? $key;
							$array_tit[$key]["cod"] = $cod;
							$array_tit[$key]["codsup"] = $codsup;
							$array_tit[$key]["linha"] = $linha;
							$array_tit[$key]["coluna"] = $coluna_ini;// + array_search($key,array_keys($array_tit));							
							$array_tit[$key]["indexreal"] = $indexreal;
							$coluna_ini++;

							/*se tiver sub*/
							if (isset($array_tit[$key][self::$keysub]) 
								&& $array_tit[$key][self::$keysub] !== null 
								&& gettype($array_tit[$key][self::$keysub]) === "array"
								&& count($array_tit[$key][self::$keysub]) > 0
							) {
								/*tem sub*/
								if (count($array_tit[$key][self::$keysub]) > 1) {
									$array_tit[$key]["colspan"] = count($array_tit[$key][self::$keysub]);
									$array_tit[$key]["colspan_ini"] = $array_tit[$key]["colspan"];
									$coluna_ini += $array_tit[$key]["colspan"] - 1;
									$codsuptemp = $array_tit[$key]["codsup"];
									while($codsuptemp > -1) {
										foreach($array_unidimen as $key2 => &$el2) {
											if ($el2["cod"] == $codsuptemp) {
												$el2["colspan"] = ($el2["colspan"] ?? 0) + $array_tit[$key]["colspan"] - ($el2["colspan_ini"] ?? 0);
												$el2["colspan_ini"] = 0;
												$codsuptemp = $el2["codsup"];
												break;
											}
										}
									}
								}
								$linha++;
								//$codsup = $cod;

								$nova_key = $key;
								$cont = "";
								if (isset($array_unidimen[$key])) {
									$nova_key .= "_";					
									$cont = 0;
									while(isset($array_unidimen[$nova_key.$cont])) {									
										$cont++;
									}
								}
								$array_unidimen[$nova_key.$cont] = $array_tit[$key];																
								$indexreal = self::transf_arrmultdimens_arrunidimens_tit2(
									array_tit: $array_tit[$key][self::$keysub],
									array_unidimen: $array_unidimen,									
									cod: $cod,
									profund: $profund,
									codsup: $cod,
									linha: $linha,
									coluna_ini: $array_tit[$key]["coluna"],
									indexreal: $indexreal
								);
								unset($array_unidimen[$nova_key.$cont][self::$keysub]);
								$linha--;
							} else {
								/*nao tem sub, eh a ultima em profundidade*/
								if (($profund - $linha) > 1) {
									$array_tit[$key]["rowspan"] = $profund - $linha;									
								}

								$nova_key = $key;
								$cont = "";
								if (isset($array_unidimen[$key])) {
									$nova_key .= "_";					
									$cont = 0;
									while(isset($array_unidimen[$nova_key.$cont])) {									
										$cont++;
									}
								}
								$array_unidimen[$nova_key.$cont] = $array_tit[$key];
								$indexreal++;
							}
						}
					}
				}
			}
			return $indexreal;
		}


	}
?>