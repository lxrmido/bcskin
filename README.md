# bcskin

## 概述

![Bilicraft](http://bbs.bilicraft.io/s/static/public/img/title.png)

这是一个minecraft第三方服务器的皮肤资源管理系统

本项目不包含皮肤MOD，请自行下载UniSkinMod等皮肤MOD

随着碧玺六周目的华丽开启，皮肤站也迎来了重建

（本项目与2012年托管于GoogleCode并发布于mcbbs上的bcskin只有名字上的关联，实际代码完全不一样，无法平滑升级）

（由于GoogleCode已关闭，期间本人进入了黑砖窑不问世事，因此也没代码的备份，也不想再看回年轻时写的代码）

（维护此项目也算是填上自己挖过的坑）

（PHP代码大规模采用了逼OOP为过程化的写法，OOP原教旨主义者阅读本代码可能会有不适）

（dev目录中把gulp等编译工具也完整打包进去了，是故意的）

 (dev/doc中本应包含设计文档、接口文档等，由于某些原因，暂时不提供)

[bilicraft](http://bbs.bilicraft.io)


## 运行截图

![login](http://i.imgur.com/vMdfejo.jpg)

![manage](http://i.imgur.com/4YdmD2X.jpg)

![admin](http://i.imgur.com/OaGZYLc.jpg)

## 本项目将会完成的内容:

*  1.7.X 及以下版本的皮肤和披风管理系统 （已完成）
*  1.8 + 的皮肤管理系统 （计划中）
*  UniSkinAPI （已完成）
*  可以通过discuz来登录本系统 （已实现）
*  皮肤分享、评论功能 （计划中）
*  1.7.x 皮肤与 1.8.x 皮肤在线转换功能 （开发中）

后续开发不会影响正在使用的功能及数据，可平滑升级

## 服务器环境需求

*  PHP 5.4+
*  PHP需要有PDO模块及GD库
*  MySQL，并支持Innodb

## 浏览器需求

*  IE 11+ 、Chrome 20+ 、Firefox 9+ 、Safari 9+ 

## 如何使用

1.  首先，请clone本repo
2.  创建目录 data/log 及cache目录，并保证这两个目录可写
3.  创建一个数据库，并导入dev/alpha.sql中的内容
4.  复制 module/public/conf/config.sample.php 为 module/public/conf/config.php，并打开这个文件编辑配置

## 皮肤文件路径？
1.  皮肤文件为：data/skin/玩家名.png
2.  披风文件为：data/cape/玩家名.png
3.  UniSkinAPI的JSON文件：data/uniskin/玩家名.json
4.  UniSkinAPI的texture目录：data/texture

## 如何配置通过Discuz！进行登录？

1.  复制一份dev/bcs.php到DZ论坛根目录
2.  编辑DZ的bcs.php 及 module/public/conf/config.php，使 BCS_LOGIN_KEY 与 DISCUZ_BCS_LOGIN_KEY一致，并使 BCS_LOGIN_API 和 DISCUZ_BCS_URL 分别指向皮肤站和论坛


## 最后备注

1.  万一有一天需要把数据迁移到其他皮肤站程序去，依靠data下简单的目录结构和user_basic表能完成的
2.  由于PHP框架其实并不是一个框架，任意PHP程序员都能读懂其中的PHP代码
3.  同上，JS方面，没有使用任何框架，只引入了jQuery和自行开发的UI库，修改起来是比较简单的
4.  假如你要修改样式又不接受less，在不编译less的前提下，只修改css也是可以的
5.  本项目将计划集成dz以外的更多开源程序的登陆实现，欢迎提出建议
6.  本项目是碧玺的衍生项目，大概不会更新碧玺站点的可能引发安全问题的其他功能
7.  以上是总结在本repo添加README前收到的邮件的回答

## 特别鸣谢

1.  碧玺的全体同仁
2.  以往碧玺的全体同仁
3.  数年前提出构想并提供修改建议的kelas、icrdr、只剩下毛的雪狼等

