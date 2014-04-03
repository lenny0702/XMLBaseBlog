<div class="p"><p class="text">Release Date: {$log->publicDate}</p></div>
<div class="p"><p class="text">Release Version: WeChat {$log->version} for Android. <a href="/cgi-bin/download302?fr=www.wechat.com&lang=en&url=android" target="_blank">Download now</a> from Google Play (or search "WeChat" in Google Play). <a href="/cgi-bin/download302?fr=www.wechat.com&lang=en&url=android503">Download the installation packag</a></p></div>

<div class="p"><p class="text">{$log->description}</p></div>
<div class="p"><p class="text bold">What's New in version {$log->version}:</p></div>
{section name=sec1 loop=$log->features }
<div class="p"><p class="text bold">{$log->features[sec1]}</p></div>
<div class="p"><p class="text bold"><img class="img" src={$IMAGEBASE}/{$log->lang}/img/{$log->dir}/wechat_{($smarty.section.sec1.index+1)*2-1}.jpg "/><img class="img" src={$IMAGEBASE}/{$log->lang}/img/{$log->dir}/wechat_{($smarty.section.sec1.index+1)*2}.jpg "/></p></div>
{/section}


