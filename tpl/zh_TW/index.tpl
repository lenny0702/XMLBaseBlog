{section name=sec1 loop=$logs max=3}
<li class="log_item">
	<a href="{$logs[sec1]->link}"><img width="164" height="92" src="{$IMAGEBASE}/{$logs[sec1]->lang}/img/{$logs[sec1]->dir}/thumbnail.png" /></a>
	<div class="info_item">
		<a class="title" href="{$logs[sec1]->link}">{$logs[sec1]->title}</a>
		<div class="date">{$logs[sec1]->publicDate}</div>
		<div class="description">{$logs[sec1]->indexDescription}</div>
	</div>
	<div class="new"></div>
</li>
{/section}
