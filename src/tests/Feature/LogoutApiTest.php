<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUP(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_認証済みのユーザーをログアウトさせる()
    {
        $response = $this->actingAs($this->user)
                            ->json('POST', route('logout'));
        
        // ログアウト後のレスポンスで、HTTPステータスコードが正常であることを確認
        $response->assertStatus(200);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }
}
