<div class="p"><p class="text">Release Date: {$log->publicDate}</p></div>
<div class="p"><p class="text">Release Version: WeChat {$log->version} for Windows Phone. <a href="/cgi-bin/download302?fr=www.wechat.com&lang=en&url=wp" target="_blank" onClick="trackOutboundLink(this, 'Download', 'download_link','wp'); return false;" >Download now</a> from Marketplace (or search "WeChat" in Marketplace). </p></div>

<div class="p"><p class="text">{$log->description}</p></div>
<div class="p"><p class="text bold">What's New in version {$log->version}:</p></div>

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

