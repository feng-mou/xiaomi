<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Session;
    use app\admin\model\GouwucheModel;
    /*
     2020年9月1日
            详情
     */
    class Gouwuche extends Base{
        public function index(){
            $name=session::get('name');
            $result=Db::name('order')
            ->field('a.id as yy,a.order_id,a.order_zt,a.name,a.order_checked,b.id,b.commodity_name,b.commodity_class,commodity_money,commodity_edition,b.commodity_img')
            ->alias('a')
            ->join('edition_money b','a.order_id=b.id')
            ->where('a.name',$name)
            ->where('a.order_zt',1)
            ->limit(0,10)
            ->select();
            
            //购物车已选择的总价格
            $money=0;
            $shu=0;//商品数量
            $i=0;//已选择的数量
            
            $checked=0;//是否全选
			foreach($result as $ak=>$m){
			    $shu++;
			    if($m['order_checked']==1){
			        //还没有选择
			    }else{
			        $i++;
			        $money+=$m['commodity_money'];
			    }
			}
			
			//判断是否是全选状态
			if($shu==$i){
			    $checked=1;
			}
			//商品总价格
			$this->assign('money',$money);
			//商品数量
			$this->assign('shu',$shu);
			//选中数量
			$this->assign('liang',$i);
			//是否为全选状态,1为全选,0为没有全选
            $this->assign('checked',$checked);
            //购物车数据
            $this->assign('result',$result);
            return $this->fetch('./gouwuche');
        }
        
        public function submit_order(){
            /*$name_id=session::get('name_id');
            $yes=Db::name('order')->where('name_id',$name_id)->where('order_zt',1)->count();
            //echo $yes;
            if($yes==10){
                return json(['code' => 500, 'data' => url('admin/Gouwuche/index'), 'msg' => '添加购物车满了']);
            }*/
            
            $data=parseParams(input('data'));
            //订单id
            $id=$data['edition_id'];
            //$id=1;
            $obj=new GouwucheModel();
            $time=date('Y-m-d h:i:s',time());
            $result=$obj->order($id,$time);
            
            return $result;
            
            //var_dump($result);
        } 
        
        //2为选中
        public function quan_yes(){
            //return 1;
            $name=session::get('name');
            $result=Db::name('order')->where('name',$name)->update(['order_checked'=>2]);
            //$this->assign('jj',1);
            return json(['data' => url('admin/Gouwuche/index')]);
            
        }
        //1为不选中
        public function quan_no(){
            $name=session::get('name');
            $result=Db::name('order')->where('name',$name)->update(['order_checked'=>1]);
            return json(['data' => url('admin/Gouwuche/index')]);
        }
        
        //取消单选
        public function quxiao_quan(){
            $id=input('id');
            $result=Db::name('order')->where('id',$id)->update(['order_checked'=>1]);
            return json(['data' => url('admin/Gouwuche/index')]);
        }
        
        //确认单选
        public function queren_quan(){
            $id=input('id');
            $result=Db::name('order')->where('id',$id)->update(['order_checked'=>2]);
            return json(['data' => url('admin/Gouwuche/index')]);
        }
        
        //取消订单
        public function quxiao_order(){
            $id=input('order_id');
            $result=Db::name('order')->where('id',$id)->update(['order_zt'=>3]);
            return json(['msg'=>"取消订单成功",'data' => url('admin/Gouwuche/index')]);
            //$this->index();
        }
        
    }
?>