package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

public class FuncoesData extends FuncoesBase {
    private static String cnome = "FuncoesData";
    private static FuncoesData uFuncoesData;

    public FuncoesData(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesData";
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

    public static synchronized FuncoesData getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesData getInstancia(Context pContexto) {
        try {
            if (uFuncoesData == null) {
                uFuncoesData = new FuncoesData(pContexto);
            }
            return uFuncoesData;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String como_string_mes_ano(Date date) {
        try {
            String retorno = "";
            String mes = "";
            String ano = "";
            if (date == null) {
                date = new Date();
            }

            mes = String.valueOf(date.getMonth()+1);
            if (mes.length() < 2) {
                mes = "0"+mes;
            }
            ano = String.valueOf(date.getYear());
            objs.funcoesBasicas.log("data","mes: ",mes,"ano",ano);
            retorno = mes + "/" + ano;
            objs.funcoesBasicas.log("data: ",retorno);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String como_string_mes_ano(Calendar c) {
        try {
            String retorno = "";
            String mes = "";
            String ano = "";
            if (c == null) {
                c = Calendar.getInstance();
            }

            mes = String.valueOf(c.get(Calendar.MONTH)+1);
            if (mes.length() < 2) {
                mes = "0"+mes;
            }
            ano = String.valueOf(c.get(Calendar.YEAR));
            objs.funcoesBasicas.log("data","mes: ",mes,"ano",ano);
            retorno = mes + "/" + ano;
            objs.funcoesBasicas.log("data: ",retorno);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Date como_data(String strData) {
        try {
            return objs.variaveisEstaticas.formatarDataPadrao.parse(strData);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Date como_data_android(String strData) {
        try {
            if (strData != null && strData.trim().length() > 0) {
                return objs.variaveisEstaticas.formatarDataAndroid.parse(strData);
            } else {
                return null;
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Date como_data(String strData, String formato) {
        try {
            Date retorno = null;
            SimpleDateFormat formatador = new SimpleDateFormat(formato);
            retorno = formatador.parse(strData);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static int comparar_datas(String strData1, String strData2, String formato){
        try {
            int retorno = 0;
            SimpleDateFormat formatador = new SimpleDateFormat(formato);
            if (strData1 != null) {
                if (strData1.trim().length() > 0) {
                    Date data1 = formatador.parse(strData1);
                    if (strData2 != null) {
                        if (strData2.trim().length() > 0) {
                            Date data2 = formatador.parse(strData2);
                            if (data1.after(data2)) {
                                retorno = 1;
                            } else if (data1.before(data2)) {
                                retorno = 2;
                            }
                        } else {
                            retorno = 1;
                        }
                    } else {
                        retorno = 1;
                    }
                } else {
                    if (strData2 != null) {
                        if (strData2.trim().length() > 0) {
                            Date data2 = formatador.parse(strData2);
                            retorno = 2;
                        }
                    }
                }
            } else {
                if (strData2 != null) {
                    if (strData2.trim().length() > 0) {
                        Date data2 = formatador.parse(strData2);
                        retorno = 2;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public static int comparar_datas(Date Data1, Date Data2){
        try {

            int retorno = 0;
            if (Data1 != null) {
                if (Data2 != null) {
                    if (Data1.after(Data2)) {
                        retorno = 1;
                    } else if (Data1.before(Data2)) {
                        retorno = 2;
                    }
                } else {
                    retorno = 1;
                }
            } else {
                if (Data2 != null) {
                    retorno = 2;
                }
            }
            objs.funcoesBasicas.log("comparando: " + Data1 + " " + Data2 + ":" + retorno);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

}
