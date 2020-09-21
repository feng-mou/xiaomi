<?php 
    namespace app\admin\controller;
    use think\Controller;
    use think\Db;
    use think\Cache;
    class Redis extends Controller{
        public function index(){
            $user_arr=Db::name('user')->select();
            if(!Cache::has('str')){
                 var_dump(Cache::set('str','this is redis_str'));
            }else{
                var_dump(Cache::get('str'));
            }
  
            return $this->fetch('./redisTest');
        }
    }
?>