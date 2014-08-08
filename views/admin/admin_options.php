

<div id="filament">

  <div id="header">
    <img src="<?php echo filament_plugin_url( '/assets/images/logo.png' ); ?>" alt="<?php _e('Filament for WordPress'); ?>">
    <span class="register">Need an account? <a href="http://app.filament.io/users/register?utm_source=filament_wp&utm_medium=need_account_link&utm_content=plugin&utm_campaign=filament">Sign Up</a></span>
  </div>

  <?php if( isset( $_GET['message'] ) && $_GET['message'] == "submit" ): ?>
    <div class="updated">
      <p><?php _e( "Snippet saved! If you use any caching plugins, you'll need to clear your cache now." ); ?> <a class="right" href="http://filament.io/connect?utm_source=filament_wp&utm_medium=caching_link&utm_content=plugin&utm_campaign=filament#caching">More info</a></p>
    </div>
  <?php endif; ?>

  <?php if( isset( $_GET['caching'] ) && !empty( $_GET['caching'] ) ): ?>
    <div class="error">
      <p>
        <?php switch( $_GET['caching'] ) {
                case "cloudflare": ?>
            It looks like you have CloudFlare running on your site, don't forget to <a href="https://www.cloudflare.com/cloudflare-settings?z=<?php echo parse_url( get_bloginfo( 'url' ), PHP_URL_HOST ); ?>#page=overview" target="_blank">Purge cache</a>.
          <?php break; ?>

          <?php case "w3-total-cache": ?>
            It looks like you are running W3 Total Cache on your site, <?php echo w3_button_link(__('empty the page cache', 'w3-total-cache'), wp_nonce_url('admin.php?page=w3tc_dashboard&w3tc_flush_pgcache', 'w3tc')); ?> for Filament to work properly.
          <?php break; ?>

          <?php case "wp-super-cache": ?>
            It looks like you are running WP Super Cache on your site, don't forget to <a href="<?php echo admin_url( 'options-general.php?page=wpsupercache' ); ?>">Delete cache</a>.
          <?php break; ?>

          <?php case "quick-cache": ?>
            It looks like you are running Quick Cache on your site, don't forget to <a href="<?php echo admin_url( 'admin.php?page=quick_cache' ); ?>">Clear cache</a>.
          <?php break; ?>

          <?php case "other": ?>
            It looks like you are running a server-side caching solution. Don't forget to clear your cache.
          <?php break; ?>
        <?php } ?>
      </p>
    </div>
  <?php endif; ?>

  <form action="" method="post" id="<?php echo $action; ?>">
    <?php wp_nonce_field( $action ); ?>

    <div id="code-snippet-wrapper">
      <p><?php echo sprintf( __( '%1$sPaste%2$s your Filament code snippet here', $this->slug ), '<strong>', '</strong>' ); ?></p>
      <textarea name="single_drop" rows="1" cols="30" id="single_drop" class="code"><?php echo esc_textarea( $data['single_drop'] ); ?></textarea>
      <p class="snippet-help"><a class="has-tooltip" href="#!find-snippet">
      Where can I get my code snippet?
      <span id="find-snippet" class="filament-tooltip" style="margin-left: -178px;">
        <span class="inner">
          <img src="<?php echo filament_plugin_url( '/assets/images/get-code-snippet.png' ); ?>">
        </span>
      </span>
      </a></p>
      <div class="submit">
        <input type="submit" name="submit" id="submit" class="filament-button" value="Save Snippet">
      </div>
    </div>

  </form>

  <div id="additional-info">
    <h3>How to connect your WordPress site to Filament</h3>
    <div id="how-to-connect" class="wrapper">
      <div class="wrapper">
        <div class="column <?php if( $step == 1 ) echo 'active'; ?>">
          <h4>Paste your Filament code snippet above</h4>
          <p>Don&rsquo;t have your code snippet? <a href="http://app.filament.io/users/login?utm_source=filament_wp&utm_medium=step_1&utm_content=plugin&utm_campaign=filament">Login</a> to your account or <a href="http://app.filament.io/users/register?utm_source=filament_wp&utm_medium=step_1&utm_content=plugin&utm_campaign=filament">signup</a></p>
        </div>
        <div class="column <?php if( $step == 2 ) echo 'active'; ?>">
          <h4>Test your site's connection to Filament</h4>
          <p>After saving your code snippet, return to the Filament dashboard to test your connection. </p>
          <p><a class="filament-button" href="http://app.filament.io/?utm_source=filament_wp&utm_medium=step_2&utm_content=plugin&utm_campaign=filament&domain_host=<?php echo parse_url( get_bloginfo( 'url' ), PHP_URL_HOST ); ?>#test-connection">Test connection now</a></p>
        </div>
        <div class="column <?php if( $step == 3 ) echo 'active'; ?>">
          <h4>Go drop apps!</h4>
          <p class="inactive">That&rsquo;s it! Start adding and managing your apps at <a href="http://app.filament.io/?utm_source=filament_wp&utm_medium=step_3&utm_content=plugin&utm_campaign=filament">app.filament.io</a></p>
          <p class="active">That&rsquo;s it! Return to your site your Filament account and add some apps!</p>
          <p><a class="filament-button" href="http://app.filament.io/?utm_source=filament_wp&utm_medium=add_apps_button&utm_content=plugin&utm_campaign=filament">Add apps now</a></p>
        </div>
      </div>
    </div>

    <h3 class="expander opened" data-toggler-for="whats-filament-about">What&rsquo;s Filament all about?</h3>
    <div id="whats-filament-about" class="wrapper expandable">
      <img src="<?php echo filament_plugin_url( '/assets/images/make-your-website-better.png' ); ?>" alt="<?php _e('Filament for WordPress'); ?>">

      <div class="apps">
        <div data-app="ivy">
          <div class="image-wrapper">
            <img src="<?php echo filament_plugin_url( '/assets/images/ivy.png' ); ?>" alt="Ivy" />
            <strong>Ivy</strong>
          </div>
          <a href="http://filament.io/ivy?utm_source=filament_wp&amp;utm_medium=app_tile&amp;utm_content=ivy&amp;utm_campaign=filament">See Demo</a>
        </div>
        <div data-app="flare">
          <div class="image-wrapper">
            <img src="<?php echo filament_plugin_url( '/assets/images/flare.png' ); ?>" alt="Flare" />
            <strong>Flare</strong>
          </div>
          <a href="http://filament.io/flare?utm_source=filament_wp&amp;utm_medium=app_tile&amp;utm_content=flare&amp;utm_campaign=filament">See Demo</a>
        </div>
        <div data-app="passport">
          <div class="image-wrapper">
            <img src="<?php echo filament_plugin_url( '/assets/images/passport.png' ); ?>" alt="Passport" />
            <strong>Passport</strong>
          </div>
          <a href="http://filament.io/passport?utm_source=filament_wp&amp;utm_medium=app_tile&amp;utm_content=passport&amp;utm_campaign=filament">See Demo</a>
        </div>
        <p>Start with one of our Social Collection apps above. Or <a href="http://app.filament.io/?utm_source=filament_wp&utm_medium=app_tiles&utm_content=plugin&utm_campaign=filament">view all apps.</a></p>
        <h2><a href="http://filament.io/?utm_source=filament_wp&utm_medium=learn_more_link&utm_content=plugin&utm_campaign=filament">Learn more about Filament</a></h2>
      </div>

    </div>

  </div>

</div>
