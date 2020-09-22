<?php 
    namespace app\admin\controller;
    use think\Controller;
    use think\Db;
    //use app\admin\model\LoginModel;
    /*
     2020年9月2日
            小米手机列表
     */
    class Liebiao extends Controller{
        public function index(){
            //接id避免直接就进来
            
            $id=input('id');
            //var_dump($id);
            if($id!==null){
                //查是否有货
                $count=Db::name('commodity')->where('commodity_class',$id)->count();
                if($count==0){
                    $this->success('没有货', 'admin/index/index');
                }
                //查看分页id
                $fy_id=input('fy_id');
                $fy_ids=($fy_id-1)*5;
                //查这个类的商品
                //$arr=Db::name('commodity')->where('commodity_class',$id)->limit(0,5)->select();
                $arr=Db::name('commodity')
                ->field('a.id as dd,
                        a.commodity_class,
                        a.commodity_describe,
                        a.commodity_count,
                        a.commodity_cc,
                        a.commodity_name,
                        a.commodity_money,
                        a.commodity_img')
                ->alias('a')
                ->where('a.commodity_class',$id)
                ->limit($fy_ids,5)
                ->select();
                //分页
                $num=ceil($count/5);
                //var_dump($num);
                //将导航栏放到列表上
                $liebiao=Db::name('class')->select();
                $this->assign('acg',$liebiao);
                
                //商品列表
                $this->assign('arr',$arr);
                
                //初始商品类id
                $this->assign('id',$id);
                
                //分页数量
                $this->assign('num',$num);
                return $this->fetch('./liebiao');
            }else{
                $this->success('不可以进入哦', 'admin/index/index');
            }
        } 
        
    }
?>