<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\ClasseBase;
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
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
	class FuncoesConversao extends ClasseBase{
		public static function como_numero($valor,$retornar_zero_nulo = false){
			try {
				$tipo = strtolower(gettype($valor));
				$vl_spt = ""; //valor sem ponto
				$vl_svg = ""; //valor sem virgula
				$posvirg = -1;
				$pospt   = -1;
				$vlini = "";
				//logs("como_numero ini: "+valor);
				$vlini=$valor;			
				if ($tipo === "null" || (($valor === null || $valor === "") && $retornar_zero_nulo === true)) {
					return 0;
				} else if ($tipo === "number" || $tipo === "integer") {
					return $valor;
				} else if ($tipo === "array") {
					foreach ($valor as &$val) {
						$val = self::como_numero($val);
					}
					return $valor;
				} else if ($tipo === "string") {
					$valor = trim($valor);
					$valor = str_ireplace("r\$","",$valor);
					$valor = str_ireplace("kg","",$valor);
					$valor = str_replace("%","",$valor);
					$valor = str_ireplace("px","",$valor);
					$valor = str_replace(" ","",$valor);
					$valor = trim($valor);
					$posvirg = strpos($valor,",");
					$pospt = strpos($valor,".");
					if($posvirg !== false){
						$vl_svg = str_replace(",","",$valor);
						if(strlen($vl_svg) < strlen($valor) -1){
							/*tinha mais de uma virgula, logo virgula nao E o separador de decimal*/
							$valor = str_replace(",","",$valor);
						} 
					}
					if($pospt !== false){
						$vl_spt = str_replace(".","",$valor);
						if(strlen($vl_spt) < strlen($valor) -1){
							/*tem mais de um ponto, logo ponto nao E o separador de decimal*/
							$valor = str_replace(".","",$valor);
						}
					}
					if($posvirg !== false || $pospt !== false){
						if(strlen($vl_svg) === strlen($valor) -1 && strlen($vl_spt) === strlen($valor) -1 ){
							/*tem uma virgula e um ponto, um pode ser o decimal e outro o milhar*/
							if(strpos($valor,",") === strpos($valor,".")+4) {
								/*ponto estA na frente da virgula e E o separador de milhar, exclui-lo*/
								$valor = str_replace(".","",$valor);
								$valor = str_replace(",",".",$valor);
							}else if(strpos($valor,".")===strpos($valor,",")+4){
								/*virgula estA na frente do ponto e E a separadora de milhar, apenas excluila*/
								$valor = str_replace(",","",$valor);
							}else{
								FuncoesBasicasRetorno::mostrar_msg_sair("erro de conversao numerica: nao eh possivel converter ".$valor . " em numero",__FILE__,__FUNCTION__,__LINE__);
							}
						}else if(strlen($vl_svg) === strlen($valor) -1){
							/*tem uma virgula somente, trocala por ponto, pois significa a separacao de decimal*/
							$valor = str_replace(",",".",$valor);
						}else if(strlen($vl_spt) === strlen($valor) -1){
							/*tem um ponto somente, jA pode ser um numero*/
						}else{
							/*nao tem nehum separador, jA pode ser um numero*/
						}
					}
					$valor = str_replace(",",".",$valor); //se sobrou uma virgula ate aqui significa que ela E o decimal
					$valor = (float)$valor;
					return $valor ;
				} else {		
					FuncoesBasicasRetorno::mostrar_msg_sair("erro de conversao numerica: nao eh possivel converter o tipo de dado ".$tipo . " em numero",__FILE__,__FUNCTION__,__LINE__);
				}
			} catch(\Exception $e) {
				return null;
			}
		}
		public static function como_boleano($var,$tipo_retorno = "booleano"){
			$retorno=false;
			if (isset($var)) {
				if ($var !== null) {
					if (gettype($var) === "string") {
						if (strcasecmp(trim($var),"true") == 0 || trim($var) === "1") {
							$retorno = true;
						} else {
							$retorno = false;
						}
					} else {
						$retorno = (bool)$var;
					}
				}
			}
			if ($tipo_retorno === "string") {
				if ($var) {
					$retorno = "true";
				} else {
					$retorno = "false";
				}
			}
			return $retorno;
		}
		
		public static function json_para_array($json,$chaves_maiusculas=false) {
			$retorno = null;
			if ($json != null) {
				$retorno = [];
				foreach($json as $ch => $el) {
					if ($chaves_maiusculas === true) {
						$retorno[strtoupper($ch)] = $el;
					} else {
						$retorno[$ch] = $el;
					} 
				}
			}
			return $retorno;
		}
		
	}
?>