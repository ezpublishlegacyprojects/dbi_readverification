{default $current_user=fetch( 'user', 'current_user' )}

{let $status=fetch('readverification','status',hash('object_id', $node.contentobject_id ))}

{switch match=$status}
{case match=0}
<input type="submit" class="button" name="VerifyAsReadButton" value="Mark as read" />
{/case}
{case match=1}
You have marked this object as read. <a href={concat("/readverification/user/", $current_user.contentobject_id, "/", $node.contentobject_id)|ezurl}>View details</a>.
{/case}
{case}

{/case}
{/switch}

{/let}

{/default}