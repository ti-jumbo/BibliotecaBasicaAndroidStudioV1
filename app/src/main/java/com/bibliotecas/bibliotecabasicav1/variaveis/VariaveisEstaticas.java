package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;
import android.graphics.Paint;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.math.BigDecimal;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;

public class VariaveisEstaticas extends ClasseBase {
    private static String cnome = "VariaveisEstaticas";
    private static VariaveisEstaticas uVariaveisEstaticas;
    public static Paint paint;
    public static NumberFormat formatarMoeda = NumberFormat.getCurrencyInstance();
    public static NumberFormat formatar2digitos = NumberFormat.getNumberInstance();
    public static SimpleDateFormat formatarDataAndroid = new SimpleDateFormat(VariaveisNomesSql.strdataandroid);
    public static SimpleDateFormat formatarDataPadrao = new SimpleDateFormat(VariaveisNomesSql.strdatanormal);
    public static SimpleDateFormat formatarDataHora = new SimpleDateFormat(VariaveisNomesSql.strdatahora);
    public static final BigDecimal bigDecimal_01 = new BigDecimal("0.01");
    public static final BigDecimal bigDecimal100 = new BigDecimal("100");
    public static String OBTER_USUARIOS_LOCAIS = "OBTER_USUARIOS_LOCAIS";

    public VariaveisEstaticas(Context pContexto){
        super(pContexto);
        try {
            String fnome = "VariaveisEstaticas";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            paint = new Paint();
            formatar2digitos.setMinimumFractionDigits(2);
            formatar2digitos.setMaximumFractionDigits(2);

            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized VariaveisEstaticas getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized VariaveisEstaticas getInstancia(Context vContexto){
        try {
            if (uVariaveisEstaticas == null) uVariaveisEstaticas = new VariaveisEstaticas(vContexto);
            return uVariaveisEstaticas;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}