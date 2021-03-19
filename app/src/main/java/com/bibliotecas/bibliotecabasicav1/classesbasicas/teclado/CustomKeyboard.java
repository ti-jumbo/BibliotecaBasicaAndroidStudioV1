package com.bibliotecas.bibliotecabasicav1.classesbasicas.teclado;

import android.app.Activity;
import android.content.Context;
import android.inputmethodservice.Keyboard;
import android.inputmethodservice.KeyboardView;
import android.text.Editable;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class CustomKeyboard {

    /** A link to the KeyboardView that is used to render this CustomKeyboard. */
    private KeyboardView mKeyboardView;
    /** A link to the activity that hosts the {@link #mKeyboardView}. */
    private Activity mHostActivity;
    private EditText inputAtual = null;
    private Method metodoMais = null;
    private Object objetoMais = null;
    private Method metodoMenos = null;
    private Object objetoMenos = null;
    private Method metodoAoMudarFoco = null;
    private Object objetoAoMudarFoco = null;
    protected ObjetosBasicos objs = null;


    /** The key (code) handler. */
    private KeyboardView.OnKeyboardActionListener mOnKeyboardActionListener = new KeyboardView.OnKeyboardActionListener() {

        public final static int CodeDelete   = -5; // Keyboard.KEYCODE_DELETE
        public final static int CodeCancel   = -3; // Keyboard.KEYCODE_CANCEL
        public final static int CodePrev     = 55000;
        public final static int CodeAllLeft  = 55001;
        public final static int CodeLeft     = 55002;
        public final static int CodeRight    = 55003;
        public final static int CodeAllRight = 55004;
        public final static int CodeNext     = 55005;
        public final static int CodeClear    = 55006;
        public final static int CodeMais     = 43;
        public final static int CodeMenos    = 45;

        @Override public void onKey(int primaryCode, int[] keyCodes) {
            objs.funcoesBasicas.logi("","onKey");
            View focusCurrent = mHostActivity.getWindow().getCurrentFocus();
            if (focusCurrent == null) {
                focusCurrent = inputAtual;
            }
            if( focusCurrent==null || !focusCurrent.getClass().getName().toLowerCase().contains("edit") ) {
                return;
            }
            EditText edittext = (EditText) focusCurrent;
            Editable editable = edittext.getText();
            int start = edittext.getSelectionStart();
            if( primaryCode==CodeCancel ) {
                hideCustomKeyboard();
            } else if( primaryCode==CodeDelete ) {
                if (edittext.isEnabled()) {
                    if (editable != null && start > 0) editable.delete(start - 1, start);
                }
            } else if( primaryCode==CodeClear ) {
                if (edittext.isEnabled()) {
                    if (editable != null) editable.clear();
                }
            } else if( primaryCode==CodeLeft ) {
                if (edittext.isEnabled()) {
                    if (start > 0) edittext.setSelection(start - 1);
                }
            } else if( primaryCode==CodeRight ) {
                if (edittext.isEnabled()) {
                    if (start < edittext.length()) edittext.setSelection(start + 1);
                }
            } else if( primaryCode==CodeAllLeft ) {
                if (edittext.isEnabled()) {
                    edittext.setSelection(0);
                }
            } else if( primaryCode==CodeAllRight ) {
                if (edittext.isEnabled()) {
                    edittext.setSelection(edittext.length());
                }
            } else if( primaryCode==CodePrev ) {
                View focusNew = edittext.focusSearch(View.FOCUS_UP);
                if( focusNew!=null && edittext.getNextFocusUpId() != -1) {
                    if (!focusNew.isEnabled()) {
                        do {
                            focusNew = focusNew.focusSearch(View.FOCUS_UP);
                        } while (focusNew!=null && focusNew.getNextFocusUpId() != -1 && !focusNew.isEnabled());
                    }
                    focusNew.requestFocus();
                }
            } else if( primaryCode==CodeNext ) {
                View focusNew = edittext.focusSearch(View.FOCUS_DOWN);
                if (focusNew != null && edittext.getNextFocusDownId() != -1) {
                    if (!focusNew.isEnabled()) {
                        do {
                            focusNew = focusNew.focusSearch(View.FOCUS_DOWN);
                        } while (focusNew!=null && focusNew.getNextFocusDownId() != -1 && !focusNew.isEnabled());
                    }
                    focusNew.requestFocus();
                }
            } else if (primaryCode==CodeMais) {
                if (edittext.isEnabled()) {
                    if (metodoMais != null) {
                        try {
                            metodoMais.invoke(objetoMais, edittext);
                        } catch (IllegalAccessException e) {
                            e.printStackTrace();
                        } catch (InvocationTargetException e) {
                            e.printStackTrace();
                        }
                    }
                }
            } else if (primaryCode==CodeMenos) {
                if (edittext.isEnabled()) {
                    if (metodoMenos != null) {
                        try {
                            metodoMenos.invoke(objetoMenos, edittext);
                        } catch (IllegalAccessException e) {
                            e.printStackTrace();
                        } catch (InvocationTargetException e) {
                            e.printStackTrace();
                        }
                    }
                }
            } else { // insert character
                if (edittext.isEnabled()) {
                    editable.insert(start, Character.toString((char) primaryCode));
                }
            }
            objs.funcoesBasicas.logf("","onKey");
        }

        @Override public void onPress(int arg0) {
        }

        @Override public void onRelease(int primaryCode) {
        }

        @Override public void onText(CharSequence text) {
        }

        @Override public void swipeDown() {
        }

        @Override public void swipeLeft() {
        }

        @Override public void swipeRight() {
        }

        @Override public void swipeUp() {
        }
    };

    /**
     * Create a custom keyboard, that uses the KeyboardView (with resource id <var>viewid</var>) of the <var>host</var> activity,
     * and load the keyboard layout from xml file <var>layoutid</var> (see {@link Keyboard} for description).
     * Note that the <var>host</var> activity must have a <var>KeyboardView</var> in its layout (typically aligned with the bottom of the activity).
     * Note that the keyboard layout xml file may include key codes for navigation; see the constants in this class for their values.
     * Note that to enable EditText's to use this custom keyboard, call the {@link #registerEditText(EditText)}.
     *
     * @param host The hosting activity.
     * @param viewid The id of the KeyboardView.
     * @param layoutid The id of the xml file containing the keyboard layout.
     */
    public CustomKeyboard(Activity host, Context pContexto, int viewid, int layoutid) {
        objs = ObjetosBasicos.getInstancia(pContexto);
        objs.funcoesBasicas.logi("","CustomKeyboard");
        mHostActivity= host;
        mKeyboardView= (KeyboardView)mHostActivity.findViewById(viewid);
        if (mKeyboardView == null) {
            mKeyboardView= (KeyboardView)mHostActivity.findViewById(R.id.keyboardview);
        }
        if (layoutid <= 0) {
            layoutid = R.xml.hexkbd;
        }
        Keyboard keyboard = new Keyboard(mHostActivity, layoutid);
        if (keyboard == null) {
            layoutid = R.xml.hexkbd;
            keyboard = new Keyboard(mHostActivity, layoutid);
        }
        mKeyboardView.setKeyboard(keyboard);
        mKeyboardView.setPreviewEnabled(false); // NOTE Do not show the preview balloons
        mKeyboardView.setOnKeyboardActionListener(mOnKeyboardActionListener);
        // Hide the standard keyboard initially
        mHostActivity.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
        objs.funcoesBasicas.logf("","CustomKeyboard");
    }

    /** Returns whether the CustomKeyboard is visible. */
    public boolean isCustomKeyboardVisible() {
        objs.funcoesBasicas.logi("","isCustomKeyboardVisible");
        objs.funcoesBasicas.logf("","isCustomKeyboardVisible");
        return mKeyboardView.getVisibility() == View.VISIBLE;
    }

    /** Make the CustomKeyboard visible, and hide the system keyboard for view v. */
    public void showCustomKeyboard( View v ) {
        objs.funcoesBasicas.logi("","showCustomKeyboard");
        mKeyboardView.setVisibility(View.VISIBLE);
        mKeyboardView.setEnabled(true);
        inputAtual = (EditText) v;
        if( v!=null )
            ((InputMethodManager) mHostActivity.getSystemService(Activity.INPUT_METHOD_SERVICE)).hideSoftInputFromWindow(v.getWindowToken(), 0);
        objs.funcoesBasicas.logf("","showCustomKeyboard");
    }

    /** Make the CustomKeyboard invisible. */
    public void hideCustomKeyboard() {
        objs.funcoesBasicas.logi("","hideCustomKeyboard");
        mKeyboardView.setVisibility(View.GONE);
        mKeyboardView.setEnabled(false);
        objs.funcoesBasicas.logf("","hideCustomKeyboard");
    }

    /**
     * Register <var>EditText<var> with resource id <var>resid</var> (on the hosting activity) for using this custom keyboard.
     *
     * @param edittext The resource id of the EditText that registers to the custom keyboard.
     */
    public void registerEditText(EditText edittext) {
        // Find the EditText 'resid'
        // Make the custom keyboard appear
        objs.funcoesBasicas.logi("","registerEditText");
        edittext.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            // NOTE By setting the on focus listener, we can show the custom keyboard when the edit box gets focus, but also hide it when the edit box loses focus
            @Override public void onFocusChange(View v, boolean hasFocus) {
                objs.funcoesBasicas.logi("","onFocusChange");
                if( hasFocus ) {
                    inputAtual = (EditText) v;
                    inputAtual.setSelection(inputAtual.length());
                    showCustomKeyboard(v);
                } else {
                    hideCustomKeyboard();
                }
                if (metodoAoMudarFoco != null) {
                    try {
                        metodoAoMudarFoco.invoke(objetoAoMudarFoco,v,hasFocus);
                    } catch (IllegalAccessException e) {
                        e.printStackTrace();
                    } catch (InvocationTargetException e) {
                        e.printStackTrace();
                    }
                }
                objs.funcoesBasicas.logf("","onFocusChange");
            }
        });
        edittext.setOnClickListener(new View.OnClickListener() {
            // NOTE By setting the on click listener, we can show the custom keyboard again, by tapping on an edit box that already had focus (but that had the keyboard hidden).
            @Override public void onClick(View v) {
                objs.funcoesBasicas.logi("","onClick");
                inputAtual = (EditText) v;
                showCustomKeyboard(v);
                objs.funcoesBasicas.logf("","onClick");
            }
        });
        // Disable standard keyboard hard way
        // NOTE There is also an easy way: 'edittext.setInputType(InputType.TYPE_NULL)' (but you will not have a cursor, and no 'edittext.setCursorVisible(true)' doesn't work )
        edittext.setOnTouchListener(new View.OnTouchListener() {
            @Override public boolean onTouch(View v, MotionEvent event) {
                objs.funcoesBasicas.logi("","onTouch");
                EditText edittext = (EditText) v;
                inputAtual = edittext;
                int inType = edittext.getInputType();       // Backup the input type
                edittext.setInputType(InputType.TYPE_NULL); // Disable standard keyboard
                edittext.onTouchEvent(event);               // Call native handler
                edittext.setInputType(inType);              // Restore input type
                objs.funcoesBasicas.logf("","onTouch");
                return true; // Consume touch event
            }
        });
        // Disable spell check (hex strings look like words to Android)
        //edittext.setInputType(edittext.getInputType() | InputType.TYPE_TEXT_FLAG_NO_SUGGESTIONS);
        objs.funcoesBasicas.logf("","registerEditText");
    }

    public Method getMetodoMais() {
        return metodoMais;
    }

    public void setMetodoMais(Method pMetodoMais) {
        this.metodoMais = pMetodoMais;
    }

    public Object getObjetoMais() {
        return objetoMais;
    }

    public void setObjetoMais(Object pObjetoMais) {
        this.objetoMais = pObjetoMais;
    }

    public Method getMetodoMenos() {
        return metodoMenos;
    }

    public void setMetodoMenos(Method pMetodoMenos) {
        this.metodoMenos = pMetodoMenos;
    }

    public Object getObjetoMenos() {
        return objetoMenos;
    }

    public void setObjetoMenos(Object pObjetoMenos) {
        this.objetoMenos = pObjetoMenos;
    }

    public Object getObjetoAoMudarFoco() {
        return objetoAoMudarFoco;
    }

    public void setObjetoAoMudarFoco(Object pObjetoAoMudarFoco) {
        this.objetoAoMudarFoco = pObjetoAoMudarFoco;
    }

    public KeyboardView.OnKeyboardActionListener getmOnKeyboardActionListener() {
        return mOnKeyboardActionListener;
    }

    public void setmOnKeyboardActionListener(KeyboardView.OnKeyboardActionListener pMOnKeyboardActionListener) {
        this.mOnKeyboardActionListener = pMOnKeyboardActionListener;
    }

    public void setMetodoAoMudarFoco(Method pMetodoAoMudarFoco) {
        this.metodoAoMudarFoco = pMetodoAoMudarFoco;
    }
}


// NOTE How can we change the background color of some keys (like the shift/ctrl/alt)?
// NOTE What does android:keyEdgeFlags do/mean
