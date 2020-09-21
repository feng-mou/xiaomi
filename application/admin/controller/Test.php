<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\session;
    class Test extends Base{
        
        
        
        
        
        
        
        public function cc(){
            $arr=Db::name('edition_money')->where('id',13)->select();
           $acg=Db::name('user')->select();
           $str = "";
           foreach ($acg as $k=>$v){
               $str = $str."<div class='json' onclick='bb()'>".$acg[$k]['name']."</div><br/>";
           }
           //var_dump($str);
            return json(['result'=>$str]);
        }
        
        
        
        
        
        
        
        public function index(){
            $name=session::get('name');
            $edition=Db::name('edition_money')
            ->field('a.id yy,
                    a.commodity_class,
                    a.commodity_edition_id,
                    a.commodity_money,
                    a.commodity_id,
                    a.commodity_img,
                    a.commodity_dd,
                    b.id,
                    b.commodity_edition')
                    ->alias('a')
                    ->join('edition b','commodity_edition_id=b.id')
                    ->where('a.commodity_id',1)->select();
                    //$this->assign('edition',$edition);
            $i=0;
            foreach($edition as $ak=>$sm){
               $dd[$i]['edition']=$sm['commodity_edition']; 
               $dd[$i]['id']=$sm['commodity_dd'];
               $dd[$i]['money']=$sm['commodity_money'];
               $i++;
            }
            $cp=array_unique($dd,SORT_REGULAR);
            
            $arr=Db::name('edition_money')
            ->field('a.id,
                     a.commodity_color laji,
                     a.commodity_img,
                     b.id bb,
                     b.commodity_color')
            ->alias('a')
            ->join('color b','a.commodity_color=b.id')
            ->where('commodity_dd',4)
            ->select();
            $str="";
            $color_i=0;
            foreach($arr as $gege=>$dd){
                $str=$str."<div class='xzbb ml20 mt10'>".
                                "<div class='banben'>".
                                    "<a>".
                                        "<span class='yuandian'></span>".
                                        "<span class='yanse' onclick='tu($dd[id],$color_i)'>".$dd['commodity_color']."</span>".
                                    "</a>".
                                    "<input type='radio' name='commodity' value='$dd[id]'>".
                                "</div>".
                            "</div>";
                $color_i++;
            }
            //echo $str;
           // $arr=Db::name('edition_money')->where('id',3)->select();
            //选中描述信息
            $arr=Db::name('edition_money')
            ->field('a.id,
                     a.commodity_name,
                     a.commodity_color laji,
                     a.commodity_img,
                     a.commodity_money,
                     a.commodity_edition_id,
                     b.id bb,
                     b.commodity_color,
                     c.id cc,
                     c.commodity_edition')
                     ->alias('a')
                     ->join('color b','a.commodity_color=b.id')
                     ->join('edition c','a.commodity_edition_id=c.id')
                     ->where('a.id',5)
                     ->select();
                     $str="";
                     foreach($arr as $ak=>$sm){
                         //图片
                         $str=$str."/static/image/".$sm['commodity_img'];
                         //名字版本和颜色
                         $edition=$sm['commodity_name'].$sm['commodity_edition'].$sm['commodity_color'];
                         //价格
                         $qian=$sm['commodity_money']."元";
                         //总价
                         $money="总计：".$sm['commodity_money']."元";
                     }
                     echo $edition;
            /*$tupian=Db::name('edition_money')->where('id',5)->select();
            $dd="";
            foreach($arr as $ak=>$sm){
                $dd=$dd.
                "<div class='left fl' id='img'>".
                "<img src='__IMAGE__/$sm[commodity_img]'width='100%'>".
                "</div>";
            }
            echo $dd;*/
           /*var_dump($arr);
            $arr=Db::name('edition_money')->where('id',13)->select();
            $acg=Db::name('user')->select();
            $str = "";
            foreach ($acg as $k=>$v){
                $str = $str."<div class='json' onclick='bb()'>".$acg[$k]['name']."</div><br/>";
            }*/
            //var_dump($str);
            //return json(['result'=>$str]);
            //$dd=random(6);random我封装的随机数函数
            /*$this->assign('result',$result);
            return $this->fetch('./test');*/
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
            //var_dump($result);
            return $this->fetch('./test2');
             
        }
        //测试
        public function kk(){
            $arr=Db::name('commodity')->where('id',2)->select();
            
            var_dump($arr);
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