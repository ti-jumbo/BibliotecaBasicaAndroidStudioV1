package com.bibliotecas.bibliotecabasicav1.tipos;

import android.content.Context;
import android.graphics.Canvas;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenho;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.lang.reflect.Method;
import java.util.ArrayList;

public class Tipos extends ClasseBase {
    private static String cnome = "Tipos";
    private static Tipos uTipos = null;

    public Tipos(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "Tipos";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.variaveisBasicas.adicionarObjeto(this);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized Tipos getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized Tipos getInstancia(Context pContexto) {
        try {
            if (uTipos == null) uTipos = new Tipos(pContexto);
            return uTipos;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static class TChaveValor<T> {
        public String chave ;
        public T valor ;

        public TChaveValor(String vchave, T vvalor) {
            try {
                this.chave = vchave;
                this.valor = vvalor;
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro("TChaveValor","TChaveValor",e);
            }
        }
    }

    public static class TCnjChaveValor<T> extends ArrayList<T> {
        public TChaveValor atualizar_valor(String chave, Object novo_valor){
            try {
                TChaveValor retorno = null;
                chave = chave.trim().toLowerCase();
                Integer qt = this.size();
                Boolean encontrado = false;
                for (Integer i = 0; i < qt; i++) {
                    if (((TChaveValor)this.get(i)).chave.trim().toLowerCase().equals(chave)) {
                        ((TChaveValor)this.get(i)).valor = novo_valor;
                        retorno = (TChaveValor) this.get(i);
                        encontrado = true;
                        break;
                    }
                }
                if (encontrado == false ) {
                    retorno = (TChaveValor)new TChaveValor(chave,novo_valor);
                    this.add((T)retorno);
                }
                return retorno;
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
                return null;
            }
        }
        public TChaveValor procurar(String chave){
            try {
                //objs.funcoesBasicas.log("Procurando por : " + chave);
                TChaveValor retorno = null;
                if (chave != null && chave.trim().length() > 0) {
                    chave = chave.trim().toLowerCase();
                    for (Object el : this) {
                        //objs.funcoesBasicas.log("Repassando chave: " + ((TChaveValor)el).chave.trim().toLowerCase());
                        if (((TChaveValor) el).chave.trim().toLowerCase().equals(chave)) {
                            //objs.funcoesBasicas.log("encontrou, saindo");
                            retorno = (TChaveValor) el;
                            break;
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

    public static class TTamanho {
        public Float width;
        public Float height;
    }

    public static class TDadosDesenho {
        /*
            tipoDesenho:
                0 = linha
                1 = retangulo
                2 = texto
                3 = arco
                4 = circulo
        */
        public Integer tipoDesenho;
        public ArrayList<Float> coordenadas;
        public ArrayList<Float> coordenadas_internas;
        public TTamanho tamanho_externo;
        public int cor_fundo;
        public int cor_contorno;
        public int cor_preenchimento;
        public boolean tamanhoViewIgualDesenho;
        public Float espessura_contorno;
        public String texto;
        public Float tamanho_texto;
        public ConstraintLayout layoutPai;
        public ArrayList<TConstraint> cnjConstraints;
        public ConstraintLayout layoutDesenho;
        public ViewDesenho viewDesenho;
        public Canvas canvas;
        public TTamanho tamanho_externo_texto;
        public ArrayList<String> dadosTag;
        public Method methodo_onclick = null;
        public Object objeto_onclick = null;
        public Float zIndex = 0f;
        public TDadosDesenho(){
            try {
                this.coordenadas = new ArrayList<Float>();
                this.coordenadas_internas = new ArrayList<Float>();
                this.tamanho_externo = new TTamanho();
                this.tamanhoViewIgualDesenho = true;
                this.cnjConstraints = new ArrayList<TConstraint>();
                this.texto = null;
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }
        public TDadosDesenho(Float... pCoordenadas){
            try {
                this.coordenadas = new ArrayList<Float>();
                this.tamanho_externo = new TTamanho();
                this.tamanhoViewIgualDesenho = true;
                this.cnjConstraints = new ArrayList<TConstraint>();
                this.texto = null;
                if (pCoordenadas.length > 0) {
                    for (Float item : pCoordenadas) {
                        this.coordenadas.add(item);
                    }
                }
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }
    }

    public static class TConstraint {
        public int tipoConstraint;
        public int idObj;
        public int idConObj;
        public int idObjPai;
        public int idConObjPai;
        public int margem;
        public TConstraint(){
        }
        public TConstraint(int pTipoConstraint, int pIdObj,int pIdConObj, int pIdObjPai, int pIdConObjPai, int pMargem){
            try {
                this.tipoConstraint = pTipoConstraint;
                this.idObj = pIdObj;
                this.idConObj = pIdConObj;
                this.idObjPai = pIdObjPai;
                this.idConObjPai = pIdConObjPai;
                this.margem = pMargem;
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }
    }

    public static class TDadosUsuario   {
        String fnome = "TDadosUsuario";
        public int codusur = 0;
        int codsupervisor = 0;
        public String nome = null;
        public String senha = null;
        public String tipoUsuario = null;
        public String podeVer = null;
        public Integer codNivelAcesso = 50;
        public Integer codFilial = null;
        public ArrayList<Integer> codsUsuariosAcessiveis;
        public TDadosUsuario(){
            try {
                this.codsUsuariosAcessiveis = new ArrayList<Integer>();
            } catch (Exception e) {
                objs.funcoesBasicas.mostrarErro(e);
            }
        }
    }

    public static class TDadosMapeadosComHttpSimples {
        public static Object titulo = null;
        public static ArrayList<ArrayList<String>> linhas = null;
    }

    public static class TMetodoRetorno {
        public static Object objeto = null;
        public static Method metodo = null;
        public static Object[] parametros = null;
        public static Integer cod = null;
        public static String idString = null;
    }

    public static class TDadosSincronizacao{
        public int codSinc ;
        public String nomeSinc = null;
        public String requisicao = null;
    }

}