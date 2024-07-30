<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Brand_Area_Widget extends Widget_Base {

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
        return 'appgenix-brand-area-widget';
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
        return esc_html__( 'Appgenix Brand Area', 'appgenix-master' );
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
            'brand_area_content',
            [
                'label' => esc_html__( 'Brand Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Brand Logo List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name'        => 'brand_logo',
                        'label'       => esc_html__( 'Brand Logo', 'appgenix-master' ),
                        'type'        => Controls_Manager::MEDIA,
                        'description' => esc_html__( 'Choose Brand Logo', 'appgenix-master' ),
                        'default'     => [
                            'url' => Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'name' => 'brand_link',
                        'label' => esc_html__( 'Brand Link', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'placeholder' => esc_html__( 'https://your-link.com', 'appgenix-master' ),
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '#',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                        'label_block' => true,
                    ],
                ],
            ]
        );

        $this->end_controls_section();

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
        <!-- brand area start -->
        <div class="brand_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="brand__wrap">
                            <div class="global-slick-init brand-slider slider-inner-margin" data-arrows="false" data-infinite="true" data-dots="false" data-slidesToShow="5" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500"
                                 data-prevArrow='<div class="prev-icon"><i class="fa-solid fa-arrow-left"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 4}},{"breakpoint": 1200,"settings": {"slidesToShow": 4}},{"breakpoint": 992,"settings": {"slidesToShow": 3}},{"breakpoint": 768,"settings": {"slidesToShow": 2}},{"breakpoint": 576, "settings": {"slidesToShow": 2} }]'>
                                <?php
                                if ( $settings['list'] ) :
                                    foreach ( $settings['list'] as $item ) :
                                        $image_url = ! empty( $item['brand_logo']['url'] ) ? $item['brand_logo']['url'] : '';
                                        $image_alt = ! empty( $item['brand_logo']['alt'] ) ? $item['brand_logo']['alt'] : '';
                                        $brand_link = ! empty( $item['brand_link']['url'] ) ? $item['brand_link']['url'] : '';
                                        ?>
                                        <div class="slick__item">
                                            <div class="brand__thumb">
                                                <a href="<?php echo esc_url( $brand_link ); ?>">
                                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( $image_alt ); ?>">
                                                </a>
                                            </div>
                                        </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- brand area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Brand_Area_Widget() );