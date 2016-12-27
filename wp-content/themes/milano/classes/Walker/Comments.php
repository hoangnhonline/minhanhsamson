<?php 
	class Walker_Comments extends Walker_Comment
	{
	    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
	        $depth++;
	        $GLOBALS['comment_depth'] = $depth;
	        $GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

	        $reply_args = array(
				'depth' => $depth,
				'max_depth' => $args['max_depth'] );

	        print '<li class="' . join( ' ', get_comment_class( $parent_class ) ) . '">'.
	        '<div class="wrapper" id="comment-' . get_comment_ID() . '">'
	        	.'<figure class="f_left">'
		        	.( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) :'' )
		        .'</figure>'
		        .'<div class="wrapper">'
		        	.'<strong>'.get_comment_author_link().'</strong>'
		        	.'<div class="coment_time">'.get_comment_time().' &middot; '.get_comment_reply_link( array_merge( $args, $reply_args ) ).'</div>'
		        .'</div>'.'<div class="comment_text">';
			comment_text();
			print '</div>'
		    .'</div>'
		    ;
	    }
	}
?>