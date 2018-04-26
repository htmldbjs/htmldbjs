<div id="divCompanyDialog" class="divDialogContent divDialogActive">
    <div class="divContentWrapper level2" style="display: block; opacity: 1;">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 blue darken-4">
                <div class="divHeaderInfo">
                    <h3 class="blue-text text-darken-4"><?php echo __('Firma Ekle'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
                        data-container-dialog="divCompanyDialog"><i class="ion-android-close blue-text text-darken-4"></i>
                </button>
            </header>
            <div class="divContentPanel z-depth-1 white">
                <form id="formCompany" name="formCompany" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="row">
                            <div class="col s12">
                                <label for="name"><?php echo __('Firma'); ?></label>
                                <div class="input-field">
                                    <input id="name" name="name" type="text" value="" class="HTMLDBFieldValue" data-htmldb-field="company_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <div class="col s6">
                                <button type="button"
                                        class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"
                                        data-container-dialog="divCompanyDialog"><?php echo __('İPTAL'); ?>
                                </button>
                            </div>
                            <div class="col s6">
                                <button id="buttonSaveCompany" name="buttonSaveCompany" data-htmldb-row-id="0" data-htmldb-target="divCompanyHTMLDBWriter" data-htmldb-dialog="divCompanyDialog" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>