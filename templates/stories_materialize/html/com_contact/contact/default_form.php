<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<div class="row">
			<div class="col s6">
				<div class="input-field">
					<label id="jform_contact_name-lbl" for="jform_contact_name" title="" data-content="Your name." data-original-title="Name">
						<?php echo JText::_("TPL_STORIES_NAME") ?><span class="star">&nbsp;*</span>
					</label>
					<input type="text" name="jform[contact_name]" id="jform_contact_name" value="" class="required"  size="30" required="required" aria-required="true">
				</div>
			</div>
			<div class="col s6">
				<div class="input-field">
					<label id="jform_contact_email-lbl" for="jform_contact_email" class="hasPopover required" title="" data-content="Email Address for contact." data-original-title="Email">
					<?php echo JText::_("TPL_STORIES_EMAIL") ?><span class="star">&nbsp;*</span>
					</label>
					<input type="email" name="jform[contact_email]" class="validate-email required" id="jform_contact_email" value="" size="30" autocomplete="email" required="required" aria-required="true">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s6">
				<div class="input-field">
					<label id="jform_contact_emailmsg-lbl" for="jform_contact_emailmsg" class="hasPopover required" title="" data-content="Enter the subject of your message here." data-original-title="Subject">
					<?php echo JText::_("TPL_STORIES_SUBJECT") ?><span class="star">&nbsp;*</span>
					</label>
					<input type="text" name="jform[contact_subject]" id="jform_contact_emailmsg" value="" class="required" size="60" required="required" aria-required="true">
				</div>
			</div>
			
			<div class="col s6">
                <div class="input-field">
                	<input id="phone" type="tel" name="jform[phone]" class="validate">
                    <label for="phone"><?php echo JText::_("TPL_STORIES_TELEPHONE") ?></label>
                </div>
            </div>
		</div>
		<div class="row">
			<div class="col s12 ">
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label id="jform_contact_message-lbl" for="jform_contact_message" class="hasPopover required" title="" data-content="Enter your message here." data-original-title="Message">
							<?php echo JText::_("TPL_STORIES_MESSAGE") ?><span class="star">&nbsp;*</span>
							</label>
							<textarea name="jform[contact_message]" id="jform_contact_message" cols="50" rows="10" class="materialize-textarea message" required="required" aria-required="true"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col s12">
				<button class="waves-effect waves-light btn-large submit-button pink mt-30 pull-right" type="submit"><?php echo JText::_("TPL_STORIES_SEND_MESSAGE"); ?></button>
			</div>
					<input type="hidden" name="option" value="com_contact">
					<input type="hidden" name="task" value="contact.submit">
					<input type="hidden" name="return" value="">
					<input type="hidden" name="id" value="2:webmaster">
					<input type="hidden" name="e607195179a74423bdf6e849dbf4aa77" value="1">				</div>
			<?php //Dynamically load any additional fields from plugins. ?>
				<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
					<?php if ($fieldset->name !== 'contact'):?>
						<?php $fields = $this->form->getFieldset($fieldset->name);?>
						<?php foreach ($fields as $field) : ?>
							<div class="control-group">
								<?php if ($field->hidden) : ?>
									<div class="controls">
									 <?php echo $field->input;?>
									</div>
								<?php else:?>
									<div class="control-label">
										<?php echo $field->label; ?>
										<?php if (!$field->required && $field->type !== 'Spacer') : ?>
											<span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
										<?php endif; ?>
									</div>
									<div class="controls"><?php echo $field->input;?></div>
								<?php endif;?>
							</div>
						<?php endforeach;?>
					<?php endif ?>
				<?php endforeach;?>
				<div class="form-actions">
					<input type="hidden" name="option" value="com_contact" />
					<input type="hidden" name="task" value="contact.submit" />
					<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
					<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</div>
	</form>
</div>
