<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\session;
    class Test extends Base{
        public function index(){
			//$acg=$this->GetRandStr(6);
			//sendTemplateSMS('19974233942',array($acg,5),1);
			/*$name=session::get('name');
			$result=Db::name('order')
			->field('a.id as yy,a.order_id,a.order_zt,a.name,a.order_checked,b.id,b.commodity_name,b.commodity_class,commodity_money,commodity_edition,b.commodity_img')
			->alias('a')
			->join('edition_money b','a.order_id=b.id')
			->where('a.name',$name)
			->where('a.order_zt',1)
			->limit(0,10)
			->select();
			var_dump($result);*/
			/*$money=0;
			foreach($result as $ak=>$m){
			    if($m['order_checked']==1){
			        //还没有选择
			    }else{
			        $money+=$m['commodity_money'];
			    }
			}
			$this->assign('money',$money);
			$this->assign('result'$result);*/
			//$where="is_menu=2 and id in (".$nodestr.")";
			//$arr=[12,13,14,15,18];
			//$arr=implode(',',$arr);
			//$where="id= id in (".$arr.")";
			/*foreach ($arr as $ak=>$m){
			    var_dump(Db::name('order')->where('id',$m)->select());
			}*/
			//$result=Db::name('order')->where($where)->select();
			//var_dump($result);
			//$time=date('Y-m-d h:i:s',time());
			
            $name=session::get('name');
            $result=Db::name('order')
            ->field('a.id as yy,a.order_count,a.order_id,a.order_zt,a.name,a.order_checked,b.id,b.commodity_name,b.commodity_class,commodity_money,commodity_edition,b.commodity_img')
            ->alias('a')
            ->join('edition_money b','a.order_id=b.id')
            ->where('a.name',$name)
            ->where('a.order_zt',1)
            ->limit(0,10)
            ->select();
            $i=0;
            foreach($result as $ak=>$m){
                $result[$ak]['i']=$i;
                $i++;
            }
            
            //$dd=random(6);random我封装的随机数函数
            $this->assign('result',$result);
            return $this->fetch('./test');
        } 
        
        function test(){
            
            //结算
            /*$name=session::get('name');
            $arr=[38,47];
            $update=[
                'order_time'=>date('Y-m-d h:i:s',time()),
                'order_zt'=>2
            ];
             for($i=0;$i<count($arr);$i++){
                 Db::name('order')->where('id',$arr[$i])->update($update);    
             }*/
            $name=session::get('name');
            $result=Db::name('order')
            ->field('a.id as yy,a.order_count,a.order_id,a.order_zt,a.name,b.id,b.commodity_name,b.commodity_class,commodity_money,commodity_edition_id,b.commodity_img,c.id,c.commodity_edition')
            ->alias('a')
            ->join('edition_money b','a.order_id=b.id')
            ->join('edition c','b.commodity_edition_id=c.id')
            ->where('a.name',$name)
            ->where('a.order_zt',1)
            ->limit(0,10)
            ->select();
            var_dump($result);
            //return $this->fetch('./test2');
             
        }
        
        
        
		function GetRandStr($len) {
    $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k","l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v","w", "x", "y", "z","0", "1", "2","3", "4", "5", "6", "7", "8", "9");
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