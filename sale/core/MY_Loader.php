<?php
class MY_Loader extends CI_Loader
{
 	protected $_ci_extensions 		= array();

 	protected $_ci_extension_paths  = array();
 	
 	public function __construct()
    {
        
        parent::__construct();
        load_class('Extension','core');
        $this->_ci_extension_paths = array(APPPATH);
    }
    
    /**
     * extension Loader
     * 
     * This function lets users load and instantiate classes.
	 * It is designed to be called from a user's app controllers.
	 *
	 * @param	string	the name of the class
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
     */
    public function extension($extension = '', $params = NULL, $object_name = NULL)
    {
        if(is_array($extension))
        {
            foreach($extension as $class)
            {

                $this->extension($class, $params);
            }
            
            return;
        }
        
        if($extension == '' or isset($this->_ci_extensions[$extension])) {
            return FALSE;
        }
 
        if(! is_null($params) && ! is_array($params)) {
            $params = NULL;
        }
        
        $subdir = '';
 
        // Is the extension in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($extension, '/')) !== FALSE)
        {
                // The path is in front of the last slash
                $subdir = substr($extension, 0, $last_slash + 1);
 
                // And the extension name behind it
                $extension = substr($extension, $last_slash + 1);
        }
        
        foreach($this->_ci_extension_paths as $path)
        {
        	$extension=ucfirst($extension);
        	
            $filepath = $path .'controllers/extension/'.$subdir.$extension.'.php';
            
            if ( ! file_exists($filepath))
            {
                continue;
            }
            
            include_once($filepath);
            
            $extension = strtolower($extension);
 
            if (empty($object_name))
            {
                $object_name = $extension;
            }
            
            $extension = ucfirst($extension);
            $CI = &get_instance();
            if($params !== NULL)
            {
                $CI->$object_name = new $extension($params);
            }
            else
            {
                $CI->$object_name = new $extension();
            }
            
            $this->_ci_extensions[] = $object_name;
            
            return;
        }
    }
}