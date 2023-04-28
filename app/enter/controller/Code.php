<?php
declare (strict_types = 1);

namespace app\enter\controller;

use think\captcha\facade\Captcha;
use think\facade\Session;
use think\facade\Config;
use think\facade\Db;

// use app\enter\model\User;
class Code
{
    public function index($user,$password)//用户登录
    {
        $res=null;
        $res=Db::table('user')->where([
            'bank'=>$user,
            'password'=>$password
        ])->select();
     
        //  echo  base64_decode(base64_encode($password));  解密
        $userr=cookie('user[0]')?true:false;

   
        if(sizeof($res)==0){
            return json(['msg'=>'用户或密码错误','code'=>404]);
        }else {
            $root=Db::query('SELECT root
            FROM post
            WHERE id=(SELECT post_id
            FROM `post_info`
            WHERE teacher_id=?)',[$user]);
            $ss=null;
            if(strlen($user)==9){
                if($root[0]['root']===0||$root[0]['root']){ $ss=$root[0]['root']; 
                    cookie('user[1]',base64_encode(rand(100000,999999).$ss));//权限cookice最后一位
                };
            }else {
                cookie('user[1]',base64_encode(rand(100000,999999).'9'));//学生权限为9
            }
          

            if(strlen($user)==9){
                cookie('user[2]',base64_encode(rand(100000,999999).'0'));  //判别身份类型
            }else {
                cookie('user[2]',base64_encode(rand(100000,999999).'1'));
            }

            $user_name=null;
            if(strlen($user)==9){
                $user_name=Db::query('SELECT *
                FROM teacher_info
                WHERE teacher_id=?',[$user]);
                $user_name=$user_name[0]['teacher_name'];
            }else {
                $user_name=Db::query('SELECT *
                FROM student_info
                WHERE student_id=?',[$user]);
                $user_name=$user_name[0]['student_name'];
            }
            return json(['msg'=>'登录成功','code'=>200,'cookie'=>$userr,'root'=>$ss,'user_name'=>$user_name,'portrait'=>$res[0]['portrait']]);
        }
    }


    public function cookie($user,$password){//密码以base64位存储cookie
       cookie('user[0]', base64_encode($password),60*60*24);
            return json(['msg'=>'存储成功','code'=>200]);
    }

    public function judge($user){//解码cookie user[0]  解码密码
        if(array_key_exists('user',$_COOKIE)){
            return json(['msg'=>'解码','code'=>200,'data'=>base64_decode($_COOKIE['user'][0])]);
        }
    }

    public function root(){//解码cookie user[1] 解码权限
        return json(['msg'=>'解码','code'=>200,'data'=>base64_decode($_COOKIE['user'][1])]);
    }



    public function img(){//验证码
        $img3=imagecreatetruecolor(110,40);//创建图片资源
        $bg_color=imagecolorallocate($img3,rand(0,255),rand(0,255),rand(0,255));//分配画布颜色(背景色)
        imagefill($img3,0,0,$bg_color);//填充背景色
        
        $ch_color=imagecolorallocate($img3,rand(0,110),rand(20,110),rand(10,110));
        $res=rand(1000,9999);
        imagettftext($img3,20,rand(-10,10),20,30,$ch_color,'/www/wwwroot/127.0.0.1/msyh.ttf',$res.'');//写字 (画布资源 文字大小 旋转角度  起始X 起始Y 颜色 字体  内容)
        
        for($i=0;$i<30;$i++){//增加干扰
            $dots_color=imagecolorallocate($img3,rand(0,255),rand(0,255),rand(0,255));
            imagestring($img3,rand(1,5),rand(0,200),rand(0,50),'*',$dots_color);  //增加干扰点
        }
        $date="/www/wwwroot/127.0.0.1/file/cache".time().'.png';
        imagepng($img3,$date);//输出资源
        $img = file_get_contents($date);
        $file_content =base64_encode($img);
        $img_base64 = 'data:image/'."png".';base64,'.$file_content;
        unlink($date);
        imagedestroy($img3);//销毁画布
        $arr=[
            'img'=>$img_base64,
            'res'=>$res
        ];
        return json($arr);
    }

 

}
