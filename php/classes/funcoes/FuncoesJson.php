<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
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
	class FuncoesJson extends ClasseBase{
		public static function encontrar_prox_asp_valida($p_str,$p_pini = 0) {
			$v_pini = $p_pini;
			$v_pos_asp_inv = strpos($p_str,'\"',$v_pini);
			$v_pos_asp1 = strpos($p_str,'"',$v_pini);
			if (($v_pos_asp_inv !== false) && ($v_pos_asp_inv === ($v_pos_asp1 - 1))) {
				while($v_pos_asp1 !== false && $v_pos_asp_inv === ($v_pos_asp1 - 1)) {
					$v_pini = $v_pos_asp1 + 1;
					$v_pos_asp_inv = strpos($p_str,'\"',$v_pini);
					$v_pos_asp1 = strpos($p_str,'"',$v_pini);    
				}
			}
			return $v_pos_asp1;
		}

		public static function preparar_str_para_conversao_json(&$pv_str) {
			$v_vpos_asp1 = self::encontrar_prox_asp_valida($pv_str);        
			if ($v_vpos_asp1 !== false) {
				$v_vpos_asp2 = 1; //somente para passar do primeiro loop;
				while ($v_vpos_asp1 !== false && $v_vpos_asp2 !== false) {
					$v_vpos_asp2 = self::encontrar_prox_asp_valida($pv_str,$v_vpos_asp1 + 1);			
					if ($v_vpos_asp2 === false) {
						break;
					}
					$v_str1 = substr($pv_str,0,$v_vpos_asp1);			
					$v_str2 = substr($pv_str,$v_vpos_asp2 + 1);
					$v_str_prep = substr($pv_str,$v_vpos_asp1,($v_vpos_asp2 - ($v_vpos_asp1) + 1));
					$v_vcomp1 = strlen($v_str_prep);
					$v_str_prep = str_replace(chr(10) . chr(13), '\n', $v_str_prep);
					$v_vpos_asp2 = $v_vpos_asp2 + (strlen($v_str_prep) - $v_vcomp1);
					$v_vcomp1 = strlen($v_str_prep);
					$v_str_prep = str_replace(chr(13) . chr(10), '\n', $v_str_prep);
					$v_vpos_asp2 = $v_vpos_asp2 + (strlen($v_str_prep) - $v_vcomp1);
					$v_vcomp1 = strlen($v_str_prep);
					$v_str_prep = str_replace(chr(10), '\n', $v_str_prep);
					$v_vpos_asp2 = $v_vpos_asp2 + (strlen($v_str_prep) - $v_vcomp1);
					$v_vcomp1 = strlen($v_str_prep);
					$v_str_prep = str_replace(chr(13), '\n', $v_str_prep);
					$v_vpos_asp2 = $v_vpos_asp2 + (strlen($v_str_prep) - $v_vcomp1);
					$v_vcomp1 = strlen($v_str_prep);
					$v_str_prep = str_replace(chr(9), '    ', $v_str_prep);
					$v_vpos_asp2 = $v_vpos_asp2 + (strlen($v_str_prep) - $v_vcomp1);
					$pv_str = $v_str1 .  $v_str_prep . $v_str2;
					$v_vpos_asp1 = self::encontrar_prox_asp_valida($pv_str,$v_vpos_asp2 + 1);
				}
			};
		}

		/**
		 * obtem um valor de um json, com base no caminho. o valor é obtido por referencia (&)
		 * @param {object | array} &$objeto - o objeto de pesquisa
		 * @param {array | string} $arr_caminho - o array ou string com o endereço da propriedade
		 * @return {variant} - o valor encontrado ou nulo se nao encontrado
		 */
		public static function get_valor(object | array &$objeto, array | string $arr_caminho) {
			if (isset($objeto) && $objeto !== null) {				
				if (gettype($arr_caminho) === "string") {				
					$arr_caminho = explode("/",$arr_caminho);
				}
				$type_obj = gettype($objeto);
				$objeto_iterador = &$objeto;
				foreach($arr_caminho as $chave) {
					if (strlen(trim($chave)) === 0) {
						continue;
					}
					if ($type_obj === "object" && property_exists($objeto_iterador,$chave)) {
						$objeto_iterador = &$objeto_iterador->{$chave};
						$type_obj = gettype($objeto_iterador);
					} else if ($type_obj === "array" && isset($objeto_iterador[$chave])) {
						$objeto_iterador = &$objeto_iterador[$chave];
						$type_obj = gettype($objeto_iterador);
					} else {
						return null;
					}
				}
				return $objeto_iterador;
			} else {
				return null;
			}			
		}

		/**
		 * processa a tag $ref no object json, fazendo referencia (&) ao objeto de refernciado pelo endereço em 
		 * $ref
		 * @todo observar o que vai ocorrer se houver recursao em loop ($ref:.... $ref:pai)
		 * 		 provavelmente travará aqui em loop infinito que deverá ser tratado
		 */
		public static function processar_tag_ref(object | array &$objeto_inicial, &$objeto_atual) {
			if ($objeto_atual !== null) {
				foreach($objeto_atual as $chave=>&$valor) {
					if (gettype($valor) === "object") {
						self::processar_tag_ref($objeto_inicial,$valor);
					}
					if ($chave === "\$ref") {
						$objeto_atual = self::get_valor($objeto_inicial,str_replace("#","",$valor));
						break;
					}					
				}
			}
		}
			
		public static function strtojson(&$str,&$mensagem_erro_conversao, $preparar_antes = true) {
			$retorno = null;
			$mensagem_erro_conversao = null;
			try{
				if ($preparar_antes === true) {
					self::preparar_str_para_conversao_json($str);
				}
				$retorno = json_decode($str);
				switch (json_last_error()) {
					case JSON_ERROR_NONE:
						$mensagem_erro_conversao  = null;
						self::processar_tag_ref($retorno,$retorno);	
						break;
					case JSON_ERROR_DEPTH:
						$mensagem_erro_conversao = json_last_error_msg() . " Profundidade Maxima de conversao de string em json extrapolada";
						break;
					case JSON_ERROR_STATE_MISMATCH:
						$mensagem_erro_conversao = json_last_error_msg() . " Underflow or the modes mismatch";
						break;
					case JSON_ERROR_CTRL_CHAR:
						$mensagem_erro_conversao = json_last_error_msg() . " Caractere de controle inesperado";
						break;
					case JSON_ERROR_SYNTAX:
						$mensagem_erro_conversao = json_last_error_msg() . " string para json mal formada, erro de sintese";
						break;
					case JSON_ERROR_UTF8:
						$mensagem_erro_conversao = json_last_error_msg() . " string para json contem caracteres nao UTF-8, erro de codificacao de caracteres";
						break;
					default:
						$mensagem_erro_conversao = json_last_error_msg() . " string para json invalida";
						break;
					break;
				}
			} catch(\Exception $e){
				$mensagem_erro_conversao .= " " .$e->getmessage();		
			}
			return $retorno;
		}

		public static function procurar_elemento_json_por_chave($json, $chave, $valor) {
			$retorno = null;
			if ($json != null) {
				foreach($json as $ch => $el) {
					if (in_array(gettype($el),["object","array"])) {
						$retorno = self::procurar_elemento_json_por_chave($el,$chave,$valor);
						if ($retorno !== null) {
							return $retorno;
						}
					} else if ($ch === $chave) {
						if ($el == $valor) {
							return $json;
						}
					}
				}		
			}
			return $retorno;
		}

		public static function strtojson2(&$str) {
			$escapers =     array("\\"  ,"\b" ,"\f" ,"\n" ,"\r" ,"\t" ,"\u" ,"/"  ,"\'" ,"\x08","\x0c","[,","{,",",]",",}",",,");
			$replacements = array("\\\\","\\b","\\f","\\n","\\r","\\t","\\u","\\/","\\'","\\f" ,"\\b" ,"[" ,"{" ,"]" ,"}" ,"," );
			$str = str_replace($escapers, $replacements, $str);
			$str = str_replace("[,","[",$str);
			$str = str_replace("{,","{",$str);
			$retorno = json_decode($str,true);			
			if (json_last_error() != 0) {
				print_r([
					json_last_error(),
					json_last_error_msg()
				]);
				echo gettype($str);
				print_r($str); 
				FuncoesBasicasRetorno::mostrar_msg_sair("erro de conversao de json: " . json_last_error_msg(),__FILE__,__FUNCTION__,__LINE__);
			}
			return $retorno;
		}
		
	}
?>