<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Banner_Area_Widget extends Widget_Base {

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
        return 'appgenix-banner-area-widget';
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
        return esc_html__( 'Appgenix Banner Area', 'appgenix-master' );
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
            'promo_content',
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
                'default' => esc_html__( 'Margin Expansion Beyond Benchmarks', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__( 'Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Our team specializes in creating applications that make a real Difference, delivering meaningful impact', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section description here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'button1_text',
            [
                'label' => esc_html__( 'Button One Text', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'All Product', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type button one text here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'button1_link',
            [
                'label' => esc_html__( 'Button One Link', 'appgenix' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_button_two',
            [
                'label' => esc_html__( 'Show Second Button', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'appgenix-master' ),
                'label_off' => esc_html__( 'Hide', 'appgenix-master' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button2_text',
            [
                'label' => esc_html__( 'Button Two Text', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Contact Us', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type button two text here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'button2_link',
            [
                'label' => esc_html__( 'Button Two Link', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'banner_image',
            [
                'label' => esc_html__( 'Choose Banner Image', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Repeater List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'feature_title',
                        'label' => esc_html__( 'Feature Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Feature Title' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                ],
                'default' => [
                    [
                        'feature_title' => esc_html__( 'High Quality Products', 'appgenix-master' ),
                    ],
                    [
                        'feature_title' => esc_html__( 'Largest global network', 'appgenix-master' ),
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

        $image_url = ! empty( $settings['banner_image']['url'] ) ? $settings['banner_image']['url'] : '';
        $image_alt = ! empty( $settings['banner_image']['alt'] ) ? $settings['banner_image']['alt'] : '';

        $button1_link = ! empty( $settings['button1_link']['url'] ) ? $settings['button1_link']['url'] : '';
        $button2_link = ! empty( $settings['button2_link']['url'] ) ? $settings['button2_link']['url'] : '';
        ?>
        <!-- Banner area starts -->
        <div class="banner_area banner_bg" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/banner/banner_bg.jpg);">
            <div class="container container-two">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="banner">
                            <div class="banner__contents">
                                <h2 class="banner__contents__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                                <span class="banner__contents__para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_description'] ); ?></span>
                                <div class="btn_wrapper d-flex mt-4">
                                    <a href="<?php echo esc_url( $button1_link ); ?>" class="cmn_btn btn_bg_1 radius-5"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['button1_text'] ); ?></a>
                                    <?php if( 'yes' == $settings['show_button_two'] ) : ?>
                                    <a href="<?php echo esc_url( $button2_link ); ?>" class="cmn_btn btn_bg_white radius-5"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['button2_text'] ); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="banner__feature mt-5">
                                    <?php if ( $settings['list'] ) : foreach ( $settings['list'] as $key => $item ) : ?>
                                    <div class="banner__feature__item checked">
                                        <span class="material-symbols-outlined">check</span>
                                        <span class="banner__feature__item__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['feature_title'] ); ?></span>
                                    </div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="banner__thumb">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Banner_Area_Widget() );