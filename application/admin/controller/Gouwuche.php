<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Session;
    //use app\admin\model\GouwucheModel;
    /*
     2020年9月1日
            详情
     */
    class Gouwuche extends Base{
        public function index(){
            
            $name=session::get('name');
            $result=Db::name('order')
            ->field('a.id as yy,
                    a.order_count,
                    a.order_id,
                    a.order_zt,
                    a.name,
                    b.id,
                    b.commodity_name,
                    commodity_money,
                    commodity_edition_id,
                    b.commodity_img,
                    c.id,
            c.commodity_edition')
            ->alias('a')
            ->join('edition_money b','a.order_id=b.id')
            ->join('edition c','b.commodity_edition_id=c.id')
            ->where('a.name',$name)
            ->where('a.order_zt',1)
            ->limit(0,10)
            ->select();
            $i=0;
            foreach($result as $ak=>$m){
                $result[$ak]['i']=$i;
                $result[$ak]['qian']=$m['order_count']*$m['commodity_money'];
                $i++;
            }
            
            //$dd=random(6);random我封装的随机数函数
            $this->assign('result',$result);
            return $this->fetch('./gouwuche');
        }
        
        public function submit_order(){
            $commodity_id=input('id'); 
            if(empty($commodity_id)){
                return json(['code' => 404, 'data' => '', 'msg' => '不能不选颜色']);
            }
            $name=session::get('name');
            $name_id=session::get('name_id');
            //判断购物车是否有这个手机
            $panduan=[
                'name'=>$name,
                'order_id'=>$commodity_id,
                'order_zt'=>1
            ];
            $result=Db::name('order')->where($panduan)->count();
            if($result>0){
                return json(['code' => 404, 'data' => '', 'msg' => '购物车有这个手机了']);
            }
            //订单号业务编码 + 时间戳 + 机器编号[前4位] + 随机4位数 + 毫秒数
            $suiji=random(4);
            $number=time().$suiji;
            //加入购物车时间
            $time=date('Y-m-d h:i:s',time());
            $order_data=[
                'name'=>$name,
                'name_id'=>$name_id,
                'order_id'=>$commodity_id,
                'order_zt'=>1,
                'order_times'=>$time,
                'order_number'=>$number,
                'order_goods'=>1,
                'order_sign'=>1,
                'order_count'=>1
            ];
            $result2=Db::name('order')->insert($order_data);
            if($result2){
                //添加购物车成功
                return json(['code' => 200, 'data' => '', 'msg' => '添加购物车成功']);
            }else{
                //添加购物车失败
                return json(['code' => 404, 'data' => '', 'msg' => '添加购物车失败']);
            }
            
            //var_dump($result);
        } 
        //数量加加
        public function order_count(){
            $id=$_POST['id'];
            $count=$_POST['count'];
            $where=[
                'id'=>$id
            ];
            $update=[
                'order_count'=>$count
            ];
            Db::name('order')->where($where)->update($update);
            //return var_dump($_POST['count']);
        }
        //取消订单
        public function quxiao_order(){
            $id=input('id');
            $result=Db::name('order')->where('id',$id)->update(['order_zt'=>3]);
            return json(['msg'=>"取消订单成功",'data' => url('admin/Gouwuche/index')]);
            //$this->index();
        }
        
    }
?>