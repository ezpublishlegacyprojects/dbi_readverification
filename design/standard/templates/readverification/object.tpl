<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{"Users who need to read '%objectname'"|i18n('design', '', hash( '%objectname', $object.name|wash ) )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Name</th>
    <th>Details</th>
</tr>
{foreach $unread_users as $unread_user sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td><a href={$unread_user.main_node.url_alias|ezurl}>{$unread_user.name|wash}</a></td>
    <td><a href={concat( '/readverification/user/', $unread_user.id, '/', $object.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>{* class="context-block" *}


<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Users who have read the object '%objectname'"|i18n('design', '', hash( '%objectname', $object.name|wash ) )}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Name</th>
    <th>Details</th>
</tr>
{foreach $read_users as $read_user sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td><a href={$read_user.main_node.url_alias|ezurl}>{$read_user.name|wash}</a></td>
    <td><a href={concat( '/readverification/user/', $read_user.id, '/', $object.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>


{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>
