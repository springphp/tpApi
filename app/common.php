<?php

// 应用公共文件

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
		'status'	=> $status,
		'message'	=> $message,
		'data'		=> $data,
		'time'		=> date('Y-m-d H:i:s'),
		'ext'		=> $ext
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