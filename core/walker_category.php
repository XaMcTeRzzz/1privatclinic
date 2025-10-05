<?php


class My_Walker_Category extends Walker {

    /**
     * What the class handles.
     *
     * @since 2.1.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'category';

    /**
     * Database fields to use.
     *
     * @since 2.1.0
     * @var array
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );

    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string  $output   Used to append additional content (passed by reference).
     * @param WP_Term $category Category data object.
     * @param int     $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array   $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int     $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

        // Don't generate an element if the category name is empty.
        if ( '' === $cat_name ) {
            return;
        }

        $atts         = array();
        $atts['href'] = get_term_link( $category );

        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string  $description Category description.
             * @param WP_Term $category    Category object.
             */
            $atts['title'] = strip_tags( apply_filters( 'category_description', $category->description, $category ) );
        }

        /**
         * Filters the HTML attributes applied to a category list item's anchor element.
         *
         * @since 5.2.0
         *
         * @param array   $atts {
         *     The HTML attributes applied to the list item's `<a>` element, empty strings are ignored.
         *
         *     @type string $href  The href attribute.
         *     @type string $title The title attribute.
         * }
         * @param WP_Term $category Term data object.
         * @param int     $depth    Depth of category, used for padding.
         * @param array   $args     An array of arguments.
         * @param int     $id       ID of the current category.
         */
        $atts = apply_filters( 'category_list_link_attributes', $atts, $category, $depth, $args, $id );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $link = sprintf(
            '<span>%s</span>',

            $cat_name
        );

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';

            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

            if ( empty( $args['feed'] ) ) {
                /* translators: %s: Category name. */
                $alt = ' alt="' . sprintf( __( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
            } else {
                $alt   = ' alt="' . $args['feed'] . '"';
                $name  = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }

            $link .= '>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . esc_url( $args['feed_image'] ) . "'$alt" . ' />';
            }
            $link .= '</a>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
        if (! empty( $args['parent-accordion'] ) ) {


            if($depth == 0 && $category->count > 1){
                $link .= '<button class="parent-accordion-arrow">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 10L12 14L16 10" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </button>';
            }
        }
        if (! empty( $args['data-term-id'] ) ) {
            $link  = str_replace( '<span', '<span data-term-id="' .$category->term_id.'"' , $link );
        }


        if ( ! empty( $args['show_count'] ) ) {
            $link .= ' (' . number_format_i18n( $category->count ) . ')';
        }
        if ( 'list' === $args['style'] ) {
            $output     .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );

            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms(
                    array(
                        'taxonomy'   => $category->taxonomy,
                        'include'    => $args['current_category'],
                        'hide_empty' => false,
                    )
                );

                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                        $link          = str_replace( '<a', '<a aria-current="page"', $link );
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param string[] $css_classes An array of CSS classes to be applied to each list item.
             * @param WP_Term  $category    Category data object.
             * @param int      $depth       Depth of page, used for padding.
             * @param array    $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
            $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

            $output .= $css_classes;
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.1.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param object $page   Not used.
     * @param int    $depth  Optional. Depth of category. Not used.
     * @param array  $args   Optional. An array of arguments. Only uses 'list' for whether should append
     *                       to output. See wp_list_categories(). Default empty array.
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $output .= "</li>\n";
    }

}


class Navigation_Catwalker extends Walker_Category {

// Configure the start of each level
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "";
    }

// Configure the end of each level
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "";
    }

// Configure the start of each element
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0) {

        // Set the category name and slug as a variables for later use
        $cat_name = esc_attr( $category->name );
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        $cat_slug = esc_attr( $category->slug );
        $n_depth = $depth + 1;
        $count = (int)number_format_i18n($category->count);
        $termchildren = get_term_children( $category->term_id, $category->taxonomy );
        $termId = $category->term_id;
        $class = '';
        $termType = $category->description;
        $arrow = '<button class="parent-accordion-arrow">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 10L12 14L16 10" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </button>';
        if($termType === 'C'){
            $cat_name.='&nbsp(чекап)';
        }
        if(count($termchildren)===0){
            $class .=  'i-dont-have-kids';
        }

        // Configure the output for the top list element and its URL

        if ( count($termchildren) > 0 ) {
            $link = '<span class="parent-category-dropdown" 
             data-term-type="'.$termType.'"'.'
             data-term-id="'.$termId.'"' . '>' . $cat_name . '</span>' .$arrow;
            $indent = str_repeat("\t", $depth);
            $output .= "\t<li class='parent-category $class' data-level='$n_depth'>$link\n$indent<ul class='children'>\n\n";
        }

        // Configure the output for lower level list elements and their URL's
        if ( count($termchildren)=== 0) {
            $link = '<span 
            data-term-id="'.$termId.'"' .' 
            data-term-type="'.$termType.'"'.'>' . $cat_name . '  </span>';
            $output .= "\t<li class='sub-category $class' data-level='$n_depth'>$link\n";
        }
    }

// Configure the end of each element
    function end_el(&$output, $category, $depth = 0,$args = array()) {
        $termchildren = get_term_children( $category->term_id, $category->taxonomy );
        if (count($termchildren)>0) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n\n";
        }
        if (count($termchildren)===0 ) {
            $output .= "</li>";
        }

    }




}
