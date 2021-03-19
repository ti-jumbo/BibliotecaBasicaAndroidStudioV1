package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.math.BigDecimal;

public class FuncoesMatematica extends FuncoesBase {
    private static String cnome = "FuncoesMatematica";
    private static FuncoesMatematica uFuncoesMatematica;

    public FuncoesMatematica(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesMatematica";
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

    public static synchronized FuncoesMatematica getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesMatematica getInstancia(Context pContexto) {
        try {
            if (uFuncoesMatematica == null) {
                uFuncoesMatematica = new FuncoesMatematica(pContexto);
            }
            return uFuncoesMatematica;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Float maiorValor(Float... valores) {
        try {
            Float retorno = 0f;
            if (valores.length > 0) {
                retorno = valores[0];
                for (Float item : valores) {
                    if (retorno < item) {
                        retorno = item;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static int maiorValor(int... valores) {
        try {
            int retorno = 0;
            if (valores.length > 0) {
                retorno = valores[0];
                for (int item : valores) {
                    if (retorno < item) {
                        retorno = item;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public static Float menorValor(Float... valores) {
        try {
            Float retorno = 0f;
            if (valores.length > 0) {
                retorno = valores[0];
                for (Float item : valores) {
                    if (retorno > item) {
                        retorno = item;
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Float positivoOuZero(Float valor) {
        try {
            Float retorno = 0f;
            if (valor > 0) {
                retorno = valor;
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0f;
        }
    }

    public BigDecimal positivoOuZero(BigDecimal valor) {
        try {
            BigDecimal retorno = BigDecimal.ZERO;
            if (valor.compareTo(BigDecimal.ZERO) > 0) {
                retorno = valor;
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return BigDecimal.ZERO;
        }
    }
}
