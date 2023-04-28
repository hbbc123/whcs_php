<?php

declare (strict_types = 1);

namespace app\index\controller;

class Sys
{   //搜索教职工信息
    public static     $str=<<<EOD
    SELECT a.teacher_name 'name',c.name department,(CASE d.name WHEN d.name IS  NULL THEN d.name
    ELSE  '无'
    END )AS room
,a.teacher_id 'key',e.politics_post_name politics_post,f.name admin_post,
(CASE a.state WHEN 1  THEN '在职'
 WHEN 2  THEN '离职'
 WHEN 3  THEN '退休'
 WHEN 4  THEN '请假'
    ELSE  '无'
    END )AS state,
    a.sex,a.site,a.iphone,a.entry_time,a.age,a.card

FROM (
SELECT f.teacher_name,f.teacher_id,f.card,f.sex,f.site,f.iphone,f.entry_time,f.state,f.age
FROM teacher e LEFT  JOIN(  
SELECT *
FROM teacher_info
) f ON  e.teacher_id=f.teacher_id
) a  LEFT JOIN (
SELECT b.`name`,a.teacher_id
FROM teacher a LEFT JOIN(
SELECT id,`name`
FROM department
) b ON  
a.department_id=b.id

)c  ON a.teacher_id=c.teacher_id LEFT  JOIN (
SELECT c.teacher_id ,d.name
FROM teacher c  LEFT JOIN(
SELECT id,`name`
FROM department_specialty
) d ON c.specialty_id=d.id

)d ON a.teacher_id=d.teacher_id  LEFT JOIN (
SELECT b.politics_post_name,a.teacher_id
FROM politics_info a LEFT JOIN (
SELECT politics_post_name,id
FROM politics_post
) b ON a.politics_post=b.id
)e ON a.teacher_id=e.teacher_id LEFT JOIN (
SELECT teacher_id,b.name
FROM post_info a JOIN(
SELECT id,`name`
FROM post
)b ON a.post_id=b.id

)f ON a.teacher_id=f.teacher_id

EOD;

//返回部门及科室
public static $str1=<<<DOE
SELECT a.name bname,a.id bid,b.name zname,b.department_id zbid,b.id zid
FROM department a JOIN (
SELECT department_id,`name`,id
FROM department_specialty
) b ON a.id=b.department_id
DOE;


//返回学生信息
public static $edu_student=<<<DOE
SELECT a.student_id ,b.name department,b.id department_id,c.name specialty_name,c.id specialty_id,d.num class
,e.student_name,a.student_id `key`,f.dorm_num_id,f.dorm_id
FROM student a LEFT JOIN (
	SELECT *
	FROM department
) b ON a.department_id=b.id LEFT JOIN (
SELECT *
FROM department_specialty
)c ON a.specialty_id=c.id LEFT  JOIN (
SELECT id,num
FROM student_class
)d ON a.class_grade_id=d.id  LEFT JOIN (
SELECT student_id,student_name
FROM student_info
) e ON a.student_id=e.student_id LEFT JOIN (
SELECT *
FROM dorm_info
)f ON a.student_id =f.member_one_id OR 
a.student_id =f.member_two_id OR
a.student_id =f.member_three_id OR
a.student_id =f.member_four_id 
DOE;


// 搜索不重复的专业
public static $zyNot=<<<EOD
SELECT id `key`,`name` `text`,`name` `value`,department_id pid
        FROM department_specialty WHERE department_id<=11  AND `name`!='院团委办公室'
 AND `name`!='院党委办公室'        
         GROUP BY `name`
EOD;

//搜索专业重复
public static $zy=<<<EOD
SELECT id `key`,`name` `text`,`name` `value`,department_id pid
FROM department_specialty WHERE department_id<=11  AND `name`!='院团委办公室'
 AND `name`!='院党委办公室'   
EOD;



//批量修改班级查重
public static $chac=<<<EOD
SELECT b.student_id,b.department_id,b.specialty_id,b.department_name,b.specialty_name,b.class_id,b.class_num,a.student_name
FROM student_info a LEFT JOIN (
SELECT 
a.student_id,a.department_id,a.specialty_id,b.department_name,c.specialty_name,d.id class_id,d.num class_num
 FROM student a LEFT JOIN (
SELECT id department_id_b,`name` department_name
FROM department
) b ON a.department_id=b.department_id_b
LEFT JOIN (
SELECT id specialty_id_id,`name` specialty_name
FROM department_specialty
)c ON a.specialty_id=c.specialty_id_id
LEFT JOIN (
SELECT id,num
FROM student_class
)d ON a.class_grade_id=d.id
) b ON a.student_id=b.student_id
WHERE
EOD;

//查找学生的专业不包含科室
public static $student_zhuan=<<<EOD
SELECT *
FROM department_specialty
WHERE department_id<=11 AND `name`!='院党委办公室' AND `name`!='院团委办公室'
EOD;


public static $clas_m=<<<EOD
SELECT 
a.key , a.class_id,a.department_id,a.department_name,a.specialty_id,a.specialty_name,a.pid,a.class_num,a.nj,b.accomplish
FROM (SELECT a.id `key` ,a.id class_id,b.id department_id,b.name department_name,c.id specialty_id, c.name specialty_name,c.department_id pid,a.num class_num,a.
student_class_num nj
FROM student_class a JOIN (
SELECT *
FROM department
) b ON a.department_id=b.id JOIN(
SELECT *
FROM department_specialty
) c ON a.department_specialty_id=c.id

) a LEFT JOIN (


SELECT a.department_specialty_id,b.name kname,a.class_id,a.nd,a.specialty_class_id,CASE  WHEN COUNT(*)<=1 THEN '未完成'
ELSE  CONCAT(COUNT(*),'节课')

END AS accomplish
FROM student_class_day a LEFT JOIN (
SELECT *
FROM specialty_class
) b ON a.specialty_class_id=b.id
WHERE a.nd=? AND specialty_class_id IS NOT NULL
GROUP BY a.class_id

) b ON a.class_id=b.class_id

GROUP BY a.class_id

EOD;


//查看专业课 可以安排的讲师
public static $teacher_add=<<<EOD
SELECT a.teacher_id `key`,c.teacher_name `value`,c.teacher_name `label`
FROM teacher a LEFT JOIN (
SELECT *
FROM post_info
)b ON a.teacher_id=b.teacher_id LEFT JOIN (
SELECT *
FROM teacher_info
)c ON a.teacher_id=c.teacher_id
WHERE  a.department_id=? AND b.post_id IN (10,12,13)
EOD;

public static $csclass=<<<EOD
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
EOD;

public static $zrove=<<<EOD
SELECT *
            FROM student_class_day
            WHERE specialty_class_id=? AND nd=? AND class_id=?
EOD;

public static $czhebkeche=<<<EOD
SELECT a.id,a.department_id,b.department_specialty_id,a.teacher_id,a.specialty_class_id,
a.classroom,a.week,a.class_time,a.semester,a.class_id,a.nd,a.start_time,a.end_time,b.name,c.teacher_name
FROM student_class_day  a LEFT JOIN (
SELECT *
FROM common_class
UNION
SELECT *
FROM specialty_class
) b ON a.specialty_class_id=b.id  LEFT JOIN(
SELECT teacher_id,teacher_name
FROM teacher_info

) c ON a.teacher_id=c.teacher_id
EOD;


public static $keykec=<<<EOD
SELECT a.name `key`,a.name label,a.name `value`,a.id,department_specialty_id pid
        FROM (
        SELECT *
        FROM specialty_class UNION 
        SELECT *
        FROM common_class
        )a
EOD;


public static $seninfo=<<<EOD
SELECT a.name `key`,a.name label,a.name `value`,a.id,department_specialty_id pid
        FROM (
        SELECT *
        FROM specialty_class UNION 
        SELECT *
        FROM common_class
        )a
EOD;


public static $Moneyapply=<<<EOD
SELECT *,a.id `key`
FROM (
SELECT *
FROM department_money_info 
WHERE applicant_id=?
) a LEFT JOIN (
SELECT teacher_name applicant_name,teacher_id applicant_id
FROM teacher_info
) b ON a.applicant_id=b.applicant_id  LEFT JOIN (
SELECT teacher_name moeny_admin_name,teacher_id moeny_admin
FROM teacher_info
) c ON a.moeny_admin=c.moeny_admin
ORDER BY a.id DESC
EOD;


public static $money_look=<<<EOD
SELECT *,a.id `key`
FROM (
SELECT *
FROM department_money_info 
WHERE id=?
) a LEFT JOIN (
SELECT teacher_name applicant_name,teacher_id applicant_id
FROM teacher_info
) b ON a.applicant_id=b.applicant_id  LEFT JOIN (
SELECT teacher_name moeny_admin_name,teacher_id moeny_admin
FROM teacher_info
) c ON a.moeny_admin=c.moeny_admin
ORDER BY a.id DESC
EOD;


public static $Moneyall=<<<EOD
SELECT *,a.id `key`
FROM (
SELECT *
FROM department_money_info 
WHERE nd=?
) a LEFT JOIN (
SELECT teacher_name applicant_name,teacher_id applicant_id
FROM teacher_info
) b ON a.applicant_id=b.applicant_id  LEFT JOIN (
SELECT teacher_name moeny_admin_name,teacher_id moeny_admin
FROM teacher_info
) c ON a.moeny_admin=c.moeny_admin LEFT JOIN (
SELECT a.department_id pid,teacher_id,b.*
FROM teacher  a LEFT JOIN (
SELECT *
FROM department_money
WHERE nd=?
) b  ON a.department_id=b.department_id
)d  ON a.applicant_id=d.teacher_id  LEFT JOIN  department e ON d.pid=e.id
ORDER BY a.id DESC
EOD;


public static $getdepartment=<<<EOD
SELECT a.department_id,b.root
FROM (
SELECT *
FROM teacher
WHERE teacher_id=?
) a LEFT JOIN (
SELECT *
FROM (
SELECT teacher_id,post_id
FROM post_info
) a LEFT JOIN post b ON a.post_id=b.id
)b  ON a.teacher_id=b.teacher_id
EOD;

public static $jisdf=<<<EOD
SELECT *
FROM department_money
WHERE department_id=? AND nd=?
EOD;

public static $Moneyset=<<<EOD
SELECT *,RAND() `key`
FROM department_money a RIGHT JOIN department b ON a.department_id=b.id LEFT JOIN (
SELECT id department_root_id,`name` department_root_name
FROM post 
)c ON a.department_root=c.department_root_id LEFT JOIN (
SELECT id department_root_big_id,`name` department_root_big_id_name
FROM post 
)d ON a.department_root_big=d.department_root_big_id
ORDER BY a.nd DESC
EOD;


public static $Moneyset_two=<<<EOD
SELECT id value,CONCAT(`name`,'及以上') AS `label`,RAND() `key`
FROM post
EOD;


public static $leave=<<<EOD
SELECT *,a.id `key`
FROM (
SELECT *
FROM leave_second
WHERE student_id=?
)a LEFT JOIN (
SELECT student_name,student_id
FROM student_info
)b ON a.student_id=b.student_id  LEFT JOIN (
SELECT teacher_name user_name,teacher_id user_id
FROM teacher_info
UNION
SELECT student_name user_name,student_id user_id
FROM student_info
)c ON a.leave_admin=user_id
EOD;


public static $leavelook=<<<EOD
SELECT *
FROM leave_second
WHERE id=?
EOD;

public static $leave_add_look_class=<<<EOD
SELECT *
FROM `leave` a LEFT JOIN (
SELECT id root_id,`name`,root
FROM post
) b ON a.leave_root=b.root_id
ORDER BY `day` ASC ,root_id ASC
EOD;



public static $leave_add_look_student=<<<EOD
SELECT *
FROM student
WHERE student_id=?
EOD;


public static $leave_add_look_son=<<<EOD
SELECT b.teacher_id,b.teacher_name
FROM (
SELECT *
FROM (
SELECT *
FROM teacher
WHERE department_id=?) a LEFT JOIN (
SELECT teacher_id teacher_id_id,post_id
FROM post_info
) b ON a.teacher_id=b.teacher_id_id 
WHERE post_id=? 
) a LEFT JOIN (
SELECT teacher_name,teacher_id
FROM  teacher_info
)b ON a.teacher_id=b.teacher_id
EOD;


public static $leave_add_look_son_class=<<<EOD
SELECT *
FROM (
SELECT *
FROM student_class_post
WHERE student_class=? AND student_post_id=1
) a LEFT JOIN (
SELECT student_name,student_id
FROM student_info
) b  ON a.student_id=b.student_id
EOD;



public static $instructor_id=<<<EOD
SELECT *
FROM student_class a LEFT JOIN (
SELECT teacher_name,teacher_id
FROM teacher_info
)b ON a.instructor_id=b.teacher_id
WHERE id=?
EOD;


public static $leaverootindex=<<<EOD
SELECT *,a.id `key`
FROM leave_second a  LEFT JOIN (
SELECT *
FROM student a LEFT JOIN (
SELECT student_name,student_id student_id_id
FROM student_info
) b ON a.student_id=b.student_id_id  LEFT JOIN (
SELECT a.num,a.student_class_num,a.id class_id ,b.*,c.*
FROM student_class a LEFT JOIN (
SELECT id sid,`name` sname
FROM department_specialty
) b ON a.department_specialty_id=b.sid  LEFT JOIN (
SELECT id pid,`name` pname
FROM department
)c ON a.department_id=c.pid
)c ON a.class_grade_id=c.class_id
)b ON a.student_id=b.student_id
WHERE leave_admin=?
EOD;


public static $Leaveset=<<<EOD
SELECT *,a.id `key`
FROM `leave` a LEFT JOIN (
SELECT id root_id,`name`,root
FROM post
) b ON a.leave_root=b.root_id
ORDER BY `day` ASC ,root_id ASC
EOD;


public static $Leaveset_post=<<<EOD
SELECT id `value`,`name` `label`
FROM post
EOD;


public static $Leaveset_post_school=<<<EOD
SELECT *
FROM (
SELECT *
FROM post_info  
WHERE post_id=1
) a LEFT JOIN (
SELECT teacher_name,teacher_id
FROM teacher_info
) b  ON a.teacher_id=b.teacher_id
EOD;


public static $get_select_class=<<<EOD
SELECT *,a.id `key`
FROM select_class_student a LEFT JOIN
select_class_info b 
ON a.select_class_info_id=b.id AND a.nd=b.nd LEFT JOIN
select_class c ON b.select_class_id=c.id LEFT JOIN (
SELECT teacher_name,teacher_id
FROM teacher_info
) e ON b.teacher_id=e.teacher_id
WHERE a.student_id=?
ORDER BY a.nd DESC
EOD;


public static $get_select_class_class=<<<EOD
SELECT *,a.id `key`
FROM select_class_info a LEFT JOIN select_class b 
ON a.select_class_id=b.id  LEFT JOIN (
SELECT teacher_name,teacher_id
FROM teacher_info
) c ON a.teacher_id=c.teacher_id
WHERE  a.nd=?
EOD;



public static $add_select_class_student=<<<EOD
SELECT `week`,`start_time`,`end_time`,`class_time`
FROM student_class_day a 
WHERE class_id IN (
SELECT class_grade_id
FROM student
WHERE student_id=?
) AND teacher_id IS NOT NULL 
AND specialty_class_id IS NOT NULL
AND classroom IS NOT NULL
AND start_time IS NOT NULL
AND end_time  IS NOT NULL
UNION
SELECT b.week,b.sen_time `start_time`,b.end_time `end_time`,b.section class_time
FROM (
SELECT *
FROM select_class_student
WHERE nd=? AND student_id=?) a  LEFT JOIN
select_class_info b ON a.select_class_info_id=b.id AND a.nd=b.nd
EOD;


public static $student_grade=<<<EOD
SELECT *,a.id `key`
FROM student_grade a LEFT JOIN (
SELECT id,`name`
FROM specialty_class
UNION
SELECT id,`name`
FROM common_class
UNION
SELECT id,`name`
FROM select_class
)b ON a.specialty_class_id=b.id
WHERE student_id=?
ORDER BY semester DESC
EOD;


public static $Management_data=<<<EOD
SELECT *,SUBSTRING(a.student_id,1,4)AS nj,a.student_id `key`
FROM student a LEFT JOIN student_info b ON a.student_id=b.student_id LEFT JOIN
department c ON a.department_id=c.id  LEFT JOIN (
SELECT `name` sname,id sid
FROM department_specialty
) d ON a.specialty_id=d.sid
EOD;

public static $Management_department=<<<EOD
SELECT `name` `text`, `name` `value`,id `key`
FROM department
WHERE id<=11
EOD;

public static $Management_department_specialty=<<<EOD
SELECT `name` `text`, `name` `value`,department_id pid,id sid
FROM department_specialty
WHERE department_id<=11 AND `name`!='院团委办公室' AND `name`!='院党委办公室'
EOD;


public static $Graduate=<<<EOD
SELECT *,  IF(
b.xuefen>=c.graduate,TRUE,FALSE
) AS `biye_tf`,a.student_id `key`
FROM (
SELECT *
FROM (
SELECT *,SUBSTRING(student_id,1,4) AS nd
FROM student
) a 
WHERE nd=?
)a LEFT JOIN (
SELECT a.student_id,
SUM(IF(one_grade>60 OR two_grade >=60,grade,NULL)) AS xuefen
FROM student_grade a LEFT JOIN (
SELECT id,`name`,grade
FROM specialty_class
UNION
SELECT id,`name`,grade
FROM select_class
UNION
SELECT id,`name`,grade
FROM common_class
)b ON a.specialty_class_id=b.id
GROUP BY a.student_id
)b ON a.student_id=b.student_id LEFT JOIN department_specialty c
ON a.specialty_id=c.id LEFT JOIN (
SELECT id pid ,`name` pname
FROM department
)d ON a.department_id=d.pid  LEFT JOIN (
SELECT id class_id,CONCAT(num,'班') AS num
FROM student_class
)e ON a.class_grade_id=e.class_id LEFT JOIN (
SELECT student_id student_id_id,student_name student_name
FROM student_info
)f ON a.student_id=f.student_id_id
EOD;


public static $up_Graduate=<<<EOD
SELECT *
FROM dorm_info
WHERE member_one_id=? OR
member_two_id=? OR
member_three_id=? OR
member_four_id=?
EOD;


public static $get_class_student=<<<EOD
SELECT *,COUNT(*) AS zong,a.id `key`
FROM student_class a LEFT JOIN (
SELECT id pid,`name` pname
FROM department
)b ON a.department_id=pid  LEFT JOIN (
SELECT id sid ,`name` sname
FROM department_specialty
)c ON a.department_specialty_id=c.sid  RIGHT JOIN (
SELECT *
FROM student
)e ON a.id=e.class_grade_id
GROUP BY a.id
EOD;

public static $Beforestudent=<<<EOD
SELECT *,a.student_id  `key`
FROM (
SELECT *,SUBSTRING(student_id,1,4) AS `year`
FROM student_old  a LEFT JOIN (
SELECT id pid,`name` pname
FROM department
)b ON a.department_id=pid  LEFT JOIN (
SELECT id sid ,`name` sname
FROM department_specialty
)c ON a.specialty_id=c.sid
)a 
ORDER BY `year` DESC
EOD;


public static $Beforeteacher=<<<EOD
SELECT *,SUBSTRING(a.teacher_id,1,4) rzhi,a.teacher_id  `key`
FROM teacher_old a  LEFT JOIN (
SELECT id pid, `name` pname
FROM department
) b  ON a.department_id=b.pid
ORDER BY end_time DESC
EOD;

public static $member=<<<EOD
SELECT *,SUBSTR(a.student_id,1,4) AS nj,a.student_id `key`
FROM student a LEFT JOIN (
SELECT student_id,student_name,student_politics
FROM student_info
)b ON a.student_id=b.student_id
LEFT JOIN (
SELECT id pid,`name` pname
FROM department
)c ON a.department_id=c.pid LEFT JOIN (
SELECT id sid,`name` sname
FROM department_specialty
)d ON a.specialty_id=d.sid  LEFT JOIN politics e
ON b.student_politics=e.id
EOD;

public static $member_select=<<<EOD
SELECT id `value`,politics_name  `label`
FROM politics
WHERE politics_name!='党员' AND politics_name!='积极分子'
EOD;

public static $Course=<<<EOD
SELECT a.id,a.name,a.time,a.grade,'专业课' AS `type`,b.sname,c.pname,RAND() `key`
FROM specialty_class a LEFT JOIN (
SELECT id sid,`name` sname,department_id
FROM department_specialty
) b
ON a.department_specialty_id=b.sid  LEFT JOIN (
SELECT id pid,`name` pname
FROM department
) c
ON b.department_id=c.pid
UNION
SELECT id,`name`,`time`,grade,'公共课' AS `type`,' ' AS sname,' ' AS pname,RAND() `key`
FROM common_class
UNION
SELECT id,`name`,`time`,grade,'选修课' AS `type`,' ' AS sname,' ' AS pname,RAND() `key`
FROM select_class

EOD;



public static $Systemroot_department=<<<EOD
SELECT *,id `key`
FROM department
EOD;

public static $Post_z=<<<EOD
SELECT *
FROM (
SELECT *
FROM teacher_root_info 
GROUP BY department_id,post_id
)a LEFT JOIN department b ON a.department_id=b.id 
LEFT JOIN post c ON a.post_id=c.id
WHERE a.department_id=?
EOD;

public static $Systemroot_info=<<<EOD
SELECT *,id `key`
FROM teacher_root
EOD;

public static $Systemroot_info_data=<<<EOD
SELECT *
FROM  teacher_root_info a LEFT JOIN teacher_root b ON a.root_id=b.id
WHERE department_id=? AND post_id=?
EOD;

public static $get_Systemroot_post=<<<EOD
SELECT `id` `value`,`name` `label`,id `key`
FROM post
EOD;

public static $get_post_Systemroot_all=<<<EOD
SELECT *
FROM teacher_root_info a LEFT JOIN (
SELECT *
FROM teacher_root
)b ON a.root_id=b.id
WHERE department_id=? AND post_id=?
GROUP BY b.father
EOD;

public static $get_post_Systemroot_all_info=<<<EOD
SELECT a.teacher_id,a.department_id,b.post_id
FROM  teacher a LEFT JOIN post_info  b 
ON a.teacher_id=b.teacher_id
WHERE a.teacher_id=?
EOD;


public static $get_post_Systemroot_all_dan=<<<EOD
SELECT *
FROM teacher_root_info a LEFT JOIN (
SELECT *
FROM teacher_root
)b ON a.root_id=b.id
WHERE department_id=? AND post_id=? AND father='false' AND b.key!='1'
EOD;



public static $get_post_student=<<<EOD
SELECT *
FROM studnet_root_info a LEFT JOIN teacher_root b
ON a.root_id=b.id
GROUP BY b.father
EOD;

public static $get_post_student_son=<<<EOD
SELECT *
FROM studnet_root_info a LEFT JOIN teacher_root b
ON a.root_id=b.id
WHERE b.father=?
EOD;

public static $son_p=<<<EOD
SELECT *
FROM studnet_root_info a LEFT JOIN teacher_root b
ON a.root_id=b.id
WHERE b.father='false'
EOD;



public static $get_post_Systemroot_all_son=<<<EOD
SELECT *
FROM teacher_root_info a LEFT JOIN (
SELECT *
FROM teacher_root
)b ON a.root_id=b.id
WHERE department_id=? AND post_id=? AND father=?
EOD;

public static $get_post_Systemroot_all_bsd=<<<EOD
SELECT remark title,id `value`
FROM teacher_root
EOD;


public static $Systemroot_post_student=<<<EOD
SELECT *,b.id `key`
FROM studnet_root_info a LEFT JOIN teacher_root b ON a.root_id=b.id
EOD;

public static $Systemroot_post_student_root_ALL=<<<EOD
SELECT *
FROM teacher_root
EOD;

public static $get_root=<<<EOD
SELECT *
FROM switch
EOD;


public static $get_root_name=<<<EOD
SELECT *,RAND() AS `key`
FROM switch_name
UNION
SELECT *,RAND() AS `key`
FROM switch
EOD;


public static $overview_department=<<<EOD
SELECT b.name `name`,COUNT(*) AS `value`
FROM teacher a LEFT JOIN department b
ON a.department_id=b.id
GROUP BY a.department_id
EOD;


public static $overview_department_zong=<<<EOD
SELECT COUNT(*) AS `zong`
FROM teacher a LEFT JOIN department b
ON a.department_id=b.id
EOD;


public static $overview_sex=<<<EOD
SELECT COUNT(*) AS zong
FROM teacher_info
WHERE sex=?
EOD;

public static $overview_nian=<<<EOD
SELECT nian `name`,COUNT(*) AS `value`
FROM (
SELECT CASE  WHEN DATEDIFF(CURDATE(),entry_time)/365<=5 THEN '1-5年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=10 THEN '6-10年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=15 THEN '11-15年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=20 THEN '16-15年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=25 THEN '21-25年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=30 THEN '26-30年'
WHEN DATEDIFF(CURDATE(),entry_time)/365<=35 THEN '31-35年'
END AS nian
FROM teacher_info
)a
GROUP BY nian
EOD;










public function index()//人事处教职工管理
{
    
    // $res=Db::query(Sql::$str);
    $res=null;
    return json($res);
}
}
