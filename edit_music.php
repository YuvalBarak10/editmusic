<?php

ob_start();

define('API_KEY','[854466744:AAEzwrtA5D9DMXObuNg5e-W_6nVxaB266C0]');
$admin = "125858918";
$admin2 = "93161337";
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$boolean = file_get_contents('booleans.txt');
$booleans= explode("\n",$boolean);
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$editm = $update->edited_message;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$fname = $message->chat->first_name;
$uname = $message->chat->username;
$text1 = $message->text;
$audio=$message->audio;
$afile_id=$audio->file_id;
$fadmin = $message->from->id;
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$reply = $update->message->reply_to_message->forward_from->id;
$forward = $update->message->forward_from;
$query=$update->callback_query;
$inline=$update->inline_query;
$channel_forward = $update->channel_post->forward_from;
$channel_text = $update->channel_post->text;
$messageid = $update->callback_query->message->message_id;
$reply = $update->message->reply_to_message;
mkdir("data");
mkdir("data/$fadmin");
$step=file_get_contents("data/$fadmin/one.txt");
$keyhome=json_encode([
	'keyboard'=>[
	[['text'=>"הגדר את הנושא ושם הזמר"]],
	[['text'=>"עריכת מוסיקה"]]
	]
	]);
	$key2=json_encode([
		'resize_keyboard'=>true,
		'keyboard'=>[
		[['text'=>"הגדר את הנושא"]],
		[['text'=>"קבע את שם הזמר"]],
		[['text'=>"חזרה לתפריט הראשי"]]
		]
		]);
if($text1=="/start"){
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"שלום, ברוך הבא. 🌹 \ n \ n אתה יכול לשנות את הנושא ואת שמו של זמר המוזיקה ל ‌ רצוי עם הרובוט הזה \ n כדי להתחיל מכפתור הגדרת הנושא ולבצע את שם ההגדרות",
	'reply_markup'=>$keyhome
	]);
	}elseif($text1=="התאם את הנושא ואת שם הזמר"){
		bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"אנא בחר אפשרות מהלחצנים למטה",
		'reply_markup'=>$key2,
		]);
		
		}elseif($text1=="חזרה לתפריט הראשי"){
			bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>"به منوی اول بازگشتید",
			'reply_markup'=>$keyhome,
			]);
			}elseif($text1=="تنظیم موضوع"){
				file_put_contents("data/$fadmin/one.txt","moz");
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"لطفا موضوع آهنگ رو بفرستید",
				'reply_markup'=>json_encode([
				'resize_keyboard'=>true,
				'keyboard'=>[
				[['text'=>"برگشت به منوی قبلی↪"]]
				]
				])
				]);
				}elseif($step=="moz"){
					file_put_contents("data/$fadmin/one.txt","null");
				if($text1=="برگشت به منوی قبلی↪"){
						file_put_contents("data/$fadmin/one.txt","null");
						bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"به منوی قبل برگشتید↪",
					'reply_markup'=>$key2,
					]);			
						}else{
							file_put_contents("data/$fadmin/moz.txt","$text1");
							file_put_contents("data/$fadmin/one.txt","null");
						bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"موضوع آهنگ با موفقیت ذخیره شد✅",
					'reply_markup'=>$key2,
					]);		
						}
		}elseif($text1=="تنظیم نام خواننده"){
				file_put_contents("data/$fadmin/one.txt","nam");
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"لطفا نام خواننده رو وارد کنید",
				'reply_markup'=>json_encode([
				'resize_keyboard'=>true,
				'keyboard'=>[
				[['text'=>"برگشت به منوی قبلی↪"]]
				]
				])
				]);
				}elseif($step=="nam"){
					file_put_contents("data/$fadmin/one.txt","null");
				if($text1=="برگشت به منوی قبلی↪"){
						file_put_contents("data/$fadmin/one.txt","null");
						bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"به منوی قبل برگشتید↪",
					'reply_markup'=>$key2,
					]);			
						}else{
							file_put_contents("data/$fadmin/nam.txt","$text1");
							file_put_contents("data/$fadmin/one.txt","null");
						bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"نام خواننده با موفقیت ذخیره شد✅",
					'reply_markup'=>$key2,
					]);		
						}
		}elseif($text1=="ادیت موزیک"){
			$moz=file_get_contents("data/$fadmin/moz.txt");
			$nam=file_get_contents("data/$fadmin/nam.txt");
			if($nam==null && $moz==null){
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"قسمت موضوع و نام خواننده خالی میباشد\nلطفا تمام مشخصات تکمیل و بعد به زدن این دکمه بکنید🚫",
				'reply_markup'=>$keyhome,
				]);
				
				}elseif($moz==null){
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"قسمت موضوع تکمیل نیست🚫",
				'reply_markup'=>$keyhome,
				]);
				}elseif($nam==null){
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"قسمت نام خواننده تکمیل نشده⛔",
				'reply_markup'=>$keyhome,
				]);
				}else{
				file_put_contents("data/$fadmin/one.txt","hang");
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"لطفا آهنگتون رو بفرستید \nفرمت آهنگ باید حتما mp3'باشد",
				'reply_markup'=>json_encode([
				'resize_keyboard'=>true,
				'keyboard'=>[
				[['text'=>"برگشت به منوی قبلی↪"]]
				]
				])
				]);
				
				}
			}elseif($step=="hang"){
			if($text1=="برگشت به منوی قبلی↪"){
						file_put_contents("data/$fadmin/one.txt","null");
						bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"به منوی قبل برگشتید↪",
					'reply_markup'=>$keyhome,
					]);			
					}elseif(isset($message->audio)){
						$nam=file_get_contents("data/$fadmin/nam.txt");
						$moz=file_get_contents("data/$fadmin/moz.txt");
						
						file_put_contents("data/$fadmin/one.txt","null");
		$url = json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY.'/getFile?file_id='.$afile_id),true);
					$path=$url['result']['file_path'];
 $file = 'https://api.telegram.org/file/bot'.API_KEY.'/'.$path;
		file_put_contents("data/$fadmin/test.mp3",file_get_contents($file));
		bot('sendaudio',[
		'chat_id'=>$chat_id,
		'audio'=>new CURLFile("data/$fadmin/test.mp3"),
		'title'=>$moz,
		'performer'=>$nam,
		'reply_markup'=>$keyhome,
		]);
		}else{
		bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"این یک آهنگ با فرمت mp3'نیست⛔\nلطفا دوباره سعی کنید!!!",
				'reply_markup'=>json_encode([
				'resize_keyboard'=>true,
				'keyboard'=>[
				[['text'=>"برگشت به منوی قبلی↪"]]
				]
				])
				]);
		
		}
		}

?>
