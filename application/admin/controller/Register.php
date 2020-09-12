<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Controller;
    //验证码
    //use think\captcha\Captcha;
    //注册账号密码
    use app\admin\model\RegisterModel;
    class Register extends Controller{
        public function index(){
            return $this->fetch('./register');
        }
        /*
         2020年9月1日
                        注册 
       */
        public function registerYz(){
            //$captcha=new Captcha();
            $data=parseParams(input('post.data'));
            $name=$data['username'];
            $pass=$data['password'];
            $pass2=$data['repassword2'];
            $tel=$data['tel'];
            $yzm=$data['yzm'];
            
            if($name==null || strlen($name)>9){
                return json(['code' => 404, 'data' => '', 'msg' => '账号格式错误']);
            }
            
            if(!preg_match("/^[\u4e00-\u9fa5]+$/",$name)) {
                return json(['code' => 404, 'data' => '', 'msg' => '该字符串不全部是英文,错误的']);
            }
            
            if($pass==null || strlen($pass)>15 || strlen($pass)<7){
                return json(['code' => 404, 'data' => '', 'msg' => '密码格式错误']);
            }
            
            if($pass!=$pass2){
                return json(['code' => 404, 'data' => '', 'msg' => '密码不一致']);
            }
            
            if($tel==null || strlen($tel)>11 || strlen($tel)<11){
                return json(['code' => 404, 'data' => '', 'msg' => '手机格式错误']);
            }
            
            /*if($yzm==null){
                return json(['code' => 404, 'data' => '', 'msg' => '验证码不能为空']);
            }*/
            
            /*if(!$captcha->check($yzm)){
                return json(['code' => 404, 'data' => '', 'msg' => '验证码不一致']);
            }*/
            
            $mpass=md5($pass);
            $time=date('Y-m-d h:i:s',time());
            $obj=new RegisterModel();
            $result=$obj->registerYz($name,$mpass,$tel,$time);
            if($result=='1'){
                return json(['code' => 404, 'data' => '', 'msg' => '账号已经存在']);
            }else if($result=='2'){
                return json(['code' => 200, 'data' => url('admin/login/index'), 'msg' => '注册成功']);
            }else{
                return json(['code' => 404, 'data' =>'', 'msg' => '注册失败']);
            }
        }
    }
?>