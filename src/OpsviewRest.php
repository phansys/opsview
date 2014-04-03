<?php
namespace Bajbnet\Opsview;

use Packaged\Config\Provider\ConfigSection;

class OpsviewRest
{
  protected $_config;
  protected $_token;
  protected $_username;

  public function __construct(ConfigSection $config)
  {
    $this->_config = $config;
  }

  public function login($username, $password)
  {
    $this->_username = $username;
    $response        = $this->call(
      'login',
      ['username' => $username, 'password' => $password]
    );

    if($response && isset($response->token))
    {
      $this->_token = $response->token;
      return true;
    }

    return false;
  }

  public function call($path, array $params = null)
  {
    $url     = $this->_config->getItem('url', false);
    $headers = [
      'X-Opsview-Username' => $this->_username,
      'X-Opsview-Token'    => $this->_token,
      'accept'             => 'application/json'
    ];

    if($params === null)
    {
      $request = \Requests::get(build_path($url, $path), $headers);
    }
    else
    {
      $request = \Requests::post(build_path($url, $path), $headers, $params);
    }
    return json_decode($request->body);
  }
}
