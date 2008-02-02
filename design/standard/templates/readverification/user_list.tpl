<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{"List of users registered for read verification"|i18n('design')}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<table class="list">
<tr>
    <th>Name</th>
    <th>Details</th>
</tr>
{foreach $users as $user sequence array( 'bglight', 'bgdark' ) as $sequence}
<tr class="{$sequence}">
    <td><a href={$user.main_node.url_alias|ezurl}>{$user.name|wash}</a></td>
    <td><a href={concat( '/readverification/user/', $user.id )|ezurl}>Read verification details</a></td>
</tr>
{/foreach}
</table>

{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>{* class="context-block" *}