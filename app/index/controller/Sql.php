<?php

namespace app\index\controller;
class Sql {
    //查找教职工所在的班级的职务
    public static $str1=<<<EOD
    SELECT *,id `key`
    FROM (
                SELECT * 
                        FROM student_class a LEFT JOIN (
                        SELECT b.teacher_id,b.teacher_name
                        FROM teacher a LEFT JOIN (
                        SELECT *
                        FROM teacher_info 
                        )b ON a.teacher_id=b.teacher_id
    
                        ) b ON a.instructor_id=b.teacher_id 
    
    )a  LEFT JOIN (
    SELECT b.teacher_id ban_id,b.teacher_name ban_name
    FROM teacher a LEFT JOIN (
    SELECT *
    FROM teacher_info 
    )b ON a.teacher_id=b.teacher_id
    
    
    
    )b   ON  a.director_id=b.ban_id  LEFT JOIN (
    SELECT id pid ,`name` pname
    FROM department
    
    ) c ON a.department_id=c.pid  LEFT JOIN (
    SELECT id kid ,`name` kname
    FROM department_specialty
    
    )d ON a.department_specialty_id=d.kid
    EOD;


    //查找院系
    public static $str2=<<<EOD
    SELECT id `key`,`name` `text`,`name` `value`
    FROM   department
    WHERE id<=11
    EOD;


    //查找院系职务为班主任的教职工
    public static $str3=<<<EOD
    SELECT a.teacher_name value,a.teacher_name label,a.teacher_id,b.name,c.department_id
    FROM teacher_info a LEFT JOIN (
        SELECT b.name,a.teacher_id
        FROM post_info a  LEFT JOIN (
        SELECT *
        FROM post
        ) b ON a.post_id=b.id
    )b ON a.teacher_id=b.teacher_id  LEFT JOIN (
    SELECT *
    FROM teacher
    ) c ON a.teacher_id=c.teacher_id
    WHERE  c.department_id=? AND b.name='班主任'
    EOD;

    //查找院系职务为辅导员的教职工
    public static $str4=<<<EOD
    SELECT a.teacher_name value,a.teacher_name label,a.teacher_id,b.name,c.department_id
    FROM teacher_info a LEFT JOIN (
        SELECT b.name,a.teacher_id
        FROM post_info a  LEFT JOIN (
        SELECT *
        FROM post
        ) b ON a.post_id=b.id
    )b ON a.teacher_id=b.teacher_id  LEFT JOIN (
    SELECT *
    FROM teacher
    ) c ON a.teacher_id=c.teacher_id
    WHERE  c.department_id=? AND b.name='辅导员'
    EOD;

    public static $str5=<<<EOD
    SELECT * 
    FROM student_class 
    WHERE id!=? AND instructor_id=?
    EOD;

    public static $str6=<<<EOD
    SELECT * 
    FROM student_class 
    WHERE id!=? AND director_id=?
    EOD;

    public static $str7=<<<EOD
    SELECT 
    b.id  `key`,
    b.dorm_num_id `name`,
    b.member_one_id,
    b.member_two_id,
    b.member_three_id,
    b.member_four_id,
    b.time,
    b.dorm_id
    FROM dorm_info a JOIN (
    SELECT *
    FROM dorm_info
    WHERE member_one_id IS  NULL  OR
    member_two_id IS  NULL  OR
    member_three_id IS  NULL  OR
    member_four_id IS  NULL    
    ) b ON a.id=b.id
    WHERE a.dorm_id=?
    EOD;

    public static $str8=<<<EOD
    SELECT *
    FROM dorm_info
    WHERE 
    member_one_id=? OR
    member_two_id=? OR
    member_three_id=? OR
    member_four_id=?
    EOD;

    public static $str9=<<<EOD
    SELECT *
    FROM dorm_info
    WHERE dorm_num_id=? AND dorm_id=?
    EOD;

    public static $str10=<<<EOD
    SELECT *
    FROM student_info
    WHERE student_id=?
    EOD;



public static $str11=<<<EOD
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
EOD;



    public static $str12=<<<EOD
        SELECT*,a.id `key`
        FROM student_sanction_info a LEFT JOIN student_info b ON a.student_id=b.student_id 
        LEFT JOIN student c ON a.student_id=c.student_id 
        LEFT JOIN (
        SELECT *, `name` pname
        FROM department
        ) d ON c.department_id=d.id
        LEFT JOIN department_specialty e ON c.specialty_id=e.id
        LEFT JOIN teacher_info f ON a.admin=f.teacher_id
        LEFT JOIN (
        SELECT teacher_id sendid,teacher_name send_name
        FROM teacher_info
        ) s ON a.send_id=s.sendid
        LEFT JOIN (
        SELECT id dsid,sciplinary_name
        FROM disciplinary_sanction
        )n ON a.disciplinary_sanction_id=n.dsid
        LEFT JOIN  (
        SELECT b.num,a.student_id,c.teacher_name  fname,d.teacher_name bname,b.student_class_num
        FROM student a LEFT JOIN student_class b  ON a.class_grade_id=b.id
        LEFT JOIN teacher_info c ON b.instructor_id=c.teacher_id
        LEFT JOIN teacher_info d ON b.director_id=d.teacher_id
        )  g ON a.student_id=g.student_id
        WHERE a.id=?
    EOD;


    public static $str13=<<<EOD
    SELECT *
    FROM student_sanction_info
    WHERE id=? AND student_id=?
    EOD;

    public static $str14=<<<EOD
    SELECT *
    FROM student_sanction_info
    WHERE id=? 
    EOD;


    public static $str15=<<<EOD
    SELECT sciplinary_name `vuale`,sciplinary_name `label`,id `key`
    FROM disciplinary_sanction
    WHERE ts=1
    EOD;


    public static $str16=<<<EOD
    SELECT id `value`,`name` `label`
    FROM department
    WHERE id<=11
    EOD;

    public static $str17=<<<EOD
    SELECT id `value`,`name` `label`,department_id pid
    FROM department_specialty 
    WHERE department_id<=11 AND `name`!='院团委办公室' AND `name`!='院党委办公室' 
    EOD;


    public static $str18=<<<EOD
    SELECT num `value`,CONCAT(num,"班") `label`,id
    FROM student_class
    WHERE department_specialty_id=? AND student_class_num=?
    EOD;



    public static $str19=<<<EOD
    SELECT *
    FROM (
    SELECT *
    FROM student 
    WHERE class_grade_id=?
    )a  LEFT JOIN (
    SELECT student_id `value`,student_name  `label`
    FROM student_info
    )b ON a.student_id=b.value
    EOD;

    public static $str20=<<<EOD
    SELECT *,id `key`,library_name text,library_name value
    FROM library
    EOD;

    public static $str21=<<<EOD
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
    ORDER BY a.lend_state DESC
    EOD;


    public static $str22=<<<EOD
    SELECT id `key`,library_name text,library_name value
    FROM library
    EOD;

    public static $str23=<<<EOD
    SELECT lend_start 
    FROM library_lend
    EOD;

    public static $str24=<<<EOD
    SELECT `name` `value`,`name` `text`
    FROM department
    WHERE id<=11
    EOD;

    public static $str25=<<<EOD
    SELECT *
    FROM library_lend
    WHERE lend_state=1 AND book_id=?
    EOD;

    public static $str26=<<<EOD
    SELECT *
    FROM teacher
    WHERE teacher_id=?
    EOD;

    public static $str27=<<<EOD
    SELECT *
    FROM student
    WHERE student_id=?
    EOD;


    public static $str28=<<<EOD
    SELECT *
    FROM library
    WHERE id=?
    EOD;

    
    public static $str29=<<<EOD
    SELECT * ,c.id `key`
    FROM  student_class_day a  LEFT JOIN (
    SELECT *
    FROM specialty_class 
    )b ON a.specialty_class_id=b.id LEFT JOIN student_class c ON a.class_id=c.id
    LEFT JOIN (
    SELECT id sid,`name` sname
    FROM department_specialty
    )d   ON a.department_specialty_id=d.sid
    WHERE teacher_id=? AND a.nd=? 
    GROUP BY class_id
    EOD;

    public static $str30=<<<EOD
    SELECT a.student_id,b.student_name,a.class_grade_id,a.student_id `key`,c.one_grade,
    c.two_grade
    FROM student a LEFT JOIN student_info b ON a.student_id=b.student_id LEFT JOIN (
    SELECT *
    FROM student_grade
    WHERE student_class_id=? AND semester=? AND specialty_class_id=?
    )c  ON a.student_id=c.student_id
    WHERE class_grade_id=? 
    EOD;

    public static $str31=<<<EOD
    SELECT *
    FROM student_grade
    WHERE semester=? AND student_class_id=? AND student_id=? AND specialty_class_id=?
    EOD;


    public static $str32=<<<EOD
    SELECT *
    FROM select_class_info a LEFT JOIN (
    SELECT id select_id,`name` select_name
    FROM select_class
    )b  ON a.select_class_id=b.select_id  
    WHERE nd=? AND teacher_id=?
    EOD;


    public static $str33=<<<EOD
    SELECT *,a.student_id sid
    FROM select_class_student  a LEFT JOIN (
    SELECT *,SUBSTRING(a.student_id,1,4) AS nj
    FROM student a LEFT JOIN (
    SELECT id pid,`name` pname
    FROM department 
    ) b  ON a.department_id=b.pid  LEFT JOIN (
    SELECT student_id sid,student_name
    FROM student_info
    )c  ON a.student_id=c.sid
    ) b ON a.student_id=b.student_id  LEFT JOIN (
    SELECT *
    FROM student_grade  
    WHERE semester=?
    ) e ON e.specialty_class_id=? AND a.student_id=e.student_id
    WHERE a.select_class_info_id=? AND a.nd=?
    EOD;



    //班级课程
    public static $str40=<<<EOD
    SELECT *
    FROM student_class_day  a LEFT JOIN (
    SELECT id,`name`
    FROM specialty_class
    UNION
    SELECT id,`name`
    FROM select_class
    UNION
    SELECT id,`name`
    FROM common_class
    ) b ON a.specialty_class_id=b.id
    GROUP BY class_id,specialty_class_id
    EOD;


    public static $str38=<<<EOD
    SELECT `name` `text`,`name` `value`,id
    FROM department
    WHERE id<=11
    EOD;


    public static $str34=<<<EOD
    SELECT `name` `text`,`name` `value`,id,department_id
    FROM department_specialty
    WHERE department_id<=11 AND `name`!='院党委办公室' AND `name`!='院团委办公室'
    EOD;

    public static $str35=<<<EOD
    SELECT *,b.sid `key`
    FROM department a RIGHT JOIN (
    SELECT `name` `text`,`name` `value`,id sid,department_id
    FROM department_specialty
    WHERE department_id<=11 AND `name`!='院党委办公室' AND `name`!='院团委办公室'
    )b ON a.id=b.department_id
    WHERE id<=11
    EOD;


    public static $str41=<<<EOD
    SELECT *,id `key`
    FROM student_class 
    WHERE department_specialty_id=?
    EOD;


    public static $str42=<<<EOD
    SELECT *,a.id `key`
    FROM student_class_day  a LEFT JOIN (
    SELECT id,`name`
    FROM specialty_class
    UNION
    SELECT id,`name`
    FROM select_class
    UNION
    SELECT id,`name`
    FROM common_class
    ) b ON a.specialty_class_id=b.id
    WHERE class_id=? AND b.name IS NOT NULL  AND a.nd=?
    GROUP BY class_id,specialty_class_id
    EOD;

    public static $str43=<<<EOD
    SELECT *,a.id `key`,a.student_id sssid
    FROM student a LEFT JOIN  (
    SELECT *
    FROM student_grade
    WHERE specialty_class_id=? AND semester=?
    ) b ON a.student_id=b.student_id LEFT JOIN (
    SELECT student_name,student_id ssid
    FROM student_info
    )c ON a.student_id=c.ssid
    WHERE class_grade_id=? 
    EOD;


    public static $str44=<<<EOD
    SELECT *,a.student_id ssid,a.iid `key`
    FROM (
    SELECT c.name,a.student_id,a.select_class_info_id,a.student_class,c.id select_id,a.nd a_nd,a.id iid
    FROM select_class_student a LEFT JOIN     select_class_info  b ON a.select_class_info_id=b.id LEFT JOIN 
    select_class c ON b.select_class_id=c.id
    ) a LEFT JOIN (
    SELECT student_name,student_id
    FROM student_info
    )b ON a.student_id=b.student_id  LEFT JOIN student_grade c ON a.student_id=c.student_id  AND a.select_id=c.specialty_class_id
    WHERE a.student_class=? AND a.a_nd=?
    EOD;







  




        public function index(){
            return 456;
        }

}