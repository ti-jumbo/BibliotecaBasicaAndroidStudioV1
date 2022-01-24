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
			FuncoesRequisicaoSis,
            TComHttp
		};		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais(["checar_chamador"=>false, "atribuir_chamador"=>true, "checar_post"=>true]);
	
	
	/*codigo*/	

    /*cria o objeto http e atribui dados*/
    $comhttp = new TComHttp();//receber_requisicao($_POST);				
    $dados_req = [];
    if (isset($_POST) && count($_POST) > 0) {
        $dados_req = $_POST;
    } else if (isset($_GET) && count($_GET) > 0) {
        $dados_req = $_GET;
    }    
    if (isset($dados_req)) {			
        if (isset($dados_req["oque"])) {
            $comhttp->requisicao->requisitar->oque = $dados_req["oque"];
        } else {
            $comhttp->requisicao->requisitar->oque = "funcoes_erp";
        }
        if (isset($dados_req["comando"])) {
            $comhttp->requisicao->requisitar->qual->comando = $dados_req["comando"];
        } else {
            $comhttp->requisicao->requisitar->qual->comando = "atualizar_realizado_objetivos_sinergia";
        }
        if (!isset($comhttp->requisicao->requisitar->qual->condicionantes) || (isset($comhttp->requisicao->requisitar->qual->condicionantes) && gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== "array")) {
            $comhttp->requisicao->requisitar->qual->condicionantes = [];
        }
        foreach($dados_req as $chave=>$val) {
            if (!in_array($chave,["oque","comando"])) {                
                $comhttp->requisicao->requisitar->qual->condicionantes[$chave] = $val;
            }
        }
    } else {
        $comhttp->requisicao->requisitar->oque = "funcoes_erp";
        $comhttp->requisicao->requisitar->qual->comando = "atualizar_realizado_objetivos_sinergia";
    }
    $comhttp->requisicao->requisitar->qual->codusur = 142;		
    $comhttp->requisicao->requisitar->qual->senha = 'Racnela1';
    if (!isset($comhttp->requisicao->requisitar->qual->condicionantes) || (isset($comhttp->requisicao->requisitar->qual->condicionantes) && gettype($comhttp->requisicao->requisitar->qual->condicionantes) !== "array")) {
            $comhttp->requisicao->requisitar->qual->condicionantes = [];
    }
    if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["usuario"])) {
        $comhttp->requisicao->requisitar->qual->condicionantes["usuario"] = 142;
    }
    if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["senha"])) {
        $comhttp->requisicao->requisitar->qual->condicionantes["senha"] = "Racnela1";
    }
    
    //$comhttp->requisicao->requisitar->qual->comando = str_replace("_mes_anterior","",strtolower(trim($comhttp->requisicao->requisitar->qual->comando)));
    $comhttp->retorno->resultado = "sucesso"; //indica comunicação com servidor, se recebeu a requisição, houve sucesso na comunicação.
    $comhttp = FuncoesRequisicaoSis::getInstancia()->processar_requisicao($comhttp);
    
    /*se a requisicao oracle chegou ate aqui sem erros, a unica resposta esperada pelos processos oracle eh sucesso*/
    $comhttp = "sucesso";
    FuncoesBasicasRetorno::getInstancia()->enviar_retorno($comhttp);
?>