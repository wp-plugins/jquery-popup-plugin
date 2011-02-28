<div class="wrap">
	<div id="icon-options-general" class="icon32"><br/>
	</div>
	<h2><?php _e('PopUp Settings','jquery-pop-up'); ?></h2>
	<form action="" method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Mode','jquery-pop-up'); ?></th>
				<td>
					<select name="popup_mode">
						<option value="disabled" <?php if($options['mode'] == 'disabled') { echo 'selected'; } ?>>Disabled</option>
						<option value="preview" <?php if($options['mode'] == 'preview') { echo 'selected'; } ?>>Preview</option>
						<option value="enabled" <?php if($options['mode'] == 'enabled') { echo 'selected'; } ?>>Enabled</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Body','jquery-pop-up'); ?></th>
				<td>
					<textarea id="popup_body" name="popup_body" value="" style="width:90%;height:200px;"><?php echo esc_attr(stripslashes($options['body'])); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Overlay color','jquery-pop-up'); ?></th>
				<td>
				<input type="text" id="popup_overlay" name="popup_overlay" value="<?php echo esc_attr($options['overlay']); ?>" class="regular-text"/>
				</td>
			</tr>			
			<tr valign="top">
				<th scope="row"><?php _e('Background Color','jquery-pop-up'); ?></th>
				<td>
				<input type="text" id="popup_background" name="popup_background" value="<?php echo esc_attr($options['background']); ?>" class="regular-text"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Vertical Position','jquery-pop-up'); ?></th>
				<td>
				<input type="text" id="popup_vertical" name="popup_vertical" value="<?php echo esc_attr($options['vertical']); ?>" class="regular-text"/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Close Button','jquery-pop-up'); ?></th>
				<td>
				<input type="checkbox" id="popup_close" name="popup_close" value="on" class="regular-text" <?php if($options['close'] == 'on') { echo 'checked'; } ?>/>
				</td>
			</tr>				
			<tr valign="top">
				<th scope="row"><?php _e('Use Default Style','jquery-pop-up'); ?><br>
				<span class="description"><?php _e("Uncheck this box to disable default style.",'jquery-pop-up'); ?></span></th>
				<td>
				<input type="checkbox" id="popup_default_style" name="popup_default_style" value="on" class="regular-text" <?php if($options['default_style'] == 'on') { echo 'checked'; } ?>/>	
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Delay','jquery-pop-up'); ?><br>
				<span class="description"><?php _e("Enter the number of seconds you would like to pass before opening the popup.",'jquery-pop-up'); ?></span></th>
				<td>
				<input type="text" id="popup_delay" name="popup_delay" value="<?php echo esc_attr($options['delay']); ?>" class="narrow-text" />	
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><?php _e('Set Cookie','jquery-pop-up'); ?><br>
				<span class="description"><?php _e("Check this box to use cookies to hide from repeat visitors",'jquery-pop-up'); ?></span></th>
				<td>
					<input type="checkbox" id="popup_cookie" name="popup_cookie" value="on" class="regular-text" <?php if($options['cookie'] == 'on') { echo 'checked'; } ?>/>	
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Cookie Expires','jquery-pop-up'); ?><br>
				<span class="description"><?php _e("Set length of time before the cookie expires in seconds. For instance, one hour would be 3600 or 60 * 60.",'jquery-pop-up'); ?></span></th>
				<td>
				<input type="text" id="popup_expires" name="popup_expires" value="<?php echo esc_attr($options['expires']); ?>" class="narrow-text" />	
				</td>
			</tr>																				
			<tr valign="top">
				<th scope="row">
					<input type="submit" value="<?php _e('Save PopUp','jquery-pop-up'); ?>" name="save-popup" class="button-primary" />
				</th>
				<td></td>
			</tr>
			<?php wp_nonce_field('_popup_nonces', 'save_changes_nonce'); ?>
		</table>
		</form>
	</div> 