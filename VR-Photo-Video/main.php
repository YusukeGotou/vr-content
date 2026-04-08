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

/**
 * 文字列の真偽値を安全に解釈する。
 */
function vr_photo_video_to_bool($value, $default = false) {
    if (is_bool($value)) {
        return $value;
    }

    if ($value === null || $value === '') {
        return (bool) $default;
    }

    return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $default;
}

/**
 * yaw指定がある場合はrotationへ変換する。
 */
function vr_photo_video_resolve_rotation($atts) {
    if (isset($atts['yaw']) && $atts['yaw'] !== '') {
        return '0 ' . floatval($atts['yaw']) . ' 0';
    }

    return $atts['rotation'];
}

function js_japanese_message() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
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
        'yaw' => '',
        'width' => '100%',
        'height' => '400px',
        'duration' => '',
        'from_rotation' => '',
        'to_rotation' => ''
    ), $atts);

    if (empty($atts['src'])) {
        return '<p>360°写真のURL（src）を指定してください。</p>';
    }

    $rotation = vr_photo_video_resolve_rotation($atts);

    $scene_id = function_exists('wp_unique_id') ? wp_unique_id('vr-photo-scene-') : uniqid('vr-photo-scene-', false);

    $output = '<div id="' . esc_attr($scene_id) . '" style="width: ' . esc_attr($atts['width']) . '; height: ' . esc_attr($atts['height']) . ';">';
    $output .= '<a-scene embedded>';
    $output .= '<a-sky src="' . esc_url($atts['src']) . '" rotation="' . esc_attr($rotation) . '">';

    if (!empty($atts['duration']) && !empty($atts['from_rotation']) && !empty($atts['to_rotation'])) {
        $output .= '<a-animation attribute="rotation" dur="' . esc_attr($atts['duration']) . '" from="' . esc_attr($atts['from_rotation']) . '" to="' . esc_attr($atts['to_rotation']) . '" repeat="indefinite"></a-animation>';
    }

    $output .= '</a-sky>';
    $output .= '</a-scene>';
    $output .= '</div>';

    return $output;
}
add_shortcode('photo_360', 'photo_360_shortcode');
add_shortcode('vr_photo', 'photo_360_shortcode');

function video_360_shortcode($atts) {
    $atts = shortcode_atts(array(
        'src' => '',
        'rotation' => '0 -130 0',
        'yaw' => '',
        'width' => '100%',
        'height' => '400px',
        'autoplay' => 'true',
        'loop' => 'true',
        'controls' => 'false'
    ), $atts);

    if (empty($atts['src'])) {
        return '<p>360°動画のURL（src）を指定してください。</p>';
    }

    $rotation = vr_photo_video_resolve_rotation($atts);
    $autoplay = vr_photo_video_to_bool($atts['autoplay'], true);
    $loop = vr_photo_video_to_bool($atts['loop'], true);
    $controls = vr_photo_video_to_bool($atts['controls'], false);

    $scene_id = function_exists('wp_unique_id') ? wp_unique_id('vr-video-scene-') : uniqid('vr-video-scene-', false);
    $video_id = function_exists('wp_unique_id') ? wp_unique_id('vr-video-') : uniqid('vr-video-', false);

	$output = '<div id="' . esc_attr($scene_id) . '" style="width: ' . esc_attr($atts['width']) . '; height: ' . esc_attr($atts['height']) . ';">';
	$output .= '<a-scene embedded>';
	$output .= '<a-assets>';
	$output .= '<video id="' . esc_attr($video_id) . '" src="' . esc_url($atts['src']) . '" ';
    $output .= $autoplay ? 'autoplay ' : '';
    $output .= $loop ? 'loop ' : '';
    $output .= $controls ? 'controls ' : '';
    $output .= 'muted playsinline webkit-playsinline></video>';
	$output .= '</a-assets>';
	$output .= '<a-videosphere src="#' . esc_attr($video_id) . '" rotation="' . esc_attr($rotation) . '"></a-videosphere>';
	$output .= '</a-scene>';
	$output .= '</div>';

    return $output;
}
add_shortcode('video_360', 'video_360_shortcode');
add_shortcode('vr_video', 'video_360_shortcode');
