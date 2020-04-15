<?php defined('_JEXEC') or die('Restricted access'); 
$dem=0;
?>

<form action="<?php echo JRoute::_('index.php?option=com_stories&view=category'); ?>" method="post" id="adminForm" name="adminForm">
	<div class="row">
		<div class="text-center mb-80">
			<a href="<?php  echo JRoute::_('index.php?option=com_stories&view=category&id='.$this->catid); ?>">
				<h2 class="section-title"><?php echo $this->category['name']; ?></h2>
			</a>
	</div>
<?php 
	foreach ($this->items as $key => $story ): 
		if ( $key % 3 == 0 ) echo "<div class='row' >";
?>
			<div class="col col-article">
			<article class="card post-wrapper">
				<div class="thumb-wrapper waves-effect waves-block waves-light card-image">
					<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$this->catid); ?>">
						<img src="<?php echo $story->feature_img; ?>" style="height:225px;width=100%;" class="activator" alt="">
					</a>
				</div>
				<div class="blog-content card-content">
					<header class="entry-header-wrapper sticky">
						<div class="entry-header">
							<h2 class="entry-title">
								<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$this->catid); ?>"><?php echo $story->name; ?></a>
							</h2>
							<div class="entry-meta">
								<ul class="list-inline">
									<li>By <span><?php echo $story->creator; ?><span></li>
									<li>
									In <a href="<?php  echo JRoute::_('index.php?option=com_stories&view=category&id='.$this->catid); ?>">
											<?php echo $this->category['name']; ?>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</header>
				</div>
			</article>
		</div>
<?php
		if ( $key % 3 == 2 ) echo "</div>";
		$dem++;
		endforeach; 
		if ( $dem % 3 ) echo "</div>";
?>
	</div>
		<?php echo $this->pagination->getListFooter(); ?>
	
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>