<?php

namespace App\Http\Controllers\Traits;

trait Vueable {
     /**
     * redirect to vue route with message cookie
     *
     * @param string $vueRoute
     * @param string $message
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirectVue($vueRoute = "", $key = "", $message = "")
    {
        $baseUrl = config('app.url');
        $route = "{$baseUrl}/{$vueRoute}";

        if (!$key || !$message) {
            return redirect($route);
        } else {
            return redirect($route)
                // PHPネイティブのsetcookieメソッドに指定する引数同じ
                // ->cookie($name, $value, $minutes, $path, $domain, $secure, $httpOnly)
                ->cookie($key, $message, 0, '', '', false, false);
        }
    }
}