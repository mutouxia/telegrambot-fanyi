<?php

//私聊(private) 群组(supergroup)
$type = $update['message']['chat']['type'];
//群组名称
$group_title = $update['message']['chat']['title'] ?: '';
//群组id
$group_username = $update['message']['chat']['username'] ?: '';
//若为群组，则为群组唯一ID，个人，个人唯一ID
$chat_id = $update['message']['chat']['id'];
//消息ID
$message_id = $update['message']['message_id'];
//转发ID
$reply_to_message = $update['message']['reply_to_message']['message_id'] ?: '';
//转发原文
$reply_text = $update['message']['reply_to_message']['text'] ?: '';
//language_code
$language_code = $update['message']['from']['language_code'] ?: '';
//text文本消息
$text = $update['message']['text'];
//用户唯一ID
$user_id = $update['message']['from']['id'] ?: '';
//TG机器人
$tgbot = $update['message']['from']['is_bot'];
//用户昵称
$first_name = $update['message']['from']['first_name'] ?: '';
//用户名:群组里At其他人
$username = $update['message']['from']['username'] ?: '';
//时间戳
$date = $update['message']['date'];
//curl请求
function curl($cmd, $data) {
    $url = 'https://api.telegram.org/bot' . BOT_TOKEN . '/' . $cmd . '?' . http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3314.0 Safari/537.36 SE 2.X MetaSr 1.0');
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    TG_BOT_LOG($ret); //日志
    return $ret;
}
//翻译
function fanyi($text, $to = 'zh-CN') {
    $entext = urlencode($text);
    $url = 'https://translate.google.cn/translate_a/single?client=gtx&dt=t&ie=UTF-8&oe=UTF-8&sl=auto&tl=' . $to . '&q=' . $entext;
    set_time_limit(0);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.81 Safari/537.36 SE 2.X MetaSr 1.0');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    if (!empty($result)) {
        foreach ($result[0] as $k) {
            $v[] = $k[0];
        }
        return implode(" ", $v);
    }
}
//日志
function TG_BOT_LOG($sendmessage) {
    global $update;
    $group_title = $update['message']['chat']['title'] ?: '';
    $group_username = $update['message']['chat']['username'] ?: '';
    $data_file = ROOT_PATH . '/data/log/' . date('y-m-d', time()) . '.log.txt'; //log文件
    if (!$group_title) {
        //群组标题为空代表为私聊
        $group_username = '';
    }
    $log = ['type' => $update['message']['chat']['type'], //聊天类型
    'group' => ['name' => $group_title, 'uid' => $group_username, //群组ID
    ], 'user' => ['name' => $update['message']['from']['first_name'], //用户昵称
    'id' => $update['message']['from']['id'], //唯一不变
    'uid' => $update['message']['from']['username'], //用户随意更改
    ], 'message_id' => $update['message']['message_id'], //消息ID
    'uptime' => $update['message']['date'], //时间
    'send' => json_decode($sendmessage, true) , ];
    $log = json_encode($log, JSON_UNESCAPED_UNICODE);
    file_put_contents($data_file, $log . "\r\n", FILE_APPEND);
}

