<?php
/**	
 * @author lxrmido@lxrmido.com
 */
class IO{

	/* 
	 * 获取$_REQUEST中的变量
	 * @param string $var_name 变量名, $_REQUEST[$var_name]
	 * @param var    $pre_set  预设值，当此值不为null且$_REQUEST[$var_name]不为空时返回预设值
	 * @param string $var_type 变量类型，可为：'string'、'uint'、'bool'、'int'、'date'、'html'
	 *                                   string : 返回为字符串
	 *                                   int    : 返回为整数
	 *                                   date   : 将字符串或者整数规格化为时间戳
	 * @return $var
	 */
	public static function I($var_name, $pre_set = null, $var_type = 'string'){
		return self::r($var_name, $pre_set, $var_type);
	}
	/*
	 * 返回信息
	 * 当此方法在AJAX响应中被调用时，将抛出JSON编码的返回信息
	 * 被直接访问时，以HTML格式输出返回信息
	 * 在IO::M()中调用时，将返回PHP变量
	 *
	 * @param int $code 错误码 大于0时表示正确返回，不大于0时表示出错返回
	 * @param var $args 返回参数，当错误码不大于0时，此参数为表示出错原因的字符串;
	 *                            当错误码大于0时，此参数为包含返回值的一个array()
	 */
	public static function O($code = 1, $args = array()){
        if(!is_integer($code)){
            $args = $code;
            $code = 1;
        }
		if($code < 1){
			self::e($code, $args);
		}else{
			self::ret($code, $args);
		}
	}
	/*
	 * 调用方法，同级调用AJAX方法，其返回值将以PHP数组形式返回
	 * @param  string $method_name 要调用的方法名称
	 * @return var $return_value
	 */
	public static function M($method_name){
		return self::method($method_name);
	}

	################################################################################
	################################################################################
	################################################################################
	################################################################################

	public static function h($type = 'text/html'){
		header("Content-Type:$type; charset=utf-8");
	}
	public static function e($code = -1, $message = '出错！'){
		if(is_string($code)){
			$message = $code;
			$code    = -1;
		}
		$error = array(
			'code'    => $code, 
			'message' => $message,
			'throw'   => 'null'
		);
		self::error($error);
	}
	public static function r($item, $val = null, $type = 'string'){
		global $INNER_CALL;
		if($INNER_CALL){
			# 内部调用
			return self::argval($item, $val);
		}else{
			# JSON调用
			return self::request($item, $val, $type);
		}
	}
	public static function request($item, $val = null, $type = 'string'){
		if(empty($_REQUEST[$item])){
			if(isset($_REQUEST[$item])){
				switch($type){
				# 字符串
				case 'string':
				case 'html':
					return '';
				# 整数
				case 'uint':
				case 'int':
					return 0;
				# BOOL
				case 'bool':
					return false;
				# 时间日期
				case 'date':
					return 0;
				# 原值返回
				default:
					return $_REQUEST[$item];
				}
			}else{
				if($val !== null){
					# 返回预设值
					return $val;
				}else{
					global $LANGS;
					# 获取翻译
					$item = empty($LANGS[$item]) ? $item : $LANGS[$item];
					self::e(-1, "'$item' 值不能为空");
				}
			}
			
		}else{
			switch($type){
			# 字符串
			case 'string':
				return self::filt_string($_REQUEST[$item]);
			# HTML
			case 'html':
				return self::filt_html($_REQUEST[$item]);
			# 整数
			case 'uint':
				$r = intval($_REQUEST[$item]);
				if($r > 0){
					return $r;
				}else{
					return 0;
				}
			case 'int':
				return intval($_REQUEST[$item]);
			case 'bool':
				return intval($_REQUEST[$item]) === 1;
			# 时间日期
			case 'date':
				$date = str_to_time(addslashes(trim($_REQUEST[$item])));
				return $date ? $date : intval($date);
			# 原值返回
			default:
				return $_REQUEST[$item];
			}
		}
	}

	public static function filt_string($str){
		return preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/',
 '&\\1', addslashes(trim($str)));
	}

	public static function filt_html($str){
		return preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/',
 '&\\1', addslashes(trim(str_replace(array('&', '"', '<', '>'),
 array('&amp;', '&quot;', '&lt;', '&gt;'), $str))));
	}

	public static function filt_emoji($str){
		return self::remove_emoji($str);
	}

	public static function remove_emoji($str){
		$str = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $str);
	    $str = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $str);
	    $str = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $str);
	    $str = preg_replace('/[\x{2600}-\x{26FF}]/u',   '', $str);
	    $str = preg_replace('/[\x{2700}-\x{27BF}]/u',   '', $str);
		return $str;
	}

	public static function match_email($str){
		return preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $str) > 0;
	}

	public static function json_body(){
		if(empty($GLOBALS["HTTP_RAW_POST_DATA"])){
			return false;
		}
		$js = trim($GLOBALS["HTTP_RAW_POST_DATA"]);
		$o = ord($js);
		if($o !== 123 && $o !== 91){
			return false;
		}
		return json_decode($js, true);
	}

	public static function argval($item, $val = null){
		global $ARGS;
		if(empty($ARGS[$item])){
			return $val;
		}else{
			return $ARGS[$item];
		}
	}
	public static function ret($code = 1, $args = array()){
		$ret = array(
			'code'    => $code,
			'message' => 'ok',
			'args'    => $args
		);
		self::genret($ret);
	}

	public static function method($method){
		global $DIE_ON_ERROR;
		global $INNER_CALL;
		$DIE_ON_ERROR = false;
		$INNER_CALL   = true;
		try{
			include(lx_method($method));
		}catch(ReturnException $e){
			$DIE_ON_ERROR = true;
			return $e->ret;
		}
		return '';
	}

	public static function error($error){
		global $DIE_ON_ERROR;
		global $METHOD;
		global $JSON_IO;
        global $JSONP;
		if($DIE_ON_ERROR){
			if($JSON_IO){
				$error['throw'] = json_encode(
					array(
						'code'    => $error['code'],
						'message' => $error['message'],
                        'method'  => $METHOD['module'].'.'.$METHOD['method'],
                        'debug'   => $METHOD['debug']
					),
					JSON_UNESCAPED_UNICODE
				);
                if($JSONP){
                    self::h('text/javascript');
                    $error['throw'] = "{$METHOD['jsonp_handle']}({$error['throw']},'{$METHOD['jsonp_key']}')";
                }else{
                    self::h('application/json');
                }
			}else{
                self::h();
                if(class_exists('TPL')){
                	TPL::show('public/error', [
                		'error' => $error
                	]);
                	die();
                }else{
					$error['throw'] = "<h3>注意</h3><p>错误码：{$error['code']}</p><p>消息内容：{$error['message']}</p>";
                }
			}
			die($error['throw']);
		}else{
			throw new ReturnException($error);
		}
	}

	public static function add_to_debug($key, $value){
		global $METHOD;
		$METHOD['debug'][$key] = $value;
	}

	public static function genret($ret){
		global $DIE_ON_ERROR;
        global $METHOD;
		global $JSON_IO;
        global $JSONP;
		if($DIE_ON_ERROR){
			if($JSON_IO){
                $json_str = json_encode(
					array(
						'code'    => $ret['code'],
						'message' => $ret['message'],
						'args'    => $ret['args'],
                        'method'  => $METHOD['module'].'.'.$METHOD['method'],
                        'debug'   => $METHOD['debug']
					),
					JSON_UNESCAPED_UNICODE
				);
                if($JSONP){
                    self::h('text/javascript');
                    die("{$METHOD['jsonp_handle']}($json_str,'{$METHOD['jsonp_key']}')");
                }else{
                    self::h('application/json');
                    die($json_str);
                }
			}else{
                self::h();
				echo "<h3>结果</h3><p>消息码：{$ret['code']}</p><p>消息内容：{$ret['message']}</p>";
				echo "<h3>返回值</h3>";
				var_dump($ret['args']);
				die();
			}
		}else{
			throw new ReturnException($ret);
		}
	}
}