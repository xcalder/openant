<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sns extends CI_Controller {

	protected $close="<script>window.opener=null;window.open('','_self');window.close();</script>";
	protected $refresh="<script>window.opener.location.reload();</script>";
	
	public function __construct()
    {
      	parent::__construct();
    	$this->load->model('setting/sign_in_with_model');
    	$this->lang->load('user/sns',$_SESSION['language_name']);
    }

	public function session($provider = '')
	{
		//$this->output->set_status_header(302);
		$providers = $this->sign_in_with_model->get_sign_with($provider);
		//var_dump($providers);
		if (!$providers)
		{
        	$this->session->set_flashdata('fali', sprintf(lang_line('not_support'), $provider));
            //redirect();
            echo $this->refresh;
            echo $this->close;
            return;
		}
		$this->load->library('oauth2');
		$provider = $this->oauth2->provider($provider, $providers);
        $args = $this->input->get();
        if ($args AND !isset($args['code']))
        {
          	$this->session->set_flashdata('fali', sprintf(lang_line('authorization_failed'), json_encode($args)));
            //redirect();
            echo $this->refresh;
            echo $this->close;
            return;
        }
        $code = $this->input->get('code', TRUE);
		if ( ! $code)
		{
                  try
                  {
			         $provider->authorize();
                  }
                  catch (OAuth2_Exception $e)
                  {
                  	$this->session->set_flashdata('fali', sprintf(lang_line('operation_failed'), $e));
                  	//redirect();
                  	echo $this->refresh;
                  	echo $this->close;
                  	return;
                  }
		}
		else
		{
			try
			{
				$token = $provider->access($code);
	        	$sns_user = $provider->get_user_info($token);
				if (is_array($sns_user))
				{
					$select_user_id=$this->sign_in_with_model->select_user_for_vid($sns_user['via'], $sns_user['uid']);
					if($select_user_id){
						if(isset($_SESSION['user_id'])){
							$this->load->model('common/user_activity_model');
							$this->user_activity_model->add_activity($_SESSION['user_id'], 'bind', array('title'=>sprintf(lang_line('already_used'), $provider), 'msg'=>''));
							$this->session->set_flashdata('fail', sprintf(lang_line('already_used'), $provider));
							echo $this->refresh;
							echo $this->close;
							return;
						}
						$this->session->set_flashdata('success', sprintf(lang_line('success_login'), $provider));
						
						$this->load->model('common/user_activity_model');
						$this->user_activity_model->add_activity($select_user_id, 'bind', array('title'=>sprintf(lang_line('success_login'), $provider), 'msg'=>''));
						
						$_SESSION['user_id']=$select_user_id;
						
					}else{
						if(isset($sns_user['first_name']) && !empty($sns_user['first_name'])){
							$data['adduser']['first_name']=$sns_user['first_name'];
						}
						if(isset($sns_user['last_name']) && !empty($sns_user['last_name'])){
							$data['adduser']['last_name']=$sns_user['last_name'];
						}
						if(isset($sns_user['email']) && !empty($sns_user['email'])){
							$data['adduser']['email']=$sns_user['email'];
						}
						if(isset($sns_user['image']) && !empty($sns_user['image'])){
							$data['adduser']['image']=$sns_user['image'];
							$data['addsgin']['image']=$sns_user['image'];
						}
						if(isset($sns_user['description']) && !empty($sns_user['description'])){
							$data['adduser']['description']=$sns_user['description'];
						}
						if(isset($sns_user['nickname']) && !empty($sns_user['nickname'])){
							$data['adduser']['nickname']=$sns_user['nickname'];
							$data['addsgin']['nickname']=$sns_user['nickname'];
						}
						
						$data['adduser']['user_group_id']=$this->config->get_config('register_group');
						$data['adduser']['user_class_id']=$this->config->get_config('default_user_class');
						$data['adduser']['sale_class_id']=$this->config->get_config('default_sale_class');
						$data['adduser']['status']='1';
						$date=date("Y-m-d H:i:s");
						$data['adduser']['date_added']=$date;
						
						$data['addsgin']['date_added']=$date;
						$data['addsgin']['via']=$sns_user['via'];
						$data['addsgin']['uid']=$sns_user['uid'];
						if(isset($sns_user['location']) && !empty($sns_user['location'])){
							$data['addsgin']['location']=$sns_user['location'];
						}
						
						if(isset($_SESSION['user_id'])){
							$this->sign_in_with_model->add_bind_accounts($data);
							$this->session->set_flashdata('success', sprintf(lang_line('success_bind'), $provider));
						}else{
							$this->sign_in_with_model->add_user_sign_in_with($data);
							$this->session->set_flashdata('success', sprintf(lang_line('success_bind_login'), $provider));
						}
					}
					
					echo $this->refresh;
                   	echo $this->close;
				}
				else
				{
                    $this->session->set_flashdata('fali', lang_line('get_information_failed'));
                    //redirect();
                    echo $this->refresh;
                    echo $this->close;
                    return;
				}
			}
			catch (OAuth2_Exception $e)
			{
                $this->session->set_flashdata('fali', sprintf(lang_line('operation_failed'), $e));
                //redirect();
                echo $this->refresh;
                echo $this->close;
                return;
			}
		}
		echo $this->refresh;
		echo $this->close;
		return;
        //redirect();
	}
}

/**
* //注意由于各个平台不一致,不是所有的参数都有值
return array(
    'via' => '', // provider 唯一标示
    'uid' => '', // 用户在对应平台的唯一标识
    'screen_name' => '', //用户的显示名称，一般为昵称
    'name' => '', // 用户的其它名称
    'location' => '', //用户所在地
    'description' => '', // 用户自我介绍
    'image' => '', // 头像地址
    'access_token' => '', // access_token
    'expire_at' => '', // access_token 对应过期时间
    'refresh_token' => '' // refresh_token
);
*/

/* End of file sns.php */
/* Location: ./application/controllers/sns.php */