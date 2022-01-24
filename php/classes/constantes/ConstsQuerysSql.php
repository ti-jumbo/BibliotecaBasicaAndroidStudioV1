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
    class ConstsQuerysSql extends ClasseBase {
		public const querys = [
            "pesquisa_filial"=>"
                select
                    pcfilial.codigo,
                    pcfilial.cidade
                from
                    jumbo.pcfilial
                where
                    __CONDICIONANTES__
                order by 
                    pcfilial.codigo
            ",
            "pesquisa_cliente"=>"
                select
                    pcclient.codcli,
                    pcclient.cliente
                from
                    jumbo.pcclient
                where
                    __CONDICIONANTES__
                order by 
                    pcclient.codcli
            ",
            "pesquisa_cidade"=>"
                select
                    pccidade.nomecidade,
                    pccidade.uf
                from
                    jumbo.pccidade
                where
                    __CONDICIONANTES__
                order by 
                    pccidade.nomecidade
            ",
            "pesquisa_estado"=>"
                select
                    pcestado.codigo,
                    pcestado.estado
                from
                    jumbo.pcestado
                where
                    __CONDICIONANTES__
                order by 
                    pcestado.codigo
            ",
            "pesquisa_rca"=>"
                select
                    pcusuari.codusur,
                    pcusuari.nome
                from
                    jumbo.pcusuari
                where
                    __CONDICIONANTES__
                order by 
                    pcusuari.codusur
            ",
            "pesquisa_gerente"=>"
                select
                    pcgerente.codgerente,
                    pcgerente.nomegerente
                from
                    jumbo.pcgerente
                where
                    __CONDICIONANTES__
                order by 
                    pcgerente.codgerente
            ",
            "pesquisa_supervisor"=>"
                select
                    pcsuperv.codsupervisor,
                    pcsuperv.nome
                from
                    jumbo.pcsuperv
                where
                    __CONDICIONANTES__
                order by 
                    pcsuperv.codsupervisor
            ",
            "pesquisa_regiao"=>"
                select
                    pcregiao.numregiao,
                    pcregiao.regiao
                from
                    jumbo.pcregiao
                where
                    __CONDICIONANTES__
                order by 
                    pcregiao.numregiao
            ",
            "pesquisa_praca"=>"
                select
                    pcpraca.codpraca,
                    pcpraca.praca
                from
                    jumbo.pcpraca
                where
                    __CONDICIONANTES__
                order by 
                    pcpraca.codpraca
            ",
            "pesquisa_rota"=>"
                select
                    pcrotaexp.codrota,
                    pcrotaexp.descricao
                from
                    jumbo.pcrotaexp
                where
                    __CONDICIONANTES__
                order by 
                    pcrotaexp.codrota
            "
        ];
	}
?>