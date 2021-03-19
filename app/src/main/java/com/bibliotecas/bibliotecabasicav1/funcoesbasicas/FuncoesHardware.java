package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.content.Intent;
import android.location.LocationManager;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.telas.TelaBase;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class FuncoesHardware extends FuncoesBase {
    private static String cnome = "FuncoesHardware";
    private static FuncoesHardware uFuncoesHardware = null;
    public static Object ObjetoHardwareAtivo = null;
    public static Method MetodoHardwareAtivo = null;
    public static Object[] ArgsHardwareAtivo = null;
    public static Object ObjetoHardwareNaoAtivo = null;
    public static Method MetodoHardwareNaoAtivo = null;
    public static Object[] ArgsHardwareNaoAtivo = null;

    public FuncoesHardware(Context pContexto) {
        super(pContexto);
        String fnome = "FuncoesHardware";
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        if (this.contexto != null) {
            System.out.println("contexto recebido de: " + this.contexto.getPackageName());
        } else {
            System.out.println("contexto recebido de: nulo");
        }
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public static synchronized FuncoesHardware getInstancia() {
        return getInstancia(contexto);
    }

    public static synchronized FuncoesHardware getInstancia(Context pContexto) {
        if (uFuncoesHardware == null) {
            uFuncoesHardware = new FuncoesHardware(pContexto);
        }

        return uFuncoesHardware;
    }

    public static Object getObjetoHardwareAtivo() {
        return ObjetoHardwareAtivo;
    }

    public static void setObjetoHardwareAtivo(Object pObjetoHardwareAtivo) {
        ObjetoHardwareAtivo = pObjetoHardwareAtivo;
    }

    public static Method getMetodoHardwareAtivo() {
        return MetodoHardwareAtivo;
    }

    public static void setMetodoHardwareAtivo(Method pMetodoHardwareAtivo) {
        MetodoHardwareAtivo = pMetodoHardwareAtivo;
    }

    public static Object[] getArgsHardwareAtivo() {
        return ArgsHardwareAtivo;
    }

    public static void setArgsHardwareAtivo(Object[] pArgsHardwareAtivo) {
        ArgsHardwareAtivo = pArgsHardwareAtivo;
    }

    public static Object getObjetoHardwareNaoAtivo() {
        return ObjetoHardwareNaoAtivo;
    }

    public static void setObjetoHardwareNaoAtivo(Object pObjetoHardwareNaoAtivo) {
        ObjetoHardwareNaoAtivo = pObjetoHardwareNaoAtivo;
    }

    public static Method getMetodoHardwareNaoAtivo() {
        return MetodoHardwareNaoAtivo;
    }

    public static void setMetodoHardwareNaoAtivo(Method pMetodoHardwareNaoAtivo) {
        MetodoHardwareNaoAtivo = pMetodoHardwareNaoAtivo;
    }

    public static Object[] getArgsHardwareNaoAtivo() {
        return ArgsHardwareNaoAtivo;
    }

    public static void setArgsHardwareNaoAtivo(Object[] pArgsHardwareNaoAtivo) {
        ArgsHardwareNaoAtivo = pArgsHardwareNaoAtivo;
    }

    public static boolean verificar_gps_ativo() {
        String fnome = "verificar_gps_ativo";
        objs.funcoesBasicas.logi(cnome,fnome);
        LocationManager lm = (LocationManager) contexto.getSystemService(Context.LOCATION_SERVICE);
        objs.funcoesBasicas.logf(cnome,fnome);
        getInstancia(contexto);
        return verificar_gps_ativo(lm);
    }

    public static boolean verificar_gps_ativo(LocationManager lm) {
        String fnome = "verificar_gps_ativo";
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesBasicas.logf(cnome,fnome);
        if (lm != null) {
            return lm.isProviderEnabled("gps");
        } else {
            getInstancia(contexto);
            return verificar_gps_ativo();
        }
    }

    public static boolean verificar_hardware_ativo(String hardware) {
        String fnome = "verificar_hardware_ativo";
        objs.funcoesBasicas.logi(cnome,fnome);
        Boolean retorno = false;
        if (hardware != null) {
            String var3 = hardware.trim().toLowerCase();
            byte var4 = -1;
            switch(var3.hashCode()) {
                case 102570:
                    if (var3.equals("gps")) {
                        var4 = 0;
                    }
                default:
                    switch(var4) {
                        case 0:
                            getInstancia(contexto);
                            retorno = verificar_gps_ativo();
                            break;
                        default:
                            retorno = false;
                    }
            }
        }

        objs.funcoesBasicas.logf(cnome,fnome);
        return retorno;
    }

    public void solicitar_ativacao_hardware(String hardware) {
        String fnome = "solicitar_ativacao_hardware";
        objs.funcoesBasicas.logi(cnome,fnome);
        TelaBase activity_atual = objs.variaveisBasicas.getActivityPrincipal();
        try {
            activity_atual.setMetodo_activity_result(this.getClass().getMethod("verificar_e_executar_se_hardware_ativo", String.class));
            activity_atual.setObjeto_activity_result(getInstancia(contexto));
            activity_atual.setArgs_activity_result(new Object[]{hardware});
        } catch (NoSuchMethodException var5) {
            var5.printStackTrace();
        }
        Intent intent = new Intent("android.settings.LOCATION_SOURCE_SETTINGS");
        activity_atual.startActivityForResult(intent, 0);
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void verificar_e_ativar_hardware(String hardware) {
        String fnome = "verificar_e_ativar_hardware";
        objs.funcoesBasicas.logi(cnome,fnome);
        getInstancia(contexto);
        if (!verificar_hardware_ativo(hardware)) {
            this.solicitar_ativacao_hardware(hardware);
        } else {
            verificar_e_executar_se_hardware_ativo(hardware);
        }

        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public static void verificar_e_executar_se_hardware_ativo(String hardware) {
        String fnome = "verificar_e_executar_se_hardware_ativo";
        objs.funcoesBasicas.logi(cnome,fnome);
        getInstancia(contexto);
        Method var10000;
        Object var10001;
        if (!verificar_hardware_ativo(hardware)) {
            try {
                getInstancia(contexto);
                var10000 = getMetodoHardwareNaoAtivo();
                getInstancia(contexto);
                var10001 = getObjetoHardwareNaoAtivo();
                getInstancia(contexto);
                var10000.invoke(var10001, getArgsHardwareNaoAtivo());
            } catch (IllegalAccessException var5) {
                var5.printStackTrace();
            } catch (InvocationTargetException var6) {
                var6.printStackTrace();
            }
        } else {
            try {
                getInstancia(contexto);
                var10000 = getMetodoHardwareAtivo();
                getInstancia(contexto);
                var10001 = getObjetoHardwareAtivo();
                getInstancia(contexto);
                var10000.invoke(var10001, getArgsHardwareAtivo());
            } catch (IllegalAccessException var3) {
                var3.printStackTrace();
            } catch (InvocationTargetException var4) {
                var4.printStackTrace();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        }
    }

    public static void executar_se_hardware_ativo(String hardware, Boolean requerer_ativacao, Object objeto, Method metodo, Object[] args, Object objeto_nao_ativo, Method metodo_nao_ativo, Object[] args_nao_ativo) {
        String fnome = "executar_se_hardware_ativo";
        objs.funcoesBasicas.logi(cnome,fnome);
        getInstancia(contexto);
        setObjetoHardwareAtivo(objeto);
        getInstancia(contexto);
        setMetodoHardwareAtivo(metodo);
        getInstancia(contexto);
        setArgsHardwareAtivo(args);
        getInstancia(contexto);
        setObjetoHardwareNaoAtivo(objeto_nao_ativo);
        getInstancia(contexto);
        setMetodoHardwareNaoAtivo(metodo_nao_ativo);
        getInstancia(contexto);
        setArgsHardwareNaoAtivo(args_nao_ativo);
        getInstancia(contexto).verificar_e_ativar_hardware(hardware);
        objs.funcoesBasicas.logf(cnome,fnome);
    }
}
