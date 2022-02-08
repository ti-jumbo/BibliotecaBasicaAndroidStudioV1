<?php
    namespace SJD\php\classes\funcoes;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

    use SJD\php\classes\{
        ClasseBase
    };
    use SJD\php\classes\constantes\Constantes;
    

    /**
     * Classe com funcoes genericas utilizadas em relatorios.
     * 
     * @author Antonio ALENCAR Velozo
     * @created 05/02/2021
     */

     /*
        considerar_vals_de:
        [0] => 0 - vendas normais
        [1] => 1 - devolucoes normais
        [2] => 2 - devolucoes avulsas
        [3] => 3 - bonificacoes
        [4] => 10 - todos
    */

    /*
        mostrar_vals_de
        [0] => 0 - qttotal
        [1] => 3 - pesototal
        [2] => 5 - valortotal
    */
    class FuncoesRelatorio extends ClasseBase {	

        /**
         * separa o array de datas do objeto comhttp padroa em periodos de 2 datas
         * @created 05/02/2022
         * @param object &$comhttp - o objeto comhttp padrao
         * @return void
         */
        public static function prepararPeriodos(object &$comhttp) : void{
			$datas = $comhttp->requisicao->requisitar->qual->condicionantes["datas"];
			$datas = explode(",",$datas);
			$periodo = [];
			$periodos = [];			
			foreach($datas as $chave => $data) {
				$periodo[] = $data;
				if (($chave % 2) > 0) {
					$periodos[] = $periodo;
					$periodo = [];
				}
			}
			$comhttp->requisicao->requisitar->qual->condicionantes["periodos"] = $periodos;
		}
        
		public static function formarCampoPeriodos(object &$comhttp, string $campo_data) : string {
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["periodos"])) {
				self::prepararPeriodos($comhttp);
			}
			$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["periodos"];
			$valores_periodos = [];
			$campos_periodos = [];
			$valor_periodo = null;
			foreach($periodos as $periodo){
				$valor_periodo = "De ". $periodo[0] . " a " . $periodo[1];
				$valores_periodos[] = $valor_periodo;
				$campos_periodos[] = "when $campo_data between to_date('".$periodo[0]."','dd/mm/yyyy') and to_date('".$periodo[1]."','dd/mm/yyyy') then '".$valor_periodo."'";
			}
			$campo_periodo = "case " . implode(" ",$campos_periodos) . " else 'indefinido' end";
			return $campo_periodo;
		}
        
		public static function formarCamposPivotForPeriodos(object &$comhttp) : string {
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["periodos"])) {
				self::prepararPeriodos($comhttp);
			}
			$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["periodos"];
			$campo_pivot_for = "";
			$campos_pivot_for = [];
			foreach($periodos as $periodo){
				$campos_pivot_for[] = "De ".$periodo[0]." a " .$periodo[1];
			}
			$campo_pivot_for = "'" . implode("','",$campos_pivot_for) . "'";
			return $campo_pivot_for;
		}
        
		public static function considerarDevolucoes(object &$comhttp) : bool{			
			$considerar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"];
			$campo = "";
			if (in_array(1,$considerar_vals_de) || in_array(2,$considerar_vals_de)) { 
				return true;
			}
			return false;
		}

		public static function formarCampoPesoSaida(&$comhttp){			
			$campo = "(".self::formarCampoQtSaida($comhttp) . ")";
			$campo .= " * coalesce(ms.pesoliqun,p.pesoliqun,1)";
			return $campo;
		}

		public static function formarCampoValorSaida(&$comhttp){
			$campo = "(".self::formarCampoQtSaida($comhttp).")";
			$campo .= " * nvl(ms.vlun,0)";
			return $campo;
		}
        
		public static function formarCampoQtEntDev(&$comhttp){			
			$considerar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"];
			$campo = "";
			$campo = "(case when nvl(me.qtdevolvida,0) > 0 then me.qtdevolvida else nvl(me.qtent,0) end) * -1";
			return $campo;
		}

		public static function formarCampoPesoEntDev(&$comhttp){			
			$campo = "(".self::formarCampoQtEntDev($comhttp) . ")";
			$campo .= " * coalesce(me.pesoliqun,p.pesoliqun,1)";
			return $campo;
		}

		public static function formarCampoValorEntDev(&$comhttp){
			$campo = "(".self::formarCampoQtEntDev($comhttp).")";
			$campo .= " * nvl(me.vlun,0)";
			return $campo;
		}

		public static function verificarVerQt(&$comhttp){			
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];				
			if (in_array(0,$mostrar_vals_de)) {
				return true;
			}
			return false;
		}

		public static function verificarVerPeso(&$comhttp){
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];				
			if (in_array(3,$mostrar_vals_de)) {
				return true;
			}
			return false;
		}

		public static function verificarVerValor(&$comhttp){
			$mostrar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["mostrar_vals_de"];				
			if (in_array(5,$mostrar_vals_de)) {
				return true;
			}
			return false;
		}

		public static function verificarTemCondicionanteVisao(&$comhttp,$visao){
			$condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];				
			if (isset($condicionantes) && $condicionantes !== null) {
				if (gettype($condicionantes) !== "array") {
					$condicionantes = FuncoesProcessoSql::prepararCondicionantesProcessoSql($condicionantes);
					$condicionantes = self::separar_condicionantes_por_visao_e_operacao($condicionantes);
					$comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"] = $condicionantes;
				}
				if (count($condicionantes) > 0) {
					if (!FuncoesString::strTemValor($visao)) {
						return true;
					} elseif (isset($condicionantes[$visao]) && $condicionantes[$visao] != null && count($condicionantes[$visao]) > 0) {
						return true;
					}
				} 
			}
			return false;
		}

		public static function formarCondicionanteVisao(&$comhttp,$visao,$campo_condicionante){
			$retorno = "";
			if (self::verificarTemCondicionanteVisao($comhttp,$visao)) {
				$condicionantes = $comhttp->requisicao->requisitar->qual->condicionantes["condicionantes"];	
				$condicionante_visao = $condicionantes[$visao];
				$condics = [];
				foreach($condicionante_visao as $op=>$valores){
					switch(trim(strtolower($op))) {
						case "=":							
							$condics[] = $campo_condicionante . " in (" . implode(",",$valores) . ")";
							break;
						case "!=":
						case "<>":							
							$condics[] = $campo_condicionante . " not in (" . implode(",",$valores) . ")";
							break;
						default:
							print_r($condicionante_visao);
							echo "operacao nao esperada";
							exit();
							break;
					}
				}
				$retorno = "(" . implode(" and ",$condics) . ")";
			}
			return $retorno;
		}

		public static function formarCondicionanteCodOperSaida(&$comhttp,$campo_condicionante){
			$considerar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"];
			$codopers = [];
			
			/*considerar devolucoes*/
			if (in_array(1,$considerar_vals_de) || in_array(2,$considerar_vals_de)) {
				$codopers[] = 11;
				//$codopers[] = 13;
			} 

			/*considerar vendas normais*/
			if (in_array(0,$considerar_vals_de)) {
				$codopers[] = 11;
			}

			/*considerar bonificacoes*/
			if (in_array(3,$considerar_vals_de)) {
				$codopers[] = 13;
			}

			$codopers = array_unique($codopers);
			$retorno = $campo_condicionante . " in (" . implode(",",$codopers) . ")";
			return $retorno;
		}

		public static function formarCondicionanteCodOperEnt(&$comhttp,$campo_condicionante){
			$considerar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"];
			$codopers = [];
			$codopers[] = 4;
			$retorno = $campo_condicionante . " in (" . implode(",",$codopers) . ")";
			return $retorno;
        }

        

        public static function formarCondicionantePeriodos(object &$comhttp,string $campo_condicionante_periodo) : string{
			if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["periodos"])) {
				self::prepararPeriodos($comhttp);
			}
			$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["periodos"];
			$condicionante_periodo = "";
			$condicionantes_periodos = [];
			foreach($periodos as $periodo){
				$condicionantes_periodos[] = "$campo_condicionante_periodo between to_date('".$periodo[0]."','dd/mm/yyyy') and to_date('".$periodo[1]."','dd/mm/yyyy')";
			}
			$condicionante_periodo = "(" . implode(" or ",$condicionantes_periodos) . ")";
			return $condicionante_periodo;
		}
       
        public static function formarCampoQtSaida(object &$comhttp) : string{			
			$considerar_vals_de = $comhttp->requisicao->requisitar->qual->condicionantes["considerar_vals_de"];
			$campo = "";
			if (in_array(0,$considerar_vals_de) || in_array(3,$considerar_vals_de)) { //codoper eh colocado deve ser colocado nas condicionantes
				$campo .= "nvl(ms.qtsaida,0)";
				if (in_array(1,$considerar_vals_de) || in_array(2,$considerar_vals_de)) {
					$campo .= " - nvl(ms.qtdevolvida,0)";
				}	
			} elseif (in_array(1,$considerar_vals_de) || in_array(2,$considerar_vals_de)) {
				$campo .= "nvl(ms.qtdevolvida,0) * -1";
			}
			return $campo;
		}

        public static function separar_condicionantes_por_visao_e_operacao($condicionantes){
			$condicionantes_visao = [];
			foreach($condicionantes as $chave_condicionante => &$condicionante) {
				if (gettype($condicionante) === "array") {
					foreach($condicionante as $item_condicionante) {
						if (gettype($condicionante) === "array") {
							$op = strtolower(trim($item_condicionante["op"]));
							$visao_condicionante = strtolower(trim($item_condicionante["processo"]));
							$valor_condicionante = strtolower(trim($item_condicionante["valor"]));
							if (!isset($condicionantes_visao[$visao_condicionante])) {
								$condicionantes_visao[$visao_condicionante] = [];
							}
							if (!isset($condicionantes_visao[$visao_condicionante][$op])) {
								$condicionantes_visao[$visao_condicionante][$op] = [];
							}
							$condicionantes_visao[$visao_condicionante][$op][] = $valor_condicionante;
						}
					}
				}
			}
			return $condicionantes_visao;
		}

		private static function montarArrayTitulosElemento(array &$array_tit, array &$elemento, array $processos) : bool {
			$retorno = false;
			/*quando encontrar o primeiro elemento que eh do tipo field (400) e que nao seja '*' significa
			que encontrou o inicio dos campos*/
			if ($elemento["codtipoobjetosql"] == 400 && $elemento["textosql"] != "*") {
				$retorno = true;

			} else {
				if (isset($elemento["sub"]) && $elemento["sub"] != null && gettype($elemento["sub"]) == "array" && count($elemento["sub"]) > 0) {
					foreach($elemento["sub"] as $chavesub => &$subelemento){
						$encontrou = self::montarArrayTitulosElemento($array_tit, $subelemento, $processos);
						if ($encontrou) {
							foreach($processos as $processo) {
								if ($processo["cod"] == $subelemento["codprocesso"]) {
									if (!isset($array_tit[$processo["visao"]])) {
										$array_tit[$processo["visao"]] = [];
									}
									$array_tit[$processo["visao"]][$subelemento["alias"]] = $subelemento["alias"];
								}
							}
						}
					}
				}
			}
			return $retorno;
		}

		public static function montarArrayTitulos(object &$comhttp, &$processo_unificado, array $processos) : array {
			$array_tit = [];
			foreach($processo_unificado["elementos"] as $chave => &$elemento) {
				if (isset($elemento) && $elemento !== null) {
					$encontrou = self::montarArrayTitulosElemento($array_tit,$elemento,$processos);				
					if ($encontrou) break;
				}
			}
			if(isset($array_tit["valores"])) {
				if (!isset($comhttp->requisicao->requisitar->qual->condicionantes["periodos"])) {
					self::prepararPeriodos($comhttp);
				}
				$periodos = $comhttp->requisicao->requisitar->qual->condicionantes["periodos"];
				$arr_tit_periodos = [];
				foreach($periodos as $periodo) {
					$texto_periodo = "De " . $periodo[0] . " a " . $periodo[1];
					$arr_tit_periodos[$texto_periodo] = [];
					foreach($array_tit["valores"] as $chave => $valor) {						
						if (strcasecmp($chave,"periodos") != 0) {
							$arr_tit_periodos[$texto_periodo][$valor] = $valor;
						}
					}
				}
			}
			unset($array_tit["valores"]);
			$array_tit = array_merge($array_tit, $arr_tit_periodos);
			//print_r($array_tit);exit();
			return $array_tit;
		}

    }
?>