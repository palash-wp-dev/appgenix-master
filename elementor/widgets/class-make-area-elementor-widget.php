<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Make_Area_Widget extends Widget_Base {

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
        return 'appgenix-make-area-widget';
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
        return esc_html__( 'Appgenix Make Area', 'appgenix-master' );
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
            'make_area_content',
            [
                'label' => esc_html__( 'Make Area Content', 'appgenix-master' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Building online business makes it easy', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type your title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Experience the journey of building an online business with unparalleled ease. Our comprehensive', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type your description here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Description', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Load More', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type button text here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Button Link', 'appgenix-master' ),
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
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Grow Area Box List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'list_title',
                        'label' => esc_html__( 'List Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Easy to-use software that can scale' , 'appgenix-master' ),
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

        $image_url = ! empty( $settings['image']['url'] ) ? $settings['image']['url'] : '';
        $image_alt = ! empty( $settings['image']['alt'] ) ? $settings['image']['alt'] : '';
        ?>
        <!-- Make area start -->
        <div class="make_area pat-50 pab-50">
            <div class="container">
                <div class="row g-4 align-items-center justify-content-between">
                    <div class="col-lg-5">
                        <div class="make__wrap">
                            <div class="new_sectionTitle text-left">
                                <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['title'] ); ?></h2>
                                <div class="section_line mt-3"></div>
                                <p class="section_para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['description'] ); ?></p>
                            </div>
                            <div class="make__inner mt-4">
                                <ul class="make__list">
                                    <?php if ( ! empty( $settings['list'] ) ) : foreach( $settings['list'] as $list_item ) : ?>
                                        <li class="make__list__item"><?php printf( esc_html__( '%s', 'appgenix-master' ), $list_item['list_title'] ); ?></li>
                                    <?php endforeach; endif; ?>
                                </ul>
                                <div class="btn_wrapper mt-4">
                                    <a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>" class="cmn_btn btn_bg_1 radius-5"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['button_text'] ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="make__wrap">
                            <div class="make__thumb">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_url( $image_alt ); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Make area end -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Make_Area_Widget() );