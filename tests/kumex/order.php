<?php


/**
 * @author lin <465382251@qq.com>
 *
 * Fill in your key and secret and pass can be directly run
 *
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/okex-php.git
 * */
use Lin\Ku\Kumex;

require __DIR__ .'../../../vendor/autoload.php';

include 'key_secret.php';

$kumex=new Kumex($key,$secret,$passphrase,$host);

//You can set special needs
$kumex->setOptions([
    //Set the request timeout to 60 seconds by default
    'timeout'=>10,

    //If you are developing locally and need an agent, you can set this
    //'proxy'=>true,
    //More flexible Settings
    /* 'proxy'=>[
     'http'  => 'http://127.0.0.1:12333',
     'https' => 'http://127.0.0.1:12333',
     'no'    =>  ['.cn']
     ], */
    //Close the certificate
    //'verify'=>false,
]);

$clientOid=rand(10000,99999).rand(10000,99999);
try {
    $result=$kumex->order()->post([
        'clientOid'=>$clientOid,
        'side'=>'buy',
        'symbol'=>'XBTUSDM',
        'leverage'=>10,

        'price'=>8100,
        'size'=>100,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

try {
    $result=$kumex->order()->get([
        //'order_id'=>$result['data']['orderId'],
        'client_order_id'=>$clientOid,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

try {
    $result=$kumex->order()->delete([
        'order_id'=>$result['data']['id'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

