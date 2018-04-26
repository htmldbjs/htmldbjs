<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
      data-page-url="my_profile">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a></h2>
    <h1>Profilim</h1>
</div>
<section class="sectionContent">
    <div class="col s12 m7">
        <div class="card horizontal grey lighten-3">
            <div class="card-stacked">
                <div class="card-content">
                    <div class="row">
                        <div class="col l3 m3 s12">
                            <label><?php echo __('Ad'); ?></label>
                            <div class="input-field">
                                <p><?php echo $controller->userFirstName; ?></p>
                            </div>
                        </div>
                        <div class="col l3 m3 s12">
                            <label><?php echo __('Soyad'); ?></label>
                            <div class="input-field">
                                <p><?php echo $controller->userLastName; ?></p>
                            </div>
                        </div>
                        <div class="col l6 m6 s12">
                            <label><?php echo __('E-posta Adresi'); ?></label>
                            <div class="input-field">
                                <p><?php echo $controller->userEmail; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button id="buttonEdit" name="buttonEdit" data-modal="divProfileDialog" class="buttonAction buttonShowModal waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-edit col s12"></i> <?php echo __('UPDATE'); ?></button>
                    <button id="buttonChangePassword" id="buttonChangePassword" data-modal="divPasswordDialog" class="buttonAction buttonShowModal waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-unlocked"></i> <?php echo __('CHANGE PASSWORD'); ?></button>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="divProfileDialog" class="divDialogContent divDialogActive">
    <div class="divContentWrapper level2" style="display: block; opacity: 1;">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 blue darken-4">
                <div class="divHeaderInfo">
                    <h3 class="blue-text text-darken-4"><?php echo __('Profile Information'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
                        data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i>
                </button>
            </header>
            <div class="divContentPanel z-depth-1 white">
                <form id="formProfile" name="formProfile" method="post" class="form-horizontal">
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="col s6">
                                    <label for="firstname"><?php echo __('Ad'); ?></label>
                                    <div class="input-field">
                                        <input id="firstname" name="firstname" type="text" value="<?php echo $controller->userFirstName; ?>" class="inputProfile">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <label for="lastname"><?php echo __('Soyad'); ?></label>
                                    <div class="input-field">
                                        <input id="lastname" name="lastname" type="text" value="<?php echo $controller->userLastName; ?>" class="inputProfile">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="email"><?php echo __('E-posta Adresi'); ?></label>
                                    <div class="input-field">
                                        <input id="email" name="email" type="email" value="<?php echo $controller->userEmail; ?>" class="inputProfile">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <div class="col s6">
                                <button type="button"
                                        class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"
                                        data-container-dialog="divProfileDialog"><?php echo __('İPTAL'); ?>
                                </button>
                            </div>
                            <div class="col s6">
                                <button id="buttonSaveProfile" name="buttonSaveProfile" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="divPasswordDialog" class="divDialogContent divDialogActive">
    <div class="divContentWrapper level2" style="display: block; opacity: 1;">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 blue darken-4">
                <div class="divHeaderInfo">
                    <h3 class="blue-text text-darken-4"><?php echo __('Change Password'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
                        data-container-dialog="divPasswordDialog"><i class="ion-android-close blue-text text-darken-4"></i>
                </button>
            </header>
            <div class="divContentPanel z-depth-1 white">
                <form id="formPassword" name="formPassword" method="post" class="form-horizontal">
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="col s12">
                                    <label for="currentPassword"><?php echo __('Mevcut Şifre'); ?></label>
                                    <div class="input-field">
                                        <input id="currentPassword" name="currentPassword" type="password" value="" class="inputPassword">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="newPassword"><?php echo __('Yeni Şifre'); ?></label>
                                    <div class="input-field">
                                        <input id="newPassword" name="newPassword" type="password" value="" class="inputPassword">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="newPassword2"><?php echo __('Yeni Şifre (Tekrar)'); ?></label>
                                    <div class="input-field">
                                        <input id="newPassword2" name="newPassword2" type="password" value="" class="inputPassword">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <div class="col s6">
                                <button type="button"
                                        class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"
                                        data-container-dialog="divPasswordDialog"><?php echo __('İPTAL'); ?>
                                </button>
                            </div>
                            <div class="col s6">
                                <button id="buttonSavePassword" name="buttonSavePassword" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="divErrorDialog" class="divDialogContent divAlertDialog divErrorDialog">
    <div class="divContentWrapper level3">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 red darken-4">
                <div class="divHeaderInfo">
                    <h3 class="red-text text-darken-4"><?php echo __('Error'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
            </header>
            <div class="divContentPanel z-depth-1 red darken-4">
                <div class="white-text">
                    <p id="pFormErrorText"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="divDialogContent divLoader" id="divLoader" style="display: none;">
    <div class="divContentWrapper level4">
        <div class="divDialogContentContainer">
            <div class="row">
                <div class="col s12 center-align">
                    <img src="assets/img/loader.svg" width="70" height="70" />
                </div>
            </div>
            <div class="row">
                <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text=""></div>
            </div>
        </div>
    </div>
</div>
<div class="divHiddenElements">
    <div id="divProfileHTMLDBWriter"></div>
    <div id="divPasswordHTMLDBWriter"></div>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/my_profile.js"></script>
</body>
</html>