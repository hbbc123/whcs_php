<?php
declare (strict_types = 1);

namespace app\student\controller;
use app\student\controller\Sql;
use think\facade\Db;
class Index
{
    public function index()
    {
        return '您好！这是一个[student]示例应用';
    }


    public function getclass($student_id){
        $res=Db::query(Sql::$str1,[$student_id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }


    public function getclass_day($student_id,$nd){
        $res=Db::query(Sql::$str2,[$student_id,$nd]);
        $select=Db::query(Sql::$str3,[$student_id,$nd]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'select'=>$select]);
    }

    public function student_punishment($student_id){
        $res=Db::query(Sql::$str4,[$student_id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function student_puntf($student_id,$type){
        Db::name('student_sanction_info')
        ->where('id', $student_id)
        ->update(['stundet_tf' => $type]);
     return json(['msg'=>'修改成功','code'=>200]);
    }

    public function student_book($student_id){
        $res=Db::query(Sql::$str5,[$student_id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function dorm_look($student_id){
        $res=Db::query(Sql::$str6,[$student_id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function dorm_weix($id){
        $res=Db::query(Sql::$str7,[$id]);
        if(sizeof($res)>0){
            $res[0]['maintain_info']=base64_decode($res[0]['maintain_info']);
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function dorm_bao_add(){
        $res=Db::query(Sql::$str8);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                $res[$k]['children']=Db::query(Sql::$str9,[$v['label']]);
            }
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    
    }


    public function end_dorm(){
    $data = ['dorop_num' =>$_POST['dorop_num'],'title'=>$_POST['title'],'accessory' => $_POST['accessory'],'maintain_info'=>base64_encode($_POST['maintain_info']),'student_id'=>$_POST['student_id'],'state'=>0,'sen_time'=>date('Y-m-d')];
    Db::name('dorm_maintain')->insert($data);
    return json(['msg'=>'添加成功','code'=>200]);
    }

    public function del_dorm_x($id){
        Db::table('dorm_maintain')->where('id',$id)->delete();
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function dorm_look_all(){
        $res=Db::query(Sql::$str10);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function up_dorm_x($id,$type,$teacher_id){
        Db::name('dorm_maintain')
        ->where('id', $id)
        ->update(['state' => $type,'end_time'=>date('Y-m-d'),'admin'=>$teacher_id]);
        return json(['msg'=>'修改成功','code'=>200]);
    }

}
