# 该项目是使用ThinkPHP框架编写的校园后台管理系统接口



# 使用方法

##### 1.把whcs.sql导入数据库

##### 2.修改config文件夹下database.php 设置操作数据库为刚导入的数据库

##### 3.访问路径为  网址:端口/你的文件夹名/public/index.php/请求地址







# 获取教师党员

请求地址:/teacher/index/clen_politics

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
politics_post:[//党内职务
  {
    "key": 1,
    "label": "党委书记",
    "value": 1
  },
]
politics:[  //政治面貌
  {
    "key": 1,
    "label": "党员",
    "value": 1
  },
]
department:[//部门
    {
      "text": "学前教育学院",
      "value": "学前教育学院"
    }
]
data:[
    {
        "name": "蒲拓鸯",
        "class": "教职工",
        "politics_name": "党员",
        "politics_post_name": "党委副书记",
        "key": "1993T8468",  //ID
        "department_name": "旅游与酒店管理学院"
    }
]
```



# 获取教师处分(全部)

请求地址:/teacher/index/teacher_clen

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
data:[
{
    "id": 1,  //处分ID
    "teacher_id": "2019T3419",  //ID
    "info":  "PHA+PC9wPg0KPGltZyBzcmM9Imh0dHBzOi8vZ2ltZzIuYmFpZHUuY29tL2ltYWdlX3NlYXJjaC9zcmM9aHR0cCUzQSUyRiUyRmxtZy5qajIwLmNvbSUyRnVwJTJGYWxsaW1nJTJGMTExNCUyRjA0MjQyMTEzMzMxMiUyRjIxMDQyNDEzMzMxMi0xLTEyMDAuanBnJnJlZmVyPWh0dHAlM0ElMkYlMkZsbWcuamoyMC5jb20mYXBwPTIwMDImc2l6ZT1mOTk5OSwxMDAwMCZxPWE4MCZuPTAmZz0wbiZmbXQ9YXV0bz9zZWM9MTY3MTcxNDcwOSZ0PTMwYWIxMDU3ZGE1YWEyYjMzNmUyODliYmQ0MjJkZTc3IiBhbHQ9InVuZGVmaW5lZCIgc3R5bGU9ImhlaWdodDogYXV0bzt3aWR0aDogYXV0byIvPg0KPHA+c2RmPC9wPg0K",   // 处分详情
    "teacher_tf": 1,  //被处理人是否同同一  1:同意 0:待同意 -1:不接受
    "admin": "2019T3419",
    "admin_tf": 1,  //审核人是否同意 0待处理 1已处理
    "epilogue": null,
    "disciplinary_sanction_id": 7, //行政处分ID
    "clan_sanction_id": 1,  //党内处分ID
    "title": "哈哈哈",  //处分标题
    "send_id": "2019T3419",  
    "add_time": "2022-11-01", //处分添加时间
    "end_time": "2022-12-03", //处理结果时间
    "beiname": "饶育悦", //被处理人姓名
    "beiid": "2019T3419",//被处理人ID
    "pname": "党政办公室",
    "beid": "2019T3419",
    "post_name": "校长",  //
    "send_name": "饶育悦",
    "send_idid": "2019T3419",
    "admin_name": "饶育悦", //审核人名称
    "admin_id": "2019T3419",//审核人ID
    "san_id": 7,
    "sciplinary_name": "严重警告",//行政处分名称
    "class_id": 1,
    "clan_name": "警告",//党内处分名称
    "key": 1
}
]
```





# 获取处分详情(教师)

请求地址:/teacher/index/clen_politics

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明       |
| ------ | ---- | -------- | ---------- |
| ID     | int  | T        | 传入处分ID |

返回参数:

```
x:[  //行政处分类型
    {
      "value": 5,
      "label": "降职撤职"
    }
]
d:[//党内处分类型
    {
      "value": 3,
      "label": "撤销党内职务"
    }
]
data:[  //被处理人详情信息 及处分详情  参考/teacher/index/teacher_clen字段说明
    {
      "id": 2,
      "teacher_id": "2016T2871",  //被处理人ID
      "info": "<p>sdafsdf</p>\r\n",
      "teacher_tf": 1,
      "admin": "2019T3419",
      "admin_tf": 1,
      "epilogue": null,
      "disciplinary_sanction_id": 7,
      "clan_sanction_id": 3,
      "title": "sdsd",
      "send_id": "2019T3419",
      "add_time": "2022-11-22",
      "end_time": "2022-11-23",
      "beiname": "徐琰", //被处理人姓名
      "beiid": "2016T2871",
      "pname": "初等教育学院",//部门
      "beid": "2016T2871",
      "post_name": "班主任", //职务
      "pidss": 2,
      "send_name": "饶育悦",
      "send_idid": "2019T3419",
      "sex": "女",
      "card": "162180212707690422",
      "site": "山东省淄博市", //被处理人地址
      "iphone": 17777454119,//被处理人手机号
      "entry_time": "2019-07-04",//入职时间
      "state": 1,//是否在职  1=在职
      "age": "1999-09-09", //出生日期
      "admin_name": "饶育悦", //处理人姓名
      "admin_id": "2019T3419",
      "san_id": 7,
      "sciplinary_name": "严重警告",
      "disciplinary_sanction_root": 3,
      "class_id": 3,
      "clan_name": "撤销党内职务",
      "clan_root": "21",
      "beiiidd": "2016T2871",
      "politics_name": "团员",
      "politics_post_name": null
    }
]
```



# 添加教职工处分

请求地址:/teacher/index/send_teacherw

请求方式：get

请求参数:

| 参数名                   | 类型   | 是否必须 | 说明       |
| ------------------------ | ------ | -------- | ---------- |
| clan_sanction_id         | INT    | T        | 党内处分ID |
| disciplinary_sanction_id | INT    | T        | 行政处分ID |
| info                     | String | T        | 内容       |
| teacher_id               | String | T        | 被处理人ID |
| title                    | String | T        | 标题       |
| id                       | INT    | T        | 填 0       |
| send_id                  | String | T        | 发起人ID   |

返回参数:

```

```









# 获取全部在职教师

请求地址:/index

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
department:[ //部门
{
  "bid": 1,
  "bname": "学前教育学院",
  "childer": [  //部门下办公室
            {
              "zbid": 1,
              "bname": "学前教育",
              "zid": 1000
            },
            {
              "zbid": 1,
              "bname": "院党委办公室",
              "zid": 1001
            },
            {
              "zbid": 1,
              "bname": "院团委办公室",
              "zid": 1002
        	}
      ]
}
]
xz:[//获取行政职务
    {
      "id": 1,
      "name": "校长",
      "root": 0,
      "salary": 20000
    }
]
zz:[//政治职务
    {
      "id": 1,
      "politics_post_name": "党委书记",
      "politics_post_root": 0
    }
]
data:[//获取教师详情
    {
        "name": "酆钤",  //姓名
        "department": "财务处\r\n\r\n",、、部门
        "room": "无", //部门办公室
        "key": "1998T8678",//教师ID
        "politics_post": "党委书记", //党内职务
        "admin_post": "处长",//行政职务
        "state": "在职", 
        "sex": "男",
        "site": "福建省福州市",
        "iphone": 11758533706,
        "entry_time": "1998-01-03",
        "age": "1978-03-22",
        "card": "154621835449725650",//身份证号
        "description": [ //详情信息
            {
                "sex": "男",
                "site": "福建省福州市",
                "iphone": 11758533706,
                "card": "154621835449725650",
                "teacher_id": "1998T8678",
                "entry_time": "1998-01-03",
                "age": 45,
                "key": "1998T8678"
            }
        ]
    }
]
```





# 获取历史教职工

请求地址:index/index/Beforeteacher

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
data:[
    {
      "id": 0,
      "teacher_name": "贺畅",
      "sex": "女",
      "card": "420117200011157511",
      "site": "天津市天津市sdf",
      "iphone": 17754400960,
      "entry_time": "2022-11-02", //入职日期
      "quit_time": null,
      "state": 2,  //1=在职 2=离职
      "teacher_id": "2022T6900",
      "age": "2022-11-02",
      "department_id": 2,
      "specialty_id": 1004,
      "end_time": "2022-12-07",//离职日期
      "pid": 2,
      "pname": "初等教育学院",
      "rzhi": "2022", 
      "key": "2022T6900"
    }
]
```





# 获取统计图数据

请求地址:/index/index/overview_department

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明                                               |
| ------ | ---- | -------- | -------------------------------------------------- |
| id     | int  | T        | 0=学校部门人数统计数据  1=性别统计  2=工龄人数统计 |

返回参数:

```
type==0
	data:[
		{
          "name": "旅游与酒店管理学院", //名称
          "value": 60  //值
        }
	]
	zong:[ //总人数
      {
        "zong": 991
      }
    ]

type==1
	data:[
        {
          "value": 657,
          "name": "男"
        }
		]
    zong:[ //总人数
          {
            "zong": 991
          }
    	]
 
 type==2
	data:[
           {
          "name": "26-30年",
          "value": 146 //人数
        }
		]
    zong:[ //总人数
          {
            "zong": 991
          }
    	]
```







# 获取全部班级课表

请求地址:/index/index/classquery

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
data:[
    {
        "key": 3,
        "class_id": 3, //班级ID
        "department_id": 7,//部门ID
        "department_name": "计算机与电子信息工程学院", //部门名称
        "specialty_id": 1045, /
        "specialty_name": "计算机应用技术", //专业名称
        "pid": 7,/专业ID
        "class_num": 1, //第几班级
        "nj": 2022,//年级
        "accomplish": "21节课"  //一周多少节课
    }
]
department_specialty:[//全部专业
    {
        "key": 1000,
        "text": "学前教育",
        "value": "学前教育",
        "pid": 1
    }
]

```



# 获取班级课表

请求地址:/index/index/classkadd

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明                                        |
| ------ | ---- | -------- | ------------------------------------------- |
| zid    | INT  | T        | 专业ID                                      |
| nd     | INT  | F        | 学年 课表   为方便使用可不传 获取以安排课表 |
| pid    | INT  | T        | 部门ID                                      |
| data   | INT  | T        | 班级ID                                      |

返回参数:

```

data:[//获取一周课表
    {
        "id": 429, 
        "department_id": 7,  //部门ID
        "department_specialty_id": 1045, //专业ID
        "teacher_id": "2001T2168",
        "specialty_class_id": 429,
        "classroom": "1-306",  //教室
        "week": 1, //周几
        "class_time": 1,//第几节课
        "semester": null,
        "class_id": 3,
        "nd": 222, //年度  前两位表示年份  1=上学期 2=下学期
        "start_time": 1,  
        "end_time": 10,
        "name": "UI界面设计", //课程名称
        "time": 30,
        "grade": 2, 
        "teacher_name": "汤奇奇",//讲师名称
        "rid": "2001T2168" //讲师ID
    }
]
ke：[//获取该专业全部课程
      {
        "key": "平面设计",
        "label": "平面设计",
        "value": "平面设计",
        "id": 428,
        "pid": 1045
    }
]
teacher:[//获取该专业可以安排的讲师
    {
        "key": "2001T2168",
        "value": "汤奇奇",
        "label": "汤奇奇"
    }
]
```



# 班级添加课程

请求地址:/index/index/classkadd

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明            |
| ---------- | ------ | -------- | --------------- |
| week       | INT    | T        | 周几            |
| class_time | INT    | T        | 第几节课        |
| data       | string | T        | 上课地点        |
| nd         | INT    | T        | 该字段统一传222 |
| class_id   | INT    | T        | 班级ID          |

返回参数:

```
看msg字段
```







# 获取每个专业的课程

请求地址:/index/index/Course

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
data:[//获取全部课程
    {
        "id": 1,//课程ID
        "name": "教育学",//课程名称
        "time": 30,//学时
        "grade": 5,//学分
        "type": "专业课",//课程类型
        "sname": "学前教育",//所属专业
        "pname": "学前教育学院",//所属院系
    }
]
department_specialty:[//获取全部专业
    {
        "text": "学前教育",
        "value": "学前教育",
        "pid": 1,
        "sid": 1000 //专业ID
    }
]
department:[//获取学院/部门
    {
        "text": "学前教育学院",
        "value": "学前教育学院",
        "key": 1 //部门ID
    }
]
```



# 添加课目

请求地址:/index/index/up_Course

请求方式：get

请求参数:

| 参数名 | 类型    | 是否必须 | 说明                        |
| ------ | ------- | -------- | --------------------------- |
| pid    | INT     | T        | 部门ID                      |
| sid    | INT     | T        | 专业ID                      |
| id     | INT     | T        | 修改课程时 传入课程ID       |
| name   | INT     | T        | 课程名称                    |
| type   | INT     | T        | a=专业课  b=公共课 c=选修课 |
| time   | INT     | T        | 课时                        |
| grade  | INT     | T        | 学分                        |
| updata | boolean | T        | 新增为false 修改为true      |

返回参数:

```

```





# 删除课目

请求地址:/index/index/del_Course

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明                        |
| ------ | ------ | -------- | --------------------------- |
| id     | INT    | T        | 课程ID                      |
| type   | string | T        | a=专业课  b=公共课 c=选修课 |

返回参数:

```

```





# 获取年度选修课程安排

请求地址:/teacher/index/selectclass

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明       |
| ------ | ---- | -------- | ---------- |
| nd     | INT  | T        | 最好传 222 |

返回参数:

```
data:[ //获取已安排的选修课程
    {
        "id": 3001, //选修课程ID
        "select_class_id": 3001,
        "teacher_id": "2018T1295",//讲师ID
        "place": "2-204",//地点
        "week": 2,//周几
        "section": "1-2节次",
        "sen_time": 1, //开始周
        "end_time": 17, //结束周
        "nd": 222,//年度
        "name": "中国语言文学",//课程名称
        "time": 30,//课时
        "grade": 2,//学分
        "teacher_name": "桑商黎",//讲师
        "key": 1
    }
]
select:[//获取可以安排的选修课程
    {
        "label": "道德素养",
        "value": "道德素养",
        "key": 3000
    }
]
teacher:[//获取可以安排的讲师
	{
    "label": "学前教育学院",//部门名称
    "value": 1,
    "children": [
        {
            "id": 415,
            "teacher_id": "2013T6390",//讲师ID
            "post_id": 13,
            "teacher_name": "通瑶",
            "department_id": 1,//部门ID
            "specialty_id": 1000,
            "label": "通瑶", //讲师姓名
            "value": "2013T6390"
        },

	}
]
```





# 添加选修课程

请求地址:/index/index/up_Course

请求方式：get

请求参数:

| 参数名          | 类型    | 是否必须 | 说明                   |
| --------------- | ------- | -------- | ---------------------- |
| end_time        | INT     | T        | 结束周                 |
| sen_time        | INT     | T        | 开始周                 |
| select_class_id | INT     | T        | 选修课目ID             |
| section         | INT     | T        | 节次                   |
| teacher_id      | INT     | T        | 讲师ID                 |
| week            | INT     | T        | 周几                   |
| nd              | INT     | T        | 传222                  |
| type            | boolean | T        | 新增为false 修改为true |
| place           | string  | T        | 上课地点               |

返回参数:

```

```



# 查询该班级是否存在

请求地址:/index/index/classrep

请求方式：get

请求参数:

| 参数名             | 类型 | 是否必须 | 说明     |
| ------------------ | ---- | -------- | -------- |
| res[department_id] | INT  | T        | 部门ID   |
| res[specialty_id]  | INT  | T        | 专业ID   |
| res[class_num]     | INT  | T        | 第几班级 |
| res[grden]         | INT  | T        | 查询年度 |

返回参数:

```
该班级不存在  该班级已存在
```





# 获取该学生信息

请求地址:/index/index/addstuendclass

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明                              |
| ------ | ------ | -------- | --------------------------------- |
| data[] | string | T        | 学生ID  data为数组 里面存放学生ID |

返回参数:

```
data:[
    {
        "student_id": "2020955J9049027",
        "department_id": 7,//原部门ID
        "specialty_id": 1040, //原专业ID
        "department_name": "计算机与电子信息工程学院",//原部门
        "specialty_name": "微电子技术",//原专业
        "class_id": 156,//原班级ID
        "class_num": 1,//原第几班级
        "student_name": "通小宸" //学生名称
    }
]
```





# 获取该学生信息

请求地址:/index/index/addstuendclass

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明                              |
| ------ | ------ | -------- | --------------------------------- |
| data[] | string | T        | 学生ID  data为数组 里面存放学生ID |

返回参数:

```
data:[
    {
        "student_id": "2020955J9049027",
        "department_id": 7,//原部门ID
        "specialty_id": 1040, //原专业ID
        "department_name": "计算机与电子信息工程学院",//原部门
        "specialty_name": "微电子技术",//原专业
        "class_id": 156,//原班级ID
        "class_num": 1,//原第几班级
        "student_name": "通小宸" //学生名称
    }
]
```





# 班级添加学生

请求地址:/index/index/addclass

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明                              |
| ------ | ------ | -------- | --------------------------------- |
| data   | Array  | T        | 学生ID  data为数组 里面存放学生ID |
| t      | INT    | T        | 0=新建班级  1=否                  |
| batch  | Object | T        | 参考一下参数                      |

batch 里参数

| 参数名        | 类型 | 是否必须 | 说明     |
| ------------- | ---- | -------- | -------- |
| specialty_id  | INT  | T        | 专业ID   |
| department_id | INT  | T        | 部门ID   |
| nj            | INT  | T        | 年级     |
| class_num     | INT  | T        | 第几班级 |

返回参数:

```
msg: "操作成功"
```







# 班级添加学生

请求地址:/index/student

请求方式：get

请求参数:无

返回参数:

```
data:[
    {
        "id": 3,
        "department_specialty_id": 1045,
        "department_id": 7,
        "student_class_num": 2022,//年级
        "instructor_id": "2011T9480",
        "director_id": "2010T2292",
        "num": 1,//第几班级
        "teacher_id": "2011T9480",//辅导员ID
        "teacher_name": "卞光晶",
        "ban_id": "2010T2292",//班主任ID
        "ban_name": "訾有菀",
        "pid": 7, //部门ID
        "pname": "计算机与电子信息工程学院",
        "kid": 1045,//专业ID
        "kname": "计算机应用技术",
        "key": 3//班级ID
    }
]
```



# 教职工班级职务设置

请求地址:/index/student/classteacher

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明                       |
| ---------- | ------ | -------- | -------------------------- |
| teacher_id | string | T        | 教职工ID                   |
| type       | INT    | T        | 0=设置辅导员  1=设置班主任 |
| class_id   | INT    | T        | 班级ID                     |

返回参数:

```
msg: "操作成功,该班主任已有3个班"
msg: "操作成功,该辅导员已有4个班"
```



# 获取全部班级

请求地址:/index/index/get_class_student

请求方式：get

请求参数:无

返回参数:

```
data:[
  {
    "id": 1,
    "department_specialty_id": 1058,//专业ID
    "department_id": 9,//部门ID
    "student_class_num": 2020,//年级
    "instructor_id": "2004T1120",//辅导员ID
    "director_id": "2003T8392",//班主任ID
    "num": 1,//第几班级
    "pid": 9,//部门ID
    "pname": "建筑工程学院",//部门名称
    "sid": 1058,//专业ID
    "sname": "建筑设计",//专业名称
    "student_id": "2020592P4846702",
    "class_grade_id": 170,
    "specialty_id": 1058,
    "zong": 17,//班级人数
    "key": 170
}
]
```



# 获取班级成绩

请求地址:/index/student/lookclass_student

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明             |
| ------ | ---- | -------- | ---------------- |
| id     | INT  | T        | 班级ID           |
| nd     | INT  | T        | 查询年度 建议222 |

返回参数:

```
data:[//获取课目下的每个学生成绩
{
    "id": 435,
    "department_id": 7,
    "department_specialty_id": 1045,
    "teacher_id": "2001T2168", //讲师ID
    "specialty_class_id": 435,
    "classroom": "1-310",
    "week": 2,
    "class_time": 1,
    "semester": null,
    "class_id": 3,
    "nd": 222,
    "start_time": 10,
    "end_time": 17,
    "name": "微信小程序开发",//课程名称
    "key": 3,
    "sondata": [//学生成绩
        {
            "id": 1,
            "student_id": "2022892P9123817",
            "department_id": 7,
            "class_grade_id": 3,//班级ID
            "specialty_id": 1045,
            "semester": 222, //年度
            "specialty_class_id": 435,
            "student_class_id": 3,
            "one_grade": 40,//正考成绩
            "two_grade": 90,//补考成绩
            "student_name": "支炅屿",//学生名称
            "ssid": "2022892P9123817",//学生ID
            "key": 139,
            "sssid": "2022892P9123817"
        },
    ]
}
]
```





# 修改学生成绩

请求地址:/index/student/lookclass_student

请求方式：get

请求参数:

| 参数名         | 类型 | 是否必须 | 说明                   |
| -------------- | ---- | -------- | ---------------------- |
| grade          | INT  | T        | 成绩                   |
| sid            | INT  | T        | 传入课程ID             |
| class_grade_id | INT  | T        | 班级ID                 |
| student_id     | INT  | T        | 学生ID                 |
| nd             | INT  | T        | 学年  建议填写222      |
| type           | INT  | T        | 1=正考成绩  2=补考成绩 |

返回参数:

```

```



# 查看全部学生处分

请求地址:/index/student/lookclass_student

请求方式：get

请求参数:无

返回参数:

```
data:[
    {
      "sid": "2021865J6407256",//学生ID
      "info": "werwer",//内容
      "stundet_tf": 0,// 学生意见  0：待处理 1:同意 -1反驳
      "admin": "2019T3419",//审核人ID
      "admin_tf": 0,//审核人意见
      "epilogue": null,
      "disciplinary_sanction_id": 2,
      "clan_sanction_id": null,
      "fujian": "16690179791830670561.jpeg,16690179791438997178.png,"//附件
      "add_time": "2022-11-21",//添加时间
      "end_time": "2022-11-23",
      "title": "erwe",//标题
      "send_id": "2019T3419",//处分发起人ID
      "key": 3, //处分ID
      "id": 1534,
      "student_id": "2021865J6407256",
      "student_name": "花铠黎",//学生名称
      "student_sex": "男",
      "student_site": "辽宁省丹东市",
      "student_card": "163007998589995437",
      "student_iphone": 11673290514,
      "student_politics": 3,
      "student_state": 0,
      "student_time": "2021-09-01",//入学时间
      "student_age": "2003-01-12",
      "state": null,
      "sids": "2021865J6407256",
      "class_grade_id": 73,
      "specialty_id": 1010,
      "ssspppid": 3,
      "pid": 3,
      "pname": "文化创意与艺术设计学院",
      "dpisd": 1010,
      "department_id": 3,
      "name": "融媒体技术",
      "teacher_id": "2019T3419",
      "teacher_name": "饶育悦",
      "send_name": "饶育悦",//处分发起人名称
      "ppid": 2,
      "sciplinary_name": "严重警告", //处分名称
      "disciplinary_day": 6,
      "disciplinary_sanction_root": 4,
      "ts": 1
    }
]
```





# 学生处分详情

请求地址:/index/student/punishmentx

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明   |
| ---------- | ------ | -------- | ------ |
| id         | INT    | T        | 处分ID |
| student_id | String | T        | 学生ID |

返回参数:

```
{
    "id": 14,
    "student_id": "2020592P4846702",
    "info": "哈哈哈哈sdfsdfsdfsdfsdf胜多负少sdf胜多负少的的苟富贵单方事故电饭锅水电费水电费水电费阿斯蒂芬sdfsdf sdfsd f水电费",
    "stundet_tf": 0,
    "admin": "2019T3419",
    "admin_tf": 0,
    "epilogue": null,
    "disciplinary_sanction_id": 4,
    "clan_sanction_id": null,
    "fujian": "1668849160293721485.jpg,16689527751341894133.jpeg",
    "add_time": "2022-11-10",
    "end_time": "2022-11-21",
    "title": "违规翻墙",
    "send_id": "2019T3419",
    "student_name": "姚清垚",
    "student_sex": "男",
    "student_site": "四川省甘孜藏族自治州",
    "student_card": "151471555601945365",
    "student_iphone": 1815597340,
    "student_politics": 2,
    "student_state": 0,
    "student_time": "2020-09-01",
    "student_age": "2002-05-06",
    "state": 1,
    "department_id": 9,
    "class_grade_id": 170,
    "specialty_id": 1058,
    "name": "建筑设计",
    "pname": "建筑工程学院",
    "graduate": 2,
    "teacher_name": "饶育悦",
    "sex": "女",
    "card": "162180212707690422",
    "site": "山东省淄博市",
    "iphone": 17777454119,
    "entry_time": "2019-07-04",
    "quit_time": null,
    "teacher_id": "2019T3419",
    "age": "1999-09-09",
    "sendid": "2019T3419",
    "send_name": "饶育悦",
    "dsid": 4,
    "sciplinary_name": "记大过",
    "num": 1,
    "fname": "侯云斯",//学生辅导员
    "bname": "林芸",//学生班主任
    "student_class_num": 2020,
    "key": 1
}
```



# 添加学生处分

请求地址:/index/student/addstudentw

请求方式：get

请求参数:

| 参数名                   | 类型   | 是否必须 | 说明       |
| ------------------------ | ------ | -------- | ---------- |
| images                   | FILE   | F        | 图片       |
| student_id               | String | T        | 学生ID     |
| info                     | String |          | 内容       |
| title                    | String |          | 标题       |
| send_id                  | String |          | 发起人ID   |
| disciplinary_sanction_id |        |          | 行政处分ID |

返回参数:

```
{
    "msg": "保存成功",
    "code": 200
}
```







# 查看全部学生个人信息

请求地址:/index/student/lookclass_student

请求方式：get

请求参数:无

返回参数:

```
{
    "id": 9,
    "student_id": "2020592P4846702",
    "department_id": 9,
    "class_grade_id": 170,
    "specialty_id": 1058,
    "student_name": "姚清垚",
    "student_sex": "男",
    "student_site": "四川省甘孜藏族自治州",
    "student_card": "151471555601945365",
    "student_iphone": 1815597340,
    "student_politics": 2,
    "student_state": 0,
    "student_time": "2020-09-01",
    "student_age": "2002-05-06",
    "state": null,
    "name": "建筑工程学院",
    "sname": "建筑设计",
    "sid": 1058,//专业ID
    "nj": "2020",
    "key": "2020592P4846702"
}
```





# 修改学生信息

请求地址:/index/student/up_Management

请求方式：get

请求参数:

| 参数名         | 类型   | 是否必须 | 说明   |
| -------------- | ------ | -------- | ------ |
| student_iphone | String | T        | 手机号 |
| student_name   | String | T        | 姓名   |
| student_sex    | String | T        | 性别   |
| student_site   | String | T        | 地址   |
| student_id     | String | T        | 学生ID |

返回参数:

```

```





# 查看全部宿舍楼住宿信息

请求地址:/index/index/studentedu

请求方式：get

请求参数:无

返回参数:

```
{
    "student_id": "2020592P4846702",//学生ID
    "department": "建筑工程学院",
    "department_id": 9,
    "specialty_name": "建筑设计",
    "specialty_id": 1058,
    "class": 1,//第几班级
    "student_name": "姚清垚",
    "key": "2020592P4846702",
    "dorm_num_id": 504,//宿舍号
    "dorm_id": 11  //楼栋号
}
```





# 查看楼栋剩余房间

请求地址:/index/student/chalooporm

请求方式：get

请求参数:

| 参数名  | 类型 | 是否必须 | 说明   |
| ------- | ---- | -------- | ------ |
| dorm_id | INT  | T        | 楼栋号 |

返回参数:

```
{
    "key": 2648,
    "name": 208, //宿舍号
    "member_one_id": null,//为空则没有人
    "member_two_id": null,
    "member_three_id": null,
    "member_four_id": null,
    "time": null,
    "dorm_id": 12,//楼栋号
    "sheng": 4
}
```



# 删除学生住宿信息

请求地址:/index/student/deldorm

请求方式：get

请求参数:

| 参数名      | 类型   | 是否必须 | 说明   |
| ----------- | ------ | -------- | ------ |
| student_id  | String | T        | 学生ID |
| dorm_id     | INT    | T        | 楼栋号 |
| dorm_num_id | INT    | T        | 宿舍号 |

返回参数:

```
s
```





# 修改学生住宿信息

请求地址:/index/student/updorm

请求方式：get

请求参数:

| 参数名      | 类型   | 是否必须 | 说明   |
| ----------- | ------ | -------- | ------ |
| student_id  | String | T        | 学生ID |
| dorm_id     | INT    | T        | 楼栋号 |
| dorm_num_id | INT    | T        | 宿舍号 |

返回参数:

```

```





# 查看宿舍报修记录

请求地址:/student/index/dorm_look_all

请求方式：get

请求参数:无

返回参数:

```
{
    "id": 15,//报修记录ID
    "dorop_num": 3,//楼栋号
    "maintain_info": "PHA+ZmdoZGZnaGZnaDwvcD4NCg==", //内容
    "accessory": "202",
    "student_id": "2020592P4846702", //上报学生ID
    "state": 0,// -1报上级 0待处理 1已处理
    "sen_time": "2022-12-10", //上报时间
    "end_time": null,
    "title": "fghfghfgh",//标题
    "admin": null, //处理人
    "student_name": "姚清垚",//上报学生
    "ssid": "2020592P4846702",
    "teacher_name": null,
    "teacher_id": null,
    "key": 15
}
```





# 修改宿舍报修记录状态

请求地址:/student/index/dorm_look_all

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明             |
| ---------- | ---- | -------- | ---------------- |
| type       | INT  | T        | -1报上级 1已处理 |
| id         | INT  | T        | 报修ID           |
| teacher_id | INT  | T        | 处理教职工ID     |

返回参数:

```

```



# 查看报修详情

请求地址:/student/index/dorm_weix

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 报修ID |

返回参数:

```
{
    "id": 15,
    "dorop_num": 3,
    "maintain_info": "<p>fghdfghfgh</p>\r\n", //内容
    "accessory": "202",
    "student_id": "2020592P4846702",
    "state": 1,
    "sen_time": "2022-12-10",
    "end_time": "2023-04-26",
    "title": "fghfghfgh",
    "admin": "2019T3419",
    "student_name": "姚清垚",
    "teacher_name": "饶育悦",//审核人
    "teacher_id": "2019T3419"
}
```



# 查看全校团员

请求地址:/index/index/member

请求方式：get

请求参数:无

返回参数:

```
{
    "id": 2,
    "student_id": "2020592P4846702",
    "department_id": 9,
    "class_grade_id": 170,
    "specialty_id": 1058,
    "student_name": "姚清垚",
    "student_politics": 2,
    "pid": 9,
    "pname": "建筑工程学院",
    "sid": 1058,
    "sname": "建筑设计",
    "politics_name": "团员",
    "politics_root": 4,
    "nj": "2020",
    "key": "2020592P4846702"
}
```





# 修改学生政治面貌

请求地址:/student/index/up_Member

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明       |
| ---------- | ------ | -------- | ---------- |
| student_id | String | T        | 学生ID     |
| type       | INT    | T        | 政治面貌ID |

返回参数:

```

```





# 获取全部部门经费

请求地址:/index/index/moneyset

请求方式：get

请求参数:无

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
|        |      |          |      |

返回参数:

```
data:{
    "department_id": 25,//部门ID
    "department_root": 10,
    "department_root_big": 7,
    "zong": 5000,//总经费
    "yi": null,//已使用
    "jie": 0,//结余
    "nd": 222,//年度
    "mid": 13,
    "id": 25,//部门ID
    "name": "图书馆\r\n\r\n",//部门名称
    "department_root_id": 10, 
    "department_root_name": "辅导员",//申请权限 xx以上
    "department_root_big_id": 7,
    "department_root_big_id_name": "科长",//审批权限 xx以上
    "key": 0.5609614695990099
}

post:[
    {
        "value": 1,
        "label": "校长及以上",
        "key": 0.5592691577591646
    },
]
```







# 编辑经费使用审批权限

请求地址:/student/index/up_Member

请求方式：get

请求参数:

| 参数名              | 类型   | 是否必须 | 说明                           |
| ------------------- | ------ | -------- | ------------------------------ |
| id                  | String | T        | 部门ID                         |
| nd                  | INT    | T        | 年度                           |
| department_root     | INT    | T        | moneyset接口中post 字段中value |
| department_root_big | INT    | T        | moneyset接口中post 字段中value |

返回参数:

```

```





# 设置部门经费

请求地址:/index/index/up_money

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明         |
| ------ | ------ | -------- | ------------ |
| id     | String | T        | 部门ID       |
| nd     | INT    | T        | 年度         |
| type   | INT    | T        | type=1       |
| money  | INT    | T        | 设置经费金额 |

返回参数:

```
	
```





# 获取经费申请记录

请求地址:/index/index/up_money

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明         |
| ------ | ---- | -------- | ------------ |
| nd     | INT  | T        | 年度 建议222 |

返回参数:

```
	{
    "id": 7,
    "applicant_id": "2004T1120",//申请人ID
    "money_info": "PHA+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZTogNzJweDsiPmRmZ2RmZ2Rmc2dkZnNnPC9zcGFuPjwvcD4NCg==",
    "moeny_accessory": "dfgd", //附件
    "moeny_state": 1, -1驳回 0待审核 1 通过‘
    "moeny_admin": "2004T1120",
    "apply_time": "2022-12-05",
    "admin_time": "2022-12-05",
    "add_money": 200, //申请金额
    "nd": 222,//年度
    "applicant_name": "侯云斯",//申请人
    "moeny_admin_name": "侯云斯", //审核人
    "pid": 7,
    "teacher_id": "2004T1120", 
    "department_id": 7,
    "department_root": 7,
    "department_root_big": 7,
    "zong": 8000,
    "yi": 1200, //已使用
    "jie": 6800,//结余
    "mid": 7,
    "name": "计算机与电子信息工程学院",
    "key": 2
}
```





# 查看经费申请详情内容

请求地址:p/index/index/money_look

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 申请ID |

返回参数:

```
{
    "id": 2,
    "applicant_id": "2004T1120",
    "money_info": "<p><span style=\"font-size: 72px;\">dfgdfgdfsgdfsg</span></p>\r\n", //申请内容
    "moeny_accessory": "dfgd", //标题
    "moeny_state": 1,
    "moeny_admin": "2004T1120",
    "apply_time": "2022-12-05",
    "admin_time": "2022-12-05",//审核时间
    "add_money": 200,
    "nd": 222,
    "applicant_name": "侯云斯",
    "moeny_admin_name": "侯云斯",
    "key": 2
}
```





# 查看图书馆全部图书

请求地址:/index/Book/index

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明 |
| ------ | ---- | -------- | ---- |
| 无     |      |          |      |

返回参数:

```
{
    "id": 1, //书籍ID
    "library_name": "教父",//书籍名称
    "add_time": "2010-10-01",//添加时间
    "lend_num": 0, //借出数量
    "book_num": 4,//书籍总数
    "deposit": 0,
    "zuozhe": "[美] 马里奥·普佐", //作者
    "site": "2-4-105-2", //书籍存放地点
    "key": 1,
    "text": "教父",
    "value": "教父"
}
```





# 编辑书籍信息

请求地址:/index/Book/bookup

请求方式：get

请求参数:

| 参数名       | 类型   | 是否必须 | 说明         |
| ------------ | ------ | -------- | ------------ |
| id           | INT    | T        | 书籍ID       |
| library_name | String | T        | 书籍名称     |
| zuozhe       | String | T        | 作者         |
| book_num     | INT    | T        | 书籍数量     |
| site         | String | T        | 书籍存放地点 |

返回参数:

```

```



# 添加书籍

请求地址:/index/Book/addbook

请求方式：get

请求参数:

| 参数名       | 类型   | 是否必须 | 说明         |
| ------------ | ------ | -------- | ------------ |
|              |        |          |              |
| library_name | String | T        | 书籍名称     |
| zuozhe       | String | T        | 作者         |
| book_num     | INT    | T        | 书籍数量     |
| site         | String | T        | 书籍存放地点 |

返回参数:

```

```



# 添加书籍借阅信息

请求地址:/index/book/add_jie_book

请求方式：get

请求参数:

| 参数名  | 类型   | 是否必须 | 说明          |
| ------- | ------ | -------- | ------------- |
| user_id | String | T        | 教职工/学生ID |
| book_id | INT    | T        | 书籍ID        |

返回参数:

```

```



# 归还借阅书籍

请求地址:/index/book/book_gui

请求方式：get

请求参数:

| 参数名  | 类型 | 是否必须 | 说明   |
| ------- | ---- | -------- | ------ |
| id      | INT  | T        | 借阅ID |
| book_id | INT  | T        | 书籍ID |

返回参数:

```
d
```





# 图书馆借阅记录

请求地址:/index/Book/borrow

请求方式：get

请求参数:无

返回参数:

```
{
    "id": 1,  //借阅ID
    "lend_id": "2020592P4846702", //教职工/学生ID
    "lend_start": "2022-11-02",//借阅开始时间
    "lend_end": "2022-11-25",//借阅结束时间
    "book_id": 1,//书籍ID
    "lend_state": 0,//1:未归还   0:已归还
    "user_id": "2020592P4846702",
    "user_name": "姚清垚",
    "department": "建筑工程学院",
    "library_name": "教父",
    "borrow": 10,
    "value": "学生",
    "text": "学生"
}
```



# 功能设置

请求地址:/index/index/get_root_name

请求方式：get

请求参数:无

返回参数:

```
data:[ 
    { 
        "select_class_xuan": "是否能选选修课",
        "slect_class_tui": "是否能退选修课",
        "leave_tf": "是否允许学生请假",
        "student_punishment": "是否开启学生处分",
        "teacher_punishment": "是否开启老师处分",
        "department_expenditure": "是否能申请部门经费",
        "teacher_select_class": "是否开启新增选修课",
        "teacher_class_ke": "是否能编辑班级课表",
        "teacher_class_post": "是否能编辑老师班级职务",
        "student_grade": "是否能编辑学生成绩",
        "teacher_add": "是否能新增教职工",
        "zzmm_teacher": "是否能编辑老师的政治面貌",
        "teacher_info": "是否能修改老师的个人信息",
        "ke_class": "是否能编辑课目",
        "ket_class_del": "是否能删除课目",
        "seelct_class_change": "是否能编辑选修课程",
        "student_class": "是否能改变学生班级",
        "student_zzmm": "是否能改变学生的政治面貌",
        "money_change": "是否能编辑经费",
        "money_root": "是否能编辑经费使用权限",
        "book_add": "是否能添加书籍",
        "book_change": "是否能编辑书籍",
        "book_jie": "是否能借阅书籍",
        "id": 1,
        "key": 0.47767394825599524
    },
    {//0=允许  1=反之
        "select_class_xuan": "0",
        "slect_class_tui": "0",
        "leave_tf": "0",
        "student_punishment": "0",
        "teacher_punishment": "0",
        "department_expenditure": "0",
        "teacher_select_class": "0",
        "teacher_class_ke": "0",
        "teacher_class_post": "0",
        "student_grade": "0",
        "teacher_add": "0",
        "zzmm_teacher": "0",
        "teacher_info": "0",
        "ke_class": "0",
        "ket_class_del": "0",
        "seelct_class_change": "0",
        "student_class": "0",
        "student_zzmm": "0",
        "money_change": "0",
        "money_root": "0",
        "book_add": "0",
        "book_change": "0",
        "book_jie": "0",
        "id": 1,
        "key": 0.40622512847764897
    }
]
```



# 功能修改

请求地址:/index/index/up_Functionset

请求方式：get

请求参数:

| 参数名 | 类型    | 是否必须 | 说明                         |
| ------ | ------- | -------- | ---------------------------- |
| type   | boolean | T        | true=允许 false=禁止         |
| name   | String  | T        | 选项名 例如select_class_xuan |

返回参数:

```
s
```





# 获取所有部门

请求地址:/index/index/Systemroot

请求方式：get

请求参数:无

返回参数:

```
data:[
    {
        "id": 1,
        "name": "学前教育学院",
        "key": 1
    },
    {
        "id": 2,
        "name": "初等教育学院",
        "key": 2
    },
]
```







# 获取部门所有职务

请求地址:/index/index/Systemroot_post

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 部门ID |

返回参数:

```
data:[
    {
        "id": 3,
        "department_id": 6,
        "post_id": 3,//职务ID
        "root_id": 13,
        "name": "院长",
        "root": 2,//权限等级
        "salary": 16000
    }
]
```



# 获取部门该职务所对应的页面路由

请求地址:/index/index/Systemroot_post

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| pid    | INT  | T        | 部门ID |
| sid    | INT  | T        | 职务ID |

返回参数:

```
data:[
    {
        "id": 16,//路由ID
        "site": "/home/teacher", //页面路由路径
        "remark": "教职工管理",
        "father": "人事处",
        "key": 16
    }
]
```





# 修改部门该职务所对应的页面路由

请求地址:/index/index/Systemroot_post

请求方式：get

请求参数:

| 参数名       | 类型    | 是否必须 | 说明                    |
| ------------ | ------- | -------- | ----------------------- |
| pid          | INT     | T        | 部门ID                  |
| sid          | INT     | T        | 职务ID                  |
| root_info_id | INT     | T        | 页面路由ID              |
| type         | boolean | T        | false=禁止    true=允许 |

返回参数:

```
s
```







# 查看具体教师的处分

请求地址:/teacher/index/teacherpunishment

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明     |
| ---------- | ------ | -------- | -------- |
| teacher_id | String | T        | 教职工ID |

返回参数:

```
data:[
    {
        "id": 1,//处分ID
        "teacher_id": "2019T3419",
        "teacher_tf": 1,
        "admin": "2019T3419",
        "admin_tf": 1,
        "epilogue": null,
        "disciplinary_sanction_id": 7,
        "clan_sanction_id": 1,
        "title": "哈哈哈",
        "send_id": "2019T3419",
        "add_time": "2022-11-01",
        "end_time": "2022-12-03",
        "beiname": "饶育悦",
        "beiid": "2019T3419",
        "pname": "党政办公室",
        "beid": "2019T3419",
        "post_name": "校长",
        "send_name": "饶育悦",
        "send_idid": "2019T3419",
        "admin_name": "饶育悦",
        "admin_id": "2019T3419",
        "san_id": 7,
        "sciplinary_name": "严重警告",
        "class_id": 1,
        "clan_name": "警告",
        "key": 1
    }
]
```





# 被处理教职工是否接受该处分

请求地址:/teacher/index/teacher_punishment_tf

请求方式：get

请求参数:

| 参数名 | 类型   | 是否必须 | 说明             |
| ------ | ------ | -------- | ---------------- |
| id     | INT    | T        | 处分ID           |
| type   | String | T        | T=同意  F=不接受 |

返回参数:

```
s
```





# 教职工处分进行审批

请求地址:/teacher/index/teacher_wshen

请求方式：get

请求参数:

| 参数名   | 类型   | 是否必须 | 说明            |
| -------- | ------ | -------- | --------------- |
| id       | INT    | T        | 处分ID          |
| admin_id | String | T        | 审核人教职工ID  |
| admin_tf | INT    |          | 1=同意  -1=驳回 |

返回参数:

```
s
```



# 查看教职工申请的经费

请求地址:/index/index/Moneyapply

请求方式：get

请求参数:

| 参数名     | 类型   | 是否必须 | 说明     |
| ---------- | ------ | -------- | -------- |
| teacher_id | String | T        | 教职工ID |

返回参数:

```
data:[
    {
        "id": 6,//经费申请ID
        "applicant_id": "2019T3419",
        "money_info": "PHA+c2Rmc2RmPC9wPg0K",
        "moeny_accessory": "dg",
        "moeny_state": 0,
        "moeny_admin": null,
        "apply_time": "2023-04-28",
        "admin_time": null,
        "add_money": 500,
        "nd": 222,
        "applicant_name": "饶育悦",
        "moeny_admin_name": null,
        "key": 6
    }
]
```





# 查看教职工申请的经费详情

请求地址:/index/index/money_look

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明     |
| ------ | ---- | -------- | -------- |
| id     | INT  | T        | 教职工ID |

返回参数:

```

```





# 查看教职工/学生 借阅的书籍

请求地址:/student/index/student_book

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明          |
| ---------- | ---- | -------- | ------------- |
| student_id | INT  | T        | 教职工/学生ID |

返回参数:

```
data:[
    {
        "id": 10,
        "lend_id": "2019T3419",
        "lend_start": "2022-11-25",
        "lend_end": "2022-11-25", //结束时间
        "book_id": 4,//书籍ID
        "lend_state": 0,  //0=已归还   1=未归还
        "user_id": "2019T3419",
        "user_name": "饶育悦",
        "department": "党政办公室",  //所属院系 部门
        "library_name": "茶花女",//书名
        "borrow": 5
    },
]
```





# 教职工获取学生请假申请

请求地址:/student/index/student_book

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明          |
| ---------- | ---- | -------- | ------------- |
| student_id | INT  | T        | 教职工/学生ID |

返回参数:

```
data:[
    {
        "id": 1,//请假申请ID
        "student_id": "2020592P4846702",
        "stundet_class_id": 170,
        "leave_info": "<p>是非得失</p>\r\n", //申请内容
        "leave_accessory": "一个",//标题
        "leave_start": "2022-12-13 00:00:00",//请假开始时间
        "leave_end": "2022-12-29 11:59:59",//请假结束时间
        "leave_class": 0, 
        "state": 1,// 0= 待审批  1=已通过   -1=拒绝
        "leave_admin": "2019T3419",//审批人ID
        "leave_admin_info": null,
        "department_id": 9,
        "class_grade_id": 170,//班级ID
        "specialty_id": 1058,//专业ID
        "student_name": "姚清垚",//申请人姓名
        "student_id_id": "2020592P4846702",//申请人ID
        "num": 1,//第几班级
        "student_class_num": 2020, //年级
        "class_id": 170,
        "sid": 1058,
        "sname": "建筑设计",//专业名称
        "pid": 9,
        "pname": "建筑工程学院", //院系名称
        "key": 5
    },
]
```







# 教职工获取学生请假申请详情

请求地址:/index/index/leavelook

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明       |
| ------ | ---- | -------- | ---------- |
| id     | INT  | T        | 请假申请ID |

返回参数:

```
data:[
{
    "id": 5,
    "student_id": "2020592P4846702",
    "stundet_class_id": 170,
    "leave_info": "<p>是非得失</p>\r\n",
    "leave_accessory": "一个",
    "leave_start": "2022-12-13 00:00:00",
    "leave_end": "2022-12-29 11:59:59",
    "leave_class": 0,
    "state": -1,
    "leave_admin": "2019T3419",
    "leave_admin_info": null
}
]
```





# 教职工审批学生请假申请

请求地址:/index/index/leavelook

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明            |
| ------ | ---- | -------- | --------------- |
| id     | INT  | T        | 请假申请ID      |
| type   | INT  | T        | 1=同意  -1=驳回 |

返回参数:

```

```









# 查看教师一周课程表

请求地址:/teacher/index/my_class_day

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明       |
| ------ | ---- | -------- | ---------- |
| id     | INT  | T        | 请假申请ID |

返回参数:

```
data:[//专业课 公共课
{
    "id": 3,
    "department_id": 7,
    "department_specialty_id": 1045,
    "teacher_id": "2004T1120",
    "specialty_class_id": 435,
    "classroom": "1-310",
    "week": 2,  //第几周
    "class_time": 1,  //第几节课
    "semester": null,
    "class_id": 3, //班级ID
    "nd": 222, //第几年度
    "start_time": 10,  //开始周
    "end_time": 17,  //结束周
    "pid": 7,
    "pname": "计算机与电子信息工程学院",
    "sid": 1045,
    "sname": "计算机应用技术",
    "ke_id": 435,
    "ke_name": "微信小程序开发",
    "num": 1,  //第几班级
    "key": 3
}
]

select :[  //选修课
    {
        "id": 3001,
        "select_class_id": 3001,
        "teacher_id": "2004T1120",
        "place": "2-203", //上课地点
        "week": 5,
        "section": 3,
        "sen_time": 1,  //开始周
        "end_time": 17,//结束周
        "nd": 222,
        "name": "中国语言文学", //课程名称
        "time": 30,
        "grade": 2,  //学分
        "key": 2
    }
]
```





# 学生获取全部请假申请

请求地址:/index/index/Leave

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 学生ID |

返回参数:

```
data:[
    {
        "id": 3, //申请ID
        "student_id": "2020592P4846702",//学生ID
        "stundet_class_id": 170, //班级ID
        "leave_info": "<p>的分公司的分公司的归属地覆盖水电费地方哥哥放</p>\r\n",//申请原因
        "leave_accessory": "dfgdf大范甘迪", //申请标题
        "leave_start": "2022-12-07 00:00:00",  //请假开始时间
        "leave_end": "2022-12-08 11:59:59",//请假结束时间
        "leave_class": 0,
        "state": 1,  // 1=同意  0=待处理  -1=驳回
        "leave_admin": "2004T1120",
        "leave_admin_info": null,
        "student_name": "姚清垚",  //学生姓名
        "user_name": "侯云斯",  //审批人姓名
        "user_id": "2004T1120",
        "key": 3
    }
]
```





# 删除请假申请（学生）

请求地址:/index/index/leave_del

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 申请ID |

返回参数:

```
s
```



# 查看我的班级（学生）

请求地址:/student/index/getclass

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明 |
| ---------- | ---- | -------- | ---- |
| student_id | INT  | T        | ID   |

返回参数:

```
data:[
    {
        "id": 1,
        "student_id": "2020592P4846702",
        "department_id": 9,
        "class_grade_id": 170,
        "specialty_id": 1058,
        "student_name": "姚清垚", //班级学生 
        "student_sex": "男",
        "student_class": 170,
        "student_post_id": 1,
        "student_post_name": "班长",//班级职务
        "student_post_root": 100,
        "stid": "2020592P4846702",
        "key": 1
    },
]
```





# 获取一周课程（学生）

请求地址:/student/index/getclass_day

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明   |
| ---------- | ---- | -------- | ------ |
| student_id | INT  | T        | 学生ID |

返回参数:

```
data:[//专业课 公共课
{
    "id": 3,
    "department_id": 7,
    "department_specialty_id": 1045,
    "teacher_id": "2004T1120",
    "specialty_class_id": 435,
    "classroom": "1-310",
    "week": 2,  //第几周
    "class_time": 1,  //第几节课
    "semester": null,
    "class_id": 3, //班级ID
    "nd": 222, //第几年度
    "start_time": 10,  //开始周
    "end_time": 17,  //结束周
    "pid": 7,
    "pname": "计算机与电子信息工程学院",
    "sid": 1045,
    "sname": "计算机应用技术",
    "ke_id": 435,
    "ke_name": "微信小程序开发",
    "num": 1,  //第几班级
    "key": 3
}
]

select :[  //选修课
    {
        "id": 3001,
        "select_class_id": 3001,
        "teacher_id": "2004T1120",
        "place": "2-203", //上课地点
        "week": 5,
        "section": 3,
        "sen_time": 1,  //开始周
        "end_time": 17,//结束周
        "nd": 222,
        "name": "中国语言文学", //课程名称
        "time": 30,
        "grade": 2,  //学分
        "key": 2
    }
]
```





# 查看我的成绩（学生）

请求地址:/index/index/student_grade

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 学生ID |

返回参数:

```
data:[
    {
        "id": 515,
        "semester": 222, //年度
        "specialty_class_id": 515,
        "student_class_id": 170,
        "one_grade": 80, //正考成绩
        "two_grade": null,//补考成绩
        "student_id": "2020592P4846702",
        "name": "建筑材料", //课程名称
        "key": 18
    }
]
```







# 查看我的选修课（学生）

请求地址:/index/index/student_grade

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 学生ID |

返回参数:

```
data:[
    {
        "id": 3001,
        "student_id": "2020592P4846702",
        "select_class_info_id": 2,
        "student_class": 170,
        "nd": 222,
        "select_class_id": 3001,
        "teacher_id": "2004T1120",
        "place": "2-203",
        "week": 5,
        "section": 3,
        "sen_time": 1,
        "end_time": 17,
        "name": "中国语言文学",
        "time": 30,
        "grade": 2,
        "teacher_name": "侯云斯",
        "key": 23  //我的选修课ID
    } 
]
class:[//全部(未选/已选)的选修课
{
    "id": 3001,
    "select_class_id": 3001,
    "teacher_id": "2018T1295",
    "place": "2-204",
    "week": 2,
    "section": 1,
    "sen_time": 1,
    "end_time": 17,
    "nd": 222,
    "name": "中国语言文学",
    "time": 30,
    "grade": 2,
    "teacher_name": "桑商黎",
    "key": 1  //选修课ID 也就是次课程ID
}
]
```



# 退选 选修课（学生）

请求地址:/index/index/del_select_class

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明         |
| ------ | ---- | -------- | ------------ |
| id     | INT  | T        | 我的选修课ID |

返回参数:

```
{
    "msg": "退课成功",
    "code": 200
}
```



# 添加 选修课（学生）

请求地址:/index/index/add_select_class

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明     |
| ------ | ---- | -------- | -------- |
| id     | INT  | T        | 选修课ID |

返回参数:

```
{"msg":"课程冲突请重新选择","code":310}
{
    "msg": "添加成功",
    "code": 200
}
```









# 查看我的处分（学生）

请求地址:/student/index/student_punishment

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明   |
| ---------- | ---- | -------- | ------ |
| student_id | INT  | T        | 学生ID |

返回参数:

```
data:[
    {
        "sid": "2020592P4846702",
        "info": "水电费",//处分内容
        "stundet_tf": 1,
        "admin": null,
        "admin_tf": 0,
        "epilogue": null,
        "disciplinary_sanction_id": 0,
        "clan_sanction_id": null,
        "fujian": "16706545211562504366.jpeg,",//处分附件
        "add_time": "2022-12-10",//处分发起时间
        "end_time": null,
        "title": "胜多负少的", //处分标题
        "send_id": "2019T3419",  //处分发起人ID
        "key": 11, //处分ID
        "id": 1,
        "student_id": "2020592P4846702", //被处理人ID
        "student_name": "姚清垚",
        "student_sex": "男",
        "student_site": "四川省甘孜藏族自治州",
        "student_card": "151471555601945365",
        "student_iphone": 18155973409,
        "student_politics": 2,
        "student_state": 0,
        "student_time": "2020-09-01",
        "student_age": "2002-05-06",
        "state": null,
        "sids": "2020592P4846702",
        "class_grade_id": 170,
        "specialty_id": 1058,
        "ssspppid": 9,
        "pid": 9,
        "pname": "建筑工程学院",
        "dpisd": 1058,
        "department_id": 9,
        "name": "建筑设计",
        "teacher_id": null,
        "teacher_name": null,
        "send_name": "饶育悦", //处分发起人
        "ppid": null,
        "sciplinary_name": null,
        "disciplinary_day": null,
        "disciplinary_sanction_root": null,
        "ts": null
    }
]
```





# 查看我的处分详情（学生）

请求地址:/student/index/student_punishment

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明   |
| ---------- | ---- | -------- | ------ |
| student_id | INT  | T        | 学生ID |
| id         | INT  |          |        |

返回参数:

```
data:[
    {
        "sid": "2020592P4846702",
        "info": "水电费",//处分内容
        "stundet_tf": 1,
        "admin": null,
        "admin_tf": 0,
        "epilogue": null,
        "disciplinary_sanction_id": 0,
        "clan_sanction_id": null,
        "fujian": "16706545211562504366.jpeg,",//处分附件
        "add_time": "2022-12-10",//处分发起时间
        "end_time": null,
        "title": "胜多负少的", //处分标题
        "send_id": "2019T3419",  //处分发起人ID
        "key": 11,
        "id": 1,
        "student_id": "2020592P4846702", //被处理人ID
        "student_name": "姚清垚",
        "student_sex": "男",
        "student_site": "四川省甘孜藏族自治州",
        "student_card": "151471555601945365",
        "student_iphone": 18155973409,
        "student_politics": 2,
        "student_state": 0,
        "student_time": "2020-09-01",
        "student_age": "2002-05-06",
        "state": null,
        "sids": "2020592P4846702",
        "class_grade_id": 170,
        "specialty_id": 1058,
        "ssspppid": 9,
        "pid": 9,
        "pname": "建筑工程学院",
        "dpisd": 1058,
        "department_id": 9,
        "name": "建筑设计",
        "teacher_id": null,
        "teacher_name": null,
        "send_name": "饶育悦", //处分发起人
        "ppid": null,
        "sciplinary_name": null,
        "disciplinary_day": null,
        "disciplinary_sanction_root": null,
        "ts": null
    }
]
```



# 是否接受该处分（学生）

请求地址:/student/index/student_puntf

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明             |
| ---------- | ---- | -------- | ---------------- |
| student_id | INT  | T        | 处分ID 是处分ID  |
| type       | INT  | T        | 1=接收   -1=反驳 |

返回参数:

```

```





# 查看我的宿舍报修记录（学生）

请求地址:/student/index/dorm_look

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明             |
| ---------- | ---- | -------- | ---------------- |
| student_id | INT  | T        | 处分ID 是处分ID  |
| type       | INT  | T        | 1=接收   -1=反驳 |

返回参数:

```
{
    "id": 15,
    "dorop_num": 3,  //楼栋号
    "maintain_info": "PHA+ZmdoZGZnaGZnaDwvcD4NCg==", 
    "accessory": "202",  //宿舍号
    "student_id": "2020592P4846702",
    "state": 1,  //1=已处理 -1=报上级   0=待处理
    "sen_time": "2022-12-10",  //申请时间
    "end_time": "2023-04-26", //结束时间
    "title": "fghfghfgh",  //标题
    "admin": "2019T3419",  //处理人ID
    "student_name": "姚清垚",
    "ssid": "2020592P4846702",
    "key": 15
}
```





# 删除我的宿舍报修记录（学生）

请求地址:/student/index/del_dorm_x

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 报修ID |

返回参数:

```

```





# 添加宿舍报修（学生）

请求地址:/student/index/end_dorm

请求方式：post

请求参数:

| 参数名        | 类型   | 是否必须 | 说明   |
| ------------- | ------ | -------- | ------ |
| maintain_info | INT    | T        | 内容   |
| dorop_num     | String | T        | 楼栋号 |
| accessory     | String | T        | 宿舍号 |
| student_id    | String | T        | 学生ID |
| title         | String | T        | 标题   |

返回参数:

```
S
```





# 获取所有的宿舍楼栋及宿舍号

请求地址:/student/index/end_dorm

请求方式：get

请求参数:

返回参数:

```
data:[
    label: 1  //楼栋号
    value: 1
    children:[//宿舍号
        {
        "label": 201,
        "value": 201
    	}
    ]
]
```







# 查看我的请假申请（学生）

请求地址:/index/index/Leave

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 学生ID |

返回参数:

```
data:[
{
    "id": 4,
    "student_id": "2020592P4846702",
    "stundet_class_id": 170,
    "leave_info": "<p>512313123123132132132</p>\r\n", 
    "leave_accessory": "415123123", /标题
    "leave_start": "2022-12-07 00:00:00",//开始时间
    "leave_end": "2022-12-07 11:59:59",//结束时间
    "leave_class": 0,  //0=请假  1=销假
    "state": 1, //0=待处理  1=同意  -1=驳回
    "leave_admin": "2020592P4846702", //处理人ID
    "leave_admin_info": null,
    "student_name": "姚清垚",//学生姓名
    "user_name": "姚清垚",//处理人姓名
    "user_id": "2020592P4846702",
    "key": 4
}
]
```





# 删除 请假申请（学生）

请求地址:/index/index/leave_del

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明       |
| ------ | ---- | -------- | ---------- |
| id     | INT  | T        | 请假申请ID |

返回参数:

```

```





# 获取请销假申请所对应的审批人（学生）

请求地址:/index/index/leave_add_look

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明   |
| ------ | ---- | -------- | ------ |
| id     | INT  | T        | 学生ID |

返回参数:

```
[
    {
        "id": 5,
        "class": 1,
        "leave_root": 0,
        "day": 1, //请销假所对应天数 权限  1天审批权限
        "root_id": null,
        "name": "班长",
        "root": null,
        "user_name": "姚清垚",
        "user_id": "2020592P4846702"
    },
    {
        "id": 1,
        "class": 0,
        "leave_root": 10,
        "day": 2, //2天审批权限
        "root_id": 10,
        "name": "辅导员",
        "root": 6,
        "user_name": "侯云斯",
        "user_id": "2004T1120"
    },
]
```





# 新增请销假申请（学生）

请求地址:/index/index/leave_add

请求方式：post

请求参数:

| 参数名          | 类型     | 是否必须 | 说明            |
| --------------- | -------- | -------- | --------------- |
| student_id      | INT      | T        | 学生ID          |
| leave_info      | String   | T        | 申请内容        |
| leave_accessory | String   | T        | 申请标题        |
| leave_class     |          | T        | 0=请假   1=销假 |
| leave_admin     | String   | T        | 审批人ID        |
| leave_start     | DATETIME | T        | 请销假开始时间  |
| leave_end       | DATETIME | T        | 请销假结束时间  |

返回参数:

```
s
```





# 获取请销假职务所对应批准天数

请求地址:/index/index/Leaveset

请求方式：get

请求参数:

返回参数:

```
data:[
    {
        "id": 5, //所对应的条目ID
        "class": 1, //0=请假  1=销假
        "leave_root": 0,  
        "day": 1, //天数
        "root_id": null,
        "name": "班长",//职务名称
        "root": null,
        "key": 5
    }
]
post:[
    {
        "value": 1,//职务ID
        "label": "校长"
    }
]
```





# 修改假职务所对应批准天数，类型

请求地址:/index/index/Leaveset

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明                                           |
| ---------- | ---- | -------- | ---------------------------------------------- |
| type       | INT  | T        | 对应条目的ID                                   |
| class      | INT  | T        | 0=请假  1=销假                                 |
| day        | INT  | T        | 所批准天数                                     |
| leave_root | INT  | T        | 对应条目的leave_root字段  职务ID  班长职务ID=0 |

返回参数:

```

```







# 删除该职务的审批假权限

请求地址:/index/index/del_leave_del

请求方式：get

请求参数:

| 参数名 | 类型 | 是否必须 | 说明         |
| ------ | ---- | -------- | ------------ |
| id     | INT  | T        | 对应条目的ID |

返回参数:

```

```





# 添加该职务的审批假权限

请求地址:/index/index/add_leave_day

请求方式：get

请求参数:

| 参数名     | 类型 | 是否必须 | 说明                  |
| ---------- | ---- | -------- | --------------------- |
| type       | INT  | T        | 0=新增  1=添加        |
| class      | INT  | T        | 0=请假  1=销假        |
| day        | INT  | T        | 请销假天数 (审批权限) |
| leave_root | INT  | T        | 职务ID  班长ID=0      |

返回参数:

```

```

