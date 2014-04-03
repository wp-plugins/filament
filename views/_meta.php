<?php foreach( $metas as $property => $content ): $content = is_bool( $content ) ? ($content ? "1" : "0") : $content; ?>
  <meta property="<?php echo "{$namespace}:{$property}"; ?>" content="<?php echo (string) $content; ?>" />
<?php endforeach; ?>