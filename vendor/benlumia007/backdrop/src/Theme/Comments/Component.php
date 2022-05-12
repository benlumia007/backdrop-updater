<?php
/**
 * Backdrop Core ( src/Component/Customize.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Benlumia007\Backdrop\Theme\Comments;

class Component {
    public static function display_comments_list( $comment, $args, $depth ) { ?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children' ] ) ? '' : 'parent' ); ?>>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <header class="comment-meta">
                    <div class="comment-author vcard">
                        <?php if ( $args[ 'avatar_size' ] != 0 ) : ?>
                            <?php echo get_avatar( $comment, $args[ 'avatar_size' ] ); ?>
                            <cite class="fn"><?php echo get_comment_author_link(); ?></cite>
                            <div class="comment-metadata">
                                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                                    <?php
                                        /* translators: 1: date, 2: time */
                                        printf( __('%1$s at %2$s'), 
                                        get_comment_date(),  
                                        get_comment_time() 
                                    ); 
                                    ?>
                                </a>
                                <span class="reply">
                                    <?php 
                                        comment_reply_link( array_merge( $args, [
                                            'add_below' => 'div-comment',
                                            'depth'     => $depth, 
                                            'max_depth' => $args['max_depth'] 
                                        ] ) );
                                    ?>
                                </span>
                                <?php 
            if ( $comment->comment_approved == '0' ) { ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
            } ?>
                            </div>
                        <?php endif ?>
                    </div>
                </header>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
            </div>
    <?php }
}