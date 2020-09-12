<?php 
    namespace app\admin\controller;
    //use app\admin\controller\Base;
    use think\Controller;
    use think\captcha\Captcha;
    //use think\Session;
    //验证账号密码
    use app\admin\model\LoginModel;
    class Login extends Controller{
        public function index(){
            return $this->fetch('./Login');
        } 
        /*
         2020年9月1日
                        登录              
                */
        public function loginYz(){
            //$captcha=new Captcha();//实例化判断验证码是否一致方法
            //解析成数组
            $data=parseParams(input('post.data'));
            $name=$data['username'];
            $pass=$data['password'];
            $yzm=$data['yzm'];
            /*if(!$captcha->check($yzm)){
                return json(['code' => 404, 'data' => '', 'msg' => '验证码不一致']);
            }*/
            if($name==null){
                return json(['code' => 404, 'data' => '', 'msg' => '账号不能为空']);
            }
            if($pass==null){
                return json(['code' => 404, 'data' => '', 'msg' => '密码不能为空']);
            }
            //$name='admin';
            $obj=new LoginModel();
            //$pass=1234;
            $pass2=md5($pass);
            $result=$obj->loginYz($name,$pass2);
            //var_dump($result);
            if($result=='1'){
                return json(['code' => 404, 'data' => '', 'msg' => '账号不存在']);
            }else if($result=='2'){
                return json(['code' => 404, 'data' => '', 'msg' => '密码错误']);
            }else{
                session('name',$name);
                $result2=$obj->yy($name,$pass2);
                session('name_id',$result2);
                return json(['code' => 200, 'data' => url('admin/index/index'), 'msg' => '登录成功']);
            }
        }
    }
?>