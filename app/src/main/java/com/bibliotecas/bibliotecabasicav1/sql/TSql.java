package com.bibliotecas.bibliotecabasicav1.sql;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;
import android.text.TextUtils;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisNomesSql;

import org.json.JSONArray;
import org.json.JSONObject;

import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.Arrays;

public class TSql extends SQLiteOpenHelper {
    private static String cnome = "TSql";
    public static final String DATABASE_NAME = "SisJD";
    public static final int DATABASE_VERSION = 1;
    protected ObjetosBasicos objs = null;
    public SQLiteDatabase db;
    public boolean checarTabelaExiste = true;
    public int limite_tentativas = 5;
    protected Context contexto = null;

    public TSql(Context pContexto) {
        super(pContexto, DATABASE_NAME, null, DATABASE_VERSION);
        try {
            String fnome = "TSql";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logi(cnome,fnome);
            this.db = this.getWritableDatabase();
            objs.variaveisBasicas.adicionarObjeto(this);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        try {
            String fnome = "onCreate";
            objs.funcoesBasicas.logi(cnome,fnome);
            verificacoes_iniciais();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        try {
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void verificacoes_iniciais() {
        try {
            String fnome = "verificacoes_iniciais";
            objs.funcoesBasicas.logi(cnome,fnome);

            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public boolean verificar_tabela_existe(String nome) {
        try {
            Boolean retorno = false;
            String cmd_sql = "SELECT name FROM sqlite_master WHERE lower(type)='table' and lower(name) = lower('" + nome + "')";
            Cursor dados = null;
            if (db != null) {
                dados = db.rawQuery(
                        cmd_sql, null
                );
            }
            if (dados != null && dados.moveToFirst()) {
                retorno = true;
            }
            objs.funcoesDados.fecharCursor(dados);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> montar_comando_sql_criar_tabelas(ArrayList<ArrayList<String>> linhas){
        try {
            String fnome = "montar_comando_sql_criar_tabelas";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> retorno = new Tipos.TCnjChaveValor<Tipos.TChaveValor<String>>();

            String nomeTabela = "";
            Tipos.TCnjChaveValor tabelas = new Tipos.TCnjChaveValor();
            /*
                estrutrua de uma linha:
                0 - codtabela
                1 - nometabela
                2 - codcampo
                3 - nomecampo
                4 - nomecampovisivel
                5 - aliascampo
                6 - tipodado
                7 - parametros
             */
            Tipos.TChaveValor<ArrayList> tabela = null;
            for(ArrayList linha : linhas) {

                objs.funcoesBasicas.log(linha);
                nomeTabela = linha.get(1).toString();
                tabela = tabelas.procurar(nomeTabela);
                if (tabela == null) {
                    tabela = new Tipos.TChaveValor<ArrayList>(nomeTabela, new ArrayList());
                    tabelas.add(tabela);
                }
                tabela.valor.add(linha);
            }
            String textosql = "";
            for (int i = 0; i < tabelas.size(); i++) {
                tabela = (Tipos.TChaveValor<ArrayList>) tabelas.get(i);
                textosql = "Create TABLE if not exists " + tabela.chave + "(";
                ArrayList<String> textosCampos = new ArrayList<String>();
                ArrayList linha = null;
                for (int j = 0; j < tabela.valor.size(); j ++) {
                    linha = (ArrayList) tabela.valor.get(j);
                    textosCampos.add(linha.get(3).toString() + " " + linha.get(6).toString() + " " + linha.get(7).toString());
                }
                textosql += textosCampos.toString().replace("[","").replace("]","");
                textosql += ")";
                retorno.add(new Tipos.TChaveValor<String>(tabela.chave,textosql));
                objs.funcoesBasicas.log(textosql);
            }

            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> montar_comando_sql_criar_tabelas(JSONArray linhas){
        try {
            String fnome = "montar_comando_sql_criar_tabelas";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> retorno = new Tipos.TCnjChaveValor<Tipos.TChaveValor<String>>();

            String nomeTabela = "";
            Tipos.TCnjChaveValor tabelas = new Tipos.TCnjChaveValor();
            /*
                estrutrua de uma linha:
                0 - codtabela
                1 - nometabela
                2 - codcampo
                3 - nomecampo
                4 - nomecampovisivel
                5 - aliascampo
                6 - tipodado
                7 - parametros
             */
            Tipos.TChaveValor<ArrayList> tabela = null;
            int qt = linhas.length();
            if (qt > 0) {
                JSONArray linha = null;
                for (int i = 0; i < qt; i++) {
                    linha = linhas.getJSONArray(i);
                    objs.funcoesBasicas.log(linha);
                    nomeTabela = linha.get(1).toString();
                    tabela = tabelas.procurar(nomeTabela);
                    if (tabela == null) {
                        tabela = new Tipos.TChaveValor<ArrayList>(nomeTabela, new ArrayList());
                        tabelas.add(tabela);
                    }
                    tabela.valor.add(linha);
                }
                String textosql = "";
                qt = tabelas.size();
                JSONArray linhaCampo = null;
                for (int i = 0; i < qt ; i++) {
                    tabela = (Tipos.TChaveValor<ArrayList>) tabelas.get(i);
                    textosql = "Create TABLE if not exists " + tabela.chave + "(";
                    ArrayList<String> textosCampos = new ArrayList<String>();
                    for (int j = 0; j < tabela.valor.size(); j++) {
                        linhaCampo = (JSONArray) tabela.valor.get(j);
                        textosCampos.add(linhaCampo.getString(3) + " " + linhaCampo.getString(6) + " " + linhaCampo.getString(7));
                    }
                    textosql += textosCampos.toString().replace("[", "").replace("]", "");
                    textosql += ")";
                    retorno.add(new Tipos.TChaveValor<String>(tabela.chave, textosql));
                    objs.funcoesBasicas.log(textosql);
                }
            }

            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void criartabelas(SQLiteDatabase db) {
        try {
            criartabelas(db,false);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public String montar_texto_sql_campodb(Cursor campodb) {
        try {
            String retorno = null;
            if (campodb != null) {
                retorno =
                        campodb.getString(campodb.getColumnIndex("nomecampodb")) + " " +
                                campodb.getString(campodb.getColumnIndex("tipodado")) + " " +
                                campodb.getString(campodb.getColumnIndex("parametros"));

            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void criartabelas(SQLiteDatabase db, Boolean sobrescrever){
        try {
            String fnome = "criartabelas";
            objs.funcoesBasicas.logi(cnome,fnome);
            String textosql = "";
            Cursor dados = executar_processo_db("lista_tabeladb_view_consultar_tabelas","");
            Cursor campos = null;
            if (dados != null && dados.moveToFirst()) {
                String nometabeladb = null;
                String codtabeladb = null;
                ArrayList<String> textosSqlCampos = null;
                do {
                    nometabeladb = dados.getString(dados.getColumnIndex("nometabeladb"));
                    if (nometabeladb != null) {
                        if (!nometabeladb.trim().equalsIgnoreCase("tabeladb") && !nometabeladb.trim().equalsIgnoreCase("campodb")
                                && !nometabeladb.trim().equalsIgnoreCase("processos") && !nometabeladb.trim().equalsIgnoreCase("comandossql")) {
                            codtabeladb = dados.getString(dados.getColumnIndex("codtabeladb"));
                            textosql = "Drop table if exists " + nometabeladb;
                            objs.funcoesBasicas.log("EXCLUINDO TABELA: " + nometabeladb);
                            this.db.execSQL(textosql);
                            textosql = "Create TABLE if not exists " + nometabeladb + "(";
                            textosSqlCampos = new ArrayList<String>();
                            campos = executar_processo_db("lista_campodb"," where codtabeladb=" + codtabeladb);
                            if (campos != null && campos.moveToFirst()) {
                                do {
                                    textosSqlCampos.add(this.montar_texto_sql_campodb(campos));
                                } while (campos.moveToNext());
                            }
                            textosql += textosSqlCampos.toString().replace("[", "").replace("]", "");
                            textosql += ")";
                            objs.funcoesBasicas.log("CRIANDO TABELA: " + textosql);
                            this.db.execSQL(textosql);
                        }
                    }
                } while (dados.moveToNext());
                objs.funcoesDados.fecharCursor(dados);
                objs.funcoesDados.fecharCursor(campos);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void limparTabelas(SQLiteDatabase db){
        try {
            String fnome = "limparTabelas";
            objs.funcoesBasicas.logi(cnome,fnome);
            ArrayList<String> campos ;
            Cursor dados = executar_processo_db("lista_tabeladb_view_consultar_tabelas","");
            if (dados != null && dados.moveToFirst()) {
                String nometabeladb = null;
                do {
                    nometabeladb = dados.getString(dados.getColumnIndex("nometabeladb"));
                    if (nometabeladb != null && !nometabeladb.equalsIgnoreCase("tabeladb")) {
                        objs.funcoesBasicas.log("LIMPANDO TABELA: " + nometabeladb);
                        db.delete(nometabeladb, null, null);
                        objs.funcoesBasicas.log("LIMPANDO TABELA: " + nometabeladb + " OK");
                    }
                } while (dados.moveToNext());
                nometabeladb = "tabeladb";
                objs.funcoesBasicas.log("LIMPANDO TABELA: " + nometabeladb);
                db.delete(nometabeladb, null, null);
                objs.funcoesBasicas.log("LIMPANDO TABELA: " + nometabeladb + " OK");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void criar_tabela(String nomeTab) {
        try {
            criar_tabela(nomeTab,false);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public void criar_tabela(String nomeTab, Boolean sobrescrever) {
        try {
            String fnome = "criar_tabela";
            objs.funcoesBasicas.logi(cnome,fnome);
            Tipos.TChaveValor<VariaveisNomesSql.TSqlDB.TSqlTabela> tabela = objs.variaveisNomesSql.sisdb.tabelas.procurar(nomeTab);
            String textosql = "";
            ArrayList<String> campos ;
            if (tabela != null) {
                if (tabela.valor.sobrescrever == true || sobrescrever == true) {
                    textosql = "Drop table if exists " + tabela.valor.nome;
                    objs.funcoesBasicas.log("EXCLUINDO TABELA: " + textosql);
                    this.db.execSQL(textosql);
                }
                textosql = "Create TABLE if not exists " + tabela.valor.nome + "(";
                campos = new ArrayList<String>();
                for (VariaveisNomesSql.TSqlDB.TSqlTabela.TSqlTabCampo campo : tabela.valor.campos){
                    campos.add(campo.nome + " " + campo.tipo + " " + campo.parametros);
                }
                textosql += campos.toString().replace("[","").replace("]","");
                textosql += ")";
                objs.funcoesBasicas.log("CRIANDO TABELA: " + textosql);
                this.db.execSQL(textosql);
                this.inserirOuAtualizar(
                        "tabelas",
                        "codtabela",
                        tabela.valor.codtabela.toString(),
                        new ArrayList<String>(Arrays.asList(
                                "nome"
                        )),
                        new ArrayList<String>(Arrays.asList(
                                tabela.valor.nome.toString()
                        ))
                );
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void criartabelas(Tipos.TCnjChaveValor<Tipos.TChaveValor<String>> cnjComandos){
        try {
            String fnome = "criartabelas";
            objs.funcoesBasicas.logi(cnome,fnome);
            String textosql = "";
            for(Tipos.TChaveValor<String> tabela : cnjComandos) {
                textosql = "Drop table if exists " + tabela.chave;
                objs.funcoesBasicas.log("EXCLUINDO TABELA: " + textosql);
                this.db.execSQL(textosql);
                textosql = tabela.valor;
                objs.funcoesBasicas.log("CRIANDO TABELA: " + textosql);
                this.db.execSQL(textosql);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void atualizar(String nomeTab, String campo, String valores,String condicoes,String[] valoresCondicoes) {
        try {
            atualizar(nomeTab,new ArrayList<String>(Arrays.asList(campo)), new ArrayList<String>(Arrays.asList(valores)),condicoes,valoresCondicoes);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void atualizar(String nomeTab,  ArrayList<String> campos, ArrayList<String> valores, String condicoes, String[] valoresCondicoes) {
        try {
            ContentValues cnjvalores = new ContentValues();
            if (nomeTab != null && nomeTab.trim().length() > 0) {
                int qt = campos.size();
                for (int i = 0; i < qt; i++) {
                    cnjvalores.put(campos.get(i), valores.get(i));
                }
                if (verificar_tabela_existe(nomeTab) == false) {
                    objs.funcoesBasicas.log("tabela " + nomeTab + " nao existe, criando");
                    criar_tabela(nomeTab);
                }
                int rows = db.update(nomeTab, cnjvalores, condicoes, valoresCondicoes);
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public ContentValues formarContentValues(ArrayList<String> campos, ArrayList<String> valores) {
        try {
            ContentValues retorno = null;
            if (campos != null) {
                int qt = campos.size();
                if (qt != valores.size()) {
                    throw new Exception("quantidade de campos diferente da quantidade de valores: " + String.valueOf(qt) + "<>" + valores.size());
                }
                retorno = new ContentValues();
                for (int i = 0; i < qt; i++) {
                    retorno.put(campos.get(i), valores.get(i));
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void inserir(String nomeTab,  ArrayList<String> campos, ArrayList<String> valores) {
        try {
            inserir(nomeTab,  campos,valores, 0);
        } catch (Exception e2) {
            objs.funcoesBasicas.mostrarErro(e2);
        }
    }

    public void inserir(String nomeTab,  ArrayList<String> campos, ArrayList<String> valores, int tentativa) {
        try {
            String fnome = "inserir";
            int i = 0;
            int qt = 0;
            ContentValues cnjvalores = formarContentValues(campos,valores);
            if (verificar_tabela_existe(nomeTab) == false) {
                objs.funcoesBasicas.log("tabela " + nomeTab + " nao existe, criando");
                criar_tabela(nomeTab);
            }
            db.insert(nomeTab, null, cnjvalores);
        } catch (SQLiteException e) {
            String erroTabelaNaoExiste = "no such table";
            String erroColunaNaoExiste = "no such column";
            objs.funcoesBasicas.log("tentativa: " + tentativa + " erro " + e.getMessage());
            String msg = e.getMessage().toLowerCase().trim();
            if (msg.contains(erroTabelaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    int pi = msg.indexOf(erroTabelaNaoExiste) + erroTabelaNaoExiste.length() + 1;
                    int pf = msg.indexOf("(", pi) - 1;
                    String tabela = msg.substring(pi, pf).toLowerCase().trim();
                    objs.funcoesBasicas.log(tabela, erroTabelaNaoExiste, msg, pi, pf);
                    this.criar_tabela(tabela, true);
                    tentativa = tentativa + 1;
                    inserir(nomeTab,  campos,valores, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else if (msg.contains(erroColunaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    this.criar_tabela(nomeTab,true);
                    tentativa = tentativa + 1;
                    inserir(nomeTab,  campos,valores, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else {
                e.printStackTrace();
                objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void inserirOuAtualizar(String nomeTab, String campoPrimaryKey, String valorPrimaryKey, ArrayList<String> demaisCampos, ArrayList<String> demaisValores) {
        try {
            inserirOuAtualizar(nomeTab, campoPrimaryKey, valorPrimaryKey,demaisCampos,demaisValores, 0);
        } catch (Exception e2) {
            objs.funcoesBasicas.mostrarErro(e2);
        }
    }

    public void inserirOuAtualizar(String nomeTab, String campoPrimaryKey, String valorPrimaryKey, ArrayList<String> demaisCampos, ArrayList<String> demaisValores, int tentativa) {
        try {
            String fnome = "inserirOuAtualizar";
            int i = 0;
            int qt = 0;
            ContentValues cnjvalores = formarContentValues(demaisCampos,demaisValores);
            if (verificar_tabela_existe(nomeTab) == false) {
                objs.funcoesBasicas.log("tabela " + nomeTab + " nao existe, criando");
                criar_tabela(nomeTab);
            }
            objs.funcoesBasicas.log("atualizando tabela " + nomeTab + ": " + campoPrimaryKey + "=" + valorPrimaryKey);
            valorPrimaryKey = valorPrimaryKey.replaceAll("'","");
            int rows = db.update(nomeTab, cnjvalores, campoPrimaryKey + " = ?", new String[]{valorPrimaryKey});
            if (rows == 0) {
                objs.funcoesBasicas.log("nao atualizou, registro nao existe, tentando inserir");
                //put sobrescreve se ja existir ou cria se nao existir
                cnjvalores.put(campoPrimaryKey, valorPrimaryKey);
                db.insert(nomeTab, null, cnjvalores);
            }
        } catch (SQLiteException e) {
            String erroTabelaNaoExiste = "no such table";
            String erroColunaNaoExiste = "no such column";
            objs.funcoesBasicas.log("tentativa: " + tentativa + " erro " + e.getMessage());
            String msg = e.getMessage().toLowerCase().trim();
            if (msg.contains(erroTabelaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    int pi = msg.indexOf(erroTabelaNaoExiste) + erroTabelaNaoExiste.length() + 1;
                    int pf = msg.indexOf("(", pi) - 1;
                    String tabela = msg.substring(pi, pf).toLowerCase().trim();
                    objs.funcoesBasicas.log(tabela, erroTabelaNaoExiste, msg, pi, pf);
                    this.criar_tabela(tabela, true);
                    tentativa = tentativa + 1;
                    inserirOuAtualizar(nomeTab, campoPrimaryKey, valorPrimaryKey,demaisCampos,demaisValores, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else if (msg.contains(erroColunaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    this.criar_tabela(nomeTab,true);
                    tentativa = tentativa + 1;
                    inserirOuAtualizar(nomeTab, campoPrimaryKey, valorPrimaryKey,demaisCampos,demaisValores, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else {
                e.printStackTrace();
                objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public ArrayList<String> obter_nomes_tabelas_comando_sql(String comando_sql) {
        try {
            ArrayList<String> retorno = null;
            ArrayList<String> froms = new ArrayList<String>(Arrays.asList(TextUtils.split(comando_sql," from ")));
            ArrayList<String> cnjTabelasJoin = null;
            ArrayList<String> cnjTabelasJoin2 = null;
            ArrayList<String> cnjNomesTabelas = new ArrayList<String>();
            String textoTabelasJoin = null;
            String textoNomeTabela = null;
            int qt = froms.size();
            int qt2 = 0;
            if (qt > 0) {
                String textoFrom = null;
                for (int i = 1; i < qt; i = i + 2) {
                    if (i < qt) {
                        textoFrom = froms.get(i);
                        cnjTabelasJoin = new ArrayList<String>(Arrays.asList(TextUtils.split(textoFrom, " where ")));
                        textoTabelasJoin = cnjTabelasJoin.get(0);
                        cnjTabelasJoin2 = new ArrayList<String>(Arrays.asList(TextUtils.split(textoTabelasJoin, " join ")));
                        qt2 = cnjTabelasJoin2.size();
                        for (int j = 0; j < qt2; j++) {
                            textoNomeTabela = cnjTabelasJoin2.get(j);
                            textoNomeTabela = textoNomeTabela.toLowerCase().trim();
                            if (textoNomeTabela.length() > 0) {
                                if (textoNomeTabela.indexOf(" ") > -1) {
                                    textoNomeTabela = textoNomeTabela.substring(0, textoNomeTabela.indexOf(" ")).trim();
                                }
                                if (cnjNomesTabelas.indexOf(textoNomeTabela) == -1) {
                                    cnjNomesTabelas.add(textoNomeTabela);
                                }
                            }
                        }
                    }
                }
            }
            if (cnjNomesTabelas.size() > 0) {
                retorno = cnjNomesTabelas;
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public Cursor executarSql(String comando_sql){
        try {
            return executarSql(comando_sql,0);
        } catch (Exception e2) {
            objs.funcoesBasicas.mostrarErro(e2);
            return null;
        }
    }

    public Cursor executarSql(String comando_sql, int tentativa){
        try {
            String fnome = "executarSql";
            Cursor retorno = null;
            retorno = db.rawQuery(
                    comando_sql, null
            );
            return retorno;
        } catch (SQLiteException e) {
            String erroTabelaNaoExiste = "no such table";
            String erroColunaNaoExiste = "no such column";
            objs.funcoesBasicas.log("tentativa: " + tentativa + " erro " + e.getMessage());
            String msg = e.getMessage().toLowerCase().trim();
            if (msg.contains(erroTabelaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    int pi = msg.indexOf(erroTabelaNaoExiste) + erroTabelaNaoExiste.length() + 1;
                    int pf = msg.indexOf("(", pi) - 1;
                    String tabela = msg.substring(pi, pf).toLowerCase().trim();
                    objs.funcoesBasicas.log(tabela, erroTabelaNaoExiste, msg, pi, pf);
                    this.criar_tabela(tabela, true);
                    tentativa = tentativa + 1;
                    return executarSql(comando_sql, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else if (msg.contains(erroColunaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    ArrayList<String> cnjNomesTabelas = this.obter_nomes_tabelas_comando_sql(comando_sql);
                    objs.funcoesBasicas.log("tabelas:" + TextUtils.join(",",cnjNomesTabelas));
                    if (cnjNomesTabelas != null && cnjNomesTabelas.size() > 0) {
                        int qt = cnjNomesTabelas.size();
                        for(int i = 0; i < qt; i++) {
                            this.criar_tabela(cnjNomesTabelas.get(i),true);
                        }
                        tentativa = tentativa + 1;
                        return executarSql(comando_sql, tentativa);
                    } else {
                        e.printStackTrace();
                        objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                    }
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else {
                e.printStackTrace();
                objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
            }
            return null;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public int deletar(String nomeTab,String whereClause, String[] whereArgs){
        try {
            return deletar(nomeTab,whereClause,whereArgs,0);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public int deletar(String nomeTab,String whereClause, String[] whereArgs, int tentativa){
        try {
            String fnome = "deletar";
            int retorno = 0;
            retorno = db.delete(nomeTab,whereClause, whereArgs);
            return retorno;
        } catch (SQLiteException e) {
            String erroTabelaNaoExiste = "no such table";
            String erroColunaNaoExiste = "no such column";
            String msg = e.getMessage().toLowerCase().trim();
            if (msg.contains(erroTabelaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    int pi = msg.indexOf(erroTabelaNaoExiste) + erroTabelaNaoExiste.length() + 1;
                    int pf = msg.indexOf("(", pi) - 1;
                    String tabela = msg.substring(pi, pf).toLowerCase().trim();
                    objs.funcoesBasicas.log(tabela, erroTabelaNaoExiste, msg, pi, pf);
                    this.criar_tabela(tabela, true);
                    tentativa = tentativa + 1;
                    return deletar(nomeTab,whereClause,whereArgs, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else if (msg.contains(erroColunaNaoExiste)) {
                if (tentativa < this.limite_tentativas) {
                    this.criar_tabela(nomeTab, true);
                    tentativa = tentativa + 1;
                    return deletar(nomeTab,whereClause,whereArgs, tentativa);
                } else {
                    e.printStackTrace();
                    objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
                }
            } else {
                e.printStackTrace();
                objs.funcoesBasicas.mostrarAlert("Sem dados locais. \nÉ necessário pelo menos uma consulta online ou sincronização para ter dados locais! \nSe o problema persistir tente desinstalar o aplicativo e reinstalar.");
            }
            return 0;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public Cursor executarSql(String nomeTab, String[] campos, String camposcriterio, String[] valorescriterio){
        try {
            Cursor retorno = null;
            if (checarTabelaExiste == true) {
                if (verificar_tabela_existe(nomeTab) == false) {
                    criar_tabela(nomeTab);
                }
            }
            try {
                retorno = db.query(
                        nomeTab,
                        campos,
                        camposcriterio,
                        valorescriterio,
                        null,
                        null,
                        null,
                        null
                );
            } catch (Exception e) {
                criar_tabela(nomeTab,true);
                retorno = db.query(
                        nomeTab,
                        campos,
                        camposcriterio,
                        valorescriterio,
                        null,
                        null,
                        null,
                        null
                );
            }
            return retorno;
        } catch (SQLiteException e) {
            e.printStackTrace();
            objs.funcoesBasicas.mostrarErro(e,"sem dados locais. É necessário pelo menos uma consulta online ou sincronização para ter dados locais!");
            return null;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public ArrayList<ArrayList<String>> dados_para_array(Cursor dados) {
        try {
            String fnome = "dados_para_array";
            objs.funcoesBasicas.logi(cnome,fnome);
            ArrayList<ArrayList<String>> retorno = null;
            if (dados != null && dados.moveToFirst()) {
                retorno = new ArrayList<ArrayList<String>>();
                ArrayList<String> linha = null;
                int qtCol = dados.getColumnCount();
                int i = 0;
                do {
                    linha = new ArrayList<String>();
                    for (i = 0 ; i < qtCol; i++) {
                        linha.add(dados.getString(i));
                    }
                    retorno.add(linha);
                } while (dados.moveToNext());
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            objs.funcoesDados.fecharCursor(dados);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public JSONArray dados_para_jsonarray(Cursor dados) {
        try {
            String fnome = "dados_para_jsonarray";
            objs.funcoesBasicas.logi(cnome,fnome);
            JSONArray retorno = null;
            if (dados != null && dados.moveToFirst()) {
                retorno = new JSONArray();
                JSONArray linha = null;
                int qtCol = dados.getColumnCount();
                int i = 0;
                do {
                    linha = new JSONArray();
                    for (i = 0 ; i < qtCol; i++) {
                        linha.put(dados.getString(i));
                    }
                    retorno.put(linha);
                } while (dados.moveToNext());
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            objs.funcoesDados.fecharCursor(dados);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void executar_processo_db(String nomeProcessoDB, JSONObject dados, Object objetoLog, Method metodoLog) {
        Cursor dadosProcesso = null;
        Cursor dadosComando = null;
        try {
            String fnome = "executar_processo_db";
            objs.funcoesBasicas.logi(cnome,fnome);
            String comando_sql = "select codprocesso from processos where lower(nomeprocesso) = lower('"+nomeProcessoDB+"')";
            objs.funcoesBasicas.log("procurando pelo processo: " + comando_sql);
            dadosProcesso = objs.sql.executarSql(comando_sql);
            if (dadosProcesso != null && dadosProcesso.moveToFirst()) {
                objs.funcoesBasicas.log("processo encontrado");
                String codProcesso = dadosProcesso.getString(0);
                comando_sql = "select * from comandossql where codprocesso = " + codProcesso ;
                objs.funcoesBasicas.log("procurando pelo comandosql: " + comando_sql);
                dadosComando = objs.sql.executarSql(comando_sql);
                if (dadosComando.moveToFirst()) {
                    objs.funcoesBasicas.log("comandosql encontrado");
                    ArrayList<String> camposComando = new ArrayList<String>(Arrays.asList(dadosComando.getColumnNames()));
                    int indCampo = -1;
                    indCampo = camposComando.indexOf("tipocomando");
                    String tipoComando = dadosComando.getString(indCampo);
                    tipoComando = tipoComando.trim().toLowerCase();
                    objs.funcoesBasicas.log("tipocomando: " + tipoComando);
                    objs.funcoesBasicas.log(tipoComando.equalsIgnoreCase("insert"));
                    if (tipoComando.equalsIgnoreCase("insert")) {
                        objs.funcoesBasicas.log("entrou na opcao insert");
                        indCampo = camposComando.indexOf("tabelas");
                        String nomesTabelas = dadosComando.getString(indCampo).trim().toLowerCase();
                        indCampo = camposComando.indexOf("aliasescamposunique");
                        String aliasesCamposUnique = dadosComando.getString(indCampo).trim().toLowerCase();
                        indCampo = camposComando.indexOf("aliasescamposresultantes");
                        String aliasescamposresultantes = dadosComando.getString(indCampo).trim().toLowerCase();
                        ArrayList<String> camposResultantes = new ArrayList<String>(Arrays.asList(aliasescamposresultantes.split(",")));
                        ArrayList<String> valores = new ArrayList<String>();
                        int qtCamposResultantes = camposResultantes.size();

                        if (dados.has("tabela") && dados.get("tabela") instanceof JSONObject) {
                            objs.funcoesBasicas.log("tabela tem mais de uma linha");
                            /*trasnforma o jsonarray de titulos arr_tit em um ArrayList e obtem seus indices em relacao aos dados*/
                            JSONArray titulos = dados.getJSONObject("tabela").getJSONObject("titulo").getJSONArray("arr_tit");
                            int qtTitulos = titulos.length();
                            String[] cnjTitulosTemp = new String[qtTitulos];
                            JSONObject titulo = null;
                            for (int i = 0; i < qtTitulos; i++) {
                                titulo = titulos.getJSONObject(i);
                                cnjTitulosTemp[titulo.getInt("indexreal")] = titulo.getString("valor").trim().toLowerCase();
                            }
                            ArrayList<String> cnjTitulos = new ArrayList<String>();
                            for(String tit : cnjTitulosTemp) {
                                cnjTitulos.add(tit);
                            }
                            objs.funcoesBasicas.log("titulos: " + cnjTitulos.toString());
                            int indCampoTemp = -1;
                            int[] indicesCampos = new int[qtCamposResultantes];
                            for (int i = 0; i < qtCamposResultantes; i++) {
                                indCampoTemp = cnjTitulos.indexOf(camposResultantes.get(i).trim().toLowerCase());
                                if (indCampoTemp > -1) {
                                    indicesCampos[i] = indCampoTemp;
                                } else {
                                    throw new Exception("campo do comando sql nao existe nos dados: " + camposResultantes.get(i).trim().toLowerCase() + "(" + camposResultantes.toString() + ")");
                                }
                            }


                            JSONArray linhas = dados.getJSONObject("tabela").getJSONArray("dados");
                            int qtLinhas = linhas.length();
                            objs.funcoesBasicas.log("qtlinhas: " + qtLinhas);
                            JSONArray linha = null;

                            /*repassa cada linha do resultado*/
                            for (int j = 0; j < qtLinhas; j++) {
                                objs.funcoesBasicas.log("passando linha " + j);
                                valores = new ArrayList<String>();
                                linha = linhas.getJSONArray(j);
                                for (int i = 0; i < qtCamposResultantes; i++) {
                                    valores.add(linha.getString(indicesCampos[i]));
                                }

                                String valorUnique = null;
                                indCampoTemp = cnjTitulos.indexOf(aliasesCamposUnique.trim().toLowerCase());
                                if (indCampoTemp > -1) {
                                    valorUnique = linha.getString(indCampoTemp);
                                } else {
                                    throw new Exception("campo do comando sql unique nao existe nos dados: " + aliasesCamposUnique + "(" + camposResultantes.toString() + ")");
                                }
                                objs.funcoesBasicas.log("atualizando " + nomesTabelas + " " + aliasesCamposUnique + "=" + valorUnique);
                                if (objetoLog != null && metodoLog != null) {
                                    metodoLog.invoke(objetoLog,"atualizando " + nomesTabelas + " " + aliasesCamposUnique + "=" + valorUnique);
                                }
                                this.objs.sql.inserirOuAtualizar(
                                        nomesTabelas,
                                        aliasesCamposUnique,
                                        valorUnique,
                                        camposResultantes,
                                        valores);
                            }

                        } else {
                            objs.funcoesBasicas.log("tabela so tem uma linha");
                            for (int i = 0; i < qtCamposResultantes; i++) {
                                if (dados.has(camposResultantes.get(i).trim().toUpperCase())) {
                                    valores.add(dados.getString(camposResultantes.get(i).trim().toUpperCase()));
                                } else {
                                    throw new Exception("campo do comando sql nao existe nos dados: " + camposResultantes.get(i).trim().toUpperCase() + "(" + camposResultantes.toString() + ")");
                                }
                            }

                            String valorUnique = null;
                            if (dados.has(aliasesCamposUnique)) {
                                valorUnique = dados.getString(aliasesCamposUnique);
                            } else if (dados.has(aliasesCamposUnique.trim().toLowerCase())) {
                                valorUnique = dados.getString(aliasesCamposUnique.trim().toLowerCase());
                            } else if (dados.has(aliasesCamposUnique.trim().toUpperCase())) {
                                valorUnique = dados.getString(aliasesCamposUnique.trim().toUpperCase());
                            } else {
                                throw new Exception("campo do comando sql unique nao existe nos dados: " + aliasesCamposUnique + "(" + camposResultantes.toString() + ")");
                            }

                            this.objs.sql.inserirOuAtualizar(
                                    nomesTabelas,
                                    aliasesCamposUnique,
                                    valorUnique,
                                    camposResultantes,
                                    valores);
                        }
                    } else {
                        throw new Exception("tipo de comando nao esperado: " + tipoComando);
                    }
                } else {
                    throw new Exception("comandosql nao encontrado: " + comando_sql);
                }
            } else {
                throw new Exception("processo nao encontrado: " + comando_sql);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        } finally {
            objs.funcoesDados.fecharCursor(dadosProcesso);
            objs.funcoesDados.fecharCursor(dadosComando);
        }
    }

    /*
     * Overload da funcao que se utilizada, tem que ter especial atenção a ORDEM dos dados no jsonarray dados, que
     * pode ser unidimensional (uma linha) ou multidimencional ([[]]) varias linhas, de forma que SEMPRE cada linha
     * deve conter o numero de elementos indicados no comandosql do processo passado como parametro e ainda o primeiro
     * detes campos de cada linha deve ser o dado que representa o campo valor unique da tabela ou primary key
     * */
    public void executar_processo_db(String nomeProcessoDB, JSONArray dados, Object objetoLog, Method metodoLog) {
        Cursor dadosProcesso = null;
        Cursor dadosComando = null;
        try {
            String fnome = "executar_processo_db";
            objs.funcoesBasicas.logi(cnome,fnome);
            String comando_sql = "select codprocesso from processos where lower(nomeprocesso) = lower('"+nomeProcessoDB+"')";
            objs.funcoesBasicas.log("procurando pelo processo: " + comando_sql);
            dadosProcesso = objs.sql.executarSql(comando_sql);
            if (dadosProcesso != null && dadosProcesso.moveToFirst()) {
                objs.funcoesBasicas.log("processo encontrado");
                String codProcesso = dadosProcesso.getString(0);
                comando_sql = "select * from comandossql where codprocesso = " + codProcesso ;
                objs.funcoesBasicas.log("procurando pelo comandosql: " + comando_sql);
                dadosComando = objs.sql.executarSql(comando_sql);
                if (dadosComando.moveToFirst()) {
                    objs.funcoesBasicas.log("comandosql encontrado");
                    ArrayList<String> camposComando = new ArrayList<String>(Arrays.asList(dadosComando.getColumnNames()));
                    int indCampo = -1;
                    indCampo = camposComando.indexOf("tipocomando");
                    String tipoComando = dadosComando.getString(indCampo);
                    tipoComando = tipoComando.trim().toLowerCase();
                    objs.funcoesBasicas.log("tipocomando: " + tipoComando);
                    objs.funcoesBasicas.log(tipoComando.equalsIgnoreCase("insert"));
                    if (tipoComando.equalsIgnoreCase("insert")) {
                        objs.funcoesBasicas.log("entrou na opcao insert");
                        indCampo = camposComando.indexOf("tabelas");
                        String nomesTabelas = dadosComando.getString(indCampo).trim().toLowerCase();
                        indCampo = camposComando.indexOf("aliasescamposunique");
                        String aliasesCamposUnique = dadosComando.getString(indCampo).trim().toLowerCase();
                        indCampo = camposComando.indexOf("aliasescamposresultantes");
                        String aliasescamposresultantes = dadosComando.getString(indCampo).trim().toLowerCase();
                        ArrayList<String> camposResultantes = new ArrayList<String>(Arrays.asList(aliasescamposresultantes.split(",")));
                        ArrayList<String> valores = new ArrayList<String>();
                        int qtCamposResultantes = camposResultantes.size();
                        if (dados.length() > 0) {
                            if (dados.get(0) instanceof JSONArray) {
                                objs.funcoesBasicas.log("tabela tem mais de uma linha");
                                JSONArray linhas = dados; //.getJSONObject("tabela").getJSONArray("dados");
                                int qtLinhas = linhas.length();
                                objs.funcoesBasicas.log("qtlinhas: " + qtLinhas);
                                JSONArray linha = null;

                                /*repassa cada linha do resultado*/
                                for (int j = 0; j < qtLinhas; j++) {
                                    objs.funcoesBasicas.log("passando linha " + j);
                                    valores = new ArrayList<String>();
                                    linha = linhas.getJSONArray(j);
                                    for (int i = 0; i < qtCamposResultantes; i++) {
                                        valores.add(linha.getString(i));
                                    }
                                    String valorUnique = linha.getString(0);
                                    objs.funcoesBasicas.log("atualizando " + nomesTabelas + " " + aliasesCamposUnique + "=" + valorUnique);
                                    if (objetoLog != null && metodoLog != null) {
                                        metodoLog.invoke(objetoLog, "atualizando " + nomesTabelas + " " + aliasesCamposUnique + "=" + valorUnique);
                                    }
                                    this.objs.sql.inserirOuAtualizar(
                                            nomesTabelas,
                                            aliasesCamposUnique,
                                            valorUnique,
                                            camposResultantes,
                                            valores);
                                }

                            } else {
                                objs.funcoesBasicas.log("tabela so tem uma linha");
                                for (int i = 0; i < qtCamposResultantes; i++) {
                                    valores.add(dados.getString(i));
                                }
                                String valorUnique = dados.getString(0);
                                this.objs.sql.inserirOuAtualizar(
                                        nomesTabelas,
                                        aliasesCamposUnique,
                                        valorUnique,
                                        camposResultantes,
                                        valores);
                            }
                        }
                    } else {
                        throw new Exception("tipo de comando nao esperado: " + tipoComando);
                    }
                } else {
                    throw new Exception("comandosql nao encontrado: " + comando_sql);
                }
            } else {
                throw new Exception("processo nao encontrado: " + comando_sql);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        } finally {
            objs.funcoesDados.fecharCursor(dadosProcesso);
            objs.funcoesDados.fecharCursor(dadosComando);
        }
    }

    public Cursor executar_processo_db(String nomeProcessoDB, String condicionantes) {
        Cursor dadosProcesso = null;
        Cursor dadosComando = null;
        Cursor dadosRetorno = null;
        try {
            String fnome = "executar_processo_db";
            objs.funcoesBasicas.logi(cnome,fnome);
            String comando_sql = "select codprocesso from processos where lower(nomeprocesso) = lower('"+nomeProcessoDB+"')";
            dadosProcesso = objs.sql.executarSql(comando_sql);
            if (dadosProcesso != null && dadosProcesso.moveToFirst()) {
                String codProcesso = dadosProcesso.getString(0);
                comando_sql = "select * from comandossql where codprocesso = " + codProcesso ;
                dadosComando = objs.sql.executarSql(comando_sql);
                if (dadosComando.moveToFirst()) {
                    ArrayList<String> camposComando = new ArrayList<String>(Arrays.asList(dadosComando.getColumnNames()));
                    int indCampo = -1;
                    indCampo = camposComando.indexOf("tipocomando");
                    String tipoComando = dadosComando.getString(indCampo);
                    tipoComando = tipoComando.trim().toLowerCase();
                    if (tipoComando.equalsIgnoreCase("select")) {
                        indCampo = camposComando.indexOf("comandosql");
                        String comandosql = dadosComando.getString(indCampo);
                        comandosql = comandosql.replace("__CONDICIONANTES__",condicionantes);
                        objs.funcoesDados.fecharCursor(dadosProcesso);
                        objs.funcoesDados.fecharCursor(dadosComando);
                        dadosRetorno = executarSql(comandosql);
                    } else {
                        throw new Exception("tipo de comando nao esperado: " + tipoComando);
                    }
                }
            } else {
                objs.funcoesBasicas.log("processo nao encontrado: " + nomeProcessoDB);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return dadosRetorno;
        } finally {
            objs.funcoesDados.fecharCursor(dadosProcesso);
            objs.funcoesDados.fecharCursor(dadosComando);
            return dadosRetorno;
        }
    }

    public Cursor obter_dados_campos_tabela(String nomeTabelaDB) {
        String fnome = "obter_dados_campos_tabela";
        Cursor retorno = null;
        try {
            objs.funcoesBasicas.logi(cnome,fnome);
            retorno = db.rawQuery("PRAGMA table_info("+nomeTabelaDB+")", null);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        } finally {
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        }
    }

    public ContentValues obter_dados_campo_tabela(String nomeTabelaDB, String nomeCampoDB) {
        String fnome = "obter_dados_campo_tabela";
        Cursor dadosCampos = null;
        ContentValues retorno = null;
        try {
            objs.funcoesBasicas.logi(cnome,fnome);
            dadosCampos = db.rawQuery("PRAGMA table_info("+nomeTabelaDB+")", null);
            if (dadosCampos != null && dadosCampos.moveToFirst()){
                int indColNome = dadosCampos.getColumnIndex("name");
                String nomeCampo = null;
                do{
                    nomeCampo = dadosCampos.getString(indColNome);
                    if (nomeCampo != null && nomeCampo.trim().length() > 0 && nomeCampo.equalsIgnoreCase(nomeCampoDB)) {
                        retorno = new ContentValues();
                        int qt = dadosCampos.getColumnCount();
                        for (int i = 0; i < qt; i++) {
                            retorno.put(dadosCampos.getColumnName(i),dadosCampos.getString(i));
                        }
                        break;
                    }
                } while (dadosCampos.moveToNext());
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        } finally {
            objs.funcoesDados.fecharCursor(dadosCampos);
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        }
    }

    public String obter_tipo_dado_campo_tabela(String nomeTabelaDB, String nomeCampoDB) {
        String fnome = "obter_tipo_dado_campo_tabela";
        ContentValues dadosCampo = null;
        String retorno = null;
        try {
            objs.funcoesBasicas.logi(cnome,fnome);
            dadosCampo = obter_dados_campo_tabela(nomeTabelaDB,nomeCampoDB);
            if (dadosCampo != null && dadosCampo.size() > 0) {
                retorno = dadosCampo.getAsString("type");
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        } finally {
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        }
    }
}