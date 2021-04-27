<?php

use Wikimedia\AtEase\AtEase;

/**
 * Skin file for BlueLL
 *
 * @file
 * @ingroup Skins
 */


class SkinBlueLL extends SkinTemplate {
	public $skinname = 'bluell', $stylename = 'bluell', $template = 'BlueLLTemplate', $useHeadElement = true;

	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;
		parent::initPage($out);

		$viewport_meta = 'width=device-width, user-scalable=yes, initial-scale=1.0';
		$out->addMeta('viewport', $viewport_meta);
		$out->addModules('skins.bluell.js');
		$out->addHeadItem('ie-meta', '<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
		$out->addModuleStyles('skins.bluell.styles');
	}

}

class BlueLLTemplate extends BaseTemplate {
	public function execute() {
		global $wgUser, $wgVersion;
		if ( method_exists( 'AtEase', 'suppressWarnings' ) ) {
			// MW >= 1.33
			AtEase::suppressWarnings();
		} else {
			Wikimedia\suppressWarnings();
		}
		$this->html('headelement');
		$body = '';

?>
<!-- START BLUELL TEMPLATE -->
		<header id="navwrapper">
			<nav role="navigation" id="menu">
				<ul class="title-area" role="banner">
					<li>
						<div class="title-name">
							<a href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>">
								<img alt="<?php echo $this->text('sitename'); ?>" class="top-bar-logo" src="<?php echo $this->text('logopath') ?>">
								<h1 class="title-name"><?php echo $GLOBALS['wgSitename']; ?></h1>
							</a>
						</div>
					</li>
					<li class="toggle-topbar menu-icon">
						<a href="#"><span><?php echo wfMessage( 'bluell-menutitle' )->text(); ?></span></a>
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
						<?php if ( class_exists( 'SpecialRecordWizard' ) ) {?>
						<li id="p-record">
							<?php $recordwizardTitle = Title::newFromText( "Special:RecordWizard" ); ?>
							<?php echo $this->makeLink( "RecordWizard", [ "msg" => "Record", "href" => $recordwizardTitle->getFullURL(), "accesskey" => "r" ] ); ?></a>
						</li>
						<?php }?>

						<!-- If user is logged in output echo location -->
						<?php if ($wgUser->isLoggedIn()): ?>
							<div id="echo-notifications-alerts"></div>
							<div id="echo-notifications-notice"></div>
						<?php endif; ?>

						<!-- Personal menu dropdown -->
						<li id="personal-menu" class="dropdown mobile-menu">
							<input id="personal-input" type="checkbox" role="button" aria-labelledby="personal-button" autocomplete="off" class="dropdown-input mobile-menu-input">
							<label id="personal-button" for="personal-input" class="dropdown-label mobile-menu-label"></label>
							<ul id="personal" class="dropdown-content mobile-menu-content">
								<?php foreach ( $this->getPersonalTools() as $key => $item ) { if ($key != "uls") { echo $this->makeListItem($key, $item); } } ?>
							</ul>
							<label id="personal-mask" for="personal-input" class="mobile-menu-mask"></label>
						</li>

					</ul>

					<div id="top-bar-bottom-menu">
						<?php foreach ( $this->getSidebar() as $boxName => $box ) { if ( $box['header'] != wfMessage( 'toolbox' )->text() && $box['id'] != 'p-lang'  ) { ?>
							<ul id="<?php echo Sanitizer::escapeIdForAttribute( $box['id'] ) ?>"<?php echo Linker::tooltip( $box['id'] ) ?>>
								<?php if ( is_array( $box['content'] ) ) { ?>
								<?php foreach ( $box['content'] as $key => $item ) { echo $this->makeListItem( $key, $item ); } ?>
								<?php } } ?>
							</ul>
						<?php } ?>

						<!-- Edit button -->
						<?php if ( isset( $this->data['content_actions']['edit'] ) ) { ?>
							<?php echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem('edit', $this->data['content_actions']['edit'], ['tag' => 'span'])); ?>
						<?php } ?>
						<?php if ( isset( $this->data['content_actions']['viewsource'] ) ) { ?>
							<?php $this->data['content_actions']['viewsource']['text'] = wfMessage( 'edit' ); ?>
							<?php echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem('edit', $this->data['content_actions']['viewsource'], ['tag' => 'span'])); ?>
						<?php } ?>

						<!-- Action menu -->
						<div id="actions-menu" class="dropdown">
							<input id="actions-input" type="checkbox" role="button" aria-labelledby="actions-button" autocomplete="off" class="dropdown-input">
							<label id="actions-button" for="actions-input" class="dropdown-label"><?php echo wfMessage( 'actions' )->text() ?></label>
							<ul id="actions" class="dropdown-content">
								<?php foreach( $this->data['content_actions'] as $key => $item ) { if ( $key === 'edit' || $key === 'viewsource' ) { continue; } echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem($key, $item)); } ?>
								<?php
									if ( version_compare( $wgVersion, '1.35', '<' ) ) {
										wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
									}
								?>

							</ul>
						</div>
						<aside id="hamburger-menu" class="mobile-menu">
							<input id="hamburger-input" type="checkbox" role="button" aria-labelledby="hamburger-label" autocomplete="off" class="mobile-menu-input">
							<label id="hamburger-button" for="hamburger-input"  class="mobile-menu-label"><?php echo wfMessage( 'bluell-menutitle' )->text() ?></label>
							<ul id="hamburger" class="mobile-menu-content">
								<!-- Hamburger search form -->
								<li id="m-searchitem">
									<form action="<?php $this->text( 'wgScript' ); ?>" id="m-searchform" class="mw-search" role="search">
										<?php echo $this->makeSearchInput(array('placeholder' => wfMessage('Linksearch-ok')->text(), 'id' => 'm-searchInput') ); ?>
										<button type="submit" title="<?php echo wfMessage( 'search' )->text() ?>"></button>
									</form>
								</li>
								<!-- Hamburger navigation -->
								<?php foreach ( $this->getSidebar() as $boxName => $box ) { if ( $box['header'] != wfMessage( 'toolbox' )->text() && $box['id'] != 'p-lang'  ) { ?>
									<?php if ( is_array( $box['content'] ) ) { ?>
										<?php foreach ( $box['content'] as $key => $item ) { $item[ 'id' ] = "m" . $item[ 'id' ]; echo $this->makeListItem( $key, $item ); } ?>
										<?php break; /* Display only the main menu in the hamburger menu */ ?>
									<?php } } ?>
								<?php } ?>
								<!-- Hamburger Actions -->
								<li id="m-action-menu">
									<a href="#"><?php echo wfMessage( 'actions' )->text() ?></a>
									<ul>
										<?php foreach( $this->data['content_actions'] as $key => $item ) { $item[ 'id' ] = "m" . $item[ 'id' ]; echo preg_replace(array('/\sprimary="1"/','/\scontext="[a-z]+"/','/\srel="archives"/'),'',$this->makeListItem($key, $item)); } ?>
										<?php
											if ( version_compare( $wgVersion, '1.35', '<' ) ) {
												wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
											}
										?>
									</ul>
								</li>
							</ul>
							<label id="hamburger-mask" for="hamburger-input" class="mobile-menu-mask"></label>
						</aside>
					</div>
				</section>
			</nav>
		</header>

		<section id="page-content">
			<aside> <!-- TODO: add style -->

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
				<?php $footerLinks = $this->getFooterLinks();?>
				<ul id="footer-left-top">
					<?php foreach ( $footerLinks["info"] ?? [] as $key ) { ?>
						<li id="footer-<?php echo $key ?>"><?php $this->html( $key ) ?></li>
					<?php } ?>
				</ul>
				<ul id="footer-left-bottom">
					<?php foreach ( $footerLinks["places"] as $key ) { if( substr( $key, 0, 7 ) !== 'social-' ) { ?>
						<li id="footer-<?php echo $key ?>"><?php $this->html( $key ) ?></li>
					<?php } else { ?>
						<li id="footer-<?php echo $key; ?>"><a href="<?php echo wfMessage( $key . '-url' )->text(); ?>"><img src="/skins/BlueLL/assets/stylesheets/icons/<?php echo substr( $key, 7 ); ?>-blue.svg"/></a></li>
					<?php } } ?>
				</ul>
			</div>
			<ul id="footer-right-icons">
				<li id="toolbox-menu" class="dropdown mobile-menu">
					<input id="toolbox-input" type="checkbox" role="button" aria-labelledby="toolbox-button" autocomplete="off" class="dropdown-input mobile-menu-input">
					<label id="toolbox-button" for="toolbox-input" class="dropdown-label mobile-menu-label"><?php echo wfMessage( 'toolbox' )->text() ?></label>
					<ul id="toolbox" class="dropdown-content mobile-menu-content">
						<?php foreach ( $this->getToolbox() as $key => $item ) { echo $this->makeListItem($key, $item); } ?>
						<li id="n-recentchanges"><?php echo Linker::specialLink('Recentchanges') ?></li>
					</ul>
					<label id="toolbox-mask" for="toolbox-input" class="mobile-menu-mask"></label>
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
		if ( method_exists( 'AtEase', 'suppressWarnings' ) ) {
			// MW >= 1.33
			AtEase::restoreWarnings();
		} else {
			Wikimedia\restoreWarnings();
		}
	}
}
?>
