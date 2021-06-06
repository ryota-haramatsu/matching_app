<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Lang;
use Socialite;
use App\Http\Controllers\Traits\Vueable;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, Vueable;

    /**
     * ログイン制限を設定
     * AuthenticatesUsersトレイトのThrottlesLoginsトレイトに
     * ログイン試行回数: maxAttempts()とログインロック時間: decayMinutes()
     * を制御することができる。
     * 例: 試行回数: 5回 / ロック時間: 1分
     */

    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // ログイン制限を追加
        $this->maxAttempts = config('auth.throttles_logins.maxAttempts', $this->maxAttempts); //試行回数
        $this->decayMinutes = config('auth.throttles_logins.decayMinutes', $this->decayMinutes); //ロック時間
    }

    // ログイン認証 routeでloginをして authenticatedを上書き
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    // ログアウト
    protected function loggedOut(Request $request)
    {
        // セッションを再生成する
        $request->session()->regenerate();

        return response()->json();
    }

    /**
     * 認証ページヘユーザーをリダイレクト
     *
     * @param [type] $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        // オプションパラメータを含めたければwith()で連想配列を渡す
        // with(['param' => 'example.com'])
        // scopesメソッドを使用し、リクエストへ「スコープ」を追加することもでる
        // ->scopes(['scope:openid%20profile'])
        $redirect_uri = config('app.url') . config('services.line.redirect');
        return Socialite::driver($provider)
                ->with(['redirect_uri' => $redirect_uri])
                ->redirect();
        
    }
    
    /**
     * プロバイダからユーザー情報を取得
     *
     * @param [type] $provider
     * @return  \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            // ユーザー情報を取得
            $providerUser = Socialite::with($provider)->user();

            // メールの取得
            $email = $providerUser->getEmail() ?? null;

            // プロバイダのIDを取得
            $providerId = $providerUser->getId();
            

            // メールアドレスがある時
            if ($email) {
                $user = User::firstOrCreate([
                    'email' => $email
                ], [
                    'provider_id' => $providerId,
                    'provider_name' => $provider,
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'nickname' => $providerUser->getNickname() ?? null,
                    'avatar' => $providerUser->getAvatar() ?? '',
                ]);
            // プロバイダIDがあるとき
            } elseif ($providerId) {
                // ユーザーの作成or更新
                $user = User::firstOrCreate([
                    'provider_id' => $providerId,
                    'provider_name' => $provider,
                ],[
                    'provider_id' => $providerUser->getId(),
                    'provider_name' => $provider,
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'nickname' => $providerUser->getNickname() ?? null,
                    'avatar' => $providerUser->getAvatar() ?? '',
                ]);
            } else {
                throw new \Exception();
            }

            // login with remember
            Auth::login($user, true);

            // メッセージ付きのリダイレクト
            $message = Lang::get('socialite login success.');
            return $this->redirectVue($redirectTo, 'MESSAGE', $message);
        } catch(\Exception $e){
            // メッセージをつけてリダイレクト
            $message = $message = Lang::get('authentication failed.');
            return $this->redirectVue('login', 'MESSAGE', $message);
        }
    }
}
