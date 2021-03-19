package com.bibliotecas.bibliotecabasicav1.classesbasicas.tablayout;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;

import java.util.ArrayList;
import java.util.List;

public class AdaptadorAbas extends FragmentPagerAdapter {

    public List<Fragment> fragmentos = new ArrayList<Fragment>();
    public List<String> titulos = new ArrayList<String>();
    public int contador = 0;

    public AdaptadorAbas(@NonNull FragmentManager fm) {
        super(fm);
    }

    @NonNull
    @Override
    public Fragment getItem(int position) {
        return this.fragmentos.get(position);
    }

    @Nullable
    @Override
    public CharSequence getPageTitle(int position) {
        return titulos.get(position);
    }

    @Override
    public int getCount() {
        return this.contador;
    }

    public void adicionarAba(Fragment fragmento, String titulo) {
        this.fragmentos.add(fragmento);
        this.titulos.add(titulo);
        this.contador++;
    }

}
