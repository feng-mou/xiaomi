<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    class Index extends Base{
        public function index(){
            $arr=Db::name('class')->select();
            $this->assign('arr',$arr);
            return $this->fetch('./index');
        } 
    }
?>