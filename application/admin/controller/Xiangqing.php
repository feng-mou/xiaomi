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
            $edition=Db::name('edition_money')
            ->field('a.id yy,
                    a.commodity_class,
                    a.commodity_edition_id,
                    a.commodity_money,
                    a.commodity_id,
                    a.commodity_img,
                    b.id,
                    b.commodity_edition')
            ->alias('a')
            ->join('edition b','commodity_edition_id=b.id')
            ->where('a.commodity_id',$id)->select();
            $this->assign('edition',$edition);
            //导航栏
            $acg=Db::name('class')->select();
            $this->assign('acg',$acg);
            
            return $this->fetch('./xiangqing');
        } 
        //颜色
        public function cc(){
            $id=input('id');
            $arr=Db::name('edition_money')->where('id',$id)->select();
            //return $arr;
        }
    }
?>