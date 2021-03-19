package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.text.Editable;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.math.BigDecimal;
import java.util.ArrayList;

public class FuncoesConversao extends FuncoesBase {
    private static String cnome = "FuncoesConversao";
    private static FuncoesConversao uFuncoesConversao;

    public FuncoesConversao(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesConversao";
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

    public static synchronized FuncoesConversao getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesConversao getInstancia(Context pContexto) {
        try {
            if (uFuncoesConversao == null) {
                uFuncoesConversao = new FuncoesConversao(pContexto);
            }
            return uFuncoesConversao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Float comoFloat(Editable editable) {
        try {
            return comoFloat(editable.toString());
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Float comoFloat(String s) {
        try {
            Float retorno = 0f;
            if (s != null) {
                String st = s.replaceAll("[^\\,-.0123456789]","");
                if (st.length() > 0) {
                    int pp = st.indexOf(".");
                    int pv = st.indexOf(",");
                    int ch = 0;
                    if (pp > -1 && pv > -1) {
                        if (pp > pv) {
                            st = st.replace(",","");
                            ch = 1; //ponto sobrou ponto
                        } else {
                            st = st.replace(".","");
                            ch = 2; //sobrou virgula
                        }
                    } else {
                        if (pp > -1) {
                            ch = 1;
                        } else if (pv > -1 ) {
                            ch = 2;
                        }
                    }
                    if (ch == 1) {
                        int qt = st.replaceAll("[^\\.]","").length()-1;
                        for (int i = 0; i < qt ;i++) {
                            st = st.replaceFirst("\\.","");
                        }
                    } else if (ch == 2) {
                        int qt = st.replaceAll("[^\\,]","").length()-1;
                        for (int i = 0; i < qt ;i++) {
                            st = st.replaceFirst("\\,","");
                        }
                    }
                    retorno = Float.parseFloat(st.replace(",","."));
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static BigDecimal comoBigDecimal(Editable editable) {
        try {
            return comoBigDecimal(editable.toString());
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static BigDecimal comoBigDecimal(String s) {
        try {
            BigDecimal retorno = null;
            if (s != null) {
                String st = s.replaceAll("[^\\,-.0123456789]","");
                if (st.length() > 0) {
                    int pp = st.indexOf(".");
                    int pv = st.indexOf(",");
                    int ch = 0;
                    if (pp > -1 && pv > -1) {
                        if (pp > pv) {
                            st = st.replace(",","");
                            ch = 1; //ponto sobrou ponto
                        } else {
                            st = st.replace(".","");
                            ch = 2; //sobrou virgula
                        }
                    } else {
                        if (pp > -1) {
                            ch = 1;
                        } else if (pv > -1 ) {
                            ch = 2;
                        }
                    }
                    if (ch == 1) {
                        int qt = st.replaceAll("[^\\.]","").length()-1;
                        for (int i = 0; i < qt ;i++) {
                            st = st.replaceFirst("\\.","");
                        }
                    } else if (ch == 2) {
                        int qt = st.replaceAll("[^\\,]","").length()-1;
                        for (int i = 0; i < qt ;i++) {
                            st = st.replaceFirst("\\,","");
                        }
                    }
                    retorno = new BigDecimal(st.replace(",","."));
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String[] comoArrayString(ArrayList<String> arrayList) {
        try {
            String[] retorno = null;
            if (arrayList != null) {
                int qt = arrayList.size();
                if (qt > 0) {
                    retorno = new String[qt];
                    for (int i = 0; i < qt; i ++) {
                        retorno[i] = arrayList.get(i);
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }

    }

    public static ArrayList<Integer> comoArrayListInteger(int[] arrayInt) {
        try {
            ArrayList<Integer> retorno = null;
            if (arrayInt != null) {
                int qt = arrayInt.length;
                if (qt > 0) {
                    retorno = new ArrayList<Integer>();
                    for (int i = 0; i < qt; i ++) {
                        retorno.add(arrayInt[i]);
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}