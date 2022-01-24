<?php
	namespace SJD\php\classes\funcoes;
	
	
	/*bloco de definicao de usos*/
	use SJD\php\classes\{
			ClasseBase,
			funcoes\FuncoesIniciais,
			funcoes\requisicao\FuncoesBasicasRetorno
		};
		
		
	/*bloco de inicializacao e protecao*/	
	if (count(spl_autoload_functions()) === 0) {
		set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
		spl_autoload_extensions(".php");
		spl_autoload_register();
	}
	FuncoesIniciais::processamentos_iniciais();
	
	
	/*codigo*/
	class FuncoesData extends ClasseBase{
		public const formatos = [
			"USA"=>"Y-m-d",
			"BR" =>"d/m/Y"
		];
		public static function detectarDelimitador($strData = null) {
			$delimitador = "";
			if(substr_count($strData,"/")==2) {
				$delimitador = "/";
			} elseif (substr_count($strData,"-")==2) {
				$delimitador = "-";
			} elseif (substr_count($strData,".")==2) {
				$delimitador = ".";
			}
			return $delimitador;
		}

		/**
		 * Tenta detectar o formato da data no banco de dados, usado para nos sqls, usar funcoes de conversao 
		 * de string para date, como to_date no oracle (funcao retorna o modelo oracle de data)
		 */
		public static function detectar_formato($data) {
			$sep = null;
			$data = trim($data);
			$formato = "";
			$sep = self::detectarDelimitador($data);
			$arr_data = explode($sep,$data);
			$qtcarac = strlen($arr_data[0]);
			$valor0 = intval($arr_data[0]);
			$valor1 = intval($arr_data[1]);
			$valor2 = intval($arr_data[2]);
			$dia_incluido = false;
			$mes_incluido = false;
			$ano_incluido = false;
			if ($qtcarac === 4) {
				$formato .= "yyyy";
				$ano_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor1 > 12) { //segundo valor eh dia ou ano(unica forma de deduzir isso)
					$formato .= "mm";
					$mes_incluido = true;
				} else {
					$formato .= "dd";
					$dia_incluido = true;
				}
			}
			$formato .= $sep;
			$qtcarac = strlen($arr_data[1]);
			if ($qtcarac === 4) {
				$formato .= "yyyy";
				$ano_incluido = true;
			} elseif ($qtcarac === 3) {
				$formato .= "MON";
				$mes_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor1 > 12 && !$dia_incluido) {
					$formato .= "dd";
					$dia_incluido = true;
				} else {
					$formato .= "mm";
					$mes_incluido = true;
				}
			}
			$formato .= $sep;
			$qtcarac = strlen($arr_data[2]);
			if ($qtcarac === 4) {
				$formato .= "yyyy";
				$ano_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor2 > 12 && !$dia_incluido) {
					$formato .= "dd";
					$dia_incluido = true;
				} elseif (!$dia_incluido) {
					$formato .= "dd";
					$dia_incluido = true;
				} elseif (!$mes_incluido) {
					$formato .= "mm";
					$mes_incluido = true;
				} else {
					$formato .= "yy";
					$ano_incluido = true;
				}
			}			
			return $formato;
		}

		/**
		 * Tenta detectar o formato da data no PHP, usado para parser, usar funcoes de conversao 
		 * de string para date
		 */
		public static function detectarFormatoPHP($data) {
			$sep = null;
			$data = trim($data);
			$formato = "";
			$sep = self::detectarDelimitador($data);
			$arr_data = explode($sep,$data);

			/*analise do primeiro dado*/
			$qtcarac = strlen($arr_data[0]);
			$valor0 = intval($arr_data[0]);
			$valor1 = intval($arr_data[1]);
			$valor2 = intval($arr_data[2]);
			$dia_incluido = false;
			$mes_incluido = false;
			$ano_incluido = false;
			if ($qtcarac === 4) {
				$formato .= "Y";
				$ano_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor1 > 12) { //segundo valor eh dia ou ano(unica forma de deduzir isso)
					$formato .= "m";
					$mes_incluido = true;
				} else {
					$formato .= "d";
					$dia_incluido = true;
				}
			}
			$formato .= $sep;

			/*analise do segundo dado*/
			$qtcarac = strlen($arr_data[1]);
			if ($qtcarac === 4) {
				$formato .= "Y";
				$ano_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor1 > 12 && !$dia_incluido) {
					$formato .= "d";
					$dia_incluido = true;
				} else {
					$formato .= "m";
					$mes_incluido = true;
				}
			}
			$formato .= $sep;

			/*analise do terceiro dado*/
			$qtcarac = strlen($arr_data[2]);
			if ($qtcarac === 4) {
				$formato .= "Y";
				$ano_incluido = true;
			} else { //espera-se qtcaract === 2
				if ($valor2 > 12 && !$dia_incluido) {
					$formato .= "d";
					$dia_incluido = true;
				} elseif (!$dia_incluido) {
					$formato .= "d";
					$dia_incluido = true;
				} else {
					$formato .= "m";
					$mes_incluido = true;
				}
			}			
			return $formato;
		}


        public static function  dataUSA($str_data=null){
			$retorno="";
			if ($str_data <> null) {
				$formato = self::detectarFormatoPHP($str_data);
				//echo $formato; exit();
				if ($formato === self::formatos["USA"]) {
					$retorno = $str_data;
				} elseif ($formato === self::formatos["BR"]) {
					$str_data = explode("/",$str_data);
					$retorno = $str_data[2] . "-" . $str_data[1] . "-" . $str_data[0];
				} else {
					FuncoesBasicasRetorno::mostrar_msg_sair("formato nao esperado: " . $formato, __FILE__,__FUNCTION__,__LINE__);
				}				
			} else {
				$retorno=date('Y-m-d');
			}
			return $retorno;
		}
        public static function  data_primeiro_dia_mes_atual($str_data=""){
			$retorno = "";
			$data = new \DateTime( self::dataUSA($str_data) );
			$dia = "01";
			$mes = $data->format('m');
			$ano = $data->format('Y') ;	
			$retorno = $dia . "/" . $mes . "/" . $ano;	
			return $retorno;
		}

		public static function  data_primeiro_dia_mes_anterior($str_data=""){
			$retorno = "";
			$data = new \DateTime( self::dataUSA($str_data) );
			$dia = "01";
			$mes = (($data->format('m') * 1)-1);
			$ano = $data->format('Y') * 1;
			if ($mes <= 0 ) {
				$mes = 12;
				$ano--;
			}
			if ($mes <= 9) {
				$mes = "0" . $mes;
			}
			$retorno = $dia . "/" . $mes . "/" . $ano;
			return $retorno;
		}
		public static function data_ultimo_dia_mes_anterior($str_data=""){
			$retorno = "";
			$data = new \DateTime( self::dataUSA($str_data) );
			$dia = 27;
			$mes = (($data->format('m') * 1)-1);
			$ano = $data->format('Y') * 1;
			if ($mes > 12 ) {
				$mes = 1;
				$ano++;
			} else if ($mes === 0) {
				$mes = 12;
				$ano--;
			}
			while (checkdate($mes,$dia,$ano) && $dia < 32) {
				$dia++;
			}
			$dia--;
			if ($mes <= 9) {
				$mes = "0" . $mes;
			}
			$retorno = $dia . "/" . $mes . "/" . $ano;
			return $retorno;
		}

        public static function  ano_atual($str_data=""){
			$retorno = "";
			$data = new \DateTime( self::dataUSA($str_data) );
			$dia = $data->format('d');
			$mes = $data->format('m');
			$ano = $data->format('Y');
			$retorno = $ano;
			return $retorno;
		}

        public static function data_atual($str_data=""){
			$d = new \DateTime(self::dataUSA($str_data));
			return $d->format('d/m/Y');
		}

		public static function  dataBR($str_data=null){
			$retorno="";
			$tem_apostrofo=false;
			$piDia=8;
			$comDia=2;
			$piMes=5;
			$comMes=2;
			$piAno=0;
			$comAno=4;
			if($str_data<>null){
				if (gettype($str_data) === "object") {
					$retorno=$str_data->format('d/m/Y');
				} else {
					$formato = self::detectarFormatoPHP($str_data);
					if ($formato === self::formatos["BR"]) {
						$retorno = $str_data;
					} elseif ($formato === self::formatos["USA"]) {
						$str_data = explode("-",$str_data);
						$retorno = $str_data[2] . "/" . $str_data[1] . "/" . $str_data[0];
					} else {
						FuncoesBasicasRetorno::mostrar_msg_sair("formato nao esperado: " . $formato,__FILE__,__FUNCTION__,__LINE__);
					}
				}
			}else{
				$retorno=date('d/m/Y');
			}
			return $retorno;
		}

		public static function  UltDiaMes ( $str_data = ""){
			$retorno="";
			$tem_apostrofo=false;
			$piDia=0;
			$comDia=2;
			$piMes=3;
			$comMes=2;
			$piAno=6;
			$comAno=4;
			if ($str_data === null || strlen(trim($str_data)) === 0) {
				$str_data = self::dataBR();
			}
			$data=str_replace("'","",$str_data);
			
			
			if($data<>$str_data){
				/**
				*	Utilizado a comparação da string recebida original com a sua substituída sem apostrofos para determinar se há ou não
				*	apóstrofo uma vez que a posição dele se existir é 0, que pode confundir-se com false no strpos.
				*/
				$tem_apostrofo=true;
			};
			$str_data=$data;
			
			if($str_data<>null){
				if((substr_count($str_data,"/")==2) || (substr_count($str_data,"-")==2) || (substr_count($str_data,".")==2)){
					$dia=substr($str_data,$piDia,$comDia);
					$mes=substr($str_data,$piMes,$comMes);
					$ano=substr($str_data,$piAno,$comAno);

					//echo $ano; 
					$ultimo_dia = date("t", mktime(0,0,0,intval($mes),1,intval($ano)));
					$str_data=$ultimo_dia."/".$mes."/".$ano;				

					if($tem_apostrofo){
						/**
						* Retirado o retorno por apóstrofo mesmo que venha com apóstrofo para uso em calculos
						*/
						// $str_data="'".$str_data."'";
					};
					$retorno=$str_data;
				}else{
					$retorno="public static function  dataUSA: Parâmetro recebido incorreto.";
				};
			};
			return $retorno;
		}

		public static function  data_ultimo_dia_mes_atual($str_data = ""){
			return self::UltDiaMes($str_data);
		}

		public static function  MesNum ( $str_mes = ""){
			$arr_meses = array("01"=>"JANEIRO","02"=>"FEVEREIRO","03"=>"MARCO","04"=>"ABRIL",
							   "05"=>"MAIO","06"=>"JUNHO","07"=>"JULHO","08"=>"AGOSTO",
							   "09"=>"SETEMBRO","10"=>"OUTUBRO","11"=>"NOVEMBRO","12"=>"DEZEMBRO");		
			return array_search( strtoupper ( $str_mes ) , $arr_meses );
		}

		public static function  mes_atual($str_data=""){
			$retorno = "";
			$data = new \DateTime( self::dataUSA($str_data) );
			$dia = $data->format('d');
			$mes = $data->format('m');
			$ano = $data->format('Y');
			$retorno = $mes;
			return $retorno;
		}

		public static function  MesTexto ( $numMes = 0){
			$arr_meses = array(1=>"JANEIRO",2=>"FEVEREIRO",3=>"MARCO",4=>"ABRIL",
							   5=>"MAIO",6=>"JUNHO",7=>"JULHO",8=>"AGOSTO",
							   9=>"SETEMBRO",10=>"OUTUBRO",11=>"NOVEMBRO",12=>"DEZEMBRO");		
			return $arr_meses[(integer)FuncoesConversao::como_numero(trim($numMes))];
		}

		public static function  comparar_meses($a,$b){
			if (self::MesNum($a) > self::MesNum($b)) {
				return +1;
			} else if (self::MesNum($a) < self::MesNum($b)) {
				return -1;
			} else {
				return 0;
			}
		}

		public static function  ordenar_meses_texto($meses = []) {
			usort($meses,self::class . "::comparar_meses");
			return $meses;
		}

		

		public static function  diferenca_datas($data1,$data2){
			$data1 = new \DateTime( self::dataUSA($data1) );
			$data2 = new \DateTime( self::dataUSA($data2) );
			$intervalo = $data1->diff( $data2 );
			return $intervalo->d+($intervalo->m*30)+($intervalo->y*360);
		}
		public static function  modificar_data($data, $parametro) {
			/*
				parametro do tipo modify do php ex. (string) '+1 day'
			*/
			$data1 = new \DateTime( self::dataUSA($data) );
			$data1->modify($parametro);
			return self::dataBR($data1);
		}
    }
?>