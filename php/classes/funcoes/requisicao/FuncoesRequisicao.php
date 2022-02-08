<?php
	namespace SJD\php\classes\funcoes\requisicao;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\Constantes	
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesObjeto,
			FuncoesArray,
			FuncoesSisJD,
			requisicao\TComHttpSimples
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();


	/*codigo*/
	class FuncoesRequisicao extends ClasseBase{		

		private static function retornar_logar(&$comhttp) {
			
			if (!FuncoesObjeto::verif_valor_prop($comhttp,["requisicao","requisitar","oque"],"logar") && !FuncoesObjeto::verif_valor_prop($comhttp,["requisicao","requisitar","oque"],"opcao_recuperar_login") && 
				!FuncoesObjeto::verif_valor_prop($comhttp,["requisicao","requisitar","oque"],"recuperar_login") && !FuncoesObjeto::verif_valor_prop($comhttp,["requisicao","requisitar","oque"],"opcao_cadastrarse") &&
				!FuncoesObjeto::verif_valor_prop($comhttp,["requisicao","requisitar","oque"],"cadastrarse")) {
					
				FuncoesSisJD::getInstancia()->logar_sisjd($comhttp);
				
				if ($comhttp->retorno->dados_retornados["conteudo_html"] !== "LOGADO") {
					$comhttp->retorno->resultado = "logar";
					
					$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesSisJD::obter_conteudo_opcao_sistema($comhttp,"login");											
					
					$comhttp->retorno->dados_retornados["conteudo_javascript"] = FuncoesSisJD::obter_javascript_opcao_sistema($comhttp,"login");	
					
					if (session_status() === PHP_SESSION_NONE) {
						session_start();
					}
					$_SESSION["usuariosis"] = $_SESSION["usuariosis"] ?? [];
					//session_write_close();
					FuncoesBasicasRetorno::enviar_retorno($comhttp); 
					exit();
				}
			} 
		}

		public static function verificar_sessao(&$comhttp) {			
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			if (defined("__requisicaophp__")) {
				$_SESSION["requisicaophp"] = __requisicaophp__;
			} else if(isset($_SESSION["requisicaophp"])) {
				define("__requisicaophp__",$_SESSION["requisicaophp"]);
			}
			if (!isset($_SESSION["id"])) {				
				$_SESSION["id"] = session_id();
			}
			
			if (!isset($_SESSION["requisitante"])) {
				if (defined("__requisitante__")) {
					$_SESSION["requisitante"] = __requisitante__;
				}
			}
			
			$requerente = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:$_SERVER["HTTP_REFERER"]);
			session_write_close();	
			if (!isset($_SESSION["logged"])) {					
				self::retornar_logar($comhttp);
			} else {
				if ($_SESSION["logged"] !== true) {
					self::retornar_logar($comhttp);
				}
			}
			
		}	
		public static function requisicao_nao_logado(&$comhttp){
			$comhttp->retorno->dados_retornados = "NAO LOGADO";
		}
		public static function requisicao_vazia(&$comhttp){
			$comhttp->retorno->dados_retornados = "REQUISICAO VAZIA";
		}
		public static function requisicao_vazia_simples(&$comhttpsimples){
			$comhttpsimples->r = "REQUISICAO VAZIA";
		}
		public static function atribuir_valores_post(&$comhttp,$post) {
			if (isset($post)) {
				if (count($post)>0) {
					if (isset($_POST["id"])) {
						$comhttp->id = $_POST["id"];
					}
					$comhttp->id_carregando = (isset($_POST["id_carregando"])?$_POST["id_carregando"]:"");
					if (gettype($post["requisicao"]) === "string") {
						$post["requisicao"] = json_decode($post["requisicao"]);
					}
					if (gettype($post["requisicao"]) === "array") {
						$comhttp->requisicao->requisitar->oque = $post["requisicao"]["requisitar"]["oque"];
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","comando"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->comando = $post["requisicao"]["requisitar"]["qual"]["comando"];
						} else {
							$comhttp->requisicao->requisitar->qual->comando = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","tipo_objeto"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = $post["requisicao"]["requisitar"]["qual"]["tipo_objeto"];
						} else {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","objeto"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->objeto = $post["requisicao"]["requisitar"]["qual"]["objeto"];
						} else {
							$comhttp->requisicao->requisitar->qual->objeto = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","tabela"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->tabela = $post["requisicao"]["requisitar"]["qual"]["tabela"];
						} else {
							$comhttp->requisicao->requisitar->qual->tabela = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","campo"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->campo = $post["requisicao"]["requisitar"]["qual"]["campo"];
						} else {
							$comhttp->requisicao->requisitar->qual->campo = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","valor"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->valor = $post["requisicao"]["requisitar"]["qual"]["valor"];
						} else {
							$comhttp->requisicao->requisitar->qual->valor = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","codusur"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->codusur = $post["requisicao"]["requisitar"]["qual"]["codusur"];
						} else {
							$comhttp->requisicao->requisitar->qual->codusur = $_SESSION["codusur"];
						}
						$comhttp->opcoes_retorno = $post["opcoes_retorno"];
						$comhttp->requisicao->requisitar->qual->condicionantes = (isset($post["requisicao"]["requisitar"]["qual"]["condicionantes"])?$post["requisicao"]["requisitar"]["qual"]["condicionantes"]:"");						
						if (gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== "array") {
							$comhttp->requisicao->requisitar->qual->condicionantes = explode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes);
						}
						$comhttp->requisicao->requisitar->qual->condicionantes = FuncoesArray::chaves_associativas($comhttp->requisicao->requisitar->qual->condicionantes);
						if (FuncoesObjeto::verif_valor_prop($post,["eventos","aposretornar"],null,"setado")) {
							$comhttp->eventos->aposretornar = $post["eventos"]["aposretornar"];
						} 
					} else {
						$comhttp->requisicao->requisitar->oque = $post["requisicao"]->requisitar->oque;
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","comando"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->comando = $post["requisicao"]->requisitar->qual->comando;
						} else {
							$comhttp->requisicao->requisitar->qual->comando = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","tipo_objeto"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = $post["requisicao"]->requisitar->qual->tipo_objeto;
						} else {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","objeto"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->objeto = $post["requisicao"]->requisitar->qual->objeto;
						} else {
							$comhttp->requisicao->requisitar->qual->objeto = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","tabela"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->tabela = $post["requisicao"]->requisitar->qual->tabela;
						} else {
							$comhttp->requisicao->requisitar->qual->tabela = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","campo"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->campo = $post["requisicao"]->requisitar->qual->campo;
						} else {
							$comhttp->requisicao->requisitar->qual->campo = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","valor"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->valor = $post["requisicao"]->requisitar->qual->valor;
						} else {
							$comhttp->requisicao->requisitar->qual->valor = "";
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","codusur"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->codusur = $post["requisicao"]->requisitar->qual->codusur;
						} else {
							$comhttp->requisicao->requisitar->qual->codusur = $_SESSION["codusur"];
						}
						if (FuncoesObjeto::verif_valor_prop($post,["requisicao","requisitar","qual","senha"],null,"setado")) {
							$comhttp->requisicao->requisitar->qual->senha = $post["requisicao"]->requisitar->qual->senha;
						} 
						$comhttp->opcoes_retorno = (isset($post["opcoes_retorno"])?$post["opcoes_retorno"]:"");
						$comhttp->requisicao->requisitar->qual->condicionantes = (isset($post["requisicao"]->requisitar->qual->condicionantes)?$post["requisicao"]->requisitar->qual->condicionantes:"");						
						if (gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== "array") {
							$comhttp->requisicao->requisitar->qual->condicionantes = explode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes);
						}
						$comhttp->requisicao->requisitar->qual->condicionantes = FuncoesArray::chaves_associativas($comhttp->requisicao->requisitar->qual->condicionantes);
						if (FuncoesObjeto::verif_valor_prop($post,["eventos","aposretornar"],null,"setado")) {
							$comhttp->eventos->aposretornar = $post["eventos"]->aposretornar;
						} 					
					}
				} else {
					self::requisicao_vazia($comhttp);
				}
			} else {
				self::requisicao_vazia($comhttp);
			}
			return $comhttp;
		}
		
		public static function atribuir_valores_post_simples(&$comhttpsimples,$post) {
			
			if (isset($post)) {				
				if (count($post)>0) {
					if (isset($post["r"])) {
						$r = json_decode($post["r"]);
						//print_r($r);exit();
						if (in_array(gettype($r),["integer","string"])) {
							$comhttpsimples->a = 0; //requisicoes iniciais estao vinculadas ao usuario 0 (padrao)
							$comhttpsimples->b = $r;
						} else {
							$comhttpsimples->a = $r->a;
							$comhttpsimples->b = $r->b;
							$comhttpsimples->c = "";
							if (isset($r->c)) {
								//echo "ok1";exit();
								$comhttpsimples->c = $r->c;
							} 
							if (gettype($comhttpsimples->c) !== "array") {
								$comhttpsimples->c = explode(Constantes::sepn1,$comhttpsimples->c);
							}
							//print_r($comhttp->requisicao->requisitar->qual->condicionantes); exit();
							//print_r($comhttpsimples->c);//exit();
							$comhttpsimples->c = FuncoesArray::chaves_associativas($comhttpsimples->c);
							//print_r($comhttpsimples->c); exit();
						}
						
					} else {
						self::requisicao_vazia_simples($comhttpsimples);
					}
				} else {
					self::requisicao_vazia_simples($comhttpsimples);
				}
			} else {
				self::requisicao_vazia_simples($comhttpsimples);
			}
			return $comhttpsimples;
		}
		
		public static function receber_requisicao($post){
			$comhttp = new TComHttp();
			self::atribuir_valores_post($comhttp,$post);		
			return $comhttp;
		}		
		
		public static function receber_requisicao_simples($post){
			$comhttpsimples = new TComHttpSimples();
			self::atribuir_valores_post_simples($comhttpsimples,$post);	
			return $comhttpsimples;
		}
		
		

		
		
	}
?>