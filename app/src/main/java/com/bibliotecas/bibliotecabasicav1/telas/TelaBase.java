package com.bibliotecas.bibliotecabasicav1.telas;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.TypedValue;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.app.ActivityCompat;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.navigation.NavController;
import androidx.navigation.fragment.NavHostFragment;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.carregando.ViewCarregando;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo.CaixaDialogoPadrao;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.teclado.CustomKeyboard;
import com.bibliotecas.bibliotecabasicav1.telas.fragmentos.FragmentoBase;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;
import com.google.android.material.navigation.NavigationView;

import java.lang.reflect.Field;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;

public abstract class TelaBase extends AppCompatActivity {
    private static String cnome = "TelaBase";
    public ViewGroup layoutPrincipal = null;
    public Toolbar toolbar;
    public DrawerLayout drawer;
    public NavHostFragment fragmentoConteudo;
    public NavigationView navigationView;
    public NavController navController;
    public Menu menu;
    Bundle bundle;
    public ViewCarregando viewCarregando;
    public ImageButton toggleButton;
    public MenuItem itensMenuDBA;
    public FragmentoBase fragmentoInicio;
    public int idLayoutPrincipal = -1;
    public CustomKeyboard tecladoNumerico = null;
    private boolean verifCondicBack = true;
    public Object objeto_activity_result = null;
    public Method metodo_activity_result = null;
    public Object[] args_activity_result = null;
    public int resultCode = 0;
    protected ObjetosBasicos objs = null;
    public Intent intent = null;
    protected Context contexto = null;
    public Object objetoRetornoPermissoes = null;
    public Method metodoRetornoPermissoes = null;

    public TelaBase(Context pContexto){
        super();
        try {
            String fnome = "TelaBase";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logi(cnome,fnome);
            this.objs.variaveisBasicas.adicionarObjeto(this);
            this.objs.variaveisBasicas.getCnjActitys().add(new Tipos.TChaveValor<TelaBase>(this.getClass().getName(), this));
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        try {
            String fnome = "onCreate";
            objs.funcoesBasicas.logi(cnome,fnome);
            super.onCreate(savedInstanceState);
            this.bundle = savedInstanceState;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    protected void onResume() {
        try {
            String fnome = "onResume";
            objs.funcoesBasicas.logi(cnome,fnome);
            super.onResume();
            this.objs.variaveisBasicas.setActivityAtual(this);
            this.objs.funcoesTela.getDisplayMetrics(this);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    protected void onResume(Boolean mostrar_carregando){
        try {
            String fnome = "onResume";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.mostrar_carregando();
            super.onResume();
            this.objs.variaveisBasicas.setActivityAtual(this);
            this.objs.funcoesTela.getDisplayMetrics(this);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    protected View.OnClickListener onClickItemMenuListener = new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            objs.funcoesSisBib.clicouNavMenuItem(v);
        }
    };

    public String obterTextoMenuItem(LinearLayout item) {
        try {
            String retorno = null;
            if (item != null && item.getChildCount() > 1) {
                retorno = ((TextView)item.getChildAt(1)).getText().toString();
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void clicouBotao(View v) {
        try {
            Object oTag = v.getTag();
            if (oTag != null) {
                String tag = oTag.toString();
                if (tag.trim().length() > 0) {
                    if (TextUtils.isDigitsOnly(tag)) {
                        int idNav = Integer.parseInt(tag);
                        navegar(idNav);
                    }
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }



    public void prosseguirBack(){
        try {
            String fnome = "prosseguirBack";
            objs.funcoesBasicas.logi(cnome,fnome);
            super.onBackPressed();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void processarBack() {
        try {
            String fnome = "processarBack";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.objs.variaveisBasicas.getFragmentoInicio() != null) {
                objs.funcoesBasicas.log("visivel",this.objs.variaveisBasicas.getFragmentoInicio().isVisible(), this.objs.variaveisBasicas.getFragmentoLogin().isVisible());
                if (this.objs.variaveisBasicas.getFragmentoInicio().isVisible() || this.objs.variaveisBasicas.getFragmentoLogin().isVisible()) {
                    objs.funcoesBasicas.log("visivel","ok");
                    finish();
                } else {
                    super.onBackPressed();
                }
            } else {
                objs.funcoesBasicas.log("visivel","errou");
                super.onBackPressed();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void onBackPressed(boolean verificarCondicBack) {
        try {
            String fnome = "onBackPressed("+String.valueOf((verificarCondicBack) + ")");
            objs.funcoesBasicas.logi(cnome,fnome);
            this.verifCondicBack = verificarCondicBack;
            this.onBackPressed();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void executar_ui(final Method metodo, final Object objeto, final Object... parametros) {
        try {
            String fnome = "executar_ui";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    try {
                        if (parametros != null && parametros.length > 0) {
                            metodo.invoke(objeto,parametros);
                        } else {
                            metodo.invoke(objeto);
                        }
                    } catch (IllegalAccessException e) {
                        e.printStackTrace();
                    } catch (InvocationTargetException e) {
                        e.printStackTrace();
                    }
                }
            });
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public void onBackPressed() {
        try {
            String fnome = "onBackPressed";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.verifCondicBack == false) {
                this.verifCondicBack = true; //o false so tem validade para uma execussao
                super.onBackPressed();
            } else {
                if (this.drawer.isDrawerOpen(GravityCompat.START)) {
                    this.drawer.closeDrawer(GravityCompat.START);
                } else if (this.tecladoNumerico != null && this.tecladoNumerico.isCustomKeyboardVisible()) {
                    this.tecladoNumerico.hideCustomKeyboard();
                } else if (this.objs.variaveisBasicas.getMenuBaseVisivel() != null) {
                    this.objs.variaveisBasicas.getMenuBaseVisivel().esconder();
                } else {
                    processarBack();
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    protected void onDestroy() {
        try {
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        } finally {
            super.onDestroy();
        }
    }

    public ImageButton getNavButtonView(Toolbar toolbar) {
        try {
            String fnome = "getNavButtonView";
            objs.funcoesBasicas.logi(cnome,fnome);
            Class<?> toolbarClass = Toolbar.class;
            Field navButtonField = toolbarClass.getDeclaredField("mNavButtonView");
            navButtonField.setAccessible(true);
            ImageButton navButtonView = (ImageButton) navButtonField.get(toolbar);
            objs.funcoesBasicas.logf(cnome,fnome);
            return navButtonView;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public ViewGroup getLayoutPricipal(){
        try {
            this.layoutPrincipal = this.findViewById(this.idLayoutPrincipal);
            return this.layoutPrincipal;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void mostrar_carregando(){
        try {
            if (this.viewCarregando != null) {
                this.viewCarregando.mostrar();
            } else {
                objs.funcoesBasicas.log("imagemcarregando nao encontrado");
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void esconder_carregando(){
        try {
            if (this.viewCarregando != null) {
                this.viewCarregando.esconder();
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public TelaBase getInstancia(){
        try {
            return this.getClass().cast(this);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void fecharMenuNavigation(){
        try {
            if (this.drawer.isDrawerOpen(GravityCompat.START)) {
                this.drawer.closeDrawer(GravityCompat.START);
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public void navegar(final int p_id_fragment) {
        try {
            String fnome = "navegar";
            navegar(p_id_fragment,null);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void navegar(final int p_id_fragment, View pViewOrigem) {
        try {
            String fnome = "navegar";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("navegando para ",p_id_fragment);
            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    Bundle vDadosExtrasFragmento = null;
                    if (pViewOrigem != null) {
                        vDadosExtrasFragmento = new Bundle();
                        vDadosExtrasFragmento.putInt("idViewOrigem",pViewOrigem.getId());
                    }
                    getInstancia().navController.navigate(p_id_fragment,vDadosExtrasFragmento);
                    fecharMenuNavigation();
                }
            });
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public int getActionBarHeight() {
        try {
            int actionBarHeight = getActionBar().getHeight();//getSupportActionBar().getHeight();
            if (actionBarHeight != 0) {
                actionBarHeight = actionBarHeight + 50;
                objs.funcoesBasicas.log("altura action bar a: " + actionBarHeight);
                return actionBarHeight;
            }
            TypedValue tv = new TypedValue();
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB) {
                objs.funcoesBasicas.log("altura action bar b");
                if (getTheme().resolveAttribute(android.R.attr.actionBarSize, tv, true)) {
                    objs.funcoesBasicas.log("altura action bar c");
                    actionBarHeight = TypedValue.complexToDimensionPixelSize(tv.data, getResources().getDisplayMetrics()) + 50;
                }
            } else {
                objs.funcoesBasicas.log("altura action bar d");
                actionBarHeight = TypedValue.complexToDimensionPixelSize(tv.data, getResources().getDisplayMetrics());
            }
            if (actionBarHeight <= 0) {
                objs.funcoesBasicas.log("altura action bar e");
                actionBarHeight = 180;
            }
            objs.funcoesBasicas.log("altura action bar: " + actionBarHeight);
            return actionBarHeight;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public void esconder_teclado(){
        try {
            ((InputMethodManager) this.getSystemService(Activity.INPUT_METHOD_SERVICE)).hideSoftInputFromWindow(this.getLayoutPricipal().getWindowToken(), 0);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public Object getObjeto_activity_result() {
        return this.objeto_activity_result;
    }

    public void setObjeto_activity_result(Object pObjeto_activity_result) {
        this.objeto_activity_result = pObjeto_activity_result;
    }

    public Method getMetodo_activity_result() {
        return this.metodo_activity_result;
    }

    public void setMetodo_activity_result(Method pMetodo_activity_result) {
        objs.funcoesBasicas.mostrarmsg("Ative o GPS");
        this.metodo_activity_result = pMetodo_activity_result;
    }

    public Object[] getArgs_activity_result() {
        return this.args_activity_result;
    }

    public void setArgs_activity_result(Object[] pArgs_activity_result) {
        this.args_activity_result = pArgs_activity_result;
    }

    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        String fnome = "onActivityResult";
        objs.funcoesBasicas.log("Inicio " + this.cnome + "." + fnome);
        super.onActivityResult(requestCode, resultCode, data);
        if (this.metodo_activity_result != null) {
            try {
                this.metodo_activity_result.invoke(this.objeto_activity_result, this.args_activity_result);
            } catch (IllegalAccessException var6) {
                var6.printStackTrace();
            } catch (InvocationTargetException var7) {
                var7.printStackTrace();
            }
        } else {
            objs.funcoesBasicas.log("metodo_activity_result null");
        }
        objs.funcoesBasicas.log("Fim " + this.cnome + "." + fnome);
    }

    public void solicitarPermissao(final String permissao,final int idSolicitacaoPermissao) {
        try {
            String fnome = "solicitarPermissao";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("solicitando permissao para: " + permissao);
            objs.funcoesBasicas.log("ok1");
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,permissao)) {
                objs.funcoesBasicas.log("ok2");
                // Provide an additional rationale to the user if the permission was not granted
                // and the user would benefit from additional context for the use of the permission.
                // For example if the user has previously denied the permission.
                CaixaDialogoPadrao cx = new CaixaDialogoPadrao(contexto);
                cx.setTitulo("Permissão necessária");
                cx.setMensagem("Permissão necessária para o correto funcionamento do App. Deseja permitir agora? Se optar por nao permitir ou negar uma permissão, infelizmente o app não poderá continuar.");
                cx.setEventoBotaoPositivo(new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        //re-request
                        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                            requestPermissions(new String[]{permissao},idSolicitacaoPermissao);
                        }
                    }
                });
                cx.mostrar();
                objs.funcoesBasicas.log("ok3");
            } else {
                // READ_PHONE_STATE permission has not been granted yet. Request it directly.
                objs.funcoesBasicas.log("ok4");

                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                    objs.funcoesBasicas.log("ok4.1");
                    requestPermissions(new String[]{permissao},idSolicitacaoPermissao);
                    objs.funcoesBasicas.log("ok4.2");
                }

            }
            objs.funcoesBasicas.log("ok5");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void solicitarPermissoes(final String[] permissoes,final int idSolicitacaoPermissao, Object objetoRetorno, Method metodoRetorno) {
        try {
            String fnome = "solicitarPermissoes";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("solicitando permissao para: ", permissoes);
            objs.funcoesBasicas.log("ok1");
            boolean temRequisicaoRacional = false;
            for(String permissao : permissoes) {
                if (!permissao.toUpperCase().contains("FOREGROUND_SERVICE")) {
                    if (ActivityCompat.shouldShowRequestPermissionRationale(this, permissao)) {
                        temRequisicaoRacional = true;
                        break;
                    }
                }
            }
            if (temRequisicaoRacional) {
                objs.funcoesBasicas.log("ok2");
                // Provide an additional rationale to the user if the permission was not granted
                // and the user would benefit from additional context for the use of the permission.
                // For example if the user has previously denied the permission.
                CaixaDialogoPadrao cx = new CaixaDialogoPadrao(contexto);
                cx.setTitulo("Permissão necessária");
                cx.setMensagem("Algumas permissões são necessárias para o correto funcionamento do App. Deseja permitir agora? Se optar por nao permitir ou negar uma permissão, infelizmente o app não poderá continuar.");
                cx.setEventoBotaoNegativo(new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        objs.funcoesBasicas.sair();
                    }
                });
                cx.setEventoBotaoPositivo(new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        //re-request
                        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                            objetoRetornoPermissoes = objetoRetorno;
                            metodoRetornoPermissoes = metodoRetorno;
                            requestPermissions(permissoes,idSolicitacaoPermissao);
                        }
                    }
                });
                cx.mostrar();
                objs.funcoesBasicas.log("ok3");
            } else {
                // READ_PHONE_STATE permission has not been granted yet. Request it directly.
                objs.funcoesBasicas.log("ok4");

                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                    objs.funcoesBasicas.log("ok4.1");
                    objetoRetornoPermissoes = objetoRetorno;
                    metodoRetornoPermissoes = metodoRetorno;
                    requestPermissions(permissoes,idSolicitacaoPermissao);
                    objs.funcoesBasicas.log("ok4.2");
                }

            }
            objs.funcoesBasicas.log("ok5");
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        try {
            String fnome = "onRequestPermissionsResult";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("retornrou permissao ",String.valueOf(requestCode), new ArrayList<String>(Arrays.asList(permissions)), Collections.singletonList(grantResults));
            if (objetoRetornoPermissoes != null && metodoRetornoPermissoes != null) {
                metodoRetornoPermissoes.invoke(objetoRetornoPermissoes,requestCode,permissions,grantResults);
            } else {
                objs.funcoesBasicas.log("sem metodo de retorno de permissoes definido");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    /*Para atualizar o Extras quando iniciada pela Notificacao*/
    @Override
    protected void onNewIntent(Intent intent) {
        try {
            String fnome = "onNewIntent";
            objs.funcoesBasicas.logi(cnome,fnome);
            super.onNewIntent(intent);
            this.intent = intent;

            if (this.intent != null) {
                Bundle extras = this.intent.getExtras();
                if (extras != null) {
                    String navegar_para = extras.getString("navegar_para");
                    if (navegar_para != null) {
                        objs.funcoesBasicas.log("navegar_para em telabase: " + navegar_para);
                    }
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


}


