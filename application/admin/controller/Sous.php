<?php 
    namespace app\admin\controller;
    use think\Controller;
    use think\Db;
    //use app\admin\model\LoginModel;
    /*
     2020年9月2日
            小米手机列表
     */
    class Sous extends Controller{
        public function index($fy_id=1){
            
            $name=input('name') ;
            //name
            $this->assign('name',$name);
            //查是否有货
            $where=[
               'commodity_describe'=>['like','%'.$name.'%']
            ];
                
            //var_dump($name);
                
            $count=Db::name('commodity')->where($where)->count();
            //var_dump($count);
            if($count==0){
                 $this->success('没有货', 'admi/index/index');
            }
             
            //查看分页id
            //$fy_id=isset($fy_id) ? $fy_id : 1;
            $fy_ids=($fy_id-1)*5;
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
                ->where($where)
                ->limit($fy_ids,5)
                ->select();
                //将导航栏放到列表上
                $liebiao=Db::name('class')->select();
                $this->assign('acg',$liebiao);
                //商品列表
                $this->assign('arr',$arr);
                //分页数量
                $num=ceil($count/5);
                $this->assign('num',$num);
                return $this->fetch('./sous');
        } 
        
    }
?>