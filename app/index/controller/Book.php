<?php
declare(strict_types = 1)
;

namespace app\index\controller;
use think\facade\Db;
use app\index\controller\Sql;


class Book{
    public function index(){
        $res=Db::query(Sql::$str20);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res]);
    }

    public function borrow(){
        $res=Db::query(Sql::$str21);
        foreach($res as $k=>$v){
            if(strlen($v['user_id'])==9){
                $res[$k]['value']='教职工';
                $res[$k]['text']='教职工';
            }else {
                $res[$k]['value']='学生';
                $res[$k]['text']='学生';
            }
        }
        $book=Db::query(Sql::$str22);
        $nian=Db::query(Sql::$str23);
        $arr=[];
        foreach($nian  as $k=>$v){
            if(!in_array(substr($v['lend_start'],0,4),$arr)){
                $str=substr($v['lend_start'],0,4);
                array_push($arr,$str);
            }
        }
        $newarr=[];
        foreach($arr as $k=>$v){
            $newarr[$k]['value']=$v;
            $newarr[$k]['text']=$v.'年';
        }
        $department=Db::query(Sql::$str24);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$res,'bookname'=>$book,'nian'=>$newarr,'department'=>$department]);
    }

    public function addbook($book_name,$book_num,$site,$zuozhe){
        $data = [
            'library_name' =>$book_name,
             'add_time' =>date('Y-m-d'),
             'lend_num' => 0,
             'book_num' => $book_num,
             'zuozhe' => $zuozhe,
             'site' => $book_num,
            ];
        $res=Db::name('library')->insert($data);
        if($res==1){
            return json(['msg'=>'添加成功','code'=>200]);
        }else {
            return json(['msg'=>'添加失败','code'=>310]);
        }
    }

    public function bookup($book_num,$id,$library_name,$site,$zuozhe){
        $res=Db::name('library')
        ->where('id', $id)
        ->update([
        'book_num' => $book_num,
        'zuozhe' => $zuozhe,
        'site' => $site,
        'library_name' => $library_name,
        ]);
        if($res==1){
            return json(['msg'=>'更改成功','code'=>200]);
        }else {
            return json(['msg'=>'更改失败','code'=>310]);
        }
    }

    public function bookdel($id){
        $tf=Db::query(Sql::$str25,[$id]);
        if(sizeof($tf)!=0){
            return json(['msg'=>'该书籍正在被借阅,暂时无法删除','code'=>300]);
        }
        $res=Db::table('library')->where('id',$id)->delete();
        if($res==1){
            return json(['msg'=>'删除成功','code'=>200]);
        }else {
            return json(['msg'=>'删除失败','code'=>310]);
        }
    }

    public function add_jie_book($user_id,$book_id){
        if(strlen($user_id)==9){
            $res=Db::query(Sql::$str26,[$user_id]);
            if(sizeof($res)==0){
                return json(['msg'=>'没有该教职工','code'=>310]);
            }
        }else {
            $res=Db::query(Sql::$str27,[$user_id]);
            if(sizeof($res)==0){
                return json(['msg'=>'没有该学生','code'=>310]);
            }
        }
        $book=Db::query(Sql::$str28,[$book_id]);
        if($book[0]['book_num']-$book[0]['lend_num']>0){
             Db::name('library')
            ->where('id',$book_id)
            ->update([
                'lend_num' =>$book[0]['lend_num']+1,
            ]);

            $data = [
                'lend_id' =>$user_id, 
                'book_id' => $book_id,
                'lend_start'=>date('Y-m-d'),
                'lend_state'=>1
            ];
            Db::name('library_lend')->insert($data);
            return json(['msg'=>'添加成功','code'=>200]);
        }else {
            return json(['msg'=>'该书籍已全部被借阅','code'=>310]);
        }
    
    }

    public function book_gui($id,$book_id){
        $res=Db::name('library_lend')
        ->where('id',$id)
        ->update([
            'lend_state' =>0,
            'lend_end'=>date('Y-m-d')
        ]);
        $data=Db::query(Sql::$str28,[$book_id]);
        $book=null;
        if(sizeof($data)!=0){
            $num=$data[0]['lend_num']-1;
            $book=Db::name('library')
            ->where('id',$book_id)
            ->update([
                'lend_num' =>$num,
            ]);
        }else {
            return json(['msg'=>'归还失败','code'=>310]);
        }
        if($res!=0&&$book!=0){
            return json(['msg'=>'归还成功','code'=>200]);

        }else {
            return json(['msg'=>'归还失败','code'=>310]);
        }
    }

}