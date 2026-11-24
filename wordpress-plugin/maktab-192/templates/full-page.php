<?php
/**
 * To‘liq sahifa shabloni: mavzu sarlavhasi va pastki qismisiz.
 *
 * @package Maktab192
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="192-maktab — Shayxontohur tumanidagi tillarga ixtisoslashtirilgan o‘rta maxsus maktab. 24/7 xavfsizlik, Face ID nazorati, oliy toifali o‘qituvchilar, sport to‘garaklari.">
<meta property="og:title" content="192-maktab — Shayxontohur">
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
