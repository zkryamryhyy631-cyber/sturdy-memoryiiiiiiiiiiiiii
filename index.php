<?php

ob_start();
$token = "00000";
define("API_KEY", $token);
$admin = "00000";

$admins = $bot['admins'];
$domin = $_SERVER['HTTP_HOST'];

function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}

function callAPI($action, $channel_id, $user_id = null, $number = 1) {

    $api_url = 'https://abdomoh.serv00.net/api/eshterak_api.php'; 

    $data = [
        'action' => $action,
        'channel_id' => $channel_id,
    ];

    if ($action === 'check' && $user_id !== null) {
        $data['user_id'] = $user_id;
    }

    if ($action === 'link') {
        $data['number'] = $number;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    if (curl_error($ch)) {
        return ['error' => curl_error($ch)];
    }

    curl_close($ch);
    return json_decode($response, true);
}


function send_message($message, $from_id, $tk) {
    $url = "https://api.telegram.org/bot" . $tk . "/sendMessage?chat_id=" . $from_id;
    $url .= "&text=" . urlencode($message);
    $url .= "&parse_mode=markdown"; 
    file_get_contents($url);
}

function abdo2() {
    global $chat_id, $message_id, $folder, $upload, $check;
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145)
⎋ اهلا بك في الاعدادات الخاصه ببوت الرفع
⚙️ — — — — — — — — — — — ⚙️
",
        'parse_mode'=>"MARKDOWN",
        'reply_markup'=>json_encode([ 
            'inline_keyboard'=>[
                [['text'=>"فحص الملفات " . $check,'callback_data'=>"check"]],
                [['text'=>"رفع الملفات " . $upload,'callback_data'=>"upload"]],
                [['text'=>"انشاء فولدرات " . $folder,'callback_data'=>"folder"]],
                [['text'=>'• المحظورين من الرفع  • ','callback_data'=>"banall" ]],
                [['text'=>'عدد ملفات' ,'callback_data'=>"numberfiles"],
                ['text'=>'عدد تحذيرات' ,'callback_data'=>"numberban"]],
                [['text'=>'• الاعدادات العامه •' ,'callback_data'=>"bot"]]
            ]
        ])
    ]);
}





function checkConditions($f) {
    global $from_id, $admin;
    $output = false;

    if ($from_id != $admin) {
        $conditions = [
            "/H3K/",
            "/public function create/",
            '/(.*)ZipArchive(.*)/i',
            '/(.*)zip(.*)/i',
            '/(.*)eval(.*)/i',
            '/(.*)file_put_contents(.*)/i',
            '/(.*)file_get_contents(.*)/i',
            '/(.*)echo(.*)/i',
            '/(.*)base64_decode(.*)/i',
            '/(.*)Hack Tool Hosting(.*)/i',
            '/(.*)\.htaccess(.*)/i',
            '/(.*)pantheonsite.io(.*)/i',
        ];

        $matches = [];
        foreach ($conditions as $key => $pattern) {
            preg_match($pattern, $f, $matches[$key]);
        }

        if (
            ($matches[0] && $matches[1]) || ($matches[2] && $matches[3]) || 
            $matches[4] || 
            $matches[9] || $matches[10] || $matches[11]
        ) {
            $output = true;
        }
    }
    return $output;
}




date_default_timezone_set('Africa/Cairo');
$bloktime = date('h:i');
$period = date('a');
if ($period == 'am') {
    $period = 'صبـاحًا';
} else {
    $period = 'مسـاءًا';
}
$bloktime .= ' ' . $period;

$update = json_decode(file_get_contents('php://input'));

$bot_id = bot("getme")->result->id;
$bot_user = bot("getme")->result->username;
$bot_name = bot("getme")->result->first_name;

$message = $update->message ?? null;
$callback_query = $update->callback_query ?? null;

$message_id = $message->message_id ?? $callback_query->message->message_id ?? null;
$username = $message->from->username ?? $callback_query->from->username ?? null;
$chat_id = $message->chat->id ?? $callback_query->message->chat->id ?? null;
$title = $message->chat->title ?? $callback_query->message->chat->title ?? null;
$text = $message->text ?? $callback_query->message->text ?? null;
$photo = $message->photo ?? null;
$voice = $message->voice ?? null;
$audio = $message->audio ?? null;
$video = $message->video ?? null;
$document = $message->document ?? null;
$sticker = $message->sticker ?? null;
$caption = $message->caption ?? null;
$name = $message->from->first_name ?? $callback_query->from->first_name ?? null;
$from_id = $message->from->id ?? $callback_query->from->id ?? null;
$type = $message->chat->type ?? null;

$reply = $message->reply_to_message ?? null;
$reply_message_id = $reply->message_id ?? null;
$rep_for = $reply->forward_from->id ?? null;

$document_file_id = $document->file_id ?? null;
$document_file_name = $document->file_name ?? null;

$data = $callback_query->data ?? null;
$message_id = $update->message->message_id ?? $message_id = $update->callback_query->message->message_id ?? null ;










$bot = file_exists('bot.json') ? json_decode(file_get_contents('bot.json'), true) : [];
$abdo = file_exists('abdo.json') ? json_decode(file_get_contents('abdo.json'), true) : [];
$eshterak = json_decode(file_get_contents("eshterak.json"), true);

function s() {
    global $abdo, $bot, $eshterak;
    file_put_contents('abdo.json', json_encode($abdo));
    file_put_contents('bot.json', json_encode($bot));
    file_put_contents('eshterak.json', json_encode($eshterak));
    
}

if(!isset($bot['tak'])){
    $bot['tak'] = "on";
    s();
}
if(!isset($bot['tawgeh'])){
    $bot['tawgeh'] = "on";
    s();
}
if(!isset($bot['bott'])){
    $bot['bott'] = "on";
    s();
}
if(!isset($bot['premium'])){
    $bot['premium'] = "off";
    s();
}
if(!isset($bot['VIP_button'])){
    $bot['VIP_button'] = "on";
    s();
}

if(!isset($bot['check'])){
    $bot['check'] = "on";
    s();
}
if(!isset($bot['upload'])){
    $bot['upload'] = "on";
    s();
}
if(!isset($bot['folder'])){
    $bot['folder'] = "on";
    s();
}
if(!isset($bot['from_folder'])){
    mkdir("all");
    mkdir("all/$chat_id/{$bot['from_folder']}");
    $bot['from_folder'] = "bots";
    s();
}

if (!file_exists("all")) {
    mkdir("all");
}

if (!file_exists("all/$chat_id")) {
    mkdir("all/$chat_id");
}

if (!file_exists("all/$chat_id/{$bot['from_folder']}")) {
    mkdir("all/$chat_id/{$bot['from_folder']}");
}

$folder_id = $bot['from_folder'];

$VIP_button = $bot['VIP_button'] === "on" ? "✅" : "❌";
if ($data == 'VIP_button') {
    $bot['VIP_button'] = $bot['VIP_button'] === "on" ? "off" : "on";
    $bott = $bot['VIP_button'] === "on" ? "يعمل ✅" : "معطل ❌";
    s();
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['VIP_button'] === "on" ? "تفعيل" : "تعطيل") . " زر التقديم على طلب اشتراك"
    ]);
    bot("EditMessageText", [
        "chat_id" => $chat_id, 
        'message_id' => $message_id,
        "text" => "[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145)\nمرحبا بك في قسم إدارة الـ VIP",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => " زر التقديم على طلب اشتراك " . $VIP_button, 'callback_data' => "VIP_button"]],
                [['text'=>"• إضافة VIP •",'callback_data'=>"addvip"],['text'=>"• حذف VIP •",'callback_data'=>"removevip"]],
                [['text' => "• عرض جميع الـ VIP •", 'callback_data' => "viewvips"]],
                [['text' => "• حذف جميع الـ VIP •", 'callback_data' => "clearvips"]],
                [['text' => "• رجوع •", 'callback_data' => "bot"]]
            ]
        ])
    ]);
}
























$premium = $bot['premium'] === "on" ? "✅" : "❌";
$bott = $bot['bott'] === "on" ? "✅" : "❌";
$tawgeh = $bot['tawgeh'] === "on" ? "✅" : "❌";
$tak = $bot['tak'] === "on" ? "✅" : "❌";
if ($data == 'premium') {
    $bot['premium'] = $bot['premium'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => abdo()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['stabilizing'] === "on" ? "تفعيل" : "تعطيل") . " التثبيت."
    ]);
} elseif ($data == 'bott') {
    $bot['bott'] = $bot['bott'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => abdo()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['directing'] === "on" ? "تفعيل" : "تعطيل") . " التوجيه."
    ]);
} elseif ($data == 'tawgeh') {
    $bot['tawgeh'] = $bot['tawgeh'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => abdo()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['radio_p'] === "on" ? "تفعيل" : "تعطيل") . " الاذاعة في الخاص."
    ]);
} elseif ($data == 'tak') {
    $bot['tak'] = $bot['tak'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => abdo()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['radio_g'] === "on" ? "تفعيل" : "تعطيل") . " الاذاعة في الجروبات."
    ]);
}
function abdo() {
    global $bot;
    $premium = $bot['premium'] === "on" ? "✅" : "❌";
    $bott = $bot['bott'] === "on" ? "✅" : "❌";
    $tawgeh = $bot['tawgeh'] === "on" ? "✅" : "❌";
    $tak = $bot['tak'] === "on" ? "✅" : "❌";
    $radio_ch = $bot['radio_ch'] === "on" ? "✅" : "❌";

    return json_encode([
        'inline_keyboard' => [
            [['text' => 'تنبيه دخول الاعضاء  ' . $tak, 'callback_data' => "tak"]], // tm
            [['text'=> 'توجيه الرسائل  ' . $tawgeh, 'callback_data'=>"tawgeh"]], // tm
            [['text'=> 'وضع البوت  ' . $bott, 'callback_data'=>"bott" ]], // tm
            [['text'=> ' الوضع المدفوع  ' . $premium, 'callback_data'=>"premium"]], // tm

            [['text'=>'• قسم الحظر •' ,'callback_data'=>"ksmblock"], // tm
            ['text'=>'• قسم الادمنيه •' ,'callback_data'=>"ksmadmin"]], // tm
            [['text' => "• قسم الاذاعه •", 'callback_data' => "msg"]], // tm
            [['text'=>'• قسم الاشتراك الاجباري •' ,'callback_data'=>"eshterak"]], // tm
            [['text'=>'• قسم الاشتراك الـ ( VIP ) •' ,'callback_data'=>"ksmvip"]],
            [['text'=>'• احصائيات البوت •' ,'callback_data'=>"statistics"]], // tm
            [['text'=>'• اعدادات بوت الرفع•' ,'callback_data'=>"abdo"]] // tm
        ]
    ]);
}
























$bot['admins'] = $bot['admins'] ?? [];
if (!in_array($admin, $bot['admins'])) {
    $bot['admins'][] = $admin;
    s();
}
$admins = $bot['admins'];
if (($text == '/start' or $data == 'bot') and in_array($from_id, $admins)) {
    if ($data) {
        $m = 'EditMessageText';
    } else {
        $m = 'sendMessage';
    }
    $getUpdatedMarkup =  abdo();
    bot($m, [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "اهلا بك عزيزي المطور
اليك لوحة الصانع
⚙️ — — — — — — — — ⚙️

[قناة السورس](https://t.me/INNV8)
",
        'parse_mode' => "markdown",
        'disable_web_page_preview' => true,
        'reply_markup' => $getUpdatedMarkup
    ]);
    $abdo['mode'][$from_id]['mode'] = null;
    s();
}







if ($message && $from_id != $admin && $bot['tawgeh'] == "on" && $type == "private") {
    $pp = bot('forwardMessage', [
        'chat_id' => $admin,
        'from_chat_id' => $from_id,
        'message_id' => $message_id
    ]);

    $message_id_to = $pp->result->message_id;
    $abdo["twasol"][$message_id_to] = $from_id;
    s();
}

if ($message && $from_id == $admin && $reply && $text != "ايدي" && in_array($reply->message_id, array_keys($abdo["twasol"]))) {
    $reply_chat_id = $abdo["twasol"][$reply->message_id];

    if ($text) {
        bot('sendMessage', [
            'chat_id' => $reply_chat_id,
            'text' => "وصلتك رسالة جديده من الدعم \n" . $text,
            'parse_mode' => "markdown",
            'protect_content' => true,
        ]);
    } elseif ($photo) {
        bot('sendPhoto', [
            'chat_id' => $reply_chat_id,
            'photo' => $photo[0]->file_id,
            'caption' => "وصلتك رسالة جديده من الدعم \n" . $caption,
        ]);
    } elseif ($voice) {
        bot('sendVoice', [
            'chat_id' => $reply_chat_id,
            'voice' => $voice->file_id,
            'caption' => "وصلتك رسالة جديده من الدعم \n" . $caption,
        ]);
    } elseif ($audio) {
        bot('sendAudio', [
            'chat_id' => $reply_chat_id,
            'audio' => $audio->file_id,
            'caption' => "وصلتك رسالة جديده من الدعم \n" . $caption,
        ]);
    } elseif ($video) {
        bot('sendVideo', [
            'chat_id' => $reply_chat_id,
            'video' => $video->file_id,
            'caption' => "وصلتك رسالة جديده من الدعم \n" . $caption,
        ]);
    } elseif ($document) {
        bot('sendDocument', [
            'chat_id' => $reply_chat_id,
            'document' => $document->file_id,
            'caption' => "وصلتك رسالة جديده من الدعم \n" . $caption,
        ]);
    } elseif ($sticker) {
        bot('sendSticker', [
            'chat_id' => $reply_chat_id,
            'sticker' => $sticker->file_id,
        ]);
    }
    exit;
} elseif ($reply && $from_id == $admin && $text == "ايدي"){
    $names = "";
    $reply_from_id = $abdo["twasol"][$reply->message_id] ?? "ايدي غير مسجل";
    $user_info = bot('getChatMember', ['chat_id' => $reply_from_id, 'user_id' => $reply_from_id])->result;
    if ($user_info) {
        $username = $user_info->user->username ?? '';
        $name = $user_info->user->first_name ?? '';
        $names .= "*User ID:* [$reply_from_id](tg://openmessage?user_id=$reply_from_id)\n";
        $names .= "*Username:*[ @$username ]\n";
        $names .= "*Name:* [$name](tg://user?id=$reply_from_id)\n";
    } else {
        $names .= "*User ID:* $reply_from_id\n";
        $names .= "*Error:* User not found\n\n";
    }
    
    bot("sendMessage", [
        "chat_id" => $chat_id, 
        "text" => "[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145):\n$names",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• رجوع •", 'callback_data' => "bot"]],
            ]
        ])
    ]);
}












//-------------------------- الاحصائيات ------------------------------//
// تحميل أو تهيئة ملف الإحصائيات
$statsFile = 'statistics.json';
$stats = file_exists($statsFile) ? json_decode(file_get_contents($statsFile), true) : [
    "users" => [],
    "groups" => [],
    "stats" => [
        "total_users" => 0,
        "total_groups" => 0,
        "today" => ["date" => date('Y-m-d'), "users" => 0, "groups" => 0],
        "yesterday" => ["date" => date('Y-m-d', strtotime("-1 day")), "users" => 0, "groups" => 0],
        "new_today" => 0,
        "new_groups_today" => 0,
    ],
];






// تحديث اليوم الجديد
if ($stats['stats']['today']['date'] != date('Y-m-d')) {
    $stats['stats']['yesterday'] = $stats['stats']['today'];
    $stats['stats']['today'] = ["date" => date('Y-m-d'), "users" => 0, "groups" => 0];
    $stats['stats']['new_today'] = 0;
    $stats['stats']['new_groups_today'] = 0;
}

function notifyAdmin($text) {
    global $admin;
    bot('sendmessage', ['chat_id' => $admin, 'text' => $text, "parse_mode" => "markdown"]);
}
// التعامل مع الخاص
if ($type == "private" && !in_array($from_id, $stats['users'])) {
    $stats['users'][] = $from_id;
    $stats['stats']['total_users']++;
    $stats['stats']['today']['users']++;
    $stats['stats']['new_today']++;
    bot('sendmessage', ['chat_id' => $admin, 'text' => "*🆕 مستخدم جديد دخل البوت*\n\n- الاسم: [$name](tg://user?id=$from_id)\n- المعرف: [@" . ($user ?? "غير متوفر") . "]\n- الايدي: `$from_id`", "parse_mode" => "markdown"]);
    file_put_contents($statsFile, json_encode($stats, JSON_PRETTY_PRINT));
}

// التعامل مع الجروبات
if (($type == "group" || $type == "supergroup") && !in_array($chat_id, $stats['groups'])) {
    $stats['groups'][] = $chat_id;
    $stats['stats']['total_groups']++;
    $stats['stats']['today']['groups']++;
    $stats['stats']['new_groups_today']++;
    bot('sendmessage', ['chat_id' => $admin, 'text' => "*🆕 تم اضافة البوت الى جروب جديد*\n\n- الاسم: $chat_title\n- الايدي: `$chat_id`", "parse_mode" => "markdown"]);
    file_put_contents($statsFile, json_encode($stats, JSON_PRETTY_PRINT));
}









// عرض الإحصائيات
if ($data == "statistics") {
    $todayDate = date('Y-m-d');
    $yesterdayDate = date('Y-m-d', strtotime("-1 day"));
    
    // إحصائيات المستخدمين
    $totalUsers = $stats['stats']['total_users'];
    $totalGroups = $stats['stats']['total_groups'];
    $usersToday = $stats['stats']['today']['users'];
    $groupsToday = $stats['stats']['today']['groups'];
    
    // إحصائيات اليوم والأمس
    $usersYesterday = $stats['stats']['yesterday']['users'];
    $groupsYesterday = $stats['stats']['yesterday']['groups'];
    
    // إحصائيات المستخدمين الجدد
    $newUsersToday = $stats['stats']['new_today'];
    $newUsersYesterday = $stats['stats']['new_groups_today'];
    $newUsersThisMonth = $stats['stats']['new_today']; // يجب تعديل هذا بناءً على الطريقة لحساب الشهر
    $newUsersLastMonth = $stats['stats']['new_today']; // تعديل نفس الشئ هنا

    // عرض الإحصائيات
    $message = "مرحبًا بك في قسم الإحصائيات 📊\n\n";
    $message .= "• المستخدمون:\n\n";
    $message .= "- العدد الإجمالي للمستخدمين: $totalUsers\n";
    $message .= "- عدد المستخدمين في الخاص: $totalUsers\n"; // يجب تعديلها حسب الوضع الفعلي
    $message .= "- عدد القنوات والمجموعات: $totalGroups\n\n";
    
    $message .= "• التفاعل:\n\n";
    $message .= "- اليوم ($todayDate):\n";
    $message .= "- المستخدمون: $usersToday\n";
    $message .= "- المجموعات: $groupsToday\n\n";
    
    $message .= "- في الأمس ($yesterdayDate):\n";
    $message .= "- المستخدمون: $usersYesterday\n";
    $message .= "- المجموعات: $groupsYesterday\n\n";
    
    $message .= "- عدد المستخدمين الجدد اليوم: $newUsersToday\n";
    $message .= "- عدد المستخدمين الجدد بالأمس: $newUsersYesterday\n";
    $message .= "- عدد المستخدمين الجدد هذا الشهر: $newUsersThisMonth\n";
    $message .= "- عدد المستخدمين الجدد في الشهر الماضي: $newUsersLastMonth\n\n";

    // عرض آخر الأعضاء الذين اشتركوا
    $recentUsers = array_slice($stats['users'], -5); // آخر 5 مستخدمين
    $message .= "- قائمة آخر الأعضاء الذين اشتركوا:\n";
    foreach ($recentUsers as $userId) {
        $message .= "$userId\n";
    }
     
    bot('EditMessageText', [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
        'text' => $message, 
        'parse_mode' => "html", 
        "reply_markup" => json_encode([
            "inline_keyboard" => [[
                ["text" => "• رجوع •", "callback_data" => "bot"]
            ]]
        ])
    ]);
}
//-------------------------- الاحصائيات ------------------------------//
















//-------------------------- الاشتراك الاجباري ------------------------------//
if ($data == "eshterak") {
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => "[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145)\nمرحبا بك في قسم الاشتراك الإجباري. اختر الإجراء المطلوب:",
        "parse_mode" => "markdown",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "+ اضف قناة +", "callback_data" => "esh"], ["text" => "- حذف قناة -", "callback_data" => "unesh"]],
                [["text" => "👁 عرض قنوات الاشتراك الإجباري", "callback_data" => "eshh"]],
                [["text" => "❗ حذف جميع القنوات", "callback_data" => "uneshh"]],
                [['text' => "• رجوع •", 'callback_data' => "bot"]]
            ]
        ])
    ]);
    $abdo['mode'][$from_id]['mode'] = null;
    s();
    exit;
}


if ($data == "esh") {
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => "👤 أرسل معرف القناة (@channel)، أيدي القناة، أو قم بتوجيه رسالة من القناة.",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "• إلغاء •", "callback_data" => "eshterak"]],
            ]
        ])
    ]);
    $abdo['mode'][$from_id]['mode'] = "esh_step1";
    s();
    exit;
}

if ($message && $abdo['mode'][$from_id]['mode'] == "esh_step1") {
    $channel_id = null;

    if (strpos($text, "@") === 0) {
        $channel_info = bot("getChat", ["chat_id" => $text]);
        if ($channel_info->ok) {
            $channel_id = $channel_info->result->id;
        }
    } elseif (is_numeric($text)) {
        $channel_id = "-100" . $text;
    } elseif ($message->forward_from_chat) {
        $channel_id = $message->forward_from_chat->id;
    }

    if ($channel_id) {
        // التحقق من الصلاحيات
        $chat_member = bot("getChatMember", ["chat_id" => $channel_id, "user_id" => $bot_id]);
        // if (!$chat_member->ok || strpos($chat_member->result->status, "administrator") === false) {
        //     bot("sendmessage", [
        //         "chat_id" => $chat_id,
        //         "text" => "⚠️ البوت لا يمتلك صلاحيات كافية لإدارة هذه القناة. تأكد من تعيينه كمدير.",
        //     ]);
        //     exit;
        // }

        $abdo['bot']['temp_channel_id'] = $channel_id;
        $channel_name = bot("getChat", ["chat_id" => $channel_id])->result->title;
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "✅ تم التعرف على القناة: $channel_name\nالآن، أرسل عدد الاشتراكات المطلوب:",
        ]);
        $abdo['mode'][$from_id]['mode'] = "esh_step2";
        s();
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "⚠️ لم أتمكن من استخراج أيدي القناة. يرجى المحاولة مرة أخرى أو التأكد من صحة البيانات.",
        ]);
    }
    exit;
}

if ($text && $abdo['mode'][$from_id]['mode'] == "esh_step2") {
    if (is_numeric($text) && intval($text) > 0) {
        $channel_id = $abdo['bot']['temp_channel_id'];
        $eshterak[$channel_id] = intval($text);
        s();

        $channel_name = bot("getChat", ["chat_id" => $channel_id])->result->title;
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "✅ تمت إضافة القناة ($channel_name) لقائمة الاشتراك الإجباري بعدد مطلوب: $text.",
        ]);
        $abdo['mode'][$from_id]['mode'] = null;
        unset($abdo['bot']['temp_channel_id']);
        s();
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "⚠️ يرجى إرسال عدد صحيح للاشتراكات المطلوبة.",
        ]);
    }
    exit;
}

if ($data == "unesh") {
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => "🗑️ أرسل معرف أو أيدي القناة التي تريد حذفها من قائمة الاشتراك الإجباري.",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "• رجوع •", "callback_data" => "eshterak"]],
            ]
        ])
    ]);
    $abdo['mode'][$from_id]['mode'] = "unesh";
    s();
    exit;
}

if ($message && $abdo['mode'][$from_id]['mode'] == "unesh") {
    $channel_id = null;

    if (strpos($text, "@") === 0) {
        $channel_info = bot("getChat", ["chat_id" => $text]);
        if ($channel_info->ok) {
            $channel_id = $channel_info->result->id;
        }
    } elseif (is_numeric($text)) {
        $channel_id = "-100" . $text;
    } elseif ($message->forward_from_chat) {
        $channel_id = $message->forward_from_chat->id;
    }

    if ($channel_id && isset($eshterak[$channel_id])) {
        unset($eshterak[$channel_id]);
        s();
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "✅ تم حذف القناة من قائمة الاشتراك الإجباري.",
        ]);
        $abdo['mode'][$from_id]['mode'] = null;
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id,
            "text" => "❌ القناة غير موجودة في قائمة الاشتراك الإجباري.",
        ]);
    }
    exit;
}


if ($data == "eshh") {
    if (!empty($eshterak)) {
        $eshterak_list = "📋 **قنوات الاشتراك الإجباري:**\n\n";
        foreach ($eshterak as $channel_id => $count) {
            $channel_info = bot("getChat", ["chat_id" => $channel_id]);
            $title = $channel_info->result->title ?? "غير معروف";
            $eshterak_list .= "🔹 [$title](tg://user?id=$channel_id) - العدد المطلوب: $count\n";
        }
    } else {
        $eshterak_list = "❌ لا توجد قنوات ضمن قائمة الاشتراك الإجباري.";
    }

    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => $eshterak_list,
        "parse_mode" => "Markdown",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "• رجوع •", "callback_data" => "eshterak"]],
            ]
        ])
    ]);
    exit;
}


if ($data == "uneshh") {
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => "⚠️ هل أنت متأكد أنك تريد حذف **جميع** قنوات الاشتراك الإجباري؟",
        "parse_mode" => "Markdown",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "نعم", "callback_data" => "confirm_uneshh"], ["text" => "لا", "callback_data" => "eshterak"]],
            ]
        ])
    ]);
    exit;
}

if ($data == "confirm_uneshh") {
    $eshterak = null;
    s();
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        "message_id" => $message_id,
        "text" => "✅ تم حذف جميع قنوات الاشتراك الإجباري.",
        "reply_markup" => json_encode([
            "inline_keyboard" => [
                [["text" => "• رجوع •", "callback_data" => "eshterak"]],
            ]
        ])
    ]);
    exit;
}





if (($data || $message) && $type == "private"  && !in_array($from_id, $admins)) {

    $channels = $eshterak;
    $is_subscribed = true;
    $missing_channels = [];

    foreach ($channels as $channel_id => $number) {

        $response = callAPI('check', $channel_id, $from_id);
        if ($response['subscribed'] === false) {
    
            $abdo[$channel_id]["members"] = [];
            if (!in_array($from_id, $abdo[$channel_id]["members"])) {
                $abdo[$channel_id]["members"][] = $from_id;
                s();
            }

            $is_subscribed = false;
            $missing_channels[$channel_id] = $number;

        } else {
            $abdo[$channel_id]["members"] = $abdo[$channel_id]["members"] ?? [];
            if (in_array($from_id, $abdo[$channel_id]["members"])) {
                unset($abdo[$channel_id]["members"][array_search($from_id, $abdo[$channel_id]["members"])]);
                $abdo[$channel_id]["nom"]++;
                s();

                $channel_name = bot("getChat", ['chat_id' => $channel_id])->result->title;
                $current_count = $abdo[$channel_id]["nom"];


                if ($current_count < $number) {
                    $message = "تم اشتراك عضو جديد\nاسم العضو: ". $name . "\nالقناة: {" . $channel_name . "}\nاجمالي الاعضاء الذين اشتركوا: " . $current_count;
                } else {
                    $message = "تم اكتمال العدد المطلوب للقناة {" . $channel_name . "}.\nعدد الأعضاء: " . $current_count . " من " . $number;
                    unset($eshterak[$channel_id]);
                    unset($abdo[$channel_id]);
                    s();
                }

                bot("sendMessage", [
                    "chat_id" => $admin,
                    "text" => $message,
                    "parse_mode" => "Markdown",
                ]);
            }

        }
    }

    if (!$is_subscribed) {
        $buttons = [];
        foreach ($missing_channels as $channel_id => $number) {
            $chat = bot("getChat", ['chat_id' => $channel_id]);
            $channel_name = $chat->result->title;

            if (!isset($abdo[$channel_id]["link"])) {

                $response = callAPI('link', $channel_id, null, $number);
                if (isset($response['link'])) {
                    $link = $response['link'];
                    $abdo[$channel_id]["link"] = $link;
                    s();
                } else {
                    bot("sendMessage", [
                        "chat_id" => $chat_id,
                        "text" => "حدث خطأ أثناء إنشاء رابط الدعوة.\nيرجى التواصل مع المطور @Abdo_1.",
                        "parse_mode" => "Markdown",
                    ]);
                    exit;
                }
            }

            $link = $abdo[$channel_id]["link"];
            $buttons[] = [['text' => "اشترك في قناة $channel_name", 'url' => $link]];
        }

        $message = "يبدو أنك غير مشترك في بعض القنوات. يرجى الاشتراك للمتابعة:";
        $keyboard = ['inline_keyboard' => $buttons];

        if ($data) {
            bot("EditMessageText", [
                "chat_id" => $chat_id,
                "message_id" => $message_id,
                "text" => $message,
                "parse_mode" => "Markdown",
                'reply_markup' => json_encode($keyboard)
            ]);
        } else {
            bot("sendMessage", [
                "chat_id" => $chat_id,
                "text" => $message,
                "parse_mode" => "Markdown",
                'reply_markup' => json_encode($keyboard)
            ]);
        }
        exit;
    }
}
//-------------------------- الاشتراك الاجباري ------------------------------//










































//-------------------------- الاذاعة ------------------------------//
$stabilizing = $bot['stabilizing'] === "on" ? "✅" : "❌";
$directing = $bot['directing'] === "on" ? "✅" : "❌";
$radio_type = $bot['radio_type'] === "Manufacturer" ? "في بوت الصانع" : "في كل البوتات";
$radio_g_or_p = $bot['radio_g_or_p'] === "private" ? "الخاص" : "الجروبات";
if ($data == 'stabilizing') {
    $bot['stabilizing'] = $bot['stabilizing'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => getUpdatedMarkup()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['stabilizing'] === "on" ? "تفعيل" : "تعطيل") . " التثبيت."
    ]);
} elseif ($data == 'directing') {
    $bot['directing'] = $bot['directing'] === "on" ? "off" : "on";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => getUpdatedMarkup()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم " . ($bot['directing'] === "on" ? "تفعيل" : "تعطيل") . " التوجيه."
    ]);
} elseif ($data == 'radio_type') {
    $bot['radio_type'] = $bot['radio_type'] === "Manufacturer" ? "all" : "Manufacturer";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => getUpdatedMarkup()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم اختيار البث الآن " . ($bot['radio_type'] === "Manufacturer" ? "في بوت الصانع" : "في كل البوتات") . "."
    ]);
} elseif ($data == 'radio_g_or_p') {
    $bot['radio_g_or_p'] = $bot['radio_g_or_p'] === "private" ? "group" : "private";
    s();
    bot('EditMessageReplyMarkup', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reply_markup' => getUpdatedMarkup()
    ]);
    bot('answerCallbackQuery', [
        'callback_query_id' => $update->callback_query->id,
        'text' => "تم اختيار مكان البث في " . ($bot['radio_g_or_p'] === "private" ? "الخاص" : "الجروبات") . "."
    ]);
}
function getUpdatedMarkup() {
    global $bot;
    $stabilizing = $bot['stabilizing'] === "on" ? "✅" : "❌";
    $directing = $bot['directing'] === "on" ? "✅" : "❌";
    $radio_type = $bot['radio_type'] === "Manufacturer" ? "في بوت الصانع" : "في كل البوتات";
    $radio_g_or_p = $bot['radio_g_or_p'] === "private" ? "الخاص" : "الجروبات";

    return json_encode([
        'inline_keyboard' => [
            [['text' => " بالتثبيت " . $stabilizing, 'callback_data' => "stabilizing"]],
            [['text' => " بالتوجيه " . $directing, 'callback_data' => "directing"]],
            [['text' => "الاذاعه في  " . $radio_g_or_p, 'callback_data' => "radio_g_or_p"]],
            [['text' => "• بدء الاذاعه •", 'callback_data' => "start_radio"]],
            [['text' => "• رجوع •", 'callback_data' => "bot"]]
        ]
    ]);
}
if ($data == "msg") {
    $getUpdatedMarkup =  getUpdatedMarkup();
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "• مرحبا عزيزي المطور في قسم الاذاعه المتطور •",
        'parse_mode' => "markdown",
        'reply_markup' => $getUpdatedMarkup
    ]);
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($data == "start_radio") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "• أرسل الآن الكليشة ( النص أو جميع الوسائط )
• يمكنك استخدام كود جاهز في الإذاعة أو يمكنك استخدام الماركدوان" ,
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• الغاء •", 'callback_data' => "msg"]]
            ]
        ])
    ]);

    $bot['mode'][$from_id]['mode'] = "waiting_for_message";
    s();
    exit;
}
$photo=$message->photo;
$video=$message->video;
$document=$message->document;
$sticker=$message->sticker;
$voice=$message->voice;
$audio=$message->audio;
$caption = $message->caption;
if ($photo) {
$sens="sendphoto";
$file_id = $update->message->photo[1]->file_id;
} elseif ($document) {

$sens="senddocument";
$file_id = $update->message->document->file_id;
} elseif ($video) {

$sens="sendvideo";
$file_id = $update->message->video->file_id;
} elseif ($audio) {

$sens="sendaudio";
$file_id = $update->message->audio->file_id;
} elseif ($voice) {

$sens="sendvoice";
$file_id = $update->message->voice->file_id;
} elseif ($sticker) {

$sens="sendsticker";
$file_id = $update->message->sticker->file_id;
} else {
    $sens="sendmessage";
    $file_id = $text;
}
if ($message and $bot['mode'][$from_id]['mode'] == "waiting_for_message") {
    $targets = $bot['radio_g_or_p'] === "private" ? $stats['users'] : $stats['groups'];
    $stabilizing = $bot['stabilizing'] === "on" ? "on" : "off";
    $directing = $bot['directing'] === "on" ? "on" : "off";
    $filename = "broadcast_" . time() . ".php";
    $fileUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['SCRIPT_NAME']) . "/$filename";

    $messag_bb = bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "تم بدء الإذاعة",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• اضغط هنا بعد ثانيتين •", 'url' => $fileUrl]]
            ]
        ])
    ]);
    $code = generateBroadcastCode($targets, $stabilizing, $directing);
    file_put_contents($filename, $code);
    $bot['mode'][$from_id]['mode'] = null;
    s();
    shell_exec("nohup php $filename > /dev/null 2>&1 &");
}

function generateBroadcastCode($targets, $stabilizing, $directing) {
    global $name, $from_id, $message, $token, $message_id, $caption, $file_id, $sens, $chat_id, $messag_bb;

    $targets = var_export($targets, true);
    $file_id = var_export($file_id, true);
    $caption = addslashes($caption);
    $sens = addslashes($sens);
    $messag_bb = $messag_bb->result->message_id;
    return <<<PHP
<?php
define('API_KEY', '$token');

function bot(\$method, \$datas = []) {
    \$url = "https://api.telegram.org/bot" . API_KEY . "/" . \$method;
    \$ch = curl_init();
    curl_setopt(\$ch, CURLOPT_URL, \$url);
    curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(\$ch, CURLOPT_POSTFIELDS, \$datas);
    \$res = curl_exec(\$ch);
    curl_close(\$ch);
    return json_decode(\$res);
}
\$targets = $targets;
\$file_id = $file_id;
\$caption = "$caption";
\$sens = "$sens";
\$stabilizing = "$stabilizing";
\$directing = "$directing";
\$count = count(\$targets);
\$blocked = 0;
\$failed = 0;
\$succeeded = 0;
foreach (\$targets as \$target) {
    try {
        \$response = null;

        if (\$directing == 'on') {
            \$response = bot('forwardMessage', [
                'chat_id' => \$target,
                'from_chat_id' => $from_id,
                'message_id' => $message_id
            ]);
        } else {
            \$payload = ["chat_id" => \$target];
            if (\$sens !== 'sendmessage') {
                \$ss = str_replace("send", "", \$sens);
                \$payload[\$ss] = \$file_id;
                if (\$caption) {
                    \$payload['caption'] = \$caption;
                }
            } else {
                \$payload['text'] = \$file_id;
                \$payload['parse_mode'] = 'Markdown';
            }
            \$response = bot(\$sens, \$payload);
        }

        if (!\$response || !\$response->ok) {
            if (isset(\$response->error_code) && \$response->error_code == 403) {
                \$blocked++;
            } else {
                \$failed++;
            }
        } else {
            \$succeeded++;
        }

        // حساب النسبة المئوية
        \$percentage = round((\$succeeded / \$count) * 100, 2);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $messag_bb,
            'text' => "تم بدء الإذاعة\n
• جاري الإذاعة إلى {\$count} مستخدم 🌐\n
• تم الإرسال إلى {\$succeeded} مستخدم 🎯\n
• المستخدمين الذين حظروا البوت: {\$blocked} 🚫\n
• النسبة المئوية: {\$percentage}%"
        ]);
    } catch (Exception \$e) {
        error_log("Error broadcasting to \$target: " . \$e->getMessage());
    }
}
bot('editMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $messag_bb,
    'text' => "<s>تم بدء الإذاعة</s>\n تم الانتهاء من الاذاعة\n
• جاري الإذاعة إلى {\$count} مستخدم 🌐\n
• تم الإرسال إلى {\$succeeded} مستخدم 🎯\n
• المستخدمين الذين حظروا البوت: {\$blocked} 🚫\n
• النسبة المئوية: {\$percentage}%",
    'parse_mode' => 'HTML'
]);
// الرسالة النهائية
bot('sendMessage', [
    'chat_id' => $from_id,
    'text' => "• تم الاذاعة بنجاح 🎉

• الاعضاء الذين شاهدو الاذاعه {" . \$succeeded . "} عضو حقيقي
• الاعضاء الذين قامو بحظر البوت {" . \$blocked . "}

• المستخدمين الذين لم يستطع البوت ارسال اذاعه لهم {" . \$failed . "} مستخدم

• عدد العضاء الكلي : {" . \$count . "}",
    'parse_mode' => 'Markdown'
]);
unlink(__FILE__);
?>
PHP;
}
//-------------------------- الاذاعة ------------------------------//
































//-------------------------- قسم الحظر ------------------------------//
if ($data == "ksmblock") {
    bot("EditMessageText", [
        "chat_id" => $chat_id, 
        'message_id' => $message_id,
        "text" => "[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145)\nمرحبا بك في قسم الحظر",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• حظر عضو •", 'callback_data' => "block"]],
                [['text' => "• إلغاء حظر عضو •", 'callback_data' => "unblock"]],
                [['text' => "• عرض جميع المحظورين •", 'callback_data' => "blocks"]],
                [['text' => "• حذف جميع المحظورين •", 'callback_data' => "unblocks"]],
                [['text' => "• رجوع •", 'callback_data' => "bot"]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($data == "block") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "حسنا ارسل ايدي الشخص المراد حظره",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• الغاء •", 'callback_data' => "ksmblock"]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = 'block';
    s();
    exit;
}
if ($data == "unblock") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "حسنا ارسل ايدي الشخص المراد إلغاء حظره",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• الغاء •", 'callback_data' => "ksmblock"]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = 'unblock';
    s();
    exit;
}
if ($text && $from_id == $admin && $bot['mode'][$from_id]['mode'] == 'block') {
    $pattern = '/\b\d{8,12}\b/';
    if (preg_match($pattern, $text, $matches)) {
        $bot['banned'][] = $text;
        s();
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "تم حظر [العضو](tg://user?id=$text) بنجاح 🔒",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "• رجوع •", 'callback_data' => "ksmblock"]]
                ]
            ])
        ]);
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "حدث خطأ او ان الايدي خاطئ\nارسل الايدي مجددا",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "• الغاء •", 'callback_data' => "ksmblock"]]
                ]
            ])
        ]);
    }
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($text && $from_id == $admin && $bot['mode'][$from_id]['mode'] == 'unblock') {
    $pattern = '/\b\d{8,12}\b/';
    if (preg_match($pattern, $text, $matches)) {
        $bot['banned'] = array_filter($bot['banned'], function($id) use ($text) {
            return $id != $text;
        });
        s();
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "تم إلغاء حظر [العضو](tg://user?id=$text) بنجاح ✅",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "• رجوع •", 'callback_data' => "ksmblock"]]
                ]
            ])
        ]);
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "حدث خطأ او ان الايدي خاطئ\nارسل الايدي مجددا",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "• الغاء •", 'callback_data' => "ksmblock"]]
                ]
            ])
        ]);
    }
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($data == "blocks") {
    $names = '';
    foreach ($bot['banned'] as $id) {
        $names .= "ID: $id\n\n";
    }
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        'message_id' => $message_id,
        "text" => "*المحظورين* :\n$names",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• رجوع •", 'callback_data' => "ksmblock"]]
            ]
        ])
    ]);
}
if ($data == "unblocks") {
    bot("EditMessageText", [
        "chat_id" => $chat_id, 
        'message_id' => $message_id,
        "text" => "هل أنت متأكد من أنك تريد حذف جميع المحظورين؟ لا يمكن التراجع عن هذا الإجراء.",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "✅ نعم، احذف", 'callback_data' => "confirm_unblocks"]],
                [['text' => "❌ إلغاء", 'callback_data' => "ksmblock"]]
            ]
        ])
    ]);
    exit;
}
if ($data == "confirm_unblocks") {
    $bot['banned'] = [];
    bot("EditMessageText", [
        "chat_id" => $chat_id, 
        'message_id' => $message_id,
        "text" => "تم حذف جميع المحظورين بنجاح.",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• رجوع •", 'callback_data' => "ksmblock"]]
            ]
        ])
    ]);
    s();
    exit;
}
//-------------------------- قسم الحظر ------------------------------//


































//-------------------------- قسم الادمنيه ------------------------------//
if ($data == "ksmadmin") {
    bot("EditMessageText", [
        "chat_id" => $chat_id, 
        'message_id' => $message_id,
        "text" => "[ᶠʳᵒᵐ ʲᵘˢᵗ ᴬᵇᵈᵒ](tg://user?id=6969088145)\nمرحبا بك في قسم الادمنيه",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text'=>"• رفع ادمن •",'callback_data'=>"admins"],['text'=>"• حذف ادمن •",'callback_data'=>"unadmins"]],
                [['text' => "• عرض جميع الادمنيه •", 'callback_data' => "adminss"]],
                [['text' => "• حذف جميع الادمنيه •", 'callback_data' => "unadminss"]],
                [['text' => "• رجوع •", 'callback_data' => "bot"]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($data == "admins") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "حسنا ارسل الايدي بتاعه حالا",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text'=>"• الغاء •",'callback_data'=>"ksmadmin" ]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = 'admins';
    s();
    exit;
}
if ($data == "unadmins") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "حسنا ارسل ايدي البرنس دا حالا",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text'=>"• الغاء •",'callback_data'=>"ksmadmin" ]]
            ]
        ])
    ]);
    $bot['mode'][$from_id]['mode'] = 'unadmins';
    s();
    exit;
}
if ($text and !$data && $from_id == $admin && $bot['mode'][$from_id]['mode'] == 'admins') {
    $pattern = '/\b\d{8,12}\b/';
    if (preg_match($pattern, $text, $matches)) {
        $bot['admins'][] = $text;
        s();

        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "تم رفع [العضو](tg://user?id=$text) ادمن بنجاح 🌹",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text'=>"• رجوع •",'callback_data'=>"ksmadmin" ]]
                ]
            ])
        ]);
        bot("sendmessage", [
            "chat_id" => $text, 
            "text" => "مرحبا.. 🌹\nتم رفعك ادمن في البوت بواسطة [المطور](tg://user?id=$admin) ♥",
            'parse_mode' => "markdown"
        ]);
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "حدث خطأ او ان الايدي خاطئ\nارسل الايدي مجددا",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text'=>"• الغاء •",'callback_data'=>"ksmadmin" ]]
                ]
            ])
        ]);
    }
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($text and !$data && $from_id == $admin && $bot['mode'][$from_id]['mode'] == 'unadmins') {
    $pattern = '/\b\d{8,12}\b/';
    if (preg_match($pattern, $text, $matches)) {
        $bot['admins'] = array_filter($bot['admins'], function($id) use ($text) {
            return $id != $text;
        });
        s();
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "تم سحب الادمن من [العضو](tg://user?id=$text) بنجاح 💯",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text'=>"• رجوع •",'callback_data'=>"ksmadmin" ]]
                ]
            ])
        ]);
        bot("sendmessage", [
            "chat_id" => $text, 
            "text" => "تم سحب الادمنيه منك بواسطة [المطور](tg://user?id=$admin)",
            'parse_mode' => "markdown"
        ]);
    } else {
        bot("sendmessage", [
            "chat_id" => $chat_id, 
            "text" => "حدث خطأ او ان الايدي خاطئ\nارسل الايدي مجددا",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text'=>"• الغاء •",'callback_data'=>"ksmadmin" ]]
                ]
            ])
        ]);
    }
    $bot['mode'][$from_id]['mode'] = null;
    s();
    exit;
}
if ($data == "adminss") {
    $names = '';
    foreach ($bot['admins'] as $id) {
        $user_info = bot('getChatMember', ['chat_id' => $id, 'user_id' => $id])->result;
        $username = $user_info->user->username ?? '';
        $name = $user_info->user->first_name ?? '';
        $names .= "ID: $id\nUsername: [@$username]\nName: [$name](tg://user?id=$id)\n\n";    }
    bot("EditMessageText", [
        "chat_id" => $chat_id,
        'message_id' => $message_id,
        "text" => "*الادمنية* :\n$names",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "• رجوع •", 'callback_data' => "ksmadmin"]]
            ]
        ])
    ]);
    exit;
}