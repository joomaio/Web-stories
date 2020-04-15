<?php 

defined('_JEXEC') or die("<a href='index.php'>home<a>"); 
$jinput = JFactory::getApplication()->input;
$component = $jinput->get('option');
$view = $jinput->get('view');
$img = "$this->baseurl/templates/$this->template/images";

if ( $this->params->get('siteName') ) $siteName = $this->params->get('siteName');
else $siteName = JText::_('TPL_STORIES_LOGO_SITENAME_DEFAULT');
if ( $this->params->get('templateInfo') ) $info = $this->params->get('templateInfo');
else $info = JText::_('TPL_STORIES_TEMPLATE_INFO_DEFAULT');
if ( $this->params->get('imgIntro') ) $imgIntro = $this->params->get('imgIntro');
else $imgIntro = "$img/website.jpg";

// $i=0;
// for($i=1;$i<131;$i++)
// {
// 	$db = JFactory::getDbo();

// $query = $db->getQuery(true);

// Fields to update.
// $fields = array(
//     $db->quoteName('catid') . ' = ' . $db->quote($i%7+94)
// );

// Conditions for which records should be updated.
// $conditions = array(
//     $db->quoteName('id') . ' ='. $i, 
// );

// $query->update($db->quoteName('k278_stories'))->set($fields)->where($conditions);

// $db->setQuery($query);

// $result = $db->execute();
// }

?>

<!doctype html>
<html lang="en">
    <head>
		<jdoc:include type="head"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta charset="UTF-8">
		<!-- core js materialize -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
		<!-- font -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:400,300,500,700,900" rel="stylesheet" type="text/css">
		
		<!-- core icon -->
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/jui/css/icomoon.css">
		<!-- icon -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- custom css -->
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/materialize.css">
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/materialize.min.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style.css" type="text/css" />
    </head>
    <body>
        <header>
			<div class="navbar-fixed">
				<nav class="header">
					<div class="container">
						<div class="row">
							<div class="nav-wrapper">
                            <a href="<?php echo $this->baseurl;; ?>" class="brand-logo"><?php echo $siteName; ?></a>
                            <div class="right">
                                <jdoc:include type="modules" name="menu" style="menu"/> 
                            </div>
							</div>
						</div>
					</div>
				</nav>
			</div>
        </header>
		<?php if ( $component == "com_stories" && $view == "categories" ): ?>
        <section class="container">
			<div class="row">
				<img src="<?php echo $imgIntro; ?>" class="forcefullwidth_wrapper_tp_banner">
			</div>
		</section>
		<?php endif; ?>
		<?php if ( $this->countModules('breadcrumbs') ): ?>
			<jdoc:include type="module" name="breadcrumbs"/>
		<?php endif; ?>

        <main role="main" class="container">
                <?php if ( $this->countModules('right') ){ ?>
                    <div class="row">
                        <div class="col s9">
                            <jdoc:include type="message"/>
                            <jdoc:include type="component"/>
                        </div>
                        <div class="col s3">
                            <jdoc:include type="modules" name="right" /> 
                        </div>
                    </div>
                <?php } else{ ?>
                    <jdoc:include type="message"/>
                    <jdoc:include type="component"/>
                <?php } ?>
        </main>
        
        <footer class="footer footer-four">
			<div class="primary-footer brand-bg text-center">
				<div class="container">
					<div class="right-align go-to-top">
						<a href="#" class="page-scroll btn-floating btn-large pink back-top waves-effect waves-light700 right-align" data-section="#top">
						<i class="material-icons"></i>
						</a>
					</div>
					<div class="footer-logo center">
						<img src="<?php echo $img; ?>/logo.png" alt="">
					</div>
					<div class="row">
						<div class="col s3"></div>
						<div class="col s7 center-align">
						<span class="copy-text">
							<?php echo JText::_("TPL_STORIES_COPYRIGHT")." "; ?><a ><?php //echo JText::_("TPL_STORIES_TEMPLATE_ORIGIN") ?></a> &nbsp; | 
							&nbsp; <?php echo JText::_("TPL_STORIES_RESERVED"); ?> &nbsp; | 
							&nbsp; <?php echo JText::_("TPL_STORIES_DESIGNED_BY"); ?> <a><?php echo JText::_("TPL_STORIES_AUTHOR"); ?></a>
						</span>
						<div class="footer-intro">
							<p><?php echo $info; ?></p>
						</div>
					</div>
				</div>
			</div>
			
			<!-- <div class="secondary-footer brand-bg darken-2 text-center">
				<nav class="darken-2 light-blue center-align center">
					<div class="container">
						<ul >
							<li><a href="#">Home</a></li>
							<li><a href="#">About us</a></li>
							<li><a href="#">Services</a></li>
							<li><a href="#">Portfolio</a></li>
							<li><a href="#">Contact us</a></li>
						</ul>
					</div>
				</nav>
			</div> -->
			</footer>
    </body>
</html>