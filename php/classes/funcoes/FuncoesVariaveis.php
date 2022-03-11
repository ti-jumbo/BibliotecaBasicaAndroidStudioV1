<?php
	namespace SJD\php\classes\funcoes;
	include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
		ClasseBase,
		constantes\Constantes,
		constantes\NomesCaminhosDiretorios,
		constantes\NomesCaminhosRelativos,
		constantes\NomesCaminhosArquivos,			
		variaveis\VariaveisSql,
		sql\TSql,
		funcoes\requisicao\FuncoesBasicasRetorno,
		funcoes\FuncoesData,
		funcoes\FuncoesHtml,
		funcoes\requisicao\TComHttp,
		funcoes\FuncoesConversao
	};
	
	/*codigo*/
	class FuncoesVariaveis extends ClasseBase{

		public static function como_texto_ou_funcao($params){//$texto,$posinibusca = 0, $ignorar_crit_exist = true){
			try {
				$retorno = $params;
				$params = $params ?? [];
				if (in_array(gettype($params),['string','char'])) {
					$params = ['texto'=>trim($params)];
				} 
				
				if (gettype($params) === 'array' && count($params) > 0) {
					if (isset($params['texto'])) {
						$params['posinibusca'] = $params['posinibusca'] ?? 0;
						$params['ignorar_crit_exist'] = $params['ignorar_crit_exist'] ?? true;
						$params['funcoes_considerar'] = $params['funcoes_considerar'] ?? [];
						$retorno = $params['texto'];
						$pinifnv = stripos($params['texto'],'__fnv', $params['posinibusca']);		
						if ($pinifnv !== false) {
							//echo $params['texto']; //exit();
							$pfimfnv = strpos($params['texto'],'__',$pinifnv + 1);
							if ($pfimfnv !== false) {
								$texto_execussao = 'return ';
								$nomefunc = trim(substr($params['texto'],$pinifnv,$pfimfnv + 2 - $pinifnv));					
								//echo $nomefunc; exit();
								if (strlen($nomefunc) > 0) {
									if ((
											count($params['funcoes_considerar']) > 0 && in_array($nomefunc,$params['funcoes_considerar'])
										) || count($params['funcoes_considerar']) === 0
									) {
										//echo 'ok1'; //exit();
										if (strtoupper(trim(str_replace(' ','',$nomefunc))) === '__FNV_RETORNAR_CONFORME_CRITERIO_EXISTENCIA__' && $params['ignorar_crit_exist'] === true) { 
											$params['posinibusca'] = $pfimfnv;
											$retorno = self::como_texto_ou_funcao($params);
										} else {							
											$valor_execussao = null;
											if (method_exists(self::getInstancia()->getInstanciaSis(),$nomefunc)) {
												//echo 'ok2'; //exit();
												$valor_execussao = self::getInstancia()->getInstanciaSis()::class . "::$nomefunc";
												//echo $valor_execussao; exit();
											} elseif (method_exists(self::getInstancia(),$nomefunc)) {
												$valor_execussao = __CLASS__ . "::$nomefunc";
											}
											
											if ($valor_execussao !== null) {
												$valor_substituir = $nomefunc;
												$piniparam = $pfimfnv+2;
												$iniparam = trim(substr($params['texto'],$piniparam,1));
												if ($iniparam === '(') {
													$qt_carac = strlen($params['texto']) ;
													$qt_parenteses = 0;
													$pfimparam = strlen($params['texto']) ;
													for ($i = ($pfimfnv + 2); $i < $qt_carac ; $i++) {
														if ($params['texto'][$i] === '(') {
															$qt_parenteses++;
														}
														if ($params['texto'][$i] === ')') {
															$qt_parenteses--;
														}
														if ($qt_parenteses <= 0) {
															$pfimparam = $i;
															break;
														}
													}
													if ($pfimparam !== false) {
														$param = substr($params['texto'],$piniparam,($pfimparam + 1 - $piniparam));
														$valor_execussao .= $param ;
														$valor_substituir .= $param;
													} else {
														FuncoesBasicasRetorno::mostrar_msg_sair('texto com funcao variavel nao encerrada: ' . $params['texto'],__FILE__,__FUNCTION__,__LINE__);
													}
													$texto_execussao .= $valor_execussao . ';';
												} else {
													$texto_execussao .= $valor_execussao . '();';
												}
												if (stripos($params['texto'],'__FNV_EVAL') !== false) {
													//$texto_execussao = stripslashes($texto_execussao);
													$texto_execussao = str_replace("\\\\","\\",$texto_execussao);														
												}
												$params['texto'] = str_ireplace($valor_substituir,eval($texto_execussao),$params['texto']);	
												$retorno = self::como_texto_ou_funcao($params);								
											}
										}
									}
								}
							}
						}
					} else {
						print_r($params);
						exit();
					}
				} 
				return $retorno;
			} catch(\Error | \Throwable | \Exception $e) {
				echo $texto_execussao ?? null;
				print_r($e); exit();
				return null;
			}
		}	
		public static function como_texto_ou_constante($texto) {
			$retorno = null;
			$texto = trim($texto);
			$retorno = $texto;
			while(strpos($retorno,'__') !== false) {
				$texto === $retorno;
				$nomeconstante = substr($retorno,strpos($retorno,'__'),strpos($retorno,'__',strpos($retorno,'__')+1) - strpos($retorno,'__') + 2);
				//echo $texto . ' ' . $nomeconstante; exit();
				if (defined($nomeconstante)) {
					$retorno = str_ireplace($nomeconstante,constant($nomeconstante),$retorno);
					//echo $retorno; exit();
				} elseif (defined(Constantes::class . '::' . $nomeconstante)) {				
					$retorno = str_ireplace($nomeconstante,constant(Constantes::class. '::' . $nomeconstante),$retorno);
				} elseif (defined(Constantes::getInstancia()->getInstanciaSis()::class . '::' . $nomeconstante)) {				
					$retorno = str_ireplace($nomeconstante,constant(Constantes::getInstancia()->getInstanciaSis()::class. '::' . $nomeconstante),$retorno);
				} elseif (defined(NomesCaminhosRelativos::class . '::' . $nomeconstante)) {				
					$retorno = str_ireplace($nomeconstante,constant(NomesCaminhosRelativos::class. '::' . $nomeconstante),$retorno);
				} elseif (defined(NomesCaminhosRelativos::getInstancia()->getInstanciaSis()::class . '::' . $nomeconstante)) {				
					$retorno = str_ireplace($nomeconstante,constant(NomesCaminhosRelativos::getInstancia()->getInstanciaSis()::class. '::' . $nomeconstante),$retorno);				
				} elseif (strcasecmp($nomeconstante,'__codusur__') === 0) {
					$retorno = str_ireplace($nomeconstante,$GLOBALS['_SESSION']['codusur'],$retorno);
				} 
				if ($retorno === $texto) {
					break; //nao encontrou a constante, sai para evitar o loop infinito
				}
			} 
			return $retorno;
		}		
		
		
		public static function __FNV_MONTAR_ABAS__($opcoes = []){			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_navs($opcoes));
		}
		
		public static function __FNV_MONTAR_ESTRUTURA_MASTER_DETAIL_PADRAO__($opcoes = []){			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_estrutura_master_detail($opcoes));
		}
		
		public static function __FNV_MONTAR_NAVBAR__(&$comhttp = null) {
			try {
				//echo 'ok1'; exit();
				$texto_opcoes = '';
				$_SERVER['arquivo_chamador'] = __FILE__;
				if ($comhttp !== null) {
				} else {
					$vars = get_defined_vars();
					if (isset($vars['comhttp'])) {
						$comhttp = $vars['comhttp'];
					} else {
						if (isset($GLOBALS['comhttp'])) {
							$comhttp = $GLOBALS['comhttp'];
						}
					}
				}			
					
				$opcoes_sistema = FuncoesSisJD::obter_opcao_sistema($comhttp);	
				
				$tipo_el_lista = FuncoesHtml::obter_tipo_elemento_html('ul');
				$fechamento_html_ul = '';
				$texto_opcoes = '';
				$form = FuncoesHtml::criar_elemento([
					'tag'=>'form',
					'id'=>'form_pesquisa_opcoes',
					'class'=>'d-flex',
					'onsubmit'=>'return false;',
					'sub'=>[
						[
							'tag'=>'input',
							'class'=>'form-control me-2',
							'type'=>'search',
							'placeholder'=>'Pesquisa...',
							'aria-label'=>'Search',
							'list'=>'lista_opcoes_sistema',
							'aria-label'=>'Pesquisa no site...',
							'onclick'=>'window.fnsisjd.carregar_lista_opcoes_sistema(this);',
							'oninput'=>'window.fnsisjd.acessar_opcao_pesquisada(this);',
							'oque'=>'dados_literais',
							'comando'=>'consultar',
							'tipo_objeto'=>'lista_opcoes_sistema_pesquisa',
							'objeto'=>'lista_opcoes_sistema_pesquisa'
						],[
							'tag'=>'datalist',
							'id'=>'lista_opcoes_sistema',
							'sub'=>[
								[
									'tag'=>'option'
								]
							]
						]
					]
				]);
				$texto_opcoes .= FuncoesHtml::montar_elemento_html($form);
				if (isset($tipo_el_lista) && $tipo_el_lista !== null) {
					switch(strtolower(trim(gettype($tipo_el_lista)))) {
						case 'object':
							$lista = FuncoesHtml::criar_elemento([],$tipo_el_lista->taghtml,'navbar-nav mr-auto ul_navbar_superior');
							break;
						case 'array':
							$lista = FuncoesHtml::criar_elemento([],$tipo_el_lista['taghtml'],'navbar-nav mr-auto ul_navbar_superior');
							break;
						default:
							$lista = FuncoesHtml::criar_elemento([],'ul','navbar-nav me-auto mb-2 mb-lg-0 ul_navbar_superior');
							break;
					}
				}
							
				
				$atalhos_inicio = [];
				if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . 'atalhosinicio')) {										
					$cmdsql = 'select * from ' . VariaveisSql::getInstancia()->getPrefixObjects() . 'atalhosinicio where codusuariosistema = ' . $_SESSION['codusur'];
					$atalhos_inicio = FuncoesSql::getInstancia()->executar_sql($cmdsql,'fetchAll',\PDO::FETCH_ASSOC);
				}								
				$lista['text'] = FuncoesSisJD::montar_lista_opcoes_recursiva($opcoes_sistema,null,$atalhos_inicio);				
				$texto_opcoes .= FuncoesHtml::montar_elemento_html($lista);
				
				return $texto_opcoes;
			} catch(\Error | \Throwable | \Exception $e) {
				FuncoesBasicasRetorno::mostrar_msg_sair($e);
				return null;
			} 
		}		
		public static function __FNV_MONTAR_FUNCS_MANUT_INI__() {
			$retorno = '';
			$table = FuncoesHtml::criar_elemento([
				'tag'=>'table',
				'sub'=>[
					[
						'tag'=>'tbody'
					]
				]
			]);
			$atualizacoes=FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis('catalogo_atualizacoes_db'));
			if (isset($atualizacoes) && $atualizacoes !== null) {
				foreach($atualizacoes as $chave=>$atualizacao){
					if (!in_array($chave,['dados_cat','versao'])) {
						if (property_exists($atualizacao,'tipoorigematualizacao')) {
							if (strcasecmp(trim($atualizacao->tipoorigematualizacao),'file') == 0) {								
								$input = FuncoesHtml::criar_elemento([],'input');
								$input['type'] = 'checkbox';
								$label = FuncoesHtml::criar_elemento([],'label','clicavel');
								if (property_exists($atualizacao,'nomevisivel')) {
									$label['text'] = $atualizacao->nomevisivel;
									$label['textodepois'] = true;
								}
								$label['sub'][] = $input;
								$td = FuncoesHtml::criar_elemento([],'td');
								$td['sub'][] = $label;
								$tr = FuncoesHtml::criar_elemento([],'tr');
								$tr['sub'][] = $td;
								$td = FuncoesHtml::criar_elemento([],'td');
								$img = FuncoesHtml::criar_elemento([],'img','img_spin_check clicavel');
								$img['src'] = NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png';
								$img['data-nomeatualizacao'] = (property_exists($atualizacao,'nomeatualizacao')?$atualizacao->nomeatualizacao:'');
								$img['onclick'] = 'fnsisjd.funcoes_iniciais(this);';
								$td['sub'][] = $img;
								$tr['sub'][] = $td;
								$table['sub'][0]['sub'][] = $tr;								
							}
						}
					}
				}
			}
			$table['sub'][0]['sub'][] = [
				'tag'=>'tr',
				'sub'=>[
					[
						'tag'=>'td',
						'sub'=>[
							[
								'tag'=>'label',
								'class'=>'clicavel',
								'text'=>'Marcar Todos',
								'textodepois'=>true,
								'sub'=>[
									[
										'tag'=>'input',
										'type'=>'checkbox',
										'onchange'=>'marcar_todos_mesmo_fieldset(this);'
									]
								]
							]
						]
					],[
						'tag'=>'td',
						'sub'=>[
							[
								'tag'=>'img',
								'class'=>'img_spin_check clicavel',
								'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
								'data-comando'=>'executar',
								'data-tipo_objeto'=>'selecionados',
								'data-objeto'=>'todos',
								'onclick'=>'window.fnsisjd.funcoes_iniciais(this);'
							]
						]
					]
				]
			];
			$retorno.=FuncoesHtml::montar_elemento_html($table);
			return $retorno;
		}
		public static function __FNV_MONTAR_FUNCS_MANUT_AVANC__() {
			try {
				$retorno = '';
				$table = FuncoesHtml::criar_elemento([
					'tag'=>'table',
					'sub'=>[
						[
							'tag'=>'tbody'
						]
					]
				]);
				if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . 'atualizacoesdb')) {			
					$comando_sql='select * from ' . VariaveisSql::getInstancia()->getPrefixObjects() . "atualizacoesdb where lower(trim(tipoorigematualizacao)) like lower(trim('%table%')) order by 1";
					$atualizacoes=FuncoesSql::getInstancia()->executar_sql($comando_sql,'fetchAll',\PDO::FETCH_ASSOC);								
					foreach($atualizacoes as $atualziacao) {
						$input = FuncoesHtml::criar_elemento([],'input');
						$input['type'] = 'checkbox';
						$label = FuncoesHtml::criar_elemento([],'label','clicavel');
						$label['text'] = self::como_texto_ou_funcao($atualziacao['nomevisivel']);
						$label['textodepois'] = true;
						$label['style'] = 'border:none;';
						$label['sub'][] = $input;
						$td = FuncoesHtml::criar_elemento([],'td');
						$td['sub'][] = $label;
						$tr = FuncoesHtml::criar_elemento([],'tr');
						$tr['sub'][] = $td;
						$td = FuncoesHtml::criar_elemento([],'td');
						$img = FuncoesHtml::criar_elemento([],'img','img_spin_check clicavel');
						$img['src'] = NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png';
						$img['data-nomeatualizacao'] = $atualziacao['nomeatualizacao'];
						$img['onclick'] = 'window.fnsisjd.funcoes_iniciais(this);';
						$td['sub'][] = $img;
						$tr['sub'][] = $td;
						$table['sub'][0]['sub'][] = $tr;
					}
					$table['sub'][0]['sub'][] = [
						'tag'=>'tr',
						'sub'=>[
							[
								'tag'=>'td',
								'sub'=>[
									[
										'tag'=>'label',
										'class'=>'clicavel',
										'text'=>'Marcar Todos',
										'textodepois'=>true,
										'sub'=>[
											[
												'tag'=>'input',
												'type'=>'checkbox',
												'onchange'=>'marcar_todos_mesmo_fieldset(this);'
											]
										]
									]
								]
							],[
								'tag'=>'td',
								'sub'=>[
									[
										'tag'=>'img',
										'class'=>'img_spin_check clicavel',
										'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
										'data-comando'=>'executar',
										'data-tipo_objeto'=>'selecionados',
										'data-objeto'=>'todos',
										'onclick'=>"fnsisjd.funcoes_iniciais(this,'executar','selecionados','todos');"
									]
								]
							]
						]
					];

				}		
				$retorno = FuncoesHtml::montar_elemento_html($table);
				return $retorno;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e); exit();
				return null;
			} 
		}
		public static function __FNV_OPCOES_SISTEMA__() {
			$_SERVER['arquivo_chamador'] = __FILE__;
			$opcoes_sistema = FuncoesSisJD::obter_opcao_sistema($comhttp);
			$tipo_el_lista = FuncoesHtml::obter_tipo_elemento_html('ul');
			$tipo_el_item = FuncoesHtml::obter_tipo_elemento_html('li');	
			$texto_opcoes = FuncoesArray::valor_elemento_array($tipo_el_lista,'aberturahtml') . FuncoesArray::valor_elemento_array($tipo_el_lista,'fechamentoaberturahtml');
			$atalhos_inicio = [];
			if (FuncoesSql::getInstancia()->tabela_existe(VariaveisSql::getInstancia()->getPrefixObjects() . 'atalhosinicio')) {
				$cmdsql = 'select * from ' . VariaveisSql::getInstancia()->getPrefixObjects() . 'atalhosinicio where codusuariosistema = ' . $_SESSION['codusur'];
				$atalhos_inicio = FuncoesSql::getInstancia()->executar_sql($cmdsql,'fetchAll',\PDO::FETCH_ASSOC);
			}
			$texto_opcoes .= FuncoesSisJD::montar_lista_opcoes_recursiva($opcoes_sistema,null,$atalhos_inicio);
			$texto_opcoes .= FuncoesArray::valor_elemento_array($tipo_el_lista,'fechamentohtml');
			return $texto_opcoes;
		}	
		public static function __FNV_DATA_ATUAL__() {
			$retorno = FuncoesData::data_atual();
			return $retorno;
		}
		public static function __FNV_DATA_PRIMEIRO_DIA_MES_ATUAL__() {
			$retorno = FuncoesData::data_primeiro_dia_mes_atual();
			return $retorno;
		}	
		public static function __FNV_MONTAR_COMBOBOX_TABELAS_CATALOGO__() {
			$retorno = '';					
			$tabelas = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis('catalogo_tabelas_campos'), ['preparar_string_antes'=>false]);	
			$texto_combobox = '';
			$opcoes_combobox = FuncoesHtml::opcoes_combobox;
			$opcoes_combobox['tipo'] = 'checkbox';
			$opcoes_combobox['multiplo'] = 1;
			$opcoes_combobox['filtro'] = 1;
			$opcoes_combobox['num_max_texto_botao'] = 1;
			$opcoes_combobox['tem_inputs'] = $opcoes_combobox['tem_inputs'] ?? true;
			$opcoes_combobox['itens'] = [];
			foreach($tabelas as $chave => $tabela) {
				if (!in_array(strtolower(trim($chave)),['dados_cat','versao'])) {
					$opcoes_combobox['itens'][] = [
						'opcoes_texto_opcao'=>$tabela->nometabeladb,
						'opcoes_valor_opcao'=>$tabela->nometabeladb
					];
				}
			}
			$opcoes_combobox['propriedades_html'] = [
				['propriedade'=>'class','valor'=>'d-inline']
			];
			$comhttpnull = null;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));		
			$retorno = $texto_combobox;
			return $retorno;
		}
		public static function __FNV_MONTAR_COMBOBOX_OPCOES_SISTEMA_CATALOGO__() {
			$retorno = '';		
			$opcoes_sistema = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis('catalogo_opcoes_sistema'), ['preparar_string_antes'=>false]);	
			$prefixo_objs = obter_prefixo_objs(VariaveisSql::getInstancia()->getInstanciaSis());
			$texto_combobox = '';
			$opcoes_combobox = FuncoesHtml::opcoes_combobox;
			$opcoes_combobox['tipo'] = 'checkbox';
			$opcoes_combobox['multiplo'] = 1;
			$opcoes_combobox['filtro'] = 1;
			$opcoes_combobox['num_max_texto_botao'] = 1;
			$opcoes_combobox['tem_inputs'] = $opcoes_combobox['tem_inputs'] ?? true;
			$opcoes_combobox['itens'] = [];
			foreach($opcoes_sistema as $opcao_sistema) {
				$opcoes_combobox['itens'][] = [
					'opcoes_texto_opcao' => $opcao_sistema['nomeops'],
					'opcoes_valor_opcao' => $opcao_sistema['nomeops']
				];
			}
			$comhttpnull = null;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));		
			$retorno = $texto_combobox;
			return $retorno;
		}							    
		public static function __FNV_GET_NAMECONNECTIONDEFAULT__() : ?string{
			return VariaveisSql::getInstancia()->getNomeConexaoPadrao();
		}
		public static function __FNV_GET_NAMECONNECTIONERP__() : ?string{
			return VariaveisSql::getInstancia()->getNomeConexaoErp();
		}
		public static function __FNV_OBTER_FUNCAO_SQL__(?string $nome_funcao = null, ?string $nome_driver = null) : ?string{
			return VariaveisSql::getInstancia()->getFuncaoSql($nome_funcao,$nome_driver);
		}
		public static function __FNV_GET_PREFIXOBJECTSDB__(?string $nome_conexao = null) : ?string{
			return VariaveisSql::getInstancia()->getPrefixObjects($nome_conexao);
		}
		public static function __FNV_GET_NOMESCHEMAERP__() : ?string{
			return VariaveisSql::getInstancia()->getNomeSchemaErp();
		}
		public static function __FNV_GET_NOMESCHEMA__(?string $nome_conexao = null) : ?string{
			return VariaveisSql::getInstancia()->getNomeSchema($nome_conexao);
		}

		public static function __FNV_RETORNAR_CONFORME_CRITERIO_EXISTENCIA__($contexto = '', $existencia = true, $valor_existe = '', $valor_nao_existe = ''){
			$retorno = $valor_existe;
			switch(strtolower(trim($contexto))) {
				case 'campo':
					if (isset($existencia)) {
						if ($existencia !== null) {
							if ($existencia == false) {
								$retorno = $valor_nao_existe;
							}
						}
					} 
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("contexto nao experado: $contexto ",__FILE__,__FUNCTION__,__LINE__);
					break;
			}
			return $retorno;		
		}


		public static function __FNV_MONTAR_COMBOBOX_CONTEXEC_SISTEMA_CATALOGO__() {
			$retorno = '';
			$opcoes_sistema = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis('catalogo_opcoes_sistema'), ['preparar_string_antes'=>false]);	
			$prefixo_objs = obter_prefixo_objs(VariaveisSql::getInstancia()->getInstanciaSis());
			$texto_combobox = '';
			$opcoes_combobox = FuncoesHtml::opcoes_combobox;
			$opcoes_combobox['tipo'] = 'checkbox';
			$opcoes_combobox['multiplo'] = 1;
			$opcoes_combobox['filtro'] = 1;
			$opcoes_combobox['num_max_texto_botao'] = 1;
			$opcoes_combobox['tem_inputs'] = $opcoes_combobox['tem_inputs'] ?? true;
			$opcoes_combobox['itens'] = [];
			foreach($opcoes_sistema as $chave=>$opcao_sistema) {
				$opcoes_combobox['itens'][] = [
					'opcoes_texto_opcao' => $chave,
					'opcoes_valor_opcao' => $chave
				];
			}
			$comhttpnull = null;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));		
			$retorno = $texto_combobox;
			return $retorno;
		}
		public static function __FNV_MONTAR_COMBOBOX_ELEMENTOS_SISTEMA_CATALOGO__() {
			$retorno = '';		
			$opcoes_sistema = FuncoesArquivo::ler_arquivo_catalogo_json(NomesCaminhosArquivos::getInstancia()->getPropInstanciaSis('catalogo_elementos_opcoes_sistema'), ['preparar_string_antes'=>false]);	
			$prefixo_objs = obter_prefixo_objs(VariaveisSql::getInstancia()->getInstanciaSis());
			$texto_combobox = '';
			$opcoes_combobox = FuncoesHtml::opcoes_combobox;
			$opcoes_combobox['tipo'] = 'checkbox';
			$opcoes_combobox['multiplo'] = 1;
			$opcoes_combobox['filtro'] = 1;
			$opcoes_combobox['num_max_texto_botao'] = 1;
			$opcoes_combobox['itens'] = [];
			$opcoes_combobox['tem_inputs'] = $opcoes_combobox['tem_inputs'] ?? true;
			foreach($opcoes_sistema as $chave=>$opcao_sistema) {
				$opcoes_combobox['itens'][] = [
					'opcoes_texto_opcao' => $chave,
					'opcoes_valor_opcao' => $chave
				];
			}
			$comhttpnull = null;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes_combobox));		
			$retorno = $texto_combobox;
			return $retorno;
		}				
		public static function __FNV_MONTAR_COMBOBOX__($opcoes=[],$selecionados=[]) {
			$texto_combobox = '';
			if (count($opcoes) === 0) {			
				$opcoes['itens'] = [];
			}
			if (!isset($opcoes['selecionados'])) {			
				$opcoes['selecionados'] = $selecionados;
			} else {
				if (count($opcoes['selecionados']) <= 0) {
					$opcoes['selecionados'] = $selecionados;
				}
			}		
			$comhttpnull = null;
			$opcoes['classe_botao'] = $opcoes['classe_botao'] ?? FuncoesHtml::classe_padrao_botao;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes));		
			return $texto_combobox;
		}
		public static function __FNV_DATA_PRIMEIRO_DIA_MES_ANTERIOR__() {
			$retorno = FuncoesData::data_primeiro_dia_mes_anterior();
			return $retorno;
		}	
		public static function __FNV_DATA_ULTIMO_DIA_MES_ANTERIOR__() {
			$retorno = FuncoesData::data_ultimo_dia_mes_anterior();
			return $retorno;
		}	
		public static function __FNV_ANO_ATUAL__() {
			$retorno = FuncoesData::ano_atual();
			return $retorno;
		}		
		public static function __FNV_DATA_ULTIMO_DIA_MES_ATUAL__() {
			$retorno = FuncoesData::data_ultimo_dia_mes_atual();
			return $retorno;
		}				
		public static function __FNV_MONTAR_TABELA_PADRAO__($processo) {
			$retorno = '';
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->sql = new TSql();
			$comhttp_temp->requisicao->requisitar->qual->objeto = $processo;
			$opcoes = [];
			if (is_numeric($processo)) {
					$processo_temp = FuncoesSql::getInstancia()->obter_processo(['condic'=>"codprocesso=$processo",'unico'=>true]);
					$comhttp_temp->requisicao->requisitar->qual->objeto = $processo_temp['processo'];		
					$opcoes = FuncoesSql::getInstancia()->obter_opcoes_dados_sql(['condic'=>'codprocesso=' . $processo,'unico'=>true]);
					if ($opcoes !== null && isset($opcoes['opcoes'])) {
						eval($opcoes['opcoes']);
					} else {
						$opcoes = FuncoesHtml::opcoes_tabela_est;
					}
					$opcoes['tipoelemento'] = $opcoes['tipoelemento'] ?? 'tabela_est';
					$comhttp_temp->requisicao->requisitar->qual->condicionantes['tipo_retorno'] = $opcoes['tipoelemento'];				
			} else {
				$comhttp_temp->requisicao->requisitar->qual->objeto = $processo;
				$opcoes = FuncoesHtml::opcoes_tabela_est;		
			}
			$comhttp_temp->opcoes_retorno['usar_arr_tit'] = true;
			$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp);
			$comhttp_temp->retorno->dados_retornados['dados'] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,'fetchAll',\PDO::FETCH_ASSOC);
			$comhttp_temp->requisicao->requisitar->qual->condicionantes['opcoes_tabela_est'] = $opcoes;
			if ($opcoes['tipoelemento'] === 'tabela_est') {
				FuncoesHtml::montar_dados_linha_padrao($comhttp_temp,$opcoes);
			}					
			$comhttp_temp->retorno->dados_retornados['conteudo_html'] = FuncoesHtml::montar_tabela_est_html($comhttp_temp,$opcoes,false);		
			$retorno = $comhttp_temp->retorno->dados_retornados['conteudo_html'];
			return $retorno;
		}
		public static function __FNV_MONTAR_COMBOBOX_MESES__($opcoes=[]) {			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox_meses($opcoes));
		}
		public static function __FNV_MONTAR_TABELA_CATALOGOS__($comhttp = null){
			$retorno = '';
			if (!isset($comhttp) || $comhttp === null) {
				$comhttp = new TComHttp();
			}
			$opcoes = FuncoesHtml::opcoes_tabela_est;
			$tipos = ['txt'];
			$dados = [];
			if ( $handle = opendir(NomesCaminhosDiretorios::getInstancia()->getPropInstanciaSis('catalogos')) ) {
				while ( $entry = readdir( $handle ) ) {
					$ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
					if( in_array( $ext, $tipos ) ) $dados[] = $entry;
				}
				closedir($handle);
			}
			$dadostemp = [];
			foreach($dados as $dado) {
				$dadostemp[] = [$dado];
			}
			$dados = $dadostemp;
			$opcoes['cabecalho']['comandos']['ativo'] = true;
			$opcoes['cabecalho']['comandos']['inclusao']['ativo'] = true;
			$opcoes['corpo']['linhas']['comandos']['ativo'] = true;
			$opcoes['corpo']['linhas']['comandos']['edicao']['ativo'] = true;
			$opcoes['corpo']['linhas']['comandos']['exclusao']['ativo'] = true;
			$opcoes['corpo']['linhas']['comandos']['salvar']['aosalvarnovalinha'] = 'criar_arquivo_catalogo(this)';
			$opcoes['corpo']['linhas']['comandos']['salvar']['aosalvaredicaolinha'] = 'renomear_arquivo_catalogo(this)';
			$opcoes['corpo']['linhas']['comandos']['exclusao']['aoexcluirlinha'] = 'deletar_arquivo_catalogo(this)';
			$opcoes['corpo']['linhas']['aoclicar'] = 'carregar_arquivo_catalogo(this)';
			$opcoes['corpo']['linhas']['marcarmultiplo'] = false;
			$opcoes['rodape']['ativo'] = false;
			$opcoes['dados'] = [];
			$opcoes['dados']['tabela'] = [];
			$opcoes['dados']['tabela']['titulo'] = [];
			$opcoes['dados']['tabela']['titulo']['arr_tit'] = [];
			$opcoes['dados']['tabela']['titulo']['arr_tit'][] = ['linha'=>0,'coluna'=>0,'valor'=>'catalogo','cod'=>0,'codsup'=>''];
			$opcoes['dados']['tabela']['dados'] = $dados;
			$comhttp->requisicao->requisitar->qual->condicionantes['opcoes_tabela_est'] = $opcoes;						
			$retorno = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes,true);
			return $retorno;
		}
		public static function __FNV_MONTAR_INPUT_ANO_ATUAL__(){
			$texto_input = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_elemento([
				'tag'=>'input',
				'class'=>'input_ano',
				'type'=>'number',
				'value'=>FuncoesData::ano_atual()
			]));
			return $texto_input;
		}
		public static function __FNV_MONTAR_EDICAO_REGISTRO_UNICO_PADRAO__($processo, $condicionantes_tab = '') {
			$retorno = '';
			$comhttp_temp = new TComHttp();
			$condicionantes_tab = trim($condicionantes_tab);		
			$comhttp_temp->requisicao->sql = new TSql();
			$comhttp_temp->requisicao->requisitar->qual->objeto = $processo;
			if (strlen($condicionantes_tab) > 0) {
				$condicionantes_tab = FuncoesSql::getInstancia()->traduzir_constantes_sql($condicionantes_tab);
				$comhttp_temp->requisicao->requisitar->qual->condicionantes['condicionantestab'] = $condicionantes_tab;
			}
			$opcoes = [];
			if (is_numeric($processo)) {
					$processo_temp = FuncoesSql::getInstancia()->obter_processo(['condic'=>"codprocesso=$processo",'unico'=>true]);
					$comhttp_temp->requisicao->requisitar->qual->objeto = $processo_temp['processo'];		
					$opcoes = FuncoesSql::getInstancia()->obter_opcoes_dados_sql(['condic'=>'codprocesso=' . $processo,'unico'=>true]);
					if ($opcoes !== null && isset($opcoes['opcoes'])) {
						eval($opcoes['opcoes']);
					} else {
						$opcoes = FuncoesHtml::opcoes_tab_reg_uni;
					}
					$opcoes['tipoelemento'] = $opcoes['tipoelemento'] ?? 'tab_reg_uni';
					$comhttp_temp->requisicao->requisitar->qual->condicionantes['tipo_retorno'] = $opcoes['tipoelemento'];				
			} else {
				$comhttp_temp->requisicao->requisitar->qual->objeto = $processo;
				$opcoes = FuncoesHtml::opcoes_tab_reg_uni;		
			}
			$comhttp_temp->opcoes_retorno['usar_arr_tit'] = true;
			$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp);
			$comhttp_temp->retorno->dados_retornados['dados'] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,'fetchAll',\PDO::FETCH_ASSOC);
			$comhttp_temp->requisicao->requisitar->qual->condicionantes['opcoes_tabela_est'] = $opcoes;
			$comhttp_temp->retorno->dados_retornados['conteudo_html'] = FuncoesHtml::montar_tabela_reg_uni($comhttp_temp,$opcoes,false);		
			$retorno = $comhttp_temp->retorno->dados_retornados['conteudo_html'];
			return $retorno;
		}

		public static function __FNV_MONTAR_DIV_RESULTADO_PADRAO__(?array $params = []) : string{			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_div_resultado_padrao($params));
		}			

		public static function __FNV_MONTAR_COMBOBOX_CONDICIONANTE__($params = []) {//$visao='origem de dados',$selecionados=[],$forcar_selecao_por_valores=false,$permite_selecao=true){			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox_condicionante($params));		
		}	

		public static function __FNV_MONTAR_CARD_PADRAO__(?array $params = []) : string {			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_card($params));
		}

		public static function __FNV_MONTAR_OPCOES_PESQUISA_PADRAO__($params = []){			
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_opcoes_pesquisa_padrao($params));
		}

		public static function __FNV_MONTAR_ATALHOS_INICIAIS_SISJD__() {
			$params = [
				FuncoesHtml::criar_row([
					'sub'=>[
						FuncoesHtml::criar_col([
							'class'=>'m-1',
							'sub'=>[
								FuncoesHtml::criar_card([
									'class'=>'mt-2 card_meus_valores',
									'titulo'=>'Meus Valores',
									'elementos_header'=>[
										FuncoesHtml::criar_combobox_meses([
											'style'=>'float:right;',
											'classe_botao'=>'btn-secondary',
											'aoselecionaropcao'=>'window.fnsisjd.selecionou_mes_inicio(this)'
										])
									],
									'sub'=>[
										FuncoesHtml::criar_row([
											'sub'=>[
												FuncoesHtml::criar_col([
													'sub'=>[
														FuncoesHtml::criar_card_valor([
															'titulo'=>'Vendas',
															'unidade'=>'R$',
															'valor'=>FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_spinner())
														])
													]
												]),
												FuncoesHtml::criar_col([
													'sub'=>[
														FuncoesHtml::criar_card_valor([
															'titulo'=>'Peso',
															'unidade'=>'KG',
															'valor'=>FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_spinner())
														])
													]
												]),
												FuncoesHtml::criar_col([
													'sub'=>[
														FuncoesHtml::criar_card_valor([
															'titulo'=>'Positivação',
															'unidade'=>'Cli',
															'valor'=>FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_spinner())
														])
													]
												]),
												FuncoesHtml::criar_col([
													'sub'=>[
														FuncoesHtml::criar_card_valor([
															'titulo'=>'Mix',
															'unidade'=>'Prod',
															'valor'=>FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_spinner())
														])
													]
												])
											]
										])
									]
								])
							]
						])
					]
				]),
				FuncoesHtml::criar_row([
					'sub'=>[
						FuncoesHtml::criar_col([
							'class'=>'m-1',
							'sub'=>[
								FuncoesHtml::criar_card([
									'class'=>'card_mais_recentes',
									'titulo'=>'Mais Recentes',
									'sub'=>[
										FuncoesHtml::criar_spinner()
									]
								])
							]
						])
					]
				]),
				FuncoesHtml::criar_row([
					'sub'=>[
						FuncoesHtml::criar_col([
							'class'=>'m-1',
							'sub'=>[
								FuncoesHtml::criar_card([
									'class'=>'card_mais_acessados',
									'titulo'=>'Mais Acessados',
									'sub'=>[
										FuncoesHtml::criar_spinner()
									]
								])
							]
						])
					]
				])
			];
			return FuncoesHtml::montar_elemento_html($params);
		}

		public static function __FNV_MONTAR_SPINNER__($params = []) {
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_spinner($params));
		}

		public static function __FNV_MONTAR_COMBOBOX_VISOES_SINERGIA__($opcoes=[]) {
			$texto_combobox = '';
			$placeholder = '(Selecione)';		
			if (count($opcoes) === 0) {			
				$opcoes['itens'] = Constantes::getInstancia()::$visoes_sinergia;
			}
			$opcoes['tem_inputs'] = $opcoes['tem_inputs'] ?? true;	
			$opcoes['tipo'] = 'radio';
			$opcoes['multiplo'] = 0;
			$opcoes['selecionar_todos'] = 0;
			$opcoes['filtro'] = 1;
			$opcoes['selecionados'] = [4];
			$opcoes['classe_botao'] = FuncoesHtml::classe_padrao_botao;
			$comhttpnull = null;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes));
			return $texto_combobox;
		}
		
		public static function __FNV_MONTAR_COMBOBOX_RCAS_SINERGIA__($opcoes=[]) {
			$texto_combobox = '';
			$placeholder = '(Selecione)';					
			if (count($opcoes) === 0) {			
				$rcas_sinergia = FuncoesSisJD::rcas_sinergia($_SESSION['usuariosis']);
				$opcoes['itens'] = $rcas_sinergia;
			}
			$opcoes['tem_inputs'] = $opcoes['tem_inputs'] ?? true;	
			$opcoes['tipo'] = 'checkbox';
			$opcoes['multiplo'] = 1;
			$opcoes['selecionar_todos'] = 1;
			$opcoes['filtro'] = 1;
			$opcoes['selecionados'] = ['todos'];
			$comhttpnull = null;
			$opcoes['classe_botao'] = $opcoes['classe_botao'] ?? FuncoesHtml::classe_padrao_botao;
			$texto_combobox = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes));		
			return $texto_combobox;
		}

		public static function __FNV_MONTAR_COMBOBOX_ANOS_SINERGIA__($opcoes = []){
			$html_combobox_anos = '';	
			$opcoes['tem_inputs'] = $opcoes['tem_inputs'] ?? true;			
			$opcoes['itens'] = [2017,2018,2019,2020,2021,2022];
			$opcoes['selecionados'] = [5];
			$opcoes['tipo'] = 'checkbox';
			$opcoes['selecionar_todos'] = 1;
			$opcoes['filtro'] = 1;
			$comhttpnull = null;
			$opcoes['classe_botao'] = $opcoes['classe_botao'] ?? FuncoesHtml::classe_padrao_botao;
			$html_combobox_anos = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($opcoes));
			return $html_combobox_anos;		
		}
		public static function __FNV_MONTAR_DROPDOWN_DETALHAR_EVOLUCAO__($params_drop = []){
			$params_drop = $params_drop ?? [];
			$params_drop['placeholder'] = $params_drop['placeholder'] ?? 'Detalhar por';
			$params_drop['class'] = $params_drop['class'] ?? 'sm';
			$params_drop['propriedades_html'] = $params_drop['propriedades_html'] ?? [];
			$params_drop['propriedades_html'][] = [
				'propriedade'=>'style',
				'valor'=>'display:inline;margin-left:30px'
			];
			$params_drop['tem_inputs'] = false;
			$params_drop['multiplo'] = 0;
			$params_drop['selecionar_todos'] = 0;
			$params_drop['classe_botao'] = $params_drop['classe_botao'] ?? 'btn-secondary btn-sm';
			$params_drop['itens'] = [];
			$params_drop['itens'][] = [
				'opcoes_texto_opcao'=>'Filial',
				'onclick'=>'window.fnsisjd.clicou_detalhar_evolucao({elemento:this})'
			];
			$params_drop['itens'][] = [
				'opcoes_texto_opcao'=>'Supervisor',
				'onclick'=>'window.fnsisjd.clicou_detalhar_evolucao({elemento:this})'
			];
			$params_drop['itens'][] = [
				'opcoes_texto_opcao'=>'Rca',
				'onclick'=>'window.fnsisjd.clicou_detalhar_evolucao({elemento:this})'
			];
			
			$retorno = FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox($params_drop));
			return $retorno;
		}
		public static function __FNV_MONTAR_COMBOBOX_MES_SINERGIA__($opcoes_combobox_mes = []){
			$opcoes_combobox_mes['propriedades_html'] = $opcoes_combobox_mes['propriedades_html'] ?? [];
			$opcoes_combobox_mes['multiplo'] = $opcoes_combobox_mes['multiplo'] ?? false;
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_combobox_meses($opcoes_combobox_mes));
		}

		public static function __FNV_MONTAR_TABELA_GRUPOS_PRODUTOS_EQUIVALENTES__(&$comhttp) {
			$retorno = '';
			$codprocesso = 10250;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(['condic'=>"codprocesso=$codprocesso",'unico'=>true]);			
			$comhttp->requisicao->requisitar->qual->objeto = $processo_temp['processo'];
			$comhttp->opcoes_retorno['usar_arr_tit'] = true;
			$comhttp->requisicao->requisitar->qual->condicionantes['usar_arr_tit'] = true;
			$opcoes = FuncoesHtml::opcoes_tabela_est;
			$opcoes['tabeladb'] = VariaveisSql::getInstancia()->getPrefixObjects() . 'gruposprodequiv';
			$opcoes['cabecalho']['filtro']['ativo'] = true;
			$opcoes['cabecalho']['ordenacao']['ativo'] = true;
			$opcoes['cabecalho']['comandos']['ativo'] = true;
			//$opcoes['cabecalho']['comandos']['inclusao']['ativo'] = true;
			//$opcoes['cabecalho']['comandos']['inclusao']['tipo'] = 'linha';
			$opcoes['cabecalho']['comandos']['classe_botoes'] = 'pequeno';
			$opcoes['cabecalho']['comandos']['classe_imgs'] = 'pequeno';
			//$opcoes['corpo']['linhas']['comandos']['ativo'] = true;
			//$opcoes['corpo']['linhas']['comandos']['edicao']['ativo'] = true;
			//$opcoes['corpo']['linhas']['comandos']['exclusao']['ativo'] = true;
			//$opcoes['corpo']['linhas']['comandos']['salvar']['aosalvarnovalinha'] = 'window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})';
			//$opcoes['corpo']['linhas']['comandos']['salvar']['aosalvaredicaolinha'] = 'window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})';
			//$opcoes['corpo']['linhas']['comandos']['exclusao']['aoexcluirlinha'] = 'window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})';
			$opcoes['corpo']['linhas']['aoclicar'] = 'window.fnsisjd.carregar_dados_grupo_prod_equiv(this)';
			$opcoes['corpo']['linhas']['marcarmultiplo'] = false;
			$opcoes['rodape']['ativo'] = false;
			$comhttp->requisicao->requisitar->qual->condicionantes['opcoes_tabela_est'] = $opcoes;
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);	
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes['arr_tit']); exit();	
			
			FuncoesHtml::montar_retorno_tabdados($comhttp);
		}	
		
		public static function __FNV_EVAL__($eval = 'return false;') {
			//echo 'executando eval: ' . $eval; exit();
			//echo str_replace('\\','\\',$eval); exit();
			return eval($eval);
		}

		public static function __FNV_MONTAR_FUNCS_MANUT_EVENTUAIS__() {
			$retorno = '';
			$params_tab = [
				'tag'=>'table',
				'sub'=>[
					[
						'tag'=>'tbody',
						'sub'=>[
							[
								'tag'=>'tr',
								'sub'=>[
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'label',
												'class'=>'clicavel',
												'text'=>'Gerar Historico Objetivos Sinergia',
												'textodepois'=>true,
												'sub'=>[
													[
														'tag'=>'input',
														'type'=>'checkbox'
													]
												]
											],
											[
												'tag'=>'input',
												'class'=>'componente_data controle_input_texto',
												'type'=>'date',
												'value'=>FuncoesData::dataUSA()
											],
											[
												'tag'=>'input',
												'class'=>'componente_data controle_input_texto',
												'type'=>'date',
												'value'=>FuncoesData::dataUSA()
											]
										]
									],
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'img',
												'class'=>'img_spin_check clicavel',
												'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
												'data-nomeatualizacao'=>'gerar_historico_objetivos_sinergia',
												'onclick'=>'window.fnsisjd.funcoes_eventuais(this);'
											]
										]
									]
								]
							],
							[
								'tag'=>'tr',
								'sub'=>[
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'label',
												'class'=>'clicavel',
												'text'=>'Atualizar dados clientes rfb (tabela clientes_verif_rfb)',
												'textodepois'=>true,
												'sub'=>[
													[
														'tag'=>'input',
														'type'=>'checkbox'
													]
												]
											]
										]
									],
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'img',
												'class'=>'img_spin_check clicavel',
												'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
												'data-nomeatualizacao'=>'atualizar_clientes_rfb',
												'onclick'=>'window.fnsisjd.funcoes_eventuais(this);'
											]
										]
									]
								]
							],
							[
								'tag'=>'tr',
								'sub'=>[
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'label',
												'class'=>'clicavel',
												'text'=>'Processar dados clientes rfb (tabela clientes_verif_rfb -> dados_clientes_rfb)',
												'textodepois'=>true,
												'sub'=>[
													[
														'tag'=>'input',
														'type'=>'checkbox'
													]
												]
											]
										]
									],
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'img',
												'class'=>'img_spin_check clicavel',
												'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
												'data-nomeatualizacao'=>'processar_dados_clientes_rfb',
												'onclick'=>'window.fnsisjd.funcoes_eventuais(this);'
											]
										]
									]
								]
							],
							[
								'tag'=>'tr',
								'sub'=>[
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'label',
												'class'=>'clicavel',
												'text'=>'Importar Devolucoes Aurora',
												'textodepois'=>true,
												'sub'=>[
													[
														'tag'=>'input',
														'type'=>'checkbox'
													]
												]
											]
										]
									],
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'img',
												'class'=>'img_spin_check clicavel',
												'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
												'data-nomeatualizacao'=>'importar_devolucoes_aurora',
												'onclick'=>'window.fnsisjd.funcoes_eventuais(this);'
											]
										]
									]
								]
							],
							[
								'tag'=>'tr',
								'sub'=>[
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'label',
												'class'=>'clicavel',
												'text'=>'Selecionar Todos',
												'onchange'=>'window.fnhtml.marcar_todos_mesmo_fieldset(this);',
												'textodepois'=>true,
												'sub'=>[
													[
														'tag'=>'input',
														'type'=>'checkbox'
													]
												]
											]
										]
									],
									[
										'tag'=>'td',
										'sub'=>[
											[
												'tag'=>'img',
												'class'=>'img_spin_check clicavel',
												'src'=>NomesCaminhosRelativos::sjd . '/images/executaramarelo32x32.png',
												'data-nomeatualizacao'=>'processar_dados_clientes_rfb',
												'onclick'=>'window.fnsisjd.funcoes_eventuais(this);'
											]
										]
									]
								]
							]
						]
					]
				]
			];
			$retorno = FuncoesHtml::montar_elemento_html($params_tab);
			return $retorno;
		}

		public static function __FNV_MONTAR_INPUTGROUP_MES_ANO__($params = []) {
			$params = $params ?? [];
			return FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_inputgroup_mes_ano($params));
		}

		public static function __FNV_OBTER_CLASSE_PADRAO_BOTAO__(){
			return FuncoesHtml::classe_padrao_botao;
		}
	
	}
?>