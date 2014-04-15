<div id="filament">

  <?php if( isset( $_GET['message'] ) && $_GET['message'] == "submit" ): ?>
    <div class="updated">
      <p><strong><?php _e( "Options Successfully Updated" ); ?></strong></p>
    </div>
  <?php endif; ?>

  <div id="header">
    <img src="<?php echo filament_plugin_url( '/assets/images/logo.png' ); ?>" alt="<?php _e('Filament for WordPress'); ?>">
    <span class="register">Need an account? <a href="http://app.filament.io/users/register">Sign Up</a></span>
  </div>

  <form action="" method="post" id="<?php echo $action; ?>">
    <?php wp_nonce_field( $action ); ?>

    <div id="code-snippet-wrapper">
      <p><?php echo sprintf( __( '%1$sPaste%2$s your Filament code snippet here', $this->slug ), '<strong>', '</strong>' ); ?></p>
      <textarea name="single_drop" rows="1" cols="30" id="single_drop" class="code"><?php echo esc_textarea( $data['single_drop'] ); ?></textarea>
      <div class="submit">
        <input type="submit" name="submit" id="submit" class="filament-button" value="Save">
      </div>
    </div>
    <p class="snippet-help"><a class="has-tooltip" href="#!find-snippet">
      Where do I find my code snippet?
      <span id="find-snippet" class="filament-tooltip" style="margin-left: -178px;">
        <span class="inner">
          <img src="<?php echo filament_plugin_url( '/assets/images/get-code-snippet.png' ); ?>">
        </span>
      </span>
    </a></p>
  </form>

  <div id="additional-info">
    <h3 class="expander" data-toggler-for="how-to-connect">How to connect your WordPress site to Filament</h3>
    <div id="how-to-connect" class="wrapper expandable">
      <div class="wrapper">
        <div class="column">
          <h4>Paste your code snippet</h4>
          <p>Don’t have your snippet? Just <a href="http://app.filament.io">login</a>&nbsp;or&nbsp;<a href="http://app.filament.io/users/register">signup</a></p>
        </div>
        <div class="column">
          <h4>Test your connection</h4>
          <p>After saving your code snippet, return to the Filament dashboard to test your connection. <a href="#!activate-filament" class="has-tooltip">
          See here
            <span id="activate-filament" class="filament-tooltip" style="margin-left: -214px;">
              <span class="inner">
                <img src="<?php echo filament_plugin_url( '/assets/images/activate-filament.png' ); ?>">
              </span>
            </span>
          </a>
          </p>
        </div>
        <div class="column">
          <h4>Drop apps!</h4>
          <p>That’s it! Start adding and managing apps at <a href="http://app.filament.io">app.filament.io</a></p>
        </div>
      </div>
    </div>

    <h3 class="expander" data-toggler-for="whats-filament-about">What’s Filament all about?</h3>
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
      </div>
    </div>

  </div>

</div>
