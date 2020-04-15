<?php

defined('_JEXEC') or die('Restricted access');
$dem = 0;

?>

<?php foreach ($this->categories as $index => $category): ?>
<div class="row">
	<div class="text-center mb-80">
		<a href="<?php  echo JRoute::_('index.php?option=com_stories&view=category&catid='.$category['id']); ?>">
			<h2 class="section-title"><?php echo $category['name']; ?></h2>
		</a>
	</div>
<?php 
	foreach ($this->items[$index] as $key => $story ): 
		if ( $key % 3 == 0 ) echo "<div class='row' >";
?>
		<div class="col col-article">
			<article class="card post-wrapper">
				<div class="thumb-wrapper waves-effect waves-block waves-light card-image">
					<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$category['id']); ?>">
						<img src="<?php echo $story->feature_img; ?>" style="height:225px;width=100%;" class="activator" alt="">
					</a>
				</div>
				<div class="blog-content card-content">
					<header class="entry-header-wrapper sticky">
						<div class="entry-header">
							<h2 class="entry-title">
								<a href="<?php echo JRoute::_('index.php?option=com_stories&view=story&id='.$story->id.'&catid='.$category['id']); ?>"><?php echo $story->name; ?></a>
							</h2>
							<div class="entry-meta">
								<ul class="list-inline">
									<li>By <span><?php echo $story->creator; ?><span></li>
									<li>
									In <a href="<?php  echo JRoute::_('index.php?option=com_stories&view=category&id='.$category['id']); ?>">
											<?php echo $category['name']; ?>
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
<?php endforeach; ?>
