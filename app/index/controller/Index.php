<?php
declare(strict_types = 1)
;

namespace app\index\controller;
use think\facade\Db;
use app\index\controller\Sys;
class Index
{

    public function sys(){
        return  '好的';
    }
    public function index() //获取教职工信息
    {
        $res = Db::query(Sys::$str);
        $dp = Db::query(Sys::$str1);
        $xz = Db::query('SELECT *
        FROM post;');
        $zz = Db::query('SELECT *
        FROM politics_post;');
        $info = Db::table('teacher_info')->select();
        $newarr = [['bid' => $dp[0]['bid'], 'bname' => $dp[0]['bname'], 'childer' => []]];
        $key = 0;
        foreach ($dp as $k => $v) {
            if ($k >= 1 && $dp[$k - 1]['bid'] != $dp[$k]['bid']) {
                array_push($newarr, ['bid' => $dp[$k]['bid'], 'bname' => $dp[$k]['bname'], 'childer' => []]);
                $key++;
            }
            array_push($newarr[$key]['childer'], ['zbid' => $dp[$k]['zbid'], 'bname' => $dp[$k]['zname'], 'zid' => $dp[$k]['zid']]);

        }
        foreach ($res as $k => $v) {
            $res[$k]['description'] = [['sex' => $v['sex'], 'site' => $v['site'], 'iphone' => $v['iphone'], 'card' => $v['card'],
                    'teacher_id' => $v['key'],
                    'entry_time' => $v['entry_time'],
                    'age' => $this->getAge($v['age']),
                    'key' => $v['key'],
                ]];
        }
        return json(['msg' => '获取成功', 'code' => 200, 'data' => $res, 'department' => $newarr, 'info' => $info, 'xz' => $xz, 'zz' => $zz]);
    }





    public function updata($data)
    { //修改教职工信息
        foreach ($data as $k => &$v) {
            if ($k == 'room' && $v === 0) {
                $v = null;
            }
        }
        $post_info = Db::query('UPDATE post_info SET post_id=? WHERE teacher_id=?;', [$data['admin_post'], $data['teacher_id']]);
        $teacher = Db::query('UPDATE teacher SET department_id=?,specialty_id=? WHERE teacher_id=?;', [$data['department'], $data['room'], $data['teacher_id']]);
        $teacher_info = Db::query('UPDATE teacher_info SET card=?,iphone=?,sex=?,site=? WHERE teacher_id=?', [$data['card'], $data['iphone'], $data['sex'], $data['site'], $data['teacher_id']]);
        return json(['msg' => '修改成功', 'code' => 200]);
    }




    public function studentedu()
    {
        $res = Db::query(Sys::$edu_student);
        $department = Db::query('SELECT id `key`,`name` `text`,`name` `value`
        FROM department WHERE id<=11');
        $department_specialty = Db::query(Sys::$zy);
        $department_specialty_f = Db::query(Sys::$zyNot);
        return json(['msg' => '获取成功', 'data' => $res, 'code' => 200, 'department' => $department, 'department_specialty' => $department_specialty, 'department_specialty_f' => $department_specialty_f]);
    }



    public function selectedRowKeys($data)
    { //批量修改学生的班级
        $str = 'SELECT * FROM student WHERE';
        foreach ($data as $k => $v) {
            if ($k < sizeof($data) - 1) {
                $str .= " student_id='" . $v . "' OR ";
            }
            else {
                $str .= " student_id='" . $v . "' GROUP BY department_id;";
            }
        }
        $res = Db::query($str);
        if (sizeof($res) == 1) {
            $str = Sys::$chac;
            foreach ($data as $k => $v) {
                if ($k < sizeof($data) - 1) {
                    $str .= " a.student_id='" . $v . "' OR ";
                }
                else {
                    $str .= " a.student_id='" . $v . "' GROUP BY b.specialty_id;";
                }
            }
            $res = Db::query($str);
            if (sizeof($res) == 1) {
                $department = Db::query('SELECT *
                 FROM department
                 WHERE id <=11');
                $specialty = Db::query(Sys::$student_zhuan);
                return json(['msg' => '获取成功', 'code' => 400, 'data' => $res, 'department' => $department, 'specialty' => $specialty]);
            }
            else {
                return json(['msg' => '不是同一个专业,无法进行操作', 'code' => 404]);
            }
        }
        else {
            return json(['msg' => '不是同一个院系,无法进行操作', 'code' => 404]);
        }
    }

    public function classrep($res)
    {
        $data = $res; //json转为关联数组
        $zui = Db::query('SELECT *
        FROM student_class
        WHERE department_specialty_id=? AND department_id=? AND student_class_num=?
        ORDER BY  num DESC', [$data['specialty_id'], $data['department_id'], $data['grden']]);
        if (sizeof($zui)) {
            if ($zui[0]['num'] + 1 == $data['class_num']) {
                return json(['msg' => '是否要新建班级?', 'code' => 200, 'data' => $data['class_num']]);
            }
            else if ($data['class_num'] <= $zui[0]['num']) {
                return json(['msg' => '该班级是否添加学生?', 'code' => 202, 'data' => $data['class_num']]);
            }
            else {
                return json(['msg' => '必须保证班级的连续性', 'code' => 303, 'data' => $zui[0]['num'] + 1]);
            }
        }
        else {
            if ($data['class_num'] == 1) {
                return json(['msg' => '是否要新建班级?', 'code' => 400, 'data' => 1]);
            }
            else {
                return json(['msg' => '该年级该专业暂时没有班级所以班级编号必须为1', 'code' => 404]);
            }
        }
        return json($zui);
    }

    public function addstuendclass($data)
    { //显示批量修改学生的原班级
        $str = Sys::$chac;
        foreach ($data as $k => $v) {
            if ($k < sizeof($data) - 1) {
                $str .= " a.student_id='" . $v . "' OR ";
            }
            else {
                $str .= " a.student_id='" . $v . "' ;";
            }
        }
        $res = Db::query($str);
        return json($res);
    }

    public function addclass($data, $t, $batch)
    { //新建添加班级
        $batch = json_decode($batch, true); //json转为关联数组
        if ($t == 0) { //新建
            $data_s = [
                'department_specialty_id' => $batch['specialty_id'],
                'department_id' => $batch['department_id'],
                'student_class_num' => $batch['nj'],
                'num' => $batch['class_num']
            ];
            $id = Db::name('student_class')->insertGetId($data_s);
            foreach ($data as $k => $v) {
                Db::name('student')
                    ->where('student_id', $v)
                    ->update(['class_grade_id' => $id]);
            }
            for ($i = 1; $i < 6; $i++) {
                for ($k = 1; $k < 7; $k++) {
                    $data = ['week' => $i,'nd'=>222, 'class_id' => $id,'class_time'=>$k,'department_id'=>$batch['department_id'],'department_specialty_id'=>$batch['specialty_id']];
                    Db::name('student_class_day')->insert($data);
                }
            }
            return json(['msg' => '操作成功', 'code' => 200]);
        }
        else { //添加
            $res = Db::table('student_class')->where([
                'department_specialty_id' => $batch['specialty_id'],
                'department_id' => $batch['department_id'],
                'student_class_num' => $batch['nj'],
                'num' => $batch['class_num']
            ])->find();
            foreach ($data as $k => $v) {
                Db::name('student')
                    ->where('student_id', $v)
                    ->update(['class_grade_id' => $res['id']]);
            }
            return json(['msg' => '操作成功', 'code' => 200, 'data' => $res]);
        }
    }

    public function classquery()
    {
        $data = Db::query(Sys::$clas_m, [222]);
        $department = Db::query('SELECT id `key`,`name` `text`,`name` `value`
        FROM department WHERE id<=11');
        $department_specialty = Db::query(Sys::$zy);
        return json(['msg' => '获取成功', 'code' => 200, 'data' => $data, 'department' => $department, 'department_specialty' => $department_specialty]);
    }

    public function classkadd($data,  $zid, $kid)
    {
        $str=Sys::$csclass.' WHERE nd=? AND class_id=? ORDER BY a.class_time ASC,a.week ASC';
        $str2=Sys::$keykec.' WHERE a.department_specialty_id=? OR a.department_specialty_id=0';
        $res = Db::query($str, [$data]);
        $kec = Db::query($str2, [$zid]);
        $jiaos = Db::query(Sys::$teacher_add, [$kid]);
        return json(['msg' => '获取成功', 'code' => 200, 'data' => $res, 'teacher' => $jiaos, 'ke' => $kec]);
    }


    public function addkeclass($type, $id, $class_id, $nd, $week, $class_time)
    { //查询课目是否被安排
        if ($type == 0) {
            Db::name('student_class_day')
            ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
            ->update(['specialty_class_id' => $id]);
            $str =Sys::$zrove;
            $data = Db::query($str, [$id, $nd, $class_id]);
            $code = 200;
            $msg = '该课程没有被安排可以添加';
            if (sizeof($data)>1) {
                $code = 300;
                $msg = '该课程已添加请确认操作';
            }
            $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=? ';
            $data5 = Db::query($str2,[$nd, $week,$class_time,$class_id]);
            if($data5[0]['teacher_id']){
                $str40= Sys::$czhebkeche.' WHERE a.teacher_id=? AND nd=? AND `week`=? AND class_time=? AND class_id!=?';
                $datass = Db::query($str40, [$data5[0]['teacher_id'],$nd, $week,$class_time,$class_id]);
                if(sizeof($datass)>0){
                    $s=0;
                    $names;$d;$start;$end;$names;
                    foreach($datass as $k=>$v){
                        if($v['department_specialty_id']==0){
                            $s++;
                            $names=$v['name'];
                            $d=$v['classroom'];
                            $start=$v['start_time'];
                            $end=$v['end_time'];
                            $name=$v['teacher_name'];
                        }
                    }
                  if(sizeof($datass)==$s){
                    $code = 300;
                    $msg=$name.'讲师时段是公共课讲师已有'.$s.'班 '.'课程:'.$names.'地点:'.$d.'学周:'.$start.'-'.$end.'周';
                    Db::name('student_class_day')
                    ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
                    ->update(['specialty_class_id' => $id]);
                    return json(['msg' => $msg, 'code' => $code]);
                  }else {
                    if($data5[0]['start_time']!=null&&$data5[0]['end_time']!=null){
                        $i=0;
                        foreach($datass as $k=>$v){
                            if($v['start_time']>$data5[0]['end_time']&&$v['end_time']>$data5[0]['end_time']
                            ||$v['start_time']<$data5[0]['start_time']&&$v['end_time']<$data5[0]['start_time']){
                                $i++;
                            }
                        }
                        if(sizeof($datass)!=$i){
                            $code = 310;
                            $msg='该讲师时段有课请重新选择';
                            return json(['msg' => $msg, 'code' => $code, 'data' => $data,'sdf'=>$i]);
                        }
                    }else {
                        $code = 310;
                        $msg = '该讲师时段有课请选择学周,判断该老师是否无课';
                    }
                  }
                   }
            }
            return json(['msg' => $msg, 'code' => $code, 'data' => $data, ]);
        }
        else {
            $code = 404;
            $msg = '参数错误';
            return json(['msg' => $msg, 'code' => $code, ]);
        }

    }

    public function classkadds($teacher_id, $nd, $week, $class_time,$class_id)
    { //查询该讲师的课程时间是否冲突
        $str =Sys::$czhebkeche.' WHERE a.teacher_id=? AND nd=? AND `week`=? AND class_time=? AND class_id!=?';
        $data = Db::query($str, [$teacher_id, $nd, $week, $class_time,$class_id]);
        $code = 200;
        $msg = '该讲师时段没有课可以安排';
        if (sizeof($data) != 0) {


            $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=? ';
            $data2 = Db::query($str2,[$nd, $week, $class_time,$class_id]);
            $s=0;
            $k;$d;$start;$end;$name;
            foreach($data as $k=>$v){
                if($v['department_specialty_id']==0){
                    $s++;
                    $k=$v['name'];
                    $d=$v['classroom'];
                    $start=$v['start_time'];
                    $end=$v['end_time'];
                    $name=$v['teacher_id'];
                }
            }
            if(sizeof($data)==$s){
                
                $code = 300;
                $msg=$name.'讲师时段是公共课讲师已有'.$s.'班 '.'课程:'.$k.'地点:'.$d.'学周:'.$start.'-'.$end.'周';
                Db::name('student_class_day')
                ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
                ->update(['teacher_id' => $teacher_id]);
                return json(['msg' => $msg, 'code' => $code, 'data' => $data]);
            }
          
                if($data2[0]['start_time']!=null&&$data2[0]['end_time']!=null){
                    $i=0;
                    foreach($data as $k=>$v){
                        if($v['start_time']>$data2[0]['end_time']&&$v['end_time']>$data2[0]['end_time']
                        ||$v['start_time']<$data2[0]['start_time']&&$v['end_time']<$data2[0]['start_time']){
                            $i++;
                        }
                    }
                    if(sizeof($data)-$i!=0){
                        $code = 310;
                        $msg='该讲师时段有课请重新选择';
                        return json(['msg' => $msg, 'code' => $code, 'data' => $data,'sdf'=>$i]);
                    }

                }else {
                    $code = 310;
                    $msg = '该讲师时段有课请选择学周,判断该老师是否无课';
                }
        }
        $str=Sys::$czhebkeche.' WHERE class_id=? AND nd=? AND `week`=? AND class_time=?';
        $res= Db::query($str,[$class_id,$nd,$week,$class_time]);
        if($res[0]['start_time']!=null&&$res[0]['end_time']!=null&&$res[0]['classroom']!=null){
          $str2=Sys::$czhebkeche.' WHERE classroom=? AND nd=? AND `week`=? AND class_time=? AND class_id!= ?';
          $res2=Db::query($str2,[$res[0]['classroom'],$nd,$week,$class_time,$class_id]);
          if(sizeof($res2)>0){
            $s=0;
            $k;$d;$start;$end;$name;
            foreach($res2 as $k=>$v){
                if($v['department_specialty_id']==0){
                    $s++;
                    $k=$v['name'];
                    $d=$v['classroom'];
                    $start=$v['start_time'];
                    $end=$v['end_time'];
                    $name=$v['teacher_name'];
                }
            }

            if(sizeof($res2)==$s){
                $code = 300;
                $msg='该时段教室公共讲师是'.$name.'已有'.$s.'班 '.'课程:'.$k.'地点:'.$d.'学周:'.$start.'-'.$end.'周';
                return json(['msg' => $msg, 'code' => $code, 'data' => $data]);
            }


                $i=0;
                foreach($res2 as $k=>$v){
                    if($v['start_time']!=null&&$v['end_time']!=null){
                        if($v['start_time']<$res[0]['start_time']&&$v['end_time']<$res[0]['start_time']
                        ||$v['start_time']>$res[0]['end_time']&&$v['end_time']>$res[0]['end_time']){
                            $i++;
                        }
                    }else {
                        $code = 310;
                        $msg = '该教室已被使用,但是学周没有选择,请重新选择教室';
                    }
                }
                if(sizeof($res2)!=$i){
                    $code = 310;
                    $msg = '该教室已被使用,请重新选择教室';
                }
            }
        }
        
            Db::name('student_class_day')
            ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
            ->update(['teacher_id' => $teacher_id]);
        return json(['msg' => $msg, 'code' => $code, 'data' => $data, ]);
    }


    public function classsite($data,$nd,$week,$class_time,$class_id){
      $datass=$data;

      $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
      $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);
      

        $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
        $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);

        $str =Sys::$czhebkeche.' WHERE a.teacher_id=? AND nd=? AND `week`=? AND class_time=? AND class_id!=?';
        $data = Db::query($str, [$data2[0]['teacher_id'], $nd, $week, $class_time,$class_id]);
        $code = 200;
        $msg = '该讲师时段没有课可以安排';
        if (sizeof($data) != 0) {
            $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=? ';
            $data2 = Db::query($str2,[$nd, $week, $class_time,$class_id]);
            $s=0;
            $k;$d;$start;$end;$name;
            foreach($data as $k=>$v){
                if($v['department_specialty_id']==0){
                    $s++;
                    $k=$v['name'];
                    $d=$v['classroom'];
                    $start=$v['start_time'];
                    $end=$v['end_time'];
                    $name=$v['teacher_name'];
                }
            }

            if(sizeof($data)==$s){
                $code = 300;
                $msg=$name.'讲师时该段是公共课讲师已有'.$s.'班 '.'课程:'.$k.'地点:'.$d.'学周:'.$start.'-'.$end.'周';
                $tf=Db::name('student_class_day')
                ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
                ->update(['classroom' => $datass]);
                return json(['msg' => $msg, 'code' => $code, 'data' => $data]);
            }
          
                if($data2[0]['start_time']!=null&&$data2[0]['end_time']!=null){
                    $i=0;
                    foreach($data as $k=>$v){
                        if($v['start_time']>$data2[0]['end_time']&&$v['end_time']>$data2[0]['end_time']
                        ||$v['start_time']<$data2[0]['start_time']&&$v['end_time']<$data2[0]['start_time']){
                            $i++;
                        }
                    }
                    if(sizeof($data)==$i){
                        $code = 310;
                        $msg='该讲师时段有课请重新选择';
                        return json(['msg' => $msg, 'code' => $code, 'data' => $data,'sdf'=>$i]);
                    }
                }else {
                    $code = 310;
                    $msg = '该讲师时段有课请选择学周,判断该老师是否无课';
                }
        }
        $str=Sys::$czhebkeche.' WHERE classroom=? AND nd=? AND `week`=? AND class_time=?';
        $res=Db::query($str,[$datass,$nd,$week,$class_time]);
        $msg='该教室可以使用';
        $code=200;
        $tf=null;
        if(sizeof($res)!=0){
            $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
            $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);
            $i=0;
            $s=0;
            $k;$d;$start;$end;$name;
            foreach($res as $k=>$v){
                if($v['department_specialty_id']==0){
                    $s++;
                    $k=$v['name'];
                    $d=$v['classroom'];
                    $start=$v['start_time'];
                    $end=$v['end_time'];
                    $name=$v['teacher_name'];
                }
            }
            
            if(sizeof($res)==$s||$s!=0){
                $code = 300;
                $msg='该教室时段已有'.$name.'公共课讲师已有'.$s.'班 '.'课程:'.$k.'地点:'.$d.'学周:'.$start.'-'.$end.'周';
                $tf=Db::name('student_class_day')
                ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
                ->update(['classroom' => $datass]);
                return json(['msg' => $msg, 'code' => $code, 'data' => $data,]);
            }
            foreach($res as $k=>$v){
                if($v['start_time']!=null&&$v['end_time']!=null){
                    if($v['start_time']<$data2[0]['start_time']&&$v['end_time']<$data2[0]['start_time']
                    ||$v['start_time']>$data2[0]['end_time']&&$v['end_time']>$data2[0]['end_time']){
                        $i++;
                    }
                }else {
                    $msg='该教室已被使用,但是没有选择学周,暂时无法选择';
                    $code=310;
                    return json(['msg'=>$msg,'code'=>$code]);
                }
            }
            if(sizeof($res)!=$i){
                $msg='该教室已被使用,请重新选择';
                $code=310;
                return json(['msg'=>$msg,'code'=>$code]);
            }else {
                $tf=Db::name('student_class_day')
                ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
                ->update(['classroom' => $datass]);
            }
           
        }
            $tf=Db::name('student_class_day')
            ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
            ->update(['classroom' => $datass]);
        return json(['msg'=>$msg,'code'=>$code,'data'=>$data,'tf'=>$tf]);
    }




    public function classtimeadd($type, $zhou, $class_id, $week, $class_time,$nd ){
        if($type==0){
            $tf=Db::name('student_class_day')
            ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
            ->update(['start_time' => $zhou]);
        }else {
            $tf=Db::name('student_class_day')
            ->where(['class_id'=>$class_id,'nd'=> $nd,'week'=>$week,'class_time'=>$class_time])
            ->update(['end_time' => $zhou]);
        }
        $msg=[];
         $bbb=false;
         $code=200;
        $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
        $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);
       if(sizeof($data2)!=0){
        if($data2[0]['classroom']){
            $str=Sys::$czhebkeche.' WHERE classroom=? AND nd=? AND `week`=? AND class_time=? AND class_id!=?';
            $res=Db::query($str,[$data2[0]['classroom'],$nd,$week,$class_time,$class_id]);
            
            $tf=null;
            $i=0;
            if(sizeof($res)!=0){
                $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
                $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);
                foreach($res as $k=>$v){
                        if($v['start_time']<$data2[0]['start_time']&&$v['end_time']<$data2[0]['start_time']
                        ||$v['start_time']>$data2[0]['end_time']&&$v['end_time']>$data2[0]['end_time']){
                            $i++;
                        }
                   
                }
                if(sizeof($res)!=$i){
                        $bbb=true;
                }
            }
        }
    }
    $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
    $data2=Db::query($str2,[$nd,$week,$class_time,$class_id]);
        $str =Sys::$czhebkeche.' WHERE a.teacher_id=? AND nd=? AND `week`=? AND class_time=? AND class_id!=?';
        $data = Db::query($str, [$data2[0]['teacher_id'], $nd, $week, $class_time,$class_id]);
        if (sizeof($data) != 0) {
            $str2=Sys::$czhebkeche.' WHERE  nd=? AND `week`=? AND class_time=? AND class_id=?';
            $data2 = Db::query($str2,[$nd, $week, $class_time,$class_id]);
            $s=0;
            $k;$d;$start;$end;$name;
            foreach($data as $k=>$v){
                if($v['department_specialty_id']==0){
                    $s++;
                    $k=$v['name'];
                    $d=$v['classroom'];
                    $start=$v['start_time'];
                    $end=$v['end_time'];
                    $name=$v['teacher_name'];
                }
            }
            
            if(sizeof($data)==$s){
                $code=300;
                array_push($msg, $name.'讲师该时段是公共课讲师已有'.$s.'班 '.'课程:'.$k.'地点:'.$d.'学周:'.$start.'-'.$end.'周');
             $bbb=false;
            }else {
              
                if($data2[0]['start_time']!=null&&$data2[0]['end_time']!=null){
                    $i=0;
                    foreach($data as $k=>$v){
                        if($v['start_time']>$data2[0]['end_time']&&$v['end_time']>$data2[0]['end_time']
                        ||$v['start_time']<$data2[0]['start_time']&&$v['end_time']<$data2[0]['start_time']){
                            $i++;
                        }
                    }
                    if(sizeof($data)!=$i){
                        $code=310;
                        array_push($msg,'该讲师时段有课请重新选择'); 
                    }
                }else {
                    $code=310;
                    array_push($msg,'该讲师时段有课但是没有选择学周,请重新选择学周或者更换讲师'); 
                }
            }
          
        }
        if($bbb){
            $code=310;
            array_push($msg,'该教室已被使用,请重新选择');
        }
      
       
        return json(['msg'=>$msg, 'code'=>$code]);
    }

    public function sendcontent($accept_id,$sen_id,$info){
        $data = ['accept_id' => $sen_id, 'sen_id' => $accept_id,'info'=>$info,'state'=>1,'sen_time'=>date("Y-m-d H:i:s")];
        $res=Db::name('chat')->insert($data);
        if($res==1){
            return json(['msg'=>'发送成功','code'=>200]);
        }else {
            return json(['msg'=>'发送失败','code'=>310]);
        }
    }

    public function Moneyapply($teacher_id){
        $res=Db::query(Sys::$Moneyapply,[$teacher_id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function money_look($id){
        $res=Db::query(Sys::$money_look,[$id]);
        if(sizeof($res)>0){
            $res[0]['money_info']=base64_decode($res[0]['money_info']);
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function Moneyall($nd){
        $res=Db::query(Sys::$Moneyall,[$nd,$nd]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function getdepartment($id){
        $res=Db::query(Sys::$getdepartment,[$id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function moneytf($id,$type,$teacher_id,$department,$nd){
        if($type==1){
            $res=Db::query(Sys::$money_look,[intval($id)]);
            $money=Db::query(Sys::$jisdf,[$department,$nd]);
            Db::name('department_money')
            ->where(['department_id'=>$department,'nd'=>$nd])
            ->update(['yi' =>$money[0]['yi']+$res[0]['add_money'],
            'jie'=>$money[0]['zong']-($money[0]['yi']+$res[0]['add_money'])
            ]);
        }
        Db::name('department_money_info')
        ->where('id', $id)
        ->update(['moeny_state' => $type,'admin_time'=>date('Y-m-d'),'moeny_admin'=>$teacher_id]);
        return json(['msg'=>'审批成功','code'=>200]);
    }

    public function moneyset(){
        $res=Db::query(Sys::$Moneyset);
        $post=Db::query(Sys::$Moneyset_two);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'post'=>$post]);
    }

    public function up_money($id,$nd,$type,$money){
        if($type=='1'){
            Db::name('department_money')
            ->where(['department_id'=>$id,'nd'=>$nd])
            ->update(['zong' => $money]);
        }else {
            $data = ['department_root'=>7, 'department_root_big' => 7,'department_id'=>$id,
            'zong'=>$money,'jie'=>0,'nd'=>$nd,'yi'=>0
            ];
            Db::name('department_money')->insert($data);
        }
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function up_money_root($id, $nd,$department_root,$department_root_big){
        Db::name('department_money')
        ->where(['department_id'=>$id,'nd'=>$nd])
        ->update(['department_root' => $department_root,
        'department_root_big' => $department_root_big]);
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function Moneyadd(){
    $data = ['applicant_id' => $_POST['applicant_id'], 
    'money_info' => base64_encode($_POST['maintain_info']),
    'moeny_accessory'=>$_POST['title'],
    'moeny_state'=>0,
    'add_money'=>$_POST['add_money'],
    'apply_time'=>date('Y-m-d'),
    'nd'=>$_POST['nd'], ];
    Db::name('department_money_info')->insert($data);
    return json(['msg'=>'新增成功','code'=>200]);
       
    }

    public function del_moeny($id){
        Db::table('department_money_info')->where('id',$id)->delete();
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function leave($id){
        $res=Db::query(Sys::$leave,[$id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function leavelook($id){
        $res=Db::query(Sys::$leavelook,[$id]);
        if(sizeof($res)>0){
            $res[0]['leave_info']==base64_decode($res[0]['leave_info']);
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function leave_add_look($id){
        $res=Db::query(Sys::$leave_add_look_class);
        $student=Db::query(Sys::$leave_add_look_student,[$id]);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                if($v['root_id']){
                    $son=Db::query(Sys::$leave_add_look_son,[$student[0]['department_id'],$res[$k]['leave_root']]);
                    if(sizeof($son)>0){
                        $res[$k]['user_name']=$son[0]['teacher_name'];
                        $res[$k]['user_id']=$son[0]['teacher_id'];
                    }
                }else {
                    $son=Db::query(Sys::$leave_add_look_son_class,[$student[0]['class_grade_id']]);
                    if(sizeof($son)>0){
                        $res[$k]['user_name']=$son[0]['student_name'];
                        $res[$k]['user_id']=$son[0]['student_id'];
                        $res[$k]['name']='班长';
                    }
                }
                if($v['leave_root']==10){
                    $son=Db::query(Sys::$instructor_id,[$student[0]['class_grade_id']]);
                    $res[$k]['user_name']=$son[0]['teacher_name'];
                    $res[$k]['user_id']=$son[0]['teacher_id'];
                }
                if($v['leave_root']==1){
                    $schoole=Db::query(Sys::$Leaveset_post_school);
                    $res[$k]['user_name']=$schoole[0]['teacher_name'];
                    $res[$k]['user_id']=$schoole[0]['teacher_id'];
                }
            }
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function leave_add(){
       $student=$res=Db::query(Sys::$leave_add_look_student,[$_POST['student_id']]);
       $data = ['leave_info' =>$_POST['leave_info'], 'student_id' => $_POST['student_id'],
        'leave_accessory'=>$_POST['leave_accessory'],'leave_class'=>$_POST['leave_class'],
        'leave_admin'=>$_POST['leave_admin'],
        'leave_start'=>$_POST['leave_start'],
        'leave_end'=>$_POST['leave_end'],
        'stundet_class_id'=>$student[0]['class_grade_id'],
        'state'=>0,
        ];
        Db::name('leave_second')->insert($data);
       return json(['msg'=>'添加成功','code'=>200]);
    }

    public function leave_del($id){
        Db::table('leave_second')->where('id',$id)->delete();
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function leaverootindex($id){
        $res=Db::query(Sys::$leaverootindex,[$id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function root_reave($id,$type){
        Db::name('leave_second')
        ->where('id', $id)
        ->update(['state' => $type]);
        return json(['msg'=>'审批成功','code'=>200]);
    }

    public function Leaveset(){
        $res=Db::query(Sys::$Leaveset);
        $post=Db::query(Sys::$Leaveset_post);
        if(sizeof($res)>0){
            foreach($res as $k=>$v){
                if(!$v['root_id']){
                    $res[$k]['name']='班长';
                }
            }
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'post'=>$post]);
    }


    public function add_leave_day($type,$class,$day,$leave_root){
        $data=['class' =>$class,
        'day' =>$day,
        'leave_root' =>$leave_root,];
        if($type!='0'){
            Db::name('leave')
            ->where('id', $type)
            ->update($data);
            return json(['msg'=>'修改成功','code'=>200]);
        }else {
            Db::name('leave')->insert($data);
            return json(['msg'=>'添加成功','code'=>200]);
        }
        
    }

    public function del_leave_del($id){
        Db::table('leave')->where('id',$id)->delete();
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function get_select_class($id,$nd){
        $res=Db::query(Sys::$get_select_class,[$id]);
        $class=Db::query(Sys::$get_select_class_class,[$nd]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'class'=>$class]);
    }

    public function del_select_class($id){
        Db::table('select_class_student')->where('id',$id)->delete();
        return json(['msg'=>'退课成功','code'=>200]);
    }

    public function add_select_class($id,$nd,$student){
        $select_class=Db::table('select_class_info')->where('id', $id)->select();
        $class_ke=Db::query(Sys::$add_select_class_student,[$student,$nd,$student]);
        if(sizeof($class_ke)>0){
            foreach($class_ke as $k=>$v){
                if($select_class[0]["week"]==$v['week']&&
                $select_class[0]["section"]==$v['class_time']
                ){
                    if(!($v['start_time']<$select_class[0]["sen_time"]&&$v['end_time']<$select_class[0]["sen_time"]
                    ||$v['start_time']>$select_class[0]["end_time"]&&$v['end_time']>$select_class[0]["end_time"])){
                        return json(['msg'=>'课程冲突请重新选择','code'=>310]);
                    }
                }
            }
        }
        $student_class=Db::table('student')->where('student_id', $student)->select();
        $data = ['student_id' =>$student, 'select_class_info_id' =>$id,'nd'=>$nd,'student_class'=>$student_class[0]['class_grade_id']];
        Db::name('select_class_student')->insert($data);
        return json(['msg'=>'选修课添加成功','code'=>200]);
    }

    public function student_grade($id){
        $res=Db::query(Sys::$student_grade,[$id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function Management(){
        $data=Db::query(Sys::$Management_data);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$data,'department'=>$department,'department_specialty'=>$department_specialty]);
    }

    public function up_Management($student_iphone,$student_name,$student_sex,$student_site,$student_id){
        Db::name('student_info')
        ->where('student_id', $student_id)
        ->update([
            'student_iphone' =>$student_iphone,
            'student_name' =>$student_name,
            'student_sex' =>$student_sex,
            'student_site' =>$student_site,
        ]);
    return json(['msg'=>'修改成功','code'=>200]);
    }

    public function Graduate($nd){
        $res=Db::query(Sys::$Graduate,[$nd-2]);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'department'=>$department,'department_specialty'=>$department_specialty]);
    }

    public function up_Graduate($student_id,$type){
        $student_info=Db::table('student_info')->where('student_id', $student_id)->select();
        $student=Db::table('student')->where('student_id', $student_id)->select();
        $arr=$student_info[0];
        unset($arr['id']);
        $arr['department_id']=$student[0]['department_id'];
        $arr['class_grade_id']=$student[0]['class_grade_id'];
        $arr['specialty_id']=$student[0]['specialty_id'];
        Db::name('student_old')->insert($arr);
        $drom=Db::query(Sys::$up_Graduate,[$student_id,$student_id,$student_id,$student_id]);
        if(sizeof($drom)>0){
           $data=$drom[0];
           $drom_id=$drom[0]['id'];
           unset($data['id']);
           $data['state']=$type;
           if($data['member_one_id']==$student){
            unset($data['member_one_id']);
           }else if($data['member_two_id']==$student){
            unset($data['member_two_id']);
           }else if($data['member_three_id']==$student){
            unset($data['member_three_id']);
           }else if($data['member_four_id']==$student){
            unset($data['member_four_id']);
           }
           Db::name('dorm_info')
            ->where('id',$drom_id )
            ->update($data);
        }
        Db::table('student_info')->where('student_id',$student_id)->delete();
        Db::table('student')->where('student_id',$student_id)->delete();
        Db::table('chat')->where('sen_id',$student_id)->delete();
        Db::table('chat')->where('accept_id',$student_id)->delete();
        Db::table('dorm_maintain')->where('student_id',$student_id)->delete();
        Db::table('leave_second')->where('student_id',$student_id)->delete();
        Db::table('library_lend')->where('lend_id',$student_id)->delete();
        Db::table('student_class_post')->where('student_id',$student_id)->delete();
        Db::table('student_grade')->where('student_id',$student_id)->delete();
        Db::table('student_sanction_info')->where('student_id',$student_id)->delete();
        Db::table('select_class_student')->where('student_id',$student_id)->delete();
        Db::table('dorm_maintain')->where('student_id',$student_id)->delete();
        return json(['msg'=>'操作成功','code'=>200]);
    }

    public function get_class_student(){
        $res=Db::query(Sys::$get_class_student);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'department'=>$department,'department_specialty'=>$department_specialty]);
    }

    public function Beforestudent(){
        $res=Db::query(Sys::$Beforestudent);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'department'=>$department,'department_specialty'=>$department_specialty]);
    }

    public function del_teacher_id($teacher_id,$type){
        $teacher_info=Db::table('teacher_info')->where('teacher_id', $teacher_id)->select();
        $teacher=Db::table('teacher')->where('teacher_id', $teacher_id)->select();
        $arr=$teacher_info[0];
        unset($arr['id']);
        $arr['state']=$type;
        $arr['department_id']=$teacher[0]['department_id'];
        $arr['specialty_id']=$teacher[0]['specialty_id'];
        $arr['end_time']=date('Y-m-d');
        Db::name('teacher_old')->insert($arr);

        Db::table('chat')->where('sen_id',$teacher_id)->delete();
        Db::table('chat')->where('accept_id',$teacher_id)->delete();
        Db::table('department_money_info')->where('applicant_id',$teacher_id)->delete();
        Db::table('dorm_admin')->where('teacher_id',$teacher_id)->delete();
        Db::table('leave_second')->where('leave_admin',$teacher_id)->delete();
        Db::table('library_lend')->where('lend_id',$teacher_id)->delete();
        Db::table('politics_info')->where('teacher_id',$teacher_id)->delete();
        Db::table('post_info')->where('teacher_id',$teacher_id)->delete();
        Db::table('select_class_info')->where('teacher_id',$teacher_id)->delete();

        $class_instructor_id=Db::table('student_class')->where('instructor_id', $teacher_id)->select();
        $class_director_id=Db::table('student_class')->where('director_id', $teacher_id)->select();
        if(sizeof($class_instructor_id)>0){
            foreach($class_instructor_id as $k=>$v){
                Db::name('student_class')
                ->where('id', $v['id'])
                ->update(['instructor_id' => NULL]);
            }
        }
        if(sizeof($class_director_id)>0){
            foreach($class_director_id as $k=>$v){
                Db::name('student_class')
                ->where('id', $v['id'])
                ->update(['director_id' => NULL]);
            }
        }
        $class_day=Db::table('student_class_day')->where('teacher_id', $teacher_id)->select();
        if(sizeof($class_day)>0){
            foreach($class_director_id as $k=>$v){
                Db::name('student_class')
                ->where('id', $v['id'])
                ->update(['teacher_id' => NULL]);
            }
        }
        Db::table('teacher')->where('teacher_id',$teacher_id)->delete();
        Db::table('teacher_info')->where('teacher_id',$teacher_id)->delete();
        Db::table('teacher_sanction_info')->where('teacher_id',$teacher_id)->delete();

        return json(['msg'=>'操作成功','code'=>200]);
    }

    public function Beforeteacher(){
        $res=Db::query(Sys::$Beforeteacher);
        $department=Db::query(Sys::$Management_department);
        return json(['msg'=>'操作成功','code'=>200,'data'=>$res,'department'=>$department]);
    }

    public function member(){
        $res=Db::query(Sys::$member);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        $member_select=Db::query(Sys::$member_select);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'department'=>$department,'department_specialty'=>$department_specialty,'member_select'=>$member_select]);
    }

    public function up_Member($student_id,$type){
        Db::name('student_info')
        ->where('student_id', $student_id)
        ->update(['student_politics' => $type]);
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function Course(){
        $res=Db::query(Sys::$Course);
        $department=Db::query(Sys::$Management_department);
        $department_specialty=Db::query(Sys::$Management_department_specialty);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'department'=>$department,'department_specialty'=>$department_specialty]);
    }

    public function up_Course($pid,$sid,$id,$name,$type,$time,$grade,$updata){
       if($updata=='true'){
        $data = [
            'name' => $name,
            'time' => $time,
            'grade' => $grade];
        if($type=='a'){
            $data['department_specialty_id']=$sid;
            Db::name('specialty_class')
            ->where('id', $id)
            ->update($data);
        }else if($type=='b'){
            Db::name('common_class')
            ->where('id', $id)
            ->update($data);
        }else if($type=='c'){
            Db::name('select_class')
            ->where('id', $id)
            ->update($data);
        }
       }else {
        $data = [
        'name' => $name,
        'time' => $time,
        'grade' => $grade];
        if($type=='a'){
            $data['department_specialty_id']=$sid;
            Db::name('specialty_class')->insert($data);
        }else if($type=='b'){
            Db::name('common_class')->insert($data);
        }else if($type=='c'){
            Db::name('select_class')->insert($data);
        }
       }
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function del_Course($id,$type){
        if($type=='a'){
            Db::table('specialty_class')->where('id',$id)->delete();
        }else if($type=='b'){
            Db::table('common_class')->where('id',$id)->delete();
        }else if($type=='c'){
            Db::table('select_class')->where('id',$id)->delete();
        }
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function Systemroot(){
        $res=Db::query(Sys::$Systemroot_department);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,]);
    }

    public function Systemroot_post($id){
        $res=Db::query(Sys::$Post_z,[$id]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function Systemroot_info($pid,$sid){
        $res=Db::query(Sys::$Systemroot_info);
        $Systemroot_info_data=Db::query(Sys::$Systemroot_info_data,[$pid,$sid]);
        $str=[];
        foreach($Systemroot_info_data as $k=>$v){
            array_push($str,$v['site']);
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'str'=>$str]);
    }

    public function up_Systemroot($pid,$sid,$root_info_id,$type){
        $data =[
            'root_id'=>$root_info_id,
            'department_id'=>$pid,
            'post_id'=>$sid
        ];
        if($type=='true'){
            Db::name('teacher_root_info')->insert($data);
        }else {
            Db::table('teacher_root_info')->where($data)->delete();
        }
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function del_Systemroot($pid,$sid){
        Db::table('teacher_root_info')->where([
            'department_id'=>$pid,
            'post_id'=>$sid,
        ])->delete();
        return json(['msg'=>'删除成功','code'=>200]);
    }

    public function get_Systemroot_post(){
        $res=Db::query(Sys::$get_Systemroot_post);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }



    public function get_post_Systemroot_all_bsd(){
        $res=Db::query(Sys::$get_post_Systemroot_all_bsd);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function add_Systemroot($pid,$sid,$data){
        foreach($data as $k=>$v){
            $data = ['department_id' => $pid, 'post_id' =>$sid,'root_id'=>intval($v)];
            Db::name('teacher_root_info')->insert($data);
        }
        return json(['msg'=>'添加成功','code'=>200]);
    }

    public function Systemroot_post_student(){
        $res=Db::query(Sys::$Systemroot_post_student);
        $data=Db::query(Sys::$Systemroot_post_student_root_ALL);
        $str=[];
        foreach($res as $k=>$v){
            array_push($str,$v['site']);
        }
        return json(['msg'=>'获取成功','code'=>200,'data'=>$data,'str'=>$str]);
    }

    public function up_Systemroot_student($type,$id){
        if($type=='true'){
            $data = ['root_id' => $id];
            Db::name('studnet_root_info')->insert($data);
        }else {
            Db::table('studnet_root_info')->where('root_id',$id)->delete();
        }
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function get_root(){
        $res=Db::query(Sys::$get_root);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }


    public function get_root_name(){
        $res=Db::query(Sys::$get_root_name);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function up_Functionset($type,$name){
        $res=Db::query(Sys::$get_root);
        $data=$res[0];
        if($type=='true'){
            $data[$name]=0;
        }else {
            $data[$name]=1;
        }
        Db::name('switch')
        ->where('id', 1)
        ->update($data);
        return json(['msg'=>'修改成功','code'=>200]);
    }

    public function set_inform($sen_id,$accept_id,$info,$sen_time){
        $data = ['sen_id' => $sen_id, 'accept_id' => $accept_id,
        'info'=>$info,'state'=>1,'sen_time'=>$sen_time];
        Db::name('inform')->save($data);
        return json(['msg'=>'添加成功','code'=>200]);
    }


    public function get_post_Systemroot_all_bbb($user_id){
        if(strlen($user_id)==9){
            $user_info=Db::query(Sys::$get_post_Systemroot_all_info,[$user_id]);
            $res=Db::query(Sys::$get_post_Systemroot_all,[$user_info[0]['department_id'],$user_info[0]['post_id']]);
            $arr=[];
            foreach($res as $k=>$v){
                $sonarr=[];
                $sonarr['value']=$v['id'];
                $sonarr['site']=$v['site'];
                $sonarr['key']=$v['key'];
                if($v['father']!='false'){
                    $son=Db::query(Sys::$get_post_Systemroot_all_son,[$user_info[0]['department_id'],$user_info[0]['post_id'],$v['father']]);
                    $sonarr['children']=$son;
                    $sonarr['title']=$v['father'];
                    array_push($arr,$sonarr);
                }else {
                    $sonarr['title']=$v['remark'];
                    array_push($arr,$sonarr);
                }
            }
            $dan=Db::query(Sys::$get_post_Systemroot_all_dan,[$user_info[0]['department_id'],$user_info[0]['post_id']]);
            if(sizeof($dan)>0){
                foreach($dan as $k=>$v){
                    $sonarr=[];
                    $sonarr['title']=$v['remark'];
                    $sonarr['value']=$v['id'];
                    $sonarr['site']=$v['site'];
                    $sonarr['key']=$v['key'];
                    array_push($arr,$sonarr);
                }
            }
            return json(['msg'=>'获取成功','code'=>200,'data'=>$arr]);
        }else {
            $arr=[];
            $user_info=Db::query(Sys::$get_post_student);
            if(sizeof($user_info)>0){
                foreach($user_info as $k=>$v){
                    $sonarr=[];
                    $sonarr['value']=$v['id'];
                    $sonarr['site']=$v['site'];
                    $sonarr['key']=$v['key'];
                    if($v['father']!='false'){
                        $son=Db::query(Sys::$get_post_student_son,[$v['father']]);
                        $sonarr['children']=$son;
                        $sonarr['title']=$v['father'];
                        array_push($arr,$sonarr);
                    }
                }
                $son_p=Db::query(Sys::$son_p);
                if(sizeof($son_p)>0){
                    foreach($son_p as $k=>$v){
                        $sonarr=[];
                        $sonarr['title']=$v['remark'];
                        $sonarr['value']=$v['id'];
                        $sonarr['site']=$v['site'];
                        $sonarr['key']=$v['key'];
                        array_push($arr,$sonarr);
                    }
                }
            }
            return json(['msg'=>'获取成功','code'=>200,'data'=>$arr]);
        }
    }

    public function overview_department($id){
        $res=[];$arr=[];
        if($id==0){
            $res=Db::query(Sys::$overview_department);
        }
        if($id==1){
            $res1=Db::query(Sys::$overview_sex,['男']);
            $res2=Db::query(Sys::$overview_sex,['女']);
            $res=[['value'=>$res1[0]['zong'],'name'=>'男'],
                 ['value'=>$res2[0]['zong'],'name'=>'女']];
        }
        if($id==2){
            $res=Db::query(Sys::$overview_nian);
        }
        $arr=Db::query(Sys::$overview_department_zong);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'zong'=>$arr]);
    }






    public function sysssd(){
    Db::table('teacher_root_info')->where('root_id',54)->delete();
    }















    private function getAge($riqi)
    {
        $birthday = strtotime($riqi);
        //格式化出生时间年月日
        $byear = date('Y', $birthday);
        $bmonth = date('m', $birthday);
        $bday = date('d', $birthday);

        //格式化当前时间年月日
        $tyear = date('Y');
        $tmonth = date('m');
        $tday = date('d');

        //开始计算年龄
        $age = $tyear - $byear;
        if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
            $age--;
        }
        return $age;
    }
}
