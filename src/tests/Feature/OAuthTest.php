<?php

namespace Tests\Feature;

use App\User;
use Auth;
use Socialite;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OAuthTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        $this->providerName = 'line';

        // モックを作成
        // $this->user = Mockery::mock('Laravel\Socialite\Two\User');
        // $this->user
        //     ->shouldReceive('getId')
        //     ->andReturn(uniqid())
        //     ->shouldReceive('getEmail')
        //     ->andReturn(uniqid().'@test.com')
        //     ->shouldReceive('getNickname')
        //     ->andReturn('Pseudo');

        // $this->provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        // $this->provider->shouldReceive('user')->andReturn($this->user);
    }

    public static function tearDownAfterClass(): void
    {
        // Mockeryの設定をもとに戻す
        // Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    /**
     * @test
     */
    public function LINEの認証画面を表示できる()
    {
        // URLをコール
        $response = $this->get(route('socialOAuth', ['provider' => $this->providerName]));
        $response->assertStatus(302);
        
        $target = parse_url($response->headers->get('location'));
        // リダイレクト先ドメインの検証
        $this->assertEquals('access.line.me', $target['host']);

         // パラメータの検証
         $query = explode('&', $target['query']);
         
         $this->assertContains('redirect_uri=' . urlencode("http://localhost:3000"), $query);
        
    }

    /**
     * 
     */
    public function LINEアカウントでユーザー登録できる()
    {
        // Socialite::shouldReceive('driver')->with($this->providerName)->andReturn($this->provider);

        // URLをコール
        $response = $this->get(route('oauthCallback', ['provider' => $this->providerName]));
        $response->assertStatus(302);
        // dd(Socialite::with($this->providerName)->user());
        // URLをコール
        $this->get(route('oauthCallback', ['provider' => $this->providerName]))
        ->assertStatus(302)
        ->assertRedirect('/kyouan/list');

        // 各データが正しく登録されているかチェック
        $this->assertDatabaseHas('users', [
            'provider_id' => $this->user->getId(),
            'provider_name' => $this->providerName,
            'name' => $this->user->getNickName(),
            'email' => $this->user->getEmail()
        ]);

        // 認証チェック
        $this->assertAuthenticated();
    }
}
