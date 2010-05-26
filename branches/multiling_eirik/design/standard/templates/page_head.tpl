{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{*?template charset=latin1?*}
{default enable_help=true() enable_link=true()}

{let name=Path
     path=$module_result.path
     reverse_path=array()}
  {section show=is_set($module_result.title_path)}
    {set path=$module_result.title_path}
  {/section}
  {section loop=$:path}
    {set reverse_path=$:reverse_path|array_prepend($:item)}
  {/section}

{set-block scope=root variable=site_title}
{section loop=$Path:reverse_path}{$:item.text|wash}{delimiter} / {/delimiter}{/section} - {$site.title|wash}
{/set-block}

{/let}

	<!-- EIRIK META -->

    <title>{$site_title}</title>

    {section show=and(is_set($#Header:extra_data),is_array($#Header:extra_data))}
      {section name=ExtraData loop=$#Header:extra_data}
      {$:item}
      {/section}
    {/section}

    {* check if we need a http-equiv refresh *}
    {section show=$site.redirect}
    <meta http-equiv="Refresh" content="{$site.redirect.timer}; URL={$site.redirect.location}" />

    {/section}

    {section name=HTTP loop=$site.http_equiv}
    <meta http-equiv="{$HTTP:key|wash}" content="{$HTTP:item|wash}" />

    {/section}

	{def $meta_data_list = fetch( fezmetadata, list_by_node_id, hash( node_id, $module_result.node_id, language, ezini( 'RegionalSettings', 'Locale', 'site.ini' ) ) )}
	{foreach $meta_data_list as $meta_data}
		<meta name="{$meta_data.meta_name|wash}" content="{$meta_data.meta_value|wash}" />
	{/foreach}
	{undef $meta_data_list}

	{def $available_meta_data=ezini( 'MetaData', 'AvailablesMetaData', 'ezmetadata.ini' )}
    {section name=meta loop=$site.meta}
		{if not( $available_meta_data|contains( $meta:key ) )}
		    <meta name="{$meta:key|wash}" content="{$meta:item|wash}" />
		{/if}
    {/section}
	{undef $available_meta_data}

    <meta name="MSSmartTagsPreventParsing" content="TRUE" />
    <meta name="generator" content="eZ Publish" />

{section show=$enable_link}
    {include uri="design:link.tpl" enable_help=$enable_help enable_link=$enable_link}
{/section}

{/default}
