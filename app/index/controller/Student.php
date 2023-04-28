<?php

namespace app\index\controller;
use app\index\controller\Sql;
use app\index\controller\Sys;
use think\facade\Db;
use think\facade\Request;
class Student {
    public function index(){
        $data=Db::query(Sql::$str1);
        $zyNot=Db::query(Sys::$zyNot);
        $department=Db::query(Sql::$str2);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$data,'zyNot'=>$zyNot,'department'=>$department]);
    }

    //返回指定院系的辅导员和班主任人员名单
    public function teacherclass($department_id){
        $res1=Db::query(Sql::$str3,[$department_id]);
        $res2=Db::query(Sql::$str4,[$department_id]);
        return json(['msg'=>'获取成功','code'=>200,'teacher'=>$res2,'ban'=>$res1]);
    }

    public function classteacher($type,$teacher_id,$class_id){
        if($type==0){
            $res=Db::query(Sql::$str5,[$class_id,$teacher_id]);
            Db::name('student_class')
            ->where('id', $class_id)
            ->update(['instructor_id' => $teacher_id]);
         return json(['msg'=>'操作成功,该辅导员已有'.sizeof($res).'个班','code'=>200]);
        }else {
            $res=Db::query(Sql::$str6,[$class_id,$teacher_id]);
            Db::name('student_class')
            ->where('id', $class_id)
            ->update(['director_id' => $teacher_id]);
            return json(['msg'=>'操作成功,该班主任已有'.sizeof($res).'个班','code'=>200]);
        }
    }

    public function deldorm($student_id,$dorm_id,$dorm_num_id){
        $msg='删除成功';
        $code=200;
        $str=null;
        $res=Db::query(Sql::$str8,[$student_id,$student_id,$student_id,$student_id]);
        if($res[0]['member_one_id']==$student_id){
            $str='member_one_id';
        }else if($res[0]['member_two_id']==$student_id){
            $str='member_two_id';
        }else if($res[0]['member_three_id']==$student_id){
            $str='member_three_id';
        }else if($res[0]['member_four_id']==$student_id){
            $str='member_four_id';
        }
        Db::name('dorm_info')
                ->where([
                    'dorm_id'=>$res[0]['dorm_id'],
                    'dorm_num_id'=>$res[0]['dorm_num_id']
                ])
                ->update([$str=>null]);
        return json(['msg'=>$msg,'code'=>$code]);
    }

    public function updorm($student_id,$dorm_id,$dorm_num_id){
        $msg='操作成功';
        $code=200;
        $str=null;
        $res=Db::query(Sql::$str8,[$student_id,$student_id,$student_id,$student_id]);
        $sex=Db::query(Sql::$str10,[$student_id]);


        if($sex[0]['student_sex']=='女'&&$dorm_id>=11){
                return json(['msg'=>'该女生不能调到男生宿舍','code'=>310]);
        }else if($sex[0]['student_sex']=='男'&&$dorm_id<=10){
                return json(['msg'=>'该男生不能调到女生宿舍','code'=>310]);
        }
        if(sizeof($res)>0){
          
            if($res[0]['member_one_id']==$student_id){
                $str='member_one_id';
            }else if($res[0]['member_two_id']==$student_id){
                $str='member_two_id';
            }else if($res[0]['member_three_id']==$student_id){
                $str='member_three_id';
            }else if($res[0]['member_four_id']==$student_id){
                $str='member_four_id';
            }
        }
   
        $res2=Db::query(Sql::$str9,[$dorm_num_id,$dorm_id]);
        $i=0;
        $str2=null;
            if($res2[0]['member_one_id']==null){
                $i++;
                $str2='member_one_id';
            }
            if($res2[0]['member_two_id']==null){
                $str2='member_two_id';
                $i++;
            }
            if($res2[0]['member_three_id']==null){
                $str2='member_three_id';
                $i++;
            }
            if($res2[0]['member_four_id']==null){
                $str2='member_four_id';
                $i++;
            }
            if($i==0){
                return json(['msg'=>'该宿舍没有空余床铺','code'=>310]);
            }else {
              if(sizeof($res)>0){
                Db::name('dorm_info')
                ->where([
                    'dorm_id'=>$res[0]['dorm_id'],
                    'dorm_num_id'=>$res[0]['dorm_num_id']
                ])
                ->update([$str=>null]);
              }

                Db::name('dorm_info')
                ->where([
                    'dorm_id'=>$dorm_id,
                    'dorm_num_id'=>$dorm_num_id
                ])
                ->update([$str2=>$student_id]);
                return json(['msg'=>'修改成功','code'=>200]);
            }
  }
  public function chalooporm($dorm_id){
    $msg='操作成功';
    $code=200;
    $res=Db::query(Sql::$str7,[$dorm_id]);
    if(sizeof($res)>0){
        foreach($res as $k=>$v){
            $i=0;
            if($v['member_one_id']==null){
                $i++;
            }
            if($v['member_two_id']==null){
                $i++;
            }
            if($v['member_three_id']==null){
                $i++;
            }
            if($v['member_four_id']==null){
                $i++;
            }
            $res[$k]['sheng']=$i;
        }
    }else {
        $msg='该楼栋暂时没有空床铺,请重新选择';
        $code=310;
    }
    return json(['msg'=>$msg,'code'=>$code,'data'=>$res]);
  }


  public function punishment(){
    $res=Db::query(Sql::$str11);
    return json(['msg'=>'获取成功',"code"=>200,'data'=>$res]);
  }

  public function punishmentx($id,$student_id){
    $res=Db::query(Sql::$str12,[$id]);
    if(sizeof($res)>0){
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res[0]]);
    }else {
        return json(['msg'=>'获取失败','code'=>310,]);
    }
  }

  public function sys($id){
    // var_dump($GLOBALS);
    $act = isset($_REQUEST["act"]) ? $_REQUEST["act"] : "";
    return var_dump($_GET,$_POST,$act);
  }

  public function postimg(){
    $arr_type=['image/jpg','image/jpeg','image/gif','image/pjpeg','image/png'];
    if(isset($_FILES['file']['name'])|isset($_FILES['file1']['name'])){
        if($_FILES['file']['error']!=0){
            switch($file['error']){
                case 1:
                case 2:echo '文件超出服务器大小<br/>';  break;
                case 3:echo '文件上传过程中出现问题,只上传一部分!<br/>'; break;
                case 4:echo '用户没有选中要上传的文件<br/>'; break;
                case 6:
                case 7:echo '文件保存失败<br/>';
            }
            return;
        }
        if(!(in_array($_FILES['file']['type'],$arr_type))){
            echo '该文件类型不符合<br/>';
            return;
        };
        if(is_uploaded_file($_FILES['file']['tmp_name'])){//is_uploaded_file判断是否上传文件:临时文件
            $fileName=time().rand().substr($_FILES['file']['name'],strpos($_FILES['file']['name'],'.'));
            if(move_uploaded_file($_FILES['file']['tmp_name'],'/www/wwwroot/127.0.0.1/file/student_w/'.$fileName)){//move_uploaded_file更改文件的路径
                $res=Db::query(Sql::$str13,[intval($_POST['id']),$_POST['student']]);
                if(sizeof($res)>0){
                    $tf=Db::name('student_sanction_info')
                    ->where('id', $res[0]['id'])
                    ->update(['fujian' =>$res[0]['fujian'].','.$fileName ]);
                    return $tf;
                }
            }else {
                echo  '文件保存失败<br/>';
            }
         return $fileName;
        }else {
            echo '文件上传失败<br/>';
        }
      
    }
  }

  public function postFile(){
    if($_FILES['file']['error']!=0){
        switch($file['error']){
            case 1:
            case 2:echo '文件超出服务器大小<br/>';  break;
            case 3:echo '文件上传过程中出现问题,只上传一部分!<br/>'; break;
            case 4:echo '用户没有选中要上传的文件<br/>'; break;
            case 6:
            case 7:echo '文件保存失败<br/>';
        }
        return;
    }
    if(is_uploaded_file($_FILES['file']['tmp_name'])){//is_uploaded_file判断是否上传文件:临时文件
        $type=substr($_FILES['file']['name'],strpos($_FILES['file']['name'],'.'));
        $fileName=time().rand().$type;
        $sen_id=$_POST['sen_id'];
        $accept_id=$_POST['accept_id'];
        if(move_uploaded_file($_FILES['file']['tmp_name'],'/www/wwwroot/127.0.0.1/file/chat/'.$fileName)){//move_uploaded_file更改文件的路径
            $arr=['old_name'=>$_POST['old_name'],'new_name'=>$fileName,'type'=>$type,];
            $jsonarr=json_encode($arr,320);
            $data = ['sen_id' =>$sen_id, 'accept_id' => $accept_id,'accessory'=>$jsonarr, 'sen_time'=>date("Y-m-d H:i:s"),
            'state'=>1];
            Db::name('chat')->strict(false)->insert($data);
            return json(['msg'=>'保存成功','code'=>200,'data'=>$arr]);
        }else {
            return  '文件保存失败<br/>';
        }
    }else {
        return '文件上传失败<br/>';
    }
  }
  
  public function changeimg($data,$id){
    $tf=Db::name('student_sanction_info')
    ->where('id',$id)
    ->update(['fujian' =>$data]);
    return json(['msg'=>'修改成功','code'=>200]);
  }

  public function upstudentw($id,$title,$info,$aid,$root){
    echo $root;
   if($root==0){
    $tf=Db::name('student_sanction_info')
    ->where('id',$id)
    ->update(['title' =>$title,'info'=>$info,'send_id'=>$aid]);
   }else {
    echo 789;
    $tf=Db::name('student_sanction_info')
    ->where('id',$id)
    ->update(['title' =>$title,'info'=>$info,'send_id'=>$aid,'disciplinary_sanction_id'=>$root]);
   }
    return json(['msg'=>'修改成功','code'=>200]);
  }

  public function delstudentw($id){
    Db::table('student_sanction_info')->where('id',$id)->delete();
    return json(['msg'=>'删除成功','code'=>200]);
  }

  public function changestudentw($id,$state,$admin){
    $msg='操作成功';
    $code=200;  
    $res=Db::query(Sql::$str14,[$id]);
    if($res[0]['stundet_tf']==1){
    $tf=Db::name('student_sanction_info')
        ->where('id',$id)
        ->update(['admin_tf'=>$state,'admin'=>$admin,'end_time'=>date('Y-m-d')]);
    }else if($res[0]['stundet_tf']==0){
        $msg='请等待被处理人同意';
        $code=300;
    }else {
        $code=310;
        $msg='被处理人不接受该处分,请联系对方';
    }
    return json(['msg'=>$msg,'code'=>$code,]);
  }

  public function jing(){
    $res=Db::query(Sql::$str15);
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
  }

  public function chadataw(){
    $res=Db::query(Sql::$str16);
    $res2=Db::query(Sql::$str17);
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'sid'=>$res2]);
  }

  public function wclass($sid,$nj){
    $res=Db::query(Sql::$str18,[$sid,$nj]);
    $arr=[];
    foreach($res as $k=>$v){
        $res2=Db::query(Sql::$str19,[$v['id']]);
        array_push($arr,['data'=>$res2,'id'=>$k+1]);
    }
   
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'names'=>$arr]);
  }

  public function addstudentw(){
    $arr_type=['image/jpg','image/jpeg','image/gif','image/pjpeg','image/png'];
    $fujian='';
    foreach($_FILES as $file){
        foreach($file['tmp_name'] as $k=>$tmp_name){
            if($file['error'][$k]!=0){
                switch($file['error'][$k]){
                    case 1:
                    case 2:echo '文件超出服务器大小<br/>';  break;
                    case 3:echo '文件上传过程中出现问题,只上传一部分!<br/>'; break;
                    case 4:echo '用户没有选中要上传的文件<br/>'; break;
                    case 6:
                    case 7:echo '文件保存失败<br/>';
                }
                continue;
            }
            if(!(in_array($file['type'][$k],$arr_type))){
                return json(['msg'=>'该文件类型不符合','code'=>310]);
                continue;
            };
            if(is_uploaded_file($tmp_name)){//is_uploaded_file判断是否上传文件:临时文件
                $fileName=time().rand().substr($file['name'][$k],strpos($file['name'][$k],'.'));
                $fujian.=$fileName.',';
                if(move_uploaded_file($tmp_name,'/www/wwwroot/127.0.0.1/file/student_w/'.$fileName)){//move_uploaded_file更改文件的路径
                }else {
                    return json(['msg'=>'文件保存失败','code'=>310]);
                }
            }else {
                return json(['msg'=>'文件保存失败','code'=>310]);
            }
        }
    };
    $data = [
    'student_id' =>$_POST['student_id'], 
    'info' =>$_POST['info'],
    'title'=>$_POST['title'],
    'send_id'=>$_POST['send_id'],
    'disciplinary_sanction_id'=>$_POST['disciplinary_sanction_id'],
    'stundet_tf'=>0,
    'admin_tf'=>0,
    'fujian'=>$fujian,
    'add_time'=>date('Y-m-d'),
    ];
    $tf= Db::name('student_sanction_info')->strict(false)->save($data);
    return json(['msg'=>'保存成功','code'=>200]);
  }

  public function register($teacher_id,$nd){
  $res=Db::query(Sql::$str29,[$teacher_id,$nd]);
  $data=[];
  if(sizeof($res)>0){
    $data['class']=$res;
    foreach($res as $k=>$v){
        $data['class'][$k]['sondata']=Db::query(Sql::$str30,[$v['key'],$nd,$v['specialty_class_id'],$v['key']]);
    }
  }
  $res=Db::query(Sql::$str32,[$nd,$teacher_id]);
  if(sizeof($res)>0){
    $data['select']=$res;
    foreach($res as $k=>$v){
        $data['select'][$k]['sondata']=Db::query(Sql::$str33,[$nd,$v['select_class_id'],$v['id'],$nd]);
    }
  }
  return json(['msg'=>'获取成功','code'=>200,'data'=>$data]);
  }


  public function upgraden($grade,$type,$sid,$class_grade_id,$student_id,$nd){
    $res=Db::query(Sql::$str31,[$nd,$class_grade_id,$student_id,$sid]);
    if(sizeof($res)>0){
        if($type==1){
            Db::name('student_grade')
            ->where('id', $res[0]['id'])
            ->update(['one_grade' =>$grade]);
        }else {
            Db::name('student_grade')
            ->where('id',  $res[0]['id'])
            ->update(['two_grade' => $grade]);
        }
    }else {
        $data = ['semester' => $nd, 'specialty_class_id' => $sid,'student_class_id' => $class_grade_id,'student_id' => $student_id];
        if($type==1){
            $data['one_grade']=$grade;
        }else {
            $data['two_grade']=$grade;
        }
        Db::name('student_grade')->insert($data);
    }
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
  }

  public function score(){
    $department=Db::query(Sql::$str38);
    $data=Db::query(Sql::$str35);
    $department_specialty=Db::query(Sql::$str34);
    return json(['msg'=>'获取成功','code'=>200,'department'=>$department,'department_specialty'=>$department_specialty,'data'=>$data]);
  }

  public function lookclass($id){
    $res=Db::query(Sql::$str41,[$id]);
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
  }

  public function lookclass_student($id,$nd){
    $res=Db::query(Sql::$str42,[$id,$nd]);
    foreach($res as $k=>$v){
        $res[$k]['sondata']=Db::query(Sql::$str43,[$v['specialty_class_id'],$nd,$v['class_id']]);
    }
    $select=Db::query(Sql::$str44,[$id,$nd]);
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'select'=>$select]);
  }
  
  public function upgraden_s($one_grade,$two_grade,$sid,$class_grade_id,$student_id,$nd){
    $res=Db::query(Sql::$str31,[$nd,$class_grade_id,$student_id,$sid]);
   
    if(sizeof($res)>0){
        echo 1;
        if($two_grade!='false'){
            echo 2;
            Db::name('student_grade')
            ->where('id', $res[0]['id'])
            ->update(['one_grade' =>$one_grade,'two_grade'=>$two_grade]);
        }else {
            echo 3;
            Db::name('student_grade')
            ->where('id',  $res[0]['id'])
            ->update(['one_grade' => $one_grade]);
        }
    }else {
        $data = ['semester' => $nd, 'specialty_class_id' => $sid,'student_class_id' => $class_grade_id,'student_id' => $student_id];
        if($two_grade!='false'){
            var_dump($two_grade);
            $data['one_grade']=$one_grade;
            $data['two_grade']=$two_grade;
        }else {
            echo 5;

            $data['one_grade']=$one_grade;
        }
        Db::name('student_grade')->insert($data);
    }
    return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
  }


 
}