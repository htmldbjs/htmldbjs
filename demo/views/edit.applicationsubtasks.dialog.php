<div id="divEditApplicationSubTasksDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Alt Adımlar'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<div class="row">
                	<div class="col s12">
                        <button id="buttonAddApplicationSubTask" name="buttonAddApplicationSubTask" class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divAddApplicationSubTaskDialog" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ ADIM</button>
                    </div>
                </div>
	            <div>
	                <table id="tableApplicationSubTaskList" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
	                    <thead>
	                        <tr>
	                            <th>
	                                <button type="button" class="buttonTableColumn buttonTableColumn1"
	                                data-column-index="1">
	                                Başlık&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
	                                    class="ion-arrow-down-b"></i></span><span
	                                    class="sorting sorting-asc blue-text text-darken-4"><i
	                                    class="ion-arrow-up-b"></i></span></button>
	                            </th>
	                            <th></th>
	                        </tr>
	                    </thead>
	                    <tbody id="tbodyApplicationSubTaskList"></tbody>
	                </table>
	            </div>
			</div>
		</div>
	</div>
</div>