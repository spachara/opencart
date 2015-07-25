<?php
/**
* Thailand Post Shipping Extension for OpenCart v2.0.1.1
* @author Sureerat Phattara-ampornchai <sureemo@gmail.com>
* @version 2015-05-26
* @copyright www.SiamTrack.com
* @license GNU Public License
*/
class ControllerShippingThaipost extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('shipping/thaipost');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('thaipost', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_service'] = $this->language->get('entry_service');
		$data['entry_reg'] = $this->language->get('entry_reg');
		$data['entry_ems'] = $this->language->get('entry_ems');

		$data['entry_reg_cost'] = $this->language->get('entry_reg_cost');
		$data['entry_ems_cost'] = $this->language->get('entry_ems_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['thaipost_reg_cost'])) {
			$data['error_reg_cost'] = $this->error['thaipost_reg_cost'];
		} else {
			$data['error_reg_cost'] = '';
		}

		if (isset($this->error['thaipost_ems_cost'])) {
			$data['error_ems_cost'] = $this->error['thaipost_ems_cost'];
		} else {
			$data['error_ems_cost'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/thaipost', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/thaipost', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['thaipost_reg'])) {
			$data['thaipost_reg'] = $this->request->post['thaipost_reg'];
		} else {
			$data['thaipost_reg'] = $this->config->get('thaipost_reg');
		}

		if (isset($this->request->post['thaipost_reg_cost'])) {
			$data['thaipost_reg_cost'] = $this->request->post['thaipost_reg_cost'];
		} else {
			$data['thaipost_reg_cost'] = $this->config->get('thaipost_reg_cost');
		}

		if (isset($this->request->post['thaipost_ems'])) {
			$data['thaipost_ems'] = $this->request->post['thaipost_ems'];
		} else {
			$data['thaipost_ems'] = $this->config->get('thaipost_ems');
		}

		if (isset($this->request->post['thaipost_ems_cost'])) {
			$data['thaipost_ems_cost'] = $this->request->post['thaipost_ems_cost'];
		} else {
			$data['thaipost_ems_cost'] = $this->config->get('thaipost_ems_cost');
		}

		if (isset($this->request->post['thaipost_tax_class_id'])) {
			$data['thaipost_tax_class_id'] = $this->request->post['thaipost_tax_class_id'];
		} else {
			$data['thaipost_tax_class_id'] = $this->config->get('thaipost_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['thaipost_geo_zone_id'])) {
			$data['thaipost_geo_zone_id'] = $this->request->post['thaipost_geo_zone_id'];
		} else {
			$data['thaipost_geo_zone_id'] = $this->config->get('thaipost_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['thaipost_status'])) {
			$data['thaipost_status'] = $this->request->post['thaipost_status'];
		} else {
			$data['thaipost_status'] = $this->config->get('thaipost_status');
		}

		if (isset($this->request->post['thaipost_sort_order'])) {
			$data['thaipost_sort_order'] = $this->request->post['thaipost_sort_order'];
		} else {
			$data['thaipost_sort_order'] = $this->config->get('thaipost_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/thaipost.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/thaipost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['thaipost_reg']) AND $this->request->post['thaipost_reg'] AND !$this->request->post['thaipost_reg_cost']) {
			$this->error['thaipost_reg_cost'] = $this->language->get('error_reg_cost');
		}

		if (isset($this->request->post['thaipost_ems']) AND $this->request->post['thaipost_ems'] AND !$this->request->post['thaipost_ems_cost']) {
			$this->error['thaipost_ems_cost'] = $this->language->get('error_ems_cost');
		}

		return !$this->error;
	}
}