<?php 
    namespace app\admin\Controller;
    use think\Controller;
    class Base extends Controller{
        public function _initialize(){
            if(session('name') == null){
                $this->success('还没有登录', 'admin/login/index');
            }
        }
    }
?>