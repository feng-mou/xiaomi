<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Session;
    //use app\admin\model\LoginModel;
    /*
     2020年9月1日
            详情
     */
    class Xiangqing extends Base{
        public function index(){
            //商品种类
            $id=input('id');
            //商品id
            $describe_id=input('describe_id');
            //$name=input('name');
            //查询描述
            $name=session::get('name');
            $arr=Db::name('commodity')
            ->field('a.id yy,
                        a.commodity_describe,
                        a.commodity_cc,
                        b.id,
                        b.commodity_name,
                        b.commodity_img,
                        b.commodity_money')
                        ->alias('a')
                        ->join('edition_money b','a.commodity_cc=b.commodity_class')
                        ->where('b.id',$describe_id)
                        ->select();
            
            $this->assign('arr',$arr);
            //版本
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
            ->where('a.commodity_id',$id)->select();
            $i=0;
            foreach($edition as $ak=>$sm){
                $dd[$i]['edition']=$sm['commodity_edition'];
                $dd[$i]['id']=$sm['commodity_dd'];
                $dd[$i]['money']=$sm['commodity_money'];
                $i++;
            }
            $cp=array_unique($dd,SORT_REGULAR);
            $this->assign('edition',$cp);
            //导航栏
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            
            return $this->fetch('./xiangqing');
        } 
        //颜色
        public function cc(){
            $id=input('commodity_dd');
            $arr=Db::name('edition_money')
            ->field('a.id,
                     a.commodity_color laji,
                     a.commodity_img,
                     b.id bb,
                     b.commodity_color')
                     ->alias('a')
                     ->join('color b','a.commodity_color=b.id')
                     ->where('commodity_dd',$id)
                     ->select();
            $str="";
            $color_i=0;
            foreach($arr as $gege=>$dd){
                $str=$str.
                    "<div class='banben' name='yanse'>".
                    "<a>".
                        "<span class='yuandian'></span>".
                        "<span class='yanse' onclick='tu($dd[id],$color_i)'>".$dd['commodity_color']."</span>".
                    "</a>".
                    "<input type='radio' name='commodity' value='$dd[id]'>".
                    "</div>";
                $color_i++;
            }
            return json(['result'=>$str]);
        }
        
        //图片
        public function tu(){
            $tu_id=input('tu_id');
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
                     ->where('a.id',$tu_id)
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
            return json(['tupian'=>$str,'edition'=>$edition,'qian'=>$qian,'money'=>$money]);
        }
    }
?>