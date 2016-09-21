<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sns extends CI_Controller {

	protected $close="<script>window.opener=null;window.open('','_self');window.close();</script>";
	protected $refresh="<script>window.opener.location.reload();</script>";
	
	public function __construct()
    {
      	parent::__construct();
    	if($this->user->getId()){
    		echo $this->refresh;
    		echo $this->close;
    		return;
    	}
    	$this->load->model('setting/sign_in_with_model');
    }

	public function session($provider = '')
	{
		$this->output->set_status_header(302);
		$providers = $this->sign_in_with_model->get_sign_with($provider);
		//var_dump($providers);
		if (!$providers)
		{
        	$this->session->set_flashdata('fali', '暂不支持'.$provider.'方式登录.');
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
          	$this->session->set_flashdata('fali', '授权失败了,可能由于应用设置问题或者用户拒绝授权.<br />具体原因:<br />'.json_encode($args));
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
                  	$this->session->set_flashdata('fali', '操作失败<pre>'.$e.'</pre>');
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
						$this->session->set_flashdata('success', ((isset($sns_user['nickname']) && !empty($sns_user['nickname'])) ? $sns_user['nickname'] : $sns_user['name']) . $provider.'登陆成功！');
						
						$_SESSION['user_id']=$select_user_id;
						
						/**
						* 把购物车信息从数据库取出写入到session中
						* @var 
						* 
						*/
						$this->db->select('rowid, id, qty, price, name, options');
						$this->db->where('user_id', $select_user_id);
						$this->db->from($this->db->dbprefix('user_cart'));
						$cart_query=$this->db->get();
						if($cart_query->num_rows() > 0){
							$cart_contents=array();
							$cart_arr=$cart_query->result_array();
							foreach($cart_arr as $key=>$value){
								$cart_arr[$key]['options']=explode('.', $cart_arr[$key]['options']);
								$cart_contents[$cart_arr[$key]['rowid']]=$cart_arr[$key];
								$cart_contents[$cart_arr[$key]['rowid']]['subtotal']=$cart_arr[$key]['qty'] * $cart_arr[$key]['price'];
							}
							$cart_contents['cart_total']=array_sum(array_column($cart_contents,'price'));
							$cart_contents['total_items']=array_sum(array_column($cart_contents,'qty'));
							$_SESSION['cart_contents']=$cart_contents;
						}
						
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
						}
						if(isset($sns_user['description']) && !empty($sns_user['description'])){
							$data['adduser']['description']=$sns_user['description'];
						}
						if(isset($sns_user['nickname']) && !empty($sns_user['nickname'])){
							$data['adduser']['nickname']=$sns_user['nickname'];
						}
						
						$data['adduser']['user_group_id']=$this->config->get_config('register_group');
						$data['adduser']['user_class_id']=$this->config->get_config('default_user_class');
						$data['adduser']['sale_class_id']=$this->config->get_config('default_sale_class');
						$data['adduser']['status']='1';
						$data['adduser']['date_added']=date("Y-m-d H:i:s");
						
						
						$data['addsgin']['via']=$sns_user['via'];
						$data['addsgin']['uid']=$sns_user['uid'];
						if(isset($sns_user['location']) && !empty($sns_user['location'])){
							$data['addsgin']['location']=$sns_user['location'];
						}
						
						$this->sign_in_with_model->add_user_sign_in_with($data);
						$this->session->set_flashdata('success', ((isset($sns_user['nickname']) && !empty($sns_user['nickname'])) ? $sns_user['nickname'] : $sns_user['name']) . $provider.'注册并登陆成功！');
					}
					
					echo $this->refresh;
                   	echo $this->close;
				}
				else
				{
                    $this->session->set_flashdata('fali', '获取用户信息失败');
                    //redirect();
                    echo $this->refresh;
                    echo $this->close;
                    return;
				}
			}
			catch (OAuth2_Exception $e)
			{
                $this->session->set_flashdata('fali', '操作失败<pre>'.$e.'</pre>');
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