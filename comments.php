<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area" >
    <div class="title"><?php _e('Отзывы и вопросы', 'mz')?></div>
    <?php
        if(!have_comments()){
	        if ( LOCALE == 'ru' ) {
		        echo 'Пока что нет отзывов';
	        } else if ( LOCALE == 'ua' ) {
		        echo 'Поки що немає відгуків';
	        }
        }
    ?>


    <div class="rowFlex jc-sb-md">
        <div class="colFlex col-md-8">

            <?php
            // You can start editing here -- including this comment!
            if ( have_comments() ) :
                ?>

                <?php the_comments_navigation(); ?>

                <ol class="comment-list">
                    <?php
                    wp_list_comments( [
                        'walker'            => new Doctor_Walker_Comment(),
                        'max_depth'         => 2,
                        'style'             => 'ul',
                        'callback'          => null,
                        'end-callback'      => null,
                        'type'              => 'all',
                        'reply_text'        => __('ответить'),
                        'page'              => '',
                        'per_page'          => '',
                        'avatar_size'       => null,
                        'reverse_top_level' => null,
                        'reverse_children'  => '',
                        'format'            => 'html5', // или xhtml, если HTML5 не поддерживается темой
                        'short_ping'        => false,    // С версии 3.6,
                        'echo'              => true,     // true или false
                    ] );
                    ?>
                </ol><!-- .comment-list -->

                <?php
                the_comments_navigation();

                // If comments are closed and there are comments, let's leave a little note, shall we?
                if ( ! comments_open() ) :
                    ?>
                    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mz' ); ?></p>
                <?php
                endif;

            endif; // Check for have_comments().
            ?>
        </div>
        <div class="colFlex col-md-3 d-md-block">

            <?php
            $defaults = [
                'fields' => [
                    'author' => '
                    <label class="input-form">
			                ' . __('Name') . ($req ? ' <span class="required">*</span>' : '') . '
			            <input id="author" class="review-name" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' .
                        $aria_req .
                        $html_req . ' />
		            </label>',
                    'email' => '
                <label class="input-form">
			            ' . __('Email') . ($req ? ' <span class="required">*</span>' : '') . '
			        <input id="email" class="review-name" name="email" type="email"  placeholder="yourmail@mail.com" value="" ' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-describedby="email-notes"' .
                        $aria_req . $html_req . ' />
		        </label>',
                ],
                'comment_field' => '
                <label class="textarea-form">
		            ' . _x('Comment', 'noun') . '
		            <textarea id="comment" class="review-review" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea>
	            </label>',
                'comment_notes_before' => '',
                'id_form' => 'commentform',
                'id_submit' => 'submit',
                'class_form' => 'form-default',
                'title_reply'  => __('Написать отзыв или задать вопрос', 'mz'),
                'title_reply_to' => '',
                'class_submit' => 'btn',
                'name_submit' => 'submit',
                'label_submit' => __( 'отправить', 'mz'),
                'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"/>%4$s</button>',
                'submit_field' => '<p class="text-center">%1$s %2$s</p>',
                'format' => 'html5',
            ];
            comment_form( $defaults );
            ?>

        </div>
    </div>
</div><!-- #comments -->