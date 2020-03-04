<?php
//群组模式

if(!is_null($reply_to_message)){
	
	//群组回复
	if($user_lang){
		$reply_text=explode("\n @", $reply_text);//去除已经翻译后At的人
					
		$fanyi=fanyi($reply_text['0'],$to);//翻译结果
					
		//组成信息
		$to_chat=array(
			'chat_id' => $chat_id,
			"text" => $fanyi."\n @".$username,
			//"reply_to_message_id" => $message_id,
		);
		//发送信息
		$sendmessage = curl('sendmessage', $to_chat);	
	}
	
}
