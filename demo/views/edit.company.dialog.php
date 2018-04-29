<div id="divCompanyDialog" class="divDialogContent divDialogActive">
    <div class="divContentWrapper level0" style="display: block; opacity: 1;">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 blue darken-4">
                <div class="divHeaderInfo">
                    <h3 class="blue-text text-darken-4"><?php echo __('Firma Bilgileri'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
                        data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i>
                </button>
            </header>
            <div class="divContentPanel z-depth-1 white">
                <form id="formCompany" name="formCompany" method="post" class="form-horizontal">
                    <input type="hidden" name="companyId" id="companyId" value="" data-htmldb-source="divCompanyHTMLDBReader" class="HTMLDBFieldValue" data-htmldb-field="id">
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="col s12"><h5 class="blue-text text-darken-4">Genel Bilgiler</h5></div>
                                <div class="col s12">
                                    <label for="name"><?php echo __('Firma'); ?></label>
                                    <div class="input-field">
                                        <input id="companyName" name="companyName" type="text" value="" data-htmldb-field="company_name" data-htmldb-source="divCompanyHTMLDBReader" class="HTMLDBFieldValue">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="type"><?php echo __('Firma Türü'); ?> </label>
                                    <select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" id="type" style="width: 100%" name="type" data-htmldb-option-source="divCompanyTypeHTMLDBReader" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="type">>
                                        <option value=""><?php echo __('Lütfen Seçiniz'); ?></option>
                                    </select>
                                </div>
                                <div class="col s12" id="consultantContainer">
                                    <label for="consultant"><?php echo __('Danışman'); ?>  </label>
                                    <select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divConsultantHTMLDBReader" id="companyConsultant" style="width: 100%" name="companyConsultant" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="consultant">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <div class="col s6">
                                <button type="button"
                                        class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"><?php echo __('İPTAL'); ?>
                                </button>
                            </div>
                            <div class="col s6">
                                <button id="buttonSaveCompany" data-htmldb-row-id="" data-htmldb-target="divCompanyHTMLDBWriter" data-htmldb-dialog="divCompanyDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divCompanyHTMLDBReader" name="buttonSaveCompany" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	</div>