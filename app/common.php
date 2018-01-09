<?php
use think\Image;
use think\Session;
use think\Request;

/* $name  string    为type="file"的input框的name值
* $file string     存在图片的文件夹 (文件夹必须在upload之下)
* return  string   返回图片的文件夹和名字
* */
function upload_img($name,$file){
    $up_dir = "./upload/$file";
    if (!file_exists($up_dir)) {
        mkdir($up_dir, 0777, true);
    }
    $image = Image::open(request()->file($name));//打开上传图片
    $size = input('avatar_data');//裁剪后的尺寸和坐标
    $size_arr=json_decode($size,true);
    $type= substr($_FILES [$name]['name'],strrpos($_FILES [$name]['name'],'.')+1);
    $name = time().".".$type;
    $info =$image->crop($size_arr['width'], $size_arr['height'],$size_arr['x'],$size_arr['y'])->save("./upload/$file/$name");
    if($info){
       return $file."/".$name;
    }else{
        return false;
    }
}

/**
 *  获取10位以上不重复的随机字符串
 */
function getUniqueStr($length=16,$param='',$start=''){
    if ($length<10) return '';
    $mstime = (int)($_SERVER['REQUEST_TIME_FLOAT']*1000);
    $str    = strtoupper(md5($param.$start.$mstime));
    $count  = $length - strlen($param) - strlen($start);
    if ($count<=4){
        $un_str = substr($str,0,$count);
    } else {
        $un_str  = substr($mstime,-($count-4),$count-4);
        $un_str  .= substr($str,0,4);
    }
    return  $start.$param.$un_str;
}

/**
 * 获取文件处理时间
 * create 创建时间
 * edit   编辑时间
 * active 访问时间
 * by chick 2017-05-03
 */
function getFileTime($file,$act = 'edit'){
    if (!is_file($file)) return false;
    switch($act){
        case 'create':
            $time = filectime($file);break;
        case 'edit':
            $time = filemtime($file);break;
        case 'active':
            $time = fileatime($file);break;
        default:
            $time = filemtime($file);break;
    }
    return $time;
}

/**
 *低版本的array_column函数
 */
if(!function_exists('array_column')){
    function array_column($input, $columnKey, $indexKey = NULL){
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();
        foreach ((array)$input AS $key => $row){
            if ($columnKeyIsNumber){
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }else{
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull){
                if ($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }else{
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }
}

/**
 * model查出来的数组对象转为数据数组
 * by chick 2017-05-02
 */
function resultToArray(&$results){
    foreach ($results as &$result) {
        $result = $result->getData();
    }
}

/**
 * 创建Tree对象
 * by chick 2017-05-03
 */
function getTree($data,$options=[],$level=0){
    return new \extend\Tree($data,$options,$level);
}

function getNamebyPk($model,$pk_name,$getField,$pk_value){
    return  model($model)->where([$pk_name=>$pk_value])->find()->$getField;
}

/**
 * 创建Api对象
 * by chick 2017-05-05
 */
function Api($type = '',$setApi=false){
    $app_debug = config('app_debug');
    $api = new \app\common\controller\Api($app_debug);
    return $api->setType($type,$setApi);
}

/**
 * 获取图片用于显示
 */
function getImg($imgName,$isUrl=false){
    if ($isUrl) {
        $url = $imgName;
    } else {
        $url   = Request::instance()->domain().'/upload/'.$imgName;
        $url_t  = ROOT_PATH.'public/upload/'.$imgName;
    }
    if (!is_file($url_t)) {
        $url = Request::instance()->domain().'/upload/'.config('default_img');
        $url_t = ROOT_PATH.'public/upload/'.config('default_img');
        $url = is_file($url_t) ? $url : Request::instance()->domain().'/static/img/default1.jpg';
    }
    return $url;
}

/**
 * html模版文件是否存在
 */
function htmlFileExists($html){
    $path = config('template.view_path').MODULE_NAME.'/'.$html.'.'.config('template.view_suffix');
    return file_exists($path);
}

/**
 * 判断值是否为空
 */
function isValue($data,$key=false){
    if ($key !== false) {
        if(!is_array($data)) return false;
        if(!array_key_exists($key,$data)) return false;
        $v = $data[$key];
    } else {
        $v = $data;
    }
    if ($v === 0 || $v === '0') return true;
    if($v != '') return true;
    if (is_array($v) && $v !=[]) return true;
    return false;
}

/** Json数据格式化
* @param  Mixed  $data   数据
* @param  String $indent 缩进字符，默认4个空格
* @return JSON
*/
function jsonFormat($data, $indent=null){

    // 对数组中每个元素递归进行urlencode操作，保护中文字符
    array_walk_recursive($data, 'jsonFormatProtect');

    // json encode
    $data = json_encode($data);

    // 将urlencode的内容进行urldecode
    $data = urldecode($data);

    // 缩进处理
    $ret = '';
    $pos = 0;
    $length = strlen($data);
    $indent = isset($indent)? $indent : '    ';
    $newline = "\n";
    $prevchar = '';
    $outofquotes = true;

    for($i=0; $i<=$length; $i++){

        $char = substr($data, $i, 1);

        if($char=='"' && $prevchar!='\\'){
            $outofquotes = !$outofquotes;
        }elseif(($char=='}' || $char==']') && $outofquotes){
            $ret .= $newline;
            $pos --;
            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $ret .= $char;

        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){
            $ret .= $newline;
            if($char=='{' || $char=='['){
                $pos ++;
            }

            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $prevchar = $char;
    }

    return $ret;
}

/** 
 * 将数组元素进行urlencode
* @param String $val
*/
function jsonFormatProtect(&$val){
    if($val!==true && $val!==false && $val!==null){
        $val = urlencode($val);
    }
}

/**
 * 获取 后台用户名称
 * @return [type] [description]
 */
function get_login_user_name(){
    return session('user.nickname') ?:session('user.account');
}

/**
 * 获取 后台分组名称
 * @return [type] [description]
 */
function get_login_admin_group(){
    $group = session('user.group');
    if (!$group) { return;}
    $name = model('auth_group')->where(['group_id'=>$group])->value('group_name');
    return $name;
}

/**
 * 获取含域名的url
 */
if (!function_exists('urldo')) {
    /**
     * Url生成
     * @param string        $url 路由地址
     * @param string|array  $vars 变量
     * @param bool|string   $suffix 生成的URL后缀
     * @param bool|string   $domain 域名
     * @return string
     */
    function urldo($url = '', $vars = '', $suffix = true, $domain = true)
    {
        return url($url, $vars, $suffix, $domain);
    }
}

/**
 * 随机纯数字字符串
 * @param  [number] $length [字符串长度]
 * @return [string]         [字符串]
 * wanggang
 */
function make_code($length){
    $output='';
    for ($i = 0; $i < $length; $i++) {
    $output .= rand(0, 9); //生成php随机数
    }
    return $output;
}

/**
 * thikphp5 已删除C/D/U/M/W/I等函数
 * 重写单字母函数C/D/U/M/W/I
 * by chick 2017-05-02
 */
function C($name = '', $value = null, $range = ''){
    return config($name, $value, $range );
}
function D($name = '', $layer = 'model', $appendSuffix = false){
    return model($name, $layer, $appendSuffix);
}
function M($name = '', $config = [], $force = true){
    return db($name, $config, $force);
}
function U($url = '', $vars = '', $suffix = true, $domain = false){
    return url($url, $vars, $suffix, $domain);
}
function W($name, $data = []){
    return widget($name, $data);
}
function I($key = '', $default = null, $filter = ''){
    return input($key, $default, $filter);
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 获取分页参数设置 前后台可用
 * @param  [type] $listRows [description]
 * @return [type]           [description]
 */
function _pageconfig($listRows){
    config(['paginate'=>['type'=>'bootstrap1','list_rows'=> listRows,'var_page'=>'page',]]);
    Session::set('pageSize', config('paginate.list_rows'));
}

/*-------------------- api接口方法 --------------------*/

/**
 * 接口访问 返回值
 * @param  integer $status   [description]
 * @param  string  $message  [description]
 * @param  [type]  $data     [description]
 * @param  [type]  $ext      [description]
 * @param  integer $httpCode [description]
 * @return [type]            [description]
 */
function show( $status = 1, $message = '', $data = [], $ext = [], $httpCode = 200){
    $responseData = [
        'status'    => $status,
        'message'   => $message,
        'data'      => $data,
        'time'      => date('Y-m-d H:i:s'),
        'ext'       => $ext
    ];
    return json($responseData,$httpCode);
}

/**
 * api 定位器 D方法的重写+api版本控制
 * @param [type] $controllerName [description]
 * @param [type] $layer          [description]
 */
function D( $controllerName, $layer ){
    $name = config('app_api.app_version').'.'.$controllerName;
    return model($name, $layer);
}

/**
 * 写文件
 * @param array  $data     [description]
 * @param string $filePath [description]
 */
function F( $data = array(), $filePath = '' ){
    if( empty($data) ) $data = $_SERVER;
    //添加日志生成时间
    if( is_array($data) ){
        $data['req_log_time'] = date('Y-m-d H:i:s');
    }elseif (is_object($data)) {
        $data->req_log_time   = date('Y-m-d H:i:s');
    }
    
    if( empty($filePath) ) {
        $filePath = '../log_file/log.txt';
    }else{
        $filePath = '../log_file/'.$filePath;
    }
    if(!file_exists($filePath)) 
        mkdir( dirname($filePath),0777,true);

    $f = fopen($filePath, 'a+');
    $br = "\n----------------------------------------------\n";
    fwrite($f, var_export($data,true).$br);
    fclose($f);
}

/*-------------------- api接口方法 --------------------*/
