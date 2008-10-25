<style type="text/css">
{literal}
	#leftmenu
	{
		display:none;
	}

	div#maincontent
	{
		margin-left:0;
	}
{/literal}
</style>

<form enctype="multipart/form-data" method="post" action={concat("/fezmetadata/edit/",first_set( $object.id, 0))|ezurl}>

<!-- Maincontent START -->

<div class="content-edit">
	<div class="context-block">
		<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
			<h1 class="context-title">{'Update this Meta Data'|i18n('fezmetadata')}</h1>
			<div class="header-mainline"></div>
		</div></div></div></div></div></div>

		<div class="box-ml"><div class="box-mr"><div class="box-content">
			<div class="context-information">
				<p class="translation">        
							</p>
				<div class="break"></div>
			</div>

			<div class="context-attributes">
			    <div class="block">
					<label for="metadata_name">{'Metadata name'|i18n('fezmetadata')}:</label>
					<select id="metadata_name" class="box" name="metaDataName" value="{$object.meta_name}">
						{def $availables_metadata=ezini( 'MetaData', 'AvailablesMetaData', 'ezmetadata.ini' ) }
							{foreach $availables_metadata as $metadata}
								<option value="{$metadata}"{if $object.meta_name|eq($metadata)} selected="selected"{/if}>{$metadata}</option>
							{/foreach}
						{undef $availables_metadata}
					</select>
				</div>
				<div class="block">
					<label for="metadata_value">{'Metadata value'|i18n('fezmetadata')}:</label>
					<input id="metada_value" class="box" type="text" size="70" name="metaDataValue" value="{$object.value}" />
				</div>
			</div>
		</div></div></div>
		<div class="controlbar">
<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block">
	<input type="hidden" name="MetaID" value="{$object.id}" />
	<input type="hidden" name="ContentObjectID" value="{$object.contentobject_id}" />
    <input class="button" type="submit" name="PublishButton" value="{'Send for publishing'|i18n( 'design/admin/content/edit' )}" title="{'Publish the contents of the draft that is being edited. The draft will become the published version of the object.'|i18n( 'design/admin/content/edit' )}" />
    <input class="button" type="submit" name="DiscardButton" value="{'Discard draft'|i18n( 'design/admin/content/edit' )}" onclick="return confirmDiscard( '{'Are you sure you want to discard the draft?'|i18n( 'design/admin/content/edit' )}' );" title="{'Discard the draft that is being edited. This will also remove the translations that belong to the draft (if any).'|i18n( 'design/admin/content/edit' ) }" />
    <input type="hidden" name="DiscardConfirm" value="1" />
</div>
</div></div></div></div></div></div>
</div>

</div>

</div>
<div class="break"></div>

</form>
