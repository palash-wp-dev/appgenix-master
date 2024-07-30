<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Mission_Area_Widget extends Widget_Base {

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
        return 'appgenix-mission-area-widget';
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
        return esc_html__( 'Appgenix Mission Area', 'appgenix-master' );
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
            'about_mission_content',
            [
                'label' => esc_html__( 'About Mission Content', 'appgenix-master' ),
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
            'video_link',
            [
                'label' => esc_html__( 'Video Link', 'textdomain' ),
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

        $video_url = ! empty( $settings['video_link']['url'] ) ? $settings['video_link']['url'] : '';
        ?>
        <!-- Mission area start -->
        <section class="mission_area pat-50 pab-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mission__wrap section_bg_2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-lg-6">
                                    <div class="mission__wrap__thumb">
                                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                                        <a href="<?php echo esc_url( $video_url ); ?>" class="mission__wrap__thumb__icon popupVideo">
                                            <span class="material-symbols-outlined">play_arrow</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mission__wrap__contents">
                                        <div class="new_sectionTitle text-left">
                                            <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                                            <div class="section_line mt-3"></div>
                                            <p class="section_para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_description'] ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Mission area ends -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Mission_Area_Widget() );