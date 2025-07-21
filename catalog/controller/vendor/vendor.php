<?php
class ControllerVendorVendor extends Controller
{
	private $error = array();

	public function index()
	{

		if ($this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('vendor/success', '', true));
		}

		$this->load->language('vendor/vendor');

		$this->document->setTitle($this->language->get('heading_title'));


		$this->load->model('vendor/vendor');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// var_dump($this->request->post);
			
			// code to save the self regitered for vendor if registered self
			$data = $this->request->post;
			$data['registered_by'] = 'Self Registered';
			
			$this->model_vendor_vendor->addVendor($data);
			$this->vendor->login($this->request->post['email'], $this->request->post['password']);
			$this->response->redirect($this->url->link('vendor/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('vendor/dashboard', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('vendor/vendor', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('vendor/login', '', true));
		$data['text_yes'] 			= $this->language->get('text_yes');
		$data['text_no'] 			= $this->language->get('text_no');
		$data['text_select'] 		= $this->language->get('text_select');
		$data['text_none'] 			= $this->language->get('text_none');
		$data['text_loading'] 		= $this->language->get('text_loading');
		$data['entry_firstname'] 	= $this->language->get('entry_firstname');
		$data['entry_lastname'] 	= $this->language->get('entry_lastname');
		$data['entry_telephone'] 	= $this->language->get('entry_telephone');
		$data['entry_gstin'] 			= $this->language->get('entry_gstin');
		$data['entry_company'] 		= $this->language->get('entry_company');
		$data['entry_address_1'] 	= $this->language->get('entry_address_1');
		$data['entry_address_2'] 	= $this->language->get('entry_address_2');

		$data['entry_newsletter'] 	= $this->language->get('entry_newsletter');
		$data['entry_password'] 	= $this->language->get('entry_password');
		$data['entry_confirm'] 		= $this->language->get('entry_confirm');
		$data['entry_about'] 		= $this->language->get('entry_about');
		$data['entry_image'] 		= $this->language->get('entry_image');
		$data['entry_display_name'] = $this->language->get('entry_display_name');
		$data['entry_bankname']  		= $this->language->get('entry_bankname');
		$data['entry_bnumber']  		= $this->language->get('entry_bnumber');
		$data['entry_swiftcode']  		= $this->language->get('entry_swiftcode');
		$data['entry_aname']  			= $this->language->get('entry_aname');
		$data['entry_anumber']  		= $this->language->get('entry_anumber');
		$data['entry_Emailid']  		= $this->language->get('entry_Emailid');
		$data['entry_method']  			= $this->language->get('entry_method');
		$data['text_bank']  			= $this->language->get('text_bank');
		$data['text_paypal']  			= $this->language->get('text_paypal');

		$data['entry_storename'] 		= $this->language->get('entry_storename');
		$data['entry_description'] 		= $this->language->get('entry_description');
		$data['entry_shippingpolicy'] 	= $this->language->get('entry_shippingpolicy');
		$data['entry_returnpolicy'] 	= $this->language->get('entry_returnpolicy');
		$data['entry_metakeyword'] 		= $this->language->get('entry_metakeyword');
		$data['entry_metadescription'] 	= $this->language->get('entry_metadescription');
		$data['entry_email'] 			= $this->language->get('entry_email');
		$data['entry_phone'] 			= $this->language->get('entry_phone');
		$data['entry_address'] 			= $this->language->get('entry_address');
		$data['entry_country'] 			= $this->language->get('entry_country');
		$data['entry_zone'] 			= $this->language->get('entry_zone');
		$data['entry_city'] 			= $this->language->get('entry_city');
		$data['entry_postcode'] 		= $this->language->get('entry_postcode');
		$data['entry_detail'] 			= $this->language->get('entry_detail');
		$data['entry_tax'] 				= $this->language->get('entry_tax');
		$data['entry_charges'] 			= $this->language->get('entry_charges');
		$data['entry_url'] 				= $this->language->get('entry_url');
		$data['entry_logo'] 			= $this->language->get('entry_logo');
		$data['entry_banner'] 			= $this->language->get('entry_banner');
		$data['entry_store_about'] 		= $this->language->get('entry_store_about');
		$data['entry_mapurl'] 		    = $this->language->get('entry_mapurl');
		$data['button_upload'] 			= $this->language->get('button_upload');
		$data['button_banner'] 			= $this->language->get('button_banner');
		$data['button_add'] 			= $this->language->get('button_add');
		$data['tab_general'] 			= $this->language->get('tab_general');
		$data['tab_data'] 			    = $this->language->get('tab_data');

		$data['tab_seller'] 		    = $this->language->get('tab_seller');
		$data['tab_generalstore'] 		= $this->language->get('tab_generalstore');
		$data['tab_datastore'] 			= $this->language->get('tab_datastore');
		$data['tab_payment'] 			= $this->language->get('tab_payment');

		$data['help_product'] = $this->language->get('help_product');

		$data['button_continue'] 	= $this->language->get('button_continue');
		$data['button_upload'] 		= $this->language->get('button_upload');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['filedwarning'])) {
			$data['filedwarning'] = $this->error['filedwarning'];
		} else {
			$data['filedwarning'] = '';
		}


		if (isset($this->error['display_name'])) {
			$data['error_display_name'] = $this->error['display_name'];
		} else {
			$data['error_display_name'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['fax'])) {
			$data['error_fax'] = $this->error['fax'];
		} else {
			$data['error_fax'] = '';
		}
		if (isset($this->request->post['uin'])) {
			$data['uin'] = $this->request->post['uin'];
		} else {
			$data['uin'] = '';
		}
		if (isset($this->error['company'])) {
			$data['error_company'] = $this->error['company'];
		} else {
			$data['error_company'] = '';
		}

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['address_2'])) {
			$data['error_address_2'] = $this->error['address_2'];
		} else {
			$data['error_address_2'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}


		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		if (isset($this->error['about'])) {
			$data['error_about'] = $this->error['about'];
		} else {
			$data['error_about'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['meta_description'])) {
			$data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$data['error_meta_description'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		if (isset($this->error['shipping_policy'])) {
			$data['error_shipping_policy'] = $this->error['shipping_policy'];
		} else {
			$data['error_shipping_policy'] = '';
		}

		if (isset($this->error['return_policy'])) {
			$data['error_return_policy'] = $this->error['return_policy'];
		} else {
			$data['error_return_policy'] = '';
		}

		if (isset($this->error['meta_keyword'])) {
			$data['error_meta_keyword'] = $this->error['meta_keyword'];
		} else {
			$data['error_meta_keyword'] = '';
		}

		if (isset($this->error['bank_detail'])) {
			$data['error_bank_detail'] = $this->error['bank_detail'];
		} else {
			$data['error_bank_detail'] = '';
		}

		if (isset($this->error['store_about'])) {
			$data['error_store_about'] = $this->error['store_about'];
		} else {
			$data['error_store_about'] = '';
		}

		if (isset($this->error['map_url'])) {
			$data['error_map_url'] = $this->error['map_url'];
		} else {
			$data['error_map_url'] = '';
		}

		if (isset($this->error['tax_number'])) {
			$data['error_tax_number'] = $this->error['tax_number'];
		} else {
			$data['error_tax_number'] = '';
		}

		if (isset($this->error['shipping_charge'])) {
			$data['error_shipping_charge'] = $this->error['shipping_charge'];
		} else {
			$data['error_shipping_charge'] = '';
		}

		if (isset($this->error['paypal'])) {
			$data['error_paypal'] = $this->error['paypal'];
		} else {
			$data['error_paypal'] = '';
		}

		if (isset($this->error['bank_account_name'])) {
			$data['error_bank_account_name'] = $this->error['bank_account_name'];
		} else {
			$data['error_bank_account_name'] = '';
		}

		if (isset($this->error['bank_account_number'])) {
			$data['error_bank_account_number'] = $this->error['bank_account_number'];
		} else {
			$data['error_bank_account_number'] = '';
		}
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}



		// if (isset($this->request->get['pincode']) && !empty($this->request->get['pincode'])) {
		// 	$pincode = $this->request->get['pincode'];
		// 	$api_url = "http://www.postalpincode.in/api/pincode/" . $pincode;

		// 	// Use cURL to fetch data from API (Recommended over file_get_contents)
		// 	$ch = curl_init();
		// 	curl_setopt($ch, CURLOPT_URL, $api_url);
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// 	$response = curl_exec($ch);
		// 	curl_close($ch);

		// 	// Convert JSON response to PHP array
		// 	$pincode_data = json_decode($response, true);

		// 	// Check if API returned valid data
		// 	if ($pincode_data['Status'] === "Success" && isset($pincode_data['PostOffice'][0])) {
		// 		$postOffice = $pincode_data['PostOffice'][0];

		// 		// Prepare response array
		// 		$result = [
		// 			'city' => $postOffice['District'],   // City
		// 			'zone' => $postOffice['State'],      // State
		// 			'country' => 'India'                 // Country (Fixed)
		// 		];
		// 	} else {
		// 		$result = [
		// 			'city' => 'Invalid Pincode',
		// 			'zone' => '',
		// 			'country' => ''
		// 		];
		// 	}

		// 	// Send JSON response
		// 	header('Content-Type: application/json');
		// 	echo json_encode($result);
		// 	exit();
		// }


		/*advance settings*/
		$data['required_displayname'] 	= $this->config->get('vendor_required_displayname');
		$data['required_lastname'] 		= $this->config->get('vendor_required_lastname');
		$data['required_telephone'] 	= $this->config->get('vendor_required_telephone');
		$data['required_fax'] 		    = $this->config->get('vendor_required_fax');
		$data['required_company'] 		= $this->config->get('vendor_required_company');
		$data['required_address_1'] 	= $this->config->get('vendor_required_address_1');
		$data['required_address_2'] 	= $this->config->get('vendor_required_address_2');
		$data['required_city'] 			= $this->config->get('vendor_required_city');
		$data['required_country'] 		= $this->config->get('vendor_required_country');
		$data['required_zone'] 			= $this->config->get('vendor_required_zone');
		$data['required_about'] 		= $this->config->get('vendor_required_about');
		$data['chkpostcode'] 			=  $this->config->get('vendor_vpostcode');

		$data['required_metadesc'] 		= $this->config->get('vendor_required_meta_description');
		$data['required_description'] 	= $this->config->get('vendor_required_description');
		$data['required_shipping_policy'] 		= $this->config->get('vendor_required_shipping_policy');
		$data['required_return_policy'] 		= $this->config->get('vendor_required_return_policy');
		$data['required_meta_keyword'] 		= $this->config->get('vendor_required_meta_keyword');

		$data['required_bank_detail'] 	= $this->config->get('vendor_required_bank_detail');
		$data['required_storeabout'] 	= $this->config->get('vendor_required_storeabout');
		$data['required_mapurl'] 		= $this->config->get('vendor_required_mapurl');
		$data['required_tax_number'] 	= $this->config->get('vendor_required_tax_number');
		$data['required_shipping'] 		= $this->config->get('vendor_required_shipping_charge');
		$data['required_url'] 		    = $this->config->get('vendor_required_url');


		$data['status_displayname']		= $this->config->get('vendor_status_displayname');
		$data['status_lastname']		= $this->config->get('vendor_status_lastname');
		$data['status_telephone']		= $this->config->get('vendor_status_telephone');
		$data['status_fax']				= $this->config->get('vendor_status_fax');
		$data['status_company']			= $this->config->get('vendor_status_company');
		$data['status_address_1']		= $this->config->get('vendor_status_address_1');
		$data['status_address_2']		= $this->config->get('vendor_status_address_2');
		$data['status_city']			= $this->config->get('vendor_status_city');
		$data['status_country']			= $this->config->get('vendor_status_country');
		$data['status_zone']			= $this->config->get('vendor_status_zone');
		$data['status_postcode']		= $this->config->get('vendor_status_postcode');
		$data['status_about']			= $this->config->get('vendor_status_about');
		$data['status_image']			= $this->config->get('vendor_status_image');

		$data['status_metadesc']		= $this->config->get('vendor_status_meta_description');
		$data['status_description']		= $this->config->get('vendor_status_description');
		$data['status_shipping_policy']	= $this->config->get('vendor_status_shipping_policy');
		$data['status_return_policy']	= $this->config->get('vendor_status_return_policy');
		$data['status_meta_keyword']	= $this->config->get('vendor_status_meta_keyword');

		$data['status_bank_detail']		= $this->config->get('vendor_status_bank_detail');
		$data['status_storeabout']		= $this->config->get('vendor_status_storeabout');
		$data['status_mapurl']			= $this->config->get('vendor_status_mapurl');
		$data['status_tax_number']		= $this->config->get('vendor_status_tax_number');
		$data['status_shipping_charge']	= $this->config->get('vendor_status_shipping_charge');
		$data['status_url']				= $this->config->get('vendor_status_url');
		$data['status_logo']			= $this->config->get('vendor_status_logo');
		$data['status_banner']			= $this->config->get('vendor_status_banner');
		$data['status_paypal']			= $this->config->get('vendor_status_paypal');
		$data['status_bank']		    = $this->config->get('vendor_status_bank');
		/*advance settings*/

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}
		
		if (isset($this->request->post['pan'])) {
			$data['pan'] = $this->request->post['pan'];
		} else {
			$data['pan'] ='';
		}

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		if (isset($this->request->post['paypal'])) {
			$data['paypal'] = $this->request->post['paypal'];
		} else {
			$data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
			$data['bank_name'] = $this->request->post['bank_name'];
		} else {
			$data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
			$data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} else {
			$data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
			$data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} else {
			$data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
			$data['bank_account_name'] = $this->request->post['bank_account_name'];
		} else {
			$data['bank_account_name'] = '';
		}

		if (isset($this->request->post['bank_account_number'])) {
			$data['bank_account_number'] = $this->request->post['bank_account_number'];
		} else {
			$data['bank_account_number'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}



		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($store_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		//// Seller Store///

		if (isset($this->request->post['bank_detail'])) {
			$data['bank_detail'] = $this->request->post['bank_detail'];
		} else {
			$data['bank_detail'] = '';
		}

		if (isset($this->request->post['store_about'])) {
			$data['store_about'] = $this->request->post['store_about'];
		} else {
			$data['store_about'] = '';
		}

		if (isset($this->request->post['tax_number'])) {
			$data['tax_number'] = $this->request->post['tax_number'];
		} else {
			$data['tax_number'] = '';
		}

		if (isset($this->request->post['shipping_charge'])) {
			$data['shipping_charge'] = $this->request->post['shipping_charge'];
		} else {
			$data['shipping_charge'] = '';
		}
		/* 05 02 2021 replace keyword*/
		if (isset($this->request->post['vendor_seo_url'])) {
			$data['vendor_seo_url'] = $this->request->post['vendor_seo_url'];
		} else {
			$data['vendor_seo_url'] = array();
		}

		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		/* 05 02 2021 */
		if (isset($this->request->post['map_url'])) {
			$data['map_url'] = $this->request->post['map_url'];
		} else {
			$data['map_url'] = '';
		}
		if (isset($this->request->post['about'])) {
			$data['about'] = $this->request->post['about'];
		} else {
			$data['about'] = '';
		}


		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} else {
			$data['image'] = '';
		}

		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} else {
			$data['logo'] = '';
		}

		if (isset($this->request->post['store_description'])) {
			$data['store_description'] = $this->request->post['store_description'];
		} else {
			$data['store_description'] = array();
		}

		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} else {
			$data['banner'] = '';
		}

		$this->load->model('tool/image');
		if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($store_info['logo'], 100, 100);
		} else {
			$data['thumb_logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($store_info['banner'], 100, 100);
		} else {
			$data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		/* 10 04 2020 */
		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}
		
		$data['password'] = isset($vendor_info['password']) ? $vendor_info['password'] : '';

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$data['vendor_vprivacy'] = $this->config->get('vendor_vprivacy_id');

		$this->load->model('catalog/information');
		$information_info = $this->model_catalog_information->getInformation($this->config->get('vendor_vprivacy_id'));
		if ($information_info) {
			$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('vendor_vprivacy_id'), true), $information_info['title'], $information_info['title']);
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}
		/* 10 04 2020 */


		$data['column_left'] 	= $this->load->controller('vendor/column_left');
		$data['column_right'] 	= $this->load->controller('common/column_right');
		$data['content_top'] 	= $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] 		= $this->load->controller('common/footer');
		$data['header'] 		= $this->load->controller('common/header');


    
//     $data['banner_images'] = [
//     [
        
//         'src' => $this->model_tool_image->resize('catalog/banners/seller_registration/A.jpg', 320, 520),
//         'title' => 'mixer'
//     ],
//     [
        
//         'src' => $this->model_tool_image->resize('catalog/banners/seller_registration/01.jpg', 320, 520),
        
//     ],
   
// ];
$data['banner_images'] = [
    'tab-user' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/01.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/A.jpg', 320, 520)
    ],
    'tab-address' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/02.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/B.jpg', 320, 520)
    ],
    'tab-login' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/03.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/C.jpg', 320, 520)
    ],
    'tab-company' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/04.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/D.jpg', 320, 520)
    ],
    'tab-business' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/05.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/E.jpg', 320, 520)
    ],
    'tab-bank' => [
        'left' => $this->model_tool_image->resize('catalog/banners/seller_registration/05.jpg', 320, 520),
        'right' => $this->model_tool_image->resize('catalog/banners/seller_registration/E.jpg', 320, 520)
    ],
];
$data['registration_video']= $this->load->controller('common/video_popup', ['video_url' => 'https://www.youtube.com/embed/Sn0fUwBwhBs']);

		$this->response->setOutput($this->load->view('vendor/vendor', $data));
	}

	private function validate()
	{

		$displayname =  $this->config->get('vendor_required_displayname');
		$displaynamestatus =  $this->config->get('vendor_status_displayname');
		if ($displaynamestatus == 1) {
			if ($displayname == 1) {
				if ((utf8_strlen(trim($this->request->post['display_name'])) < 3) || (utf8_strlen(trim($this->request->post['display_name'])) > 32)) {
					$this->error['display_name'] = $this->language->get('error_display_name');
				}
			}
		}

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 2) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

// 		$lastnamestatus =  $this->config->get('vendor_status_lastname');
// 		$lastname =  $this->config->get('vendor_required_lastname');
// 		if ($lastnamestatus == 1) {
// 			if ($lastname == 1) {
// 				if ((utf8_strlen(trim($this->request->post['lastname'])) < 3) || (utf8_strlen(trim($this->request->post['lastname'])) > 12)) {
// 					$this->error['lastname'] = $this->language->get('error_lastname');
// 				}
// 			}
// 		}

		$email_info = $this->model_vendor_vendor->getVendorByEmail($this->request->post['email']);

		if (!isset($this->request->get['vendor_id'])) {
			if ($email_info) {
				$this->error['warning'] = $this->language->get('error_email_match');
			}
		} else {
			if ($email_info && ($this->request->get['vendor_id'] != $email_info['vendor_id'])) {
				$this->error['warning'] = $this->language->get('error_email_match');
			}
		}

// 		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
// 			$this->error['email'] = $this->language->get('error_email');
// 		}

        $telephone_info = $this->model_vendor_vendor->getVendorByTelephone($this->request->post['telephone']);

		if (!isset($this->request->get['vendor_id'])) {
			if ($telephone_info) {
				$this->error['warning'] = $this->language->get('error_telephone_match');
			}
		} else {
			if ($telephone_info && ($this->request->get['vendor_id'] != $telephone_info['vendor_id'])) {
				$this->error['warning'] = $this->language->get('error_telephone_match');
			}
		}

		$telephonestatus =  $this->config->get('vendor_status_telephone');
		$telephone =  $this->config->get('vendor_required_telephone');
		if ($telephonestatus == 1) {
			if ($telephone == 1) {
				if ((utf8_strlen($this->request->post['telephone']) < 10) || (utf8_strlen($this->request->post['telephone']) > 10)) {
					$this->error['telephone'] = $this->language->get('error_telephone');
				}
			}
		}

		$faxstatus =  $this->config->get('vendor_status_fax');
		$fax =  $this->config->get('vendor_required_fax');
		// if ($faxstatus == 1) {
		// 	if ($fax == 1) {
		// 		$gst_number = strtoupper($this->request->post['fax']);
		// 		if ((utf8_strlen($this->request->post['fax']) != 15)) {
		// 			$this->error['fax'] = $this->language->get('error_gstin');
		// 		}
		// 	}
		// }
		
// 		$gstin_info = $this->model_vendor_vendor->getVendorBygstin($this->request->post['fax']);

// 		if (!isset($this->request->get['vendor_id'])) {
// 			if ($gstin_info) {
// 				$this->error['warning'] = $this->language->get('error_gstin_match');
// 			}
// 		} else {
// 			if ($gstin_info && ($this->request->get['vendor_id'] != $gstin_info['vendor_id'])) {
// 				$this->error['warning'] = $this->language->get('error_gstin_match');
// 			}
// 		}

        if (isset($this->request->post['fax']) && !empty($this->request->post['fax'])) {
		
    		$gstin_info = $this->model_vendor_vendor->getVendorBygstin($this->request->post['fax']);
    
    		if (!isset($this->request->get['vendor_id'])) {
    			if ($gstin_info) {
    				$this->error['warning'] = $this->language->get('error_gstin_match');
    			}
    		} else {
    			if ($gstin_info && ($this->request->get['vendor_id'] != $gstin_info['vendor_id'])) {
    				$this->error['warning'] = $this->language->get('error_gstin_match');
    			}
    		}
		}

		$company =  $this->config->get('vendor_required_company');
		$companystatus =  $this->config->get('vendor_status_company');
		if ($companystatus == 1) {
			if ($company == 1) {
				if ((utf8_strlen($this->request->post['company']) > 255)) {
					$this->error['company'] = $this->language->get('error_company');
				}
			}
		}

// 		$address_1status =  $this->config->get('vendor_status_address_1');
// 		$address_1 =  $this->config->get('vendor_required_address_1');
// 		if ($address_1status == 1) {
// 			if ($address_1 == 1) {
// 				if ((utf8_strlen(trim($this->request->post['address_1'])) < 10) || (utf8_strlen(trim($this->request->post['address_1'])) > 40)) {
// 					$this->error['address_1'] = $this->language->get('error_address_1');
// 				}
// 			}
// 		}

// 		$address_2status =  $this->config->get('vendor_status_address_2');
// 		$address_2 =  $this->config->get('vendor_required_address_2');
// 		if ($address_2status == 1) {
// 			if ($address_2 == 1) {
// 				if ((utf8_strlen(trim($this->request->post['address_2'])) > 50)) {
// 					$this->error['address_2'] = $this->language->get('error_address_2');
// 				}
// 			}
// 		}

// 		$citystatus =  $this->config->get('vendor_status_city');
// 		$city =  $this->config->get('vendor_required_city');
// 		if ($citystatus == 1) {
// 			if ($city == 1) {
// 				if ((utf8_strlen(trim($this->request->post['city'])) < 3) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
// 					$this->error['city'] = $this->language->get('error_city');
// 				}
// 			}
// 		}

		$this->load->model('localisation/country');
		if (isset($this->request->post['country_id'])) {
			$country_id = $this->request->post['country_id'];
		} else {
			$country_id = '';
		}
		$country_info = $this->model_localisation_country->getCountry($country_id);


		// if ($this->request->post['country_id'] == '') {
		// 	$this->error['country'] = $this->language->get('error_country');
		// }

		$zonestatus =  $this->config->get('vendor_status_zone');
		$zone =  $this->config->get('vendor_required_zone');
		// if ($zonestatus == 1) {
		// 	if ($zone == 1) {
		// 		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
		// 			$this->error['zone'] = $this->language->get('error_zone');
		// 		}
		// 	}
		// }


		if ((utf8_strlen($this->request->post['password']) < 8) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

		$aboutstatus =  $this->config->get('vendor_status_about');
		$about =  $this->config->get('vendor_required_about');
		// if ($aboutstatus == 1) {
		// 	if ($about == 1) {
		// 		if ((utf8_strlen(trim($this->request->post['about'])) < 2) || (utf8_strlen(trim($this->request->post['about'])) > 1000)) {
		// 			$this->error['about'] = $this->language->get('error_about');
		// 		}
		// 	}
		// }


		foreach ($this->request->post['store_description'] as $language_id => $value) {

			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			$meta_description =  $this->config->get('vendor_required_meta_description');
			$meta_descriptionstatus =  $this->config->get('vendor_status_meta_description');
			// if ($meta_descriptionstatus == 1) {
			// 	if ($meta_description == 1) {
			// 		if ((utf8_strlen($value['meta_description']) < 3) || (utf8_strlen($value['meta_description']) > 500)) {
			// 			$this->error['meta_description'][$language_id] = $this->language->get('error_meta_description');
			// 		}
			// 	}
			// }

			$description =  $this->config->get('vendor_required_description');
			$descriptionstatus =  $this->config->get('vendor_status_description');
			// if ($descriptionstatus == 1) {
			// 	if ($description == 1) {
			// 		if ((utf8_strlen($value['description']) < 3) || (utf8_strlen($value['description']) > 500)) {
			// 			$this->error['description'][$language_id] = $this->language->get('error_description');
			// 		}
			// 	}
			// }

			$shipping_policy =  $this->config->get('vendor_required_shipping_policy');
			$shipping_policystatus =  $this->config->get('vendor_status_shipping_policy');
			// if ($shipping_policystatus == 1) {
			// 	if ($shipping_policy == 1) {
			// 		if ((utf8_strlen($value['shipping_policy']) < 3) || (utf8_strlen($value['shipping_policy']) > 500)) {
			// 			$this->error['shipping_policy'][$language_id] = $this->language->get('error_shipping_policy');
			// 		}
			// 	}
			// }

			$return_policystatus =  $this->config->get('vendor_status_return_policy');
			$return_policy =  $this->config->get('vendor_required_return_policy');
			// if ($return_policystatus == 1) {
			// 	if ($return_policy == 1) {
			// 		if ((utf8_strlen($value['return_policy']) < 3) || (utf8_strlen($value['return_policy']) > 500)) {
			// 			$this->error['return_policy'][$language_id] = $this->language->get('error_return_policy');
			// 		}
			// 	}
			// }

			$meta_keyword =  $this->config->get('vendor_required_meta_keyword');
			$meta_keywordstatus =  $this->config->get('vendor_status_meta_keyword');
			// if ($meta_keywordstatus == 1) {
			// 	if ($meta_keyword == 1) {
			// 		if ((utf8_strlen($value['meta_keyword']) < 3) || (utf8_strlen($value['meta_keyword']) > 500)) {
			// 			$this->error['meta_keyword'][$language_id] = $this->language->get('error_meta_keyword');
			// 		}
			// 	}
			// }
		}

		$bank_detail =  $this->config->get('vendor_required_bank_detail');
		$bank_detailstatus =  $this->config->get('vendor_status_bank_detail');
		if ($bank_detailstatus == 1) {
			if ($bank_detail == 1) {
				if ((utf8_strlen(trim($this->request->post['bank_detail'])) < 2) || (utf8_strlen(trim($this->request->post['bank_detail'])) > 1000)) {
					$this->error['bank_detail'] = $this->language->get('error_bank_detail');
				}
			}
		}

		$storeabout =  $this->config->get('vendor_required_storeabout');
		$storeaboutstatus =  $this->config->get('vendor_status_storeabout');
		// if ($storeaboutstatus == 1) {
		// 	if ($storeabout == 1) {
		// 		if ((utf8_strlen(trim($this->request->post['store_about'])) < 2) || (utf8_strlen(trim($this->request->post['store_about'])) > 1000)) {
		// 			$this->error['store_about'] = $this->language->get('error_store_about');
		// 		}
		// 	}
		// }

		$map_url =  $this->config->get('vendor_required_mapurl');
		$map_urlstatus =  $this->config->get('vendor_status_mapurl');
		// if ($map_urlstatus == 1) {
		// 	if ($map_url == 1) {
		// 		if ((utf8_strlen(trim($this->request->post['map_url'])) < 2) || (utf8_strlen(trim($this->request->post['map_url'])) > 1000)) {
		// 			$this->error['map_url'] = $this->language->get('error_map_url');
		// 		}
		// 	}
		// }


		$tax_number =  $this->config->get('vendor_required_tax_number');
		$tax_numberstatus =  $this->config->get('vendor_status_tax_number');
		// if ($tax_numberstatus == 1) {
		// 	if ($tax_number == 1) {
		// 		if ((utf8_strlen(trim($this->request->post['tax_number'])) < 2) || (utf8_strlen(trim($this->request->post['tax_number'])) > 128)) {
		// 			$this->error['tax_number'] = $this->language->get('error_tax_number');
		// 		}
		// 	}
		// }

		$shipping_charge =  $this->config->get('vendor_required_shipping_charge');
		$shipping_chargestatus =  $this->config->get('vendor_status_shipping_charge');
		// if ($shipping_chargestatus == 1) {
		// 	if ($shipping_charge == 1) {
		// 		if ((utf8_strlen(trim($this->request->post['tax_number'])) < 2) || (utf8_strlen(trim($this->request->post['shipping_charge'])) > 128)) {
		// 			$this->error['shipping_charge'] = $this->language->get('error_shipping_charge');
		// 		}
		// 	}
		// }


		$statuspaypal = $this->config->get('vendor_status_paypal');
		// if ($statuspaypal == 1) {
		// 	if ($this->request->post['payment_method'] == 'paypal') {
		// 		if ($this->request->post['paypal'] == '') {
		// 			$this->error['paypal'] = $this->language->get('error_paypal');
		// 		}
		// 	} elseif ($this->request->post['payment_method'] == 'banktransfer') {
		// 		if ($this->request->post['bank_account_name'] == '') {
		// 			$this->error['bank_account_name'] = $this->language->get('error_bank_account_name');
		// 		}

		// 		if ($this->request->post['bank_account_number'] == '') {
		// 			$this->error['bank_account_number'] = $this->language->get('error_bank_account_number');
		// 		}
		// 	}
		// }

		$chkpostcode =  $this->config->get('vendor_vpostcode');
		$chkpostcodestatus =  $this->config->get('vendor_status_postcode');
		if ($chkpostcodestatus == 1) {
			if ($chkpostcode == 1) {
				if (empty($this->request->post['postcode'])) {
					$this->error['postcode'] = $this->language->get('error_postcode');
				}
			}
		}
		/* 24 03 2020 */
		if ($this->error) {
// 			var_dump($this->error);
			$this->error['filedwarning'] =  $this->language->get('error_filedwarning');
		}
		/* 24 03 2020 */

		/* 10 04 2020 */

		$vendor_vprivacy = $this->config->get('vendor_vprivacy_id');
		if ($vendor_vprivacy != 0) {
			if ($this->config->get('vendor_vprivacy_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('vendor_vprivacy_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
		}
		/* 10 04 2020 */

		/* 05 02 2021 */
		$vendorstatusurl = $this->config->get('vendor_status_url');
		$vendorrequiredurl = $this->config->get('vendor_required_url');
		if ($vendorstatusurl == 1) {
			if ($vendorrequiredurl == 1) {
				if ($this->request->post['vendor_seo_url']) {

					$this->load->model('vendor/seo_url');

					foreach ($this->request->post['vendor_seo_url'] as $store_id => $language) {
						foreach ($language as $language_id => $keyword) {
							if (!empty($keyword)) {
								if (count(array_keys($language, $keyword)) > 1) {
									$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
								}

								$seo_urls = $this->model_vendor_seo_url->getSeoUrlsByKeyword($keyword);

								foreach ($seo_urls as $seo_url) {
									if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['vendor_id']) || (($seo_url['query'] != 'vendor_id=' . $this->request->get['vendor_id'])))) {
										$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
									}
								}
							}
							if (empty($keyword)) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_srequired');
							}
						}
					}
				}
			}
		}

		/* 05 02 2021 */

		return !$this->error;
	}

	public function autocomplete()
	{

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'firstname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$this->load->model('vendor/vendor');

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			//'filter_name' => $filter_name,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$results = $this->model_vendor_vendor->getVendors($filter_data);

		foreach ($results as $result) {

			$json[] = array(
				'vendor_id'  => $result['vendor_id'],
				'firstname'   => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
			);
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function upload()
	{
		$this->load->language('tool/upload');
		$json = array();
		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}
			// Allowed file extension types
			$allowed = array();
			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
			$filetypes = explode("\n", $extension_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Allowed file mime types
			$allowed = array();
			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
			$filetypes = explode("\n", $mime_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);
			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		$this->load->model('tool/image');
		if (!$json) {
			$targetDir = DIR_IMAGE . 'catalog/multivendor/' . $this->vendor->getId() . '/';
			$file = $filename;
			$location = $targetDir . $file;
			$location1 = 'catalog/multivendor/' . $this->vendor->getId() . '/' . $file;
			$location2 = 'catalog/multivendor/' . $this->vendor->getId() . '/' . $file;
			move_uploaded_file($this->request->files['file']['tmp_name'], $location);
			$json['filename'] = $filename;
			$json['location1'] = $location1;
			$json['location2'] = $this->model_tool_image->resize($location1, 150, 150);
			$json['success'] = $this->language->get('text_upload');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function fetchInfo() {
        $this->response->addHeader('Content-Type: application/json');
        $pincode = $this->request->get['pincode'] ?? '';
    
        if (strlen($pincode) !== 6) {
            $this->response->setOutput(json_encode([
                'success' => false,
                'message' => 'Invalid Pincode Format'
            ]));
            return;
        }
    
        // Use fallback DB
        $query = $this->db->query("SELECT city, state FROM " . DB_PREFIX . "city_pincode WHERE pincode = '" . $this->db->escape($pincode) . "' LIMIT 1");
    
        if ($query->num_rows) {
            $this->response->setOutput(json_encode([
                'success' => true,
                'city'    => $query->row['city'],
                'state'   => $query->row['state'],
                'source'  => 'database'
            ]));
        } else {
            $this->response->setOutput(json_encode([
                'success' => false,
                'message' => 'City and State not found for this pincode'
            ]));
        }
    }
    
}
