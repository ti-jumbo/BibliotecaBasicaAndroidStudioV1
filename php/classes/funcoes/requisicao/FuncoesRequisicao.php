<?php
	namespace SJD\php\classes\funcoes\requisicao;
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_file.php';	
	/*bloco de definicao de usos*/
	
	use SJD\php\classes\{
			ClasseBase,
			Acess,
			constantes\Constantes
		};
	use SJD\php\classes\funcoes\{
		FuncoesObjeto,
		FuncoesArray,
		requisicao\TComHttpSimples
	};
	
	/*codigo*/
	class FuncoesRequisicao extends ClasseBase{		

		private static function retornar_logar(&$comhttp) {
			
			$url = 'http://' . $_SERVER['HTTP_HOST'].'/sjd/login.php';
    		header('Location: ' . $url, true, 301); 
			exit();
		}

		public static function verificar_sessao(&$comhttp) {			
			if (!Acess::logged() && strcasecmp($comhttp->requisicao->requisitar->oque,'logar') != 0) {					
				self::retornar_logar($comhttp);
			} 			
		}	
		public static function requisicao_nao_logado(&$comhttp){
			$comhttp->retorno->dados_retornados = 'NAO LOGADO';
		}
		public static function requisicao_vazia(&$comhttp){
			$comhttp->retorno->dados_retornados = 'REQUISICAO VAZIA';
		}
		public static function requisicao_vazia_simples(&$comhttpsimples){
			$comhttpsimples->r = 'REQUISICAO VAZIA';
		}
		public static function atribuir_valores_post(&$comhttp,$post) {
			if (isset($post)) {
				if (count($post)>0) {
					if (isset($_POST['id'])) {
						$comhttp->id = $_POST['id'];
					}
					$comhttp->id_carregando = (isset($_POST['id_carregando'])?$_POST['id_carregando']:'');
					if (gettype($post['requisicao']) === 'string') {
						$post['requisicao'] = json_decode($post['requisicao']);
					}
					if (gettype($post['requisicao']) === 'array') {
						$comhttp->requisicao->requisitar->oque = $post['requisicao']['requisitar']['oque'];
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','comando'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->comando = $post['requisicao']['requisitar']['qual']['comando'];
						} else {
							$comhttp->requisicao->requisitar->qual->comando = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','tipo_objeto'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = $post['requisicao']['requisitar']['qual']['tipo_objeto'];
						} else {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','objeto'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->objeto = $post['requisicao']['requisitar']['qual']['objeto'];
						} else {
							$comhttp->requisicao->requisitar->qual->objeto = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','tabela'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->tabela = $post['requisicao']['requisitar']['qual']['tabela'];
						} else {
							$comhttp->requisicao->requisitar->qual->tabela = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','campo'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->campo = $post['requisicao']['requisitar']['qual']['campo'];
						} else {
							$comhttp->requisicao->requisitar->qual->campo = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','valor'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->valor = $post['requisicao']['requisitar']['qual']['valor'];
						} else {
							$comhttp->requisicao->requisitar->qual->valor = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','codusur'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->codusur = $post['requisicao']['requisitar']['qual']['codusur'];
						} else {
							$comhttp->requisicao->requisitar->qual->codusur = $_SESSION['codusur'] ?? '';
						}
						$comhttp->opcoes_retorno = $post['opcoes_retorno'];
						$comhttp->requisicao->requisitar->qual->condicionantes = (isset($post['requisicao']['requisitar']['qual']['condicionantes'])?$post['requisicao']['requisitar']['qual']['condicionantes']:'');						
						if (gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== 'array') {
							$comhttp->requisicao->requisitar->qual->condicionantes = explode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes);
						}
						$comhttp->requisicao->requisitar->qual->condicionantes = FuncoesArray::chaves_associativas($comhttp->requisicao->requisitar->qual->condicionantes);
						if (FuncoesObjeto::verif_valor_prop($post,['eventos','aposretornar'],null,'setado')) {
							$comhttp->eventos->aposretornar = $post['eventos']['aposretornar'];
						} 
					} else {
						$comhttp->requisicao->requisitar->oque = $post['requisicao']->requisitar->oque;
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','comando'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->comando = $post['requisicao']->requisitar->qual->comando;
						} else {
							$comhttp->requisicao->requisitar->qual->comando = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','tipo_objeto'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = $post['requisicao']->requisitar->qual->tipo_objeto;
						} else {
							$comhttp->requisicao->requisitar->qual->tipo_objeto = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','objeto'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->objeto = $post['requisicao']->requisitar->qual->objeto;
						} else {
							$comhttp->requisicao->requisitar->qual->objeto = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','tabela'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->tabela = $post['requisicao']->requisitar->qual->tabela;
						} else {
							$comhttp->requisicao->requisitar->qual->tabela = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','campo'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->campo = $post['requisicao']->requisitar->qual->campo;
						} else {
							$comhttp->requisicao->requisitar->qual->campo = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','valor'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->valor = $post['requisicao']->requisitar->qual->valor;
						} else {
							$comhttp->requisicao->requisitar->qual->valor = '';
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','codusur'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->codusur = $post['requisicao']->requisitar->qual->codusur;
						} else {
							$comhttp->requisicao->requisitar->qual->codusur = $_SESSION['codusur'];
						}
						if (FuncoesObjeto::verif_valor_prop($post,['requisicao','requisitar','qual','senha'],null,'setado')) {
							$comhttp->requisicao->requisitar->qual->senha = $post['requisicao']->requisitar->qual->senha;
						} 
						$comhttp->opcoes_retorno = (isset($post['opcoes_retorno'])?$post['opcoes_retorno']:'');
						$comhttp->requisicao->requisitar->qual->condicionantes = (isset($post['requisicao']->requisitar->qual->condicionantes)?$post['requisicao']->requisitar->qual->condicionantes:'');						
						if (gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== 'array') {
							$comhttp->requisicao->requisitar->qual->condicionantes = explode(Constantes::sepn1,$comhttp->requisicao->requisitar->qual->condicionantes);
						}
						$comhttp->requisicao->requisitar->qual->condicionantes = FuncoesArray::chaves_associativas($comhttp->requisicao->requisitar->qual->condicionantes);
						if (FuncoesObjeto::verif_valor_prop($post,['eventos','aposretornar'],null,'setado')) {
							$comhttp->eventos->aposretornar = $post['eventos']->aposretornar;
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
					/*requisicoes cujo a,b,c vem soltos no request e nao encapsulados no r*/
					if (!isset($post['r']) && isset($post['a'])) {
						$post = [
							'r'=>$post
						];
						$post['r'] = json_encode($post['r']);
					}
					if (isset($post['r'])) {
						$r = json_decode($post['r']);
						if (in_array(gettype($r),['integer','string'])) {
							$comhttpsimples->a = 0; //requisicoes iniciais estao vinculadas ao usuario 0 (padrao)
							$comhttpsimples->b = $r;
						} else {
							$comhttpsimples->a = $r->a;
							$comhttpsimples->b = $r->b;
							$comhttpsimples->c = '';
							if (isset($r->c)) {
								$comhttpsimples->c = $r->c;
							} 
							if (gettype($comhttpsimples->c) !== 'array') {
								$comhttpsimples->c = explode(Constantes::sepn1,$comhttpsimples->c);
							}
							$comhttpsimples->c = FuncoesArray::chaves_associativas($comhttpsimples->c);
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