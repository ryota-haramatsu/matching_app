<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Kyouan extends Model
{
     /**
     * モデルと関連しているテーブルを指定できる
     *
     * @var string
     */
    protected $table = 'kyouans';

    /** 
     * プライマリーの型 を$keyTypeを上書きして変更できる
     * (主キーが整数でない場合は以下のように設定必要)
     * 
     * @var string  
     */
    protected $keyType = 'string';

    /** IDの桁数 */
    const ID_LENGTH = 12;


    /**
     * idはランダムな乱数にしたいので
     * 
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (! Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }


    /**
     * ランダムなID値をid属性に代入する
     */
    public function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    /**
     * ランダムなID値を生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }
}

