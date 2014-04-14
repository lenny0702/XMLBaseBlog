<div class="p"><p class="text">Release Date: {$log->publicDate}</p></div>
<div class="p"><p class="text">Release Version: WeChat {$log->version} for Symbian V3. <a href="/cgi-bin/download302?fr=www.wechat.com&lang=en&url=symbian_v3{$log->downloadVersion}" onClick="trackOutboundLink(this, 'Download', 'download_link','symbianv3_package'); return false;" >Download now</a>.<a href="/cgi-bin/download302?fr=www.wechat.com&lang=en&url=symbian_v3" target="_blank" onClick="trackOutboundLink(this, 'Download', 'download_link','symbianv3'); return false;" >or go to OVI Store</a>(or search "WeChat" in Ovi Store).</p></div>

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


