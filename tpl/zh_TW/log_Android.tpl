<div class="p"><p class="text">發佈日期：{$log->publicDate}</p></div>
<div class="p"><p class="text">發佈版本：WeChat {$log->version} for Android. <a href="/cgi-bin/download302?fr=www.wechat.com&lang=zh_TW&url=android" target="_blank" onClick="trackOutboundLink(this, 'Download', 'download_link','android'); return false;" >請到Google Play下載</a>（或到手機Google Play搜尋“WeChat”）。<a href="/cgi-bin/download302?fr=www.wechat.com&lang=zh_TW&url=android{$log->downloadVersion}" onClick="trackOutboundLink(this, 'Download', 'download_link','android_package'); return false;" >下載安裝包</a></p></div>

<div class="p"><p class="text">{$log->description}</p></div>
<div class="p"><p class="text bold">WeChat {$log->version} 新特性：</p></div>

{assign var=val value=1}
{section name=sec1 loop=$log->features }
<div class="p"><p class="text bold">{$log->features[sec1]}</p></div>
<div class="p"><p class="text bold">
{for $featureNum=1 to {$log->featuresNum[sec1]}}
	<img class="img" src={$IMAGEBASE}/{$log->lang}/img/{$log->dir}/wechat_{$val}.jpg "/>
	{assign var=val value=$val+1}
{/for}
</p></div>
{/section}
