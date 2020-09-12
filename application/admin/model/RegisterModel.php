<?php 
    namespace app\admin\Model;
    use think\Model;
    use think\Db;
    class RegisterModel extends Model{
        //验证账号是否存在
        public function registerYz($name,$pass,$tel,$time){
            //判断账号是否存在
            $result=Db::name('user')->where('name',$name)->count();
            if($result==1){
                //账号存已经存在
                return '1';
            }
            $registerData=[
                'name'=>$name,
                'pass'=>"$pass",
                'tel'=>$tel,
                'register_time'=>$time
            ];
            $result2=Db::name('user')->insert($registerData);
            if($result2){
                return '2';
            }else{
                return '3';
            }
        }
   }
?>