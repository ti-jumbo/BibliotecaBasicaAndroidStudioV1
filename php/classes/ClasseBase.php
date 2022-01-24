<?php
	namespace SJD\php\classes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\funcoes\FuncoesIniciais;
	
	
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	/*
		ClasseBase implementa a base para outras classe no formato SingleTon, 
		para isso chamar NomeClasse::getInstancia() ou ClasseBase::getInstancia(NomeClasse) para obter a SingleTon
	*/
	abstract class ClasseBase {
		private static $instancias = [];
		private $instancia_sis = null;
		function __construct($pinstancia_sis = null)
		{
			/*em sistemas que vao utilizar funcoes do sjd, chamar setInstanciaSis para arquivos de nomes iguais, por exemplo NomesCaminhosArquivos*/
			$this->instancia_sis = $pinstancia_sis ?? self::$instancia_sis ?? $this;
		}
		/*
			As classes que herdarem desta devem chamar esta function para receber a Single Instance. 
		*/
		public static function getInstancia() : ClasseBase
		{			
			$classe = static::class;
			if (!isset(self::$instancias[$classe])) {
				self::$instancias[$classe] = new static();
			}
			return self::$instancias[$classe];			
		}
		
		protected function __clone() { }
		
		public function __wakeup()
		{
			throw new \Exception("Cannot unserialize a singleton.");
		}
		
		public function setInstanciaSis($pinstancia_sis) {
			$this->instancia_sis = $pinstancia_sis;
		}
		
		public function getInstanciaSis(){
			return $this->instancia_sis;
		}
		
		public function getPropInstanciaSis($nome_prop){
			try {
				$retorno = null;			
				if (isset($this->instancia_sis) && $this->instancia_sis !== null) {
					if (defined($this->instancia_sis::class . "::$nome_prop")) {
						$retorno = constant($this->instancia_sis::class . "::$nome_prop");
					} elseif (property_exists($this->instancia_sis,$nome_prop)) {
						/*tenta obter como estatica primeiramente, se houver erro, pega como nao estatica*/
						try {
							$retorno = $this->instancia_sis::class::$$nome_prop;
						} catch(\Error | \Throwable | \Exception $e) {
							$retorno = $this->instancia_sis->{$nome_prop};
						} 
					} else {
						//echo "propriedade $nome_prop nao existe em "  .$this->instancia_sis::class; exit();
					}
				} else {
					trigger_error("instancia_sis de " . self::class . " nula");
				}
				return $retorno;
			} catch(\Error | \Throwable | \Exception $e) {
				print_r($e);
				exit();
				return null;
			} 
		}		
	};
?>