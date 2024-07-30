<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Blog_Area_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve Elementor widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'appgenix-blog-area-widget';
    }

    /**
     * Get widget title.
     *
     * Retrieve Elementor widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__( 'Appgenix Blog Area', 'appgenix-master' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Elementor widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-apps';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Elementor widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories() {
        return [ 'appgenix_widgets' ];
    }

    /**
     * Register Elementor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function register_controls() {

        $this->start_controls_section(
            'blog_area_content',
            [
                'label' => esc_html__( 'Blog Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Update News & Blog', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per page', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -1,
                'max' => 50,
                'step' => 1,
                'default' => -1,
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Order', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'appgenix-master' ),
                    'DESC' => esc_html__( 'Descending', 'appgenix-master' ),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => esc_html__( 'Categories', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->all_categories(),
                'default' => [ 'title', 'description' ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Get all the categories of WP default post type.
     *
     *
     * @since 1.0.0
     * @access protected
     */
    private function all_categories() {
        $categories = get_categories();

        $category_names = [];

        foreach ( $categories as $category ) {
            $category_names[$category->term_id] = $category->name;
        }

        return $category_names;
    }

    /**
     * Render Elementor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <!-- Blog area start -->
        <div class="blog_area pat-100 pab-100">
            <div class="container">
                <div class="new_sectionTitle">
                    <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                </div>
                <div class="row g-4 mt-4">
                    <?php
                    $args = [
                        'post_type' => 'post',
                        'posts_per_page' => $settings['posts_per_page'],
                        'order' => $settings['order'],
                        'cat' => $settings['categories'],
                    ];
                    $query = new \WP_Query( $args );
                    if ( $query->have_posts() ) :
                        while ( $query->have_posts() ) :
                            $query->the_post();
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog__item radius-10">
                            <?php
                            if ( has_post_thumbnail() ) :
                                // Get the featured image URL.
                                $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),  'full' );
                                $featured_image_alt = get_post_meta( get_post_thumbnail_id(),  '_wp_attachment_image_alt',  true );

                                $archive_year  = get_the_time( 'Y' );
                                $archive_month = get_the_time( 'm' );
                                $archive_day   = get_the_time( 'd' );

                                $date_archive_link = get_day_link( $archive_year, $archive_month, $archive_day );
                            ?>
                            <div class="blog__item__thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $featured_image_url ); ?>" alt="<?php esc_attr_e( $featured_image_alt ); ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="blog__item__contents">
                                <div class="blog__item__contents__tag mb-3">
                                    <a href="<?php echo esc_url( $date_archive_link ); ?>" class="blog__item__contents__tag__item">
                                        <div class="blog__item__contents__tag__icon"><span class="material-symbols-outlined">schedule</span></div>
                                        <p class="blog__item__contents__tag__para"><?php echo get_the_date( 'd F Y' ); ?></p>
                                    </a>
                                    <?php
                                    $categories = $this->all_categories();

                                    $first_cat = reset($categories);

                                    $categories_for_link = get_the_category();

                                    if ( $categories_for_link ) {
                                        $first_category = reset($categories_for_link);

                                        // Get the category link.
                                        $category_link = get_category_link( $first_category->term_id );
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $category_link ); ?>" class="blog__item__contents__tag__item">
                                        <div class="blog__item__contents__tag__icon"><span class="material-symbols-outlined">label</span></div>
                                        <p class="blog__item__contents__tag__para"><?php printf( esc_html__( '%s', 'appgenix' ), $first_cat )?></p>
                                    </a>
                                </div>
                                <h4 class="blog__item__contents__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                            <div class="btn_wrapper blog__item__btn">
                                <a href="<?php the_permalink(); ?>" class="blog__item__btn__loadMore"><?php esc_html_e( 'Read More', 'appgenix-master' ); ?> <span class="material-symbols-outlined">arrow_right_alt</span></a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>
        <!-- Blog area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Blog_Area_Widget() );