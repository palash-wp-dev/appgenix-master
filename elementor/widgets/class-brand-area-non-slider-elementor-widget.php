<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Brand_Area_Non_Slider_Widget extends Widget_Base {

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
        return 'appgenix-brand-area-non-slider-widget';
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
        return esc_html__( 'Appgenix Brand Area Non-Slider', 'appgenix-master' );
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
            'brand_area_non_slider_content',
            [
                'label' => esc_html__( 'Promo Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Worldwide Trusted Clients', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Brand Area Non-Slider List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name'        => 'brand_image',
                        'label'       => esc_html__( 'Choose Image', 'appgenix-master' ),
                        'type'        => Controls_Manager::MEDIA,
                        'default'     => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                    ],
                    [
                      'name' => 'brand_link',
                        'label' => esc_html__( 'Brand Link', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '',
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
        <div class="brand_area pat-50 pab-100">
            <div class="container">
                <div class="new_sectionTitle">
                    <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="brand__wrap style_02 mt-5">
                            <div class="brand__wrap__flex">
                                <?php if ( $settings['list'] ) :
                                    foreach ( $settings['list'] as $item ) :
                                        $image_url = ! empty( $item['brand_image']['url'] ) ? $item['brand_image']['url'] : '';
                                        $image_alt = ! empty( $item['brand_image']['alt'] ) ? $item['brand_image']['alt'] : '';
                                        $brand_url = ! empty( $item['brand_link']['url'] ) ? $item['brand_link']['url'] : '';
                                    ?>
                                    <a href="<?php echo esc_url( $brand_url ); ?>" class="brand__wrap__item">
                                        <div class="brand__wrap__item__thumb">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                                        </div>
                                    </a>
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

Plugin::instance()->widgets_manager->register( new Appgenix_Brand_Area_Non_Slider_Widget() );