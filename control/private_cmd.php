<?php
//私聊时使用的命令
	
// /开头的命令循环
switch ($cmd) {
   case "start":
     $text=$bot_name."( ".$bot_id." )\n现在支持\"任意\"语言\n翻译为以下8种语言：\n    中文、英文、韩语、日语、德语、俄语、法语、菲律宾语\n如有更多建议，或者需要更多的语言，请进入群组 @fanyitest 反馈！\n 以下为所支持的命令! \n /help 帮助中心 \n /default 设置默认语言 ";
     break;
   case "help":
     $text="在群组中：\n（仅支持回复模式，或者直接转发给机器人）\n1.需要长按回复时\n2.在输入框写入\n  [要翻译的语言(汉语或英语)]\n 例如输入: 中文\n \n在私聊时：\n(支持转发、回复、直接发送私聊)三种方式\n1.转发：\n     转发给机器人会直接返回你默认( /default )的翻译语言\n2.回复：\n      和群组里的操作一样\n3.直发:\n       直接发送文本给机器人，它会根据您所默认( /default )的语言进行翻译";
     break;
   case "default":
     $text="请输入默认语言(请选择):\n当前语言为".$lang_user_name."\n(此项在您给我转发消息时,回复消息是的默认翻译语言)\n /Chinese (中文) \n /English (英语) \n /Korean (韩语) \n /Japanese (日语) \n /Deutsch (德语) \n /Russian (俄语) \n /French (法语) \n /Filipino (菲律宾语)";
     break;
   case "about":
     $text="一款TG端的翻译机器人\n出生于2020/02/20";
     break;
   case "chinese":
   case "english":
   case "korean":
   case "japanese":
   case "deutsch":
   case "russian":
   case "french":
   case "filipino":
	 file_put_contents(ROOT_PATH .'/data/user/'.$user_id.'.txt', $cmd);
	 $text ='已为您保存设置(默认语言:'.$cmd.')，如需更改请重新设置(/default)。';
     break;
   default:
     $text ="您输入的命令不存在，请点击(/start)获取介绍和所有指令。";
}