<div id="divCompanyDialog" class="divDialogContent divDialogActive htmldb-dialog-edit">
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
                <form id="formCompany" name="formCompany" method="post" class="form-horizontal htmldb-form" data-htmldb-table="companyHTMLDB">
                    <input type="hidden" class="htmldb-field" name="id" id="id" value="0" data-htmldb-field="id">
                    <div class="row">
                        <div class="col s12">
                            <label for="name"><?php echo __('Firma'); ?></label>
                            <div class="input-field">
                                <input id="name" name="name" type="text" value="" class="htmldb-field" data-htmldb-field="company_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="type"><?php echo __('Firma Türü'); ?> </label>
                            <select id="input2" class="htmldb-field" data-htmldb-field="type" data-htmldb-value="{{type}}" data-htmldb-option-table="companyTypesHTMLDB" data-htmldb-option-value="{{id}}" data-htmldb-option-title="{{column0}}">
                                <option value=""><?php echo __('Lütfen Seçiniz'); ?></option>
                            </select>
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
                                <button id="buttonSaveCompany" name="buttonSaveCompany" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12 htmldb-button-save" data-htmldb-form="formCompany"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>