<?php
include_once('vendor/autoload.php');

$config = new \Packaged\Config\Provider\ConfigSection(
  'opsview', [
    'url' => 'http://opsview.yourdomain.com/rest/'
  ]
);

$api = new \Bajbnet\Opsview\OpsviewRest($config);
$api->login('username', 'password');

var_dump($api->call('status?state=2')); //Critical
var_dump($api->call('status?state=1')); //Warning
