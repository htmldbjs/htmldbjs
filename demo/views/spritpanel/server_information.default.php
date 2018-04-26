<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="server_information">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('Server Information'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divServerInformationContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<div class="row">
						<div class="col l3 m6 s12">
							<div class="card white" style="min-height: 320px;">
								<div class="card-content center">
								  <p><img class="pull-left media-object" src="assets/img/<?php echo $controller->strServerOSIconPath; ?>" width="74" height="64" data-holder-rendered="true" /></p>
					              <span class="card-title blue-text text-darken-4"><?php echo $controller->strServerOSHeader; ?></span>
					              <p class="blue-text text-darken-4">Operating System</p>
					              <p>&nbsp;</p>
					              <p class="grey-text"><?php echo $controller->strServerOSDetail; ?></p>
					            </div>
					        </div>
					    </div>
						<div class="col l3 m6 s12">
							<div class="card white" style="min-height: 320px;">
								<div class="card-content center">
                                  <p><img class="pull-left media-object" src="assets/img/<?php echo $controller->strWebServerIconPath; ?>" width="74" height="64" data-holder-rendered="true" /></p>
					              <span class="card-title blue-text text-darken-4"><?php echo $controller->strWebServerHeader; ?></span>
					              <p class="blue-text text-darken-4">Web Server</p>
					              <p>&nbsp;</p>
					              <p class="grey-text"><?php echo $controller->strWebServerDetail; ?></p>
					            </div>
					        </div>
					    </div>
						<div class="col l3 m6 s12">
							<div class="card white" style="min-height: 320px;">
								<div class="card-content center">
                                  <p><img class="pull-left media-object" src="assets/img/<?php echo $controller->strApplicationIconPath; ?>" width="74" height="64" data-holder-rendered="true" /></p>
					              <span class="card-title blue-text text-darken-4"><?php echo $controller->strApplicationHeader; ?></span>
					              <p class="blue-text text-darken-4">Application Server</p>
					              <p>&nbsp;</p>
					              <p class="grey-text"><?php echo $controller->strApplicationDetail; ?></p>
					            </div>
					        </div>
					    </div>
						<div class="col l3 m6 s12">
							<div class="card white" style="min-height: 320px;">
								<div class="card-content center">
                                  <p><img class="pull-left media-object" src="assets/img/<?php echo $controller->strDatabaseIconPath; ?>" width="74" height="64" data-holder-rendered="true" /></p>
					              <span class="card-title blue-text text-darken-4"><?php echo $controller->strDatabaseHeader; ?></span>
					              <p class="blue-text text-darken-4">Database Server</p>
					              <p>&nbsp;</p>
					              <p class="grey-text"><?php echo $controller->strDatabaseDetail; ?></p>
					            </div>
					        </div>
					    </div>
					</div><!--.row-->
				</div>
			</div>
		</div>
	</div>
	<iframe id="iframeFormDatabase" name="iframeFormDatabase" class="iframeFormPOST"></iframe>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/server_information.js"></script>
</body>
</html>