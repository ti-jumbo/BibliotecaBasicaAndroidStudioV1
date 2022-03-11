<?php		
	namespace SJD\php\funcoes\requisicao;
	include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_resource.php';
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\constantes\Constantes;	
	use SJD\php\classes\funcoes\requisicao\{
		FuncoesBasicasRetorno,			
		FuncoesRequisicao,
		FuncoesRequisicaoSis
	};		
	
	/*codigo*/
	$comhttp = FuncoesRequisicao::getInstancia()->receber_requisicao($_POST);
	$comhttp->retorno->resultado = 'sucesso'; //indica comunicação com servidor, se recebeu a requisição, houve sucesso na comunicação.
	$comhttp = FuncoesRequisicaoSis::getInstancia()->processar_requisicaows($comhttp);		
	FuncoesBasicasRetorno::getInstancia()->enviar_retorno($comhttp);	
?>
