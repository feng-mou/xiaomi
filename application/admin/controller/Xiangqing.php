<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    //use app\admin\model\LoginModel;
    /*
     2020年9月1日
            详情
     */
    class Xiangqing extends Base{
        public function index(){
            $id=input('id');
            $describe_id=input('describe_id');
            //$name=input('name');
            //查询描述
            $arr=Db::name('commodity')->where('id',$describe_id)->select();
            
            //
            $edition=Db::name('edition_money')->where('commodity_id',$id)->select();
            $this->assign('arr',$arr);
            $this->assign('edition',$edition);
            
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            //var_dump($edition);die;
            //$acg[]=$arr;
            //var_dump($acg['commodity_name']);die;
            return $this->fetch('./xiangqing');
        } 
        
    }
?>