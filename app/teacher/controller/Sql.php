<?php
namespace app\teacher\controller;
class Sql
{
    public static  $str=<<<EOD
    SELECT a.teacher_name,c.name ,d.name ,a.teacher_id,e.politics_post_name
        FROM (
            SELECT f.teacher_name,f.teacher_id
            FROM teacher e LEFT  JOIN(
            SELECT teacher_id,teacher_name
            FROM teacher_info
            ) f ON  e.teacher_id=f.teacher_id
        ) a  LEFT JOIN (
            SELECT b.`name`,a.teacher_id
            FROM teacher a LEFT JOIN(
            SELECT id,`name`
            FROM department
            ) b ON  
            a.department_id=b.id

        )c  ON a.teacher_id=c.teacher_id LEFT JOIN (
                SELECT c.teacher_id ,d.name
                FROM teacher c LEFT JOIN(
                SELECT id,`name`
                FROM department_specialty
                ) d ON c.specialty_id=d.id 

        )d ON a.teacher_id=d.teacher_id LEFT JOIN (
                SELECT b.politics_post_name,a.teacher_id
                FROM politics_info a LEFT JOIN (
                SELECT politics_post_name,id
                FROM politics_post
                ) b ON a.politics_post=b.id
        )e ON a.teacher_id=e.teacher_id
        WHERE d.name='院团委办公室' AND e.politics_post_name  IS NULL
    EOD; 

    public static $str1=<<<EOD
    SELECT *,a.id `key`
    FROM teacher_sanction_info a LEFT JOIN (
            SELECT teacher_name beiname,teacher_id beiid
            FROM teacher_info
            )b ON a.teacher_id=b.beiid 
                LEFT JOIN (
            SELECT b.name pname,a.teacher_id beid,c.post_name
            FROM teacher a LEFT JOIN department b ON a.department_id=b.id
            LEFT JOIN(
                    SELECT a.teacher_id beeid,a.post_id,b.post_name
                FROM post_info a LEFT JOIN (
                            SELECT id post_iid,`name` post_name
                            FROM post
                        )b ON a.post_id=b.post_iid
                    ) c ON a.teacher_id=c.beeid
                
        )c ON a.teacher_id=c.beid LEFT JOIN (
            SELECT teacher_name send_name,teacher_id send_idid
            FROM teacher_info
        )d ON a.send_id=d.send_idid  LEFT JOIN (
            SELECT teacher_name admin_name,teacher_id admin_id
            FROM teacher_info
        )e ON a.admin=e.admin_id LEFT JOIN (
            SELECT  id san_id,sciplinary_name
            FROM disciplinary_sanction
        )f ON a.disciplinary_sanction_id=f.san_id LEFT JOIN (
            SELECT id class_id,clan_name
            FROM  clan_sanction
        )g ON a.clan_sanction_id=g.class_id
    EOD;

    public static $str2=<<<EOD
    SELECT *
    FROM teacher_sanction_info a LEFT JOIN (
            SELECT teacher_name beiname,teacher_id beiid
            FROM teacher_info
            )b ON a.teacher_id=b.beiid 
                LEFT JOIN (
            SELECT b.name pname,a.teacher_id beid,c.post_name,b.id pidss
            FROM teacher a LEFT JOIN department b ON a.department_id=b.id
            LEFT JOIN(
                    SELECT a.teacher_id beeid,a.post_id,b.post_name
                FROM post_info a LEFT JOIN (
                            SELECT id post_iid,`name` post_name
                            FROM post
                        )b ON a.post_id=b.post_iid
                    ) c ON a.teacher_id=c.beeid
                
        )c ON a.teacher_id=c.beid LEFT JOIN (
            SELECT teacher_name send_name,teacher_id send_idid,sex,card,site,iphone,entry_time,state,age
            FROM teacher_info
        )d ON a.send_id=d.send_idid  LEFT JOIN (
            SELECT teacher_name admin_name,teacher_id admin_id
            FROM teacher_info
        )e ON a.admin=e.admin_id LEFT JOIN (
            SELECT  id san_id,sciplinary_name,disciplinary_sanction_root
            FROM disciplinary_sanction
        )f ON a.disciplinary_sanction_id=f.san_id LEFT JOIN (
            SELECT id class_id,clan_name,clan_root
            FROM  clan_sanction
        )g ON a.clan_sanction_id=g.class_id  LEFT JOIN (
                SELECT  a.teacher_id beiiidd,b.politics_name,c.politics_post_name
                FROM politics_info a LEFT JOIN (
                    SELECT id poli_id,politics_name
                    FROM politics
                )b ON a.politics_id=b.poli_id LEFT JOIN (
                    SELECT id politics_post_id,politics_post_name
                    FROM politics_post
                )c ON a.politics_post=c.politics_post_id
        )h ON a.teacher_id=h.beiiidd
        WHERE a.id=?
    EOD;

    public static $str3=<<<EOD
    SELECT id `value`,sciplinary_name label FROM disciplinary_sanction WHERE ts=0
    EOD;

    public static $str4=<<<EOD
    SELECT id `value`,clan_name label FROM clan_sanction
    EOD;

    public static $str5=<<<EOD
    SELECT id `value`,`name` label FROM department
    EOD;

    public static $str6=<<<EOD
    SELECT a.teacher_id `value`,a.teacher_id `key`,b.teacher_name label
    FROM teacher a LEFT JOIN (
        SELECT *
        FROM teacher_info
    )b ON a.teacher_id=b.teacher_id
    WHERE a.department_id=?
    EOD;

    public static $str7=<<<EOD
    SELECT *
    FROM politics_info a LEFT JOIN politics  b
    ON a.politics_id=b.id
    WHERE teacher_id=?
    EOD;

    
    public static $str8=<<<EOD
    SELECT *
    FROM politics_info 
    WHERE teacher_id=?
    EOD; 



    public static $str9=<<<EOD
    SELECT `name` label,id `key`,id `value`
    FROM department
    EOD; 
    public static $str10=<<<EOD
    SELECT id `key`,`name` label,id `value`,department_id pid
    FROM department_specialty
    EOD; 
    public static $str11=<<<EOD
    SELECT id `key`,`name` label,id `value`
    FROM post
    EOD; 
    public static $str12=<<<EOD
    SELECT id `key`,`politics_name` label,id `value`
    FROM politics
    EOD; 
    public static $str13=<<<EOD
    SELECT id `key`,`politics_post_name` label,id `value`
    FROM politics_post
    EOD; 


    public static $str14=<<<EOD
    SELECT student_name `name`,'学生' class,b.politics_name ,'' politics_post_name,a.student_id `key`,c.name department_name
    FROM student_info a LEFT JOIN politics b ON a.student_politics=b.id LEFT JOIN (
    SELECT b.name,a.student_id
    FROM student a LEFT JOIN  department b ON a.department_id=b.id
    ) c ON a.student_id=c.student_id
    WHERE  student_politics IN (1,4)
    UNION
    SELECT a.teacher_name `name`,'教职工' class,c.politics_name,d.politics_post_name,a.teacher_id `key`,e.name department_name
    FROM teacher_info a LEFT JOIN politics_info b ON a.teacher_id=b.teacher_id LEFT JOIN 
    politics c ON b.politics_id=c.id LEFT JOIN politics_post d ON b.politics_post=d.id  LEFT JOIN (
    SELECT b.name,a.teacher_id
    FROM teacher a LEFT JOIN department b ON a.department_id=b.id
    )e ON a.teacher_id=e.teacher_id
    WHERE  b.politics_id IN (1,4)
    EOD; 

    public static $str15=<<<EOD
    SELECT *
    FROM teacher a LEFT JOIN department b ON a.department_id= b.id
    LEFT JOIN  (
    SELECT department_id,`name` son_name,id son_id
    FROM department_specialty
    )c ON a.specialty_id=c.son_id
    LEFT JOIN teacher_info d ON a.teacher_id=d.teacher_id
    WHERE a.teacher_id=?
    EOD;


    public static $str16=<<<EOD
    SELECT *
    FROM student a LEFT JOIN department b ON a.department_id= b.id
    LEFT JOIN  (
    SELECT department_id,`name` son_name,id son_id
    FROM department_specialty
    )c ON a.specialty_id=c.son_id
    LEFT JOIN student_info d ON a.student_id=d.student_id
    WHERE a.student_id=?
    EOD;

    public static $str17=<<<EOD
    SELECT `name` `text`,`name` `value`
    FROM department
    EOD;

    public static $str18=<<<EOD
    SELECT *,CONCAT(a.num,'班') class_num
    FROM student_class a  LEFT JOIN (
    SELECT id pid,`name` pname
    FROM department
    )b  ON a.department_id=pid  LEFT JOIN (
    SELECT id sid,`name` sname
    FROM department_specialty
    )c  ON a.department_specialty_id=c.sid
    WHERE instructor_id=? OR director_id=?
    EOD;

    public static $str19=<<<EOD
    SELECT *
    FROM student_class_post a LEFT JOIN (
    SELECT student_id,student_name
    FROM student_info
    )b ON a.student_id=b.student_id
    WHERE student_class=? AND student_post_id=?
    EOD;

    public static $str21=<<<EOD
    SELECT *,a.id `key`
    FROM student a  JOIN (
    SELECT *,CONCAT(a.num,'班') class_num
    FROM student_class a  LEFT JOIN (
    SELECT id pid,`name` pname
    FROM department
    )b  ON a.department_id=pid  LEFT JOIN (
    SELECT id sid,`name` sname
    FROM department_specialty
    )c  ON a.department_specialty_id=c.sid
    WHERE instructor_id='2004T1120' OR director_id='2004T1120'
    ) b ON a.class_grade_id=b.id  LEFT JOIN (
    SELECT student_id stid,student_name stname,student_politics
    FROM student_info
    )c   ON a.student_id=c.stid  LEFT JOIN (
    SELECT *
    FROM student_class_post a LEFT JOIN  (
    SELECT id post_id,student_post_name
    FROM student_post
    )b ON  a.student_post_id=b.post_id
    WHERE student_class=?
    )d  ON a.student_id=d.student_id
    WHERE b.id=?
    EOD;


    public static $str22=<<<EOD
    SELECT student_post_name `value`,student_post_name `label`,id `key`
    FROM student_post
    EOD;

    public static $str23=<<<EOD
    SELECT *
    FROM student_class_post
    WHERE student_class=? AND student_id=?
    EOD;


    public static $str24=<<<EOD
    SELECT *
    FROM student_class a LEFT JOIN (
    SELECT teacher_id instructor_id,teacher_name instructor_name
    FROM teacher_info 
    ) b ON a.instructor_id=b.instructor_id  LEFT JOIN (
    SELECT teacher_id director_id,teacher_name director_name
    FROM teacher_info 
    ) c ON a.director_id=c.director_id  LEFT JOIN (
    SELECT id pid,`name` pname
    FROM department
    ) d ON a.department_id=d.pid LEFT JOIN (
    SELECT id sid,`name` sname
    FROM department_specialty
    )e ON a.department_specialty_id=e.sid
    WHERE a.instructor_id=? OR a.director_id=?
    EOD;


    public static $str25=<<<EOD
    SELECT *
    FROM student_class_day a LEFT JOIN(
    SELECT *
    FROM (
    SELECT *
    FROM specialty_class UNION 
    SELECT *
    FROM common_class
    )a  
    ) b ON a.specialty_class_id=b.id
    LEFT JOIN (
    SELECT teacher_name,teacher_id rid
    FROM teacher_info
    ) c ON a.teacher_id=c.rid
     WHERE nd=? AND class_id=? ORDER BY a.class_time ASC,a.week ASC
    EOD;

    public static $str26=<<<EOD
    SELECT *,a.id `key`
    FROM select_class_info a LEFT JOIN select_class b ON a.select_class_id=b.id
    LEFT JOIN (
    SELECT teacher_name,teacher_id
    FROM teacher_info
    ) c ON a.teacher_id=c.teacher_id
    WHERE a.nd=?
    EOD;


    public static $str27=<<<EOD
    SELECT `name` label,`name` `value`,id `key`
    FROM select_class
    EOD;

    public static $str28=<<<EOD
    SELECT `name` `label`,id `value`
    FROM department
    WHERE id<=11
    EOD;

    public static $str29=<<<EOD
    SELECT *,b.teacher_name `label`,a.teacher_id `value`
    FROM post_info a LEFT JOIN (
    SELECT teacher_name,teacher_id
    FROM teacher_info
    )b ON a.teacher_id=b.teacher_id  LEFT JOIN (
    SELECT *
    FROM teacher
    )c ON a.teacher_id=c.teacher_id 
    WHERE post_id IN (10,12,13)  AND c.department_id=?
    EOD;


    public static $str30=<<<EOD
    SELECT *
    FROM student_class_day
    WHERE teacher_id=? AND nd=?
    EOD;

    public static $str31=<<<EOD
    SELECT *
    FROM student_class_day
    WHERE classroom=?
    EOD;

    public static $str32=<<<EOD
    SELECT *,a.id `key`
    FROM teacher_sanction_info a LEFT JOIN (
            SELECT teacher_name beiname,teacher_id beiid
            FROM teacher_info
            )b ON a.teacher_id=b.beiid 
                LEFT JOIN (
            SELECT b.name pname,a.teacher_id beid,c.post_name
            FROM teacher a LEFT JOIN department b ON a.department_id=b.id
            LEFT JOIN(
                    SELECT a.teacher_id beeid,a.post_id,b.post_name
                FROM post_info a LEFT JOIN (
                            SELECT id post_iid,`name` post_name
                            FROM post
                        )b ON a.post_id=b.post_iid
                    ) c ON a.teacher_id=c.beeid
                
        )c ON a.teacher_id=c.beid LEFT JOIN (
            SELECT teacher_name send_name,teacher_id send_idid
            FROM teacher_info
        )d ON a.send_id=d.send_idid  LEFT JOIN (
            SELECT teacher_name admin_name,teacher_id admin_id
            FROM teacher_info
        )e ON a.admin=e.admin_id LEFT JOIN (
            SELECT  id san_id,sciplinary_name
            FROM disciplinary_sanction
        )f ON a.disciplinary_sanction_id=f.san_id LEFT JOIN (
            SELECT id class_id,clan_name
            FROM  clan_sanction
        )g ON a.clan_sanction_id=g.class_id
            WHERE a.teacher_id=?
    EOD;


    public static $str33=<<<EOD
    SELECT *,a.id `key`
    FROM (
    SELECT *
    FROM  student_class_day
    WHERE teacher_id=? AND nd=?) a LEFT JOIN (
    SELECT id pid,`name` pname
    FROM department
    ) b ON a.department_id=b.pid LEFT JOIN (
    SELECT id sid,`name` sname
    FROM department_specialty 
    )c ON a.department_specialty_id=c.sid LEFT JOIN (
    SELECT id ke_id,`name` ke_name
    FROM specialty_class 
    )d ON a.specialty_class_id=d.ke_id  LEFT JOIN (
    SELECT id class_id,num
    FROM student_class
    ) e ON a.class_id=e.class_id
    EOD;


    public static $str34=<<<EOD
    SELECT *,a.id `key`
    FROM (
    SELECT *
    FROM select_class_info 
    WHERE teacher_id=? AND nd=?
    )a LEFT JOIN select_class b  ON a.select_class_id=b.id
    EOD;







    public function index()
    {
        return '您好！这是一个[teacher]示例应用';
    }
}