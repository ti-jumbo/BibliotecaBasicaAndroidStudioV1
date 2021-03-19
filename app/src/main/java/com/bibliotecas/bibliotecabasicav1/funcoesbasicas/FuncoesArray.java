package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONArray;

import java.util.ArrayList;

public class FuncoesArray extends FuncoesBase {
    private static String cnome = "FuncoesArray";
    private static FuncoesArray uFuncoesArray;
    public FuncoesArray(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesArray";
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

    public static synchronized FuncoesArray getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesArray getInstancia(Context pContexto) {
        try {
            if (uFuncoesArray == null) {
                uFuncoesArray = new FuncoesArray(pContexto);
            }
            return uFuncoesArray;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Float maiorValorMatriz(ArrayList arr) {
        try {
            return maiorValorMatriz(arr,-1);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Float maiorValorMatriz(ArrayList arr,int colIgnorar) {
        try {
            String fnome = "maiorValorMatriz";
            objs.funcoesBasicas.logi(cnome,fnome);
            Float maior = 0f;
            Float maiorTemp = 0f;
            String c = "";
            Object item;
            int cont = 0;
            cont = 0;
            for (int i = 0; i < arr.size(); i++) {
                item = arr.get(i);
                c =  item.getClass().getName();
                if (c.equals("java.util.ArrayList")){
                    maiorTemp = maiorValorMatriz((ArrayList)item,colIgnorar);
                    if (maior < maiorTemp) {
                        maior = maiorTemp;
                    }
                } else {
                    if (i == colIgnorar) {
                        continue;
                    }
                    if (maior < Float.valueOf(item.toString().replaceAll("\\.","").replace(",","."))) {
                        maior = Float.valueOf(item.toString().replaceAll("\\.","").replace(",","."));
                    }
                }
            }
            return maior;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Float menorValorMatriz(ArrayList arr) {
        try {
            return maiorValorMatriz(arr,-1);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Float menorValorMatriz(ArrayList arr,int colIgnorar) {
        try {
            String fnome = "menorValorMatriz";
            objs.funcoesBasicas.logi(cnome,fnome);
            Float menor = 0f;
            Float menorTemp = 0f;
            String c = "";
            int cont = 0;
            cont = 0;
            for (Object item : arr) {
                c = item.getClass().getName();
                if (c.equals("java.lang.Float")) {
                    if (cont == colIgnorar) {
                        continue;
                    }
                    if (menor > (Float) item) {
                        menor = (Float) item;
                    }
                } else if (c.equals("java.util.ArrayList")) {
                    menorTemp = maiorValorMatriz((ArrayList) item, colIgnorar);
                    if (menor > menorTemp) {
                        menor = menorTemp;
                    }
                }
            }

            objs.funcoesBasicas.logf(cnome,fnome);
            return menor;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float maiorValorColuna(ArrayList<ArrayList> matriz, int indColuna, Float ignorarAcima) {
        try {
            Float retorno = 0f;
            if (matriz.size() > 0) {
                retorno = Float.valueOf(matriz.get(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                for (ArrayList linha : matriz) {
                    if (retorno < Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",",".")) &&
                            Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",",".")) < ignorarAcima) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."));
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float maiorValorColuna(JSONArray matriz, int indColuna, Float ignorarAcima) {
        try {
            Float retorno = 0f;
            if (matriz.length() > 0) {
                retorno = Float.valueOf(matriz.getJSONArray(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                int qt = matriz.length();
                JSONArray linha = null;
                for (int i = 0; i < qt; i++) {
                    linha = matriz.getJSONArray(i);
                    if (retorno < Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",",".")) &&
                            Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",",".")) < ignorarAcima) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."));
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }


    public Float maiorValorColuna(ArrayList<ArrayList> matriz, int indColuna, int indMaior) {
        try {
            Float retorno = 0f;
            if (matriz.size() > 0) {
                retorno = Float.valueOf(matriz.get(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                for (ArrayList linha : matriz) {
                    if (retorno < Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."))) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."));
                    }
                }
                if (indMaior > 0) {
                    while (indMaior > 0) {
                        retorno = maiorValorColuna(matriz,indColuna,retorno);
                        indMaior --;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float maiorValorColuna(JSONArray matriz, int indColuna, int indMaior) {
        try {
            Float retorno = 0f;
            if (matriz.length() > 0) {
                retorno = Float.valueOf(matriz.getJSONArray(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                int qt = matriz.length();
                JSONArray linha = null;
                for (int i = 0; i < qt; i++) {
                    linha = matriz.getJSONArray(i);
                    if (retorno < Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."))) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."));
                    }
                }
                if (indMaior > 0) {
                    while (indMaior > 0) {
                        retorno = maiorValorColuna(matriz,indColuna,retorno);
                        indMaior --;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }


    public Float menorValorColuna(ArrayList<ArrayList> matriz, int indColuna, Float ignorarAbaixo) {
        try {
            Float retorno = 0f;
            if (matriz.size() > 0) {
                retorno = Float.valueOf(matriz.get(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                for (ArrayList linha : matriz) {
                    if (retorno > Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) &&
                            Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) > ignorarAbaixo) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."));
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float menorValorColuna(JSONArray matriz, int indColuna, Float ignorarAbaixo) {
        try {
            Float retorno = 0f;
            if (matriz.length() > 0) {
                retorno = Float.valueOf(matriz.getJSONArray(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                int qt = matriz.length();
                JSONArray linha = null;
                for (int i = 0; i < qt; i++) {
                    linha = matriz.getJSONArray(i);
                    if (retorno > Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) &&
                            Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) > ignorarAbaixo) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."));
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float menorValorColuna(ArrayList<ArrayList> matriz, int indColuna, int indMenor) {
        try {
            Float retorno = 0f;
            if (matriz.size() > 0) {
                retorno = Float.valueOf(matriz.get(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                for (ArrayList linha : matriz) {
                    if (retorno > Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."))) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."));
                    }
                }
                if (indMenor > 0) {
                    while (indMenor > 0) {
                        retorno = menorValorColuna(matriz, indColuna, retorno);
                        indMenor--;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float menorValorColuna(JSONArray matriz, int indColuna, int indMenor) {
        try {
            Float retorno = 0f;
            if (matriz.length() > 0) {
                retorno = Float.valueOf(matriz.getJSONArray(0).get(indColuna).toString().replaceAll("\\.", "").replace(",", ".")) ;
                int qt = matriz.length();
                JSONArray linha = null;
                for (int i = 0; i < qt; i++) {
                    linha = matriz.getJSONArray(i);
                    if (retorno > Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."))) {
                        retorno = Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.", "").replace(",", "."));
                    }
                }
                if (indMenor > 0) {
                    while (indMenor > 0) {
                        retorno = menorValorColuna(matriz, indColuna, retorno);
                        indMenor--;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public String como_string(Object... objetos) {
        try {
            String retorno = "";
            String sep = ",";
            for (Object o : objetos) {
                retorno += String.valueOf(o) + sep;
            }
            if (retorno.length() > 0) {
                retorno = retorno.substring(0,retorno.length()-1);
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float somarValorColuna(ArrayList<ArrayList> matriz, int indColuna) {
        try {
            Float retorno = 0f;
            if (matriz.size() > 0) {
                for (ArrayList linha : matriz) {
                    retorno += Float.valueOf(linha.get(indColuna).toString().replaceAll("\\.","").replace(",","."));

                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public int procurar(String[] array,String valor) {
        try {
            int retorno = -1;
            int qtElementos = 0;
            if (valor != null && array != null) {
                qtElementos = array.length;
                String valorProcurar = valor.trim().toLowerCase();
                for (int i = 0; i < qtElementos; i++) {
                    if (array[i].toLowerCase().trim().equals(valorProcurar)) {
                        retorno = i;
                        break;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return -1;
        }
    }
}
