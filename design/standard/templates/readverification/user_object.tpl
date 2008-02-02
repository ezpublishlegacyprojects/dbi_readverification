<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{"Read verification history of '%objectname' for user '%username'"|i18n('design', '', hash( '%username', $user.contentobject.name|wash, '%objectname', $object.name|wash ) )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Version</th>
    <th>Modified</th>
    <th>Status</th>
    <th>Read</th>
</tr>
{foreach $version_info as $version_info_item sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td>{$version_info_item.contentobject_version.version}</td>
    <td>{$version_info_item.contentobject_version.modified|l10n( shortdatetime )}</td>
    <td>{$version_info_item.contentobject_version.status|choose( 'Draft'|i18n( 'design/admin/content/history' ), 'Published'|i18n( 'design/admin/content/history' ), 'Pending'|i18n( 'design/admin/content/history' ), 'Archived'|i18n( 'design/admin/content/history' ), 'Rejected'|i18n( 'design/admin/content/history' ), 'Untouched draft'|i18n( 'design/admin/content/history' ) )}</td>
    <td>{if is_set($version_info_item.contentobjectversion_readverification)}{$version_info_item.contentobjectversion_readverification.time|l10n( shortdatetime )}{/if}</td>
</tr>
{/foreach}
</table>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>{* class="context-block" *}