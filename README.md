# 我的tp5框架下写api模块示例
## 由于api模块设计接口数据返回，安全处理，APP交互json处理，异常处理等
### 数据返回：
	- 移动开发中，最常见的的就是json数据结构
	- tp5对json支持调优了，配置文件可以单独设置，json()方式也可以处理返回值数据结构
	- 常见返回格式如下：status:0,message:'操作成功',data:[]
