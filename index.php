<?php

define('ROOT_PATH', dirname(__FILE__));
require ROOT_PATH . '/config.php';

//是否为机器人Token
if (isset($_GET['token'])) {
	
	//如果需要设置回调
	//第一次请访问:https://你的域名/?setWebhook=1&token=token
	if (isset($_GET['setWebhook'])) {
		$res = array('url' => "https://{$_SERVER['SERVER_NAME']}/?token={$_GET['token']}");
		$res = curl('setWebhook', $res);
		if ($res) {
			echo 'Tg setWebhook设置成功!';
		} else {
			echo 'Tg setWebhook设置失败!';
		}
		exit();
	}
	
	
    //判断是否存在默认语言
    $user_lang = ROOT_PATH . '/data/user/' . $user_id . '.txt';
    $lang_user_name = '中文'; //系统默认
    $to = $language[$lang_user_name]; //系统默认翻译
    if (file_exists($user_lang)) {
        $lang_user_name = file_get_contents($user_lang); //读取用户设置
        $to = $language[$lang_user_name]; //用户设置语言
        
    }
    $type_name = array('supergroup', 'private');
	
    if (!$tgbot AND in_array($type, $type_name)) {
        //不是机器人 并且为私聊或者群组
        $user_cmd = mb_substr($text, 0, 1, 'utf-8');
        if ($user_cmd == '/') {
            // /TG命令模式
            $cmd = str_replace('/', "", $text);
            $cmd = strtolower(trim($cmd)); //全部小写，并且去除空格以及特殊符号
            
        }
        if (!$language[$text] AND $user_cmd != '/') {
            //翻译模式
            $lang_cmd = strtolower(mb_substr($text, 0, 2, 'utf-8'));
            if ($lang_cmd == '翻译') {
                //检测是否为翻译命令
                //preg_match("/翻译(.*?)\//is", $text.'/',$user_cmd);
                $user_lang = str_replace('翻译', "", $text);
                $user_lang = strtolower(trim($user_lang));
                if ($language[$user_lang]) {
                    $lang = $to = $language[$user_lang];
                }
            }
        } 
		if ($language[$text] AND $user_cmd != '/') {
            //直接语言回复模式
            $lang = $to = $language[$text];
        }
        include ROOT_PATH . '/control/' . $type . '.php';
    }
}

