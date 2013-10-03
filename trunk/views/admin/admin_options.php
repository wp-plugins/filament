<div class="wrap">
  <h2>Get Connected with Filament</h2>

  <form action="" method="post" id="<?php echo $action; ?>">
    <?php wp_nonce_field( $action ); ?>

    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row">
            <label for="single_drop" class="control-label">Filament Code Snippet</label>
          </th>
          <td>
            <textarea name="single_drop" rows="10" cols="50" id="single_drop" class="large-text code"><?php echo $data['single_drop']; ?></textarea>
            <p>Your code snippet will automatically be appended automatically to all pages on your site.</p>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
  </form>
</div>