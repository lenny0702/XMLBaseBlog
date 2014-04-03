<div class="log_category">
<h3 class="Android_log">Android</h3>
<ul>
{section name=sec1 loop=$AndroidLogs }
<li class="log_category_item"><a href="{$AndroidLogs[sec1]->link}">{$AndroidLogs[sec1]->title}</a><span>{$AndroidLogs[sec1]->publicDate}</span><span>New</span></li>
</ul>
</div>
{/section}
