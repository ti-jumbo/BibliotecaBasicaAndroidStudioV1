package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.requisicoes.TComHttp;
import com.bibliotecas.bibliotecabasicav1.requisicoes.TComHttpSimples;

import org.json.JSONArray;
import org.json.JSONObject;

public class FuncoesRequisicao extends FuncoesBase {
    private static String cnome = "FuncoesRequisicao";
    private static FuncoesRequisicao uFuncoesRequisicao;

    public FuncoesRequisicao(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesRequisicao";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesRequisicao getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesRequisicao getInstancia(Context pContexto) {
        try {
            if (uFuncoesRequisicao == null) {
                uFuncoesRequisicao = new FuncoesRequisicao(pContexto);
            }
            return uFuncoesRequisicao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }


    public JSONObject obter_dados_retornados(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "obter_dados_retornados";
            objs.funcoesBasicas.logi(cnome,fnome);
            JSONObject retorno = null;
            if (comhttpSimples != null) {
                if (comhttpSimples.req != null) {
                    if (comhttpSimples.req.getJSONObject("r") != null) {
                        retorno = comhttpSimples.req.getJSONObject("r").getJSONObject("dados");
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

    public JSONArray obter_dados_tabela(TComHttpSimples comhttpSimples) {
        try {
            String fnome = "dados_retorno_simples_como_arraylist";
            objs.funcoesBasicas.logi(cnome,fnome);
            JSONArray retorno = null;
            if (comhttpSimples != null) {
                if (comhttpSimples.req != null) {
                    if (comhttpSimples.req.getJSONObject("r") != null) {
                        JSONObject joDados = comhttpSimples.req.getJSONObject("r").getJSONObject("dados");
                        if (joDados != null) {
                            JSONObject joTabela = joDados.getJSONObject("tabela");
                            if (joTabela != null) {
                                retorno = joTabela.getJSONArray("dados");
                            }
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

    public JSONArray obter_dados_tabela(TComHttp comhttp) {
        try {
            String fnome = "dados_retorno_simples_como_arraylist";
            objs.funcoesBasicas.logi(cnome,fnome);
            JSONArray retorno = null;
            if (comhttp != null) {
                if (comhttp.req != null) {
                    if (comhttp.req.getJSONObject("retorno") != null) {
                        JSONObject joDados = comhttp.req.getJSONObject("retorno").getJSONObject("dados_retornados");
                        if (joDados != null) {
                            if (joDados.has("dados")) {
                                joDados = joDados.getJSONObject("dados");
                            }

                            JSONObject joTabela = joDados.getJSONObject("tabela");
                            if (joTabela != null) {
                                retorno = joTabela.getJSONArray("dados");
                            }
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

    /*public static ArrayList<ArrayList<String>> dados_retorno_simples_como_arraylist(TComHttpSimples comHttpSimples) {
        try {
            String fnome = "dados_retorno_simples_como_arraylist";
            objs.funcoesBasicas.logi(cnome,fnome);
            ArrayList<ArrayList<String>> retorno = null;
            if (comHttpSimples != null) {

                Map objmap = null;
                /*comhttpSimples.req.r deve ser o retorno */
                /*objmap = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(comHttpSimples.req.r), Map.class);
                Object dadosRet = objmap.get("dados");
                Map objMapDados = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(dadosRet), Map.class);
                Object tabela = objMapDados.get("tabela");
                Map objmaptabela = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(tabela), Map.class);
                Object titulo = objmaptabela.get("titulo");
                retorno = (ArrayList<ArrayList<String>>) objmaptabela.get("dados");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }*/

    /*public Map mapear_dados_comHttpSimples(TComHttpSimples comHttpSimples) {
        try {
            String fnome = "mapear_dados_comHttpSimples";
            objs.funcoesBasicas.logi(cnome,fnome);
            Map retorno = null;
            Map objmap = null;
            objmap = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(comHttpSimples.req.r), Map.class);
            Object dadosRet = objmap.get("dados");
            retorno = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(dadosRet), Map.class);
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }*/

    /*public Tipos.TDadosMapeadosComHttpSimples mapear_dados_tabela_comHttpSimples(TComHttpSimples comHttpSimples) {
        try {
            String fnome = "mapear_dados_tabela_comHttpSimples";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TDadosMapeadosComHttpSimples retorno = new Tipos.TDadosMapeadosComHttpSimples();
            Map objMapDados = mapear_dados_comHttpSimples(comHttpSimples);
            //JSONObject jo =
            Object tabela = objMapDados.get("tabela");
            Map objmaptabela = objs.variaveisBasicas.objectMapper.readValue(objs.variaveisBasicas.gson.toJson(tabela), Map.class);
            retorno.titulo = objmaptabela.get("titulo");
            retorno.linhas = (ArrayList<ArrayList<String>>) objmaptabela.get("dados");
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }*/

}