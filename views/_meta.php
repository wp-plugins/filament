<?php foreach( $metas as $property => $content ): $content = is_bool( $content ) ? ($content ? "1" : "0") : $content; ?>
  <meta property="<?php echo "{$namespace}:{$property}"; ?>" content="<?php echo (string) $content; ?>" />
<?php endforeach; ?>

<script type="text/javascript">
  window.Filament = window.Filament || {};
  window.Filament.social_stats_urls = window.Filament.social_stats_urls || {};

  window.Filament.social_stats_urls.stumbleupon = "<?php echo str_replace( '&amp;', '&', $stumbleupon_url ); ?>&url={{url}}&callback={{callback}}";
  window.Filament.social_stats_urls.googleplus = "<?php echo str_replace( '&amp;', '&', $googleplus_url ); ?>&url={{url}}&callback={{callback}}";
</script>
