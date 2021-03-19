package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import java.util.ArrayList;

public class VariaveisNomesSql extends ClasseBase {
    public static VariaveisNomesSql uVariaveisNomesSql = null;
    public static String strdataandroid = "yyyy-MM-dd HH:mm:ss";
    public static String strdatanormal = "dd/MM/yyyy";
    public static String strdatahora = "dd/MM/yyyy HH:mm:ss";
    private static String cnome = "VariaveisNomesSql";
    public static String nomeappdb = "sis";

    public static class TSqlDB {

        public static class TSqlTabela {

            public class TSqlTabCampo {
                public Integer codtabela;
                public Integer codcampo;
                public String nome;
                public String tipo;
                public String parametros;

                public TSqlTabCampo() {
                    try {
                        this.codtabela = 0;
                        this.codtabela = 0;
                        this.nome = "";
                        this.tipo = "";
                        this.parametros = "";
                    } catch (Exception e) {
                        objs.funcoesBasicas.mostrarErro(e);
                    }
                }
            }

            public Integer codtabela;
            public String nome;
            public Boolean sobrescrever;
            public ArrayList<TSqlTabCampo> campos;

            public TSqlTabela() {
                try {
                    this.codtabela = 0;
                    this.nome = "";
                    this.campos = new ArrayList<TSqlTabCampo>();
                    this.sobrescrever = false;
                } catch (Exception e) {
                    objs.funcoesBasicas.mostrarErro(e);
                }
            }

            public void onCreate() {
                try {
                } catch (Exception e) {
                    objs.funcoesBasicas.mostrarErro(e);
                }
            }
        }

        public String nome;
        public Tipos.TCnjChaveValor<Tipos.TChaveValor> tabelas;
        public TSqlTabela sqlTabela;

        public TSqlDB() {
            try {
                this.nome = "";
                this.sqlTabela = new TSqlTabela();
                this.tabelas = new Tipos.TCnjChaveValor<Tipos.TChaveValor>();
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }


        public void onCreate() {
            try {
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }
    }

    public static class TIndicesColunas{
        public static class TTabClientes{
            /*
                Colunas conforme vem do sql do arquivo montar_sql_consulta_dados_cliente.php
                0 c.codcli,
                1 c.cgcent,
                2 c.cliente,
                3 c.fantasia,
                4 c.codusur1,
                5 c.codplpag,
                6 c.codcob,
                7 nvl( c.codfilialnf,u.codfilial) as codfilial,
                8 to_date( c.dtultalter,'dd/mm/yyyy') as dtultalter,
                9 cb.cobranca,
                10 pl.descricao,
                11 c.numregiaocli,
                12 pl.numpr,
                13 c.codrede
                14 c.bloqueio,
                15 to_char(c.dtexclusao,'yyyy-mm-dd hh24:mi:ss') as dtexclusao,
                16 c.limcred,
                17 c.motivobloq,
                18 c.motivoexclusao,
                19 to_char(c.dtultcomp,'yyyy-mm-dd hh24:mi:ss') as dtultcomp
                20 municent
                21 estent
                22 bairroent
                23 enderent
                24 numeroent
                25 telent
                26 email
                27 latitude
                28 longitude
                29 vltotal
                30 qtitens
                31 numpedrca
                32 statussinc (campo local, nao vem do sql)
                33 dtatualizacao
            */
            public static int indColCodCli = 0;
            public static int indColCNPJ = 1;
            public static int indColRazao = 2;
            public static int indColFantasia = 3;
            public static int indColCodUsur = 4;
            public static int indColCodPlPag = 5;
            public static int indColCodCob = 6;
            public static int indColCodFilial = 7;
            public static int indColDtUltAlter = 8;
            public static int indColDescCob = 9;
            public static int indColDescPlPag = 10;
            public static int indColNumRegiao = 11;
            public static int indColNumColPreco = 12;
            public static int indColCodRede = 13;
            public static int indColBloqueio = 14;
            public static int indColDtExclusao = 15;
            public static int indColLimCred = 16;
            public static int indColMotivoBloqueio = 17;
            public static int indColMotivoExclusao = 18;
            public static int indColDtUltComp = 19;
            public static int indColMunicent = 20;
            public static int indColEstent = 21;
            public static int indColBairroent = 22;
            public static int indColEnderent = 23;
            public static int indColNumeroent = 24;
            public static int indColTelent = 25;
            public static int indColEmail = 26;
            public static int indColLatitude = 27;
            public static int indColLongitude = 28;
            public static int indColVlTotal = 29;
            public static int indColQtItens = 30;
            public static int indColNumPedRca = 31;
            public static int indColStatusSinc = 32;
            public static int indColDtAtualizacao = 33;
            public static int indColCnjPoliticas = 34; //criado e usado no app
        }

        public static class TTabProdutos{
            /*
                Colunas conforme vem do sql do arquivo montar_sql_consulta_lista_produtos_completa_simples.php
                    0 e.filial || '-' || r.numregiao || '-' || e.codprod as filialregprod,
                    1 e.filial,
                    2 r.numregiao,
                    3 tr.tipo,
                    3 e.codprod,
                    4 e.descricao,
                    5 e.un,
                    6 e.qtde jumbo,
                    7 e.reservado,
                    8 e.pendente,
                    9 e.transmitido,
                    10 e.disponivel jumbo,
                    11 e.previsao disp jumbo,
                    12 e.disponivel aurora,
                    13 e.disponivel total,
                    14 e.previsao disp total,
                    15 e.aurora,
                    16 round(pr.pvenda1,2) as pvenda1,
                    17 round(pr.pvenda2,2) as pvenda2,
                    18 round(pr.pvenda3,2) as pvenda3,
                    19 round(pr.pvenda4,2) as pvenda4,
                    20 round(pr.pvenda5,2) as pvenda5,
                    21 round(pr.pvenda6,2) as pvenda6,
                    22 round(pr.perdescmax,2) as perdesc,
                    23 p.multiplo,
                    24 p.qtunitcx
                    25 p.dtultvenda
                    26 p.vltotal
                    27 p.numpedrca
                    28 p.pesoliq
                    29 statussinc (campo local, nao vem do sql)
            */
            public static int indColFilialRegProd = 0;
            public static int indColCodFilial = 1;
            public static int indColNumRegiao = 2;
            public static int indColTipoRegiao = 3;
            public static int indColCodProd = 4;
            public static int indColDescricao = 5;
            public static int indColUn = 6;
            public static int indColQtJumbo = 7;
            public static int indColReservado= 8;
            public static int indColPendente = 9;
            public static int indColTransmitido = 10;
            public static int indColDispJumbo = 11;
            public static int indColPrevDispJumbo = 12;
            public static int indColDispAurora = 13;
            public static int indColDispTotal = 14;
            public static int indColPrevDispTotal = 15;
            public static int indColAurora = 16;
            public static int indColPVenda1 = 17;
            public static int indColPVenda2 = 18;
            public static int indColPVenda3 = 19;
            public static int indColPVenda4 = 20;
            public static int indColPVenda5 = 21;
            public static int indColPVenda6 = 22;
            public static int indColPercDescMax = 23;
            public static int indColMultiplo = 24;
            public static int indColQtUnitCx = 25;
            public static int indColDtUltVenda = 26;
            public static int indColVlTotal = 27;
            public static int indColNumPedRca = 28;
            public static int indColPesoLiq = 29;
            public static int indColPesoVariavel = 30;
            public static int indColStatusSinc = 31;
            public static int indColDtConsulta = 32;
            public static int indColPercDesc = 33; //criado e usado nas telas de pedido
            public static int indColQt = 34; //criado e usado nas telas de pedido
            public static int indColPVenda = 35; //criado e usado nas telas de pedido
            public static int indColPVendaTotal = 36; //criado e usado nas telas de pedido
            public static int indColDtInclusaoItemPed = 37; //criado e usado nas telas de pedido
            public static int indColDtInicioTransacao = 37; //eh o mesmo campo anterior
            public static int indColNumPedApp = 38; //criado e usado nas telas de pedido
        }

        public static class TTabPedidos{
            /*
                Colunas conforme vem do sql local
                    0 numpedapp,
                    1 codcli,
                    2 codcob,
                    3 codplpag,
                    4 status,
                    5 numpederp
                    6 statussinc (campo local, nao vem do sql)
            */
            public static int indColNumPedApp = 0;
            public static int indColCodCli = 1;
            public static int indColCodCob = 2;
            public static int indColCodPlPag = 3;
            public static int indColStatus = 4;
            public static int indColNumPedErp = 5;
            public static int indColStatusSinc = 6;
        }

        public static class TTabPoliticasDesconto{
            /*
                Colunas conforme vem do sql remoto e local
                     0 d.coddesconto,
                     1 d.codprod,
                     2 d.percdesc,
                     3 to_char(d.dtinicio,'".$GLOBALS["sbu"]["sql"]["strdataandroid"]."') as dtinicio,
                     4 to_char(d.dtfim,'".$GLOBALS["sbu"]["sql"]["strdataandroid"]."') as dtfim,
                     5 d.qtini,
                     6 d.qtfim,
                     7 d.aplicadesconto,
                     8 d.alteraptabela,
                     9 d.prioritaria,
                    10 d.prioritariageral,
                    11 d.codfilial,
                    12 d.codcli,
                    13 d.codrede
                    14 statussinc (campo local, nao vem do sql)
                    */
            public static int indColCodDesconto = 0;
            public static int indColCodProd = 1;
            public static int indColPercDesc = 2;
            public static int indColDtInicio = 3;
            public static int indColDtFim = 4;
            public static int indColQtIni = 5;
            public static int indColQtFim = 6;
            public static int indColAplicarDesconto = 7;
            public static int indColAlterarPTabela = 8;
            public static int indColPrioritaria = 9;
            public static int indColPrioritariaGeral = 10;
            public static int indColCodFilial = 11;
            public static int indColCodCli = 12;
            public static int indColCodRede = 13;
            public static int indColCodUsur = 14;
            public static int indColStatusSinc = 15;
        }

        public static class TTabPrecoFixo {
            /*
                Colunas conforme vem do sql remoto e local
                     0 pf.codprecoprom,
                     1 pf.codprod,
                     2 to_char(pf.dtiniciovigencia,'".$GLOBALS["sbu"]["sql"]["strdataandroid"]."') as dtiniciovigencia,
                     3 to_char(pf.dtfimvigencia,'".$GLOBALS["sbu"]["sql"]["strdataandroid"]."') as dtfimvigencia,
                     4 pf.precofixo,
                     5 pf.numregiao,
                     6 pf.codcli,
                     7 pf.codfilial,
                     8 pf.codrede
                     9 statussinc (campo local, nao vem do sql)
                    */
            public static int indColCodPrecoProm = 0;
            public static int indColCodProd = 1;
            public static int indColDtIncioVigencia = 2;
            public static int indColDtFimVigencia = 3;
            public static int indColPrecoFixo = 4;
            public static int indColNumRegiao = 5;
            public static int indColCodCli = 6;
            public static int indColCodFilial = 7;
            public static int indColCodRede = 8;
            public static int indColStatusSinc = 9;
        }

        public static TTabClientes tabClientes;
        public static TTabProdutos tabProdutos;
        public static TTabPedidos tabPedidos;
        public static TTabPoliticasDesconto tabPoliticasDesconto;
        public static TTabPrecoFixo tabPrecoFixo;

        public TIndicesColunas(){
            this.tabClientes = new TTabClientes();
            this.tabProdutos = new TTabProdutos();
            this.tabPoliticasDesconto = new TTabPoliticasDesconto();
            this.tabPrecoFixo = new TTabPrecoFixo();

        }
    }

    public static TSqlDB sisdb;
    public static TIndicesColunas indicesColunas;

    public VariaveisNomesSql(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "VariaveisNomesSql";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            this.sisdb = new TSqlDB();
            this.indicesColunas = new TIndicesColunas();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public VariaveisNomesSql(Context pContexto, String pNomeAppDB) {
        super(pContexto,pNomeAppDB);
        try {
            String fnome = "VariaveisNomesSql";
            contexto = pContexto;
            this.nomeappdb = pNomeAppDB;
            objs = ObjetosBasicos.getInstancia(contexto,pNomeAppDB);
            this.nomeappdb = pNomeAppDB;
            objs.funcoesBasicas.logi(cnome,fnome);
            this.sisdb = new TSqlDB();
            this.indicesColunas = new TIndicesColunas();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized VariaveisNomesSql getInstancia(){
        try {
            return getInstancia(contexto,nomeappdb);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized VariaveisNomesSql getInstancia(Context vContexto, String pNomeAppDB){
        try {
            nomeappdb = pNomeAppDB;
            if (uVariaveisNomesSql == null)  {
                uVariaveisNomesSql = new VariaveisNomesSql(vContexto, pNomeAppDB);
                uVariaveisNomesSql.nomeappdb = pNomeAppDB;
            }

            return uVariaveisNomesSql;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

}