<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Grow_Area_Widget extends Widget_Base {

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
        return 'appgenix-grow-area-widget';
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
        return esc_html__( 'Appgenix Grow Area', 'appgenix-master' );
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
            'grow_area_content',
            [
                'label' => esc_html__( 'Grow Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'one',
                'options' => [
                    'one' => esc_html__( 'One', 'appgenix-master' ),
                    'two' => esc_html__( 'Two', 'appgenix-master' ),
                ],
            ]
        );


        $this->add_control(
            'show_link',
            [
                'label' => esc_html__( 'Show Link', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'appgenix-master' ),
                'label_off' => esc_html__( 'Hide', 'appgenix-master' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_list',
            [
                'label' => esc_html__( 'Grow Area Box List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name'        => 'image',
                        'label'       => esc_html__( 'Image', 'appgenix-master' ),
                        'type'        => Controls_Manager::MEDIA,
                        'description' => esc_html__( 'enter title.', 'appgenix-master' ),
                        'default'     => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'condition' => [
                            'style' => 'one'
                        ]
                    ],
                    [
                        'name' => 'title',
                        'label' => esc_html__( 'Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Powerful Analysis' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => esc_html__( 'Description', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Functionality, and centric experiences that drive results and success.' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'button_text',
                        'label' => esc_html__( 'Box Description', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Load More' , 'appgenix-master' ),
                        'label_block' => true,
                        'condition' => [
                                'show_link' => 'yes'
                        ]
                    ],
                    [
                        'name' => 'button_link',
                        'label' => esc_html__( 'Button Link', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'placeholder' => esc_html__( 'https://your-link.com', 'appgenix-master' ),
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '#',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                        'label_block' => true,
                        'condition' => [
                            'show_link' => 'yes'
                        ]
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

       $grow_style = 'one' == $settings['style'] ? 'text-center' : 'style_02';
       $icons = [ 'diversity_1', 'thumb_up', 'volunteer_activism' ];
        ?>
            <!-- Grow area start -->
            <div class="grow_area pat-100 pab-50">
                <div class="container">
                    <div class="row g-4">
                        <?php
                            if ( ! empty( $settings['box_list'] ) ) :
                                foreach ( $settings['box_list'] as $key => $list_item ) :
                                    $image_url = ! empty( $list_item['image']['url'] ) ? $list_item['image']['url'] : '';
                                    $image_alt = ! empty( $list_item['image']['alt_text'] ) ? $list_item['image']['alt'] : '';
                        ?>
                        <div class="col-lg-4 col-sm-6">
                            <div class="grow__item <?php echo esc_attr( $grow_style ); ?> radius-10">
                                <div class="grow__item__icon">
                                    <?php if( 'one' === $settings['style'] ) : ?>
                                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php printf( esc_html__( '%s', 'appgenix-master' ), $image_alt ); ?>">
                                    <?php else : ?>
                                    <?php
                                        $index = $key % count( $icons );
                                        $icon = $icons[$index];
                                    ?>
                                        <span class="material-symbols-outlined"><?php echo esc_html( $icon ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="grow__item__contents mt-4">
                                    <h4 class="grow__item__contents__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['title'] ); ?></h4>
                                    <p class="grow__item__contents__para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['description'] ); ?></p>
                                    <?php if ( 'yes' === $settings['show_link'] ) : ?>
                                    <div class="btn_wrapper mt-4">
                                        <a href="<?php echo esc_url( $list_item['button_link']['url'] ); ?>" class="grow__item__btn"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['button_text'] ); ?> <span class="material-symbols-outlined">arrow_right_alt</span></a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
            <!-- Grow area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Grow_Area_Widget() );