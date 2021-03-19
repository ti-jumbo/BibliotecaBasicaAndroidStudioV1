package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.database.Cursor;
import android.text.TextUtils;
import android.view.View;
import android.widget.Toast;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.requisicoes.TComHttp;
import com.bibliotecas.bibliotecabasicav1.requisicoes.TComHttpSimples;
import com.bibliotecas.bibliotecabasicav1.sql.TSql;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import org.json.JSONArray;
import org.json.JSONObject;

import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Arrays;

public class FuncoesSisBib extends FuncoesBase {
    private static String cnome = "FuncoesSis";
    private static FuncoesSisBib uFuncoesSisBib = null;
    private static Method metodoLogSincronizar = null;
    public FuncoesSisBib(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesSis";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            this.localizarMetodoLogSincronizar();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesSisBib getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesSisBib getInstancia(Context pContexto) {
        try {
            if (uFuncoesSisBib == null) {
                uFuncoesSisBib = new FuncoesSisBib(pContexto);
            }
            return uFuncoesSisBib;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void localizarMetodoLogSincronizar(){
        try {
            if (this.metodoLogSincronizar == null) {
                metodoLogSincronizar = this.getClass().getMethod("logSincronizar", String.class);
            }
        } catch (Exception e) {
            e.printStackTrace(); //nao deve mostrar erro
        }
    }

    public static void setarVisoesDisponiveis(Tipos.TDadosUsuario pDadosUsuario) {
        try {
            if (pDadosUsuario.podeVer.trim().toLowerCase().equals("tudo")) {
                objs.variaveis.visoesDisponiveis = new String[5];
                objs.variaveis.visoesDisponiveis[0] = "Geral";
                objs.variaveis.visoesDisponiveis[1] = "Filial";
                objs.variaveis.visoesDisponiveis[2] = "Supervisor";
                objs.variaveis.visoesDisponiveis[3] = "Rca";
                objs.variaveis.visoesDisponiveis[4] = "Produto";
            } else {

                switch (pDadosUsuario.tipoUsuario.trim().toLowerCase()) {
                    case "interno":
                        objs.variaveis.visoesDisponiveis = new String[4];
                        objs.variaveis.visoesDisponiveis[0] = "Geral";
                        objs.variaveis.visoesDisponiveis[1] = "Supervisor";
                        objs.variaveis.visoesDisponiveis[2] = "Rca";
                        objs.variaveis.visoesDisponiveis[3] = "Produto";
                        break;
                    case "supervisor":
                        objs.variaveis.visoesDisponiveis = new String[3];
                        objs.variaveis.visoesDisponiveis[0] = "Geral";
                        objs.variaveis.visoesDisponiveis[1] = "Rca";
                        objs.variaveis.visoesDisponiveis[2] = "Produto";
                        break;
                    case "rca":
                    default:
                        objs.variaveis.visoesDisponiveis = new String[2];
                        objs.variaveis.visoesDisponiveis[0] = "Geral";
                        objs.variaveis.visoesDisponiveis[1] = "Produto";
                        break;
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public Cursor obter_processo(String p_nomeprocesso) {
        try {
            String fnome = "obter_processo";
            objs.funcoesBasicas.logi(cnome,fnome);
            Cursor retorno = null;
            retorno = objs.sql.executarSql(
                    "processos",
                    new String[]{"*"},
                    "lower(trim(nomeprocesso))=?",
                    new String[]{p_nomeprocesso.toLowerCase().trim()});
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public String obter_comando_sql(String p_nomeprocesso) {
        try {
            String fnome = "obter_comando_sql";
            objs.funcoesBasicas.logi(cnome,fnome);
            String retorno = null;
            ArrayList<ArrayList<String>> processo = objs.variaveis.getSql(contexto).dados_para_array(obter_processo(p_nomeprocesso));
            if (processo != null && processo.size() > 0) {
                retorno = obter_comando_sql(Integer.parseInt(processo.get(0).get(0)));
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public String obter_comando_sql(Integer p_codprocesso) {
        try {
            String fnome = "obter_comando_sql";
            objs.funcoesBasicas.logi(cnome,fnome);
            Cursor dados = null;
            String retorno = null;
            dados = objs.sql.executarSql(
                    "comandossql",
                    new String[]{"comandosql"},
                    "codprocesso=?",
                    new String[]{String.valueOf(p_codprocesso)});
            if (dados != null && dados.moveToFirst()) {
                retorno = dados.getString(dados.getColumnIndex("comandosql"));
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Cursor obter_usuarios_locais() {
        try {
            String fnome = "obter_usuarios_locais";
            objs.funcoesBasicas.logi(cnome,fnome);
            Cursor retorno = null;
            String comandoSql = obter_comando_sql(objs.variaveisEstaticas.OBTER_USUARIOS_LOCAIS);
            if (comandoSql != null && comandoSql.length() > 0) {
                objs.funcoesBasicas.log(fnome,comandoSql);
                retorno = objs.sql.executarSql(comandoSql);
            } else {
                throw new Exception("comando sql do processo " + objs.variaveisEstaticas.OBTER_USUARIOS_LOCAIS + " nao localizado");
            }
            objs.funcoesBasicas.logf(cnome,fnome);

            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public String logar(TComHttp comhttp, int idNavDestino) {
        try {
            String fnome = "logar";
            objs.funcoesBasicas.logi(cnome,fnome);
            String retorno = "";
            Cursor dados;
            objs.funcoesBasicas.log("CODUSUR " + comhttp.req.getJSONObject("requisicao").getJSONObject("requisitar").getJSONObject("qual").getString("codusur"));
            dados = objs.sql.executarSql(
                    "usuarios",
                    new String[]{"*"},
                    "codusur = ?",
                    new String[]{(String) comhttp.req.getJSONObject("requisicao").getJSONObject("requisitar").getJSONObject("qual").getString("codusur")}
            );

            if (dados != null && dados.moveToFirst()) {
                objs.funcoesBasicas.log("login dados encontrados");
                Tipos.TCnjChaveValor condic;
                condic = strlist_para_chavevalor(comhttp.req.getJSONObject("requisicao").getJSONObject("requisitar").getJSONObject("qual").getString("condicionantes"), "=");
                Tipos.TChaveValor el = condic.procurar("senha");
                if (el != null) {
                    objs.funcoesBasicas.log("SENHA: " + el.valor);
                    objs.funcoesBasicas.log("comparando " + el.valor.toString().trim().toLowerCase() + " com " + dados.getString(2).trim().toLowerCase());
                    if (el.valor.toString().trim().toLowerCase().equals(dados.getString(2).trim().toLowerCase())) {
                        objs.funcoesBasicas.log("igual");
                        objs.variaveis.setLogado(true);
                        objs.variaveis.setCodusur(comhttp.req.getJSONObject("requisicao").getJSONObject("requisitar").getJSONObject("qual").getString("codusur"));
                        objs.variaveis.dadosUsuario.nome = dados.getString(dados.getColumnIndex("nome"));
                        objs.variaveis.dadosUsuario.tipoUsuario = dados.getString(dados.getColumnIndex("tipousuario"));
                        objs.variaveis.dadosUsuario.podeVer = dados.getString(dados.getColumnIndex("podever"));
                        objs.variaveis.dadosUsuario.codNivelAcesso = Integer.parseInt(dados.getString(dados.getColumnIndex("codnivelacesso")));
                        objs.variaveis.dadosUsuario.codsUsuariosAcessiveis = new ArrayList(Arrays.asList(dados.getString(dados.getColumnIndex("codsusuariosacessiveis")).split(",")));
                        FuncoesSisBib.getInstancia(contexto).setarVisoesDisponiveis(objs.variaveis.dadosUsuario);
                        objs.variaveisBasicas.getFragmentoAtual().desbloquearDrawer();
                        objs.variaveisBasicas.getActivityPrincipal().navegar(idNavDestino);
                    } else {
                        objs.funcoesBasicas.mostrarmsg("Nao Logado: senha incorreta");
                        objs.funcoesTela.esconder_carregando();
                    }
                } else {
                    objs.funcoesBasicas.mostrarmsg("Nao Logado: dados locais nao encontrados");
                    objs.funcoesTela.esconder_carregando();
                }

            } else {
                //objs.funcoesBasicas.log("dados nao encontrados");
                objs.funcoesBasicas.mostrarmsg("Nao Logado: dados locais nao encontrados\nSe é a primeira vez que usa o sistema, deve pelo menos usar uma vez online ou sincronizar para obter dados do servidor!", Toast.LENGTH_LONG);
                objs.funcoesTela.esconder_carregando();
            }
            objs.funcoesDados.fecharCursor(dados);
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }



    public Tipos.TCnjChaveValor strlist_para_chavevalor(ArrayList<String> str, String separador) {
        try {
            String fnome = "strlist_para_chavevalor";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor retorno = new Tipos.TCnjChaveValor();
            ArrayList<String> retornotemp = str;
            for (String condic : retornotemp) {
                retorno.add(new Tipos.TChaveValor(
                        condic.substring(0, condic.indexOf(separador)),
                        condic.substring(condic.indexOf(separador) + 1)
                ));
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Tipos.TCnjChaveValor strlist_para_chavevalor(String str, String separador) {
        try {
            String fnome = "strlist_para_chavevalor";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor retorno = new Tipos.TCnjChaveValor();
            String retornotemp = str;
            objs.funcoesBasicas.log(str);
            if (str.length() > 0) {
                if (str.contains(separador)) {
                    retorno.add(new Tipos.TChaveValor(
                            str.substring(0, str.indexOf(separador)),
                            str.substring(str.indexOf(separador) + 1)
                    ));
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void sair(boolean deslogar, Integer idNavLogin) {
        try {
            String fnome = "sair";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (deslogar == true) {
                objs.variaveis.setLogado(false);
                objs.sql.inserirOuAtualizar(
                        "usuarios",
                        "codusur",
                        objs.variaveis.getCodusur(),
                        new ArrayList<String>(Arrays.asList("logado")),
                        new ArrayList<String>(Arrays.asList("0")));
            }
            if (idNavLogin != null) {
                objs.variaveisBasicas.getActivityPrincipal().navegar(idNavLogin);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    /*public static ArrayList<ArrayList> dados_sql_para_array(TComHttp comhttp) {
        try {
            String fnome = "dados_sql_para_array";
            objs.funcoesBasicas.logi(cnome,fnome);

            Map objmap = null;
            ArrayList<ArrayList> retorno = null;
            try {
                //objmap = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(comhttp.req.retorno.dados_retornados.dados), Map.class);
                comhttp.req.retorno.dados_retornados.dados.
                Object tabela = objmap.get("tabela");
                Map objmaptabela = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(tabela), Map.class);
                retorno = (ArrayList<ArrayList>) objmaptabela.get("dados");
            } catch (Exception e) {
                e.printStackTrace();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }*/

    public static Tipos.TCnjChaveValor condicionantes_estruturadas(String condicionantes_string) {
        try {
            String fnome = "condicionantes_estruturadas";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("estruturando condicionantes: " + condicionantes_string);
            Tipos.TCnjChaveValor retorno = new Tipos.TCnjChaveValor();
            if (condicionantes_string != null) {
                condicionantes_string = condicionantes_string.trim();
                if (condicionantes_string.indexOf("condicionantes=") == 0) {
                    condicionantes_string = condicionantes_string.substring(15);
                }
                objs.funcoesBasicas.log("condicionantes> " + condicionantes_string);
                String[] lista_condicionantes = condicionantes_string.split(objs.variaveis.sepn1);
                for (String condicicionante : lista_condicionantes) {
                    String[] itens_condicionante = condicicionante.split(objs.variaveis.sepn2);
                    for (String item_condicionante : itens_condicionante) {
                        String[] partes_condicionante = item_condicionante.split("=");
                        Tipos.TChaveValor novo = retorno.procurar(partes_condicionante[0]);
                        if (novo == null) {
                            objs.funcoesBasicas.log("Gerando condicionante para o item: " + partes_condicionante[0]);
                            ArrayList<String> subitens = new ArrayList<String>();
                            subitens.add(item_condicionante);
                            novo = new Tipos.TChaveValor(partes_condicionante[0], subitens);
                            retorno.add(novo);
                        } else {
                            objs.funcoesBasicas.log("adicionando condicionante para o item: " + partes_condicionante[0]);
                            ((ArrayList<String>) novo.valor).add(item_condicionante);
                        }
                    }
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String condicionantes_string(Tipos.TCnjChaveValor<Tipos.TChaveValor> condicionantes_estruturadas) {
        try {
            String fnome = "condicionantes_string";
            objs.funcoesBasicas.logi(cnome,fnome);
            String retorno = null;
            if (condicionantes_estruturadas != null) {
                ArrayList<String> lista_condicionantes = new ArrayList<String>();
                for (Tipos.TChaveValor condicionante : condicionantes_estruturadas) {
                    lista_condicionantes.add(TextUtils.join(objs.variaveis.sepn2, (ArrayList<String>) condicionante.valor));
                }
                retorno = TextUtils.join(objs.variaveis.sepn1, lista_condicionantes);
                if (retorno.length() > 0) {
                    retorno = "condicionantes=" + retorno;
                }
            }
            objs.funcoesBasicas.log("condicionantes> " + retorno);
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void atualizar_dados_locais(String tabela, String campoPrimaryKey, String valorPrimaryKey, ArrayList<String> campos, ArrayList<String> valores) {
        try {
            TSql s = objs.sql;
            s.checarTabelaExiste = false;
            s.inserirOuAtualizar(
                    tabela,
                    campoPrimaryKey,
                    valorPrimaryKey,
                    campos,
                    valores
            );
            s.checarTabelaExiste = true;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public String decodificar_msg_falha_requisicao(TComHttpSimples comHttpSimples) {
        try {
            int statusRequisicao = comHttpSimples.getStatusRequisicao();
            String retorno = "";
            switch (statusRequisicao) {
                case 4:
                    retorno += ": Retorno invalido : ";
                    if (comHttpSimples.mensagensErroServidor != null) {
                        if (comHttpSimples.mensagensErroServidor.size() > 0) {
                            retorno += TextUtils.join("\n",comHttpSimples.mensagensErroServidor);
                        } else {
                            retorno += comHttpSimples.response;
                        }
                    } else {
                        retorno += comHttpSimples.response;
                    }
                    break;
                case 5:
                    retorno += ": Conexão Perdida";
                    break;
                case 6:
                    retorno += ": Sem Conexão";
                    break;
                case 7:
                    retorno += ": Requisição Cancelada";
                    break;
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void requisicao_sincronizacao_falhou(TComHttpSimples comHttpSimples, String nomeTab, String nomeProcesso, int statusRequisicao) {
        try {
            String fnome = "requisicao_sincronizacao_falhou";
            objs.funcoesBasicas.logi(cnome,fnome);
            //restaurar_statussinc(nomeTab);
            String mensagem = nomeProcesso + " falhou(" + statusRequisicao+")" ;
            mensagem += decodificar_msg_falha_requisicao(comHttpSimples);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisicao_falhou(TComHttpSimples comHttpSimples) {
        try {
            String fnome = "requisicao_falhou";
            objs.funcoesBasicas.logi(cnome,fnome);
            String mensagem = "Requisicao falhou: \n";
            mensagem += decodificar_msg_falha_requisicao(comHttpSimples);
            objs.funcoesBasicas.mostrarAlert(mensagem);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public void requisicao_padrao(String codRequisicao, String condicionantes, Object objetoRetorno, Method metodoRetorno) {
        try {
            String fnome = "requisicao_padrao";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao(codRequisicao,condicionantes,objetoRetorno,metodoRetorno,null,null);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisicao_padrao(String codRequisicao, String condicionantes, Object objetoRetorno, Method metodoRetorno,  Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisicao_padrao";
            objs.funcoesBasicas.logi(cnome,fnome);

            TComHttpSimples comhttpSimples = new TComHttpSimples(contexto);
            if (objs.variaveisBasicas.getIdSessao() != null) {
                comhttpSimples.req.put("a",objs.variaveisBasicas.getIdSessao());
            } else {
                comhttpSimples.req.put("a",objs.variaveis.getCodusur());
            }
            if (comhttpSimples.req.getString("a") == null || comhttpSimples.req.getString("a").trim().replace(" ","").length() == 0) {
                comhttpSimples.req.put("a","0");
            }
            comhttpSimples.req.put("b",codRequisicao);
            comhttpSimples.setObjetoRetorno(objetoRetorno);
            comhttpSimples.setMetodoRetorno(metodoRetorno);
            comhttpSimples.setObjetoRetornoRetornoRequsicaoInvalido(objetoRetornoErro);
            comhttpSimples.setMetodoRetornoRetornoRequsicaoInvalido(metodoRetornoErro);
            comhttpSimples.req.put("c",condicionantes);
            comhttpSimples.async = true;
            comhttpSimples.execute();

            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_sincronizacao_padrao(String nomeTab, String codRequisicao, String nomeMetodoRetorno, Object objetoRetorno ){
        try {
            String fnome = "requisitar_sincronizacao_padrao";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + ":" + nomeTab + " ' iniciado");
            //this.mostrarCarregandoSincronizar();
            TComHttpSimples comhttpSimples = new TComHttpSimples(contexto);
            if (objs.variaveisBasicas.getIdSessao() != null) {
                comhttpSimples.req.put("a",objs.variaveisBasicas.getIdSessao());
            } else {
                comhttpSimples.req.put("a",objs.variaveis.getCodusur());
            }
            comhttpSimples.req.put("b",codRequisicao);
            comhttpSimples.setMetodoRetorno(objetoRetorno.getClass().getMethod(nomeMetodoRetorno, TComHttpSimples.class));
            comhttpSimples.setObjetoRetorno(objetoRetorno);
            comhttpSimples.req.put("c","");
            //marcar_registros_para_sincronizacao(nomeTab);
            comhttpSimples.async = true;
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() + 1);
            //objs.variaveisBasicas.getDadosFragSincronizar().adicionarRequisicaoAtiva(comhttpSimples);
            comhttpSimples.setTimeOut(Integer.parseInt(FuncoesSisBib.getInstancia(contexto).obter_opcao_banco("tempo_espera_requisicao_sincronizacao","300000")));
            comhttpSimples.execute();
            //logSincronizar("-processo '" + fnome + ":" + nomeTab + " ' requisitado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void receber_requisicao_padrao(TComHttpSimples comhttpSimples) {
        try {
            /*
            mudar o teim estados para ter objeto e metodo de requisicao diferente do padra, implementar e testar
                    depois retirar, deixar no padrao
            implementar os demais itens ao maximo que der para o padrao e implementar os que nao forem padrao*/
            String fnome = "receber_requisicao_padrao";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + "' iniciado");
            if (comhttpSimples != null) {
                int statusRequisicao = comhttpSimples.getStatusRequisicao();
                objs.funcoesBasicas.log("StatusRequisicao: " + statusRequisicao);
                if (statusRequisicao == 3) {
                    if (!comhttpSimples.isCancelled()) {
                        Cursor dadosLocaisSinc = (Cursor) comhttpSimples.getDados();
                        String nomeTab = null;
                        if (dadosLocaisSinc != null && dadosLocaisSinc.moveToFirst()) {
                            objs.funcoesBasicas.log("dados locais: " + TextUtils.join(",",dadosLocaisSinc.getColumnNames()) + dadosLocaisSinc.getCount());
                            int qt = dadosLocaisSinc.getColumnCount();
                            for (int i = 0 ; i < qt; i++) {
                                objs.funcoesBasicas.log(dadosLocaisSinc.getColumnName(i) + "=" + dadosLocaisSinc.getString(i));
                            }
                            nomeTab = dadosLocaisSinc.getString(dadosLocaisSinc.getColumnIndex("tabela"));
                            JSONObject dados = objs.funcoesRequisicao.obter_dados_retornados(comhttpSimples);
                            this.localizarMetodoLogSincronizar();
                            objs.sql.executar_processo_db("inserir_ou_atualizar_" + nomeTab, dados,this,metodoLogSincronizar);
                        } else {
                            //restaurar_statussinc(nomeTab);
                            //logSincronizar("-processo '" + fnome + "' com erro");
                            throw new Exception("dados esperados na comhttpsimples nao foram encontrados");
                        }
                    } else {
                        //logSincronizar("-processo '" + fnome + "' cancelado");
                    }
                } else {
                    requisicao_sincronizacao_falhou(comhttpSimples, "", fnome, statusRequisicao);
                }
                //objs.variaveisBasicas.getDadosFragSincronizar().removerRequisicaoAtiva(comhttpSimples);
            }
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() - 1);
            //logSincronizar("-processo '" + fnome + "' finalizado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_sincronizacao_padrao(Cursor dadosLocaisSinc, Tipos.TDadosSincronizacao dadosSinc){
        try {
            String fnome = "requisitar_sincronizacao_padrao";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (dadosLocaisSinc != null && dadosLocaisSinc.moveToFirst()) {
                String nomeTab = dadosLocaisSinc.getString(dadosLocaisSinc.getColumnIndex("tabela"));
                String codRequisicao = dadosLocaisSinc.getString(dadosLocaisSinc.getColumnIndex("codrequisicao"));
                //logSincronizar("-processo '" + fnome + ":" + nomeTab + " ' iniciado");
                //this.mostrarCarregandoSincronizar();
                TComHttpSimples comhttpSimples = new TComHttpSimples(contexto);
                if (objs.variaveisBasicas.getIdSessao() != null) {
                    comhttpSimples.req.put("a", objs.variaveisBasicas.getIdSessao());
                } else {
                    comhttpSimples.req.put("a", objs.variaveis.getCodusur());
                }
                comhttpSimples.req.put("b", codRequisicao);

                String strObjetoRetorno = dadosLocaisSinc.getString(dadosLocaisSinc.getColumnIndex("objetoretorno"));
                Object objetoRetorno = null;
                if (strObjetoRetorno != null && strObjetoRetorno.trim().length() > 0) {
                    objetoRetorno = objs.variaveisBasicas.procurar_objeto(strObjetoRetorno);
                } else {
                    objetoRetorno = this;
                }

                if (objetoRetorno != null) {
                    String strMetodoRetorno = dadosLocaisSinc.getString(dadosLocaisSinc.getColumnIndex("metodoretorno"));
                    Method metodoRetorno = null;
                    if (strMetodoRetorno != null && strMetodoRetorno.trim().length() > 0) {
                        metodoRetorno = objetoRetorno.getClass().getMethod(strMetodoRetorno, TComHttpSimples.class);
                    } else {
                        metodoRetorno = objetoRetorno.getClass().getMethod("receber_requisicao_padrao", TComHttpSimples.class);
                    }
                    if (metodoRetorno != null) {
                        comhttpSimples.setObjetoRetorno(objetoRetorno);
                        comhttpSimples.setMetodoRetorno(metodoRetorno);
                        comhttpSimples.req.put("c", "");
                        //marcar_registros_para_sincronizacao(nomeTab);
                        comhttpSimples.async = true;
                        comhttpSimples.setDados(dadosLocaisSinc);
                        //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() + 1);
                        //objs.variaveisBasicas.getDadosFragSincronizar().adicionarRequisicaoAtiva(comhttpSimples);
                        comhttpSimples.setTimeOut(Integer.parseInt(FuncoesSisBib.getInstancia(contexto).obter_opcao_banco("tempo_espera_requisicao_sincronizacao", "300000")));
                        comhttpSimples.execute();
                    } else {
                        throw new Exception("Metodo retorno nao encontrado: " + strMetodoRetorno);
                    }
                } else {
                    throw new Exception("Objeto retorno nao encontrado: " + strObjetoRetorno);
                }
                //logSincronizar("-processo '" + fnome + ":" + nomeTab + " ' requisitado");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }



    public void receber_lista_tabelasdb(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "receber_lista_tabelasdb";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + "' iniciado");
            if (comhttpSimples != null) {
                String nomeTab = "tabeladb";
                int statusRequisicao = comhttpSimples.getStatusRequisicao();
                objs.funcoesBasicas.log("StatusRequisicao: " + statusRequisicao);
                if (statusRequisicao == 3) {
                    if (!comhttpSimples.isCancelled()) {
                        if (!comhttpSimples.isCancelled()) {
                            JSONArray dados = comhttpSimples.req.getJSONObject("r").getJSONObject("dados").getJSONObject("tabela").getJSONArray("dados");
                            if (dados != null) {
                                int qt = dados.length();
                                if (qt > 0) {
                                    String codtabeladb = null;
                                    objs.funcoesBasicas.log("qtd tabelas recebidas: " + String.valueOf(qt));
                                    JSONArray linha = null;
                                    for (int i = 0; i < qt; i++) {
                                        if (comhttpSimples.isCancelled()) {
                                            break;
                                        }
                                        linha = dados.getJSONArray(i);
                                        codtabeladb = linha.getString(0);
                                        //logSincronizar("sincronizando tabeladb: " + codtabeladb);
                                        objs.sql.inserirOuAtualizar(
                                                nomeTab,
                                                "codtabeladb",
                                                "'" + codtabeladb + "'",
                                                new ArrayList<String>(Arrays.asList(
                                                        /* 1*/"nometabeladb",
                                                        /* 2*/"statussinc"
                                                )),
                                                new ArrayList<String>(Arrays.asList(
                                                        linha.getString(1),
                                                        objs.funcoesObjeto.nvl(linha.getString(2), "").toString()
                                                ))
                                        );
                                    }
                                }
                            }
                        }
                    } else {
                        //restaurar_statussinc(nomeTab);
                        //logSincronizar("-processo '" + fnome + "' cancelado");
                    }
                } else {
                    requisicao_sincronizacao_falhou(comhttpSimples,nomeTab,fnome,statusRequisicao);
                }
                //objs.variaveisBasicas.getDadosFragSincronizar().removerRequisicaoAtiva(comhttpSimples);
            }
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() - 1);
            //logSincronizar("-processo '" + fnome + "' finalizado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public void receber_lista_camposdb(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "receber_lista_camposdb";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + "' iniciado");
            if (comhttpSimples != null) {
                String nomeTab = "campodb";
                int statusRequisicao = comhttpSimples.getStatusRequisicao();
                objs.funcoesBasicas.log("StatusRequisicao: " + statusRequisicao);
                if (statusRequisicao == 3) {
                    if (!comhttpSimples.isCancelled()) {
                        if (!comhttpSimples.isCancelled()) {
                            JSONArray dados = objs.funcoesRequisicao.obter_dados_tabela(comhttpSimples);
                            if (dados != null) {
                                int qt = dados.length();
                                String codcampodb = null;
                                JSONArray linha = null;
                                for (int i = 0; i < qt; i++) {
                                    if (comhttpSimples.isCancelled()) {
                                        break;
                                    }
                                    linha = dados.getJSONArray(i);
                                    codcampodb = linha.getString(0);
                                    //logSincronizar("sincronizando campodb: " + codcampodb);
                                    objs.sql.inserirOuAtualizar(
                                            nomeTab,
                                            "codcampodb",
                                            "'" + codcampodb + "'",
                                            new ArrayList<String>(Arrays.asList(
                                                    /* 1*/"codtabeladb",
                                                    /* 2*/"nomecampodb",
                                                    /* 3*/"nomecampovisivel",
                                                    /* 4*/"aliascampodb",
                                                    /* 5*/"tipodado",
                                                    /* 6*/"parametros",
                                                    /* 7*/"statussinc"
                                            )),
                                            new ArrayList<String>(Arrays.asList(
                                                    linha.getString(1),
                                                    linha.getString(2),
                                                    linha.getString(3),
                                                    linha.getString(4),
                                                    linha.getString(5),
                                                    linha.getString(6),
                                                    objs.funcoesObjeto.nvl(linha.getString(7), "").toString()
                                            ))
                                    );
                                }
                            }
                        }
                    } else {
                        //restaurar_statussinc(nomeTab);
                        //logSincronizar("-processo '" + fnome + "' cancelado");
                    }
                } else {
                    requisicao_sincronizacao_falhou(comhttpSimples,nomeTab,fnome,statusRequisicao);
                }
                //objs.variaveisBasicas.getDadosFragSincronizar().removerRequisicaoAtiva(comhttpSimples);
            }
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() - 1);
            //logSincronizar("-processo '" + fnome + "' finalizado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public void receber_lista_processos(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "receber_lista_processos";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + "' iniciado");
            if (comhttpSimples != null) {
                String nomeTab = "processos";
                int statusRequisicao = comhttpSimples.getStatusRequisicao();
                objs.funcoesBasicas.log("StatusRequisicao: " + statusRequisicao);
                if (statusRequisicao == 3) {
                    if (!comhttpSimples.isCancelled()) {
                        if (!comhttpSimples.isCancelled()) {
                            JSONArray dados = objs.funcoesRequisicao.obter_dados_tabela(comhttpSimples);
                            if (dados != null) {
                                int qt = dados.length();
                                String codprocesso = null;
                                objs.funcoesBasicas.log("qtd processos recebidos: " + qt);
                                JSONArray linha = null;
                                for (int i = 0; i < qt; i++) {
                                    if (comhttpSimples.isCancelled()) {
                                        break;
                                    }
                                    linha = dados.getJSONArray(i);
                                    codprocesso = linha.getString(0);
                                    //logSincronizar("sincronizando processo: " + codprocesso);
                                    objs.sql.inserirOuAtualizar(
                                            nomeTab,
                                            "codprocesso",
                                            "'" + codprocesso + "'",
                                            new ArrayList<String>(Arrays.asList(
                                                    /* 1*/"nomeprocesso",
                                                    /* 2*/"statussinc"
                                            )),
                                            new ArrayList<String>(Arrays.asList(
                                                    linha.getString(1),
                                                    objs.funcoesObjeto.nvl(linha.getString(2), "").toString()
                                            ))
                                    );
                                }
                            }
                        }
                    } else {
                        //restaurar_statussinc(nomeTab);
                        //logSincronizar("-processo '" + fnome + "' cancelado");
                    }
                } else {
                    requisicao_sincronizacao_falhou(comhttpSimples,nomeTab,fnome,statusRequisicao);
                }
                //objs.variaveisBasicas.getDadosFragSincronizar().removerRequisicaoAtiva(comhttpSimples);
            }
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() - 1);
            //logSincronizar("-processo '" + fnome + "' finalizado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void receber_lista_comandossql(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "receber_lista_comandossql";
            objs.funcoesBasicas.logi(cnome,fnome);
            //logSincronizar("-processo '" + fnome + "' iniciado");
            if (comhttpSimples != null) {
                String nomeTab = "comandossql";
                int statusRequisicao = comhttpSimples.getStatusRequisicao();
                objs.funcoesBasicas.log("StatusRequisicao: " + statusRequisicao);
                if (statusRequisicao == 3) {
                    if (!comhttpSimples.isCancelled()) {
                        if (!comhttpSimples.isCancelled()) {
                            JSONArray dados = objs.funcoesRequisicao.obter_dados_tabela(comhttpSimples);
                            if (dados != null) {
                                int qt = dados.length();
                                String codcomandosql = null;
                                objs.funcoesBasicas.log("qtd comandossql recebidos: " + qt);
                                JSONArray linha = null;
                                for (int i = 0; i < qt; i++) {
                                    if (comhttpSimples.isCancelled()) {
                                        break;
                                    }
                                    linha = dados.getJSONArray(i);
                                    codcomandosql = linha.getString(0);
                                    objs.funcoesBasicas.log("sincronizando comandosql: " + codcomandosql);
                                    //logSincronizar("sincronizando comandosql: " + codcomandosql);
                                    objs.funcoesBasicas.log(linha.join(","));
                                    /*
                                    Comando sql no servidor:
                                    SELECT
                                        codcomandosql,
                                        codprocesso,
                                        tipocomando,
                                        tipoobjeto,
                                        comandosql,
                                        tabelas,
                                        aliasescamposunique,
                                        aliasescamposresultantes,
                                        condicionantes,
                                        groupby,
                                        having_,
                                        orderby,
                                        traducaocampossqlobjapp,
                                        traducaotipossqlobjapp,
                                        statussinc
                                    FROM
                                        sjdcomandossqlcel
                                    where
                                        __CONDICTAB__
                                    order by 1
                                     */


                                    objs.sql.inserirOuAtualizar(
                                            nomeTab,
                                            "codcomandosql",
                                            "'" + codcomandosql + "'",
                                            new ArrayList<String>(Arrays.asList(
                                                    /* 1*/"codprocesso",
                                                    /* 2*/"tipocomando",
                                                    /* 3*/"tipoobjeto",
                                                    /* 4*/"comandosql",
                                                    /* 5*/"tabelas",
                                                    /* 6*/"aliasescamposunique",
                                                    /* 7*/"aliasescamposresultantes",
                                                    /* 8*/"condicionantes",
                                                    /* 9*/"groupby",
                                                    /* 10*/"having_",
                                                    /* 11*/"orderby",
                                                    /* 12*/"traducaocampossqlobjapp",
                                                    /* 13*/"traducaotipossqlobjapp",
                                                    /* 14*/"statussinc"
                                            )),
                                            new ArrayList<String>(Arrays.asList(
                                                    linha.getString(1),
                                                    linha.getString(2),
                                                    linha.getString(3),
                                                    linha.getString(4),
                                                    linha.getString(5),
                                                    linha.getString(6),
                                                    linha.getString(7),
                                                    linha.getString(8),
                                                    linha.getString(9),
                                                    linha.getString(10),
                                                    linha.getString(11),
                                                    linha.getString(12),
                                                    linha.getString(13),
                                                    linha.getString(14)
                                            ))
                                    );
                                }
                            }
                        }
                    } else {
                        //restaurar_statussinc(nomeTab);
                        //logSincronizar("-processo '" + fnome + "' cancelado");
                    }
                } else {
                    requisicao_sincronizacao_falhou(comhttpSimples,nomeTab,fnome,statusRequisicao);
                }
                //objs.variaveisBasicas.getDadosFragSincronizar().removerRequisicaoAtiva(comhttpSimples);
            }
            //objs.variaveisBasicas.getDadosFragSincronizar().setNumReqSincAtivas(objs.variaveisBasicas.getDadosFragSincronizar().getNumReqSincAtivas() - 1);
            //logSincronizar("-processo '" + fnome + "' finalizado");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static String obter_opcao_banco(String opcao){
        try {
            return obter_opcao_banco(opcao,null);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String obter_opcao_banco(String opcao, String valorPadrao){
        try {
            String retorno = null;
            if (objs.sql.verificar_tabela_existe("opcoes") == true) {
                Cursor dados = objs.sql.executarSql(
                        "opcoes",
                        new String[]{"valor"},
                        "opcao=?",
                        new String[]{opcao.trim().toLowerCase()}
                );
                if (dados != null && dados.moveToFirst()) {
                    retorno = dados.getString(0);
                } else {
                    if (valorPadrao != null) {
                        objs.sql.inserirOuAtualizar(
                                "opcoes",
                                "opcao",
                                "'" + opcao + "'",
                                new ArrayList<String>(Arrays.asList("valor")),
                                new ArrayList<String>(Arrays.asList(valorPadrao))
                        );
                    }
                    retorno = valorPadrao;
                }
                objs.funcoesDados.fecharCursor(dados);
            } else {
                retorno = valorPadrao;
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return valorPadrao;
        }
    }

    public void navegar(int id) {
        try {
            navegar(id,null);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void navegar(int id, View pViewOrigem) {
        try {
            objs.variaveisBasicas.getActivityPrincipal().navegar(id, pViewOrigem);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void fecharMenuNavigation(){
        try {
            objs.variaveisBasicas.getActivityPrincipal().fecharMenuNavigation();
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void clicouNavMenuItem(View v) {
        try {
            if (v != null) {
                String tag = String.valueOf(v.getTag());
                Integer resId = null;
                resId = v.getResources().getIdentifier(tag, "id", v.getContext().getPackageName());
                if (resId == null && objs.variaveisBasicas.getActivityAtual() != null) {
                    resId = objs.variaveisBasicas.getActivityAtual().getResources().getIdentifier(tag, "id", objs.variaveisBasicas.getActivityAtual().getPackageName());
                }
                if (resId != null ) {
                    navegar(resId, v);
                } else {
                    switch (tag) {
                        case "nav_sair":
                            sair(true,objs.variaveisBasicas.getFragmentoLogin().getId());
                            break;
                        default:
                            objs.funcoesBasicas.log("botao nao programado");
                            break;
                    }
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void sair(int idNavLogin) {
        try {
            objs.funcoesBasicas.mostrarmsg("saindo...");
            FuncoesSisBib.getInstancia(contexto).sair(true, idNavLogin);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void recriarTabelas(int idNavLogin) {
        try {
            objs.funcoesBasicas.mostrarmsg("recriando tabelas...");
            objs.sql.criartabelas(objs.sql.db, true);
            navegar(idNavLogin);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void limparTabelas() {
        try {
            objs.funcoesBasicas.mostrarmsg("limpando tabelas...");
            objs.sql.limparTabelas(objs.sql.db);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_estrutura_banco_dados(Object objetoRetorno, Method metodoRetorno, Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_estrutura_banco_dados";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("0","nomeapp=" + objs.variaveisNomesSql.nomeappdb ,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_lista_tabelasdb(Object objetoRetorno, Method metodoRetorno,Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_lista_tabelasdb";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("1","nomeapp=" + objs.variaveisNomesSql.nomeappdb,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_lista_camposdb(Object objetoRetorno, Method metodoRetorno,Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_lista_camposdb";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("2","nomeapp=" + objs.variaveisNomesSql.nomeappdb,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_lista_processos(Object objetoRetorno, Method metodoRetorno,Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_lista_processos";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("3","nomeapp=" + objs.variaveisNomesSql.nomeappdb,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_lista_comandossql(Object objetoRetorno, Method metodoRetorno,Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_lista_comandossql";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("4","nomeapp=" + objs.variaveisNomesSql.nomeappdb,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void requisitar_lista_atualizacoes_obrigatorias(Object objetoRetorno, Method metodoRetorno,Object objetoRetornoErro, Method metodoRetornoErro) {
        try {
            String fnome = "requisitar_lista_atualizacoes_obrigatorias";
            objs.funcoesBasicas.logi(cnome,fnome);
            requisicao_padrao("5","nomeapp=" + objs.variaveisNomesSql.nomeappdb,objetoRetorno,metodoRetorno,objetoRetornoErro,metodoRetornoErro);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    /* o arraylist de linhas deve ser de forma que cada linha contenha um registro informando a tabela e campo*/
    public void atualizar_estrutura_banco_dados(ArrayList<ArrayList<String>> linhas) {
        try {
            String fnome = "atualizar_estrutura_banco_dados";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> comandosTabelas = objs.sql.montar_comando_sql_criar_tabelas(linhas);
            objs.sql.criartabelas(comandosTabelas);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    /* o arraylist de linhas deve ser de forma que cada linha contenha um registro informando a tabela e campo*/
    public void atualizar_estrutura_banco_dados(JSONArray linhas) {
        try {
            String fnome = "atualizar_estrutura_banco_dados";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> comandosTabelas = objs.sql.montar_comando_sql_criar_tabelas(linhas);
            objs.sql.criartabelas(comandosTabelas);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void verificar_existencia_tabelasdb() {
        try {
            String fnome = "verificar_existencia_tabelasdb";
            objs.funcoesBasicas.logi(cnome,fnome);
            String comandoSql = "" +
                    "SELECT distinct " +
                    "   t.codtabeladb, " +
                    "   t.nometabeladb " +
                    "FROM " +
                    "   tabeladb t " +
                    "order by 1";
            ArrayList<ArrayList<String>> tabelas = objs.sql.dados_para_array(objs.sql.executarSql(comandoSql));
            ArrayList<String> codsTabelasCriar = new ArrayList<String>();
            for(ArrayList<String> tabela : tabelas) {
                if (objs.sql.verificar_tabela_existe(tabela.get(1)) == false) {
                    codsTabelasCriar.add(tabela.get(0));
                }
            }
            objs.funcoesBasicas.log("qtd tabelas criar: ",codsTabelasCriar.size());

            comandoSql = "" +
                    "SELECT " +
                    "   t.codtabeladb, " +
                    "   t.nometabeladb," +
                    "   c.codcampodb," +
                    "   c.nomecampodb," +
                    "   c.nomecampovisivel," +
                    "   c.aliascampodb," +
                    "   c.tipodado," +
                    "   c.parametros " +
                    "FROM " +
                    "   tabeladb t" +
                    "   join campodb c on (c.codtabeladb = t.codtabeladb) " +
                    "WHERE " +
                    "   t.codtabeladb in ("+ codsTabelasCriar.toString().replace("[","").replace("]","") +") " +
                    "order by 1,3";
            tabelas = objs.sql.dados_para_array(objs.sql.executarSql(comandoSql));
            if (tabelas != null && tabelas.size() > 0) {
                objs.funcoesBasicas.log(tabelas);
                Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> comandosCriarTabelas = objs.sql.montar_comando_sql_criar_tabelas(tabelas);
                objs.sql.criartabelas(comandosCriarTabelas);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}