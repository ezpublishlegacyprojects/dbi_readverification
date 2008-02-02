<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{"List of objects registered for read verification"|i18n('design')}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<form method="post" action={"/readverification/object_list"|ezurl}>
<select name="SortField">
    <option value="c.identifier" {if $sortField|eq('c.identifier')}selected="selected"{/if}>Class</option>
    <option value="o.name" {if $sortField|eq('o.name')}selected="selected"{/if}>Name</option>
    <option value="o.modified" {if $sortField|eq('o.modified')}selected="selected"{/if}>Modified</option>
</select>

<select name="SortOrder">
    <option value="asc" {if $sortOrder|eq('asc')}selected="selected"{/if}>Ascending</option>
    <option value="desc" {if $sortOrder|eq('desc')}selected="selected"{/if}>Descending</option>
</select>

<input type="submit" name="SortButton" value="Order" />
</form>

<table class="list">
<tr>
    <th>Name</th>
    <th>Content class</th>
    <th>Status</th>
    <th>Modified</th>
    <th>Details</th>
</tr>
{foreach $objects as $object sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td>{if $object.status|eq(1)}<a href={$object.main_node.url_alias|ezurl}>{$object.name|wash}</a>{else}{$object.name|wash}{/if}</td>
    <td>{$object.class_name|wash}</td>
    <td>{$object.status|choose( 'Draft'|i18n( 'design/admin/content/history' ), 'Published'|i18n( 'design/admin/content/history' ), 'Trashed'|i18n( 'design/admin/content/history' ))}</td>
    <td>{$object.modified|l10n( shortdatetime )}</td>
    <td><a href={concat( '/readverification/object/', $object.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>{* class="context-block" *}