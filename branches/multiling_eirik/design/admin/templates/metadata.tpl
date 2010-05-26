{* MetaData window. *}
{def $meta_data_list = fetch( 'fezmetadata', 'list_by_node_id', hash( node_id, $node.node_id ) )
	 $can_remove = false()
	 $fmd_can_create=fetch( 'content', 'access', hash( 'access', 'edit', 'contentobject', $node.object ) )
}
<form name="metadatasform" method="post" action={'content/action'|ezurl}>
<input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
<input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
<input type="hidden" name="ViewMode" value="{$viewmode|wash}" />
<input type="hidden" name="ContentObjectLanguageCode" value="{$language_code|wash}" />

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{'Meta Data [%meta_data]'|i18n( 'design/admin/node/view/full',, hash( '%meta_data', $meta_data_list|count ) )}</h2>


{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{def $language_list=ezini( 'Language', 'List', 'ezmetadata.ini' )}
<table class="list" cellspacing="0">
	<tr>
    	<th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.metadatasform, 'MetaDataIDSelection[]' ); return false;"/></th>
		<th class="wide">{'Name'|i18n('fezmetadata')}</th>
		<th class="wide">{'Value'|i18n('fezmetadata')}</th>
		<th class="wide">{'Language'|i18n('fezmetadata')}</th>
		<th class="edit">&nbsp;</th>
	</tr>
	{foreach $meta_data_list as $meta_data sequence array( bglight, bgdark ) as $sequence}
		<tr class="{$sequence}">
			{* Remove. *}
    		<td>
			    {if $meta_data.can_remove}
        			<input type="checkbox" name="MetaDataIDSelection[]" value="{$meta_data.id}" title="{'Select meta data for removal.'|i18n( 'design/admin/node/view/full' )}" />
        			{set can_remove=true()}
			    {else}
			        <input type="checkbox" name="MetaDataIDSelection[]" value="{$meta_data.id}" disabled="disabled" title="{'This meta data cannot be removed either because you do not have permission to remove it or because it is currently being displayed.'|i18n( 'design/admin/node/view/full' )}" />
			    {/if}
		    </td>
			<td>
				{$meta_data.name}
			</td>
			<td>
				{$meta_data.value}
			</td>
			<td>
				{$language_list[$meta_data.language]} ({$meta_data.language})
			</td>
			<td>
			{section show=$meta_data.can_edit}
            <a href={concat( 'fezmetadata/edit/', $meta_data.id)|ezurl}><img src={'edit.gif'|ezimage} alt="{'Edit'|i18n( 'design/admin/node/view/full' )}" title="{'Edit <%child_name>.'|i18n( 'design/admin/node/view/full',, hash( '%child_name', $child_name ) )|wash}" /></a>
        {section-else}
            <img src={'edit-disabled.gif'|ezimage} alt="{'Edit'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to edit %child_name.'|i18n( 'design/admin/node/view/full',, hash( '%child_name', $child_name ) )|wash}" />
        {/section}
			</td>
		</tr>
	{/foreach}
	{if $meta_data_list|count|eq(0)}
		<tr>
			<td colspan="4">
				<p>{'No Meta Data stored for this object'|i18n( 'fezmetadata' )}</p>
			</td>
		</tr>
	{/if}
</table>

{* DESIGN: Content END *}</div></div></div>
<div class="controlbar">

{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">

<div class="block">
<div class="button-left">
    {if $can_remove}
    <input class="button" type="submit" name="RemoveMetaDataButton" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" title="{'Remove selected locations from the list above.'|i18n( 'design/admin/node/view/full' )}" />
    {else}
    <input class="button-disabled" type="submit" name="RemoveMetaDataButton" value="{'Remove selected'|i18n( 'design/admin/node/view/full' )}" title="{'There is no removable location.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
    {/if}

	{if $fmd_can_create}
    <input class="button" type="submit" name="AddMetaDataButton" value="{'Add meta data'|i18n( 'design/admin/node/view/full' )}" title="{'Add one new meta data.'|i18n( 'design/admin/node/view/full' )}" />
    {else}
    <input class="button-disabled" type="submit" name="AddMetaDataButton" value="{'Add meta data'|i18n( 'design/admin/node/view/full' )}" title="{'It is not possible to add a meta data.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
    {/if}

</div>

<div class="button-right"></div>

<div class="break"></div>
</div>

{* DESIGN: Control bar END *}</div></div></div></div></div></div>


</form>

{undef $can_create $can_remove $meta_data_list}
