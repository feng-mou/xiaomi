<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Session;
    class Dingdanzhongxin extends Base{
        /*
         2020年9月4日
                        订单详情
         */
        public function index(){
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            
            $name=session::get('name');
            $where=[
                'name'=>$name,
                'order_zt'=>2
            ];
            $result=Db::name('order')
            ->field('a.id as yy,
                    a.order_goods,
                    a.order_times,
                    a.order_number,
                    a.order_count,
                    a.order_id,
                    a.order_zt,
                    a.name,
                    b.id,
                    b.commodity_name,
                    b.commodity_money,
                    b.commodity_edition_id,
                    b.commodity_img,
                    c.id,
            c.commodity_edition')
            ->alias('a')
            ->join('edition_money b','a.order_id=b.id')
            ->join('edition c','b.commodity_edition_id=c.id')
            ->where('a.name',$name)
            ->where('a.order_zt',2)
            ->select();
            $this->assign('result',$result);
            return $this->fetch('./dingdanzhongxin');
        } 
        //付款
        public function order_jieguo(){
            $name=session::get('name');
            if(empty($_POST['id'])){
                return json(['code'=>"error",'msg'=>"没有商品",'data'=>url('admin/Gouwuche/index')]);
            }
            $data=$_POST['id'];
            $update=[
                'order_time'=>date('Y-m-d h:i:s',time()),
                'order_zt'=>2
            ];
            for($i=0;$i<count($data);$i++){
                Db::name('order')->where('id',$data[$i])->where('name',$name)->update($update);
            }
            return json(['code'=>200,'msg'=>"购买成功,请查看订单",'data'=>url('admin/Gouwuche/index')]);
            //return var_dump($data);
            /*$arr=$data['order_id'];
            foreach($arr as $ak=>$m){
                Db::name('order')->where('id',$m)->update(['order_zt'=>2]);
            }
            return json(['msg'=>"购买成功,请查看订单",'data'=>url('admin/Gouwuche/index')]);*/
            //return var_dump($data);
        }
    }
?>