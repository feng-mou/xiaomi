<?php 
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    //use app\admin\model\LoginModel;
    /*
     2020年9月1日
            详情
     */
    class Add extends Base{
        public function index(){
            //版本
            $edition=Db::name('edition')->select();
            $this->assign('edition',$edition);
            
            //什么类
            $class=Db::name('class')->select();
            $this->assign('class',$class);
            
            //什么颜色
            $color=Db::name('color')->select();
            $this->assign('color',$color);
            return $this->fetch('./add');
        } 
        
        public function add(){
            // 允许上传的图片后缀
            $allowedExts = array("gif", "jpeg", "jpg", "png","ico");
            $temp = explode(".", $_FILES["file"]["name"]);
            echo $_FILES["file"]["size"];
            $extension = end($temp);     // 获取文件后缀名
            if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/jpg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/x-png")
                || ($_FILES["file"]["type"] == "image/png"))
                && ($_FILES["file"]["size"] < 204800)   // 小于 200 kb
                && in_array($extension, $allowedExts))
            {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "错误：: " . $_FILES["file"]["error"] . "<br>";
                }
                else
                {
                    echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
                    echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
                    echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                    echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
                    
                    // 判断当前目录下的 upload 目录是否存在该文件
                    // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                    if (file_exists("/static/image/" . $_FILES["file"]["name"]))
                    {
                        echo $_FILES["file"]["name"] . " 文件已经存在。 ";
                    }
                    else
                    {
                        // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                        move_uploaded_file($_FILES["file"]["tmp_name"], "D:/phpstudy_pro/WWW/php02/xiaomi/public/static/image/".$_FILES["file"]["name"]);
                        echo "文件存储在: " . "D:/phpstudy_pro/WWW/php02/xiaomi/public/static/image/" . $_FILES["file"]["name"];
                        $data=$_POST;
                        $commodity_name=$data['commodity_name'];
   
                        $commodity_money=$data['commodity_money'];
                        $commodity_edition_id=$data['edition'];
                        $class=$data['class'];
                        $color=$data['color'];
                        
                        $addData=[
                            'commodity_name'=>$commodity_name,
       
                            'commodity_money'=>$commodity_money,
                            'commodity_edition_id'=>$commodity_edition_id,
                            'commodity_img'=>$_FILES["file"]["name"],
                            'commodity_class'=>$class,
                            'commodity_color'=>$color
                        ];
                        $result=Db::name('edition_money')->insert($addData);
                        if($result){
                            echo "成功添加";
                        }else{
                            echo "添加失败";
                        }
                    }
                }
            }
            else
            {
                echo "非法的文件格式";
            }
        }
    }
?>