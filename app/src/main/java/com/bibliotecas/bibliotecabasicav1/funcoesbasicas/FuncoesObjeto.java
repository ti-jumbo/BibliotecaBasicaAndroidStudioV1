package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.os.Build;
import android.view.View;
import android.view.ViewGroup;

import androidx.core.view.ViewCompat;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class FuncoesObjeto extends FuncoesBase {
    private static String cnome = "FuncoesObjeto";
    private static FuncoesObjeto uFuncoesObjeto;

    public FuncoesObjeto(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesObjeto";
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

    public static synchronized FuncoesObjeto getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesObjeto getInstancia(Context pContexto) {
        try {
            if (uFuncoesObjeto == null) {
                uFuncoesObjeto = new FuncoesObjeto(pContexto);
            }
            return uFuncoesObjeto;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static View procurar_superior(View view, String nomeClasseSuperior) {
        try {
            View retorno = null;
            if (view != null) {
                View view_temp = view;
                while (view_temp != null) {
                    objs.funcoesBasicas.log("procurando: " + nomeClasseSuperior + " em " + view_temp.getClass().getName());
                    if (view_temp.getClass().getName().trim().toLowerCase().equals(nomeClasseSuperior.trim().toLowerCase())) {
                        retorno = view_temp;
                        break;
                    }
                    view_temp = (View) view_temp.getParent();
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Object nvl(Object valor, Object valorSeNulo) {
        try {
            if (valor != null) {
                return valor;
            } else {
                return valorSeNulo;
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return valor;
        }
    }

    public static void atribuirOnLongClickMenu(ViewGroup viewGroup, final Method metodo, final Object objeto) {
        try {
            String fnome = "atribuirOnLongClickMenu";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (viewGroup != null) {
                View viewFilha = null;
                int qt = viewGroup.getChildCount();
                objs.funcoesBasicas.log(viewGroup.getClass().getName() + "( " + qt + " )");
                for (int i = 0; i < qt; i++) {
                    viewFilha = viewGroup.getChildAt(i);
                    objs.funcoesBasicas.log(viewFilha.getClass().getName());
                    if (viewFilha.getClass().getName().contains("NavigationMenuItemView")) {
                        objs.funcoesBasicas.log("menu: vinculou");
                        viewFilha.setOnLongClickListener(new View.OnLongClickListener() {
                            @Override
                            public boolean onLongClick(View v) {
                                objs.funcoesBasicas.log("long clicou");
                                try {
                                    metodo.invoke(objeto,v);
                                } catch (IllegalAccessException e) {
                                    e.printStackTrace();
                                } catch (InvocationTargetException e) {
                                    e.printStackTrace();
                                }
                                return false;
                            }
                        });
                    }

                    if (viewFilha instanceof ViewGroup) {
                        atribuirOnLongClickMenu((ViewGroup) viewFilha, metodo, objeto );
                    }
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Integer gerarIdView(){
        try {
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN_MR1) {
                return View.generateViewId();
            } else {
                return ViewCompat.generateViewId();
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}
