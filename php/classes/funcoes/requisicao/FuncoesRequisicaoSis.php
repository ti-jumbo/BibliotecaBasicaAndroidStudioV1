<?php
	namespace SJD\php\classes\funcoes\requisicao;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';
	
	use SJD\php\classes\ClasseBase;
	use SJD\php\classes\funcoes\{
			FuncoesSisJD,
			requisicao\FuncoesRequisicao,
			FuncoesAtualizacao,
			FuncoesConversao,
			FuncoesMontarSql,
			FuncoesSql,
			FuncoesArquivo
		};
	
	/*codigo*/
	class FuncoesRequisicaoSis extends ClasseBase{		
		function processar_requisicao(&$comhttp) {			
			FuncoesRequisicao::getInstancia()->verificar_sessao($comhttp);							
			$comhttp->retorno->resultado = 'sucesso';	
			switch(strtolower(trim($comhttp->requisicao->requisitar->oque))) {
				case 'logar':					
					FuncoesSisJD::logar_sisjd($comhttp);
					break;
				case 'opcao_cadastrarse':	
					opcao_cadastrarse($comhttp);
					break;				
				case 'cadastrarse':	
					cadastrarse($comhttp);
					break;								
				case 'opcao_recuperar_login':	
					opcao_recuperar_login($comhttp);
					break;				
				case 'recuperar_login':	
					recuperar_login($comhttp);
					break;								
				case 'conteudo_html':									
					FuncoesSisJD::conteudo_html($comhttp);									
					break;			
				case 'processar_atualizacao':
					FuncoesAtualizacao::processar_atualizacao($comhttp);
					break;		
				case 'dados_sql':
					FuncoesSisJD::dados_sql($comhttp);	
					break;
				case 'dados_sqlws':
					dados_sqlws($comhttp);	
					break;				
				case 'dados_arquivo':
					dados_arquivo($comhttp);	
					break;				
				case 'gravar_dados_arquivo':
					gravar_dados_arquivo($comhttp);	
					break;								
				case 'criar_arquivo_catalogo':
					criar_arquivo_catalogo($comhttp);	
					break;												
				case 'deletar_arquivo_catalogo':
					deletar_arquivo_catalogo($comhttp);	
					break;												
				case 'renomear_arquivo_catalogo':
					renomear_arquivo_catalogo($comhttp);	
					break;																	
				case 'atualizar_dados_sql':
					FuncoesSql::getInstancia()->atualizar_dados_sql($comhttp);			
					break;			
				case 'excluir_dados_sql':
					FuncoesSql::getInstancia()->excluir_dados_sql($comhttp);			
					break;			
				case 'incluir_dados_sql':
					FuncoesSql::getInstancia()->incluir_dados_sql($comhttp);			
					break;							
				case 'gravar_dados_sql':
					FuncoesSql::getInstancia()->gravar_dados_sql($comhttp);			
					break;			
				case 'dados_literais':
					FuncoesSisJD::dados_literais($comhttp);			
					break;			
				case 'tela':
					tela($comhttp);
					break;			
				case 'compartilhar':				
					FuncoesSisJD::compartilhar($comhttp);
					break;							
				case 'funcoes_sisjd':
					FuncoesSisJD::funcoes_sisjd($comhttp);
					break;
				case 'funcoes_erp':
					FuncoesSisJD::funcoes_erp($comhttp);
					break;		
				case 'funcoes_eventuais':				
					FuncoesSisJD::funcoes_eventuais($comhttp);
					break;			
				default:
					$comhttp->retorno->resultado = 'falha';
					$comhttp->retorno->dados_retornados['conteudo_html'] = __FILE__.'.'.__FUNCTION__.'.'.__LINE__.':requisitar o que nao implementado: '.$comhttp->requisicao->requisitar->oque;
			}
			FuncoesSisJD::log_acesso($comhttp);
			return $comhttp;
		}
		
		public static function montar_retorno_simples_padrao(&$comhttpsimples,?array $params_sql = null) : void{
			$params_sql = $params_sql ?? [];
			$params_sql['query'] = $params_sql['query'] ?? $comhttpsimples->d['s'];
			$params_sql['fetch'] = $params_sql['fetch'] ?? 'fetchAll';
			$params_sql['fetch_mode'] = $params_sql['fetch_mode'] ?? \PDO::FETCH_NUM;
			$params_sql['retornar_resultset'] = $params_sql['retornar_resultset'] ?? true;
			$dados = FuncoesSql::getInstancia()->executar_sql($params_sql);
			$comhttpsimples->r['dados'] = [
				'tabela'=>[
					'titulo'=>$dados['fields'],
					'dados'=>$dados['data']
				]
			];
		}
		
		public static function processar_requisicao_simples(&$comhttpsimples) {
			/*lembrar de passar para montar_retorno_simples_padrao 'fetchClob' se o resultado contiver clob*/
			switch(FuncoesConversao::como_numero($comhttpsimples->b)) {
				case 0: /*catalogo tabelas e campos inicial(somente tabelas tabeladb e campodb)*/				
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_tabeladbcel($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 1: /*catalogo tabelas(todas)*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_tabeladbcel($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 2: /*catalogo campos(todas)*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_campodbcel($comhttpsimples);								
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 3: /*catalogo processos*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_processoscel($comhttpsimples);								
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 4: /*catalogo comandossql*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_comandossqlcel($comhttpsimples);								
					self::montar_retorno_simples_padrao($comhttpsimples,['fetch'=>'fetchClob']);
					break;						
				case 5: /*lista atualizacoes obrigatorias*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_atualizacoes_obrigatorias($comhttpsimples);								
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 6: /*itens sincronizacoes*/
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_itens_sincronizacoes($comhttpsimples);								
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 10: /*SIMPLE LOGIN*/
					$comhttpsimples->r['logged'] = FuncoesSisJD::login(code:$comhttpsimples->a,password:$comhttpsimples->c[0]);
					if ($comhttpsimples->r['logged'] == true) {
						$comhttpsimples->r['user'] = $comhttpsimples->u;
						$comhttpsimples->r['user']['senha'] = null;
					}
					break;	
				case 100:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_clientes_atualizados($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;				
				case 101:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_dados_cliente($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 102: /*transmitir pedido unico*/								
					FuncoesSisJD::consultar_cliente_rfb_simples($comhttpsimples);								
					break;
				case 103: /*transmitir cliente unico*/								
					FuncoesSisJD::cadastrar_cliente_simples($comhttpsimples);								
					break;
				case 104:/*lista clientes*/								
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_clientes_simples($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 200: /*lista produtos completa*/								
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_produtos_completa_simples($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 201:/*lista produtos estoque*/								
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_estoque_simples($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;				
				case 302: /*transmitir pedido unico*/								
					FuncoesSisJD::incluir_pedido_simples($comhttpsimples);								
					break;	
				case 301: /*receber status pedidos*/								
					FuncoesSisJD::status_pedidos_simples($comhttpsimples);								
					break;	
				case 400:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_politicas_desconto($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 401:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_precos_fixos($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 500: //receber mensagens sistema
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_mensagens_sistema($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;					
				case 501: //receber mensagens usuarios
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_mensagens_usuarios($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;					
				case 502: //receber mensagens usuarios
					FuncoesSisJD::incluir_mensagens($comhttpsimples);								
					break;	
				case 600:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_cobrancas($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 601:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_cobrancas_clientes($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;				
				case 610:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_prazos($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 611:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_prazos_clientes($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 612:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_restricoes_prazos($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;				
				case 620:
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_cobrancas_x_prazos($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;										
				case 1000: //receber naturezas juridicas
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_naturezas_juridicas($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 1001: //receber naturezas juridicas
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_portes_empresas($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;		
				case 1002: //receber naturezas juridicas
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_tipos_empresas($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 1003: //receber naturezas juridicas
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_cnaes($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;	
				case 1010: //receber naturezas juridicas
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_lista_estados($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);
					break;
				case 50000: //processar requisicao de senha cofre chave veiculo reserva motorista
					FuncoesSisJD::processar_requisicao_senha_veiculo_reserva($comhttpsimples);				
					break;
				case 50100: //processar requisicao de senha cofre chave veiculo reserva motorista
					FuncoesSisJD::verificar_senha_cadastrada($comhttpsimples);								
					break;
				case 50101: 
					FuncoesSisJD::cadastrar_senha_cofre($comhttpsimples);								
					break;
				case 50110: 
					FuncoesSisJD::processar_requisicao_devolver_chave($comhttpsimples);								
					break;
				case 60001: 
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_cargas($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);							
					break;
				case 60002: 
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_notascargajumbo($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples,['fetch'=>'fetchClob']);		
					//print_r($comhttpsimples->r['dados']['tabela']['dados']);exit();
					break;
				case 60003: 
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_itensnotascargajumbo($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);							
					break;
				case 60004: 
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_pagamentosnotascargajumbo($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);							
					break;
				case 60005: 
					$comhttpsimples->d['s'] = FuncoesMontarSql::montar_sql_consulta_pagamentoscarregamentosjumbo($comhttpsimples);
					self::montar_retorno_simples_padrao($comhttpsimples);							
					break;
				case 60010: /*transmitir entrega unica*/								
					FuncoesSisJD::incluir_entrega_simples($comhttpsimples);								
					break;
				case 60011: /*transmitir carregamento simples*/
					FuncoesSisJD::incluir_carregamento_simples($comhttpsimples);								
					break;
				
				default:
					$comhttpsimples->r = __FILE__.'.'.__FUNCTION__.'.'.__LINE__.':requisitar o que nao implementado: '.$comhttpsimples->b;
					break;
			}
			return $comhttpsimples;
		}


		public static function processar_requisicaows(&$comhttp) {
			if ($comhttp->requisicao->requisitar->oque === 'logar') {
			} else {
				session_write_close();
			}
			$comhttp->retorno->resultado = 'sucesso';		
			switch(strtolower(trim($comhttp->requisicao->requisitar->oque))) {
				case 'logar':					
					FuncoesSisJD::logar_sisjd($comhttp);				
					break;
				case 'opcao_recuperar_login':	
					FuncoesSisJD::opcao_recuperar_login($comhttp);
					break;				
				case 'recuperar_login':	
					FuncoesSisJD::recuperar_login($comhttp);
					break;								
				case 'conteudo_html':
					FuncoesSisJD::conteudo_html($comhttp);
					break;			
				case 'funcoes_iniciais':
					funcoes_iniciais($comhttp);
					break;		
				case 'dados_sql':
					FuncoesSisJD::dados_sqlws($comhttp);	
					break;
				case 'dados_arquivo':
					dados_arquivo($comhttp);	
					break;				
				case 'gravar_dados_arquivo':
					gravar_dados_arquivo($comhttp);	
					break;								
				case 'criar_arquivo_catalogo':
					criar_arquivo_catalogo($comhttp);	
					break;												
				case 'deletar_arquivo_catalogo':
					deletar_arquivo_catalogo($comhttp);	
					break;																
				case 'renomear_arquivo_catalogo':
					renomear_arquivo_catalogo($comhttp);	
					break;												
				case 'atualizar_dados_sql':
					FuncoesSisJD::atualizar_dados_sql($comhttp);			
					break;			
				case 'excluir_dados_sql':
					FuncoesSql::getInstancia()->excluir_dados_sql($comhttp);			
					break;			
				case 'incluir_dados_sql':
					FuncoesSisJD::incluir_dados_sql($comhttp);			
					break;							
				case 'gravar_dados_sql':
					FuncoesSisJD::gravar_dados_sql($comhttp);			
					break;			
				case 'dados_literais':
					FuncoesSisJD::dados_literais($comhttp);			
					break;			
				case 'tela':
					FuncoesSisJD::tela($comhttp);
					break;			
				case 'compartilhar':				
					FuncoesSisJD::compartilhar($comhttp);
					break;							
				case 'funcoes_sisjd':
					FuncoesSisJD::funcoes_sisjd($comhttp);
					break;
				case 'funcoes_erp':
					FuncoesSisJD::funcoes_erp($comhttp);
					break;				
				default:
					$comhttp->retorno->resultado = 'falha';
					$comhttp->retorno->dados_retornados['conteudo_html'] = __FILE__.'.'.__FUNCTION__.'.'.__LINE__.':requisitar o que nao implementado: '.$comhttp->requisicao->requisitar->oque;
			}
			FuncoesSisJD::log_acesso($comhttp);
			return $comhttp;
		}
	}
?>
