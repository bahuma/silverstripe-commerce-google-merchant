<?php

class GoogleMerchantController extends Controller {
	private static $allowed_actions = [
		'index'
	];

	public function index(SS_HTTPRequest $request) {
		$categories = ShopCategory::get();

		$allItems = ArrayList::create();

		foreach ($categories as $category) {
			$allItems->merge($category->ValidItems());
		}

		$allItems->removeDuplicates();

		$output = "id	title	description	google product category	link	image link	condition	availability	price	shipping	identifier_exists	adult\n";

		foreach($allItems as $item) {
			$output .= $item->Sku;
			$output .= "\t";
			
			$output .= $item->Title;
			$output .= "\t";
			
			$output .= trim(str_replace("\t", '', str_replace("\r", '', str_replace("\n", '', strip_tags(str_replace('</p>', ' ', $item->Content))))));
			$output .= "\t";
			
			if ($item->ClassName == 'ShopItemVariation') {
				$output .= $item->Item()->Categories()->first()->GoogleProductCategory;
			} else {
				$output .= $item->Categories()->first()->GoogleProductCategory;
			}
			$output .= "\t";

			$output .= Director::absoluteBaseURL() . ltrim($item->Link(), '/');
			$output .= "\t"; 

			$output .= $item->SortedImages()->first()->FitMax(1200, 1200)->AbsoluteLink(); 
			$output .= "\t";

			$output .= 'new';
			$output .= "\t";

			$output .= 'in stock';
			$output .= "\t";

			$output .= $item->Price . ' EUR';
			$output .= "\t";

			$output .= ':::' . ShippingMethod::get()->byId(2)->WeightTiers()->min('PriceHomeland') . ' EUR';
			$output .= "\t";

			$output .= 'no';
			$output .= "\t";		

			$output .= 'no';
			
			$output .= "\n";
		}

		$response = new SS_HTTPResponse($output, 200);
		$response->addHeader("Content-Type", "text/plain; charset=\"utf-8\"");
		return $response;
	}
}