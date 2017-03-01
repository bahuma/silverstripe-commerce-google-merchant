<?php
class GoogleMerchantShopCategoryExtension extends DataExtension {
	private static $db = [
		'GoogleProductCategory' => 'Varchar(255)',
	];

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab('Root.Main', TextField::create('GoogleProductCategory', 'Google Product Category (ID)')->setDescription('Siehe: <a href="https://support.google.com/merchants/answer/6324436?visit_id=1-636239902530875486-2000212677&rd=1">https://support.google.com/merchants/answer/6324436?visit_id=1-636239902530875486-2000212677&rd=1</a>'));
	}
}