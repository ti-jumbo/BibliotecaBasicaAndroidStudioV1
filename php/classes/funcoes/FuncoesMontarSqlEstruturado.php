<?php
	namespace SJD\php\classes\funcoes;	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_resource.php';
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,
		constantes\Constantes,
		variaveis\VariaveisSql
	};	
	use SJD\php\classes\funcoes\{
		FuncoesVariaveis,
		FuncoesSisJD,
		FuncoesBasicasRetorno,
		FuncoesConversao,
		FuncoesArray,
		FuncoesSql,
		requisicao\TComHttp,
		requisicao\FuncoesRequisicao
	};
	

	/*codigo*/


	/**
	 * Esta classe tem por funcao montar um comando sql com base em um processo estruturado.
	 * Um processo estruturado é um conjunto de dados armazenados hierarquicamente, nas tabelas:
	 * -sjdprocessos
	 * -sjdligtabelasis
	 * -sjdligcamposis
	 * -sjdligtabeladb
	 * -sjdligcampodb
	 * -sjdligrelacionamentos
	 * Um processo tem um registro na tabela sjdprocessos e n registros na tabelas seguintes citadas acima, 
	 * de forma que com base nestes registros seja possível montar um comando sql valido.
	 * 
	 * @author Antonio ALENCAR Velozo
	 * @created 28/07/2017
	 * @lastupdate 11/10/2021
	 */
	class FuncoesMontarSqlEstruturado extends ClasseBase {

		/**
		 * processa (eval) os criterios de existencia de uma entidade (ligacoes, campos, etc), retornando se existe ou nao no processo conforme eval
		 * este campo eh uma string armazenada no banco na entidade que ao ser eval executa um codigo php valido que resulta em true or false		 * 
		 * @param {array} - &$dados - o array de dados da entidade
		 * @param {?bool} - $padrao = false - o retorno padrao caso nao exista o campo criterio_existencia
		 */
		public static function processar_criterio_existencia($dados,?bool $padrao = false) : bool {
			if (isset($dados['criterio_existencia']) && strlen(trim(($dados['criterio_existencia']))) > 0) {
				return eval($dados['criterio_existencia']);
			}
			return $padrao;
		}

		/**
		 * mostra o array de processos, utilizada para testes e debug
		 * @param {array} - &$processo - o array de processo do processo
		 */
		private static function mostrar_params(array &$params) : void{
			print_r($params['processos']);
			if (isset($params['ligstabelasis_unicas'])) {
				print_r($params['ligstabelasis_unicas']);
			}
			if (isset($params['resultante_intermediaria'])) {
				print_r($params['resultante_intermediaria']);
			}
			exit();
		}

		/**
		 * acrescenta ou vincula processo do tipo condicionante passado pelos parametros
		 * @param {array} - &$processo - o array de processo do processo
		 * @param {array} - &$cnj_condicionantes_processo - o conjunto das condicionantes
		 * @param {?string} - $prefixo_nome_proc_condic - o prefixo para localizar o processo na tabela de processos pelo nome
		 * @param {?string} - $tradutor_processo_condic - o tratudor para localizar o processo na tabela de processos pelo nome
		 */
		private static function acrescenta_vincula_processos_condicionantes(array &$processos, array &$cnj_condicionantes_processo, ?string $prefixo_nome_proc_condic = 'relatorio_venda_visao_', ?string $tradutor_processo_condic=null) : void {
			foreach ($cnj_condicionantes_processo as $chave_proc_condic => &$condic_proc) {
				$localizado = false;
				$nome_temp_proc = $chave_proc_condic;
				if (isset($tradutor_processo_condic)) {
					if ($tradutor_processo_condic !== null && strlen(trim($tradutor_processo_condic)) > 0) {
						$nome_temp_proc = str_replace(' ', '_', str_ireplace('__proccondic__',$nome_temp_proc,trim($tradutor_processo_condic)));
					} 
				}
				$nome_temp_proc = strtolower(trim(str_replace(' ', '_', trim($prefixo_nome_proc_condic . $nome_temp_proc))));
				/**
				* Tenta encontrar o processo condicionante na lista de processos ja existente, comparando os nomes. 
				*/
				$nome_temp_proc = FuncoesSisJD::corrigir_nome_processo($nome_temp_proc);
				$condic_proc_temp =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo)) = lower(trim('" . $nome_temp_proc."'))", 'unico' => true]);
				foreach ($processos as $chave_proc => &$proc) {
					if ($nome_temp_proc === strtolower(trim($proc['nome']))) {
						$localizado = true;
						$proc['temcondicexplic'] = true;				
						$proc['nome'] = FuncoesSisJD::corrigir_nome_processo($proc['nome']);
						$condic_proc['codprocesso_original'] =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo)) = lower(trim('" . $proc['nome']."'))", 'unico' => true])['codprocesso'];
						if (!isset($proc['condicionantes'])) {
							$proc['condicionantes'] = [];
						}
						$proc['condicionantes'][] = $condic_proc;
						break;
					} else {
						$proc['nome'] = FuncoesSisJD::corrigir_nome_processo($proc['nome']);
						$proc_temp =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo)) = lower(trim('" . strtolower(trim($proc['nome']))."'))", 'unico' => true]);
						if (count($proc_temp) > 0) {
							if (strlen(trim($proc_temp['aceita_condic_proc'])) > 0) {
								if (in_array($condic_proc_temp['codprocesso'],explode(',',trim($proc_temp['aceita_condic_proc'])))) {
									$localizado = true;
									$proc['temcondicexplic'] = true;										
									$condic_proc['codprocesso_original'] = $condic_proc_temp['codprocesso'];
									if (!isset($proc['condicionantes'])) {
										$proc['condicionantes'] = [];
									}
									$proc['condicionantes'][] = $condic_proc;
								}
							}
						}
					}
				}
				if (!$localizado) {
					/**
					* Localiza o processo condicionante na base pelo nome
					*/
					$nome_temp_proc = FuncoesSisJD::corrigir_nome_processo($nome_temp_proc);
					$proc_condic =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo))=lower(trim('".$nome_temp_proc."'))", 'unico' => true]);
					if (count($proc_condic) > 0) {
						/**
						* Se o processo condicionante existir na base, verifica se existe na lista de processos ja existentes processo 
						* que o aceita como condicionante.
						*/
						foreach ($processos as $chave_proc => &$proc) {
							$proc['nome'] = FuncoesSisJD::corrigir_nome_processo($proc['nome']);
							$proc_temp =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo))=lower(trim('".strtolower(trim($proc['nome']))."'))", 'unico' => true]);					
							if (in_array($proc_condic['codprocesso'], explode(',', $proc_temp['aceita_condic_proc']))) {
								$proc['temcondicexplic'] = true;
								$condic_proc['codprocesso_original'] = explode(',', $proc_temp['aceita_condic_proc'])[array_search( $proc_condic['codprocesso'], explode(',', $proc_temp['aceita_condic_proc']))];
								if (!isset($proc['condicionantes'])) {
									$proc['condicionantes'] = [];
								}						
								$proc['condicionantes'][] = $condic_proc;						
								$localizado = true;
								break;
							} 					
						}
						if (!$localizado) {
							/**
							* Se nao existe na lista, cria um novo processo para a condicinante
							*/
							$chave_proc = count($processos);
							$condic_proc['codprocesso_original'] = $proc_condic['codprocesso'];
							$processos[] = [
								'nome' => $proc_condic['processo'],/*$nome_temp_proc*/
								'tipo' => 'condicionante',
								'temcondicexplic' => true,
								'temcmpavulexplic' => true,
								'condicionantes' => [$condic_proc],
								'campos_avulsos' => [],				
							];
						}
					} else {		
						FuncoesBasicasRetorno::mostrar_msg_sair('processo condicionante nao localizado: ' . $nome_temp_proc,__FILE__,__FUNCTION__,__LINE__);
					}
				}
			}
		}

		/**
		 * acrescenta ou vincula processo do tipo campo avulso passado pelos parametros
		 * @param {array} - &$processo - o array de processo do processo
		 * @param {array|string} - &$cnj_cmps_avulsos - o conjunto dos campos avulsos 
		 */
		private static function acrescenta_vincula_processos_campos_avulsos(array &$processo, array|string &$cnj_cmps_avulsos) :void {
			if (gettype($cnj_cmps_avulsos) !== 'array') {
				if (strlen(trim($cnj_cmps_avulsos)) > 0) {
					$cnj_cmps_avulsos = explode(',', strtolower(trim((string)$cnj_cmps_avulsos)));
				} else {
					$cnj_cmps_avulsos = [];
				}
			}
			$cnj_campos_avulsos_tab_sis = [];
			foreach ($cnj_cmps_avulsos as &$campo_avulso) {
				$pini = 0;
				if (strpos($campo_avulso,'=') !== false) {
					$pini = strpos($campo_avulso, '=')+1;
				}
				$campo = strtolower(trim(str_replace("'", '', substr($campo_avulso, $pini))));
				$pini = strpos($campo, '.')+1;
				$nometab = substr($campo, 0, $pini-1);
				$campo = substr($campo, $pini);
				if (!isset($cnj_campos_avulsos_tab_sis[$nometab])) {
					$cnj_campos_avulsos_tab_sis[$nometab] = [];
					$cnj_campos_avulsos_tab_sis[$nometab]['nometabelasis'] = $nometab;
					$cnj_campos_avulsos_tab_sis[$nometab]['campossis'] = [];
				}
				$cnj_campos_avulsos_tab_sis[$nometab]['campossis'][$campo] = ['nomecamposis' => $campo, 'encontrado' => false];
			}
			$cnj_tab_sis_campos_avulsos = [];
			foreach ($cnj_campos_avulsos_tab_sis as $chave_tab_sis => &$tabsis) {
				$tabelasis =  FuncoesSql::getInstancia()->obter_tabela_sis(['condic' => "lower(trim(nometabelasis))=lower(trim('" . $tabsis['nometabelasis'] . "'))", 'unico' => true]);		
				if (!isset($cnj_tab_sis_campos_avulsos[trim((string)$tabelasis['nometabelasis'])])) {
					$cnj_tab_sis_campos_avulsos[trim((string)$tabelasis['nometabelasis'])] = $tabelasis;
				}			
				$proc_temp =  FuncoesSql::getInstancia()->obter_processo(['condic' => $tabelasis['codtabelasis'] . ' in (select column_value from table(sjdpkg_funcs_array.como_array_num('.VariaveisSql::getInstancia()->getPrefixObjects().'processo.aceita_tabsis_cmpavul)))', 'unico' => true]);
				if (count($proc_temp) > 0) {
					$localizado = false;
					foreach ($processo as $chave_proc => &$proc) {
						if (strcasecmp(trim($proc['nome']),trim($proc_temp['processo'])) == 0) {
							$localizado = true;	
							$proc['temcmpavulexplic'] = true;
							$proc['campos_avulsos'] = FuncoesArray::acrescentar_elemento_array($proc['campos_avulsos'], [$tabsis], true, true);
							break;
						} 
					}
					if (!$localizado) {
						$processo[] = ['nome' => strtolower(trim($proc_temp['processo'])),
										'tipo' => 'campo_avulso',
										'condicionantes' => [],
										'campos_avulsos' => [$tabsis],
										'temcondicexplic' => false,
										'temcmpavulexplic' => true];					
					}
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair('processo nao encontrado para campo avulso do processo: ' . $ligproc['codprocesso']  , __FILE__ , __FUNCTION__  , __LINE__);
				}
			}	
		}

		/**
		 * seta se eh ou nao para desconsiderar ligstabelasis do tipo condicionantes no processo
		 * @param {array} - &$params - o array de params do processo
		 */
		private static function setar_desconsiderar_ligtabelasis_condicionante(array &$params) : void {
			$params['ligtabelasis_incluir']['desconsiderar_ligacoes_condicionantes'] = false;
			if (strcasecmp(trim($params['processos'][trim((string)$params['chave_processo_atual'])]['tipo']),'condicionante') == 0) {
				if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['desconsiderar_ligacoes_condicionantes'])) {
					if (FuncoesConversao::como_boleano($params['comhttp']->requisicao->requisitar->qual->condicionantes['desconsiderar_ligacoes_condicionantes']) === true) {
						$params['ligtabelasis_incluir']['desconsiderar_ligacoes_condicionantes'] = true;
					}
				}
			}	
		}

		/**
		 * inicializa o conjunto de dados (props) do processo
		 * @param {array} - &$params - o array de params do processo
		 */
		private static function inicializar_conjuntos_dados(array &$params) : void {
			$params['conjuntos_dados'] = [
				'ligstabelasis' => [],
				'ligscamposis' => [],
				'ligstabeladb' => [],
				'ligscampodb' => [],
				'ligsrelacionamento' => [],
				'tabelasis' => [],
				'camposis' => [],
				'tabeladb' => [],
				'campodb' => [],
				'relacionamento' => []
			];
		}

		/**
		 * inicializa o bloco comando sql com suas propriedades
		 * @return {array} - o array inicializado
		 */
		private static function inicializar_bloco_comando_sql() : array {
			return [
				'tem_union_anterior' => false,
				'tem_condicionante' => false,					
				'tem_group' => false,
				'union_anterior' => null,
				'select' => [],
				'condicionante' => [],
				'group' => [],
				'tabelas' => []
			];
		}

		/**
		 * inicializa o bloco select com suas propriedades
		 * @param {array} &$cnj_blocos_select - o array de cnj_blocos_select do processo
		 * @param {string|number} $chave_bloco_select - a chave do bloco select 		 
		 */
		private static function inicializar_bloco_select(array &$cnj_blocos_select, string|number $chave_bloco_select) : void{
			$cnj_blocos_select[trim((string)$chave_bloco_select)] = [
				'comando_sql' => self::inicializar_bloco_comando_sql(),
				'ligscampo' => [],
				'ligstabela' => [],
				'ligsrelacionamento' => []
			];
		}

		/**
		 * inclui no processo informacoes dos ligstabelasis
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_ligstabelasis_processos(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				$ligstabelasis = FuncoesSql::getInstancia()->obter_lig_tabelasis(['condic' => 'codprocesso=' . $params['processos'][$chave_processo]['processo']['codprocesso'], 'unico' => false]);	
				$params['processos'][$chave_processo]['ligstabelasis'] = [];
				$vinculou_condicionantes = false;
				foreach ($ligstabelasis as $chave_ligtabelasis => $ligtabelasis) {
					$chave_nova_ligtabelasis = trim((string)$ligstabelasis[$chave_ligtabelasis]['codligtabelasis']);
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis] = $ligstabelasis[$chave_ligtabelasis];
					$params['conjuntos_dados']['ligstabelasis'][$chave_nova_ligtabelasis] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['duplicado'] = false;
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['ligscamposis'] = [];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['ligstabeladb'] = [];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['ligscampodb'] = [];			
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['ligsrelacionamento'] = [];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['qt_campos_dados'] = 0;
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['qt_campos_valores'] = 0;			
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['tipo'] = $params['processos'][$chave_processo]['tipo'];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['campos_avulsos'] = $params['processos'][$chave_processo]['campos_avulsos'];			
					if ($vinculou_condicionantes === false) {
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['temcondicexplic'] = $params['processos'][$chave_processo]['temcondicexplic'];
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_nova_ligtabelasis]['condicionantes'] = $params['processos'][$chave_processo]['condicionantes'];
						$vinculou_condicionantes = true;
					}
				}
				/*verifica se o processo tem campos avulsos que pertencem as tabelas incluidas e as referencia como tabelas de campos avulsos*/
				if (isset($params['processos'][$chave_processo]['campos_avulsos'])) {
					if ($params['processos'][$chave_processo]['campos_avulsos'] !== null) {
						if (count($params['processos'][$chave_processo]['campos_avulsos']) > 0) {
							foreach($params['processos'][$chave_processo]['campos_avulsos'] as $chave_tabelasis_campo_avulso => $tabelasis_campo_avulso) {
								$tabsis =  FuncoesSql::getInstancia()->obter_tabela_sis(['condic' => "lower(trim(nometabelasis))=lower(trim('".$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['nometabelasis']."'))", 'unico' => true]);	
								if ($tabsis !== null && count($tabsis) > 0) {
									$encontrou = false;
									foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => $ligtabelasis) {								
										if ($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis'] === $tabsis['codtabelasis']) {
											$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis'] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis];
											$encontrou = true;
											break;
										}
									}
									if ($encontrou === false) {
										FuncoesBasicasRetorno::mostrar_msg_sair('tabelasis de campo avulso nao encontrada no processo: ' . $params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['nometabelasis'],__FILE__,__FUNCTION__,__LINE__);
									}
								} else {
									FuncoesBasicasRetorno::mostrar_msg_sair('tabelasis de campo avulso nao encontrada: ' . $params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['nometabelasis'],__FILE__,__FUNCTION__,__LINE__);
								}
							}					
						}
					}
				}
			}
		}

		/**
		 * inclui no processo informacoes dos ligscamposis
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_ligscamposis_processos(array &$params) : void {
			$condic_campos_valores = '';
			foreach($params['processos'] as $chave_processo => &$processo) {
				$params['processos'][$chave_processo]['qt_campos_dados'] = 0;
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {			
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_dados'] = 0;
					$condic_selecao_ligscamposis = 'codligtabelasis=' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codligtabelasis'] . " and lower(trim(criterio_uso)) not like lower(trim('%AVULSO%')) "/* . $condic_campos_valores*/;
					$ligscamposis = FuncoesSql::getInstancia()->obter_lig_camposis(['condic' => $condic_selecao_ligscamposis, 'unico' => false]);
					foreach ($ligscamposis as $chave_ligcamposis => $ligcamposis) {				
						$existe = self::processar_criterio_existencia($ligcamposis,true);
						if ($existe === true) {
							$chave_novo_ligcamposis = trim((string)$ligscamposis[$chave_ligcamposis]['codligcamposis']);
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_novo_ligcamposis] = $ligscamposis[$chave_ligcamposis];
							$params['conjuntos_dados']['ligscamposis'][$chave_novo_ligcamposis] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_novo_ligcamposis];
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_novo_ligcamposis]['duplicado'] = false;
							if (in_array(trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_novo_ligcamposis]['codcamposis']),$params['cods_campos_sis_valores_visiveis'])) {
								if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_valores'])) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_valores'] = 0;
								}
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_valores']++;
							} else {					
								if (in_array(strtolower(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_novo_ligcamposis]['criterio_uso'])),['usar sempre','campo avulso'])) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_dados']++;
								}
							}
						}
					}
					$params['processos'][$chave_processo]['qt_campos_dados'] += $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_dados'];
					$params['processos'][$chave_processo]['qt_campos_valores'] += $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['qt_campos_valores'];
				}
				/*verifica se o processo tem campos avulsos que pertencem as tabelas incluidas e as referencia como membros da tabela de campos avulsos de referencia*/
				if (isset($params['processos'][$chave_processo]['campos_avulsos'])) {
					if ($params['processos'][$chave_processo]['campos_avulsos'] !== null) {
						if (count($params['processos'][$chave_processo]['campos_avulsos']) > 0) {
							foreach($params['processos'][$chave_processo]['campos_avulsos'] as $chave_tabelasis_campo_avulso => &$tabelasis_campo_avulso) {						
								foreach($params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['campossis'] as $chave_nome_camposis => &$nome_camposis) {
									$camposis =  FuncoesSql::getInstancia()->obter_campo_sis(['condic' => 'codtabelasis=' . $params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['codtabelasis'] . " AND lower(trim(nomecamposis))=lower(trim('".$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['campossis'][$chave_nome_camposis]['nomecamposis']."'))", 'unico' => true]);	
									if ($camposis !== null && count($camposis) > 0) {
										$ligcamposis_avulso = FuncoesSql::getInstancia()->obter_lig_camposis(['condic' => 'codcamposis=' . $camposis['codcamposis'] . ' AND codligtabelasis='.$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['codligtabelasis']." AND lower(trim(CRITERIO_USO))=lower(trim('campo avulso'))", 'unico' => true]);	
										if ($ligcamposis_avulso !== null && count($ligcamposis_avulso) > 0) {
											$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['ligscamposis'][trim((string)$ligcamposis_avulso['codligcamposis'])] = $ligcamposis_avulso;
											$params['conjuntos_dados']['ligscamposis'][trim((string)$ligcamposis_avulso['codligcamposis'])] = &$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['ligscamposis'][trim((string)$ligcamposis_avulso['codligcamposis'])];
											$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['ligscamposis'][trim((string)$ligcamposis_avulso['codligcamposis'])]['duplicado'] = false;									
											$params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['ligtabelasis']['qt_campos_dados']++;
											$params['processos'][$chave_processo]['qt_campos_dados']++;
										} else {
											FuncoesBasicasRetorno::mostrar_msg_sair('ligcamposis de campo avulso nao encontrado: ' . $params['processos'][$chave_processo]['campos_avulsos'][$chave_tabelasis_campo_avulso]['campossis'][$chave_nome_camposis]['nomecamposis'],__FILE__,__FUNCTION__,__LINE__);
										}
									} else {
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * inclui no processo informacoes dos ligstabeladb
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_ligstabeladb_processos(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {			
					$ligstabeladb = FuncoesSql::getInstancia()->obter_lig_tabeladb([
						'condic' => 'codligtabelasis=' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codligtabelasis'], 
						'ordenacao' => 'bloco_select,ordem,codligtabeladb',
						'unico' => false
					]);
					if (count($ligstabeladb) > 0) {
						foreach ($ligstabeladb as $chave_ligtabeladb => $ligtabeladb) {
							$existe = self::processar_criterio_existencia($ligtabeladb,true);
							if ($existe === true) {
								$chave_nova_ligtabeladb = trim((string)$ligstabeladb[$chave_ligtabeladb]['codligtabeladb']);
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb] = $ligstabeladb[$chave_ligtabeladb];
								$params['conjuntos_dados']['ligstabeladb'][$chave_nova_ligtabeladb] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb];
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb]['ligsrelacionamento'] = [];
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb]['duplicado'] = false;
								if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb]['bloco_select'])) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_nova_ligtabeladb]['bloco_select'] = 0;
								}
							}
						}
					}
				}
			}
		}

		/**
		 * inclui no processo informacoes dos ligscampodb
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_ligscampodb_processos(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					$condic_ligscamposis = [];
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'] = [];
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
						$condic_ligscamposis[] = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['codligcamposis'];
					}
					if (count($condic_ligscamposis) > 0) {
						$condic_ligscamposis = ' and codligcamposis in (' . implode(',',$condic_ligscamposis) . ') ';
						foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'] as $chave_ligtabeladb => &$ligtabeladb) {
							if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['codligtabeladb'])) {
								$ligscampodb = FuncoesSql::getInstancia()->obter_lig_campodb(['condic' => 'codligtabeladb=' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['codligtabeladb'] .  $condic_ligscamposis, 'unico' => false]);
								if ($ligscampodb !== null && count($ligscampodb) > 0) {
									foreach ($ligscampodb as $chave_ligcampodb => $ligcampodb) {
										$existe = self::processar_criterio_existencia($ligcampodb,true);
										if ($existe === true) {
											$chave_novo_ligcampodb = trim((string)$ligcampodb['codligcampodb']);
											$chave_ligtabeladb_ref = trim((string)$ligcampodb['codligtabeladb']);
											$chave_ligcamposis_ref = trim((string)$ligcampodb['codligcamposis']);
											$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb] = $ligcampodb;
											$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['duplicado'] = false;							
											$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['ligtabeladb'] = &$params['conjuntos_dados']['ligstabeladb'][$chave_ligtabeladb_ref];
											$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['ligcamposis'] = &$params['conjuntos_dados']['ligscamposis'][$chave_ligcamposis_ref];
											$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['codprocesso_original'] = $params['processos'][$chave_processo]['processo']['codprocesso'];
											$params['conjuntos_dados']['ligscampodb'][$chave_novo_ligcampodb] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb];
											if (stripos($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['transformacoes'],'__FNV_RETORNAR_CONFORME_CRITERIO_EXISTENCIA__') !== false) {
												$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['transformacoes'] = FuncoesVariaveis::como_texto_ou_funcao([
													'texto'=>$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_novo_ligcampodb]['transformacoes'],
													'ignorar_crit_exist' => false
												]);
											}
										}
									}
								}
							}
						}				
					}
				}
			}
		}

		/**
		 * inclui no processo informacoes dos ligsrelacionamentos
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_ligsrelacionamento_processos(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {			
					$ligsrelacionamento =  FuncoesSql::getInstancia()->obter_lig_relacionamento(['condic' => 'codligtabela2=' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codligtabelasis'] . " and lower(trim(tipoligtabela2))=lower(trim('sis'))", 'unico' => false]);			
					if ($ligsrelacionamento !== null && count($ligsrelacionamento) > 0) {
						foreach ($ligsrelacionamento as $chave_ligrelacionamento => $ligrelacionamento) {
							$chave_novo_ligrelacionamento = trim((string)$ligrelacionamento['codligrelacionamento']);
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_novo_ligrelacionamento] = $ligrelacionamento;
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_novo_ligrelacionamento]['duplicado'] = false;					
							$params['conjuntos_dados']['ligsrelacionamento'][$chave_novo_ligrelacionamento] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_novo_ligrelacionamento];
						}
					}
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'] as $chave_ligtabeladb => &$ligtabeladb) {
						$ligsrelacionamento =  FuncoesSql::getInstancia()->obter_lig_relacionamento(['condic' => 'codligtabela2=' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['codligtabeladb'] . " and lower(trim(tipoligtabela2))=lower(trim('db'))", 'unico' => false]);						
						if ($ligsrelacionamento !== null && count($ligsrelacionamento) > 0) {
							foreach ($ligsrelacionamento as $chave_ligrelacionamento => $ligrelacionamento) {
								$existe = self::processar_criterio_existencia($ligrelacionamento,true);
								if ($existe === true) {			
									$chave_novo_ligrelacionamento = trim((string)$ligrelacionamento['codligrelacionamento']);
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ligsrelacionamento'][$chave_novo_ligrelacionamento] = $ligrelacionamento;
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ligsrelacionamento'][$chave_novo_ligrelacionamento]['duplicado'] = false;					
									$params['conjuntos_dados']['ligsrelacionamento'][$chave_novo_ligrelacionamento] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ligsrelacionamento'][$chave_novo_ligrelacionamento];
								}
							}
						}
					}
				}
			}
		}

		/**
		 * inclui no processo informacoes das entidades envolvidas (tabelas, campos, relacionamentos, etc)
		 * @param {array} &$params - o array de params do processo
		 */
		private static function incluir_conjuntos_dados(array &$params) : void {	
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					$chave_codtabelasis = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis']);
					if (!isset($params['conjuntos_dados']['tabelasis'][$chave_codtabelasis])) {
						$params['conjuntos_dados']['tabelasis'][$chave_codtabelasis] =  FuncoesSql::getInstancia()->obter_tabela_sis(['condic' => $chave_codtabelasis, 'unico' => true]);
					}
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
						$chave_codcamposis = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['codcamposis']);
						if (!isset($params['conjuntos_dados']['camposis'][$chave_codcamposis])) {
							$params['conjuntos_dados']['camposis'][$chave_codcamposis] =  FuncoesSql::getInstancia()->obter_campo_sis(['condic' => $chave_codcamposis, 'unico' => true]);
						}
					}
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'] as $chave_ligtabeladb => &$ligtabeladb) {
						$chave_codtabeladb = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['codtabeladb']);
						if (!isset($params['conjuntos_dados']['tabeladb'][$chave_codtabeladb])) {
							$params['conjuntos_dados']['tabeladb'][$chave_codtabeladb] =  FuncoesSql::getInstancia()->obter_tabela_db(['condic' => $chave_codtabeladb, 'unico' => true]);
						}
						foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {
							$chave_codrelacionamento = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ligsrelacionamento'][$chave_ligrelacionamento]['codrelacionamento']);
							if (!isset($params['conjuntos_dados']['relacionamento'][$chave_codrelacionamento])) {
								$params['conjuntos_dados']['relacionamento'][$chave_codrelacionamento] =  FuncoesSql::getInstancia()->obter_relacionamento(['condic' => $chave_codrelacionamento, 'unico' => true]);
							}
						}				
						if ($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['ignorar_crit_acess'] != 1) {
							$criterios_acesso = [];
							$criterios_acesso =  FuncoesSql::getInstancia()->obter_criterios_acesso($params['processos'][$chave_processo]['usuariosis'], $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]);		
							if (count($criterios_acesso ?? []) > 0) {
								$cnj_criterios =  FuncoesSql::getInstancia()->traduzir_criterios_acesso($params['processos'][$chave_processo]['usuariosis'], $criterios_acesso);
								$params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'] = implode(' and ', $cnj_criterios);
							}
						}
						if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantestab'])) {
							/*a condicionante tab deve vir dentro do objeto ->condicionantes['condicionantestab'] no formato nome_tab[condicionantes] [sepn1 ...
								e tudo que estiver entre os colchetes como 'condicionantes' sera colocado na clausula where onde a tabela for citada*/
							if (gettype($params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantestab']) !== 'array') {
								$params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantestab'] =  FuncoesSql::getInstancia()->preparar_condicionantestab($params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantestab']);
							}
							$cnj_condicionantestab = [];
							foreach ($params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantestab'] as $chavecondtab => $condtab) {
								$condtab = str_ireplace(Constantes::subst_virg, ',', $condtab);
								if (strcasecmp(trim($chavecondtab),trim($params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['nometabeladb'])) == 0) {	
									$cnj_condicionantestab[] = $condtab;
								}
							}
							if (count($cnj_condicionantestab) > 0) {								
								if (!isset($params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'])) {
									$params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'] = '';
								}
								if (strlen(trim($params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'])) > 0) {
									$params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'] .= ' and ';
								}
								$cnj_condicionantestab = FuncoesVariaveis::como_texto_ou_funcao(FuncoesVariaveis::como_texto_ou_constante(implode(' and ',$cnj_condicionantestab)));
								$params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['condicionantes'] .= ' (' . $cnj_condicionantestab . ') ';
							}
						}				
					}
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'] as $chave_ligcampodb => &$ligcampodb) {
						$chave_codcampodb = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['codcampodb']);
						if (!isset($params['conjuntos_dados']['campodb'][$chave_codcampodb])) {
							if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['tipoligcampodb']) && strcasecmp(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['tipoligcampodb']),'sis') == 0) {
								if (!isset($params['conjuntos_dados']['camposis'][$chave_codcampodb])) {
									$params['conjuntos_dados']['camposis'][$chave_codcampodb] =  FuncoesSql::getInstancia()->obter_campo_sis(['condic' => $chave_codcampodb, 'unico' => true]);
								}
							} else {
								$params['conjuntos_dados']['campodb'][$chave_codcampodb] =  FuncoesSql::getInstancia()->obter_campo_db(['condic' => $chave_codcampodb, 'unico' => true]);
							}
						}
					}
					if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento']) && gettype($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento']) === 'array') {
						foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {
							$chave_codrelacioanmento = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['codrelacionamento']);
							if (!isset($params['conjuntos_dados']['relacionamento'][$chave_codrelacioanmento])) {
								$params['conjuntos_dados']['relacionamento'][$chave_codrelacioanmento] =  FuncoesSql::getInstancia()->obter_relacionamento(['condic' => $chave_codrelacioanmento, 'unico' => true]);
							}
						}			
					}
				}
			}
		}

		/**
		 * obtem os dados do processo e atribui ao array do processo
		 * @param {array} &$params - o array de params do processo
		 */
		private static function atribuir_dados_processos(array &$params) : void {
			$processos_temp = [];
			$params['dados_extra'] = [];
			$params['dados_extra']['somarunion'] = 'n';
			$params['dados_extra']['desconsiderar_ligacoes_condicionantes'] = false;
			$params['dados_extra']['mudar_somar_union'] = false;
			$params['dados_extra']['mudar_desc_lig_condic'] = false;
			$params['dados_extra']['mudou_algo'] = false;
			foreach($params['processos'] as $chave_proc => &$proc) {
				$proc['tabelasis'] = [];
				if (isset($_SESSION['codusur']) && strlen(trim($_SESSION['codusur'])) > 0 && trim($_SESSION['codusur']) !== '0') {
					$proc['usuariosis'] = FuncoesSql::getInstancia()->obter_usuario_sis(['condic' => $_SESSION['codusur'], 'unico' => true]);
				} else {
					$proc['usuariosis'] = FuncoesSql::getInstancia()->obter_usuario_sis(['condic' => $params['comhttp']->requisicao->requisitar->qual->codusur, 'unico' => true]);
				}
				$proc['nome'] = FuncoesSisJD::corrigir_nome_processo($proc['nome']);
				$dados_processo =  FuncoesSql::getInstancia()->obter_processo(['condic' => "lower(trim(processo))=lower(trim('" . strtolower(trim($proc['nome'])) . "'))", 'unico' => true]);
				if (count($dados_processo) <= 0) {
					FuncoesBasicasRetorno::mostrar_msg_sair('processo nao localizado: '.$proc['nome'], __FILE__, __FUNCTION__, __LINE__);
				}
				$dados_processo['tipo'] = $proc['tipo'];
				$proc['processo'] = $dados_processo;
				$proc['qt_campos_dados'] = 0;
				$proc['qt_campos_valores'] = 0;
				$processos_temp[trim((string)$proc['processo']['codprocesso'])] = $proc;
			}
			$params['processos'] = $processos_temp;	
			self::inicializar_conjuntos_dados($params);
			self::incluir_ligstabelasis_processos($params);		
			self::incluir_ligscamposis_processos($params);	
			self::incluir_ligstabeladb_processos($params);	
			self::incluir_ligsrelacionamento_processos($params);	
			self::incluir_ligscampodb_processos($params);	
			self::incluir_conjuntos_dados($params);
		}

		/**
		 * ordena os camposis de uma ligtabelasis conforme ordem no registro ['ordem'=>n]
		 * @param {array} &$ligtabelasis - o array de ligtabelasis do processo
		 */
		private static function ordenar_camposis(array &$ligtabelasis) : void {
			if (!isset($ligtabelasis['duplicado']) || $ligtabelasis['duplicado'] === false) {
				$ordens = [];
				foreach ($ligtabelasis['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
					if (!isset($ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'])) {
						$ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'] = $ligtabelasis['ligscamposis'][$chave_ligcamposis]['codligcamposis'];
					}
					if (strlen(trim($ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'])) === 0) {
						$ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'] = $ligtabelasis['ligscamposis'][$chave_ligcamposis]['codligcamposis'];
					}
					if (isset($ordens[(string)trim($ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'])])) {
						$limitador_loop = 1000;
						$contador_looop = 0;
						while(isset($ordens[(string)trim($ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'])])){
							$ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem']++;
							$contador_looop ++;
							if ($contador_looop > $limitador_loop) {
								FuncoesBasicasRetorno::mostrar_msg_sair("ordem '".$ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem']."' duplicada para o chave_ligcamposis: " . $chave_ligcamposis,__FILE__,__FUNCTION__,__LINE__);
							}
						}
					}
					$ordens[trim((string)$ligtabelasis['ligscamposis'][$chave_ligcamposis]['ordem'])] = $chave_ligcamposis;
				}
				ksort($ordens, SORT_NUMERIC);
				$camposis_ordenados = [];
				foreach ($ordens as $ordem => &$chave_ligcamposis) {
					$camposis_ordenados[$chave_ligcamposis] = &$ligtabelasis['ligscamposis'][$chave_ligcamposis];
				}
				$ligtabelasis['ligscamposis'] = $camposis_ordenados;
			}
		}

		/**
		 * apos obtidos as ligacoes do processo, forma o array do processo com suas caracteristica
		 * @param {array} &$params - o array de params do processo
		 */
		private static function formar_processo_estruturado(array &$params) : void {
			if (count($params['processos']) > 0) {
				/*INICIO ORDENACAO TABELAS SIS DENTRO DE CADA PROCESSO*/
				foreach ($params['processos'] as $chave_processo => &$processo) {
					$ordens = [];
					foreach ($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'])) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'] = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codligtabelasis'];
						}
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'] = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codligtabelasis'];
						}
						if (isset($ordens[(string)trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'])])) {
							FuncoesBasicasRetorno::mostrar_msg_sair("ordem '".$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem']."' duplicada para o processo: " . $chave_processo,__FILE__,__FUNCTION__,__LINE__);
						}
						$ordens[(string)trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ordem'])] = $chave_ligtabelasis;
					}
					ksort($ordens, SORT_NUMERIC);
					$ligstabelassis_ordenadas = [];
					foreach ($ordens as $ordem => &$chave_ligtabelasis) {
						$ligstabelassis_ordenadas[$chave_ligtabelasis] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis];
					}
					if (count($ligstabelassis_ordenadas) > 0) {
						$params['processos'][$chave_processo]['ligstabelasis'] = $ligstabelassis_ordenadas;
					}
				}		
				/*FIM ORDENACAO TABELAS SIS DENTRO DE CADA PROCESSO*/	
				/*INICIO ORDENACAO CAMPOS SIS DENTRO DE CADA PROCESSO*/
				foreach ($params['processos'] as $chave_processo => &$processo) {
					foreach ($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
						self::ordenar_camposis($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]);
					}
				}
				/*ATRIBUICAO DE ALIASES*/
				foreach ($params['processos'] as $chave_processo => &$processo) {
					foreach ($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {						
						$chave_codtabelasis = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis']);

						/*aliases ligtabelasis*/
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'])) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabelasis]['alias'];
						}						
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabelasis]['alias'];
						}
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabelasis]['nometabelavisivel'];
						}
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabelasis]['nometabelasis'];
						}
						/*se houver espaco, e nao estiver envolto em aspas duplas, envolve*/
						if (strpos($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'],' ') !== false
						 	&& strpos($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'],"\"") === false 
						) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] = '"' . $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['alias'] . '"';
						}

						foreach ($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
							$chave_codcamposis = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['codcamposis']);
							if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'])) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'] = $params['conjuntos_dados']['camposis'][$chave_codcamposis]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'] = $params['conjuntos_dados']['camposis'][$chave_codcamposis]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'] = $params['conjuntos_dados']['camposis'][$chave_codcamposis]['nomecampovisivel'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_ligcamposis]['alias'] = $params['conjuntos_dados']['camposis'][$chave_codcamposis]['nomecamposis'];
							}
						}
						foreach ($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'] as $chave_ligtabeladb => &$ligtabeladb) {
							$chave_codtabeladb = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['codtabeladb']);
							if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['tipoligtabeladb']) && strcasecmp(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['tipoligtabeladb']),'sis') == 0) {
								if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabeladb]['alias'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabeladb]['alias'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabelasis'][$chave_codtabeladb]['nometabelasis'];
								}
							} else {
								if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['alias'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['alias'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['nometabelavisivel'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['nometabelasistema'];
								}
								if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'])) === 0) {
									$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['alias'] = $params['conjuntos_dados']['tabeladb'][$chave_codtabeladb]['nometabeladb'];
								}
							}
						}
						foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'] as $chave_ligcampodb => &$ligcampodb) {
							$chave_codcampodb = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['codligcamposis']);
							$chave_codcamposis = trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['codligcamposis']);
							if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['ligscamposis'][$chave_codcamposis]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['ligscamposis'][$chave_codcamposis]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['camposis'][trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_codcamposis]['codcamposis'])]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['camposis'][trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_codcamposis]['codcamposis'])]['nomecampovisivel'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['camposis'][trim((string)$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis'][$chave_codcamposis]['codcamposis'])]['nomecamposis'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['campodb'][$chave_codcampodb]['alias'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['campodb'][$chave_codcampodb]['nomecampovisivel'];
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['alias'] = $params['conjuntos_dados']['campodb'][$chave_codcampodb]['nomecampodb'];
							}
						}
					}
				}
			}		
		}

		/**
		 * separa blocos_select do processo, conforme registro ['bloco_select'=>0] do processo e ligtabelasis		 
		 * @param {array} &$params - o array de params do processo
		 */
		private static function separar_blocos(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'] = [];
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'] as $chave_ligtabeladb => &$ligtabeladb) {
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['bloco_select'])) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['bloco_select'] = 0;
						}
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['bloco_select'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['bloco_select'] = 0;
						}
						$chave_bloco_select = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]['bloco_select'];
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select])) {
							self::inicializar_bloco_select($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'], $chave_bloco_select);
						}
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select]['ligstabela'][$chave_ligtabeladb] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb];
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb] = &$GLOBALS['null'];
						unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb'][$chave_ligtabeladb]);
					}
					foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'] as $chave_ligcampodb => &$ligcampodb) {
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['ligtabeladb']['bloco_select'])) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['ligtabeladb']['bloco_select'] = 0;
						}
						if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['ligtabeladb']['bloco_select'])) === 0) {
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['ligtabeladb']['bloco_select'] = 0;
						}
						$chave_bloco_select = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]['ligtabeladb']['bloco_select'];
						if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select])) {
							self::inicializar_bloco_select($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'], $chave_bloco_select);
						}
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select]['ligscampo'][$chave_ligcampodb] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb];
						$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb] = &$GLOBALS['null'];
						unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb'][$chave_ligcampodb]);
					}
					unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligstabeladb']);
					unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligscampodb']);
					if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento']) && gettype($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento']) === 'array') {
						foreach($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {
							if (isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['tipoligtabela2']) && strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['tipoligtabela2'])) > 0) {
								if (strcasecmp(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['tipoligtabela2']),'sis') == 0) { 
									continue;
								}
							}
							if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['bloco_select'])) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['bloco_select'] = 0;
							}
							if (strlen(trim($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['bloco_select'])) === 0) {
								$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['bloco_select'] = 0;
							}
							$chave_bloco_select = $params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]['bloco_select'];
							if (!isset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select])) {
								self::inicializar_bloco_select($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'], $chave_bloco_select);
							}
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'][$chave_bloco_select]['ligsrelacionamento'][$chave_ligrelacionamento] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento];				
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento] = &$GLOBALS['null'];
							unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['ligsrelacionamento'][$chave_ligrelacionamento]);
						}
					}
					ksort($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['blocos_select'], SORT_NUMERIC);
				}
			}
		}

		/**
		 * une (merge) as caracteristicas (props) de ligstabelasis maradas como unica (['unica'=>1]) se existir em mais de um processo
		 * A ligtabealsis unica tera um registro no array principal de params e sera excluida do array de ligstabelasis do processo
		 * @param {array} &$params - o array de params do processo
		 * @param {array} &$ligtabelasis_original - o array de ligtabelasis_original do processo
		 * @param {array} &$ligtabelasis_replicar - o array de ligtabelasis_replicar do processo
		 */
		private static function unir_caracteristicas_ligtabsis(array &$params, array &$ligtabelasis_original, array &$ligtabelasis_replicar) : void {
			$replicar = false;
			if (strcasecmp(trim($ligtabelasis_original['criterio_uso']),'acessorio') == 0 
				&& strcasecmp(trim($ligtabelasis_replicar['criterio_uso']),'acessorio') != 0
			) {				
				if (
					   strcasecmp(trim($ligtabelasis_replicar['tipo']),'condicionante') != 0
					|| strcasecmp(trim($params['processos'][$ligtabelasis_replicar['codprocesso']]['processo']['tipo']),'condicionante') == 0
					|| strcasecmp(trim($params['processos'][$ligtabelasis_replicar['codprocesso']]['processo']['criterio_uso'] ?? ''),'condicionante') == 0 
					|| strcasecmp(trim($ligtabelasis_replicar['criterio_uso']??''),'condicionante') == 0 
				) {
					$ligtabelasis_original['tipo'] = 'condicionante';
					$ligtabelasis_original['criterio_uso'] = 'condicionante';
					//print_r($ligtabelasis_original); exit();
				} else {
					$ligtabelasis_original['criterio_uso'] = $ligtabelasis_replicar['criterio_uso'];
				}
			}
			if (isset($ligtabelasis_replicar['condicionantes']) && count($ligtabelasis_replicar['condicionantes']) > 0) {
				if (!isset($ligtabelasis_original['condicionantes'])) {
					$ligtabelasis_original['condicionantes'] = [];
				}
				foreach($ligtabelasis_replicar['condicionantes'] as $chave_cond => $condicionante) {
					$ligtabelasis_original['condicionantes'][] = $condicionante;
				}
				$ligtabelasis_original['temcondicexplic'] = true;
			}
			foreach($ligtabelasis_replicar['ligscamposis'] as $chave_ligcamposis_replicar => &$ligcamposis_replicar) {
				if (!in_array(trim((string)$chave_ligcamposis_replicar),array_keys($ligtabelasis_original['ligscamposis']))) {
					$replicar = true;
					foreach($ligtabelasis_original['ligscamposis'] as $chave_ligcamposis_original => &$ligcamposis_original) {
						if ($ligtabelasis_original['ligscamposis'][$chave_ligcamposis_original]['codcamposis'] === $ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['codcamposis']) {
							if (in_array(trim((string)$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['codcamposis']),VariaveisSql::cods_campos_sis_valores)) {
								$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['duplicado'] = true;
								$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['original'] = &$ligtabelasis_original['ligscamposis'][$chave_ligcamposis_original];
								$replicar = false;
								break;
							} else {
								if (strcasecmp(trim($ligtabelasis_original['ligscamposis'][$chave_ligcamposis_original]['alias']),trim($ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['alias'])) == 0) {
									$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['alias'] = $ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['alias'] . '_'.count($ligtabelasis_original['ligscamposis']);
								}
							}
						}
					}
					if ($replicar === true) {			
						/*corrige a ordem, se ja existir */
						$ordens_existentes = [];
						foreach($ligtabelasis_original['ligscamposis'] as $chave_ligcamposis2 => $ligcamposis2) {
							$ordens_existentes[] = $ligtabelasis_original['ligscamposis'][$chave_ligcamposis2]['ordem'];
						}
						if (in_array($ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['ordem'],$ordens_existentes)) {
							$contador_loop = 0;
							$limitador_loop = 1000;
							$ordem_anterior = $ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['ordem'];
							while(in_array($ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['ordem'],$ordens_existentes)) {
								$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['ordem']++;
								$contador_loop++;
								if ($contador_loop > $limitador_loop) {
									FuncoesBasicasRetorno::mostrar_msg_sair('Ordem do ligcamposis preexisntente, impossivel incluir ligcamposis com mesma ordem:' . $chave_ligcamposis2,__FILE__,__FUNCTION__,__LINE__);
								}
							}
							/*a referencia esta se perdendo em algum ponto ate chegar aqui, somente alterando no conjunto de dados que tem efeito*/
							$params['conjuntos_dados']['ligscamposis'][trim((string)$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['codligcamposis'])]['ordem'] = $ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]['ordem'];					
						}
						$ligtabelasis_original['ligscamposis'][trim((string)$chave_ligcamposis_replicar)] = &$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar];
						$ligtabelasis_original['ligscamposis'][trim((string)$chave_ligcamposis_replicar)]['codligtabelasis'] = $ligtabelasis_original['codligtabelasis'];				
						if (!in_array(strtolower(trim($ligtabelasis_replicar['tipo'])),['normal','campo_avulso']) 
							&& in_array(strtolower(trim($ligtabelasis_original['ligscamposis'][trim((string)$chave_ligcamposis_replicar)]['criterio_uso'])),['usar sempre','campo avulso'])) {
							$ligtabelasis_original['ligscamposis'][trim((string)$chave_ligcamposis_replicar)]['criterio_uso'] = 'herdado ' . $ligtabelasis_original['ligscamposis'][trim((string)$chave_ligcamposis_replicar)]['criterio_uso'];
						}
						$ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar] = &$GLOBALS['null'];
						unset($ligtabelasis_replicar['ligscamposis'][$chave_ligcamposis_replicar]);
					}
				}
			}
			foreach($ligtabelasis_replicar['ligsrelacionamento'] as $chave_ligrelacionamento_replicar => &$ligrelacionamento_replicar) {
				if (!in_array(trim((string)$chave_ligrelacionamento_replicar),array_keys($ligtabelasis_original['ligsrelacionamento']))) {
					$replicar = true;
					foreach($ligtabelasis_original['ligsrelacionamento'] as $chave_ligrelacionamento_original => &$ligrelacionamento_original) {
						if ($ligtabelasis_original['ligsrelacionamento'][$chave_ligrelacionamento_original]['codrelacionamento'] === $ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['codrelacionamento']) {
							$ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['duplicado'] = true;
							$ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['original'] = &$ligtabelasis_original['ligsrelacionamento'][$chave_ligrelacionamento_original];
							$replicar = false;
							break;
						}
					}
					if ($replicar === true) {				
						$ligtabelasis_original['ligsrelacionamento'][$chave_ligrelacionamento_replicar] = &$ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar];
						$ligtabelasis_original['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['codligtabelasis'] = $ligtabelasis_original['codligtabelasis'];
						$ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar] = &$GLOBALS['null'];
						unset($ligtabelasis_replicar['ligsrelacionamento'][$chave_ligrelacionamento_replicar]);
					}
				}
			}
			$qt_campos = 0;
			foreach($ligtabelasis_replicar['blocos_select'] as $chave_bloco_select_replicar => &$bloco_select_replicar) {
				if (!in_array($chave_bloco_select_replicar,array_keys($ligtabelasis_original['blocos_select']))) {			
					$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar] = &$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar];
					$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar] = &$GLOBALS['null'];
					unset($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]);
					if (count($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo']) > $qt_campos) {
						$qt_campos = count($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo']);
					}
					continue;
				}
				foreach($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'] as $chave_ligtabeladb_replicar => &$ligtabeladb_replicar) {		
					$chave_ligtabeladb_referencia_original = $chave_ligtabeladb_replicar;
					if (!in_array(trim((string)$chave_ligtabeladb_replicar),array_keys($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela']))) {
						$replicar = true;
						foreach($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'] as $chave_ligtabeladb_original => &$ligtabeladb_original) {
							if ($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_original]['codtabeladb'] === $ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['codtabeladb'] &&
								strcasecmp(trim($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_original]['alias']),trim($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['alias'])) == 0) {
								$chave_ligtabeladb_referencia_original = $chave_ligtabeladb_original;
								$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['duplicado'] = true;
								$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['original'] = &$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_original];
								$replicar = false;
								break;
							}
						}
						if ($replicar === true) {					
							$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_replicar)] = &$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar];
							$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_replicar)]['codligtabelasis'] = $ligtabelasis_original['codligtabelasis'];
							$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar] = &$GLOBALS['null'];
							unset($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]);
						} else {
							if (gettype($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento']) === 'array') {				
								foreach($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'] as $chave_ligrelacionamento_replicar => &$ligrelacionamento_replicar) {
									if (!in_array(trim((string)$chave_ligrelacionamento_replicar),array_keys($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_referencia_original)]['ligsrelacionamento']))) {
										$replicar = true;
										foreach($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_referencia_original)]['ligsrelacionamento'] as $chave_ligrelacionamento_original => &$ligrelacionamento_original) {
											if ($ligrelacionamento_original['codrelacionamento'] === $ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['codrelacionamento']) {
												$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['duplicado'] = true;
												$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar]['original'] = &$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_referencia_original)]['ligsrelacionamento'][$chave_ligrelacionamento_original];
												$replicar = false;
												break;
											}
										}
										if ($replicar === true) {
											$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_referencia_original)]['ligsrelacionamento'][trim((string)$chave_ligrelacionamento_replicar)] = &$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar];
											$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][trim((string)$chave_ligtabeladb_referencia_original)]['ligsrelacionamento'][trim((string)$chave_ligrelacionamento_replicar)]['codligtabelasis'] = $ligtabelasis_original['codligtabelasis'];
											$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar] = &$GLOBALS['null'];
											unset($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligstabela'][$chave_ligtabeladb_replicar]['ligsrelacionamento'][$chave_ligrelacionamento_replicar]);
										}
									}
								}
							}
						}
					}
				}
				foreach($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'] as $chave_ligcampo_replicar => &$ligcampo_replicar) {	
					if (!in_array(trim((string)$chave_ligcampo_replicar),array_keys($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo']))) {
						$replicar = true;						
						foreach($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'] as $chave_ligcampodb_original => &$ligcampodb_original) {
							if (trim($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampodb_original]['codcampodb']) === trim($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['codcampodb'])) {
								if (in_array(trim((string)$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['ligcamposis']['codcamposis']),VariaveisSql::cods_campos_sis_valores)) {
									$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['duplicado'] = true;
									$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['original'] = &$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampodb_original];
									$replicar = false;
									break;
								} else {
									if (strcasecmp(trim($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['criterio_uso']),'condicionante') == 0 && strcasecmp(trim($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampodb_original]['criterio_uso']),'condicionante') == 0 &&
										strcasecmp(trim($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['especificacao_criterio']),trim($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampodb_original]['especificacao_criterio'])) == 0 ) {
										$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['duplicado'] = true;
										$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['original'] = &$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampodb_original];
										$replicar = false;
										break;	
									} else {
										$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['alias'] = $ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar]['ligcamposis']['alias']; /*alias do camposis ja retificado acima*/
									}
								}
							}
						}
						if ($replicar === true) {							
							$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)] = &$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][$chave_ligcampo_replicar];
							$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)]['codprocesso_original'] = $ligtabelasis_replicar['codprocesso'];
							if (isset($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)]['aceita_condic_proc']) &&
								strlen(trim($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)]['aceita_condic_proc'])) > 0) {
								$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)]['aceita_condic_proc'] = $ligtabelasis_original['codprocesso'];
							}
							$ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)] = &$GLOBALS['null'];
							unset($ligtabelasis_replicar['blocos_select'][$chave_bloco_select_replicar]['ligscampo'][trim((string)$chave_ligcampo_replicar)]);
						}
					}
				}
				if (count($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo']) > $qt_campos) {
					$qt_campos = count($ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar]['ligscampo']);
					$bloco_select_ref_campos = &$ligtabelasis_original['blocos_select'][$chave_bloco_select_replicar];
				}		
			}
		}

		/**
		 * prepara as ligstabelasis maradas como unica (['unica'=>1]) para essa configuracao no processo
		 * A ligtabealsis unica tera um registro no array principal de params e sera excluida do array de ligstabelasis do processo
		 * @param {params} &$params - o array de params do processo
		 */
		private static function preparar_ligtabelasis_unica(array &$params) : void {
			$params['ligstabelasis_unicas'] = [];	
			foreach ($params['processos'] as $chave_processo => &$processo) {
				foreach($params['processos'][$chave_processo]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					/*move tabelas unicas por registro para o array principal e exclue-a do array da ligtabsis para ser tratada depois*/
					if ($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['tabunicaporreg'] == 1) {
						if (in_array($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis'],array_keys($params['ligstabelasis_unicas']))) {
							self::unir_caracteristicas_ligtabsis($params,$params['ligstabelasis_unicas'][$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis']],$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]);
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['duplicado'] = true;
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis] = &$GLOBALS['null'];
							unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]);
						} else {
							$params['ligstabelasis_unicas'][$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]['codtabelasis']] = &$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis];
							$params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis] = &$GLOBALS['null'];
							unset($params['processos'][$chave_processo]['ligstabelasis'][$chave_ligtabelasis]);
						}				
						continue;
					}
				}
			}
		}

		/**
		 * ordena o conjunto de conjunto_ligstabelasis de um bloco_select
		 * 
		 * A ordenacao das ligstabelasis deve seguir a ordem que foram incluidas, pois geralmente obedecem a ordem das visoes que o usuario escolheu. 
		 * Somente a tabela de valores (9000000) deve ser movida para o final, se ja nao estiver na ultima posicao
		 * 
		 * @param {array} &$conjunto_ligstabelasis - o array de conjunto_ligstabelasis do processo
		 */
		private static function ordenar_conjunto_ligstabelasis(array &$conjunto_ligstabelasis) : void {
			if (count($conjunto_ligstabelasis) > 1) {
				$codtabelasis_valores = '9000000';
				foreach ($conjunto_ligstabelasis as $chave_ligtabelasis => &$ligtabelasis) {		
					if (trim((string)$conjunto_ligstabelasis[$chave_ligtabelasis]['codtabelasis']) === $codtabelasis_valores) {
						if (array_search($chave_ligtabelasis,array_keys($conjunto_ligstabelasis)) < (count($conjunto_ligstabelasis) - 1)) {
							/*move para a ultima posicao do array*/
							$temp = &$conjunto_ligstabelasis[$chave_ligtabelasis];
							unset($conjunto_ligstabelasis[$chave_ligtabelasis]);
							$conjunto_ligstabelasis[$chave_ligtabelasis] = $temp;
						}
					}
				}		
			}
		}

		/**
		 * ordena o conjunto de ligscamposis de um bloco_select
		 * @param {array} &$conjunto_ligscamposis - o array de conjunto_ligscamposis do processo
		 */
		private static function ordenar_conjunto_ligscamposis(array &$conjunto_ligscamposis) : void {
			if (count($conjunto_ligscamposis) > 1) {
				$ordens = [];
				foreach ($conjunto_ligscamposis as $chave_ligcamposis => &$ligcamposis) {
					if (!isset($conjunto_ligscamposis[$chave_ligcamposis]['ordem'])) {
						$conjunto_ligscamposis[$chave_ligcamposis]['ordem'] = $conjunto_ligscamposis[$chave_ligcamposis]['codligcamposis'];
					}
					if (strlen(trim($conjunto_ligscamposis[$chave_ligcamposis]['ordem'])) === 0) {
						$conjunto_ligscamposis[$chave_ligcamposis]['ordem'] = $conjunto_ligscamposis[$chave_ligcamposis]['codligcamposis'];
					}
					if (isset($ordens[(string)trim($conjunto_ligscamposis[$chave_ligcamposis]['ordem'])])) {
						$limitador_loop = 1000;
						$contador_looop = 0;
						while(isset($ordens[(string)trim($conjunto_ligscamposis[$chave_ligcamposis]['ordem'])])){
							$conjunto_ligscamposis[$chave_ligcamposis]['ordem']++;
							$contador_looop ++;
							if ($contador_looop > $limitador_loop) {
								FuncoesBasicasRetorno::mostrar_msg_sair("ordem '".$conjunto_ligscamposis[$chave_ligcamposis]['ordem']."' duplicada para o chave_ligcamposis: " . $chave_ligcamposis,__FILE__,__FUNCTION__,__LINE__);
							}
						}
					}
					$ordens[trim((string)$conjunto_ligscamposis[$chave_ligcamposis]['ordem'])] = $chave_ligcamposis;
				}
				ksort($ordens, SORT_NUMERIC);
				$camposis_ordenados = array();
				foreach ($ordens as $ordem => &$chave_ligcamposis) {
					$camposis_ordenados[$chave_ligcamposis] = &$conjunto_ligscamposis[$chave_ligcamposis];
				}
				$conjunto_ligscamposis = $camposis_ordenados;
			}
		}

		/**
		 * atribui as ordens de ligcamposis a ligcampodb referenciado
		 * @param {array} &$ligcampodb - o array de ligcampodb do processo
		 */
		private static function atribuir_ordem_ligcamposis_ligcampodb(array &$ligcampodb) : void {
			if (isset($ligcampodb['ligcamposis'])) {
				$ligcamposisref = self::obter_ligcamposis_ref_ligcampodb($ligcampodb);
				$ligcampodb['ordem'] = $ligcamposisref['ordem'];
				$ligcampodb['ordem_ligcamposis'] = $ligcampodb['ordem'];
			} else {
				print_r($ligcampodb);
				FuncoesBasicasRetorno::mostrar_msg_sair('referencia a ligcamposis nao existe em ligcampodb: '. $ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
			}
		}

		/**
		 * atribui as ordens de ligscamposis a ligscampodb e ligstabelasis referenciados
		 * @param {array} &$ligtabelasis - o array de ligtabelasis do processo
		 */
		private static function atribuir_ordens_ligcamposis_ligcampodb_ligtabelasis(array &$ligtabelasis) : void {
			foreach ($ligtabelasis['blocos_select'] as $chave_bloco_select => &$bloco_select) {	
				foreach($ligtabelasis['blocos_select'][$chave_bloco_select]['ligscampo'] as $chave_ligcampo => &$ligcampo) {
					self::atribuir_ordem_ligcamposis_ligcampodb($ligtabelasis['blocos_select'][$chave_bloco_select]['ligscampo'][$chave_ligcampo]);
				}
			}
		}

		/**
		 * atribui as ordens de ligscamposis a ligscampodb referenciados
		 * @param {array} &$params - o array de params do processo
		 */	
		private static function atribuir_ordens_ligscamposis_ligscampodb(array &$params) : void{
			foreach($params['processos'] as $chave_ligprocesso => &$processo) {
				foreach ($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {	
					self::atribuir_ordens_ligcamposis_ligcampodb_ligtabelasis($params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis]);
				}				
			}
			foreach ($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {	
				self::atribuir_ordens_ligcamposis_ligcampodb_ligtabelasis($params['ligstabelasis_unicas'][$chave_ligtabelasis]);
			}
		}

		/**
		 * ordena as ligstabelasis
		 * @param {array} &$params - o array de params do processo
		 */	
		private static function ordenar_ligstabelasis(array &$params) : void {	
			foreach($params['processos'] as $chave_ligprocesso => &$processo) {
				self::ordenar_conjunto_ligstabelasis($params['processos'][$chave_ligprocesso]['ligstabelasis']);
			}
			self::ordenar_conjunto_ligstabelasis($params['ligstabelasis_unicas']);
		}

		/**
		 * ordena as ligscamposis
		 * @param {array} &$params - o array de params do processo
		 */	
		private static function ordenar_ligscamposis(array &$params) : void {
			$ordens = [];
			foreach($params['processos'] as $chave_ligprocesso => &$processo) {
				foreach ($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {				
					self::ordenar_conjunto_ligscamposis($params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis]['ligscamposis']);
				}				
			}
			foreach ($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {				
				self::ordenar_conjunto_ligscamposis($params['ligstabelasis_unicas'][$chave_ligtabelasis]['ligscamposis']);
			}
		}

		/**
		 * ordena as ligacoes
		 * @param {array} &$params - o array de params do processo
		 */	
		private static function ordenar_ligs(array &$params) : void {	
			self::ordenar_ligstabelasis($params);	
			self::ordenar_ligscamposis($params);
			self::atribuir_ordens_ligscamposis_ligscampodb($params); 
		}

		/**
		 * duplica um ligcampodb
		 * @param {array} &$nova_ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} &$novo_bloco_select - o array de novo_bloco_select do processo
		 * @param {array} $ligcampodb - o array de ligcampodb a ser duplicado
		 * @return {array} - o array duplicado
		 */			
		private static function duplicar_ligcampodb(array &$nova_ligtabelasis,array &$novo_bloco_select, array $ligcampodb) : array {
			$novo_ligcampodb = [];	
			foreach($ligcampodb as $chave => $valor) {
				if (gettype($valor) !== 'array') {
					$novo_ligcampodb[$chave] = $valor;
				}
			}
			foreach($ligcampodb as $chave => $valor) {
				if (gettype($valor) === 'array') {
					switch(strtolower(trim($chave))) {
						case 'relacionamentos_especificos':
							$novo_ligcampodb[$chave] = FuncoesArray::arrayCopy($valor);
							break;
						case 'ligtabeladb':										
							if (!in_array(trim((string)$ligcampodb['codligtabeladb']),array_keys($novo_bloco_select['ligstabela']))) {
								$ligtabeladbref = self::obter_ligtabeladb_ref_ligcampodb($ligcampodb);
								if (!in_array(trim((string)$ligcampodb['codligtabeladb']),array_keys($novo_bloco_select['ligstabela'])) && strcasecmp(trim($novo_ligcampodb['transformacoes']),'null') != 0) {
									FuncoesBasicasRetorno::mostrar_msg_sair('chave ligtabeladb nao localizada no novo_bloco_select: '.$ligcampodb['codligtabeladb'],__FILE__,__FUNCTION__,__LINE__);
								}
							} 
							$novo_ligcampodb[$chave] = &$novo_bloco_select['ligstabela'][trim((string)$ligcampodb['codligtabeladb'])];
							break;
						case 'ref_bloco_select':
							/*nada a fazer, campo temporaria criado em outros processsos*/
							break;
						case 'ligcamposis':
							$novo_ligcampodb[$chave] = &$nova_ligtabelasis['ligscamposis'][trim((string)$ligcampodb['codligcamposis'])];
							break;
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair('chave nao esperada: ' . $chave, __FILE__,__FUNCTION__,__LINE__);
							break;
					}
				} 
			}
			return $novo_ligcampodb;
		}

		/**
		 * duplica um ligtabeladb
		 * @param {array} &$nova_ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} $ligtabeladb - o array de ligtabeladb a ser duplicado
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_ligtabeladb(array &$nova_ligtabelasis, array $ligtabeladb) : array {
			$nova_ligtabeladb = [];
			foreach($ligtabeladb as $chave => $valor) {
				if (gettype($valor) === 'array') {
					switch(strtolower(trim($chave))) {
						case 'ligsrelacionamento':
							$nova_ligtabeladb[$chave] = FuncoesArray::arrayCopy($valor);
							break;
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair('chave nao esperada: ' . $chave, __FILE__,__FUNCTION__,__LINE__);
							break;
					}
				} else {
					$nova_ligtabeladb[$chave] = $valor;
				}
			}
			return $nova_ligtabeladb;
		}

		/**
		 * duplica um conjunto de ligstabela
		 * @param {array} &$nova_ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} $ligstabela - o array de ligstabela a ser duplicado
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_conjunto_ligstabela(array &$nova_ligtabelasis, array $ligstabela) : array {
			$novo_conjunto_ligstabela = [];
			foreach($ligstabela as $chave_ligtabela => $ligtabela) {
				if (is_numeric($chave_ligtabela)) {
					if (gettype($ligtabela) === 'array') {
						if (isset($ligtabela['codligtabeladb'])) {
							$novo_conjunto_ligstabela[trim((string)$chave_ligtabela)] = self::duplicar_ligtabeladb($nova_ligtabelasis, $ligtabela);
						} else {
							print_r($ligtabela);
							FuncoesBasicasRetorno::mostrar_msg_sair('ligtabela nao tem codligtabeladb, implementar', __FILE__,__FUNCTION__,__LINE__);
							exit();
						}
					} else {				
						$novo_conjunto_ligstabela[trim((string)$chave_ligtabela)] = $ligstabela;
					}
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair('chave_ligtabela nao esperada: ' . $chave_ligtabela, __FILE__,__FUNCTION__,__LINE__);
				}
			}
			return $novo_conjunto_ligstabela;
		}

		/**
		 * duplica um conjunto de ligscampodb
		 * @param {array} &$nova_ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} $novo_bloco_select - o array de bloco select
		 * @param {array} $ligscampodb - o array de ligscampodb a ser duplicado
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_ligscampodb(array &$nova_ligtabelasis, array &$novo_bloco_select, array &$ligscampodb) : array {
			$novo_ligscampodb = [];
			foreach($ligscampodb as $chave_ligcampodb => $ligcampodb) {
				if (is_numeric($chave_ligcampodb)) {
					if (gettype($ligcampodb) === 'array') {
						if (isset($ligcampodb['codligcampodb'])) {
							$novo_ligscampodb[trim((string)$chave_ligcampodb)] = self::duplicar_ligcampodb($nova_ligtabelasis, $novo_bloco_select,$ligcampodb);
						} else {
							print_r($ligcampodb);
							FuncoesBasicasRetorno::mostrar_msg_sair('ligcampodb nao tem codligtabeladb, implementar', __FILE__,__FUNCTION__,__LINE__);
							exit();
						}
					} else {
						FuncoesBasicasRetorno::mostrar_msg_sair('tipo ligcampodb nao esperada: ' . gettype($ligcampodb), __FILE__,__FUNCTION__,__LINE__);
					}
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair('chave_ligcampodb nao esperada: ' . $chave_ligcampodb, __FILE__,__FUNCTION__,__LINE__);
				}
			}
			return $novo_ligscampodb;
		}

		/**
		 * duplica um blocos_select
		 * @param {array} &$nova_ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} $bloco_select - o array de bloco select a ser duplicado
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_bloco_select(array &$nova_ligtabelasis,array $bloco_select) : array {
			$novo_bloco_select = [];
			$novo_bloco_select['ligstabela'] = self::duplicar_conjunto_ligstabela($nova_ligtabelasis,$bloco_select['ligstabela']);
			foreach($bloco_select as $chave => $valor) {
				if (gettype($valor) === 'array') {
					switch(strtolower(trim($chave))) {				
						case 'ligsrelacionamento':
						case 'datas_periodo':
						case 'comando_sql':
							$novo_bloco_select[$chave] = FuncoesArray::arrayCopy($valor);
							break;
						case 'ligscampo':
							$novo_bloco_select[$chave] = self::duplicar_ligscampodb($nova_ligtabelasis,$novo_bloco_select, $valor);
							break;
						case 'ligstabela':
							break;
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair('chave nao esperada: ' . $chave, __FILE__,__FUNCTION__,__LINE__);
							break;
					}
				} else {
					$novo_bloco_select[$chave] = $valor;
				}
			}
			return $novo_bloco_select;
		}

		/**
		 * duplica um array de blocos_select
		 * @param {array} &$ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} $blocos_select - o array de bloco select a ser duplicado
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_blocos_select(array &$nova_ligtabelasis, array $blocos_select) : array {
			$novo_blocos_select = [];
			foreach($blocos_select as $chave_bloco_select => $bloco_select) {
				if (gettype($bloco_select) === 'array') {
					if (is_numeric($chave_bloco_select)) {
						$novo_blocos_select[$chave_bloco_select] = self::duplicar_bloco_select($nova_ligtabelasis,$bloco_select);
					} else {
						FuncoesBasicasRetorno::mostrar_msg_sair('chave_bloco_select nao esperada: ' . $chave_bloco_select, __FILE__,__FUNCTION__,__LINE__);
					}
				} else {
					$novo_blocos_select[$chave_bloco_select] = $bloco_select;
				}
			}
			return $novo_blocos_select;
		}

		/**
		 * duplica uma ligtabelasis
		 * @param {array} &$ligtabelasis - o array de ligtabelasis do processo
		 * @return {array} - o array duplicado
		 */	
		private static function duplicar_ligtabelasis(array $ligtabelasis) : array {
			$nova_ligtabelasis = [];	
			/*duplica primeiramente as chaves dos tipos primitivos*/
			foreach($ligtabelasis as $chave => $valor) {
				if (gettype($valor) !== 'array') {
					$nova_ligtabelasis[$chave] = $valor;
				}
			}
			$nova_ligtabelasis['ligscamposis'] = FuncoesArray::arrayCopy($ligtabelasis['ligscamposis']);
			/*duplica os arrays, exceto o ligscamposis, duplicado antecipadamente pq serve de referencia para ligcampodb*/
			foreach($ligtabelasis as $chave => $valor) {
				if (gettype($valor) === 'array') {
					switch(strtolower(trim($chave))) {
						case 'ligsrelacionamento':
						case 'condicionantes':
						case 'campos_avulsos':
							$nova_ligtabelasis[$chave] = FuncoesArray::arrayCopy($valor);
							break;
						case 'blocos_select':
							$nova_ligtabelasis[$chave] = self::duplicar_blocos_select($nova_ligtabelasis,$valor);
							break;
						case 'ligscamposis':
							break;
						default:
							FuncoesBasicasRetorno::mostrar_msg_sair('chave nao esperada: ' . $chave, __FILE__,__FUNCTION__,__LINE__);
							break;
					}
				} 
			}	
			return $nova_ligtabelasis;
		}

		/**
		 * gera a ligtabelasis do processo se houverem condicionantes de datas, uma para cada periodo de data (ini,fim)
		 * @param {string|number} &$chave_ligtabelasis - a chave da ligtabelasis no array de ligstabelasis do processo
		 * @param {array} &$ligtabelasis - o array de ligtabelasis do processo
		 * @param {array} &$periodos - o array de periodos do processo
		 */	
		private static function gerar_ligtabelasis_conforme_datas(string|number $chave_ligtabelasis, array &$ligtabelasis, array $periodos) : void {	
			if ($ligtabelasis['gerarconfintervdata'] == 1) {
				$novas_ligtabelasis = [];
				foreach($periodos as $chave_periodo => &$periodo) {
					$nova_ligtabelasis = self::duplicar_ligtabelasis($ligtabelasis);
					$chave_nova_ligtabelasis = $chave_ligtabelasis . '_' . $chave_periodo;
					$nova_ligtabelasis['alias'] .= '_' . $chave_periodo;
					$nova_ligtabelasis['periodo'] = $chave_periodo;
					$nova_ligtabelasis['datas_periodo'] = $periodo;
					$novas_ligtabelasis[$chave_nova_ligtabelasis] = $nova_ligtabelasis;					
				}
				if (count($novas_ligtabelasis) > 0) {
					$ligtabelasis = [
						'gerarconfintervdata' => $ligtabelasis['gerarconfintervdata'],
						'codtabelasis' => $nova_ligtabelasis['codtabelasis'],
						'ligstabelasis' => $novas_ligtabelasis
					];
				}
			}
		}

		/**
		 * gera a ligstabelasis dos processos se houverem condicionantes de datas, uma para cada periodo de data (ini,fim)
		 * @param {array} &$params - o array de params dos processos
		 */	
		private static function gerar_ligstabelasis_conforme_datas(array &$params) : void {	
			foreach($params['processos'] as $chave_ligprocesso => &$processo) {
				foreach($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					self::gerar_ligtabelasis_conforme_datas($chave_ligtabelasis, $params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis], $params['periodos']);
				}
			}
			foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
				self::gerar_ligtabelasis_conforme_datas($chave_ligtabelasis, $params['ligstabelasis_unicas'][$chave_ligtabelasis], $params['periodos']);
			}
		}

		/**
		 * gera a resultante intermediaria dos processsos
		 * @param {array} &$params - o array de params dos processos
		 */	
		private static function gerar_resultante_intermediaria(array &$params) :void {
			$params['resultante_intermediaria'] = [];
			$params['resultante_intermediaria']['blocos_select'] = [];
			if (isset($params['periodos']) && count($params['periodos']) > 0) {
				foreach($params['periodos'] as $chave_periodo => &$periodo) {
					self::inicializar_bloco_select($params['resultante_intermediaria']['blocos_select'],$chave_periodo);	
					$params['resultante_intermediaria']['blocos_select'][$chave_periodo]['periodo'] = $chave_periodo;
					$params['resultante_intermediaria']['blocos_select'][$chave_periodo]['datas_periodo'] = $periodo;
					foreach($params['processos'] as $chave_ligprocesso => &$processo) {
						foreach($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
							$params['resultante_intermediaria']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis];
						}
					}
					foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
						if (isset($params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata']) && $params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata'] == 1) {
							$params['resultante_intermediaria']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis]['ligstabelasis'][$chave_ligtabelasis.'_'.$chave_periodo];
						} else {
							$params['resultante_intermediaria']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis];
						}
					}
				}
			} else {
				self::inicializar_bloco_select($params['resultante_intermediaria']['blocos_select'],0);		
				foreach($params['processos'] as $chave_ligprocesso => &$processo) {
					foreach($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
						$params['resultante_intermediaria']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis];			
					}
				}
				foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
					if (isset($params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata']) && $params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata'] == 1) {
						$params['resultante_intermediaria']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis]['ligstabelasis'][$chave_ligtabelasis.'_0'];
					} else {
						$params['resultante_intermediaria']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis];
					}
				}
			}
		}

		/**
		 * gera a resultante final dos processsos
		 * @param {array} &$params - o array de params dos processos
		 */	
		private static function gerar_resultante_final(array &$params) : void {
			$params['resultante_final'] = [];
			$params['resultante_final']['blocos_select'] = [];
			if (isset($params['periodos']) && count($params['periodos']) > 0) {
				foreach($params['periodos'] as $chave_periodo => &$periodo) {
					self::inicializar_bloco_select($params['resultante_final']['blocos_select'],$chave_periodo);		
					foreach($params['processos'] as $chave_ligprocesso => &$processo) {
						foreach($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
							$params['resultante_final']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis];
						}
					}
					foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
						if (isset($params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata']) && $params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata'] == 1) {
							$params['resultante_final']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis]['ligstabelasis'][$chave_ligtabelasis.'_'.$chave_periodo];
						} else {
							$params['resultante_final']['blocos_select'][$chave_periodo]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis];
						}
					}
				}
			} else {
				self::inicializar_bloco_select($params['resultante_final']['blocos_select'],0);		
				foreach($params['processos'] as $chave_ligprocesso => &$processo) {
					foreach($params['processos'][$chave_ligprocesso]['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
						$params['resultante_final']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['processos'][$chave_ligprocesso]['ligstabelasis'][$chave_ligtabelasis];
					}
				}
				foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
					if (isset($params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata']) && $params['ligstabelasis_unicas'][$chave_ligtabelasis]['gerarconfintervdata'] == 1) {
						$params['resultante_final']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis]['ligstabelasis'][$chave_ligtabelasis.'_0'];
					} else {
						$params['resultante_final']['blocos_select'][0]['ligstabela'][$chave_ligtabelasis] = &$params['ligstabelasis_unicas'][$chave_ligtabelasis];
					}
				}
			}
		}

		/**
		 * prepara ligstabelasis se houverem condicionantes como processo
		 * @param {array} &$params - o array de params do processo
		 * @param {array} &$ligstabelasis - o array de ligstabelasis do processo
		 */	
		private static function preparar_processo_condicionantes_ligstabelasis(array &$params, array &$ligstabelasis) : void {
			foreach($ligstabelasis as $chave_ligtabelasis => &$ligtabelasis) {
				if ($ligtabelasis['duplicado'] === false) {			
					if (((isset($ligtabelasis['tipo']) && strcasecmp(trim($ligtabelasis['tipo']), 'condicionante') == 0) || 
						(isset($ligtabelasis['temcondicexplic']) && $ligtabelasis['temcondicexplic']=== true)) &&
						(isset($ligtabelasis['condicionantes']) && count($ligtabelasis['condicionantes']) > 0)) {				
						$condicionantes_processo = $ligtabelasis['condicionantes'];			
						if (gettype($condicionantes_processo) !== 'array') {								
							$condicionantes_processo = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condicionantes_processo);
						}
						/*INCLUSAO DAS CONDICIONANTES SAO INCLUIDAS NOS COMANDOS SQL*/
						if (count($condicionantes_processo) > 0) {	
							/*encontrar os camposdb do processo que aceitam a condic*/
							$ligscampodb_condicionante = [];
							foreach($ligtabelasis['blocos_select'] as $chave_bloco_select => &$bloco_select) {
								foreach($bloco_select['ligscampo'] as $chave_ligcampodb => &$ligcampodb) {
									if ($ligcampodb['duplicado'] === false) {
										if (in_array($ligtabelasis['codprocesso'], explode(',', $ligcampodb['aceita_condic_proc']))) {									
											$ligcampodb['ref_bloco_select'] = &$bloco_select;
											$ligscampodb_condicionante[$chave_ligcampodb] = &$ligcampodb;									
										}
									}
								}
							}					
							if (count($ligscampodb_condicionante) > 0) {
								foreach($ligtabelasis['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {
									if (strcasecmp(trim($ligrelacionamento['tipoligtabela2']),'sis') == 0) {
										$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao'] = trim($params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao']);
										$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao'] = str_ireplace('left outer','',$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao']);
										$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao'] = str_ireplace('right outer','',$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao']);
										$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao'] = str_ireplace('inner','',$params['conjuntos_dados']['relacionamento'][$ligrelacionamento['codrelacionamento']]['tipojuncao']);
									}
								}
								foreach($ligscampodb_condicionante as $chave_ligcampodb => &$ligcampodb) {
									if ($ligcampodb['duplicado'] === false) {
										$condicionantes_campo = [];
										$texto_condicionante_campo = $ligcampodb['criterio_cond'];
										$texto_condicionante_campo = str_ireplace('__tabela__.__campo__',$ligcampodb['ligtabeladb']['alias'] . '.' . $params['conjuntos_dados']['campodb'][trim((string)$ligcampodb['codcampodb'])]['nomecampodb'],$texto_condicionante_campo);
										$texto_condicionante_campo = str_ireplace('__tabela__',$ligcampodb['ligtabeladb']['alias'] ,$texto_condicionante_campo);
										$texto_condicionante_campo = str_ireplace('__campo__',$ligcampodb['ligtabeladb']['alias'] . '.' . $params['conjuntos_dados']['campodb'][trim((string)$ligcampodb['codcampodb'])]['nomecampodb'],$texto_condicionante_campo);								
										$texto_condicionante_campo = str_ireplace('distinct','',$texto_condicionante_campo);
										foreach($condicionantes_processo as &$conjunto_condicionante_processo) {
											$codprocesso_condic_original = null;
											if (isset($conjunto_condicionante_processo['codprocesso_original'])) {
												$codprocesso_condic_original = $conjunto_condicionante_processo['codprocesso_original'];
												if (strcasecmp(trim($codprocesso_condic_original),trim($ligcampodb['codprocesso_original'])) != 0 &&
													(!in_array($codprocesso_condic_original,explode(',',$ligcampodb['aceita_condic_proc'])))
													) {
													/*salta para o proximo item do loop, este item nao pertence ao campo*/
													continue;
												}
											}
											if (gettype($conjunto_condicionante_processo) === 'array') {
												if (count($conjunto_condicionante_processo) > 0) {
													foreach($conjunto_condicionante_processo as $chave_condicionante => &$item_condicionante) {
														if (gettype($item_condicionante) === 'array') {
															$op = strtolower(trim($item_condicionante['op']));
															$texto_condicionante = $texto_condicionante_campo;
															$texto_condicionante = str_ireplace('__opcond__',$op,$texto_condicionante);
															$texto_condicionante = str_ireplace('__valorcond__',$item_condicionante['valor'],$texto_condicionante);
															if (!isset($condicionantes_campo[$op])) {
																$condicionantes_campo[$op] = [];
															}
															$condicionantes_campo[$op][] = $texto_condicionante;
														}
													}
												}
											}
										}								
										if (count($condicionantes_campo) > 0) {
											foreach($condicionantes_campo as $op => &$condicionantes) {
												switch(strtolower(trim($op))) {
													case '=':
													case 'ig':
													case 'in':
														if (count($condicionantes) > 0) {
															$condicionantes_campo[$op] = '(' . implode(' or ',$condicionantes) . ')';												
														} else {
															unset($condicionantes_campo[$op]);
														}
														break;
													case '!=':
													case 'not in':
													case '<>':
													case 'anterior':
														if (count($condicionantes) > 0) {												
															$condicionantes_campo[$op] = '(' . implode(' and ',$condicionantes) . ')';												
														} else {
															unset($condicionantes_campo[$op]);
														}
														break;
													default:
														FuncoesBasicasRetorno::mostrar_msg_sair('operacao de comparacao nao esperada: ' . $op,__FILE__,__FUNCTION__,__LINE__);
														break;
												}
												if (strlen(trim(str_replace([' ','(((())))','((()))','(())','()'],'',str_replace(' ','',$condicionantes_campo[$op])))) === 0) {
													unset($condicionantes_campo[$op]);
													continue;
												}
											}
											$condicionantes_campo = '(' . implode(' and ',$condicionantes_campo) . ')';
											if (strlen(trim(str_replace([' ','(((())))','((()))','(())','()'],'',str_replace(' ','',$condicionantes_campo)))) > 0) {
												$ligcampodb['ref_bloco_select']['comando_sql']['condicionante'][] = $condicionantes_campo;
											}
										}
									}
									$ligcampodb['ref_bloco_select'] = &$GLOBALS['null'];
									unset($ligcampodb['ref_bloco_select']);
								}
							}
						}
					}
				}
			}
		}

		/**
		 * prepara processos se houverem condicionantes como processo
		 * @param {array} &$params - o array de params do processo
		 */	
		private static function preparar_processos_condicionantes(array &$params) : void {
			foreach($params['processos'] as $chave_processo => &$processo) {
				if (strcasecmp(trim($processo['tipo']), 'condicionante') == 0 || $processo['temcondicexplic'] === true) {			
					self::preparar_processo_condicionantes_ligstabelasis($params,$processo['ligstabelasis']);			
				}
			}	
			self::preparar_processo_condicionantes_ligstabelasis($params,$params['ligstabelasis_unicas']);	
		}

		/**
		 * Obtem os dados do processo estruturado
		 * @param {array} &$params - o array de params do processo
		 * @return {array} os dados obtidos do processo estruturado
		 */	
		private static function obter_processo_estruturado(array &$params) : array {
			/*INICIALIZAÇÃO DE VARIAVEIS*/
			$params['cods_campos_sis_valores_visiveis'] = [];
			/*DEFINE O CONJUNTO DE CAMPOS REFERENTES A VALORES VISIVEIS*/
			if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'])) {
				if (gettype($params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de']) !== 'array') {
					$params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'] = explode(',', strtolower(trim((string)$params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'])));
				} 
				if (count($params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de']) > 0) {
					foreach ($params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'] as &$mostvalde) {
						if ((integer)$mostvalde < 6) {
							$params['cods_campos_sis_valores_visiveis'][] = (string)((integer)$mostvalde + 9009000);
						}
					}
				}
			}
			if (gettype($params['processos']) !== 'array') {
				$params['processos'] = explode(',', str_replace(' ' , '_' , (string)$params['processos']));
			}	
			foreach ($params['processos'] as $chave_proc => &$proc) {
				$proc = ['nome' => $proc, 'tipo' => 'normal', 'condicionantes' => [], 'campos_avulsos' => [], 'temcondicexplic' => false];
			}
			/*FIM INICIALIZACAO DE VARIAVEIS*/
			/*INSERE VISOES, SE NECESSARIO, PARA VINCULAR AS CONDICIONANTES OU VINCULA-AS NAS VISOES JÁ EXISTENTES SE COMPATIVEIS*/	
			$cnj_condicionantes_processo = FuncoesProcessoSql::prepararCondicionantesProcessoSql($params['comhttp']->requisicao->requisitar->qual->condicionantes['condicionantes']);	
			$prefixo_nome_proc_condic = '';
			$tradutor_processo_condic = null;
			if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['prefixo_nome_proc_condic'])) {
				if (strlen(trim($params['comhttp']->requisicao->requisitar->qual->condicionantes['prefixo_nome_proc_condic'])) > 0) {
					$prefixo_nome_proc_condic = strtolower(trim($params['comhttp']->requisicao->requisitar->qual->condicionantes['prefixo_nome_proc_condic']));
				}
			}
			if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['tradutor_processo_condic'])) {
				if (strlen(trim($params['comhttp']->requisicao->requisitar->qual->condicionantes['tradutor_processo_condic'])) > 0) {
					$tradutor_processo_condic = strtolower(trim($params['comhttp']->requisicao->requisitar->qual->condicionantes['tradutor_processo_condic']));
				}
			}
			self::acrescenta_vincula_processos_condicionantes($params['processos'], $cnj_condicionantes_processo, $prefixo_nome_proc_condic,$tradutor_processo_condic);	
			/*INSERE VISOES, SE NECESSARIO, PARA VINCULAR OS CAMPOS AVULSOS OU INSERE-OS NAS JÁ EXISTENTES SE COMPATÍVEIS*/
			if (isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['campos avulsos'])) {	
				$cnj_cmps_avulsos = $params['comhttp']->requisicao->requisitar->qual->condicionantes['campos avulsos']; 
				self::acrescenta_vincula_processos_campos_avulsos($params['processos'], $cnj_cmps_avulsos);
			}
			self::atribuir_dados_processos($params);		
			self::formar_processo_estruturado($params);		
			self::separar_blocos($params);
			self::preparar_ligtabelasis_unica($params);
			self::ordenar_ligs($params);	
			self::preparar_processos_condicionantes($params);
			self::gerar_ligstabelasis_conforme_datas($params);	
			self::gerar_resultante_intermediaria($params);
			self::gerar_resultante_final($params);
			return $params;
		}

		/**
		 * Obtem o array ligtabeladb de referencia de um ligcampodb
		 * @param {array} &$ligcampodb - o array do registro de ligcampodb do banco de dados (associativo)
		 * @return {array} o ligtabeladb encontrado
		 */	
		private static function obter_ligtabeladb_ref_ligcampodb(array &$ligcampodb) : array {
			if (!isset($ligcampodb['ligtabeladb'])) {
				print_r($ligcampodb);
				FuncoesBasicasRetorno::mostrar_msg_sair('ligtabeladb nao existe no campo: ' .$ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
			}
			$ligtabeladbref = $ligcampodb['ligtabeladb'];
			if ($ligtabeladbref['duplicado'] === true) {
				$limitador_looop = 1000;
				$contador_loop = 0;
				while ($contador_loop < 1000 && $ligtabeladbref['duplicado'] === true) {
					$ligtabeladbref = &$ligtabeladbref['original'];
					$contador_loop++;
				}
				if ($ligtabeladbref['duplicado'] === true) {
					FuncoesBasicasRetorno::mostrar_msg_sair('ligtabeladbref encontrada eh duplicada para o ligcampodb ' . $ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
				}
				$ligcampodb['ligtabeladb'] = &$ligtabeladbref;
				$ligcampodb['codligtabeladb'] = $ligcampodb['ligtabeladb']['codligtabeladb'];
			}
			return $ligtabeladbref;
		}

		/**
		 * Obtem o array ligcamposis de referencia de um ligcampodb
		 * @param {array} &$ligcampodb - o array do registro de ligcampodb do banco de dados (associativo)
		 * @return {array} o ligcamposis encontrado
		 */	
		private static function obter_ligcamposis_ref_ligcampodb(array &$ligcampodb) : array {
			if (!isset($ligcampodb['ligcamposis'])) {
				print_r($ligcampodb);
				FuncoesBasicasRetorno::mostrar_msg_sair('ligcamposis nao existe no campo: ' .$ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
			}
			$ligcamposisref = $ligcampodb['ligcamposis'];
			if (isset($ligcamposisref['duplicado']) && $ligcamposisref['duplicado'] === true) {
				$limitador_looop = 1000;
				$contador_loop = 0;
				while ($contador_loop < 1000 && $ligcamposisref['duplicado'] === true) {
					$ligcamposisref = &$ligcamposisref['original'];
					$contador_looop++;
				}
				if ($ligcamposisref['duplicado'] === true) {
					FuncoesBasicasRetorno::mostrar_msg_sair('ligcamposisref encontrada eh duplicada para o ligcampodb ' . $ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
				}
				$ligcampodb['ligcamposis'] = &$ligcamposisref;
			}
			return $ligcamposisref;
		}

		/**
		 * Monta o texto sql de um registro tabeladb
		 * @param {array} &$params - o array de params
		 * @param {array} &$bloco_select - o array de bloco_select
		 * @param {array} &$ligtabeladb - o array do registro de ligtabeladb do banco de dados (associativo)
		 * @return {string} o texto sql montado
		 */	
		private static function montar_texto_sql_tabeladb(array &$params, array &$bloco_select, array &$ligtabeladb) : string {
			if ($ligtabeladb['duplicado'] === false) {
				if (isset($ligtabeladb['tipoligtabeladb']) && strcasecmp(trim($ligtabeladb['tipoligtabeladb']),'sis') == 0) {
					$ligtabeladb['texto_sql'] = $params['conjuntos_dados']['tabelasis'][trim((string)$ligtabeladb['codtabeladb'])]['alias'] . ' ' . $params['conjuntos_dados']['tabelasis'][trim((string)$ligtabeladb['codtabeladb'])]['alias'] . ' ';
				} else {
					$ligtabeladb['texto_sql'] = $params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['nomeschemadb'] . '.' . $params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['nometabeladb'] . ' ' . $ligtabeladb['alias'] . ' ';
				}
				if (isset($ligtabeladb['transformacoes']) && strlen(trim($ligtabeladb['transformacoes'])) > 0) {
					$ligtabeladb['texto_sql'] = $ligtabeladb['transformacoes'];
					$ligtabeladb['texto_sql'] = str_ireplace('__USUARIODB__',$params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['nomeschemadb'],$ligtabeladb['texto_sql']);
					$ligtabeladb['texto_sql'] = str_ireplace('__TABELA__',$params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['nometabeladb'],$ligtabeladb['texto_sql']);
				}
				if (count($ligtabeladb['ligsrelacionamento']) > 0) {
					if (count($ligtabeladb['ligsrelacionamento']) > 1) {
						FuncoesBasicasRetorno::mostrar_msg_sair('encontrado '.count($ligtabeladb['ligsrelacionamento']).' quando era esperado somente 1 para a ligtabeladb='.$ligtabeladb['codligtabeladb'],__FILE__,__FUNCTION__,__LINE__);
					}
					foreach($ligtabeladb['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {
						if ($ligrelacionamento['duplicado'] === false) {
							if (stripos($params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'],'union') !== false) {
								$bloco_select['comando_sql']['tem_union_anterior'] = true;
								$bloco_select['comando_sql']['union_anterior'] = $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'];
							} else {
								$ligtabeladb['texto_sql'] = $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'] . ' ' . $ligtabeladb['texto_sql'] ;
								$ligtabeladb['texto_sql'] .= ' on ( ';
								$ligtabeladb['texto_sql'] .= $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['criterios'];
								$ligtabeladb['texto_sql'] .= ' ) ';
								if (stripos($ligtabeladb['texto_sql'],'__ALIASTABELA1__') !== false) {
									if (isset($bloco_select['ligstabela'][$ligrelacionamento['codligtabela1']])) {
										$ligtabeladb['texto_sql'] = str_ireplace('__ALIASTABELA1__',$bloco_select['ligstabela'][$ligrelacionamento['codligtabela1']]['alias'],$ligtabeladb['texto_sql']);
									} else if (isset($params['conjuntos_dados']['ligstabeladb'][$ligrelacionamento['codligtabela1']])) {
										if (isset($params['conjuntos_dados']['ligstabeladb'][$ligrelacionamento['codligtabela1']]['original'])) {
											$ligtabeladb['texto_sql'] = str_ireplace('__ALIASTABELA1__',$params['conjuntos_dados']['ligstabeladb'][$ligrelacionamento['codligtabela1']]['original']['alias'],$ligtabeladb['texto_sql']);
										} else {
											$ligtabeladb['texto_sql'] = str_ireplace('__ALIASTABELA1__',$params['conjuntos_dados']['ligstabeladb'][$ligrelacionamento['codligtabela1']]['alias'],$ligtabeladb['texto_sql']);
										}												
									} else {
										FuncoesBasicasRetorno::mostrar_msg_sair('ligtabeladb nao encontrada: ' . $ligrelacionamento['codligtabela1'], __FILE__,__FUNCTION__,__LINE__);
									}
								}
								if (stripos($ligtabeladb['texto_sql'],'__ALIASTABELA2__') !== false) {
									$ligtabeladb['texto_sql'] = str_ireplace('__ALIASTABELA2__',$ligtabeladb['alias'],$ligtabeladb['texto_sql']);
								}				
							}
						}
					}
				}
				if (isset($params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['condicionantes']) && 
					strlen(trim($params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['condicionantes'])) > 0) {
					if (!isset($bloco_select['comando_sql']['condicionante'])) {
						$bloco_select['comando_sql']['condicionante'] = [];
					}
					$bloco_select['comando_sql']['condicionante'][] = str_ireplace('__ALIASTABELADB__',$ligtabeladb['alias'],str_ireplace('__aliastabeladb__',$ligtabeladb['alias'],$params['conjuntos_dados']['tabeladb'][trim((string)$ligtabeladb['codtabeladb'])]['condicionantes']));
				}
				return $ligtabeladb['texto_sql'];
			}	
		}

		/**
		 * Monta o texto sql de um registro ligcampodb
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {array} &$bloco_select - o array de bloco_select
		 * @param {array} &$ligcampodb - o array do registro de ligcampodb do banco de dados (associativo)
		 */	
		private static function montar_texto_sql_ligcampodb(array &$params, array &$ligtabelasis, array &$bloco_select, array &$ligcampodb) : void {
			$ligtabeladbref = self::obter_ligtabeladb_ref_ligcampodb($ligcampodb);
			$ligcamposisref = self::obter_ligcamposis_ref_ligcampodb($ligcampodb);
			if (isset($ligcampodb['tipoligcampodb']) && strcasecmp(trim($ligcampodb['tipoligcampodb']),'sis') == 0) {
				$ligcampodb['texto_campo_original'] = $ligtabeladbref['alias'] . '.' . $params['conjuntos_dados']['camposis'][trim((string)$ligcampodb['codcampodb'])]['alias'];
			} else {
				$ligcampodb['texto_campo_original'] = $ligtabeladbref['alias'] . '.' . $params['conjuntos_dados']['campodb'][trim((string)$ligcampodb['codcampodb'])]['nomecampodb'];
			}
			$ligcampodb['texto_campo_final'] = $ligcampodb['texto_campo_original'];
			if (!isset($ligcampodb['transformacoes'])) {
				$ligcampodb['transformacoes'] = '';
			}
			if (strlen(trim($ligcampodb['transformacoes'])) > 0) {
				$ligcampodb['texto_campo_transformado'] = $ligcampodb['transformacoes'];			
				$ligcampodb['texto_campo_transformado'] = str_ireplace('__TABELA__', $ligtabeladbref['alias'],$ligcampodb['texto_campo_transformado']);
				if (isset($ligcampodb['tipoligcampodb']) && strcasecmp(trim($ligcampodb['tipoligcampodb']),'sis') == 0) {
					$ligcampodb['texto_campo_transformado'] = str_ireplace('__CAMPO__', $params['conjuntos_dados']['camposis'][trim((string)$ligcampodb['codcampodb'])]['alias'],$ligcampodb['texto_campo_transformado']);
				} else {
					$ligcampodb['texto_campo_transformado'] = str_ireplace('__CAMPO__', $params['conjuntos_dados']['campodb'][trim((string)$ligcampodb['codcampodb'])]['nomecampodb'],$ligcampodb['texto_campo_transformado']);
				}
				$ligcampodb['texto_campo_final'] = $ligcampodb['texto_campo_transformado'];
			}
			if (!isset($ligcampodb['agrupamento'])) {
				$ligcampodb['agrupamento'] = '';
			}
			switch(strtolower(trim($ligcampodb['criterio_uso']))) {
				case 'usar sempre' :
				case 'campo de ligacao':
				case 'campo avulso':								
					if (strlen(trim($ligcampodb['agrupamento'])) > 0) {
						$ligcampodb['texto_campo_agrupamento'] = $ligcampodb['agrupamento'];
						$ligcampodb['texto_campo_agrupamento'] = str_ireplace('__TABELA__.__CAMPO__',$ligcampodb['texto_campo_final'],$ligcampodb['texto_campo_agrupamento']);
						$ligcampodb['texto_campo_agrupamento'] = str_ireplace('__TABELA__',$ligcampodb['ligtabeladb']['alias'],$ligcampodb['texto_campo_agrupamento']);
						$ligcampodb['texto_campo_agrupamento'] = str_ireplace('__CAMPO__',$ligcampodb['texto_campo_final'],$ligcampodb['texto_campo_agrupamento']);									
						$ligcampodb['texto_campo_final'] = $ligcampodb['texto_campo_agrupamento'];
						$bloco_select['comando_sql']['tem_group'] = true;
					} else {
						if (!isset($bloco_select['comando_sql']['group'][$ligcampodb['codligcampodb']])) {
							$bloco_select['comando_sql']['group'][$ligcampodb['codligcampodb']] = str_ireplace('distinct','',$ligcampodb['texto_campo_final']);
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair('ligcampodb duplicado: ' . $ligcampodb['codligcampodb'],__FILE__,__FUNCTION__,__LINE__);
						}
					}
					$alias = $ligcamposisref['alias'];
					if (!isset($alias) || $alias === null) {
						$alias = $ligcampodb['alias'];
					}
					if (strlen(trim($alias)) === 0) {
						$alias = $ligcampodb['alias'];
					}
					$ligcampodb['texto_campo_final_com_alias'] = $ligcampodb['texto_campo_final'] . ' as ' . $alias; 
					if (!isset($bloco_select['comando_sql']['select'][$ligcampodb['ordem_ligcamposis']])) {
						$bloco_select['comando_sql']['select'][$ligcampodb['ordem_ligcamposis']] = $ligcampodb['texto_campo_final_com_alias'];
					} else {
						print_r($ligcampodb); 
						FuncoesBasicasRetorno::mostrar_msg_sair('ordem duplicada de ligcamposis replicada em ligcampodb: ' . $ligcampodb['ordem_ligcamposis'],__FILE__,__FUNCTION__,__LINE__);
					}
					break;
				case 'condicionante':							
					if (strlen(trim($ligcampodb['agrupamento'])) > 0) {
						FuncoesBasicasRetorno::mostrar_msg_sair('ligacao campo condicionante nao pode ter agrupamento.  CODLIGCAMPODB: ' . $ligcampodb['codligcampodb'] . ',' . $ligcampodb['agrupamento'],__FILE__,__FUNCTION__,__LINE__);
					}
					if (strlen(trim($ligcampodb['especificacao_criterio'])) > 0) {
						$ligcampodb['texto_campo_condicionante'] = $ligcampodb['especificacao_criterio'];
						$ligcampodb['texto_campo_condicionante'] = str_ireplace('__TABELA__.__CAMPO__',$ligcampodb['texto_campo_final'],$ligcampodb['texto_campo_condicionante']);
						$ligcampodb['texto_campo_condicionante'] = str_ireplace('__TABELA__',$ligtabeladbref['alias'],$ligcampodb['texto_campo_condicionante']);
						$ligcampodb['texto_campo_condicionante'] = str_ireplace('__CAMPO__',$ligcampodb['texto_campo_final'],$ligcampodb['texto_campo_condicionante']);
						$ligcampodb['texto_campo_condicionante'] = str_ireplace(' ENTRE ', ' BETWEEN ' ,$ligcampodb['texto_campo_condicionante']);
						$ligcampodb['texto_campo_condicionante'] = str_ireplace(' E ', ' AND ' ,$ligcampodb['texto_campo_condicionante']);
						if (isset($ligtabelasis['datas_periodo']) && count($ligtabelasis['datas_periodo']) > 0) {
							//echo FuncoesData::detectar_formato($ligtabelasis['datas_periodo'][0]); exit();
							$ligcampodb['texto_campo_condicionante'] = str_ireplace('__VDTINI__',"'".$ligtabelasis['datas_periodo'][0]."'",$ligcampodb['texto_campo_condicionante']);
							$ligcampodb['texto_campo_condicionante'] = str_ireplace('__VDTFIM__',"'".$ligtabelasis['datas_periodo'][1]."'",$ligcampodb['texto_campo_condicionante']);
						} else if (isset($params['periodos']) && count($params['periodos']) > 0) {
							//echo FuncoesData::detectar_formato($params['periodos'][0][0]); exit();
							$ligcampodb['texto_campo_condicionante'] = str_ireplace('__VDTINI__',"'".$params['periodos'][0][0]."'",$ligcampodb['texto_campo_condicionante']);
							$ligcampodb['texto_campo_condicionante'] = str_ireplace('__VDTFIM__',"'".$params['periodos'][0][1]."'",$ligcampodb['texto_campo_condicionante']);
						}
						$bloco_select['comando_sql']['tem_condicionante'] = true;
						if (!isset($bloco_select['comando_sql']['condicionante'][$ligcampodb['ordem_ligcamposis']])) {
							$bloco_select['comando_sql']['condicionante'][$ligcampodb['ordem_ligcamposis']] = $ligcampodb['texto_campo_condicionante'];
						} else {
							/*para condicionante, permite-se ordens duplicadas (mesmo campo sis)*/
							$nova_ordem = $ligcampodb['ordem_ligcamposis'] + 1;
							while(isset($bloco_select['comando_sql']['condicionante'][$nova_ordem])) {
								$nova_ordem++;
							}
							$bloco_select['comando_sql']['condicionante'][$nova_ordem] = $ligcampodb['texto_campo_condicionante'];
						} 
					} else {
						FuncoesBasicasRetorno::mostrar_msg_sair('ligacao campo condicionante obrigatoriamente tem que ter preenchido o capmo especificacao criterio.  CODLIGCAMPODB: ' . $ligcampodb['codligcampodb'] . ',' . $ligcampodb['especificacao_criterio'],__FILE__,__FUNCTION__,__LINE__);
					}
					break;
				default :
					FuncoesBasicasRetorno::mostrar_msg_sair('criterio_uso ligcampodb nao esperado: ' . $ligcampodb['criterio_uso'],__FILE__,__FUNCTION__,__LINE__);
			}
		}

		/**
		 * Monta o texto sql de comando_sql (array)
		 * @param {array} &$comando_sql - o array do comando_sql
		 */	
		private static function montar_texto_sql_comando_sql(array &$comando_sql) : void{
			$comando_sql['comando_sql'] = '';
			if ($comando_sql['tem_union_anterior'] === true) {
				$comando_sql['comando_sql'] .= ' ' . $comando_sql['union_anterior'] . ' ' ;
			}
			$comando_sql['comando_sql'] .= ' select ' ;
			$comando_sql['comando_sql'] .= ' ' . implode(',',$comando_sql['select']);
			$comando_sql['comando_sql'] .= ' from ';
			$comando_sql['comando_sql'] .= ' ' . implode(' ',$comando_sql['tabelas']);
			if (count($comando_sql['condicionante']) > 0) {
				$comando_sql['comando_sql'] .= ' where ';		
				$comando_sql['comando_sql'] .= implode(' and ',$comando_sql['condicionante']);
			}
			if ((isset($comando_sql['tem_group']) && $comando_sql['tem_group'] === true) && count($comando_sql['group']) > 0) {
				$comando_sql['comando_sql'] .= ' group by ';		
				$comando_sql['comando_sql'] .= implode(',',$comando_sql['group']);
			}
		}

		/**
		 * Monta o texto sql de um registro de bloco select de uma ligtabelasis
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {array} &$bloco_select - o array de bloco_select
		 * @param {boolean} $primeira_ligtabelasis=true - se é a primeira do bloco
		 */		
		private static function montar_texto_sql_bloco_select(array &$params, array &$ligtabelasis, array &$bloco_select) : void {
			$tem_agrupamento_ligtabeladb = false;
			foreach($bloco_select['ligstabela'] as $chave_ligtabela => &$ligtabela) {
				if (isset($ligtabela['codligtabeladb'])) {
					if ($tem_agrupamento_ligtabeladb === false && $ligtabela['temagrupamento'] == 1) {
						$tem_agrupamento_ligtabeladb = true;
					}
					$bloco_select['comando_sql']['tabelas'][$chave_ligtabela] = self::montar_texto_sql_tabeladb($params, $bloco_select, $ligtabela);
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair('ligtabela invalida: ' . $chave_ligtabela, __FILE__,__FUNCTION__,__LINE__);
				}
			}	
			foreach($bloco_select['ligscampo'] as $chave_ligcampo => &$ligcampo) {
				if (isset($ligcampo['codligcampodb'])) {
					self::montar_texto_sql_ligcampodb($params,$ligtabelasis, $bloco_select,$ligcampo);
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair('ligcampo invalida: ' . $chave_ligcampo, __FILE__,__FUNCTION__,__LINE__);
				}
			}
			ksort($bloco_select['comando_sql']['select'], SORT_NUMERIC);
			ksort($bloco_select['comando_sql']['group'], SORT_NUMERIC);
			ksort($bloco_select['comando_sql']['condicionante'], SORT_NUMERIC);
			if ($tem_agrupamento_ligtabeladb === true) {
				$bloco_select['comando_sql']['tem_group'] = $tem_agrupamento_ligtabeladb;
			}
			self::montar_texto_sql_comando_sql($bloco_select['comando_sql']);
		}

		/**
		 * Monta o texto sql de um registro de bloco select de uma ligtabelasis
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {boolean} $primeira_ligtabelasis=true - se é a primeira do bloco
		 */
		private static function montar_textos_sql_subelementos_ligtabelasis(array &$params, array &$ligtabelasis) : void {
			if (isset($ligtabelasis['blocos_select']) && $ligtabelasis['blocos_select'] !== null) {
				foreach($ligtabelasis['blocos_select'] as $chave_bloco_select => &$bloco_select) {		
					self::montar_texto_sql_bloco_select($params,$ligtabelasis,$bloco_select);
				}
			}
		}

		/**
		 * Monta o texto sql de um registro de ligtabelasis 
		 * @param {array} &$params - o array de params
		 * @param {array} &$bloco_select - o array do registro do bloco select continente
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {boolean} $primeira_ligtabelasis=true - se é a primeira do bloco
		 */
		private static function montar_texto_sql_ligtabelasis(array &$params,array &$bloco_select, array &$ligtabelasis,?bool $primeira_ligtabelasis = true) : void{	
			if (!isset($ligtabelasis['duplicado']) || $ligtabelasis['duplicado'] === false) {		
				$ligtabelasis['texto_sql'] = $ligtabelasis['alias'];
				if (isset($ligtabelasis['ligsrelacionamento']) && count($ligtabelasis['ligsrelacionamento']) > 0) {	
					if (count($ligtabelasis['ligsrelacionamento']) > 1) {
					}			
					$esta_em_loop = false;			
					foreach($ligtabelasis['ligsrelacionamento'] as $chave_ligrelacionamento => &$ligrelacionamento) {	
						if ($ligrelacionamento['duplicado'] === false) {
							if (stripos($params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'],'union') !== false) {
								$ligtabelasis['tem_union_anterior'] = true;
								$ligtabelasis['union_anterior'] = $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'];
							} else {
								if ($esta_em_loop === false) {
									$ligtabelasis['texto_sql'] = $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['tipojuncao'] . ' ' . $ligtabelasis['texto_sql'];
									$ligtabelasis['texto_sql'] .= ' on ( ';
									$ligtabelasis['texto_sql'] .= $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['criterios'];				
									$ligtabelasis['texto_sql'] .= ' ) ';
								} else {
									/*significa que tem duas juncoes para a mesma tabela2, acumular as condicionantes para juncao na mesma tabela2*/
									$ligtabelasis['texto_sql'] = substr($ligtabelasis['texto_sql'],0,strrpos($ligtabelasis['texto_sql'],')'));
									$ligtabelasis['texto_sql'] .= ' and ' . $params['conjuntos_dados']['relacionamento'][trim((string)$ligrelacionamento['codrelacionamento'])]['criterios'] . ') ';
								}				
								$ligtabelasis['texto_sql'] = str_ireplace('__ALIASTABELA2__',$ligtabelasis['alias'],$ligtabelasis['texto_sql']);
								if (stripos($ligtabelasis['texto_sql'],'__ALIASTABELA1__') !== false) {
									if (isset($ligrelacionamento['tipoligtabela1'])) {
										if (strcasecmp(trim($ligrelacionamento['tipoligtabela1']),'sis') == 0) {
											if (isset($params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])])) {										
												if (
													isset($params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['gerarconfintervdata']) 
													&& $params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['gerarconfintervdata'] == 1
												){
													$chave_codtabelasis = $params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['codtabelasis'];
													$chave_tabsis_periodo = $chave_codtabelasis . '_' . $bloco_select['periodo'];
													if (isset($params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['ligstabelasis'][$chave_tabsis_periodo])) {
														$ligtabelasis['texto_sql'] = str_ireplace('__ALIASTABELA1__',$params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['ligstabelasis'][$chave_tabsis_periodo]['alias'],$ligtabelasis['texto_sql']);
													} else {
														if (isset($params['ligstabelasis_unicas'][$chave_codtabelasis])) {
															if (isset($params['ligstabelasis_unicas'][$chave_codtabelasis]['gerarconfintervdata']) && $params['ligstabelasis_unicas'][$chave_codtabelasis]['gerarconfintervdata'] == 1) {														
																$ligtabelasis['texto_sql'] = str_ireplace('__ALIASTABELA1__',$params['ligstabelasis_unicas'][$chave_codtabelasis]['ligstabelasis'][$chave_tabsis_periodo]['alias'],$ligtabelasis['texto_sql']);
															} else {
																FuncoesBasicasRetorno::mostrar_msg_sair('implementar', __FILE__,__FUNCTION__,__LINE__);
															}													
														} else {
															FuncoesBasicasRetorno::mostrar_msg_sair('ligtabelasis_unica nao existe no conjunto de dados: ' . $chave_tabsis_periodo, __FILE__,__FUNCTION__,__LINE__);
														}
													}
												} else {
													$ligtabelasis['texto_sql'] = str_ireplace(
														'__ALIASTABELA1__',
														$params['conjuntos_dados']['ligstabelasis'][trim((string)$ligrelacionamento['codligtabela1'])]['alias'],
														$ligtabelasis['texto_sql']
												);
												}
											} else {
												FuncoesBasicasRetorno::mostrar_msg_sair('ligtabelasis1 nao existe no conjunto de dados: ' . $ligrelacionamento['codligtabela1'], __FILE__,__FUNCTION__,__LINE__);
											}
										} else {
											FuncoesBasicasRetorno::mostrar_msg_sair('implementar', __FILE__,__FUNCTION__,__LINE__);
										}
									} else {
										FuncoesBasicasRetorno::mostrar_msg_sair('implementar', __FILE__,__FUNCTION__,__LINE__);
									}
								}
								$esta_em_loop = true;
							}
						}
					}
				} 
			}
		}

		/**
		 * Monta o texto sql de um registro de ligcamposis 
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {array} &$ligcamposis - o array do registro de ligcamposis do banco de dados (associativo)
		 * @param {boolean} $processar_agrupamento=true - se é para ja incluir as funcoes de agrupamento se houverem
		 * @param {boolean} $processar_transformacoes=true - se é para ja incluir as transformacoes se houverem
		 * @param {string} $alias_tabela_sis=null - se vier preenchido, usara este alias ao inves do contido no registro de ligtabelasis
		 * @return {array} - o array com os dados montados
		 */
		private static function montar_texto_sql_ligcamposis(array &$params, array &$ligtabelasis, array &$ligcamposis,?bool $processar_agrupamento = true,?bool $processar_transformacoes = true, ?string $alias_tabela_sis = null) : array{
			$retorno = [
				'texto_campo_original' => null,
				'texto_campo_transformado' => null,
				'texto_campo_agrupamento' => null,
				'texto_campo_final' => null,
				'texto_campo_final_com_alias' => null,
				'texto_campo_condicionante' => null,
				'texto_campo_group' => null,
				'tem_group' => false
			];
			if (!isset($ligcamposis['duplicado']) || $ligcamposis['duplicado'] === false) {
				$retorno['texto_campo_original'] = '';
				if ($alias_tabela_sis === null) {
					$alias_tabela_sis = $ligtabelasis['alias'];
				}
				if (isset($alias_tabela_sis) && strlen(trim($alias_tabela_sis)) > 0) {
					$retorno['texto_campo_original'] .= $alias_tabela_sis . '.';
				}
				$retorno['texto_campo_original'] .= $ligcamposis['alias'];
				$retorno['texto_campo_final'] = $retorno['texto_campo_original'];
				if (!isset($ligcamposis['transformacoes'])) {
					$ligcamposis['transformacoes'] = '';
				}
				if (strlen(trim($ligcamposis['transformacoes'])) > 0 && $processar_transformacoes === true) {
					$retorno['texto_campo_transformado'] = $ligcamposis['transformacoes'];
					$retorno['texto_campo_transformado'] = str_ireplace('__TABELA__.__CAMPO__', $retorno['texto_campo_final'],$retorno['texto_campo_transformado']);			
					$retorno['texto_campo_transformado'] = str_ireplace('__TABELA__', $alias_tabela_sis,$retorno['texto_campo_transformado']);
					$retorno['texto_campo_transformado'] = str_ireplace('__CAMPO__', $retorno['texto_campo_final'], $retorno['texto_campo_transformado']);
					$retorno['texto_campo_final'] = $retorno['texto_campo_transformado'];
				}
				if (!isset($ligcamposis['agrupamento'])) {
					$ligcamposis['agrupamento'] = '';
				}
				$retorno['texto_campo_final_com_alias'] = $retorno['texto_campo_final'] . ' as ' . $ligcamposis['alias'];
				switch(strtolower(trim($ligcamposis['criterio_uso']))) {
					case 'usar sempre':
					case 'campo avulso':
					case 'campo de ligacao':
					case 'herdado usar sempre':
					case 'herdado campo avulso':
					case 'herdado campo de ligacao':
						if ($processar_agrupamento === true) {					
							if (strlen(trim($ligcamposis['agrupamento'])) > 0) {
								$retorno['texto_campo_agrupamento'] = $ligcamposis['agrupamento'];
								$retorno['texto_campo_agrupamento'] = str_ireplace('__TABELA__.__CAMPO__',$retorno['texto_campo_final'],$retorno['texto_campo_agrupamento']);
								$retorno['texto_campo_agrupamento'] = str_ireplace('__CAMPO__',$retorno['texto_campo_final'],$retorno['texto_campo_agrupamento']);									
								$retorno['texto_campo_final'] = $retorno['texto_campo_agrupamento'];
								$retorno['texto_campo_final_com_alias'] = $retorno['texto_campo_final'] . ' as ' . $ligcamposis['alias'];
								$retorno['tem_group'] = true;
							} else {
								$retorno['texto_campo_group'] = str_ireplace('distinct','',$retorno['texto_campo_final']);
							}					
						} else {
							if (strlen(trim($ligcamposis['agrupamento'])) > 0) {
								$retorno['tem_group'] = true;
							} else {
								$retorno['texto_campo_group'] = str_ireplace('distinct','',$retorno['texto_campo_final']);
							}
						}
						break;
					case 'condicionante':
					case 'herdado condicionante':
						if (strlen(trim($ligcamposis['agrupamento'])) > 0) {
							FuncoesBasicasRetorno::mostrar_msg_sair('ligacao campo condicionante nao pode ter agrupamento.  CODLIGCAMPOSIS: ' . $ligcamposis['codligcamposis'] . ',' . $ligcamposis['agrupamento'],__FILE__,__FUNCTION__,__LINE__);
						}
						if (strlen(trim($ligcamposis['especificacao_criterio'])) > 0) {
							$retorno['texto_campo_condicionante'] = $ligcamposis['especificacao_criterio'];
							$retorno['texto_campo_condicionante'] = str_ireplace('__TABELA__.__CAMPO__',$retorno['texto_campo_final'],$retorno['texto_campo_condicionante']);
							$retorno['texto_campo_condicionante'] = str_ireplace('__TABELA__',$alias_tabela_sis,$retorno['texto_campo_condicionante']);
							$retorno['texto_campo_condicionante'] = str_ireplace('__CAMPO__',$retorno['texto_campo_final'],$retorno['texto_campo_condicionante']);
							$retorno['texto_campo_condicionante'] = str_ireplace(' ENTRE ', ' BETWEEN ' ,$retorno['texto_campo_condicionante']);
							$retorno['texto_campo_condicionante'] = str_ireplace(' E ', ' AND ' ,$retorno['texto_campo_condicionante']);
						}			
						break;
					default:
						FuncoesBasicasRetorno::mostrar_msg_sair('criteio de uso do ligcamposis ' . $ligcamposis['codligcamposis'] . ' nao esperado: ' . $ligcamposis['criterio_uso'],__FILE__,__FUNCTION__,__LINE__);
						break;
				}
			}
			return $retorno;
		}

		/**
		 * Monta o texto sql de um registro de ligcamposis como subregistro de uma ligtabelasis
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @param {array} &$ligcamposis - o array do registro de ligcamposis do banco de dados (associativo)
		 * @param {boolean} $processar_agrupamento=true - se é para ja incluir as funcoes de agrupamento se houverem
		 * @param {boolean} $processar_transformacoes=true - se é para ja incluir as transformacoes se houverem
		 * @param {string} $alias_tabela_sis=null - se vier preenchido, usara este alias ao inves do contido no registro de ligtabelasis
		 */
		private static function montar_texto_sql_ligcamposis_em_ligtabelasis(array &$params, array &$ligtabelasis, array &$ligcamposis,?bool $processar_agrupamento = true,?bool $processar_transformacoes = true,?string $alias_tabela_sis = null) : void{
			$array_textos_camposis = self::montar_texto_sql_ligcamposis($params,$ligtabelasis,$ligcamposis,$processar_agrupamento, $processar_transformacoes, $alias_tabela_sis);
			foreach($array_textos_camposis as $chave => $valor) {
				$ligcamposis[$chave] = $valor;
			}
			if ($ligcamposis['tem_group'] === true) {
				$ligtabelasis['comando_sql']['tem_group'] = $ligcamposis['tem_group'];
			} else {
				if (!isset($ligtabelasis['comando_sql']['group'][$ligcamposis['ordem']])) {			
					$ligtabelasis['comando_sql']['group'][$ligcamposis['ordem']] = $ligcamposis['texto_campo_group'];
				} 
			}
		}

		/**
		 * Monta o texto sql da uniao dos withs anteriores formando uma resultante intermediaria, onde serao 
		 * aplicados as operacoes de agregacao se houverem
		 * @param {array} &$params - o array de params
		 */
		private static function montar_texto_sql_resultante_intermediaria(array &$params) : void {
			$aliases_campossis_valores = [];
			foreach($params['resultante_intermediaria']['blocos_select'] as $chave_bloco_select => &$bloco_select) {
				/*cada bloco select eh um periodo*/
				$bloco_select['comando_sql']['conjunto_aliases'] = [];
				$incluidos_campossis_anteriores = false;
				$incluido_campossis_valores_periodos_anteriores = false;
				$primeira_ligtabelasis = true;
				foreach($bloco_select['ligstabela'] as $chave_ligtabela => &$ligtabela) {	
					if (isset($ligtabela) && $ligtabela !== null && gettype($ligtabela) === 'array' && count($ligtabela) > 0) {
						$incluir_campos = true;			
						if (strcasecmp(trim($params['processos'][$ligtabela['codprocesso']]['processo']['tipo']),'condicionante') == 0) {
							$incluir_campos = false;
						}
						if (isset($ligtabela['codligtabelasis']) && strlen(trim($ligtabela['codligtabelasis'])) > 0) {
							self::montar_texto_sql_ligtabelasis($params,$bloco_select, $ligtabela,$primeira_ligtabelasis);
							if (isset($ligtabela['criterio_uso']) && strcasecmp(trim($ligtabela['criterio_uso']),'acessorio') != 0) {
								if (trim((string)$ligtabela['codtabelasis']) === '9000000') {
									array_unshift($bloco_select['comando_sql']['tabelas'],$ligtabela['texto_sql']);
								} else {
									$bloco_select['comando_sql']['tabelas'][$chave_ligtabela] = $ligtabela['texto_sql'];
								}
							}
							foreach($ligtabela['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {						
								if (isset($ligcamposis['codligcamposis']) && strlen(trim($ligcamposis['codligcamposis'])) > 0) {
									if (in_array(strtolower(trim($ligcamposis['criterio_uso'])),['usar sempre','campo avulso'])) {
										$eh_campo_valor = false;
										if (in_array(trim((string)$ligcamposis['codcamposis']),$params['cods_campos_sis_valores_visiveis'])) {
											$eh_campo_valor = true;
										}
										if (!isset($bloco_select['comando_sql']['select'][trim((string)$chave_ligcamposis)])) {																	
											/*acrescenta os camposis nulos no caso de periodos anteriores a este para valores*/
											if ((int)$chave_bloco_select > 0 && $incluidos_campossis_anteriores === false) {
												if ($eh_campo_valor === true) {
													if (count($aliases_campossis_valores) > 0) {
														for($i = 0; $i < (int)$chave_bloco_select; $i++) {
															for ($j = 0; $j < count($aliases_campossis_valores); $j++) {
																$alias_temp = $aliases_campossis_valores[array_keys($aliases_campossis_valores)[$j]] . '_' . $i;
																$bloco_select['comando_sql']['select'][] = 'null as ' . $alias_temp;
															}
														}
														$incluidos_campossis_anteriores = true;
													}
												}
											}
											self::montar_texto_sql_ligcamposis_em_ligtabelasis($params,$ligtabela,$ligcamposis,false,true);
											if ($incluir_campos === true || $eh_campo_valor) {
												if (!$eh_campo_valor) {								
													$alias_temp = trim($ligcamposis['alias']);
													if (in_array($alias_temp,$bloco_select['comando_sql']['conjunto_aliases'])) {
														$incrementador = 0;
														while(in_array($alias_temp,$bloco_select['comando_sql']['conjunto_aliases'])) {
															$alias_temp = trim($ligcamposis['alias']) . '_' . $incrementador;
															$incrementador ++;
														}
													}										
												}
												$bloco_select['comando_sql']['select'][trim((string)$chave_ligcamposis)] = $ligcamposis['texto_campo_final_com_alias'];
												if (!$eh_campo_valor) {
													$bloco_select['comando_sql']['select'][trim((string)$chave_ligcamposis)] = str_ireplace(trim(' as ' . $ligcamposis['alias']),' as ' . $alias_temp,trim($bloco_select['comando_sql']['select'][trim((string)$chave_ligcamposis)]));
													$bloco_select['comando_sql']['conjunto_aliases'][] = $alias_temp;										
												} else {
													$bloco_select['comando_sql']['select'][trim((string)$chave_ligcamposis)] .= '_' . $chave_bloco_select;
													$bloco_select['comando_sql']['conjunto_aliases'][] = trim($ligcamposis['alias']) . '_' . $chave_bloco_select;
												} 
											}
											/*cria o conjunto de aliases valores ao encontralos no primeiro periodo*/
											if ((int)$chave_bloco_select === 0) {
												if ($eh_campo_valor === true) {
													$aliases_campossis_valores[trim((string)$ligcamposis['codcamposis'])] = $ligcamposis['alias'];										
												}
											}
										} else {
											FuncoesBasicasRetorno::mostrar_msg_sair('chave ja existe para o ligcamposis: ' . $chave_ligcamposis, __FILE__,__FUNCTION__,__LINE__);
										}
									} 
								} else {
									FuncoesBasicasRetorno::mostrar_msg_sair('ligcamposis nao tem CODLIGCAMPOSIS: ' . $chave_ligcamposis, __FILE__,__FUNCTION__,__LINE__);
								}
							}
							/*acrescenta os campossis valores nulos para periodos posteriores a este*/
							if (count($aliases_campossis_valores) > 0 && trim((string)$ligtabela['codtabelasis']) === '9000000') {
								if ((int)$chave_bloco_select < count($params['resultante_intermediaria']['blocos_select']) -1) {
									for($i = ((int)$chave_bloco_select) + 1; $i < count($params['resultante_intermediaria']['blocos_select']); $i++) {
										for ($j = 0; $j < count($aliases_campossis_valores); $j++) {
											$bloco_select['comando_sql']['select'][] = 'null as ' . $aliases_campossis_valores[array_keys($aliases_campossis_valores)[$j]] . '_' . $i;
										}
									}
								}
							}
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair('ligtabela nao tem CODLIGTABELASIS: ' . $chave_ligtabela, __FILE__,__FUNCTION__,__LINE__);
						}
						$primeira_ligtabelasis = false;
					}
				}
				self::montar_texto_sql_comando_sql($bloco_select['comando_sql']);
			}
		}

		/**
		 * Monta o texto sql resultante final, que é o ultimo select do comando
		 * @param {array} &$params - o array de params
		 */
		private static function montar_texto_sql_resultante_final(array &$params) : void{
			$aliases_campossis_valores = [];
			$passou_primeiro_bloco_select = false;
			$blocos_select_temp = [];
			self::inicializar_bloco_select($blocos_select_temp,0);
			$bloco_select_agrupado = $blocos_select_temp[0];
			$bloco_select_agrupado['comando_sql']['tabelas'] = ['resultante_intermediaria r'];	
			$bloco_select_agrupado['comando_sql']['conjunto_aliases'] = [];
			foreach($params['resultante_final']['blocos_select'] as $chave_bloco_select => &$bloco_select) {				
				foreach($bloco_select['ligstabela'] as $chave_ligtabela => &$ligtabela) {
					if (isset($ligtabela) && $ligtabela !== null && gettype($ligtabela) === 'array' && count($ligtabela) > 0) {
						$incluir_campos = true;
						if (
							   strcasecmp(trim($params['processos'][$ligtabela['codprocesso']]['processo']['tipo']),'condicionante') == 0 
							|| strcasecmp(trim($params['processos'][$ligtabela['codprocesso']]['processo']['tipo']),'acessorio') == 0 
							|| strcasecmp(trim($params['processos'][$ligtabela['codprocesso']]['processo']['criterio_uso'] ?? ''),'condicionante') == 0 
							|| strcasecmp(trim($params['processos'][$ligtabela['codprocesso']]['processo']['criterio_uso'] ?? ''),'acessorio') == 0 
							|| strcasecmp(trim($ligtabela['tipo']??''),'condicionante') == 0 
							|| strcasecmp(trim($ligtabela['tipo']??''),'acessorio') == 0 
							|| strcasecmp(trim($ligtabela['criterio_uso']??''),'condicionante') == 0 
							|| strcasecmp(trim($ligtabela['criterio_uso']??''),'acessorio') == 0
						) {
							$incluir_campos = false;	
						}
						if (isset($ligtabela['codligtabelasis']) && strlen(trim($ligtabela['codligtabelasis'])) > 0) {
							if ($incluir_campos === true) {
								if (isset($ligtabela['datas_periodo']) && count($ligtabela['datas_periodo']) > 0) {
									$chave_tit = 'De ' . implode(' a ',$ligtabela['datas_periodo']);
									if (!isset($params['arr_tit'][$chave_tit])) {
										$params['arr_tit'][$chave_tit] = [];
									}
								} else {
									$chave_tit = str_replace('"','',$ligtabela['alias']);
									if (!isset($params['arr_tit'][$chave_tit])) {
										$params['arr_tit'][$chave_tit] = [];
									}									
								}
							}
							$alias_tabelasis_temp = $ligtabela['alias'];
							if (isset($ligtabela['temagrupamento']) && $ligtabela['temagrupamento'] == 1) {
								$bloco_select_agrupado['comando_sql']['tem_group'] = true;
							}
							foreach($ligtabela['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
								$eh_campo_valor = false;
								if (in_array(trim((string)$ligcamposis['codcamposis']),$params['cods_campos_sis_valores_visiveis'])) {
									$eh_campo_valor = true;
								}
								$nova_chave_ligcamposis = $chave_ligcamposis;
								if (isset($ligcamposis['codligcamposis']) && strlen(trim($ligcamposis['codligcamposis'])) > 0) {
									if ($passou_primeiro_bloco_select === false || ($passou_primeiro_bloco_select === true && in_array(trim((string)$ligcamposis['codcamposis']),$params['cods_campos_sis_valores_visiveis']))) {							
										if (($ligtabela['tipo'] === 'normal' && in_array(strtolower(trim($ligcamposis['criterio_uso'])),['usar sempre','campo avulso'])) ||
											($ligtabela['tipo'] === 'campo_avulso' && in_array(strtolower(trim($ligcamposis['criterio_uso'])),['campo avulso']))) {
											if (in_array(trim((string)$ligcamposis['codcamposis']),$params['cods_campos_sis_valores_visiveis'])) {
												$nova_chave_ligcamposis .= '_' . $chave_bloco_select;
												$ligcamposis['alias'] = $ligcamposis['alias'].'_'.$chave_bloco_select;
											}
											if (!isset($bloco_select_agrupado['comando_sql']['select'][$nova_chave_ligcamposis])) {																	
												self::montar_texto_sql_ligcamposis_em_ligtabelasis($params,$ligtabela,$ligcamposis,true,false,'r');
												if ($incluir_campos === true || $eh_campo_valor) {
													if (!$eh_campo_valor) {								
														$alias_temp = trim($ligcamposis['alias']);
														if (in_array($alias_temp,$bloco_select_agrupado['comando_sql']['conjunto_aliases'])) {
															$incrementador = 0;
															while(in_array($alias_temp,$bloco_select_agrupado['comando_sql']['conjunto_aliases'])) {
																$alias_temp = trim($ligcamposis['alias']) . '_' . $incrementador;
																$incrementador ++;
															}
														}										
													}

													/*campo que efetivamente fara parte do resultado*/
													$bloco_select_agrupado['comando_sql']['select'][$nova_chave_ligcamposis] = $ligcamposis['texto_campo_final_com_alias'];

													/*inclui no arr_tit que é utilizado para montagem do cabecalho de tabela html*/
													if ($incluir_campos === true && (($ligtabela['tipo'] === 'normal' && in_array(strtolower(trim($ligcamposis['criterio_uso'])),['usar sempre','campo avulso'])) || 
														($ligtabela['tipo'] === 'campo_avulso' && in_array(strtolower(trim($ligcamposis['criterio_uso'])),['campo avulso']))))  {
														if (!isset($params['arr_tit'][$chave_tit][$ligcamposis['alias']])) {
															$params['arr_tit'][$chave_tit][$ligcamposis['alias']] = [
																'texto' => $ligcamposis['alias'],
																'codligcamposis' => $ligcamposis['codligcamposis']
															];																			
														}
													}

													if (!$eh_campo_valor) {
														$bloco_select_agrupado['comando_sql']['select'][$nova_chave_ligcamposis] = str_ireplace(trim(' as ' . $ligcamposis['alias']),' as ' . $alias_temp,trim($bloco_select_agrupado['comando_sql']['select'][$nova_chave_ligcamposis]));
														$bloco_select_agrupado['comando_sql']['conjunto_aliases'][] = $alias_temp;
													} else {
														$bloco_select_agrupado['comando_sql']['conjunto_aliases'][] = trim($ligcamposis['alias']);
													} 
													if (strlen(trim($ligcamposis['agrupamento'])) > 0) {
														$bloco_select_agrupado['comando_sql']['tem_group'] = true;
													} else {
														$bloco_select_agrupado['comando_sql']['group'][$nova_chave_ligcamposis] = $ligcamposis['texto_campo_final'];
													}
												}
											} else {
												FuncoesBasicasRetorno::mostrar_msg_sair('chave ja existe para o ligcamposis: ' . $chave_ligcamposis, __FILE__,__FUNCTION__,__LINE__);
											}
										}
									}
								} else {
									FuncoesBasicasRetorno::mostrar_msg_sair('ligcamposis nao tem CODLIGCAMPOSIS: ' . $chave_ligcamposis, __FILE__,__FUNCTION__,__LINE__);
								}
							}				
						} else {
							FuncoesBasicasRetorno::mostrar_msg_sair('ligtabela nao tem CODLIGTABELASIS: ' . $chave_ligtabela, __FILE__,__FUNCTION__,__LINE__);
						}
					}
				}		
				$passou_primeiro_bloco_select = true;
			}
			self::montar_texto_sql_comando_sql($bloco_select_agrupado['comando_sql']);
			$params['resultante_final']['blocos_select'] = [$bloco_select_agrupado];			
		}

		/**
		 * Monta o texto sql da parte da ordenacao final (order by) do comando principal
		 * @param {array} &$params - o array de params
		 */
		private static function montar_texto_sql_ordenacao_final(array &$params) : void {
			$ordenacao_final = [];
			$qt_campos_acumulados = 0;
			foreach ($params['processos'] as $chave_processo => &$processo) {		
				if ($processo['tipo'] !== 'condicionante') {
					if (isset($processo['processo']['ordenacao']) && strlen(trim($processo['processo']['ordenacao'])) > 0) {
						if (!in_array($processo['processo']['ordenacao'],$ordenacao_final)) {
							$ordenacao_final[] = $processo['processo']['ordenacao'];
						} else {
							/*corrige o indice do campo de ordem do processo no caso de processos multiplos com ordenacoes multiplas*/
							$ordenacao_temp = $processo['processo']['ordenacao'];
							$ordenacao_temp = explode(',',$ordenacao_temp);
							foreach($ordenacao_temp as &$elord) {
								$numord = $elord;
								if (strpos($numord,' ') !== false) {
									$numord = trim(substr($numord,0,strpos($numord,' ')));
									$nova_ord = trim(substr($elord,strpos($elord,' ')));
									if (strlen($numord) > 0) {
										if (is_numeric($numord)) {
											$numord_corrigido = ($numord * 1) + $qt_campos_acumulados;
											$nova_ord = $numord_corrigido . ' ' . $nova_ord;
											$ordenacao_final[] = $nova_ord;
										}
									}
								}
							}
						}
					}	
					$qt_campos_acumulados += $processo['qt_campos_dados'];		
				}
			}
			$params['comando_sql']['ordenacao'] = $ordenacao_final;
		}

		/**
		 * Monta o texto sql de um registro de ligtabelasis
		 * @param {array} &$params - o array de params
		 * @param {array} &$ligtabelasis - o array do registro de ligtabealsis do banco de dados (associativo)
		 * @return {string} o comando sql montado
		 */
		private static function montar_texto_sql_ligtabelasis_select(array &$params, array &$ligtabelasis) : string {
			$retorno = '';
			$retorno .= ' ' . $ligtabelasis['alias'] . ' as ( ' ;
			$textos_blocos_select = [];
			foreach($ligtabelasis['blocos_select'] as $chave_bloco_select => &$bloco_select) {
				$textos_blocos_select []= $bloco_select['comando_sql']['comando_sql'];
			}
			if (count($textos_blocos_select) > 0) {
				if (stripos(trim($textos_blocos_select[0]),'union all') === 0) {
					$textos_blocos_select[0] = substr($textos_blocos_select[0],10);			
				}
			}
			if (isset($ligtabelasis['gerarselectgroup']) && $ligtabelasis['gerarselectgroup'] == 1) {
				$retorno .= 'select ';
				$campossis_select = [];
				$campossis_group = [];
				foreach($ligtabelasis['ligscamposis'] as $chave_ligcamposis => &$ligcamposis) {
					$array_dados_camposis = self::montar_texto_sql_ligcamposis($params,$ligtabelasis,$ligcamposis,true,true,'');
					$campossis_select[] = $array_dados_camposis['texto_campo_final_com_alias'];
					if (isset($array_dados_camposis['texto_campo_group']) && $array_dados_camposis['texto_campo_group'] !== null && strlen(trim($array_dados_camposis['texto_campo_group'])) > 0) {
						$campossis_group[] = $array_dados_camposis['texto_campo_group'];
					}
				}
				$retorno .= implode(',',$campossis_select);
				$retorno .= ' from (';
				$retorno .= implode(' ',$textos_blocos_select);
				$retorno .= ') ';
				$retorno .= ' group by ';
				$retorno .= implode(',',$campossis_group);
			} else {
				$retorno .= implode(' ',$textos_blocos_select);
			}
			$retorno .= ')';
			return $retorno;
		}

		/**
		 * Monta o comando sql com base nos dados obtidos do processo
		 * @param {array} &$params - o array params
		 * @return {string} - o comando sql montado
		 */
		private static function montar_comando_sql(array &$params) : string{
			foreach($params['processos'] as $chave_processo => &$processo) {		
				foreach($processo['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {	
					self::montar_textos_sql_subelementos_ligtabelasis($params, $ligtabelasis);
				}
			}
			if (isset($params['ligstabelasis_unicas']) && $params['ligstabelasis_unicas'] !== null && gettype($params['ligstabelasis_unicas']) === 'array' && count($params['ligstabelasis_unicas']) > 0) {
				foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
					$montou = false;
					if (isset($ligtabelasis['gerarconfintervdata']) && $ligtabelasis['gerarconfintervdata'] == 1 && 
						isset($ligtabelasis['ligstabelasis']) && $ligtabelasis['ligstabelasis'] !== null && gettype($ligtabelasis['ligstabelasis']) === 'array' && count($ligtabelasis['ligstabelasis']) > 0) {
						foreach($ligtabelasis['ligstabelasis'] as $chave_ligtabelasis2 => &$ligtabelasis2) {					
							if (isset($ligtabelasis2) && $ligtabelasis2 !== null && gettype($ligtabelasis2) === 'array' && count($ligtabelasis2) > 0) {						
								self::montar_textos_sql_subelementos_ligtabelasis($params, $ligtabelasis2);
								$montou = true;
							} else {
								unset($ligtabelasis['ligstabelasis'][$chave_ligtabelasis2]);
							}
						}
					} else {
						unset($ligtabelasis['ligstabelasis']);
						self::montar_textos_sql_subelementos_ligtabelasis($params, $ligtabelasis);
						$montou = true;
					}
					if ($montou === false) {
						/*se as checagens de que o ligtabelasis eh valido falharem, pode ser que nao monte, dai tenta aqui novamente*/
						self::montar_textos_sql_subelementos_ligtabelasis($params, $ligtabelasis);
					}
				}
			}
			self::montar_texto_sql_resultante_intermediaria($params);
			self::montar_texto_sql_resultante_final($params);
			$params['comando_sql']['comando_sql'] = 'with ';
			foreach($params['processos'] as $chave_processo => &$processo) {
				foreach($processo['ligstabelasis'] as $chave_ligtabelasis => &$ligtabelasis) {
					$params['comando_sql']['comando_sql'] .= ' ' . $ligtabelasis['alias'] . ' as ( ' ;
					foreach($ligtabelasis['blocos_select'] as $chave_bloco_select => &$bloco_select) {				
						$params['comando_sql']['comando_sql'] .= ' ' . $bloco_select['comando_sql']['comando_sql'] . ' ' ;
					}
					$params['comando_sql']['comando_sql'] .= '),';
				}
			}
			foreach($params['ligstabelasis_unicas'] as $chave_ligtabelasis => &$ligtabelasis) {
				if (isset($ligtabelasis['gerarconfintervdata']) && $ligtabelasis['gerarconfintervdata'] == 1) {
					foreach($ligtabelasis['ligstabelasis'] as $chave_ligtabelasis2 => &$ligtabelasis2) {
						$params['comando_sql']['comando_sql'] .= self::montar_texto_sql_ligtabelasis_select($params,$ligtabelasis2) . ',';
					}
				} else {			
					$params['comando_sql']['comando_sql'] .= self::montar_texto_sql_ligtabelasis_select($params,$ligtabelasis) . ',';
				}
			}
			if (count($params['resultante_intermediaria']['blocos_select']) > 0) {
				$params['comando_sql']['comando_sql'] .= ' ' . 'resultante_intermediaria' . ' as ( ' ;
				$comando_sql_resultante_intermediaria = [];
				foreach($params['resultante_intermediaria']['blocos_select'] as $chave_bloco_select => &$bloco_select) {			
					$comando_sql_resultante_intermediaria[] = ' ' . $bloco_select['comando_sql']['comando_sql'] . ' ';			
				}
				$params['comando_sql']['comando_sql'] .= implode(' union all ' , $comando_sql_resultante_intermediaria);
				$params['comando_sql']['comando_sql'] .= '),';
			}
			foreach($params['resultante_final']['blocos_select'] as $chave_bloco_select => &$bloco_select) {
				$params['comando_sql']['comando_sql'] .= ' ' . 'resultante_final' . ' as ( ' ;
				$params['comando_sql']['comando_sql'] .= ' ' . $bloco_select['comando_sql']['comando_sql'] . ' ';
				$params['comando_sql']['comando_sql'] .= ') ';
			}
			$params['comando_sql']['comando_sql'] .= ' select * from resultante_final';
			self::montar_texto_sql_ordenacao_final($params);
			if (count($params['comando_sql']['ordenacao']) > 0) {
				$params['comando_sql']['comando_sql'] .= ' order by ';
				$params['comando_sql']['comando_sql'] .= implode(',',$params['comando_sql']['ordenacao']);
			}
			return $params['comando_sql']['comando_sql'];
		}

		/**
		 * principal funcao da classe, chamada por processos externos para montar uma sql conforme 
		 * regras do sistema definidas em processos, ligacoes tabelas sis, campos sis, tabela db,campos db
		 * e relacionamentos armazenados.
		 * @param {TComHttp} &$comhttp - o objeto padrao de comunicação cliente-servidor
		 * @return {string} - o comando sql montado
		 */
		public static function montar_sql_processo_estruturado(TComHttp &$comhttp) : string {
			$comando_sql = '';
			$params = [];
			$params['comhttp'] = &$comhttp;
			$params['processos'] = &$params['comhttp']->requisicao->requisitar->qual->objeto;
			$params['processos'] = explode(',', $params['processos']);
			$params['arr_tit'] = [];
			$params['resultantes'] = [];
			$params['comando_sql'] = [
				'tem_resultante_periodos' => false,
				'comando_sql' => ''
			];
			$periodos = [];

			/*separa as datas em pediodos de duas datas (dtini, dtfim)*/
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes['datas'])) {
				if (gettype($comhttp->requisicao->requisitar->qual->condicionantes['datas']) !== 'array') {
					if (strlen(trim(str_replace(' ','',$comhttp->requisicao->requisitar->qual->condicionantes['datas']))) > 0) {
						$comhttp->requisicao->requisitar->qual->condicionantes['datas'] = explode(',',$comhttp->requisicao->requisitar->qual->condicionantes['datas']);
					} else {
						$comhttp->requisicao->requisitar->qual->condicionantes['datas'] = [];
					}
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes['datas'])) {
				if (count($comhttp->requisicao->requisitar->qual->condicionantes['datas']) > 0) {		
					$contador_periodos = 0;
					foreach($comhttp->requisicao->requisitar->qual->condicionantes['datas'] as $chave_data => &$data) {
						if (!isset($periodos[$contador_periodos])) {
							$periodos[$contador_periodos] = [$data];
						} else {			
							$periodos[$contador_periodos][] = $data;
							$contador_periodos ++;
						}
					}
				}
			}
			$params['periodos'] = $periodos;

			/*mostrar vals de geralmente é utilizado no sisjd para mostrar peso e/ou valor e/ou qtd, etc.*/
			if (!isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'])) {
				$params['comhttp']->requisicao->requisitar->qual->condicionantes['mostrar_vals_de'] = [];
			}
			if (!isset($params['comhttp']->requisicao->requisitar->qual->condicionantes['considerar_vals_de'])) {
				$params['comhttp']->requisicao->requisitar->qual->condicionantes['considerar_vals_de'] = [];
			}

			/*obtem o processo estruturado com base nos parametros e obtem as ligacoes e dados de campos e tabelas utilizados no processo*/
			self::obter_processo_estruturado($params); 

			/*monta efetivamente o comando sql do processo*/
			self::montar_comando_sql($params);

			$comando_sql = $params['comando_sql']['comando_sql'];
			$comhttp->requisicao->requisitar->qual->condicionantes['arr_tit'] = $params['arr_tit'];
			$comhttp->requisicao->sql->comando_sql = $comando_sql;
			$comhttp->requisicao->requisitar->qual->condicionantes['processo_estruturado'] = &$params;

			return $comando_sql;
		}
	}
?>