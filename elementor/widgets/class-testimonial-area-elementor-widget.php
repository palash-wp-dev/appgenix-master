<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Testimonial_Area_Widget extends Widget_Base {

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
        return 'appgenix-testimonial-area-widget';
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
        return esc_html__( 'Appgenix Testimonial Area', 'appgenix-master' );
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
            'testimonial_area_content',
            [
                'label' => esc_html__( 'Testimonial Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'What Say our Customers About Us', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Testimonial List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => esc_html__( 'Name', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Angela Melody' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'designation',
                        'label' => esc_html__( 'Designation', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'UX Designer' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'review',
                        'label' => esc_html__( 'Review', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => esc_html__( 'Phasellus consectetur aliquet augue non ultrices. Nunc mattis congue ante a feugiat. Pellentesque commodo cursus eros, suscipit mollis velit consequat ' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'rating',
                        'label' => esc_html__( 'Star', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 5,
                        'min' => 1,
                        'max' => 5,
                        'step' => 0.5,
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'image',
                        'label'       => esc_html__( 'Image', 'appgenix-master' ),
                        'type'        => Controls_Manager::MEDIA,
                        'description' => esc_html__( 'Choose Image', 'appgenix-master' ),
                        'default'     => [
                            'url' => Utils::get_placeholder_image_src()
                        ]
                    ],
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Function to create star rating
     *
     * @since 1.0.0
     * @access protected
     */
    private function starRating( $rating, $echo = true ) {
        $starRating = '';
        $j = 0;
        for( $i = 0; $i <= 4; $i++ ) {
            $j++;
            if( $rating  >= $j   || $rating  == '5'   ) {
                $starRating .= '<i class="fas fa-star"></i>';
            }
            elseif( $rating < $j && $rating  > $i ) {
                $starRating .= '<i class="fas fa-star-half-alt"></i>';
            }
        }
        if( $echo == true ) {
            echo $starRating;
        } else {
            return $starRating;
        }
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
        <!-- Testimonial area start -->
        <section class="testimonial_area bg-image pat-100 pab-100" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/testimonial/testimonial_bg.jpg);">
            <div class="container">
                <div class="new_sectionTitle">
                    <h2 class="title">What Say our Customers About Us</h2>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="global-slick-init slider-inner-margin dot_one" data-centerMode="true" data-centerPadding="0px" data-slidesToShow="3" data-infinite="true" data-arrows="false" data-dots="true" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fas fa-arrow-left"></i></div>'
                             data-nextArrow='<div class="next-icon"><i class="fas fa-arrow-right"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 3}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 768,"settings": {"slidesToShow": 2}},{"breakpoint": 576, "settings": {"slidesToShow": 1} }]'>
                            <?php
                            if ( ! empty( $settings['list'] ) ) :
                                foreach ( $settings['list'] as $item ) :
                                    $image_url = ! empty( $item['image']['url'] ) ? $item['image']['url'] : '';
                                    $image_alt = ! empty( $item['image']['alt'] ) ? $item['image']['alt'] : '';
                            ?>
                            <div class="slick_item">
                                <div class="testimonial_single radius-10">
                                    <div class="testimonial_single__author">
                                        <div class="testimonial_single__author__thumb">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( $image_alt ); ?>">
                                        </div>
                                        <div class="testimonial_single__author__contents">
                                            <h5 class="testimonial_single__author__title"><?php echo esc_html($item['name']); ?></h5>
                                            <p class="testimonial_single__author__para mt-2"><?php echo esc_html($item['designation']); ?></p>
                                        </div>
                                    </div>
                                    <p class="testimonial_single__para mt-4"><?php echo esc_html($item['review']); ?> </p>

                                    <div class="testimonial_single__icon mt-3">
                                        <?php
                                        // display the star rating
                                        $rating = $item['rating'];
                                        $echo = true;
                                        $this->starRating( $rating, $echo )
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Testimonial_Area_Widget() );