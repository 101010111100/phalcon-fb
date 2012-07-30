<?
require_once(__DIR__ . '/api/facebook.php');

class FB extends Facebook {
 	
	public $uid;
	public $session;
	
	function __construct($options=array()) {
		if (empty($options['cookie'])) {
			$options['cookie'] = 0;
		}
		$options = array_merge(array('appId' => $config->facebook->appId, 'secret' => $config->facebook->secret, 'domain' => $config->site->domain), $options);
		parent::__construct($options);
		$this->uid = $this->getUser();
	}
	
	function login($next = '') 
	{
		if (empty($this->uid)) {
			if (empty($next)) {
				$next = 'index.php';
			}
			
			$url = $this->getLoginUrl(array(
						  'redirect_uri' =>  $config->facebook->appUrl .'/'. $next, // indicamos la url de la app
						  'scope' => $config->facebook->scope
			           ));
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			exit();
		}
		//if (empty($_SESSION[FB_SESSION_TOKEN])) {
		//	$_SESSION[FB_SESSION_TOKEN] = $this->getAccessToken();
		//}
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		
	}

	function me($options = array())
	{
		$datos = $this->exec("/me", $options);
		return $datos;
	}

	function is_no_fan($redirect = "index.php")
	{
		if (!$this->is_fan()) {
			header("location:". $redirect);
			exit();
		}
	}
	
	function is_fan($redirect = null)
	{
		$data = $this->exec("/me/likes", array('fields' => 'id,name'));
		foreach ($data['data'] as $item) {
			if ($item['id'] == $config->facebook->pageId && empty($redirect)) {
				return true;
			} elseif ($item['id'] == $config->facebook->pageId && !empty($redirect)) {
				header("location:". $redirect);
				exit();
			}
		}
		return false;
	}
	
	function get_fanpage_id($name)
	{
		$data = $this->exec("/me/likes", array('fields' => 'id,name'));
		foreach ($data['data'] as $item) {
			if (strtolower($item['name']) == strtolower($name)) {
				return $item['id'];
			}
		}
		return false;
	}
	
	function post_wall($options = array())
	{
		$this->api('/me/feed', 'POST', $options);
	}
	
	function get_all_fanpages()
	{
		var_dump($this->api("/me/likes?fields=id,name"));
		exit();
	}
	
	function get_info($uid, $options = array())
	{
		$datos = $this->exec('/'.$uid, $options);
		return $datos;
	}
	
	function get_friends($options = array())
	{
		$datos = $this->exec('/me/friends', $options);
		return $datos['data'];
	}

	function is_friend($uid)
	{
		$datos = $this->exec('/me/friends', array('fields' => 'id'));
		foreach ($datos['data'] as $item) {
			if ($item['id'] == $uid) {
				return true;
			}
		}
		return false;
	}

	function prepare_options($options)
	{
		$get_url_params = array();
		
		foreach ($options as $key => $value) {
			$get_url_params[] = $key ."=". $value;
		}
		
		if (count($get_url_params) > 0) {
			return "?". implode("&", $get_url_params);
		} else {
			return "";
		}
		
	}
	
	function exec($path, $options)
	{
		$query_string = $this->prepare_options($options);
		$datos = $this->api($path.$query_string);
		return $datos;
	}
}

?>