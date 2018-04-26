		<?php include(SPRITPANEL_CNFDIR . '/Menu.php'); ?>
		<ul id="ulSideNavCollapsibleMenu" class="collapsible accordion">
			<?php

			$menuArray = array();
			includeLibrary('spritpanel/getSideMenu');
			$menuArray = getSideMenu();

			$countMenuArray = count($menuArray);
			for ($i=0; $i < $countMenuArray; $i++) { 
				if ($menuArray[$i]['visible']) {
					$strHref = '';
					if ('' == $menuArray[$i]['URL']) {
						$strHref = 'javascript:void(0);';
					} else {
						$strHref = $_SPRIT['SPRITPANEL_URL_PREFIX'] . $menuArray[$i]['URL'];
					} // if ('' == $menuArray[$i]['URL']) {
					?>
					<li id="pageurl<?php echo $menuArray[$i]['id']; ?>">
						<a class="pageurl<?php echo $menuArray[$i]['id']; ?> collapsible-header waves-effect waves-light" href="<?php echo $strHref; ?>">
							<?php echo __($menuArray[$i]['name']); ?>
						</a>
						<?php
						$subMenus = array();
						$hasChild = false;
						
						if (count($menuArray[$i]['subMenus'])) {
							?>
							<div class="collapsible-body" style="display: block;">
								<ul>
									<?php
									$subMenus = $menuArray[$i]['subMenus'];
									$countSubmenuArray = count($subMenus);
									for ($j=0; $j < $countSubmenuArray; $j++) {
										if($subMenus[$j]['visible']) {
											$strHref = '';
											if ('' == $subMenus[$j]['URL']) {
												$strHref = 'javascript:void(0);';
											} else {
												$strHref = $_SPRIT['SPRITPANEL_URL_PREFIX'] . $subMenus[$j]['URL'];
											} // if ('' == $subMenus[$j]['URL']) {
											?>
											<li data-parent-url="<?php echo $menuArray[$i]['id']; ?>" id="pageurl<?php echo $subMenus[$j]['id']; ?>">
												<a class="" href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX'] . $subMenus[$j]['URL']; ?>">
													<?php echo __($subMenus[$j]['name']); ?>
												</a>
											</li>
											<?php
										} // if($subMenus[$j]['visible']) {								
									} // for ($j=0; $j < $countSubmenuArray; $j++) {
									?>
								</ul>
							</div>
							<?php
						} // if (count($menuArray[$i]['subMenus'])) {
						?>
					</li>
					<?php
				} // if ($menuArray[$i]['visible']) {
			} // for ($i=0; $i < $countMenuArray; $i++) { 
			?>
		</ul>