<?php
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;
/**
 * 管理员模型
 * @author 
 * @version wanggang 2017/5/13
 */
class Auth extends Model{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $readonly = [];//只读字段

    public function index(){}
}