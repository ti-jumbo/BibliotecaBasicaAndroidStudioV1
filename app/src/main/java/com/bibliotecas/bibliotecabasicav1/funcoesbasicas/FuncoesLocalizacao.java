package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;

import androidx.core.app.ActivityCompat;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnSuccessListener;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class FuncoesLocalizacao extends FuncoesBase {
    private static String cnome = "FuncoesLocalizacao";
    private static FuncoesLocalizacao uFuncoesLocalizacao = null;
    private Object objetoAoReceberCoordenadas = null;
    private Method metodoAoReceberCoordenadas = null;
    private Object[] argsAoReceberCorrdenadas = null;
    private FusedLocationProviderClient mFusedLocationClient = null;

    public FuncoesLocalizacao(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesLocalizacao";
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

    public static synchronized FuncoesLocalizacao getInstancia() {
        return getInstancia(contexto);
    }

    public static synchronized FuncoesLocalizacao getInstancia(Context pContexto) {
        if (uFuncoesLocalizacao == null) {
            uFuncoesLocalizacao = new FuncoesLocalizacao(pContexto);
        }
        return uFuncoesLocalizacao;
    }

    public Object getObjetoAoReceberCoordenadas() {
        return this.objetoAoReceberCoordenadas;
    }

    public void setObjetoAoReceberCoordenadas(Object pObjetoAoReceberCoordenadas) {
        this.objetoAoReceberCoordenadas = pObjetoAoReceberCoordenadas;
    }

    public Method getMetodoAoReceberCoordenadas() {
        return this.metodoAoReceberCoordenadas;
    }

    public void setMetodoAoReceberCoordenadas(Method pMetodoAoReceberCoordenadas) {
        this.metodoAoReceberCoordenadas = pMetodoAoReceberCoordenadas;
    }

    public Object[] getArgsAoReceberCorrdenadas() {
        return this.argsAoReceberCorrdenadas;
    }

    public void setArgsAoReceberCorrdenadas(Object[] pArgsAoReceberCorrdenadas) {
        this.argsAoReceberCorrdenadas = pArgsAoReceberCorrdenadas;
    }

    public void recebeu_coordenadas_gps(Location localizacao) {
        String fnome = "recebeu_coordenadas_gps";
        objs.funcoesBasicas.logi(cnome,fnome);
        try {
            getMetodoAoReceberCoordenadas().invoke(getObjetoAoReceberCoordenadas(), localizacao, getArgsAoReceberCorrdenadas());
        } catch (IllegalAccessException var4) {
            var4.printStackTrace();
        } catch (InvocationTargetException var5) {
            var5.printStackTrace();
        }
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void carregar_servico_localizacao() {
        try {
            String fnome = "carregar_servico_localizacao";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.mFusedLocationClient = LocationServices.getFusedLocationProviderClient(objs.variaveisBasicas.getActivityPrincipal());
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void solicitar_coordenadas_gps_tem_permissao() {
        String fnome = "solicitar_coordenadas_gps_tem_permissao";
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesBasicas.log("requisitando gps");
        if (this.mFusedLocationClient == null) {
            this.carregar_servico_localizacao();
        }
        if (ActivityCompat.checkSelfPermission(contexto, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(contexto, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        this.mFusedLocationClient.getLastLocation().addOnSuccessListener(objs.variaveisBasicas.getActivityAtual(), new OnSuccessListener<Location>() {
            public void onSuccess(Location location) {
                if (location != null) {
                    recebeu_coordenadas_gps(location);
                }
            }
        });
        if (ActivityCompat.checkSelfPermission(contexto, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(contexto, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        this.mFusedLocationClient.getLastLocation();
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void solicitar_coordenadas_gps() {
        String fnome = "solicitar_coordenadas_gps";
        objs.funcoesBasicas.logi(cnome,fnome);
        try {
            objs.funcoesPermissao.executar_se_permitido("android.permission.ACCESS_FINE_LOCATION", contexto, this, objs.funcoesLocalizacao.getClass().getMethod("solicitar_coordenadas_gps_tem_permissao"), (Object[])null);
        } catch (NoSuchMethodException var3) {
            var3.printStackTrace();
        }

        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void ativacao_gps_negado() {
        String fnome = "ativacao_gps_negado";
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesBasicas.mostrarmsg("Ativação do Hardware GPS negado pelo usuario");
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void solicitar_localizacao(Method metodoReceptor, Object objetoReceptor, Object... args) {
        String fnome = "solicitar_localizacao";
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesLocalizacao.setObjetoAoReceberCoordenadas(objetoReceptor);
        objs.funcoesLocalizacao.setMetodoAoReceberCoordenadas(metodoReceptor);
        objs.funcoesLocalizacao.setArgsAoReceberCorrdenadas(args);

        try {
            objs.funcoesHardware.executar_se_hardware_ativo("gps", true, objs.funcoesLocalizacao, objs.funcoesLocalizacao.getClass().getMethod("solicitar_coordenadas_gps"), (Object[])null, objs.funcoesLocalizacao, objs.funcoesLocalizacao.getClass().getMethod("ativacao_gps_negado"), (Object[])null);
        } catch (NoSuchMethodException var6) {
            var6.printStackTrace();
        }

        objs.funcoesBasicas.logf(cnome,fnome);
    }
}
