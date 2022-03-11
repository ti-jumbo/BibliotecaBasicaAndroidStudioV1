<?php		
	namespace SJD\php\funcoes\requisicao;
	include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_resource.php';	
	/*bloco de definicao de usos*/
	use SJD\php\classes\constantes\Constantes;
	use SJD\php\classes\funcoes\{			
		FuncoesSql
	};
	use SJD\php\classes\funcoes\requisicao\{
		FuncoesBasicasRetorno,			
		FuncoesRequisicao,
		FuncoesRequisicaoSis
	};		
	
	/*codigo*/	
	
    $comhttpsimples = FuncoesRequisicao::getInstancia()->receber_requisicao_simples($_POST);
	$comando_sql = "select * from sjdusuariosis where idsessao='" . $comhttpsimples->a."'";
	if (strlen($comhttpsimples->a) <= 8) {
		$comando_sql .= " or codusuariosis = '" . $comhttpsimples->a . "'";
	}
	$comhttpsimples->u = FuncoesSql::getInstancia()->executar_sql($comando_sql,'fetchAll',\PDO::FETCH_ASSOC);
	if (count($comhttpsimples->u) > 0) {
		$comhttpsimples->u = $comhttpsimples->u[0];	
		$GLOBALS['usuariosis'] = $comhttpsimples->u;
		$comhttpsimples = FuncoesRequisicaoSis::getInstancia()->processar_requisicao_simples($comhttpsimples);		
		FuncoesBasicasRetorno::getInstancia()->enviar_retorno_simples($comhttpsimples);
	} else {
		echo 'sessao nao localizada, logue novamente: ' . $comhttpsimples->a; exit();
	}
?>
