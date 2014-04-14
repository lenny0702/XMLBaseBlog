<div class="log_category">
<h3 class="mac_log">Mac</h3>
<ul>
{section name=sec1 loop=$MacLogs }
<li class="log_category_item"><a href="{$MacLogs[sec1]->link}">{$MacLogs[sec1]->title}</a><span>{$MacLogs[sec1]->publicDate}</span>
    {if $MacLogs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="iphone_log">iPhone</h3>
<ul>
{section name=sec1 loop=$iPhoneLogs }
<li class="log_category_item"><a href="{$iPhoneLogs[sec1]->link}">{$iPhoneLogs[sec1]->title}</a><span>{$iPhoneLogs[sec1]->publicDate}</span>
    {if $iPhoneLogs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="Android_log">Android</h3>
<ul>
{section name=sec1 loop=$AndroidLogs }
<li class="log_category_item"><a href="{$AndroidLogs[sec1]->link}">{$AndroidLogs[sec1]->title}</a><span>{$AndroidLogs[sec1]->publicDate}</span>
    {if $AndroidLogs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="wp_log">Windows Phone</h3>
<ul>
{section name=sec1 loop=$WindowsPhoneLogs }
<li class="log_category_item"><a href="{$WindowsPhoneLogs[sec1]->link}">{$WindowsPhoneLogs[sec1]->title}</a><span>{$WindowsPhoneLogs[sec1]->publicDate}</span>
    {if $WindowsPhoneLogs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="s40_log">S40</h3>
<ul>
{section name=sec1 loop=$S40Logs }
<li class="log_category_item"><a href="{$S40Logs[sec1]->link}">{$S40Logs[sec1]->title}</a><span>{$S40Logs[sec1]->publicDate}</span>
    {if $S40Logs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="symbian_v5_log">Symbian V5</h3>
<ul>
{section name=sec1 loop=$SymbianV5Logs }
<li class="log_category_item"><a href="{$SymbianV5Logs[sec1]->link}">{$SymbianV5Logs[sec1]->title}</a><span>{$SymbianV5Logs[sec1]->publicDate}</span>
    {if $SymbianV5Logs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="symbian_v3_log">Symbian V3</h3>
<ul>
{section name=sec1 loop=$SymbianV3Logs }
<li class="log_category_item"><a href="{$SymbianV3Logs[sec1]->link}">{$SymbianV3Logs[sec1]->title}</a><span>{$SymbianV3Logs[sec1]->publicDate}</span>
    {if $SymbianV3Logs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="blackberry_log">BlackBerry</h3>
<ul>
{section name=sec1 loop=$BlackBerryLogs }
<li class="log_category_item"><a href="{$BlackBerryLogs[sec1]->link}">{$BlackBerryLogs[sec1]->title}</a><span>{$BlackBerryLogs[sec1]->publicDate}</span>
    {if $BlackBerryLogs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
<div class="log_category">
<h3 class="bb10_log">BlackBerry 10</h3>
<ul>
{section name=sec1 loop=$BlackBerry10Logs }
<li class="log_category_item"><a href="{$BlackBerry10Logs[sec1]->link}">{$BlackBerry10Logs[sec1]->title}</a><span>{$BlackBerry10Logs[sec1]->publicDate}</span>
    {if $BlackBerry10Logs[sec1]->isNew eq 1}
        <span class="new1"></span>
    {/if}
</li>
{/section}
</ul>
</div>
