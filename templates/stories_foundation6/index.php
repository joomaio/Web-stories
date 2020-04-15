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
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/foundation6.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/style.css" type="text/css" />
    </head>
    <body>
        <header>
            <div class="grid-container">
                <div class="grid-x">
                <div class="cell auto">
                    <ul class="menu">
                    <li><a href="<?php echo $this->baseurl; ?>"><?php echo $siteName; ?></a></li>
                    <jdoc:include type="modules" name="menu" style="menu"/> 
                    </ul>
                </div>
                <div class="cell small-3"> 
                <ul class="menu"><li>
                    <jdoc:include type="modules" name="search"/> 
                    </li></ul>
                </div>
                </div>
            </div>
        </header>
        <div class="grid-container">
            <div class="grid-x">
                <div class="cell">
                    <jdoc:include type="modules" name="header"/>
                </div>
            </div>
        </div>
        
        <main role="main" class="grid-container">
            <div class="grid-x">
            <?php if ( $this->countModules('left') ): ?>
                <div class="cell small-3">
                    <jdoc:include type="modules" name="left" /> 
                </div>
            <?php endif; ?>
            <div class="cell auto">
                <div><jdoc:include type="message"/></div>
                <div><jdoc:include type="component"/></div>
                <div><jdoc:include type="modules" name="bottom"/></div>
            </div>
            </div>
        </main>
        
        <footer class="grid-container">
            <div class="grid-x">
                <?php if ( $this->countModules('footer') ): ?>
                    <div class="cell"> <jdoc:include type="modules" name="footer" /> </div> 
                <?php endif; ?>
                <div class="cell auto">
                    <a href="#" class="float-right">Back to top</a> 
                    <p> 2020 © Webstories </p>
                </div>
            </div>
        </footer>
    </body>
</html>