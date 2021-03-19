package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.widget.Spinner;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.spinner.SpinnerAdapter2Linhas;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.spinner.SpinnerAdapterBase;

import java.util.ArrayList;
import java.util.Arrays;

public class FuncoesSpinner extends FuncoesBase {
    private static String cnome = "FuncoesSpinner";
    private static FuncoesSpinner uFuncoesSpinner;

    public FuncoesSpinner(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesSpinner";
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

    public static synchronized FuncoesSpinner getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesSpinner getInstancia(Context pContexto) {
        try {
            if (uFuncoesSpinner == null) {
                uFuncoesSpinner = new FuncoesSpinner(pContexto);
            }
            return uFuncoesSpinner;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public void montar_spinner_simples(Spinner spinner, ArrayList<ArrayList<String>> dados){
        try {
            String fnome = "montar_spinner_simples";
            objs.funcoesBasicas.logi(cnome,fnome);
            montar_spinner_simples(spinner,dados,null,-1);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void montar_spinner_simples(Spinner spinner, ArrayList<ArrayList<String>> dados, ArrayList<String> dadosSelecionado, int indColComparacao){
        try {
            String fnome = "montar_spinner_simples";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (spinner != null) {
                String dadoSelecionado = null;
                int indItemSelecionado = -1;
                int qt = 0;
                SpinnerAdapterBase spa = null;
                if (dadosSelecionado != null && dados != null) {
                    dadoSelecionado = dadosSelecionado.get(indColComparacao);
                    qt = dados.size();
                    if (qt > 0) {
                        if (dadoSelecionado != null && dadoSelecionado.trim().length() > 0) {
                            dadoSelecionado = dadoSelecionado.replace("-", "").replace(".", "").replace("/", "").trim();
                            for (int i = 0; i < qt; i++) {
                                if (dados.get(i).get(indColComparacao).replace("-", "").replace(".", "").replace("/", "").trim().equalsIgnoreCase(dadoSelecionado)) {
                                    indItemSelecionado = i;
                                    break;
                                }
                            }
                        }
                    }
                }
                if (dados != null) {
                    qt = dados.size();
                    if (qt > 0) {
                        spa = new SpinnerAdapterBase(spinner, contexto, R.layout.spinner_item_padrao, R.id.textViewSpinner, dados);
                        spinner.setAdapter(spa);
                        if (indItemSelecionado == -1 && dadoSelecionado != null) {
                            spa.getItems().add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                            indItemSelecionado = spa.getItems().size() - 1;
                            spa.notifyDataSetChanged();
                        }
                        spinner.setSelection(indItemSelecionado, false);
                    } else if (dadoSelecionado != null) {
                        dados.add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                        spa = new SpinnerAdapterBase(spinner, contexto, R.layout.spinner_item_padrao, R.id.textViewSpinner, dados);
                        spinner.setAdapter(spa);
                        indItemSelecionado = spa.getItems().size() - 1;
                        spa.notifyDataSetChanged();
                        spinner.setSelection(indItemSelecionado, false);
                    }
                } else if (dadoSelecionado != null) {
                    dados = new ArrayList<ArrayList<String>>();
                    dados.add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                    spa = new SpinnerAdapterBase(spinner, contexto, R.layout.spinner_item_padrao, R.id.textViewSpinner, dados);
                    spinner.setAdapter(spa);
                    indItemSelecionado = spa.getItems().size() - 1;
                    spa.notifyDataSetChanged();
                    spinner.setSelection(indItemSelecionado, false);
                }
            } else {
                objs.funcoesBasicas.log("spinner nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void montar_spinner_2linhas(Spinner spinner, int indColPrincipal, int indColLinha0, int indColLinha1,ArrayList<ArrayList<String>> dados){
        try {
            String fnome = "montar_spinner_2linhas";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (spinner != null) {
                montar_spinner_2linhas(spinner, indColPrincipal, indColLinha0, indColLinha1, dados, null, -1);
            } else {
                objs.funcoesBasicas.log("spinner nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void montar_spinner_2linhas(Spinner spinner, int indColPrincipal, int indColLinha0, int indColLinha1, ArrayList<ArrayList<String>> dados, ArrayList<String> dadosSelecionado,int indColComparacao){
        try {
            String fnome = "montar_spinner_2linhas";
            if (spinner != null) {
                objs.funcoesBasicas.logi(cnome,fnome);
                String dadoSelecionado = null;
                int indItemSelecionado = -1;
                int qt = 0;
                SpinnerAdapter2Linhas spa = null;
                if (dadosSelecionado != null && dados != null) {
                    dadoSelecionado = dadosSelecionado.get(indColComparacao);
                    qt = dados.size();
                    if (qt > 0) {
                        if (dadoSelecionado != null && dadoSelecionado.trim().length() > 0) {
                            dadoSelecionado = dadoSelecionado.replace("-","").replace(".","").replace("/","").trim();
                            for (int i = 0; i < qt; i++) {
                                if (dados.get(i).get(indColComparacao).replace("-","").replace(".","").replace("/","").trim().equalsIgnoreCase(dadoSelecionado)) {
                                    indItemSelecionado = i;
                                    break;
                                }
                            }
                        }
                    }
                }
                if (dados != null) {
                    qt = dados.size();
                    if (qt > 0) {
                        spa = new SpinnerAdapter2Linhas(spinner,contexto, R.layout.spinner_item_2linhas, R.id.textViewSpinner, dados);
                        spa.setIndColDados(indColPrincipal);
                        spa.setIndColDadosL0(indColLinha0);
                        spa.setIndColDadosL1(indColLinha1);
                        spinner.setAdapter(spa);
                        if (indItemSelecionado == -1 && dadoSelecionado != null) {
                            spa.getItems().add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                            indItemSelecionado = spa.getItems().size()-1;
                            spa.notifyDataSetChanged();
                        }
                        spinner.setSelection(indItemSelecionado,false);
                    } else if (dadoSelecionado != null){
                        dados.add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                        spa = new SpinnerAdapter2Linhas(spinner,contexto, R.layout.spinner_item_2linhas, R.id.textViewSpinner, dados);
                        spa.setIndColDados(indColPrincipal);
                        spa.setIndColDadosL0(indColLinha0);
                        spa.setIndColDadosL1(indColLinha1);
                        spinner.setAdapter(spa);
                        indItemSelecionado = spa.getItems().size()-1;
                        spa.notifyDataSetChanged();
                        spinner.setSelection(indItemSelecionado,false);
                    }
                } else if (dadoSelecionado != null){
                    dados = new ArrayList<ArrayList<String>>();
                    dados.add(new ArrayList<String>(Arrays.asList(dadoSelecionado)));
                    spa = new SpinnerAdapter2Linhas(spinner, contexto, R.layout.spinner_item_2linhas, R.id.textViewSpinner, dados);
                    spa.setIndColDados(indColPrincipal);
                    spa.setIndColDadosL0(indColLinha0);
                    spa.setIndColDadosL1(indColLinha1);
                    spinner.setAdapter(spa);
                    indItemSelecionado = spa.getItems().size()-1;
                    spa.notifyDataSetChanged();
                    spinner.setSelection(indItemSelecionado,false);
                }
            } else {
                objs.funcoesBasicas.log("spinner nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void selecionar_valor_adapter(Spinner spinner, ArrayList<String> dadoSelecionar, int colComparacao, boolean acrescentar) {
        try {
            String fnome = "selecionar_valor_adapter";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (spinner != null) {
                int indSelecionado = -1;
                SpinnerAdapterBase adapter = (SpinnerAdapterBase) spinner.getAdapter();

                objs.funcoesBasicas.log("dado selecionado: " + dadoSelecionar.get(0));
                if (adapter != null) {
                    objs.funcoesBasicas.log("tem adapter");
                    ArrayList<ArrayList<String>> itens = adapter.getItems();
                    if (itens != null) {
                        objs.funcoesBasicas.log("tem itens: " + itens.size());
                        int qt = itens.size();
                        if (dadoSelecionar != null) {
                            objs.funcoesBasicas.log("tem dados selecionar: " + dadoSelecionar.size()+ " " + colComparacao );
                            if (dadoSelecionar.size() > colComparacao) {

                                String valorSelecionar = dadoSelecionar.get(colComparacao);
                                objs.funcoesBasicas.log("valorselecionar: " + valorSelecionar);
                                if (valorSelecionar != null) {

                                    valorSelecionar = valorSelecionar.replace("-", "").replace(".", "").replace("/", "").trim();
                                    objs.funcoesBasicas.log("prourand " + valorSelecionar);
                                    for (int i = 0; i < qt; i++) {
                                        if (itens.get(i).get(colComparacao).replace("-", "").replace(".", "").replace("/", "").trim().equalsIgnoreCase(valorSelecionar)) {
                                            indSelecionado = i;
                                        }
                                    }
                                    if (indSelecionado > -1) {
                                        spinner.setSelection(indSelecionado, false);
                                    } else if (acrescentar == true) {
                                        itens.add(dadoSelecionar);
                                        indSelecionado = itens.size() - 1;
                                        adapter.notifyDataSetChanged();
                                        spinner.setSelection(indSelecionado, false);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                objs.funcoesBasicas.log("spinner nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}

