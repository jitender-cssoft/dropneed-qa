<div class="row">
	<div class="span12">
		<?php echo form_open($this->config->item('admin_folder').'/payment/settings/'. $module);?>
			<fieldset>
				
				

<?php
echo $form;
?>
				<div class="form-actions">
					<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
				</div>
			</fieldset>
		</form>
	</div>
</div>