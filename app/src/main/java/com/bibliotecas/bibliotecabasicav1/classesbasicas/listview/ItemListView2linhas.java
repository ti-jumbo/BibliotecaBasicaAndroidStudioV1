package com.bibliotecas.bibliotecabasicav1.classesbasicas.listview;

public class ItemListView2linhas {
    private String linha1;
    private String linha2;
    private Object dado1;

    public ItemListView2linhas(String linha1,String linha2, Object dado1){
        this.linha1 = linha1;
        this.linha2 = linha2;
        this.dado1 = dado1;
    }

    public void atualizar_dados(String linha1,String linha2, Object dado1){
        this.linha1 = linha1;
        this.linha2 = linha2;
        this.dado1 = dado1;
    }

    public String getLinha1() {
        return linha1;
    }

    public void setLinha1(String pLinha1) {
        this.linha1 = pLinha1;
    }

    public String getLinha2() {
        return linha2;
    }

    public void setLinha2(String pLinha2) {
        this.linha2 = pLinha2;
    }

    public Object getDado1() {
        return dado1;
    }

    public void setDado1(Object pDado1) {
        this.dado1 = pDado1;
    }
}

