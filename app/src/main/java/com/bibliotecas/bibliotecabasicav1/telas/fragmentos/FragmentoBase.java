package com.bibliotecas.bibliotecabasicav1.telas.fragmentos;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.carregando.ViewCarregando;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo.CaixaDialogoPadrao;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.menu.MenuBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

public abstract class FragmentoBase extends Fragment {
    private static String cnome = "FragmentoBase";
    public int idLayoutPrincipal = -1;
    public ViewGroup layoutPrincipal;
    public View view;
    public ViewCarregando viewCarregando;

    public MenuBase menuSuspensoBtnDireito = null;
    public MenuBase menuSuspensoInf = null;
    public String titulo = null;
    protected ObjetosBasicos objs = null;
    protected int idLayoutMenuDireito = -1;
    public ConstraintLayout ltmenususpenso;
    protected CaixaDialogoPadrao caixaDialogoPrincial = null;
    protected Context contexto = null;
    public FragmentoBase(Context pContexto){
        super();
        try {
            String fnome = "FragmentoBase";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logi(cnome,fnome);

            this.objs.variaveisBasicas.adicionarObjeto(this);
            this.objs.variaveisBasicas.getCnjFragmentos().add(new Tipos.TChaveValor(this.getClass().getName(),this));
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        try {
            this.titulo = "Fragmento";
            if (this.objs.variaveisBasicas.getActivityPrincipal() != null) {
                if (this.objs.variaveisBasicas.getActivityPrincipal().getActionBar() != null) {
                    if (this.objs.variaveisBasicas.getActivityPrincipal().getActionBar().getTitle() != null) {
                        this.titulo = this.objs.variaveisBasicas.getActivityPrincipal().getActionBar().getTitle().toString();
                    }
                }
            }
            return null;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    @Override
    public void onResume() {
        try {
            super.onResume();
            this.objs.variaveisBasicas.setFragmentoAtual(this);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        setHasOptionsMenu(true);
        super.onViewCreated(view, savedInstanceState);
    }

    @Override
    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        try {
            if (this.idLayoutMenuDireito != -1) {
                inflater.inflate(this.idLayoutMenuDireito, menu);
            }
            super.onCreateOptionsMenu(menu, inflater);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public FragmentoBase getInstancia(){
        try {
            return this.getClass().cast(this);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public ViewGroup getLayoutPrincipal(){
        try {
            if (this.layoutPrincipal == null ) {
                if (this.view != null) {
                    if (this.view.getId() == this.idLayoutPrincipal) {
                        this.layoutPrincipal = (ViewGroup) this.view;
                    } else {
                        if (this.getView() != null) {
                            if (this.getView().getId() == this.idLayoutPrincipal) {
                                this.layoutPrincipal = (ViewGroup) this.getView();
                            } else {
                                if (this.getView().getRootView() != null) {
                                    if (this.getView().getRootView().getId() == this.idLayoutPrincipal) {
                                        this.layoutPrincipal = (ViewGroup) this.getView().getRootView();
                                    }
                                }
                            }
                        }
                    }
                }
            }
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
                objs.funcoesBasicas.log("objeto carregando nao encontrado");
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


    public void bloquearDrawer() {
        try {
            this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    objs.variaveisBasicas.getActivityPrincipal().drawer.setDrawerLockMode(DrawerLayout.LOCK_MODE_LOCKED_CLOSED);
                    objs.variaveisBasicas.getActivityPrincipal().toggleButton.setEnabled(false);
                }
            });
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void desbloquearDrawer() {
        try {
            this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    objs.variaveisBasicas.getActivityPrincipal().drawer.setDrawerLockMode(DrawerLayout.LOCK_MODE_UNLOCKED);
                    objs.variaveisBasicas.getActivityPrincipal().toggleButton.setEnabled(true);
                    objs.variaveisBasicas.getActivityPrincipal().toggleButton.setVisibility(View.VISIBLE);
                }
            });
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}
