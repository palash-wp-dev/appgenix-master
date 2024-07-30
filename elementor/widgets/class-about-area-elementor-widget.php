<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_About_Area_Widget extends Widget_Base {

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
        return 'appgenix-about-area-widget';
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
        return esc_html__( 'Appgenix About Area', 'appgenix-master' );
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
            'about_area_content',
            [
                'label' => esc_html__( 'About Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'About Company', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__( 'Section Description', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Lorem ipsum dollar net amur.', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section description here', 'appgenix-master' ),
            ]
        );


        $this->add_control(
            'section_image',
            [
                'label' => esc_html__( 'Choose Section Image', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Promo List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => esc_html__( 'Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Revenue Generated' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'number',
                        'label' => esc_html__( 'Number', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( '45' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'number_extension',
                        'label' => esc_html__( 'Number Extension', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'K' , 'appgenix-master' ),
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

        $image_url = ! empty( $settings['section_image']['url'] ) ? $settings['section_image']['url'] : '';
        $image_alt = ! empty( $settings['section_image']['alt'] ) ? $settings['section_image']['alt'] : '';
        ?>
        <!-- About area start -->
        <section class="about_area pat-100 pab-50">
            <div class="container">
                <div class="row justify-content-between align-items-center flex-column-reverse flex-lg-row g-4">
                    <div class="col-xxl-5 col-lg-6">
                        <div class="about__wrap">
                            <div class="new_sectionTitle text-left">
                                <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                                <div class="section_line mt-3"></div>
                                <p class="section_para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_description'] ); ?></p>
                            </div>
                            <div class="about__wrap__inner mt-5">
                                <div class="row">
                                    <?php if ( $settings['list'] ) : foreach ( $settings['list'] as $key => $item ) : ?>
                                    <div class="col-xl-6 col-lg-12 col-sm-6">
                                        <div class="promo__item about__promo">
                                            <div class="promo__item__flex">
                                                <div class="promo__item__icon">
                                                    <span class="material-symbols-outlined"><?php if ( 0 == $key % 2 ) echo esc_html( 'monetization_on' ); else echo esc_html( 'pages' ); ?></span>
                                                </div>
                                                <div class="promo__item__contents">
                                                    <div class="promo__item__title counter__count">
                                                        <span class="odometer promo__item__title__odometer" data-odometer-final="<?php echo esc_attr( $item['number'] ); ?>"></span>
                                                        <span class="promo__item__title__span"><?php echo esc_html( $item['number_extension'] ); ?></span>
                                                    </div>
                                                    <p class="promo__item__para"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['title'] ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__thumb">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( $image_alt ); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_About_Area_Widget() );