<div id="divCompanyDialog" class="divDialogContent divDialogActive htmldb-dialog-edit">
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
                <form id="formCompany" name="formCompany" method="post" class="form-horizontal htmldb-form" data-htmldb-table="companyHTMLDB">
                    <input type="hidden" name="companyId" id="companyId" value="" class="htmldb-field" data-htmldb-field="id" data-htmldb-value="{{id}}">
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="col s12"><h5 class="blue-text text-darken-4">Genel Bilgiler</h5></div>
                                <div class="col s12">
                                    <label for="name"><?php echo __('Firma'); ?></label>
                                    <div class="input-field">
                                        <input id="companyName" name="companyName" type="text" value="" data-htmldb-field="company_name" class="htmldb-field" data-htmldb-value="{{company_name}}">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="type"><?php echo __('Firma Türü'); ?> </label>
                                    <select class="selectClassSelection htmldb-field" id="type" style="width: 100%" name="type" data-htmldb-option-table="companyTypeHTMLDB" data-htmldb-option-title="{{column0}}" data-htmldb-option-value="{{id}}" data-htmldb-field="type" data-htmldb-value="{{type}}">
                                        <option value=""><?php echo __('Lütfen Seçiniz'); ?></option>
                                    </select>
                                </div>
                                <div class="col s12 htmldb-toggle" data-htmldb-filter="type/eq/1" id="consultantContainer">
                                    <label for="consultant"><?php echo __('Danışman'); ?>  </label>
                                    <select class="selectClassSelection htmldb-field" data-htmldb-option-table="consultantHTMLDB" id="companyConsultant" style="width: 100%" name="companyConsultant"  data-htmldb-field="consultant" data-htmldb-value="{{consultant}}" data-htmldb-option-title="{{column0}}" data-htmldb-option-value="{{id}}">
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
                                <button id="buttonSaveCompany" data-htmldb-form="formCompany" name="buttonSaveCompany" type="button" class="htmldb-button-save waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	</div>