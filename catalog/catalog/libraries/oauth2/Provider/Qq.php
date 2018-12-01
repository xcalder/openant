<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * Oauth2 SocialAuth for CodeIgniter
  * QQ Provider
  */

class OAuth2_Provider_Qq extends OAuth2_Provider
{
	public $name = 'qq';

	public $human = 'QQ';

	public $uid_key = 'openid';

	public $method = 'POST';
 
	public function url_authorize()
	{
		return 'https://graph.qq.com/oauth2.0/authorize';
	}

	public function url_access_token()
	{
		return 'https://graph.qq.com/oauth2.0/token';
	}

	public function get_user_info(OAuth2_Token_Access $token)
	{
		$url = 'https://graph.qq.com/oauth2.0/me?'.http_build_query(array(
			'access_token' => $token->access_token
		));
		
		//$response = file_get_contents($url);
		$response = $this->vget($url);
		
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        }
        $me = json_decode($response);
                
        if (isset($me->error))
        {
            throw new OAuth2_Exception((array) $me);
        }
		
        $url = 'https://graph.qq.com/user/get_user_info?'.http_build_query(array(
			'access_token' => $token->access_token,
			'openid' => $me->openid,
            'oauth_consumer_key' => $this->client_id
		));
        
        //$response = file_get_contents($url);
        $response = $this->vget($url);
        
		$user = json_decode($response);
                
	    if (isset($me->error))
	    {
	    	throw new OAuth2_Exception((array) $user);
	    }
                
		return array(
            'via' => 'qq',//来源
			'uid' => $me->openid,//user_id
			'nickname' => $user->nickname,//昵称
			'name' => '',//名字
			'location' => '',//本地
			'description' => '',//描述
			'image' => $user->figureurl,//头像
			'access_token' => $token->access_token,//访问令牌
			'expire_at' => $token->expires,//到期
			'refresh_token' => $token->refresh_token //刷新令牌
		);
	}
}
