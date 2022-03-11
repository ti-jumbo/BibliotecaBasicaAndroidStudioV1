<?php
	namespace SJD\php\classes\funcoes;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,
		funcoes\FuncoesConversao
	};

	/*codigo*/
	class FuncoesObjeto extends ClasseBase{
		static function comparar($obj,$valor,$tipo_checagem='valor',$comparacao='='){
			switch($tipo_checagem) {
				case 'valor':
					switch($comparacao) {
						case '=':
						case 'igual':
							if (gettype($obj) === 'boolean' || gettype($valor) === 'boolean') {
								if (FuncoesConversao::como_boleano($obj) === FuncoesConversao::como_boleano($valor)) {
									return true;
								} else {
									return false;
								}						
							} else {
								if (in_array(gettype($obj),['integer','double','float','number','numeric']) || in_array(gettype($valor),['integer','double','float','number','numeric'])) {
									if (FuncoesConversao::como_numero($obj) === FuncoesConversao::como_numero($valor)) {
										return true;
									} else {
										return false;
									}
								} else {
									if ($obj === $valor) {
										return true;
									} else {
										return false;
									}							
								}
							}
							break;
						case '<>':
						case '!=':
						case '!==':
						case 'diferente':					
							if (gettype($obj) === 'boolean' || gettype($valor) === 'boolean') {
								if (FuncoesConversao::como_boleano($obj) !== FuncoesConversao::como_boleano($valor)) {
									return true;
									} else {
									return false;
								}						
							} else {
								if (in_array(gettype($obj),['integer','double','float','number','numeric']) || in_array(gettype($valor),['integer','double','float','number','numeric'])) {
									if (FuncoesConversao::como_numero($obj) !== FuncoesConversao::como_numero($valor)) {
										return true;
									} else {
										return false;
									}
								} else {
									if ($obj !== $valor) {
										return true;
									} else {
										return false;
									}							
								}
							}					

							break;										
						default:
							echo __FILE__.__LINE__.' comparacao nao definida: '.$comparacao;
							exit();
							break;									
					}							
					break;
				case 'contagem':
				case 'quantidade':
				case 'tamanho':
					switch($comparacao) {
						case '>':
						case 'maior':
							$tipo_obj = gettype($obj);
							switch($tipo_obj) {							
								case 'string':
									if (strlen(trim($obj)) > $valor) {
										return true;
									} else {
										return false;
									}							
									break;
								case 'array':
								default:
									if (count($obj) > $valor) {
										return true;
									} else {
										return false;
									}
									break;
							}
							break;
						default:
							echo __FILE__.LINE__.' comparacao nao definida: '.$comparacao;
							exit();
							break;
					}
					break;
				case 'setado':
					if (isset($obj)) {
						return true;
					} else {
						return false;
					}
					break;
				default:
					echo __FILE__.__LINE__.'tipo_checagem nao definido: '.$tipo_checagem;
					exit();
					break;
			}
		}	
		static function verif_valor_prop($obj,$arr_props,$valor=true,$tipo_checagem='valor',$comparacao='=') {
			$tipo_obj = '';
			$tipo_valor = gettype($valor);
			if (isset($obj)) {
				$tipo_obj = gettype($obj);
				switch($tipo_obj) {
					case 'object':
						if (count($arr_props) > 0) {
							if (property_exists($obj,$arr_props[0])) {
								$obj = $obj->{$arr_props[0]};
								array_shift($arr_props);
								return self::verif_valor_prop($obj,$arr_props,$valor,$tipo_checagem,$comparacao);
							} else {
								return false;
							}
						} else {
							$tipo_valor = gettype($valor);
							if ($tipo_obj === $tipo_valor) {
								return self::comparar($obj,$valor,$tipo_checagem,$comparacao);
							} else {							
								return false;
							}
						}
						break;
					case 'array':
						if (count($arr_props) > 0) {
							if (isset($obj[$arr_props[0]])) {
								$obj = $obj[$arr_props[0]];
								array_shift($arr_props);
								return self::verif_valor_prop($obj,$arr_props,$valor,$tipo_checagem,$comparacao);
							} else {
								return false;
							}
						} else {
							$tipo_valor = gettype($valor);
							return self::comparar($obj,$valor,$tipo_checagem,$comparacao);
						}
						break;
					default:
						$tipo_valor = gettype($valor);					
						return self::comparar($obj,$valor,$tipo_checagem,$comparacao);
						break;
				}
			} else {
				return false;
			}
		}
		
		static function valor_propriedade_objeto($obj,$arr_props) {
			$tipo_obj = '';
			$retorno = null;
			if (isset($obj) && $obj !== null) {
				$tipo_obj = gettype($obj);
				if (isset($arr_props) && $arr_props !== null) {
					if (gettype($arr_props) === 'string') {
						if (strpos($arr_props,',') !== false) {
							$arr_props = explode(',',$arr_props);
						} else {							
							switch($tipo_obj) {
								case 'object':
									if (property_exists($obj,$arr_props)) {
										return $obj->{$arr_props};
									} else {
										return null;
									}
									break;
								case 'array':
									return $obj[$arr_props];
									break;
								default:
									return null;
									break;
							}
						}
					} 
				
					
					switch($tipo_obj) {
						case 'object':
							if (count($arr_props) > 0) {
								if (property_exists($obj,$arr_props[0])) {
									$obj = $obj->{$arr_props[0]};
									array_shift($arr_props);
									if (count($arr_props) > 0) {
										return self::valor_propriedade_objeto($obj,$arr_props);
									} else {
										return $obj;
									}
								}
							}
							break;
						case 'array':
							if (count($arr_props) > 0) {
								if (isset($obj[$arr_props[0]])) {
									$obj = $obj[$arr_props[0]];
									array_shift($arr_props);
									if (count($arr_props) > 0) {
										return self::valor_propriedade_objeto($obj,$arr_props);
									} else {
										return $obj;
									}
								}
							}								
							break;
						default:
							return null;
							break;
					}
				}
			}
			return $retorno;
		}
		
		function copiar_propriedades( $ref , &$alvo, $atribuir_valores_chaves_iguais = false){
			$prop='';
			$tp_ref = '';
			$tp_alvo = '';
			if(isset( $ref )){
				$tp_ref = gettype( $ref ) ;
				if(isset( $alvo )){
					$tp_alvo = gettype( $alvo );
					if($tp_ref=== 'object' && $tp_alvo === 'object'){
						foreach ( $ref as $ind=>$val){
							$tp_ref = isset($ref->{$ind})?gettype( $ref->{$ind} ):'NULL';
							$tp_alvo = isset($alvo->{$ind})?gettype( $alvo->{$ind} ):'NULL';
							if($tp_ref === 'object' && $tp_alvo === 'object'){
								self::copiar_props( $ref->{$ind} , $alvo->{$ind} ) ;
							} else if($tp_ref === 'object'){
								$alvo->{$ind} = json_decode(json_encode($ref->{$ind}));
							}else{
								if($atribuir_valores_chaves_iguais || $tp_alvo === 'NULL'){
									$alvo->{$ind} = $ref->{$ind};
								};
							}
						};
					} else if($tp_ref === 'object'){
						$alvo = json_decode(json_encode($ref));
						return $alvo;
					}else{
						if($atribuir_valores_chaves_iguais){
							$alvo = $ref;
						}
						return $alvo;
					}
				}else{
					if($tp_ref === 'object'){
						$alvo = json_decode(json_encode($ref[$ind]));
						return $alvo;
					}else{
						$alvo = $ref;
						return $alvo;
					}
				}
			}else{
				return $alvo;
			}
		}	
	}
?>