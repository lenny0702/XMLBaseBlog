<div class="p"><p class="text">發佈日期：{$log->publicDate}</p></div>
<div class="p"><p class="text">發佈版本：WeChat {$log->version} for BlackBerry 10. <a href="http://www.wechat.com/cgi-bin/download302?fr=www.wechat.com&lang=zh_TW&url=bb1010" target="_blank" onClick="trackOutboundLink(this, 'Download', 'download_link','bb10'); return false;" >請到BlackBerry World下載</a></p></div>

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

