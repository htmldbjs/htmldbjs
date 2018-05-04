<div id="divUnitDialog" class="divDialogContent divDialogActive htmldb-dialog-edit">
    <div class="divContentWrapper level2" style="display: block; opacity: 1;">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 blue darken-4">
                <div class="divHeaderInfo">
                    <h3 class="blue-text text-darken-4"><?php echo __('Alan Ekle'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
                        data-container-dialog="divCompanyDialog"><i class="ion-android-close blue-text text-darken-4"></i>
                </button>
            </header>
            <div class="divContentPanel z-depth-1 white">
                <form id="formUnit" name="formUnit" method="post" class="form-horizontal htmldb-form" data-htmldb-table="unitHTMLDB">
                    <input type="hidden" name="unitId" id="unitId" value="0" class="htmldb-field" data-htmldb-field="id">
                    <input type="hidden" name="unitCompany" id="unitCompany" value="" class="htmldb-field" data-htmldb-field="company_id" data-htmldb-reset-value="{{$URL.-1}}">
                    <div class="row">
                        <div class="row">
                            <div class="col s12">
                                <label for="name"><?php echo __('Alan'); ?></label>
                                <div class="input-field">
                                    <input id="name" name="name" type="text" value="" class="htmldb-field" data-htmldb-field="name" data-htmldb-value="{{name}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <div class="col s6">
                                <button type="button"
                                        class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"
                                        data-container-dialog="divUnitDialog"><?php echo __('İPTAL'); ?>
                                </button>
                            </div>
                            <div class="col s6">
                                <button id="buttonSaveUnit" name="buttonSaveUnit" type="button" data-htmldb-form="formUnit" class="htmldb-button-save waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('KAYDET'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	</div>