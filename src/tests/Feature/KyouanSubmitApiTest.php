<?php

namespace Tests\Feature;

use App\Kyouan;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class KyouanSubmitApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }


    /**
     * @test
     */
    public function should_画像ファイルをアップロードできる()
    {
        // storage/framework/testing/disks/kyouans に保存用ディスクが作成される
        // Storage::persistentFake('kyouans'); テスト後も画像ファイルが残る
        Storage::fake('kyouans');

        $response = $this->actingAs($this->user)
            ->json('POST', route('kyouan.create'), [
                // ダミーファイルを作成して送信している
                'kyouan_img' => UploadedFile::fake()->image('kyouan.jpg'),
            ]);

         // レスポンスが201(CREATED)であること
         $response->assertStatus(201);

         $kyouan = Kyouan::first();
 
         // 写真のIDが12桁のランダムな文字列であること
         $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $kyouan->id);
 
         // DBに挿入されたファイル名のファイルがストレージに保存されていること
         Storage::cloud()->assertExists($kyouan->filename);
    }

    /**
     * 
     */
    public function should_データベースエラーの場合はファイルを保存しない()
    {
        // 乱暴だがこれでDBエラーを起こす
        Schema::drop('kyouans');

        Storage::fake('kyouans');

        $response = $this->actingAs($this->user)
            ->json('POST', route('kyouan.create'), [
                'kyouans' => UploadedFile::fake()->image('kyouan.jpg'),
            ]);

        // レスポンスが500(INTERNAL SERVER ERROR)であること
        $response->assertStatus(500);

        // ストレージにファイルが保存されていないこと
        $this->assertEquals(0, count(Storage::cloud()->files()));
    }

    /**
     * 
     */
    public function should_ファイル保存エラーの場合はDBへの挿入はしない()
    {
        // ストレージをモックして保存時にエラーを起こさせる
        Storage::shouldReceive('cloud')
            ->once()
            ->andReturnNull();

        $response = $this->actingAs($this->user)
            ->json('POST', route('kyouan.create'), [
                'kyouans' => UploadedFile::fake()->image('kyouan.jpg'),
            ]);

        // レスポンスが500(INTERNAL SERVER ERROR)であること
        $response->assertStatus(500);

        // データベースに何も挿入されていないこと
        $this->assertEmpty(Kyouan::all());
    }
}
