<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{"Objects to be read by user '%username'"|i18n('design', '', hash( '%username', $user.contentobject.name|wash ) )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Name</th>
    <th>Published</th>
    <th>Modified</th>
    <th>Status</th>
    <th>Details</th>
</tr>
{foreach $unread_objects as $unread_object sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td>{if $unread_object.status|eq(1)}<a href={$unread_object.main_node.url_alias|ezurl}>{$unread_object.name|wash}</a>{else}{$unread_object.name|wash}{/if}</td>
    <td>{$unread_object.published|l10n( shortdatetime )}</td>
    <td>{$unread_object.modified|l10n( shortdatetime )}</td>
    <td>{$unread_object.status|choose( 'Draft'|i18n( 'design/admin/content/history' ), 'Published'|i18n( 'design/admin/content/history' ), 'Trashed'|i18n( 'design/admin/content/history' ))}</td>
    <td><a href={concat( '/readverification/user/', $user.contentobject_id, '/', $unread_object.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>{* class="context-block" *}


<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Read by user '%username'"|i18n('design', '', hash( '%username', $user.contentobject.name|wash ) )}</h1>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Name</th>
    <th>Published</th>
    <th>Modified</th>
    <th>Status</th>
    <th>Details</th>
</tr>
{foreach $read_objects as $read_object sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td>{if $read_object.status|eq(1)}<a href={$read_object.main_node.url_alias|ezurl}>{$read_object.name|wash}</a>{else}{$read_object.name|wash}{/if}</td>
    <td>{$read_object.published|l10n( shortdatetime )}</td>
    <td>{$read_object.modified|l10n( shortdatetime )}</td>
    <td>{$read_object.status|choose( 'Draft'|i18n( 'design/admin/content/history' ), 'Published'|i18n( 'design/admin/content/history' ), 'Trashed'|i18n( 'design/admin/content/history' ))}</td>
    <td><a href={concat( '/readverification/user/', $user.contentobject_id, '/', $read_object.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>


{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>