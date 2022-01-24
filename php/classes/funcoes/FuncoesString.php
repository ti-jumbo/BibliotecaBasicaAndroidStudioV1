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
	class FuncoesString extends ClasseBase{
		public static function transfhtmlentities($texto){
			$texto=htmlentities($texto,ENT_NOQUOTES,"ISO-8859-1");	
			return $texto;
		}
		public static function aumentar_nivel_aspas_simples($texto){
			$texto=str_replace("'","''",$texto);
			return $texto;	
		}
		public static function separar_comandos_por_delimitador($texto,$delimitador="/"){
			$arrcmd=[];
			$contcmd=0;
			foreach($texto as $chave=>$cmd){
				if(trim($cmd)===$delimitador){
					$contcmd++;
				} else {
					$arrcmd[$contcmd][]=$cmd;
				}
			}
			return $arrcmd;
		}
		public static function str_contem($str,$arr_procura) {
			$retorno = false;
			foreach($arr_procura as $str_procura) {
				if (stripos(trim($str),trim($str_procura)) !== false) {
					$retorno = true;
					break;
				}
			}
			return $retorno;
		}
		public static function concatenar($strs) {
			$retorno = "";
			if (gettype($strs) === "array") {
				foreach($strs as $str) {
					if (isset($str)) {
						if ( $str !== null ) {
							$retorno .= $str;
						}
					}
				}
			} else {
				$retorno = $strs;
			}
			return $retorno;
		}
		public static function aspas_duplas($str) {
			$retorno = "";
			$retorno = '"' . $str . '"';
			return $retorno;
		}
		public static function aspas_simples($str) {
			$retorno = "";
			$retorno = "'" . $str . "'";
			return $retorno;
		}
		public static function inserir_string($string_origem, $str_inserir, $posicao = null, $inserir_substituindo = false, $comprimento_substituir = null) {
			if ($posicao === null) {
				$posicao = strlen($string_origem);		
			}
			if ($inserir_substituindo === true) {
				
				return substr($string_origem, 0, $posicao) . $str_inserir . substr($string_origem, $posicao + $comprimento_substituir);
			} else {
				return substr($string_origem, 0, $posicao) . $str_inserir . substr($string_origem, $posicao);
			}
		}

		/**
			* Funcao que incrementa uma string baseado no numero ao final dela ou inclui um numero ao final dela, indicando um indice.
			*
			* @param string $str a string a incrementar o indice
			* @param string $indicador_posicao_indice a string que indica o inicio da posicao do indice dentro da string
			* @param integer $incrementar_em a string a incrementar o indice
			* @return string $str a string incrementada
			* @todo ver possibilidade de migrar essa funcao para um arquivo mais generico, o de funcoes de string por exemplo, pois ela pode ser util em outras partes.
		*/	
		public static function incrementar_indice_string($str, $indicador_posicao_indice = "_", $incrementar_em = 1) 
		{
			$p_ini_ind = strrpos($str, $indicador_posicao_indice);
			$indice = 0;
			$indice_str = "";
			if ($p_ini_ind === false) {
				$str .= $indicador_posicao_indice . $indice;
			} else {
				$indice_str = substr($str, $p_ini_ind + 1);
				if (strlen(trim($indice_str)) > 0) {
					$indice = como_numero($indice_str);
					if ($indice !== null) {
						$indice += $incrementar_em;
						$str = substr($str, 0, $p_ini_ind + 1) . $indice;
					} else {
						$indice = 0;
						$str .= $indicador_posicao_indice . $indice;
					}			
				} else {
					$str .= $indice;
				}
			}
			return $str;
		}

		public static function primeiro_nao_vazio($arrstr) {
			$retorno = "";
			foreach($arrstr as $str) {
				if ($str !== null && strlen(trim($str)) > 0) {
					$retorno = $str;
					break;
				}
			}
			return $retorno;
		}
		
		public static function substituir_acentos(&$string) {
			$string = str_ireplace(["á","à","ã","â","ä"],"a",$string);
			$string = str_ireplace(["Á","À","Ã","Â","Ä"],"A",$string);
			$string = str_ireplace(["é","è","ê","ë"],"e",$string);
			$string = str_ireplace(["É","È","Ê","Ë"],"E",$string);
			$string = str_ireplace(["í","ì","î","ï"],"i",$string);
			$string = str_ireplace(["Í","Ì","Î","Ï"],"I",$string);
			$string = str_ireplace(["ó","ò","õ","ô","ö"],"o",$string);
			$string = str_ireplace(["Ó","Ò","Õ","Ô","Ö"],"O",$string);
			$string = str_ireplace(["ú","ù","û","ü"],"u",$string);
			$string = str_ireplace(["Ú","Ù","Û","Ü"],"U",$string);
			$string = str_ireplace(["ç","Ç","&"],["c","C","E"],$string);			
			return $string;
		}

		public static function strTemValor($str) : bool {
			if (isset($str) && $str !== null && strlen(trim($str)) > 0) {
				return true;
			}
			return false;
		}

		public static function eliminarCaracteresEspeciais($string) {
			$escapers =     array("\\"  ,"\\b" ,"\\f" ,"\\n" ,"\\r" ,"\\t" ,"\\u" ,"/"  ,"\\'" ,"\x08","\x0c");
			$retorno = str_replace($escapers,"",$string);

			return $retorno;
		}

	}
?>