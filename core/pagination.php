<?php

function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {
        if ($paged == 1) {
            $prev_link = get_pagenum_link(1);
        } else {
            $prev_link = get_pagenum_link($paged - 1);
        }
        echo "<li class=\"pagination__item-prev\">
                            <a href='". $prev_link ."' class=\"pagination__link arrow-cast-left\"></a>
                        </li>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "";
        if($paged > 1 && $showitems < $pages) echo "";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<li class=\"pagination__item\"><a class=\"pagination__item-link active\" href='javascript:void(0);'>$i</a></li>":"<li class=\"pagination__item\"><a class=\"pagination__item-link\" href='".get_pagenum_link($i)."'>$i</a></li>";
            }
        }

        if ($paged < $pages && $showitems < $pages) echo "";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "";
        if ($paged == $pages) {
            $next_link = get_pagenum_link($paged);
        } else {
            $next_link = get_pagenum_link($paged + 1);
        }
        echo "<li class=\"pagination__item-next\">
                 <a href='". $next_link ."' class=\"pagination__link arrow-cast-right\"></a>
              </li>";
    }
}

function blog_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_tax('blog') ) {
        $query->set( 'posts_per_page', 10 );
    }
}

add_action( 'pre_get_posts', 'equipment_posts_per_page' );

function equipment_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive('equipment') ) {
        $query->set( 'posts_per_page', 5 );
    }
}

add_action( 'pre_get_posts', 'equipment_posts_per_page' );

function reviews_posts_per_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive('reviews') ) {
        $query->set( 'posts_per_page', 20 );
    }
}

add_action( 'pre_get_posts', 'reviews_posts_per_page' );
