<?php
namespace app\student\controller;
class Sql
{
    public static $str1=<<<EOD
    SELECT *,a.student_id stid,a.id `key`
    FROM (
    SELECT *
    FROM student 
    WHERE class_grade_id= (
    SELECT class_grade_id
    FROM student
    WHERE student_id=?
    )) a LEFT JOIN (
    SELECT student_name,student_id,student_sex
    FROM student_info
    )b ON a.student_id=b.student_id LEFT JOIN student_class_post c
    ON a.student_id=c.student_id  LEFT JOIN student_post d ON c.student_post_id=d.id
    EOD;


    public static $str2=<<<EOD
    SELECT *,a.id `key`
    FROM (SELECT *
    FROM student_class_day
    WHERE class_id=(
    SELECT class_grade_id
    FROM student
    WHERE student_id=?
    ) AND teacher_id IS NOT NULL AND classroom IS NOT NULL AND `week` IS NOT NULL 
    AND start_time IS NOT NULL  AND nd=?)  a LEFT JOIN  (
    SELECT id pid ,`name` pname
    FROM department
    )b ON a.department_id=b.pid  LEFT JOIN (
    SELECT id sid ,`name`  sname
    FROM department_specialty
    )c ON a.department_specialty_id=c.sid  LEFT JOIN (
    SELECT id ke_id,`name` k_name
    FROM specialty_class
    )d ON a.specialty_class_id=d.ke_id  LEFT JOIN (
    SELECT teacher_name,teacher_id
    FROM teacher_info
    )e ON a.teacher_id=e.teacher_id  LEFT JOIN (
    SELECT id class_id,num
    FROM  student_class
    )f ON a.class_id=f.class_id
    EOD;





    public static $str3=<<<EOD
    SELECT *
    FROM (
    SELECT *
    FROM select_class_student 
    WHERE student_id=?  AND nd=?
    )a  LEFT JOIN select_class_info b ON a.select_class_info_id=b.id 
    LEFT JOIN select_class c ON b.select_class_id=c.id  LEFT JOIN (
    SELECT teacher_id,teacher_name
    FROM teacher_info
    )d ON b.teacher_id=d.teacher_id
    EOD;

    public static $str4=<<<EOD
    SELECT *
    FROM (
       SELECT *
        FROM (
        SELECT
    student_id sid,
    info,
    stundet_tf,
    admin,
    admin_tf,
    epilogue,
    disciplinary_sanction_id,
    clan_sanction_id,
    fujian,
    add_time,
    end_time,
    title,
    send_id ,
    id `key`
    FROM   student_sanction_info
        ) a LEFT JOIN student_info b ON a.sid=b.student_id 
         LEFT JOIN (
    SELECT student_id sids,class_grade_id,specialty_id,
    department_id ssspppid
    FROM student     
         ) c ON a.sid=c.sids 
         LEFT JOIN (
        SELECT id pid, `name` pname
        FROM department 
         ) d ON c.ssspppid=d.pid 
         LEFT JOIN (
        SELECT id dpisd,department_id,`name`
        FROM department_specialty
         ) e ON c.specialty_id=e.dpisd
         LEFT JOIN (
        SELECT teacher_id,teacher_name
        FROM teacher_info
         ) f ON a.admin=f.teacher_id
         ORDER BY a.add_time DESC )a LEFT JOIN(
    SELECT teacher_name send_name,teacher_id send_id
    FROM teacher_info   
         )b ON a.send_id=b.send_id
         LEFT JOIN (
        SELECT id ppid,
        sciplinary_name,
        disciplinary_day,
        disciplinary_sanction_root,
        ts
        FROM disciplinary_sanction
         )p ON a.disciplinary_sanction_id=p.ppid
    WHERE a.student_id=?
    EOD;

    public static $str5=<<<EOD
    SELECT a.id,
    a.lend_id,
    a.lend_start,
    a.lend_end,
    a.book_id,
    a.lend_state,
    b.user_id,
    b.user_name,
    b.department,
    c.library_name,
    c.book_num-c.lend_num borrow
    FROM library_lend a LEFT JOIN (
            SELECT student_id user_id, student_name  user_name ,b.name department
            FROM student_info a LEFT JOIN  (
            SELECT  b.name,a.student_id sid
            FROM student a LEFT JOIN department b ON a.department_id=b.id
            )b ON a.student_id=b.sid
            UNION
            SELECT teacher_id user_id,teacher_name  user_name,b.name department
            FROM teacher_info a LEFT JOIN  (
            SELECT  b.name,a.teacher_id tid
            FROM teacher a LEFT JOIN department b ON a.department_id=b.id
            )b ON a.teacher_id=b.tid
    ) b ON a.lend_id=b.user_id LEFT JOIN library c ON  a.book_id=c.id
    WHERE lend_id=?
    ORDER BY a.lend_state DESC
    EOD;

    public static $str6=<<<EOD
    SELECT *,a.id `key`
    FROM dorm_maintain a  LEFT JOIN  (
    SELECT student_name,student_id ssid
    FROM student_info
    )b  ON a.student_id=b.ssid
    WHERE student_id=?
    ORDER BY sen_time DESC
    EOD;

    public static $str7=<<<EOD
    SELECT *
    FROM (
    SELECT *
    FROM dorm_maintain 
    WHERE id=?
    )a LEFT JOIN (
    SELECT student_name,student_id
    FROM student_info
    )b ON  a.student_id=b.student_id  LEFT JOIN (
    SELECT teacher_name,teacher_id
    FROM teacher_info
    )c ON a.admin=c.teacher_id
 
    EOD;

    public static $str8=<<<EOD
    SELECT `dorm_num` `label`,`dorm_num` `value`
    FROM dorm_num
    EOD;

    public static $str9=<<<EOD
    SELECT 	`dorm_num_id` `label`,`dorm_num_id` `value`
    FROM dorm_info
    WHERE dorm_id=?
    EOD;


    public static $str10=<<<EOD
    SELECT *,a.id `key`
    FROM dorm_maintain a  LEFT JOIN  (
    SELECT student_name,student_id ssid
    FROM student_info
    )b  ON a.student_id=b.ssid LEFT JOIN (
    SELECT teacher_name,teacher_id
    FROM teacher_info
    )c ON a.admin=c.teacher_id
    ORDER BY  state DESC,sen_time DESC
    EOD;



    public function index()
    {
        return '您好！这是一个[teacher]示例应用';
    }
}