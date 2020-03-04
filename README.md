# telegrambot-fanyi
电报(telegram)翻译机器人 
群组https://t.me/fanyitest
机器人id: @fanxiaoyi

1.首次安装请按照一下规则手动访问一次链接！
  第一次请访问:https://你的域名/?setWebhook=1&token=输入你的token
  
2.将你的机器人Token放到config.php中的第五行里。

3.修改config.php里的机器人ID、名称

【注意：翻译接口使用的是谷歌接口，
有时会因为谷歌拦截问题翻译失败或者空白！】


ok大功告成。
代码写的不好请见谅！谢谢


目录介绍

/control/            
/control/function.php       ****核心文件
/control/private.php        ****私聊
/control/private_cmd.php    ****私聊命令
/control/supergroup.php     ****群聊


/data/
/data/log/                ****网站日志，每天生成一个文件请及时清理
/data/user/               ****存储用户默认语言

/config.php          ****核心设置
/index.php           **** 首页
