<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to milano_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>
<div class="all_comments">
	<?php if ( have_comments() ) : ?>
		<div class="comments_list_box">

			<h6 class="comments-title title6">
				<?php
					printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'milano' ),
						number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h6>

			<ul class="commentlist">
				<?php wp_list_comments(array('walker' => new Walker_Comments)); ?>
			</ul><!-- .commentlist -->
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-below" class="navigation" role="navigation">
					<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'milano' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'milano' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'milano' ) ); ?></div>
				</nav>
			<?php endif; // check for comment navigation ?>
		</div> <!-- .comments_list_box -->
		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'milano' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<div id="comments" class="comments-area">
		<?php // You can start editing here -- including this comment! ?>

		<?php 
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? ' aria-required="true"' : '' );
		$name = __( 'Name', 'milano'  ) . ($req?'*':'');
		$email = __( 'Email', 'milano'  ) . ($req?'*':'');
		$url = __( 'Website', 'milano'  );

		comment_form(array(
			'comment_field' => '<p class="comment-form-comment">
									<label for="comment">' . __('Comment', 'milano' ) . '</label>
									<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" aria-required="true"></textarea>
									<label class="error" style="display: none;">' . __('This field is required','milano') . '.</label>
								</p>',
			'fields' => apply_filters( 'comment_form_default_fields', array(  
				'author'=> '<p class="comment-form-author">' . 
						'<input id="author" name="author" type="text" value="' . $name . '"
							data-default="' . $name . '"
							onBlur="if(this.value==\'\') this.value=\'' . $name . '\';"
							onFocus="if(this.value ==\'' . $name . '\' ) this.value=\'\';" size="30"' . $aria_req . ' />
							<label class="error" style="display: none;">' . __('This field is required','milano') . '.</label></p>',  
				'email' => '<p class="comment-form-email">' . 
						'<input id="email" name="email" type="text" value="' . $email . '"
							data-default="' . $email . '"
							onBlur="if(this.value==\'\') this.value=\'' . $email . '\';"
							onFocus="if(this.value ==\'' . $email . '\' ) this.value=\'\';" size="30" ' . $aria_req . ' />
							<label class="error" style="display: none;">' . __('This field is required','milano') . '.</label></p>',
				'url'	=> '<p class="comment-form-url">' .
						'<input id="url" name="url" type="text" value="' . $url . '" 
							onBlur="if(this.value==\'\') this.value=\'' . $url . '\';"
							onFocus="if(this.value ==\'' . $url . '\' ) this.value=\'\';" size="30" /></p>'
				 ))
		));
		?>
		<script type="text/javascript">
			jQuery('#commentform').submit(function(e) {
				var regular = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				var error = false;
				jQuery('#commentform').find('[aria-required="true"]').each(function(){
					if( jQuery(this).val() == '' || 
						jQuery(this).val() == jQuery(this).data('default') ||
						(jQuery(this).attr('id') == 'email' && !regular.test(jQuery(this).val()))
					){
						jQuery(this).parent().find('.error').show();
						error = true;
					} else {
						jQuery(this).parent().find('.error').hide();
					}
				});
				if(error){
					e.preventDefault();
				}
			});

		</script>

	</div><!-- #comments .comments-area -->
</div>
