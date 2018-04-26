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
                                    <label for="consultant"><?php echo __('Danışman'); ?>  </label>
                                    <select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divConsultantHTMLDBReader" id="companyConsultant" style="width: 100%" name="companyConsultant" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="consultant">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
                                </div>
                                <div class="col s12">
                                    <p>
                                        <label class="checkbox2" for="companyPersonal">
                                        <input id="companyPersonal" name="companyPersonal" value="1" type="checkbox" data-htmldb-field="personal" data-htmldb-source="divCompanyHTMLDBReader" class="HTMLDBFieldValue">
                                        <span class="outer">
                                            <span class="inner"></span>
                                        </span>Bireysel</label>
                                    </p>
                                </div>
                                <div class="sh-element sh-companyPersonal-false">
                                    <div class="col s12"><h5 class="blue-text text-darken-4">Sponsor</h5></div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Ad'); ?></label>
                                        <div class="input-field">
                                            <input id="companySponsorFirstName" name="companySponsorFirstName" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_firstname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Soyad'); ?></label>
                                        <div class="input-field">
                                            <input id="companySponsorLastName" name="companySponsorLastName" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_lastname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('E-posta'); ?></label>
                                        <div class="input-field">
                                            <input id="companySponsorEmail" name="companySponsorEmail" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_email" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Şifre'); ?></label>
                                        <div class="input-field">
                                            <input id="companySponsorPassword" name="companySponsorPassword" type="password" data-htmldb-source="divCompanyHTMLDBReader" value="" data-htmldb-field="sponsor_password" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col s12"><h5 class="blue-text text-darken-4">Koordinatör</h5></div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Ad'); ?></label>
                                        <div class="input-field">
                                            <input id="companyCoordinatorFirstName" name="companyCoordinatorFirstName" type="text" data-htmldb-source="divCompanyHTMLDBReader" value="" data-htmldb-field="coordinator_firstname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Soyad'); ?></label>
                                        <div class="input-field">
                                            <input id="companyCoordinatorLastName" name="companyCoordinatorLastName" type="text" data-htmldb-source="divCompanyHTMLDBReader" value="" data-htmldb-field="coordinator_lastname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('E-posta'); ?></label>
                                        <div class="input-field">
                                            <input id="companyCoordinatorEmail" name="companyCoordinatorEmail" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="coordinator_email" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Şifre'); ?></label>
                                        <div class="input-field">
                                            <input id="companyCoordinatorPassword" name="companyCoordinatorPassword" type="password" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="coordinator_password" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col s12"><h5 class="blue-text text-darken-4">Yayılım Şampiyonu</h5></div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Ad'); ?></label>
                                        <div class="input-field">
                                            <input id="companyPropagationChampionFirstName" name="companyPropagationChampionFirstName" type="text" data-htmldb-source="divCompanyHTMLDBReader" value="" data-htmldb-field="propagation_champion_firstname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Soyad'); ?></label>
                                        <div class="input-field">
                                            <input id="companyPropagationChampionLastName" name="companyPropagationChampionLastName" type="text" data-htmldb-source="divCompanyHTMLDBReader" value="" data-htmldb-field="propagation_champion_lastname" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('E-posta'); ?></label>
                                        <div class="input-field">
                                            <input id="companyPropagationChampionEmail" name="companyPropagationChampionEmail" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="propagation_champion_email" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Şifre'); ?></label>
                                        <div class="input-field">
                                            <input id="companyPropagationChampionPassword" name="companyPropagationChampionPassword" type="password" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="propagation_champion_password" class="HTMLDBFieldValue">
                                        </div>
                                    </div>

                                    <div class="col s12"><h5 class="blue-text text-darken-4">Bölüm Temsilcileri</h5></div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('İSG Temsilcisi'); ?></label>
                                        <div class="input-field">
                                            <input id="companyHSEResponsible" name="companyHSEResponsible" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="hse_responsible" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('İK Temsilcisi'); ?></label>
                                        <div class="input-field">
                                            <input id="companyHRResponsible" name="companyHRResponsible" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="hr_responsible" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Planlama Temsilcisi'); ?></label>
                                        <div class="input-field">
                                            <input id="companyPlanningResponsible" name="companyPlanningResponsible" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="planning_responsible" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Bakım Temsilcisi'); ?></label>
                                        <div class="input-field">
                                            <input id="companyMaintenanceResponsible" name="companyMaintenanceResponsible" type="text" value="" data-htmldb-field="maintenance_responsible" data-htmldb-source="divCompanyHTMLDBReader" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <label for="name"><?php echo __('Kalite Temsilcisi'); ?></label>
                                        <div class="input-field">
                                            <input id="companyQualityResponsible" name="companyQualityResponsible" type="text" value="" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="quality_responsible" class="HTMLDBFieldValue">
                                        </div>
                                    </div>
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