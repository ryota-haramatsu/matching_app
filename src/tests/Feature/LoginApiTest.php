<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
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
    public function should_登録済みのユーザーを認証して返却()
    {
        $response = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'password' 
        ]); 

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $this->user->name
            ]);

        $this->assertAuthenticatedAs($this->user);
    }
}
