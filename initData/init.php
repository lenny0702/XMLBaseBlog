<?php 
define("DB_PATH","./");
include "xmlDB1.php";
$row = Database::factory("logs2",NULL,"Logs");
//-----------------------------------------------for iPhone-----------------------------------
$row->date = "2013-12-13";
$row->version = "4.3";
$row->lang = "en";
$row->title = "WeChat 4.3 for iPhone Release";
$row->description = "Web Grab allows you to pull images straight from your computer browser to your phone.";
$row->indexDescription = ">WeChat is the complete mobile communication and social networking app. Free, cross-platform, and full-featured, WeChat is the best way to keep in touch with everyone you care about. It supports 15 languages including English, Chinese, Thai, Vietnamese, Indonesian, and Portuguese.";
$row->features = array("1.Introduced Web Grab, a new feature allowing you to pull images straight from your computer browser to your phone. (Visit http://www.wechat.com/shake to learn more) .",
			"2.Sync your Moments photos to Twitter.",
			"3.Download photos from your Facebook albums and share them on WeChat Moments.",
			"4.Download special emoticons."
			);
$row->save();
$row->date = "2013-12-13";
$row->version = "4.3";
$row->lang = "zh_TW";
$row->title = "WeChat 4.3 for iPhone 全新發佈";
$row->description = "WeChat, 超過一億人使用的手機社交App。實踐免費語音短訊、影片、文字、相片分享及交友的All-in-One App 。";
$row->indexDescription = "新增搖一搖傳圖,可以將電腦網頁上的圖片“搖”到手機上。";
$row->features = array("1.新增搖一搖傳圖，你可以將電腦網頁上的圖片“搖”到手機上，讓好友也搖到你的圖片。（查看詳情http://www.wechat.com/shake）。",
			"2.可以將朋友圈的相片同步到Twitter，讓更多朋友分享你的快樂一刻。",
			"3.可以從Facebook相簿下載相片並分享到朋友圈。",
			"4.可以下載動畫表情。"
			);
$row->save();
$row->date = "2013-2-13";
$row->version = "4.2";
$row->lang = "en";
$row->title = "WeChat 4.2 for iPhone Release";
$row->description = "WeChat is the complete mobile communication and social networking app. Free, cross-platform, and full-featured, WeChat is the best way to keep in touch with everyone you care about. It supports 15 languages including English, Chinese, Thai, Vietnamese, Indonesian, and Portuguese.";
$row->indexDescription = "WeChat 4.2 for iPhone has been released. Download WeChat in App Store to experience video calls and web WeChat on your handset";
$row->features = array("1.Video Calls: talk to your friends face to face.",
			"2.Web WeChat: chat on WeChat from your PC through the browser.",
			"3.Selective sharing of Moments using Visibility and custom-defined groups and the ability to reply directly to a friend’s comment in Moments using @.",
			"4.New QR Name Card."
			);
$row->save();
$row->date = "2013-2-13";
$row->version = "4.2";
$row->lang = "zh_TW";
$row->title = "WeChat 4.2 for iPhone 全新發佈";
$row->description = "超過一億人使用的手機社交App。實踐免費語音短訊、影片、文字、相片分享及交友的All-in-One App 。";
$row->indexDescription = "新增視訊通話功能";
$row->features = array("1.新增視訊通話功能，遠距離不再是問題。",
			"2.新增WeChat網頁版，電腦連接WeChat，輸入文字更方便。",
			"3.朋友圈上傳相片可選擇分享對象 ，加強朋友圈私隱保護；回覆某條相片評論，讓交流更直接明確。",
			"4.全新的WeChat名片設計，讓你更具魅力。"
			);
$row->save();
//--------------------------------------------for Android---------------------------------------------
$row->date = "2013-12-13";
$row->version = "4.3";
$row->lang = "en";
$row->title = "WeChat 4.3 for Android Release";
$row->description = "Web Grab allows you to pull images straight from your computer browser to your phone.";
$row->indexDescription = ">WeChat is the complete mobile communication and social networking app. Free, cross-platform, and full-featured, WeChat is the best way to keep in touch with everyone you care about. It supports 15 languages including English, Chinese, Thai, Vietnamese, Indonesian, and Portuguese.";
$row->features = array("1.Introduced Web Grab, a new feature allowing you to pull images straight from your computer browser to your phone. (Visit http://www.wechat.com/shake to learn more) .",
			"2.Sync your Moments photos to Twitter.",
			"3.Download photos from your Facebook albums and share them on WeChat Moments.",
			"4.Download special emoticons."
			);
$row->save();
$row->date = "2013-12-13";
$row->version = "4.3";
$row->lang = "zh_TW";
$row->title = "WeChat 4.3 for Android 全新發佈";
$row->description = "WeChat, 超過一億人使用的手機社交App。實踐免費語音短訊、影片、文字、相片分享及交友的All-in-One App 。";
$row->indexDescription = "新增搖一搖傳圖,可以將電腦網頁上的圖片“搖”到手機上。";
$row->features = array("1.新增搖一搖傳圖，你可以將電腦網頁上的圖片“搖”到手機上，讓好友也搖到你的圖片。（查看詳情http://www.wechat.com/shake）。",
			"2.可以將朋友圈的相片同步到Twitter，讓更多朋友分享你的快樂一刻。",
			"3.可以從Facebook相簿下載相片並分享到朋友圈。",
			"4.可以下載動畫表情。"
			);
$row->save();
$row->date = "2013-2-13";
$row->version = "4.2";
$row->lang = "en";
$row->title = "WeChat 4.2 for Android Release";
$row->description = "WeChat is the complete mobile communication and social networking app. Free, cross-platform, and full-featured, WeChat is the best way to keep in touch with everyone you care about. It supports 15 languages including English, Chinese, Thai, Vietnamese, Indonesian, and Portuguese.";
$row->indexDescription = "WeChat 4.2 for Android has been released. Download WeChat in App Store to experience video calls and web WeChat on your handset";
$row->features = array("1.Video Calls: talk to your friends face to face.",
			"2.Web WeChat: chat on WeChat from your PC through the browser.",
			"3.Selective sharing of Moments using Visibility and custom-defined groups and the ability to reply directly to a friend’s comment in Moments using @.",
			"4.New QR Name Card."
			);
$row->save();
$row->date = "2013-2-13";
$row->version = "4.2";
$row->lang = "zh_TW";
$row->title = "WeChat 4.2 for Android 全新發佈";
$row->description = "超過一億人使用的手機社交App。實踐免費語音短訊、影片、文字、相片分享及交友的All-in-One App 。";
$row->indexDescription = "新增視訊通話功能";
$row->features = array("1.新增視訊通話功能，遠距離不再是問題。",
			"2.新增WeChat網頁版，電腦連接WeChat，輸入文字更方便。",
			"3.朋友圈上傳相片可選擇分享對象 ，加強朋友圈私隱保護；回覆某條相片評論，讓交流更直接明確。",
			"4.全新的WeChat名片設計，讓你更具魅力。"
			);
$row->save();
?>

