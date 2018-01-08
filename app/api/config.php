<?php

return [
	// 默认输出类型
    'default_return_type'    => 'json',
    // 异常处理handle类 留空使用 \think\exception\Handle
    // 'exception_handle'       => '\app\api\common\lib\exception\ApiHandleException',


    //接口参数
    'app_api'	=>[
    	'apiKey'		=> 'iwater123456',
    	'secrectCode'	=> '4de43a3abf792807c86fb040152530c1',
        //请求时间
        'request_time'  => '10',
        //app版本号
        'app_version'   => 'v1'
    ],
];