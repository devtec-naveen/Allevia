<?php
	
if(!is_callable('http_response_code')) {
	function http_response_code($code) {
		header(':', true, $code);
	}
}

class Framework {

	//some important variables
	protected static $ajax, $output, $routes, $routeAuth, $data, $inlineScripts;
	public static $css = array(), $js = array(), $elements = array(), $cmd;
	protected static $layout = 'default', $environment = '', $static_version = '';
	protected static $title = '', $meta = array('desc' => '', 'words' => '');
	public static $route, $dir = array(), $url = array(), $globals = array(), $conf, $req;
	public static $compare_dirs = array('base', 'app');
	
	//initialize the framework!
	public static function _init() {
		//set up our directories and stuff
		static::$dir['app'] = APP_PATH;
		static::$dir['base'] = FRAMEWORK_PATH;
		static::$dir['classes'] = static::$dir['base'] . 'classes/';
		static::$dir['includes'] = static::$dir['base'] . 'includes/';
		static::$dir['config'] = static::$dir['app'] . 'config/';
		static::$dir['cmd'] = static::$dir['app'] . 'cmd/';
		static::$dir['emails'] = static::$dir['app'] . 'emails/';
		static::$url['app'] = '/';//WEBROOT;
		static::$url['base'] = /*WEBROOT .*/ '/framework/';
		static::$url['js'] = static::$url['base'] . 'js/';
		static::$url['css'] = static::$url['base'] . '/css/';
		
		//get the config
		static::get_config();
		
		//Admin URL - this can be changed by the config.
		static::$url['admin'] = static::$url['app'] . static::$conf['admin-route'] . '/';

		//Command line?
		static::$cmd = PHP_SAPI === 'cli'; #(!empty($_SERVER['BASH']) or !empty($_SERVER['USER']));

		//Let's trim, and stripslashes all of the user data
		array_walk_recursive($_POST, function(&$x) {$x = stripslashes(trim($x));});
		array_walk_recursive($_GET, function(&$x) {$x = stripslashes(trim($x));});
		array_walk_recursive($_COOKIE, function(&$x) {$x = stripslashes(trim($x));});
		array_walk_recursive($_REQUEST, function(&$x) {$x = stripslashes(trim($x));});

		//Set up the DB if credentials are provided.
		if(!empty(static::$conf['database']))
			static::globals('DB', Helper::Database(static::$conf['database']));

		//start the session
		$handler = new DBSessionHandler();
		session_set_save_handler($handler, true);
		session_start();
		
		//Set up authorization stuff and check if the user is logged in
		if(!empty(static::$conf['auth'])) {
			Auth::check();
			static::globals(array('me' => Auth::$data, 'logged' => Auth::$logged));
		}

		Hooks::initEnd();
	}
	
	//use for loading elements, HTML snippits we like to reuse
	public static function element($_name, $_data = null, $_map = false) {
		if(!array_key_exists($_name, static::$elements)) {
			$_file = static::dir('elements/' . $_name . '.php', 'compare');
			if(file_exists($_file))
				static::$elements[$_name] = '?>' . file_get_contents($_file);
			else
				static::error("Referenced element file '" . $_name . "' doesn't exist!");
		}
		if($_map) {
			$_return = array();
			foreach($_data as $v)
				$_return[] = static::element($_name, $v);
			return $_return;
		} else {
			extract(static::$globals, EXTR_REFS);
			if(is_array($_data))
				extract($_data, EXTR_SKIP);
			ob_start();
			eval(static::$elements[$_name]);
			return ob_get_clean();
		}
	}
	
	//set which layout to use for the requests
	public static function layout($name = null) {
		if(is_null($name))
			return static::$layout;
		else if($name === true) {
			$_file = static::dir('layouts/' . static::$layout . '.php', 'compare');
			extract(static::$globals, EXTR_REFS);
			if(file_exists($_file))
				require $_file;
			else
				static::error("Referenced layout file '" . static::$layout . "' doesn't exist!");
		} else 
			static::$layout = $name;
	}
	
	//set global variables, which are passed to all elements, helpers, and usable in pages and AJAX requests too
	public static function globals($x, $y = null) {
		if(is_array($x))
			foreach($x as $i => $v)
				static::globals($i, $v);
		else if(!isset($y))
			return static::$globals[$x];
		else {
			static::$globals[$x] = $y;
			if(get_called_class() == 'Ajax')
				$this->$x =& static::$globals[$x];
		}
	}
	
	//set which environment to use
	public static function environment($name = null) {
		if(is_null($name))
			return static::$environment;
		static::$environment = $name;
	}
	
	//set which environment to use
	public static function static_version($name = null) {
		if(is_null($name))
			return static::$static_version;
		static::$static_version = $name;
	}

	//use for loading and initializing the various helper classes
	public static function helper($helper, $conf = null) {
		return new $helper($conf);
	}
	
	//main request routing function
	public static function request() {
		//set up some variables
		static::$ajax = $_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest' || $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		if(static::$cmd) {
			array_shift($_SERVER['argv']);
			static::$req = array_shift($_SERVER['argv']);
			static::$data = $_SERVER['argv'];
		} else {
			static::$req = preg_replace('/' . static::$conf['ext'] . '$/', '', $_GET['_framework_path']);
			static::$data = explode('/', static::$req);
		}
		
		//We want to Gzip!
		ob_start();
		
		//we're running something from the command line
		if(static::$cmd) {
			header('Content-type: text/plain; charset=UTF-8');
			static::layout('cmd');
			ob_start();
			require static::dir(static::$req . '.php', 'cmd');
			static::$output = ob_get_clean();
			static::layout(true);
		}
		//you don't want HTML?  let's give you JSON then!
		else if($_GET['_framework_ajax']) {
			header('Content-type: application/json; charset=UTF-8');
			Hooks::beforeAjax();
			static::ajax(static::$req, $_POST);
		} 
		//nope, just HTML then
		else {
			header('Content-type: text/html; charset=UTF-8');
			Hooks::beforeLoad();
			static::content();
			static::layout(true);
		}
		
		ob_end_flush();
	}
	
	//which route are we matching?
	private static function route() {

		foreach(static::$routes as $route) {
			if(!is_array($route))
				$route = array($route);
			
			//if it's an empty page, we want it to be anything!
			if(empty($route[1]))
				$route[1] = static::$data[0];
				
			//are they both empty?
			if($route[0] == '' and static::$req == '')
				return $route[1];
			//it's regex!
			else if(Is::regex($route[0])) {
				if(preg_match($route[0], static::$req))
					return $route[1];
			} 
			//it's a closure!
			else if(!is_string($route[0]) and is_callable($route[0])) {
				if($x = $route[0](static::$req, static::$data))
					return is_bool($x) ? $route[1] : $x;
			}
			//an array
			else if(is_array($route[0]) && in_array(static::$req, $route[0]))
				return $route[1];
			//just a boring old string...
			else {
				#if(@strpos(static::$req, $route[0]) === 0)
				
				if($route[0] == static::$data[0])
					return $route[1] ? : $route[0];
			}
		}
		return 'error';
	}

	//does the route require authentication?
	public static function routeAuth($route) {
		foreach(static::$routeAuth as $key => $auth) {
			if(!is_array($auth) || !$auth['routes'])
				continue;
			if($auth['routes'] === true || in_array($route, $auth['routes']))
				return Auth::route($key);
		}

		return false; //we don't need to authenticate
	}
	
	//figure out which page to load, and load it
	private static function content() {
		ob_start();
		//match the route
		$route = static::$route = static::route();
		//do we need to authenticate?
		if(static::routeAuth($route))
			return;
		extract(static::$globals, EXTR_REFS);
		//does the page exist?
		if(file_exists(static::dir('pages/' . $route . '.php', 'compare')))
			require static::dir('pages/' . $route . '.php', 'compare');
		//nothing, so it's an error!
		else
			require static::dir('pages/error.php', 'compare');

		$content = ob_get_clean();
		preg_match_all("#<script>(.+?)</script>#s", $content, $scripts);

		static::$inlineScripts = $scripts[1];
		static::$output = preg_replace("#<script>(.+?)</script>#s", "", $content);
	}
	
	//function to route AJAX requests
	private static function ajax($act, $data) {
		die(new Ajax($act, $data));
	}
	
	//generate the title for a page
	private static function title($x = null) {
		if($x) {
			static::$title = $x;
			return;
		}
		return static::$title ?: static::$conf['title'];
	}
	
	//and meta data
	private static function meta($type, $x = null) {
		// if($type != 'words' && $type != 'desc') {
		// 	static::error('Invalid meta field set!  Only use words or desc.');
		// 	return;
		// }
		if($x) {
			static::$meta[$type] = $x;
			return;
		}
		return static::$meta[$type] ?: static::$conf['meta'][$type];
	}
	
	//Force a reload on static items.
	public static function cache_break() {
		//return (static::static_version()) ? '_v' . static::static_version() . '/' : '';
		return (static::static_version()) ? '?_t=' . static::static_version() : '';
	}
	
	//add resources to be included in the header
	public static function resource($x, $y = '', $type = null, $return = false, $full = true) {
		if(!$type)
			$type = static::match_ext($x);
		if(!$y)
			$y = 'app';
		$static = $y != 'ext' ? static::cache_break() : '';
$full = $y != 'ext' ? static::cache_break() : '';
//anuj
		// $full = $full && strpos($x, 'http') !== 0;
 
		if($type == 'css') {
			$url = static::url(($y != 'ext' ? 'css/' : '') . $x . $static, $y, $full);
			if($return)
				return $url;
			else
				static::$css[] = $url;
		} else if($type == 'js' || $type == 'js-min') {
			$url = static::url(($y != 'ext' ? $type . '/' : '') . $x . $static, $y, $full);
			if($return)
				return $url;
			else
				static::$js[] = $url;
		} else if($type == 'images')
			return static::url(($y != 'ext' ? 'images/' : '') . $x . $static, $y, $full);
	}
	
	//Redirect us places!
	public static function redirect($x = '') {
		header('Location: ' . (preg_match("/^https?\:\/\//i", $x) ? $x : static::url($x)));
		exit;
	}
	
	//URL-generating function
	public static function url($x, $y = null, $full = false) {
		if(!$y)
			$y = static::match_ext($x);
		if($y == 'app')
			$x .= static::$conf['ext'];
		$url = static::$url[$y] . $x;
      if($full) {
			if(substr(WEBROOT, -1, 1) === '/' && substr($url, 0, 1) === '/')
				$url = substr($url, 1);
			$url = /*'http' . (self::$conf['https'] ? 's' : '') . ':' . */ WEBROOT . $url;
		}


	 // return $url;


	if(!$full)
		return '/financhill'.$url;		
	else  return $url;
 
	}
	
	//path-generating function
	public static function dir($x, $y = 'base') {
		if($y == 'compare') {
			$dirname = dirname($x);
			$basename = basename($x);
			foreach(array_reverse(static::$compare_dirs) as $dir) {
				if(!static::$dir[$dir])
					static::$dir[$dir] = dirname(static::$dir['base']) . '/' . $dir . '/';
				if(file_exists(static::dir($x, $dir)))
					return static::dir($x, $dir);
			}
			return "";
		} else {
			return static::$dir[$y] . $x;
		}
	}
	
	//match extensions so we know which folder the files are in
	private static function match_ext($x) {
		$ext = pathinfo($x, PATHINFO_EXTENSION);
		switch($ext) {
			case 'css':
			case 'js':
				$y = $ext;
				break;
			case 'less':
				$y = 'css';
				break;
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
			case 'ico':
			case 'svg':
				$y = 'images';
				break;
			default:
				$y = 'app';
				break;
		}
		return $y;
	}
	
	//function to load the config files
	private static function get_config() {
		$conf = $routes = array();
		//first we include all the default config
		require static::dir('config.php');
		//then the app's config, as to override stuff
		require static::dir('config.php', 'app');

		static::$conf = $conf;
		static::$routes = $routes;
		static::$routeAuth = $routeAuth;
	}
	
	//read and write session and cookie data
	public static function cookie($x, $y = null) {
		if(is_array($x))
			foreach($x as $i => $v)
				static::cookie($i, $v);
		else if(is_null($y))
			return $_COOKIE[static::$conf['cookie']['prefix'] . $x];
		else {
			$_COOKIE[static::$conf['cookie']['prefix'] . $x] = $y;
			setcookie(static::$conf['cookie']['prefix'] . $x, $y, time() + static::$conf['cookie']['duration']*86400, static::$conf['cookie']['path'], static::$conf['cookie']['domain'], static::$conf['cookie']['secure']);
		}
	}
	
	public static function session($x, $y = null) {
		if(is_array($x))
			foreach($x as $i => $v)
				static::session($i, $v);
		else if(is_null($y))
			return $_SESSION[static::$conf['session']['prefix'] . $x];
		else
			$_SESSION[static::$conf['session']['prefix'] . $x] = $y;
	}
	
	//throw errors
	public static function error($m) {
		//Useful::pre(debug_backtrace());
		//trigger_error($m, E_USER_ERROR);
		throw new Exception($m);
		exit;
	}
	
	//check if it's a mobile browser - borrowed from detectmobilebrowsers.com
	public static function is_mobile($agent = null) {
		if(!$agent)
			$agent = $_SERVER['HTTP_USER_AGENT'];
		return (preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $agent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($agent,0,4)));
	}
	
	//headers for static files we generate
	private static function headers($mime, $date, $lifespan = 15) {
		header("Content-type: " . $mime);
		if(static::environment() != 'prod') {
			header("Cache-Control: max-age=0, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: " . date("D, j M Y G:m:s", time() - 999999) . " GMT");
		} else {
			header("Cache-Control: max-age=" . ($lifespan*86400) . ", must-revalidate");
			header("Pragma: cache");
			header("Expires: " . date("D, j M Y G:m:s", time() + $lifespan*86400) . " GMT");
		}
		header("Last-Modified: " . date("D, j M Y G:m:s", $date) . " GMT");
	}

	//function to set proper headers and initiate a file download
	public static function download($filename, $contents = false) {
		if(!$contents)
			$contents = file_get_contents($filename);
		$filename = basename($filename);
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: application/octet-stream;');
		echo $contents;
		exit;
	}

	//Parse and cache Markdown-formatted files
	public static function markdown($filename, $force = false) {
		$file = static::dir('markdown/' . $filename . '.md', 'app');
		$cache = static::dir('markdown/cache/' . $filename . '.html', 'app');
		if(!file_exists($file))
			static::error("Markdown file '" . $file . "' was not found.");
		if(!$force) {
			if(!file_exists($cache) || filemtime($cache) < filemtime($file))
				$force = true;
		}
		if($force) {
			$output = static::markdownParse(file_get_contents($file));
			file_put_contents($cache, $output);
		} else
			$output = file_get_contents($cache);
		return $output;
	}

	//Parse strings of Markdown
	public static function markdownParse($text) {
		$md = new \Michelf\Markdown;
		$md->empty_element_suffix = ">";
		return $md->transform($text);
	}
	
}

spl_autoload_register(function($class) {
	static $aws_base = false;
	if($class === 'Michelf\Markdown')
		$class = 'Markdown';

	if($class === 'App') {
		$x = APP_PATH . 'classes/App.php';
	} else if(strpos($class, 'Amazon') === 0) {
		if(!$aws_base) {
			$aws_base = true;
			require App::dir('sdks/aws/sdk.class.php', 'base');
		}
		$x = App::dir('sdks/aws/services/' . strtolower(str_replace("Amazon", "", $class)) . '.class.php', 'base');
	} else {
		$x = App::dir('classes/' . str_replace('\\', '/', $class) . '.php', 'compare');
	}

	if(file_exists($x))
		require $x;
});

class Helper {
	public static function __callStatic($method, $args) {
		if(count($args) == 1)
			$args = $args[0];
		$method = str_replace('_', '/', $method);
		return App::helper($method, $args);
	}
}

class Element {
	public static function __callStatic($method, $args) {
		if(count($args) == 1)
			$args = $args[0];
		$method = str_replace('_', '/', $method);
		if(substr($method, -3) == 'Map') {
			$map = true;
			$method = substr($method, 0, -3);
		} else
			$map = false;
		return App::element($method, $args, $map);
	}
}

class Globals extends App {
	public static function __callStatic($method, $args) {
		return parent::globals($method, $args[0]);
	}
}

App::_init();
