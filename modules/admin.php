<div class="wrap">
	<h2><?php echo GROWBUTTON_BRAND_NAME ?> Options</h2>
	<p>
		<?php echo GROWBUTTON_BRAND_NAME ?> plugin can install Grow button in your wordpress.
		<a href="http://growbutton.com/setting#!get_button" target="_blank">get api key.</a>
	</p>
	
	<h3>Getting Started</h3>
	<ol>
		<li>Please join <a href="http://growbutton.com/" target="_blank">Grow!</a>.</li>
		<li>Please <a href="http://growbutton.com/setting#!get_button" target="_blank">Get API Key</a></li>
	</ol>
	
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="<?php echo WP_GROWBUTTON_OPTIONS_APIKEY . ',' . WP_GROWBUTTON_OPTIONS_BUTTON_TYPE . ',' . WP_GROWBUTTON_OPTIONS_POSITION ?>" />
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">API Key</th>
				<td><input type="text" name="<?php echo WP_GROWBUTTON_OPTIONS_APIKEY ?>" value="<?php echo get_option(WP_GROWBUTTON_OPTIONS_APIKEY); ?>" />
					<br/>
					*if you do not have API key. <a href="http://growbutton.com/setting#!get_button" target="_blank">get api key.</a>
				</td>
			</tr>
			<tr>
				<th>Shape of the Grow! Button
				</th>
				<td>
					<input id="square" type="radio" name="<?php echo WP_GROWBUTTON_OPTIONS_BUTTON_TYPE; ?>" value="square" <?php if('square' == get_option(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE)):?> checked="checked" <?php endif; ?>><label for="square">Square</label>
					<br/>
					<input id="rectangle" type="radio" name="<?php echo WP_GROWBUTTON_OPTIONS_BUTTON_TYPE; ?>" value="rectangle" <?php if('rectangle' == get_option(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE)):?> checked="checked" <?php endif; ?>><label for="rectangle">Rectangle</label>
				</td>
			</tr>
			<tr>
				<th>Position</th>
				<td>
					<?php $position = get_option(WP_GROWBUTTON_OPTIONS_POSITION); ?>
					<select name="<?php echo WP_GROWBUTTON_OPTIONS_POSITION ?>">
						<option value="top" <?php if($position == 'top'): ?>selected="selected"<?php endif;?>>Top</option>
						<option value="bottom" <?php if($position == 'bottom'): ?>selected="selected"<?php endif;?>>Bottom</option>
						<option value="none" <?php if($position == 'none'): ?>selected="selected"<?php endif;?>>None</option>
					</select>
				</td>
			</tr>
		</table>
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>