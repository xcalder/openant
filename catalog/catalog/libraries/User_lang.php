<?php  
/** User Language Class 获取/设置用户访问的页面语言，如果用户没有设置访问语言，则读取Accept-Language 
*   Date:   2014-05-26 
*   Author: fdipzone 
*   Ver:    1.0 
* 
*   Func: 
*   public  get               获取用户访问语言 
*   public  set               设置用户访问语言 
*   private getAcceptLanguage 获取HTTP_ACCEPT_LANGUAGE 
*/  
  
class User_lang{ // class start  
  
    private $name = 'userlang'; // cookie name  
    private $expire = 2592000;  // cookie expire 30 days  
  
  
    /** 初始化 
    * @param String $name   cookie name 
    * @param int    $expire cookie expire 
    */  
    public function __construct($name='', $expire=null){  
  
        // 设置cookie name  
        if($name!=''){  
            $this->name = $name;  
        }  
  
        // 设置cookie expire  
        if(is_numeric($expire) && $expire>0){  
            $this->expire = intval($expire);  
        }  
  
    }  
  
  
    /** 获取用户访问语言 */  
    public function get(){  
  
        // 判断用户是否有设置过语言  
        if(isset($_COOKIE[$this->name])){  
            $lang = $_COOKIE[$this->name];  
        }else{  
            $lang = $this->getAcceptLanguage();  
        }  
  
        return $lang;  
  
    }  
  
  
    /** 设置用户访问语言 
    * @param String $lang 用户访问语言 
    */  
    public function set($lang=''){  
  
        $lang = strtolower($lang);  
  
        // 只能是英文，简体中文，繁体中文  
        if(in_array($lang, array('en','sc','tc'))){  
            setcookie($this->name, $lang, time()+$this->expire);  
        }  
  
    }  
  
  
    /** 获取HTTP_ACCEPT_LANGUAGE */  
    private function getAcceptLanguage(){  
  
        $lang = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);  
  
        if(in_array(substr($lang,0,5), array('zh-tw','zh_hk'))){  
            $lang = 'tc';  
        }elseif(in_array(substr($lang,0,5), array('zh-cn','zh-sg'))){  
            $lang = 'sc';  
        }else{  
            $lang = 'en';  
        }  
  
        return $lang;  
  
    }  
  
  
} // class end  
  
?>  