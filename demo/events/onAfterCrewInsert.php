<?php
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

function onAfterCrewInsert($sender) {
	includeModel('Company');
	includeModel('Unit');

	switch ($sender->type) {
		case 1:
			$Company = new Company($sender->company_id);
			$Company->sponsor_id = $sender->id;
			$Company->update();
			break;
		case 2:
			$Company = new Company($sender->company_id);
			$Company->coordinator_id = $sender->id;
			$Company->update();
			break;
		case 3:
			$Company = new Company($sender->company_id);
			$Company->hse_responsible_id = $sender->id;
			$Company->update();
			break;
		case 4:
			$Company = new Company($sender->company_id);
			$Company->hr_responsible_id = $sender->id;
			$Company->update();
			break;
		case 5:
			$Company = new Company($sender->company_id);
			$Company->planning_responsible_id = $sender->id;
			$Company->update();
			break;
		case 6:
			$Company = new Company($sender->company_id);
			$Company->maintenance_responsible_id = $sender->id;
			$Company->update();
			break;
		case 7:
			$Company = new Company($sender->company_id);
			$Company->quality_responsible_id = $sender->id;
			$Company->update();
			break;
		case 8:
			$Company = new Company($sender->company_id);
			$Company->propagation_champion_id = $sender->id;
			$Company->update();
			break;
		case 9:
			$Unit = new Unit($sender->unit_id);
			$Unit->process_owner_id = $sender->id;
			$Unit->update();
			break;
		case 10:
			$Unit = new Unit($sender->unit_id);
			$Unit->champion_id = $sender->id;
			$Unit->update();
			break;
		case 11:
			$Unit = new Unit($sender->unit_id);
			$Unit->advisor_id = $sender->id;
			$Unit->update();
			break;
		case 12:
			$Unit = new Unit($sender->unit_id);
			$Unit->leader1_id = $sender->id;
			$Unit->update();
			break;
		case 13:
			$Unit = new Unit($sender->unit_id);
			$Unit->leader2_id = $sender->id;
			$Unit->update();
			break;
		case 14:
			$Unit = new Unit($sender->unit_id);
			$Unit->leader3_id = $sender->id;
			$Unit->update();
			break;	
	}

	return;
}
?>