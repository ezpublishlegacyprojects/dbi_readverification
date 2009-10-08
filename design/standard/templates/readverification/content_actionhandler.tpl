{default $current_user			=	fetch( 'user', 'current_user' )
		 $policies				=	fetch( 'user', 'user_role', hash( 'user_id', $current_user.contentobject_id ) )
		 $view_user_permission	=	false() }

{let $status=fetch('readverification','status',hash('object_id', $node.contentobject_id ))}

{cache-block keys=array( $current_user.contentobject_id, $node.contentobject_id, $status )}
{foreach $policies as $policy}
	{if and( eq( $policy.moduleName, 'readverification' ),
			 eq( $policy.functionName, 'user_info' ) )}
		{set $view_user_permission = true()}
	{elseif or( and( eq( $policy.moduleName, '*' ),
					 eq( $policy.functionName, '*' ) ),
				and( eq( $policy.moduleName, 'readverification' ),
					 eq( $policy.functionName, '*' ),
					 eq( $policy.limitation, '*' )) )}
		{set $view_user_permission = true()}
	{/if}
{/foreach}

{switch match=$status}
{case match=0}
<input type="submit" class="button" name="VerifyAsReadButton" value="Mark as read" />
{/case}
{case match=1}
You have marked this object as read. {if $view_user_permission}<a href={concat("/readverification/user/", $current_user.contentobject_id, "/", $node.contentobject_id)|ezurl}>View details</a>.{/if}
{/case}
{case}

{/case}
{/switch}

{/cache-block}

{/let}

{/default}
