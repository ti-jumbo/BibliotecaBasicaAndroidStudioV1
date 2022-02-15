<?php
    namespace SJD\php\classes\funcoes;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

    use SJD\php\classes\{
        ClasseBase
    };
    use SJD\php\classes\constantes\Constantes;
    /*use SJD\php\classes\funcoes\{

    }*/

    /**
     * Classe com funcoes genericas referentes a processos sql.
     * 
     * @author Antonio ALENCAR Velozo
     * @created 05/02/2021
     */
    class FuncoesProcessoSql extends ClasseBase {	

        /**
         * prepara as condicionantes do processo sql
         * @created 05/02/2022
         * @param &$condicionantes - as condicionantes
         * @return array - o array de condicionantes preparadas para o processo
         */
        public static function prepararCondicionantesProcessoSql(&$condicionantes) : array {
			$cnj_condicionantes = null;
			$cnj_condicionantes_processo = [];
			if (gettype($condicionantes) !== "array") {
				if (in_array(gettype($condicionantes),["object","resource"])) {
					$condicionantes = stream_get_contents($condicionantes);
				}
				$cnj_condicionantes = strtolower(trim($condicionantes));
				$cnj_condicionantes = explode(strtolower(trim(Constantes::sepn1)), $cnj_condicionantes);
			} else {
				$cnj_condicionantes = $condicionantes;
			}
			foreach ($cnj_condicionantes as $chave_condic => $condic) {
				if (gettype($condic) !== "array") {
					if (in_array(gettype($condic),["object","resource"])) {
						$condic = stream_get_contents($condic);
					}
					$cnj_condicionantes[$chave_condic] = explode(strtolower(trim(Constantes::sepn2)), $condic);
				}		
			}
			FuncoesArray::array_eliminar_elementos_vazios($cnj_condicionantes);	
			FuncoesMontarSql::extrair_montar_condicionantes_linear__rec($cnj_condicionantes, $cnj_condicionantes_processo);
			return $cnj_condicionantes_processo;
		}

        /**
         * processa um texto que contenha uma expressao 'return ...;' em seu corpo, executando o codigo php correspondente e 
         * substituindo o resultado pelo retorno do codigo executado
         * @created 05/02/2022
         * @param array|object &$comhttp - o objeto comhttp padrao
         * @param string $valor - o valor a avaliar e evoluir
         * @return string - o valor recebido como paramtro e executado o codigo
         */
        public static function processarEval(array|object &$comhttp,string $valor) : string{
			$pos_return = stripos($valor,"return ");
			if ($pos_return !== false) {
				$pos_final = stripos($valor,";",$pos_return);
				$qt_carac = ($pos_final - $pos_return) + 1 ;
				$texto_eval = substr($valor,$pos_return,$qt_carac);
				$valor_eval = eval($texto_eval);
				$valor = str_ireplace($texto_eval,$valor_eval,$valor);				
			}
			return $valor;
		}

		/**
		 * obtem criterios de acesso em funcao dos parametros passados, geralmente utilizada de forma avulsa por outros
		 * processos. Em processos, eh mais eficiente embutir esse sql no sql que obtem os dados do processo para ja retornar se ha o 
		 * acesso ou nao e seus criterios no proprio sql de obtencao dos dados.
		 * @created 14/02/2022
		 * @param object &$comhttp - o objeto de comunicacao padrao (necessario para processar eval)
		 * @param array|string|int $params = [] - os parametros
		 * @return array - o retorno informando permissao e criterios
		 */
		public static function obterCriteriosAcesso(object &$comhttp, array|string|int $params = []) : array {
			$params = $params ?? [];
			if (in_array(gettype($params),["string","number","numeric","integer"])) {
				$params = [
					"codobjetosql"=>$params
				];
			}
			$params["codusur"] = $params["codusur"] ?? $_SESSION["codusur"];
			$params["codtipoobjetosql"] = $params["codtipoobjetosql"] ?? 300;
			$params["codobjetosql"] = $params["codobjetosql"] ?? "null";
			$params["permissao"] = $params["permissao"] ?? "permiteler";
			$comando_sql = "select 
				ac.codtipoobjetosql,
				ac.codobjetosql,
				ac.codprocessosql,
				ac.codobjetoprocessosql,
				min(nvl(ac.".$params["permissao"].",0)) as ".$params["permissao"].",
				listagg(ac.criteriosacessosler, ' and ') within group (order by ac.cod) as criteriosacessosler
			from
				ep.epacessossql ac,
				ep.epusuarios u,
				ep.epobjetossql o
			where
				nvl(ac.codperfilusuario,u.codperfilusuario) = u.codperfilusuario
				and nvl(ac.codusuario,u.cod) = u.cod
				and nvl(ac.codobjetosql,o.cod) = o.cod
				and u.cod = ".$params["codusur"]."
				and nvl(ac.codtipoobjetosql,".$params["codtipoobjetosql"].") = ".$params["codtipoobjetosql"]."
				and (nvl(to_char(ac.codobjetosql),'".$params["codobjetosql"]."') = '".$params["codobjetosql"]."'
					or lower(trim(o.nomeobjetosqldb)) = lower(trim('".$params["codobjetosql"]."'))
				)
			group by
				ac.codtipoobjetosql,
				ac.codobjetosql,
				ac.codprocessosql,
				ac.codobjetoprocessosql";
			$dados_acesso = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
			$retorno = [];
			$retorno["permitido"] = FuncoesConversao::como_boleano($dados_acesso[$params["permissao"]] ?? false);
			$retorno["criterios"] = $dados_acesso["criteriosacessosler"] ?? "";
			$retorno["temcriterios"] = FuncoesString::strTemValor($retorno["criterios"]);
			if ($retorno["temcriterios"]) {
				if (FuncoesString::strTemValor($params["aliastabela"]??null)) {
					$retorno["criterios"] = " and ".str_ireplace("__ALIAS_TABELA__",$params["aliastabela"],$retorno["criterios"]);
				}

				$contador_loops = 0;
				while (stripos($retorno["criterios"]."","return ") !== false) {
					//echo $valor.chr(10);
					$retorno["criterios"] = self::processarEval($comhttp,$retorno["criterios"]);					
					$contador_loops++;
					if ($contador_loops > 1000) {
						print_r($retorno["criterios"]);
						FuncoesBasicasRetorno::mostra_msg_sair("Excesso de loops",__FILE__,__FUNCTION__,__LINE__);
					}
				}
			}
			return $retorno;
		}

        /**
         * obtem dados dos componentes dos processos sql
         * @created 05/02/2021
         * @param array &$processos - o array de processos a montar o sql
         * @return void 
         */
        private static function obterDadosProcessos(array &$processos) : void { 
            /* (sql recursive connect by)*/ 
            if (isset($processos) && $processos != null && gettype($processos) == "array" && count($processos) > 0) {
                foreach($processos as $chave=>$processo) {
                    /*query do tipo sql recursive para obter os elementos do processo, pois elementos sao aninhados em profundidade
                    indefinida devido a estarem na mesma tabela e serem relacionados com os campos cod e codsup.
                     traz tambem dados do acesso, se existirem*/
                    $params_query = [
                        "query"=>"
                            select 
                                d.cod,
                                d.codorigeminfo,
                                d.codsup,
                                d.codprocesso,
                                d.codtipoobjetosql,
                                d.codobjetosql,
                                d.textosqlantes,
                                d.textosql,
                                d.textosqlapos,
                                d.criterioexistencia,
                                d.ordem,
                                d.alias,
                                d.titulo,
                                d.tipodado,
                                d.classecss,
                                d.codstatusreg,
                                min(ac.permiteler) as permiteler,
                                listagg(ac.criteriosacessosler, ' and ') within group (order by 1) as criteriosacessosler
                            from 
                                (
                                    select 
                                        d.*
                                    from 
                                        ep.epobjetosprocessosql d     
                                    connect by prior 
                                        d.cod = d.codsup
                                    start with 
                                        d.codprocesso = ".$processo["cod"]." and codsup is null
                                    order by 
                                        nvl(d.codsup,-1),
                                        d.ordem
                                ) d
                                left outer join (
                                    select 
                                        ac.codtipoobjetosql,
                                        ac.codobjetosql,
                                        ac.codprocessosql,
                                        ac.codobjetoprocessosql,
                                        min(nvl(ac.permiteler,0)) as permiteler,
                                        listagg(ac.criteriosacessosler, ' and ') within group (order by ac.cod) as criteriosacessosler
                                    from
                                        ep.epacessossql ac,
                                        ep.epusuarios u
                                    where
                                        nvl(ac.codperfilusuario,u.codperfilusuario) = u.codperfilusuario
                                        and nvl(ac.codusuario,u.cod) = u.cod
                                        and u.cod = ".$_SESSION["codusur"]."
                                    group by
                                        ac.codtipoobjetosql,
                                        ac.codobjetosql,
                                        ac.codprocessosql,
                                        ac.codobjetoprocessosql
                                ) ac on (
                                    nvl(ac.codtipoobjetosql,d.codtipoobjetosql) = d.codtipoobjetosql
                                    and nvl(ac.codobjetosql,d.codobjetosql) = d.codobjetosql
                                    and nvl(ac.codprocessosql,d.codprocesso) = d.codprocesso
                                    and nvl(ac.codobjetoprocessosql,d.cod) = d.cod
                                )
                            group by
                                d.cod,
                                d.codorigeminfo,
                                d.codsup,
                                d.codprocesso,
                                d.codtipoobjetosql,
                                d.codobjetosql,
                                d.textosqlantes,
                                d.textosql,
                                d.textosqlapos,
                                d.criterioexistencia,
                                d.ordem,
                                d.alias,
                                d.titulo,
                                d.tipodado,
                                d.classecss,
                                d.codstatusreg
                            order by
                                nvl(d.codsup,-1),
                                d.ordem",
                        "fetch"=>"fetchAll",
                        "fetch_mode"=>\PDO::FETCH_ASSOC				
                    ];
                    $elementos = FuncoesSql::getInstancia()->executar_sql($params_query);
                    $elementos_por_cod = [];
                    foreach($elementos as $chaveel=>$elemento) {
                        $elementos_por_cod[$elementos[$chaveel]["cod"]] = $elementos[$chaveel];
                    }
                    $processos[$chave]["elementos"] = $elementos_por_cod;
                    $processos[$chave]["elementos"] = FuncoesArray::estruturar_array($processos[$chave]["elementos"]);
                }
            }
        }


        /**
         * unifica elementos de processos sql, parte do processo de unificar processos
         * @created 05/02/2022
         * @param array &$elemento_unificado - o elemento resultante unificado
         * @param array $processo_unificar - o processo ao qual o elemento a ser unificado pertence
         * @param array $elemento_unificar - o elemento que sera unificado
         * @param bool $somente_verificar - se a funcao deve unificar ou somente verificar se existe no elemento unificado
         * @todo substituir os literais de codtipoobjetosql por consulta a esses dados num array, obtido uma unica vez por conexao
         */
        private static function unificarSubelementosProcessoSql(array &$elemento_unificado, array $processo_unificar, array $elemento_unificar, bool $somente_verificar = false) : bool{
			if (isset($elemento_unificar) && $elemento_unificar != null && gettype($elemento_unificar) === "array") {
				if (isset($elemento_unificar["sub"]) && $elemento_unificar["sub"] !== null && gettype($elemento_unificar["sub"]) === "array") {
					if (!isset($elemento_unificado["ordemsubatual"]) && !$somente_verificar) {
						$elemento_unificado["ordemsubatual"] = 0;
						/*para subs de select, tipo field, gera nova ordem baseada na ordem das visoes, 
						a fim de manter a ordem das visoes do cliente*/
						if (in_array($elemento_unificado["codtipoobjetosql"]-0,[1000])) {
							if (isset($elemento_unificado["sub"]) && count($elemento_unificado["sub"]) > 0) {
								foreach($elemento_unificado["sub"] as &$sub) {
									if (in_array($sub["codtipoobjetosql"]-0,[400])) {
										$sub["ordem"] = $elemento_unificado["ordemsubatual"];
										$elemento_unificado["ordemsubatual"]++;
									}
								}
							}
						}
					}
					if (!(isset($elemento_unificado["sub"]) && count($elemento_unificado["sub"]) > 0)) {
						if (count($elemento_unificar["sub"]) > 0) {
							if ($somente_verificar) {
								return false;
							} else {
								$elemento_unificado["sub"] = $elemento_unificar["sub"];
								/*para subs de select, tipo field, gera nova ordem baseada na ordem das visoes, 
								a fim de manter a ordem das visoes do cliente*/
								if (in_array($elemento_unificado["codtipoobjetosql"]-0,[1000])) {
									foreach($elemento_unificado["sub"] as &$sub) {
										if (in_array($sub["codtipoobjetosql"]-0,[400])) {
											$sub["ordem"] = $elemento_unificado["ordemsubatual"];
											$elemento_unificado["ordemsubatual"]++;
										}
									}
								}
							}
						}
					} else {
						foreach($elemento_unificar["sub"] as $chave_sub=>$sub_unificar){
							$texto_sql_unificar = trim($sub_unificar["textosqlantes"] . $sub_unificar["textosql"] . $sub_unificar["textosqlapos"] . $sub_unificar["alias"]);
							$existe_sub_unificado = false;
							foreach($elemento_unificado["sub"] as $chave_sub_u => &$sub_unificado) {
								$texto_sql_unificado = trim($sub_unificado["textosqlantes"] . $sub_unificado["textosql"] . $sub_unificado["textosqlapos"] . $sub_unificado["alias"]);							
								if (strcasecmp($texto_sql_unificado,$texto_sql_unificar) == 0) {
									if ($somente_verificar) {
										return true;
									} else {
										/*caso seja um join(1150), somente nao repete se o sub(table) for igual, senao deve repetir o join*/
										if ($sub_unificado["codtipoobjetosql"] == 1150) {
											$somente_verificar_antes = $somente_verificar;
											$sub_igual = self::unificarSubelementosProcessoSql($sub_unificado,$processo_unificar,$sub_unificar,true);											
											$somente_verificar = $somente_verificar_antes;
											if ($sub_igual) {
												$existe_sub_unificado = true;
												break;
											} else {
												$existe_sub_unificado = false;
												break;
											}
										} else {
											self::unificarSubelementosProcessoSql($sub_unificado,$processo_unificar,$sub_unificar,$somente_verificar);
											$existe_sub_unificado = true;
											break;
										}
									}
								}
							}
							if (!$existe_sub_unificado) {
								if ($somente_verificar) {
									return false;
								} else {
									/*processo condicionante nao deve incluir campos do select*/
									if ($processo_unificar["criteriouso"] === "condicionante") {
										if ($sub_unificar["codtipoobjetosql"] != 400) {
											/*para subs de select, tipo field, gera nova ordem baseada na ordem das visoes, processos estao ordenados por visoes*/
											if (in_array($elemento_unificado["codtipoobjetosql"]-0,[1000])) {
												if (in_array($sub_unificar["codtipoobjetosql"]-0,[400])) {
													$sub_unificar["ordem"] = $elemento_unificado["ordemsubatual"];
													$elemento_unificado["ordemsubatual"]++;
												}
											}
											$elemento_unificado["sub"][] = $sub_unificar;	
										}
									} else {
										/*para subs de select, tipo field, gera nova ordem baseada na ordem das visoes, processos estao ordenados por visoes*/
										if (in_array($elemento_unificado["codtipoobjetosql"]-0,[1000])) {
											if (in_array($sub_unificar["codtipoobjetosql"]-0,[400])) {
												$sub_unificar["ordem"] = $elemento_unificado["ordemsubatual"];
												$elemento_unificado["ordemsubatual"]++;
											}
										}
										$elemento_unificado["sub"][] = $sub_unificar;
									}
								}
							} 
						}
					}
				}
			}
            return false;			
		}



        /**
         * unifica os processos em um so por sobreposicao posicional, inserindo no processo resultante
         * apenas itens que ainda nao estejam nele.
         * @created 05/02/2021
         * @param array|object &$comhttp - o objeto comhttp padrao
         * @param array &$processo_unificado - o processo unificado resultante
         * @param array &$processo_unificar - o processo a ser unificado no processo unificado
         */
        private static function unificarProcessosSql(array|object &$comhttp,&$processo_unificado, $processo_unificar) {
			if (!($processo_unificado != null && count($processo_unificado) > 0)) {
				$processo_unificado = $processo_unificar;
			} else {
				if (!isset($processo_unificado["elementos"])) {
					$processo_unificado["elementos"] = $processo_unificar["elementos"];
				}
				if (isset($processo_unificar["elementos"]) && count($processo_unificar["elementos"]) > 0) {				
					foreach($processo_unificar["elementos"] as $chaveel => $elemento_unificar) {
						$texto_sql_unificar = trim($elemento_unificar["textosqlantes"] . $elemento_unificar["textosql"] . $elemento_unificar["textosqlapos"] . $elemento_unificar["alias"]);
						$existe_unificado = false;
						foreach($processo_unificado["elementos"] as $chaveelu => &$elemento_unificado) {
							$texto_sql_unificado = trim($elemento_unificado["textosqlantes"] . $elemento_unificado["textosql"] . $elemento_unificado["textosqlapos"] . $elemento_unificado["alias"]);							
							if (strcasecmp($texto_sql_unificado,$texto_sql_unificar) == 0) {
								self::unificarSubelementosProcessoSql($elemento_unificado,$processo_unificar,$elemento_unificar);
								$existe_unificado = true;
								break;
							}
						}
                        /*se nao existir, insere*/
						if (!$existe_unificado) {
							$processo_unificado["elementos"][] = $elemento_unificar;
						} 
					}
					
				}
			}
		}


        /**
         * verifica se os elementos atentem a criterios de existencia armazenados no campo criterioexistencia do elemento
         * @created 05/02/2022
         * @param array|object &$comhttp - o objeto padrao comhttp
         * @param array &$elemento - o elemento a verificar
         * @return bool - se o elemento deve existir ou nao nesse processo
         */
        private static function processarCriteriosExistenciaElementoProcessoSql(array|object &$comhttp,array &$elemento) : bool {
			if (isset($elemento) && $elemento !== null && gettype($elemento) === "array") {
				if (FuncoesString::strTemValor($elemento["criterioexistencia"])) {
					/**/
					$valor = $elemento["criterioexistencia"];
					$valor = self::processarEval($comhttp,$valor);
					$valor = FuncoesConversao::como_boleano($valor);
					if ($valor) {
						if (isset($elemento["sub"]) && $elemento["sub"] !== null && gettype($elemento["sub"]) === "array") {				
							foreach($elemento["sub"] as $chavesub=>&$sub) {
								$valorsub = self::processarcriteriosexistenciaelementoprocessosql($comhttp,$sub);
								if (!$valorsub){
									unset($elemento["sub"][$chavesub]);
								}
							}
						}
					}
					return $valor;
				}
			}
			return false;
		}



        /**
         * processa os criterios de acesso do elemento, se for tabela, para que exista no processo, o perfil
         * do usuario deve ter acesso a tabela.
         * @created 05/02/2022
         * @param array|object &$comhttp - o objeto comhttp padrao
         * @param array &$elemento - o elemento a verificar o acesso
         * @param array &$selectSuperior - o select ao qual o elemento pertence
         * @return bool - se o acesso eh permitido ou nao
         */
        private static function processarCriteriosAcessoElementoProcessoSql(array|object &$comhttp,array &$elemento,array &$selectSuperior) : bool{
			$retorno = true;
			if (isset($elemento) && $elemento !== null && gettype($elemento) === "array") {				
				$ehTabela = $elemento["codtipoobjetosql"] == 300;
				$permitido = FuncoesConversao::como_boleano($elemento["permiteler"] ?? false);
				$criterios = $elemento["criteriosacessosler"] ?? "";
				$temCriterios = FuncoesString::strTemValor($criterios);

				if ($ehTabela && $temCriterios) {
					$criterios = str_ireplace("__ALIAS_TABELA__",$elemento["alias"],$criterios);
				}

				if (!$ehTabela || $permitido || $temCriterios ) {
					
					/*se houver criterios, o sub where do select tem que ser encontrado/incluido e colocado o criterio*/
					if ($temCriterios){					
						$selectSuperior["sub"] = $selectSuperior["sub"] ?? [];
						$temWhere = false;
						foreach($selectSuperior["sub"] as $chavesubselect=>&$subselect){							
							if ($subselect["codtipoobjetosql"] == 1200) {
								$temWhere = true;
								$selectSuperior["sub"][$chavesubselect]["sub"][] = [
									"codsup"=>$selectSuperior["sub"][$chavesubselect]["cod"],
									"codtipoobjetosql"=>10000,
									"textosql"=>$criterios,
									"ordem"=>999,									
									"codstatusreg"=>1
								];
								break;
							}
						}
						/*cria o elemento where caso nao exista no select*/
						if (!$temWhere) {
							$selectSuperior["sub"][] = [
								"codsup" => ($selectSuperior["cod"]??null),
								"codtipoobjetosql"=>1200,
								"textosql"=>"where",
								"ordem"=>999,
								"codstatusreg"=>1,
								"sub"=>[
									[
										"codtipoobjetosql"=>10000,
										"textosql"=>$criterios,
										"ordem"=>999,									
										"codstatusreg"=>1
									]
								]
							];
						}
					}
					
					if (isset($elemento["sub"]) && $elemento["sub"] !== null && gettype($elemento["sub"]) === "array") {				
						foreach($elemento["sub"] as $chavesub=>&$sub) {
							if ($elemento["codtipoobjetosql"] == 1000) {
								$permitidosub = self::processarCriteriosAcessoElementoProcessoSql($comhttp,$sub,$elemento);
							} else {
								$permitidosub = self::processarCriteriosAcessoElementoProcessoSql($comhttp,$sub,$selectSuperior);
							}
							if (!$permitidosub){
								if ($elemento["codtipoobjetosql"] == 1150) {
									$retorno = false;
									break;
								} else {
									unset($elemento["sub"][$chavesub]);
								}
							}
						}
					}
				} elseif ($ehTabela && !$permitido) {
					$retorno = false;
				}  
			}
			return $retorno;
		}



        /**
         * ordena os subelementos do processo, conforme o campo ordem
         * @created 05/02/2022
         * @param array &$elemento - o elemento cujos sub elementos devem ser ordenados
         * @return void
         */
        private static function ordenarSubElementosProcessoSql(array &$elemento) : void {
			if (isset($elemento) && $elemento !== null && gettype($elemento) === "array") {
				if (isset($elemento["sub"]) && $elemento["sub"] !== null && gettype($elemento["sub"]) === "array") {
					$elemento["sub"] = FuncoesArray::ordenar_por_chave($elemento["sub"],"ordem");
					foreach($elemento["sub"] as &$subelemento) {
						self::ordenarSubElementosProcessoSql($subelemento);
					}
				}
			}			
		}



        /**
         * monta o comando sql do elemento do processo sql
         * @created 05/02/2022
         * @param array|object &$comhttp - objeto comhttp padrao
         * @param array &$elemento - o elemento a ser montado
         * @param array $elementosup - o elmeento superior do elemento a ser montado
         * @return string - o comando sql montado
         */
        private static function montarComandoSqlElemento(array|object &$comhttp,array &$elemento,array $elementosup=null) : string{
			$retorno = "";
			if (isset($elemento) && $elemento !== null && gettype($elemento) === "array") {
				foreach($elemento as $chave=>&$valor) {
					if ($chave != "sub" && $valor !== null && gettype($valor) !== "array") {
						$contador_loops = 0;
						while (stripos($valor."","return ") !== false) {
							//echo $valor.chr(10);
							$valor = self::processarEval($comhttp,$valor);					
							$contador_loops++;
							if ($contador_loops > 1000) {
								print_r($valor);
								FuncoesBasicasRetorno::mostra_msg_sair("Excesso de loops",__FILE__,__FUNCTION__,__LINE__);
							}
						}
						
					}
				}
				$retorno .= " " . ($elemento["textosqlantes"] ?? "") . " " . $elemento["textosql"] . " ";
				if (!in_array($elemento["codtipoobjetosql"]-0,[1000,1600,1650])) {
					$retorno .= " " .($elemento["textosqlapos"] ?? "") . " " . ($elemento["alias"] ?? ""). " " ;
				}
				
				/*verifica se tem o parenteses ( '(' ) caso elemento superior seja from e subelemento seja select (primeiro select somente)*/ 
				if (isset($elementosup) && $elementosup !== null && $elementosup["codtipoobjetosql"] == 1100 && $elemento["codtipoobjetosql"] == 1000) {
					if ($elementosup["sub"][array_key_first($elementosup["sub"])]["cod"] == $elemento["cod"]) {
						if (strpos(trim($retorno),"(") !== 0) {
							$retorno = " (" . $retorno;
						}
					}
				}

				if (isset($elemento["sub"]) && $elemento["sub"] !== null && gettype($elemento["sub"]) === "array") {
					$retorno_subs = [];
					foreach($elemento["sub"] as &$subelemento) {
						$retorno_sub = self::montarComandoSqlElemento($comhttp,$subelemento,$elemento);
						if (FuncoesString::strTemValor($retorno_sub)) {
							$retorno_subs[] = $retorno_sub;
						}
					}

					if (count($retorno_subs) > 0) {
						if (in_array($elemento["codtipoobjetosql"] - 0,[1000,1300,1500,1600])) {
							$retorno .= implode(",",$retorno_subs);
						} elseif (in_array($elemento["codtipoobjetosql"] - 0,[1155,1200,1400])) {
							$retorno_subs = array_unique($retorno_subs);
							$retorno .= implode(" and ",$retorno_subs);
						} else {
							$retorno .= implode(" " , $retorno_subs);
						}
					}
				}

				/*correcoes no codigo gerado*/
				$retorno = trim($retorno);
				$retorno = preg_replace('/\,\s*from/i',' from',$retorno);
				$retorno = preg_replace('/\,\s*where/i',' where',$retorno);
				$retorno = preg_replace('/\,\s*pivot/i',' pivot',$retorno);
				$retorno = preg_replace('/\,\s*for/i',' for',$retorno);
				/*$retorno = preg_replace('/\s+and\s+and\s+/i',' and ',$retorno);
				$retorno = preg_replace('/\s+and\s+union\s+/i',' union ',$retorno);
				$retorno = preg_replace('/\s+and\s*\)/i',' ) ',$retorno);*/
				

				if (isset($elementosup) && $elementosup !== null && $elementosup["codtipoobjetosql"] == 1100 && $elemento["codtipoobjetosql"] == 1000) {
					if ($elementosup["sub"][array_key_last($elementosup["sub"])]["cod"] == $elemento["cod"]) {
						if (strpos(trim($retorno),")") !== strlen(trim($retorno))-1) {
							$retorno .= ") ";
						}
					}
				}

				if (in_array($elemento["codtipoobjetosql"]-0,[1000,1600,1650])) {
					$retorno .= " " . $elemento["alias"] . " " . $elemento["textosqlapos"] . " " ;
				}
				
			}	
			return $retorno;
		}


        /**
         * monta o comando sql do processo unificado
         * @created 05/02/2022
         * @param array|object &$comhttp - o objeto comhttp padrao
         * @param array &$processo_unificado - o processo a ter o comando sql montado
         * @return string - o comando sql montado
         */
        private static function montarComandoSqlProcessoSql(array|object &$comhttp,array &$processo_unificado) : string{
			$retorno = "";			
			if (isset($processo_unificado) && $processo_unificado !== null && gettype($processo_unificado) === "array") {
				foreach($processo_unificado["elementos"] as $elemento) {				
					$retorno .= self::montarComandoSqlElemento($comhttp,$elemento);
				}
			}
			return $retorno;
		}



        /**
         * monta o sql estruturado.
         * @created 05/02/2021
         * @param array | object &$comhttp - o objeto comhttp padrao
         * @param array &$processos - os processos a montar
         * @return string o comando sql montado
         */
        public static function montarSqlProcessoEstruturado(array | object &$comhttp) : string { 
            $retorno = "";

			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$comhttp->requisicao->requisitar->qual->objeto = explode(",",strtolower(trim($comhttp->requisicao->requisitar->qual->objeto)));
			$visoes_relatorio = [];
			foreach($comhttp->requisicao->requisitar->qual->objeto as $vis) {
				$visoes_relatorio[$vis] = [
					"criteriouso"=>"normal"
				];
			}
			//print_r($visoes_relatorio);exit();
			if (FuncoesRelatorio::verificarTemCondicionanteVisao($comhttp,null)) {
				$visoes_condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
				foreach($visoes_condicionantes as $viscond=>$cond) {
					if (!isset($visoes_relatorio[$viscond])) {
						$visoes_relatorio[$viscond] = [
							"criteriouso"=>"condicionante"
						];
					}
				}
			}
			$comhttp->requisicao->requisitar->qual->objeto[] = "valores";
			$visoes_relatorio["valores"] = [
				"criteriouso"=>"normal"
			];

			/*obtem os codigos dos processos sql em funcao das visoes*/ 
			$params_query = [
				"query"=>"select codprocessosql from ep.epvisoes where lower(trim(descricao)) in ('".strtolower(implode("','",array_keys($visoes_relatorio)))."')",
				"fetch"=>"fetchAll",
				"fetch_mode"=>\PDO::FETCH_COLUMN
			];
			//print_r($params_query);exit();
			$cods_processos = FuncoesSql::getInstancia()->executar_sql($params_query);		
			//print_r($cods_processos);exit();
			/*obtem os dados dos processos*/ 
			$params_query = [
				"query"=>"
					select 
						(
							select
								lower(trim(v.descricao)) as visao
							from
								ep.epvisoes v
							where
								lower(trim(v.descricao)) in ('".strtolower(implode("','",array_keys($visoes_relatorio)))."')
								and v.codprocessosql = p.cod
						) as visao,
						p.* 
					from ep.epprocessossql p
					where p.cod in (".implode(",",$cods_processos).")",
				"fetch"=>"fetchAll",
				"fetch_mode"=>\PDO::FETCH_ASSOC				
			];
			$processos = FuncoesSql::getInstancia()->executar_sql($params_query);
			//print_r($processos);exit();
			/*vincula criterio de uso*/
			foreach($processos as &$dados_processo) {
				$dados_processo["criteriouso"] = $visoes_relatorio[$dados_processo["visao"]]["criteriouso"] ?? "normal";
			}

			/*ordena os processos conforme visoes recebidas do cliente*/
			$arr_ord = [];
			$ord = 0;
			foreach(array_keys($visoes_relatorio) as $visao) {
				$arr_ord[$visao] = $ord;
				$ord++;
			}
			$processos_ordenados = [];			
			foreach($processos as $chave=>$processo) {
				$visao = $processos[$chave]["visao"];
				$processos_ordenados[$arr_ord[$visao]] = $processos[$chave];
			}
			$processos = $processos_ordenados;
			ksort($processos,SORT_NUMERIC);
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];
			//print_r($processos);exit();


            if (isset($processos) && $processos != null && gettype($processos) == "array" && count($processos) > 0) {
                self::obterDadosProcessos($processos);

				//print_r($processos);exit();

                /*unifica processos */
                $processo_unificado = [];
                foreach($processos as $chaveproc=>$processo){
                    self::unificarProcessosSql($comhttp,$processo_unificado,$processo);				
                }
				//print_r($processo_unificado);exit();

                /*elimina  elementos que nao atendem criterios existencia*/			
                foreach($processo_unificado["elementos"] as $chave=>&$elemento){
                    $existencia = self::processarcriteriosexistenciaelementoprocessosql($comhttp,$elemento);
                    if (!$existencia) {
                        unset($processo_unificado["elementos"][$chave]);
                    }
                    $existencia = self::processarCriteriosAcessoElementoProcessoSql($comhttp,$elemento,$processo_unificado["elementos"]);
                    if (!$existencia) {
                        unset($processo_unificado["elementos"][$chave]);
                    }
                }

                /*ordena os subelementos*/
                $processo_unificado["elementos"] = FuncoesArray::ordenar_por_chave($processo_unificado["elementos"],"ordem");
                foreach($processo_unificado["elementos"] as &$elemento){
                    self::ordenarSubElementosProcessoSql($elemento);
                }		
				//print_r($processo_unificado);exit();		

                $retorno = self::montarComandoSqlProcessoSql($comhttp,$processo_unificado);
                
				$array_tit = FuncoesRelatorio::montarArrayTitulos($comhttp,$processo_unificado,$processos);
				$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $array_tit;
            }
            return $retorno;
        }

    }
?>    