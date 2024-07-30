<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Promo_Widget extends Widget_Base {

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
        return 'appgenix-promo-widget';
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
        return esc_html__( 'Appgenix Promo', 'appgenix-master' );
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
            'list',
            [
                'label' => esc_html__( 'Grow Area Box List', 'appgenix-master' ),
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

        // Define the class names
        $class_names = [ 'no_color_class', 'color_success', 'color_secondary' ];
        // Define the icons
        $icons = [ 'monetization_on', 'monitoring', 'pages' ];
        ?>
        <!-- Promo area start -->
        <div class="promo_area pat-50 pab-50">
            <div class="container">
                <div class="col-lg-12">
                    <div class="promo__wrapper radius-10">
                        <div class="promo__wrapper__flex">
                            <?php
                            if ( $settings['list'] ) :
                                foreach ( $settings['list'] as $key => $list_item ) :
                                    // determine the index of each class in the loop
                                    $index = $key % count( $class_names );
                                    // assign class name on each item of the loop based on their index number
                                    $class_name = $class_names[$index];
                                    // assign icon on each item of the loop based on their index number
                                    $icon = $icons[$index];
                            ?>
                                    <div class="promo__item <?php echo esc_attr( $class_name ); ?>">
                                        <div class="promo__item__flex">
                                            <div class="promo__item__icon">
                                                <span class="material-symbols-outlined"><?php echo esc_html( $icon ); ?></span>
                                            </div>
                                            <div class="promo__item__contents">
                                                <div class="promo__item__title counter__count">
                                                    <span class="odometer promo__item__title__odometer" data-odometer-final="<?php echo esc_attr( $list_item['number'] ); ?>"></span>
                                                    <span class="promo__item__title__span"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['number_extension'] ); ?></span>
                                                </div>
                                                <p class="promo__item__para"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['title'] ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Promo area end -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Promo_Widget() );