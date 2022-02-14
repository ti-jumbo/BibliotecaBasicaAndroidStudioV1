<?php
	namespace SJD\php\classes\funcoes;	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			constantes\Constantes,
			variaveis\VariaveisSql,
			sql\TSql
		};
	use SJD\php\classes\funcoes\{
			FuncoesIniciais,
			FuncoesSql,
			FuncoesData,
			FuncoesArquivo,
			FuncoesArray,
			FuncoesConversao,
			FuncoesHtml,			
			FuncoesString,
			FuncoesProcessoSql,
			requisicao\FuncoesBasicasRetorno,
			requisicao\FuncoesRequisicao,
		};
	use SJD\php\classes\{
			constantes\Constantes as ConstantesSis,
			funcoes\FuncoesSisJD,
			funcoes\FuncoesMontarSql
		};
		
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	/*codigo*/
	class FuncoesMontarSql extends ClasseBase {		
		public static function montar_sql_campanhas_estruturadas_objetivos_gerais(&$comhttp){
			/*Objetivo: montar o sql do sinergia*/
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->sql = new TSql();
			$comhttp_temp->requisicao->requisitar->qual->objeto = "linha campanha";
			$comhttp_temp->requisicao->requisitar->qual->condicionantes = ["condicionantestab"=>"sjdcampestr[sjdcampestr.codcampestr=" . $comhttp->requisicao->requisitar->qual->condicionantes["codcampestr"]."]"];
			$comhttp_temp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp,"linha");
			$comhttp_temp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$campanha = $comhttp_temp->retorno->dados_retornados["dados"];
			$visao_campanha = $campanha["tabela"]["dados"][0][3]; 
			$comhttp_temp2 = new TComHttp();
			$comhttp_temp2->requisicao->sql = new TSql();
			$comhttp_temp2->requisicao->requisitar->qual->objeto = "lista campanhas objetivos";
			$comhttp_temp2->requisicao->requisitar->qual->condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes;
			$comhttp_temp2->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp2,"lista");
			$comhttp_temp2->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp2->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$objetivos_gerais = $comhttp_temp2->retorno->dados_retornados["dados"];
			$cnj_mostrar_vals_de = ["qt","un","kgun","kg","r\$un","r\$","mix"];
			$comhttp_temp2->retorno->dados_retornados["dados"]["tabela"]["titulo"]["arr_tit"][] = [
				"cod" => 7,
				"codsup" => -1,
				"valor" => "observado",
				"linha" => 0,
				"coluna" => 7,
				"indexreal" => 7
			];
			foreach($objetivos_gerais["tabela"]["dados"] as $chave_lin=>$linha) {		
				$datas = [$linha[5],$linha[6]];
				$unidade = strtolower(trim($linha[3]));
				$mostrar_vals_de = array_search($unidade,$cnj_mostrar_vals_de);
				$comhttp_temp3 = new TComHttp();
				$comhttp_temp3->requisicao->sql = new TSql();
				$comhttp_temp3->requisicao->requisitar->qual->objeto = $visao_campanha;
				$comhttp_temp3->requisicao->requisitar->qual->condicionantes["datas"]=implode(",",$datas);
				$comhttp_temp3->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = $mostrar_vals_de;
				$comhttp_temp3->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp3,"relatorio_venda");
				$comhttp_temp3->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp3->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
				$observado = 0;
				$linhas = $comhttp_temp3->retorno->dados_retornados["dados"]["tabela"]["dados"];			
				if ($unidade !== "mix") {			
					foreach($linhas as $linha) {
						$ind_ult_cel = count($linha) - 1;
						$valor = str_replace(",",".",str_replace(".","",trim($linha[$ind_ult_cel]))) * 1;	
						$observado += $valor;
					}
					echo $observado;exit();
				} else {
					$observado = count($linhas); 
				}
				$comhttp_temp2->retorno->dados_retornados["dados"]["tabela"]["dados"][$chave_lin][7] = $observado;
			}
			$retorno = "";
			return $retorno;
		}
		public static function montar_sql_cispe(&$comhttp){
			/*Objetivo: montar o sql do relatorio cispe*/
			$comhttp->requisicao->sql->comando_sql="";
			$comhttp->requisicao->sql->comando_sql.="WITH rcas_cidade_bairro
		 AS (SELECT DISTINCT ' '||u.codusur||' '     AS rca,
							 ci.nomecidade AS cidade,
							 C.bairroent   AS bairro
			 FROM   jumbo.pcmov m,
					jumbo.pcusuari u,
					jumbo.pcclient C,
					jumbo.pccidade ci
			 WHERE  m.dtmov BETWEEN '01/'||to_char(add_months(sysdate,-6),'MM/YYYY') AND last_day(sysdate)
					AND m.codfiscal IN ( 5102, 5405, 5910, 6102,6404, 6910 )
					AND Nvl(m.codusur, 0) <> 0
					AND m.codcli = c.codcli(+)
					AND m.codusur = u.codusur(+)
					AND c.codcidade = ci.codcidade(+)),
		 rcas_cidade
		 AS (SELECT DISTINCT ' '||u.codusur||' '     AS rca,
							 ci.nomecidade AS cidade
			 FROM   jumbo.pcmov m,
					jumbo.pcusuari u,
					jumbo.pcclient C,
					jumbo.pccidade ci
			 WHERE  m.dtmov BETWEEN '01/'||to_char(add_months(sysdate,-6),'MM/YYYY') AND last_day(sysdate)
					AND m.codfiscal IN ( 5102, 5405, 5910, 6102,6404, 6910 )
					AND Nvl(m.codusur, 0) <> 0
					AND m.codcli = c.codcli(+)
					AND m.codusur = u.codusur(+)
					AND c.codcidade = ci.codcidade(+)),
		 mov
		 AS (SELECT To_number(Replace(Replace(Replace(Nvl(c.cgcent, 0), '/'), '-'), '.')) AS cnpj,
					SUM(nvl(nvl(m.qt,m.qtcont),0)) - sum(nvl(m.qtdevol,0))                                                               AS qt
			 FROM   jumbo.pcmov m,
					jumbo.pcclient c
			 WHERE  m.dtmov BETWEEN '".$comhttp->requisicao->requisitar->qual->condicionantes["dtini"]."' and '".$comhttp->requisicao->requisitar->qual->condicionantes["dtfim"]."'
					AND m.codfiscal IN ( 5102, 5405, 5910, 6102,6404, 6910 )
					AND Nvl(m.codusur, 0) <> 0
					AND m.codcli = c.codcli(+)
			 GROUP  BY c.cgcent),
		 mova
		 AS (SELECT To_number(Replace(Replace(Replace(Nvl(a.cgc_destino, 0), '/'), '-'), '.')) AS cnpj,
					SUM(a.peso_liquido_item)                                                   AS qt
			 FROM   dados_vendas_origem a
			 WHERE  a.dt_emissao_nfsa BETWEEN '".$comhttp->requisicao->requisitar->qual->condicionantes["dtini"]."' and '".$comhttp->requisicao->requisitar->qual->condicionantes["dtfim"]."'
					AND nvl(a.vendedor,0)<>0
			 GROUP  BY a.cgc_destino),
		 cnpjs_aurora
		 AS (SELECT DISTINCT To_number(Replace(Replace(Replace(Nvl(a.cgc_destino, 0), '/'), '-'), '.')) AS cnpj
			 FROM   dados_vendas_origem a),
		 cnpjs_jumbo
		 AS (SELECT DISTINCT To_number(Replace(Replace(Replace(Nvl(c.cgcent, 0), '/'), '-'), '.')) AS cnpj
			 FROM   jumbo.pcclient c),
		resultante as (SELECT DISTINCT Nvl((SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade_bairro r WHERE  r.cidade = m.cidade AND r.bairro = m.bairro), 
						(SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade r WHERE  r.cidade = m.cidade)) AS RCAs,
					'Cascavel'                                                          AS OrigemCispe,
					Decode(Nvl(c.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseJumbo,
					Decode(Nvl(mv.qt, 0), 0, 'NAO','SIM')                               AS PositivadoJumbo,
					Decode(Nvl(a.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseAurora,
					Decode(Nvl(mva.qt, 0), 0, 'NAO','SIM')                              AS PositivadoAurora,
					m.cnpj                                                              AS CNPJ,
					m.nome_fantasia                                                     AS \"RAZAO SOCIAL\",
					m.endereco                                                          AS \"ENDERECO\",
					m.bairro                                                            AS BAIRRO,
					m.cep                                                               AS CEP,
					m.cidade                                                            AS CIDADE,
					To_char(m.data_fundacao)                                            AS \"DATA FUNDACAO\",
					to_char(m.codigo_cnae) AS \"CODCNAE\",
					m.descricao_cnae                                                    AS \"DESC. CNAE\",
					m.descricao_segmento as \"DESC. SEGM\",
					m.cliente_origem                                                    AS \"CLIENTE AURORA\",
					m.latitude                                                          AS LATITUDE,
					m.longitude                                                         AS LONGITUDE
			FROM   cispe_cascavel m,
		   cnpjs_jumbo c,
		   cnpjs_aurora a,
		   mov mv,
		   mova mva
			WHERE  Nvl(m.cnpj, 0) <> 0
		   AND To_number(m.cnpj) = To_number(c.cnpj(+))
		   AND To_number(m.cnpj) = To_number(a.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mv.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mva.cnpj(+)) 
			UNION ALL
			SELECT DISTINCT Nvl((SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade_bairro r WHERE  r.cidade = m.cidade AND r.bairro = m.bairro), 
						(SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade r WHERE  r.cidade = m.cidade)) AS RCAs,
					'Londrina'                                                          AS OrigemCispe,
					Decode(Nvl(c.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseJumbo,
					Decode(Nvl(mv.qt, 0), 0, 'NAO','SIM')                               AS PositivadoJumbo,
					Decode(Nvl(a.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseAurora,
					Decode(Nvl(mva.qt, 0), 0, 'NAO','SIM')                              AS PositivadoAurora,
					m.cnpj                                                              AS CNPJ,
					m.nome_fantasia                                                     AS \"RAZAO SOCIAL\",
					m.endereco                                                          AS \"ENDERECO\",
					m.bairro                                                            AS BAIRRO,
					m.cep                                                               AS CEP,
					m.cidade                                                            AS CIDADE,
					To_char(m.data_fundacao)                                            AS \"DATA FUNDACAO\",
					to_char(m.codigo_cnae) AS \"CODCNAE\",
					m.descricao_cnae                                                    AS \"DESC. CNAE\",
					m.descricao_segmento as \"DESC. SEGM\",
					m.cliente_origem                                                    AS \"CLIENTE AURORA\",
					m.latitude                                                          AS LATITUDE,
					m.longitude                                                         AS LONGITUDE
			FROM   cispe_londrina m,
		   cnpjs_jumbo c,
		   cnpjs_aurora a,
		   mov mv,
		   mova mva
			WHERE  Nvl(m.cnpj, 0) <> 0
		   AND To_number(m.cnpj) = To_number(c.cnpj(+))
		   AND To_number(m.cnpj) = To_number(a.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mv.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mva.cnpj(+)) 
			UNION ALL
			SELECT DISTINCT Nvl((SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade_bairro r WHERE  r.cidade = m.cidade AND r.bairro = m.bairro), 
						(SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade r WHERE  r.cidade = m.cidade)) AS RCAs,
					'Maringa'                                                          AS OrigemCispe,
					Decode(Nvl(c.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseJumbo,
					Decode(Nvl(mv.qt, 0), 0, 'NAO','SIM')                               AS PositivadoJumbo,
					Decode(Nvl(a.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseAurora,
					Decode(Nvl(mva.qt, 0), 0, 'NAO','SIM')                              AS PositivadoAurora,
					m.cnpj                                                              AS CNPJ,
					m.nome_fantasia                                                     AS \"RAZAO SOCIAL\",
					m.endereco                                                          AS \"ENDERECO\",
					m.bairro                                                            AS BAIRRO,
					m.cep                                                               AS CEP,
					m.cidade                                                            AS CIDADE,
					To_char(m.data_fundacao)                                            AS \"DATA FUNDACAO\",
					to_char(m.codigo_cnae) AS \"CODCNAE\",
					m.descricao_cnae                                                    AS \"DESC. CNAE\",
					m.descricao_segmento as \"DESC. SEGM\",
					m.cliente_origem                                                    AS \"CLIENTE AURORA\",
					m.latitude                                                          AS LATITUDE,
					m.longitude                                                         AS LONGITUDE
			FROM   cispe_maringa m,
		   cnpjs_jumbo c,
		   cnpjs_aurora a,
		   mov mv,
		   mova mva
			WHERE  Nvl(m.cnpj, 0) <> 0
		   AND To_number(m.cnpj) = To_number(c.cnpj(+))
		   AND To_number(m.cnpj) = To_number(a.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mv.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mva.cnpj(+)) 
			UNION ALL
			SELECT DISTINCT Nvl((SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade_bairro r WHERE  r.cidade = m.cidade AND r.bairro = m.bairro), 
						(SELECT Listagg(r.rca, ';') within GROUP (ORDER BY r.rca DESC) FROM   rcas_cidade r WHERE  r.cidade = m.cidade)) AS RCAs,
					'Prj Mandaguari'                                                          AS OrigemCispe,
					Decode(Nvl(c.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseJumbo,
					Decode(Nvl(mv.qt, 0), 0, 'NAO','SIM')                               AS PositivadoJumbo,
					Decode(Nvl(a.cnpj, 0), 0, 'NAO','SIM')                              AS NaBaseAurora,
					Decode(Nvl(mva.qt, 0), 0, 'NAO','SIM')                              AS PositivadoAurora,
					to_number(m.cnpj)                                                              AS CNPJ,
					m.nome_fantasia                                                     AS \"RAZAO SOCIAL\",
					m.endereco                                                          AS \"ENDERECO\",
					m.bairro                                                            AS BAIRRO,
					to_number(m.cep)                                                               AS CEP,
					m.cidade                                                            AS CIDADE,
					To_char('01/01/0001')                                            AS \"DATA FUNDACAO\",
					'nao disponivel' as \"CODCNAE\",
					'nao disponivel'                                                    AS \"DESC. CNAE\",
					'nao disponivel' as \"DESC. SEGM\",
					0                                                    AS \"CLIENTE AURORA\",
					0                                                          AS LATITUDE,
					0                                                         AS LONGITUDE
			FROM   lista_cispe_prj_mandaguari m,
		   cnpjs_jumbo c,
		   cnpjs_aurora a,
		   mov mv,
		   mova mva
			WHERE  Nvl(m.cnpj, 0) <> 0
		   AND m.cnpj NOT IN (SELECT DISTINCT g.cnpj FROM cispe_maringa g)
		   AND To_number(m.cnpj) = To_number(c.cnpj(+))
		   AND To_number(m.cnpj) = To_number(a.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mv.cnpj(+))
		   AND To_number(m.cnpj) = To_number(mva.cnpj(+)) 
			order by 1,2,3 )
			select * from resultante r ";
			$condicionantes = "";
			$valor_condic = "";
			if(isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])){
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = explode("|",$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
				foreach($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] as $k0=>$condicionantes){
					$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"][$k0] = explode(",",$condicionantes) ;
					foreach($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"][$k0] as $k1=>$condicionante){
						if(stripos($condicionante, "RCA" ) !== false){
							$valor_condic = str_replace("'","",str_ireplace("RCA='","",$condicionante));
							$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"][$k0][$k1] = " r.rcas like '% ".$valor_condic." %' ";
						}
					}
					$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"][$k0] = implode(" or ",$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"][$k0]);
				}
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = trim(implode(" and ",$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));
				if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] !== ""){
					$comhttp->requisicao->sql->comando_sql.= " where ".$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
				}
				if($_SESSION['podever']=='PADRAO'){					
					if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] !== ""){
						$comhttp->requisicao->sql->comando_sql.=" and (";

						$condic = [];
						$condic[] = " r.rcas like '% ".($_SESSION["codusur"] ?? ($_SESSION["usuariosis"] ?? [])["codusur"] ?? "")." %' ";
						$_SESSION[ "rcas_subordinados" ] = explode( "," , $_SESSION[ "rcas_subordinados" ] ?? [] ) ;
						foreach( $_SESSION[ "rcas_subordinados" ] as $rca){
							 $condic[] = " r.rcas like '% ".$rca." %' ";
						}
						$comhttp->requisicao->sql->comando_sql.= implode( " or " , $condic ) . ")";
						$_SESSION[ "rcas_subordinados" ] = implode( "," , $_SESSION[ "rcas_subordinados" ] ?? [] ) ;
					}else{
						$comhttp->requisicao->sql->comando_sql.=" where ";
						$condic = [];
						$condic[] = " r.rcas like '% ".($_SESSION["codusur"] ?? ($_SESSION["usuariosis"] ?? [])["codusur"] ?? "")." %' ";
						$_SESSION[ "rcas_subordinados" ] = explode( "," , $_SESSION[ "rcas_subordinados" ] ?? []) ;
						foreach( $_SESSION[ "rcas_subordinados" ] as $rca){
							 $condic[] = " r.rcas like '% ".$rca." %' ";
						}
						$comhttp->requisicao->sql->comando_sql.= implode( " or " , $condic ) ;
						$_SESSION[ "rcas_subordinados" ] = implode( "," , $_SESSION[ "rcas_subordinados" ] ?? []) ;
					}
				};
			}else{
				if($_SESSION['podever']=='PADRAO'){
					$comhttp->requisicao->sql->comando_sql.=" where ";
					$condic = [];
					$_SESSION[ "rcas_subordinados" ] = explode( "," , $_SESSION[ "rcas_subordinados" ] ?? []) ;
					foreach( $_SESSION[ "rcas_subordinados" ] as $rca){
						 $condic[] = " r.rcas like '% ".$rca." %' ";
					}
					$comhttp->requisicao->sql->comando_sql.= implode( " or " , $condic ) ;
					$_SESSION[ "rcas_subordinados" ] = implode( "," , $_SESSION[ "rcas_subordinados" ] ?? []) ;
				};
			};
			//echo $comhttp->requisicao->sql->comando_sql; exit();
			return $comhttp->requisicao->sql->comando_sql;		
		}
		public static function montar_sql_clientes_nao_positivados(&$comhttp){
			/*Objetivo: montar o sql do relatorio clientes nao positivados*/
			$retorno = "";
			$comhttp->requisicao->sql=new TSql();
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = "relatorio_venda_visao_" . implode(",relatorio_venda_visao_",explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]));
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = 3;
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
			$comhttp->requisicao->requisitar->qual->objeto = $comhttp->requisicao->requisitar->qual->condicionantes["visoes"];
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$comhttp->requisicao->sql->comando_sql = trim($comhttp->requisicao->sql->comando_sql);
			$pos_ult_parenteses = strrpos($comhttp->requisicao->sql->comando_sql,")");
			$comhttp->requisicao->sql->comando_sql = FuncoesString::inserir_string($comhttp->requisicao->sql->comando_sql,' having SUM(nvl(r.pesototal_1,0) ) <= 0',$pos_ult_parenteses);	
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_clientesativosxpositivados(&$comhttp){
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
			$condicionantes = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes[] = "entidade='rca'";
				if ($rcas_filial !== null && count($rcas_filial) > 0) {
					$condicionantes[] = "codentidade in (".implode(",",$rcas_filial).")";
				} else {
					$condicionantes[] = "codentidade in (-1)";
				}
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				$rcas_supervisor = FuncoesSql::getInstancia()->obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes[] = "entidade='rca'";
				if ($rcas_supervisor !== null && count($rcas_supervisor) > 0) {
					$condicionantes[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				} else {
					$condicionantes[] = "codentidade in (-1)";
				}
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
		WITH 
		objetivos_mix_cli AS (
			SELECT
				o.codentidade AS rca,
				SUM(nvl(o.valor, 0)) AS objetivo,
				SUM(
					CASE
						WHEN o.realizado >(o.valor * o.percmaxating / 100) THEN
							round(o.valor * o.percmaxating / 100, 2)
						ELSE
							o.realizado
					END
				) AS realizado
			FROM
				sjdobjetivossinergia o
				join jumbo.pcusuari u on (u.codusur = o.codentidade)
			WHERE
				o.codcampanhasinergia = 1
				AND to_date('01'||'/'||sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'dd/mm/yyyy') between 
					to_date('$data_periodo1','dd/mm/yyyy') and to_date('$data_periodo2','dd/mm/yyyy')
					".(strlen(trim($condicionantes)) > 0 ? " and " . $condicionantes : "")."
				GROUP BY
					o.codentidade),
		clientes_jumbo_ativ AS (
			SELECT
				c.codusur1,
				c.codcli,
				c.cliente,
				c.fantasia,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
				c.limcred,
				c.bloqueio
			FROM
				jumbo.pcclient c
				LEFT OUTER JOIN (
					sjdcliente_origem   ca 
					join sjdpessoa_origem po on (ca.codpessoaorigem = po.codpessoa)
				) ON ( to_number(regexp_replace(po.numcnpjcpf,'[^0-9]+','')) = to_number(regexp_replace(c.cgcent,'[^0-9]+','')) )
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
			ORDER BY
				limcred DESC,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) DESC
		), clientes_aurora_ativ AS (
			SELECT
				nvl(c.codusur1, nvl(ca.codvendedororigem,ca.codvendedor_erp)) AS cdusur1,
				nvl(c.codcli, pe.numcnpjcpf) AS codcli,
				nvl(c.cliente, pe.nomerazao) AS cliente,
				nvl(c.fantasia, pe.nomerazao) AS fantasia,
				greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
				nvl(c.limcred, 0) AS limcred,
				nvl(c.bloqueio, 'N') AS bloqueio
			FROM
				sjdcliente_origem   ca
				join sjdpessoa_origem pe on (pe.codpessoa = ca.codpessoaorigem)
				LEFT OUTER JOIN jumbo.pcclient c ON ( to_number(regexp_replace(pe.numcnpjcpf,'[^0-9]+','')) = to_number(regexp_replace(c.cgcent,'[^0-9]+','')) )
			WHERE
				nvl(c.dtexclusao, NULL) IS NULL
				AND nvl(c.codusur1, nvl(ca.codvendedororigem,ca.codvendedor_erp)) != 150
				and c.codcli is null
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
				limcred,
				bloqueio
		), res_cli_ativos_resumo AS (
			SELECT
				codusur1,
				COUNT(1) AS qtativos
			FROM
				res_cli_ativos
			GROUP BY
				codusur1
		)
		select
			cli.rca,
			u.nome,
			ca.qtativos as \"Qtde Cli Ativos\",
			cli.objetivo as \"objetivo mix cli\",
			cli.realizado as \"realizado mix cli\"
		from 
			objetivos_mix_cli cli
			left outer join jumbo.pcusuari u on (u.codusur = cli.rca)
			left outer join RES_CLI_ATIVOS_RESUMO ca on ( ca.codusur1 = cli.rca )
		order by 1";
			$comhttp->requisicao->sql->comando_sql = $comando_sql;
			//echo $comando_sql; exit();
			return $comando_sql;
		}
		public static function montar_sql_consulta_cliente(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$codprocesso = 10000; 
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_clientes_simples(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttpsimples->c["condicionantes"] = $condictemp;
			}
			$comhttpsimples->d["objeto"] = "lista_clientes";
			$comando_sql = "
				select
					/*0*/c.codcli,
					/*1*/c.cgcent,
					/*2*/c.cliente,
					/*3*/c.fantasia,
					/*4*/c.codusur1,
					/*5*/c.codplpag,
					/*6*/c.codcob,
					/*7*/nvl(u.codfilial,c.codfilialnf) as codfilial,
					/*8*/to_char(greatest(
							nvl(c.dtultalter,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultcomp,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtbloq,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtdesbloqueio,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtexclusao,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtreglim,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultalter1203,to_date('01/01/2000','dd/mm/yyyy'))),'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtultalter,
					/*9*/cb.cobranca,
					/*10*/pl.descricao,
					/*11*/c.numregiaocli,
					/*12*/pl.numpr,
					/*13*/c.codrede,
					/*14*/c.bloqueio,
					/*15*/to_char(c.dtexclusao,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtexclusao,
					/*16*/c.limcred,
					/*17*/dbms_lob.substr(c.motivobloq, 4000, 1 ) AS motivobloq,
					/*18*/c.motivoexclusao,
					/*19*/to_char(c.dtultcomp,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtultcomp,
					/*20*/c.municent,
					/*21*/c.estent,
					/*22*/c.bairroent,
					/*23*/c.enderent,
					/*24*/c.numeroent,
					/*25*/c.telent,
					/*26*/c.email,
					/*27*/c.latitude,			
					/*28*/c.longitude,
					/*29*/v.vltotal,
					/*30*/v.qtitens,
					/*31*/v.numpedrca,
					/*32*/1 as statussinc
				from
					jumbo.pcclient c
					join jumbo.pcusuari u on (u.codusur = c.codusur1)
					left outer join jumbo.pccob cb on (cb.codcob = c.codcob)
					left outer join jumbo.pcplpag pl on (pl.codplpag = c.codplpag)
					left outer join sjdcliultcomp v on (v.codcli = c.codcli)
				where				
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_dados_cliente(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
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
				select
					/*0*/c.codcli,
					/*1*/c.cgcent as cnpj,
					/*2*/c.cliente as razao,
					/*3*/c.fantasia,
					/*4*/c.codusur1 as codvendedor,
					/*5*/c.codplpag,
					/*6*/c.codcob,
					/*7*/nvl(c.codfilialnf,u.codfilial) as codfilial,
					/*8*/to_char(greatest(
							nvl(c.dtultalter,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultcomp,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtbloq,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtdesbloqueio,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtexclusao,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtreglim,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultalter1203,to_date('01/01/2000','dd/mm/yyyy'))),'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtultalter,			
					/*9*/cb.cobranca,
					/*10*/pl.descricao as descplpag,
					/*11*/c.numregiaocli,
					/*12*/pl.numpr as numcolpreco,
					/*13*/c.codrede,
					/*14*/c.bloqueio,
					/*15*/to_char(c.dtexclusao,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtexclusao,
					/*16*/c.limcred,
					/*17*/dbms_lob.substr(c.motivobloq, 4000, 1 ) AS motivobloq,
					/*18*/c.motivoexclusao,
					/*19*/to_char(c.dtultcomp,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtultcomp,
					/*20*/c.municent,
					/*21*/c.estent,
					/*22*/c.bairroent,
					/*23*/c.enderent,
					/*24*/c.numeroent,
					/*25*/c.telent,
					/*26*/c.email,
					/*27*/c.latitude,				
					/*28*/c.longitude,
					/*29*/v.vltotal,
					/*30*/v.qtitens,
					/*31*/v.numpedrca,
					/*32*/1 as statussinc,
					/*33*/to_char(sysdate,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtatualizacao
				from
					jumbo.pcclient c
					join jumbo.pcusuari u on (u.codusur = c.codusur1)
					left outer join jumbo.pccob cb on (cb.codcob = c.codcob)
					left outer join jumbo.pcplpag pl on (pl.codplpag = c.codplpag)
					left outer join sjdcliultcomp v on (v.codcli = c.codcli)
				where				
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_estoque(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($condictemp)));
			}
			$comhttp->requisicao->requisitar->qual->objeto = "lista_produtos_estoque";
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";

			/*encontra os codigos dos produtos se a condicionante veio do front como nome do produto */
			if (count($condictemp) > 0) {
				foreach($condictemp as $chave=>$condict) {
					if ($condictemp[$chave] !== "array") {
						$condictemp[$chave] = explode(strtolower(trim(Constantes::sepn2)),strtolower(trim($condictemp[$chave])));
					}
					if (count($condictemp[$chave]) > 0) {
						foreach($condictemp[$chave] as $chave2=>$condict2) {
							$condic = strtolower(trim(substr($condictemp[$chave][$chave2],0,strpos($condictemp[$chave][$chave2],"="))));
							$valor = strtolower(trim(substr($condictemp[$chave][$chave2],strpos($condictemp[$chave][$chave2],"=") + 1)));			
							if ($condic === "produto") {
								if (is_numeric($valor)) {	
									} else {
									$comando_sql_temp = "select codprod from jumbo.pcprodut where lower(descricao) like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "produto=" . $prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);
									} else {
										$condictemp[$chave][$chave2] = "produto=-1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condictemp;
			}


			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);

			//print_r($comando_sql); exit();
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];
			if (gettype($mostrar_vals_de) !== "array") {
				$mostrar_vals_de = explode(",",$mostrar_vals_de);
			}
			if (count($mostrar_vals_de) > 0) {
				$pfim = stripos($comando_sql," from resultante_final") + 23;
				$comando_sql_antes = substr($comando_sql,0,$pfim);
				$comando_sql_depois = substr($comando_sql,$pfim);
				$condictemp = [];		
				$mostrar_vals_de = $mostrar_vals_de ?? true;
				if (array_search(0,$mostrar_vals_de) !== false) {
					$condictemp[] = "resultante_final.\"disponivel jumbo\" > 0";
				}
				if (array_search(1,$mostrar_vals_de) !== false) {
					$condictemp[] = "resultante_final.\"disponivel aurora\" > 0";
				}
				if (array_search(2,$mostrar_vals_de) !== false) {
					$condictemp[] = "resultante_final.\"disponivel total\" > 0";
				}
				if (count($condictemp) > 0) {
					$comando_sql = $comando_sql_antes . " where " . implode(" and ",$condictemp) . " " . $comando_sql_depois;
				} else {
					$comando_sql = $comando_sql_antes . " " . $comando_sql_depois;
				}
			}
			$retorno = trim($comando_sql);
			$retorno = str_ireplace("and SJDESTOQUE_ORIGEM.codfilialorigem = 1","",$retorno);
			$retorno = str_ireplace("and SJDESTOQUE_ORIGEM.codfilialorigem = 2","",$retorno);
			$retorno = str_ireplace("and SJDESTOQUE_ORIGEM.codfilialorigem = 3","",$retorno);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_estoque_simples(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condicprod = [];
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
							if ($condic === "produto") {
								if (is_numeric($valor)) {	
									$condicprod[] = "\"codprod\"=".$valor;
								} else {
									$comando_sql_temp = "select codprod from jumbo.pcprodut where lower(descricao) like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "\"codprod\"=" . $prodtemp;
											$condicprod[] = "\"codprod\"=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "\"codprod\"=-1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttpsimples->c["condicionantes"] = $condictemp;
			}
			$comhttpsimples->d["objeto"] = "lista_produtos_estoque";
			$comando_sql = "
				WITH transmitidos AS (
					SELECT
						c.codfilial,
						i.codprod,
						SUM(nvl(i.qt, 0)) AS qt
					FROM
						jumbo.pcpedcfv   c
						JOIN jumbo.pcpedifv   i ON ( i.numpedrca = c.numpedrca )
					WHERE
						c.importado = 1
					GROUP BY
						c.codfilial,
						i.codprod
				), estaur AS (
					SELECT
						sjdestoque_origem.codfilialorigem   AS \"filial\",
						sjdestoque_origem.codprodorigem     AS \"codprod\",
						nvl(p.descricao, sjdproduto_origem.descricao) AS \"descricao\",
						nvl(nvl(p.unidade, sjdunidades_origem.unidade), 'kg') AS \"un\",
						0 AS \"qtde jumbo\",
						0 AS \"reservado\",
						0 AS \"pendente\",
						0 AS \"transmitido\",
						0 AS \"disponivel jumbo\",
						0 AS \"previsao disp jumbo\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"disponivel aurora\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"disponivel total\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"previsao disp total\",
						1 AS \"aurora\"
					FROM
						sjdestoque_origem
						LEFT OUTER JOIN sjdproduto_origem   sjdproduto_origem ON ( sjdestoque_origem.codprodorigem = sjdproduto_origem.codprod_na_origem )
						LEFT OUTER JOIN sjdunidades_origem on (sjdunidades_origem.codunidade = sjdproduto_origem.codunidadeorigem)
						LEFT OUTER JOIN jumbo.pcprodut                p ON ( p.codprod = sjdestoque_origem.codprodorigem )
					WHERE
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) > 0
				), estjum AS (
					SELECT
						e.codfilial          AS \"filial\",
						e.codprod            AS \"codprod\",
						pcprodut.descricao   AS \"descricao\",
						pcprodut.unidade     AS \"un\",
						nvl(e.qtestger, 0) - ( nvl(e.qtbloqueada, 0) + nvl(e.estmin, 0) ) AS \"qtde jumbo\",
						nvl(e.qtreserv, 0) AS \"reservado\",
						nvl(e.qtpendente, 0) AS \"pendente\",
						nvl(t.qt, 0) AS \"transmitido\",
						nvl(e.qtestger, 0) - ( nvl(e.qtbloqueada, 0) + nvl(e.estmin, 0) + nvl(e.qtreserv, 0) ) AS \"disponivel jumbo\",
						nvl(e.qtestger, 0) - ( nvl(e.qtbloqueada, 0) + nvl(e.estmin, 0) + nvl(e.qtreserv, 0) + nvl(e.qtpendente, 0) + nvl(t.qt, 0) ) AS \"previsao disp jumbo\",
						nvl(ea.\"disponivel aurora\", 0) AS \"disponivel aurora\",
						(nvl(e.qtestger, 0) - ( nvl(e.qtbloqueada, 0) + nvl(e.estmin, 0) + nvl(e.qtreserv, 0) )) + nvl(ea.\"disponivel aurora\", 0) AS \"disponivel total\",
						(nvl(e.qtestger, 0) - ( nvl(e.qtbloqueada, 0) + nvl(e.estmin, 0) + nvl(e.qtreserv, 0) + nvl(e.qtpendente, 0) + nvl(t.qt, 0) )) + nvl(ea.\"disponivel aurora\", 0) AS \"previsao disp total\",
						(
							CASE
								WHEN nvl(f.fornecedor, '') LIKE '%AUROR%' THEN
									1
								ELSE
									0
							END
						) AS \"aurora\"
					FROM
						jumbo.pcest      e
						JOIN jumbo.pcprodut   pcprodut ON ( e.codprod = pcprodut.codprod )
						LEFT OUTER JOIN jumbo.pcfornec   f ON ( f.codfornec = pcprodut.codfornec )
						LEFT OUTER JOIN transmitidos     t ON ( t.codfilial = e.codfilial
															AND t.codprod = e.codprod )
						left outer join estaur ea on (ea.\"filial\" = e.codfilial and ea.\"codprod\" = e.codprod)
					WHERE
						nvl(lower(TRIM(pcprodut.revenda)), 'x') = ( lower('S') )
						AND pcprodut.dtexclusao IS NULL
						AND lower(nvl(pcprodut.obs2, 'x')) <> lower('FL')
				)
				, estjuntos AS (
					SELECT
						to_number(ej.\"filial\") AS \"filial\",
						ej.\"codprod\",
						ej.\"descricao\",
						ej.\"un\",
						ej.\"qtde jumbo\",
						ej.\"reservado\",
						ej.\"pendente\",
						ej.\"transmitido\" AS \"transmitido\",
						ej.\"disponivel jumbo\",
						ej.\"previsao disp jumbo\",
						ej.\"disponivel aurora\",
						ej.\"disponivel total\",
						ej.\"previsao disp total\",
						ej.\"aurora\"
					FROM
						estjum ej
					UNION ALL
					SELECT
						ea.\"filial\",
						ea.\"codprod\",
						ea.\"descricao\",
						ea.\"un\",
						ea.\"qtde jumbo\",
						ea.\"reservado\",
						ea.\"pendente\",
						ea.\"transmitido\" AS \"transmitido\",
						ea.\"disponivel jumbo\",
						ea.\"previsao disp jumbo\",
						ea.\"disponivel aurora\",
						ea.\"disponivel total\",
						ea.\"previsao disp total\",
						ea.\"aurora\"
					FROM
						estaur ea
					where
						not exists (select 1 from estjum ej where ej.\"filial\" = ea.\"filial\" and ej.\"codprod\" = ea.\"codprod\")
				)
				SELECT
					ej.\"filial\",
					ej.\"codprod\",
					nvl(ej.\"descricao\", 'sem descricao') AS \"descricao\",
					nvl(ej.\"un\", 'kg') AS \"un\",
					nvl(ej.\"qtde jumbo\", 0) AS \"qtde jumbo\",
					nvl(ej.\"reservado\", 0) AS \"reservado\",
					nvl(ej.\"pendente\", 0) AS \"pendente\",
					nvl(ej.\"transmitido\", 0) AS \"transmitido\",
					nvl(ej.\"disponivel jumbo\", 0) AS \"disponivel jumbo\",
					nvl(ej.\"previsao disp jumbo\", 0) AS \"previsao disp jumbo\",
					nvl(ej.\"disponivel aurora\", 0) AS \"disponivel aurora\",
					nvl(ej.\"disponivel total\", 0) AS \"disponivel total\",
					nvl(ej.\"previsao disp total\", 0) AS \"previsao disp total\",
					nvl(ej.\"aurora\", 0) AS \"aurora\"
				FROM
					estjuntos ej
				WHERE				
					__CONDICPROD__
					__CONDICFILIAL__
					and
						(nvl(ej.\"qtde jumbo\",0) != 0 or nvl(ej.\"disponivel aurora\",0) !=0)
					and nvl(ej.\"previsao disp total\",0) != 0
				order by 1,2	
			";
			if (count($condicprod) > 0) {
				$comando_sql = str_ireplace("__CONDICPROD__"," (".implode(" or ",$condicprod).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICPROD__"," 1=1 ",$comando_sql);
			}
			//print_r($GLOBALS["usuariosis"]);exit();
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and ej.\"filial\" = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_atualizacoes_obrigatorias(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_atualizacoes_obrigatorias";
			$comando_sql = "
			SELECT
				a.*
			FROM
				sjdatualizacoesobrigcel a			
			where
			(
				not exists(select 1 from sjdatualizobrigcelrestr r where r.codatualizacao = a.codatualizacao)
				or exists (select 1 from sjdatualizobrigcelrestr r where r.codatualizacao = a.codatualizacao and r.codusuariosis = ".$GLOBALS["usuariosis"]["codusuariosis"].")
			)    
			and not exists(select 1 from sjdatualizobrigcelhist h where h.codatualizacao = a.codatualizacao and h.codatualizacao = ".$GLOBALS["usuariosis"]["codusuariosis"].")
			and (
				lower(trim(a.nomeapp)) = lower(trim('__NOMEAPP__'))
				or (
					lower(trim(a.nomeapp)) = lower(trim('todos'))
					and not exists(
						select 1 from sjdatualizacoesobrigcel a2 where lower(trim(a2.nomeapp)) = lower(trim('__NOMEAPP__')) and a2.codsinc = i.codsinc
					)
				)		
			)
			__CONDICTAB__
			order by 1";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_campodbcel(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_camposdbcel";
			$comando_sql = "
				SELECT
					c.codcampodb,
					c.codtabeladb,
					c.nomecampodb,
					c.nomecampovisivel,
					c.alias,
					c.tipodado,
					c.parametros,
					c.statussinc
				FROM
					sjdcampodbcel c
					join sjdtabeladbcel t on (t.codtabeladb = c.codtabeladb)
				where
					(
						lower(trim(t.nomeapp)) = lower(trim('__NOMEAPP__'))
						or (
							lower(trim(t.nomeapp)) = lower(trim('todos'))
							and not exists(
								select 1 from sjdtabeladbcel t2 where lower(trim(t2.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t2.nometabeladb)) = lower(trim(t.nometabeladb))
							)
						)
					)
					__CONDICTAB__
				order by 1	
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_clientes_atualizados(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttpsimples->c["condicionantes"] = $condictemp;
			}
			$comhttpsimples->d["objeto"] = "lista_clientes";
			$comando_sql = "
				select
					/* 0*/c.codcli,
					/* 1*/to_char(greatest(
							nvl(c.dtultalter,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultcomp,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtbloq,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtdesbloqueio,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtexclusao,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtreglim,to_date('01/01/2000','dd/mm/yyyy')),
							nvl(c.dtultalter1203,to_date('01/01/2000','dd/mm/yyyy'))),'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."')  as dtultalt
				from
					jumbo.pcclient c
					join jumbo.pcusuari u on (u.codusur = c.codusur1)
				where				
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_clientes_rca(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($condictemp)));
			}
			$comhttp->requisicao->requisitar->qual->objeto = "lista_clientes_rca";
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "";
			if (count($condictemp) > 0) {
				$condtabclicodusur = [];
				foreach($condictemp as $chave=>&$condict) {
					if ($condictemp[$chave] !== "array") {
						$condictemp[$chave] = explode(strtolower(trim(Constantes::sepn2)),strtolower(trim($condictemp[$chave])));
					}
					if (count($condictemp[$chave]) > 0) {
						foreach($condictemp[$chave] as $chave2=>&$condict2) {
							$condic = strtolower(trim(substr($condictemp[$chave][$chave2],0,strpos($condictemp[$chave][$chave2],"="))));
							$valor = strtolower(trim(substr($condictemp[$chave][$chave2],strpos($condictemp[$chave][$chave2],"=") + 1)));			
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									} else {
									$comando_sql_temp = "select replace(replace(replace(cgcent,'.',''),'/',''),'-','') from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' " + 
														" unon " + 
														"select replace(replace(replace(cnpj_cliente,'.',''),'/',''),'-','') from sjdcliente_origem where lower(descr_cliente) like '%$valor%' and existe_jumbo = 0" ;
									echo $comando_sql_temp; exit();
									$clientes_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($clientes_temp) > 0) {
										$condic_substituta = [];
										foreach($clientes_temp as $clienttemp) {
											$condic_substituta[] = "cliente=" . $clienttemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);
									} else {
										$condictemp[$chave][$chave2] = "cliente=-1";
										break;
									}				
								}
							} else if ($condic === "rca") {
								if ($valor !== $_SESSION["codusur"]) {
									$condtabclicodusur[] = $valor;
								} else {
									unset($condictemp[$chave][$chave2]);
									continue;
								}
							}
						}
						if (count($condictemp[$chave]) === 0) {
							unset($condictemp[$chave]);
						}
					}
					if (isset($condictemp[$chave])) {
						if (count($condictemp[$chave]) > 0) {
							$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
						}
					}
				}
				if (isset($condictemp)) {
					if (count($condictemp) > 0) {
						$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
					} 
					} else {
					$condictemp === [];
				}
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condictemp;
			}
			if (count($condtabclicodusur) > 0) {
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"][] = "pcclient[pcclient.codusur1 in (".implode(",",$condtabclicodusur).")]";
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"][] = "sjdcliente_origem[sjdcliente_origem.cd_vendedor in (".implode(",",$condtabclicodusur).")]";
			}
			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_cnaes(&$comhttpsimples){
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					/* 0*/cn.codcnae,
					/* 1*/upper(translate(lower(cn.desccnae),'ãáàçúíéêôóõ','aaacuieeooo')) as descricao,
					/* 2*/cn.codativ1,
					/* 3*/1 as statussinc
				FROM
					jumbo.pccnae cn
				ORDER BY
					1
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}

		public static function montar_sql_consulta_cargas(&$comhttpsimples){			
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					c.numcar,
					0 as codorigemdado,
					coalesce(ac.codveiculo,c.codveiculo,e.codveiculo) as codveiculo,
					coalesce(ac.codmotorista,c.codmotorista,e.matricula) as codmotorista,
					coalesce(ac.nomemotorista,e.nome) as nomemotorista,
					coalesce(ac.placa,v.placa) as placa,
					coalesce(ac.destino,c.destino) as destino,
					to_char(coalesce(ac.dtsaida,c.dtsaida),'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtsaida,
					coalesce(ac.pesototal,c.totpeso) as pesototal,
					coalesce(ac.numnotas,c.numnotas) as numnotas,
					coalesce(ac.nument,c.nument) as nument,
					coalesce(ac.vltotal,c.vltotal) as vltotal,
					coalesce(ac.vltotalrecebidodepositado,0) as vltotalrecebidodepositado,
					to_char(ac.dtinicioentregas,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtinicioentregas,
					to_char(ac.dtfimentregas,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtfimentregas,
					ac.observacao as observacao,
					coalesce(ac.statuscarregamento,0) as statuscarregamento,
					1 as statussinc
				FROM
					jumbo.pccarreg c
					left outer join jumbo.pcveicul v on (v.codveiculo = c.codveiculo)
					left outer join jumbo.pcempr e on (e.matricula = c.codmotorista)    
					left outer join sjdacompentregacarreg ac on (ac.numcar = c.numcar)
				WHERE
					c.numcar = __NUMCARJUMBO__				
			";
			$cargas = $comhttpsimples->c["cargas"];
			$cargas = trim($cargas);
			$cargas = explode("-",$cargas);
			if (strlen(trim($cargas[0])) > 0) {
				$comando_sql = str_replace("__NUMCARJUMBO__",$cargas[0],$comando_sql);
			} else {
				$comando_sql = str_replace("__NUMCARJUMBO__","-1",$comando_sql);
			}			
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}

		public static function montar_sql_consulta_notascargajumbo(&$comhttpsimples){			
			$comando_sql = "";	
			$comando_sql = "
				SELECT DISTINCT
					s.chavenfe,
					0 as codorigemdado,
					s.numcar,
					s.numnota,    
					s.cliente as razaosocial,
					c.fantasia,
					to_char(s.dtsaida,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtsaida,
					to_char(s.dtentrega,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtentrega,
					s.horaentrega,
					s.minutoentrega,
					s.codcli,
					s.cgc as cnpjcliente,
					s.codusur as codvendedor,
					s.numitens as qtitens,
					s.totpesobruto as pesototal,
					s.vltotal as valortotal,
					s.codcob,
					s.cobranca as desccobranca,
					s.codplpag,
					pl.descricao as descplpag,    
					s.endereco,
					s.numendereco,
					s.bairro,
					s.municipio,    
					s.cep,
					s.telefone,
					c.latitude,
					c.longitude,
					coalesce(ac.statusentrega,0) as statusentrega,
					to_char(ac.dtinicioentrega,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtinicioentrega,
					to_char(ac.dtfimentrega,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtfimentrega,
					ac.observacao,
					1 as statussinc
				FROM
					jumbo.pcnfsaid s
					join jumbo.pcmov m on (m.numtransvenda = s.numtransvenda)
					join jumbo.pcclient c on (c.codcli = s.codcli)
					left outer join jumbo.pcplpag pl on (pl.codplpag = s.codplpag)
					left outer join sjdacompentreganotas ac on (ac.chavenfe = s.chavenfe)
				WHERE
					s.numcar = __NUMCARJUMBO__
					and s.dtcancel is null
					and s.especie = 'NF'
					and m.codoper in ('S','SB')

			";
			$numcar = $comhttpsimples->c["numcar"];
			if (strlen(trim($numcar)) > 0) {
				$comando_sql = str_replace("__NUMCARJUMBO__",$numcar,$comando_sql);
			} else {
				$comando_sql = str_replace("__NUMCARJUMBO__","-1",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}

		public static function montar_sql_consulta_itensnotascargajumbo(&$comhttpsimples){			
			$comando_sql = "";	
			$comando_sql = "
				SELECT DISTINCT
					s.chavenfe || '-' || m.codprod as chavenfecodprod,
					1 as codorigemdado,
					s.chavenfe,
					m.codprod as codprod,
					coalesce(m.descricao,p.descricao) as descricao,
					p.codauxiliar as codbarrasun,
					p.codauxiliar2 as codbarrasmaster,
					p.codauxiliartrib as codbarrastrib,
					coalesce(m.unidade,p.unidade) as un,
					p.unidademaster,
					p.unidadetrib,
					coalesce(ap.qt,m.qt,m.qtcont) as qt,
					coalesce(m.qtunitcx,p.qtunitcx) as qtunitcx,
					coalesce(m.pesoliq,p.pesoliq) as pesoliqun,
					coalesce(m.pesobruto,p.pesobruto) as pesobrutoun,
					coalesce(ap.qt,m.qt,m.qtcont) / coalesce(m.qtunitcx,1) as qtcx,
					coalesce(m.qt,m.qtcont) * coalesce(m.pesobruto,p.pesobruto) as pesobrutototal,
					coalesce(ap.valorunitario,m.punit,m.punitcont) as valorunitario,
					ap.qtentregue,
					ap.qtentreguecx,
					coalesce(ap.vltotal,coalesce(ap.qt,m.qt,m.qtcont) * coalesce(ap.valorunitario,m.punit,m.punitcont)) as valortotal,
					to_char(ap.dtinicioentrega,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtinicioentrega,
					to_char(ap.dtfimentrega,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtfimentrega,
					ap.observacao,
					nvl(ap.statusentrega,0) as statusentrega,
					1 as statussinc
				FROM
					jumbo.pcnfsaid s 
					join jumbo.pcmov m on (m.numtransvenda = s.numtransvenda)
					join jumbo.pcprodut p on (p.codprod = m.codprod)
					left outer join sjdacompentregaprod ap on (ap.chavenfe = s.chavenfe and ap.codprod = m.codprod)
				where
					s.chavenfe = __CHAVENFE__
					and s.dtcancel is null
					and m.dtcancel is null
					and s.especie = 'NF'
					and m.codoper in ('S','SB')
		
			";
			$chavenfe = $comhttpsimples->c["chavenfe"];
			if (strlen(trim($chavenfe)) > 0) {
				$comando_sql = str_replace("__CHAVENFE__",$chavenfe,$comando_sql);
			} else {
				$comando_sql = str_replace("__CHAVENFE__","-1",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			//echo $comando_sql; exit();
			return $retorno;
		}

		public static function montar_sql_consulta_pagamentosnotascargajumbo(&$comhttpsimples){			
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					p.idapp as \"rowid\",
					p.chavenfe,
					p.formapagamento,
					p.valor,
					1 as statussinc
				FROM
					sjdacompentregapag p 
				where
					p.chavenfe = __CHAVENFE__
		
			";
			$chavenfe = $comhttpsimples->c["chavenfe"];
			if (strlen(trim($chavenfe)) > 0) {
				$comando_sql = str_replace("__CHAVENFE__",$chavenfe,$comando_sql);
			} else {
				$comando_sql = str_replace("__CHAVENFE__","-1",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}

		public static function montar_sql_consulta_pagamentoscarregamentosjumbo(&$comhttpsimples){			
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					p.idapp as \"rowid\",
					p.numcar,
					p.formapagamento,
					p.valor,
					1 as statussinc
				FROM
					sjdacompentregapagcar p 
				where
					p.numcar = __NUMCAR__
		
			";
			$numcar = $comhttpsimples->c["numcar"];
			if (strlen(trim($numcar)) > 0) {
				$comando_sql = str_replace("__NUMCAR__",$numcar,$comando_sql);
			} else {
				$comando_sql = str_replace("__NUMCAR__","-1",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}

		

		public static function montar_sql_consulta_lista_cobrancas(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccob = [];
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
							if ($condic === "cobranca") {
								if (is_numeric($valor)) {	
									$condiccob[] = "codcob=".$valor;
								} else {
									$comando_sql_temp = "select codcob from jumbo.pccob where lower(cobranca) like '%$valor%' ";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "codcob=" . $prodtemp;
											$condiccob[] = "codcob=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "codcob='-1'";
										break;
										}				
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
				SELECT
					/* 0*/codcob,
					/* 1*/cobranca as desccob,
					/* 2*/nivelvenda as nivelcob,
					/* 3*/prazomaximovenda as prazomaximovenda,
					/* 4*/vlminpedido as vlminpedido,
					/* 5*/codfilial as codfilial,
					/* 6*/codrede as codrede,
					/* 7*/1 as statussinc
				FROM
					jumbo.pccob
				WHERE
					enviacobrancafv = 'S'
					__CONDICCOB__
				ORDER BY
					3
			";
			if (count($condiccob) > 0) {
				$comando_sql = str_ireplace("__CONDICCOB__"," AND (".implode(" or ",$condiccob).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCOB__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_cobrancas_clientes(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
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
				SELECT
					cob.codcob || '-' || cob.codcli as codcob_codcli,
					cob.codcob,
					cob.codcli,
					1 as statussinc
				FROM
					jumbo.pccobcli cob
					join jumbo.pcclient c on (c.codcli = cob.codcli)
					join jumbo.pcusuari u on (u.codusur = c.codusur1)
				where 
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_cobrancas_x_prazos(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comando_sql = "	
				select 
					/* 0*/codcob || '-' || codplpag as codcobcodprazo,
					/* 1*/codcob,
					/* 2*/codplpag,
					1 as statussinc
				from 
					jumbo.PCCOBPLPAG
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_comandossqlcel(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_comandos_cel";
			$comando_sql = "
				SELECT
					c.codcomandosql,
					c.codprocesso,
					c.tipocomando,
					c.tipoobjeto,
					c.comandosql,
					c.tabelas,
					c.aliasescamposunique,
					c.aliasescamposresultantes,
					c.condicionantes,
					c.groupby,
					c.having_,
					c.orderby,
					c.traducaocampossqlobjapp,
					c.traducaotipossqlobjapp,			
					c.statussinc
				FROM
					sjdcomandossqlcel c
				where
					(
						lower(trim(c.nomeapp)) = lower(trim('__NOMEAPP__'))
						or (
							lower(trim(c.nomeapp)) = lower(trim('todos'))
							and not exists(
								select 1 from sjdcomandossqlcel c2 where lower(trim(c2.nomeapp)) = lower(trim('__NOMEAPP__')) and c2.codprocesso = c.codprocesso
							)
						)		
					)
					__CONDICTAB__
				order by 1		
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_desvios_volume(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$condics = [];
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condictemp);
			}
			$condic_datas = " 
					o.ano = TO_CHAR(SYSDATE, 'yyyy')
					and lower(trim(o.mes)) = lower(trim(sjdpkg_funcs_data.mes_texto(to_number(to_char(sysdate, 'mm'))))) ";
			if (isset($condictemp["datas"])) {
				$datas = $condictemp["datas"][0]["valor"];
				$datas = explode(",",$datas);
				$condic_datas = " to_date(sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'mm/yyyy') between to_date('".$datas[0]."','mm/yyyy') and to_date('".$datas[1]."','mm/yyyy') ";
			}
			if (!isset($condictemp["visao"])) {
				$condictemp["visao"] = [0=>["valor"=>$comhttp->requisicao->requisitar->qual->condicionantes["visao"] ?? "rca"]];
			} 
			if (isset($condictemp["filial"])) {
				foreach($condictemp["filial"] as $condic) {
					$condics[] = "u.codfilial = " . $condic["valor"];
				}
			}
			if (isset($condictemp["supervisor"])) {
				foreach($condictemp["supervisor"] as $condic) {
					$condics[] = "u.codsupervisor = " . $condic["valor"];
				}
			}
			if (isset($condictemp["rca"])) {
				foreach($condictemp["rca"] as $condic) {
					$condics[] = "u.codusur = " . $condic["valor"];
				}
			}
			if (isset($condictemp["produto"])) {
				foreach($condictemp["produto"] as $condic) {
					$condics[] = "o.coditemvisao = '" . $condic["valor"]."'";
				}
			}
			if (!isset($_SESSION["usuariosis"]) || (isset($_SESSION["usuariosis"]) && ($_SESSION["usuariosis"] === null || count($_SESSION["usuariosis"]) === 0)) ) {
				$_SESSION["usuariosis"] = FuncoesSql::getInstancia()->obter_usuario_sis(["condic"=>$_SESSION["codusur"]])[0];
				if (strcasecmp(trim($condictemp["visao"][0]["valor"]), "geral") == 0)  {
					if (strcasecmp(trim($_SESSION["usuariosis"]["podever"]), "tudo") == 0) {
						$condictemp["visao"][0]["valor"] = "Filial";
					} else {
						switch(strtolower(trim($_SESSION["usuariosis"]["tipousuario"]))) {
							case "interno":
								$condictemp["visao"][0]["valor"] = "Filial";
								break;
							case "supervisor":
								$condictemp["visao"][0]["valor"] = "Supervisor";
								break;
							case "rca": default:
								$condictemp["visao"][0]["valor"] = "Rca";
								break;						
						}
					}
				}
			}
			$codusuracessiveis = [];
			if (!isset($_SESSION["usuarios_acessiveis"])) {
				$_SESSION["usuarios_acessiveis"] = FuncoesSisJD::obter_usuarios_acessiveis($_SESSION["usuariosis"],["*"],true,true);
				foreach($_SESSION["usuarios_acessiveis"] as $usur) {
					$codusuracessiveis[] = $usur["codusuariosis"];
				}
			}
			if (count($codusuracessiveis) > 0) {
				$condics[] = "u.codusur in (".implode(",",$codusuracessiveis).")";
			} 
			if (count($condics) > 0) {
				$condics = " and " . implode(" and ",$condics);
			} else {
				$condics = "";
			}
			$retorno = "
				with dados as (
					SELECT
						__CAMPOSSELECT__			
						round(sum(o.valor) - sum(
							case 
								when o.realizado / o.valor * 100 > o.percmaxating then o.valor
								else o.realizado
							end
						)) as falta,
						null as observacoes
					FROM
						sjdobjetivossinergia o 
						join jumbo.pcusuari u on (u.codusur = o.codentidade)
						__JOINS__
					WHERE
						" . $condic_datas . " 
						and o.codcampanhasinergia = 0
						and lower(trim(o.entidade)) = 'rca'
						and lower(trim(o.visao)) = 'produto' 
						and lower(trim(o.unidade)) = 'kg'			
						__CONDICS__
					group by
						__CAMPOSGROUP__
						null
					order by 
						3 desc)
				select * from dados 
				union all
				select __CAMPOSSELECTNULL__
						MAX(falta),
						null as observacoes
					FROM
						dados 
					group by
						__CAMPOSGROUPNULL__
						null
				union all
				select __CAMPOSSELECTNULL__
						MIN(falta),
						null as observacoes
					FROM
						dados 
					group by
						__CAMPOSGROUPNULL__
						null
			";
			$camposselectnull = "9999999999,null,";
			$camposgroupnull = "9999999999,null,";
			switch(strtolower(trim($condictemp["visao"][0]["valor"]))) {
				case "filial":
					$camposselect = "u.codfilial,f.cidade,";
					$joins = "left outer join jumbo.pcfilial f on (f.codigo = u.codfilial)";
					$camposgroup = "u.codfilial,f.cidade,";
					$camposselectnull = "to_char(9999999999),null,";
					$camposgroupnull = "to_char(9999999999),null,";
					break;
				case "supervisor":
					$camposselect = "u.codsupervisor,s.nome,";
					$joins = "left outer join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor)";
					$camposgroup = "u.codsupervisor,s.nome,";
					break;
				case "rca":
					$camposselect = "o.codentidade,u.nome,";
					$joins = "";
					$camposgroup = "o.codentidade,u.nome,";
					break;
				case "produto":
					$camposselect = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod) as descricao,";
					$joins = "left outer join jumbo.pcprodut p on (p.codprod = case when instr(lower(o.coditemvisao),'g') > 0 THEN -1 else to_number(o.coditemvisao) end)left outer join sjdgruposprodequiv g on (g.codvisivelgrupo = o.coditemvisao)";
					$camposgroup = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod),";
					$camposselectnull = "'G9999999999',null,";
					$camposgroupnull = "'G9999999999',null,";
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("visao nao definida: " . $condictemp["visao"],__FILE__,__FUNCTION__,__LINE__);
			}
			$retorno = str_ireplace("__CAMPOSSELECT__",$camposselect,$retorno);
			$retorno = str_ireplace("__JOINS__",$joins,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUP__",$camposgroup,$retorno);
			$retorno = str_ireplace("__CONDICS__",$condics,$retorno);
			$retorno = str_ireplace("__CAMPOSSELECTNULL__",$camposselectnull,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUPNULL__",$camposgroupnull,$retorno);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			/*$retorno = "
				select 1,'teste',10000,null from dual
				union all
				select 2,'teste2',8000,null from dual
				union all
				select 3,'teste2',6000,null from dual
				union all
				select 4,'teste2',4000,null from dual
				union all
				select 5,'teste2',-2000,null from dual
				union all
				select 6,'teste2',-4000,null from dual
				union all
				select 7,'teste2',-5000,null from dual
				union all
				select 8,'teste2',10000,null from dual
				union all
				select 8,'teste2',-5000,null from dual";
			$comhttp->requisicao->sql->comando_sql = $retorno;
			FuncoesArquivo::escrever_arquivo("temp.txt",$comhttp->requisicao->sql->comando_sql);*/
			return $retorno;
		}
		public static function montar_sql_consulta_lista_estados(&$comhttpsimples){
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					/* 0*/et.codigo as codestado,
					/* 1*/upper(translate(lower(et.estado),'ãáàçúíéêôóõ','aaacuieeooo')) as descricao,
					/* 2*/1 as statussinc
				FROM
					jumbo.pcestado et
				ORDER BY
					1
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_itens_sincronizacoes(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			
			$comhttpsimples->d["objeto"] = "lista_itenssinc_cel";
			$comando_sql = "
				SELECT
					i.codsinc,
					i.codsincsup,
					i.codrequisicao,
					i.ordemvisual,
					i.ordemexcecussao,
					i.textovisivel,
					i.marcado,
					i.habilitado,
					i.aberto,
					i.metodoaoabrir,
					i.objetoaoabrir,
					i.dtultsinc,
					i.observacoesultsinc,
					i.metodoaoselecionar,
					replace(i.objetoaoselecionar,'__VARNOMEAPP__','".$nomeapp."') as objetoaoselecionar,
					replace(i.objetorequisicao,'__VARNOMEAPP__','".$nomeapp."') as objetorequisicao,
					i.metodorequisicao,
					replace(i.objetoretorno,'__VARNOMEAPP__','".$nomeapp."') as objetoretorno,
					i.metodoretorno,
					i.tabela,
					i.statussinc
				FROM
					sjditenssinccel i
				where
					(
						lower(trim(i.nomeapp)) = lower(trim('__NOMEAPP__'))
						or (
							lower(trim(i.nomeapp)) = lower(trim('todos'))
							and not exists(
								select 1 from sjditenssinccel i2 where lower(trim(i2.nomeapp)) = lower(trim('__NOMEAPP__')) and i2.codsinc = i.codsinc
							)
						)		
					)
					__CONDICTAB__
				order by 1		
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$comando_sql = str_ireplace("__VARNOMEAPP__","__NOMEAPP__",$comando_sql);
			$retorno = $comando_sql;
			//echo $comando_sql; exit();
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_mensagens_sistema(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$codiccodusur = [];
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
							if ($condic === "codusur") {
								if (is_numeric($valor)) {	
									$codiccodusur[] = "m.codusur=".$valor;
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
				select
					/* 0*/rowidtochar(m.rowid) as rid,
					/* 1*/m.codusur,
					/* 2*/to_char(m.data,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as data,
					/* 3*/m.mens1,
					/* 4*/m.mens2,
					/* 5*/m.mens3,
					/* 6*/m.mens4,
					/* 7*/m.mens5,
					/* 8*/m.mens6,
					/* 9*/m.mens7,
					/*10*/m.mens8,
					/*11*/m.retorno,
					/*12*/to_char(m.dtinclusao,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtinclusao,
					/*13*/m.codfuncemite,
					/*14*/nvl(u.nome,e.nome) as nomefuncemite,
					/*15*/1 as statussinc
				from
					jumbo.pcmensfv m
					left outer join jumbo.pcusuari u on (u.codusur = m.codfuncemite)
					left outer join jumbo.pcempr e on (e.matricula = m.codfuncemite)
				where
					m.retorno = 2
					and trunc(m.dtinclusao) >= trunc(sysdate-30)
					__CONDICCODUSUR__
				order by 1,2	
			";
			$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,m.codusur) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_mensagens_usuarios(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$codiccodusur = [];
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
							if ($condic === "codusur") {
								if (is_numeric($valor)) {	
									$codiccodusur[] = "m.codusur=".$valor;
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
				SELECT
					/* 0*/r.numrecado,
					/* 1*/r.codsetororig,
					/* 2*/sorig.descricao as nomesetororig,    
					/* 3*/r.codsetordest,
					/* 4*/sdest.descricao as nomesetordest,
					/* 5*/nvl(edest.codusur,r.codfuncdest) as codfuncdest,
					/* 6*/nvl(udest.nome,edest.nome) as nomefuncdest,
					/* 7*/r.assunto,
					/* 8*/r.codfuncre,
					/* 9*/nvl(ure.nome,ere.nome) as nomefuncre,
					/*10*/to_char(r.dtre,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtre,
					/*11*/r.comunicado,
					/*12*/r.textorecado,
					/*13*/r.numrecadofv,
					/*14*/nvl(r.codusur,r.codfuncab) as codusur,
					/*15*/nvl(uorig.nome,eorig.nome) as nomeusur,
					/*16*/to_char(r.dtab,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtab,
					/*14*/r.excluido,
					/*18*/to_char(r.dtexclusao,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtexclusao,
					/*19*/case when r.codusur = ". $GLOBALS["usuariosis"]["codusuariosis"] . " or r.codfuncab = ". $GLOBALS["usuariosis"]["codusuariosis"]. " then 1 else 0 end as tipo,
					/*20*/case when r.dtre is not null then 6 else 5 end as status,
					/*20*/1 as statussinc
				FROM
					jumbo.pcrecfunc r
					left outer join jumbo.pcusuari uorig on (uorig.codusur = nvl(r.codusur,r.codfuncab))
					left outer join jumbo.pcempr eorig on (eorig.matricula = nvl(r.codusur,r.codfuncab))
					left outer join jumbo.pcusuari ure on (ure.codusur = r.codfuncre)
					left outer join jumbo.pcempr ere on (ere.matricula = r.codfuncre)
					left outer join jumbo.pcusuari udest on (udest.codusur = r.codfuncdest)
					left outer join jumbo.pcempr edest on (edest.matricula = r.codfuncdest)
					left outer join jumbo.pcsetor sdest on (sdest.codsetor = r.codsetordest)
					left outer join jumbo.pcsetor sorig on (sorig.codsetor = r.codsetororig)
				WHERE
					--r.dtexclusao is null
					--and upper(trim(nvl(r.excluido,'x'))) = 'N'
					--r.dtre is null
					__CONDICCODUSUR__
			";
			$comando_sql = str_ireplace("__CONDICCODUSUR__"," (r.codfuncdest = ". $GLOBALS["usuariosis"]["codusuariosis"] . " or edest.codusur = ". $GLOBALS["usuariosis"]["codusuariosis"] . " or r.codusur = ". $GLOBALS["usuariosis"]["codusuariosis"] . " or r.codfuncab = ". $GLOBALS["usuariosis"]["codusuariosis"] . " ) ",$comando_sql);
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_naturezas_juridicas(&$comhttpsimples){
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					/* 0*/nj.codnatjur,
					/* 1*/upper(translate(lower(nj.tiponatjur),'ãáàçúíéêôóõ','aaacuieeooo')) as tipo,
					/* 2*/upper(translate(lower(nj.descricao),'ãáàçúíéêôóõ','aaacuieeooo')) as descricao,
					/* 3*/1 as statussinc
				FROM
					sjdnatjur nj
				ORDER BY
					1
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_politicas_desconto(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "d.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "d.codcli=" . $prodtemp;
											$condiccli[] = "d.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "d.codcli=-1";
										break;
										}				
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
				select 
					/* 0*/d.coddesconto,
					/* 1*/d.codprod,
					/* 2*/d.percdesc,
					/* 3*/to_char(d.dtinicio,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtinicio,
					/* 4*/to_char(d.dtfim,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtfim,
					/* 5*/d.qtini,
					/* 6*/d.qtfim,
					/* 7*/d.aplicadesconto,
					/* 8*/d.alteraptabela,
					/* 9*/d.prioritaria,
					/*10*/d.prioritariageral,
					/*11*/d.codfilial,
					/*12*/d.codcli,        
					/*13*/d.codrede,
					/*14*/d.codusur,
					1 as statussinc
				from 
					jumbo.pcdesconto d
				where
					d.dtfim >= trunc(sysdate)
					and d.dtinicio <= trunc(sysdate)
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and (d.codfilial is null or (d.codfilial = 99 or d.codfilial = ". $GLOBALS["usuariosis"]["codfilial"] . ")) ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and (d.codusur is null or d.codusur = ". $GLOBALS["usuariosis"]["codusuariosis"] . ")",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_portes_empresas(&$comhttpsimples){
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					/* 0*/pe.codporteemp,
					/* 1*/upper(translate(lower(pe.descricao),'ãáàçúíéêôóõ','aaacuieeooo')) as descricao,
					/* 2*/1 as statussinc
				FROM
					sjdporteemp pe
				ORDER BY
					1
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_positivacao_cliente(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$condicsobjetivo = [];
			$condicsativosjumbo = [];
			$condicsativosaurora = [];
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condictemp);
			}
			$condic_datas = " 
					o.ano = TO_CHAR(SYSDATE, 'yyyy')
					and lower(trim(o.mes)) = lower(trim(sjdpkg_funcs_data.mes_texto(to_number(to_char(sysdate, 'mm'))))) ";
			if (isset($condictemp["datas"])) {
				$datas = $condictemp["datas"][0]["valor"];
				$datas = explode(",",$datas);
				$condic_datas = " to_date(sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'mm/yyyy') between to_date('".$datas[0]."','mm/yyyy') and to_date('".$datas[1]."','mm/yyyy') ";
			}
			if (!isset($condictemp["visao"])) {
				$condictemp["visao"] = [0=>["valor"=>$comhttp->requisicao->requisitar->qual->condicionantes["visao"] ?? "rca"]];				
			} 
			if (isset($condictemp["filial"])) {
				foreach($condictemp["filial"] as $condic) {
					if (!in_array(strtolower(trim($condic["valor"])),Constantes::sinonimos["todos"])) {
						$condicsobjetivo[] = "u.codfilial = " . $condic["valor"];
						$condicsativosjumbo[] = "u.codfilial = " . $condic["valor"];
						$condicsativosaurora[] = "u.codfilial = " . $condic["valor"];
					}
				}
			}
			if (isset($condictemp["supervisor"])) {
				foreach($condictemp["supervisor"] as $condic) {
					if (!in_array(strtolower(trim($condic["valor"])),Constantes::sinonimos["todos"])) {
						$condicsobjetivo[] = "u.codsupervisor = " . $condic["valor"];
						$condicsativosjumbo[] = "u.codsupervisor = " . $condic["valor"];
						$condicsativosaurora[] = "u.codsupervisor = " . $condic["valor"];
					}
				}
			}
			if (isset($condictemp["rca"])) {
				foreach($condictemp["rca"] as $condic) {
					if (!in_array(strtolower(trim($condic["valor"])),Constantes::sinonimos["todos"])) {
						$condicsobjetivo[] = "u.codusur = " . $condic["valor"];
						$condicsativosjumbo[] = "u.codusur = " . $condic["valor"];
						$condicsativosaurora[] = "u.codusur = " . $condic["valor"];
					}
				}
			}
			if (isset($condictemp["produto"])) {
				foreach($condictemp["produto"] as $condic) {
					$condicsobjetivo[] = "o.coditemvisao = '" . $condic["valor"]."'";
				}
			}
			if (count($condicsobjetivo) > 0) {
				$condicsobjetivo = " and " . implode(" and ",$condicsobjetivo);
			} else {
				$condicsobjetivo = "";
			}
			if (count($condicsativosjumbo) > 0) {
				$condicsativosjumbo = " and " . implode(" and ",$condicsativosjumbo);
			} else {
				$condicsativosjumbo = "";
			}
			if (count($condicsativosaurora) > 0) {
				$condicsativosaurora = " and " . implode(" and ",$condicsativosaurora);
			} else {
				$condicsativosaurora = "";
			}
			if (!isset($_SESSION["usuariosis"]) || (isset($_SESSION["usuariosis"]) && ($_SESSION["usuariosis"] === null || count($_SESSION["usuariosis"]) === 0)) ) {
				$_SESSION["usuariosis"] = FuncoesSql::getInstancia()->obter_usuario_sis(["condic"=>$_SESSION["codusur"]])[0];
			}
			switch (strtolower(trim($_SESSION["usuariosis"]["tipousuario"]))){
				case "supervisor":
					$visao = "supervisor";
					$camposselect = " u.codsupervisor AS codentidade,s.nome as descricao, ";
					$camposgroup = " u.codsupervisor,s.nome, ";
					$joins = " join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor) ";
					$camposselectativos = " u.codsupervisor as codentidade, s.nome as descricao, ";
					$camposgroupativos = " u.codsupervisor, s.nome ";
					$joinsativos = " join jumbo.pcusuari u on (u.codusur = a.codentidade) join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor) ";
					$condiccodusur = FuncoesSisJD::rcas_subordinados($comhttp->requisicao->requisitar->qual->codusur);
					if (count($condiccodusur) > 0) {
						$condiccodusur = implode(",",$condiccodusur);
					} else {
						$condiccodusur = $comhttp->requisicao->requisitar->qual->codusur;
					}
					break;
				case "vendedor":
					$visao = "rca";
					$condiccodusur = $comhttp->requisicao->requisitar->qual->codusur;
					$camposselect = " u.codusur AS codentidade,u.nome as descricao, ";
					$camposgroup = " u.codusur,u.nome, ";
					$joins = " ";
					$camposselectativos = " u.codusur as codentidade, u.nome as descricao, ";
					$camposgroupativos = " u.codusur, u.nome ";
					$joinsativos = " join jumbo.pcusuari u on (u.codusur = a.codentidade) ";			
					break;
				case "interno":
					$visao = "rca";
					$condiccodusur = "u.codusur";
					$camposselect = " 1 AS codentidade,null as descricao, ";
					$camposgroup = " 1,null, ";
					$joins = " ";
					$camposselectativos = " 1 as codentidade, null as descricao, ";
					$camposgroupativos = " 1, null ";
					$joinsativos = " join jumbo.pcusuari u on (u.codusur = a.codentidade) ";			
					break;
				default:
					$visao = "rca";
					$condiccodusur = $comhttp->requisicao->requisitar->qual->codusur;
					$camposselect = " u.codusur AS codentidade,u.nome as descricao, ";
					$camposgroup = " u.codusur,u.nome, ";
					$joins = " ";
					$camposselectativos = " u.codusur as codentidade, u.nome as descricao, ";
					$camposgroupativos = " u.codusur, u.nome ";
					$joinsativos = " join jumbo.pcusuari u on (u.codusur = a.codentidade) ";			
					break;
			} 
			$retorno = "
				WITH objetivos_mix_cli AS (
					SELECT
						__CAMPOSSELECT__
						SUM(nvl(o.valor, 0)) AS objetivo,
						SUM(
							CASE
								WHEN o.realizado >(o.valor * o.percmaxating / 100) THEN
									round(o.valor * o.percmaxating / 100, 2)
								ELSE
									o.realizado
							END
						) AS realizado,
						null
					FROM
						sjdobjetivossinergia o
						left outer join jumbo.pcusuari u on (u.codusur = o.codentidade)
						__JOINS__
					WHERE				
						__CONDICDATAS__
						AND o.codcampanhasinergia = 1
						AND o.codentidade IN (
							__CONDICCODUSUR__
						)
						__CONDICSOBJETIVO__
					GROUP BY
						__CAMPOSGROUP__
						null
				), clientes_jumbo_ativ AS (
					SELECT
						c.codusur1 as codentidade,
						u.nome as descricao,
						c.codcli,
						c.cliente,
						c.fantasia,
						greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
						c.limcred,
						c.bloqueio
					FROM
						jumbo.pcclient c
						join jumbo.pcusuari u on (u.codusur = c.codusur1)
						LEFT OUTER JOIN sjdcliente_origem   ca ON ( ca.codcliente = c.codcli )
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
						AND c.codusur1 IN (
							__CONDICCODUSUR__
						)
						__CONDICSATIVOSJUMBO__
					ORDER BY
						limcred DESC,
						greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) DESC
				), clientes_aurora_ativ AS (
					SELECT
						nvl(c.codusur1, nvl(ca.codvendedororigem,ca.codvendedor_erp)) AS codentidade,
						u.nome as descricao,
						nvl(c.codcli, pe.numcnpjcpf) AS codcli,
						nvl(c.cliente, pe.nomerazao) AS cliente,
						nvl(c.fantasia, pe.nomerazao) AS fantasia,
						greatest(nvl(c.dtultcomp, TO_DATE('01/01/0001', 'dd/mm/yyyy')), nvl(ca.dtultcompra_origem, TO_DATE('01/01/0001', 'dd/mm/yyyy'))) AS dtultcomp,
						nvl(c.limcred, 0) AS limcred,
						nvl(c.bloqueio, 'N') AS bloqueio
					FROM
						sjdcliente_origem   ca
						left outer join sjdpessoa_origem pe on (pe.codpessoa = ca.codpessoaorigem)
						join jumbo.pcusuari u on (u.codusur = nvl(ca.codvendedororigem,ca.codvendedor_erp))
						LEFT OUTER JOIN jumbo.pcclient c ON (c.codcli = ca.codcli_erp)
					WHERE
						nvl(c.dtexclusao, NULL) IS NULL
						AND nvl(c.codusur1, nvl(ca.codvendedororigem,ca.codvendedor_erp)) != 150
						AND NOT EXISTS (
							SELECT
								1
							FROM
								clientes_jumbo_ativ cj
							WHERE
								cj.codcli = ca.codcliente
						)
						AND nvl(c.codcli, pe.numcnpjcpf) NOT IN (
							13519,
							13363,
							2848,
							1919,
							3829
						)
						AND nvl(c.codusur1, nvl(ca.codvendedororigem,ca.codvendedor_erp)) IN (
							__CONDICCODUSUR__
						)
						__CONDICSATIVOSAURORA__
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
						codentidade,
						descricao,
						codcli,
						cliente,
						fantasia,
						MAX(dtultcomp) AS dtultcomp,
						limcred,
						bloqueio
					FROM
						clientes_juntos_ativ
					GROUP BY
						codentidade,
						descricao,
						codcli,
						cliente,
						fantasia,
						limcred,
						bloqueio
				), res_cli_ativos_resumo AS (
					SELECT
						__CAMPOSSELECTATIVOS__
						COUNT(1) AS qtativos
					FROM
						res_cli_ativos a
						__JOINSATIVOS__
					GROUP BY
						__CAMPOSGROUPATIVOS__
				)
				SELECT
					ca.codentidade as codentidade,
					ca.descricao as descricao,
					ca.qtativos      AS \"Qtde Cli Ativos\",
					null as descricao2,
					'#CCCCCC' as cor,
					'Clientes Carteira' as legenda,
					'Existem ' || (ca.qtativos - cli.realizado) || ' disponiveis' as legenda2
				FROM
					res_cli_ativos_resumo ca            
					LEFT OUTER JOIN objetivos_mix_cli   cli ON ( cli.codentidade = ca.codentidade )
				union all
				SELECT
					ca.codentidade as codentidade,
					ca.descricao as descricao,
					cli.objetivo      AS \"objetivo\",
					null as descricao2,
					'#007DD6' as cor,
					'Clientes objetivo' as legenda,
					'Faltam ' || (cli.objetivo - cli.realizado) || ' para objetivo' as legenda2
				FROM
					res_cli_ativos_resumo ca            
					LEFT OUTER JOIN objetivos_mix_cli   cli ON ( cli.codentidade = ca.codentidade )
				union all
				SELECT
					ca.codentidade as codentidade,
					ca.descricao as descricao,
					cli.realizado      AS \"realizado\",
					null as descricao2,
					'#008577' as cor,
					'Clientes positivados' as legenda,
					null as legenda2
				FROM
					res_cli_ativos_resumo ca            
					LEFT OUTER JOIN objetivos_mix_cli   cli ON ( cli.codentidade = ca.codentidade )
				";
			$retorno = str_ireplace("__CONDICDATAS__",$condic_datas,$retorno);
			$retorno = str_ireplace("__CONDICCODUSUR__",$condiccodusur,$retorno);
			$retorno = str_ireplace("__CAMPOSSELECT__",$camposselect,$retorno);
			$retorno = str_ireplace("__JOINS__",$joins,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUP__",$camposgroup,$retorno);
			$retorno = str_ireplace("__CAMPOSSELECTATIVOS__",$camposselectativos,$retorno);
			$retorno = str_ireplace("__JOINSATIVOS__",$joinsativos,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUPATIVOS__",$camposgroupativos,$retorno);
			$retorno = str_ireplace("__CONDICSOBJETIVO__",$condicsobjetivo,$retorno);
			$retorno = str_ireplace("__CONDICSATIVOSJUMBO__",$condicsativosjumbo,$retorno);
			$retorno = str_ireplace("__CONDICSATIVOSAURORA__",$condicsativosaurora,$retorno);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			/*$retorno = "
				select 1,'teste',10000,null from dual
				union all
				select 2,'teste2',8000,null from dual
				union all
				select 3,'teste2',7000,null from dual";*/
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_prazos(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condicplpag = [];
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
							if ($condic === "cobranca") {
								if (is_numeric($valor)) {	
									$condicplpag[] = "codplpag=".$valor;
								} else {
									$comando_sql_temp = "select codplpag from jumbo.pcplpag where lower(descricao) like '%$valor%' ";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "codplpag=" . $prodtemp;
											$condicplpag[] = "codplpag=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "codplpag='-1'";
										break;
										}				
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
				SELECT
					/* 0*/codplpag,
					/* 1*/descricao as descplpag,
					/* 2*/numdias,
					/* 3*/numpr,
					/* 4*/vlminpedido,
					/* 5*/pertxfim,
					/* 6*/codfilial,
					/* 7*/1 as statussinc
				FROM
					jumbo.pcplpag
				where
					enviaplanofv = 'S'
					and status = 'A'
					__CONDICPLPAG__
				order by 1
			";
			if (count($condicplpag) > 0) {
				$comando_sql = str_ireplace("__CONDICPLPAG__"," and (".implode(" or ",$condicplpag).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICPLPAG__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_prazos_clientes(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
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
				SELECT
					pl.codplpag || '-' || pl.codcli as codplpag_codcli,
					pl.codplpag,
					pl.codcli,
					1 as statussinc
				FROM
					jumbo.pcplpagcli pl
					join jumbo.pcclient c on (c.codcli = pl.codcli)
					join jumbo.pcusuari u on (u.codusur = c.codusur1)
				where 
					__CONDICCLI__
					__CONDICFILIAL__
					__CONDICCODUSUR__
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," and nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_precos_fixos(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
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
				SELECT
					/* 0*/pf.codprecoprom,
					/* 1*/pf.codprod,
					/* 2*/to_char(pf.dtiniciovigencia,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtiniciovigencia,			
					/* 3*/to_char(pf.dtfimvigencia,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtfimvigencia,
					/* 4*/pf.precofixo,
					/* 5*/pf.numregiao,
					/* 6*/pf.codcli,
					/* 7*/pf.codfilial,
					/* 8*/pf.codrede,
					pf.codusur,
					1 as statussinc
				FROM
					jumbo.pcprecoprom pf
				WHERE
					DTFIMVIGENCIA >= TRUNC(SYSDATE)
					AND DTINICIOVIGENCIA <= TRUNC(SYSDATE)
					AND ENVIAFV = 'S'
					__CONDICCLI__
					__CONDICFILIAL__
				ORDER BY
					codprod
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__","",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and nvl(pf.codfilial,".$GLOBALS["usuariosis"]["codfilial"].") = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_processoscel(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_processos_cel";
			$comando_sql = "
				SELECT
					p.codprocesso,
					p.nomeprocesso,
					p.statussinc
				FROM
					sjdprocessoscel p
				where
					(
						lower(trim(p.nomeapp)) = lower(trim('__NOMEAPP__'))
						or (
							lower(trim(p.nomeapp)) = lower(trim('todos'))
							and not exists(
								select 1 from sjdprocessoscel p2 where lower(trim(p2.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(p2.nomeprocesso)) = lower(trim(p.nomeprocesso))
							)
						)		
					)
					__CONDICTAB__
				order by 1		
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_produtos_completa(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = explode(strtolower(trim(Constantes::sepn1)),strtolower(trim($condictemp)));
			}
			$comhttp->requisicao->requisitar->qual->objeto = "lista_produtos_completa";
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			if (count($condictemp) > 0) {
				foreach($condictemp as $chave=>$condict) {
					if ($condictemp[$chave] !== "array") {
						$condictemp[$chave] = explode(strtolower(trim(Constantes::sepn2)),strtolower(trim($condictemp[$chave])));
					}
					if (count($condictemp[$chave]) > 0) {
						foreach($condictemp[$chave] as $chave2=>$condict2) {
							$condic = strtolower(trim(substr($condictemp[$chave][$chave2],0,strpos($condictemp[$chave][$chave2],"="))));
							$valor = strtolower(trim(substr($condictemp[$chave][$chave2],strpos($condictemp[$chave][$chave2],"=") + 1)));			
							if ($condic === "produto") {
								if (is_numeric($valor)) {	
									} else {
									$comando_sql_temp = "select codprod from jumbo.pcprodut where lower(descricao) like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "produto=" . $prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);
									} else {
										$condictemp[$chave][$chave2] = "produto=-1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condictemp;
			}
			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];
			if (gettype($mostrar_vals_de) !== "array") {
				$mostrar_vals_de = explode(",",$mostrar_vals_de);
			}
			if (count($mostrar_vals_de) > 0) {
				$pfim = stripos($comando_sql," from r ") + 8;
				$comando_sql_antes = substr($comando_sql,0,$pfim);
				$comando_sql_depois = substr($comando_sql,$pfim);
				$condictemp = [];
				if (array_search(0,$mostrar_vals_de) !== false) {
					$condictemp[] = "r.\"qtestdispjumbo\" > 0";
				}
				if (array_search(1,$mostrar_vals_de) !== false) {
					$condictemp[] = "r.\"qtdispaurora\" > 0";
				}
				if (array_search(2,$mostrar_vals_de) !== false) {
					$condictemp[] = "r.\"qtdisptotal\" > 0";
				}
				if (count($condictemp) > 0) {
					$comando_sql = $comando_sql_antes . " where " . implode(" and ",$condictemp) . " " . $comando_sql_depois;
				} else {
					$comando_sql = $comando_sql_antes . " " . $comando_sql_depois;
				}
			}
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_produtos_completa_simples(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condicprod = [];
			$condicregiao = [];
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
							if ($condic === "produto") {
								if (is_numeric($valor)) {	
									$condicprod[] = "\"codprod\"=".$valor;
								} else {
									$comando_sql_temp = "select codprod from jumbo.pcprodut where lower(descricao) like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "\"codprod\"=" . $prodtemp;
											$condicprod[] = "\"codprod\"=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "\"codprod\"=-1";
										break;
										}				
								}
							} else if ($condic === "regiao") {
								if (is_numeric($valor)) {	
									$condicregiao[] = " r.numregiao = ".$valor;
									} else {
									$comando_sql_temp = "select numregiao from jumbo.pcregiao where lower(regiao) like '%$valor%'";
									$regiao_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($regiao_temp) > 0) {
										$condic_substituta = [];
										foreach($regiao_temp as $regtemp) {
											$condic_substituta[] = " r.numregiao = " . $regtemp;
											$condicregiao[] = " r.numregiao = ".$regtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = " r.numregiao = -1";
										break;
										}				
								}
							}
						}
					}
					$condictemp[$chave] = trim(implode(strtolower(trim(Constantes::sepn2)),$condictemp[$chave]));
				}
				$condictemp = trim(implode(strtolower(trim(Constantes::sepn1)),$condictemp));
				$comhttpsimples->c["condicionantes"] = $condictemp;
			}
			$comhttpsimples->d["objeto"] = "lista_produtos_estoque";
			$comando_sql = "
				with 
				transmitidos as (
					select
						c.codfilial,
						i.codprod,
						sum(nvl(i.qt, 0))  as qt
					from
						jumbo.pcpedcfv c
						join jumbo.pcpedifv i on (i.numpedrca = c.numpedrca)
					where
						c.importado = 1        
					group by
						c.codfilial,
						i.codprod
				),
				estjum as (
					SELECT
						e.codfilial AS \"filial\",
						e.codprod        AS \"codprod\",
						pcprodut.descricao   AS \"descricao\",
						pcprodut.unidade     AS \"un\",
						nvl(e.qtestger, 0) - (nvl(e.qtbloqueada,0) + nvl(e.estmin,0)) AS \"qtde jumbo\",
						nvl(e.qtreserv, 0) AS \"reservado\",
						nvl(e.qtpendente, 0) AS \"pendente\",
						nvl(t.qt, 0) AS \"transmitido\",        
						nvl(e.qtestger, 0) - (nvl(e.qtbloqueada,0) + nvl(e.estmin,0) + nvl(e.qtreserv, 0))  AS \"disponivel jumbo\",
						nvl(e.qtestger, 0) - (nvl(e.qtbloqueada,0) + nvl(e.estmin,0) + nvl(e.qtreserv, 0) + nvl(e.qtpendente, 0) + nvl(t.qt, 0)) AS \"previsao disp jumbo\",
						0 AS \"disponivel aurora\",
						nvl(e.qtestger, 0) - (nvl(e.qtbloqueada,0) + nvl(e.estmin,0) + nvl(e.qtreserv, 0)) AS \"disponivel total\",
						nvl(e.qtestger, 0) - (nvl(e.qtbloqueada,0) + nvl(e.estmin,0) + nvl(e.qtreserv, 0) + nvl(e.qtpendente, 0) + nvl(t.qt, 0)) AS \"previsao disp total\",
						(case when nvl(f.fornecedor,'') like '%AUROR%' THEN 1 ELSE 0 END) AS \"aurora\"
					FROM
						jumbo.pcest e
						JOIN jumbo.pcprodut   pcprodut ON ( e.codprod = pcprodut.codprod )        
						LEFT OUTER JOIN JUMBO.PCFORNEC F ON (F.CODFORNEC = pcprodut.CODFORNEC)
						LEFT OUTER JOIN transmitidos t ON ( t.codfilial = e.codfilial AND t.codprod = e.codprod )    
					WHERE
						nvl(lower(TRIM(pcprodut.revenda)), 'x') = ( lower('S') )
						AND pcprodut.dtexclusao IS NULL
						AND lower(nvl(pcprodut.obs2, 'x')) <> lower('FL')
					),
				estaur as (
					SELECT
						sjdestoque_origem.codfilialorigem                AS \"filial\",
						sjdestoque_origem.codprodorigem                  AS \"codprod\",
						nvl(p.descricao,sjdproduto_origem.descricao)   AS \"descricao\",
						nvl(nvl(p.unidade,sjdunidades_origem.unidade),'kg')     AS \"un\",
						0 AS \"qtde jumbo\",
						0 AS \"reservado\",
						0 AS \"pendente\",
						0 AS \"transmitido\",
						0 AS \"disponivel jumbo\",
						0 AS \"previsao disp jumbo\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"disponivel aurora\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"disponivel total\",
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) AS \"previsao disp total\",
						1 AS \"aurora\"
					FROM
						sjdestoque_origem
						LEFT OUTER JOIN sjdproduto_origem sjdproduto_origem ON ( sjdestoque_origem.codprodorigem = sjdproduto_origem.codprod_na_origem )
						LEFT OUTER JOIN sjdunidades_origem on (sjdunidades_origem.codunidade = sjdproduto_origem.codunidadeorigem)
						LEFT OUTER JOIN jumbo.pcprodut p ON ( p.codprod = sjdestoque_origem.codprodorigem )
					where
						nvl(sjdestoque_origem.qtfisicodisponivel, 0) > 0
				),
				estjuntos as (
					select 
						to_number(ej.\"filial\") as \"filial\",
						ej.\"codprod\",
						ej.\"descricao\",
						ej.\"un\",
						ej.\"qtde jumbo\",
						ej.\"reservado\",
						ej.\"pendente\",
						ej.\"transmitido\" as \"transmitido\",
						ej.\"disponivel jumbo\",
						ej.\"previsao disp jumbo\",
						ej.\"disponivel aurora\",
						ej.\"disponivel total\",
						ej.\"previsao disp total\",
						ej.\"aurora\"
					from 
						estjum ej
					union all
					select 
						ea.\"filial\",
						ea.\"codprod\",
						ea.\"descricao\",
						ea.\"un\",
						ea.\"qtde jumbo\",
						ea.\"reservado\",
						ea.\"pendente\",
						ea.\"transmitido\" as \"transmitido\",
						ea.\"disponivel jumbo\",
						ea.\"previsao disp jumbo\",
						ea.\"disponivel aurora\",
						ea.\"disponivel total\",
						ea.\"previsao disp total\",
						ea.\"aurora\"
					from 
						estaur ea
				), 
				estoquecompleto as (
				select
					ej.\"filial\",
					ej.\"codprod\",
					max(nvl(ej.\"descricao\",'sem descricao')) as \"descricao\",
					max(nvl(ej.\"un\",'kg')) as \"un\",
					sum(nvl(ej.\"qtde jumbo\",0)) as \"qtde jumbo\",
					sum(nvl(ej.\"reservado\",0)) as \"reservado\",
					sum(nvl(ej.\"pendente\",0)) as \"pendente\",
					sum(nvl(ej.\"transmitido\",0)) as \"transmitido\",
					sum(nvl(ej.\"disponivel jumbo\",0)) as \"disponivel jumbo\",
					sum(nvl(ej.\"previsao disp jumbo\",0)) as \"previsao disp jumbo\",
					sum(nvl(ej.\"disponivel aurora\",0)) as \"disponivel aurora\",
					sum(nvl(ej.\"disponivel total\",0)) as \"disponivel total\",
					sum(nvl(ej.\"previsao disp total\",0)) as \"previsao disp total\",
					max(nvl(ej.\"aurora\",0)) as \"aurora\"
				from 
					estjuntos ej
				where				
					__CONDICPROD__
					__CONDICFILIAL__
				group by
					ej.\"filial\",
					ej.\"codprod\"
				having 
					(sum(nvl(ej.\"qtde jumbo\",0)) != 0 or sum(nvl(ej.\"disponivel aurora\",0)) !=0)
					and sum(nvl(ej.\"previsao disp total\",0)) != 0
				order by 1,2)
				select
					/*0*/e.\"filial\" || '-' || r.numregiao || '-' || e.\"codprod\" as filialregprod,
					/* 1*/e.\"filial\" as codfilial,
					/* 2*/r.numregiao,
					/* 3*/tr.tipo as tiporegiao,
					/* 4*/e.\"codprod\",
					/* 5*/e.\"descricao\",
					/* 6*/e.\"un\" as unidade,
					/* 7*/e.\"qtde jumbo\" as qtjumbo,
					/* 8*/e.\"reservado\" as qtreserva,
					/* 9*/e.\"pendente\" as qtpendente,
					/*10*/e.\"transmitido\" as transmitido,
					/*11*/e.\"disponivel jumbo\" as qtdispjumbo,
					/*12*/e.\"previsao disp jumbo\" as qtprevdispjumbo,
					/*13*/e.\"disponivel aurora\" as qtdispaur,
					/*14*/e.\"disponivel total\" as qtdisptotal,
					/*15*/e.\"previsao disp total\" as qtprevdisptotal,
					/*16*/e.\"aurora\",
					/*17*/round(pr.pvenda1,2) as pvenda1,
					/*18*/round(pr.pvenda2,2) as pvenda2,
					/*19*/round(pr.pvenda3,2) as pvenda3,
					/*20*/round(pr.pvenda4,2) as pvenda4,
					/*21*/round(pr.pvenda5,2) as pvenda5,
					/*22*/round(pr.pvenda6,2) as pvenda6,
					/*23*/round(pr.perdescmax,2) as percdesc,
					/*24*/nvl(pf.multiplo,p.multiplo) as multiplo,
					/*25*/p.qtunitcx,
					/*26*/to_char(v.dtultvenda,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtultvenda,
					/*27*/v.vltotal,
					/*28*/v.numpedrca,
					/*29*/nvl(p.pesoliq,1) as pesoliq,
					/*30*/nvl(p.pesovariavel,'N') as pesovariavel,
					/*31*/1 as statussinc,
					/*32*/to_char(sysdate,'".VariaveisSql::getInstancia()::$dados_conexoes->{VariaveisSql::getInstancia()->getNomeConexaoPadrao()}->driver->strings->strdataandroid."') as dtatualizacao
				from 
					estoquecompleto e 
					join jumbo.pcregiao r on (r.codfilial = e.\"filial\")
					join jumbo.pctabpr pr on (pr.codprod = e.\"codprod\" and pr.numregiao = r.numregiao)
					join jumbo.pcprodut p on (p.codprod = e.\"codprod\")
					left outer join jumbo.pcprodfilial pf on (pf.codfilial = e.\"filial\" and pf.codprod = e.\"codprod\")
					left outer join sjdprodrcaultvenda v on (v.codprod = e.\"codprod\" and v.codrca = ".$GLOBALS["usuariosis"]["codusuariosis"]." ) 
					left outer join sjdtiporegiao tr on (tr.codregiao = r.numregiao)
				where	
					r.status = 'A'
					and nvl(pr.pvenda1,0) > 0
					__CONDICREGIAOFILIAL__
					__CONDICREGIAO__
				order by 
					2,3,5
			";
			if (count($condicprod) > 0) {
				$comando_sql = str_ireplace("__CONDICPROD__"," (".implode(" or ",$condicprod).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICPROD__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," and ej.\"filial\" = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
				$comando_sql = str_ireplace("__CONDICREGIAOFILIAL__"," and r.codfilial = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","",$comando_sql);
				$comando_sql = str_ireplace("__CONDICREGIAOFILIAL__","",$comando_sql);
			}
			if (count($condicregiao) > 0) {
				$comando_sql = str_ireplace("__CONDICREGIAO__"," and (".implode(" or ",$condicregiao).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICREGIAO__","",$comando_sql);
			}	
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_restricoes_prazos(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictemp = [];
			$condiccli = [];
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
							if ($condic === "cliente") {
								if (is_numeric($valor)) {	
									$condiccli[] = "c.codcli=".$valor;
								} else {
									$comando_sql_temp = "select codcli from jumbo.pcclient where lower(cliente) like '%$valor%' or lower(fantasia) like '%$valor%' or cgcent like '%$valor%'";
									$produtos_temp = FuncoesSql::getInstancia()->executar_sql($comando_sql_temp,"fetchAll",\PDO::FETCH_COLUMN,0);
									if (count($produtos_temp) > 0) {
										$condic_substituta = [];
										foreach($produtos_temp as $prodtemp) {
											$condic_substituta[] = "c.codcli=" . $prodtemp;
											$condiccli[] = "c.codcli=".$prodtemp;
										}
										$condictemp[$chave][$chave2] = implode(strtolower(trim(Constantes::sepn2)),$condic_substituta);								
									} else {
										$condictemp[$chave][$chave2] = "c.codcli=-1";
										break;
										}				
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
				SELECT
					/* 0*/pl.codplpag || '-' || pl.codrestricao || '-' || pl.tiporestricao  as codplpagcodrestrrestr,
					/* 1*/pl.codplpag,
					/* 2*/pl.codrestricao,
					/* 3*/pl.tiporestricao,
					1 as statussinc
				FROM
					jumbo.pcplpagrestricao pl
					left outer join jumbo.pcclient c on (c.codcli = pl.codrestricao)
					left outer join jumbo.pcusuari u on (u.codusur = c.codusur1)
				where 
					(c.codcli is null or (__CONDICCLI__))
					/*and (u.codfilial is null or (__CONDICFILIAL__))
					and (u.codusur is null or (__CONDICCODUSUR__)) estas condicao nao pode ser efetuada pq o app precisa saber a restricao de outros clientes
					para efetivamente conseguir apurar  a restricao para seu cliente*/
				order by 1,2	
			";
			if (count($condiccli) > 0) {
				$comando_sql = str_ireplace("__CONDICCLI__"," (".implode(" or ",$condiccli).") ",$comando_sql);
				} else {
				$comando_sql = str_ireplace("__CONDICCLI__"," 1=1 ",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) >= 30) {
				$comando_sql = str_ireplace("__CONDICFILIAL__"," nvl(u.codfilial,c.codfilialnf) = ". $GLOBALS["usuariosis"]["codfilial"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICFILIAL__","1=1",$comando_sql);
			}
			if (intval($GLOBALS["usuariosis"]["codnivelacesso"]) === 50) {
				$comando_sql = str_ireplace("__CONDICCODUSUR__"," nvl(u.codusur,c.codusur1) = ". $GLOBALS["usuariosis"]["codusuariosis"],$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICCODUSUR__","1=1",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_tabeladbcel(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_tabelasdbcel";
			$comando_sql = "
				SELECT
					t.codtabeladb,
					t.nometabeladb,
					t.statussinc
				FROM
					sjdtabeladbcel t
				where
					(
						lower(trim(t.nomeapp)) = lower(trim('__NOMEAPP__'))
						or (
							lower(trim(t.nomeapp)) = lower(trim('todos'))
							and not exists(select 1 from sjdtabeladbcel t2 where lower(trim(t2.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t2.nometabeladb)) = lower(trim(t.nometabeladb)))					
						)
					) 			 
					 __CONDICTAB__
				order by 1,3	
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_tipos_empresas(&$comhttpsimples){
			$comando_sql = "";	
			$comando_sql = "
				SELECT
					/* 0*/tp.codtipoemp,
					/* 1*/tp.descricao,
					/* 2*/1 as statussinc
				FROM
					sjdtipoemp tp
				ORDER BY
					1
			";
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_volumes(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$condics = [];
			$condictemp = [];
			//print_r($comhttp->requisicao->requisitar->qual->condicionantes); exit();
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));
			}
			//print_r($condictemp); exit();
			if (gettype($condictemp) !== "array") {
				$condictemp = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condictemp);
			}			
			$condic_datas = " 
					o.ano = TO_CHAR(SYSDATE, 'yyyy')
					and lower(trim(o.mes)) = lower(trim(sjdpkg_funcs_data.mes_texto(to_number(to_char(sysdate, 'mm'))))) ";
			if (isset($condictemp["datas"])) {
				$datas = $condictemp["datas"][0]["valor"];
				$datas = explode(",",$datas);
				$condic_datas = " to_date(sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'mm/yyyy') between to_date('".$datas[0]."','mm/yyyy') and to_date('".$datas[1]."','mm/yyyy') ";
			}
			if (!isset($condictemp["visao"])) {
				$condictemp["visao"] = [0=>["valor"=>$comhttp->requisicao->requisitar->qual->condicionantes["visao"] ?? "rca"]];
			} 
			if (isset($condictemp["filial"])) {
				foreach($condictemp["filial"] as $condic) {
					$condics[] = "u.codfilial = " . $condic["valor"];
				}
			}
			if (isset($condictemp["supervisor"])) {
				foreach($condictemp["supervisor"] as $condic) {
					$condics[] = "u.codsupervisor = " . $condic["valor"];
				}
			}
			if (isset($condictemp["rca"])) {
				foreach($condictemp["rca"] as $condic) {
					$condics[] = "u.codusur = " . $condic["valor"];
				}
			}
			if (isset($condictemp["produto"])) {
				foreach($condictemp["produto"] as $condic) {
					$condics[] = "o.coditemvisao = '" . $condic["valor"]."'";
				}
			}
			if (!isset($_SESSION["usuariosis"]) || (isset($_SESSION["usuariosis"]) && ($_SESSION["usuariosis"] === null || count($_SESSION["usuariosis"]) === 0)) ) {
				$_SESSION["usuariosis"] = FuncoesSql::getInstancia()->obter_usuario_sis(["condic"=>$_SESSION["codusur"]])[0];
				if (strcasecmp(trim($condictemp["visao"][0]["valor"]),"geral") == 0) {
					if (strcasecmp(trim($_SESSION["usuariosis"]["podever"]),"tudo") == 0) {
						$condictemp["visao"][0]["valor"] = "Filial";
					} else {
						switch(strtolower(trim($_SESSION["usuariosis"]["tipousuario"]))) {
							case "interno":
								$condictemp["visao"][0]["valor"] = "Filial";
								break;
							case "supervisor":
								$condictemp["visao"][0]["valor"] = "Supervisor";
								break;
							case "rca": default:
								$condictemp["visao"][0]["valor"] = "Rca";
								break;						
						}
					}
				}
			} 
			$codusuracessiveis = [];
			if (!isset($_SESSION["usuarios_acessiveis"])) {
				$_SESSION["usuarios_acessiveis"] = FuncoesSisJD::obter_usuarios_acessiveis($_SESSION["usuariosis"],["*"],true,true);
				foreach($_SESSION["usuarios_acessiveis"] as $usur) {
					$codusuracessiveis[] = $usur["codusuariosis"];
				}
			}
			if (count($codusuracessiveis) > 0) {
				$condics[] = "u.codusur in (".implode(",",$codusuracessiveis).")";
			} 
			if (count($condics) > 0) {
				$condics = " and " . implode(" and ",$condics);
			} else {
				$condics = "";
			}
			$retorno = "
					with dados as (
						SELECT
							__CAMPOSSELECT__
							round(sum(
								case 
									when o.realizado / o.valor * 100 > o.percmaxating then o.valor
									else o.realizado
								end
							)) as realizadoliq,
							null as observacoes
						FROM
							sjdobjetivossinergia o 
							join jumbo.pcusuari u on (u.codusur = o.codentidade)
							__JOINS__
						WHERE
							" . $condic_datas . " 
							and o.codcampanhasinergia = 0
							and lower(trim(o.entidade)) = 'rca'
							and lower(trim(o.visao)) = 'produto' 
							and lower(trim(o.unidade)) = 'kg'
							__CONDICS__
						group by
							__CAMPOSGROUP__
							null)
					select * from dados 
					union all
					select __CAMPOSSELECTNULL__
							MAX(realizadoliq),
							null as observacoes
						FROM
							dados 
						group by
							__CAMPOSGROUPNULL__
							null
					order by 1
					";
			$camposselectnull = "9999999999,null,";
			$camposgroupnull = "9999999999,null,";
			switch(strtolower(trim($condictemp["visao"][0]["valor"]))) {
				case "filial":
					$camposselect = "u.codfilial,f.cidade,";
					$joins = "left outer join jumbo.pcfilial f on (f.codigo = u.codfilial)";
					$camposgroup = "u.codfilial,f.cidade,";
					$camposselectnull = "to_char(9999999999),null,";
					$camposgroupnull = "to_char(9999999999),null,";
					break;
				case "supervisor":
					$camposselect = "u.codsupervisor,s.nome,";
					$joins = "left outer join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor)";
					$camposgroup = "u.codsupervisor,s.nome,";
					break;
				case "rca":
					$camposselect = "o.codentidade,u.nome,";
					$joins = "";
					$camposgroup = "o.codentidade,u.nome,";
					break;
				case "produto":
					$camposselect = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod) as descricao,";
					$joins = "left outer join jumbo.pcprodut p on (p.codprod = case when instr(lower(o.coditemvisao),'g') > 0 THEN -1 else to_number(o.coditemvisao) end)left outer join sjdgruposprodequiv g on (g.codvisivelgrupo = o.coditemvisao)";
					$camposgroup = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod),";
					$camposselectnull = "'9999999999',null,";
					$camposgroupnull = "'9999999999',null,";
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("visao nao definida: " . $condictemp["visao"][0]["valor"],__FILE__,__FUNCTION__,__LINE__);
			}
			$retorno = str_ireplace("__CAMPOSSELECT__",$camposselect,$retorno);
			$retorno = str_ireplace("__JOINS__",$joins,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUP__",$camposgroup,$retorno);
			$retorno = str_ireplace("__CONDICS__",$condics,$retorno);
			$retorno = str_ireplace("__CAMPOSSELECTNULL__",$camposselectnull,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUPNULL__",$camposgroupnull,$retorno);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_volumes_rca(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$codsuperior = 6;
			$retorno = "
				SELECT
					o.codentidade,
					sum(o.valor) as objetivo,
					sum(
						case 
							when o.realizado / o.valor * 100 > o.percmaxating then o.valor
							else o.realizado
						end
					) as realizadoliq,
					sum(
						case 
							when o.realizado / o.valor * 100 > o.percmaxating then o.valor
							else o.realizado
						end
					) / decode(sum(o.valor),null,1,0,1,sum(o.valor)) * 100 as percating,
					sum(o.valor) - sum(
						case 
							when o.realizado / o.valor * 100 > o.percmaxating then o.valor
							else o.realizado
						end
					) as falta
				FROM
					sjdobjetivossinergia o 
					join jumbo.pcusuari u on (u.codusur = o.codentidade)
				WHERE
					o.codcampanhasinergia = 0
					and lower(trim(o.entidade)) = 'rca'
					and lower(trim(o.visao)) = 'produto' 
					and lower(trim(o.unidade)) = 'kg'
					and o.ano = TO_CHAR(SYSDATE, 'yyyy')
					and lower(trim(o.mes)) = lower(trim(sjdpkg_funcs_data.mes_texto(to_number(to_char(sysdate, 'mm')))))
					/*and u.codsupervisor = " .$codsuperior . "*/
				group by
					o.codentidade
				order by 
					1
			";
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_lista_volumes_x_meta(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$condics = [];
			$condictemp = [];
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
				$condictemp = strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));
			}
			if (gettype($condictemp) !== "array") {
				$condictemp = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condictemp);
			}
			$condic_datas = " 
					o.ano = TO_CHAR(SYSDATE, 'yyyy')
					and lower(trim(o.mes)) = lower(trim(sjdpkg_funcs_data.mes_texto(to_number(to_char(sysdate, 'mm'))))) ";
			if (isset($condictemp["datas"])) {
				$datas = $condictemp["datas"][0]["valor"];
				$datas = explode(",",$datas);
				$condic_datas = " to_date(sjdpkg_funcs_data.mes_numero(o.mes)||'/'||o.ano,'mm/yyyy') between to_date('".$datas[0]."','mm/yyyy') and to_date('".$datas[1]."','mm/yyyy') ";
			}
			if (!isset($condictemp["visao"])) {
				$condictemp["visao"] = [0=>["valor"=>$comhttp->requisicao->requisitar->qual->condicionantes["visao"] ?? "rca"]];
			} 
			if (isset($condictemp["filial"])) {
				foreach($condictemp["filial"] as $condic) {
					$condics[] = "u.codfilial = " . $condic["valor"];
				}
			}
			if (isset($condictemp["supervisor"])) {
				foreach($condictemp["supervisor"] as $condic) {
					$condics[] = "u.codsupervisor = " . $condic["valor"];
				}
			}
			if (isset($condictemp["rca"])) {
				foreach($condictemp["rca"] as $condic) {
					$condics[] = "u.codusur = " . $condic["valor"];
				}
			}
			if (isset($condictemp["produto"])) {
				foreach($condictemp["produto"] as $condic) {
					$condics[] = "o.coditemvisao = '" . $condic["valor"]."'";
				}
			}
			if (!isset($_SESSION["usuariosis"]) || (isset($_SESSION["usuariosis"]) && ($_SESSION["usuariosis"] === null || count($_SESSION["usuariosis"]) === 0)) ) {
				$_SESSION["usuariosis"] = FuncoesSql::getInstancia()->obter_usuario_sis(["condic"=>$_SESSION["codusur"]])[0];
				if (strcasecmp(trim($condictemp["visao"][0]["valor"]),"geral") == 0) {
					if (strcasecmp(trim($_SESSION["usuariosis"]["podever"]),"tudo") == 0) {
						$condictemp["visao"][0]["valor"] = "Filial";
					} else {
						switch(strtolower(trim($_SESSION["usuariosis"]["tipousuario"]))) {
							case "interno":
								$condictemp["visao"][0]["valor"] = "Filial";
								break;
							case "supervisor":
								$condictemp["visao"][0]["valor"] = "Supervisor";
								break;
							case "rca": default:
								$condictemp["visao"][0]["valor"] = "Rca";
								break;						
						}
					}
				}
			}
			$codusuracessiveis = [];
			if (!isset($_SESSION["usuarios_acessiveis"])) {
				$_SESSION["usuarios_acessiveis"] = FuncoesSisJD::obter_usuarios_acessiveis($_SESSION["usuariosis"],["*"],true,true);
				foreach($_SESSION["usuarios_acessiveis"] as $usur) {
					$codusuracessiveis[] = $usur["codusuariosis"];
				}
			}
			if (count($codusuracessiveis) > 0) {
				$condics[] = "u.codusur in (".implode(",",$codusuracessiveis).")";
			} 
			if (count($condics) > 0) {
				$condics = " and " . implode(" and ",$condics);
			} else {
				$condics = "";
			}
			$retorno = "
				with dados as (
					SELECT
						__CAMPOSSELECT__
						round(sum(o.valor)) as objetivo,
						round(sum(
							case 
								when o.realizado / o.valor * 100 > o.percmaxating then o.valor
								else o.realizado
							end
						)) as realizadoliq,
						round(sum(
							case 
								when o.realizado / o.valor * 100 > o.percmaxating then o.valor
								else o.realizado
							end
						) / decode(sum(o.valor),null,1,0,1,sum(o.valor)) * 100) as percating,
						null as observacoes
					FROM
						sjdobjetivossinergia o 
						join jumbo.pcusuari u on (u.codusur = o.codentidade)
						__JOINS__
					WHERE
						" . $condic_datas . " 
						and o.codcampanhasinergia = 0
						and lower(trim(o.entidade)) = 'rca'
						and lower(trim(o.visao)) = 'produto' 
						and lower(trim(o.unidade)) = 'kg'
						__CONDICS__
					group by
						__CAMPOSGROUP__
						null
					order by 
						1
				)
				select * from dados 
				union all
				select __CAMPOSSELECTNULL__
						MAX(objetivo),
						MAX(realizadoliq),
						MAX(percating),
						null as observacoes
					FROM
						dados 
					group by
						__CAMPOSGROUPNULL__
						null
			";
			$camposselectnull = "9999999999,null,";
			$camposgroupnull = "9999999999,null,";
			switch(strtolower(trim($condictemp["visao"][0]["valor"]))) {
				case "filial":
					$camposselect = "u.codfilial,f.cidade,";
					$joins = "left outer join jumbo.pcfilial f on (f.codigo = u.codfilial)";
					$camposgroup = "u.codfilial,f.cidade,";
					$camposselectnull = "to_char(9999999999),null,";
					$camposgroupnull = "to_char(9999999999),null,";
					break;
				case "supervisor":
					$camposselect = "u.codsupervisor,s.nome,";
					$joins = "left outer join jumbo.pcsuperv s on (s.codsupervisor = u.codsupervisor)";
					$camposgroup = "u.codsupervisor,s.nome,";
					break;
				case "rca":
					$camposselect = "o.codentidade,u.nome,";
					$joins = "";
					$camposgroup = "o.codentidade,u.nome,";
					break;
				case "produto":
					$camposselect = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod) as descricao,";
					$joins = "left outer join jumbo.pcprodut p on (p.codprod = case when instr(lower(o.coditemvisao),'g') > 0 THEN -1 else to_number(o.coditemvisao) end)left outer join sjdgruposprodequiv g on (g.codvisivelgrupo = o.coditemvisao)";
					$camposgroup = "o.coditemvisao,nvl(p.descricao,g.nomegrupoprod),";
					$camposselectnull = "'G9999999999',null,";
					$camposgroupnull = "'G9999999999',null,";
					break;
				default:
					FuncoesBasicasRetorno::mostrar_msg_sair("visao nao definida: " . $condictemp["visao"],__FILE__,__FUNCTION__,__LINE__);
			}
			$retorno = str_ireplace("__CAMPOSSELECT__",$camposselect,$retorno);
			$retorno = str_ireplace("__JOINS__",$joins,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUP__",$camposgroup,$retorno);
			$retorno = str_ireplace("__CONDICS__",$condics,$retorno);
			$retorno = str_ireplace("__CAMPOSSELECTNULL__",$camposselectnull,$retorno);
			$retorno = str_ireplace("__CAMPOSGROUPNULL__",$camposgroupnull,$retorno);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			/*$retorno = "
				select 1,'teste',10000,9000,90,null from dual
				union all
				select 2,'teste2',8000,7000,90,null from dual
				union all
				select 3,'teste2',7000,5000,90,null from dual
				union all
				select 4,'teste2',6000,5000,90,null from dual
				union all
				select 5,'teste2',5000,4000,90,null from dual
				union all
				select 6,'teste2',3000,2000,90,null from dual
				union all
				select 7,'teste2',1000,1000,90,null from dual
				union all
				select 8,'teste2',20,10,90,null from dual
				union all
				select 9999999,null,10000,9000,90,null from dual";	
			$comhttp->requisicao->sql->comando_sql = $retorno;*/
			//FuncoesArquivo::escrever_arquivo("temp.txt",$comhttp->requisicao->sql->comando_sql);
			return $retorno;
		}
		public static function montar_sql_consulta_pedido(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$codprocesso = 10300; 
			$processo_temp = FuncoesSql::getInstancia()->obter_processo(["condic"=>"codprocesso=$codprocesso","unico"=>true]);
			$comhttp->requisicao->requisitar->qual->objeto = $processo_temp["processo"];
			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp,"lista");
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];
			if (gettype($mostrar_vals_de) !== "array") {
				$mostrar_vals_de = explode(",",$mostrar_vals_de);
			}
			foreach($mostrar_vals_de as $chave=>&$valor) {
				if ($valor === 0 || $valor === "0") {
					$valor = "'R'";
				} else if ($valor === 1 || $valor === "1") {
					$valor = "'C'";
				} else if ($valor === 2 || $valor === "2") {
					$valor = "'B'";
				} else if ($valor === 3 || $valor === "3") {				
					$valor = "'P'";
				} else if ($valor === 4 || $valor === "4") {
					$valor = "'L'";
				} else if ($valor === 5 || $valor === "5") {
					$valor = "'M'";
				} else if ($valor === 6 || $valor === "6") {
					$valor = "'F'";
				} else {
					unset($mostrar_vals_de[$chave]);
				}
			}
			$comando_sql = "select * from (" . $comando_sql . ") where upper(nvl(posicao,'x')) in (".implode(",",$mostrar_vals_de).")";
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_consulta_relatorio_majoracao_cc_rca(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			if (gettype($comhttp->requisicao->requisitar->qual->condicionantes["datas"]) !== "array") {
				$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["datas"]);
			}
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [
				"USUARIOSIS"=>[
					"CODUSUR"=>[
						"texto"=>"CODUSUR"
					],
					"NOME" => [
						"texto"=> "NOME"
					]
				]
			];
			$filial_in = [];
			$filial_not_in = [];
			$rca_in = [];
			$rca_not_in = [];
			if (FuncoesArray::verif_valor_chave($comhttp->requisicao->requisitar->qual->condicionantes,["condicionantes"],0,"quantidade","maior") === true) {
				$condicionantes = FuncoesProcessoSql::prepararCondicionantesProcessoSql($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
				if (count($condicionantes) > 0) {
					foreach($condicionantes as $condicionante) {
						foreach($condicionante as $condic) {
							if (strcasecmp(trim($condic["processo"]),"filial") == 0) {
								if ($condic["op"] === "=") {
									$filial_in[] = $condic["valor"];
								} else {
									$filial_not_in[] = $condic["valor"];
								}
							} else if (strcasecmp(trim($condic["processo"]), "rca") == 0) {
								if ($condic["op"] === "=") {
									$rca_in[] = $condic["valor"];
								} else {
									$rca_not_in[] = $condic["valor"];
								}
							}
						}
					}
				}
			}
			$criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($_SESSION["codusur"],FuncoesSql::getInstancia()->obter_criterios_acesso($_SESSION["codusur"],"pcusuari"));
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit_num_vis"] = 1;
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = "Rca";
			$comando_sql = "";
			$comando_sql = "
				with creditos as (
					select
						pclogrca.codusur,
						pcusuari.nome,
						pcfornec.codfornec,
						pcfornec.fornecedor,
						nvl(pclogrca.vlcorrente,0) - nvl(pclogrca.vlcorrenteant,0) as valortotal0
					from 
						jumbo.pclogrca
						join jumbo.pcusuari on (pcusuari.codusur = pclogrca.codusur)
						join jumbo.pcprodut on (pcprodut.codprod = pclogrca.codprod)
						join jumbo.pcfornec on (pcfornec.codfornec = pcprodut.codfornec)
					where 
						pclogrca.data between '" . $comhttp->requisicao->requisitar->qual->condicionantes["datas"][0] . "' and '" . $comhttp->requisicao->requisitar->qual->condicionantes["datas"][1] . "'
						and lower(pclogrca.historico) like '%major%' ";
			if (count($filial_in) > 0) {
				$comando_sql .= "
						and pcusuari.codfilial in (" . implode(",",$filial_in) . ") ";
			}
			if (count($filial_not_in) > 0) {
				$comando_sql .= "
						and pcusuari.codfilial not in (" . implode(",",$filial_not_in) . ") ";
			}
			if (count($rca_in) > 0) {
				$comando_sql .= "
						and pcusuari.codusur in (" . implode(",",$rca_in) . ") ";
			}
			if (count($rca_not_in) > 0) {
				$comando_sql .= "
						and pcusuari.codusur not in (" . implode(",",$rca_not_in) . ") ";
			}
			if (count($criterios_acesso) > 0) {
				$comando_sql .= "
						and " . implode(" and ",$criterios_acesso) . " ";
			}
			$comando_sql .= "
				)
				select 
					* 
				from 
					creditos 
				pivot xml
				(
					sum(valortotal0) as valortotal0
					for (codfornec,fornecedor) in (any,any)
				)	
			";
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			$comhttp->requisicao->sql->pivot = true;
			return $retorno;
		}
		public static function acrescentar_arr_tit(&$arr,$arr_acresc,$nome_rating,$mostrar_valores = false, $mostrar_ratings_individuais = false, $chacar_de = true) {
			foreach($arr_acresc as $chave=>&$valor) {
				if (stripos($chave,"De ") !== false && $chacar_de === true) {
					$nova_chave = $chave;
					$cont = 0;
					while (in_array($nova_chave,array_keys($arr))) {
						$nova_chave = $chave . "_" . $cont;
						$cont++;
					}
					$arr[$nova_chave] = $valor;
					self::acrescentar_arr_tit($arr[$nova_chave],$valor,$nome_rating, $mostrar_valores, $mostrar_ratings_individuais);
				} else {
					if (stripos(trim($chave),"quantidade") !== false 
						|| stripos(trim($chave),"pesototal") !== false
						|| stripos(trim($chave),"valortotal") !== false) {
						if ($mostrar_ratings_individuais === true) {
							$arr[$nome_rating] = ["texto"=>$nome_rating,"codligcamposis"=>null,"formatacao"=>"cel_quantdec_med"];
						}
						if (!$mostrar_valores) {
							unset($arr[$chave]);
						}
					} else {
						if (!isset($arr[$chave])) {
							$arr[$chave] = $valor;
							self::acrescentar_arr_tit($arr[$chave],$valor,$nome_rating, $mostrar_valores, $mostrar_ratings_individuais,false);
						} else {
							if (gettype($valor) === "array") {
								self::acrescentar_arr_tit($arr[$chave],$valor,$nome_rating, $mostrar_valores, $mostrar_ratings_individuais);
							}
						}
					}
				}
			}
		}
		public static function montar_sql_consulta_relatorio_ratings_focais(&$comhttp){
			$mostrar_valores = false;
			$mostrar_ratings_individuais = false;
			if (in_array("10",$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"]) ||
				in_array(10,$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"])) {
				$mostrar_valores = true;
			}
			if (in_array("11",$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"]) ||
				in_array(11,$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"])) {
				$mostrar_ratings_individuais = true;
			}
			$condicionantes_processo = FuncoesProcessoSql::prepararCondicionantesProcessoSql($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]);
			$comando_sql = "select * from sjdratingsvenda";
			$dados_rating = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			if (count($dados_rating) > 0) {
				$comando_sql = "select CODITEMRATING,CODRATING,NOME,FORMAAPURACAO,DECODE(NVL(MULTIPLICADOR,1),0,1,NVL(MULTIPLICADOR,1)) AS MULTIPLICADOR, condicionantes from sjditensrating where codrating = ".$dados_rating[0]["codratingvenda"];
				$comando_sql_fetch_all = "select CODITEMRATING,CODRATING,NOME,FORMAAPURACAO,DECODE(NVL(MULTIPLICADOR,1),0,1,NVL(MULTIPLICADOR,1)) AS MULTIPLICADOR from sjditensrating where codrating = ".$dados_rating[0]["codratingvenda"];
				$comando_sql_cont = "select count(1) from (" . $comando_sql . ")";
				$dados_itens_rating = FuncoesSql::getInstancia()->executar_sql($comando_sql);				
				$dados_itens_rating_fetch_all = FuncoesSql::getInstancia()->executar_sql($comando_sql_fetch_all,"fetchAll",\PDO::FETCH_ASSOC);
				$qtitensrating = FuncoesSql::getInstancia()->executar_sql($comando_sql_cont,"fetchColumn");				
				if (count($dados_itens_rating) > 0) {
					$comandos_ratings = [];
					$arr_tit = [];
					$proc_est = [];
					$ind_item_rating = -1;
					while($item_rating = $dados_itens_rating["result"]->fetch(\PDO::FETCH_ASSOC) ) {
						$ind_item_rating++;
						$condic_zerados = [];
						$tabelas_vinculos_finais = [];
						$condicionantes_vinculos_finais = [];
						$comando_sql = "select * from sjdcompitemrating where coditemrating = ".$item_rating["coditemrating"];
						$dados_comp_item_rating = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
						
						$condicionantes_rating = "";
						if (count($dados_comp_item_rating) > 0) {
							$condicionantes_rating = [];
							foreach($dados_comp_item_rating as $comp_item_rating) {
								if (!isset($condicionantes_rating[$comp_item_rating["visao"]])) {
									$condicionantes_rating[$comp_item_rating["visao"]] = [];
								}
								if (strlen(trim($comp_item_rating["coditemvisao"])) > 0) {
									$itens_visao = explode(",",$comp_item_rating["coditemvisao"]);
									foreach($itens_visao as $item_visao) {
										if (strlen(trim($item_visao)) > 0) {
											$condicionantes_rating[$comp_item_rating["visao"]][] =  $item_visao;
											if (in_array(strtolower(trim($comp_item_rating["visao"])),["filial","supervisor","rca"])) {
												switch(strtolower(trim($comp_item_rating["visao"]))) {
													case "rca":
														if (!isset($condic_zerados["sjdusuariosis"])) {
															$condic_zerados["sjdusuariosis"] = [];
														}
														if (!isset($condic_zerados["sjdusuariosis"]["="])) {
															$condic_zerados["sjdusuariosis"]["="] = [];
														}
														$condic_zerados["sjdusuariosis"]["="][] = "usuarios.codusuariosis=" . $item_visao;
														break;
													case "supervisor":
														if (!in_array("jumbo.pcsuperv pcsuperv",$tabelas_vinculos_finais)) {
															$tabelas_vinculos_finais[] = "jumbo.pcsuperv pcsuperv";
															$condicionantes_vinculos_finais[] =  "pcsuperv.codsupervisor = pcusuari.codsupervisor";
														}
														if (!isset($condic_zerados["pcsuperv"])) {
															$condic_zerados["pcsuperv"] = [];
														}
														if (!isset($condic_zerados["pcsuperv"]["="])) {
															$condic_zerados["pcsuperv"]["="] = [];
														}
														$condic_zerados["pcsuperv"]["="][] = "pcsuperv.codsupervisor=" . $item_visao;
														break;
													case "filial":
														if (!in_array("jumbo.pcfilial pcfilial",$tabelas_vinculos_finais)) {
															$tabelas_vinculos_finais[] = "jumbo.pcfilial pcfilial";
															$condicionantes_vinculos_finais[] =  "pcfilial.codigo = pcusuari.codfilial";
														}
														if (!isset($condic_zerados["pcfilial"])) {
															$condic_zerados["pcfilial"] = [];
														}
														if (!isset($condic_zerados["pcfilial"]["="])) {
															$condic_zerados["pcfilial"]["="] = [];
														}
														$condic_zerados["pcfilial"]["="][] = "pcfilial.codigo=" . $item_visao;												
														break;
													default:
														break;
												}
											}
										}
									}
								}
							}
							foreach($condicionantes_rating as $chave=>&$condic) {
								$condic = $chave . "=" . implode(Constantes::sepn2 . $chave . "=",$condic);
							}
							$condicionantes_rating = implode(Constantes::sepn1,$condicionantes_rating);
						}
						$item_rating["condicionantes"] = stream_get_contents($item_rating["condicionantes"]);
						if (strlen(trim($item_rating["condicionantes"])) > 0) {
							if (strlen(trim($condicionantes_rating)) > 0) {
								$condicionantes_rating .= Constantes::sepn1.$item_rating["condicionantes"];
							} else {
								$condicionantes_rating = $item_rating["condicionantes"];
							}
						}
						$comhttp_rating = unserialize(serialize($comhttp));
						$comhttp_rating->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
						$comhttp_rating->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp_rating->requisicao->requisitar->qual->objeto);
						$comhttp_rating->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
						if (isset($comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"])) {
							if (strlen(trim($comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"])) > 0) {
								$comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"] .= Constantes::sepn1 . $condicionantes_rating;
							} else {
								$comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condicionantes_rating;
							}
						} else {
							$comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condicionantes_rating;
						}
						$condicionantes_processo = $comhttp_rating->requisicao->requisitar->qual->condicionantes["condicionantes"];
						$condicionantes_processo = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condicionantes_processo);
						$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_rating);
						$comando_sql = trim(str_replace("  "," ",$comando_sql));
						self::acrescentar_arr_tit($arr_tit,$comhttp_rating->requisicao->requisitar->qual->condicionantes["arr_tit"], trim(str_ireplace("FORNECEDOR","",str_ireplace("FORNECEDORES","",$item_rating["nome"]))), $mostrar_valores, $mostrar_ratings_individuais);
						$proc_est = $comhttp_rating->requisicao->requisitar->qual->condicionantes["processo_estruturado"];
						$comando_sql = "select * from (" . $comando_sql . ") " ;
						$pos = 0;					
						$pos = stripos($comando_sql,"resultante_intermediaria as (");					
						$pos = stripos($comando_sql,"select",$pos);					
						$posfim = stripos($comando_sql," from ", $pos);
						$campos_vinculos = str_replace('"',"",trim(substr($comando_sql,$pos,$posfim - $pos)));
						$campos_vinculos = explode(" as ",$campos_vinculos);				
						array_pop($campos_vinculos);
						foreach($campos_vinculos as &$campo_vinc) {
							$campo_vinc = str_ireplace("select ","",$campo_vinc);
							$campo_vinc = explode(",",$campo_vinc);
							if (count($campo_vinc) > 1) {
								array_shift($campo_vinc);
							}
							$campo_vinc = implode(",",$campo_vinc);
						}
						$campos_vinculos_finais = [];
						foreach($campos_vinculos as &$campo_vinculo) {
							$cnj_campo = explode(".",$campo_vinculo);
							$cnj_campo[0] = strtolower(trim($cnj_campo[0]));
							if (stripos($cnj_campo[0], "fornecedores") !== false) {
								if (!in_array("jumbo.pcfornec fornecedores",$tabelas_vinculos_finais)) {
									$tabelas_vinculos_finais[] = "jumbo.pcfornec fornecedores";
								}
							} else if (stripos($cnj_campo[0], "filial") !== false) {
								if (!in_array("jumbo.pcfilial filial",$tabelas_vinculos_finais)) {
									$tabelas_vinculos_finais[] = "jumbo.pcfilial filial";
								}
							} else if (stripos($cnj_campo[0], "usuarios") !== false) {
								if (strcasecmp(trim($cnj_campo[1]),"nome") == 0) {
									$campo_vinculo = "nvl(pcusuari.nome,$campo_vinculo)";
								}
								if (!in_array("sjdusuariosis usuarios",$tabelas_vinculos_finais)) {
									array_unshift($tabelas_vinculos_finais,"jumbo.pcusuari pcusuari");
									array_unshift($tabelas_vinculos_finais,"sjdusuariosis usuarios");
									array_unshift($condicionantes_vinculos_finais,"nvl(usuarios.contabilizarvendas, 0) = 1");
									array_unshift($condicionantes_vinculos_finais,"pcusuari.codusur(+) = usuarios.codusuariosis");
								}
							} else {
								$campo_vinculo = "null";
							}
						}
						$comando_sql_mostrar_zerados = " union all select " . implode(",",$campos_vinculos) . " from ";
						$tem_condic_final = false;
						if (isset($condicionantes_processo) && $condicionantes_processo !== null && gettype($condicionantes_processo) === "array" && count($condicionantes_processo) > 0) {
							foreach($condicionantes_processo as $chave_condic_proc=>$condic_proc) {
								if (in_array(strtolower(trim($chave_condic_proc)),["filial","supervisor","rca"])) {
									switch(strtolower(trim($chave_condic_proc))) {
										case "rca":
											foreach($condic_proc as $cond) {
												if (!isset($condic_zerados["sjdusuariosis"])) {
													$condic_zerados["sjdusuariosis"] = [];
												}
												if (!isset($condic_zerados["sjdusuariosis"][$cond["op"]])) {
													$condic_zerados["sjdusuariosis"][$cond["op"]] = [];
												}
												$condic_zerados["sjdusuariosis"][$cond["op"]][] = "usuarios.codusuariosis" . $cond["op"] . $cond["valor"];
											}
											break;
										case "supervisor":
											if (!in_array("jumbo.pcsuperv pcsuperv",$tabelas_vinculos_finais)) {
												$tabelas_vinculos_finais[] = "jumbo.pcsuperv pcsuperv";
												$condicionantes_vinculos_finais[] =  "pcsuperv.codsupervisor = pcusuari.codsupervisor";
											}
											foreach($condic_proc as $cond) {
												if (!isset($condic_zerados["pcsuperv"])) {
													$condic_zerados["pcsuperv"] = [];
												}
												if (!isset($condic_zerados["pcsuperv"][$cond["op"]])) {
													$condic_zerados["pcsuperv"][$cond["op"]] = [];
												}
												$condic_zerados["pcsuperv"][$cond["op"]][] = "pcsuperv.codsupervisor" . $cond["op"] . $cond["valor"];
											}
											break;
										case "filial":
											if (!in_array("jumbo.pcfilial pcfilial",$tabelas_vinculos_finais)) {
												$tabelas_vinculos_finais[] = "jumbo.pcfilial pcfilial";
												$condicionantes_vinculos_finais[] =  "pcfilial.codigo = pcusuari.codfilial";
											}
											foreach($condic_proc as $cond) {
												if (!isset($condic_zerados["pcfilial"])) {
													$condic_zerados["pcfilial"] = [];
												}
												if (!isset($condic_zerados["pcfilial"][$cond["op"]])) {
													$condic_zerados["pcfilial"][$cond["op"]] = [];
												}
												$condic_zerados["pcfilial"][$cond["op"]][] = "pcfilial.codigo" . $cond["op"] . $cond["valor"];
											}
											break;
										default:
											echo strtolower(trim($chave_condic_proc));
											break;
									}
								}
							}
						}
						$condic_finais = [];
						if (count($condic_zerados) > 0) {
							foreach($condic_zerados as $chave_tab=>&$condic_zer) {
								foreach($condic_zer as $chave_op => &$condic_op) {
									if ($chave_op === "=") {								
										$condic_finais[] = "(".implode(" or " , $condic_op) . ")";
									} else { $condic_finais[] = implode(" and " , $condic_op);
									}
								}
							}
						}
						$comando_sql_mostrar_zerados .= implode(",",$tabelas_vinculos_finais);
						if (count($condicionantes_vinculos_finais) > 0) {
							$comando_sql_mostrar_zerados .= " where " . implode(" and ", $condicionantes_vinculos_finais);
							$tem_condic_final = true;
						}
						if (count($condic_finais) > 0) {
							if ($tem_condic_final !== true) {
								$comando_sql_mostrar_zerados .= " where ";							
							} else {
								$comando_sql_mostrar_zerados .= " and ";
							}
							$comando_sql_mostrar_zerados .= implode(" and " , $condic_finais). " ";
						}
						$str_pfim_subst = "resultante_final as (";
						$pos = stripos($comando_sql, $str_pfim_subst,$pos);
						if($pos !== false) {					
							$pos = $pos -3;
							$comando_sql = substr($comando_sql,0,$pos) . $comando_sql_mostrar_zerados . substr($comando_sql,$pos);	
						}
						$campos_resultantes = $comhttp_rating->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["resultante_final"]["blocos_select"][0]["comando_sql"]["conjunto_aliases"];
						$campos_resultantes_finais = [];
						$campos_resultantes_finais_dados = [];
						$campos_resultantes_finais_valores = [];
						$campos_resultantes_finais_valores_rating = [];
						$texto_campo_resultante_temp = null;
						$qtcamposvalores = 0;
						foreach($campos_resultantes as $campo_resultante) {						
							$texto_campo_resultante = str_replace("\"","",$campo_resultante);
							if (stripos($texto_campo_resultante,"quantidade") !== false 
								|| stripos($texto_campo_resultante,"pesototal") !== false
								|| stripos($texto_campo_resultante,"valortotal") !== false) {
								$indice_campo = str_ireplace(["pesototal_","valortotal_","quantidade_"],"",$texto_campo_resultante);
								if ($texto_campo_resultante_temp === null) {
									$texto_campo_resultante_temp = str_ireplace($indice_campo,"",$texto_campo_resultante);
								}
								$qtcamposvalores++;
							}
							if ($texto_campo_resultante_temp === null) { 
								$campos_resultantes_finais[] = $campo_resultante;
								$campos_resultantes_finais_dados[] = $campo_resultante;
							}
						}
						$indice_campo = 0;
						for ($j = 0; $j < $ind_item_rating; $j++) {
							for($i = 0; $i < $qtcamposvalores; $i++) {
								$campos_resultantes_finais[] = "null as " . $texto_campo_resultante_temp . $indice_campo; 
								$campos_resultantes_finais[] = "null as " . str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "s". $indice_campo; 
								$campos_resultantes_finais[] = "null as " . str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "m". $indice_campo; 
								$campos_resultantes_finais_valores[] = $texto_campo_resultante_temp . $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "s" . $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "m" . $indice_campo;
								$campos_resultantes_finais_valores_rating[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . $indice_campo;
								$indice_campo++;
							}
						}
						foreach($campos_resultantes as $campo_resultante) {
							$texto_campo_resultante = str_replace("\"","",$campo_resultante);
							if (stripos($texto_campo_resultante,"quantidade") !== false 
								|| stripos($texto_campo_resultante,"pesototal") !== false
								|| stripos($texto_campo_resultante,"valortotal") !== false) {
								$campos_resultantes_finais[] = $campo_resultante . " as " . $texto_campo_resultante_temp . $indice_campo;
								$campos_resultantes_finais[] = "(select sum($campo_resultante) from resultante_final) as ". str_replace(" " , "_",$item_rating["nome"]). "s" . $indice_campo;	
								$campos_resultantes_finais[] = str_replace(",",".",$item_rating["multiplicador"]) . "  as ". str_replace(" " , "_",$item_rating["nome"]) . "m" . $indice_campo;	
								$campos_resultantes_finais_valores[] = $texto_campo_resultante_temp . $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$item_rating["nome"]) . "s" . $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$item_rating["nome"]) . "m" . $indice_campo;
								$campos_resultantes_finais_valores_rating[] = str_replace(" " , "_",$item_rating["nome"]).$indice_campo;
								$indice_campo ++;
							}
						}
						for ($j = $ind_item_rating + 1; $j < $qtitensrating ; $j++) {
							for($i = 0; $i < $qtcamposvalores; $i++) {
								$campos_resultantes_finais[] = "null as " . $texto_campo_resultante_temp . $indice_campo; 
								$campos_resultantes_finais[] = "null as " . str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "s" . $indice_campo; 
								$campos_resultantes_finais[] = "null as " . str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "m" . $indice_campo; 
								$campos_resultantes_finais_valores[] = $texto_campo_resultante_temp . $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "s" .  $indice_campo;
								$campos_resultantes_finais_valores[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . "m" .  $indice_campo;
								$campos_resultantes_finais_valores_rating[] = str_replace(" " , "_",$dados_itens_rating_fetch_all[$j]["nome"]) . $indice_campo;
								$indice_campo ++;
							}
						}
						$comando_sql = str_ireplace("select * from resultante_final","select " . implode(",",$campos_resultantes_finais ). " from resultante_final",$comando_sql);
						$comandos_ratings[] = $comando_sql;
					}
				}
			}
			$comandos_ratings = implode(" UNION ALL ",$comandos_ratings);
			$arr_tit["Valores Saida"]["RATING TOTAL"]=["texto"=>"RATING TOTAL","codligcamposis"=>null,"formatacao"=>"cel_quantdec_med"];
			$c1 = 0;
			$campos_resultantes_finais_valores_rating_soma2 = [];
			$campos_resultantes_finais_valores_rating_soma3 = [];
			$campos_resultantes_finais_valores2 = [];
			$aliascampovalorant = "";
			$aliascamposomaant = "";
			$campos_group_valores = [];
			foreach($campos_resultantes_finais_valores as $chave=>&$campo) {		
				$alias = $campo;
				if (stripos($campo,"quantidade") !== false 
						|| stripos($campo,"pesototal") !== false
						|| stripos($campo,"valortotal") !== false) {
					$campo = "sum(nvl($campo,0))";
					$campo .= " as $alias";
					$aliascampovalorant = $alias;	
					$campos_resultantes_finais_valores2[] = $campo;			
				} else {
					$campos_group_valores[] = $alias;
					$campo = "max(nvl($campo,0))";			
					$campo .= " as $alias";
					if ($c1 > 0) {
						$campos_resultantes_finais_valores_rating_soma3[] = "(case when sum(nvl($aliascampovalorant,0)) > max(nvl($aliascamposomaant,0)) over () / count(*) over() then 0 else 1 end * max(nvl($alias,0)) over ())";
						$campos_resultantes_finais_valores_rating_soma2[] = "(case when sum(nvl($aliascampovalorant,0)) > max(nvl($aliascamposomaant,0)) over () / count(*) over() then 0 else 1 end * max(nvl($alias,0)) over ()) as $alias";
						$c1 = 0;
						$aliascamposomaant = "";
					} else {
						$c1++;
						$aliascamposomaant = $alias;
					}
				}
			}	
			$comandos_ratings = "select " . implode(",",$campos_resultantes_finais_dados) . 
				(count($campos_resultantes_finais_valores) > 1 ? "," . implode(",",$campos_resultantes_finais_valores):"") . 
				 " from ( " . $comandos_ratings . ") group by " . implode(",",$campos_resultantes_finais_dados);
			/*exclui campos de valores se marcado para nao mostrar*/
			$campos_rating_somados = implode("+",$campos_resultantes_finais_valores_rating_soma3). " as resultante_rating";
			if (!$mostrar_valores) {
				$campos_resultantes_finais_valores2 = [];
			}
			/*exclui campos de itens rating se marcado para nao mostrar*/
			if (!$mostrar_ratings_individuais === true) {
				$campos_resultantes_finais_valores_rating_soma2 = [];		
			} 

			/*retira do arr_tit os campos de valores caso esteja marcado para nao mostrar*/
			if (!$mostrar_valores && !$mostrar_ratings_individuais) {
				foreach($arr_tit as $chave => $el) {
					if (stripos($chave,"De ") !== false) {
						unset($arr_tit[$chave]);
					}
				}
			}
			
			$campos_finais = [];
			if (count($campos_resultantes_finais_valores2)) {
				foreach($campos_resultantes_finais_valores2 as $chave=>&$campo_temp) {
					$campos_finais[] = $campo_temp;
					if (isset($campos_resultantes_finais_valores_rating_soma2[$chave])) {
						$campos_finais[] = $campos_resultantes_finais_valores_rating_soma2[$chave];
					}
				}
			} else {
				$campos_finais = $campos_resultantes_finais_valores_rating_soma2;
				}
			$campos_finais[] = $campos_rating_somados;
			$comandos_ratings = "select " . implode(",",$campos_resultantes_finais_dados) . "," . implode(",",$campos_finais) . " from (" . $comandos_ratings . ")";
			$comandos_ratings .= " group by " . implode(",",$campos_resultantes_finais_dados) . ",". implode(",",$campos_group_valores);
			$retorno = $comandos_ratings;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = $arr_tit;
			return $retorno;
		}
		public static function montar_sql_consulta_tabeladbcel(&$comhttpsimples){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$condictab = "";
			$nomeapp = "__NOMEAPP__";
			if (isset($comhttpsimples->c["condicionantes"])) {
				$condictab = $comhttpsimples->c["condicionantes"];
			}
			if (isset($comhttpsimples->c["nomeapp"])) {
				$nomeapp = $comhttpsimples->c["nomeapp"];
			}
			$comhttpsimples->d["objeto"] = "lista_tabelas_campos_cel";
			$comando_sql = "
				SELECT
					t.codtabeladb,
					t.nometabeladb,
					c.codcampodb,
					c.nomecampodb,
					c.nomecampovisivel,
					c.alias,
					c.tipodado,
					c.parametros
				FROM
					sjdtabeladbcel t
					join sjdcampodbcel c on (c.codtabeladb = t.codtabeladb)
				where
					(
						(lower(trim(t.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t.nometabeladb)) = lower(trim('tabeladb')))
						or (
							not exists(select 1 from sjdtabeladbcel t2 where lower(trim(t2.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t2.nometabeladb)) = lower(trim('tabeladb')))
							and lower(trim(t.nomeapp)) = lower(trim('todos')) and lower(trim(t.nometabeladb)) = lower(trim('tabeladb'))
						)
					) or (
						(lower(trim(t.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t.nometabeladb)) = lower(trim('campodb')))
						or (
							not exists(select 1 from sjdtabeladbcel t2 where lower(trim(t2.nomeapp)) = lower(trim('__NOMEAPP__')) and lower(trim(t2.nometabeladb)) = lower(trim('campodb')))
							and lower(trim(t.nomeapp)) = lower(trim('todos')) and lower(trim(t.nometabeladb)) = lower(trim('campodb'))
						)
					 )			 
					 __CONDICTAB__			 
				order by 1,3	
			";
			if ($condictab !== null && strlen(trim($condictab)) > 0){
				$comando_sql = str_ireplace("__CONDICTAB__"," and (" . $condictab . ") ",$comando_sql);
			} else {
				$comando_sql = str_ireplace("__CONDICTAB__","",$comando_sql);
			}
			if ($nomeapp !== null && strlen(trim($nomeapp)) > 0){
				$comando_sql = str_ireplace("__NOMEAPP__",$nomeapp,$comando_sql);
			} 
			$retorno = $comando_sql;
			$comhttpsimples->d["s"] = $retorno;
			return $retorno;
		}
		public static function montar_sql_critica(&$comhttp){
			/*Objetivo: montar o sql do relatorio do critica*/
			$condicionantes=strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]));	
			$condicionantes=explode(strtolower(trim(Constantes::sepn1)),$condicionantes);
			$meses = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
			$anos = $comhttp->requisicao->requisitar->qual->condicionantes["ano"];
			$filial=[];
			foreach($condicionantes as $condic){
				$condic=explode(strtolower(trim(Constantes::sepn2)),$condic);
				foreach($condic as $cond){
					if(stripos($cond,"filial")>-1){
						$filial[]=substr($cond,stripos($cond,"=")+1);
					}		
				}
			}
			if (gettype($anos) !== "array") {
				$anos = explode(",",strtolower(trim($anos)));
			}
			sort($anos);
			if (gettype($meses) !== "array") {
				$meses = explode(",",strtolower(trim($meses)));
			}	
			$dtini_metas = "01/" . FuncoesData::MesNum($meses[0]) . "/" . $anos[0];
			$dtfim_metas = "01/" . FuncoesData::MesNum($meses[count($meses) -1 ]) . "/" . $anos[count($anos) -1];
			$dtfim_metas = FuncoesData::UltDiaMes($dtfim_metas);
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->condicionantes["visoes"]);
			$comhttp->requisicao->requisitar->qual->objeto = $comhttp->requisicao->requisitar->qual->condicionantes["visoes"];
			$comhttp->requisicao->sql->comando_sql=FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$comhttp->requisicao->sql->comando_sql = trim(str_replace("  "," ",$comhttp->requisicao->sql->comando_sql));
			$comhttp->requisicao->sql->comando_sql = substr($comhttp->requisicao->sql->comando_sql,0,strrpos($comhttp->requisicao->sql->comando_sql, "order by"));
			$campos_resultantes = [];
			$campos_group = [];
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["resultante_final"]["blocos_select"][0]["comando_sql"]["select"] as $cmp) {			
				$cmp = strtolower(trim($cmp));
				$campos_resultantes[] = $cmp;		
			}
			foreach($campos_resultantes as $chave => $campo) {
				if (stripos($campo," as ") !== false) {
					$campo = explode(" as ",$campo);
					$campo = "r." . $campo[1];
					$campos_resultantes[$chave] = $campo;
				}
			}
			$campos_group = $campos_resultantes;
			$campos_resultantes2 = [];
			$campos_resultantes2[] = "sjdmetas_origem.meta";
			$campos_group[] = "sjdmetas_origem.meta";
			$campos_resultantes2[] = "sjdmetas_origem.critica";
			$campos_group[] = "sjdmetas_origem.critica";
			$campos_resultantes2[] = "SUM(nvl(nvl(pcmov.qt,pcmov.qtcont),0)) - sum(nvl(pcmov.qtdevol,0)) AS QTRECEBIDA";
			$comhttp->requisicao->sql->comando_sql = str_ireplace("select * from resultante_final",",resultante_final2 as (select * from resultante_final) select ".implode(",",$campos_resultantes).",".implode(",",$campos_resultantes2)." from resultante_final2 r",$comhttp->requisicao->sql->comando_sql);
			$comhttp->requisicao->sql->comando_sql .= " join sjdmetas_origem on (sjdmetas_origem.codfilial = r.codfilial AND sjdmetas_origem.codprod = r.codprod and trunc(sjdmetas_origem.dtini) >= to_date('$dtini_metas','dd/mm/yyyy') AND trunc(sjdmetas_origem.dtfim) <= to_date('$dtfim_metas','dd/mm/yyyy'))";
			$comhttp->requisicao->sql->comando_sql .= " 
							LEFT OUTER JOIN ( 
									 jumbo.pcmov JOIN (
														jumbo.pcnfent JOIN jumbo.pcfornec ON (pcnfent.codfornec = pcfornec.codfornec
														AND pcfornec.fornecedor LIKE '%AURORA%')
													  ) ON (pcnfent.numtransent = pcmov.numtransent
															AND pcnfent.dtent BETWEEN '$dtini_metas' AND '$dtfim_metas'
															AND pcnfent.dtcancel is null
															and pcmov.codoper in ('E','EB')) 
												  ) ON (pcmov.codfilial = r.codfilial
														AND pcmov.codprod = r.codprod
													   )	";
			$comhttp->requisicao->sql->comando_sql .= " group by " . implode(",",$campos_group);
			$comhttp->requisicao->sql->comando_sql .= " order by 1,3,5";
			$retorno = $comhttp->requisicao->sql->comando_sql;
			return $retorno;
		}
		public static function montar_sql_freezer(&$comhttp){
			/*Objetivo: montar o sql do relatorio do freezer*/
			$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
			$datas = explode(",",$datas);
			$dt = 0;
			$condic_datas = [];
			foreach($datas as $data) {
				if ($dt ===0) {
					$condic_datas[] = "TRUNC(PCMOV.DTMOV) BETWEEN '" . $data . "' and ";
					$dt = 1;
				} else {
					$condic_datas[count($condic_datas) - 1] .= " '".$data."'";			
					$dt = 0;
				}
			}
			$condic_datas = "(" . implode(" or " ,$condic_datas) . ")";
			$comando_sql = "
				SELECT 
					distinct
					cm.codcli,
					trim(replace(replace(replace(pcclient.cgcent,'.',''),'-',''),'/','')) as cgcent			
				  FROM JUMBO.PCCONTRATOCOMODLOC cm
					join jumbo.pcclient on (pcclient.codcli = cm.codcli)
				  where 
					trunc(sysdate) between cm.dtvigenciaini and cm.dtvigenciafin";
			$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$clientes = [];
			foreach ($dados as $c){
				$clientes[] = "cliente='" . $c["cgcent"] . "'";
			};
			if (count($clientes) > 0) {
				$clientes = implode(Constantes::sepn2,$clientes);
				$fornecedores = [
					"fornecedor='500797'",
					"fornecedor='501538'",
					"fornecedor='501747'",
					"fornecedor='500967'",
				];
			} else {
				$clientes = ["cliente='0'"];
				$fornecedores = ["fornecedor='0'"];
			}
			$fornecedores = implode(Constantes::sepn2,$fornecedores);
			if( trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]) === ""){
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]=$clientes;
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"].=Constantes::sepn1.$fornecedores;
			}else{
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"].=Constantes::sepn1.$clientes;
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"].=Constantes::sepn1.$fornecedores;
			}	
			$comhttp->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
			$comhttp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->objeto);
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_gestao_acessos(&$comhttp){
			/*Objetivo: montar o sql da gestao de acesso*/
			$datas = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["datas"]);
			$dtini = "'".$datas[0]."'";
			$dtfim = "'".$datas[1]."'";
			$comando_sql = "select CODUSUR,DATA_ACESSO,HORARIO_ACESSO, TIPO_PROCESSO,NOME_PROCESSO,VISOES,PERIODOS,EXPORTADO,IP,NAVEGADOR from log_acesso ";
			$negado=false;
			if(strpos($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"],"!=")>-1){
				$negado=true;
			}
			$condic_rcas=explode(strtolower(trim(Constantes::sepn2))."rca=",strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])));
			$condic_rcas[0]=str_ireplace("rca=","",$condic_rcas[0]);
			if($negado){
				$condic_rcas=" codusur not in (".implode(",",$condic_rcas).")";
			} else {
				$condic_rcas=" codusur in (".implode(",",$condic_rcas).")";
			}
			$comando_sql .= " where data_acesso between ".$dtini." and ".$dtfim." and (".$condic_rcas.")";	
			$comhttp->requisicao->sql->comando_sql = $comando_sql;
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_grafico_evolucao_sinergia(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$mes = $comhttp->requisicao->requisitar->qual->condicionantes["mes"];
			if ($mes !== null && strlen(trim($mes)) > 0) {
				$mesnum = FuncoesData::MesNum($mes);		
			} else {
				$mesnum = FuncoesData::mes_atual();
			}
			$dtini = "01/" . $mesnum . "/" . ano_atual();
			$dtfim = FuncoesData::data_ultimo_dia_mes_atual($dtini);
			$condicionantes_sinergia = [];
			$condicionantes_comhttp = [];
			$condicionantes_comhttp_rca = [];
			$cnj_criterios_acesso_sinergia = [];
			$usuariosis = $_SESSION["usuariosis"];
			$nometabela_objetivos = "sjdobjetivossinergia";
			$tabeladb_objetivos = FuncoesSql::getInstancia()->obter_tabela_db(["condic"=> "lower(trim(nometabeladb))=lower(trim('$nometabela_objetivos'))","unico"=>true]);				
			$criterios_acesso = FuncoesSql::getInstancia()->obter_criterios_acesso($usuariosis,$tabeladb_objetivos);
			$cnj_criterios_acesso = FuncoesSql::getInstancia()->traduzir_criterios_acesso($usuariosis,$criterios_acesso);
			if (count($cnj_criterios_acesso) > 0) {
				foreach($cnj_criterios_acesso as $crit) {
					$condicionantes_sinergia[] = str_ireplace("sjdobjetivossinergia","ob",$crit);
					$condicionantes_comhttp_rca[] = "rca=$crit";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["filial"])) {
				$rcas_filial = FuncoesSisJD::obter_rcas_filial_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["filial"]);
				$condicionantes_sinergia[] = "entidade='rca'";
				$condicionantes_sinergia[] = "codentidade in (".implode(",",$rcas_filial).")";
				foreach ($rcas_filial as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"])) {
				$rcas_supervisor = FuncoesSql::getInstancia()->obter_rcas_supervisor_jumbo($comhttp->requisicao->requisitar->qual->condicionantes["supervisor"]);
				$condicionantes_sinergia[] = "entidade='rca'";
				$condicionantes_sinergia[] = "codentidade in (".implode(",",$rcas_supervisor).")";
				foreach ($rcas_supervisor as $rca_condic) {
					$condicionantes_comhttp_rca[] = "rca=$rca_condic";
				}		
			}
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["rca"])) {
				$condicionantes_sinergia[] = "entidade='rca'";
				$condicionantes_sinergia[] = "codentidade in (" . $comhttp->requisicao->requisitar->qual->condicionantes["rca"] . ")";
			}
			if (count($condicionantes_comhttp_rca) > 0) {
				$condicionantes_comhttp[] = implode(Constantes::sepn2,$condicionantes_comhttp_rca);
			}
			if (count($condicionantes_comhttp) > 0) {
				$condicionantes_comhttp = implode(Constantes::sepn1,$condicionantes_comhttp);
			} else {
				$condicionantes_comhttp = null;
			}
			$condicionantes_sinergia = trim(implode(" and ",$condicionantes_sinergia));		
			$comando_sql = "";
			$comando_sql = "
		SELECT
			trunc(ev.data) as data,
			sum(case when nvl(ob.valor,0) * nvl(ob.percmaxating,100) / 100 > nvl(ev.realizado,0) then nvl(ev.realizado,0) else nvl(ob.valor,0) * nvl(ob.percmaxating,100) / 100 end) as realizado
			--sum(nvl(ev.realizado,0)) as realizado
		FROM
			sjdevolobjetsinergia ev
			join sjdobjetivossinergia ob on (ob.codobjetivosinergia = ev.codobjetivosinergia)
		where
			trunc(ev.data) between trunc(to_date('$dtini','dd/mm/yyyy')) and trunc(to_date('$dtfim','dd/mm/yyyy'))    
			and ob.codcampanhasinergia = 0
			__CONDICIONANTES__
		group by 
			trunc(ev.data)
		order by 
			trunc(ev.data)
		";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			if(strlen(trim($condicionantes_sinergia)) > 0) {
				$comando_sql = str_ireplace("__CONDICIONANTES__"," and " . $condicionantes_sinergia,$comando_sql);		
			} else {
				$comando_sql = str_ireplace("__CONDICIONANTES__"," ",$comando_sql);
			}
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}
		public static function montar_sql_lista_clientes(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "select c.codcli,c.cgcent,c.cliente, decode(c.fantasia,null,' ',c.fantasia) as fantasia, decode(c.bloqueio,'S','S','N') AS bloqueio, decode(c.limcred,null,0,limcred) as LIMCRED, 
					nvl(c.dtultcomp,'') AS DTULTCOMP, 
					CASE 
						  WHEN c.dtultcomp BETWEEN '01/' ||  TO_CHAR(SYSDATE,'MM/YYYY')  AND last_day(sysdate) THEN 'M0'
						  WHEN c.dtultcomp BETWEEN '01/' ||  TO_CHAR(ADD_MONTHS(SYSDATE,-1),'MM/YYYY')  AND last_day(ADD_MONTHS(sysdate,-1)) THEN 'M1'
						  ELSE 'MN' 
						  END
					AS positivado,
					c.codcob,
					cb.cobranca,
					c.codplpag,
					nvl(pg.descricao,' ') as descricao, 
					pg.numdias, 
					pg.numpr,				
					nvl(DECODE(c.bloqueio,'S',(c.obs||decode(c.obs,null,'','; ')||c.obs2||decode(c.obs2,null,'','; ')||c.obscredito||decode(c.obscredito,null,'','; ')||c.obs3||decode(c.obs3,null,'','; ')||c.obs4||decode(c.obs4,null,'','; ')||' VENCIMENTOS: '||
					DECODE(
						(select Listagg(pr.dtvenc||'-'||pr.valor,';') within GROUP (ORDER BY pr.dtvenc ASC) from jumbo.pcprest pr where pr.codcli = c.codcli and pr.dtpag is null)
							,null,
								'NAO HA VALORES VENCIDOS',
							(select Listagg(pr.dtvenc||'-'||pr.valor,';') within GROUP (ORDER BY pr.dtvenc ASC) from jumbo.pcprest pr where pr.codcli = c.codcli and pr.dtpag is null)
							)),' '),' ') as MOTIVO
					from jumbo.pcclient c, jumbo.pcplpag pg, jumbo.pccob cb where c.codusur1 not in (150,250) and c.codusur1 in ("."101"./*$_SESSION["rcas_subordinados"]*/".) and c.codplpag=pg.codplpag(+) and c.codcob=cb.codcob(+) ORDER BY C.CLIENTE" ;		
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_lista_cobranca(&$comhttp){
			$comhttp->requisicao->sql->comando_sql  = " select codcob, cobranca, pagcomissao, txjuros, prazomaximovenda, boleto, vlminpedido from jumbo.pccob where codcob in ('D','CH',
				CASE 
					WHEN ".$_SESSION["codusur"]." BETWEEN 100 AND 199 THEN '1399' 
					WHEN ".$_SESSION["codusur"]." BETWEEN 200 AND 299 THEN '2399' 
				END,
				CASE
					WHEN ".$_SESSION["codusur"]." NOT BETWEEN 100 AND 299 THEN '1399'
				END,
				CASE
					WHEN ".$_SESSION["codusur"]." NOT BETWEEN 100 AND 299 THEN '2399'
				END)";
			if(isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])){
				if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]!==""){
					if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]==="CH"){
						$comhttp->requisicao->sql->comando_sql .= " and codcob in ('CH','D')" ;
					} else if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]==="D"){
						$comhttp->requisicao->sql->comando_sql .= " and codcob in ('D')" ;
					} 
				}
			}
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_lista_prazos(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = " select codplpag, nvl(descricao,' ') as descricao, numdias, prazo1, numpr, tipovenda, vlminpedido from jumbo.pcplpag where codplpag<=8 and codplpag!=7 ";
			if(isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"])){
				if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]!==""){
					$comhttp->requisicao->sql->comando_sql .= " and ".$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];
				}
			}
			$comhttp->requisicao->sql->comando_sql .= " order by 1";
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_lista_produtos(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "WITH 
						mov0 as (SELECT
						p.codprod AS codprod,
						nvl(SUM(nvl(m.qt,0) ),0) - nvl(sum(nvl(m.qtdevol,0)),0) AS peso
					FROM
						jumbo.pcmov m
					RIGHT OUTER JOIN jumbo.pcprodut p ON (
							m.codprod = p.codprod
						AND m.dtmov BETWEEN '01' ||  TO_CHAR(SYSDATE,'MM/YYYY') AND last_day(SYSDATE)
						AND m.codusur = 101)
					GROUP BY p.codprod
					UNION 
					SELECT
						a.cd_item AS codprod,
						nvl(SUM(nvl(a.peso_liquido_item,0) ),0) AS peso
					FROM
						dados_vendas_origem a
					RIGHT OUTER JOIN jumbo.pcprodut p ON (
							a.cd_item = p.codprod
						AND a.dt_emissao_nfsa BETWEEN '01' ||  TO_CHAR(SYSDATE,'MM/YYYY') AND last_day(SYSDATE)
						AND substr(a.vendedor,3) = 101 ) 
					GROUP BY a.cd_item),
		m0 AS (
			SELECT
				codprod,
				SUM(peso) AS peso
			FROM
				mov0
			GROUP BY
				codprod),
		mov1 as (SELECT
						p.codprod AS codprod,
						nvl(SUM(nvl(m.qt,0) ),0) - nvl(sum(nvl(m.qtdevol,0)),0) AS peso
					FROM
						jumbo.pcmov m
					RIGHT OUTER JOIN jumbo.pcprodut p ON (
							m.codprod = p.codprod
						AND m.dtmov BETWEEN '01' ||  TO_CHAR(ADD_MONTHS(SYSDATE,-1),'MM/YYYY') AND last_day(ADD_MONTHS(SYSDATE,-1))
						AND m.codusur = 101)
					GROUP BY p.codprod
					UNION 
					SELECT
						a.cd_item AS codprod,
						nvl(SUM(nvl(a.peso_liquido_item,0) ),0) AS peso
					FROM
						dados_vendas_origem a
					RIGHT OUTER JOIN jumbo.pcprodut p ON (
							a.cd_item = p.codprod
						AND a.dt_emissao_nfsa BETWEEN '01' ||  TO_CHAR(ADD_MONTHS(SYSDATE,-1),'MM/YYYY') AND last_day(ADD_MONTHS(SYSDATE,-1))
						AND substr(a.vendedor,3) = 101 ) 
					GROUP BY a.cd_item),
		m1 AS (
			SELECT
				codprod,
				SUM(peso) AS peso
			FROM
				mov1
			GROUP BY
				codprod),
		POSITIVACOES AS (SELECT
			m0.CODPROD,
			case
			  when m0.peso>0 then 'M0'
			  when m1.peso>0 then 'M1'
			  ELSE 'MN'
			END as positivado
		FROM
			m0,m1
		where m0.codprod = m1.codprod)			
					SELECT   p.codprod,
				 p.descricao,
				 p.unidade,
				 to_char(Nvl(p.qtunitcx, 1),'9999990.999999') AS \"QT.UN.CX\",
				 to_char(( Nvl(e.qtestger, 0) - Nvl(e.qtreserv, 0) - Nvl(e.qtpendente, 0) - Nvl(e.qtindeniz, 0) ) ,'9999990.999999') AS \"QT. DISPONIVEL\",
				 to_char(nvl(pt.PERDESCMAX,0),'9999990.999999') AS \"% DESC.MAX\", 
				 to_char(pt.pvenda1,'9999990.999999') as \"A VISTA\",
				 to_char(pt.pvenda2,'9999990.999999') as \"7 DIAS\",
				 to_char(pt.pvenda3,'9999990.999999') as \"14 DIAS\",
				 to_char(pt.pvenda4,'9999990.999999') as \"21 DIAS\",
				 to_char(pt.pvenda5,'9999990.999999') as \"28 DIAS\",
				 to_char(pt.pvenda6,'9999990.999999') as \"35 DIAS\",
				 to_char(p.multiplo,'9999990.999999') as multiplo,
				 ps.positivado as positivado,
				 cb.regratextual as regraenquadramento,
				 icb.regratextual as regravalidacao
		FROM     jumbo.pcprodut p,
				 jumbo.pcest e,
				 jumbo.pcfilial f,
				 jumbo.pcprodfilial pf,
				 jumbo.pctabpr pt,
				 positivacoes ps,
				 combo cb,
				 itemcombo icb
		WHERE    
		p.codprod in (select distinct codprod from jumbo.pcpedi where data BETWEEN ADD_MONTHS(SYSDATE,-6) AND SYSDATE)
		and p.codprod = e.codprod
		and 	 p.codprod = pt.codprod
		AND      f.codigo = e.codfilial
		AND      p.codprod = pf.codprod
		AND      e.codfilial = pf.codfilial
		AND 	 p.codprod = cb.coditem(+)
		and 	 cb.codcombo = icb.codcombo(+)
		and p.codprod = ps.codprod(+)
				aND pt.NUMREGIAO in (1/*,2,3,10,11,12,13*/)																						   
		AND      ( (
								   p.obs2 <> 'FL' )
				 AND      (
								   pf.foralinha = 'N' ) )
		AND      e.codfilial IN ( '1' )
		AND ( (Nvl(e.qtestger, 0) - Nvl(e.qtreserv, 0) - Nvl(e.qtpendente, 0) - Nvl(e.qtindeniz, 0)) > 0)
		ORDER BY p.codprod,
				 p.descricao";
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function obter_campos_pivot_ligtabelasis(array &$ligtabelasis,array &$cnj_campos_pivot, array &$cnj_campos_any) {
			foreach($ligtabelasis["ligscamposis"] as $chave_ligcamposis => $ligcamposis) {
				if (in_array(strtolower(trim($ligcamposis["criterio_uso"])),["usar sempre","campo avulso"])) {
					FuncoesArray::inserir_se_nao_existir($ligcamposis["alias"],$cnj_campos_pivot,true,true,'campo_select');
					$cnj_campos_any[] = "ANY";
				}
			}
		}
		public static function obter_campos_select_ligtabelasis(array &$ligtabelasis,array &$cnj_campos_select) {
			foreach($ligtabelasis["ligscamposis"] as $chave_ligcamposis => $ligcamposis) {
				if (in_array(strtolower(trim($ligcamposis["criterio_uso"])),["usar sempre","campo avulso"])) {
					if (!in_array(strtolower(trim($ligcamposis["alias"])),["pesototal_0","quantidade_0","valortotal_0"])) {
						FuncoesArray::inserir_se_nao_existir($ligcamposis["alias"],$cnj_campos_select,true,true,'campo_select');
					}
				}
			}
		}
		public static function montar_sql_positivacoes(&$comhttp){
			/*Objetivo: montar o sql dos relatorios de positivacoes*/
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadas"]=strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["visoes"]));
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]=strtolower(trim($comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadas"].','.$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]));
			$comhttp->requisicao->requisitar->qual->objeto = $comhttp->requisicao->requisitar->qual->condicionantes["visoes"];
			if(in_array(strtolower(trim(ConstantesSis::getInstancia()::$visoes[13])), explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]))){
				$comhttp->requisicao->requisitar->qual->condicionantes["tem_vis_item"]=true;
			};
			$comhttp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->objeto);
			$comhttp->requisicao->sql->comando_sql=FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] as $chave_tit => &$el_tit) {
				if (stripos(trim($chave_tit),"de ") === 0) {
					unset($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"][$chave_tit]);
				}
			}
			/*localiza os cods dos processos positivados e positivadores*/
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]=explode(',',$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]);
			$nomes_processos_positivadores = explode(",",FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]));
			foreach($nomes_processos_positivadores as $chave=>$nome_processo) {
				$nomes_processos_positivadores[$chave] = FuncoesSisJD::corrigir_nome_processo($nome_processo);
			}
			$processos_positivadores = FuncoesSql::getInstancia()->obter_processo(["condic"=>"lower(trim(processo)) in ('".strtolower(trim(implode("','",$nomes_processos_positivadores)))."')","unico"=>false]);	
			$cods_processos_positivadores = [];
			foreach($processos_positivadores as $chave_processo => $processo) {
				$cods_processos_positivadores[] = $processo["codprocesso"];
			}
			$nomes_processos_positivados = explode(",",FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadas"]));
			foreach($nomes_processos_positivados as $chave=>$nome_processo) {
				$nomes_processos_positivados[$chave] = FuncoesSisJD::corrigir_nome_processo($nome_processo);
			}
			$processos_positivados = FuncoesSql::getInstancia()->obter_processo(["condic"=>"lower(trim(processo)) in ('".strtolower(trim(implode("','",$nomes_processos_positivados)))."')","unico"=>false]);	
			$cods_processos_positivados = [];
			foreach($processos_positivados as $chave_processo => $processo) {
				$cods_processos_positivados[] = $processo["codprocesso"];
			}
			/*exclui do arr_tit as visoes positivadores, que serao montadas na montagem dos dados_sql conforme xml pivot*/
			foreach($cods_processos_positivadores as $codprocpositivador){
				foreach($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] as $chave_arr_tit => $arr_tit) {
					foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["processos"] as $proc){
						if (strcasecmp(trim($proc["processo"]["codprocesso"]),trim($codprocpositivador)) == 0) {
							if (strcasecmp(trim($proc["processo"]["tipo"]),"normal") == 0 && count($proc["ligstabelasis"]) > 0) {
								echo "implementar";
								print_r($proc); exit();
							}
						}
					}
					foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["ligstabelasis_unicas"] as $ligtabelasis_unica){										
						if ($ligtabelasis_unica["gerarconfintervdata"] == 1 && count($ligtabelasis_unica["ligstabelasis"]) > 0) {
							foreach($ligtabelasis_unica["ligstabelasis"] as $chave_ligtabelasis2 => $ligtabelasis_unica2) {
								if (strcasecmp(trim($ligtabelasis_unica2["codprocesso"]),trim($codprocpositivador)) == 0) {
									if (strcasecmp(trim($ligtabelasis_unica2["tipo"]),"normal") == 0 && count($ligtabelasis_unica2["ligscamposis"]) > 0) {
										if (strcasecmp(trim($chave_arr_tit),trim($ligtabelasis_unica2["alias"])) == 0){
											unset($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"][$chave_arr_tit] ) ;
										}
									}
								}
							}
						} else {
							if (strcasecmp(trim($ligtabelasis_unica["codprocesso"]),trim($codprocpositivador)) == 0) {
								if (strcasecmp(trim($ligtabelasis_unica["tipo"]),"normal") == 0 && count($ligtabelasis_unica["ligscamposis"]) > 0) {
									if (strcasecmp(trim($chave_arr_tit),trim($ligtabelasis_unica["alias"])) == 0){
										unset($comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"][$chave_arr_tit] ) ;
									}
								}
							}
						}
					}
				}
			}
			$i=0;
			$j=0;
			foreach( $comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] as $arrtit){
				foreach($arrtit as $cmps){
					$i++;	
				}
				$j++;
			}
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit_num_vis"] = $j ;
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit_num_cmps_vis"] = $i ;
			$cnj_cmps_pivot=array();
			$cnj_cmps_any=array();
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["processos"] as $proc){
				if (strcasecmp(trim($proc["processo"]["tipo"]),"normal") == 0 && count($proc["ligstabelasis"]) > 0) {
					echo "implementar";
					print_r($proc); exit();
					if (strcasecmp(trim($proc["processo"]["nomeprocvisivel"]),trim($vis)) == 0) {
						print_r($proc["select"]["camposcomalias"]); exit();
						foreach($proc["select"]["camposcomalias"] as $chave_campo => $campo) {
							if ($campo["codcamposis"] < 900000) {
								FuncoesArray::inserir_se_nao_existir(substr($campo["nome_campo"],stripos($campo["nome_campo"]," as ")+3),$cnj_cmps_pivot,true,true,'campo_select');
								$cnj_cmps_any[]='ANY';
							}
						}
						break;
					}
				}
			}
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["ligstabelasis_unicas"] as $ligtabelasis_unica){
				if ($ligtabelasis_unica["gerarconfintervdata"] == 1 && count($ligtabelasis_unica["ligstabelasis"]) > 0) {
					foreach($ligtabelasis_unica["ligstabelasis"] as $chave_ligtabelasis2 => $ligtabelasis_unica2) {
						if (strcasecmp(trim($ligtabelasis_unica2["tipo"]),"normal") == 0 && count($ligtabelasis_unica2["ligscamposis"]) > 0) {
							if (in_array($ligtabelasis_unica2["codprocesso"],$cods_processos_positivadores)) {
								self::obter_campos_pivot_ligtabelasis($ligtabelasis_unica2,$cnj_cmps_pivot,$cnj_cmps_any);
								break;
							}
						}					
					}
				} else {
					if (strcasecmp(trim($ligtabelasis_unica["tipo"]),"normal") == 0 && count($ligtabelasis_unica["ligscamposis"]) > 0) {
						if (in_array($ligtabelasis_unica["codprocesso"],$cods_processos_positivadores)) {
							self::obter_campos_pivot_ligtabelasis($ligtabelasis_unica,$cnj_cmps_pivot,$cnj_cmps_any);						
						}
					}
				}
			}
			$cnj_cmps_data=array();
			$i=0;
			$j=0;
			$cnj_cmps_pivot='('.implode(',',$cnj_cmps_pivot).')';
			$cnj_cmps_any=implode(',',$cnj_cmps_any);
			$cnj_campos_data = [];
			if (stripos($comhttp->requisicao->sql->comando_sql,"pesototal_0") !== false) {
				$cnj_cmps_data[] = 'sum(pesototal_0) as pesototal_0';
			} 
			if (stripos($comhttp->requisicao->sql->comando_sql,"quantidade_0") !== false) {
				$cnj_cmps_data[] = 'sum(quantidade_0) as quantidade_0';
			} 
			if (stripos($comhttp->requisicao->sql->comando_sql,"valortotal_0") !== false) {
				$cnj_cmps_data[] = 'sum(valortotal_0) as valortotal_0';
			} 
			$cnj_cmps_data=implode(',',$cnj_cmps_data);
			/*estava dando erro de conversão em formatar_numero e truncando ou diminuindo uma centena do valor real*/
			$comhttp->requisicao->sql->comando_sql = trim(str_replace("  "," ",$comhttp->requisicao->sql->comando_sql));
			$comhttp->requisicao->sql->comando_sql = substr($comhttp->requisicao->sql->comando_sql,0,strrpos($comhttp->requisicao->sql->comando_sql,"order by"));
			$comhttp->requisicao->sql->comando_sql.=" pivot xml (".$cnj_cmps_data." for ".$cnj_cmps_pivot." in (".$cnj_cmps_any."))";		
			$comhttp->requisicao->sql->comando_sql = str_ireplace("select * from resultante_final",",resultante2 as (select * from resultante_final",$comhttp->requisicao->sql->comando_sql) . ")";	
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadas"]=explode(',',$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadas"]);	
			$cnj_cmps_sel = [];
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["processos"] as $proc){
				if (strcasecmp(trim($proc["processo"]["tipo"]),"normal") == 0 && count($proc["ligstabelasis"]) > 0) {
					echo "implementar ";
					print_r($proc); exit();
					if (strcasecmp(trim($proc["processo"]["nomeprocvisivel"]),trim($vis)) == 0) {
						foreach($proc["select"]["camposcomalias"] as $chave_campo => $campo) {
							if ($campo["codcamposis"] < 900000) {
								FuncoesArray::inserir_se_nao_existir(substr($campo["nome_campo"],stripos($campo["nome_campo"]," as ")+3),$cnj_cmps_sel,true,true,'campo_select');
							}					
						}
						break;
					}
				}
			}
			foreach($comhttp->requisicao->requisitar->qual->condicionantes["processo_estruturado"]["ligstabelasis_unicas"] as $ligtabelasis_unica){
				if ($ligtabelasis_unica["gerarconfintervdata"] == 1 && count($ligtabelasis_unica["ligstabelasis"]) > 0) {
					foreach($ligtabelasis_unica["ligstabelasis"] as $chave_ligtabelasis2 => $ligtabelasis_unica2) {
						if (strcasecmp(trim($ligtabelasis_unica2["tipo"]),"normal") == 0 && count($ligtabelasis_unica2["ligscamposis"]) > 0) {
							if (in_array($ligtabelasis_unica2["codprocesso"],$cods_processos_positivados)) {
								self::obter_campos_select_ligtabelasis($ligtabelasis_unica2,$cnj_cmps_sel);
								break;
							}
						}					
					}
				} else {
					if (strcasecmp(trim($ligtabelasis_unica["tipo"]),"normal") == 0 && count($ligtabelasis_unica["ligscamposis"]) > 0) {
						if (in_array($ligtabelasis_unica["codprocesso"],$cods_processos_positivados)) {
							self::obter_campos_select_ligtabelasis($ligtabelasis_unica,$cnj_cmps_sel);
						}
					}
				}
			}
			$cnj_cmps_sel=implode(',',$cnj_cmps_sel);
			$cnj_cmps_pivot = str_replace('"','',$cnj_cmps_pivot);
			$cnj_cmps_pivot = str_replace(["(",")"],"",$cnj_cmps_pivot);
			$cnj_cmps_pivot = str_replace(" ","",$cnj_cmps_pivot);
			$cnj_cmps_pivot = explode(",",$cnj_cmps_pivot);
			$cnj_cmps_pivot = trim(implode("_",$cnj_cmps_pivot));
			if(strlen($cnj_cmps_pivot)>26){
				$cnj_cmps_pivot=substr($cnj_cmps_pivot,0,26);
			};
			$cnj_cmps_pivot = $cnj_cmps_pivot . '_XML';
			$cnj_cmps_sel = "r2." . implode(",r2.",explode(",",$cnj_cmps_sel));
			$comhttp->requisicao->sql->comando_sql.=" select ".$cnj_cmps_sel.",r2.".$cnj_cmps_pivot.".getBlobVal(nls_charset_id ( 'WE8ISO8859P1')) from resultante2 r2";
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"] = implode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes_positivadoras"]);
			$comhttp->requisicao->sql->pivot = true;
			//echo  $comhttp->requisicao->sql->comando_sql; exit();
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_produtos_nao_positivados(&$comhttp){
			/*Objetivo: montar o sql do relatorio clientes nao positivados*/
			$retorno = "";
			$comhttp->requisicao->sql=new TSql();
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = "relatorio_venda_visao_" . implode(",relatorio_venda_visao_",explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]));
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = 3;
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
			$comhttp->requisicao->requisitar->qual->objeto = $comhttp->requisicao->requisitar->qual->condicionantes["visoes"];
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$comhttp->requisicao->sql->comando_sql = trim($comhttp->requisicao->sql->comando_sql);
			$pos_ult_parenteses = strrpos($comhttp->requisicao->sql->comando_sql,")");
			$comhttp->requisicao->sql->comando_sql = FuncoesString::inserir_string($comhttp->requisicao->sql->comando_sql,' having SUM(nvl(r.pesototal_1,0) ) <= 0',$pos_ult_parenteses);	
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_promotoras(&$comhttp){
			/*Objetivo: montar o sql do relatorio promotoras*/
			$retorno = "";
			$comando_sql = "select cgc from clientes_com_promotor";
			$dados = FuncoesSql::getInstancia()->executar_sql($comando_sql,"fetchAll",\PDO::FETCH_COLUMN,0);
			foreach ($dados as &$c){
				$c = "cliente='".str_replace("-","",str_replace("/","",str_replace(".","",$c)))."'";
			};
			$dados = implode(Constantes::sepn2,$dados);
			if($comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] === ""){
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"]=$dados;
			}else{
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"].=Constantes::sepn1.$dados;
			}	
			$comhttp->opcoes_retorno["usar_arr_tit"] = true;
			$comhttp->requisicao->requisitar->qual->condicionantes["usar_arr_tit"] = true;
			$comhttp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->objeto);
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			$comhttp->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_relatorio_personalizado_old(&$comhttp){
			/*Objetivo: montar o sql dos relatorios personalizados*/
			$comando_sql = "";
			$comhttp->requisicao->requisitar->qual->condicionantes["arr_tit"] = [];	
			$comhttp->requisicao->requisitar->qual->objeto = FuncoesSisJD::visoes_como_relatorio_venda($comhttp->requisicao->requisitar->qual->objeto);
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "relatorio_venda_visao_";
			$comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$retorno = $comando_sql;
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;
			return $retorno;
		}


		
		
		
		public static function montar_sql_relatorio_personalizado(&$comhttp){
			
			/*	
			migrar para outros relatorios que usam a mesma base					
			criar processos de importacao automatico das vendas para as novas tabelas de vendas ep
				este processo deve incluir automaticamente entidades relacionadas (usuarios, clientes, prods, etc)
				ao nao encontralos nas novas tabelas
			rastrear comandos e criar indices
			reimplementar campos avulsos
			*/
			
			$retorno = FuncoesProcessoSql::montarSqlProcessoEstruturado($comhttp);
			$comhttp->requisicao->sql = new TSql();
			$comhttp->requisicao->sql->comando_sql = $retorno;	
			//echo $retorno;exit();	
			return $retorno;
		}



		

		public static function montar_sql_sinergia(&$comhttp){
			/*Objetivo: montar o sql do sinergia*/
			$retorno = "";
			$condic_sup = "";
			$tab_junc_sup = [];
			$junc_sup = [];
			$data_temp = "";
			$perc_max_vis = 110;
			$perc_max_calc = 100;
			$anos = [];
			$meses = [];
			$rcas = [];
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]);	
			foreach ($comhttp->requisicao->requisitar->qual->condicionantes["visoes"] as &$visao){
				$visao = "relatorio_metas_" . $visao;
			}
			$comhttp->requisicao->requisitar->qual->condicionantes["visoes"] = implode(",",$comhttp->requisicao->requisitar->qual->condicionantes["visoes"]);
			$rcas = explode(",",trim($comhttp->requisicao->requisitar->qual->condicionantes["rca"]));
			$comhttp->requisicao->requisitar->qual->condicionantes["mes"] = explode(",",strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mes"])));
			$comhttp->requisicao->requisitar->qual->condicionantes["ano"] = explode(",",$comhttp->requisicao->requisitar->qual->condicionantes["ano"]);
			$meses = [];
			foreach ($comhttp->requisicao->requisitar->qual->condicionantes["mes"] as $mes) {
				$meses[] = $mes;
			}
			$meses = FuncoesData::ordenar_meses_texto($meses);
			$anos = [];
			foreach ($comhttp->requisicao->requisitar->qual->condicionantes["ano"] as $ano) {
				$anos[] = $ano;
			}
			sort($anos);
			$datas = [];
			foreach ($anos as $ano){
				foreach ($meses as $mes) {
					$datas[] = "01/". FuncoesData::MesNum($mes) . "/$ano" ; 
					$datas[] = FuncoesData::UltDiaMes($datas[count($datas)-1]);
				}
			}
			$dtini = $datas[0];
			$dtfim = $datas[count($datas)-1];
			$anoini = $anos[0];
			$anofim = $anos[count($anos)-1];
			$comhttp->requisicao->requisitar->qual->condicionantes["datas"] = implode(",",$datas);
			$cmps_select ="";
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
			$comhttp->retorno->mostrar_vals_de = [3];
			$comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3];
			$condicionantes = "rca=".implode(",rca=",$rcas);
			$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = str_replace(",",Constantes::sepn2,$condicionantes);
			if (isset($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) && $comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] !== null) {
				if (gettype($comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"]) !== "array") {
					$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] .= Constantes::sepn1 . "sjdobjetivossinergia[sjdobjetivossinergia.codcampanhasinergia=0]";
				} else {
					$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"][] = "sjdobjetivossinergia[sjdobjetivossinergia.codcampanhasinergia=0]";
				}
			} else {
				$comhttp->requisicao->requisitar->qual->condicionantes["condicionantestab"] = "sjdobjetivossinergia[sjdobjetivossinergia.codcampanhasinergia=0]";
			}
			$comhttp->requisicao->requisitar->qual->objeto = $comhttp->requisicao->requisitar->qual->condicionantes["visoes"];	
			$comhttp->requisicao->requisitar->qual->condicionantes["prefixo_nome_proc_condic"] = "lista_condicionantes_";
			$comhttp->requisicao->sql->comando_sql=FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp);
			$retorno = $comhttp->requisicao->sql->comando_sql;
			return $retorno;
		}
		public static function montar_sql_sinergia2(&$comhttp){
			$opcoes_tabela_est = FuncoesHtml::opcoes_tabela_est;
			$opcoes_tabela_est["cabecalho"]["ativo"]=false;
			$opcoes_tabela_est["rodape"]["ativo"] = false;
			$opcoes_tabela_est["subregistros"]["ativo"] = true;
			$comhttp_temp = new TComHttp();
			$comhttp_temp->requisicao->sql = new TSql();
			$comhttp_temp->requisicao->sql->comando_sql = "select * from sjdcampanhassinergia where dtfim >= sysdate";
			$comhttp_temp->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$mesPeriodo1 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo1"]));
			$mesPeriodo2 = strtoupper(trim($comhttp->requisicao->requisitar->qual->condicionantes["mesperiodo2"]));
			$anoPeriodo1 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo1"];
			$anoPeriodo2 = $comhttp->requisicao->requisitar->qual->condicionantes["anoperiodo2"];
			$dataPeriodo1 = "01/" . FuncoesData::MesNum($mesPeriodo1) . "/" . $anoPeriodo1;
			$dataPeriodo2 = "01/" . FuncoesData::MesNum($mesPeriodo2) . "/" . $anoPeriodo2;
			$dataPeriodo2 = FuncoesData::UltDiaMes($dataPeriodo2);
			$comhttp_temp1 = new TComHttp();
			$comhttp_temp1->requisicao->sql = new TSql();
			$comhttp_temp1->requisicao->sql->comando_sql = "select * from sjdobjetivossinergia where codcampanhasinergia = " . $comhttp_temp->retorno->dados_retornados["dados"]["tabela"]["dados"][0][0] . " and mes||'/'||ano in ('$mesPeriodo1'||'/'||$anoPeriodo1,'$mesPeriodo1'||'/'||$anoPeriodo1)";		
			$comhttp_temp1->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp1->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$objetivo_acumulado = 0;
			foreach($comhttp_temp1->retorno->dados_retornados["dados"]["tabela"]["dados"] as $lin) {
				$objetivo_acumulado += FuncoesConversao::como_numero($lin[7]);
			}
			$comhttp_temp2 = new TComHttp();
			$comhttp_temp2->requisicao->sql = new TSql();
			$comhttp_temp2->requisicao->requisitar->qual->objeto="produto";
			$comhttp_temp2->requisicao->requisitar->qual->condicionantes["datas"] = $dataPeriodo1 . "," . $dataPeriodo2;
			$comhttp_temp2->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"] = [3]; 
			$comhttp_temp2->requisicao->sql->comando_sql = FuncoesSql::getInstancia()->montar_sql_processo_estruturado($comhttp_temp2,"relatorio_venda");
			$comhttp_temp2->retorno->dados_retornados["dados"] = FuncoesSql::getInstancia()->executar_sql($comhttp_temp2->requisicao->sql->comando_sql,"fetchAll",\PDO::FETCH_ASSOC);
			$atingido_acumulado = 0;
			foreach($comhttp_temp2->retorno->dados_retornados["dados"]["tabela"]["dados"] as $lin) {
				$atingido_acumulado += FuncoesConversao::como_numero($lin[2]);
			}
			$opcoes_tabela_est["dados"]["tabela"]["titulo"]["arr_tit"] = [
				[
					"valor"=>"CAMPANHA",
					"cod"=>0,
					"codsup"=>-1,
					"indexreal"=>0,
					"linha"=>0,
					"coluna"=>0,
					"rowspan"=>1,
					"colspan"=>1,
					"formatacao"=>"cel_texto"
				],[
					"valor"=>"OBJETIVO",
					"cod"=>1,
					"codsup"=>-1,
					"indexreal"=>1,
					"linha"=>0,
					"coluna"=>1,
					"rowspan"=>1,
					"colspan"=>1,
					"formatacao"=>"cel_peso"
				],[
					"valor"=>"REALIZADO",
					"cod"=>2,
					"codsup"=>-1,
					"indexreal"=>2,
					"linha"=>0,
					"coluna"=>2,
					"rowspan"=>1,
					"colspan"=>1,
					"formatacao"=>"cel_peso"
				],[
					"valor"=>"%REALIZADO",
					"cod"=>2,
					"codsup"=>-1,
					"indexreal"=>2,
					"linha"=>0,
					"coluna"=>2,
					"rowspan"=>1,
					"colspan"=>1,
					"formatacao"=>"cel_perc"
				]];
			$opcoes_tabela_est["dados"]["tabela"]["dados"] = [
				[$comhttp_temp->retorno->dados_retornados["dados"]["tabela"]["dados"][0][1],$objetivo_acumulado,$atingido_acumulado, $atingido_acumulado / $objetivo_acumulado * 100]
			];
			$texto_retorno = FuncoesHtml::montar_tabela_est_html($comhttp_temp,$opcoes_tabela_est,true);
			return $texto_retorno;
		}
		public static function montar_sql_tabela_para_edicao(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "select ".$comhttp->requisicao->requisitar->qual->condicionantes["tabela"].".rowid||'' as rid,".$comhttp->requisicao->requisitar->qual->condicionantes["tabela"].".* from ".$comhttp->requisicao->requisitar->qual->condicionantes["tabela"];
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_ult_peds_cli(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "WITH todos_pedidos AS (
							SELECT
								pc.numped,
								pc.data,
								pc.posicao,
								pc.vltotal,
								nvl(pc.vltotal,0)*nvl(pc.perdesc,0)/100 as vldesc,
								pc.numitens,
								pc.codplpag,
								pl.numdias,
								pl.descricao,
								pl.numpr,
								pb.cobranca,
								pb.codcob
							FROM
								jumbo.pcpedc pc,
								jumbo.pcplpag pl,
								jumbo.pccob pb
							WHERE
								pc.codcli = ".$comhttp->requisicao->requisitar->qual->condicionantes["codcli"]."
							AND
								pc.codplpag = pl.codplpag (+)
							AND
								pc.codcob = pb.codcob (+)
							ORDER BY
								pc.data DESC
							) 
							SELECT
								*
							FROM
								todos_pedidos
							WHERE
								ROWNUM <= 5 ";
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_ult_peds_itens_cli(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "SELECT
							i.numped,
							i.codprod,
							p.descricao,
							i.qt,
							i.perdesc,
							i.ptabela,
							i.pvenda,
							i.qt * i.pvenda AS vltotal,
							p.unidade, 
							p.qtunitcx,
							p.multiplo,
							pr.pvenda1,
							pr.pvenda2,
							pr.pvenda3,
							pr.pvenda4,
							pr.pvenda5,
							pr.pvenda6,
							pr.perdescmax,
							cb.regratextual as regraenquadramento,
							icb.regratextual as regravalidacao					
						FROM
							jumbo.pcpedi i,
							jumbo.pcprodut p,
							jumbo.pctabpr pr,
							combo cb,
							itemcombo icb
						WHERE
							i.codprod = p.codprod (+)
							and i.codprod = pr.codprod(+)
							AND 	 p.codprod = cb.coditem(+)
							and 	 cb.codcombo = icb.codcombo(+)					
							and pr.numregiao = (select numregiaocli from jumbo.pcclient where codcli = (select codcli from jumbo.pcpedc where numped = ".$comhttp->requisicao->requisitar->qual->condicionantes["numped"]."))
							AND i.numped = ".$comhttp->requisicao->requisitar->qual->condicionantes["numped"];
			return $comhttp->requisicao->sql->comando_sql;
		}
		public static function montar_sql_ult_peds_rca(&$comhttp){
			$comhttp->requisicao->sql->comando_sql = "WITH todos_pedidos AS (
							SELECT
								pc.numped,
								pc.data,
								pc.posicao,
								pc.vltotal,
								nvl(pc.vltotal,0)*nvl(pc.perdesc,0)/100 as vldesc,
								pc.numitens,
								pc.codplpag,
								pl.numdias,
								pl.descricao,
								pl.numpr,
								pb.cobranca,
								pb.codcob
							FROM
								jumbo.pcpedc pc,
								jumbo.pcplpag pl,
								jumbo.pccob pb
							WHERE
								pc.codusur in ("./*$_SESSION["rcas_subordinados"]*/"101".") 
							AND
								pc.codplpag = pl.codplpag (+)
							AND
								pc.codcob = pb.codcob (+)
							ORDER BY
								pc.data DESC
							) 
							SELECT
								*
							FROM
								todos_pedidos
							WHERE
								ROWNUM <= 5 ";
			return $comhttp->requisicao->sql->comando_sql;
		}

		public static function montar_sql_valores_por_entidade($params) : string{
			$params["agregacao"] = $params["agregacao"] ?? "sum";
			$params["campo"] = $params["campo"] ?? "valor";

			$retorno = "
				select ".$params["agregacao"]."(nvl(".$params["campo"].",0)) 
				from sjdvalores_por_entidade 
				where entidade in ('__ENTIDADE__')
					__CODSENTIDADES__
					and nome_valor = '__NOMEVALOR__'
					and periodo_ini_ref = to_date('__DTINI__','dd/mm/yyyy')
					and periodo_fim_ref = to_date('__DTFIM__','dd/mm/yyyy')
					__CONDICIONANTES__";
			$retorno = str_replace("__ENTIDADE__",$params["entidade"],$retorno);
			if (isset($params["codsentidades"]) && $params["codsentidades"] !== null && strlen($params["codsentidades"]) > 0) {
				$retorno = str_replace("__CODSENTIDADES__"," and codentidade in (" . $params["codsentidades"] . ") ",$retorno);
			} else {
				$retorno = str_replace("__CODSENTIDADES__","",$retorno);
			}
			$retorno = str_replace("__NOMEVALOR__",$params["nomevalor"],$retorno);
			$retorno = str_replace("__DTINI__",$params["dtini"],$retorno);
			$retorno = str_replace("__DTFIM__",$params["dtfim"],$retorno);
			if (isset($params["condicionantes"]) && $params["condicionantes"] !== null && strlen($params["condicionantes"]) > 0) {
				$retorno = str_replace("__CONDICIONANTES__"," and " . $params["condicionantes"]??"",$retorno);
			} else {
				$retorno = str_replace("__CONDICIONANTES__","",$retorno);
			}
			
			return $retorno;
		}

		public static function extrair_montar_condicionantes_linear__rec(&$condicionantes, &$condicionantes_retorno) 
		{
			if (gettype($condicionantes) === "array") {
				foreach ($condicionantes as &$condicionante) {
					self::extrair_montar_condicionantes_linear__rec($condicionante, $condicionantes_retorno);
				}
			} else {
				if (in_array(gettype($condicionantes),["object","resource"])) {
					$condicionantes = stream_get_contents($condicionantes);
				}
				if (strlen(trim($condicionantes)) > 0) {
					$condicionante_valida = false;
					$nova_condic = [];
					if (strpos($condicionantes, "!=") !== false) {
						$nova_condic["op"] = "!=";
						$condicionante_valida = true;
					} else if (strpos($condicionantes, "=") !== false) {
						$nova_condic["op"] = "=";
						$condicionante_valida = true;
					} else {
						//FuncoesBasicasRetorno::mostrar_msg_sair("condicionante invalida: " . $condicionantes, __FILE__, __FUNCTION__, __LINE__);
						$condicionante_valida = false;
					}
					if ($condicionante_valida) {
						$condicionantes = explode($nova_condic["op"], $condicionantes);
						$nova_condic["processo"] = $condicionantes[0];
						$nova_condic["valor"] = $condicionantes[1];				
						if (!isset($condicionantes_retorno[$nova_condic["processo"]])) {
							$condicionantes_retorno[$nova_condic["processo"]] = [];
						}
						$condicionantes_retorno[$nova_condic["processo"]][] = $nova_condic;
					} else {
						unset($condicionantes);
					}
				} else {
					unset($condicionantes);
				}
			}
		}
	}
?>