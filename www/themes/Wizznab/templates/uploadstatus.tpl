<h1>{$page->title}</h1>

{if $releaselist}
{$pager}

<table style="margin:10px 0;width:100%;" class="table table-hover table-condensed table-highlight table-striped data" id="browsetable">
	<tr>
		<th>name</th>
		<th>adddate</th>
		<th>status</th>
	</tr>

	{foreach from=$releaselist item=release}
	<tr class="{cycle values=",alt"}">

		<td title="{$release.releasename}">
			{if $release.guid}
			<a href="{$smarty.const.WWW_TOP}/details/{$release.guid}/">{$release.releasename|escape:"htmlall"|wordwrap:75:"\n":true}</a>
			{else}
			{$release.releasename|escape:"htmlall"|wordwrap:75:"\n":true}
			{/if}
		</td>
		<td class="less">{$release.adddate|date_format}</td>
		<td class="less">
			{if $release.status == "success"}
				<span class="label label-success">{$release.status}</span>
			{else if $release.status == "pending"}
				<span class="label label-default">{$release.status}</span>
			{else if $release.status == "duplicate"}
				<span class="label label-warning">{$release.status}</span>
			{else}
				<span class="label label-danger">{$release.status}</span>
			{/if}
		</td>
	</tr>
	{/foreach}



</table>
{else}
<p>No releases available.</p>
{/if}
