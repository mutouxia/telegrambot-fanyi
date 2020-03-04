<?php
//私聊模式

if ($reply_text) {
    //回复模式
    if ($language[$text]) {
        //如果包含翻译指令
        $to = $language[$text];
        $text = $reply_text;
    } else {
        $text = '您需要翻译的语言暂时不支持！请查看支持的语言(/default)';
    }
}
if ($cmd) {
    // /开头的命令
    include ROOT_PATH . '/control/private_cmd.php';
} else {
    $text = fanyi($text, $to); //翻译
    
}
//组成信息
$to_chat = array(
    'chat_id' => $chat_id,
    "text" => $text,
);
//发送信息
$sendmessage = curl('sendmessage', $to_chat);

