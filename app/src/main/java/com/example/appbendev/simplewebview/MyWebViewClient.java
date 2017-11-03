package com.example.appbendev.simplewebview;

import android.webkit.WebView;
import android.webkit.WebViewClient;

/**
 * Created by coach redire on 12/07/2017.
 */

public class MyWebViewClient extends WebViewClient {
    @Override
    public boolean shouldOverrideUrlLoading(WebView view, String url) {
        view.loadUrl(url);
        return true;
    }

}