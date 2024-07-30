<?php
/**
 * Elementor Widget
 * @package appgenix
 * @since 1.0.0
 */

namespace Elementor;

class Appgenix_Follow_Area_Widget extends Widget_Base {

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
        return 'appgenix-follow-area-widget';
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
        return esc_html__( 'Appgenix Follow Area', 'appgenix-master' );
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
                'default' => esc_html__( 'Follow 4 Steps to Build your Amazing Product', 'appgenix-master' ),
                'placeholder' => esc_html__( 'Type section title here', 'appgenix-master' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Grow Area Box List', 'appgenix-master' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name'        => 'icon',
                        'label'       => esc_html__( 'Icon', 'appgenix-master' ),
                        'type'        => Controls_Manager::MEDIA,
                        'description' => esc_html__( 'Choose icon', 'appgenix-master' ),
                        'default'     => [
                            'url' => Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'name' => 'title',
                        'label' => esc_html__( 'Title', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Idea & Concept' , 'appgenix-master' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => esc_html__( 'Description', 'appgenix-master' ),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => esc_html__( 'An idea is spark of creativity that ignites innovation.', 'appgenix-master' ),
                        'placeholder' => esc_html__( 'Type description here', 'appgenix-master' ),
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
        <!-- Follow area start -->
        <div class="follow_area pat-50 pab-100">
            <div class="container container-two">
                <div class="new_sectionTitle">
                    <h2 class="title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $settings['section_title'] ); ?></h2>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="follow__wrapper">
                            <div class="follow__wrapper__lineShape">
                                <svg width="1558" height="106" viewBox="0 0 1558 106" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 105C1 105 146.234 21.7763 248.961 7.68319C396.557 -12.5653 473.456 88.476 622.351 87.1255C765.163 85.8301 837.005 8.55869 979.82 7.68319C1126.69 6.78285 1202.83 110.684 1347.9 87.1255C1431.72 73.5155 1551 7.68319 1551 7.68319" stroke="#6B5AF7" stroke-width="2" stroke-dasharray="4 4"/>
                                    <path d="M1558 1.89049L1557.72 3.77918L1544 1.88869L1544.28 0L1558 1.89049Z" fill="#6B5AF7"/>
                                    <path d="M1557.72 3.77918L1555.76 17L1553.8 16.7299L1555.76 3.50911L1557.72 3.77918Z" fill="#6B5AF7"/>
                                </svg>
                            </div>
                            <div class="follow__wrapper__flex">
                                <?php
                                if ( $settings['list'] ) :
                                    foreach ( $settings['list'] as $key => $item ) :
                                        $icon_url = ! empty( $item['icon']['url'] ) ? $item['icon']['url'] : '';
                                        $icon_attr = ! empty( $item['icon']['alt'] ) ? $item['icon']['alt'] : '';
                                ?>
                                <div class="follow__item text-center radius-10">
                                    <span class="follow__item__number"><?php echo esc_html( $key-$key . $key+1 ); ?></span>
                                    <div class="follow__item__box radius-10">
                                        <div class="follow__item__icon">
                                            <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( $icon_attr ); ?>">
                                        </div>
                                        <div class="follow__item__contents mt-4">
                                            <h4 class="follow__item__contents__title"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['title'] ); ?></h4>
                                            <p class="follow__item__contents__para mt-3"><?php printf( esc_html__( '%s', 'appgenix-master' ), $item['description'] ); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Follow area end -->
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Appgenix_Follow_Area_Widget() );