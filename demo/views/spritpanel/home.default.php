<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="home" data-cache-all-required="<?php echo $controller->cacheAllRequired; ?>">
	<?php includeView($controller, 'spritpanel/header'); ?>
    <div id="divCacheAllDialog" class="divDialogContent">
        <div class="divContentWrapper">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4"><?php echo __('Cache Manager'); ?></h3>
                    </div>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formCacheAll" name="formCacheAll" method="post" class="form-horizontal">
                        <div id="divCacheClassListLoaderContainer" class="row">
                        	<div class="col s12">
				                <div class="progress blue-grey lighten-4">
				                    <div class="indeterminate blue darken-4" style="width: 100%;" data-progress="100"></div>
				                </div>
				                <p><?php echo __('Loading class list ...'); ?></p>
			            	</div>
                        </div>
                        <div id="divCacheClassListContainer" style="display: none;">
                        	<div class="row">
	                        	<div class="col s12">
	                        		<p><?php echo __('Please choose classes to be cached from the list below:'); ?> (<a class="aCacheClassListSelectAll" href="JavaScript:void(0);"><?php echo __('Select All'); ?></a> / <a class="aCacheClassListSelectNone" href="JavaScript:void(0);"><?php echo __('Select None'); ?></a>)</p>
	                        	</div>
                        	</div>
                        	<div id="divCacheClassList" class="row">
                        		
                        	</div>
                        	<div class="row">
                                <div class="col s12">
                                    <button id="buttonStartCacheProcess" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Start'); ?></button>
                                </div>
                        	</div>
                        </div>
                        <div id="divCacheProcessContainer" class="row" style="display: none;">
                            <div class="col s12">
                                <div class="progress blue-grey lighten-4">
                                    <div id="divCacheProcessMinorProgressBar" class="determinate blue darken-4" style="width: 0%;" data-progress="0"></div>
                                </div>
                                <p id="pCacheProcessMinorProgressText" data-template-text="Caching records %1 / %2 ..." data-completed-text="Completed!">&nbsp;</p>
                            </div>
                            <div class="col s12">
                                <div class="progress blue-grey lighten-4">
                                    <div id="divCacheProcessMajorProgressBar" class="determinate blue darken-4" style="width: 0%;" data-progress="0"></div>
                                </div>
                                <p id="pCacheProcessMajorProgressText" data-template-text="Caching model %1 (%2 / %3) ..." data-completed-text="Completed!">&nbsp;</p>                                
                            </div>
                        </div>
                        <div class="row" id="divCacheProcessCloseButtonContainer" style="display: none;">
                            <div class="col s12">
                                <button type="button" class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12" data-container-dialog="divCacheAllDialog"><?php echo __('Close'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="divHiddenElements">
		<div id="divCacheClassListTemplate">
				<div class="col s12">
                    <label class="checkbox2 left-align" for="inputCacheClass__CLASS_NAME__">
                        <input class="inputCacheClass inputCacheClass__CLASS_NAME__" id="inputCacheClass__CLASS_NAME__" name="inputCacheClass__CLASS_NAME__" checked="checked" value="__CLASS_NAME__" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                        <span>__CLASS_NAME__</span>
                    </label>
				</div>
			</div>
		</div>
    </div>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/home.js"></script>
</body>
</html>