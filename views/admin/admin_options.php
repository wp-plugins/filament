<div id="filament" class="wrap">
  <h2><?php _e( "Get Connected with Filament" ); ?></h2>

  <?php if( isset( $_GET['message'] ) && $_GET['message'] == "submit" ): ?>

    <div class="updated">
      <p><strong><?php _e( "Options Successfully Updated" ); ?></strong></p>
    </div>

  <?php endif; ?>

  <form action="" method="post" id="<?php echo $action; ?>">
    <?php wp_nonce_field( $action ); ?>

    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row">
            <label for="single_drop" class="control-label"><?php _e( "Filament Code Snippet" ); ?></label>
          </th>
          <td>
            <textarea name="single_drop" rows="10" cols="50" id="single_drop" class="large-text code"><?php echo esc_textarea( $data['single_drop'] ); ?></textarea>
            <p><?php _e( "Your code snippet will automatically be appended to all pages on your site." ); ?></p>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
  </form>

  <hr />

  <div id="about-filament">
    <h2>Make Your Website Better With Filament</h2>
    <h3>Apps that anyone can easily install to make visitors happier.</h3>

    <div class="apps">
      <div data-app="flare">
        <img src="<?php echo filament_plugin_url( '/assets/images/flare.png' ); ?>" alt="Flare" />
        <a href="http://filament.io/flare?utm_source=filament_wp&utm_medium=app_tile&utm_content=flare&utm_campaign=filament">
          <strong>Flare</strong>
          <em>Make sharing content better for your visitors</em>
        </a>
      </div>
      <div data-app="ivy">
        <img src="<?php echo filament_plugin_url( '/assets/images/ivy.png' ); ?>" alt="Ivy" />
        <a href="http://filament.io/ivy?utm_source=filament_wp&utm_medium=app_tile&utm_content=ivy&utm_campaign=filament">
          <strong>Ivy</strong>
          <em>Share the parts of your content that matter to you</em>
        </a>
      </div>
      <div data-app="passport">
        <img src="<?php echo filament_plugin_url( '/assets/images/passport.png' ); ?>" alt="Passport" />
        <a href="http://filament.io/passport?utm_source=filament_wp&utm_medium=app_tile&utm_content=passport&utm_campaign=filament">
          <strong>Passport</strong>
          <em>Showcase your online footprint better</em>
        </a>
      </div>
    </div>
  </div>
</div>