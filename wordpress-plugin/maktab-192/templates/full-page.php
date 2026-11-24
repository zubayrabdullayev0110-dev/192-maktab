<?php
/**
 * Тўлиқ саҳифа шаблони: мавзу сарлавҳаси ва пастки қисмисиз.
 *
 * @package Maktab192
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="192-мактаб — Шайхонтоҳур туманидаги тилларга ихтисослаштирилган ўрта махсус мактаб. 24/7 хавфсизлик, Face ID назорати, олий тоифали ўқитувчилар, спорт тўгараклари.">
<meta property="og:title" content="192-мактаб — Шайхонтоҳур">
<meta property="og:type" content="website">
<meta name="theme-color" content="#24493d">
<?php wp_head(); ?>
<style>html,body{margin:0;padding:0;scroll-behavior:smooth}</style>
</head>
<body <?php body_class( 'maktab192-full' ); ?>>
<?php wp_body_open(); ?>
<?php echo maktab192_render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside template. ?>
<?php wp_footer(); ?>
</body>
</html>
