<?php
	namespace SJD\php\classes\funcoes;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			sql\TSql,
			variaveis\VariaveisSql,
			constantes\Constantes
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesSql,
			FuncoesHtml,
			FuncoesConversao,
			FuncoesArray,
			FuncoesData,			
			requisicao\FuncoesBasicasRetorno,
			requisicao\TComHttp
		};
	use SJD\php\classes\funcoes\{
			FuncoesMontarSQL,
			FuncoesSisJD
		};
	
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesMontarRetorno extends ClasseBase {
		public static function consulta_estruturada_campanhas_estruturadas_objetivos_gerais(&$comhttp,$condicionantestab=null){
			/*Objetivo: montar o sql do sinergia*/
			
			if (gettype($comhttp)!=="object") {
				$codcampestr = $comhttp;
				$comhttp = new TComHttp();
				$comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"] = $codcampestr;
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = $condicionantestab;
			} else {
				$codcampestr = $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"];
				$condicionantestab = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"];
			}
		
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
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$opcoes_tabela_est["tabeladb"]="consulta_estruturada_campanhas_estruturadas_objetivos_gerais";		
			$codprocesso = 4300;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			if ($processo_temp !== null && count($processo_temp) > 0) {
				$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];			
				$comhttp->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdobjetcampestr[sjdobjetcampestr.codcampestr=" . $codcampestr."]"];
				$comhttp->opcoes_retorno["usar_arr_tit"] = true;
				$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
				$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
				$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);			
				

				$comando_sql = "select * from sjdcampestr where codcampestr = $codcampestr";
				$campanha = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetch",\PDO::FETCH_ASSOC);
				//FuncoesHtml::montar_retorno_tabdados($comhttp);
				//print_r($comhttp->retorno->dados_retornados["dados"]);//exit();
				$params_sql = [
					"query"=>$comhttp->requisicao->sql->comando_sql,
					"fetch"=>"fetchAll"
				];
				$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($params_sql);
				$atingimentototal = 0;
				$qtlinhas = 0;
				foreach($comhttp->retorno->dados_retornados["dados"] as $chave_lin=>$linha) {			
					$atingimento = FuncoesConversao::como_numero($linha["% realiz."]);
					if ($atingimento > 120) {
						$atingimento = 120;
					}
					$atingimentototal += $atingimento;
					$qtlinhas ++;
				}
				$atingimentototal = $atingimentototal / count($comhttp->retorno->dados_retornados["dados"]);
				if ($atingimentototal > 120) {
					$atingimentototal = 120;
				}
				$vlpremiacao = FuncoesConversao::como_numero($campanha["vlpremiacao"]);
				$vlatingpremiacao = number_format($vlpremiacao * ($atingimentototal) / 100,2,",",".");
				$vlpremiacao = number_format($vlpremiacao,2,",",".");
				$linha = FuncoesHtml::criar_elemento([],"tr","linharodape");
				$th = FuncoesHtml::criar_elemento([],"th","naomostrar");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th","naomostrar");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$th["text"] = "Vlr. Premiável: ";
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$th["text"] = $vlpremiacao;
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$th["text"] = "Vlr. Atingido: ";
				$linha["sub"][] = $th;
				$th = FuncoesHtml::criar_elemento([],"th");
				$th["text"] = $vlatingpremiacao;
				$linha["sub"][] = $th;
				$opcoes_tabela_est["rodape"]["linhasextras"][0] = FuncoesHtml::montar_elemento_html($linha);
				$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
				$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
				$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
				$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);			
			}
			return $comhttp;
		}

		public static function consulta_estruturada_campanhas_estruturadas_objetivos_especificos(&$comhttp){
			/*Objetivo: montar o sql do sinergia*/
			$opcoes_tabela_est=FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["subregistros"]["ativo"]=false;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["exportacao"]["ativo"]=true;					
			$opcoes_tabela_est["corpo"]["ativo"]=true;					
			$opcoes_tabela_est["rodape"]["ativo"]=false;					
			$opcoes_tabela_est["campos_visiveis"]=["todos"];					
			$opcoes_tabela_est["campos_ocultos"]=[];
			$opcoes_tabela_est["campos_chaves_primaria"]=[];
			$opcoes_tabela_est["campos_chaves_unica"]=[];					
			$opcoes_tabela_est["campos_ordenacao"]=["todos"];					
			$opcoes_tabela_est["campos_filtro"]=["todos"];					
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$opcoes_tabela_est["tabeladb"]="consulta_estruturada_campanhas_estruturadas_objetivos_especificos";
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->sql = new TSql();
			$codprocesso = 4400;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp_temp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];		
			$comhttp_temp->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdcampestr[sjdcampestr.codcampestr=" . $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"]."]"];
			$comhttp_temp->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"linha");
			$comhttp_temp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			$comhttp_temp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_NUM);
			$campanha = $comhttp_temp->retorno->dados_retornados["dados"];		
			$codcampestr = $campanha[0][0];
			$visao_campanha = $campanha[0][3]; 
			
			
			/*obtem a condicionante*/
			$comhttp_temp1 = new TComHttp();
			$comhttp_temp1->requisicao->sql = new TSql();
			$codprocesso = 4410;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp_temp1->requisicao->requisitar->qual->objeto = $processo_temp["processo"];				
			$comhttp_temp1->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdcampestr[sjdcampestr.codcampestr=" . $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"]."]"];
			$comhttp_temp1->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp_temp1->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp1,"condicionantes");
			$comhttp_temp1->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp1->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_NUM);
			$condicionantes_campanha = $comhttp_temp1->retorno->dados_retornados["dados"];
			$condicionantes_campanha = $condicionantes_campanha[0][1];

			/*obtem a campanha*/
			$codprocesso = 4420;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];					
			$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = ["sjdobjetespeccampestr[sjdobjetespeccampestr.codcampestr=".$codcampestr."]"];
			$comhttp->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
			$comhttp_temp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);			
			FuncoesHtml::montar_retorno_tabdados($comhttp);
		}
		
		
		public static function consulta_estruturada_campanhas_estruturadas_objetivos_gerais_subcampanhas(&$comhttp){
			/*Objetivo: montar o sql do sinergia*/			
			$comhttp->opcoes_retorno["usar_arr_tit"] = false;			

			$opcoes_tabela_est=FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["subregistros"]["ativo"]=false;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["exportacao"]["ativo"]=true;					
			$opcoes_tabela_est["corpo"]["ativo"]=true;					
			$opcoes_tabela_est["rodape"]["ativo"]=false;					
			$opcoes_tabela_est["campos_visiveis"]=["todos"];					
			$opcoes_tabela_est["campos_ocultos"]=[];
			$opcoes_tabela_est["campos_chaves_primaria"]=[];					
			$opcoes_tabela_est["campos_chaves_unica"]=[];					
			$opcoes_tabela_est["campos_ordenacao"]=["todos"];					
			$opcoes_tabela_est["campos_filtro"]=["todos"];					
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$opcoes_tabela_est["tabeladb"]="consulta_estruturada_campanhas_estruturadas_objetivos_gerais_subcampanhas";
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->sql = new TSql();
			$codprocesso = 4400;
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp_temp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];			
			$comhttp_temp->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdcampestr[sjdcampestr.codcampestrsup=" . $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"]."]"];
			$comhttp_temp->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"lista");			
			$comhttp_temp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			$subcampanhas = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_NUM);
			$iteracoes = 0;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
			$comhttp->retorno->dados_retornados["dados"] = [];
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = [];
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = [];
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = [];
			foreach($subcampanhas as $ind => $subcampanha) {
				$comhttp_subcampanha = self::consulta_estruturada_campanhas_estruturadas_objetivos_gerais($subcampanha[0]);				
				$comhttp->retorno->dados_retornados["dados"][$ind] = $comhttp_subcampanha->retorno->dados_retornados["dados"];
				$comhttp->retorno->dados_retornados["conteudo_html"]["props"][$ind] = $comhttp_subcampanha->retorno->dados_retornados["conteudo_html"]["props"];
				$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"][$ind] = $comhttp_subcampanha->retorno->dados_retornados["conteudo_html"]["cabecalho"];
				$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"][$ind] = $comhttp_subcampanha->retorno->dados_retornados["conteudo_html"]["rodape"];				
				$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"][$ind] = str_ireplace("OBJETCAMPANHASESTRUTURADAS",$subcampanha[2],$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"][$ind]);
				$iteracoes ++;
				if ($iteracoes > 15) {
					break;
				}
			}
		}
		
		/**
			* Função para montar o resultado da pesquisa ao sinergia2
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_sinergia2(&$comhttp){			
			$texto_retorno = null;
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["cabecalho"]["ativo"]=true;
			$opcoes_tabela_est["rodape"]["ativo"] = false;
			$opcoes_tabela_est["subregistros"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["aoabrir"] = "window.fnsisjd.pesquisar_subregistro_painel({elemento:this})";
			$opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"] = [
			[
				"valor"=>"SUB",
				"texto"=>"SUB",
				"cod"=>0,
				"codsup"=>-1,
				"indexreal"=>0,
				"linha"=>0,
				"coluna"=>0,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_texto"
			],
			[
				"valor"=>"CAMPANHA",
				"texto"=>"CAMPANHA",
				"cod"=>1,
				"codsup"=>-1,
				"indexreal"=>1,
				"linha"=>0,
				"coluna"=>1,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_texto"
			],[
				"valor"=>"OBJETIVO",
				"texto"=>"OBJETIVO",
				"cod"=>2,
				"codsup"=>-1,
				"indexreal"=>2,
				"linha"=>0,
				"coluna"=>2,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"REALIZ. BRUTO",
				"texto"=>"REALIZ. BRUTO",
				"cod"=>3,
				"codsup"=>-1,
				"indexreal"=>3,
				"linha"=>0,
				"coluna"=>3,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"REALIZ. C/TRAVA",
				"texto"=>"REALIZ. C/TRAVA",
				"cod"=>4,
				"codsup"=>-1,
				"indexreal"=>4,
				"linha"=>0,
				"coluna"=>4,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"%REALIZ.",
				"texto"=>"%REALIZ.",
				"cod"=>5,
				"codsup"=>-1,
				"indexreal"=>5,
				"linha"=>0,
				"coluna"=>5,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_perc_med"
			]];	
			
			$usuariosis = [];
			$usuariosis = FuncoesSql::getInstancia()->obter_usuario_sis(["condic" => $_SESSION["codusur"],"unico"=>true]);
			if (count($usuariosis) <= 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("usuario nao encontrado", __FILE__,__FUNCTION__,__LINE__);
			}
			$comhttp_temp = new TComHttp();
			$comando_sql = "";
			
			/*monta as datas conforme periodos escolhidos pelo usuario*/
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			/*
				obtem as campanhas vigentes
				nao requer nivel de acesso
			*/	
			$comando_sql = "select * from sjdcampanhassinergia where dtfim >= sysdate";	
			$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			
			/*prepara as condicionantes para serem usadas caso tenham sido passadas no filtro*/
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_filial).")";
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				
				$rcas_supervisor = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				foreach ($rcas_supervisor as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}		
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (" . $comhttp->requisicao->requisitar->qual->condicionantes["rca"] . ")";
			}
			if (count($condicionantes_comhttp_rca) > 0) {
				$condicionantes_comhttp[] = implode(Constantes::sepn2,$condicionantes_comhttp_rca);
			}
			if (count($condicionantes_comhttp) > 0) {
				$condicionantes_comhttp = implode(Constantes::sepn1,$condicionantes_comhttp);
			}
			$condicionantes = trim(implode(" and ",$condicionantes));
			if (count($dados_campanhas) > 0) {
				$nometabela_objetivos = "sjdobjetivossinergia";
				$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
				$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
				$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);	
				foreach ($dados_campanhas as $linha_campanha) {
					if (strcasecmp(trim($linha_campanha["unidade"]), "mix") == 0) {
						$visoes_entidades_objetivos_campanha = FuncoesSisJD::obter_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$data_periodo1,$data_periodo2,$cnj_criterios_acesso);
						//print_r($visoes_entidades_objetivos_campanha); exit();
						if (isset($visoes_entidades_objetivos_campanha) && $visoes_entidades_objetivos_campanha !== null && count($visoes_entidades_objetivos_campanha) > 0) {
							foreach($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
								$visoes_objetivos_sinergia = FuncoesSisJD::obter_visoes_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$data_periodo1,$data_periodo2,$cnj_criterios_acesso);
								//print_r($visoes_objetivos_sinergia);exit();
								foreach($visoes_objetivos_sinergia as $visao_objet_sin){
									if ($comhttp->requisicao->requisitar->qual->comando === "atualizar_realizado_objetivos_sinergia") {
										$comhttp_temp->requisicao->requisitar->qual->objeto=$visao_entidades_objetivos. "," . $visao_objet_sin;
										$comhttp_temp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp_temp->requisicao->requisitar->qual->objeto);
										$comhttp_temp->requisicao->requisitar->qual->condicionantes["datas"] = $data_periodo1 . "," . $data_periodo2;
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
										if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
											$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
											if (count($condicionantes_comhttp) > 0) {
												$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = explode(Constantes::sepn1,$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
												$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"][] = $condicionantes_comhttp;
												$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = implode(Constantes::sepn1,$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
											}
										}
										$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"relatorio_venda");
										$dados_atingimento_agrupados = [];
										if (strcasecmp(trim($visao_objet_sin), "produto") == 0) {
											$dados_atingimento = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);			
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
													$comando_sql_temp .= " and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
													$produtos_por_entidade[$linha_atingimento[array_keys($linha_atingimento)[0]]] = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
												}										
												/*somente soma no atingimento se o produto fazer parte da meta do rca, senao nao*/
												if (in_array($linha_atingimento[array_keys($linha_atingimento)[2]],$produtos_por_entidade[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {									
													$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] ++;
												}
											}
											//print_r($dados_atingimento_agrupados); exit();
										} else {
											$dados_atingimento = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
											foreach ($dados_atingimento as $linha_atingimento) {
												if (!isset($dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]])) {
													$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] = 0;
												}
												$dados_atingimento_agrupados[$linha_atingimento[array_keys($linha_atingimento)[0]]] ++;
											}
										}
										
										
										$comando_sql_update = "";
										if (isset($dados_atingimento_agrupados) && $dados_atingimento_agrupados !== null && count($dados_atingimento_agrupados) > 0) {									
										
											/*atualiza as entidades que nao tiveram vendas para 0 (not in)*/
											$entidades = implode(",",array_keys($dados_atingimento_agrupados));									
											$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade not in ($entidades) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
											FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
											foreach ($dados_atingimento_agrupados as $chave=>$atingimento) {
												/*atualiza cada linha conforme a entidade*/
												$comando_sql_update = "update sjdobjetivossinergia set realizado = $atingimento where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
												//echo $comando_sql_update; exit();
												FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
											}
										} else {
											/*se nao houver dados de venda, atualiza todos para 0 no periodo*/
											$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"] . "')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
											FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
										}
										$comando_sql_update = "commit";
										FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
										$atingimento_acumulado = count($dados_atingimento); 
				
									} else {
										/*obtem os registros dos objetivos da campanha*/
										$comando_sql = "select * from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
										if (strlen($condicionantes) > 0) {
											$comando_sql .= ' and ' . $condicionantes;
										}
										if (count($cnj_criterios_acesso) > 0) {
											$comando_sql .= " and " . implode(" and " , $cnj_criterios_acesso);
										}
										$dados_objetivos = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
										$objetivo_acumulado = 0;
										$atingimento_acumulado = 0;
										if (strcasecmp(trim($linha_campanha["visao"]), "produto") == 0) {
											foreach($dados_objetivos as &$linha_objetivo) {									
												$linha_objetivo["valor"] = FuncoesConversao::como_numero($linha_objetivo["valor"]);
												$linha_objetivo["realizado"] = FuncoesConversao::como_numero($linha_objetivo["realizado"]);
												if ($linha_objetivo["valor"] > $objetivo_acumulado) {
													$objetivo_acumulado = $linha_objetivo["valor"];
												}
												if ($linha_objetivo["realizado"] > $atingimento_acumulado) {
													$atingimento_acumulado = $linha_objetivo["realizado"];
												}
												
											}							
										} else {
											foreach($dados_objetivos as $linha_objetivo) {									
												$objetivo_acumulado += FuncoesConversao::como_numero($linha_objetivo["valor"]);
												$atingimento_acumulado += FuncoesConversao::como_numero($linha_objetivo["realizado"]);
											}
										}
										if ($objetivo_acumulado === 0) {
											$objetivo_acumulado = 1;
										}
										$atingimento_acumulado_ponderado = $atingimento_acumulado / $objetivo_acumulado * 100;
										$opcoes_tabela_est["dados"]["tabela"]["dados"][] = [
											$linha_campanha["nome"],
											number_format($objetivo_acumulado,2,",","."),
											number_format($atingimento_acumulado,2,",","."),
											number_format($atingimento_acumulado ,2,",","."),
											number_format($atingimento_acumulado_ponderado,2,",",".") 
										];	
										
									}
								}
							}	
						}					
					} else {
						//continue;
						$visoes_entidades_objetivos_campanha = FuncoesSisJD::obter_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$data_periodo1,$data_periodo2,$cnj_criterios_acesso);
						foreach ($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
							$visoes_objetivos_sinergia = FuncoesSisJD::obter_visoes_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$data_periodo1,$data_periodo2,$cnj_criterios_acesso);
							foreach ($visoes_objetivos_sinergia as $visao_objet_sin) {
								if ($comhttp->requisicao->requisitar->qual->comando === "atualizar_realizado_objetivos_sinergia") {	
									$comhttp_temp->requisicao->requisitar->qual->objeto=$visao_entidades_objetivos. "," . $visao_objet_sin;
									$comhttp_temp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp_temp->requisicao->requisitar->qual->objeto);
									$comhttp_temp->requisicao->requisitar->qual->condicionantes["datas"] = $data_periodo1 . "," . $data_periodo2;
									$comhttp_temp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3]; //3=peso total;
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
										$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
										if (count($condicionantes_comhttp) > 0) {
											$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = explode(Constantes::sepn1,$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
											$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"][] = $condicionantes_comhttp;
											$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"] = implode(Constantes::sepn1,$comhttp_temp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
										}
									}
									
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
										$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and codentidade not in ($entidades) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
										FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
										foreach ($dados_atingimento_agrupados as $chave_entidade => $itens_atingimento) {									
											if (count($itens_atingimento) > 0) {
												
												/*atualiza as linha do objetivo dos produto da entidade que nao tem vendas (not in)*/
												$produtos = "'" . strtoupper(implode("','",array_keys($itens_atingimento))) . "'";
												$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave_entidade and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and upper(trim(coditemvisao)) not in ($produtos) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
												FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
												foreach($itens_atingimento as $chave_item_atingimento => $item_atingimento) {
													/*atualiza cada linha existente do produto */
													$comando_sql_update = "update sjdobjetivossinergia set realizado = ". FuncoesConversao::como_numero($item_atingimento) . " where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave_entidade and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and upper(trim(coditemvisao)) = upper(trim('$chave_item_atingimento'))  and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";											
													FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
												}
											} else {
												/*caso nao existam dados de vendas, atualiza todos os produtos da entidade para 0*/
												$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and codentidade = $chave_entidade and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";										
												FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
											}
										}
									} else {
										/*caso nao existam entidades com vendas, atualiza todas as entidades para 0*/
										$comando_sql_update = "update sjdobjetivossinergia set realizado = 0 where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";								
										FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
									}
									$comando_sql_update = "commit";
									FuncoesSql::getInstancia()->executar_sql($comando_sql_update);
									$atingimento_acumulado = count($dados_atingimento); 
				
								} else {
									$comando_sql = "select * from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(unidade)) = lower(trim('".$linha_campanha["unidade"]."')) and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos."')) and lower(trim(visao)) = lower(trim('$visao_objet_sin')) and to_date('01/'||sjdpkg_funcs_data.mes_numero(mes)||'/'||ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
									if (strlen($condicionantes) > 0) {
										$comando_sql .= ' and ' . $condicionantes;
									}							
									if (count($cnj_criterios_acesso) > 0) {
										$comando_sql .= " and " . implode(" and " , $cnj_criterios_acesso);
									}
									$dados_atingimento = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
									$objetivo_acumulado = 0;
									$valor_bruto_acumulado = 0;
									$valor_percmaxating_acumulado = 0;
									foreach($dados_atingimento as &$linha_atingimento) {								
										$linha_atingimento["valor"] = FuncoesConversao::como_numero($linha_atingimento["valor"],true);
										$linha_atingimento["realizado"] = FuncoesConversao::como_numero($linha_atingimento["realizado"],true);
										$linha_atingimento["percmaxating"] = FuncoesConversao::como_numero($linha_atingimento["percmaxating"],true);
										if ($linha_atingimento["percmaxating"] === null || $linha_atingimento["percmaxating"] === 0) {
											$linha_atingimento["percmaxating"] = 100;
										}
										if ($linha_atingimento["valor"] > 0) {
											$linha_atingimento["atingimento"] = $linha_atingimento["realizado"] / $linha_atingimento["valor"] * 100;
										} else {
											$linha_atingimento["atingimento"] = 100; //100% no caso de objetivo 0
										}
										if ($linha_atingimento["atingimento"] > $linha_atingimento["percmaxating"]) {
											$linha_atingimento["atingimento"] = $linha_atingimento["percmaxating"];
										}
										$linha_atingimento["valor_percmaxating"] = $linha_atingimento["atingimento"] * $linha_atingimento["valor"];
										$valor_percmaxating_acumulado += $linha_atingimento["valor_percmaxating"];
										$valor_bruto_acumulado += $linha_atingimento["realizado"];
										$objetivo_acumulado += $linha_atingimento["valor"];
									}							
									$atingimento_acumulado_permaxating = $valor_percmaxating_acumulado / $objetivo_acumulado;

									$opcoes_tabela_est["dados"]["tabela"]["dados"][] = [
										$linha_campanha["nome"],
										number_format($objetivo_acumulado,2,",","."),
										number_format($valor_bruto_acumulado,2,",","."),
										number_format($valor_percmaxating_acumulado / 100,2,",","."),
										number_format($atingimento_acumulado_permaxating,2,",",".") 
									];	
								}
							}
						}
					}
				}
			}
			if ($comhttp->requisicao->requisitar->qual->comando === "atualizar_realizado_objetivos_sinergia") {
				$texto_retorno = "dados atualizados com sucesso";
				$comhttp->retorno->dados_retornados["conteudo_html"] = $texto_retorno;
			} else {
				$opcoes_tabela_est["propriedades_html"]["visao"] = "geral";
				$opcoes_tabela_est["propriedades_html"]["filtro_filial"] = (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])?$comhttp->requisicao->requisitar->qual->condicionantes["filial"]:null);
				$opcoes_tabela_est["propriedades_html"]["filtro_supervisor"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])?$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]:null);
				$opcoes_tabela_est["propriedades_html"]["filtro_rca"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])?$comhttp->requisicao->requisitar->qual->condicionantes["rca"]:null);
				$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo1"] =  $mes_periodo1;
				$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo1"] =  $ano_periodo1;
				$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo2"] =  $mes_periodo2; 
				$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo2"] =  $ano_periodo2;				
				$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
				
				$comhttp->retorno->dados_retornados["dados"] = $opcoes_tabela_est["dados"]["tabela"]["dados"] ?? [];
				$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"];
				$comhttp->retorno->dados_retornados["conteudo_html"] = $comhttp->retorno->dados_retornados["conteudo_html"] ?? [];
				if (gettype($comhttp->retorno->dados_retornados["conteudo_html"]) === "array") { 
					$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);								
					$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false,true);
					$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);
				}
			}
			return $texto_retorno;
		}


		public static function montar_sinergia2evolucao(&$comhttp){
			
			$usuariosis = [];
			$usuariosis = FuncoesSql::getInstancia()->obter_usuario_sis(["condic" => $_SESSION["codusur"],"unico"=>true]);
			if (count($usuariosis) <= 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("usuario nao encontrado", __FILE__,__FUNCTION__,__LINE__);
			}
			$comando_sql = "";
			
			/*monta as datas conforme periodos escolhidos pelo usuario*/
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			
			/*
				obtem as campanhas vigentes
				nao requer nivel de acesso
			*/	
			$comando_sql = "select * from sjdcampanhassinergia where dtfim >= sysdate";	
			$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			
			/*prepara as condicionantes para serem usadas caso tenham sido passadas no filtro*/
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_filial).")";
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				
				$rcas_supervisor = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				foreach ($rcas_supervisor as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}		
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (" . $comhttp->requisicao->requisitar->qual->condicionantes["rca"] . ")";
			}
			if (count($condicionantes_comhttp_rca) > 0) {
				$condicionantes_comhttp[] = implode(Constantes::sepn2,$condicionantes_comhttp_rca);
			}
			if (count($condicionantes_comhttp) > 0) {
				$condicionantes_comhttp = implode(Constantes::sepn1,$condicionantes_comhttp);
			}
			$condicionantes = trim(implode(" and ",$condicionantes));
			
			$dados_retorno = [];

			if (count($dados_campanhas) > 0) {
				$nometabela_objetivos = "sjdobjetivossinergia";
				$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
				$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
				$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);	
				foreach ($dados_campanhas as $linha_campanha) {	
					$comando_sql = "
						SELECT
							o.codcampanhasinergia,
							'new Date(' || to_char(ev.data,'yyyy') || ',' || (to_char(ev.data,'mm') - 1) || ',' || (to_char(ev.data,'dd') *1) || ')' as data,
							sum(nvl(ev.realizado,0)) as realizado,
							(
								sum(o.valor) / (
									sjdpkg_funcs_data.get_qt_dias_uteis(to_date('".$data_periodo1."','dd/mm/yyyy'),to_date('".$data_periodo2 . "','dd/mm/yyyy'))
								)
							) * (sjdpkg_funcs_data.get_qt_dias_uteis(to_date('".$data_periodo1."','dd/mm/yyyy'),ev.data)) as objetivodia
						FROM
							sjdevolobjetsinergia ev
							join sjdobjetivossinergia o on o.codobjetivosinergia = ev.codobjetivosinergia
						where
							ev.data between to_date('".$data_periodo1."','dd/mm/yyyy') and to_date('".$data_periodo2 . "','dd/mm/yyyy')
							and o.codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . "
							and to_date('01/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy') >= to_date('".$data_periodo1."','dd/mm/yyyy') 
							and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy')) <= to_date('".$data_periodo2 . "','dd/mm/yyyy') 
							__CONDICIONANTES__
						group by
							o.codcampanhasinergia,
							ev.data,
							'new Date(' || to_char(ev.data,'yyyy') || ',' || (to_char(ev.data,'mm') - 1) || ',' || (to_char(ev.data,'dd') *1) || ')'
						order by
							o.codcampanhasinergia,
							ev.data
					";			
					$condicionantes_comando_sql = [];			
					if (strlen($condicionantes) > 0) {
						$condicionantes_comando_sql[] = $condicionantes;
					}
					if (count($cnj_criterios_acesso) > 0) {
						$condicionantes_comando_sql[] = str_ireplace("sjdobjetivossinergia.","o.",implode(" and " , $cnj_criterios_acesso));				
					}
					
					if (count($condicionantes_comando_sql) > 0) {
						$condicionantes_comando_sql = " and " . implode(" and ",$condicionantes_comando_sql);
						$comando_sql = str_ireplace("__CONDICIONANTES__",$condicionantes_comando_sql,$comando_sql);
					} else {
						$comando_sql = str_ireplace("__CONDICIONANTES__","",$comando_sql);
					}
					
					$dados_evolucao = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					
					foreach($dados_evolucao as $chave=>$valor) {
						if (!isset($dados_retorno[$valor["codcampanhasinergia"]])) {
							$dados_retorno[$valor["codcampanhasinergia"]] = [];
						}
						$dados_retorno[$valor["codcampanhasinergia"]][] = [$valor["data"],$valor["realizado"],$valor["objetivodia"]];
					}
					
				}
			}
			$comhttp->retorno->dados_retornados["dados"] = $dados_retorno;
			return $dados_retorno;
		}


		public static function montar_sinergia2evolucaoDetalhado(&$comhttp){
			
			$usuariosis = [];
			$usuariosis = FuncoesSql::getInstancia()->obter_usuario_sis(["condic" => $_SESSION["codusur"],"unico"=>true]);
			if (count($usuariosis) <= 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("usuario nao encontrado", __FILE__,__FUNCTION__,__LINE__);
			}
			$comando_sql = "";
			
			/*monta as datas conforme periodos escolhidos pelo usuario*/	
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			
			/*
				obtem as campanhas vigentes
				nao requer nivel de acesso
			*/	
			$comando_sql = "select * from sjdcampanhassinergia where codcampanhasinergia = 0 and dtfim >= sysdate";	
			$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			
			/*prepara as condicionantes para serem usadas caso tenham sido passadas no filtro*/
			$detalhadopor = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["detalhadopor"]));	
			$campo_detalhe = "";
			switch($detalhadopor) {
				case "filial":
					$campo_detalhe = "u.codfilial";
					break;
				case "supervisor":
					$campo_detalhe = "u.codsupervisor";
					break;
				case "rca":
					$campo_detalhe = "u.codusur";
					break;
				default:
					$campo_detalhe = "u.codusur";
					break;
			}
			
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_filial).")";
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				
				$rcas_supervisor = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				foreach ($rcas_supervisor as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}		
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (" . $comhttp->requisicao->requisitar->qual->condicionantes["rca"] . ")";
			}
			if (count($condicionantes_comhttp_rca) > 0) {
				$condicionantes_comhttp[] = implode(Constantes::sepn2,$condicionantes_comhttp_rca);
			}
			if (count($condicionantes_comhttp) > 0) {
				$condicionantes_comhttp = implode(Constantes::sepn1,$condicionantes_comhttp);
			}
			$condicionantes = trim(implode(" and ",$condicionantes));
			
			$dados_retorno = [];

			if (count($dados_campanhas) > 0) {
				$nometabela_objetivos = "sjdobjetivossinergia";
				$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
				$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
				$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);	
				
				foreach ($dados_campanhas as $linha_campanha) {	
					$comando_sql = "
						SELECT
							o.codcampanhasinergia,
							$campo_detalhe as codentidade,
							'new Date(' || to_char(ev.data,'yyyy') || ',' || (to_char(ev.data,'mm') - 1) || ',' || (to_char(ev.data,'dd') *1) || ')' as data,
							sum(nvl(ev.realizado,0)) as realizado,
							(
								sum(o.valor) / (
									sjdpkg_funcs_data.get_qt_dias_uteis(to_date('".$data_periodo1."','dd/mm/yyyy'),to_date('".$data_periodo2 . "','dd/mm/yyyy'))
								)
							) * (sjdpkg_funcs_data.get_qt_dias_uteis(to_date('".$data_periodo1."','dd/mm/yyyy'),ev.data)) as objetivodia
						FROM
							sjdevolobjetsinergia ev
							join sjdobjetivossinergia o on o.codobjetivosinergia = ev.codobjetivosinergia
							join jumbo.pcusuari u on u.codusur = o.codentidade
						where	
							o.codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . "
							and to_date('01/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy') >= to_date('".$data_periodo1."','dd/mm/yyyy') 
							and last_day(to_date('01/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy')) <= to_date('".$data_periodo2 . "','dd/mm/yyyy') 
							__CONDICIONANTES__
						group by
							o.codcampanhasinergia,
							$campo_detalhe,
							ev.data,
							'new Date(' || to_char(ev.data,'yyyy') || ',' || (to_char(ev.data,'mm') - 1) || ',' || (to_char(ev.data,'dd') *1) || ')'
						order by
							o.codcampanhasinergia,
							ev.data
					";			
					$condicionantes_comando_sql = [];			
					if (strlen($condicionantes) > 0) {
						$condicionantes_comando_sql[] = $condicionantes;
					}
					if (count($cnj_criterios_acesso) > 0) {
						$condicionantes_comando_sql[] = str_ireplace("sjdobjetivossinergia.","o.",implode(" and " , $cnj_criterios_acesso));				
					}
					
					if (count($condicionantes_comando_sql) > 0) {
						$condicionantes_comando_sql = " and " . implode(" and ",$condicionantes_comando_sql);
						$comando_sql = str_ireplace("__CONDICIONANTES__",$condicionantes_comando_sql,$comando_sql);
					} else {
						$comando_sql = str_ireplace("__CONDICIONANTES__","",$comando_sql);
					}
					$dados_evolucao = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
					
					foreach($dados_evolucao as $chave=>$valor) {
						if (!isset($dados_retorno[$valor["codcampanhasinergia"]])) {
							$dados_retorno[$valor["codcampanhasinergia"]] = [];
						}
						if (!isset($dados_retorno[$valor["codcampanhasinergia"]][$valor["codentidade"]])) {
							$dados_retorno[$valor["codcampanhasinergia"]][$valor["codentidade"]] = [];
						}
						$dados_retorno[$valor["codcampanhasinergia"]][$valor["codentidade"]][] = [$valor["data"],$valor["realizado"],$valor["objetivodia"]];
					}
				}
			}
			$comhttp->retorno->dados_retornados["dados"] = $dados_retorno;
			return $dados_retorno;
		}



		/**
			* Função para montar o resultado da pesquisa dos subregistros do painel
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_subregistros_painel(&$comhttp) {			
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["cabecalho"]["ativo"]=true;
			$opcoes_tabela_est["rodape"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["aoabrir"] = "window.fnsisjd.pesquisar_subregistro_painel({elemento:this})";
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["mostrarcolunasocultas"]["ativo"] = false;
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"] = [
			[
				"valor"=>"SUB",
				"cod"=>0,
				"codsup"=>-1,
				"indexreal"=>0,
				"linha"=>0,
				"coluna"=>0,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint"
			],
			[
				"valor"=>"CODCAMPANHA",
				"cod"=>1,
				"codsup"=>-1,
				"indexreal"=>1,
				"linha"=>0,
				"coluna"=>1,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint"
			],
			[
				"valor"=>"DESCCAMPANHA",
				"cod"=>2,
				"codsup"=>-1,
				"indexreal"=>2,
				"linha"=>0,
				"coluna"=>2,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_texto"
			],[
				"valor"=>"OBJETIVO",
				"cod"=>3,
				"codsup"=>-1,
				"indexreal"=>3,
				"linha"=>0,
				"coluna"=>3,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"REALIZ. BRUTO",
				"cod"=>4,
				"codsup"=>-1,
				"indexreal"=>4,
				"linha"=>0,
				"coluna"=>4,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"REALIZ. C/TRAVA",
				"cod"=>5,
				"codsup"=>-1,
				"indexreal"=>5,
				"linha"=>0,
				"coluna"=>5,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_quant"
			],[
				"valor"=>"%REALIZ.",
				"cod"=>6,
				"codsup"=>-1,
				"indexreal"=>6,
				"linha"=>0,
				"coluna"=>6,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_perc_med"
			]];		
			
			$visoes_painel = ["geral","filial","supervisor","rca","grupo giro","departamento","produto"];
			$visao_painel = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["visao"]));
			$opcoes_tabela_est["propriedades_html"]["visao"] = $visao_painel;
			$usuariosis = [];
			$usuariosis = FuncoesSql::getInstancia()->obter_usuario_sis(["condic" => $_SESSION["codusur"],"unico"=>true]);
			if (count($usuariosis) <= 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("usuario nao encontrado", __FILE__,__FUNCTION__,__LINE__);
			}
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->requisitar->qual->condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes;
			$comando_sql = "";
			
			/*obtem as campanhas vigentes*/	
			$comando_sql = "select * from sjdcampanhassinergia where dtfim >= sysdate and lower(trim(nome)) = lower(trim('".$comhttp->requisicao->requisitar->qual->condicionantes["campanha"]."'))";	
			$dados_campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			
			/*monta as datas conforme periodos escolhidos pelo usuario*/			
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);

			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo1"] =  $mes_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo1"] =  $ano_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo2"] =  $mes_periodo2; 
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo2"] =  $ano_periodo2;
			
			/*prepara as condicionantes para serem usadas caso tenham sido passadas no filtro*/
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {				
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_filial).")";
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {				
				$rcas_supervisor = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				foreach ($rcas_supervisor as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}		
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = "entidade='rca'";
				$condicionantes[] = "codentidade in (" . $comhttp->requisicao->requisitar->qual->condicionantes["rca"] . ")";
			}
			if (count($condicionantes_comhttp_rca) > 0) {
				$condicionantes_comhttp[] = implode(Constantes::sepn2,$condicionantes_comhttp_rca);
			}
			if (count($condicionantes_comhttp) > 0) {
				$condicionantes_comhttp = implode(Constantes::sepn1,$condicionantes_comhttp);
			}
			$condicionantes = trim(implode(" and ",$condicionantes));
			

			$opcoes_tabela_est["propriedades_html"]["filtro_filial"] = (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])?$comhttp->requisicao->requisitar->qual->condicionantes["filial"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_supervisor"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])?$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_rca"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])?$comhttp->requisicao->requisitar->qual->condicionantes["rca"]:null);

			if (count($dados_campanhas) > 0) {
				
				$nometabela_objetivos = "sjdobjetivossinergia";
				$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
				$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
				$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);				
				$comando_sql_inicial = "						
					WITH 
						grupos_depto as (
							select 
								distinct
								g.codvisivelgrupo,
								p.codepto,
								d.descricao
							from 
								sjdinteggrupoprod ig
								join sjdgruposprodequiv g on (g.codgrupoprod = ig.codgrupoprod)
								join jumbo.pcprodut p on (p.codprod =  ig.codprod)
								join jumbo.pcdepto d on (d.codepto = p.codepto)
						),			
					valores AS (
						 SELECT
							 u.codfilial AS codfilial,
							 f.cidade AS filial,
							 u.codsupervisor as codsupervisor,
							 s.nome as nomesupervisor,
							 o.codentidade as codrca,
							 u.nome as nomerca,
							 o.codgrupogiro,
							 gg.nomegrupogiro,
							 nvl(gd.codepto,d.codepto) as codepto,
							 nvl(gd.descricao,d.descricao) as departamento,
							 o.coditemvisao as codprod,
							 nvl(g.nomegrupoprod,p.descricao) as descricao,
							 o.valor,
							 o.realizado,
							 nvl(o.percmaxating,100) as percmaxating,
							 CASE
								 WHEN o.realizado / DECODE(o.valor,0,1,NULL,1,o.valor) * 100 > nvl(o.percmaxating,100) THEN
									 nvl(o.percmaxating,100)
								 ELSE
									 o.realizado / DECODE(o.valor,0,1,NULL,1,o.valor) * 100
							 END AS percating,
							 CASE
								 WHEN o.realizado / DECODE(o.valor,0,1,NULL,1,o.valor) * 100 > nvl(o.percmaxating,100) THEN
									 o.valor * nvl(o.percmaxating,100) / 100
								 ELSE
									 o.realizado
							 END as realizado_percmax
						 FROM
							 sjdobjetivossinergia o
							 left outer join jumbo.pcprodut p on (to_char(p.codprod) = o.coditemvisao)
							 left outer join jumbo.pcusuari u on (u.codusur = o.codentidade)
							 left outer join jumbo.pcfilial f on (f.codigo = u.codfilial)
							 left outer join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor)
							 left outer join sjdgruposprodequiv g on (g.codvisivelgrupo = o.coditemvisao)
							 left outer join sjdgruposgiro gg on (gg.codgrupogiro = o.codgrupogiro)											 
							 left outer join jumbo.pcdepto d on (d.codepto = p.codepto)
							 left outer join grupos_depto gd on (gd.codvisivelgrupo = g.codvisivelgrupo)
						 WHERE										 
							o.codcampanhasinergia = __CODCAMPANHASINERGIA__ 
							and lower(trim(o.unidade)) = lower(trim('__UNIDADE__'))
							and lower(trim(o.entidade)) = lower(trim('__VISAO_ENTIDADES_OBJETIVOS__'))
							and lower(trim(o.visao)) = lower(trim('__VISAO_OBJET_SIN__'))
							and to_date('01/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy') between to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')";
							 
				if (strlen($condicionantes) > 0) {
					$comando_sql_inicial .= ' and ' . str_ireplace("sjdobjetivossinergia.","o.",strtolower(trim($condicionantes)));
				}
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"])) {
					$condicionantestab = FuncoesSql::getInstancia()->preparar_condicionantestab($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]);
					$comando_sql_inicial .= ' and ' . str_ireplace("sjdobjetivossinergia.","o.",strtolower(trim(implode(" and " ,$condicionantestab))));
				}								
				if (count($cnj_criterios_acesso) > 0) {
					$comando_sql_inicial .= " and " . str_ireplace("sjdobjetivossinergia.","o.",strtolower(trim(implode(" and " , $cnj_criterios_acesso))));
				}
				foreach ($dados_campanhas as $linha_campanha) {					
					$opcoes_tabela_est["propriedades_html"]["campanha"] = $linha_campanha["nome"];					
					if ($linha_campanha["unidade"] === "mix") {						
						
						$opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"] = [
						[
							"valor"=>"SUB",
							"cod"=>0,
							"codsup"=>-1,
							"indexreal"=>0,
							"linha"=>0,
							"coluna"=>0,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_numint"
						],
						[
							"valor"=>"CODCAMPANHA",
							"cod"=>1,
							"codsup"=>-1,
							"indexreal"=>1,
							"linha"=>0,
							"coluna"=>1,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_numint"
						],
						[
							"valor"=>"DESCCAMPANHA",
							"cod"=>2,
							"codsup"=>-1,
							"indexreal"=>2,
							"linha"=>0,
							"coluna"=>2,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_texto"
						],[
							"valor"=>"OBJETIVO",
							"cod"=>3,
							"codsup"=>-1,
							"indexreal"=>3,
							"linha"=>0,
							"coluna"=>3,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_quant"
						],[
							"valor"=>"REALIZADO",
							"cod"=>4,
							"codsup"=>-1,
							"indexreal"=>4,
							"linha"=>0,
							"coluna"=>4,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_quant"
						],[
							"valor"=>"%REALIZ.",
							"cod"=>5,
							"codsup"=>-1,
							"indexreal"=>5,
							"linha"=>0,
							"coluna"=>5,
							"rowspan"=>1,
							"colspan"=>1,
							"formatacao"=>"cel_perc_med"
						]];					
					
						$visoes_entidades_objetivos_campanha = FuncoesSisJD::obter_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$data_periodo1,$data_periodo2,$cnj_criterios_acesso);				
						foreach($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
							$visoes_objetivos_sinergia = FuncoesSisJD::obter_visoes_entidades_objetivos($linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$data_periodo1,$data_periodo2,$cnj_criterios_acesso);
							foreach($visoes_objetivos_sinergia as $visao_objet_sin){
								$comando_sql = $comando_sql_inicial; 
								$comando_sql = str_ireplace(["__CODCAMPANHASINERGIA__","__UNIDADE__","__VISAO_ENTIDADES_OBJETIVOS__","__VISAO_OBJET_SIN__"],[$linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos,$visao_objet_sin],$comando_sql);
								if (strcasecmp(trim($linha_campanha["visao"]),"produto") == 0) {
									if ($visao_painel === $visoes_painel[1]) { //VISAO FILIAL
										$comando_sql .= '			 
											 )
											 SELECT
												 codfilial,
												 filial,
												 MAX(valor) as Objetivo,
												 MAX(realizado) as Realizado,
												 MAX(realizado) / decode(MAX(valor),0,1,null,1,MAX(valor)) * 100 as "% Realiz." 
											 FROM
												 valores
											 GROUP BY
												 codfilial,
												 filial
												  ORDER BY 1';
										$params_dados_ating = [
											"query"=>$comando_sql,
											"fetch"=>"fetchAll",
											"fetch_mode"=>\PDO::FETCH_ASSOC,
											"retornar_resultset"=>true
										];
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} else if ($visao_painel === $visoes_painel[2]) { //VISAO SUPERVISOR
										$comando_sql .= '			 
											 )
											 SELECT
												 codsupervisor as "Cod.Superv.",
												 nomesupervisor as "Nome",
												 MAX(valor) as Objetivo,
												 MAX(realizado) as Realizado,
												 MAX(realizado) / decode(MAX(valor),0,1,null,1,MAX(valor)) * 100 as "% Realiz."
											 FROM
												 valores ';
										if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codfilial"])) {
											$comando_sql .= ' where codfilial = '.$comhttp->requisicao->requisitar->qual->condicionantes["codfilial"].' ';
										}
										$comando_sql .= ' GROUP BY
												 codsupervisor,
												 nomesupervisor
												  ORDER BY 1';
										$params_dados_ating = [
											"query"=>$comando_sql,
											"fetch"=>"fetchAll",
											"fetch_mode"=>\PDO::FETCH_ASSOC,
											"retornar_resultset"=>true
										];
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} else if ($visao_painel === $visoes_painel[3]) { // VISAO RCA
										$comando_sql .= '			 
											 )
											 SELECT
												 codrca,
												 nomerca,
												 MAX(valor) as Objetivo,
												 MAX(realizado) as Realizado,
												 MAX(realizado) / decode(MAX(valor),0,1,null,1,MAX(valor)) * 100 as "% Reliaz."
											 FROM
												 valores ';
										if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"])) {
											$comando_sql .= ' where codsupervisor = '.$comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"].' ';
										}
										
										$comando_sql .= ' GROUP BY
												 codrca,
												 nomerca
												  ORDER BY 1';
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;


										$params_dados_ating = [
											"query"=>$comando_sql,
											"fetch"=>"fetchAll",
											"fetch_mode"=>\PDO::FETCH_ASSOC,
											"retornar_resultset"=>true
										];
										$opcoes_tabela_est["subregistros"]["ativo"] = false;
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} 
								} else {							
									if ($visao_painel === $visoes_painel[1]) {
										$comando_sql .= '			 
											 )
											 SELECT
												 codfilial,
												 filial,
												 SUM(valor) as Objetivo,
												 SUM(realizado) as Realizado,
												 SUM(percating) / COUNT(codfilial) as "% Realiz."
											 FROM
												 valores
											 GROUP BY
												 codfilial,
												 filial 
											 ORDER BY 1';
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} else if ($visao_painel === $visoes_painel[2]) {
										$comando_sql .= '			 
											 )
											 SELECT
												 codsupervisor,
												 nomesupervisor,
												 SUM(valor) as Objetivo,
												 SUM(realizado) as Realizado,
												 SUM(percating) / COUNT(codsupervisor) as "% Realiz."
											 FROM
												 valores ';
										if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codfilial"])) {
											$comando_sql .= ' where codfilial = '.$comhttp->requisicao->requisitar->qual->condicionantes["codfilial"].' ';
										}
										$comando_sql .= ' GROUP BY
												 codsupervisor,
												 nomesupervisor 
												 ORDER BY 1';
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} else if ($visao_painel === $visoes_painel[3]) {
										$comando_sql .= '			 
											 )
											 SELECT
												 codrca,
												 nomerca,
												 SUM(valor) as Objetivo,
												 SUM(realizado) as Realizado,
												 SUM(percating) / COUNT(codrca) as "% Realiz."
											 FROM
												 valores ';
										if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"])) {
											$comando_sql .= ' where codsupervisor = '.$comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"].' ';
										}
										
										$comando_sql .= ' GROUP BY
												 codrca,
												 nomerca 
												order by 1';
										$opcoes_tabela_est["subregistros"]["ativo"] = false;
										$comhttp->requisicao->sql->comando_sql = $comando_sql;
										$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
										FuncoesHtml::montar_retorno_tabdados($comhttp);
									} 
								}
							}
						}				
					} else {
						$visoes_entidades_objetivos_campanha = [];
						$comando_sql = "select distinct lower(trim(entidade)) from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"];
						$visoes_entidades_objetivos_campanha = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_NUM);
						foreach($visoes_entidades_objetivos_campanha as $visao_entidades_objetivos) {
							$visoes_objetivos_sinergia = [];
							$comando_sql = "select distinct lower(trim(visao)) from sjdobjetivossinergia where codcampanhasinergia = " . $linha_campanha["codcampanhasinergia"] . " and lower(trim(entidade)) = lower(trim('".$visao_entidades_objetivos[0]."'))";
							if (count($cnj_criterios_acesso) > 0) {
								$comando_sql .= " and " . implode(" and " , $cnj_criterios_acesso);
							}					
							$visoes_objetivos_sinergia = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_NUM);
							foreach($visoes_objetivos_sinergia as $visao_objet_sin){
								$comando_sql = $comando_sql_inicial; 
								$comando_sql = str_ireplace(["__CODCAMPANHASINERGIA__","__UNIDADE__","__VISAO_ENTIDADES_OBJETIVOS__","__VISAO_OBJET_SIN__"],[$linha_campanha["codcampanhasinergia"],$linha_campanha["unidade"],$visao_entidades_objetivos[0],$visao_objet_sin[0]],$comando_sql);
								if ($visao_painel === $visoes_painel[1]) { //visao filial
									$comando_sql .= '			 
										 )
										 SELECT
											 codfilial,
											 filial,
											 to_char(SUM(valor),\'999G999G999D99\') as "Objetivo",
											 to_char(SUM(realizado),\'999G999G999D99\') as "Realiz. Bruto",
											 to_char(SUM(realizado_percmax),\'999G999G999D99\') as "Realiz. Liq.",
											 to_char((SUM(realizado_percmax) / sum(valor)) * 100,\'999G999G999D99\') as "% Realiz. Liq."
										 FROM
											 valores
										 GROUP BY
											 codfilial,
											 filial 
										 order by 
											 1,3';
									
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);
								} else if ($visao_painel === $visoes_painel[2]) { //VISAO SUPERVISOR
									$comando_sql .= '			 
										 )
										 SELECT
											 codsupervisor,
											 nomesupervisor,
											 SUM(valor) as Objetivo,
											 SUM(realizado) as "Realiz. Bruto",
											 SUM(realizado_percmax) as "Realiz. Liq.",
											 (SUM(realizado_percmax) / sum(valor)) * 100 as "% Realiz. Liq."
										 FROM
											 valores ';
									
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codfilial"])) {
										$comando_sql .= ' where codfilial = '.$comhttp->requisicao->requisitar->qual->condicionantes["codfilial"].' ';
									}
									$comando_sql .= ' GROUP BY
											 codsupervisor,
											 nomesupervisor
											 order by 1,3';
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);	
								} else if ($visao_painel === $visoes_painel[3]) { //VISAO RCA
									$comando_sql .= '			 
										 )
										 SELECT
											 codrca,
											 nomerca,
											 SUM(valor) as Objetivo,
											 SUM(realizado) as "Realiz. Bruto",
											 SUM(realizado_percmax) as "Realiz. Liq.",
											 (SUM(realizado_percmax) / sum(valor)) * 100 as "% Realiz. Liq."
										 FROM
											 valores ';
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"])) {
										$comando_sql .= ' where codsupervisor = '.$comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"].' ';
									}
									
									$comando_sql .= ' GROUP BY
											 codrca,
											 nomerca 
											 order by 1,3';
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);	
								} else if ($visao_painel === $visoes_painel[4]) { //VISAO GRUPO GIRO
									$comando_sql .= '			 
										 )
										 SELECT
											 codgrupogiro,
											 nomegrupogiro,
											 SUM(valor) as Objetivo,
											 SUM(realizado) as "Realiz. Bruto",
											 SUM(realizado_percmax) as "Realiz. Liq.",
											 (SUM(realizado_percmax) / sum(valor)) * 100 as "% Realiz. Liq.",
											 nvl(percmaxating,100) as "% Max. Ating."
										 FROM
											 valores ';
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codrca"])) {
										$comando_sql .= ' where codrca = '.$comhttp->requisicao->requisitar->qual->condicionantes["codrca"].' ';
									}
									
									$comando_sql .= ' GROUP BY
											 codgrupogiro,
											 nomegrupogiro,
											 nvl(percmaxating,100)
											 order by 1,3';
									$opcoes_tabela_est["classes_linhas"] = [
										"CODGRUPOGIRO" => [
											1 => "grupoprodsin1",
											2 => "grupoprodsin2",
											3 => "grupoprodsin3"
										]
									];
									$opcoes_tabela_est["corpo"]["linhas"]["classes"]["linha_atingida_min"] = [
										"condicionantes" => [
											"col" => 5,
											"operacao" => ">=",
											"valor" => 90
										]
									];
									
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);	
								} else if ($visao_painel === $visoes_painel[5]) { //VISAO DEPARTAMENTO
									$comando_sql .= '			 
										 )
										 SELECT
											 codepto,
											 departamento,
											 SUM(valor) as "Objetivo",
											 SUM(realizado) as "Realiz. Bruto",
											 SUM(realizado_percmax) as "Realiz. Liq",
											 (SUM(realizado_percmax) / sum(valor)) * 100 as "% Realiz. Liq."
										 FROM
											 valores ';
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"])) {
										$comando_sql .= ' where codsupervisor = '.$comhttp->requisicao->requisitar->qual->condicionantes["codsupervisor"].' ';
									}
									
									$comando_sql .= ' GROUP BY
											 codepto,
											 departamento
											 order by 1,3';
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);	
								} else if ($visao_painel === $visoes_painel[6]) { //VISAO PRODUTO
									$comando_sql .= '
										 )
										 SELECT
											 codprod,
											 descricao,
											 SUM(valor) as Objetivo,
											 SUM(realizado) as "Realiz. Bruto.",
											 SUM(realizado_percmax) as "Realiz. Liq.",
											 (SUM(realizado_percmax) / sum(valor)) * 100 as "% Realiz. Liq.",
											 codgrupogiro ||\'-\'|| nomegrupogiro as "Grupo Giro",
											 nvl(percmaxating,100) as "% Max. Ating"
										 FROM
											 valores ';
									if (isset($comhttp->requisicao->requisitar->qual->condicionantes["codrca"])) {
										$comando_sql .= " where codrca = ".$comhttp->requisicao->requisitar->qual->condicionantes["codrca"]." ";
									}
									
									$comando_sql .= " GROUP BY
											 codprod,
											 descricao,
											 codgrupogiro ||'-'|| nomegrupogiro,
											 nvl(percmaxating,100)
											 order by 1,2";

									$opcoes_tabela_est["subregistros"]["ativo"] = false;
									$opcoes_tabela_est["classes_linhas"] = [
										"GRUPOGIRO" => [
											"1-Itens Giro" => "grupoprodsin1",
											"2-Itens Industrializados" => "grupoprodsin2",
											"3-Itens Jumbo" => "grupoprodsin3"
										]
									];
									$opcoes_tabela_est["corpo"]["linhas"]["classes"]["linha_atingida_min"] = [
										"condicionantes" => [
											"col" => 5,
											"operacao" => ">=",
											"valor" => 90
										]
									];									
									$opcoes_tabela_est["subregistros"]["ativo"] = false;
									$comhttp->requisicao->sql->comando_sql = $comando_sql;
									$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
									FuncoesHtml::montar_retorno_tabdados($comhttp);	
								}						
							}
						}
					}
				}
			}
		}
		

		/**
			* Função para montar o resultado da pesquisa ao painel, quadro campanhas estruturadas
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_painel_campanhas_estruturadas(&$comhttp) {
			$texto_retorno = "";
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"])) {
				$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
				$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
				$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
				$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
				$dtini = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
				$dtfim = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
				$dtfim = FuncoesData::UltDiaMes($dtfim);	
			} else {
				$dtini = FuncoesData::data_primeiro_dia_mes_atual(dataBr());
				$dtfim = FuncoesData::UltDiaMes(FuncoesData::dataBr());
			}
			$datas = [$dtini,$dtfim];
			
			$comando_sql = "select codcampestr,codcampestrsup,nome,visao,dtini,dtfim,codusurcondic,codfilialcondic,vlpremiacao,vlpremiacaototal from sjdcampestr where dtini between '$dtini' and '$dtfim' ";
			
			$rcas = [];
			$supervisor = [];
			$filial = [];
			
			/* 
				verifica se foram impostados valores nos filtros
			*/
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$rcas = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["rca"]);	
				$rcas = FuncoesConversao::como_numero($rcas);
			}
			
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				$supervisor = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);	
				$supervisor = FuncoesConversao::como_numero($supervisor);
			}
			
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$filial = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["filial"]);	
				$filial = FuncoesConversao::como_numero($filial);
			}
			
			/*
				verifica se o usuario tem restricao de acesso conforme nivel de acesso e atribui condicionante ao codigo sql
			*/
			$codscamp_com_acesso = FuncoesSisJD::obter_codscampestr_acessiveis_usuario($comhttp);
			if (count($codscamp_com_acesso) > 0) { 
				$comando_sql .=" and codcampestr in (".implode(",",$codscamp_com_acesso).")";
			} else {
				if (FuncoesConversao::como_numero($_SESSION["usuariosis"]["codnivelacesso"]) >= 30 || (
				
					count($rcas) > 0 || count($filial) > 0 || count($supervisor) > 0
				)) {
					$comando_sql .=" and 1=2";
				}
			}	
			$comando_sql .= " order by nvl(codcampestrsup,codcampestr) || '-' || decode(codcampestrsup,null,0,codcampestr)";
			$campanhas = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);	
			/*print_r($campanhas); exit();
			/*
				ordena as campanhas localizadas de forma que as subcampanhas fiquem imediatamente abaixo de sua campanha superior
			*/
			/*$campanhas_temp = [];
			$codcampestrsup = null;
			foreach ($campanhas as $chave_camp => &$camp) {
				$codcampestrsup = FuncoesConversao::como_numero($camp["codcampestrsup"]);
				if (isset($codcampestrsup) && $codcampestrsup != null && strlen($codcampestrsup) > 0) {					
					array_splice($campanhas_temp,array_search($codcampestrsup,array_keys($campanhas_temp))+1,0,$camp);
				} else {
					$campanhas_temp[FuncoesConversao::como_numero($camp["codcampestr"])] = $camp;
				}
			}
			$campanhas = $campanhas_temp;*/
			//print_r($campanhas); exit();
			$opcoes_tabela_est=FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["subregistros"]["ativo"]=false;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"]=false;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"]=false;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"]=false;
			$opcoes_tabela_est["corpo"]["ativo"]=true;					
			$opcoes_tabela_est["rodape"]["ativo"]=false;					
			$opcoes_tabela_est["campos_visiveis"]=["todos"];					
			$opcoes_tabela_est["campos_ocultos"]=[];
			$opcoes_tabela_est["campos_chaves_primaria"]=[];					
			$opcoes_tabela_est["campos_chaves_unica"]=[];					
			$opcoes_tabela_est["campos_ordenacao"]=["todos"];					
			$opcoes_tabela_est["campos_filtro"]=["todos"];					
			$cods_camp_sup = [];
			$comhttp_temp = new TComHttp();
			if (count($campanhas) > 0) {
				$padding_left = 0;
				$style = "";
				$codcampsup = -1;
				
				/*
					percorre as campanhas selecionadas montando-as em tabelas html para retornar ao usuario
				*/
				$contcamp = 0;
				foreach ($campanhas as $campanha) {		
					$comhttp_temp->requisicao->sql = new TSql();
					$codprocesso = 4300; 
					$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
					$comhttp_temp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];	
					$comhttp_temp->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdobjetcampestr[sjdobjetcampestr.codcampestr=" . $campanha["codcampestr"]."]"];
					$comhttp_temp->opcoes_retorno["usar_arr_tit"] = true;
					$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp);
					//echo $comhttp_temp->requisicao->sql->comando_sql; exit();
					$comhttp_temp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
					
					$comhttp->retorno->dados_retornados["dados"][$contcamp] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);					
					$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"][$contcamp] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp_temp,false);

					/*
						acrescenta ou retira padding-left da tabela conforme sua hierarquia (se e uma sub campanha tem padding-left)
					*/
					$margin_left = 0;
					if (isset($campanha["codcampestrsup"]) && $campanha["codcampestrsup"] != null && strlen($campanha["codcampestrsup"]) > 0) {
						$margin_left = 10;
					}
					$comhttp->retorno->dados_retornados["conteudo_html"]["props"][$contcamp][] = ["prop"=>"style","value"=>"margin-left:" . $margin_left . "px;"];

					/*if ($codcampsup === -1 && $contcamp > 0) {
						$texto_retorno .= FuncoesHtml::montar_elemento_html(FuncoesHtml::criar_elemento([],'br'));
					}*/
					$contcamp ++;
				}
			}
			//$comhttp->retorno->dados_retornados["conteudo_html"] = $texto_retorno;
			return $comhttp->retorno->dados_retornados["conteudo_html"] ?? [];
		}

		/**
			* Função para montar o resultado da pesquisa ao sinergia2
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_painel_clientes_nao_positivados(&$comhttp, $opcoes_tabela_est = null) {
			$opcoes_tabela_est = $opcoes_tabela_est ?? FuncoesHtml::opcoes_tabela_est;
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["visoes"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = "cliente";
			}
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"])) {				
					$data_ini = "01/" . FuncoesData::mesNum($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]) . "/" . $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
					$data_fim = FuncoesData::UltDiaMes("01/" . FuncoesData::mesNum($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]) . "/" . $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"]);
					$data_ini_mes_ant = FuncoesData::data_primeiro_dia_mes_anterior($data_ini);
					$data_fim_mes_ant = FuncoesData::UltDiaMes($data_ini_mes_ant);
					$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = $data_ini_mes_ant . "," . $data_fim_mes_ant . "," . $data_ini . "," . $data_fim;
				} else {
					$data_ini_mes_ant = FuncoesData::data_primeiro_dia_mes_anterior();
					$data_fim_mes_ant = FuncoesData::UltDiaMes($data_ini_mes_ant);			
					$data_ini = FuncoesData::data_primeiro_dia_mes_atual();
					$data_fim = FuncoesData::UltDiaMes($data_ini);
					$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = $data_ini_mes_ant . "," . $data_fim_mes_ant . "," . $data_ini . "," . $data_fim;		
				}
			}
			FuncoesMontarSql::montar_sql_clientes_nao_positivados($comhttp);
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			$opcoes_tabela_est["tabeladb"]="clientesnaopositivados";
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ocultarcolunas"]["ativo"] = false;
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			//$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			//print_r($comhttp->retorno->dados_retornados["dados"]); exit();
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = null;//FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);


			/*obtem da tabela valores por entidade */
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes);exit();
			/*if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mes"])) {
				$mes1 = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
				$mes_num = FuncoesData::MesNum($mes1);
				$dtini = '01/'.$mes_num . '/' . FuncoesData::ano_atual();
				$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);									
			} else {
				$dtini = FuncoesData::data_primeiro_dia_mes_atual();
				$dtfim = FuncoesData::data_ultimo_dia_mes_atual();
			}
			$datas = [$dtini,$dtfim];*/
			//$mes1 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);
			$codsusuariosacessiveis = FuncoesSisJD::obter_cods_rcas_acessiveis();				
			
			/*monta as condicionantes conforme o filtro que vier do painel*/
			$condicionantes = [];
			$condicionantes[] = "codentidade in (".implode(",",$codsusuariosacessiveis).")";
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"]) && $comhttp->requisicao->requisitar->qual->condicionantes["rca"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["rca"])>0
			) {
				$condicionantes[] = "codentidade = " .$comhttp->requisicao->requisitar->qual->condicionantes["rca"];
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]) && $comhttp->requisicao->requisitar->qual->condicionantes["supervisor"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])>0
			) {
				$codsusuariossuperv = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);				
				$condicionantes[] = "codentidade in (".implode(",",$codsusuariossuperv).")";
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"]) && $comhttp->requisicao->requisitar->qual->condicionantes["filial"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["filial"])>0
			) {
				$codsusuariosfilial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);				
				$condicionantes[] = "codentidade in (".implode(",",$codsusuariosfilial).")";
			}
			$params_valores_por_entidade = [
				"agregacao"=>"",
				"campo"=>"dadosclob",
				"entidade"=>"rca",
				"condicionantes" => implode(" and ",$condicionantes),
				"nomevalor"=>"clientes_naoposit_mes",
				"dtini"=>$data_ini,
				"dtfim"=>$data_fim		
			];
			$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);								
			$params_sql = [
				"query"=>$cmd_sql
			];
			//echo $cmd_sql; exit();
			$cursor = FuncoesSql::getInstancia()->executar_sql($params_sql);
			$linhas = [];
			while($linha = $cursor["result"]->fetch(\PDO::FETCH_COLUMN,0)) {
				if (in_array(gettype($linha),["object","resource"])) {
					$linha = stream_get_contents($linha);
				}
				$linha = str_replace(["[","]"],"",$linha);
				$linhas[] = $linha;				
			}
			FuncoesSql::getInstancia()->fechar_cursor($cursor);
			//print_r($linhas);exit();
			$linhas = '[' . implode(",",$linhas) . ']';	
			$comhttp->retorno->dados_retornados["dados"] = FuncoesJson::strtojson2($linhas);			
		}
		
		/**
			* Função para montar o resultado da pesquisa ao sinergia2
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_painel_produtos_nao_positivados(&$comhttp, $opcoes_tabela_est = null) {			
			$opcoes_tabela_est = $opcoes_tabela_est  ?? FuncoesHtml::opcoes_tabela_est;
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["visoes"])) {
				$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = "produto";
			}
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["datas"])) {
				if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"])) {
				
					$data_ini = "01/" . FuncoesData::mesNum($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]) . "/" . $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
					$data_fim = FuncoesData::UltDiaMes("01/" . FuncoesData::mesNum($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]) . "/" . $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"]);
					$data_ini_mes_ant = FuncoesData::data_primeiro_dia_mes_anterior($data_ini);
					$data_fim_mes_ant = FuncoesData::UltDiaMes($data_ini_mes_ant);
					$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = $data_ini_mes_ant . "," . $data_fim_mes_ant . "," . $data_ini . "," . $data_fim;
				} else {
					$data_ini_mes_ant = FuncoesData::data_primeiro_dia_mes_anterior();
					$data_fim_mes_ant = FuncoesData::UltDiaMes($data_ini_mes_ant);			
					$data_ini = FuncoesData::data_primeiro_dia_FuncoesData::mes_atual();
					$data_fim = FuncoesData::UltDiaMes($data_ini);
					$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = $data_ini_mes_ant . "," . $data_fim_mes_ant . "," . $data_ini . "," . $data_fim;		
				}
			}
			$ano_ini = FuncoesData::ano_atual($data_ini);
			$ano_fim = FuncoesData::ano_atual($data_fim);
			$mes_ini = FuncoesData::mes_atual($data_ini);
			$mes_fim = FuncoesData::mes_atual($data_fim);
			$mes_ini = strtolower(trim(FuncoesData::MesTexto($mes_ini)));
			$mes_fim = strtolower(trim(FuncoesData::MesTexto($mes_fim)));	
			FuncoesMontarSql::montar_sql_produtos_nao_positivados($comhttp);
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			$comhttp->requisicao->sql->comando_sql = str_replace("  "," ",$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = substr(trim($comhttp->requisicao->sql->comando_sql),0,strrpos(trim($comhttp->requisicao->sql->comando_sql)," order by"));
			$criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($_SESSION["usuariosis"],FuncoesSql::getInstancia()->obter_criterios_acesso($_SESSION["usuariosis"],"sjdobjetivossinergia"));
			$criterios_acesso = implode(" and ",$criterios_acesso);
			$condicionantes = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = " sjdobjetivossinergia.codentidade = " . $comhttp->requisicao->requisitar->qual->condicionantes["rca"]. " ";
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				$usuarios_subordinados = FuncoesSisJD::obter_usuarios_subordinados($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = " sjdobjetivossinergia.codentidade in (" . implode(",",$usuarios_subordinados) . ") ";		
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$usuarios_filial = FuncoesSisJD::obter_usuarios_filial($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = " sjdobjetivossinergia.codentidade in (" . implode(",",$usuarios_filial) . ") ";		
			} 
			$condicionantes = implode(" and ", $condicionantes);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('r.codprod as codprod','to_char(r.codprod) as codprod',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace(' from jumbo.pcprodut pcprodut',' from jumbo.pcprodut pcprodut left outer join sjdinteggrupoprod on sjdinteggrupoprod.codprod = pcprodut.codprod left outer join sjdgruposprodequiv on sjdgruposprodequiv.codgrupoprod = sjdinteggrupoprod.codgrupoprod',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('to_char(pcprodut.codprod)','to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,pcprodut.codprod))',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('to_char(pcmov.codprod)','to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,pcmov.codprod))',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('to_char(dados_vendas_origem.cd_item)','to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,dados_vendas_origem.cd_item))',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('pcprodut.descricao','nvl(sjdgruposprodequiv.nomegrupoprod,pcprodut.descricao)',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('group by to_number(pcprodut.codprod)','group by to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,pcprodut.codprod))',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('pcmov.codprod as','to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,pcmov.codprod)) as',$comhttp->requisicao->sql->comando_sql);
			//$comhttp->requisicao->sql->comando_sql = str_ireplace('where pcnfsaid.dtsaida between',' left outer join sjdinteggrupoprod on (sjdinteggrupoprod.codprod = pcmov.codprod) left outer join sjdgruposprodequiv on (sjdgruposprodequiv.codgrupoprod = sjdinteggrupoprod.codgrupoprod) where pcnfsaid.dtsaida between',$comhttp->requisicao->sql->comando_sql);
			//$comhttp->requisicao->sql->comando_sql = str_ireplace('where pcnfent.dtent between',' left outer join sjdinteggrupoprod on (sjdinteggrupoprod.codprod = pcmov.codprod) left outer join sjdgruposprodequiv on (sjdgruposprodequiv.codgrupoprod = sjdinteggrupoprod.codgrupoprod) where pcnfent.dtent between',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql = str_ireplace('dados_vendas_origem.cd_item as','to_char(nvl(sjdgruposprodequiv.codvisivelgrupo,dados_vendas_origem.cd_item)) as',$comhttp->requisicao->sql->comando_sql);
			//$comhttp->requisicao->sql->comando_sql = str_ireplace('where dados_vendas_origem.dt_emissao_nfsa',' left outer join sjdinteggrupoprod on sjdinteggrupoprod.codprod = dados_vendas_origem.cd_item left outer join sjdgruposprodequiv on sjdgruposprodequiv.codgrupoprod = sjdinteggrupoprod.codgrupoprod where dados_vendas_origem.dt_emissao_nfsa',$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql .= " 
				union all
				select 
					distinct
					sjdobjetivossinergia.coditemvisao,
					nvl(pcprodut.descricao,(select nomegrupoprod from sjdgruposprodequiv where sjdgruposprodequiv.codvisivelgrupo = sjdobjetivossinergia.coditemvisao)),
					0,
					0
				from 
					sjdobjetivossinergia 
					left outer join jumbo.pcprodut on (to_char(pcprodut.codprod) = sjdobjetivossinergia.coditemvisao)
				where
					sjdobjetivossinergia.visao='produto'
					and sjdobjetivossinergia.coditemvisao is not null
					and sjdobjetivossinergia.ano in ($ano_ini,$ano_fim)
					and lower(trim(sjdobjetivossinergia.mes)) in ('$mes_ini','$mes_fim')
					and not exists(select 1 from resultante_final r where to_char(r.codprod) = sjdobjetivossinergia.coditemvisao)
					__CRITERIOS_ACESSO__
					__CONDICIONANTES__
				 ORDER BY
					 1";
			if (strlen($criterios_acesso) > 0) {
				$comhttp->requisicao->sql->comando_sql = str_ireplace("__CRITERIOS_ACESSO__"," and " . $criterios_acesso,$comhttp->requisicao->sql->comando_sql);
			} else {
				$comhttp->requisicao->sql->comando_sql = str_ireplace("__CRITERIOS_ACESSO__","",$comhttp->requisicao->sql->comando_sql);
			}	
			if (strlen($condicionantes) > 0) {
				$comhttp->requisicao->sql->comando_sql = str_ireplace("__CONDICIONANTES__", " and " . $condicionantes,$comhttp->requisicao->sql->comando_sql);	
			} else {
				$comhttp->requisicao->sql->comando_sql = str_ireplace("__CONDICIONANTES__","" ,$comhttp->requisicao->sql->comando_sql);			
			}
			$opcoes_tabela_est["tabeladb"]="produtosnaopositivados";
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ocultarcolunas"]["ativo"] = false;
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			//$comhttp->retorno->dados_retornados["dados"]=FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);


			/*obtem da tabela valores por entidade */
			/*if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mes"])) {
				$mes1 = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
				$mes_num = FuncoesData::MesNum($mes1);
				$dtini = '01/'.$mes_num . '/' . FuncoesData::ano_atual();
				$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);									
			} else {
				$dtini = FuncoesData::data_primeiro_dia_mes_atual();
				$dtfim = FuncoesData::data_ultimo_dia_mes_atual();
			}
			$datas = [$dtini,$dtfim];
			$mes1 = substr(FuncoesData::mesTexto(FuncoesData::mes_atual($dtini)),0,3);*/
			$codsusuariosacessiveis = FuncoesSisJD::obter_cods_rcas_acessiveis();				


			/*monta as condicionantes conforme o filtro que vier do painel*/
			$condicionantes = [];
			$condicionantes[] = "codentidade in (".implode(",",$codsusuariosacessiveis).")";
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"]) && $comhttp->requisicao->requisitar->qual->condicionantes["rca"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["rca"])>0
			) {
				$condicionantes[] = "codentidade = " .$comhttp->requisicao->requisitar->qual->condicionantes["rca"];
			} 
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]) && $comhttp->requisicao->requisitar->qual->condicionantes["supervisor"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])>0
			) {
				$codsusuariossuperv = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);				
				$condicionantes[] = "codentidade in (".implode(",",$codsusuariossuperv).")";
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"]) && $comhttp->requisicao->requisitar->qual->condicionantes["filial"] !== null
				&& strlen($comhttp->requisicao->requisitar->qual->condicionantes["filial"])>0
			) {
				$codsusuariosfilial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);				
				$condicionantes[] = "codentidade in (".implode(",",$codsusuariosfilial).")";
			}
			$params_valores_por_entidade = [
				"agregacao"=>"",
				"campo"=>"dadosclob",
				"entidade"=>"rca",
				"condicionantes" => implode(" and ",$condicionantes),
				"nomevalor"=>"produtos_naoposit_mes",
				"dtini"=>$data_ini,
				"dtfim"=>$data_fim		
			];

			$cmd_sql = FuncoesMontarSql::montar_sql_valores_por_entidade($params_valores_por_entidade);	
			$params_sql = [
				"query"=>$cmd_sql
			];
			$cursor = FuncoesSql::getInstancia()->executar_sql($params_sql);
			$linhas = [];
			$novas_linhas = [];
			$nova_linha = [];
			while($linha = $cursor["result"]->fetch(\PDO::FETCH_COLUMN,0)) {
				if (in_array(gettype($linha),["object","resource"])) {
					$linha = stream_get_contents($linha);
				}
				$linha = FuncoesJson::strtojson2($linha); 
				/*cria novas linhas cujos indices dos produtos contidos sao o próprio cod do produto e converte valores para numero*/
				$nova_linha = [];
				foreach($linha as $prod) {
					$nova_linha[$prod["codprod"]] = $prod;
					$nova_linha[$prod["codprod"]]["pesototal_0"] = FuncoesConversao::como_numero($nova_linha[$prod["codprod"]]["pesototal_0"]);
					$nova_linha[$prod["codprod"]]["pesototal_1"] = FuncoesConversao::como_numero($nova_linha[$prod["codprod"]]["pesototal_1"]);
				}
				$novas_linhas[] = $nova_linha;
				
			}
			FuncoesSql::getInstancia()->fechar_cursor($cursor);

			/*cria o array de produtos, somando os valores caso o produto apareça em mais de uma linha*/
			foreach($novas_linhas as $linha) {
				foreach($linha as $chave => $prod) {
					if (!isset($prods[$chave])) {
						$prods[$chave] = $prod;
					} else {
						$prods[$chave]["pesototal_0"] += $prod["pesototal_0"];
						$prods[$chave]["pesototal_1"] += $prod["pesototal_1"];
					}
				}
			}

			/*retifica o array de produtos excluindo produtos que positivaram (pesototal_1>0 || pesototal_0<0)*/
			foreach($prods as $chave => &$prod) {
				if ($prod["pesototal_1"] > 0 || $prod["pesototal_0"] < 0) {
					unset($prods[$chave]);
				} else {
					$prod["pesototal_0"] = number_format($prod["pesototal_0"],2,",",".");
				}
			}

			$comhttp->retorno->dados_retornados["dados"] = $prods;
		}
		

		/**
			* Função para montar o resultado da pesquisa ao sinergia2
			* @param TComHttp $comhttp o pacote de comunicacao padrao
			* @return string $texto_retorno a tabela html com os dados
		*/	
		public static function montar_consulta_itens_camp_giro(&$comhttp){
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["cabecalho"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"]=true;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"]=true;
			$opcoes_tabela_est["subregistros"]["ativo"] = false;
			$opcoes_tabela_est["rodape"]["ativo"] = false;
			$opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"] = [
			[
				"valor"=>"RCA",
				"cod"=>0,
				"codsup"=>-1,
				"indexreal"=>0,
				"linha"=>0,
				"coluna"=>0,
				"rowspan"=>1,
				"colspan"=>1,
				"codligcamposis"=>null
			],[
				"valor"=>"CODRCA",
				"texto"=>"CODRCA",
				"cod"=>1,
				"codsup"=>0,
				"indexreal"=>0,
				"linha"=>1,
				"coluna"=>0,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Nao Positivados",
				"cod"=>2,
				"codsup"=>-1,
				"indexreal"=>1,
				"linha"=>0,
				"coluna"=>1,
				"rowspan"=>1,
				"colspan"=>3
			],[
				"valor"=>"Giro",
				"texto"=>"Giro",
				"cod"=>3,
				"codsup"=>2,
				"indexreal"=>1,
				"linha"=>1,
				"coluna"=>1,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Industr",
				"texto"=>"Industr",
				"cod"=>4,
				"codsup"=>2,
				"indexreal"=>2,
				"linha"=>1,
				"coluna"=>2,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Jumbo",
				"texto"=>"Jumbo",
				"cod"=>5,
				"codsup"=>2,
				"indexreal"=>3,
				"linha"=>1,
				"coluna"=>3,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Positivados sem Bater",
				"cod"=>6,
				"codsup"=>-1,
				"indexreal"=>4,
				"linha"=>0,
				"coluna"=>4,
				"rowspan"=>1,
				"colspan"=>3
			],[
				"valor"=>"Giro",
				"texto"=>"Giro",
				"cod"=>7,
				"codsup"=>6,
				"indexreal"=>4,
				"linha"=>1,
				"coluna"=>4,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Industr",
				"texto"=>"Industr",
				"cod"=>8,
				"codsup"=>6,
				"indexreal"=>5,
				"linha"=>1,
				"coluna"=>5,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Jumbo",
				"texto"=>"Jumbo",
				"cod"=>9,
				"codsup"=>6,
				"indexreal"=>6,
				"linha"=>1,
				"coluna"=>6,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Batidos",
				"cod"=>10,
				"codsup"=>-1,
				"indexreal"=>7,
				"linha"=>0,
				"coluna"=>7,
				"rowspan"=>1,
				"colspan"=>3
			],[
				"valor"=>"Giro",
				"texto"=>"Giro",
				"cod"=>11,
				"codsup"=>10,
				"indexreal"=>7,
				"linha"=>1,
				"coluna"=>7,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Industr",
				"texto"=>"Industr",
				"cod"=>12,
				"codsup"=>10,
				"indexreal"=>8,
				"linha"=>1,
				"coluna"=>8,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Jumbo",
				"texto"=>"Jumbo",
				"cod"=>13,
				"codsup"=>10,
				"indexreal"=>9,
				"linha"=>1,
				"coluna"=>9,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			],[
				"valor"=>"Clientes",
				"cod"=>14,
				"codsup"=>-1,
				"indexreal"=>10,
				"linha"=>0,
				"coluna"=>10,
				"rowspan"=>1,
				"colspan"=>1
			],[
				"valor"=>"NAO POSIT",
				"texto"=>"NAO POSIT",
				"cod"=>15,
				"codsup"=>14,
				"indexreal"=>10,
				"linha"=>1,
				"coluna"=>10,
				"rowspan"=>1,
				"colspan"=>1,
				"formatacao"=>"cel_numint",
				"codligcamposis"=>null
			]];	
			$usuariosis = [];
			$usuariosis = FuncoesSql::getInstancia()->obter_usuario_sis(["condic" => $_SESSION["codusur"],"unico"=>true]);
			if (count($usuariosis) <= 0) {
				FuncoesBasicasRetorno::mostrar_msg_sair("usuario nao encontrado", __FILE__,__FUNCTION__,__LINE__);
			}
			$comando_sql = "";
			
			/*monta as datas conforme periodos escolhidos pelo usuario*/
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			$data_periodo1_posit = FuncoesData::data_primeiro_dia_mes_anterior($data_periodo1);
			$data_periodo2_posit = FuncoesData::data_ultimo_dia_mes_anterior($data_periodo1);
			$data_periodo1_posit = FuncoesData::data_primeiro_dia_mes_anterior($data_periodo1_posit); //60 DIAS COMO FELIPE PEDIU
			$data_periodo1_naoposit = $data_periodo1;
			$data_periodo2_naoposit = FuncoesData::data_ultimo_dia_mes_atual($data_periodo1_naoposit);
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->requisitar->oque = "dados_sql";
			$comhttp_temp->requisicao->requisitar->qual->comando = "consultar";
			$comhttp_temp->requisicao->requisitar->qual->tipo_objeto = "visao";
			$comhttp_temp->requisicao->requisitar->qual->objeto = "Cliente,Rca";
			$comhttp_temp->requisicao->requisitar->qual->condicionantes = [
				"tipo_dados" => "tabelaest",
				"relatorio" => "clientesnaopositivados",
				"visoes" => "Cliente,Rca",
				"datas" => "$data_periodo1_posit,$data_periodo2_posit,$data_periodo1_naoposit,$data_periodo2_naoposit",
				"dtini" => "$data_periodo1_posit",
				"dtfim" => "$data_periodo2_posit",
				"mostrar_vals_de" => 1,
				"usar_arr_tit" => false
			];
			
			FuncoesMontarSql::montar_sql_clientes_nao_positivados($comhttp_temp);
			
			/*prepara as condicionantes para serem usadas caso tenham sido passadas no filtro*/
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			$nometabela_objetivos = "sjdobjetivossinergia";
			$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
			$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
			$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);	
			$comhttp->requisicao->sql->comando_sql = $comhttp_temp->requisicao->sql->comando_sql;
			$comhttp->requisicao->sql->comando_sql = trim(str_ireplace("  "," ",$comhttp->requisicao->sql->comando_sql));
			$comhttp->requisicao->sql->comando_sql = str_ireplace(") select * from resultante_final order","),resultantefinal as (select * from resultante_final order",$comhttp->requisicao->sql->comando_sql) . ") ";
			$comhttp->requisicao->sql->comando_sql  .= "
		SELECT
			sjdobjetivossinergia.codentidade,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 1
						 AND nvl(sjdobjetivossinergia.realizado, 0) <= 0 THEN
						1
					ELSE
						NULL
				END
			) AS naopositgiro,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 2
						 AND nvl(sjdobjetivossinergia.realizado, 0) <= 0 THEN
						1
					ELSE
						NULL
				END
			) AS naopositindustr,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 3
						 AND nvl(sjdobjetivossinergia.realizado, 0) <= 0 THEN
						1
					ELSE
						NULL
				END
			) AS naopositjumbo,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 1
						 AND nvl(sjdobjetivossinergia.realizado, 0) > 0
						 AND nvl(sjdobjetivossinergia.realizado, 0) < nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS positgiro,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 2
						 AND nvl(sjdobjetivossinergia.realizado, 0) > 0
						 AND nvl(sjdobjetivossinergia.realizado, 0) < nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS positindustr,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 3
						 AND nvl(sjdobjetivossinergia.realizado, 0) > 0
						 AND nvl(sjdobjetivossinergia.realizado, 0) < nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS positjumbo,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 1
						 AND nvl(sjdobjetivossinergia.realizado, 0) >= nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS batidosgiro,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 2
						 AND nvl(sjdobjetivossinergia.realizado, 0) >= nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS batidosindustr,
			COUNT(
				CASE
					WHEN sjdobjetivossinergia.codgrupogiro = 3
						 AND nvl(sjdobjetivossinergia.realizado, 0) >= nvl(sjdobjetivossinergia.valor, 0) THEN
						1
					ELSE
						NULL
				END
			) AS batidosjumbo,
			(select count(1) from resultantefinal rf where rf.codusuariosis = sjdobjetivossinergia.codentidade) as clientes_naoposit
		FROM
			sjdobjetivossinergia     
			LEFT OUTER JOIN sjdgruposgiro   g ON ( g.codgrupogiro = sjdobjetivossinergia.codgrupogiro )
		WHERE
			to_date('01/'||sjdpkg_funcs_data.mes_numero(sjdobjetivossinergia.MES) || '/' || sjdobjetivossinergia.ano,'dd/mm/yyyy')
				between
					to_date('01/'||sjdpkg_funcs_data.mes_numero('$mes_periodo1')||'$ano_periodo1','dd/mm/yyyy') 
					AND LAST_DAY(to_date('01/'||sjdpkg_funcs_data.mes_numero('$mes_periodo2')||'$ano_periodo2','dd/mm/yyyy'))     
			AND sjdobjetivossinergia.codcampanhasinergia = 0
			AND lower(TRIM(sjdobjetivossinergia.entidade)) = 'rca'
			AND lower(TRIM(sjdobjetivossinergia.visao)) = 'produto'
			AND lower(TRIM(sjdobjetivossinergia.unidade)) = 'kg'
		GROUP BY
			sjdobjetivossinergia.codentidade
		ORDER BY
			10 DESC,
			9 DESC,
			8 DESC
			";
			
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			FuncoesHtml::montar_retorno_tabdados($comhttp);
		}

		public static function montar_consulta_clientesativosxpositivados(&$comhttp){
			/*monta as datas conforme periodos escolhidos pelo usuario*/
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"])) {
				$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
				$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
				$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
				$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
				$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
				$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
				$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			} else {
				$data_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["dtini"];
				$data_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["dtfim"];
			}
			$comhttp->requisicao->sql->comando_sql = FuncoesMontarSql::montar_sql_clientesativosxpositivados($comhttp);
			
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["usar_arr_tit"] = true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["aoabrir"] = "window.fnsisjd.pesquisar_sub_registro_clientes_ativosxposit(this)";
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["propriedades_html"]["visao"] = "rca";
			$opcoes_tabela_est["propriedades_html"]["filtro_filial"] = (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])?$comhttp->requisicao->requisitar->qual->condicionantes["filial"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_supervisor"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])?$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_rca"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])?$comhttp->requisicao->requisitar->qual->condicionantes["rca"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo1"] =  $mes_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo1"] =  $ano_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo2"] =  $mes_periodo2; 
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo2"] =  $ano_periodo2;
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$opcoes_tabela_est["tabeladb"]="clientesativosnaopositivados";
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			FuncoesSisJD::obter_sql_dados_arr_tit($comhttp);
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);
		}
		
		public static function montar_consulta_clientesativosxpositivados_subregistros(&$comhttp){
			/*monta as datas conforme periodos escolhidos pelo usuario*/
			$mes_periodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mes_periodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$ano_periodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$ano_periodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];	
			$data_periodo1 = "01/" . FuncoesData::MesNum($mes_periodo1) . "/" . $ano_periodo1;
			$data_periodo2 = "01/" . FuncoesData::MesNum($mes_periodo2) . "/" . $ano_periodo2;
			$data_periodo2 = FuncoesData::UltDiaMes($data_periodo2);
			$condicionantes = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				if ($rcas_filial !== null && count($rcas_filial) > 0) {
					$condicionantes[] = "u.codusur in (".implode(",",$rcas_filial).")";
				} else {
					$condicionantes[] = "u.codusur in (-1)";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				$rcas_supervisor = FuncoesSisJD::obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);		
				if ($rcas_supervisor !== null && count($rcas_supervisor) > 0) {
					$condicionantes[] = "u.codusur in (".implode(",",$rcas_supervisor).")";
				} else {
					$condicionantes[] = "u.codusur in (-1)";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes[] = "u.codusur in (".$comhttp->requisicao->requisitar->qual->condicionantes["rca"].")";
			}
			if ($_SESSION["usuariosis"]["podever"] === "PADRAO") {
				if (intval($_SESSION["usuariosis"]["codnivelacesso"]) >= 30) {
					$condicionantes[] = "u.codfilial = " . $_SESSION["usuariosis"]["codfilial"];
				} 
				if (intval($_SESSION["usuariosis"]["codnivelacesso"]) === 50) {
					$condicionantes[] = "u.codusur = " . $_SESSION["usuariosis"]["codusuariosis"];
				} 
			}
			$condicionantes = trim(implode(" and ",$condicionantes));
			$comando_sql = "
		WITH clientes_jumbo_ativ AS (
			SELECT
				c.codusur1,
				c.codcli,
				c.cliente,
				c.fantasia,
				CASE
					WHEN EXISTS (
						SELECT
							1
						FROM
							jumbo.pcnfsaid s
						WHERE
							s.codcli = c.codcli
							AND s.dtsaida BETWEEN '$data_periodo1' AND '$data_periodo2'
							AND s.dtcancel IS NULL
							AND s.especie = 'NF'
							AND s.codcob NOT IN (
								'BNF',
								'BNFT'
							)
					) THEN
						'SIM'
					ELSE
						'NAO'
				END AS positivou_jumbo,
				CASE
					WHEN EXISTS (
						SELECT
							1
						FROM
							dados_vendas_origem s
						WHERE
							to_number(regexp_replace(s.cgc_destino,'[^0-9]+','')) = to_number(regexp_replace(c.cgcent,'[^0-9]+',''))
							AND s.dt_emissao_nfsa BETWEEN '$data_periodo1' AND '$data_periodo2'
							AND s.qtde_liquida_item > 0
					) THEN
						'SIM'
					ELSE
						'NAO'
				END AS positivou_aurora,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
				c.limcred,
				c.bloqueio
			FROM
				jumbo.pcclient                c
				join jumbo.pcusuari u on (u.codusur = c.codusur1 or u.codusur = c.codusur2)
				LEFT OUTER JOIN (
					sjdcliente_origem ca
					JOIN sjdpessoa_origem po ON ( ca.codpessoaorigem = po.codpessoa )
				) ON ( to_number(regexp_replace(po.numcnpjcpf, '[^0-9]+', '')) = to_number(regexp_replace(c.cgcent, '[^0-9]+', '')) )
			WHERE
				c.dtexclusao IS NULL
				AND c.codusur1 != 150
				AND c.codcli NOT IN (
					13519,
					13363,
					2848,
					1919,
					3829
				)  
				 ".(strlen(trim($condicionantes)) > 0?" and " . $condicionantes:"")."               
			ORDER BY
				limcred DESC,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) DESC
		), clientes_aurora_ativ AS (
			SELECT
				nvl(c.codusur1, ca.codvendedororigem) AS cdusur1,
				nvl(c.codcli, po.numcnpjcpf) AS codcli,
				nvl(c.cliente, po.nomerazao) AS cliente,
				nvl(c.fantasia, po.fantasia) AS fantasia,
				'NAO' AS positivou_jumbo,
				CASE
					WHEN EXISTS (
						SELECT
							1
						FROM
							dados_vendas_origem s
						WHERE
							to_number(regexp_replace(s.cgc_destino,'[^0-9]+','')) = to_number(regexp_replace(po.numcnpjcpf,'[^0-9]+',''))
							AND s.dt_emissao_nfsa BETWEEN '$data_periodo1' AND '$data_periodo2'
							AND s.qtde_liquida_item > 0
					) THEN
						'SIM'
					ELSE
						'NAO'
				END AS positivou_aurora,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
				nvl(c.limcred, 0) AS limcred,
				nvl(c.bloqueio, 'N') AS bloqueio
			FROM
				" . VariaveisSql::getInstancia()->getPrefixObjects() . "cliente_origem   ca
				join " . VariaveisSql::getInstancia()->getPrefixObjects() . "pessoa_origem   po on (po.codpessoa = ca.codpessoaorigem)
				join jumbo.pcusuari u on (u.codusur = ca.codvendedororigem)
				LEFT OUTER JOIN jumbo.pcclient                c ON (to_number(regexp_replace(po.numcnpjcpf,'[^0-9]+','')) = to_number(regexp_replace(c.cgcent,'[^0-9]+','')))
			WHERE
				c.dtexclusao IS NULL
				AND nvl(c.codusur1, ca.codvendedororigem) != 150
				and c.codcli is null
				 ".(strlen(trim($condicionantes)) > 0?" and " . $condicionantes:"")."               
			ORDER BY
				limcred DESC,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) DESC
		), clientes_juntos_ativ AS (
			SELECT
				*
			FROM
				clientes_jumbo_ativ
			UNION ALL
			SELECT
				*
			FROM
				clientes_aurora_ativ
		), res_cli_ativos AS (
			SELECT
				codusur1,
				codcli,
				cliente,
				fantasia,
				positivou_jumbo AS positivou_jumbo,
				positivou_aurora AS positivou_aurora,
				decode(positivou_jumbo,'SIM','SIM',decode(positivou_aurora,'SIM','SIM','NAO')) as positivou,
				MAX(dtultcomp) AS dtultcomp,
				limcred,
				bloqueio
			FROM
				clientes_juntos_ativ
			GROUP BY
				codusur1,
				codcli,
				cliente,
				fantasia,
				positivou_jumbo,
				positivou_aurora,
				limcred,
				bloqueio
		)
		SELECT
			*
		FROM
			res_cli_ativos 
		order by 7 desc";
			$comhttp->requisicao->sql->comando_sql = $comando_sql;
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["usar_arr_tit"] = true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["subregistros"]["ativo"] = false;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["propriedades_html"]["visao"] = "cliente";
			$opcoes_tabela_est["propriedades_html"]["filtro_filial"] = (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])?$comhttp->requisicao->requisitar->qual->condicionantes["filial"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_supervisor"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])?$comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_rca"] =  (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])?$comhttp->requisicao->requisitar->qual->condicionantes["rca"]:null);
			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo1"] =  $mes_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo1"] =  $ano_periodo1;
			$opcoes_tabela_est["propriedades_html"]["filtro_mes_periodo2"] =  $mes_periodo2; 
			$opcoes_tabela_est["propriedades_html"]["filtro_ano_periodo2"] =  $ano_periodo2;
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			FuncoesHtml::montar_retorno_tabdados($comhttp);
            /*$comhttp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$comhttp->retorno->dados_retornados["conteudo_html"] = FuncoesHtml::montar_tabela_est_html($comhttp,$opcoes_tabela_est);
			return $comhttp->retorno->dados_retornados["conteudo_html"];*/
		}

		public static function consulta_ratings_focais(&$comhttp){		
			$comhttp->opcoes_retorno["usar_arr_tit"] = true;
			FuncoesMontarSql::montar_sql_consulta_relatorio_ratings_focais($comhttp);
			$opcoes_tabela_est=FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["cabecalho"]["filtro"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["ordenacao"]["ativo"] = true;
			$opcoes_tabela_est["cabecalho"]["comandos"]["ativo"] = true;
			$opcoes_tabela_est["tabeladb"]="consultar_ratingsfocais";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_botoes"] = "pequeno";
			$opcoes_tabela_est["cabecalho"]["comandos"]["classe_imgs"] = "pequeno";
			$comhttp->requisicao->requisitar->qual->condicionantes["opcoes_tabela_est"] = $opcoes_tabela_est;
			FuncoesSisJD::obter_sql_dados_arr_tit($comhttp);
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
			$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = FuncoesHtml::montar_propriedades_tabdados($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = FuncoesHtml::montar_linhas_tit_tabela_est_html($comhttp,false);
			$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = FuncoesHtml::montar_rodape_tabela_est_html($comhttp,false);
		}

		/**
		 * Funcao para ser chamada na parte final de obtencao de dados sql
		 */
		public static function montar_retorno_dados_sqlws(&$comhttp,$params_sql=[]){			
			
			/*define valores padrao ou recebidos*/
			$params_sql["query"] = $params_sql["query"] ?? $comhttp->requisicao->sql->comando_sql;
			$params_sql["fetch"] = $params_sql["fetch"] ?? "fetchAll";
			$params_sql["fetch_mode"] = $params_sql["fetch_mode"] ?? \PDO::FETCH_ASSOC;
			$params_sql["retornar_resultset"] = FuncoesConversao::como_boleano($params_sql["retornar_resultset"] ?? false);			
			
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = FuncoesConversao::como_boleano($comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] ?? true);
			$atribuir_fields = false;

			/*decide se vai retornar result set em funcao de ter ou nao arr_tit*/
			if ($comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] === true) {
				if (!(
					isset($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) 
					&& $comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] !== null
					&& gettype($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) === "array" 
					&& count($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"]) > 0
				)) {					
					$params_sql["retornar_resultset"] = true;
					$atribuir_fields = true;
				}
			} else {
				$params_sql["retornar_resultset"] = true;
				$atribuir_fields = true;				
			}

			/*executa sql e monta o retorno*/
			$retornar_resultset = $params_sql["retornar_resultset"]; //se nao retornar resultset, essa variavel se perde
			$resultset = FuncoesSql::getInstancia()->executar_sql($params_sql);
			if ($retornar_resultset === true) {
				$comhttp->retorno->dados_retornados["dados"] = [
					"tabela"=>[
						"dados"=>$params_sql["data"]
					]
				];
				if ($atribuir_fields === true) {
					$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $params_sql["fields"];
					$comhttp->retorno->dados_retornados["dados"]["tabela"]["titulo"] = $params_sql["fields"];
				} 
				FuncoesSql::getInstancia()->fechar_cursor($resultset);
			} else {
				$comhttp->retorno->dados_retornados["dados"] = [
					"tabela"=>[
						"dados"=>$resultset
					]
				];
			}	
			//$comhttp->retorno->dados_retornados["conteudo_html"]["props"] = self::montar_propriedades_tabdados($comhttp,false);
			//$comhttp->retorno->dados_retornados["conteudo_html"]["cabecalho"] = self::montar_linhas_tit_tabela_est_html($comhttp,false);
			//$comhttp->retorno->dados_retornados["conteudo_html"]["rodape"] = self::montar_rodape_tabela_est_html($comhttp,false);			
		}
	}
?>