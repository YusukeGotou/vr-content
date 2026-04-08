# VR-Photo-Video WordPress Plugin

## Description
The "VR-Photo-Video" plugin is designed to enable the embedding of 360° photos and videos into your WordPress website. It utilizes the A-Frame JavaScript library for creating immersive VR experiences.

## Author
- [YusukeGoto](https://note.com/yusuke723/)

## Features
This plugin offers the following features:

- Embed 360° photos with customizable parameters.
- Embed 360° videos with autoplay and loop options.
- Includes Japanese language support for VR mode instructions.
- Easier shortcode options (`vr_photo` / `vr_video`) in addition to existing ones.
- Optional `yaw` parameter for simpler orientation settings.
- Helpful message output when `src` is missing.

## Installation
1. Download the plugin files and place them in the `/wp-content/plugins/` directory of your WordPress installation.
2. Activate the "VR-Photo-Video" plugin from the WordPress admin panel.

## Usage
Once the plugin is activated, you can embed 360° photos and videos into WordPress posts/pages with shortcodes.

### Embedding 360° Photos
You can use either shortcode name:

- `[photo_360 ...]`
- `[vr_photo ...]`

Example:

```text
[vr_photo src="https://example.com/photo.jpg" yaw="-130" width="100%" height="400px"]
```

Photo options:
- `src` (required): URL to your 360° photo.
- `rotation`: 3D rotation vector (default: `0 -130 0`).
- `yaw`: simpler horizontal angle setting (overrides `rotation` when set).
- `width`, `height`: scene size.
- `duration`, `from_rotation`, `to_rotation`: optional rotation animation settings.

### Embedding 360° Videos
You can use either shortcode name:

- `[video_360 ...]`
- `[vr_video ...]`

Example:

```text
[vr_video src="https://example.com/video.mp4" yaw="-130" autoplay="true" loop="true" controls="false"]
```

Video options:
- `src` (required): URL to your 360° video.
- `rotation`: 3D rotation vector (default: `0 -130 0`).
- `yaw`: simpler horizontal angle setting (overrides `rotation` when set).
- `width`, `height`: scene size.
- `autoplay`: `true`/`false`.
- `loop`: `true`/`false`.
- `controls`: `true`/`false` to display native video controls.

## Japanese VR Mode Message
The plugin includes a feature to display a Japanese message when entering VR mode. The message provides instructions for using VR headsets or entering fullscreen mode on desktop.

## Important Notes
- Ensure that you have the A-Frame JavaScript library loaded properly for the plugin to function correctly.
- Use shortcodes as described above to embed 360° content in your posts or pages.
- Review and understand the plugin's code to make any necessary customizations.
- Visit the provided author's URL for support or questions related to the plugin.

## License
This plugin is distributed under the [GNU General Public License, version 2 (GPL-2.0)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html).

Enjoy creating immersive 360° experiences on your WordPress website!
