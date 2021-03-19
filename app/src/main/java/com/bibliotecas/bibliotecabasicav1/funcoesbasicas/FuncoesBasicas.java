package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.database.Cursor;
import android.widget.Toast;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo.CaixaAlertaDialogo;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.Writer;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;

public class FuncoesBasicas extends FuncoesBase {
    private static String cnome = "FuncoesBasicas";
    private static FuncoesBasicas uFuncoesBasicas = null;

    public FuncoesBasicas(Context vContexto) {
        super(vContexto);
        try {
            String fnome = "FuncoesBasicas";
            System.out.println("Inicio " + cnome + "." + fnome);
            contexto = vContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            System.out.println("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(e);
        }
    }
    public static synchronized FuncoesBasicas getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            e.printStackTrace();
            FuncoesBasicas.mostrarErro(cnome,"getInstancia",e);
            return null;
        }
    }
    public static synchronized FuncoesBasicas getInstancia(Context vContexto){
        try {
            if (uFuncoesBasicas == null) uFuncoesBasicas = new FuncoesBasicas(vContexto);
            return uFuncoesBasicas;
        } catch (Exception e) {
            e.printStackTrace();
            FuncoesBasicas.mostrarErro(cnome,"getInstancia",e);
            return null;
        }
    }
    public static void log(Object... textos){
        try {
            String s = "";
            for (Object o : textos) {
                if (o instanceof Cursor) {
                    ArrayList<ArrayList<String>> linhas = objs.variaveis.getSql(contexto).dados_para_array((Cursor) o);
                    if (linhas != null) {
                        log(s);
                        s = "";
                        for (ArrayList<String> l : linhas) {
                            log(l.toString());
                        }
                    }
                } else {
                    s += o + ",";
                }
            }
            if (s.length() > 0) {
                s = s.substring(0,s.length() - 1) ;
            }
            log(s);
        } catch (Exception e) {
            e.printStackTrace();
            FuncoesBasicas.mostrarErro(cnome,"log",e);
        }
    }
    public static void log(Object texto){
        try {
            if (texto != null) {
                System.out.println(texto);
            }
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(cnome,"log",e);
        }
    }

    public static void logi(Object classeNome, Object funcaoNome){
        try {
            FuncoesBasicas.log("Inicio " + classeNome + "." + funcaoNome);
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(cnome,"log",e);
        }
    }

    public static void logf(Object classeNome, Object funcaoNome){
        try {
            FuncoesBasicas.log("Fim " + classeNome + "." + funcaoNome);
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(cnome,"log",e);
        }
    }

    public static void mostrarmsg(Object s) {
        try {
            mostrarmsg(s, Toast.LENGTH_SHORT);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    public static void mostrarmsg(final Object s,final int duracao) {
        try {
            if (s != null) {
                if (objs.variaveisBasicas.getActivityPrincipal() != null) {
                    objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast msg = Toast.makeText(objs.variaveisBasicas.getActivityPrincipal(), s.toString(), duracao);
                            msg.setDuration(duracao);
                            msg.show();
                        }
                    });
                } else {
                    Toast msg = Toast.makeText(contexto, s.toString(), duracao);
                    msg.setDuration(duracao);
                    msg.show();
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void gravarErro(String classeObjeto, String funcao, String mensagem, Exception erro) {
        try {
            String strTrace = "";
            String strClasseObjeto = classeObjeto;
            String strFuncao = funcao;
            String strMensagem = mensagem;
            if (erro != null) {
                Writer writer = new StringWriter();
                erro.printStackTrace(new PrintWriter(writer));
                strTrace = writer.toString();
                if (strClasseObjeto != null && strClasseObjeto.trim().length() > 0) {

                } else {
                    strClasseObjeto = erro.getStackTrace()[2].getClassName();
                }
                if (strFuncao != null && strFuncao.trim().length() > 0) {

                } else {
                    strFuncao = erro.getStackTrace()[2].getClassName();
                }

                if (strMensagem != null && strMensagem.trim().length() > 0) {
                    strMensagem += strMensagem + "-" + erro.getMessage();
                } else {
                    strMensagem = erro.getMessage();
                }
            }

            if (objs.sql.verificar_tabela_existe("erros")) {
                objs.sql.inserir(
                        "erros",
                        new ArrayList<String>(Arrays.asList(
                                "dataerro",
                                "classe",
                                "metodo",
                                "mensagem",
                                "trace"
                        )),
                        new ArrayList<String>(Arrays.asList(
                                objs.variaveisEstaticas.formatarDataAndroid.format(new Date()),
                                strClasseObjeto,
                                strFuncao,
                                strMensagem,
                                strTrace
                        ))
                );
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void mostrarErro(String classeObjeto, String funcao, Exception erro) {
        try {
            if (erro != null) {
                erro.printStackTrace();
                gravarErro(classeObjeto,funcao,null,erro);
                mostrarAlert("Ocorreu um Erro!" + "\n\n" +
                        "Local: " + classeObjeto + "." + funcao + "\n\n" +
                        "Mensagem: " + erro.getMessage());
            } else {
                mostrarAlert("Ocorreu um Erro!" + "\n\n" +
                        "Local: " + classeObjeto + "." + funcao);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void mostrarErro(Exception erro) {
        try {
            if (erro != null) {
                erro.printStackTrace();
                gravarErro(null,null,null,erro);
                mostrarAlert("Ocorreu um Erro!" + "\n\n" +
                        "Local: " + erro.getStackTrace()[2].getClassName() +"." + erro.getStackTrace()[2].getMethodName() + "\n\n" +
                        "Mensagem: " + erro.getMessage() );
            } else {
                mostrarAlert("Erro nulo");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void mostrarErro(Exception erro,String mensagem) {
        try {
            if (erro != null) {
                erro.printStackTrace();
                gravarErro(null,null,mensagem,erro);
                mostrarAlert("Ocorreu um Erro! " + "\n\n" +
                        "Local: " + erro.getStackTrace()[2].getClassName() + "." + erro.getStackTrace()[2].getMethodName() + "\n\n" +
                        "Mensagem: " + mensagem);
            } else {
                mostrarAlert("Erro nulo");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void mostrarErro(String classeObjeto, String funcao, String mensagem) {
        try {
            gravarErro(classeObjeto,funcao,mensagem,null);
            mostrarAlert("Ocorreu um Erro!" + "\n\n" +
                    "Local: " + classeObjeto + "." + funcao + "\n\n" +
                    "Mensagem: " + mensagem);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    public static CaixaAlertaDialogo mostrarAlert(String mensagem) {
        try {
            return mostrarAlert(null,mensagem,null,null);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public static CaixaAlertaDialogo mostrarAlert(String mensagem, boolean botoesVisiveis) {
        try {
            return mostrarAlert(null,mensagem,null,null,botoesVisiveis);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public static CaixaAlertaDialogo mostrarAlert(String titulo, String mensagem) {
        try {
            return mostrarAlert(titulo,mensagem,null,null);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
    public static CaixaAlertaDialogo mostrarAlert(String titulo, String mensagem, Method metodoDismiss, Object objetoDismiss) {
        try {
            return mostrarAlert(titulo, mensagem,metodoDismiss,objetoDismiss,true);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
    public static CaixaAlertaDialogo mostrarAlert(String titulo, String mensagem, Method metodoDismiss, Object objetoDismiss, boolean botoesVisiveis) {
        try {
            CaixaAlertaDialogo cx = null;
            if ((titulo != null && titulo.length() > 0) || (mensagem != null && mensagem.length() > 0)) {
                cx = new CaixaAlertaDialogo(contexto);
                if (titulo != null) {
                    cx.setTitulo(titulo);
                }
                cx.setMensagem(mensagem);
                if (metodoDismiss != null) {
                    cx.setEventoDismiss(metodoDismiss);
                }
                if (objetoDismiss != null) {
                    cx.setObjetoDismiss(objetoDismiss);
                }
                cx.setBotoesPadraoVisiveis(botoesVisiveis);
                cx.mostrar();
            }
            return cx;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public static void sair(){
        objs.variaveisBasicas.getActivityAtual().finish();
        System.exit(0);
    }

}

