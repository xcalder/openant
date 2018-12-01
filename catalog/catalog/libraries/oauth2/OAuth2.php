<?php
include('Exception.php');
include('Token.php'); 
include('Provider.php');

/**
 * OAuth2.0
 *
 * @author Phil Sturgeon < @philsturgeon >
 */
class OAuth2 {

	public static function provider($name, array $options = NULL)
	{
		$name = ucfirst(strtolower($name));

		include_once 'Provider/'.$name.'.php';

		$class = 'OAuth2_Provider_'.$name;

		return new $class($options);
	}

}