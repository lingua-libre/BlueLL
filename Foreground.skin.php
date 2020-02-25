<?php

/**
 * Skin file for Foreground
 *
 * @file
 * @ingroup Skins
 */


class Skinforeground extends SkinTemplate {
	public $skinname = 'foreground', $stylename = 'foreground', $template = 'foregroundTemplate', $useHeadElement = true;

	public function setupSkinUserCss(OutputPage $out) {
		parent::setupSkinUserCss($out);
		$out->addHeadItem('ie-meta', '<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
		$out->addModuleStyles('skins.foreground.styles');
	}

	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;
		parent::initPage($out);

		$viewport_meta = 'width=device-width, user-scalable=yes, initial-scale=1.0';
		$out->addMeta('viewport', $viewport_meta);
		$out->addModules('skins.foreground.js');
	}

}

class foregroundTemplate extends BaseTemplate {
	public function execute() {
		global $wgUser;
		wfSuppressWarnings();
		$this->html('headelement');
		$body = '';

?>
<!-- START FOREGROUNDTEMPLATE -->
		<header id="navwrapper">
			<nav data-topbar role="navigation" data-options="back_text: <?php echo wfMessage( 'foreground-menunavback' )->text(); ?>">
				<ul class="title-area">
					<li>
						<div class="title-name">
							<a href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>">
								<img alt="<?php echo $this->text('sitename'); ?>" class="top-bar-logo" src="<?php echo $this->text('logopath') ?>">
								<h1 class="title-name"><?php echo $GLOBALS['wgSitename']; ?></h1>
							</a>
						</div>
					</li>
					<li class="toggle-topbar menu-icon">
						<a href="#"><span><?php echo wfMessage( 'foreground-menutitle' )->text(); ?></span></a>
					</li>
				</ul>

				<section id="top-bar-sections">
					<ul id="top-bar-top-menu">
						<!-- Search form -->
						<li>
							<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform" class="mw-search" role="search">
								<?php echo $this->makeSearchInput(array('placeholder' => wfMessage('Linksearch-ok')->text(), 'id' => 'searchInput') ); ?>
								<button type="submit" title="<?php echo wfMessage( 'search' )->text() ?>"></button>
							</form>
						</li>

						<!-- Language selector -->
						<li>
							<?php foreach ( $this->getPersonalTools() as $key => $item ) { if ($key == "uls") { echo $this->makeListItem($key, $item); break; } } ?>
						</li>

						<!-- Record call-to-action -->
						<li id="p-record">
							<?php $recordwizardTitle = Title::newFromText( "Special:RecordWizard" ); ?>
							<?php echo $this->makeLink( "RecordWizard", [ "msg" => "Record", "href" => $recordwizardTitle->getFullURL(), "accesskey" => "r" ] ); ?></a>
						</li>

						<!-- Personal menu dropdown -->
						<li id="p-personal" class="dropdown">
							<a href="#"></a>
							<ul class="dropdown-content">
								<?php foreach ( $this->getPersonalTools() as $key => $item ) { if ($key != "uls") { echo $this->makeListItem($key, $item); } } ?>
							</ul>
						</li>

					</ul>

					<div id="top-bar-bottom-menu">
						<?php foreach ( $this->getSidebar() as $boxName => $box ) { if ( $box['header'] != wfMessage( 'toolbox' )->text() && $box['id'] != 'p-lang'  ) { ?>
							<ul class="bottom-menu-item horizontal-menu"  id='<?php echo Sanitizer::escapeId( $box['id'] ) ?>'<?php echo Linker::tooltip( $box['id'] ) ?>>
								<?php if ( is_array( $box['content'] ) ) { ?>
								<?php foreach ( $box['content'] as $key => $item ) { echo $this->makeListItem( $key, $item ); } ?>
								<?php } } ?>
							</ul>
						<?php } ?>

						<div id="action-menu" class="bottom-menu-item dropdown">
							<a id="actions-button" href="#"><?php echo wfMessage( 'actions' )->text() ?></a>
							<ul id="actions" class="dropdown-content">
								<?php foreach( $this->data['content_actions'] as $key => $item ) { echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem($key, $item)); } ?>
								<?php wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );  ?>
							</ul>
						</div>
					</div>
				</section>
			</nav>
		</header>

		<section id="page-content">
			<aside style="display: none;"> <!-- TODO: temporary hidden, how should it be styled ?
				<!-- If user is logged in output echo location -->
				<?php if ($wgUser->isLoggedIn()): ?>
					<div id="echo-notifications">
						<div id="echo-notifications-alerts"></div>
						<div id="echo-notifications-messages"></div>
						<div id="echo-notifications-notice"></div>
					</div>
				<?php endif; ?>

				<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="sitenotice"><?php $this->html( 'sitenotice' ); ?></div><?php } ?>
				<?php if ( $this->data['newtalk'] ) { ?><div id="usermessage" class="newtalk"><?php $this->html( 'newtalk' ); ?></div><?php } ?>

				<div id="mw-js-message" style="display:none;"></div>
			</aside>

			<article id="content" role="main">
				<header id="contentHeading">
					<hgroup>
						<?php
						$namespace = str_replace('_', ' ', $this->getSkin()->getTitle()->getNsText());
						$displaytitle = $this->data['title'];
						if (!empty($namespace)) {
							$pagetitle = $this->getSkin()->getTitle();
							$newtitle = str_replace($namespace.':', '', $pagetitle);
							$displaytitle = str_replace($pagetitle, $newtitle, $displaytitle);
						?>
							<h4 class="namespace"><?php print $namespace; ?></h4>
						<?php } ?>
						<h1 id="firstHeading" class="title"><?php print $displaytitle; ?></h1>
						<h2 id="contentSub"><?php $this->html('subtitle') ?></h2>
						<?php echo $this->getIndicators(); ?>
					</hgroup>
				</header>
				<div id="bodyContent" class="mw-bodytext">
					<?php $this->html('bodytext'); ?>
					<div class="clear_both"></div>
				</div>
	    		<footer>
					<?php $this->html('catlinks'); ?>
		    		<?php $this->html('dataAfterContent'); ?>
				</footer>
			</article>
		</section>

		<footer id="footer">
			<div id="footer-left">
				<?php $footerLinks = $this->getFooterLinks(); ?>
				<ul id="footer-left-top">
					<?php foreach ( $footerLinks["info"] as $key ) { ?>
						<li id="footer-<?php echo $key ?>"><?php $this->html( $key ) ?></li>
					<?php } ?>
				</ul>
				<ul id="footer-left-bottom">
					<?php foreach ( $footerLinks["places"] as $key ) { ?>
						<li id="footer-<?php echo $key ?>"><?php $this->html( $key ) ?></li>
					<?php } ?>
				</ul>
			</div>
			<ul id="footer-right-icons">
				<li id="toolbox-menu" class="bottom-menu-item dropdown">
					<a id="toolbox-button" href="#"><?php echo wfMessage( 'toolbox' )->text() ?></a>
					<ul id="toolbox" class="dropdown-content">
						<?php foreach ( $this->getToolbox() as $key => $item ) { echo $this->makeListItem($key, $item); } ?>
						<li id="n-recentchanges"><?php echo Linker::specialLink('Recentchanges') ?></li>
					</ul>
				</li>

				<?php foreach ( $this->getFooterIcons( "icononly" ) as $blockName => $footerIcons ) { ?>
					<li class="<?php echo $blockName ?>">
						<?php foreach ( $footerIcons as $icon ) { ?>
							<?php echo $this->getSkin()->makeFooterIcon( $icon, "withImage" ); ?>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</footer>

		<?php $this->printTrail(); ?>

		</body>
		</html>

<?php
		wfRestoreWarnings();
	}
}
?>
