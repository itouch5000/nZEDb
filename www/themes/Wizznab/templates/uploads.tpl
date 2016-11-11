<h1>{$page->title}</h1>
{if $releaselist}

<p class="lead">
	<b>{$pagertotalitems}</b> uploads von diesem User mit insgesamt <b>{$grabs}</b> Grabs
</p>

<div class="clearfix" style="margin: 15px 0">
	{$pager}
</div>

<table style="margin:10px 0;width:100%;" class="table table-hover table-condensed table-highlight table-striped data" id="browsetable">
	<tr>
		<th>name</th>
		<th>adddate</th>
		<th>grabs</th>
		<th>size</th>
	</tr>

	{foreach from=$releaselist item=release}
	<tr class="{cycle values=",alt"}">

		<td title="{$release.releasename}">
			{if $release.guid}
			<a href="{$smarty.const.WWW_TOP}/details/{$release.guid}/">{$release.searchname|escape:"htmlall"|wordwrap:75:"\n":true}</a>
			{else}
			{$release.searchname|escape:"htmlall"|wordwrap:75:"\n":true}
			{/if}
		</td>
		<td class="less">{$release.adddate|date_format}</td>
		<td class="less">
			{$release.grabs}
		</td>
		<td class="less">
			{$release.size|fsize_format:"MB"}
		</td>
	</tr>
	{/foreach}



</table>
<div class="clearfix" style="margin: 15px 0">
	{$pager}
</div>

{else}
<p>No releases available.</p>
{/if}
