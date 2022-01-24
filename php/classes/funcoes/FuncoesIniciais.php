<?php	
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/	
	/*nao deve incluir outras classes, haja vista todas as outras chamarem esta em seu inicio*/
	
	
	/*bloco de inicializacao e protecao*/
	/*nao consta, pois este proprio arquivo eh a inicializacao e protecao*/
	
	
	/*codigo*/
	final class FuncoesIniciais {
		private const titulo_erro = 'ACESSO RESTRITO';
		private const mensagem_erro_acesso_direto_proibido = 
			'<h1>'.self::titulo_erro.'</h1>'
			.'<pre>O Acesso direto ao recurso solicitado foi negado. Este recurso somente está acessível pela raiz do site, apos fazer login.</pre>'
			.'<br /><br />'
			.'<text>Jumbo Alimentos 2021 - Todos os direitos reservados</text>';
		public static function processamentos_iniciais($params=["checar_chamador"=>true, "atribuir_chamador"=>false, "checar_post"=>false]){
			/*bloco de protecao de acesso direto nao autorizado. deve constar em todos os inicios de arquivos*/
			$params = $params ?? ["checar_chamador"=>true, "atribuir_chamador"=>false, "checar_post"=>false];
			$params["checar_chamador"] = $params["checar_chamador"] ?? true;
			$params["atribuir_chamador"] = $params["atribuir_chamador"] ?? false;
			$params["checar_post"] = $params["checar_post"] ?? false;
			if ($params["checar_chamador"] === true) {
				if (!isset($_SERVER["chamador"]) || (isset($_SERVER["chamador"]) && ($_SERVER["chamador"] === null || strlen($_SERVER["chamador"]) === 0))) {					
					echo self::mensagem_erro_acesso_direto_proibido;
					echo "<br />chamador indefinido";
					exit();
				}
			} elseif ($params["atribuir_chamador"] === true) {
				$_SERVER["chamador"] = $_SERVER["REQUEST_URI"];
			}
			if ($params["checar_post"] === true) {
				if (!(isset($_POST) && $_POST !== null && gettype($_POST) === "array" && count($_POST) > 0) 
					 && !(isset($_GET) && $_GET !== null && gettype($_GET) === "array" && count($_GET) > 0)) {
					echo self::mensagem_erro_acesso_direto_proibido;
					echo "<br />post indefinido";
					exit();
				}
			}
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			if (!isset($_SESSION["nome_usuario"])) {
				$_SESSION["nome_usuario"] = "USUARIO";
				$_SESSION["codusur"] = 0;
			}
			//session_write_close();			
		}
	}
?>
