<?php


namespace App\Services;


use Illuminate\Support\Facades\Redis;

class CacheService
{
    private $redis;

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function writeCache()
    {
        $this->redis->select(1);

        $data = ['el1' => 'test1', 'el2' => 'test4'];


        $this->redis->set('test_key_check', json_encode($data));
    }
}
