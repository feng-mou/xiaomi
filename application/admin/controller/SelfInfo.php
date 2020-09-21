<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\session;
    class SelfInfo extends Base{
        public function index(){
            //获得用户信息
            $name_id=session::get('name_id');
            $information=Db::name('user')->where('id',$name_id)->select();
            //var_dump($information);
            $this->assign('information',$information);
            //把商品导航栏放进去
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            return $this->fetch('./self_info');
        } 
    }
?>