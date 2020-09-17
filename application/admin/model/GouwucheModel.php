<?php 
    namespace app\admin\Model;
    use think\Model;
    use think\Db;
    use think\Session;
    class GouwucheModel extends Model{
       public function order($id,$time){
           //$result=Db::name('edition_money')->where('id',$id)->select();
         
           $name=session::get('name');
           $name_id=session::get('name_id');
           
           $order_data=[
               'name'=>$name,
               'name_id'=>$name_id,
               'order_id'=>$id,
               'order_zt'=>1,
               'order_checked'=>1,
               'order_time'=>$time
           ];
           $result2=Db::name('order')->insert($order_data);
           if($result2){
               return "添加购物车成功";
               return json(['code' => 404, 'data' => '', 'msg' => '添加购物车成功']);
           }else{
               //添加购物车失败
               return json(['code' => 404, 'data' => '', 'msg' => '添加购物车失败']);
           }
           //return $this->order_add($id);
       }
       public function order_add($id){
           
           //return $id;
           //return session::get('name');
           $name=session::get('name');
           $name_id=session::get('name_id');
           
           //return var_dump($time);die;
           //$str=GetRandStr(4);
           //$order_number=time().$str;
           $order_data=[
               'name'=>$name,
               'name_id'=>$name_id,
               'order_id'=>$id,
               'order_zt'=>1,
               'order_checked'=>1,
               'order_time'=>$time
           ];
           /*ini_set("display_errors","On");      
           error_reporting(E_ALL);*/
           $result=Db::name('order')->insert($order_data);
           if($result){
               //添加购物车成功
               return json(['code' => 404, 'data' => '', 'msg' => '添加购物车成功']);
           }else{
               //添加购物车失败
               return json(['code' => 404, 'data' => '', 'msg' => '添加购物车失败']);
           }
       }
       function GetRandStr($len) {
           $chars = array("0", "1", "2","3", "4", "5", "6", "7", "8", "9");
           $charsLen = count($chars) - 1;
           shuffle($chars);
           $output = "";
           for ($i=0; $i<$len; $i++){
               $output .= $chars[mt_rand(0, $charsLen)];
           }
           return $output;
       }
    }
   
?>