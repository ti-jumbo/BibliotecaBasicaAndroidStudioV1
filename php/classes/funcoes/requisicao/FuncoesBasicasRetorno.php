<?php
	namespace SJD\php\classes\funcoes\requisicao;	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\ClasseBase;
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesArray
		};
	
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesBasicasRetorno extends ClasseBase {
		public static function mostrar_msg_sair() {
			echo "<pre>";
			print_r(func_get_args());
			echo "</pre>";
			exit();
		}
		
		public static function limpar_retorno(&$comhttp) {
			if (gettype($comhttp->requisicao->sql) === "object") {
				$comhttp->requisicao->sql->consulta_sql = null;
			}
			if (FuncoesArray::verif_valor_chave($comhttp->retorno->dados_retornados,["conteudo_html","mensagem"],0,"tamanho","maior") === true) {
				$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"] = htmlentities($comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"],ENT_NOQUOTES,'ISO-8859-1');
			}
		}
		public static function enviar_retorno(&$comhttp) {
			if (gettype($comhttp) === "object") {
				if (isset($comhttp->retorno) && gettype($comhttp->retorno) === "object") {
					self::limpar_retorno($comhttp);
					$comhttp->retorno->resultado="sucesso";
					if (isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"])) {
						unset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]);
					}
					if (isset($comhttp->requisicao->requisitar->qual->condicionantes["proc_estruturado"])) {
						unset($comhttp->requisicao->requisitar->qual->condicionantes["proc_estruturado"]);
					}
					if (isset($comhttp->requisicao->requisitar->qual->objeto)) {
						if (gettype($comhttp->requisicao->requisitar->qual->objeto) !== "string") {
							unset($comhttp->requisicao->requisitar->qual->objeto);
						}
					}
					if (isset($comhttp->retorno->dados_retornados["conteudo_html"])) {
						if (gettype($comhttp->retorno->dados_retornados["conteudo_html"]) === "string") {
							if (strlen(trim($comhttp->retorno->dados_retornados["conteudo_html"])) > 0) {						
								$conteudo_html_temp = $comhttp->retorno->dados_retornados["conteudo_html"];
								$conteudo_html_temp = str_replace(["\\","/","\t","\r","\n",'"'],["\\\\","\/","\\t","\\r","\\n",'\"'],$conteudo_html_temp);
								$comhttp->retorno->dados_retornados["conteudo_html"] = "";								
								$retorno = json_encode($comhttp,JSON_INVALID_UTF8_SUBSTITUTE);
								$chavecont = '"conteudo_html":""';
								$pinicont = stripos($retorno,$chavecont) ;
								if ($pinicont === false) {
									self::mostrar_msg_sair("conteudo html nao localizado: " . $retorno . "\nJSON:".json_last_error() . ":" . json_last_error_msg(),__FILE__,__FUNCTION__,__LINE__);
								} 
								$compchavecont = strlen($chavecont);
								$pinicont = $pinicont + $compchavecont - 1;
								$retorno1 = substr($retorno,0,$pinicont);
								$retorno2 = substr($retorno,$pinicont);
								unset($retorno);
								$retorno = $retorno1 . $conteudo_html_temp . $retorno2;
							} else {
								$retorno = json_encode($comhttp,JSON_INVALID_UTF8_SUBSTITUTE);
							}
						} else {
							$retorno = json_encode($comhttp,JSON_INVALID_UTF8_SUBSTITUTE);
						}
					} else {
						$retorno = json_encode($comhttp,JSON_INVALID_UTF8_SUBSTITUTE);
					}
				} else {
					$retorno = json_encode($comhttp,JSON_INVALID_UTF8_SUBSTITUTE);
				}
				if (json_last_error() > 0) {
					echo "Houve erro de conversao para json do retorno: ".json_last_error_msg(); 
					print_r($comhttp);
					exit();
				} else {
					echo $retorno; 
					exit();
				}
			} else {
				echo $comhttp; exit();
			}
		}
		
		public static function enviar_retorno_simples(&$comhttpsimples) {
			if (gettype($comhttpsimples) === "object") {
				/*if (gettype($comhttpsimples->r) === "array") {
					array_walk_recursive($comhttpsimples->r, function (&$val) {
						if (is_string($val)) {
							$val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
						}
					});
				}*/
				$retorno = json_encode($comhttpsimples->r,JSON_INVALID_UTF8_SUBSTITUTE); //JSON_UNESCAPED_UNICODE
				
				if (json_last_error() > 0) {
					echo "Houve erro de conversao para json do retorno: ".json_last_error_msg(); 
					print_r($comhttpsimples);
					//escrever_arquivo("logErrosRetorno.txt",json_last_error_msg());
					//file_put_contents('logErrosRetornoDados.txt', print_r($comhttpsimples, TRUE));
					exit();
				} else {
					echo $retorno; 
					$comhttpsimples = null;
					exit();
				}
			} else {
				echo $comhttpsimples; exit();
			}
		}
	}
?>