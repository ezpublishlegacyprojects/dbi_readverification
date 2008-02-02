{let $unread_objects=fetch( 'readverification', 'unread_objects' )}
<p>You have {$unread_objects|count} objects to read.</p>
<ul>
{foreach $unread_objects as $unread_object}
    <li><a href={$unread_object.main_node.url_alias|ezurl}>{$unread_object.name|wash}</a></li>
{/foreach}
</ul>
{/let}