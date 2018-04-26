<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="my_profile">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('My Profile'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divMyProfileContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<form id="formMyProfile" name="formMyProfile" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>my_profile/formchangeprofile" class="form-horizontal" target="iframeFormMyProfile"  enctype="multipart/form-data">
						<div class="row">
							<div class="col l6 m6 s12 center-align" style="margin-bottom: 40px;">
								<figure>
									<img id="imgCurrentImage" src="<?php echo $controller->spritpaneluserimage; ?>" width="150" height="150" class="z-depth-1 circle"/>
									<input type="hidden" id="strCurrentImageSource" name="strCurrentImageSource" value="">
									<input type="hidden" id="strCurrentImageType" name="strCurrentImageType" value="<?php echo $controller->spritpaneluserimagetype; ?>">


								</figure>
								<button id="buttonChangeCurrentImage" data-default-text="UPLOAD IMAGE" data-loading-text="UPLOADING IMAGE..." type="button" class="waves-effect waves-dark btn white blue-text text-darken-4">UPLOAD IMAGE</button>
							</div>
							<div class="col l6 m6 s12">
								<div class="row">
									<div class="col s12">
										<div class="card green divFormResult" id="divFormSuccess">
											<div class="card-content white-text">
												<p id="pSuccessMessage"></p>
											</div>
										</div>
										<div class="card red divFormResult" id="divFormError">
											<div class="card-content white-text">
												<p id="pErrorMessage"></p>
											</div>
										</div>
									</div>
									<div class="col s12">
										<div>
											<label for="spritpanelusername"><?php echo (0 == $controller->spritpanelusertype) ? '<span class="step size-32"><i class="icon ion-locked"></i></span> ' : ''; ?><?php echo __('First Name'); ?></label>
										</div>
										<div class="input-field">
											<input id="spritpanelusername" name="spritpanelusername" type="text" class="blue-text text-darken-4" value="<?php echo $controller->spritpanelusername; ?>" placeholder="" <?php echo (0 == $controller->spritpanelusertype) ? 'disabled' : ''; ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<div>
											<label for="spritpaneluseremail"><?php echo (0 == $controller->spritpanelusertype) ? '<span class="step size-32"><i class="icon ion-locked"></i></span> ' : ''; ?><?php echo __('E-mail Address'); ?></label>
										</div>
										<div class="input-field">
											<input id="spritpaneluseremail" name="spritpaneluseremail" type="text" class="blue-text text-darken-4" value="<?php echo $controller->spritpaneluseremail; ?>" placeholder="" <?php echo (0 == $controller->spritpanelusertype) ? 'disabled' : ''; ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<div class="switch collapsed">
											<label>
												<input id="changePassword" name="changePassword" value="1" type="checkbox" <?php echo (0 == $controller->spritpanelusertype) ? 'disabled' : ''; ?>>
												<span class="lever"></span>
											</label>
											<?php echo (0 == $controller->spritpanelusertype) ? '<span class="step size-32"><i class="icon ion-locked"></i></span> ' : ''; ?><label for="changePassword"><?php echo __('Change Password'); ?></label>
										</div>
									</div>
								</div>
								<div class="row sh-element sh-changePassword-true" style="display:none;">
									<div class="col s12">
										<div>
											<label for="oldPassword"><?php echo __('Password'); ?></label>
										</div>
										<div class="input-field">
											<input id="oldPassword" name="oldPassword" type="password" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
									<div class="col s12">
										<div>
											<label for="newPassword"><?php echo __('New Password'); ?></label>
										</div>
										<div class="input-field">
											<input id="newPassword" name="newPassword" type="password" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
									<div class="col s12">
										<div>
											<label for="newPasswordAgain"><?php echo __('New Password Again'); ?></label>
										</div>
										<div class="input-field">
											<input id="newPasswordAgain" name="newPasswordAgain" type="password" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col offset-l6 l6 offset-m6 m6 s12">
									<button id="buttonSaveMyProfileForm" name="buttonSaveMyProfileForm" data-default-text="<?php echo __('Save');?>" data-loading-text="<?php echo __('Saving...');?>" data-error-text="<?php echo __('Error'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save');?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <div id="divEditCurrentImage" class="divDialogContent">
    	<div class="divContentWrapper">
    		<div class="divDialogContentContainer">
    			<header class="headerHero z-depth-1 blue darken-4">
    				<div class="divHeaderInfo">
    					<h3 class="blue-text text-darken-4">Profile Image</h3>
    				</div>
    				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divEditCurrentImage"><i class="ion-android-close blue-text text-darken-4"></i></button>
    			</header>
    			<div class="divContentPanel z-depth-1 white">
					<form id="formEditProfileImage" name="formEditProfileImage" method="post" class="form-horizontal" style="min-height:250px;">
						<div class="row center">
							<img src="<?php echo $controller->spritpaneluserimage; ?>" id="imgUploadedImage" style="display:none;"/>
							<input id="filUploadedImage" name="filUploadedImage" style="display:none;" type="file"/>
							<div class="divChangeImage col s12">
								<a class="aChangeImage waves-effect waves-light btn-large blue darken-4" href="JavaScript:void(0);" title="Upload">Upload Image</a>
							</div>
						</div>
						<div class="row">
							<div class="col s12 center">
								<div id="divEditProfileImage">
									<div class="imagesCropWrapper" data-handle-before="true">
										<div class="divCroppedImage" id="divCroppedImage"></div>
										<div id="divRevisedImage"></div>
									</div>
								</div>
							</div>
							<div id="divCroppedImages" hidden="true">
								<canvas id="canvasImage" width="200" height="200" style="display:none;"></canvas>
							</div>
						</div>
						<div class="row" style="margin-top:0px;">
							<p class="range-field center">
								<i class="ion-image tifika-text-color tiny"></i>
								<input type="range" id="resizeImage" min="0" max="100" style="width:155px;"/>
								<i class="ion-image tifika-text-color small"></i>
							</p>
						</div>
						<div class="row">
                            <div class="input-field">
                                <div class="col s6">
                                    <button id="buttonCancelSaveImage" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12" data-container-dialog="divEditCurrentImage">Cancel</button>
                                </div>
                                <div class="col s6">
                                    <button id="buttonSaveImage" type="button" class="buttonSaveImage buttonSaveChanges waves-effect waves-light btn-large blue darken-4 col s12" data-default-text="Save Image" data-loading-text="Saving Image...">Save Image</button>
                                </div>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="divDialogContent divLoader" id="divLoader">
        <div class="divContentWrapper level4">
            <div class="divDialogContentContainer">
                <div class="progress blue-grey lighten-4">
                    <div id="divLoaderProgress" class="indeterminate blue darken-4" style="width: 100%;" data-progress="100"></div>
                </div>
                <div class="row">
                    <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text="Loading..."></div>
                </div>
            </div>
        </div>
    </div>
	<div class="divHiddenElements">
		<canvas id="canvasTemplate"></canvas>
		<div id="divRevisedImageTemplate">
			<img id="imgRevisedImage__DELETE__" src="" data-img-type="__IMAGE_TYPE__">
		</div>
	</div>
	<iframe id="iframeFormMyProfile" name="iframeFormMyProfile" class="iframeFormPOST"></iframe>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/my_profile.js"></script>
</body>
</html>