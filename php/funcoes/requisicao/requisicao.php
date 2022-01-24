<?php		
	namespace SJD\php\funcoes\requisicao;
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\constantes\Constantes;
	use SJD\php\classes\funcoes\{
			FuncoesErro,
			FuncoesIniciais
		};
	use SJD\php\classes\funcoes\requisicao\{
			FuncoesBasicasRetorno,			
			FuncoesRequisicao,
			FuncoesRequisicaoSis
		};		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais(["checar_chamador"=>false, "atribuir_chamador"=>true, "checar_post"=>true]);
	
	
	/*codigo*/
	$comhttp = FuncoesRequisicao::getInstancia()->receber_requisicao($_POST);
	$comhttp->retorno->resultado = "sucesso"; //indica comunicação com servidor, se recebeu a requisição, houve sucesso na comunicação.
	
	$comhttp = FuncoesRequisicaoSis::getInstancia()->processar_requisicao($comhttp);		
	
	FuncoesBasicasRetorno::getInstancia()->enviar_retorno($comhttp);
?>