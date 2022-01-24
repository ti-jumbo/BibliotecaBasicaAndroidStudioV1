<?php
	namespace SJD\php\classes\constantes;	
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			funcoes\FuncoesIniciais,
			funcoes\FuncoesSisJD
		};
	
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class Constantes extends ClasseBase {
		public const versao_arquivos = "1.81";
		public const nomesis = "SISJD";
		public const descricao_nomesis = "Sistema Basico Util";
		public const abreviacao_nomesis = "SJD";
		public const abreviacao_nomesisjd = self::abreviacao_nomesis;
		public const ig = "=";
		public const sepn1="_1N_,_N1_";
		public const sepn2 ="_2N_,_N2_";
		public const subst_virg = "nvirg_nvirg";
		public const __NOMEORIGINALSIS__ = "SISJD";	
		public const sinonimos = [
			"todos" =>["tudo","todo","toda","todos","todas","all","alls"],
			"varchar2" =>["varchar2","varchar","texto","textos","palavra","letra","palavras","letras","strings"],
			"tipo_tem_apostrofo" =>["varchar2","varchar","texto","textos","palavra","letra","palavras","letras","strings","data","date"],
			"number" =>["number","numeric","numero","número","integer","inteiro","real","float","flutuante","numeros","inteiros","numbers"],
			"date" =>["data","date"],
			"especifico" =>["especifico","especifica","especicos","especificas","especif"]
		];
		public const array_verdade = ["sim","true","1",true,1];
		public const array_falsidade = ["nao","não","","false","0",0,false];
		public const meses = ["JANEIRO","FEVEREIRO","MARCO","ABRIL","MAIO","JUNHO","JULHO","AGOSTO","SETEMBRO","OUTUBRO","NOVEMBRO","DEZEMBRO"];
		public const meses_abrev = ["JAN","FEV","MAR","ABR","MAI","JUN","JUL","AGO","SET","OUT","NOV","DEZ"];
		public static $visoes_possiveis = null;
		public static $visoes = null;
		public static $visoes_sinergia = null;
		public static $visoes_condic = null;
		public static $rcas_sinergia = null;
		public function __construct(){
			parent::__construct($this);
			self::$visoes_possiveis = FuncoesSisJD::obter_visoes_relatorio_venda();			
			self::$visoes_condic = FuncoesSisJD::obter_visoes_relatorio_venda_condic();			
			self::$visoes = self::$visoes_possiveis;
			self::$visoes_sinergia = ["Filial","Supervisor","RCA","Departamento","Produto"];			
		}
	}
?>