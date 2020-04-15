<?php 

defined('_JEXEC') or die("<a href='index.php'>home<a>"); 
if ( $this->params->get('siteName') ) $siteName = $this->params->get('siteName');
else $siteName = JText::_('TPL_STORIES_LOGO_SITENAME_DEFAULT');

?>

<!doctype html>
<html lang="en">
    <head>
        <jdoc:include type="head"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="UTF-8">
        <!-- core bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- core icon -->
        <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/jui/css/icomoon.css">
        <!-- custom css -->
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/style.css" type="text/css" />
    </head>
    <body id="stories">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container">
                    <a href="<?php echo $this->baseurl; ?>" class="navbar-brand"><?php echo $siteName; ?></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="menu col-12"> <jdoc:include type="modules" name="menu" style="menu"/> </div>   
                        <!-- <div class="nav navbar-collapse float-right"> 
                            <jdoc:include type="modules" name="search"/> 
                        </div> -->
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="container">
            <jdoc:include type="modules" name="header"/>
        </div>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php if ( $this->countModules('left') ){ ?>
                        <div class="col-lg-3 order-lg-1">
                            <jdoc:include type="modules" name="left" /> 
                        </div>
                    <div class="col-9 order-lg-12">
                    <?php } else { ?>
                    <div class="col-12 order-lg-12">
                    <?php }?>
                        <div class="span12"><jdoc:include type="message"/></div>
                        <jdoc:include type="component"/>
                        <div class="row"> <jdoc:include type="modules" name="bottom"/> </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="container">
            <?php if ( $this->countModules('footer') ): ?>
                <jdoc:include type="modules" name="footer" /> 
            <?php endif; ?>
            <p class="float-right"><a href="#">Back to top</a> </p>
            <p> 2020 © Webstories </p>
        </div>
    </body>
</html>