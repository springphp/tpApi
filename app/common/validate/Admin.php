<?php
namespace app\common\validate;
use think\Validate;

class Admin extends Validate{
	 protected $rule = [
        ['account',     'require|unique:Admin|alphaDash|length:6,30|regex:^[a-zA-z]+\w+',                        '帐号不能为空|帐号已存在|帐号只允许字母、数字和下划线 破折号|帐号长度为5-50个字符|帐号必须以字母开头'],
        ['nickname',     'length:6,30',                    '昵称长度需在6-21个字符之间'],
        ['password',    'require',                          '密码不能为空'],
        ['phone',       ['regex'=>'/^1[3|4|5|7|8][0-9]{9}$/','unique:Admin','require'],    '手机格式错误|手机号已存在|手机号不能为空'],
        ['email',       'email|unique:Admin|require',                       '邮箱格式错误|邮箱已存在|邮箱不能为空'],
        
    ];
    protected $scene = [
        'add'   =>  ['account','nickname','password','phone','email'],
        'edit'	=>	['phone','email'],
    ];    
}