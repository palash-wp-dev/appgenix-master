<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Contact_Area_Widget extends Widget_Base {

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
        return 'appgenix-contact-area-widget';
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
        return esc_html__( 'Appgenix Contact Area', 'appgenix-master' );
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
            'contact_area_content',
            [
                'label' => esc_html__( 'Contact Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'address_section_title',
            [
                'label' => esc_html__( 'Address Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Get in Touch', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type address section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'address_section_list',
            [
                'label' => esc_html__( 'Address Section List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'contact_title',
                        'label' => esc_html__( 'Contact Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Address:' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'contact_icon_type',
                        'label' => esc_html__( 'Contact Icon Type', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'location_on',
                        'options' => [
                            'location_on' => esc_html__( 'Location', 'appgenix-master' ),
                            'mail' => esc_html__( 'Mail', 'appgenix-master' ),
                            'call'  => esc_html__( 'Call', 'appgenix-master' ),
                        ],
                    ],
                    [
                        'name' => 'contact_details',
                        'label' => esc_html__( 'Contact Details', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => esc_html__( 'Contact Details' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                ],
            ]
        );

        $this->add_control(
            'social_section_title',
            [
                'label' => esc_html__( 'Social Section Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Get in Touch', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type address section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'social_section_list',
            [
                'label' => esc_html__( 'Social Section List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'social_icon_type',
                        'label' => esc_html__( 'Social Icon Type', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'fa-facebook-f',
                        'options' => [
                            'fa-facebook-f' => esc_html__( 'Facebook', 'appgenix-master' ),
                            'fa-twitter' => esc_html__( 'Twitter', 'appgenix-master' ),
                            'fa-instagram'  => esc_html__( 'Instagram', 'appgenix-master' ),
                            'fa-youtube' => esc_html__( 'Youtube', 'appgenix-master' ),
                            'fa-behance' => esc_html__( 'Behance', 'appgenix-master' ),
                        ],
                    ],
                    [
                        'name' => 'social_icon_link',
                        'label' => esc_html__( 'Social Link', 'appgenix-master' ),
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

        $image_url = ! empty( $settings['section_image']['url'] ) ? $settings['section_image']['url'] : '';
        $image_alt = ! empty( $settings['section_image']['alt'] ) ? $settings['section_image']['alt'] : '';
        ?>
        <!-- Contact area start -->
        <div class="contact_area pat-100 pab-100">
            <div class="container">
                <div class="row justify-content-between align-items-center flex-column-reverse flex-lg-row g-4">
                    <div class="contact">
                        <h4 class="contact__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['address_section_title'] ); ?></h4>
                        <div class="contact__inner mt-4">
                            <?php
                            if ( $settings['address_section_list'] ) :
                            foreach ( $settings['address_section_list'] as $item ) :
                            ?>
                            <div class="contact__item">
                                <div class="contact__item__flex">
                                    <div class="contact__item__icon">
                                        <span class="material-symbols-outlined"><?php echo esc_html( $item['contact_icon_type'] ); ?></span>
                                    </div>
                                    <div class="contact__item__contents">
                                        <h5 class="contact__item__contents__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['contact_title'] ); ?></h5>
                                        <p class="contact__item__contents__para mt-1"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['contact_details'] ); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                        <div class="contact__footer mt-4">
                            <h5 class="contact__footer__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['social_section_title'] ); ?></h5>
                            <div class="contact__footer__list mt-3">
                                <?php
                                if ( $settings['social_section_list'] ) :
                                foreach ( $settings['social_section_list'] as $item ) :
                                    $icon_url = ! empty( $item['social_icon_link']['url'] ) ? $item['social_icon_link']['url'] : '';
                                ?>
                                <a href="<?php echo esc_url( $icon_url ); ?>" class="contact__footer__list__item"><i class="fa-brands <?php echo esc_attr( $item['social_icon_type'] ); ?>"></i></a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Contact_Area_Widget() );