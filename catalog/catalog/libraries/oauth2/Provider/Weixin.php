<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 /**
  * Oauth2 SocialAuth for CodeIgniter
  * 微信 Provider
  * 
  * @author  <2994273988@qq.com>
  */
 
class OAuth2_Provider_Weixin extends OAuth2_Provider
{
  public $client_id_key = 'appid';
 
        public $name = 'weixin';
 
        public $human = '微信';
 
        public $uid_key = 'openid';
 
        public $method = 'GET';
        
        public $scope = 'snsapi_userinfo';
        
        public $client_secret_key = 'secret';
 
        // 注意参数顺序
        public function authorize($options = array())
        {
          $state = md5(uniqid(rand(), true));
          get_instance()->session->set_userdata('state', $state);
          $params = array(
              $this->client_id_key              => $this->client_id,
              $this->redirect_uri_key   => isset($options[$this->redirect_uri_key]) ? $options[$this->redirect_uri_key] : $this->redirect_uri,
              'response_type'   => 'code',
              'scope'                           => is_array($this->scope) ? implode($this->scope_seperator, $this->scope) : $this->scope,
              $this->state_key  => $state
          );
        
          $params = array_merge($params, $this->params);
          
          redirect($this->url_authorize().'?'.http_build_query($params).'#wechat_redirect');
        }
        
        public function url_authorize()
        {
                return 'https://open.weixin.qq.com/connect/oauth2/authorize';
        }
 
        public function url_access_token()
        {
                return 'https://api.weixin.qq.com/sns/oauth2/access_token';
        }
 
        public function get_user_info(OAuth2_Token_Access $token)
        {
 
                $url = 'https://api.weixin.qq.com/sns/userinfo?'.http_build_query(array(
                        'access_token' => $token->access_token,
                        'openid' => $token->uid,
                ));
                
                $user = json_decode($this->vget($url));
                //$user = json_decode(file_get_contents($url));
                
        if (array_key_exists("error", $user))
        {
                throw new OAuth2_Exception((array) $user);
        } 
                // Create a response from the request
                return array(
      					'via' => 'weixin',
                        'uid' => $user->openid,
                        'nickname' => $user->nickname,
                        'name' => $user->nickname,
                        'location' => $user->province.' '.$user->city,
                        'description' => $user->privilege,
                        'image' => $user->headimgurl,
                        'access_token' => $token->access_token,
                        'expire_at' => $token->expires,
                        'refresh_token' => $token->refresh_token
                );
        }
}