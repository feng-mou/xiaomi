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
            //获取session的name值
            $name=session::get('name');
            //查询描述
            $arr=Db::name('commodity')->where('id',$describe_id)->select();
           
            //查版本
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
            
            //版本去重
            $i=0;
            foreach($edition as $ak=>$sm){
                $dd[$i]['edition']=$sm['commodity_edition'];
                $dd[$i]['id']=$sm['commodity_dd'];
                $dd[$i]['money']=$sm['commodity_money'];
                $i++;
            }
            $cp=array_unique($dd,SORT_REGULAR);
            //将版本选择放入xiangqing.html
            $this->assign('edition',$cp);
            //描述
            $this->assign('arr',$arr);
            //导航栏
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            
            return $this->fetch('./xiangqing');
        } 
        //颜色盒子
        public function cc(){
            /*
             * 接收传过来的版本id
             */
            $id=input('commodity_dd');
            /*
             * 查询edition_money表和commodity_color表拿到的值
             * */
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
            //设置一个字符串变量
            $str="";
            //$color_i下标
            $color_i=0;
            //循环以字符串的形式放入$str
            //dd[id]代表这个颜色对应的id
            //radio单项按钮的value代表id
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
            //放入json
            return json(['result'=>$str]);
        }
        
        //图片
        public function tu(){
            //接受id根据id连表查图片
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
            //设置空字符串
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
            //放入json返回到前台去
            return json(['tupian'=>$str,'edition'=>$edition,'qian'=>$qian,'money'=>$money]);
        }
    }
?>