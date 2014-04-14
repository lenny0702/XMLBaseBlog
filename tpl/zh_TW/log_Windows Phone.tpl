<div class="p"><p class="text">發佈日期：{$log->publicDate}</p></div>
<div class="p"><p class="text">發佈版本： WeChat {$log->version} for Windows Phone. <a href="/cgi-bin/download302?fr=www.wechat.com&lang=zh_TW&url=wp" target="_blank" onClick="trackOutboundLink(this, 'Download', 'download_link','wp'); return false;" >請到Marketplace下載</a>（或到手機Marketplace搜尋“WeChat”）。 </p></div>

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


