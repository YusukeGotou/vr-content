<?php
/**
 * Plugin Name: VR-Photo-Video
 * Description: 360°写真や動画をWebサイトに埋め込むことができます。
 * Author: YusukeGoto
 * Author URI: https://note.com/yusuke723/
 */

// A-Frame JavaScriptの読み込み
function enqueue_aframe_script() {
    wp_enqueue_script('aframe', 'https://aframe.io/releases/1.2.0/aframe.min.js');
}
add_action('wp_enqueue_scripts', 'enqueue_aframe_script');

function js_japanese_message() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {
            let scene = document.querySelector('a-scene');
            if (scene) {
                scene.addEventListener('loaded', function () {
                    let vrMessage = document.querySelector('.a-enter-vr-button[title]');
                    if (vrMessage) {
                        vrMessage.setAttribute('title', 'ヘッドセットを使用してVRモードに入るか、デスクトップで全画面モードにするにはこちらをクリックしてください。詳しくは https://webvr.rocks や https://webvr.info をご覧ください。');
                    }
                });
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'js_japanese_message');


// ショートコードの処理
function photo_360_shortcode($atts) {
    $atts = shortcode_atts(array(
        'src' => '',
        'rotation' => '0 -130 0',
        'width' => '100%',
        'height' => '400px',
        'duration' => '',
        'from_rotation' => '',
        'to_rotation' => ''
    ), $atts);

    $output = '<div id="scene" style="width: ' . esc_attr($atts['width']) . '; height: ' . esc_attr($atts['height']) . ';">';
    $output .= '<a-scene embedded>';
    $output .= '<a-sky src="' . esc_url($atts['src']) . '" rotation="' . esc_attr($atts['rotation']) . '">';

    if (!empty($atts['duration']) && !empty($atts['from_rotation']) && !empty($atts['to_rotation'])) {
        $output .= '<a-animation attribute="rotation" dur="' . esc_attr($atts['duration']) . '" from="' . esc_attr($atts['from_rotation']) . '" to="' . esc_attr($atts['to_rotation']) . '" repeat="indefinite"></a-animation>';
    }

    $output .= '</a-sky>';
    $output .= '</a-scene>';
    $output .= '</div>';

    return $output;
}
add_shortcode('photo_360', 'photo_360_shortcode');

function video_360_shortcode($atts) {
    $atts = shortcode_atts(array(
        'src' => '',
        'rotation' => '0 -130 0',
        'width' => '100%',
        'height' => '400px',
        'autoplay' => 'true',
        'loop' => 'true'
    ), $atts);

	$output = '<div id="video-scene" style="width: ' . esc_attr($atts['width']) . '; height: ' . esc_attr($atts['height']) . ';">';
	$output .= '<a-scene embedded>';
	$output .= '<a-assets>';
	$output .= '<video id="video-360" src="' . esc_url($atts['src']) . '" ' . ($atts['autoplay'] === 'true' ? 'autoplay' : '') . ' ' . ($atts['loop'] === 'true' ? 'loop' : '') . ' muted></video>';
	$output .= '</a-assets>';
	$output .= '<a-videosphere src="#video-360" rotation="' . esc_attr($atts['rotation']) . '"></a-videosphere>';
	$output .= '</a-scene>';
	$output .= '</div>';

    return $output;
}
add_shortcode('video_360', 'video_360_shortcode');
