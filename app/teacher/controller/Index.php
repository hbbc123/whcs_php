<?php
declare (strict_types = 1);

namespace app\teacher\controller;
use think\facade\Db;
use app\teacher\controller\Sql;
class Index
{
    public function index()
    { 
      
        $res=Db::query(Sql::$str);
        return json($res);
    }
    public function teacher_clen(){
        $res=Db::query(Sql::$str1);
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res]);
    }

    public static function nei_teacher_clenX(){
        $res2=Db::query(Sql::$str3);
        $res3=Db::query(Sql::$str4);
        $res4=Db::query(Sql::$str5);
        foreach($res4 as $k=>$v){
            $son=Db::query(Sql::$str6,[$v['value']]);
            $res4[$k]['children']=$son;
        }
        $arr=[$res2,$res3,$res4];
        return $arr;
    }

    public function teacher_clenX($id){
        $res=Db::query(Sql::$str2,[$id]);
        $res[0]['info']=base64_decode($res[0]['info']);
        $data=Index::nei_teacher_clenX();
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res,'x'=>$data[0],'d'=>$data[1],'t'=>$data[2]]);
    }
    public function fu_teacher_clenX(){
        $data=Index::nei_teacher_clenX();
        return json(['msg'=>"获取成功",'code'=>200,'x'=>$data[0],'d'=>$data[1],'t'=>$data[2]]);
    }
    public function send_teacherw(){
        $postjson = file_get_contents("php://input");
        if($_POST['id']!=0){
            Db::name('teacher_sanction_info')
            ->where('id',$_POST['id'])
            ->update([
                'teacher_id' => $_POST['teacher_id'],
                'clan_sanction_id'=>$_POST['clan_sanction_id'],
                'disciplinary_sanction_id'=>$_POST['disciplinary_sanction_id'],
                'info'=>base64_encode($_POST['info']),
                'title'=>$_POST['title'],
                'send_id'=>$_POST['send_id'],
            ]);
        }else {
            $data=[
                'teacher_id' => $_POST['teacher_id'],
                'disciplinary_sanction_id'=>$_POST['disciplinary_sanction_id'],
                'info'=>base64_encode($_POST['info']),
                'title'=>$_POST['title'],
                'send_id'=>$_POST['send_id'],
                'add_time'=>date('Y-m-d'),
                'teacher_tf'=>0,
                'admin_tf'=>0
            ];
            if($_POST['clan_sanction_id']!=-1){
                $data['clan_sanction_id']=$_POST['clan_sanction_id'];
            }
            Db::name('teacher_sanction_info')->strict(false)->insert($data);
        }
        return json(['msg'=>"保存成功",'code'=>200]);
    }

    public function chazz($id){
        $res=Db::query(Sql::$str7,[$id]);
        json($res);
        if(sizeof($res)>0){
            return json(['msg'=>"获取成功",'code'=>200,'data'=>$res[0]]);
        }else {
            return json(['msg'=>"获取失败",'code'=>310,'data'=>null]);
        }
    }
    public function teacher_wdel($id){
        Db::table('teacher_sanction_info')->where('id',$id)->delete();
        return json(['msg'=>"删除成功",'code'=>200]);
    }

    public function teacher_politics($id){
        $res=Db::query(Sql::$str8,[$id]);
        $data;
        if(sizeof($res)>0){
            $data=$res[0]['politics_post'];
            return json(['msg'=>"获取成功",'code'=>200,'data'=>$data]);
        }
        return json(['msg'=>"获取失败",'code'=>310]);

    }

    public function teacher_wshen($id,$admin_id,$admin_tf){
        Db::name('teacher_sanction_info')
        ->where('id', $id)
        ->update(['admin' => $admin_id,'admin_tf'=>$admin_tf,'end_time'=>date('Y-m-d')]);
        return json(['msg'=>"修改成功",'code'=>200]);
    }

    public function teacher_add(){
        $department=Db::query(Sql::$str9);
        $department_specialty=Db::query(Sql::$str10);
        $post=Db::query(Sql::$str11);
        $politics=Db::query(Sql::$str12);
        $politics_post=Db::query(Sql::$str13);

        return json([
            'msg'=>"获取成功",
            'code'=>200,
            'department'=>$department,
            'department_specialty'=>$department_specialty,
            'post'=>$post,
            'politics'=>$politics,
            'politics_post'=>$politics_post,
        ]);
    }

 

    public function teacherAddinfo($age,$card,$department,$department_specialty,$entry_time,$iphone,$politics,$politics_post,$post,$sex,$site,$teacher_id,$teacher_name){
        $data = ['teacher_id' =>$teacher_id, 'department_id' => $department];
        if($department_specialty){
            $data['specialty_id']=$department_specialty;
        }
        Db::name('teacher')->insert($data);

        $data=['state'=>1,'teacher_id' =>$teacher_id,'age'=>$age,'card'=>$card,'entry_time'=>$entry_time,'iphone'=>$iphone,'sex'=>$sex,'site'=>$site,'teacher_name'=>$teacher_name];
        Db::name('teacher_info')->insert($data);

        $data=['teacher_id'=>$teacher_id,'post_id'=>$post];
        Db::name('post_info')->insert($data);


        $data=['teacher_id'=>$teacher_id,'politics_id'=>$politics,'politics_post'=>$politics_post];
        Db::name('politics_info')->insert($data);

        $data=['bank'=>$teacher_id,'password'=>substr($card,strlen($card)-6,6)];
        Db::name('user')->insert($data);
        return json(['msg'=>"保存成功",'code'=>200,'data'=>$res]);
    }

    public function clen_politics(){
        $res=Db::query(Sql::$str14);
        $politics=Db::query(Sql::$str12);
        $politics_post=Db::query(Sql::$str13);
        $department=Db::query(Sql::$str17);
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res,'politics'=>$politics,'politics_post'=>$politics_post,'department'=>$department]);
    }

    public function clen_politics_info($id){
        $res=null;
        if(strlen($id)<=9){
            $res=Db::query(Sql::$str15,[$id]);
        }else {
            $res=Db::query(Sql::$str16,[$id]);
        }
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res[0]]);
    }

    public function clen_updata($id,$type,$lei,$user_id){
        if($lei==0){
          if($type==0){
            Db::name('politics_info')
            ->where('teacher_id', $user_id)
            ->update(['politics_id' => $id]);
          }else if($type==1){
            $res=Db::name('politics_info')
            ->where('teacher_id', $user_id)
            ->update(['politics_post' => $id]);
          }
        }else {
            if($type==0){
                Db::name('student_info')
                ->where('student_id', $user_id)
                ->update(['student_politics' => $id]);
            }
        }
        return json(['msg'=>"修改成功",'code'=>200]);
    }



    public function class_look($user_id){
        $res=Db::query(Sql::$str18,[$user_id,$user_id]);

        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                $banname=Db::query(Sql::$str19,[$v['id'],1]);
                $fubanname=Db::query(Sql::$str19,[$v['id'],2]);
                $tuanname=Db::query(Sql::$str19,[$v['id'],3]);
                if(sizeof($banname)>0){
                    $res[$k]['banname']= $banname[0]['student_name'];
                }else {
                    $res[$k]['banname']='';
                }
                if(sizeof($fubanname)>0){
                    $res[$k]['fubanname']=$fubanname[0]['student_name'];
                }else {
                    $res[$k]['fubanname']='';
                }
                if(sizeof($tuanname)>0){
                    $res[$k]['tuanname']=$tuanname[0]['student_name'];
                }else {
                    $res[$k]['tuanname']='';
                }
                $class=Db::query(Sql::$str21,[$v['id'],$v['id']]);
                $res[$k]['key']=$res[$k]['id'];
                $res[$k]['sondata']=$class;
            }
            $post=Db::query(Sql::$str22);

            return json(['msg'=>"获取成功",'code'=>200,'data'=>$res,'post'=>$post]);
        }else {
            return json(['msg'=>"获取失败",'code'=>310]);
        }
    }


    public function class_post($student_id,$type,$class_id,$cao){
        if($type==1){
            $tf=Db::query(Sql::$str23,[$class_id,$student_id]);
            if(sizeof($tf)==1){
                Db::name('student_class_post')
                ->where(['student_class'=>$class_id,'student_id'=>$student_id] )
                ->update(['student_post_id' => $cao]);
            }else {
                $data = ['student_class' => $class_id, 'student_id' =>$student_id,'student_post_id'=>$cao];
                Db::name('student_class_post')->insert($data);
            }
        }else {
            Db::table('student_class_post')->where(['student_class'=>$class_id,'student_id'=>$student_id])->delete();
        }
        return json(['msg'=>"修改成功",'code'=>200]);

    }

    public function data(){
        // Db::table('politics_info')->where('id','>',686)->delete();
        $st1=<<<EOD
        SELECT *
        FROM teacher a LEFT JOIN (
        SELECT id,teacher_id teacher_iid,politics_id,politics_post
        FROM politics_info    
        ) b ON a.teacher_id=b.teacher_iid
        WHERE  b.politics_id IS NULL OR politics_post IS NULL
        EOD;

        $res=Db::query($st1);
        foreach($res as $k=>$v){
           var_dump($v['teacher_id']);
            $data = ['teacher_id' => $res[$k]['teacher_id'], 'politics_id' => rand(1,2),'politics_post'=>0];
            Db::name('politics_info')->insert($data);
        }
    
    }


    public function class_day($teacher_id){
        $res=Db::query(Sql::$str24,[$teacher_id,$teacher_id]);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                $children=Db::query(Sql::$str25,[222,$v['id']]);
                $res[$k]['sondata']=$children;
            }
            return json(['msg'=>"获取成功",'code'=>200,'data'=>$res]);
        }else {
            return json(['msg'=>"暂无数据",'code'=>310,'data'=>null]);
        }

    }
    public function selectclass($nd){
        $res=Db::query(Sql::$str26,[$nd]);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                $res[$k]['section']=(($res[$k]['section']*2)-1).'-'.($res[$k]['section']*2).'节次';
            }
        }
        $select=Db::query(Sql::$str27);
        $teacher=Db::query(Sql::$str28);
        foreach($teacher as $k=>$v){
            $teacher[$k]['children']=Db::query(Sql::$str29,[$v['value']]);
        }
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res,'select'=>$select,'teacher'=>$teacher]);
    }


    public function upselectclass($end_time,$place,$section,$select_class_id,$sen_time,$teacher_id,$week,$id,$nd,$type){
        $res=Db::query(Sql::$str30,[$teacher_id,$nd]);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                if($v['week']==$week){
                    if($v['class_time']==$section){
                        if(!(($v['start_time']>$sen_time&&$v['end_time']>$end_time)
                        ||($v['start_time']<$sen_time&&$v['end_time']<$end_time))){
                            return json(['msg'=>"该讲师该时段以有课请重新安排",'code'=>300]);
                        }
                    }
                }
            }
        }
        $res=Db::query(Sql::$str31,[$place]);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                if($v['week']==$week){
                    if($v['class_time']==$section){
                        if(!(($v['start_time']>$sen_time&&$v['end_time']>$end_time)
                        ||($v['start_time']<$sen_time&&$v['end_time']<$end_time))){
                            return json(['msg'=>"该教室该时段已被使用,请重新选择",'code'=>300]);
                        }
                    }
                }
            }
        }
        $data=[
            'end_time' => $end_time,
            'week' => $week,
            'place' => $place,
            'section' => $section,
            'select_class_id' => $select_class_id,
            'sen_time' => $sen_time,
            'teacher_id' => $teacher_id,
            'nd'=>$nd
        ];
        if($type=='true'){
            Db::name('select_class_info')
            ->where('id', $id)
            ->update($data);
        }else {
            Db::name('select_class_info')->insert($data);
        }
        if($type=='true'){
            return json(['msg'=>"修改成功",'code'=>200]);
        }else {
            return json(['msg'=>"添加成功",'code'=>200]);
        }
    
    }
    
    public function teacherpunishment($teacher_id){
        $res=Db::query(Sql::$str32,[$teacher_id]);
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res]);
    }

    public function teacher_punishment_tf($id,$type){
        $data=[];

        if($type=='T'){
            Db::name('teacher_sanction_info')
            ->where('id', $id)
            ->update(['teacher_tf' => 1]);
        }else {
            Db::name('teacher_sanction_info')
            ->where('id', $id)
            ->update(['teacher_tf' => -1]);
        }
        return json(['msg'=>"修改成功",'code'=>200]);
    }

    public function my_class_day($teacher_id,$nd){
        $res=Db::query(Sql::$str33,[$teacher_id,$nd]);
        $select=Db::query(Sql::$str34,[$teacher_id,$nd]);
        return json(['msg'=>"获取成功",'code'=>200,'data'=>$res,'select'=>$select]);
    }

}
