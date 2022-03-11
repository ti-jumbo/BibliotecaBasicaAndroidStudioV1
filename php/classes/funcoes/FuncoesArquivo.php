<?php
	namespace SJD\php\classes\funcoes;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,			
			variaveis\VariaveisSql
		};
	use SJD\php\classes\funcoes\{			
		FuncoesJson,
		FuncoesVariaveis,
		requisicao\FuncoesBasicasRetorno
	};
	
	/*codigo*/		
	class FuncoesArquivo extends ClasseBase{
		public static function obter_nome($linha,$campo_nome){
			$pinivlr = 0;
			$pinivlr = strpos($linha,'=',stripos($linha,$campo_nome)) + 1 ;
			$pfimvlr = strpos($linha,']',$pinivlr);				
			$nome_elemento = strtolower(trim(substr($linha,$pinivlr,$pfimvlr-$pinivlr)));
			return $nome_elemento;	
		}

		public static function estruturar_array_arquivo(&$caminho_arquivo='',&$elementos = [],$filtro=null,&$arr_linhas_arq=[],$configuracoes_catalogo = []) {
			$pinivlr = 0;
			$pfimvlr = 0;
			$nome_elemento = null;
			$encontrouini = false;
			$encontroufim = false;
			$campoini = false;
			$campofim = false;
			$pinicomp = 0;
			$prop = null;
			$vlprop = null;
			$iniciou_config = false;
			$finalizou_config = true;
			$tamanho_arr_lins_arq = count($arr_linhas_arq);
			$sub=false;
			if (isset($filtro) && $filtro !== null) {
				if (gettype($filtro) !== 'array' && strlen(trim($filtro)) > 0) {
					$filtro = explode(',',$filtro);
				} else {
					$filtro = [];
				}
				if (count($filtro) > 0) {
					$filtro = explode(',',trim(strtolower(implode(',',$filtro))));
				}		
			} else {
				$filtro = [];
			}
			while(current($arr_linhas_arq) !== false) {
				$linha = current($arr_linhas_arq);
				next($arr_linhas_arq);
				/*PREVINE LEITURA INDEVIDA DAS CONFIGURACOES DO CATALOGO COMO DADOS DO CATALOGO*/
				if (!in_array('configuracoes_catalogo', $filtro)) {
					if (stripos($linha,'[INICIO CONFIGURACOES CATALOGO') !== false) {
						$iniciou_config = true;
						$finalizou_config = false;				
						continue;
					}
					if (stripos($linha,'[FIM CONFIGURACOES CATALOGO') !== false) {
						$iniciou_config = false;
						$finalizou_config = true;
						continue;
					}		
					if ($iniciou_config === true && $finalizou_config === false) {
						continue;
					}
				}
				$pinivlr = 0;
				$pfimvlr = 0;
				if ($configuracoes_catalogo['limparespacoslinha'] === true) {
					$linha = trim($linha);
				}
				if ($campoini && !$campofim) {
					if (strpos($linha,'__FIMCAMPO__') !== false) {
						$campoini = false;
						$campofim = true;
						continue;
					} else {
						$elementos[$nome_elemento][$prop] .= $linha;
						continue;
					}
				}
				if (stripos($linha,$configuracoes_catalogo['inicio']) !== false || stripos($linha,$configuracoes_catalogo['iniciosub']) !== false ) {						
					if ($encontrouini === true && $encontroufim === false) {
						if ($configuracoes_catalogo['grupamento_sub'] === true || $configuracoes_catalogo['grupamento_sub'] === 'true') {
							if (!isset($elementos[$nome_elemento]['sub'])) {
								$elementos[$nome_elemento]['sub'] = [];
							}
							prev($arr_linhas_arq);
							self::estruturar_array_arquivo($caminho_arquivo,$elementos[$nome_elemento]['sub'],null,$arr_linhas_arq,$configuracoes_catalogo);
						} else {
							prev($arr_linhas_arq);
							self::estruturar_array_arquivo($caminho_arquivo,$elementos[$nome_elemento],null,$arr_linhas_arq,$configuracoes_catalogo);
						}				
						continue;
					} else {
						$nome_elemento = obter_nome($linha,$configuracoes_catalogo['nome']);
						if (isset($filtro) && $filtro !== null && count($filtro) > 0 && !in_array('todos',$filtro)) {				
							if (in_array(trim(strtolower($nome_elemento)), $filtro)) {						
								if (isset($elementos[$nome_elemento])) {
									FuncoesBasicasRetorno::mostrar_msg_sair('elemento com indice(nome) duplicado:'.$nome_elemento. ', arquivo: '.$caminho_arquivo,__FILE__,__FUNCTION__,__LINE__);
								}
								
								$elementos[$nome_elemento] = [];
								$encontrouini = true;
								$encontroufim = false;
								continue;						
							} else {
								if (count($elementos) > 0 && !$sub) {
									break;
								} else {
									$encontrouini = false;
									$encontroufim = false;
									continue;
								}
							}
						} else {
							if (isset($elementos[$nome_elemento])) {
								FuncoesBasicasRetorno::mostrar_msg_sair('elemento com indice(nome) duplicado:'.$nome_elemento. ', arquivo: '.$caminho_arquivo,__FILE__,__FUNCTION__,__LINE__);
							}
							$elementos[$nome_elemento] = [];
							$encontrouini = true;
							$encontroufim = false;					
							continue;
						}
					}
				} 			
				if (stripos($linha,$configuracoes_catalogo['fim']) !== false || stripos($linha,$configuracoes_catalogo['fimsub']) !== false) {
					if ($encontrouini === true) {
						if ($encontroufim === false) {
							$encontrouini = false;
							$encontroufim = true;
							continue;					
						} else {
							prev($arr_linhas_arq);
							break;					
						}
					} else {
						if ($encontroufim === true) {
							$encontrouini = false;
							$encontroufim = true;
							prev($arr_linhas_arq);
							break;					

						} else {
							continue;
						}				
					}
				}
				if ($encontrouini === true && $encontroufim === false) {
					if ($configuracoes_catalogo['linhascomopropriedades'] === false || $configuracoes_catalogo['linhascomopropriedades'] === 'false') {
						$elementos[$nome_elemento][] = $linha;
						continue;
					} else {
						$pinicomp = strpos($linha,'=');
						if ($pinicomp !== false) {
							$pinicmp = 0;
							$prop = strtolower(trim(substr($linha,$pinicmp,$pinicomp)));
							$vlprop = trim(substr($linha,$pinicomp + 1));
							if (stripos(trim($vlprop),'__INICAMPO__') !== false) {
								$campoini = true;
								$campofim = false;	
								$elementos[$nome_elemento][$prop] = '';
							} else {
								$elementos[$nome_elemento][$prop] = $vlprop;
							}
						} 
						continue;				
					}						
					if (stripos($linha,$configuracoes_catalogo['iniciosub']) !== false) {
						if ($configuracoes_catalogo['grupamento_sub'] === true) {
							if (isset($elementos[$nome_elemento]['sub']) === false) {
								$elementos[$nome_elemento]['sub'] = [];
							}
							prev($arr_linhas_arq);
							self::estruturar_array_arquivo($caminho_arquivo,$elementos[$nome_elemento]['sub'],null,$arr_linhas_arq,$configuracoes_catalogo);
						} else {
							prev($arr_linhas_arq);
							self::estruturar_array_arquivo($caminho_arquivo,$elementos[$nome_elemento],null,$arr_linhas_arq,$configuracoes_catalogo);
						}
						continue;				
					} 		
					if (stripos($linha,$configuracoes_catalogo['fimsub']) !== false) {
						if ($encontrouini === true) {
							if ($encontroufim === false) {
								$encontrouini = false;
								$encontroufim = true;
								continue;					
							} else {
								prev($arr_linhas_arq);
								break;					
							}
						} else {
							if ($encontroufim === true) {
								$encontrouini = false;
								$encontroufim = true;
							prev($arr_linhas_arq);
							break;					
							} else {
								continue;
							}				
						}
					}			
				}
			}
			return $elementos;
		}

		/**
		 * Traduz constantes antes de parsear o conteudo do arquivo em json.
		 * Nem todas as constantes devem ser traduzidas, na verdade somente as explicitas nesta funcao sao traduzidas na leitura
		 * do catalogo, demais devem ser traduzidas em processos proprios ou serem gravadas no banco como estao para serem
		 * traduzidas no momento de sua recuperacao
		 */
		public static function traduzir_constantes_catalogo($texto) {
			if (strpos($texto,'__') !== false) {

				/*traduz constantes em catalogos que correspondem a valores de objetos de banco de dados */
				$texto = str_ireplace([
					'__PREFIXODBSISJD__',
					'__PREFIXODBSIS__',
					'__FNV_GET_PREFIXOBJECTSDB__',
					'__FNV_GET_NAMECONNECTIONDEFAULT__',
					'__FNV_GET_NAMECONNECTIONERP__',
					'__FNV_GET_NOMESCHEMAERP__'
				],[
					VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd),
					VariaveisSql::getInstancia()->getPrefixObjects(),
					FuncoesVariaveis::__FNV_GET_PREFIXOBJECTSDB__(),
					FuncoesVariaveis::__FNV_GET_NAMECONNECTIONDEFAULT__(),
					FuncoesVariaveis::__FNV_GET_NAMECONNECTIONERP__(),
					FuncoesVariaveis::__FNV_GET_NOMESCHEMAERP__()
				],$texto);

				$p1 = stripos($texto,'__FNV_GET_NOMESCHEMA__(');
				while ($p1 !== false) {					
					$texto_temp = $texto;
					$p1a = strpos($texto,'(',$p1);
					$p2a = strpos($texto,')',$p1a);
					$p2 = $p2a + 1;
					$str_substituir = substr($texto,$p1,($p2-$p1));					
					$str_substituta = eval('return \\SJD\\php\\classes\\funcoes\\FuncoesVariaveis::' . str_replace('\\','',$str_substituir) . ';');
					$texto = str_ireplace($str_substituir,$str_substituta,$texto);
					$p1 = stripos($texto,'__FNV_GET_NOMESCHEMA__(');
					if ($texto === $texto_temp) { //previne loop infinito;
						break;
					}
				}
				$texto = str_ireplace('__FNV_GET_NOMESCHEMA__',FuncoesVariaveis::__FNV_GET_NOMESCHEMA__(),$texto);

				$autoincnum = 0;
				$pos_autoinc = stripos($texto,'__AUTOINC__');
				$length = strlen('__AUTOINC__');
				while($pos_autoinc !== false) {
					$texto = substr_replace($texto, $autoincnum, $pos_autoinc, $length);
					$autoincnum++;
					$pos_autoinc = stripos($texto,'__AUTOINC__');
				}
			}
			return $texto;
		}


		/**
		 * Traduz constantes do catalogo apos parseado em json.
		 * Nem todas as constantes devem ser traduzidas, na verdade somente as explicitas nesta funcao sao traduzidas na leitura
		 * do catalogo, demais devem ser traduzidas em processos proprios ou serem gravadas no banco como estao para serem
		 * traduzidas no momento de sua recuperacao
		 */
		public static function traduzir_constantes_json_catalogo(&$json, $chave_sup = null, $elemento_sup = null) {
			$p1 = false;
			if (strpos(json_encode($json),'__') !== false) {		
				/*traduz constantes que fazem referencia a objetos json depois de criado o objeto json */
				if (in_array(gettype($json),['object','array'])) {
					foreach($json as $chave => &$valor) {												
						switch(gettype($valor)){
							case 'string':
								while (strpos($valor,'__') !== false) {
									$valor_temp = $valor;
									$valor = str_ireplace('__CHAVE__',($chave_sup!==null?$chave_sup:$chave),$valor);									
									$p1 = stripos($valor,'__VALORCHAVESUP__(');
									if ($p1 !== false) {
										
										$p1a = strpos($valor,'(',$p1);
										$p2a = strpos($valor,')',$p1a);
										$p2 = $p2a + 1;
										$str_substituir = substr($valor,$p1,($p2-$p1));
										$str_chave_sup = trim(substr($valor,$p1a+1,($p2a - ($p1a+1))));
										if (property_exists($elemento_sup,$str_chave_sup)) {
											$valor = str_ireplace($str_substituir,$elemento_sup->{$str_chave_sup},$valor);
										}
									}

									$p1 = stripos($valor,'__VALORCHAVE__(');
									if ($p1 !== false) {
										$p1a = strpos($valor,'(',$p1);
										$p2a = strpos($valor,')',$p1a);
										$p2 = $p2a + 1;
										$str_substituir = substr($valor,$p1,($p2-$p1));
										$str_chave = trim(substr($valor,$p1a+1,($p2a - ($p1a+1))));
										if (property_exists($json,$str_chave)) {
											$valor = str_ireplace($str_substituir,$json->{$str_chave},$valor);
										}
									}

									if ($valor === $valor_temp) { //evita loop infinito
										break;
									}
								}
								break;
							case 'object':
								self::traduzir_constantes_json_catalogo($valor,$chave,$json);
								break;
							case 'array':
								foreach($valor as $indice => &$elemento) {						
									self::traduzir_constantes_json_catalogo($elemento,$chave_sup,$json);
								}
								break;
							default:
								if (gettype($valor) !== 'integer') {
									echo 'iplementar a tratativa deste tipo: ' . $chave . ' ' . gettype($valor) . ' ' ; 
									print_r($json);
									exit();
								}
								break;
						}
					}	
				}			
			}
			return $json;
		}
		
		public static function ler_arquivo($caminhoarquivo,$tipo_retorno = 'texto') {
			$retorno = null;
			if (file_exists($caminhoarquivo)) {		
				switch(strtolower(trim($tipo_retorno))) {
					case 'array':
						$retorno = file($caminhoarquivo);
						break;
					case 'texto':
					case 'string':
					default:
						$retorno = file_get_contents($caminhoarquivo);
						break;
				}
			}
			return $retorno;
		}

		public static function ler_arquivo_catalogo_json(
			$caminho_arquivo = null, 
			$opcoes = [
				'filtro' => null, 
				'traduzir_apos_filtro' => false, 
				'preparar_string_antes'=>true]
		) {
			try {				
				$elementos = null;
				if (isset($caminho_arquivo)) {
					if ($caminho_arquivo !== null) {
						if (gettype($caminho_arquivo) === 'string') {
							if (strlen(trim($caminho_arquivo)) > 0 ) {
								if (file_exists($caminho_arquivo)) {
									if (!isset($opcoes['filtro'])) {
										$opcoes['filtro'] = null;
									}
									if (!isset($opcoes['traduzir_apos_filtro'])) {
										$opcoes['traduzir_apos_filtro'] = false;
									}
									if (!isset($opcoes['preparar_string_antes'])) {
										$opcoes['preparar_string_antes'] = true;
									}
									
									$texto_arq = self::ler_arquivo($caminho_arquivo,'string');
									
									$texto_arq = self::traduzir_constantes_catalogo($texto_arq);
									
									if (strlen($texto_arq) > 0) {								
										$mensagem_erro_conversao = '';
										
										$json_arq = FuncoesJson::strtojson($texto_arq, $mensagem_erro_conversao, $opcoes['preparar_string_antes']);
										
										if ($opcoes['traduzir_apos_filtro']  === false) {											
											self::traduzir_constantes_json_catalogo($json_arq);
										}
										
										if ($mensagem_erro_conversao !== null && strlen($mensagem_erro_conversao) > 0) {
											print_r($texto_arq);
											FuncoesBasicasRetorno::mostrar_msg_sair('erro na conversao para json ao arquivo $caminho_arquivo: ' . $mensagem_erro_conversao, __FILE__,__FUNCTION__,__LINE__);
										} else {
											if ($opcoes['filtro'] !== null) {
												
												if (property_exists($json_arq,$opcoes['filtro'])) {
													$elementos = $json_arq->{$opcoes['filtro']};
												} 
											} else {
												$elementos = $json_arq;
											}
										}								
										if ($elementos !== null && $opcoes['traduzir_apos_filtro']  === true) {											
											self::traduzir_constantes_json_catalogo($elementos);
										}

									} else {
										FuncoesBasicasRetorno::mostrar_msg_sair('catalogo vazio: ' . $caminho_arquivo,__FILE__,__FUNCTION__,__LINE__);
									}
								} else {
									FuncoesBasicasRetorno::mostrar_msg_sair('catalogo nao existe: ' . $caminho_arquivo,__FILE__,__FUNCTION__,__LINE__);
								}
							}
						}
					}
				}
				return $elementos;
			} catch (\Exception $e) {
				FuncoesBasicasRetorno::mostrar_msg_sair($e);
			} 
		}
		
		public static function criar_arquivo(&$comhttp,$caminhoarquivo,$valor=null,$sobrescrever=false){
			$arquivo = null;
			//echo 'ok1'; exit();
			if ($caminhoarquivo !== null) {
				if (strlen(trim($caminhoarquivo)) > 0) {
					if (file_exists($caminhoarquivo)) {
						if ($sobrescrever===true) {
							
							unlink($caminhoarquivo);
							$diretorio = dirname($caminhoarquivo);
							if (!is_dir($diretorio)){
								mkdir($diretorio, 0755, true);
							}			
							$arquivo = fopen($caminhoarquivo,'x');
							fwrite($arquivo,$valor);
							fclose($arquivo);			
						} else {
							
						}
					} else {		
						$diretorio = dirname($caminhoarquivo);
						if ($diretorio !== null) {
							if (trim($diretorio) !== '.' && trim($diretorio) !== '') {								
								if (!is_dir($diretorio)) {
									mkdir($diretorio, 0755, true);
								}
							}
						}
						$arquivo = fopen($caminhoarquivo,'x');
						fwrite($arquivo,$valor);
						fclose($arquivo);
					}
				} else {
					trigger_error('caminho de arquivo em branco',E_USER_ERROR);
				}
			} else {
				trigger_error('caminho de arquivo nulo',E_USER_ERROR);
			}
		}
	}
?>