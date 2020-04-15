<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<address>
	<?php if (($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode) && ($addressCheck = $this->params->get('address_check') > 0)) : ?>
		<address>
			<i class="material-icons brand-color"></i>
			<div class="address">
				<p>
					<?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
						<?php echo nl2br($this->contact->address); ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
						<?php echo $this->contact->suburb; ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->state && $this->params->get('show_state')) : ?>
						<?php echo $this->contact->state; ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->country && $this->params->get('show_country')) : ?>
						<?php echo $this->contact->country; ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
						<?php echo JText::_("TPL_STORIES_POSTCODE").": "; ?>
						<?php echo $this->contact->postcode; ?>
						<br/>
					<?php endif; ?>
				</p>
			</div>
			<i class="material-icons brand-color"></i>
			<div class="phone">
				<p>
					<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
						<?php 
							//echo $this->params->get('marker_telephone'); 
							echo JText::_("TPL_STORIES_PHONE").": ";
						?>
						<?php 
							echo nl2br($this->contact->telephone); 
						?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
						<?php 
							//echo $this->params->get('marker_fax'); 
							echo JText::_("TPL_STORIES_FAX").": ";
						?>
						<?php echo nl2br($this->contact->fax); ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
						<?php 
							//echo $this->params->get('marker_mobile'); 
							echo JText::_("TPL_STORIES_MOBILE").": ";
						?>
						<?php echo nl2br($this->contact->mobile); ?>
						<br/>
					<?php endif; ?>
				</p>
			</div>
			<i class="material-icons brand-color"></i>
			<div class="mail">
				<p>
					<?php if ($this->contact->email_to) : ?>
						<?php 
							//echo $this->params->get('marker_email'); 
							echo JText::_("TPL_STORIES_EMAIL").": ";
						?>
						<?php echo $this->contact->email_to; ?>
						<br/>
					<?php endif; ?>
					<?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
						<a href="<?php echo $this->contact->webpage; ?>" target="_blank" rel="noopener noreferrer">
						<?php echo $this->contact->webpage; ?></a>
						<br/>
					<?php endif; ?>
					
				</p>
			</div>
	<?php endif; ?>
</address>

