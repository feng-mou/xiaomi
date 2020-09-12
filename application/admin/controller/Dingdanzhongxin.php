<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Session;
    class Dingdanzhongxin extends Base{
        public function index(){
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            
            $name=session::get('name');
            //$result=Db::name('order');
            return $this->fetch('./dingdanzhongxin');
        } 
        //付款
        public function order_jieguo(){
            $data=parseParams(input('post.data'));
            $arr=$data['order_id'];
            foreach($arr as $ak=>$m){
                Db::name('order')->where('id',$m)->update(['order_zt'=>2]);
            }
            return json(['msg'=>"购买成功,请查看订单",'data'=>url('admin/Gouwuche/index')]);
            //return var_dump($data);
        }
    }
?>