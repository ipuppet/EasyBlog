# EasyBlog
>一个简易的个人博客模板

### 开始使用
将项目文件下载到你的设备当中，其中：  
`vender`  
`public/static/library/editormd`  
这两个目录不是必须从这里下载（不过直接从这里下载会更方便），`vender`中的项目使用composer安装即可。（该项目中存在composer.json）
`public/static/library/editormd`是一个开源的markdown编辑器，地址：[Editor.md](https://pandao.github.io/editor.md/)

接下来，`easyblog_db.sql`中有创建相关数据库的sql语句，其实我们只需要一张article表就行了。
这里要注意：字符集改为`utf8mb4`  
数据库建好以后，里面可能是空的，这时我们的页面可能会显示不正常，我们需要添加几篇文章进去。  
在EasyBlog目录中，运行以下命令：（当然你需要给console文件一些必备的权限）  
`php console admin add`  
它会帮助你添加一个管理员，用来登陆我们的后台进行内容管理（管理员的头像暂时不能通过admin.json文件进行配置，如果你喜欢，在`public/static/images/`目录中添加一个1.jpg，这就是模板中的头像图片的路径）  

#### 我们更改一些信息
在`app/config/data.json`中，有一个about，它的name属性的值将会呈现在博客首页的最上方位置（就是那句Welcome To XXX's Blog）XXX就是这个值，页脚的爱心后面也是这个值 

所必须的配置文件：
路径：`app/config`

database.php

    return array(
        'database' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'dbname' => 'Blog',
        'username' => 'username',
        'password' => 'password',
        'charset' => 'utf8mb4'
    );
    
data.json

    {
      "about": {
        "name": "your name",
        "motto": "一个人至少拥有一个梦想，有一个理由去坚强。心若没有栖息的地方，到哪里都是在流浪。"
      },
      "banners": [
        {
          "title": "梦想",
          "url": "#",
          "abstract": "一个人至少拥有一个梦想，有一个理由去坚强。心若没有栖息的地方，到哪里都是在流浪。",
          "background": "#ffa158"
        }
      ],
      "tags": [
        "Linux",
        "杂谈",
        "Java"
      ]
    }
    
admin.json(该文件内容请按照下面内容填写，只有一对方括号，其他内容通过console添加)

    [
    ]


如果你不喜欢默认的页面样式，可以在`app/templates`中进行修改。当然，如果你在其他位置（既不是这个目录和它原来存在的子目录，你在这新建的子目录也不行）存在模板文件，需要在  
`app/config/twig.php`的templates中加上你的目录。这里面的目录是以app这个目录为起点开始的。
### 技术文档
[请看这里](./doc.md)