<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    class Index extends Base{
        /*
         2020年9月1日
                        小米商城页面
         */
        public function index(){
            $arr=Db::name('class')->select();
            $this->assign('arr',$arr);
            return $this->fetch('./index');
        } 
    }
?>