<?php //phpcs:ignore
/**
 * Elementor widgets for jisit meet
 *
 * @package JITSI_MEET_WP
 */

namespace Jitsi\Widgets;

use Elementor\Widget_Base; // phpcs:ignore
use Elementor\Controls_Manager; // phpcs:ignore
use Elementor\Scheme_Color; // phpcs:ignore
use Elementor\Scheme_Typography; // phpcs:ignore
use Elementor\Group_Control_Typography; // phpcs:ignore


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Jitsi_Elementor extends Widget_Base {
	/**
	 * Load hooks, fumctions and scripts
	 *
	 * @param   array $data  data array.
	 * @param   array $args  args array.
	 *
	 * @return  void
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * Get script depends
	 *
	 * @return  string
	 */
	public function get_script_depends() {
		return array( 'jitsi-api', 'jitsi-script' );
	}

	/**
	 * Get name
	 *
	 * @return  string
	 */
	public function get_name() {
		return 'jitsi_elementor';
	}

	/**
	 * Get title
	 *
	 * @return  string
	 */
	public function get_title() {
		return __( 'Jitsi Meet', 'jitsi-meet-wp' );
	}

	/**
	 * Get icon
	 *
	 * @return  string
	 */
	public function get_icon() {
		return 'eicon-video-camera';
	}

	/**
	 * Get keywords
	 *
	 * @return  string
	 */
	public function get_keywords() {
		return array( 'jitsi', 'meeting', 'conference' );
	}

	/**
	 * Get widget categories
	 *
	 * @return  string
	 */
	public function get_categories() {
		return array( 'basic' );
	}

	/**
	 * Register widget controls
	 *
	 * @return  void
	 */
	protected function register_controls() {

		// -------------------  Default Section  -----------------------//
		$this->start_controls_section(
			'Configuration',
			array(
				'label' => __( 'Configuration', 'jitsi-meet-wp' ),
			)
		);

		$this->add_control(
			'name',
			array(
				'label'       => __( 'Name', 'jitsi-meet-wp' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'SampleJitsiMeetRoom',
				'placeholder' => __( 'Meeting name here', 'jitsi-meet-wp' ),
			)
		);

		$this->add_control(
			'width',
			array(
				'label'     => __( 'Width', 'jitsi-meet-wp' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 100,
				'max'       => 2000,
				'step'      => 5,
				'default'   => 1080,
				'selectors' => array(
					'{{WRAPPER}} .jitsi-wrapper' => 'width: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'height',
			array(
				'label'   => __( 'Height', 'jitsi-meet-wp' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 5,
				'default' => 720,
			)
		);

		$this->add_control(
			'audio_muted',
			array(
				'label'        => __( 'Start audio muted', 'jitsi-meet-wp' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => '',
				'label_off'    => '',
				'return_value' => true,
				'default'      => false,
			)
		);

		$this->add_control(
			'video_muted',
			array(
				'label'        => __( 'Start video muted', 'jitsi-meet-wp' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => '',
				'label_off'    => '',
				'return_value' => true,
				'default'      => true,
			)
		);

		$this->add_control(
			'screen_sharing',
			array(
				'label'        => __( 'Screen Sharing', 'jitsi-meet-wp' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => '',
				'label_off'    => '',
				'return_value' => true,
				'default'      => true,
			)
		);

		$this->add_control(
			'invite',
			array(
				'label'        => __( 'Enable Inviting', 'jitsi-meet-wp' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => '',
				'label_off'    => '',
				'return_value' => true,
				'default'      => true,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widgets
	 *
	 * @return  void
	 */
	protected function render() {

		$settings = $this->get_settings();
		?>
		<div 
			class="jitsi-wrapper-elementor" 
			data-name="<?php echo esc_attr( $settings['name'] ); ?>"
			data-width="<?php echo esc_attr( $settings['width'] ); ?>"
			data-height="<?php echo esc_attr( $settings['height'] ); ?>"
			data-mute="<?php echo $settings['audio_muted'] ? esc_attr( $settings['audio_muted'] ) : 'false'; ?>"
			data-videomute="<?php echo $settings['video_muted'] ? esc_attr( $settings['video_muted'] ) : 'false'; ?>"
			data-screen="<?php echo $settings['screen_sharing'] ? esc_attr( $settings['screen_sharing'] ) : 'false'; ?>"
			data-invite="<?php echo $settings['invite'] ? esc_attr( $settings['invite'] ) : 'false'; ?>"
		></div>
		<?php
	}
}
