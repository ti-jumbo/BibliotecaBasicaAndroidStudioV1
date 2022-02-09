<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			sql\TSql,			
			variaveis\VariaveisSql
		};
	use SJD\php\classes\constantes\{
			Constantes,
			NomesDiretorios,
			NomesCaminhosDiretorios,
			NomesCaminhosArquivos,
			NomesCaminhosRelativos,
			ConstsQuerysSql
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesErro,
			FuncoesSql,
			FuncoesArquivo,
			FuncoesArray,
			FuncoesHtml,
			FuncoesData,
			FuncoesMontarRetorno,
			FuncoesVariaveis,
			requisicao\TComHttp,
			requisicao\FuncoesRequisicao,
			requisicao\FuncoesRequisicaoSis,
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
	class FuncoesSisJD extends ClasseBase{		

		public static function obter_visoes_relatorio_venda(){
			$cmd_sql="";
			$visoes = [];
			if (FuncoesSql::getInstancia()->tabela_existe("sjdvisoes")) {
				$cmd_sql="select nomevisaovisivel from sjdvisoes order by codvisao";
				$visoes = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchAll",\PDO::FETCH_COLUMN,0);				
			}			
			return $visoes;
		}

		public static function obter_visoes_relatorio_venda_condic(){
			$cmd_sql="";
			$visoes = [];
			if (FuncoesSql::getInstancia()->tabela_existe("sjdvisoes")) {
				$cmd_sql="select nomevisaovisivel from sjdvisoes where coalesce(aparecer_condicionante,0) = 1 order by codvisao";
				$visoes = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchAll",\PDO::FETCH_COLUMN,0);				
			}
			return $visoes;
		}

		public static function visoes_como_relatorio_venda($visoes){
			if (gettype($visoes) !== "array") {
				$visoes = explode(",",$visoes);
			}
			foreach ($visoes as &$vis) {
				$vis = "relatorio_venda_visao_" . str_replace(" ","_",strtolower(trim($vis)));		
			}	
			$visoes = implode(",",$visoes);
			return $visoes;
		}

		/**
		 * Funcao utilizada na ordenacao de arr_tit de dados sql com pivot
		 */
		public static function pegar_ordem(&$item, $key) {
			if (gettype($item) === "integer") {
				$GLOBALS["arr_ord"][] = $item;
			}
		}
		public static function voltar_texto_tit_original(&$item, $key) {
			if (gettype($item) !== "array") {
				if (!in_array($key,["cod","codsup","codligcamposis","texto","valor","linha","coluna","formatacao","indexreal","rowspan","colspan"])) {
					$item = $key;
				}
			}
		}

		public static function logar_sisjd(&$comhttp) {
			try {
				$retorno_func = '';
				$condic_log = '';
				
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["usuario"]) && isset($comhttp->requisicao->requisitar->qual->condicionantes["senha"])) {		
					$usuario = $comhttp->requisicao->requisitar->qual->condicionantes["usuario"];
					$senha = $comhttp->requisicao->requisitar->qual->condicionantes["senha"];
				} else {
					if (isset($comhttp->requisicao->requisitar->qual->codusur) && isset($comhttp->requisicao->requisitar->qual->senha)) {
						$usuario = $comhttp->requisicao->requisitar->qual->codusur;
						$senha = $comhttp->requisicao->requisitar->qual->senha;
					} else {
						$retorno_func .= 'Dados de login em branco.';
						$comhttp->retorno->resultado = "sucesso";
						$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
						goto fim;
					}
				}
				
				$comhttp->retorno->dados_retornados = [];
				if (trim($usuario) !== '') {
					$condic_log = 'CODUSUARIOSIS='.$usuario;
				} else {
					$retorno_func = "Dados nao informados";
					$comhttp->retorno->resultado = "sucesso";
					$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
					return ;
				}			
				
				$prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();
				if (FuncoesSql::getInstancia()->tabela_existe($prefix_objects. "usuariosis") === true) {	
					$comando_sql = "select * from " . $prefix_objects . "usuariosis " . " where ".$condic_log;
					$login = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);					
				} else {		
					$dados_cat = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_usuarios_sistema"),["filtro"=>"0","traduzir_apos_filtro"=>true,"preparar_string_antes"=>false]); //se a tabela ainda nao existe, somente o usuario 0 pode logar
					if ($dados_cat != null) {			
						if ($dados_cat->codusuariosis."" === $usuario."") {
							$login = [
								"codusuariosis" => (property_exists($dados_cat,"codusuariosis")?$dados_cat->codusuariosis:""),
								"nome" => (property_exists($dados_cat,"nome")?$dados_cat->nome:""),
								"status" => (property_exists($dados_cat,"status")?$dados_cat->status:""),
								"tipousuario" => (property_exists($dados_cat,"tipousuario")?$dados_cat->tipousuario:""),
								"podever" => (property_exists($dados_cat,"podever")?$dados_cat->podever:""),
								"codnivelacesso" => (property_exists($dados_cat,"codnivelacesso")?$dados_cat->codnivelacesso:""),
								"regrapersonalizada" => (property_exists($dados_cat,"regrapersonalizada")?$dados_cat->regrapersonalizada:""),
								"senha" => (property_exists($dados_cat,"senha")?$dados_cat->senha:"")					
							];				
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair("somente usuario sistema(0) pode logar se as tabelas nao existirem",__FILE__,__FUNCTION__,__LINE__);
						}
					} else {
						FuncoesBasicasRetorno::mostrar_msg_sair("usuario sistema(0) nao encontrado no catalogo, somente usuario sistema(0) pode logar se as tabelas nao existirem",__FILE__,__FUNCTION__,__LINE__);
					}
				}
				

				if (gettype($login) === "array" && count($login) > 0) {	
					if (strcasecmp(trim($login['senha']),trim($senha)) == 0) {
						if (!($login['status'] === 'LIBERADO')) {
							$retorno_func.="Cadastro nao liberado. Entre em contato com a Jumbo Alimentos para liberar seu cadastro.";
							$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
						} else {
							$comhttp->requisicao->requisitar->qual->codusur = $login["codusuariosis"];
							$_SESSION['login'] = true;
							$_SESSION["logged"] = $_SESSION['login'];
							$_SESSION['nome_usuario'] = $login['nome'];
							$_SESSION['codusur'] = $login['codusuariosis'];
							$_SESSION["tipousuario"] = $login["tipousuario"];
							if ($login["tipousuario"] === "cliente") {
								$cmdsqltemp = "select codcli from jumbo.pcclient where to_number(trim(replace(replace(replace(cgcent,'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(". $login["codusuariosis"] . ",'.',''),'-',''),'/',''))) and bloqueio != 'S' and dtexclusao is null and rownum <=1" ;
								$dadoscli = FuncoesSql::getInstancia()->executar_sql($cmdsqltemp,"fetch",\PDO::FETCH_ASSOC);
								if (count($dadoscli) > 0) {
									$_SESSION["codcli"] = $dadoscli["codcli"];
								} else {
									$retorno_func = "Nao foi possivel logar, dados do cliente nao localizados na base. Contate a Jumbo Alimentos para regularizar.";
									$comhttp->retorno->resultado = "sucesso";
									$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
								}
							}
							$_SESSION['podever'] = $login['podever'];	
							$_SESSION['nivelacesso'] = $login['codnivelacesso'];	
							$_SESSION['regrapersonalizada'] = $login['regrapersonalizada'];	
							$_SESSION['navegador'] = isset($opcoes->navegador)?$opcoes->navegador:"";
							$ips_cliente = [];
							$vars_http = array("REMOTE_ADDR","HTTP_X_FORWARDED_FOR","HTTP_X_FORWARDED","HTTP_FORWARDED_FOR","HTTP_FORWARDED","HTTP_X_COMING_","HTTP_COMING_","HTTP_CLIENT_IP");    
							
							foreach ($vars_http as $vr) {
								if (isset($_SERVER[$vr])) {
									$ips_cliente[]= trim($_SERVER[$vr]);
								}
							}
							$_SESSION["ips_cliente"] = implode( "," , $ips_cliente );
							if ($_SESSION['codusur'] !== 142) {
								$opcoes = '
								{
									"codusur":"'.$_SESSION['codusur'].'",
									"data_acesso":"'.date('d/m/Y').'",
									"horario_acesso":"'.date('H:i:s').'",
									"tipo_processo":"login",
									"nome_processo":"login",
									"visoes":"nulo",
									"campos_avulsos_visoes":"nulo",
									"visoes_positivadoras":"nulo",
									"campos_avulsos_visoes_posit":"nulo",
									"condicionantes":"'.$_SESSION['podever'].", ".$_SESSION['regrapersonalizada'].'",
									"periodos":"nulo",
									"opcoes_pesquisa":"nulo",
									"exportado":"false",
									"navegador":"'.$_SESSION['navegador'].'"
								}';							
								$opcoes = json_decode($opcoes);
							}
							
							$_SESSION["usuariosis"] = FuncoesSql::getInstancia()->obter_usuario_sis(["condic"=>$_SESSION["codusur"]]);
							if (isset($_SESSION["usuariosis"]) && $_SESSION["usuariosis"] !== null && gettype($_SESSION["usuariosis"]) === "array" && count($_SESSION["usuariosis"]) > 0) {
								$_SESSION["usuariosis"] = $_SESSION["usuariosis"][0];
							}
							$GLOBALS["usuariosis"] = $_SESSION["usuariosis"];
							
							$_SESSION["usuarios_subordinados"] = self::getInstancia()->obter_usuarios_subordinados($_SESSION["codusur"],["*"],true,true);						
							$_SESSION["usuarios_acessiveis"] = self::obter_usuarios_acessiveis($_SESSION["usuariosis"],["*"],true,true);
							$retorno_func = 'LOGADO';	
							$comhttp->retorno->resultado = "sucesso";
							$comhttp->retorno->dados_retornados["dados"] = [];
							$comhttp->retorno->dados_retornados["dados"]["usuariosis"] = $_SESSION["usuariosis"];
							$comhttp->retorno->dados_retornados["dados"]["usuarios_subordinados"] = $_SESSION["usuarios_subordinados"];
							$comhttp->retorno->dados_retornados["dados"]["usuarios_acessiveis"] = $_SESSION["usuarios_acessiveis"];
							$comhttp->retorno->dados_retornados["dados"]["idsessao"] = session_id();

							$nome_funcao_current_datetime = VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->functions->current_datetime->name ??
								VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->functions->current_datetime ?? null;
							FuncoesSql::getInstancia()->atualizar_dados_sql_avulso(
								$prefix_objects . "usuariosis",
								["idsessao","dtultlogin","dadoscon"],
								[$comhttp->retorno->dados_retornados["dados"]["idsessao"],$nome_funcao_current_datetime,""],
								["codusuariosis=" . $_SESSION['codusur']]
							);
							$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
							$GLOBALS["usuariosis"] = $_SESSION["usuariosis"];
							$GLOBALS["codusur"] = $login['codusuariosis'];
							session_write_close();
						}
					} else {
						$retorno_func .= "Senha incorreta.";
						$comhttp->retorno->resultado = "sucesso";
						$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
					}
					
				} else {
					$retorno_func .= 'Dados nao localizados.'.$usuario;
					$comhttp->retorno->resultado = "sucesso";
					$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
					
				};	
				fim:
				return ;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 	
		}

		public static function opcao_recuperar_login(&$comhttp){
			$comhttp->retorno->dados_retornados["conteudo_html"] = self::obter_conteudo_opcao_sistema($comhttp,"recuperar_login");
			$comhttp->retorno->dados_retornados["conteudo_javascript"] = self::obter_javascript_opcao_sistema($comhttp,"recuperar_login");		
		}
		public static function opcao_cadastrarse(&$comhttp){
			$comhttp->retorno->dados_retornados["conteudo_html"] = self::obter_conteudo_opcao_sistema($comhttp,"cadastrarse");
			$comhttp->retorno->dados_retornados["conteudo_javascript"] = self::obter_javascript_opcao_sistema($comhttp,"cadastrarse");		
		}

		public static function recuperar_login(&$comhttp) {
			$retorno_func = '';
			$condic_log = '';
			$temdado = false;
			$dados = [];
			$dados_envio = [];
			$comhttp->retorno->dados_retornados = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["usuario"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["usuario"])) > 0) {
					$dados["usuario"] = $comhttp->requisicao->requisitar->qual->condicionantes["usuario"];
					$temdado = true;
				}
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["email"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["email"])) > 0) {
					$dados["email"] = $comhttp->requisicao->requisitar->qual->condicionantes["email"];
					$temdado = true;
				} 
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["fone"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["fone"])) > 0) {
					$dados["fone"] = $comhttp->requisicao->requisitar->qual->condicionantes["fone"];
					$temdado = true;
				}
			} 
			
			
			if (count($dados) === 0) {
				$retorno_func .= 'Dados necessários nao informado. Informe corretamente ou entre em contato com o administrador do sistema.';
				$comhttp->retorno->resultado = "sucesso";
				$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO LOGADO: ".$retorno_func;
				goto fim;
			}
			
			$encontrado = false;
			if (isset($dados["usuario"])) {
				$comando_sql = "select * from ".VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis " . " where codusuariosis = " . $dados["usuario"];
				$dados = funcoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados) > 0) {
					$encontrado = true;
				}
			} 

			$prefixo_objects_sjd = VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd);
			
			if (isset($dados["email"])&&!$encontrado) {
				$comando_sql = "select * from " . $prefixo_objects_sjd . "usuariosis " . " where lower(trim(email)) = '" . strtolower(trim($dados["email"])) . "'";
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados) > 0) {
					$encontrado = true;
				}
			} 
			
			if (isset($dados["fone"])&&!$encontrado) {
				$comando_sql = "select * from " . $prefixo_objects_sjd . "usuariosis " . " where lower(trim(fones_usuario)) = '" . strtolower(trim($dados["fone"])) . "'";
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados) > 0) {
					$encontrado = true;
				}	
			}
			
			if ($encontrado === true && count($dados) > 0) {
				$comhttp->retorno->dados_retornados["conteudo_html"] = [];
				if (count($dados) > 0) {			
					$encontrado = true;
					$dados = $dados[0];
					$dados_envio["codusuariosis"] = "codigo usuario: " . $dados["codusuariosis"];
					$dados_envio["senha"] = "senha: " . $dados["senha"];			
					$dados_envio["status"] = "status: " . $dados["status"] .($dados["status"] === "cadastrado"?"(aguardando liberacao)":"");			

					if (strlen(trim($dados["email"])) > 0) {	
						$paramsemail = [];
						$paramsemail["assunto"] = Constantes::__NOMEORIGINALSIS__." - Recuperacao de Acesso";
						$paramsemail["dest"] = trim($dados["email"]);
						$paramsemail["msg"] = implode(",",$dados_envio);				
						FuncoesEmail::enviar_email($paramsemail["dest"],$paramsemail["assunto"],$paramsemail["msg"]);
						$comhttp->retorno->dados_retornados["conteudo_html"][] = "Mensagem Email enviada para o email cadastrado(..." . substr($paramsemail["dest"],3) ."). \n";
					}
					
					if (count($comhttp->retorno->dados_retornados["conteudo_html"]) > 0) {
						$comhttp->retorno->dados_retornados["conteudo_html"][] = "Recarregue a pagina e use os dados que recebeu para fazer login.";
					} else {
						$comhttp->retorno->dados_retornados["conteudo_html"][] = "Nao foi possível recuperar sua senha porque não há email ou telefone cadastrado. Entre em contato com o administrador do sistema para poder recuperar seu acesso.";
					}
					$comhttp->retorno->dados_retornados["conteudo_html"] = implode("",$comhttp->retorno->dados_retornados["conteudo_html"]);
					
				}
			} else {
				$comhttp->retorno->dados_retornados["conteudo_html"] = "Nao ha usuario cadastrado com esse(s) dado(s).";
			}
			fim:
			return ;	
		}
		public static function cadastrarse(&$comhttp) {
			$retorno_func = '';
			$condic_log = '';
			$temdado = false;
			$dados_recebidos = [];
			$dados_envio = [];
			$comhttp->retorno->dados_retornados = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["usuario"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["usuario"])) > 0) {
					$dados_recebidos["usuario"] = $comhttp->requisicao->requisitar->qual->condicionantes["usuario"];
					$temdado = true;
				}
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["email"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["email"])) > 0) {
					$dados_recebidos["email"] = $comhttp->requisicao->requisitar->qual->condicionantes["email"];
					$temdado = true;
				} 
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["fone"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["fone"])) > 0) {
					$dados_recebidos["fone"] = $comhttp->requisicao->requisitar->qual->condicionantes["fone"];
					$temdado = true;
				}
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["senha"])) {
				if (strlen(trim($comhttp->requisicao->requisitar->qual->condicionantes["senha"])) > 0) {
					$dados_recebidos["senha"] = $comhttp->requisicao->requisitar->qual->condicionantes["senha"];
					$temdado = true;
				}
			} 
			
			
			if (count($dados_recebidos) < 4) {
				$retorno_func .= 'Dados necessários nao informados. Informe todos os dados ou entre em contato com a Jumbo Alimentos para saber como cadastrar-se.';
				$comhttp->retorno->resultado = "sucesso";
				$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO CADASTRADO: ".$retorno_func;
				goto fim;
			}
			
			$encontrado = false;
			if (isset($dados_recebidos["usuario"])) {
				$comando_sql = "select codfilialnf,fantasia, from jumbo.pcclient where  to_number(trim(replace(replace(replace(coalesce(cgcent,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
				$dados_cliente = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados_cliente) > 0) {
					$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where  to_number(trim(replace(replace(replace(coalesce(codusuariosis,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
					$dados_usuario = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
					if (count($dados_usuario) > 0) {
						$retorno_func .= 'Cadastro já existe com este codigo. Confirme se o código está correto conforme instrução ou utilize a opção recuperar login na pagina inicial, ou ainda entre em contato com a Jumbo Alimentos para regularizar/liberar seu cadastro. Obrigado.';
						$comhttp->retorno->resultado = "sucesso";
						$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
						goto fim;			
					} else {
						$encontrado = true;
						$campos = ["codusuariosis","nome","senha","codnivelacesso","email","status","codfilial","codsupervisor","fones_usuario","podever","tipousuario"];
						$valores = [$dados_recebidos["usuario"],"'".$dados_cliente["fantasia"]."'","'" . $dados_recebidos["senha"] . "'",100,"'".$dados_recebidos["email"]."'","'CADASTRADO'",$dados_cliente["codfilialnf"],"null","'".$dados_recebidos["fone"]."'","'PADRAO'","'CLIENTE'"];
						$comando_sql = "insert into " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis (" . implode(",",$campos) . ") values (".implode(",",$valores) .")";
						FuncoesSql::getInstancia()->executar_sql($comando_sql);
						$comando_sql = "commit";
						FuncoesSql::getInstancia()->executar_sql($comando_sql);
						$dados_envio["codusuariosis"] = "codigo usuario: " . $dados_recebidos["usuario"];
						$dados_envio["senha"] = "senha: " . $dados_recebidos["senha"];			
						$dados_envio["status"] = "status: aguardando liberacao";			
						$paramsemail = [];
						$paramsemail["assunto"] = Constantes::__NOMEORIGINALSIS__." - Cadastro";
						$paramsemail["dest"] = trim($dados_recebidos["email"]);
						$paramsemail["msg"] = implode(",",$dados_envio);				
						FuncoesEmail::enviar_email($paramsemail["dest"],$paramsemail["assunto"],$paramsemail["msg"]);		
						$retorno_func .= 'Cadastro efetuado. Para poder acessar o sistema entre em contato com a Jumbo Alimentos para solicitar a liberação do cadastro. Um email foi enviado para o email informado para que não esqueça seus dados de acesso. Obrigado.';
						$comhttp->retorno->resultado = "sucesso";
						$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
						goto fim;
					}
				} else {
					$comando_sql = "select * from jumbo.pcusuari where  to_number(trim(replace(replace(replace(coalesce(codusur,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
					$dados_usuario = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
					if (count($dados_usuario) > 0) {
						$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where  to_number(trim(replace(replace(replace(coalesce(codusuariosis,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
						$dados_usuario_cadastrado = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
						if (count($dados_usuario_cadastrado) > 0) {
							$retorno_func .= 'Cadastro já existe com este codigo. Confirme se o código está correto conforme instrução ou utilize a opção recuperar login na pagina inicial, ou ainda entre em contato com a Jumbo Alimentos para regularizar/liberar seu cadastro. Obrigado.';
							$comhttp->retorno->resultado = "sucesso";
							$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
							goto fim;			
						} else {
							$encontrado = true;
							$campos = ["codusuariosis","nome","senha","codnivelacesso","email","status","codfilial","codsupervisor","fones_usuario","podever","tipousuario"];
							$valores = [$dados_recebidos["usuario"],"'".$dados_usuario["nome"]."'","'" . $dados_recebidos["senha"] . "'",50,"'".$dados_recebidos["email"]."'","'CADASTRADO'","'".$dados_usuario["codfilial"]."'",$dados_usuario["codsupervisor"],"'".$dados_recebidos["fone"]."'","'PADRAO'","'INTERNO'"];
							$comando_sql = "insert into " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis (" . implode(",",$campos) . ") values (".implode(",",$valores) .")";
							FuncoesSql::getInstancia()->executar_sql($comando_sql);
							$comando_sql = "commit";
							FuncoesSql::getInstancia()->executar_sql($comando_sql);
							$dados_envio["codusuariosis"] = "codigo usuario: " . $dados_recebidos["usuario"];
							$dados_envio["senha"] = "senha: " . $dados_recebidos["senha"];			
							$dados_envio["status"] = "status: aguardando liberacao";			
							$paramsemail = [];
							$paramsemail["assunto"] = Constantes::__NOMEORIGINALSIS__." - Cadastro";
							$paramsemail["dest"] = trim($dados_recebidos["email"]);
							$paramsemail["msg"] = implode(",",$dados_envio);				
							FuncoesEmail::enviar_email($paramsemail["dest"],$paramsemail["assunto"],$paramsemail["msg"]);		
							$retorno_func .= 'Cadastro efetuado. Para poder acessar o sistema entre em contato com a Jumbo Alimentos para solicitar a liberação do cadastro. Um email foi enviado para o email informado para que não esqueça seus dados de acesso. Obrigado.';
							$comhttp->retorno->resultado = "sucesso";
							$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
							goto fim;
						}
					} else {			
						$comando_sql = "select nome_guerra,codfilial from jumbo.PCEMPR where  to_number(trim(replace(replace(replace(coalesce(matricula,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
						$dados_usuario = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
						if (count($dados_usuario) > 0) {
							$comando_sql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where  to_number(trim(replace(replace(replace(coalesce(codusuariosis,0),'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace(coalesce(" . $dados_recebidos["usuario"] . ",0),'.',''),'-',''),'/','')))";
							$dados_usuario_cadastrado = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
							if (count($dados_usuario_cadastrado) > 0) {
								$retorno_func .= 'Cadastro já existe com este codigo. Confirme se o código está correto conforme instrução ou utilize a opção recuperar login na pagina inicial, ou ainda entre em contato com a Jumbo Alimentos para regularizar/liberar seu cadastro. Obrigado.';
								$comhttp->retorno->resultado = "sucesso";
								$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
								goto fim;			
							} else {
								$encontrado = true;
								$campos = ["codusuariosis","nome","senha","codnivelacesso","email","status","codfilial","codsupervisor","fones_usuario","podever","tipousuario"];
								$valores = [$dados_recebidos["usuario"],"'".$dados_usuario["nome_guerra"]."'","'" . $dados_recebidos["senha"] . "'",50,"'".$dados_recebidos["email"]."'","'CADASTRADO'","'".$dados_usuario["codfilial"]."'","null","'".$dados_recebidos["fone"]."'","'PADRAO'","'INTERNO'"];
								$comando_sql = "insert into " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis (" . implode(",",$campos) . ") values (".implode(",",$valores) .")";
								FuncoesSql::getInstancia()->executar_sql($comando_sql);
								$comando_sql = "commit";
								FuncoesSql::getInstancia()->executar_sql($comando_sql);
								$dados_envio["codusuariosis"] = "codigo usuario: " . $dados_recebidos["usuario"];
								$dados_envio["senha"] = "senha: " . $dados_recebidos["senha"];			
								$dados_envio["status"] = "status: aguardando liberacao";			
								$paramsemail = [];
								$paramsemail["assunto"] = Constantes::__NOMEORIGINALSIS__." - Cadastro";
								$paramsemail["dest"] = trim($dados_recebidos["email"]);
								$paramsemail["msg"] = implode(",",$dados_envio);				
								FuncoesEmail::enviar_email($paramsemail["dest"],$paramsemail["assunto"],$paramsemail["msg"]);		
								$retorno_func .= 'Cadastro efetuado. Para poder acessar o sistema entre em contato com a Jumbo Alimentos para solicitar a liberação do cadastro. Um email foi enviado para o email informado para que não esqueça seus dados de acesso. Obrigado.';
								$comhttp->retorno->resultado = "sucesso";
								$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_func;
								goto fim;
							}
						} else {				
							$retorno_func .= 'Dados nao encontrados na base da Jumbo Alimentos. Verifique se o codigo está conforme a instrução e ou entre em contato com a Jumbo Alimentos para saber como cadastrar-se.';
							$comhttp->retorno->resultado = "sucesso";
							$comhttp->retorno->dados_retornados["conteudo_html"] = "NAO CADASTRADO: ".$retorno_func;
							goto fim;
						}			
					}
				}
			} 	
			fim:
			return ;	
		}

		public static function obter_sql_dados_arr_tit(?object &$comhttp) {
			$params_sql = [
				"query"=>$comhttp->requisicao->sql->comando_sql,
				"fetch"=>"fetchAll",
				"fetch_mode"=>\PDO::FETCH_ASSOC,
				"retornar_resultset"=>true
			];
			$result = FuncoesSql::getInstancia()->executar_sql($params_sql);
			$comhttp->retorno->dados_retornados["dados"] = $result["data"];
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $result["fields"];
			FuncoesSql::getInstancia()->fechar_cursor($result);
			$params_sql = null;
			$result = null;
		}
		
		public static function montar_elemento_lista_opcoes_object($op, $class_subs="",$atalhos_inicio=[], $cont_recursao = 0){
			$retorno = null;
			if (!property_exists($op,"visivel") || (property_exists($op,"visivel") && $op->visivel == 1)) {
				$classe_li = "nav-item";
				$classe_a = "nav-link";
				$onclick_a = "";
				if (property_exists($op,"sub")) {
					$classe_ul = "dropdown-menu";
					if ($cont_recursao > 0) {
						$classe_li = "dropdown-item dropdown";
						$classe_a = "dropdown-toggle";
						$onclick_a = "window.fnevt.clicou_link_abrir_submenu(this,event)";
					} else {
						$classe_li = "nav-item dropdown";
						$classe_a = "nav-link dropdown-toggle";
					}					
					$li = FuncoesHtml::criar_elemento([],"li",$classe_li);
					$li["codops"] = $op->codops;
					$a = FuncoesHtml::criar_elemento([
						"tag"=>"a",
						"class"=>$classe_a,
						"id"=>"navbarDropdown".$op->codops,
						"role"=>"button",
						"data-bs-toggle"=>"dropdown",
						"aria-haspopup"=>"true",
						"aria-expanded"=>"false",
						"text"=>ucfirst(FuncoesObjeto::valor_propriedade_objeto($op,"nomeopcaovisivel"))						 
					]);
					if (strlen($onclick_a) > 0) {
						$a["onclick"] = $onclick_a;
					}
					$li["sub"][] = $a;
					$ul = FuncoesHtml::criar_elemento([
						"tag"=>"ul",
						"class"=>$classe_ul." bg-dark",
						"aria-labelledby"=>"navbarDropdown".$op->codops,
						"text"=>self::montar_lista_opcoes_recursiva($op->sub, $class_subs,$atalhos_inicio, $cont_recursao+1)
					]);
					$li["sub"][] = $ul;
					$retorno .= FuncoesHtml::montar_elemento_html($li);
				} else {
					if ($cont_recursao > 0) {
						$classe_li = "dropdown-item";
						$classe_a = "";
					}
					$onclick_a = "window.fnevt.clicou_link_abrir_itemmenu(this,event)";
					$li = FuncoesHtml::criar_elemento([],"li",$classe_li);
					$li["codops"]=FuncoesObjeto::valor_propriedade_objeto($op,"codops");
					$li["carr_din"]=FuncoesObjeto::valor_propriedade_objeto($op,"carregamentodinamico");
					$li["carregado"]="NAO";
					$li["objeto"]=FuncoesObjeto::valor_propriedade_objeto($op,"nomeops");
					$li["nomeops"]=FuncoesObjeto::valor_propriedade_objeto($op,"nomeops");
					$li["seletor_conteudo"]=FuncoesObjeto::valor_propriedade_objeto($op,"seletorconteudo");
					$li["onclick"] = $onclick_a;
					$a = FuncoesHtml::criar_elemento([],"a",$classe_a);
					$a["codops"]=FuncoesObjeto::valor_propriedade_objeto($op,"codops");
					$a["carr_din"]=FuncoesObjeto::valor_propriedade_objeto($op,"carregamentodinamico");
					$a["carregado"]="NAO";
					$a["objeto"]=FuncoesObjeto::valor_propriedade_objeto($op,"nomeops");
					$a["nomeops"]=FuncoesObjeto::valor_propriedade_objeto($op,"nomeops");
					$a["seletor_conteudo"]=FuncoesObjeto::valor_propriedade_objeto($op,"seletorconteudo");
					$a["onclick"] = $onclick_a;
					$a["text"] = ucfirst(FuncoesObjeto::valor_propriedade_objeto($op,"nomeopcaovisivel"));
					$li["sub"][] = $a;
					$retorno.= FuncoesHtml::montar_elemento_html($li);
				}
			}
			return $retorno;
		}
		
		public static function montar_elemento_lista_opcoes_array($op, $class_subs="",$atalhos_inicio=[], $cont_recursao = 0){
			$retorno = null;
				if ($op["visivel"] ?? 0 == 1) { 
					$classe_li = "nav-item";
					$classe_a = "nav-link";
					$onclick_a = "";
					$li = FuncoesHtml::criar_elemento([],"li");
					$li["codops"]=$op["codops"];
					$li["carr_din"]=FuncoesArray::valor_elemento_array($op,"carregamentodinamico");
					$li["carregado"]="NAO";
					$li["objeto"]=FuncoesArray::valor_elemento_array($op,"nomeops");
					$li["nomeops"]=FuncoesArray::valor_elemento_array($op,"nomeops");
					$li["seletor_conteudo"]=FuncoesArray::valor_elemento_array($op,"seletorconteudo");					
					$button = FuncoesHtml::criar_elemento([],"button","btn align-items-center rounded collapsed btn_menu");
					if (FuncoesObjeto::verif_valor_prop($op,["sub"],0,"contagem","maior")) {
						$button["class"] .= " btn-toggle";
						$button["data-bs-toggle"]="collapse";
						$button["data-bs-target"]="#collapse_".$op["codops"];
						$button["aria-expanded"]="false";
						$button["text"]=ucfirst(FuncoesArray::valor_elemento_array($op,"nomeopcaovisivel"));
						$li["sub"][] = $button;
						$div = FuncoesHtml::criar_elemento([],"div","collapse");
						$div["id"] = "collapse_" . $op["codops"];
						$ul = FuncoesHtml::criar_elemento([],"ul","btn-toggle-nav list-unstyled fw-normal pb-1 small");
						$ul["text"] = self::montar_lista_opcoes_recursiva($op["sub"], $class_subs,$atalhos_inicio, $cont_recursao+1);
						$div["sub"][] = $ul;
						$li["sub"][] = $div;
					} else {
						$button["onclick"] = "window.fnevt.clicou_link_abrir_itemmenu(this,event)";
						$button["text"] = ucfirst(FuncoesArray::valor_elemento_array($op,"nomeopcaovisivel"));
						$li["sub"][] = $button;
					}
					$retorno = FuncoesHtml::montar_elemento_html($li);
				}
			return $retorno;
		}
		
		public static function montar_lista_opcoes_recursiva($listaopcoes,$class_subs="",$atalhos_inicio=[], $cont_recursao = 0) {
			$retorno = '';
			$listatemp = [];		
			switch(strtolower(trim(gettype($listaopcoes)))) {				
				case "object": /*lido do arquivo catalogo json*/		
					foreach($listaopcoes as $chaveop=>$op) {					
						switch(strtolower(trim(gettype($op)))) {
							case "object":
								$retorno .= self::montar_elemento_lista_opcoes_object($op, $class_subs, $atalhos_inicio, $cont_recursao );
								break;
							case "array":							
								$retorno .= self::montar_elemento_lista_opcoes_array($op, $class_subs, $atalhos_inicio, $cont_recursao);
								break;
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("tipo da lista de opcoes nao esperado: " . gettype($listaopcoes),__FILE__,__FUNCTION__,__LINE__);
								break;
						}
					}
					break;
				case "array": /*lido do arquivo catalogo json sub ou lido da tabela*/		
					$listaopcoes = FuncoesArray::estruturar_array($listaopcoes,"codops","codopssup");
					foreach($listaopcoes as $chaveop=>$op) {					
						switch(strtolower(trim(gettype($op)))) {
							case "object":
								$retorno .= self::montar_elemento_lista_opcoes_object($op, $class_subs, $atalhos_inicio, $cont_recursao);
								break;
							case "array":
								$retorno .= self::montar_elemento_lista_opcoes_array($op, $class_subs, $atalhos_inicio, $cont_recursao);
								break;
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("tipo da lista de opcoes nao esperado: " . gettype($listaopcoes),__FILE__,__FUNCTION__,__LINE__);
								break;
						}
					}
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo da lista de opcoes nao esperado: " . gettype($listaopcoes),__FILE__,__FUNCTION__,__LINE__);
			} 
			return $retorno;
		}

		public static function corrigir_nome_processo($nome_processo) {
			$nome_processo_corrigido = strtolower(trim($nome_processo));
			return $nome_processo_corrigido;	
		}
		
		public static function obter_conteudo_opcao_sistema(&$comhttp, $opcao = null) {
			$retorno = null;	
			$retorno = self::obter_html_opcao_sistema($comhttp,$opcao);		
			return $retorno;
		}
		
		public static function traduzir_funcoes_constantes_elementos(&$elementos) {
			if ($elementos !== null) {
				$tp = gettype($elementos);
				if (in_array($tp,["array","object"])) {
					foreach($elementos as $chave => &$elemento) {
						if (gettype($elemento) === "string" && strpos($elemento,"__") !== false) {							
							if ($tp === "object") {
								$ret = FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao($elemento));
								
								$elementos->{$chave} = $ret;
							} else {
								$elementos[$chave] = FuncoesVariaveis::como_texto_ou_constante(FuncoesVariaveis::como_texto_ou_funcao($elemento));
							}
						} else if (in_array(gettype($elemento),["array","object"])) {
							self::traduzir_funcoes_constantes_elementos($elemento);
						}
					}
				}
			}
		}

		public static function montar_estrutura_inicial_arquivo_html(&$comhttp,$opcao = "pagina") {
			$retorno_html = null;
			
			switch(strtolower(trim($opcao))) {
				case "pagina": case "inicio": case "manutencao": case "login": case "atualizacoes_sistema":		
					
					$elementos = FuncoesArquivo::ler_arquivo_catalogo_json(
						NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_elementos_opcoes_sistema"),
						[
							"filtro"=>strtolower(trim($opcao)),
							"traduzir_apos_filtro"=>true,
							"preparar_string_antes"=>false]
					);
					if ($elementos === null || (
							$elementos !== null && (
								(gettype($elementos) === "object" && count(get_object_vars($elementos)) === 0)
								||(gettype($elementos) === "array" && count($elemento) === 0)
							)
						)
					) {
						$elementos = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::catalogo_elementos_opcoes_sistema,["filtro"=>strtolower(trim($opcao)),"traduzir_apos_filtro"=>true,"preparar_string_antes"=>false]);				
					}				
					if ($elementos !== null) {												
						self::traduzir_funcoes_constantes_elementos($elementos);
						$retorno_html = $elementos;
					}
					
					break;
				case "maximizada":
					$retorno_html = "";
					break;
				default:
					$retorno_html .= __FILE__ . "." . __FUNCTION__ . "." . __LINE__ . ": opcao " . $opcao . " nao programado";
			}
			return $retorno_html;
		}
		
		public static function montar_estrutura_inicial_html_sisjd(&$comhttp,$opcao){
			try {
				$retorno_html = null;				
				$prefixo_objects_sjd = VariaveisSql::getInstancia()->getPrefixObjects(VariaveisSql::nome_conexao_padrao_sjd);
				switch(strtolower(trim($opcao))) {
					case "pagina": case "inicio": case "manutencao": case "login": case "atualizacoes_sistema":						
						if (FuncoesSql::getInstancia()->tabela_existe($prefixo_objects_sjd . "opcoessistema") && FuncoesSql::getInstancia()->tabela_existe($prefixo_objects_sjd."contopcoessistema") && 
							FuncoesSql::getInstancia()->tabela_existe($prefixo_objects_sjd."tiposelementoshtml") && FuncoesSql::getInstancia()->tabela_existe($prefixo_objects_sjd."elementosopcoessistema")) {			
							$comando_sql="select codops from " . $prefixo_objects_sjd . "opcoessistema where lower(trim(nomeops))='".strtolower(trim($opcao))."'";				
							$opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
							if (count($opcao_sistema) > 0) {
								$comando_sql="select * from " . $prefixo_objects_sjd . "elementosopcoessistema where codops=" . $opcao_sistema["codops"] . " order by 1";				
								$elementos_opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								if (count($elementos_opcao_sistema) > 0) {
									$elementos_opcao_sistema=FuncoesArray::estruturar_array($elementos_opcao_sistema,"codelemento","codelementosup");
									$retorno_html = $elementos_opcao_sistema;
								} else {
									$retorno_html = self::montar_estrutura_inicial_arquivo_html($comhttp,$opcao);
								}
							} else {
								$retorno_html = self::montar_estrutura_inicial_arquivo_html($comhttp,$opcao);
							}
						} else {
							$retorno_html = self::montar_estrutura_inicial_arquivo_html($comhttp,$opcao);
						}
						break;
					default:
						$retorno_html = self::montar_estrutura_inicial_arquivo_html($comhttp,$opcao);
						break;
				}
				return $retorno_html;			
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 
		}
		
		public static function obter_html_opcao_sistema(&$comhttp, $opcao = "pagina") {
			try {
				$retorno_html = null;	
				
				$prefixo_objects = VariaveisSql::getInstancia()->getPrefixObjects();			
				if (FuncoesSql::getInstancia()->tabela_existe($prefixo_objects . "opcoessistema") && FuncoesSql::getInstancia()->tabela_existe($prefixo_objects."contopcoessistema") && 
					FuncoesSql::getInstancia()->tabela_existe($prefixo_objects."tiposelementoshtml") && FuncoesSql::getInstancia()->tabela_existe($prefixo_objects."elementosopcoessistema")) {												
					$comando_sql="select codops from " . $prefixo_objects . "opcoessistema where lower(trim(nomeops))='".strtolower(trim($opcao))."'";									
					$opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);					
					if (count($opcao_sistema) > 0) {						
						$comando_sql="select * from " . $prefixo_objects . "elementosopcoessistema where codops=" . $opcao_sistema["codops"] . " order by 1";				
						$elementos_opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);						
						if (count($elementos_opcao_sistema) > 0) {
							$elementos_opcao_sistema=FuncoesArray::estruturar_array($elementos_opcao_sistema,"codelemento","codelementosup");
							self::traduzir_funcoes_constantes_elementos($elementos_opcao_sistema);
							$retorno_html = $elementos_opcao_sistema;
						} else {
							$retorno_html = self::montar_estrutura_inicial_html_sisjd($comhttp,$opcao);
						}
					} else {
						$retorno_html = self::montar_estrutura_inicial_html_sisjd($comhttp,$opcao);
					}
				} else {
					$retorno_html = self::montar_estrutura_inicial_html_sisjd($comhttp,$opcao);
				}				
				return $retorno_html;				
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 
		}
		
		public static function obter_javascript_opcao_sistema(&$comhttp, $opcao = "pagina") {
			try {
				
				$retorno_javascript = null;
				$prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();	
				
				if (FuncoesSql::getInstancia()->tabela_existe($prefix_objects . "opcoessistema") && FuncoesSql::getInstancia()->tabela_existe($prefix_objects."contopcoessistema") && 
					FuncoesSql::getInstancia()->tabela_existe($prefix_objects."tiposelementoshtml") && FuncoesSql::getInstancia()->tabela_existe($prefix_objects."elementosopcoessistema")) {
						
					$comando_sql="select codops from " . $prefix_objects . "opcoessistema where lower(trim(nomeops))='".strtolower(trim($opcao))."'";				
					$opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
					
					if (count($opcao_sistema) > 0) {
						
						$comando_sql="select * from " . $prefix_objects . "contexecopcoessistema where codops=" . $opcao_sistema["codops"] . " order by 1";								
						$retorno_javascript = '';
						$params_exec_sql = [
							"query"=>$comando_sql,
							"retornar_resultset"=>true
						];
						$cursor_retorno_javascript = FuncoesSql::getInstancia()->executar_sql($params_exec_sql);
						//ver se o problema nao esta em retornar clob, mas eh aqui que a pagina trava no inicio
						while($dado = $cursor_retorno_javascript["result"]->fetch(\PDO::FETCH_ASSOC) ) {
							/*se vier do banco como objeto lob, extrai o conteudo*/
							if (in_array(gettype($dado["codigoexecutavel"]),["resource","object"])) {
								$retorno_javascript .= stream_get_contents($dado["codigoexecutavel"]);
							} else {
								$retorno_javascript .= $dado["codigoexecutavel"];
							}
							$retorno_javascript .= trim($retorno_javascript);
						} 
						FuncoesSql::getInstancia()->fechar_cursor($cursor_retorno_javascript);
						
						if (strlen($retorno_javascript) > 0) {
							$retorno = "";
							$retorno_javascript = eval($retorno_javascript);
							$retorno_javascript = $retorno;
						}
					}
				} else {
					
					switch(strtolower(trim($opcao))) {
						case "pagina": case "manutencao": case "login": case "inicio":
							$retorno_javascript = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_conteudo_executavel_opcoes_sistema"),["filtro"=>strtolower(trim($opcao)),"traduzir_apos_filtro"=>true,"preparar_string_antes"=>true]);				
							if ($retorno_javascript !== null ) {
								if (property_exists($retorno_javascript,"codigoexecutavel")) {
									$retorno = "";
									eval($retorno_javascript->codigoexecutavel);
									$retorno_javascript = $retorno;
								}
							} else {
								$retorno_javascript = null;
							}
							break;
						default:
							$retorno_javascript = null; 
					}
				}
				return $retorno_javascript;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 
		}
		
		public static function log_acesso(&$comhttp){	
			if(isset($_SESSION)){
				if(isset($_SESSION["login"])){
					if($_SESSION["login"]===true||$_SESSION["login"]==="true"){
						if($_SESSION["codusur"]!==142){
							if (FuncoesSql::getInstancia()->tabela_existe("log_acesso")) {
								$campos = "";
								$valores = "";
								$campos = "INSERT INTO LOG_ACESSO (CODUSUR,DATA_ACESSO,HORARIO_ACESSO,TIPO_PROCESSO,NOME_PROCESSO,VISOES,CAMPOS_AVULSOS_VISOES,VISOES_POSITIVADORAS,CAMPOS_AVULSOS_VISOES_POSIT,CONDICIONANTES,PERIODOS,OPCOES_PESQUISA,EXPORTADO,IP,NAVEGADOR)";
								$data_acesso = date('d/m/Y');
								$horario_acesso = date('H:i:s');
								$condicionantes = "";
								//$condicionantes=(isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])?$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]:"");
								//$condicionantes = str_replace("'","",(isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])?$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]:""));
								//$condicionantes=substr($condicionantes,0,3999);
								$tipo_processo=$comhttp->requisicao->requisitar->oque;
								$nome_processo="";
								$visoes=(isset($comhttp->requisicao->requisitar->qual->condicionantes["visoes"])?$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]:"");
								$campos_avulsos=(isset($comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"])?$comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"]:"");
								$visoes_positivadoras=(isset($comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"])?$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]:"");
								$campos_avulsos_positivacoes=(isset($comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos_positivacoes"])?$comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos_positivacoes"]:"");
								$periodos=(isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])?$comhttp->requisicao->requisitar->qual->condicionantes["datas"]:"");
								$opcoes_pesquisa="";
								$exportado="";						
								$navegador=(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"indefinido");//oracle pode passar requisicao sem essa configuracao
								if($tipo_processo==="conteudo_html"){
									return false;//conteudos de componentes;
								} else if($tipo_processo==="dados_sql"){
									if(isset($comhttp->requisicao->requisitar->qual->condicionantes["relatorio"])){
										$nome_processo=$comhttp->requisicao->requisitar->qual->condicionantes["relatorio"];
									}else{
										$nome_processo="indefinido";
									}
								}
								if(gettype($visoes)==="array"){
									$visoes=implode(",",$visoes);
								}
								$valores = " VALUES (";
								$valores .= $_SESSION["codusur"].",";
								$valores .= "to_date('".$data_acesso."','dd/mm/yyyy'),";
								$valores .= "'".$horario_acesso."',";
								$valores .= "'".$tipo_processo."',";
								$valores .= "'".$nome_processo."',";
								$valores .= "'".$visoes."',";
								if(gettype($campos_avulsos)==="array"){
									$campos_avulsos=implode("|",$campos_avulsos);
								}
								$valores .= "'".(gettype($campos_avulsos) === "array"?implode(",",$campos_avulsos):$campos_avulsos)."',";
								$valores .= "'".(gettype($visoes_positivadoras) === "array"?implode(",",$visoes_positivadoras):$visoes_positivadoras)."',";
								$valores .= "'".(gettype($campos_avulsos_positivacoes) === "array"?implode(",", $campos_avulsos_positivacoes) : $campos_avulsos_positivacoes)."',";
								//$valores .= "'".$condicionantes."',";
									$valores .= "'',";
								$valores .= "'".str_replace("'","",(gettype($periodos) !== "string"?implode(",",$periodos):$periodos))."',";
								$valores .= "'".$opcoes_pesquisa."',";
								$valores .= "'".$exportado."',";
								$valores .= @"'".(is_array($_SESSION["ips_cliente"])?implode(",",$_SESSION["ips_cliente"]):$_SESSION["ips_cliente"])."',";
								$valores .= "'".$navegador."')";
								$comando_sql = $campos.$valores;
								FuncoesSql::getInstancia()->executar_sql($comando_sql);
							}
						}
					}
				}
			}
		}
		
		public static function obter_caminho_recurso(&$comhttp, $opcao = "pagina") {
			try {
				$opcao = str_replace(" ","_",$opcao);
				$retorno = null;	
				$prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();			
				if (FuncoesSql::getInstancia()->tabela_existe($prefix_objects . "opcoessistema") && FuncoesSql::getInstancia()->tabela_existe($prefix_objects."contopcoessistema") && 
					FuncoesSql::getInstancia()->tabela_existe($prefix_objects."tiposelementoshtml") && FuncoesSql::getInstancia()->tabela_existe($prefix_objects."elementosopcoessistema")) {
					
					$comando_sql="select caminhorecurso from " . $prefix_objects . "opcoessistema where lower(trim(nomeops))='".strtolower(trim($opcao))."'";
					$opcao_sistema = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
					//echo "ok1"; exit();
					if (count($opcao_sistema) > 0) {
						$retorno = FuncoesVariaveis::como_texto_ou_constante($opcao_sistema["caminhorecurso"]);
						goto fim;
					} else {
						goto estruturainicial;
					}
				} 		
				estruturainicial:
				switch(strtolower(trim($opcao))) {
					case "pagina": case "manutencao": case "inicio": case "login": case "atualizacoes_sistema": 
						$opcoes_sistema = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_opcoes_sistema"));					
						$opcao_sistema = FuncoesJson::procurar_elemento_json_por_chave($opcoes_sistema,"nomeops",strtolower(trim($opcao)));				
						if ($opcao_sistema !== null) {
							if (property_exists($opcao_sistema,"caminhorecurso")) {
								$retorno = FuncoesVariaveis::como_texto_ou_constante($opcao_sistema->caminhorecurso);
							}
						}
						break;
					default:
						$retorno .= __FILE__ . "." . __FUNCTION__ . "." . __LINE__ . ": opcao " . $opcao . " nao programado";
				}
				fim:		
				$retorno = str_ireplace(trim(NomesCaminhosDiretorios::getInstancia()->getPropInstanciaSis("raiz")),"",trim(str_replace("\\",DIRECTORY_SEPARATOR,$retorno)));
				return $retorno;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
                exit();
                return null;
			} 
		}
		
		public static function conteudo_html(&$comhttp){
			try { 
				
				$retorno_html = "";
				$caminho_recurso = "";
				$retorno_javascript = "";
				$comhttp->requisicao->requisitar->qual->tipo_objeto = $comhttp->requisicao->requisitar->qual->tipo_objeto ?? "opcao_sistema";
				if (strlen(trim($comhttp->requisicao->requisitar->qual->tipo_objeto)) === 0) {
					$comhttp->requisicao->requisitar->qual->tipo_objeto = "opcao_sistema";
				}
				switch(strtolower(trim($comhttp->requisicao->requisitar->qual->tipo_objeto))) {
					case "opcao_sistema":												
						$caminho_recurso = self::obter_caminho_recurso($comhttp,$comhttp->requisicao->requisitar->qual->objeto);													
						if (in_array(strtolower(trim($comhttp->requisicao->requisitar->qual->objeto)),["pagina","inicio","inicio2"])) {							
							$retorno_html = self::obter_html_opcao_sistema($comhttp,$comhttp->requisicao->requisitar->qual->objeto);						
							$retorno_javascript = self::obter_javascript_opcao_sistema($comhttp,$comhttp->requisicao->requisitar->qual->objeto);						
						} else {							
							if (FuncoesObjeto::verif_valor_prop($comhttp->requisicao->requisitar->qual->condicionantes,["inicial"],"false")) {
							} else {								
								$retorno_html = self::obter_html_opcao_sistema($comhttp,$comhttp->requisicao->requisitar->qual->objeto);								
								$retorno_javascript = self::obter_javascript_opcao_sistema($comhttp,$comhttp->requisicao->requisitar->qual->objeto);
							}
						}
						break;
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("tipo_objeto nao implementado: " . $comhttp->requisicao->requisitar->qual->tipo_objeto,[__FILE__,__FUNCTION__,__LINE__]);
						break;
				}
				$comhttp->retorno->dados_retornados=[];
				$comhttp->retorno->dados_retornados["conteudo_html"] = $retorno_html;
				$comhttp->retorno->dados_retornados["conteudo_javascript"] = $retorno_javascript;	
				$comhttp->retorno->dados_retornados["caminho_recurso"] = $caminho_recurso;	
				return $comhttp;
			} catch(\Error | \Throwable | \Exception $e) {
				FuncoesBasicasRetorno::mostrar_msg_sair($e);
			}
		}
		
		public static function obter_opcao_sistema(&$comhttp, $opcao = null) {
			try {
				$retorno = null;
				$prefix_objects = VariaveisSql::getInstancia()->getPrefixObjects();			
				if(FuncoesSql::getInstancia()->tabela_existe(strtoupper($prefix_objects."opcoessistema"))){
					$comando_sql = "
					WITH OPCOES_LIBERADAS AS (
						select 
							o.codops,
							o.codopssup,
							o.nomeops,
							o.nomeopcaovisivel,
							o.seletorconteudo,
							o.carregamentodinamico,
							o.visivel,
							o.podemver,
							o.ordem,
							o.icone,
							o.codperfilespecifico,
							o.codnivelacessorequerido,
							o.codnivelacessoespecifico,
							o.caminhorecurso,
							o.arqrecursopreexistente,
							o.diretorioespecifico,
							o.bloco_use
						from 
							" . $prefix_objects."OPCOESSISTEMA o
							left outer join (
								" . $prefix_objects."usuariosis u 
								join " . $prefix_objects."perfil p on (p.codperfil = u.codperfil)
								join " . $prefix_objects."acessosperfil ap on (
									ap.codperfil = p.codperfil
									and coalesce(p.ativo,0) = 1
									and u.codusuariosis = ".(isset($_SESSION["usuariosis"]) && $_SESSION["usuariosis"] !== null && gettype($_SESSION["usuariosis"]) === "array" && count($_SESSION["usuariosis"]) > 0 ?$_SESSION["usuariosis"]["codusuariosis"]:"u.codusuariosis")."
								)
							) on (
								lower(trim(ap.tipoentidade)) = lower(trim('OPCAO SISTEMA'))
								and ap.codentidade = o.codops
								and coalesce(ap.ativo,0) = 1
								/*and coalesce(ap.permissao,0) = 1 CHECAGEM NO WHERE, POIS PODE ESTAR NEGADA*/
							)
						where 
							(
								o.diretorioespecifico is null 
								or (
									lower(trim(o.diretorioespecifico)) = lower(trim('".NomesDiretorios::getInstancia()->getPropInstanciaSis("base_sis")."'))
								)
							)";
					if (isset($_SESSION)) {
						if (isset($_SESSION["usuariosis"]) && $_SESSION["usuariosis"] !== null 
							&& gettype($_SESSION["usuariosis"]) === "array" && count($_SESSION["usuariosis"]) > 0 ) {
								$_SESSION["usuariosis"]["codnivelacesso"] = $_SESSION["usuariosis"]["codnivelacesso"] ?? 9999;
								$comando_sql .= " 
									and ( 
											( 
												coalesce(o.codnivelacessoespecifico,".$_SESSION["usuariosis"]["codnivelacesso"].") = ".$_SESSION["usuariosis"]["codnivelacesso"] . "
												and coalesce(o.codnivelacessorequerido,0) >= ".$_SESSION["usuariosis"]["codnivelacesso"] . "
												and (
													lower(trim(o.podemver)) = lower(trim('TODOS')) 
													or '" . $_SESSION["usuariosis"]["codusuariosis"] . "' = o.podemver
													or instr(o.podemver,'" . $_SESSION["usuariosis"]["codusuariosis"] . ",') = 1
													or instr(o.podemver,'," . $_SESSION["usuariosis"]["codusuariosis"] . ",') > 0
													or instr(o.podemver,'," . $_SESSION["usuariosis"]["codusuariosis"] . "') = length(o.podemver) + 1 - length('," . $_SESSION["usuariosis"]["codusuariosis"] . "')
												)
												and coalesce(ap.permissao,1) = 1 
											) or (
												coalesce(ap.permissao,0) = 1
											) 
										) ";
						}
					}
					if (isset($opcao)) {
						if (strlen(trim($opcao)) > 0) {
							$comando_sql .= " and lower(trim(o.nomeops)) = '" . strtolower(trim($opcao)) . "'";
						}
					}
					$comando_sql .= ")
					select
						a1.*
					from ( 
						SELECT O1.* FROM OPCOES_LIBERADAS O1 WHERE O1.CODOPSSUP IS NULL
						UNION ALL
						SELECT O1.* FROM OPCOES_LIBERADAS O1
						JOIN OPCOES_LIBERADAS O2 ON (
							O1.CODOPSSUP = O2.CODOPS
						) 
					) a1 order by coalesce(a1.codopssup,-1),coalesce(a1.ordem,a1.codops),a1.codops
					";
					$opcoes = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					if (count($opcoes) > 0) {
						$retorno = $opcoes;
					} else {
						$retorno = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_opcoes_sistema"));
					}				
				} else {
					$retorno = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("catalogo_opcoes_sistema"));					
				}
				return $retorno;
			} catch(\Error | \Throwable | \Exception $e) {
				FuncoesBasicasRetorno::mostrar_msg_sair($e);
			} 
		}
		
		public static function pesquisar_dado_global($arr_dado=null){
			$retorno=null;
			$tipo_arr_dado="";
			$nulo=null;
			if(isset($arr_dado)){
				$tipo_arr_dado=gettype($arr_dado);
				switch($tipo_arr_dado){
					case "string":
						FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao: tipo de arr dado global não suportado: ".$tipo_arr_dado,true,true);
						break;
					case "array":
						$alvo=null;
						$cont=0;
						$nao_encontrado=false;
						foreach($arr_dado as $elem_arr_dado){
							if($alvo===null&&$cont===0){
								if(isset($GLOBALS[$elem_arr_dado])){
									$alvo=$GLOBALS[$elem_arr_dado];
								} else {
									$alvo=&$nulo;
									break;
								}
							} else {
								if(isset($alvo)){							
									if(isset($alvo[$elem_arr_dado])){
										$alvo=$alvo[$elem_arr_dado];
									} else {
										$alvo=&$nulo;
										break;
									}							
								} else {
									$alvo=&$nulo;
									break;
								}
							}
							$cont++;
						}
						if(isset($alvo)){
							$retorno=$alvo;
						} 
						break;
					default:
						FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao de dados sql: tipo de arr dado global não definido: ".json_encode($comhttp->requisicao->condicionantes),true,true);
						break;
				}
			}
			return $retorno;
		}
		public static function setar_dado_global($arr_dado=null,$valor=null){
			$retorno=null;
			$tipo_arr_dado="";
			if(isset($arr_dado)){
				$tipo_arr_dado=gettype($arr_dado);
				switch($tipo_arr_dado){
					case "string":
						FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao: tipo de arr dado global não definido: ".$tipo_arr_dado,true,true);
						break;
					case "array":
						$alvo=null;
						$cont=0;
						$nao_encontrado=false;
						foreach($arr_dado as $elem_arr_dado){
							if($alvo===null&&$cont===0){
								if(isset($GLOBALS[$elem_arr_dado])){
									$alvo=&$GLOBALS[$elem_arr_dado];
								} else {
									$GLOBALS[$elem_arr_dado]=[];
									$alvo=&$GLOBALS[$elem_arr_dado];
								}
							} else {
								if(isset($alvo)){							
									if(isset($alvo[$elem_arr_dado])){
										$alvo=&$alvo[$elem_arr_dado];
									} else {
										$alvo[$elem_arr_dado]=[];
										$alvo=&$alvo[$elem_arr_dado];
									}							
								} else {
									$alvo=[];
									$alvo[$elem_arr_dado]=[];
									$alvo=&$alvo[$elem_arr_dado];
								}
							}
							$cont++;
						}
						
						$alvo=$valor;
						$retorno=$alvo;
						break;
					default:
						FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao de dados sql: tipo de arr dado global não definido: ".json_encode($comhttp->requisicao->condicionantes),true,true);
						break;
				}
			}
			return $retorno;
		}

		public static function montar_valores_condicionante($params = []) {
			//&$comhttp , &$opcoes_combobox, $dados){
			$retorno=[];
			$params = $params ?? [];
			/*["opcoes_texto_opcao"] = [];
			$opcoes_combobox["opcoes_valor_opcao"] = [];
			$opcoes_combobox["opcoes_texto_botao"] = [];*/
			
			if (count($params["dados"]) > 0) {
				if (!isset($params["dados"][0]["texto_opcao"]) && !isset($params["dados"][0]["texto_opcao"])) {		
					$prefixo = $params["visao"] . "='";
					$posfixo = "'";
					$dados_temp = [];
					$chave_val = null;
					$chave_op = null;
					$chave_bot = null;
					foreach($params["dados"] as $chave=>&$dado) {
						$dados_temp[$chave] = [];
						$contcol=0;
						foreach($dado as $chave_col=>$val) {					
							if (!isset($dados_temp[$chave]["valor_opcao"]) && $contcol === 0) {
								$dados_temp[$chave]["valor_opcao"] = $prefixo . $val . $posfixo;
								$chave_val=$chave_col;
								}
							if (!isset($dados_temp[$chave]["texto_opcao"]) && $contcol === 1) {
								$dados_temp[$chave]["texto_opcao"] = $val;
								$chave_op=$chave_col;
								}
							if (!isset($dados_temp[$chave]["texto_botao"]) && $contcol === 2) {
								$dados_temp[$chave]["texto_botao"] = $val;
								$chave_bot = $chave_col;
							}
							$contcol++;
						}
						
						if (!isset($dados_temp[$chave]["texto_opcao"])) {
							$dados_temp[$chave]["texto_opcao"] = $dado[$chave_val];
						}
						if (!isset($dados_temp[$chave]["texto_botao"])) {
							if (isset($chave_op)) {
								$dados_temp[$chave]["texto_botao"] = $dado[$chave_op];
							} else {
								$dados_temp[$chave]["texto_botao"] = $dado[$chave_val];
							}
						}				
					}
					$params["dados"] = $dados_temp;
					
				} else if (isset($params["dados"][0]["texto_opcao"])) {
					
					foreach($params["dados"] as $dado) {
						$retorno[] = [
							"opcoes_texto_opcao"=>$dado["texto_opcao"],
							"opcoes_valor_opcao"=>$dado["valor_opcao"],
							"opcoes_texto_botao"=>$dado["texto_botao"]
						];
					}
				} else if (isset($params["dados"][0]["texto_opcao"])) {
					foreach($params["dados"] as $dado) {
						$retorno[] = [
							"opcoes_texto_opcao"=>$dado["texto_opcao"],
							"opcoes_valor_opcao"=>$dado["valor_opcao"],
							"opcoes_texto_botao"=>$dado["texto_botao"]
						];
					}			
				} else {
					print_r($params["dados"]);
					FuncoesBasicasRetorno::mostrar_msg_sair("erro no dado passado para a funcao",__FILE__,__FUNCTION__,__LINE__);
				}
			}
			return $retorno;
		}

		public static function visoes_como_lista_condicionantes($visoes){
			if (gettype($visoes) !== "array") {
				$visoes = explode(",",$visoes);
			}
			foreach ($visoes as &$vis) {
				$vis = "lista_condicionantes_" . str_replace(" ","_",strtolower(trim($vis)));		
			}	
			$visoes = implode(",",$visoes);
			return $visoes;
		}

		public static function valores_para_condicionante($visao){
			$opcoes_combobox = null;
			$visao=strtolower(trim($visao));
			//echo $visao; exit();
			switch($visao) {	
				case "negocio aurora":
				case "negocio origem":					
					$cmd_select = "
						select
							'negocio origem='||n.cod as valor_opcao,
							n.cod || '-' || n.descricao as texto_opcao,
							n.cod as texto_botao
						from
							ep.epnegociosorigem n
						order by 
							n.cod
					";
					$dados = FuncoesSql::getInstancia()->executar_sql($cmd_select,"fetchAll",\PDO::FETCH_ASSOC);				
					$opcoes_combobox = self::montar_valores_condicionante(["visao"=>$visao,"dados"=>$dados]);
					break;				
				case "categoria aurora":
				case "categoria origem":					
					$cmd_select = "
						select
							'categoria origem='||c.cod as valor_opcao,
							c.cod || '-' || c.descricao as texto_opcao,
							c.cod as texto_botao
						from
							ep.epcategoriasorigem c
						order by 
							c.cod
					";
					$dados = FuncoesSql::getInstancia()->executar_sql($cmd_select,"fetchAll",\PDO::FETCH_ASSOC);				
					$opcoes_combobox = self::montar_valores_condicionante(["visao"=>$visao,"dados"=>$dados]);
					break;
				case "cliente":
				case "clientes":
					/*implementar criterios de acesso*/
					$cmd_select = "
						select
							'cliente='||cl.cod as valor_opcao,
							cl.cod || '-' || cl_ps.coddocidentificador || '-' || cl_ps.nomerazao as texto_opcao,
							cl.cod as texto_botao
						from
							ep.epcliente cl
							join ep.eppessoa cl_ps on cl_ps.cod = cl.codpessoa
						order by 
							cl.cod
					";
					$dados = FuncoesSql::getInstancia()->executar_sql($cmd_select,"fetchAll",\PDO::FETCH_ASSOC);				
					$opcoes_combobox = self::montar_valores_condicionante(["visao"=>$visao,"dados"=>$dados]);
					break;
				default:					
					$comhttp_temp = new TComHttp();
					$comhttp_temp->requisicao->requisitar->qual->objeto = $visao;
					$comhttp_temp->requisicao->requisitar->qual->objeto = self::visoes_como_lista_condicionantes($comhttp_temp->requisicao->requisitar->qual->objeto);
					$cmd_select=FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp);
					$dados = FuncoesSql::getInstancia()->executar_sql($cmd_select,"fetchAll",\PDO::FETCH_ASSOC);				
					$opcoes_combobox = self::montar_valores_condicionante(["visao"=>$visao,"dados"=>$dados]);
					break;
			}
			return $opcoes_combobox;
		}


		public static function montar_combobox_valores_para_condicionante(&$comhttp,$visao=null,&$opcoes_combobox = []) {
			if (isset($visao)) {
				if ($visao === null) {
					$visao = $comhttp->requisicao->requisitar->qual->objeto;
				} else {
					if (strlen(trim($visao)) === "") {
						$visao = $comhttp->requisicao->requisitar->qual->objeto;
					}
				}
			} else {
				$visao = $comhttp->requisicao->requisitar->qual->objeto;
			}
			
			$visao = strtolower(trim($visao));
			$opcoes_combobox["multiplo"] = 1;
			$opcoes_combobox["filtro"] = 1;
			$opcoes_combobox["tipo"] = "checkbox";
			$opcoes_combobox["tem_inputs"] = $opcoes_combobox["tem_inputs"] ?? true;
			$opcoes_combobox["classe_botao"] = $opcoes_combobox["classe_botao"] ?? FuncoesHtml::classe_padrao_botao;
			$opcoes_combobox["propriedades_html"] = [];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "class","valor" => "condicionante"];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "data-visao_atual","valor" => $visao];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "data-visao","valor" => $visao];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "aoabrir","valor" => "window.fnsisjd.incluir_options_condicionante(this)"];
			if (strtolower(trim($visao)) === "cliente") {
				$opcoes_combobox["funcao_filtro"] = "window.fnjs.verificar_tecla(this,event,{Enter:'window.fnhtml.fndrop.filtrar_dropdown(this)'})";
			}
			
			$opcoes_combobox["itens"] = self::valores_para_condicionante($visao);
			
			$comhttpnull = null;
			$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));	
			
			return $comhttp->retorno->dados_retornados;

		}

		public static function montar_valores_campo_avulso ( &$comhttp , &$opcoes_combobox, $dados){
			$retorno=[];
			$opcoes_combobox["itens"] = [];
			
			if (count($dados) > 0) {
				if (!isset($dados[0]["texto_opcao"])) {
					$prefixo = $comhttp->requisicao->requisitar->qual->objeto . "='";
					$posfixo = "'";
					$dados_temp = [];
					$chave_val = null;
					$chave_op = null;
					$chave_bot = null;
					foreach($dados as $chave=>&$dado) {
						$dados_temp[$chave] = [];
						$contcol=0;
						foreach($dado as $chave_col=>$val) {					
							if (!isset($dados_temp[$chave]["valor_opcao"]) && $contcol === 0) {
								$dados_temp[$chave]["valor_opcao"] = $prefixo . $val . $posfixo;
								$chave_val=$chave_col;
								}
							if (!isset($dados_temp[$chave]["texto_opcao"]) && $contcol === 1) {
								$dados_temp[$chave]["texto_opcao"] = $val;
								$chave_op=$chave_col;
								}
							if (!isset($dados_temp[$chave]["texto_botao"]) && $contcol === 2) {
								$dados_temp[$chave]["texto_botao"] = $val;
								$chave_bot = $chave_col;
								}
							$contcol++;
						}
						
						if (!isset($dados_temp[$chave]["texto_opcao"])) {
							$dados_temp[$chave]["texto_opcao"] = $dado[$chave_val];
						}
						if (!isset($dados_temp[$chave]["texto_botao"])) {
							if (isset($chave_op)) {
								$dados_temp[$chave]["texto_botao"] = $dado[$chave_op];
							} else {
								$dados_temp[$chave]["texto_botao"] = $dado[$chave_val];
							}
						}				
					}
					$dados = $dados_temp;
					
				}

				foreach($dados as $dado) {
					$opcoes_combobox["itens"][] = [
						"opcoes_texto_opcao" => $dado["texto_opcao"],
						"opcoes_valor_opcao" => $dado["valor_opcao"],
						"opcoes_texto_botao" => $dado["texto_botao"]
					];
				}
			}
			return $opcoes_combobox;
		}


		public static function valores_para_campo_avulso(&$comhttp){
			/*Objetivo: retoarna os valores para campo avulso*/
			$objeto = $comhttp->requisicao->requisitar->qual->objeto;
			$campos_avulsos = [];
			$cmd_select=FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$opcoes_combobox = [];
			$opcoes_combobox["multiplo"] = 1;
			$opcoes_combobox["filtro"] = 1;
			$opcoes_combobox["tipo"] = "checkbox";
			$opcoes_combobox["tem_inputs"] = $opcoes_combobox["tem_inputs"] ?? true;
			$opcoes_combobox["propriedades_html"] = [];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "data-visao_atual","valor" => $objeto];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "data-visao","valor" => $objeto];
			$opcoes_combobox["propriedades_html"][] = ["propriedade" => "aoabrir","valor" => ""];				
			$campos_avulsos = FuncoesSql::getInstancia()->executar_sql($cmd_select,"fetchAll",\PDO::FETCH_ASSOC);
			self::montar_valores_campo_avulso($comhttp,$opcoes_combobox,$campos_avulsos);	
			$comhttpnull = null;
			$comhttp->retorno->dados_retornados["conteudo_html"]=FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));
			return $comhttp;
		}

		public static function dados_literais(&$comhttp){
			/*Objetivo: retornar dados literais conforme solicitado*/
			$id_conteudo="";
			$retorno="";
			$tipo_objeto=$comhttp->requisicao->requisitar->qual->tipo_objeto;
			switch(strtolower(trim($tipo_objeto))){
				case "visoes":
					$visoes = self::obter_visoes_relatorio_venda();
					$comhttp->retorno->dados_retornados["dados"] = $visoes;
					break;
				case "visoes_condicionantes":
					$visoes_condicionantes = $visoes = self::obter_visoes_relatorio_venda_condic();
					$comhttp->retorno->dados_retornados["dados"] = $visoes_condicionantes;
					break;
				case "visoes_painel":
					$comhttp->retorno->dados_retornados["dados"] = ["Filial","Supervisor","Rca","Grupo Giro","Departamento","Produto"];
					break;
				case "valor_para_condicionante":
				case "valores_para_condicionante":
				case "valores_para_condicionantes":
					self::montar_combobox_valores_para_condicionante($comhttp);
					break;
				case "valor_para_campo_avulso":
				case "valores_para_campo_avulso":
				case "valores_para_campos_avulsos":
					self::valores_para_campo_avulso($comhttp);
					break;			
				case "lista_rcas_subordinados_grupo_msg":
					$comhttp->requisicao->sql = new TSql();
					//$comhttp->opcoes_retorno["ignorar_tabela_est"] = true;
					$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista_rcas_subordinados_grupo_msg");
					$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					$opcoes_input_combobox = [];
					$opcoes_input_combobox["opcoes_valor_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_botao"] = [];
					$opcoes_input_combobox["tipo"] = "radio";
					$opcoes_input_combobox["multiplo"] = 0;
					$opcoes_input_combobox["selecionar_todos"] = 0;
					$opcoes_input_combobox["aoselecionaropcao"] = "preencher_dados_usuario_grupo_msg(this)";
					$opcoes_input_combobox["tem_filtro_geral"] = true;
					$opcoes_input_combobox["id_input_combobox"] = $comhttp->requisicao->requisitar->qual->condicionantes["id_input_combobox"];
					$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_input_combobox"] = $opcoes_input_combobox;
					foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"] as $linha) {
						$opcoes_input_combobox["opcoes_valor_opcao"][] = $linha[0];
						$opcoes_input_combobox["opcoes_texto_opcao"][] = $linha;
						$opcoes_input_combobox["opcoes_texto_botao"][] = $linha[2];
					}
					$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_elemento_html_sisjd($comhttp,$opcoes_input_combobox);
					break;
				case "lista_produtos":
					$comhttp->requisicao->sql = new TSql();
					//$comhttp->opcoes_retorno["ignorar_tabela_est"] = true;
					$comhttp->requisicao->sql->comando_sql = "select codprod,descricao from jumbo.pcprodut";
					$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					$opcoes_input_combobox = [];
					$opcoes_input_combobox["opcoes_valor_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_botao"] = [];
					$opcoes_input_combobox["tipo"] = "radio";
					$opcoes_input_combobox["multiplo"] = 0;
					$opcoes_input_combobox["selecionar_todos"] = 0;
					$opcoes_input_combobox["aoselecionaropcao"] = "preencher_dados_produto_grupo(this)";
					$opcoes_input_combobox["tem_filtro_geral"] = true;
					$opcoes_input_combobox["id_input_combobox"] = $comhttp->requisicao->requisitar->qual->condicionantes["id_input_combobox"];
					$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_input_combobox"] = $opcoes_input_combobox;
					foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"] as $linha) {
						$opcoes_input_combobox["opcoes_valor_opcao"][] = $linha[0];
						$opcoes_input_combobox["opcoes_texto_opcao"][] = $linha;
						$opcoes_input_combobox["opcoes_texto_botao"][] = $linha[1];
					}
					$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_elemento_html_sisjd($comhttp,$opcoes_input_combobox);
					break;
				case "lista_itens_simples":
					$comhttp->requisicao->sql = new TSql();
					//$comhttp->opcoes_retorno["ignorar_tabela_est"] = true;
					$visao = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["visao"]));
					switch($visao) {
						case "fornecedor":
							$comhttp->requisicao->sql->comando_sql = "select codfornec,fornecedor from jumbo.pcfornec order by 1";
						case "filial":
							$comhttp->requisicao->sql->comando_sql = "select codigo,cidade from jumbo.pcfilial order by 1";
							break;
						case "rca":
							$comhttp->requisicao->sql->comando_sql = "select codusur,nome from jumbo.pcusuari order by 1";
							break;
						case "supervisor":
							$comhttp->requisicao->sql->comando_sql = "select codsupervisor,nome from jumbo.pcsuperv order by 1";
							break;
						case "origem de dados":
							$comhttp->requisicao->sql->comando_sql = "select 'Jumbo' from dual union all select 'Aurora' from dual";
							break;
						case "cidade":
							$comhttp->requisicao->sql->comando_sql = "select nomecidade,UF from jumbo.pccidade order by 2,1";
							break;
						case "ramo de atividade":
							$comhttp->requisicao->sql->comando_sql = "select codativ,ramo from jumbo.pcativi order by 1";
							break;
						case "departamento":
							$comhttp->requisicao->sql->comando_sql = "select codepto,descricao from jumbo.pcdepto order by 1";
							break;
						case "produto":
							$comhttp->requisicao->sql->comando_sql = "select codprod,descricao from jumbo.pcprodut order by 1";
							break;
						case "cliente":
							$comhttp->requisicao->sql->comando_sql = "select codcli,cgcent,cliente from jumbo.pcclient order by 1";
							break;
						case "rota":
							$comhttp->requisicao->sql->comando_sql = "select codrota,descricao from jumbo.pcrotaexp order by 1";
							break;
						case "praca":
							$comhttp->requisicao->sql->comando_sql = "select codpraca,praca from jumbo.pcpraca order by 1";
							break;
						case "negocio aurora":
							$comhttp->requisicao->sql->comando_sql = "select negocio from sjdnegocio_aurora order by 1";
							break;
						case "categoria aurora":
							$comhttp->requisicao->sql->comando_sql = "select categoria from sjdcategoria_aurora order by 1";
							break;
						case "rede de clientes":
							$comhttp->requisicao->sql->comando_sql = "select codrede,descricao from jumbo.pcredecliente order by 1";
							break;
							
							
							

							
							
							
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair("visao nao programada:" . $visao,__FILE__,__FUNCTION__,__LINE__);
							break;
					}
					$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					$opcoes_input_combobox = [];
					$opcoes_input_combobox["opcoes_valor_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_botao"] = [];
					$opcoes_input_combobox["tipo"] = "checkbox";
					$opcoes_input_combobox["multiplo"] = 1;
					$opcoes_input_combobox["selecionar_todos"] = 1;
					$opcoes_input_combobox["aoselecionaropcao"] = "preencher_dados_input_simples(this)";
					$opcoes_input_combobox["tem_filtro_geral"] = true;
					$opcoes_input_combobox["id_input_combobox"] = $comhttp->requisicao->requisitar->qual->condicionantes["id_input_combobox"];
					$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_input_combobox"] = $opcoes_input_combobox;
					foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"] as $linha) {
						$opcoes_input_combobox["opcoes_valor_opcao"][] = $linha[0];
						$opcoes_input_combobox["opcoes_texto_opcao"][] = $linha;
						$opcoes_input_combobox["opcoes_texto_botao"][] = $linha[0];
					}
					$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_elemento_html_sisjd($comhttp,$opcoes_input_combobox);
					break;
				case "lista_opcoes_sistema_pesquisa":
					$comhttp->requisicao->sql = new TSql();
					//$comhttp->opcoes_retorno["ignorar_tabela_est"] = true;
					$comhttp->requisicao->sql->comando_sql = "
						select 
							o.codops,
							o.nomeops,
							(
								select (
									select (
										select o5.nomeopcaovisivel||'>' from sjdopcoessistema o5 where o5.codops = o4.codopssup
									) || o4.nomeopcaovisivel||'>' from sjdopcoessistema o4 where o4.codops = o3.codopssup
								) || o3.nomeopcaovisivel||'>' from sjdopcoessistema o3 where o3.codops = o.codopssup
							) || o.nomeopcaovisivel
						from 
							sjdopcoessistema o
						where
							not exists(
								select
									1
								from
									sjdopcoessistema o2
								where
									o2.codopssup = o.codops
							)
							and o.visivel = 1
							and (
								lower(trim(o.podemver)) = 'todos'
								or (
									'" . $_SESSION["usuariosis"]["codusuariosis"] . "' = trim(o.podemver)
									or trim(o.podemver) like '%" . $_SESSION["usuariosis"]["codusuariosis"] . ",%' 
									or trim(o.podemver) like '%," . $_SESSION["usuariosis"]["codusuariosis"] . "%'
								)
							)
							and (
								o.codnivelacessoespecifico is null 
								or " . $_SESSION["usuariosis"]["codnivelacesso"] . " = o.codnivelacessoespecifico
							)
							and " . $_SESSION["usuariosis"]["codnivelacesso"] . " <= o.codnivelacessorequerido
							and o.codops not in (0,1,100,9996)
						order by 
							o.ordem,
							o.codopssup,
							2,1			
									";
					//echo $comhttp->requisicao->sql->comando_sql; exit();
					$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_NUM);
					$opcoes_input_combobox = [];
					$opcoes_input_combobox["opcoes_valor_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_opcao"] = [];
					$opcoes_input_combobox["opcoes_texto_botao"] = [];
					$opcoes_input_combobox["tipo"] = "radio";
					$opcoes_input_combobox["multiplo"] = 0;
					$opcoes_input_combobox["classe_tabela"] = "tab_pesquisa_opcoes_sistema";
					$opcoes_input_combobox["selecao_ativa"] = false;
					$opcoes_input_combobox["filtro_ativo"] = false;
					$opcoes_input_combobox["selecionar_todos"] = 0;
					$opcoes_input_combobox["aoselecionaropcao"] = "acessar_opcao_sistema(this)";
					$opcoes_input_combobox["tem_filtro_geral"] = true;
					$opcoes_input_combobox["aoclicarlinha"] = "window.fnsisjd.acessar_opcao_sistema_pesquisa({elemento:this})";
					$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_input_combobox"] = $opcoes_input_combobox;
					$comhttp->retorno->dados_retornados["conteudo_html"] = [];
					foreach($comhttp->retorno->dados_retornados["dados"] as $linha) {
						$comhttp->retorno->dados_retornados["conteudo_html"][] = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_elemento([
							"tag"=>"option",
							"nomeops"=> $linha[1],
							"text"=>$linha[2]
						]));
					}
					$comhttp->retorno->dados_retornados["conteudo_html"] = implode("",$comhttp->retorno->dados_retornados["conteudo_html"]);
					break;
				default:
					FuncoesErro::erro(null,8,__FILE__,__function__,__LINE__,null,"Erro na requisicao: tipo dados literais não definido: ".$comhttp->requisicao->requisitar->qual->tipo_objeto,true,true);
					break;			
			}
			return $retorno;
		}

		public static function obter_visoes_entidades_objetivos($codcampanhasinergia,$unidade,$visao_entidade,$data_periodo1, $data_periodo2, $cnj_criterios_acesso = []){
			$retorno = null;
			$comando_sql = "select distinct lower(trim(visao)) as visao from sjdobjetivossinergia where ";
			$comando_sql .= " codcampanhasinergia = $codcampanhasinergia";
			$comando_sql .= " and lower(trim(unidade)) = lower(trim('$unidade'))";
			$comando_sql .= " and lower(trim(entidade)) = lower(trim('$visao_entidade'))";
			$comando_sql .= " and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
			if (count($cnj_criterios_acesso) > 0) {
				$comando_sql .= " and " . implode(" and " , $cnj_criterios_acesso);
			}
			//echo $comando_sql; exit();
			$retorno = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN,0);
			return $retorno;
		}

		public static function setar_criterios_globais_existencia($mostrar_vals_de = [3],$considerar_vals_de = [0,1,2],$considerar_grupos_produtos = false){
			$GLOBALS["considerar_vendas_normais"] = false;
			$GLOBALS["considerar_devolucoes_vinculadas"] = false;
			$GLOBALS["considerar_devolucoes_avulsas"] = false;
			$GLOBALS["considerar_bonificacoes"] = false;
			$GLOBALS["ver_vals_qttotal"] = false;
			$GLOBALS["ver_vals_un"] = false;
			$GLOBALS["ver_vals_pesoun"] = false;
			$GLOBALS["ver_vals_pesotot"] = false;
			$GLOBALS["ver_vals_valorun"] = false;
			$GLOBALS["ver_vals_valortot"] = false;
			$GLOBALS["considerar_grupos_produtos"] = $considerar_grupos_produtos;
			foreach($mostrar_vals_de as $chave => $valor) {
				switch(strtolower(trim($valor))) {
					case "0":
						$GLOBALS["ver_vals_qttotal"] = true;
						break;
					case "1":
						$GLOBALS["ver_vals_un"] = true;
						break;
					case "2":
						$GLOBALS["ver_vals_pesoun"] = true;
						break;
					case "3":
						$GLOBALS["ver_vals_pesotot"] = true;
						break;
					case "4":
						$GLOBALS["ver_vals_valorun"] = true;
						break;
					case "5":
						$GLOBALS["ver_vals_valortot"] = true;
						break;
					case "6":
						//implementar
						break;
					case "7":
						//implementar
						break;
					case "10":
						//opcao todos
						break;
					case "11":
						//tratativa especifica no relatorio de ratings
						break;	
					case "":
						//quando relatorio nao exige estes dados, vem em branco
						break;	
					default:
						mostrar_msg_sair("valor nao esperado para mostrar_vals_de: $valor",__FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
			foreach($considerar_vals_de as $chave => $valor) {
				switch(strtolower(trim($valor))) {
					case "0":
						$GLOBALS["considerar_vendas_normais"] = true;
						break;
					case "1":
						$GLOBALS["considerar_devolucoes_vinculadas"] = true;
						break;
					case "2":
						$GLOBALS["considerar_devolucoes_avulsas"] = true;
						break;
					case "3":
						$GLOBALS["considerar_bonificacoes"] = true;
						break;
					case "10":
						//ja setado nas anteriores
						break;
					case "":
						//quando relatorio nao exige estes dados, vem em branco
						break;	
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("valor nao esperado para considerar_vals_de: $valor",__FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
		}

		
		

		public static function dados_sql(&$comhttp){
			/*Objetivo: identificar e retornar os dados sql conforme solicitado, como array*/
			$comhttp->requisicao->sql=new TSQL($comhttp);	
			$comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"] = $comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"] ?? [];
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] ?? 3;
			$comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"] = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"] ?? "0,1,2";
			$comhttp->requisicao->requisitar->qual->condicionantes["def_tipo_campos"] = $comhttp->requisicao->requisitar->qual->condicionantes["def_tipo_campos"] ?? "sql";
			$comhttp->requisicao->requisitar->qual->condicionantes["pivot"] = $comhttp->requisicao->requisitar->qual->condicionantes["pivot"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = $comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["html_entities"] = $comhttp->requisicao->requisitar->qual->condicionantes["html_entities"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] = $comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] ?? "tabelaest";
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"]);
			if (count($comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"]) === 0) {
				$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3];
			}
			$comhttp->requisicao->sql->campos_avuslos= $comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"] ?? null;
			$opcoes=[];
			if (gettype($comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"]) !== "array") {
				$comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"]);
			}
			if (count($comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"]) === 0) {
				$comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"] = [0,1,2]; 
			}
			self::setar_criterios_globais_existencia($comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"],$comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"],false);

			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"])) {
				$codprocesso = $comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"];
				$processo = FuncoesSql::getInstancia()->obter_processo(["condic" => "codprocesso=" . $codprocesso,"unico"=>true]);
				//print_r($processo); exit();
				$comhttp->requisicao->requisitar->qual->objeto = $processo["processo"];
				$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);		
				$opcoes = FuncoesSql::getInstancia()->obter_opcoes_dados_sql(["condic"=>"codprocesso=" . $codprocesso,"unico"=>true]);
				if ($opcoes !== null && isset($opcoes["opcoes"])) {
					if (in_array(gettype($opcoes["opcoes"]),["resource","object"])) {
						$opcoes["opcoes"] = stream_get_contents($opcoes["opcoes"]);
					}
					eval($opcoes["opcoes"]);
				} else {
					$opcoes = FuncoesHtml::opcoes_tabela_est;
				}
				$comhttp->opcoes_retorno["usar_arr_tit"] = FuncoesConversao::como_boleano($comhttp->opcoes_retorno["usar_arr_tit"] ?? $opcoes["usar_arr_tit"] ?? true);
				if (isset($opcoes["usar_arr_tit"]) && $opcoes["usar_arr_tit"] != null) {
					if (
						$opcoes["usar_arr_tit"] != $comhttp->opcoes_retorno["usar_arr_tit"] || 
						$opcoes["usar_arr_tit"] != $comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] 
					) {
						$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"]  = $opcoes["usar_arr_tit"];
						$comhttp->opcoes_retorno["usar_arr_tit"] = $opcoes["usar_arr_tit"];
					}
				}
				$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = FuncoesConversao::como_boleano($comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] ?? $comhttp->opcoes_retorno["usar_arr_tit"] ?? true);
				$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
				$opcoes["tipoelemento"] = $opcoes["tipoelemento"] ?? "tabdados";
				$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = $opcoes["tipoelemento"];
				$params_sql = [];
				if (isset($opcoes["fetch"])) {
					$params_sql["fetch"] = $opcoes["fetch"];
				}
				if (isset($opcoes["fetch_mode"])) {
					$params_sql["fetch_mode"] = $opcoes["fetch_mode"];
				}
				if (isset($opcoes["numcol"])) {
					$params_sql["numcol"] = $opcoes["numcol"];
				}
				//print_r($opcoes["tipoelemento"]); exit();
				if (in_array(strtolower(trim($opcoes["tipoelemento"])),["tabdados","tabela_est"])) {
					FuncoesHtml::montar_retorno_tabdados($comhttp,$params_sql);
				} else if (FuncoesArray::verif_valor_chave($comhttp->requisicao->requisitar->qual->condicionantes,["retornar_comando_sql"],true)) {
					$comhttp->retorno->dados_retornados=$comhttp->requisicao->sql->comando_sql;
				} else {
					FuncoesHtml::montar_retorno_tabdados($comhttp,$params_sql);
					$opcoes["dados"] = $comhttp->retorno->dados_retornados["dados"];
					$comhttp->retorno->dados_retornados=FuncoesHtml::montar_elemento_html_sisjd($opcoes);
				}
			} else {		
				switch($comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"]){			
					case "lista":
						switch($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"]){							
							case "integgrupomsg":
								$comhttp->requisicao->requisitar->qual->objeto = "lista integrantes grupos mensagens";					
								$codprocesso = 33;
								$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
								$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
								$comhttp->opcoes_retorno["usar_arr_tit"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
								$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista");
								$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes=FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"]="sjdinteggrupomsg";
								$opcoes["campos_chaves_primaria"]=["codintegrante"];
								$opcoes["campos_chaves_unica"]=[];
								$opcoes["cabecalho"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["ativo"]=true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"]=true;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["classe_sub_elementos_colunas"][2] = "input_combobox";
								$opcoes["corpo"]["propriedades_colunas"][2] = ' oque="dados_literais" comando="consultar" tipo_objeto="lista_rcas_subordinados_grupo_msg" objeto="lista_rcas_subordinados_grupo_msg" propriedades_sub_elementos_coluna="oque,comando,tipo_objeto,objeto" ';
								$opcoes["rodape"]["ativo"] = false;
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = "tabela_est";
								if(isset($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"])){
									$valstemp = FuncoesArray::chaves_associativas(explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"]))));
									$opcoes["corpo"]["linhas"]["valores_padrao"] = $valstemp;
									$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"] = $valstemp;
								}
								$opcoes["corpo"]["linhas"]["marcar"] = true;
								FuncoesHtml::montar_dados_linha_padrao($comhttp,$opcoes);
								ksort($opcoes["corpo"]["linhas"]["linha_padrao"]["dados"]);
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes);										
								break;
							case "integgrupoprod":
								$codprocesso = 10252;
								$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
								$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
								$comhttp->opcoes_retorno["usar_arr_tit"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
								$opcoes=FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"]="sjdinteggrupoprod";
								$opcoes["campos_chaves_primaria"]=["codintegrante"];
								$opcoes["campos_chaves_unica"]=[];
								$opcoes["cabecalho"]["ativo"] = true;
								$opcoes["cabecalho"]["filtro"]["ativo"] = true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["ativo"]=true;
								//$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"]=true;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								//$opcoes["corpo"]["linhas"]["comandos"]["ativo"]=true;
								//$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"]=true;
								//$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"]=true;
								//$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";					
								//$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";					
								//$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["classe_sub_elementos_colunas"][2] = "input_combobox";
								$opcoes["corpo"]["propriedades_colunas"][2] = ' oque="dados_literais" comando="consultar" tipo_objeto="lista_produtos" objeto="lista_produtos" propriedades_sub_elementos_coluna="oque,comando,tipo_objeto,objeto" ';								
								$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = "tabela_est";
								$opcoes["rodape"]["ativo"] = false;
								$opcoes["corpo"]["linhas"]["marcar"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista");
								//$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								
								/*if(isset($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"])){
									$valstemp = FuncoesArray::chaves_associativas(explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"]))));
									$opcoes["corpo"]["linhas"]["valores_padrao"] = $valstemp;
									$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"] = $valstemp;
								}*/
								
								/*FuncoesHtml::montar_dados_linha_padrao($comhttp,$opcoes);
								ksort($opcoes["corpo"]["linhas"]["linha_padrao"]["dados"]);
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes);*/
								//echo $comhttp->requisicao->sql->comando_sql; exit();
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;						
							case "objetivos":
								$codprocesso = 35;
								$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
								$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
								$opcoes=FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"]="sjdinteggrupomsg";
								$opcoes["campos_chaves_primaria"]=["codintegrante"];
								$opcoes["campos_chaves_unica"]=[];
								$opcoes["cabecalho"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["ativo"]=true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";					
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";					
								$opcoes["rodape"]["ativo"] = false;
								$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista");
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = "tabela_est";
								if(isset($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"])){
									$valstemp = FuncoesArray::chaves_associativas(explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["valorespadrao"]))));
									$opcoes["corpo"]["linhas"]["valores_padrao"] = $valstemp;
									$opcoes["corpo"]["linhas"]["linha_padrao"]["dados"] = $valstemp;
								}
								$opcoes["corpo"]["linhas"]["marcar"] = true;
								FuncoesHtml::montar_dados_linha_padrao($comhttp,$opcoes);
								ksort($opcoes["corpo"]["linhas"]["linha_padrao"]["dados"]);
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes);										
								break;	
							case "itens_visao":
								if (gettype($comhttp->requisicao->requisitar->qual->objeto) !== "string") {
									$comhttp->requisicao->requisitar->qual->objeto = strtolower(trim(implode(",",$comhttp->requisicao->requisitar->qual->objeto)));
								}
								$comhttp->requisicao->requisitar->qual->objeto = "lista_itens_visao_" . $comhttp->requisicao->requisitar->qual->objeto;
								$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista");
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesSql::getInstancia()->obter_opcoes_dados_sql(["condic"=>"codprocesso=100","unico"=>true]);
								if ($opcoes !== null && isset($opcoes["opcoes"])) {
									eval($opcoes["opcoes"]);
								} else {
									$opcoes = FuncoesHtml::opcoes_tabela_est;
								}	
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = "tabela_est";
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes);										
								break;	
							case "lista_produtos_pedido_cliente":
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$comhttp->requisicao->sql->comando_sql = "
									SELECT
										p.codprod as Codigo,
										p.descricao as Descricao,
										p.unidade as \"UN\",
										nvl(pf.multiplo,p.multiplo) AS Multiplo,
										nvl(pe.qtestger,0) - (nvl(pe.qtreserv,0) + nvl(pe.qtpendente,0) + nvl(pe.qtbloqueada,0)) AS \"Qt. Estoque\",
										pr.pvenda1 as \"A Vista\",
										pr.pvenda2 as \"7 dias\",
										pr.pvenda3 as \"14 dias\",
										pr.pvenda4 as \"20 dias\",
										pr.pvenda5 as \"28 dias\"
									FROM
										jumbo.pcprodut p
										LEFT OUTER JOIN jumbo.pcprodfilial pf ON ( pf.codprod = p.codprod
																				   AND pf.codfilial = 1 )
										LEFT OUTER JOIN jumbo.pcest pe ON ( pe.codprod = p.codprod
																			AND pe.codfilial = 1 )
										LEFT OUTER JOIN jumbo.pctabpr pr ON ( pr.codprod = p.codprod
																			  AND pr.numregiao = 1 )
									WHERE
										p.dtexclusao IS NULL
										AND P.REVENDA = 'S'
										AND p.enviarforcavendas = 'S'
										AND p.obs2 != 'FL'
										AND nvl(pe.qtestger,0) - (nvl(pe.qtreserv,0) + nvl(pe.qtpendente,0) + nvl(pe.qtbloqueada,0)) > 0
										AND pr.pvenda1 is not null
										and lower(p.descricao) not like '%freezer%'
									ORDER BY
										1";		
								$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"] = VariaveisSql::getInstancia()->getPrefixObjects() . "produtos";
								$opcoes["cabecalho"]["comandos"]["ativo"] = false;
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["selecao"]["ativo"] = true;
								$opcoes["selecao"]["multiplo"] = false;
								$opcoes["selecao"]["selecao_tipo"] = "radio";
								$opcoes["selecao"]["selecionar_todos"] = false;
								$opcoes["selecao"]["selecionar_pela_linha"] = true;
								$opcoes["corpo"]["linhas"]["aoduploclicar"] = "incluir_produtos_selecionados_incl_ped_cliente(this)";
								$opcoes["rodape"]["ativo"] = false;	
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][0]["formatacao"] = "cel_numint";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][3]["formatacao"] = "cel_num";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][3]["formatacao"] = "cel_quantdec";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][5]["formatacao"] = "cel_valor";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][6]["formatacao"] = "cel_valor";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][7]["formatacao"] = "cel_valor";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][8]["formatacao"] = "cel_valor";
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][9]["formatacao"] = "cel_valor";
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes);										
								break;
							case "lista_motoristas":
									$opcoes = FuncoesHtml::opcoes_tabela_est;
									$comhttp->requisicao->sql->comando_sql = "
										SELECT
											m.codusuariosis as codmotorista,
											m.nome as nomemotorista
										FROM
											sjdusuariosis m
										WHERE
											m.tipousuario = 'MOTORISTA'
										ORDER BY
											1";		
									$comhttp->retorno->dados_retornados["dados"] =FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
									break;							
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"],__FILE__,__FUNCTION__,__LINE__);
								break;				
						}
						break;
					case "linha_dados":			
						switch($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"]){														
							case "pcclient":
								FuncoesSisJD::consultar_cliente($comhttp);
								break;
							case "pcclient_rfb":
								FuncoesSisJD::consultar_cliente_rfb($comhttp);
								break;						
							case "pcpedc":
							case "pcpedcfv":
							case "pcnfcan":
								FuncoesSisJD::consultar_pedido($comhttp);
								break;
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"],__FILE__,__FUNCTION__,__LINE__);
								break;					
						}
						break;
					case "texto":
						switch($comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"]){							
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["especificacao_dados"],__FILE__,__FUNCTION__,__LINE__);
								break;									
						}
						break;
					case "tabelaest": 
					case "tabela_est":				
						$opcoes_tabela_est=FuncoesHtml::opcoes_tabela_est;
						$opcoes_tabela_est["subregistros"]["ativo"]=false;
						$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"]=true;
						$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"]=true;
						$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"]=true;
						$opcoes_tabela_est["cabecalho"]["comandos"]["exportacao"]["ativo"]=true;					
						$opcoes_tabela_est["corpo"]["ativo"]=true;					
						$opcoes_tabela_est["rodape"]["ativo"]=true;					
						$opcoes_tabela_est["campos_visiveis"]=["todos"];					
						$opcoes_tabela_est["campos_ocultos"]=[];	
						$opcoes_tabela_est["campos_chaves_primaria"]=[];				
						$opcoes_tabela_est["campos_chaves_unica"]=[];					
						$opcoes_tabela_est["campos_ordenacao"]=["todos"];					
						$opcoes_tabela_est["campos_filtro"]=["todos"];					
						if ($comhttp->opcoes_retorno === null || gettype($comhttp->opcoes_retorno) === "string") {
							$comhttp->opcoes_retorno = [];
						}
						$comhttp->opcoes_retorno["associativo"] = true;		
						$comhttp->opcoes_retorno["usar_arr_tit"] = true;
						$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
						$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
						$comhttp->requisicao->requisitar->qual->condicionantes["relatorio"] = $comhttp->requisicao->requisitar->qual->condicionantes["relatorio"] ?? $comhttp->requisicao->requisitar->qual->objeto;
						switch (strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["relatorio"]))) {
							case "sinergia":
								$comhttp->opcoes_retorno["usar_arr_tit"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
								FuncoesMontarSQL::montar_sql_sinergia($comhttp);
								$arr_tit_temp = [];
								foreach ($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] as $chave => &$valor) {
									if (strcasecmp(trim($chave),"valores saida") != 0) {
										foreach ($valor as $chave_campo => $campo) {
											$arr_tit_temp[$chave_campo] = $campo;
										}
									} else {
										foreach($valor as $datas) {
											foreach ($datas as $chave_campo => $campo) {
												$arr_tit_temp[$chave_campo] = $campo;
											}
										}
									}
								}
								$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $arr_tit_temp;
								//$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="sinergia";
								$opcoes_tabela_est["classes_linhas"]=[
									"grupogiro" => [
										"1-Itens Giro"=>"grupoprodsin1",
										"2-Itens Industrializados"=>"grupoprodsin2",
										"3-Itens Jumbo"=>"grupoprodsin3",
									]
								];
								$opcoes_tabela_est["cabecalho"]["ocultarcolunas"]["ativo"]=true;
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
								//$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "sinergia2":
								FuncoesMontarRetorno::montar_sinergia2($comhttp);
								break;	
							case "sinergia2evolucao":
								$comhttp->opcoes_retorno["usar_arr_tit"] = false;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = false;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesMontarRetorno::montar_sinergia2evolucao($comhttp);
								break;	
							case "sinergia2evolucaodetalhado":
								$comhttp->opcoes_retorno["usar_arr_tit"] = false;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = false;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesMontarRetorno::montar_sinergia2evolucaoDetalhado($comhttp);
								break;	
							case "painel_subregistros":
								FuncoesMontarRetorno::montar_subregistros_painel($comhttp);
								break;	
							case "painel_campestr":
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesMontarRetorno::montar_painel_campanhas_estruturadas($comhttp);
								//print_r($comhttp->retorno->dados_retornados["conteudo_html"]); exit();
								break;
							case "campanhas_estruturadas_objetivos_gerais":
								FuncoesMontarRetorno::consulta_estruturada_campanhas_estruturadas_objetivos_gerais($comhttp);			
								break;
							case "campanhas_estruturadas_objetivos_gerais_subcampanhas":
								FuncoesMontarRetorno::consulta_estruturada_campanhas_estruturadas_objetivos_gerais_subcampanhas($comhttp);			
								break;						
							case "campanhas_estruturadas_objetivos_especificos":
								FuncoesMontarRetorno::consulta_estruturada_campanhas_estruturadas_objetivos_especificos($comhttp);			
								break;						
							case "relatorio_personalizado":	
								FuncoesMontarSQL::montar_sql_relatorio_personalizado($comhttp);
								//print_r($comhttp->requisicao->sql->comando_sql); exit();
								$opcoes_tabela_est["tabeladb"]="relatorio_personalizado";
								$opcoes_tabela_est["subregistros"]["ativo"] = true;
								$opcoes_tabela_est["subregistros"]["aoabrir"] = "window.fnsisjd.pesquisar_sub_registro_linha_relatorio({elemento:this})";
								$opcoes_tabela_est["subregistros"]["campo_subregistro"] = "__CAMPOSUBREGISTRO__";
								$opcoes_tabela_est["subregistros"]["campo_subregistro_pai"] = "__CAMPOSUBREGISTROPAI__";
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "valores_venda_inicio":									
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mes"])) {
									$mes = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
									$mes_num = FuncoesData::MesNum($mes);
									$dtini = '01/'.$mes_num . '/' . FuncoesData::ano_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);									
								} else {
									$dtini = FuncoesData::data_primeiro_dia_mes_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual();
								}
								$datas = [$dtini,$dtfim];
								$codsusuariosacessiveis = self::obter_cods_rcas_acessiveis();
								$params_valores_por_entidade = [
									"entidade"=>"rca",
									"codsentidades"=>implode(",",$codsusuariosacessiveis),
									"nomevalor"=>"valor_venda_mes",
									"dtini"=>$dtini,
									"dtfim"=>$dtfim		
								];
								$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);									
								$cmd_sql2 = $cmd_sql;								
								$comhttp->retorno->dados_retornados["dados"] = [];								
								$comhttp->retorno->dados_retornados["dados"][] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetch",\PDO::FETCH_NUM)[0] ?? 0;
								$cmd_sql = str_replace("valor_venda_mes","peso_venda_mes",$cmd_sql2);
								$comhttp->retorno->dados_retornados["dados"][] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetch",\PDO::FETCH_NUM)[0] ?? 0;
								break;
							case "positivacao_inicio":									
								$mes1 = null;
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mes"])) {
									$mes1 = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
									$mes_num = FuncoesData::MesNum($mes1);
									$dtini = '01/'.$mes_num . '/' . FuncoesData::ano_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);									
								} else {
									$dtini = FuncoesData::data_primeiro_dia_mes_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual();									
								}
								$mes1 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);
								

								$codsusuariosacessiveis = self::obter_cods_rcas_acessiveis();								
								$params_valores_por_entidade = [
									"entidade"=>"rca",
									"codsentidades"=>implode(",",$codsusuariosacessiveis),
									"nomevalor"=>"positivacao_cliente_mes",
									"dtini"=>$dtini,
									"dtfim"=>$dtfim		
								];
								$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);								
								$comhttp->retorno->dados_retornados["dados"] = [];
								$comhttp->retorno->dados_retornados["dados"][0] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchColumn",0) ?? 0; 

								$dtini = FuncoesData::data_primeiro_dia_mes_anterior($dtini);
								$dtfim = FuncoesData::data_ultimo_dia_mes_anterior($dtfim);
								$datas = [$dtini,$dtfim];
								$mes2 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);
								$params_valores_por_entidade = [
									"entidade"=>"rca",
									"codsentidades"=>implode(",",$codsusuariosacessiveis),
									"nomevalor"=>"positivacao_cliente_mes",
									"dtini"=>$dtini,
									"dtfim"=>$dtfim		
								];
								$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);								
								$comhttp->retorno->dados_retornados["dados"][1] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchColumn",0) ?? 0; 
								$comhttp->retorno->dados_retornados["dados"][2] = $mes1;
								$comhttp->retorno->dados_retornados["dados"][3] = $mes2;
								break;
							case "mix_inicio":
								/*dados mes atual*/
								$mes1 = null;
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mes"])) {
									$mes1 = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
									$mes_num = FuncoesData::MesNum($mes1);
									$dtini = '01/'.$mes_num . '/' . FuncoesData::ano_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);									
								} else {
									$dtini = FuncoesData::data_primeiro_dia_mes_atual();
									$dtfim = FuncoesData::data_ultimo_dia_mes_atual();
								}
								$datas = [$dtini,$dtfim];
								$mes1 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);
								$codsusuariosacessiveis = self::obter_cods_rcas_acessiveis();	
								
								$params_valores_por_entidade = [
									"agregacao"=>"max",
									"entidade"=>"rca",
									"codsentidades"=>implode(",",$codsusuariosacessiveis),
									"nomevalor"=>"positivacao_produto_mes",
									"dtini"=>$dtini,
									"dtfim"=>$dtfim		
								];
								$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);								
								$comhttp->retorno->dados_retornados["dados"] = [];
								$comhttp->retorno->dados_retornados["dados"][0] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchColumn",0) ?? 0;


								/*dados mes anterior*/
								$dtini = FuncoesData::data_primeiro_dia_mes_anterior($dtini);
								$dtfim = FuncoesData::data_ultimo_dia_mes_anterior($dtfim);
								$datas = [$dtini,$dtfim];
								$mes2 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);
								$params_valores_por_entidade = [
									"agregacao"=>"max",
									"entidade"=>"rca",
									"codsentidades"=>implode(",",$codsusuariosacessiveis),
									"nomevalor"=>"positivacao_produto_mes",
									"dtini"=>$dtini,
									"dtfim"=>$dtfim		
								];
								$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);								
								$comhttp->retorno->dados_retornados["dados"][1] = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchColumn",0) ?? 0;
								$comhttp->retorno->dados_retornados["dados"][2] = $mes1;
								$comhttp->retorno->dados_retornados["dados"][3] = $mes2;
								break;
							case "menu":
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesVariaveis::__FNV_MONTAR_NAVBAR__($comhttp);
								break;
							case "data_aurora":
								$comando_sql = "select TO_CHAR(max(s.dtemissao),'dd/mm/yyyy') as dt from ep.epnfssaida s where s.codorigeminfo = 1";
								
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN,0);
								$comhttp->retorno->dados_retornados["conteudo_html"] = $comhttp->retorno->dados_retornados["conteudo_html"][0];
								
								break;								
							case "mes_inicio":
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox_meses([
									"style"=>"float:right;",
									"classe_botao"=>"btn-secondary",
									"aoselecionaropcao"=>"window.fnsisjd.selecionou_mes_inicio(this)"
								]));
								break;
							case "mais_recentes_inicio":																	
								$comando_sql2 = "
									SELECT
										max(to_date(to_char(l.data_acesso,'dd/mm/yyyy') || ' ' || l.horario_acesso,'dd/mm/yyyy hh24:mi:ss')) as ordenacao,
										to_char(max(to_date(to_char(l.data_acesso,'dd/mm/yyyy') || ' ' || l.horario_acesso,'dd/mm/yyyy hh24:mi:ss')),'dd/mm/yyyy hh24:mi:ss') as data_acesso,
										o.nomeops,
										o.seletorconteudo,
										o.nomeops,
										o.icone,
										o.nomeopcaovisivel
									FROM
										log_acesso l
										join ".VariaveisSql::getInstancia()->getPrefixObjects()."opcoessistema o on (
											o.nomeops = case 
												when l.nome_processo = 'sinergia2' then 'consultar_painel' 
												when l.nome_processo = 'sinergia' then 'consultar_sinergia'
												when l.nome_processo = 'gestao_acessos' then 'gestao'
												when l.nome_processo = 'consulta_majorar_ccrca' then 'majoracao_vendas_ccrca'
												when l.nome_processo = 'consulta_relatorio_majoracao_cc_rca' then 'relatoio_majoracao_vendas_ccrca'
												when l.nome_processo = 'freezer' then 'freezers'
												when l.nome_processo = 'promotor' then 'promotoras'
												when l.nome_processo = 'consultar_ratingsfocais' then 'consultarratingsfocais'
												when l.nome_processo = 'consulta_cliente' then 'consultar_cliente'
												when l.nome_processo = 'consulta_pedido' then 'consultar_pedidos'
												when l.nome_processo = 'clientescispenaojumbo' then 'cispe'
												when l.nome_processo = 'lista_campanhas_estruturadas_alterar' then 'alterar_campanhas_estruturadas'            
												when l.nome_processo = 'altera_pedido' then 'alterar_pedidos'
												when l.nome_processo = 'consulta_codigos_devolucao' then 'cadastro_codigos_devolucao'
												when l.nome_processo = 'consulta_estoque' then 'consultaestoque'
												when l.nome_processo like '%estruturada%' then 'consultar_campanhas_estruturadas'
												else l.nome_processo 
											end     
										)
									WHERE
										l.codusur = ".$_SESSION["codusur"]."
										and l.nome_processo is not null
										and l.tipo_processo != 'logar'
										and l.nome_processo not like 'painel_%'
										and l.nome_processo not in (
											'sinergia2evolucao',
											'login'
										)
									group by
										o.nomeops,
										o.seletorconteudo,
										o.nomeops,
										o.icone,
										o.nomeopcaovisivel
									ORDER BY
										1 DESC";	
								$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comando_sql2,"fetchAll",\PDO::FETCH_ASSOC);
								break;								
							case "mais_acessados_inicio":
								$comando_sql = "
									SELECT
										count(1) as qtacessos,
										o.nomeops,
										o.seletorconteudo,
										o.nomeops,
										o.icone,
										o.nomeopcaovisivel
									FROM
										log_acesso l
										join ".VariaveisSql::getInstancia()->getPrefixObjects()."opcoessistema o on (
											o.nomeops = case 
												when l.nome_processo = 'sinergia2' then 'consultar_painel' 
												when l.nome_processo = 'sinergia' then 'consultar_sinergia'
												when l.nome_processo = 'gestao_acessos' then 'gestao'
												when l.nome_processo = 'consulta_majorar_ccrca' then 'majoracao_vendas_ccrca'
												when l.nome_processo = 'consulta_relatorio_majoracao_cc_rca' then 'relatoio_majoracao_vendas_ccrca'
												when l.nome_processo = 'freezer' then 'freezers'
												when l.nome_processo = 'promotor' then 'promotoras'
												when l.nome_processo = 'consultar_ratingsfocais' then 'consultarratingsfocais'
												when l.nome_processo = 'consulta_cliente' then 'consultar_cliente'
												when l.nome_processo = 'consulta_pedido' then 'consultar_pedidos'
												when l.nome_processo = 'clientescispenaojumbo' then 'cispe'
												when l.nome_processo = 'lista_campanhas_estruturadas_alterar' then 'alterar_campanhas_estruturadas'            
												when l.nome_processo = 'altera_pedido' then 'alterar_pedidos'
												when l.nome_processo = 'consulta_codigos_devolucao' then 'cadastro_codigos_devolucao'
												when l.nome_processo = 'consulta_estoque' then 'consultaestoque'
												when l.nome_processo like '%estruturada%' then 'consultar_campanhas_estruturadas'
												else l.nome_processo 
											end 
										)
									WHERE
										l.codusur = ".$_SESSION["codusur"]."
										and l.nome_processo is not null
										and l.tipo_processo != 'logar'
										and l.nome_processo not like 'painel_%'
										and l.nome_processo not in (
											'sinergia2evolucao',
											'login'
										)
									group by
										o.nomeops,
										o.seletorconteudo,
										o.nomeops,
										o.icone,
										o.nomeopcaovisivel
									ORDER BY
										1 DESC";
								$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "produtoxrca":
							case "clientexproduto":
							case "clientexfornecedor":
							case "positivacaopersonalizada":
								$comhttp->requisicao->requisitar->qual->condicionantes["pivot"]=true;
								FuncoesMontarSQL::montar_sql_positivacoes($comhttp);
								//echo $comhttp->requisicao->sql->comando_sql;exit();					
								$cursor = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,null);
								
								/*arr_tit aqui contem os campos que representam as colunas não pivotadas somente*/
								$arr_tit = $comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"];								
								if (FuncoesArray::verif_valor_chave($comhttp->requisicao->requisitar->qual->condicionantes,["visoes_positivadoras"],0,"tamanho","maior") === true) {
									$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]);
								}
								FuncoesArray::chaves_minusculas($arr_tit);


								$ilin = 0;
								$icol = 0;
								$branco_se_zero = (bool)$comhttp->requisicao->requisitar->qual->condicionantes["branco_se_zero"];
								
								/*obtem aliases ligstabelasis*/
								$cnj_aliases_ligstabelasis = [];
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"])) {
									foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["processos"] as $chave_proc => $proc) {
										if (strcasecmp(trim($proc["processo"]["tipo"]),"normal") == 0 && count($proc["ligstabelasis"]) > 0) {
											echo "implementar";
											print_r($proc); 
											exit();				
										}
									}
									
									foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["ligstabelasis_unicas"] as $chave_ligtabelasis => $ligtabelasis_unica) {
										if ($ligtabelasis_unica["gerarconfintervdata"] == 1 && count($ligtabelasis_unica["ligstabelasis"]) > 0) {
											foreach($ligtabelasis_unica["ligstabelasis"] as $chave_ligtabelasis2 => $ligtabelasis_unica2) {
												if (strcasecmp(trim($ligtabelasis_unica2["tipo"]),"normal") == 0 && count($ligtabelasis_unica2["ligscamposis"]) > 0) {
													$cnj_aliases_ligstabelasis[] = strtolower(trim($ligtabelasis_unica2["alias"]));
												}
											}
										} else {
											if (strcasecmp(trim($ligtabelasis_unica["tipo"]),"normal") == 0 && count($ligtabelasis_unica["ligscamposis"]) > 0) {
												$cnj_aliases_ligstabelasis[] = strtolower(trim($ligtabelasis_unica["alias"]));
											}
										}
									}
								}

								/*gera os arrays de titulos e dados de forma manual, haja vista ser pivot xml o result sql */
								$ilin = 0;
								$icol = 0;
								$arr_dados = [];
								$titulos_simples_setados = false;
								$indcoldados = 0;
								while($linha = $cursor["result"]->fetch(\PDO::FETCH_ASSOC)) {
									$arr_dados[$ilin] = [];
									foreach ($linha as $k => $c) {
										$k = utf8_decode($k);
										$k = trim($k);
										if ((stripos($k,"_xml") === false)) {
											/*se não é o campo xml de lob, onde foi feito comando pivot do sql*/
											if (!( $titulos_simples_setados )) { 
												//so passa aqui uma vez, no final do primeiro loop atribui esta variavel como true
												//forma a estrutura do titulo da tabela colocando visoes em cima e campos em baixo, sob as formas de chaves do 
												//arr_tit, e armazendo o número da coluna para o par tit[visao][campo] = numcol
												if (count($cnj_aliases_ligstabelasis) > 0) { 
													foreach($cnj_aliases_ligstabelasis as $vis) {
														if (isset( $arr_tit[ strtolower(trim($vis)) ][ strtolower(trim($k)) ] )) {
															$arr_tit[ strtolower(trim($vis)) ][ strtolower(trim($k)) ] = $icol ;										
															$arr_dados[ $ilin ][ $arr_tit[ strtolower(trim($vis)) ] [ strtolower(trim($k)) ] ] = htmlentities($c, ENT_NOQUOTES,"ISO-8859-1");
															$icol++;
														}
													}
												} else {
													FuncoesArray::alterar_chave_array_recursivo($arr_tit,strtolower(trim($k)), $icol);
													$arr_dados[ $ilin ][$icol] = htmlentities($c, ENT_NOQUOTES,"ISO-8859-1");
													$icol++;
												}
											}else{
												if (count($cnj_aliases_ligstabelasis) > 0) {
													foreach( $cnj_aliases_ligstabelasis as $vis) {
														if (isset( $arr_tit[ strtolower(trim($vis)) ][ strtolower(trim($k)) ] )) {
															$arr_dados[ $ilin ][ $arr_tit[ strtolower(trim($vis)) ] [ strtolower(trim($k)) ] ] = htmlentities($c, ENT_NOQUOTES,"ISO-8859-1");
														}
													}
												} else {
													$indcoldados = FuncoesArray::procurar_chave_array_recursivo($arr_tit,strtolower(trim($k)));
													$arr_dados[ $ilin ][ $indcoldados ] = htmlentities($c, ENT_NOQUOTES,"ISO-8859-1");
												}
											}
										} else {
											if (is_object($linha[$k]) || is_resource($linha[$k])) {
												$c = stream_get_contents($linha[$k]); 
											} 
											$c = utf8_decode($c);
											$cnj_itens= new \SimpleXMLElement($c);
											foreach ($cnj_itens->item as $item) {
												$arr_tit_pai = [];
												$arr_tit_pai = &$arr_tit;
												$qtcolunas = count($item->column);
												$contador_colunas = 0;
												foreach ($item->column as $coluna) {
													$nome_col = strtolower(trim(htmlentities((string)$coluna['name'], ENT_NOQUOTES,"UTF-8")));
													$val_col = strtolower(trim(htmlentities((string)$coluna, ENT_NOQUOTES,"UTF-8")));
													if (stripos($nome_col,'quantidade_0') !== false ||stripos($nome_col,'pesototal_0') !== false||stripos($nome_col,'valortotal_0') !== false ||
														stripos($nome_col,'quantidade0') !== false ||stripos($nome_col,'pesototal0') !== false||stripos($nome_col,'valortotal0') !== false) {
														$campodevalor = "";
														if (stripos($nome_col,'quantidade_0') !== false) {
															$campodevalor = "quantidade_0";
														} else if (stripos($nome_col,'quantidade0') !== false) {
															$campodevalor = "quantidade0";
														} else if (stripos($nome_col,'pesototal_0') !== false) {
															$campodevalor = "pesototal_0";
														}else if (stripos($nome_col,'pesototal0') !== false) {
															$campodevalor = "pesototal0";
														} else if (stripos($nome_col,'valortotal_0') !== false) {
															$campodevalor = "valortotal_0";
														} else if (stripos($nome_col,'valortotal0') !== false) {
															$campodevalor = "valortotal0";
														}
														$nome_col = $campodevalor;
														if (!( array_key_exists($nome_col , $arr_tit_pai))) {
															$arr_tit_pai[ $nome_col ] = $icol;  // cria novo elemento no array do nivel corrente, que aqui é o último e armazena nele o índice da coluna de dados;
															$icol++; //como foi gerada uma coluna nova, incrementa o ind de col;										
														} 
														if (($val_col === 0 || $val_col === "0") && $branco_se_zero) {
															$arr_dados[ $ilin ][ $arr_tit_pai[ $nome_col ] ] = "";
														} else {
															$arr_dados[ $ilin ][ $arr_tit_pai[ $nome_col ] ] = $val_col;//atribui dados
														}
														$arr_tit_pai = &$null; //aponta a variavel para nulo para que ela não mais interfira no array principal
													}else{
														if (!( array_key_exists( $val_col , $arr_tit_pai ) )) {
															$arr_tit_pai[ $val_col ] = [] ; // cria novo elemento no array do nivel corrente								
														} 
														$arr_tit_pai = &$arr_tit_pai[ $val_col ] ; //se joga para o proximo nivel (linha)
														
													}
													$contador_colunas++;
												};
											};
										};
									};
									$ilin++;
									$titulos_simples_setados = true;
								}

						
								
								/*PREENCHE AS COLUNAS FALTANTES COM VALOR EM BRANCO*/
								foreach( $arr_dados as $ilin => $lin) {
									$ka = 0;
									ksort( $arr_dados[ $ilin ] , SORT_NUMERIC );
									foreach( $arr_dados[ $ilin ] as $k => $v) {
										if ($k > $ka) {//ka = 2 k = 3
											for($ka = $ka ; $ka < $k ; $ka ++) {
												$arr_dados[ $ilin ][ $ka ] = "";
											}
										}
										$ka = $k + 1;	
									}
									if ($ka < $icol) {
										for($ka = $ka ; $ka < $icol ; $ka ++) {
											$arr_dados[ $ilin ][ $ka ] = "";
										}
									}
								}


								/*ORDENAÇÃO*/
								$arr_tit_vis = array_slice($arr_tit,0,$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit_num_vis"],true);
								$arr_tit_cols = array_slice($arr_tit,$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit_num_vis"],count($arr_tit),true);

								//ordena apenas as colunas que foram pivoteadas, mantendo as colunas das visoes nas suas posicoes originais, por isso o 
								//slice antes.
								ksort($arr_tit_cols, SORT_NATURAL ); 
								$GLOBALS["arr_ord"] = [];			
								$arr_tit = $arr_tit_vis;
								foreach($arr_tit_cols as $k => $v) {
									/*reinclui no arr_tit o array das colunas ordenadas*/
									$arr_tit[$k] = $v;
								}
								
								array_walk_recursive($arr_tit,self::class . "::pegar_ordem");
								$arr_dados_ord = [];
								foreach($arr_dados as $k => $lin) {
									$lin_ord = [];	
									foreach($GLOBALS["arr_ord"] as $ord) {
										$lin_ord[] = $lin[$ord];//se $ord nao estiver na ordem numerica natural, o que geralmente ocorre, o javascript reordena o array ao fazer JSON.parse, o que embaralha os dados novamente, colocando-os em suas posicoes erradas.
									}
									$arr_dados_ord[$k] = $lin_ord;
								}
								$arr_dados = $arr_dados_ord;
								$opcoes_tabela_est["tabeladb"]="positivacoes";
								$opcoes_tabela_est["subregistros"]["ativo"] = false;								
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
								array_walk_recursive($arr_tit,self::class . "::voltar_texto_tit_original");
								$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $arr_tit;
								$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
								$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
								$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);
								$comhttp->retorno->dados_retornados["dados"] = $arr_dados;
								$comhttp->requisicao->sql = null;
								FuncoesSql::getInstancia()->fechar_cursor($cursor);
								break;
							case "clientesnaopositivados":
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"]=true;
								FuncoesMontarSQL::montar_sql_clientes_nao_positivados($comhttp);
								print_r($comhttp->requisicao->sql->comando_sql);exit();
								$opcoes_tabela_est["tabeladb"]="clientesnaopositivados";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;						
							case "produtosnaopositivados":
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"]=true;
								FuncoesMontarSQL::montar_sql_produtos_nao_positivados($comhttp);
								$opcoes_tabela_est["tabeladb"]="clientesnaopositivados";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;												
							case "clientescispenaojumbo":
								FuncoesMontarSQL::montar_sql_cispe($comhttp);
								self::obter_sql_dados_arr_tit($comhttp);
								$opcoes_tabela_est["tabeladb"]="clientescispenaojumbo";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "promotor":								
								FuncoesMontarSQL::montar_sql_promotoras($comhttp);
								$opcoes_tabela_est["tabeladb"]="promotor";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "freezer":
								FuncoesMontarSQL::montar_sql_freezer($comhttp);
								$opcoes_tabela_est["tabeladb"]="freezer";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "critica":
								$comhttp->opcoes_retorno["usar_arr_tit"] = false;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = false;
								FuncoesMontarSQL::montar_sql_critica($comhttp);
								self::obter_sql_dados_arr_tit($comhttp);
								$opcoes_tabela_est["tabeladb"]="critica";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;					
							case "gestao_acessos":
								FuncoesMontarSQL::montar_sql_gestao_acessos($comhttp);
								$opcoes_tabela_est["tabeladb"]="gestao_acessos";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;														
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;
							case "lista_clientes":
								FuncoesMontarSQL::montar_sql_lista_clientes($comhttp);
								$comhttp->retorno->dados_retornados = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "lista_clientes_atualizar_rfb":
								$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
								$comhttp->requisicao->sql = new TSql();
								$comhttp->requisicao->sql->comando_sql = $comando_sql;
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="consulta_cliente";
								$opcoes_tabela_est["corpo"]["linhas"]["aoduploclicar"] = "carregar_dados_cliente_rfb(this)";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);										
								break;					
							case "lista_cobranca":
								FuncoesMontarSQL::montar_sql_lista_cobranca($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "lista_prazos":
								FuncoesMontarSQL::montar_sql_lista_prazos($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);								
								break;
							case "lista_produtos":
								FuncoesMontarSQL::montar_sql_lista_produtos($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;		
							case "ult_peds_cli":
								FuncoesMontarSQL::montar_sql_ult_peds_cli($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "itens_pedido":
								FuncoesMontarSQL::montar_sql_ult_peds_itens_cli($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "ult_peds_rca":
								FuncoesMontarSQL::montar_sql_ult_peds_rca($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "tabela_para_edicao":
								FuncoesMontarSQL::montar_sql_tabela_para_edicao($comhttp);
								$comhttp->retorno->dados_retornados=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "consulta_estoque":
								FuncoesMontarSQL::montar_sql_consulta_estoque($comhttp);
								$opcoes_tabela_est["tabeladb"]="consulta_estoque";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								FuncoesHtml::montar_retorno_tabdados($comhttp);
								break;										
							case "consulta_cliente":
								FuncoesMontarSQL::montar_sql_consulta_cliente($comhttp);
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="consulta_cliente";
								$opcoes_tabela_est["corpo"]["linhas"]["aoduploclicar"] = "carregar_dados_cliente(this)";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);										
								break;										
							case "consulta_pedido":
								FuncoesMontarSQL::montar_sql_consulta_pedido($comhttp);
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="consulta_pedido";
								$opcoes_tabela_est["corpo"]["linhas"]["aoduploclicar"] = "carregar_dados_pedido(this)";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);										
								break;							
							case "altera_pedido":
								FuncoesMontarSQL::montar_sql_consulta_pedido($comhttp);
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="consulta_pedido";
								$opcoes_tabela_est["selecao"]["ativo"] = true;
								$opcoes_tabela_est["selecao"]["selecao_tipo"] = "checkbox";
								$opcoes_tabela_est["selecao"]["selecionar_pela_linha"] = false;
								$opcoes_tabela_est["selecao"]["selecionar_todos"] = 1;
								$opcoes_tabela_est["cabecalho"]["linhas_adicionais"] = [
									0=>FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_elemento([
										"tag"=>"tr",
										"class"=>"linha_comandos_usuario",
										"text"=>"Excluir item dos pedidos",
										"sub"=>[
											[
												"tag"=>"th",
												"colspan"=>"999",
												"class"=>"cel_tit_comandos_usuario",
												"sub"=>[
													[
														"tag"=>"button",
														"onclick"=>"window.fnsisjd.excluir_itens_pedidos_selecionados(this)"
													]
												]
											]
										]
									]))
								];
								$opcoes_tabela_est["corpo"]["linhas"]["aoduploclicar"] = "carregar_dados_pedido(this)";
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;						
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);										
								break;							
							case "painel_clientesnaoposit":								
								FuncoesMontarRetorno::montar_painel_clientes_nao_positivados($comhttp);
								break;						
							case "painel_produtosnaoposit":
								FuncoesMontarRetorno::montar_painel_produtos_nao_positivados($comhttp);
								break;
							case "entidades_campanhas_sinergia":
								$comhttp->requisicao->sql->comando_sql = "select distinct entidade from sjdobjetivossinergia ";
								$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = FuncoesSql::getInstancia()->preparar_condicionantestab($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]);
								if (count($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) > 0) {
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"])) {
										$comhttp->requisicao->sql->comando_sql .= " where " . $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"];
									}
								}
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"] = VariaveisSql::getInstancia()->getPrefixObjects() . "objetivossinergia";
								$opcoes["cabecalho"]["comandos"]["ativo"] = false;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"] = "linha";
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"] = false;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["marcarmultiplo"] = false;
								$opcoes["subregistros"]["ativo"] = true;
								$opcoes["subregistros"]["aoabrir"] = "carregar_subregistro_alterar_campanhas_sinergia(this)";
								$opcoes["rodape"]["ativo"] = false;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["propriedades_html"]["visao"] = $comhttp->requisicao->requisitar->qual->condicionantes["relatorio"];
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes,false);		
								break;
							case "cods_entidades_campanhas_sinergia":
								$comhttp->requisicao->sql->comando_sql = "select distinct codentidade from sjdobjetivossinergia ";
								$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = FuncoesSql::getInstancia()->preparar_condicionantestab($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]);
								if (count($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) > 0) {
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"])) {
										$comhttp->requisicao->sql->comando_sql .= " where " . $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"];
									}
								}
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"] = VariaveisSql::getInstancia()->getPrefixObjects() . "objetivossinergia";
								$opcoes["cabecalho"]["comandos"]["ativo"] = false;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"] = "linha";
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"] = false;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["marcarmultiplo"] = false;
								$opcoes["subregistros"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["subregistros"]["aoabrir"] = "carregar_subregistro_alterar_campanhas_sinergia(this)";
								$opcoes["rodape"]["ativo"] = false;
								$opcoes["propriedades_html"]["visao"] = $comhttp->requisicao->requisitar->qual->condicionantes["relatorio"];
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes,false);		
								break;	
							case "visoes_campanhas_sinergia":
								$comhttp->requisicao->sql->comando_sql = "select distinct visao from sjdobjetivossinergia ";
								$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = FuncoesSql::getInstancia()->preparar_condicionantestab($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]);
								if (count($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) > 0) {
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"])) {
										$comhttp->requisicao->sql->comando_sql .= " where " . $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]["sjdobjetivossinergia"];
									}
								}
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"] = VariaveisSql::getInstancia()->getPrefixObjects() . "objetivossinergia";
								$opcoes["cabecalho"]["comandos"]["ativo"] = false;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"] = "linha";
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"] = false;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["marcarmultiplo"] = false;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["subregistros"]["ativo"] = true;
								$opcoes["subregistros"]["aoabrir"] = "carregar_subregistro_alterar_campanhas_sinergia(this)";
								$opcoes["rodape"]["ativo"] = false;
								$opcoes["propriedades_html"]["visao"] = $comhttp->requisicao->requisitar->qual->condicionantes["relatorio"];
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes,false);		
								break;
							case "itens_visoes_campanhas_sinergia":
								$codprocesso = 5810;
								$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
								$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
								$comhttp->opcoes_retorno["usar_arr_tit"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
								$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes = FuncoesHtml::opcoes_tabela_est;
								$opcoes["tabeladb"] = VariaveisSql::getInstancia()->getPrefixObjects() . "objetivossinergia";
								$opcoes["cabecalho"]["comandos"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["ativo"] = true;
								$opcoes["cabecalho"]["comandos"]["inclusao"]["tipo"] = "linha";
								$opcoes["cabecalho"]["filtro"]["ativo"]=true;
								$opcoes["cabecalho"]["ordenacao"]["ativo"]=true;
								$opcoes["corpo"]["linhas"]["comandos"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["edicao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["ativo"] = true;
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvarnovalinha"] = "window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["salvar"]["aosalvaredicaolinha"] = "window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["comandos"]["exclusao"]["aoexcluirlinha"] = "window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})";
								$opcoes["corpo"]["linhas"]["marcarmultiplo"] = false;
								$opcoes["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes["subregistros"]["ativo"] = false;
								$opcoes["rodape"]["ativo"] = false;
								$opcoes["propriedades_html"]["visao"] = $comhttp->requisicao->requisitar->qual->condicionantes["relatorio"];
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes;
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes,false);		
								break;	
							case "consulta_relatorio_majoracao_cc_rca":								
								FuncoesMontarSQL::montar_sql_consulta_relatorio_majoracao_cc_rca($comhttp);
								$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$opcoes_tabela_est["tabeladb"]="relatorio_majoracao_cc_rca";						
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
								$indultcol = 0;
								foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"] as $celtit) {
									if ($celtit["linha"] = 0) {
										if ($celtit["coluna"] > $indultcol) {
											$indultcol = $celtit["coluna"];
										}
									}
								}
								$indultcol2 = 0;
								foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"] as $celtit) {
									if ($celtit["linha"] = 1) {
										if ($celtit["coluna"] > $indultcol2) {
											$indultcol2 = $celtit["coluna"];
										}
									}
								}
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][count($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"])] = [
									"cod"=>count($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"]),
									"codsup"=>-1,
									"valor"=>"Total",
									"linha"=>0,
									"coluna"=>$indultcol + 1,
									"indexreal"=> $indultcol + 1,
									"colspan"=> 1,
									"texto"=>"Total"
								];
								$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][count($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"])] = [
									"cod"=>count($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"]),
									"codsup"=>count($comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"])-1,
									"valor"=>"Vlr Total",
									"linha"=>1,
									"coluna"=>$indultcol2 + 1,
									"indexreal"=> $indultcol2 + 1,
									"colspan"=> 1,
									"rowspan"=> 2,
									"texto"=>"Vlr. Total"
								];
								foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"] as $chave_lin => $linha) {
									$ind = count($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin]);
									$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$ind] = 0;
									foreach($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin] as $chave_cel=>$cel) {								
										if ($chave_cel > 1 && $chave_cel !== $ind) {									
											if (strpos($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel],".") !== false) {
												if (strpos($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel],",") !== false) {
													$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel] = str_replace(".","",$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel]);
												} else {
													$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel] = str_replace(".",",",$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel]);
												}
											}
											$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$ind] = $comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$ind] + FuncoesConversao::como_numero($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$chave_cel]);
										}
									}
									$comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$ind] = number_format($comhttp->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][$ind],2,",",".");
								}
								$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);										
								break;
							case "consultar_ratingsfocais":								
								FuncoesMontarRetorno::consulta_ratings_focais($comhttp);
								break;
							case "consultar_itens_campanha_giro":								
								FuncoesMontarRetorno::montar_consulta_itens_camp_giro($comhttp);
								break;	
							case "clientesativosxpositivados":								
								FuncoesMontarRetorno::montar_consulta_clientesativosxpositivados($comhttp);
								break;	
							case "clientes_ativosxposit_subregistros":								
								FuncoesMontarRetorno::montar_consulta_clientesativosxpositivados_subregistros($comhttp);
								break;
							case "dados_graficos_inicio":								
								FuncoesMontarSQL::montar_sql_grafico_evolucao_sinergia($comhttp);
								$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								break;
							case "tabela_valores_resumo_sinergia":								
								FuncoesMontarRetorno::montar_tabela_valores_resumo_sinergia($comhttp);
								break;
							case "tabela_clientesativosxposit_resumo_sinergia":								
								FuncoesMontarRetorno::montar_tabela_clientesativosxposit_resumo_sinergia($comhttp);
								break;
							case "tabela_mixprod_resumo_sinergia":								
								FuncoesMontarRetorno::montar_tabela_mixprod_resumo_sinergia($comhttp);
								break;	
							case "relatorio_uso_veiculo_reserva":
								$comando_sql = "
									SELECT
										r1.dtreq as dtini,
										r2.dtreq as dtfim,
										r1.codmotorista as codmot,
										u.nome as nome,
										r1.rota as rota,
										r1.motivo as motivo,
										r1.kmpainel as kmpainel_antes,    
										r2.kmpainel as kmpainel_depois,
										r2.kmpainel - r1.kmpainel as km_utilizados,
										r1.fotopainel as fotopainel_antes,
										r2.fotopainel as fotopainel_depois,
										r2.fotonotacombustivel as notacombustivel,
										r2.tempototalutilizado as dias_utilizados
									FROM
										sjdreqsenhaveic r2
										left outer join sjdreqsenhaveic r1 on (r1.codrequisicao = r2. codrequisicaoant)
										left outer join sjdusuariosis u on (u.codusuariosis = r2.codmotorista)
									WHERE
										r2.tempototalutilizado IS NOT NULL 
								";
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["periodos"]) && $comhttp->requisicao->requisitar->qual->condicionantes["periodos"] !== null) {
									$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["periodos"];
									$periodos = explode("],[",$periodos);
									if (count($periodos) > 0) {
										foreach($periodos as &$periodo) {
											$periodo = str_replace(["[","]","\"","'"],"",$periodo);
											$periodo = explode(",",$periodo);
										}									
										$comando_sql .= " and r2.dtreq between to_date('" . $periodos[0][0] . "','dd/mm/yyyy') and to_date('" . $periodos[0][1] . "','dd/mm/yyyy') ";
									}
								}
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["motorista"]) && $comhttp->requisicao->requisitar->qual->condicionantes["motorista"] !== null) {
									$motorista = $comhttp->requisicao->requisitar->qual->condicionantes["motorista"];
									$motorista = trim($motorista);
									if (strlen($motorista) > 0) {
										$motorista = explode(",",$motorista);
										if (count($motorista) > 0) {
											$comando_sql .= " and r2.codmotorista in (".implode(",",$motorista).") ";											
										}
									}
								}
								$comando_sql .= " order by r2.dtreq ";
								$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql->requisicao->sql->comando_sql);
								$comhttp->retorno->dados_retornados["dados"] = [
									"tabela"=>[
										"titulo"=>[
											"arr_tit"=>FuncoesSql::getInstancia()->obter_campos_resource($dados["result"])
										],
										"dados"=>$dados["result"]->fetchAll(\PDO::FETCH_ASSOC)
									]
								];
								FuncoesSql::getInstancia()->fechar_cursor($dados);
								break;
							case "entregas":
								/*
								comando para notas
								$comando_sql = "
									SELECT
										s.numtransvenda,
										s.numcar,
										s.numnota,
										s.totpesobruto,
										s.vltotal,
										case 
											when a.statusentrega = 0 then 'Nao Iniciada'
											when a.statusentrega = 1 then 'Em Andamento'
											when a.statusentrega = 2 then 'Entregue Total'
											when a.statusentrega = 3 then 'Devolvido Parcial'
											when a.statusentrega = 4 then 'Devolvido Total'
											else 'Indefinido'
										end as status,
										sum(i.qtentregue) as qtentregue,
										sum(i.qtentregue * m.pesobruto) as pesoentregue,
										sum(i.qtentregue * m.punit) as valorentregue,										
										s.codcob,
										(select sum(p.valor) from sjdacompentregapag p where p.chavenfe = a.chavenfe and lower(p.formapagamento) = 'dinheiro') as \"Vlr Rec. Dinh.\",
										(select sum(p.valor) from sjdacompentregapag p where p.chavenfe = a.chavenfe and lower(p.formapagamento) = 'pix') as \"Vlr Rec. Pix\",
										(select sum(p.valor) from sjdacompentregapag p where p.chavenfe = a.chavenfe and lower(p.formapagamento) = 'cheque') as \"Vlr Rec. Cheque\",
										s.codmotorista,
										e.nome as nomemotorista,
										s.codusur,
										u.nome as nomeusuario,
										c.codveiculo,
										v.placa,
										to_char(a.dtinicioentrega,'dd/mm/yyyy hh24:mi') as dtinientrega,
										to_char(a.dtfimentrega,'dd/mm/yyyy hh24:mi') as dtfimentrega,
										to_char(a.dttransmissao,'dd/mm/yyyy hh24:mi') as dttransmissao,
										a.observacao
									FROM
										jumbo.pcnfsaid s 
										join jumbo.pcmov m on (m.numtransvenda = s.numtransvenda)
										left outer join jumbo.pcusuari u on (u.codusur = s.codusur)
										left outer join jumbo.pccarreg c on (c.numcar = s.numcar)
										left outer join jumbo.pcempr e on (e.matricula = c.codmotorista)
										left outer join jumbo.pcveicul v on (v.codveiculo = c.codveiculo)
										left outer join sjdacompentreganotas a on (a.chavenfe = s.chavenfe)
										left outer join sjdacompentregaprod i on (i.chavenfe = a.chavenfe and i.codprod = m.codprod)
									where											
										__CONDICIONANTES__
									group by
										s.numtransvenda,
										s.numcar,
										s.numnota,
										s.totpesobruto,
										s.vltotal,
										case 
											when a.statusentrega = 0 then 'Nao Iniciada'
											when a.statusentrega = 1 then 'Em Andamento'
											when a.statusentrega = 2 then 'Entregue Total'
											when a.statusentrega = 3 then 'Devolvido Parcial'
											when a.statusentrega = 4 then 'Devolvido Total'
											else 'Indefinido'
										end,
										s.codcob,
										s.codmotorista,
										e.nome,
										s.codusur,
										u.nome,
										c.codveiculo,
										v.placa,
										to_char(a.dtinicioentrega,'dd/mm/yyyy hh24:mi'),
										to_char(a.dtfimentrega,'dd/mm/yyyy hh24:mi'),
										to_char(a.dttransmissao,'dd/mm/yyyy hh24:mi'),
										a.chavenfe,
										a.observacao
								";*/
								$comando_sql = "
									select
										c.numcar as \"Carregamento\",
										c.codmotorista as \"Mot\",
										c.nomemotorista as \"Nome\",
										c.placa,
										c.destino,
										c.dtsaida as \"Data\",
										c.numnotas as \"NFs\",
										c.vltotal,
										c.dtinicioentregas as \"Inicio\",
										c.dtfimentregas as \"Fim\",
										c.dttransmissao as \"Transmissao\",
										c.statuscarregamento as \"Status\",
										c.observacao,
										count(distinct case when n.statusentrega = 0 then n.chavenfe else null end) as \"NFs A Entregar\",
										count(distinct case when n.statusentrega = 2 then n.chavenfe else null end) as \"NFs Entregue\",
										count(distinct case when n.statusentrega = 3 then n.chavenfe else null end) as \"NFs Dev. Parcial\",
										count(distinct case when n.statusentrega = 4 then n.chavenfe else null end) as \"NFs Dev. Total\",
										sum(case when n.statusentrega = 2 then i.qtentregue * i.valorunitario else 0 end) as \"Vl. Entregue\",
										sum(case when s.codcob in ('D') and n.statusentrega in (2,3) then i.qtentregue * i.valorunitario else 0 end) as \"Vl. Devido\",
										pgd.valor as \"Vl Deposito\",
										pgm.valor as \"Vl Malote\"
									from 
										sjdacompentregacarreg c
										left outer join (
											select
												pg.numcar,
												pg.formapagamento,
												sum(nvl(pg.valor,0)) as valor
											from
												sjdacompentregapagcar pg
											where
												lower(pg.formapagamento) = 'deposito'
											group by
												pg.numcar,
												pg.formapagamento
										) pgd on (pgd.numcar = c.numcar)
										left outer join (
											select
												pg.numcar,
												pg.formapagamento,
												sum(nvl(pg.valor,0)) as valor
											from
												sjdacompentregapagcar pg
											where
												lower(pg.formapagamento) = 'malote'
											group by
												pg.numcar,
												pg.formapagamento
										) pgm on (pgm.numcar = c.numcar)
										left outer join sjdacompentreganotas n on n.numcar = c.numcar
										left outer join jumbo.pcnfsaid s on (
											s.chavenfe = n.chavenfe
											and s.numcar = c.numcar				
										)
										left outer join sjdacompentregaprod i on i.chavenfe = n.chavenfe
									where
										__CONDICIONANTES__
									group by
										c.numcar,
										c.codmotorista,
										c.nomemotorista,
										c.placa,
										c.destino,
										c.dtsaida,
										c.pesototal,
										c.numnotas,
										c.vltotal,
										c.dtinicioentregas,
										c.dtfimentregas,
										c.dttransmissao,
										c.statuscarregamento,
										c.observacao,
										pgd.valor,
										pgm.valor
									order by
										c.numcar
								";
								$condicionantes = [];
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"]) && $comhttp->requisicao->requisitar->qual->condicionantes["datas"] !== null) {
									$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
									$periodos = explode("],[",$periodos);
									if (count($periodos) > 0) {
										foreach($periodos as &$periodo) {
											$periodo = str_replace(["[","]","\"","'"],"",$periodo);
											$periodo = explode(",",$periodo);
										}									
										$condicionantes[] = "trunc(c.dttransmissao) between to_date('" . $periodos[0][0] . "','dd/mm/yyyy') and to_date('" . $periodos[0][1] . "','dd/mm/yyyy') ";
									}
								}

								
								if (gettype($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]) === "string" && $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] !== null) {
									$condicionantes_temp = explode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
									foreach($condicionantes_temp as $chave=>$cond) {
										$condicionantes_temp[$chave] = explode(Constantes::sepn2,$condicionantes_temp[$chave]);
									}
									$cond_car = [];
									$cond_mot = [];
									$cond_rca = [];
									foreach($condicionantes_temp as $chave=>$cond){
										foreach($condicionantes_temp[$chave] as $chave2=>$item_cond) {
											$condicionantes_temp[$chave][$chave2] = explode("=",$condicionantes_temp[$chave][$chave2]);
											switch(strtolower(trim($condicionantes_temp[$chave][$chave2][0]))) {
												case "carregamento":
													if (FuncoesString::strTemValor($condicionantes_temp[$chave][$chave2][1]))  {
														$cond_car[] = "c.numcar=" . $condicionantes_temp[$chave][$chave2][1];
													}
													break;
												case "motorista":
													if (FuncoesString::strTemValor($condicionantes_temp[$chave][$chave2][1]))  {
														$cond_mot[] = "c.codmotorista=" . $condicionantes_temp[$chave][$chave2][1];
													}
													break;
												case "rca":
													if (FuncoesString::strTemValor($condicionantes_temp[$chave][$chave2][1]))  {
														$cond_rca[] = "s.codusur=" . $condicionantes_temp[$chave][$chave2][1];
													}
													break;
												default:
													echo "condicao nao esperada: ";
													print_r($condicionantes_temp[$chave][$chave2]); exit();
													break;
											}
										}
									}
									if (count($cond_car) > 0 ) {
										$condicionantes[] = "(".implode(" or ", $cond_car).")";
									}
									if (count($cond_mot) > 0 ) {
										$condicionantes[] = "(".implode(" or ", $cond_mot).")";
									}
									if (count($cond_rca) > 0 ) {
										$condicionantes[] = "(".implode(" or ", $cond_rca).")";
									}
								}

								if (count($condicionantes) > 0) {
									$comando_sql = str_ireplace("__CONDICIONANTES__",implode(" and ",$condicionantes),$comando_sql);
								} else {
									$comando_sql = str_ireplace("__CONDICIONANTES__","1=1",$comando_sql);
								}
								
								$comhttp->requisicao->sql = new TSql();
								$comhttp->requisicao->sql->comando_sql = $comando_sql;
								$opcoes_tabela_est["tabeladb"]="entregas";								
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
								$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
								$opcoes_tabela_est["subregistros"]["ativo"] = true;
								$opcoes_tabela_est["subregistros"]["aoabrir"] = "window.fnsisjd.pesquisar_sub_registro_linha_relatorio({elemento:this})";
								$opcoes_tabela_est["subregistros"]["campo_subregistro"] = "__CAMPOSUBREGISTRO__";
								$opcoes_tabela_est["subregistros"]["campo_subregistro_pai"] = "__CAMPOSUBREGISTROPAI__";
								$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
								$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [
									"Dados Carregamento"=>[
										"Carregamento",
										"Mot",
										"Nome",
										"Placa",
										"Destino",
										"Data",
										"NFs",
										"Valor",
										"Inicio",
										"Fim",
										"Transmissao",
										"Status",
										"Observacao"
									],
									"Dados Entrega"=>[
										"NFs a Entregar",
										"NFs Entregues",
										"NFs Dev. Parcial",
										"NFs Dev. Total",
										"Vl Tot. Entregue",
										"Vl Devido",
										"Vl Deposito",
										"Vl Malote"
									]
								];
								$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
								FuncoesHtml::montar_retorno_tabdados($comhttp);								
								break;
							case "pesquisa_filial":
							case "pesquisa_basica_filial":
							case "pesquisa_avancada_filial":
							case "pesquisa_cliente":
							case "pesquisa_basica_cliente":
							case "pesquisa_avancada_cliente":
							case "pesquisa_rca":
							case "pesquisa_basica_rca":
							case "pesquisa_avancada_rca":
							case "pesquisa_gerente":
							case "pesquisa_basica_gerente":
							case "pesquisa_avancada_gerente":
							case "pesquisa_supervisor":
							case "pesquisa_basica_supervisor":
							case "pesquisa_avancada_supervisor":
							case "pesquisa_cidade":
							case "pesquisa_basica_cidade":
							case "pesquisa_avancada_cidade":
							case "pesquisa_basica_estado":
							case "pesquisa_avancada_estado":
							case "pesquisa_regiao":
							case "pesquisa_basica_regiao":
							case "pesquisa_avancada_regiao":
							case "pesquisa_rota":
							case "pesquisa_basica_rota":
							case "pesquisa_avancada_rota":
							case "pesquisa_praca":
							case "pesquisa_basica_praca":
							case "pesquisa_avancada_praca":
								$rel = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["relatorio"]));
								$rel = str_ireplace(["_avancada","_avancado","_basico","_basica"],"",$rel);
								$comando_sql = ConstsQuerysSql::querys[$rel];
								$texto_condicionantes = "1=1";
								if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])){
									$condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
									$condicionantes = str_ireplace(Constantes::sepn1," and ",$condicionantes);
									$texto_condicionantes = $condicionantes;
								} 
								$comando_sql = str_ireplace("__CONDICIONANTES__",$texto_condicionantes,$comando_sql);
								//$comhttp->requisicao->sql->comando_sql = $comando_sql;
								//FuncoesHtml::montar_retorno_tabdados($comhttp);
								$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql);
								$comhttp->retorno->dados_retornados["dados"] = [
									"tabela"=>[
										"titulo"=>[
											"arr_tit"=>FuncoesSql::getInstancia()->obter_campos_resource($dados["result"])
										],
										"dados"=>$dados["result"]->fetchAll(\PDO::FETCH_ASSOC)
									]
								];								
								FuncoesSql::getInstancia()->fechar_cursor($dados);
								break;
							case "gruposprodutosequivalentes":
								FuncoesVariaveis::__FNV_MONTAR_TABELA_GRUPOS_PRODUTOS_EQUIVALENTES__($comhttp);
								break;
							default:
								FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["relatorio"],__FILE__,__FUNCTION__,__LINE__);
								break;												
						}
						break;
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"],__FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
			return ;
		}

		public function obter_fornecs_vinculados($codusur){
			$fornecs = [];
			$nome_tabela = "";	
			$nome_tabela = VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosisfornec";
			if (FuncoesSql::getInstancia()->tabela_existe($nome_tabela)) {
				$cmdsql = "select codfornec from $nome_tabela where codusuariosistema = " . $codusur ;
				$fornecs = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_COLUMN,0);
			}
			return $fornecs;
		}

		public static function obter_deptos_vinculados($codusur)
		{
			$deptos = [];
			$nome_tabela = "";	
			$nome_tabela = VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosisdepto";
			if (FuncoesSql::getInstancia()->tabela_existe($nome_tabela)) {
				$cmdsql = "select codepto from $nome_tabela where codusuariosis = " . $codusur ;
				$deptos = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_ASSOC);
			}
			return $deptos;
		}


		/**
			* Função que obtem usuarios vinculados a uma filial conforme do sistema conforme parametros
			*
			* @author Antonio Alencar Velozo
			* @version 1.0		
			* @param string $codfilial a filial
			* @param array $campos os campos que a pesquisa deve retornar
			* @param Boolean $associativo se o retorno deve retornar os valores das conlunas como array indexado pelo nome dos campos ou numeros
			* @param Boolean $array_multi_dimens se o array vai trazer mutidimensao linha x registro ou vai juntar tudo numa unica sequencia
			* @return array $usursfilial os dados obtidos
		*/
		public static function obter_usuarios_filial($codfilial,$campos=["codusuariosis"], $associativo = false , $array_multi_dimens = false) {			
			$retorno = null;
			$qt_campos = 1;
			if (gettype($campos) === "array") {
				$qt_campos = count($campos);
				$campos = implode(",",$campos);
			}
			$cmdsql = "select " . $campos . " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis";
			if (isset($codfilial)) {
				if (strlen(trim($codfilial)) > 0) {
					$cmdsql .= " where codfilial in (" . $codfilial . ")";
				}
			} 
			if ($qt_campos === 1) {
				//retorna array como unica coluna
				$retorno = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_COLUMN,0);
			} else {
				$retorno = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_ASSOC);
			}
			//guarda na sessao se ainda nao guardado
			if (!isset($_SESSION["usuarios_filial"])) {
				$_SESSION["usuarios_filial"] = $retorno;
			}
			return $retorno;
		}

		/**
			* Função que obtem usuarios subordinados de supervisor(es) conforme do sistema conforme parametros
			*
			* @author Antonio Alencar Velozo
			* @version 1.0		
			* @param string $codusur o usuario superior
			* @param array $campos os campos que a pesquisa deve retornar
			* @param Boolean $associativo se o retorno deve retornar os valores das conlunas como array indexado pelo nome dos campos ou numeros
			* @param Boolean $array_multi_dimens se o array vai trazer mutidimensao linha x registro ou vai juntar tudo numa unica sequencia
			* @return array $subordinados os dados obtidos
		*/	
		public function obter_usuario_superior($codusur,$campos=["codsupervisor"], $associativo = false , $array_multi_dimens = false) {							
			if (!isset($_SESSION["superior"])){
				$cmdsql = "select " . implode(",",$campos). " from ". VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where codusuariosis = " . $codusur;
				$_SESSION["superior"] = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_ASSOC);		
			}
			return $_SESSION["superior"];
		}

		/**
			* Função que obtem usuarios subordinados de supervisor(es) conforme do sistema conforme parametros
			*
			* @author Antonio Alencar Velozo
			* @version 1.0		
			* @param string $codusur o usuario superior
			* @param array $campos os campos que a pesquisa deve retornar
			* @param Boolean $associativo se o retorno deve retornar os valores das conlunas como array indexado pelo nome dos campos ou numeros
			* @param Boolean $array_multi_dimens se o array vai trazer mutidimensao linha x registro ou vai juntar tudo numa unica sequencia
			* @return array $subordinados os dados obtidos
		*/
		public static function obter_usuarios_subordinados($codusur,$campos=["codusuariosis"], $associativo = false , $array_multi_dimens = false) {
			$subordinados = [];
			if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis")) {
				$qt_campos = 1;
				if (gettype($campos) === "array") {
					$qt_campos = count($campos);
					$campos = implode(",",$campos);
				}
				$cmdsql = "select " . $campos. " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where codsupervisor = " . $codusur . " or codusuariosis = " . $codusur;
				if ($qt_campos === 1 || $array_multi_dimens === false) {
					$subordinados = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_COLUMN,0);
				} else {
					if ($associativo) {
						$subordinados = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_ASSOC);
					} else {
						$subordinados = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_NUM);
					}
				}				
			}
			return $subordinados;
		}

		/**
			* Função que obtem usuarios subordinados de supervisor(es) conforme do sistema conforme parametros
		*/	
		public static function obter_usuarios_acessiveis($usuariosis,$campos=["codusuariosis"], $associativo = false , $array_multi_dimens = false) {
			$acessiveis = [];			
			if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis")) {
				switch(strtolower(trim($usuariosis["tipousuario"]))) {		
					case "supervisor":
						if (in_array(strtolower(trim($usuariosis["podever"])),["tudo","personalizado"])) {
							$cmdsql = "select " . implode(",",$campos). " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario='VENDEDOR'"  . " ORDER BY 1";
						} else {
							$cmdsql = "select " . implode(",",$campos). " from ". VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario = 'VENDEDOR' AND codsupervisor = " . $usuariosis["codusuariosis"] . " or codusuariosis = " . $usuariosis["codusuariosis"] . " ORDER BY 1";
						}
						break;
					case "interno":
						switch(strtolower(trim($usuariosis["podever"]))){
							case "tudo":
								$cmdsql = "select " . implode(",",$campos). " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario='VENDEDOR'"  . " ORDER BY 1";
								break;
							default:
								$cmdsql = "select " . implode(",",$campos). " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario='VENDEDOR' AND CODFILIAL = " . $usuariosis["codfilial"] . " ORDER BY 1";
								break;
						}
						break;
					case "fornecedor":
						$cmdsql = "select " . implode(",",$campos). " from " . VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario='VENDEDOR' ";
						if (isset($usuariosis["codfilial"]) && $usuariosis["codfilial"] !== null && strlen($usuariosis["codfilial"]) > 0) {
							$cmdsql .= " AND CODFILIAL = " . $usuariosis["codfilial"] . " ";
						}
						$cmdsql .= " ORDER BY 1";
						break;
					case "vendedor":
					default:
						$cmdsql = "select " . implode(",",$campos). " from " .  VariaveisSql::getInstancia()->getPrefixObjects() . "usuariosis where tipousuario = 'VENDEDOR' AND codusuariosis = " . $usuariosis["codusuariosis"] . " ORDER BY 1";
						break;
						
				}
				$params_exec = [
					"query" => $cmdsql,
					"fetch" => "fetchAll",
					"fetch_mode" => ($associativo === true?\PDO::FETCH_ASSOC:\PDO::FETCH_NUM)
				];				
				$acessiveis = FuncoesSql::getInstancia()->executar_sql($params_exec);
				if (!$array_multi_dimens) {
					foreach($acessiveis as &$lin) {
						$lin = implode(";",$lin);
					}
				}				
			}
			return $acessiveis;
		}

		public static function criar_arquivo_recurso(&$comhttp,&$params) {
			$name_space = str_ireplace(trim(NomesCaminhosDiretorios::raiz) . DIRECTORY_SEPARATOR,"",trim(pathinfo($params["caminho_recurso"])["dirname"]));
			$name_space = substr($name_space,1);
			$name_space = str_replace("\\\\","\\",$name_space);
			$params["caminho_recurso"] = $params["caminho_recurso"];											
			$conteudo = FuncoesArquivo::ler_arquivo(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis("base_html_recurso"));
			$conteudo = str_ireplace("__NAME_SPACE__",$name_space,$conteudo);
			$params["bloco_use"] = $params["bloco_use"] ?? "";
			$params["bloco_use"] = str_replace("\\\\","\\",$params["bloco_use"]);
			$conteudo = str_ireplace("__BLOCO_USE__",$params["bloco_use"],$conteudo);
			$caminho_rec = str_replace(["/","\\\\"],"\\",$params["caminho_recurso"]);
			$conteudo = str_ireplace('__CONTEUDOHTML__',$params["conteudo_html"],$conteudo);
			FuncoesArquivo::criar_arquivo($comhttp,$params["caminho_recurso"],$conteudo,true);
		}


		public static function criar_arquivo_tabela_html(&$comhttp){
			$nomearq = "tab" . $_SESSION["codusur"] . str_replace("/","",FuncoesData::dataBR()) . rand() . ".html";	
			$caminho = NomesCaminhosDiretorios::raiz_arquivos_html . DIRECTORY_SEPARATOR . $nomearq;
			while(file_exists($caminho)) {
				$nomearq = "tab" . $_SESSION["codusur"] . str_replace("/","",FuncoesData::dataBR()) . rand() . ".html";
				$caminho = NomesCaminhosDiretorios::raiz_arquivos_html . DIRECTORY_SEPARATOR . $nomearq;		
			}
			$params_criar = [];
			$params_criar["caminho_recurso"] = $caminho;
			$params_criar["conteudo_html"] = $comhttp->requisicao->requisitar->qual->condicionantes["valor"];
			self::criar_arquivo_recurso($comhttp,$params_criar);
			$protocolo = "http://";
			$porta = "";
			$host = "www.jumboalimentos.com.br/redir=";
			$link = $protocolo . $host . $porta . "/arquivos/html/" . $nomearq;	
			$comhttp->retorno->dados_retornados["dados"]["link"] = $link;
		}

		public static function compartilhar_tabela(&$comhttp){
			$paramsms = [];
			switch(strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["tipo_arquivo"]))) {
				case "html":
					self::criar_arquivo_tabela_html($comhttp);
					$comhttp->requisicao->requisitar->qual->condicionantes["compartilhar_por"] = $comhttp->requisicao->requisitar->qual->condicionantes["compartilhar_por"]??[1];
					$numeros = $comhttp->requisicao->requisitar->qual->condicionantes["compartilharcom"];
					if ($numeros === "obter_link") {
						$comhttp->retorno->dados_retornados["conteudo_html"] = $comhttp->retorno->dados_retornados["dados"]["link"];
					} else {
						$msg = "Sisjd: Link de acesso a tabela compartilhada: " . $comhttp->retorno->dados_retornados["dados"]["link"];
					
						//$msg = trim($comhttp->retorno->dados_retornados["dados"]["link"]);
						$numeros = explode(",",$numeros);
						if (in_array(0,$comhttp->requisicao->requisitar->qual->condicionantes["compartilhar_por"])) {				
							include_once($GLOBALS["sjd"]["nca"]["enviar_sms"]);
							foreach($numeros as $chave_num => &$num) {
								$paramsms[$chave_num] = [];
								$paramsms[$chave_num]["phoneNumber"] = $num;
								$paramsms[$chave_num]["msg"] = $msg;
							}			
							$comhttp->retorno->dados_retornados["conteudo_html"] = enviar_sms($paramsms);
						} else if (in_array(1,$comhttp->requisicao->requisitar->qual->condicionantes["compartilhar_por"])) {
							include_once($GLOBALS["sjd"]["nca"]["enviar_whatsapp"]);
							foreach($numeros as $chave_num => &$num) {
								if (!is_numeric($num)) {
									$cmdsql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "gruposmsgs where trim(lower(nomegrupomsg)) = '" . strtolower(trim($num)) . "' and codusur = " . $_SESSION["codusur"];
									$grupo = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetch",\PDO::FETCH_ASSOC);
									if (count($grupo) > 0) {
										$cmdsql = "select * from " . VariaveisSql::getInstancia()->getPrefixObjects() . "integgrupomsg where codgrupomsg = " . $grupo["codgrupomsg"];
										$integrantes = FuncoesSql::getInstancia()->executar_sql($cmdsql,"fetchAll",\PDO::FETCH_ASSOC);
										if (count($integrantes) > 0) {
											if (strlen(trim($grupo["textopadrao"])) > 0) {
												$msgtemp = $grupo["textopadrao"] . " " . $comhttp->retorno->dados_retornados["dados"]["link"];
											} else {
												$msgtemp = $msg;
											}
											$chavetemp = count($paramsms);
											foreach($integrantes as $integr) {
												$paramsms[$chavetemp] = [];
												$paramsms[$chavetemp]["phone"] = $integr["fone_usuario"];
												$paramsms[$chavetemp]["text"] = $msgtemp;
												$chavetemp ++;
											}
										} else {
											FuncoesBasicasRetorno::mostrar_msg_sair("impossivel prosseguir, grupo vazio: " . $grupo["nomegrupomsg"],__FILE__,__FUNCTION__,__LINE__);
										}
									} else {
										FuncoesBasicasRetorno::mostrar_msg_sair("impossivel prosseguir, grupo nao encontrado: " . $num,__FILE__,__FUNCTION__,__LINE__);
									}
								} else {
									$paramsms[$chave_num] = [];
									$paramsms[$chave_num]["phone"] = $num;
									$paramsms[$chave_num]["text"] = $msg;
								}
							}			
							$comhttp->retorno->dados_retornados["conteudo_html"] = enviar_whatsapp($paramsms);
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair("opcao compartilhar_por nao programado: " . $comhttp->requisicao->requisitar->qual->condicionantes["compartilhar_por"],__FILE__,__FUNCTION__,__LINE__);
						}
					}
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo arquivo nao programado: " . $comhttp->requisicao->requisitar->qual->condicionantes["tipo_arquivo"],__FILE__,__FUNCTION__,__LINE__);
					break;		
			}
		}

		public static function compartilhar(&$comhttp){
			switch(strtolower(trim($comhttp->requisicao->requisitar->qual->tipo_objeto))) {
				case "tabela":
					self::compartilhar_tabela($comhttp);		
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("tipo objeto nao programado: " . $comhttp->requisicao->requisitar->qual->tipo_objeto,__FILE__,__FUNCTION__,__LINE__);
					break;		
			}
		}

		public static function rcas_sinergia( $usuariosis ) {
			$rcas_sinergia = [];
			if (Constantes::getInstancia()::$rcas_sinergia !== null) {
				$rcas_sinergia = Constantes::getInstancia()::$rcas_sinergia;		
			} else {		
				$rcas_acessiveis = self::getInstancia()->obter_usuarios_acessiveis($usuariosis,["codusuariosis"],false,false);
				if (count($rcas_acessiveis) > 0) {			
					$comando_sql = "select distinct codentidade from sjdobjetivossinergia where lower(trim(entidade)) = 'rca' and codentidade in (".implode(",",$rcas_acessiveis).") order by 1";
					$rcas_sinergia = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN,0);
					Constantes::getInstancia()::$rcas_sinergia = $rcas_sinergia;
				}
			}
			return $rcas_sinergia;
		}

		public static function obter_entidades_objetivos($codcampanhasinergia,$unidade,$data_periodo1, $data_periodo2, $cnj_criterios_acesso = []){
			$retorno = null;
			$comando_sql = "select distinct lower(trim(entidade)) as entidade from sjdobjetivossinergia where ";
			$comando_sql .= " codcampanhasinergia = $codcampanhasinergia";
			$comando_sql .= " and lower(trim(unidade)) = lower(trim('$unidade'))";
			$comando_sql .= " and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
			if (count($cnj_criterios_acesso) > 0) {
				$comando_sql .= " and " . implode(" and " , $cnj_criterios_acesso);
			}
			$retorno = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN,0);
			return $retorno;
		}


		/**
			* Função para retornar a lista de codigos rcas da(s) filial(is) passada(s) como parametro
			*
			* @author Antonio Alencar Velozo
			* @version 1.0		
			* @param [string,integer,array of string,array of integer] $codfilial o(s) codigo(s) da(s) filial(is)
			* @return array $rcas_filial os codigos dos rcas da(s) filial(is)		
		*/
		public static function obter_codscampestr_acessiveis_usuario($comhttp){				
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"])) {
				$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
				$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
				$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
				$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
				$dtini = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
				$dtfim = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
				$dtfim = FuncoesData::UltDiaMes($dtfim);	
			} else {
				$dtini = FuncoesData::data_primeiro_dia_mes_atual(FuncoesData::dataBr());
				$dtfim = FuncoesData::UltDiaMes(FuncoesData::dataBr());
			}
			$comando_sql = "select * from sjdcampestr where dtini between '$dtini' and '$dtfim' ";
			$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql);
			$condicionantes_campanha = "";
			$codscamp_com_acesso = [];
			$rcas = [];
			$tem_filtro = false;
			$tem_restricao_acesso = false;
			if (count($dados_campanhas) > 0) {
				$codsusur_subordinados = [];
				$codsusur_filial = [];
				if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) === 30) {
					$tem_restricao_acesso = true;
					$codsusur_filial = FuncoesSisJD::obter_usuarios_filial($_SESSION["usuariosis"]["codfilial"]);			
					foreach ($codsusur_filial as $codusur) {
						$rcas[] = $codusur;
					}
				}
				if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) === 40) {
					$tem_restricao_acesso = true;
					$codsusur_subordinados = FuncoesSisJD::obter_usuarios_subordinados(FuncoesConversao::como_numero($_SESSION["usuariosis"]["codusuariosis"]));
					foreach ($codusur_subordinados as $codusur) {
						$rcas[] = $codusur;
					}
				}
				if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) >= 50) {
					$tem_restricao_acesso = true;
					$rcas = [$_SESSION["usuariosis"]["codusuariosis"]];
				}
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
					$filial = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["filial"]);	
					if (count($filial) > 0) {				
						$filial = FuncoesConversao::como_numero($filial);
						foreach($filial as $fil) {
							$rcas_temp = FuncoesSisJD::obter_usuarios_filial($fil);
							if ($tem_restricao_acesso === true) {
								$rcas_temp2 = [];
								foreach ($rcas as $rca) {
									if (in_array($rca,$rcas_temp)) {
										$rcas_temp2[] = $rca;
									}
								}
								$rcas = $rcas_temp2;
							} else {
								foreach($rcas_temp as $rcat) {
									$rcas[] = $rcat;
								}
							}
						}
						$tem_filtro = true;
					}
				}		
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
					$supervisor = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);	
					if (count($supervisor) > 0) {				
						$supervisor = FuncoesConversao::como_numero($supervisor);			
						foreach($supervisor as $superv) {
							$rcas_temp = FuncoesSisJD::obter_usuarios_subordinados($superv);
							if ($tem_restricao_acesso === true || $tem_filtro === true) {
								$rcas_temp2 = [];
								foreach($rcas as $rca) {
									if (in_array($rca,$rcas_temp)) {
										$rcas_temp2[] = $rca;
									}
								}
								$rcas = $rcas_temp2;
							} else {
								foreach($rcas_temp as $rcat) {
									$rcas[] = $rcat;
								}
							}
						}
						$tem_filtro = true;
					}
				}
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {		
					$rcas_temp = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["rca"]);	
					if (count($rcas_temp) > 0) {				
						$rcas_temp = FuncoesConversao::como_numero($rcas_temp);			
						if ($tem_restricao_acesso === true || $tem_filtro === true) {
							$rcas_temp2 = [];
							foreach($rcas as $rca) {
								if (in_array($rca,$rcas_temp)) {
									$rcas_temp2[] = $rca;
								}
							}
							$rcas = $rcas_temp2;
						} else {
							$rcas = $rcas_temp;
						}
						$tem_filtro = true;
					}
				}
				while($campanha = $dados_campanhas["result"]->fetch(\PDO::FETCH_ASSOC) ) {
					if (in_array(gettype($campanha["condicionantes"]),["object","resource"])) {
						$condicionantes_campanha = stream_get_contents($campanha["condicionantes"]);
					} else {
						$condicionantes_campanha = $campanha["condicionantes"];
					}
					$condicionantes_campanha = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($condicionantes_campanha)));
					if (count($condicionantes_campanha) > 0) {
						foreach ($condicionantes_campanha as $condicionante) {
							$condicionante = explode(strtolower(trim(Constantes::sepn2)),strtolower(trim($condicionante)));
							if (count($condicionante) > 0) {
								foreach ($condicionante as $condic) {
									$sinal_condicionante = "";
									if (strpos($condic,"!=") !== false) {
										$sinal_condicionante = "!=";
										$condic = explode($sinal_condicionante,$condic);
									} else if (strpos($condic,"=") !== false){
										$sinal_condicionante = "=";
										$condic = explode($sinal_condicionante,$condic);
									} else {
										echo $condic;
										FuncoesBasicasRetorno::mostrar_msg_sair("sinal da condicionante nao esperada",__FILE__,__FUNCTION__,__LINE__);
									}
									if (strcasecmp(trim($condic[0]),"rca") == 0) {
										if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) === 50) {
											if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codusuariosis"]) === FuncoesConversao::como_numero($condic[1]) && $sinal_condicionante === "=") {
												if ($tem_filtro === true) {
													if (in_array(FuncoesConversao::como_numero($condic[1]),$rcas)) {
														$codscamp_com_acesso[] = $campanha["codcampestr"];
													}
												} else {
													$codscamp_com_acesso[] = $campanha["codcampestr"];
												}
											}
										} else if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) === 40) {
											if (in_array(FuncoesConversao::como_numero($condic[1]),$codsusur_subordinados) && $sinal_condicionante === "=") {
												if ($tem_filtro === true) {
													if (in_array(FuncoesConversao::como_numero($condic[1]),$rcas)) {
														$codscamp_com_acesso[] = $campanha["codcampestr"];
													}
												} else {									
													$codscamp_com_acesso[] = $campanha["codcampestr"];
												}
											}
										} else if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) === 30) {									
											if (in_array(FuncoesConversao::como_numero($condic[1]),$codsusur_filial) && $sinal_condicionante === "=") {
												if ($tem_filtro === true) {
													if (in_array(FuncoesConversao::como_numero($condic[1]),$rcas)) {
														$codscamp_com_acesso[] = $campanha["codcampestr"];
													}
												} else {
													$codscamp_com_acesso[] = $campanha["codcampestr"];
												}
											}
										} else if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) < 30) {
											if ($tem_filtro === true) {
												if (in_array(FuncoesConversao::como_numero($condic[1]),$rcas)) {
													$codscamp_com_acesso[] = $campanha["codcampestr"];
												}
											} else {
												$codscamp_com_acesso[] = $campanha["codcampestr"];
											}
										}
									}								
								}
							}
						}
					}
				}				
				FuncoesSql::getInstancia()->fechar_cursor($dados_campanhas);
			}
			return $codscamp_com_acesso;
		}

		/**
			* Função para retornar a lista de codigos rcas da(s) filial(is) passada(s) como parametro
			* @param [string,integer,array of string,array of integer] $codfilial o(s) codigo(s) da(s) filial(is)
			* @return array $rcas_filial os codigos dos rcas da(s) filial(is)		
		*/
		public static function obter_rcas_filial_jumbo( $codfilial ){				
			$rcas_filial = [] ;
			$cmd_sql="";
			$cmd_sql="select codusur from jumbo.pcusuari where codfilial in ($codfilial) order by 1";	
			$rcas_filial = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchAll",\PDO::FETCH_COLUMN,0); 
			return $rcas_filial;
		}

		public static function obter_cods_rcas_acessiveis(){
			$retorno = [];
			if (isset($_SESSION["cods_usuarios_acessiveis"]) && gettype($_SESSION["cods_usuarios_acessiveis"]) === "array" && $_SESSION["cods_usuarios_acessiveis"] !== null && count($_SESSION["cods_usuarios_acessiveis"]) > 0) {
				$retorno = $_SESSION["cods_usuarios_acessiveis"];
			} else {
				if (isset($_SESSION["usuarios_acessiveis"])) {
					foreach($_SESSION["usuarios_acessiveis"] as $key=>$usuariosis) {
						$retorno[] = $usuariosis["codusuariosis"];
					}	
				}
			}
			return $retorno;
		}


		/**
			* Função para retornar a lista de codigos rcas da(s) filial(is) passada(s) como parametro
			* @param [string,integer,array of string,array of integer] $codsupervisor o(s) codigo(s) do(s) supervisor(es)
			* @return array $rcas_supervisor os codigos dos rcas do(s) supervisor(es)		
		*/
		public static function obter_rcas_supervisor_jumbo( $codsupervisor ){				
			$rcas_supervisor = [] ;
			$cmd_sql="select codusur from jumbo.pcusuari";
			if (isset($codsupervisor) && $codsupervisor !== null) {
				if (gettype($codsupervisor) === "array") {
					$codsupervisor = implode(",",$codsupervisor);
				}
				$cmd_sql .= " where codsupervisor in ($codsupervisor)";
			}
			$cmd_sql .= " order by 1";	
			$rcas_supervisor = FuncoesSql::getInstancia()->executar_sql($cmd_sql,"fetchAll",\PDO::FETCH_COLUMN,0); 
			return $rcas_supervisor;
		}


		public static function dados_sqlws(&$comhttp){
			/*Objetivo: identificar e retornar os dados sql conforme solicitado, como array*/
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			//echo $comhttp->requisicao->requisitar->qual->codusur; exit();
			$_SESSION["codusur"] = $comhttp->requisicao->requisitar->qual->codusur;
			$comhttp->requisicao->sql=new TSql($comhttp);	
			$comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"] = $comhttp->requisicao->requisitar->qual->condicionantes["campos_avulsos"] ?? [];
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] ?? 2;
			$comhttp->requisicao->requisitar->qual->condicionantes["def_tipo_campos"] = $comhttp->requisicao->requisitar->qual->condicionantes["def_tipo_campos"] ?? "sql";
			$comhttp->requisicao->requisitar->qual->condicionantes["pivot"] = $comhttp->requisicao->requisitar->qual->condicionantes["pivot"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = $comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["html_entities"] = $comhttp->requisicao->requisitar->qual->condicionantes["html_entities"] ?? false;
			$comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] = $comhttp->requisicao->requisitar->qual->condicionantes["tipo_dados"] ?? "tabelaest";
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"]);
			$opcoes=[];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codligprocesso"]) || isset($comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"])) {
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"])) {
					$codprocesso = $comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"];
				} else {
					$codprocesso = $comhttp->requisicao->requisitar->qual->condicionantes["codligprocesso"];
					$comhttp->requisicao->requisitar->qual->condicionantes["codprocesso"] = $codprocesso;
				}
				$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
				$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];					
				$comhttp->opcoes_retorno["usar_arr_tit"] = true;
				$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
				$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);		
				FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp);
				$opcoes = FuncoesSql::getInstancia()->obter_opcoes_dados_sql(["condic"=>"codprocesso=" . $codprocesso,"unico"=>true]);
				if ($opcoes !== null && isset($opcoes["opcoes"])) {
					eval($opcoes["opcoes"]);
				} else {
					$opcoes = FuncoesHtml::opcoes_tabela_est;
				}
				$opcoes["tipoelemento"] = $opcoes["tipoelemento"] ?? "tabela_est";
				$comhttp->requisicao->requisitar->qual->condicionantes["tipo_retorno"] = $opcoes["tipoelemento"];				
			} else {
				switch(strtolower(trim($comhttp->requisicao->requisitar->qual->objeto))){
					case "lista produtos estoque":
						FuncoesMontarSql::montar_sql_consulta_estoque($comhttp);
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;		
					case "lista_produtos_completa":
						FuncoesMontarSql::montar_sql_consulta_lista_produtos_completa($comhttp);
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;
					case "lista_volumes":				
						FuncoesMontarSql::montar_sql_consulta_lista_volumes($comhttp);						
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;
					case "lista_volumes_x_meta":				
						FuncoesMontarSql::montar_sql_consulta_lista_volumes_x_meta($comhttp);						
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;
					case "lista_desvios_volume":				
						FuncoesMontarSql::montar_sql_consulta_lista_desvios_volume($comhttp);						
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;
					case "lista_positivacao_cliente":				
						FuncoesMontarSql::montar_sql_consulta_lista_positivacao_cliente($comhttp);
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;
					case "lista_clientes_rca":
						FuncoesMontarSql::montar_sql_consulta_lista_clientes_rca($comhttp);
						FuncoesMontarRetorno::montar_retorno_dados_sqlws($comhttp,["fetch_mode"=>\PDO::FETCH_NUM]);
						break;				
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair("Erro na requisicao de dados sql: relatorio não definido: ".$comhttp->requisicao->requisitar->qual->objeto,__FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
			return ;
		}

		public static function atualizar_realizado_objetivos_sinergia_mes_anterior(&$comhttp){
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
				$datas = explode(",",$datas);
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[0]));
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[1]));
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual($datas[0]);
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = FuncoesData::ano_atual($datas[1]);
			} else {
				$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = FuncoesData::data_primeiro_dia_mes_anterior().",".FuncoesData::data_ultimo_dia_mes_anterior();
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual(FuncoesData::data_primeiro_dia_mes_anterior()));
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = FuncoesData::MesTexto(FuncoesData::mes_atual(FuncoesData::data_primeiro_dia_mes_anterior()));
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual(FuncoesData::data_primeiro_dia_mes_anterior());
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = FuncoesData::ano_atual(FuncoesData::data_primeiro_dia_mes_anterior());
			}
			FuncoesMontarRetorno::montar_sinergia2($comhttp);
		}
		public static function atualizar_realizado_objetivos_sinergia(&$comhttp){
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
				$datas = explode(",",$datas);
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[0]));
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[1]));
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual($datas[0]);
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = FuncoesData::ano_atual($datas[1]);
			} else {
				$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = FuncoesData::data_primeiro_dia_mes_atual().",".FuncoesData::UltDiaMes();
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual());
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = $comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"];
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual();
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			}
			FuncoesMontarRetorno::montar_sinergia2($comhttp);
		}

		public static function atualizar_realizado_objetivos_campanhas_estruturadas(&$comhttp) {
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
				$datas = explode(",",$datas);
				$data_ini = $datas[0];
				$data_fim = $datas[1];
				$datas = [$data_ini,$data_fim];
			} else {		
				$data_ini = FuncoesData::data_primeiro_dia_mes_atual();
				$data_fim = FuncoesData::UltDiaMes($data_ini);
				$datas = [$data_ini,$data_fim];
			}
			$cnj_mostrar_vals_de = ["qt","un","kgun","kg","r\$un","r\$","mix"];
			$comando_sql = "select * from sjdobjetcampestr where dtini >= '$data_ini' and dtini <= '$data_fim'";
			$objetivos_atualizar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$codscampanhas = [];
			if (count($objetivos_atualizar) > 0) {
				foreach ($objetivos_atualizar as $objetivo) {
					$codscampanhas[$objetivo["codcampestr"]] = $objetivo["codcampestr"];
				}
				$comando_sql = "select * from sjdcampestr where codcampestr in (".implode(",",$codscampanhas).")";
				$cursor_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql);		
				$comhttp_temp = new TComHttp();
				while($camp = $cursor_campanhas["result"]->fetch(\PDO::FETCH_ASSOC) ) {
					if (in_array(gettype($camp["condicionantes"]),["object","resource"])) {
						$condicionantes_campanha = stream_get_contents($camp["condicionantes"]);
					} else {
						$condicionantes_campanha = $camp["condicionantes"];
					}					
					$datas_camp = [$camp["dtini"],$camp["dtfim"]];
					foreach ($objetivos_atualizar as $objet) {
						if (FuncoesConversao::como_numero($objet["codcampestr"]) === FuncoesConversao::como_numero($camp["codcampestr"])) {
							$unidade = strtolower(trim($objet["unidade"]));
							$visao = strtolower(trim($objet["visao"]));
							if (strlen($unidade) > 0) {
								if (strlen($visao) === 0) {
									$visao = strtolower(trim($camp["visao"]));
									if (strlen($visao) === 0) {
										$visao = "produto";
									}
								}
								$mostrar_vals_de = array_search($unidade,$cnj_mostrar_vals_de);
								if ($mostrar_vals_de === 6) {
									$mostrar_vals_de = array_search("kg",$cnj_mostrar_vals_de);
								}
								$comhttp_temp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
								$comhttp_temp->requisicao->requisitar->qual->objeto = $comhttp_temp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] . $visao;
								$comhttp_temp->requisicao->requisitar->qual->condicionantes["datas"] = implode(",",$datas_camp); 
								$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condicionantes_campanha;
								$comhttp_temp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = explode(",",$mostrar_vals_de);
								$comhttp_temp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"] = [0,1,2];						
								FuncoesSisJD::setar_criterios_globais_existencia($comhttp_temp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"],$comhttp_temp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"],false);						
								$comhttp_temp->opcoes_retorno["usar_arr_tit"] = true;
								$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp);
								$dados_realizado = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
								$realizado = 0;
								if (count($dados_realizado) > 0) {
									if ($unidade !== "mix") {					
										$indrealizado = array_keys($dados_realizado[0]);
										$indrealizado = $indrealizado[count($indrealizado) -1];
										foreach($dados_realizado as $linha) {							
											$realizado += (str_replace(",",".",str_replace(".","",trim($linha[$indrealizado]))) * 1);
										}
									} else {
										$realizado = count($dados_realizado);
									}
								}
								$comando_sql = "update sjdobjetcampestr set realizado = $realizado where codobjetcampestr = " . $objet["codobjetcampestr"];
								FuncoesSql::getInstancia()->executar_sql($comando_sql); 
								$comando_sql = "commit";
								FuncoesSql::getInstancia()->executar_sql($comando_sql);
								}
						}
					}		
				}
				FuncoesSql::getInstancia()->fechar_cursor($cursor_campanhas);
			}
		}

		public static function atualizar_realizado_objetivos_campanhas_estruturadas_mes_anterior (&$comhttp){
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
				$datas = explode(",",$datas);
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[0]));
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = FuncoesData::MesTexto(FuncoesData::mes_atual($datas[1]));
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual($datas[0]);
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = FuncoesData::ano_atual($datas[1]);
			} else {
				$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = FuncoesData::data_primeiro_dia_mes_anterior().",".FuncoesData::data_ultimo_dia_mes_anterior();
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"] = FuncoesData::MesTexto(FuncoesData::mes_atual(FuncoesData::data_primeiro_dia_mes_anterior()));
				$comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"] = FuncoesData::MesTexto(FuncoesData::mes_atual(FuncoesData::data_primeiro_dia_mes_anterior()));
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"] = FuncoesData::ano_atual(FuncoesData::data_primeiro_dia_mes_anterior());
				$comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"] = FuncoesData::ano_atual(FuncoesData::data_primeiro_dia_mes_anterior());
			}
			self::atualizar_realizado_objetivos_campanhas_estruturadas($comhttp);
		}

		public static function gerar_hist($codobjetivosinergia, $data, $valor){	
			$comando_sql = "select count(1) as qt from sjdevolobjetsinergia where codobjetivosinergia = " . $codobjetivosinergia . " and trunc(data) = '" . $data . "'";
			$dado_gerar_hist = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if ($dado_gerar_hist[0]["qt"] === "0" || $dado_gerar_hist[0]["qt"] === 0) {
				$comando_sql_insert = "insert into sjdevolobjetsinergia values (" . $codobjetivosinergia . ",'" . $data . "',".$valor.")";
				FuncoesSql::getInstancia()->executar_sql($comando_sql_insert);
			} else {
				$comando_sql_update = "update sjdevolobjetsinergia set realizado = ".$valor." where codobjetivosinergia = " . $codobjetivosinergia . " and trunc(data) = '" . $data . "'";
				FuncoesSql::getInstancia()->executar_sql($comando_sql_update);											
			}	
		}

		public static function gerar_historico_objetivos_sinergia(&$comhttp) {
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes["datas"]); exit();
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"]) && $comhttp->requisicao->requisitar->qual->condicionantes["datas"] !== null) {
				$datas = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["datas"]);
			} else {
				$datas = [
					FuncoesData::modificar_data(FuncoesData::dataBR(),'-3 days'),
					FuncoesData::dataBR()
				];
				$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = implode(",",$datas);
			}
			$data_periodo1 = $datas[0];
			$data_periodo2 = $datas[1];
			$primeiro_dia_data_periodo_1 = "01" . substr(FuncoesData::dataBR($data_periodo1),2);
			$intervalo_dias = FuncoesData::diferenca_datas($data_periodo1,$data_periodo2);
			$i = 0;
			$array_datas_dias = [];
			$data1 = $data_periodo1;
			$data1 = FuncoesData::dataBR($data1);
			/*separa as datas do inicio ao fim em array de datas de dia a dia */
			for($i = 0; $i <= $intervalo_dias; $i++) {
				$primeiro_dia_mes_atual = FuncoesData::data_primeiro_dia_mes_atual($data1);
				$array_datas_dias[] = [$primeiro_dia_mes_atual,$data1];		
				$data1 = new \DateTime(FuncoesData::dataUSA($data1));
				$data1->add(new \DateInterval('P1D'));
				$data1 = FuncoesData::dataBR($data1);
			}
			//print_r($array_datas_dias); exit();
			
			/*percorre o array de dias gerando o historico para cada dia*/
			foreach($array_datas_dias as $datas_dias) {
				$comando_sql = "select * from sjdcampanhassinergia where dtfim >= to_date('" . $datas_dias[1] . "','dd/mm/yyyy')";	
				$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
				if (count($dados_campanhas) > 0) {
					$comhttp_temp = new TComHttp();
					$nometabela_objetivos = "sjdobjetivossinergia";
					$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
					foreach ($dados_campanhas as $linha_campanha) {
						$visoes_entidades_objetivos_campanha = FuncoesSisJD::obter_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$primeiro_dia_data_periodo_1,$datas_dias[1]);				
						if (strtolower(trim($linha_campanha["unidade"])) === "mix") {					
							if (isset($visoes_entidades_objetivos_campanha) && $visoes_entidades_objetivos_campanha !== null && count($visoes_entidades_objetivos_campanha) > 0) {
								foreach($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
									$visoes_objetivos_sinergia = FuncoesSisJD::obter_visoes_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$primeiro_dia_data_periodo_1,$datas_dias[1]);
									foreach($visoes_objetivos_sinergia as $visao_objet_sin){
										$comhttp_temp->requisicao->requisitar->qual->objeto=$visao_entidades_objetivos. "," . $visao_objet_sin;
										$comhttp_temp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp_temp->requisicao->requisitar->qual->objeto);
										$comhttp_temp->requisicao->requisitar->qual->condicionantes["datas"] = $datas_dias[0] . "," . $datas_dias[1];
										$comhttp_temp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3]; //3=peso total;
										$GLOBALS["considerar_vendas_normais"] = true;
										$GLOBALS["considerar_devolucoes_vinculadas"] = true;
										$GLOBALS["considerar_devolucoes_avulsas"] = true;
										$GLOBALS["considerar_bonificacoes"] = false;
										$GLOBALS["ver_vals_qttotal"] = false;
										$GLOBALS["ver_vals_un"] = false;
										$GLOBALS["ver_vals_pesoun"] = false;
										$GLOBALS["ver_vals_pesotot"] = true;
										$GLOBALS["ver_vals_valorun"] = false;
										$GLOBALS["ver_vals_valortot"] = false;
										$GLOBALS["considerar_grupos_produtos"] = true;
										$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"relatorio_venda");								
										$dados_atingimento = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
										$dados_atingimento_agrupados = [];
										if (strtolower(trim($visao_objet_sin)) === "produto") {
											$produtos_por_entidade = [];
											foreach ($dados_atingimento as $linha_atingimento) {
												/*obtem todos os produtos que ha objetivo por entidade*/
												if (!isset($dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {
													$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] = 0;
													$comando_sql_temp = "select distinct coditemvisao from sjdobjetivossinergia where lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) ";
													$comando_sql_temp .= " and codentidade = " . $linha_atingimento[array_keys($linha_atingimento)[0]];
													$comando_sql_temp .= " and lower(trim(visao)) = lower(trim('$visao_objet_sin'))";
													$comando_sql_temp .= " and lower(trim(unidade)) != lower(trim('mix')) ";//nao usa a unidade da linha_campanha porque o objetivo eh obter todos os produtos que tem meta, que geralmente eh em kg ou un
													$comando_sql_temp .= " and coditemvisao is not null "; //nao obtem linhas cujos coditemvisao nao estejam estabelecidos
													$comando_sql_temp .= " and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
													$produtos_por_entidade[$linha_atingimento[array_keys($linha_atingimento)[0]]] = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);//, false, false, false);
												}										
												/*somente soma no atingimento se o produto fazer parte da meta do rca, senao nao*/
												if (in_array($linha_atingimento[array_keys($linha_atingimento)[2]],$produtos_por_entidade[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {
													$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] ++;
												}
											}
										} else {
											foreach ($dados_atingimento as $linha_atingimento) {
												if (!isset($dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {
													$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] = 0;
												}
												$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] ++;
											}
										}
										$comando_sql = "";
										$comando_sql_update = "";
										$comando_sql_insert = "";
										
										if (isset($dados_atingimento_agrupados) && $dados_atingimento_agrupados !== null && count($dados_atingimento_agrupados) > 0) {							
											/*atualiza as entidades que nao tiveram vendas para 0 (not in)*/
											$entidades = implode(",",array_keys($dados_atingimento_agrupados));									
											$comando_sql =  "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade not in ($entidades) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
											$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
											foreach($dados_zerar as $codobjetivosinergia_zerar) {
												self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
											}									
											foreach ($dados_atingimento_agrupados as $chave=>$atingimento) {
												/*atualiza cada linha conforme a entidade*/
												$comando_sql = "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
												$dados_gerar_hist = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
												foreach($dados_gerar_hist as $codobjetivosinergia_atualizar) {
													self::gerar_hist($codobjetivosinergia_atualizar["codobjetivosinergia"], $datas_dias[1], $atingimento);
												}
											}									
										} else {
											/*se nao houver dados de venda, atualiza todos para 0 no periodo*/
											$comando_sql = "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
											$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
											foreach($dados_zerar as $codobjetivosinergia_zerar) {
												self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
											}									
										}								
									}
								}
							}
						} else {
							foreach ($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
								$visoes_objetivos_sinergia = FuncoesSisJD::obter_visoes_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$primeiro_dia_data_periodo_1,$datas_dias[1]);
								foreach ($visoes_objetivos_sinergia as $visao_objet_sin) {
									$comhttp_temp->requisicao->requisitar->qual->objeto=$visao_entidades_objetivos. "," . $visao_objet_sin;
									$comhttp_temp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp_temp->requisicao->requisitar->qual->objeto);
									$comhttp_temp->requisicao->requisitar->qual->condicionantes["datas"] = $datas_dias[0] . "," . $datas_dias[1];
									$comhttp_temp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3]; //3=peso total;
									$GLOBALS["considerar_vendas_normais"] = true;
									$GLOBALS["considerar_devolucoes_vinculadas"] = true;
									$GLOBALS["considerar_devolucoes_avulsas"] = true;
									$GLOBALS["considerar_bonificacoes"] = false;
									$GLOBALS["ver_vals_qttotal"] = false;
									$GLOBALS["ver_vals_un"] = false;
									$GLOBALS["ver_vals_pesoun"] = false;
									$GLOBALS["ver_vals_pesotot"] = true;
									$GLOBALS["ver_vals_valorun"] = false;
									$GLOBALS["ver_vals_valortot"] = false;
									$GLOBALS["considerar_grupos_produtos"] = true;							
									$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"relatorio_venda");
									$dados_atingimento = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
									$nome_campo_visao_item = "codprod"; //decidir em função da visao;
									$nome_campo_valor_realizado = "pesototal_0";
									$dados_atingimento_agrupados = [];
									foreach ($dados_atingimento as $linha_atingimento) {
										if (!isset($dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {
											$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] = [];
										}
										$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]][$linha_atingimento[$nome_campo_visao_item]] = $linha_atingimento[$nome_campo_valor_realizado];
									}

									$comando_sql_update = "";
									$dados_atualizacao_grupos = [];
									
									if (count($dados_atingimento_agrupados) > 0) {
										
										/*atualiza os que nao fazem parte destas entidades (not in)*/
										$entidades = implode(",",array_keys($dados_atingimento_agrupados));
										$comando_sql =  "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade not in ($entidades) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
										$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
										foreach($dados_zerar as $codobjetivosinergia_zerar) {
											self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
										}
										foreach ($dados_atingimento_agrupados as $chave_entidade => $itens_atingimento) {									
											if (count($itens_atingimento) > 0) {
												
												/*atualiza as linha do objetivo dos produto da entidade que nao tem vendas (not in)*/
												$produtos = "'" . strtoupper(implode("','",array_keys($itens_atingimento))) . "'";
												$comando_sql =  "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave_entidade and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and upper(trim(coditemvisao)) not in ($produtos) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
												$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
												foreach($dados_zerar as $codobjetivosinergia_zerar) {
													self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
												}
												
												foreach($itens_atingimento as $chave_item_atingimento => $item_atingimento) {
													/*atualiza cada linha existente do produto */
													$comando_sql = "
													select 
														codobjetivosinergia, valor, percmaxating 
													from 
														sjdobjetivossinergia 
													where 
														codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . 
														" and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) 
														and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) 
														and codentidade = ".$chave_entidade."
														 and lower(trim(visao)) = lower(trim('$visao_objet_sin')) 
														 and upper(trim(coditemvisao)) = upper(trim('$chave_item_atingimento')) 
														 and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') 
														 	<= to_date('".$datas_dias[0]."','dd/mm/yyyy') 
														 and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) 
														 	>= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";													
													$dados_gerar_hist = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
													if ($dados_gerar_hist !== null) {
														if (count($dados_gerar_hist) > 1 ) {
															print_r($linha_campanha);
															print_r([$visao_entidades_objetivos,$chave_entidade,$visao_objet_sin,$chave_item_atingimento,$datas_dias]);
															print_r($linha_campanha);
															print_r($comando_sql);
															print_r($dados_gerar_hist);
															FuncoesBasicasRetorno::mostrar_msg_sair("comando sql retornou mais de uma linha quando so era esperado uma",__FILE__,__FUNCTION__,__LINE__);
														}
														foreach($dados_gerar_hist as $codobjetivosinergia_atualizar) {
															$realizado = FuncoesConversao::como_numero($item_atingimento);
															$percmaxating  = FuncoesConversao::como_numero($codobjetivosinergia_atualizar["percmaxating"]);
															$valor_objetivo  = FuncoesConversao::como_numero($codobjetivosinergia_atualizar["valor"]);
															if ($realizado > ($valor_objetivo * $percmaxating / 100)) {
																$realizado = $valor_objetivo * $percmaxating / 100;
															}
															self::gerar_hist($codobjetivosinergia_atualizar["codobjetivosinergia"], $datas_dias[1], $realizado);
														}
													}
												}
												
											} else {
												/*caso nao existam dados de vendas, atualiza todos os produtos da entidade para 0*/										
												$comando_sql =  "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave_entidade and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
												$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
												foreach($dados_zerar as $codobjetivosinergia_zerar) {
													self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
												}
												
											}
										}
									} else {
										/*caso nao existam entidades com vendas, atualiza todas as entidades para 0*/
										$comando_sql =  "select codobjetivosinergia from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') <= to_date('".$datas_dias[0]."','dd/mm/yyyy') and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy')) >= to_date('".$datas_dias[1] . "','dd/mm/yyyy')";
										$dados_zerar = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
										foreach($dados_zerar as $codobjetivosinergia_zerar) {
											self::gerar_hist($codobjetivosinergia_zerar["codobjetivosinergia"], $datas_dias[1], 0);
										}
									}
								}
							}
						}
					}						
				}
				/*comita somente a cada dia gerado, haja vista que pode ser muito demorado*/
				$comando_sql = "commit";
				FuncoesSql::getInstancia()->executar_sql($comando_sql);
			}
		}

		/**
		 * Obtem o codigo no erp em funcao do codigo do registro vindo da origem
		 * @project ERP
		 * @created 19/01/2021
		 */
		public static function getCodErpDaOrigem($tabelarel, $codorigeminfo,$valor_na_origem){
			$condicao_origem = "codnaorigem = $valor_na_origem";
			if (!FuncoesString::strTemValor($valor_na_origem)) {
				$condicao_origem = "codnaorigem is null";
			}
			$params = [
				"query"=>"
					select
						codnodestino,
						ignorar
					from
						ep.$tabelarel 
					where
						codorigeminfo = $codorigeminfo
						and $condicao_origem
				",
				"fetch"=>"fetch"
			];
			return FuncoesSql::getInstancia()->executar_sql($params);	
		}

		/**
		 * Obtem o codigo no erp em funcao do codigo do registro vindo da origem
		 * @project ERP
		 * @created 19/01/2021 
		 */
		public static function getCodCliErpDaOrigem($tabelarel, $codorigeminfo,$valor_na_origem){
			$condicao_origem = "p.coddocidentificador = $valor_na_origem";
			if (!FuncoesString::strTemValor($valor_na_origem)) {
				$condicao_origem = "p.coddocidentificador is null";
			}
			$params = [
				"query"=>"
					select
						t.codnodestino,
						t.ignorar
					from
						ep.$tabelarel t
						join ep.epcliente c on c.cod = t.codnodestino
						join ep.eppessoa p on p.cod = c.codpessoa
					where
						t.codorigeminfo = $codorigeminfo
						and $condicao_origem
				",
				"fetch"=>"fetch"
			];
			return FuncoesSql::getInstancia()->executar_sql($params);	
		}

		/**
		 * Trata uma data que vem nas tabelas de origem de informacoes, que podem vir em variados formatos
		 * @project ERP
		 * @created 19/01/2021 
		 * @todo implementar conforme os formatos forem aparecendo
		 */
		public static function tratarDataOrigem($codorigeminfo,$valor_na_origem){
			$retorno = null;
			$dt = $valor_na_origem;
			$formato = FuncoesData::detectar_formato($dt);
			$retorno = "to_date('$dt','$formato'";
			if (strpos($formato,"MON") !== false) {
				$retorno .= ",'NLS_DATE_LANGUAGE=''AMERICAN'''";
			}
			$retorno .= ")";
			return $retorno;
		}

		/**
		 * Obtem o cod(id) de uma nf de saida com base no nro da nota
		 * @project ERP
		 * @created 19/01/2021 
		 * @todo implementar
		 * 			query para buscar
		 */
		public static function getCodNfSaida($codorigeminfo,$nroNfSaida){
			$retorno = "";			
			return $retorno;
		}

		/**
		 * Obtem o cod(id) de uma nf de saida com base no nro da nota
		 * @project ERP
		 * @created 19/01/2021 
		 * @todo implementar
		 * 			query para buscar
		 */
		public static function comoNumeroSql($codorigeminfo,$valor){
			$retorno = $valor;
			$retorno = FuncoesConversao::como_numero($retorno);
			return $retorno;
		}

		public static function importar_devolucoes_aurora(&$comhttp){
			try {
				$caminho_arq = "\\\\192.168.2.42\\winthor\\AURORA\\DEVOLUCOES\\devolucoes.csv";
				$conteudo = FuncoesArquivo::ler_arquivo($caminho_arq,"array");
				$delimit_col = ";";
				if ($conteudo !== null && count($conteudo) > 0) {
					$titulos = $conteudo[0];
					array_shift($conteudo);
					//$titulos = str_replace(" "," ",$titulos);
					$titulos = FuncoesString::eliminarCaracteresEspeciais($titulos);
					$titulos = FuncoesString::transfhtmlentities($titulos);
					$titulos = explode($delimit_col,strtolower(trim($titulos)));

					/*obtem e indexa as colunas pelo nome do campo na origem*/
					$params = [
						"query"=>"
							select
								*
							from
								ep.eprelcolorigemdb
							where
								codorigeminfo = 1
								and lower(trim(nometabelanaorigem)) = lower(trim('devolucoes.csv'))
								and (
									lower(trim(nometabelanodestino)) in (
										lower(trim('EPNFBASE')),
										lower(trim('EPNFDEVCLI')),
										lower(trim('EPNFMOVBASE'))										
									) 
									or ignorar = 1
								)
						",
						"fetch"=>"fetchAll"												
					];
					$colunas_origem = FuncoesSql::getInstancia()->executar_sql($params);
					$colunas_temp = [];
					foreach($colunas_origem as $col) {
						$colunas_temp[
							strtolower(trim($col["codorigeminfo"])) . "-" 
								.strtolower(trim($col["nometabelanaorigem"])) . "-" 
								.strtolower(trim($col["nomecamponaorigem"])) . "-"
								.strtolower(trim($col["nometabelanodestino"])) . "-" 
								.strtolower(trim($col["nomecamponodestino"])) . "-"
						] = $col;
					}
					$colunas_origem = $colunas_temp;

					$qtcampos = count($titulos);
					$valores_insert = [];
					$comandos_insert = [];
					foreach($conteudo as $linha) {
						$campos_insert = [];
						$valores_insert = [];
						$linha = explode($delimit_col,$linha);
						$ignorar = false;
						for($i = 0; $i < $qtcampos; $i++) {

							/*verifica se a coluna existe na tabela de relacionamento de campos da origem*/
							if (isset($colunas_origem[$titulos[$i]])) {

								/*se nao for para ignorar a coluna da origem*/ 
								if (!FuncoesConversao::como_boleano($colunas_origem[$titulos[$i]]["ignorar"])) {
									$nometab_dest = strtolower(trim($colunas_origem[$titulos[$i]]["nometabelanodestino"]));								
									/*verifica se tem transformacoes cadastradas a fazer*/
									if (isset($colunas_origem[$titulos[$i]])) {
										if (FuncoesString::strTemValor($colunas_origem[$titulos[$i]]["transformacoes"])) {
											$comando = $colunas_origem[$titulos[$i]]["transformacoes"];
											$comando = str_replace("__VALOR_NA_ORIGEM__",$linha[$i],$comando);
											$linha[$i] = eval($comando);
											if ($linha[$i] !== null) {
												switch(gettype($linha[$i])) {
													case "array":
														if (count($linha[$i]) > 0) {
															if (!FuncoesConversao::como_boleano($linha[$i]["ignorar"])) {
																$linha[$i] = $linha[$i]["codnodestino"];
															} else {
																/*ignorar registro(linha da origem) com esse valor na origem*/
																$ignorar = true;
																break(2);
															}
														} else {
															print_r($linha);
															throw new \Exception("registro nao encontrado na origem para o comando: " . $comando);
														}
														break;
													case "string":
													case "number":														
														//nada a fazer, ja atribuiu 
														break;
													case "double":
														break;
													default:
														throw new \Exception("tipo do dado retornado do eval nao esperado: ".gettype($linha[$i])."\n" . $comando);		
														break;
												}
											} else {
												print_r($linha);
												throw new \Exception("eval do comando retornou nulo: " . $comando);
											}
										}
									}

									/*verifica se o valor nao eh nulo9*/									
									if (FuncoesString::strTemValor($linha[$i])) {									
										if (!isset($valores_insert[$nometab_dest])) {
											$valores_insert[$nometab_dest] = [];											
										}
										$valores_insert[$nometab_dest][$colunas_origem[$titulos[$i]]["nomecamponodestino"]] = $linha[$i];	
									}
								}

							} else {
								throw new \Exception("campo inexistente na tabela eprelcolorigemdb:" . $titulos[$i]);
							}
						}
						if (!$ignorar && count($valores_insert) > 0) {
							foreach($valores_insert as $tab=>$insert){
								if (!isset($comandos_insert[$tab])){
									$comandos_insert[$tab] = [];
								}
								$comandos_insert[$tab][] = "insert into ep.$tab(" . implode(",",array_keys($insert)) . ") values (" . implode(",",$insert) . ")";
							}
						}
					}					
				} else {
					throw new \Exception("arquivo nao existe: " . $caminho_arq);   
				}

				/*elimina duplicatas*/
				foreach($comandos_insert as $tab => $comandos) {
					$comandos_temp = array_unique($comandos);
					$comandos_insert[$tab] = $comandos_temp;
				}
				print_r($comandos_insert); exit();
			} catch(\Error | \Throwable | \Exception $e) {
				FuncoesBasicasRetorno::mostrar_msg_sair($e);
			} 
		}

		public static function funcoes_eventuais(&$comhttp) {
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["nomeatualizacao"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["nomeatualizacao"] = $comhttp->requisicao->requisitar->qual->comando;
			}
			$nomeatualizacao = $comhttp->requisicao->requisitar->qual->condicionantes["nomeatualizacao"];
			switch(strtolower(trim($nomeatualizacao))) {
				case "gerar_historico_objetivos_sinergia":
					self::gerar_historico_objetivos_sinergia($comhttp);
					break;
				case "atualizar_clientes_rfb":
					self::atualizar_clientes_rfb($comhttp);
					break;
				case "processar_dados_clientes_rfb":
					self::processar_dados_clientes_rfb($comhttp);
					break;
				case "importar_devolucoes_aurora":
					self::importar_devolucoes_aurora($comhttp);
					break;					
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("nomeatualizacao nao programado: " . $nomeatualizacao, __FILE__,__FUNCTION__,__LINE__);
					break;
			}
		}

		public static function atualizar_dt_objetivoscampanha($codcampestr,$campo,$data){
			$comando_sql = "select * from sjdobjetcampestr where codcampestr=" . $codcampestr;
			$objetivos = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($objetivos) > 0) {
				foreach($objetivos as $objetivo) {
					$comando_sql = "update sjdobjetcampestr set " . $campo . " = '" .$data."' where codobjetcampestr = ".$objetivo["codobjetcampestr"]; 
					FuncoesSql::getInstancia()->executar_sql($comando_sql);			
				}
			}	
		}
		public static function atualizar_dt_objetivosespecificoscampanha($codcampestr,$campo,$data){
			$comando_sql = "select * from sjdobjetespeccampestr where codcampestr=" . $codcampestr;
			$objetivos = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($objetivos) > 0) {
				foreach($objetivos as $objetivo) {
					$comando_sql = "update sjdobjetespeccampestr set " . $campo . " = '" .$data."' where codobjetespeccampestr = ".$objetivo["codobjetesepeccampestr"]; 
					FuncoesSql::getInstancia()->executar_sql($comando_sql);			
				}
			}
		}
		public static function atualizar_dt_subcampanhas($codcampestr,$campo,$data) {
			$comando_sql = "select * from sjdcampestr where codcampestrsup=" . $codcampestr;
			$subcampanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($subcampanhas) > 0) {
				foreach($subcampanhas as $subcampanha) {
					$comando_sql = "update sjdcampestr set " . $campo . " = '" .$data."' where codcampestr = ".$subcampanha["codcampestr"]; 
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					self::atualizar_dt_objetivoscampanha($subcampanha["codcampestr"],$campo,$data);
					self::atualizar_dt_objetivosespecificoscampanha($subcampanha["codcampestr"],$campo,$data);
					self::atualizar_dt_subcampanhas($subcampanha["codcampestr"],$campo,$data);
				}
			}
		}

		public static function atualizar_dt_campanha(&$comhttp){
			$codcampestr = $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"];
			$campo = $comhttp->requisicao->requisitar->qual->condicionantes["campo"];
			$data = $comhttp->requisicao->requisitar->qual->condicionantes["data"];	
			if (gettype($campo) === "string") {
				$campo = explode(",",$campo);
			}
			if (gettype($data) === "string") {
				$data = explode(",",$data);
			}
			foreach($campo as $i => $cmp) {
				self::atualizar_dt_objetivoscampanha($codcampestr,$cmp,$data[$i]);
				self::atualizar_dt_objetivosespecificoscampanha($codcampestr,$cmp,$data[$i]);
				self::atualizar_dt_subcampanhas($codcampestr,$cmp,$data[$i]);
			}
			$comhttp->retorno->dados_retornados["conteudo_html"]["mensagem"] = "Dados atualizados com sucesso. \nA campanha deve ser recarregada para ver todos os dados atualizados.";
		}

		public static function gerar_qrcode_nfsaida($comhttp){
			$numtransvenda = $comhttp->requisicao->requisitar->qual->condicionantes["numtransvenda"];
			if (isset($numtransvenda) && $numtransvenda !== null && strlen(trim($numtransvenda)) > 0) {
				$comando_sql = "select count(1) as qt from sjdqrcodenfsaid where numtransvenda = " . $numtransvenda;
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				if (isset($dados) && $dados !== null && gettype($dados) === "array" && count($dados) > 0) {
					if (($dados["qt"] - 0) == 0) {
						include_once "sjd/php/bibliotecas/phpqrcode/qrlib.php";
						$qrcode = implode(",",\QRcode::text($numtransvenda));
						//print_r($qrcode); exit();
						$comando_sql = "insert into sjdqrcodenfsaid(numtransvenda,qrcode) values (".$numtransvenda. ",'".$qrcode."')";
						FuncoesSql::getInstancia()->executar_sql($comando_sql);
						$comando_sql = "commit";
						FuncoesSql::getInstancia()->executar_sql($comando_sql);
					}
				}
			}
		}

		public static function obter_dados_cliente_rfb_simples($cnpj) {
			$cnpj = str_replace([".","-","/"],"",$cnpj);
			$retorno = null;
			try{
				$solicitacao_receitaws = "http://receitaws.com.br/v1/cnpj/".$cnpj;
				$dados_receita = "";
				$ch = curl_init();
				$timeout = 0;
				curl_setopt($ch, CURLOPT_URL, $solicitacao_receitaws);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$dados_receita = curl_exec ($ch);
				$dados_receita = trim($dados_receita);
				curl_close($ch);							
				if (strlen($dados_receita) > 0) {
					if (strpos($dados_receita,"{") !== false) {
						$dados_receita = json_decode($dados_receita);
						if (trim(json_last_error()) === "0") {	
							$retorno = $dados_receita;
						} else {
							//print_r($dados_receita);
							//mostrar_msg_sair("erro de conversao do retorno do servico para json: " . json_last_error_msg(),__FILE__,__FUNCTION__,__LINE__);
							$dados_receita = json_decode('{"status":"ERROR","message":"o retorno eh invalido."}');				
							$retorno = $dados_receita;
						}
					} else {
						$dados_receita = json_decode('{"status":"ERROR","message":"Excesso de requisições por minuto a receita, tente mais tarde."}');				
						$retorno = $dados_receita;
					}
				} else {
					//mostrar_msg_sair("servico nao retornou dados",__FILE__,__FUNCTION__,__LINE__);			
					$dados_receita = json_decode('{"status":"ERROR","message":"Excesso de requisições por minuto a receita, serviço retornou nulo, tente mais tarde."}');				
					$retorno = $dados_receita;
				}
			} catch(\Exception $e){
				echo "erro"; 
				print_r($e); 
				exit();
			}
			return $retorno;
		}


		public static function consultar_cliente_rfb_simples(&$comhttpsimples){
			$cnpj = $comhttpsimples->c["condicionantes"];
			$dados_receita = [];
			$dados_receita = self::obter_dados_cliente_rfb_simples($cnpj);

			if ($dados_receita !== null) {
				/*gera campos que não vem por padrao no objeto de retorno da consulta do serviço*/
				@$dados_receita->inscricao_estadual = "";
				@$dados_receita->latitude = "";
				@$dados_receita->longitude = "";
				@$dados_receita->existe_cadastro = "";
				@$dados_receita->codcli = "";
				
				/*
				link para download dos ativos: 
				https://www.fazenda.pr.gov.br/modules/conteudo/conteudo.php?conteudo=109
				*/
				
				$cmd_consulta_inscestadual = "select * from sjdinscestaduais where to_number(trim(replace(replace(replace(cnpj,'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace('$cnpj','.',''),'-',''),'/','')))";
				$dados_inscest = FuncoesSql::getInstancia()->executar_sql($cmd_consulta_inscestadual,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados_inscest) > 0) {
					$dados_receita->inscricao_estadual = $dados_inscest["inscest"];
				} else {
					$dados_receita->inscricao_estadual = "ISENTO";
				}	
				
				$cmd_consulta_existencia = "select codcli from JUMBO.PCCLIENT where to_number(trim(replace(replace(replace(cgcent,'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace('$cnpj','.',''),'-',''),'/','')))";
				$dados_existencia = FuncoesSql::getInstancia()->executar_sql($cmd_consulta_existencia,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados_existencia) > 0) {
					$dados_receita->existe_cadastro = "S";
					$dados_receita->codcli = $dados_existencia["codcli"];
				} else {
					$dados_receita->existe_cadastro = "N";
				}	
			}
			$comhttpsimples->r["dados"] = $dados_receita;
		}

		public static function excluir_pedrca_fv_simples($conexao,$numpedrca) {
			$comando_sql = "delete from jumbo.pcpedifv where numpedrca = " . $numpedrca;
			$params_sql = [
				"query"=>$comando_sql,
				"conexao"=>$conexao
			];
			FuncoesSql::getInstancia()->executar_sql($params_sql);		
			$comando_sql = "delete from jumbo.pcpedcfv where numpedrca = " . $numpedrca;
			$params_sql = [
				"query"=>$comando_sql,
				"conexao"=>$conexao
			];
			FuncoesSql::getInstancia()->executar_sql($params_sql);			
		}
		public static function desfazer_inclusao_pedrca_fv_simples($conexao,$numpedrca) {			
			$params_sql = [
				"query"=>"rollback",
				"conexao"=>$conexao
			];
			FuncoesSql::getInstancia()->executar_sql($params_sql);		
			self::excluir_pedrca_fv_simples($conexao,$numpedrca);
			$params_sql = [
				"query"=>"commit",
				"conexao"=>$conexao
			];
			FuncoesSql::getInstancia()->executar_sql($params_sql);						
		}

		public static function incluir_pedido_simples(&$comhttpsimples) {				
			$comhttpsimples->r["pedido_gravado"] = "n";
			$comhttpsimples->r["numpederp"] = null;
			$comhttpsimples->c["condicionantes"] = FuncoesArray::chaves_associativas($comhttpsimples->c);	
			$pedido_recebido = json_decode($comhttpsimples->c["condicionantes"]["pedido"]);	
			$comhttpsimples->r["numpedapp"] = $pedido_recebido->numpedapp;
			$pedido = [];
			$pedido["cabecalho"] = [];
			$pedido["cabecalho"]["importado"] = 1;
			/*encontra o cliente do pedido na base*/
			$comando_sql = "select * from jumbo.pcclient where codcli = " . $pedido_recebido->codcli;
			$dados_cliente = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
			//print_r($dados_cliente);exit();
			if (!count($dados_cliente) > 0) {
				$retorno = "dados do cliente nao encontrado na base. Pedido nao incluido.";
				goto fim;		
			}
			/*encontra a cobrança selecionada no pedido*/
			$comando_sql = "select * from jumbo.pccob";
			$dados_cob = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$pedido_recebido->codcob = trim(strtolower($pedido_recebido->codcob));
			/*if ($pedido_recebido->cabecalho->codcob==="dinheiro a vista") {
				$pedido_recebido->cabecalho->codcob = "dinheiro";
			}*/
			//print_r($dados_cob);exit();
			$cobranca = [];
			foreach($dados_cob as $linhacob) {
				$codcob = "";
				$codcob = $pedido_recebido->codcob;
				$codcob = strtolower(trim($codcob));
				if ($pedido_recebido->codcob === trim(strtolower($linhacob["codcob"]))||
					$codcob === trim(strtolower($linhacob["codcob"]))) {
					$cobranca = $linhacob; 
					break;
				}
			}
			if (count($cobranca) === 0) {
				$retorno = "Cobranca nao encontrada: ". $pedido_recebido->cabecalho->codcob. ". Pedido nao incluido.";
				goto fim;		
			}
			/*encontra o plano de pagamento selecionado no pedido*/
			$comando_sql = "select * from jumbo.pcplpag";
			$dados_plpag = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$pedido_recebido->codplpag = trim(strtolower($pedido_recebido->codplpag));
			$plpag = [];
			//print_r($dados_plpag);exit();
			foreach($dados_plpag as $linhaplpag) {
				if ($pedido_recebido->codplpag === trim(strtolower($linhaplpag["codplpag"]))) {
					$plpag = $linhaplpag; 
					break;
				}
			}
			if (count($plpag) === 0) {
				$retorno = "Plano de pagamento nao encontrado: ". $pedido_recebido->cabecalho->plpag. ". Pedido nao incluido.";
				goto fim;
			}	
			$data = "to_date(" . FuncoesString::aspas_simples(date('d/m/Y H:i:s')) . ",'DD/MM/YYYY HH24:MI:SS')";	
			/*
				prevenção de vir informação nula ou errada nos campos de data
			*/
			if ($pedido_recebido->dtiniped !== null) {
				if (strlen(trim($pedido_recebido->dtiniped)) > 0) {
					if (strtolower(trim($pedido_recebido->dtiniped)) !== "null") {
						$dtiniped = "to_date(" . FuncoesString::aspas_simples($pedido_recebido->dtiniped) . ",'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."')";	
					} else {
						$dtiniped = "sysdate";
					}
				} else {
					$dtiniped = "sysdate";
				}
			} else {
				$dtiniped = "sysdate";
			}
			if ($pedido_recebido->dtfimped !== null) {
				if (strlen(trim($pedido_recebido->dtfimped)) > 0) {
					if (strtolower(trim($pedido_recebido->dtfimped)) !== "null") {
						$dtfimped = "to_date(" . FuncoesString::aspas_simples($pedido_recebido->dtfimped) . ",'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."')";	
					} else {
						$dtfimped = "sysdate";
					}
				} else {
					$dtfimped = "sysdate";
				}
			} else {
				$dtfimped = "sysdate";
			}
			$pedido["cabecalho"]["numpedrca"] = null;
			$pedido["cabecalho"]["codusur"] = $pedido_recebido->codusur ?? $dados_cliente["codusur1"];	
			$pedido["cabecalho"]["codcli"] = $dados_cliente["codcli"];	
			$pedido["cabecalho"]["codclinf"] = $dados_cliente["codcli"];	
			$pedido["cabecalho"]["cgccli"] = FuncoesString::aspas_simples(str_replace("/","",str_replace(".","",str_replace("-","",$dados_cliente["cgcent"]))));
			$pedido["cabecalho"]["dtaberturapedpalm"] = $dtiniped;
			$pedido["cabecalho"]["dtfechamentopedpalm"] = $dtfimped;
			$pedido["cabecalho"]["dtentrega"] = $dtfimped; 
			$pedido["cabecalho"]["codfilial"] = $dados_cliente["codfilialnf"];
			$pedido["cabecalho"]["codfilialnf"] = $dados_cliente["codfilialnf"]; 
			$pedido["cabecalho"]["codfilialretira"] = $dados_cliente["codfilialnf"]; 
			$pedido["cabecalho"]["fretedespacho"] = "'C'"; 
			$pedido["cabecalho"]["freteredespacho"] = "'C'"; 
			$pedido["cabecalho"]["codcob"] = FuncoesString::aspas_simples($cobranca["codcob"]);
			$pedido["cabecalho"]["codplpag"] = $plpag["codplpag"];
			$pedido["cabecalho"]["condvenda"] = 1;
			$pedido["cabecalho"]["origemped"] = FuncoesString::aspas_simples("F");
			$pedido["cabecalho"]["retorno"] = "null";
			/*$comando_sql = "select * from jumbo.pcplpag where codplpag = " . $pedido["cabecalho"]["codplpag"];
			$dados_plpag = FuncoesSql::getInstancia()->dados_sql_para_array_avulso(FuncoesSql::getInstancia()->executar_sql($comando_sql),true,false,false);
			if (!count($dados_cliente) > 0) {
				mostrar_msg_sair("dados plano de pagamento do cliente nao encontrado na base", __FILE__,__FUNCTION__,__LINE__);
			}*/
			//var_dump($pedido_recebido);exit();
			$pedido["itens"] = [];
			$comando_sql = "select jumbo.sjdseqnumpedrca.nextval as numpedrca from dual";
			$numpedrca = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
			if (count($numpedrca) > 0) {
				$numpedrca = $numpedrca["numpedrca"];
			} else {
				$retorno = "falha ao obter o proximo numero de pedido. Pedido nao incluido.";
				goto fim;
			}
			$pedido["cabecalho"]["numpedrca"] = $numpedrca;	
			$comando_sql = "insert into jumbo.pcpedcfv (" . implode(",",array_keys($pedido["cabecalho"])) . ") values (" . implode(",",$pedido["cabecalho"]) . ")" ;
			$params_conexao_jumbo = [
				"nome_conexao"=>"oracle_jumbo_sjd"
			];
			$conexaojumbo = FuncoesSql::getInstancia()->conectar($params_conexao_jumbo);
			if (!$conexaojumbo){
				$retorno = "erro ao conectar na base jumbo para incluir o pedido.";
				goto fim;
			}
			$params_sql = [
				"query"=>$comando_sql,
				"conexao"=>$conexaojumbo
			];
			//echo $comando_sql;
			FuncoesSql::getInstancia()->executar_sql($params_sql);
			//exit();



			$numseq = 1;
			$vltotal = 0;
			foreach($pedido_recebido->itens as $item) {
				$comando_sql = "select * from jumbo.pcprodut where codprod = " . $item->codprod;
				$dados_produto = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				//print_r($dados_produto);exit();
				if (count($dados_produto) > 0) {
					$comando_sql = "select * from jumbo.pctabpr where codprod = " . $dados_produto["codprod"] . " and numregiao = " . $dados_cliente["numregiaocli"];
					$dados_preco = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
					if (count($dados_preco) > 0) {
						$pedido["itens"][$dados_produto["codprod"]] = [];
						$pedido["itens"][$dados_produto["codprod"]]["numpedrca"] = $numpedrca;
						$pedido["itens"][$dados_produto["codprod"]]["cgccli"] = $pedido["cabecalho"]["cgccli"];
						$pedido["itens"][$dados_produto["codprod"]]["codusur"] = $pedido["cabecalho"]["codusur"];
						$pedido["itens"][$dados_produto["codprod"]]["dtaberturapedpalm"] = $pedido["cabecalho"]["dtaberturapedpalm"]; 
						$pedido["itens"][$dados_produto["codprod"]]["codprod"] = $dados_produto["codprod"];
						$pedido["itens"][$dados_produto["codprod"]]["qt"] = FuncoesConversao::como_numero($item->qt);
						$pedido["itens"][$dados_produto["codprod"]]["pvenda"] = FuncoesConversao::como_numero($item->pvenda);
						$pedido["itens"][$dados_produto["codprod"]]["numseq"] = $numseq;
						$pedido["itens"][$dados_produto["codprod"]]["unidade_frios"] = "'".$dados_produto["unidade"]."'";
						$vltotal = $vltotal + ($pedido["itens"][$dados_produto["codprod"]]["qt"] * $pedido["itens"][$dados_produto["codprod"]]["pvenda"]);
						$comando_sql = "insert into jumbo.pcpedifv (" . implode(",",array_keys($pedido["itens"][$dados_produto["codprod"]])) . ") values (" . implode(",",$pedido["itens"][$dados_produto["codprod"]]) . ")" ;
						$params_sql = [
							"query"=>$comando_sql,
							"conexao"=>$conexaojumbo
						];
						FuncoesSql::getInstancia()->executar_sql($params_sql);
						$numseq++;
					} else {
						$retorno = "dados do preco do produto nao encontrado na base: " . $item->codprod. ". Pedido nao incluido.";
						self::desfazer_inclusao_pedrca_fv_simples($conexaojumbo,$numpedrca);
						goto fim;
					}			
				} else {
					$retorno = "produto nao encontrado na base: " . $item->codprod. ". Pedido nao incluido.";
					self::desfazer_inclusao_pedrca_fv_simples($conexaojumbo,$numpedrca);
					goto fim;
				}
			}
			if ($vltotal <= FuncoesConversao::como_numero($plpag["vlminpedido"])) {
				$retorno = "Valor minimo para um pedido nao atingido (R$ ".$plpag["vlminpedido"]."). Pedido nao incluido.";
				self::desfazer_inclusao_pedrca_fv_simples($conexaojumbo,$numpedrca);
				goto fim;
			}
			$params_sql = [
				"query"=>"commit",
				"conexao"=>$conexaojumbo
			];
			FuncoesSql::getInstancia()->executar_sql($params_sql);
			$retorno = "Pedido gravado com numero: " .$numpedrca. ". Acompanhe a situacao na opcao de consulta.";
			$comhttpsimples->r["pedido_gravado"] = "s";
			$comhttpsimples->r["numpederp"] = $numpedrca;
			fim:
			$conexaojumbo = null;
			$comhttpsimples->r["mensagem_retorno"] = $retorno;
			return $retorno;
		}

		public static function status_pedidos_simples(&$comhttpsimples) {	
			$comhttpsimples->r["pedido_gravado"] = "n";
			$comhttpsimples->r["numpederp"] = null;
			$condicped = [];
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictemp = $comhttpsimples->c["condicionantes"];
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($condictemp)));
			}	
			if (count($condictemp) > 0) {
				foreach($condictemp as $chave=>$condict) {
					if ($condictemp[$chave] !== "array") {
						$condictemp[$chave] = explode(strtolower(trim(Constantes::sepn2)),strtolower(trim($condictemp[$chave])));				
					}
					if (count($condictemp[$chave]) > 0) {
						foreach($condictemp[$chave] as $chave2=>$condict2) {
							$condic = strtolower(trim(substr($condictemp[$chave][$chave2],0,strpos($condictemp[$chave][$chave2],"="))));
							$valor = strtolower(trim(substr($condictemp[$chave][$chave2],strpos($condictemp[$chave][$chave2],"=") + 1)));			
							if ($condic === "pedido") {
								if (is_numeric($valor)) {	
									$condicped[] = $valor;
								} 
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttpsimples->c["condicionantes"] = $condictemp;
			}
			
			$comando_sql = "
				select p.NUMPEDRCA, 
					case 
						when p.POSICAO = 'P' THEN 5 
						when p.POSICAO = 'L' THEN 7 
						WHEN p.POSICAO = 'M' THEN 8 
						WHEN p.POSICAO = 'F' THEN 
							(select decode(s.dtfecha,null,9,                                                            
								case when exists(select 1 from jumbo.pcprest pg where pg.dtpag is null and pg.numtransvenda = p.numtransvenda and pg.codcli = p.codcli) then
									case when (select max(dtvenc) from jumbo.pcprest pg where pg.dtpag is null and pg.numtransvenda = p.numtransvenda and pg.codcli = p.codcli) < sysdate then
										12
									else
										10
									end
								else 
									11
								end                
							) from jumbo.pcnfsaid s where s.numtransvenda = p.numtransvenda)
						ELSE 4 
					END AS POSICAO 
				from jumbo.pcpedc p where p.numpedrca in (" . implode(",",$condicped) . ") 
				union 
				select 
					numpedrca,
					6 as posicao 
				from jumbo.pcnfcan where numpedrca in (". implode(",",$condicped) .")";
			$comhttpsimples->d["s"] = $comando_sql;
			FuncoesRequisicaoSis::montar_retorno_simples_padrao($comhttpsimples);
			return $comhttpsimples;
		}


		public static function cadastrar_cliente_simples(&$comhttpsimples){
			$condicionantes = $comhttpsimples->c["condicionantes"];
			$condicionantes = ["cliente" => str_replace("cliente=","",$condicionantes)];
			$condicionantes["cliente"] = json_decode($condicionantes["cliente"]);
			$cnpj_original = $condicionantes["cliente"]->cnpj;
			$cgccli = trim(str_replace("/","",str_replace("-","",str_replace(".","",$cnpj_original))));
			$cmd_temp = "select * from jumbo.pcclient where to_number(trim(replace(replace(replace(cgcent,'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace('$cgccli','.',''),'-',''),'/',''))) and rownum <=1";
			$dados_cliente_existente = FuncoesSql::getInstancia()->executar_sql($cmd_temp,"fetch",\PDO::FETCH_ASSOC);
			if (count($dados_cliente_existente) > 0) {
				$comhttpsimples->r["cliente_gravado"] = "N";
				$comhttpsimples->r["mensagem_retorno"] = "Cliente ja existe (COD ".$dados_cliente_existente["codcli"]."), impossivel cadastrar novamente";
			} else {
				$razao_social = strtoupper(trim(str_replace(["&"],["E"],$condicionantes["cliente"]->razao)));
				$fantasia = substr(strtoupper(trim(str_replace(["&"],["E"],$condicionantes["cliente"]->fantasia))),0,39);
				$ieent = trim($condicionantes["cliente"]->inscest);
				$codcnae = trim($condicionantes["cliente"]->codcnae);
				$enderent = strtoupper(trim($condicionantes["cliente"]->logradouro));
				$numeroent = trim($condicionantes["cliente"]->numero);
				$complementoent = strtoupper(trim($condicionantes["cliente"]->complemento ?? ""));
				$bairroent = strtoupper(trim($condicionantes["cliente"]->bairro));
				$telent = substr(trim(str_replace([" ",".","-","/",","],"",$condicionantes["cliente"]->telefone)),0,12);
				$municent = strtoupper(trim($condicionantes["cliente"]->municipio));
				$estent = strtoupper(trim($condicionantes["cliente"]->uf));
				$cepent = substr(trim(str_replace([" ",".","-","/",","],"",$condicionantes["cliente"]->cep)),0,8);
				$paisent = "BRASIL";
				$pontoref = "";
				$codusur1 = trim($condicionantes["cliente"]->codusur);
				$email = strtoupper(trim($condicionantes["cliente"]->email ?? ""));
				$site = null;
				$latitude = trim($condicionantes["cliente"]->latitude ?? "");
				$longitude = trim($condicionantes["cliente"]->longitude ?? "");
				$codativ1 = "null";	
				$cmd_temp = "select * from jumbo.pccnae where to_number(trim(replace(replace(replace(codcnae,'.',''),'-',''),'/',''))) = to_number(trim(replace(replace(replace('$codcnae','.',''),'-',''),'/',''))) and rownum <=1";
				$dados_cnae = FuncoesSql::getInstancia()->executar_sql($cmd_temp,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados_cnae) > 0) {
					$codcnae = $dados_cnae["codcnae"];
					$codativ1 = $dados_cnae["codativ1"];
				} else {
				}
				$codcidadeibge = "null";
				$codcidade = "null";
				if ($estent !== null && $municent !== null) {
					if (strlen(trim($estent)) > 0 && strlen(trim($municent)) > 0) {
						$cmd_temp = "select * from jumbo.pccidade where lower(trim(uf)) = lower(trim('" . $estent . "')) and lower(trim(nomecidade)) = lower(trim('" . $municent . "')) and rownum <= 1";
						$dados_cidade = FuncoesSql::getInstancia()->executar_sql($cmd_temp,"fetch",\PDO::FETCH_ASSOC);
						if (count($dados_cidade) > 0) {
							$codcidadeibge = $dados_cidade["codibge"];
							$codcidade = $dados_cidade["codcidade"];
						}
					}
				}
				$codfilialnf = "null";
				$cmd_temp = "select * from jumbo.pcusuari where codusur = " . $codusur1;
				$dados_usuariosis = FuncoesSql::getInstancia()->executar_sql($cmd_temp,"fetch",\PDO::FETCH_ASSOC);
				if (count($dados_usuariosis) > 0) {
					$codfilialnf = $dados_usuariosis["codfilial"];
				} else {		
					$cmd_temp = "select * from sjdusuariosis where codusuariosis = " . $codusur1;
					$dados_usuariosis = FuncoesSql::getInstancia()->executar_sql($cmd_temp,"fetch",\PDO::FETCH_ASSOC);
					if (count($dados_usuariosis) > 0) {
						$codfilialnf = $dados_usuariosis["codfilial"];
					} else {		
						$codfilialnf = ($codusur1>199?2:1);
					}		
				}
				if ($codfilialnf === null) {
					$codfilialnf = ($codusur1>199?2:1);
				} else {
					if (strlen(trim($codfilialnf)) === 0) {
						$codfilialnf = ($codusur1>199?2:1);
					}
				}		
				if ($codfilialnf === null) {
					$codfilialnf = 1;
				} else {
					if (strlen(trim($codfilialnf)) === 0) {
						$codfilialnf = 1;
					}
				}
				$codpraca = 593; 
				$codcob = "D";
				$codplpag = 1;
				$campos = [
					"IMPORTADO",
					"TIPOOPERACAO",
					"CGCENT",	
					"CLIENTE",
					"CODCLI",
					"FANTASIA",
					"IEENT",
					"IMENT",
					"RG",
					"ORGAORG",
					"CODCLIPALM",
					"CODATV1",
					"ENDERENT",
					"NUMEROENT",
					"COMPLEMENTOENT",
					"BAIRROENT",
					"TELENT",
					"MUNICENT",
					"ESTENT",
					"CEPENT",
					"PAISENT",
					"PONTOREFER",
					"ENDERCOB",
					"COMPLEMENTOCOB",
					"NUMEROCOB",
					"BAIRROCOB",
					"TELCOB",
					"MUNICCOB",
					"ESTCOB",
					"CEPCOB",
					"ENDERCOM",
					"NUMEROCOM",
					"COMPLEMENTOCOM",
					"BAIRROCOM",
					"MUNICCOM",
					"ESTCOM",
					"CEPCOM",
					"TELCOM",
					"FAXCOM",
					"CODUSUR1",
					"CODUSUR2",
					"FAXCLI",
					"CODPRACA",
					"PREDIOPROPRIO",
					"OBS",
					"OBS2",
					"OBS3",
					"OBS4",
					"OBSCREDITO",
					"TELENT1",
					"EMAIL",
					"CAIXAPOSTAL",
					"OBSENTREGA1",
					"OBSENTREGA2",
					"OBSENTREGA3",
					"OBSENTREGA4",
					"NUMBANCO1",
					"NUMAGENCIA1",
					"NUMCCORRENTE1",
					"NUMBANCO2",
					"NUMAGENCIA2",
					"NUMCCORRENTE2",
					"QTCHECKOUT",
					"SITE",
					"OBSGERENCIAL1",
					"OBSGERENCIAL2",
					"OBSGERENCIAL3",
					"LATITUDE",
					"LONGITUDE",
					"DATACOLETA",
					"OBSERVACAO_PC",
					"EMAILNFE",
					"CODCOB",
					"CODPLPAG",
					"CODCIDADEIBGE",
					"CODFILIALNF",
					"CONSUMIDORFINAL",
					"CONTRIBUINTE",
					"CLIENTPROTESTO",
					"ENVIONFEMAILCOM",
					"DIASEMANA",
					"NUMSEMANA",
					"SEQUENCIA",
					"PERIODICIDADE",
					"SIMPLESNACIONAL",
					"CODPAIS",
					"DTALTERACAO",
					"DTINCLUSAO",
					"CALCULAST",
					"CLIENTEFONTEST",
					"PARTICIPAFUNCEP",
					"FRETEDESPACHO",
					"VALIDARMULTIPLOVENDA",
					"CODCNAE"];
				$valores = [
					1,
					"'I'",
					"'$cgccli'",	
					"'$razao_social'",
					"null",
					"'$fantasia'",
					"'$ieent'",
					"null",
					"null",
					"null",
					"null",
					"$codativ1",
					"'$enderent'",
					"'$numeroent'",
					"'$complementoent'",			
					"'$bairroent'",
					"'$telent'",
					"'" . substr($municent,0,15) . "'",
					"'$estent'",
					"'$cepent'",
					"'BRASIL'",
					"null",
					"'$enderent'",
					"'$complementoent'",
					"'$numeroent'",
					"'$bairroent'",
					"'$telent'",
					"'" . substr($municent,0,15) . "'",
					"'$estent'",
					"'$cepent'",
					"'$enderent'",
					"'$numeroent'",
					"'$complementoent'",
					"'$bairroent'",
					"'" . substr($municent,0,15) . "'",
					"'$estent'",
					"'$cepent'",
					"'$telent'",
					"null",
					"$codusur1",
					"null",
					"null",
					"$codpraca",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"'$telent'",
					"'$email'",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"'$site'",
					"null",
					"null",
					"null",
					"'$latitude'",
					"'$longitude'",
					"null",
					"null",
					"'$email'",
					"'$codcob'",
					"$codplpag",
					"$codcidadeibge",
					"$codfilialnf",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"null",
					"1058",
					"null",
					"null",
					"null",
					"null",
					"null",
					"'C'",
					"'S'",
					"'$codcnae'"];	
				$cmd_inserir = "insert into jumbo.pcclientfv (".implode(",",$campos).") values (".implode(",",$valores).")";
				$params_conexao_jumbo = [
					"nome_conexao"=>"oracle_jumbo_sjd"
				];
				$conexaojumbo = FuncoesSql::getInstancia()->conectar($params_conexao_jumbo);
				if (!$conexaojumbo){
					$retorno = "erro ao conectar na base jumbo para incluir o pedido.";
					goto fim;
				}
				$params_sql = [
					"query"=>$cmd_inserir,
					"conexao"=>$conexaojumbo
				];
				FuncoesSql::getInstancia()->executar_sql($params_sql);
				$params_sql = [
					"query"=>"commit",
					"conexao"=>$conexaojumbo
				];
				FuncoesSql::getInstancia()->executar_sql($params_sql);
				$retorno = "cliente gravado com sucesso";
				$comandos_inserir_socios = "";
				if (isset($condicionantes["cliente"]->cnjsocios)) {
					if ($condicionantes["cliente"]->cnjsocios !== null) {
						if (gettype($condicionantes["cliente"]->cnjsocios) === "array") {
							foreach($condicionantes["cliente"]->cnjsocios as $chave => &$socio) {
								$campos = ["importado","cgccli","tipocontato"];
								$valores = [1, "'" . $cgccli . "'","'F'"];
								if (isset($socio->nome)) {
									$campos[] = "nomecontato";
									$valores[] = "'" . $socio->nome . "'";
								}
								if (isset($socio->cpfcnpj)) {
									$campos[] = "cgccpf";
									$valores[] = "'" . str_replace(['.','-',',','/'],'',$socio->cpfcnpj) . "'";
								}
								if (isset($socio->tiporep)) {
									$campos[] = "cargo";
									$valores[] = "'" . $socio->tiporep . "'";
								}
								if (isset($socio->celular)) {
									$campos[] = "celular";
									$valores[] = "'" . str_replace(['.','-',',','/'],'',$socio->celular) . "'";
								}
								if (isset($socio->fone)) {
									$campos[] = "telefone";
									$valores[] = "'" . str_replace(['.','-',',','/'],'',$socio->fone) . "'";
								}
								if (isset($socio->email)) {
									$campos[] = "email";
									$valores[] = "'" . $socio->email . "'";
								}
								if (isset($socio->estado)) {
									$campos[] = "estado";
									$valores[] = "'" . $socio->estado . "'";
								}
								if (isset($socio->cidade)) {
									$campos[] = "cidade";
									$valores[] = "'" . $socio->cidade . "'";
								}
								if (isset($socio->bairro)) {
									$campos[] = "bairro";
									$valores[] = "'" . $socio->bairro . "'";
								}
								if (isset($socio->logradouro)) {
									$campos[] = "endereco";
									$valores[] = "'" . $socio->logradouro . "'";
								}
								if (isset($socio->cep)) {
									$campos[] = "cep";
									$valores[] = "'" . str_replace(['.','-',',','/'],'',$socio->cep) . "'";
								}
								if (isset($socio->hobbie)) {
									$campos[] = "hobbie";
									$valores[] = "'" . $socio->hobbie . "'";
								}
								if (isset($socio->time)) {
									$campos[] = "time";
									$valores[] = "'" . $socio->time . "'";
								}
								if (isset($socio->dtnascimento)) {
									$campos[] = "dtnascimento";
									$valores[] = "to_date('" . $socio->dtnascimento . "','dd/mm/yyyy')";
								}
								if (isset($socio->nomeconjuge)) {
									$campos[] = "nomeconjuge";
									$valores[] = "'" . $socio->nomeconjuge . "'";
								}
								if (isset($socio->dtnascimentoconj)) {
									$campos[] = "dtnascconjuge";
									$valores[]= "to_date('" . $socio->dtnascimentoconj . "','dd/mm/yyyy')";
								}								
								$params_sql = [
									"query"=>$comandos_inserir_socios,
									"conexao"=>$conexaojumbo
								];
								FuncoesSql::getInstancia()->executar_sql($params_sql);
							}
							$params_sql = [
								"query"=>"commit",
								"conexao"=>$conexaojumbo
							];
							FuncoesSql::getInstancia()->executar_sql($params_sql);
						}
					}
				} 
				$conexaojumbo = null;
				$comhttpsimples->r["cliente_gravado"] = "S";
				$comhttpsimples->r["cnpj"] = $cnpj_original;
				fim:
				$comhttpsimples->r["mensagem_retorno"] = $retorno;

			}
		}

		public static function funcoes_erp(&$comhttp) {
			switch(strtolower(trim($comhttp->requisicao->requisitar->qual->comando))) {
				case "excluir_item_pedido":
					self::excluir_item_pedido($comhttp);
					break;
				case "incluir_pedido_cliente":
					self::incluir_pedido_cliente($comhttp);
					break;
				case "atualizar_tabela_arestaurimportacao":
					self::atualizar_tabela_arestaurimportacao($comhttp);
					break;			
				case "atualizar_vendas_aurora":
					self::atualizar_vendas_aurora($comhttp);
					break;						
				case "atualizar_clientes_rfb":
					self::atualizar_clientes_rfb($comhttp);
					break;						
				case "atualizar_dt_campanha":
					self::atualizar_dt_campanha($comhttp);
					break;	
				case "aplicar_percentual_geral_campanha":
					self::aplicar_percentual_geral_campanha($comhttp);
					break;
				case "consultar_cliente_rfb":
					self::consultar_cliente_rfb($comhttp);
					break;
				case "cadastrar_cliente":
					self::cadastrar_cliente($comhttp);
					break;
				case "atualizar_realizado_objetivos_sinergia":
					self::atualizar_realizado_objetivos_sinergia($comhttp);
					break;		
				case "atualizar_realizado_objetivos_sinergia_mes_anterior":
					self::atualizar_realizado_objetivos_sinergia_mes_anterior($comhttp);
					break;		
				case "atualizar_realizado_objetivos_campanhas_estruturadas":
					self::atualizar_realizado_objetivos_campanhas_estruturadas($comhttp);
					break;
				case "atualizar_realizado_objetivos_campanhas_estruturadas_mes_anterior":
					self::atualizar_realizado_objetivos_campanhas_estruturadas_mes_anterior($comhttp);
					break;
				case "gerar_qrcode_nfsaida":
					self::gerar_qrcode_nfsaida($comhttp);
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("comando nao esperado: " . $comhttp->requisicao->requisitar->qual->comando, __FILE__,__FUNCTION__,__LINE__);
					break;
			}
		}



		public static function copiar_campanha(&$comhttp,$dados_retorno_originais=[]){
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"] = [];
			}
			$codcampestr = $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"];
			$comhttp->requisicao->requisitar->qual->condicionantes["tabela"] = "sjdcampestr";
			$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = "codcampestr=".$codcampestr;
			//echo $codcampestr.chr(10); exit();
			FuncoesSql::getInstancia()->duplicar_registro($comhttp);
			//echo "ok1"; exit();
			$codnovacampanha = $comhttp->retorno->dados_retornados["dados"][0]["valor"];
			//echo $codnovacampanha; exit();

			if (count($dados_retorno_originais) === 0) {
				$dados_retorno_originais = $comhttp->retorno->dados_retornados["dados"];
			}
			$comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"] = [];//apaga valores substitutos anteriores,pois a tabela eh outra
			$comhttp->requisicao->requisitar->qual->condicionantes["tabela"] = "sjdobjetcampestr";
			$comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"]["codcampestr"] = $codnovacampanha;
			$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = "codcampestr=".$codcampestr ;
			FuncoesSql::getInstancia()->duplicar_registro($comhttp);
			
			$comhttp->requisicao->requisitar->qual->condicionantes["tabela"] = "sjdobjetespeccampestr";
			$comhttp->requisicao->requisitar->qual->condicionantes["valores_substitutos"]["codcampestr"] = $codnovacampanha;
			$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = "codcampestr=".$codcampestr ;
			FuncoesSql::getInstancia()->duplicar_registro($comhttp);
			$comhttp->retorno->dados_retornados["dados"] = $dados_retorno_originais;
			
			$comando_sql_sub = "select * from sjdcampestr where codcampestrsup=" . $codcampestr;
			$campanhas_sub = FuncoesSql::getInstancia()->executar_sql($comando_sql_sub,"fetchAll",\PDO::FETCH_ASSOC);			
			if (count($campanhas_sub) > 0) {
				foreach($campanhas_sub as $campanha_sub) {
					$comhttp_sub = clone $comhttp;
					$comhttp_sub->requisicao->requisitar->qual->condicionantes["codcampestr"] = $campanha_sub["codcampestr"] ;
					$comhttp_sub->requisicao->requisitar->qual->condicionantes["valores_substitutos"]["codcampestrsup"] = $codnovacampanha;
					self::copiar_campanha($comhttp_sub,$dados_retorno_originais);
				}
			}	
		}

		public static function funcoes_sisjd(&$comhttp) {
			$funcao = "";
			$funcao = $comhttp->requisicao->requisitar->qual->objeto . "(\$comhttp);";
			eval("self::".$funcao);
		}

		private static function prepararValoresInclusao(array &$valores) : array{
			foreach($valores as $chave=>&$valor){						
				if (strpos($chave,"dt") !== false || strpos($chave,"data") !== false) {
					$valores[$chave] = "to_date(" . FuncoesString::aspas_simples($valores[$chave]) . ",'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."')";
				} else if (strpos($chave,"nome") !== false || strpos($chave,"chave") !== false || strpos($chave,"observacao") !== false
					|| strpos($chave,"placa") !== false || strpos($chave,"destino") !== false || strpos($chave,"forma") !== false
				) {
					$valores[$chave] = FuncoesString::aspas_simples($valores[$chave]);
				} else if (stripos($chave,"peso") !== false || stripos($chave,"valor") !== false || stripos($chave,"vl") !== false
					|| stripos($chave,"qt") !== false || stripos($chave,"quant") !== false
				) {
					$valores[$chave] = str_replace(",",".",$valores[$chave]);
				} 
			}
			return $valores;
		}


		public static function incluir_carregamento_simples(&$comhttpsimples) {				
			try {
				$comhttpsimples->r["carregamento_gravado"] = "n";				
				$comhttpsimples->c["condicionantes"] = FuncoesArray::chaves_associativas($comhttpsimples->c);	
				$entrega_recebida = json_decode($comhttpsimples->c["condicionantes"]["carregamento"]);
				$comhttpsimples->r["numcar"] = $entrega_recebida->numcar;
				$nometabela = "sjdacompentregacarreg";
				$params_sql = [
					"query"=>"select * from ".$nometabela." where numcar='".$entrega_recebida->numcar."'",
					"fetch"=>"fetch",
					"fetch_mode"=>\PDO::FETCH_ASSOC,
					"retornar_resultset"=>true
				];
				$cursorCarregamento = FuncoesSql::getInstancia()->executar_sql($params_sql);
				if (gettype($cursorCarregamento["data"]) === "array" && count($cursorCarregamento["data"]) > 0) {
					$comando_sql = "delete from " .$nometabela . " where numcar='".$cursorCarregamento["data"]["numcar"]."'";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);					
					$comando_sql = "delete from sjdacompentregapagcar where numcar='".$cursorCarregamento["data"]["numcar"]."'";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "commit";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
				} 

				/*insere o cabecalho do carregamento */
				$camposInsert = [];
				foreach($cursorCarregamento["fields"] as $campo) {
					if (property_exists($entrega_recebida,$campo)){
						$camposInsert[$campo] = $entrega_recebida->{$campo};
					}
				}	
				self::prepararValoresInclusao($camposInsert);
				$comando_sql = "insert into " .$nometabela . "(" . implode(",",array_keys($camposInsert)) . ") values (".implode(",",$camposInsert).")";				
				FuncoesSql::getInstancia()->executar_sql($comando_sql);


				/*insercao pagamentos*/
				$nometabela = "sjdacompentregapagcar";
				$params_sql = [
					"query"=>"select * from ".$nometabela." where 1=2",
					"fetch"=>"fetch",
					"fetch_mode"=>\PDO::FETCH_ASSOC,
					"retornar_resultset"=>true
				];
				$cursorPags = FuncoesSql::getInstancia()->executar_sql($params_sql);

				$camposInsertPags = [];
				foreach($entrega_recebida->pagamentos as $pag) {
					$camposInsertPags = [];
					foreach($cursorPags["fields"] as $campo) {
						if (property_exists($pag,$campo)) {
							$camposInsertPags[$campo] = $pag->{$campo};
						}
					}
					self::prepararValoresInclusao($camposInsertPags);
					$comando_sql = "insert into " .$nometabela . "(" . implode(",",array_keys($camposInsertPags)) . ") values (".implode(",",$camposInsertPags).")";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "commit";
				}
				FuncoesSql::getInstancia()->fechar_cursor($cursorPags);
				$comando_sql = "commit";				
				FuncoesSql::getInstancia()->executar_sql($comando_sql);
				FuncoesSql::getInstancia()->fechar_cursor($cursorCarregamento);
				
				$comhttpsimples->r["carregamento_gravado"] = "s";				
				$retorno = "Carregamento gravado com sucesso";
				$comhttpsimples->r["mensagem_retorno"] = $retorno;
			} catch(\Error | \Throwable | \Exception $e) {				
				FuncoesSql::getInstancia()->fechar_cursor($cursorCarregamento);
				$comhttpsimples->r["carregamento_gravado"] = "n";
				$retorno = "Erro ao gravar carregamento: " . serialize($e);
				$comhttpsimples->r["mensagem_retorno"] = $retorno;
			} 				
		}


		public static function incluir_entrega_simples(&$comhttpsimples) {				
			try {
				$comhttpsimples->r["entrega_gravada"] = "n";				
				$comhttpsimples->c["condicionantes"] = FuncoesArray::chaves_associativas($comhttpsimples->c);	
				$entrega_recebida = json_decode($comhttpsimples->c["condicionantes"]["entrega"]);
				$comhttpsimples->r["chavenfe"] = $entrega_recebida->chavenfe;
				$nometabela = "sjdacompentreganotas";
				$params_sql = [
					"query"=>"select * from ".$nometabela." where chavenfe='".$entrega_recebida->chavenfe."'",
					"fetch"=>"fetch",
					"fetch_mode"=>\PDO::FETCH_ASSOC,
					"retornar_resultset"=>true
				];
				$cursorNota = FuncoesSql::getInstancia()->executar_sql($params_sql);
				if (gettype($cursorNota["data"]) === "array" && count($cursorNota["data"]) > 0) {
					//print_r($cursorNota["data"]);exit();
					$comando_sql = "delete from " .$nometabela . " where chavenfe='".$cursorNota["data"]["chavenfe"]."'";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);					
					$comando_sql = "delete from sjdacompentregapag where chavenfe='".$cursorNota["data"]["chavenfe"]."'";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "delete from sjdacompentregaprod where chavenfe='".$cursorNota["data"]["chavenfe"]."'";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "commit";
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
				} 

				/*insere o cabecalho da nota */
				$camposInsert = [];
				foreach($cursorNota["fields"] as $campo) {
					if (property_exists($entrega_recebida,$campo)){
						$camposInsert[$campo] = $entrega_recebida->{$campo};
					}
				}	
				self::prepararValoresInclusao($camposInsert);
				$comando_sql = "insert into " .$nometabela . "(" . implode(",",array_keys($camposInsert)) . ") values (".implode(",",$camposInsert).")";
				
				FuncoesSql::getInstancia()->executar_sql($comando_sql);
				$comando_sql = "commit";
				FuncoesSql::getInstancia()->executar_sql($comando_sql);


				/*insercao produtos*/
				$nometabela = "sjdacompentregaprod";
				$params_sql = [
					"query"=>"select * from ".$nometabela." where 1=2",
					"fetch"=>"fetch",
					"fetch_mode"=>\PDO::FETCH_ASSOC,
					"retornar_resultset"=>true
				];
				$cursorItens = FuncoesSql::getInstancia()->executar_sql($params_sql);
				$camposInsertItem = [];
				foreach($entrega_recebida->itens as $item) {
					$camposInsertItem = [];
					foreach($cursorItens["fields"] as $campo) {
						if (property_exists($item,$campo)) {
							$camposInsertItem[$campo] = $item->{$campo};
						}
						$camposInsertItem["statusentrega"] = 4;
					}

					self::prepararValoresInclusao($camposInsertItem);

					$comando_sql = "insert into " .$nometabela . "(" . implode(",",array_keys($camposInsertItem)) . ") values (".implode(",",$camposInsertItem).")";
					//echo $comando_sql; exit();
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "commit";
				}
				FuncoesSql::getInstancia()->fechar_cursor($cursorItens);


				/*insercao pagamentos*/
				$nometabela = "sjdacompentregapag";
				$params_sql = [
					"query"=>"select * from ".$nometabela." where 1=2",
					"fetch"=>"fetch",
					"fetch_mode"=>\PDO::FETCH_ASSOC,
					"retornar_resultset"=>true
				];
				$cursorPags = FuncoesSql::getInstancia()->executar_sql($params_sql);

				$camposInsertPags = [];
				foreach($entrega_recebida->pagamentos as $pag) {
					$camposInsertPags = [];
					foreach($cursorPags["fields"] as $campo) {
						if (property_exists($pag,$campo)) {
							$camposInsertPags[$campo] = $pag->{$campo};
						}
					}

					self::prepararValoresInclusao($camposInsertPags);

					$comando_sql = "insert into " .$nometabela . "(" . implode(",",array_keys($camposInsertPags)) . ") values (".implode(",",$camposInsertPags).")";
					//echo $comando_sql; exit();
					FuncoesSql::getInstancia()->executar_sql($comando_sql);
					$comando_sql = "commit";
				}
				FuncoesSql::getInstancia()->fechar_cursor($cursorPags);
				


				FuncoesSql::getInstancia()->fechar_cursor($cursorNotas);
				
				$comhttpsimples->r["entrega_gravada"] = "s";				
				$retorno = "Entrega gravada com sucesso";
				$comhttpsimples->r["mensagem_retorno"] = $retorno;
			} catch(\Error | \Throwable | \Exception $e) {				
				FuncoesSql::getInstancia()->fechar_cursor($cursorItens);
				FuncoesSql::getInstancia()->fechar_cursor($cursorPags);
				FuncoesSql::getInstancia()->fechar_cursor($cursorNotas);
				$comhttpsimples->r["entrega_gravada"] = "n";
				$retorno = "Erro ao gravar entrega: " . serialize($e);
				$comhttpsimples->r["mensagem_retorno"] = $retorno;
			} 				
		}


		public static function obterCodVendedor(&$comhttp){
			if (!isset($_SESSION["codvendedor"])) {
				$comando_sql = "
					SELECT
						v.cod
					FROM
						ep.epusuarios u
						join ep.epvendedores v on v.cod = u.codvendedor
					WHERE
						u.cod = " . $_SESSION["codusur"];				
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_COLUMN);
				if (FuncoesString::strTemValor($dados)){
					$_SESSION["codvendedor"] = $dados;
				}
			}
			return ($_SESSION["codvendedor"] ?? null);
		}

		public static function obterCodsVendedoresUsuario(&$comhttp){
			if (!isset($_SESSION["codsvendedores"])) {
				$comando_sql = "
					SELECT
						v.cod
					FROM
						ep.epusuarios u
						join ep.epvendedores v on v.cod = u.codvendedor
						join ep.eptrabalhadores t on t.cod = v.codtrabalhador
					WHERE
						u.cod = " . $_SESSION["codusur"] . " 
						or t.codsup = ". $_SESSION["codusur"] ;
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN);
				if (count($dados)){
					$dados = array_unique($dados);
					$_SESSION["codsvendedores"] = $dados;
				}
			}
			return implode(",",$_SESSION["codsvendedores"] ?? []);
		}


		public static function obterCodsFiliaisUsuario(&$comhttp){
			if (!isset($_SESSION["codsfiliaisusuario"])) {
				$comando_sql = "
					SELECT
						distinct
						case 
							when r.codobjetosql1 = 406 then r.valorcampoobjetosql1 
							else r.valorcampoobjetosql2
						end as valorobjetosql2
					FROM
						ep.eprelacionamentosdados r
					where
						(
							r.codobjetosql1 = 436
							and r.nomecampoobjetosql1 = 'cod'
							and r.valorcampoobjetosql1 = ".$_SESSION["codusur"]."
							and r.codobjetosql2 = 406
							and r.nomecampoobjetosql2 = 'cod'
						) or (
							r.codobjetosql2 = 436
							and r.nomecampoobjetosql2 = 'cod'
							and r.valorcampoobjetosql2 = ".$_SESSION["codusur"]."
							and r.codobjetosql1 = 406
							and r.nomecampoobjetosql1 = 'cod'
						)		
				";
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN);
				if (count($dados)){
					$dados = array_unique($dados);
					$_SESSION["codsfiliaisusuario"] = $dados;
				}
			}
			return implode(",",$_SESSION["codsfiliaisusuario"] ?? []);
		}


		public static function obterCodsAdministradoresUsuario(&$comhttp){
			if (!isset($_SESSION["codsadministradores"])) {
				$comando_sql = "
					SELECT
						t.codsup
					FROM
						ep.epusuarios u
						left outer join ep.epvendedores v on v.cod = u.codvendedor
						left outer join ep.eptrabalhadores t on t.cod in (u.codtrabalhador,v.codtrabalhador)
					WHERE
						u.cod = " . $_SESSION["codusur"] . " 
						or t.codsup = ". $_SESSION["codusur"];
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN);
				if (count($dados)){
					$dados = array_unique($dados);
					$_SESSION["codsadministradores"] = $dados;
				}
			}
			return implode(",",$_SESSION["codsadministradores"] ?? []);
		}


		public static function obterCodsTrabalhadoresUsuario(&$comhttp){
			if (!isset($_SESSION["codstrabalhadores"])) {
				$comando_sql = "
					SELECT
						t.cod
					FROM
						ep.epusuarios u
						left outer join ep.epvendedores v on v.cod = u.codvendedor
						left outer join ep.eptrabalhadores t on t.cod in (u.codtrabalhador,v.codtrabalhador)
					WHERE
						u.cod = " . $_SESSION["codusur"] . "
						or t.codsup = " . $_SESSION["codusur"] ;
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN);
				if (count($dados)){
					$dados = array_unique($dados);
					$_SESSION["codstrabalhadores"] = $dados;
				}
			}
			return implode(",",$_SESSION["codstrabalhadores"] ?? []);
		}

		public static function obterCodsVendedoresFiliaisUsuario(&$comhttp){
			$filiais = self::obterCodsFiliaisUsuario($comhttp);
			if (!isset($_SESSION["codsvendedoresfilial"])) {
				$comando_sql = "
					SELECT
						v.cod
					FROM
						ep.epvendedores v
						left outer join ep.eptrabalhadores t on t.cod = v.codtrabalhador
					WHERE
						t.codfilial in ($filiais)";					
				$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN);
				if (count($dados)){
					$dados = array_unique($dados);
					$_SESSION["codsvendedoresfilial"] = $dados;
				}
			}
			return implode(",",$_SESSION["codsvendedoresfilial"] ?? []);
		}
	}
?>