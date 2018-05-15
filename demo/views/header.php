	<header>
		<div class="navbar-fixed">
			<nav class="blue darken-4">
				<div class="divTopMenu nav-wrapper">
					<div class="row">
						<div class="col s12" style="padding: 0px;">
							<button id="buttonTopMenuSideNav" type="button" class="btn btn-flat waves-effect waves-light white-text buttonTopMenu notransition" data-activates="ulSideNav"><i class="ion-navicon-round"></i></button>
							<img src="assets/img/portallogo.png" height="40px" />
						</div>
						<div id="divPageTopMenu" class="col s9 right-align" style="padding: 0px;">
							<!-- <button id="buttonPageTopMenuPrevious" type="button" class="buttonPageTopMenu btn btn-flat waves-effect waves-light white-text buttonTopMenu notransition"><i class="ion-arrow-left-b"></i></button>
							<button id="buttonPageTopMenuNext" type="button" class="buttonPageTopMenu btn btn-flat waves-effect waves-light white-text buttonTopMenu notransition"><i class="ion-arrow-right-b"></i></button> -->
							<button id="buttonPageTopMenuMore" type="button" class="buttonPageTopMenu btn btn-flat waves-effect waves-light white-text buttonTopMenu dropdown-button notransition" data-activates="ulPageTopMenuMore" data-constrainwidth="false" data-beloworigin="true" data-alignment="right"><i class="ion-android-more-vertical"></i></button>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<ul id="ulSideNav" class="side-nav">
			<li>
				<div class="userView" style="min-height: 150px;background-color: rgba(0, 0, 0, 0.5);">
					<div class="background">
						<img width="300" src="assets/img/side-nav-default-background.jpg">
					</div>
					<a class="aProfileLink" href="<?php echo $_SPRIT['URL_PREFIX']; ?>my_profile">
						<span class="white-text name"><br><br><?php echo $controller->userFirstName . ' ' . $controller->userLastName; ?></span>
					</a>
				</div>
			</li>
			<li>
				<?php includeView($controller, 'divmenulayer'); ?>
			</li>
		</ul>
	</header>