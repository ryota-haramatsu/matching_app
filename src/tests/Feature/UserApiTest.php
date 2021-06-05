<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class)->create();
    }

    /**
     * リダイレクトすると
     * Vueアプリケーションが再生成されuserステートnullになる->見た目はログアウト
     * サーバー側のセッションはログイン状態
     * ->最初にログインユーザーを取得してから Vue アプリケーションを生成するようにすべき
     */

    /** @test */
    public function should_ログイン中のユーザーを返却する()
    {
        $response = $this->actingAs($this->user)->json('GET', route('user'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $this->user->name,
            ]);
    }

    /**
     * @test
     * ログインしていないと Auth::user()はnullを返却するが、
     * HTTPレスポンスに返却される際に空の文字列に変わるため
     */
    public function should_ログインされていない場合は空文字を返却する()
    {
        $response = $this->json('GET', route('user'));

        $response->assertStatus(200);
        $this->assertEquals("", $response->content());
    }
}
