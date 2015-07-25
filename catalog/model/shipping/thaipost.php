<?php
/**
* Thailand Post Shipping Extension for OpenCart v2.0.1.1
* @author Sureerat Phattara-ampornchai <sureemo@gmail.com>
* @version 2015-05-26
* @copyright www.SiamTrack.com
* @license GNU Public License
*/
class ModelShippingThaipost extends Model {
	function getQuote($address) {
		$this->load->language('shipping/thaipost');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('thaipost_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('thaipost_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			if ($this->config->get('thaipost_reg')) {
				$quote_data['thaipost_reg'] = array(
					'code'         => 'thaipost.thaipost_reg',
					'title'        => '<span class="thaipost"><img src="image/thaipost/registered.png"></span> <span>'.$this->language->get('text_thaipost_registered').'</span>',
					'cost'         => $this->config->get('thaipost_reg_cost'),
					'tax_class_id' => $this->config->get('thaipost_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($this->config->get('thaipost_reg_cost'), $this->config->get('thaipost_tax_class_id'), $this->config->get('config_tax')))
				);
			}

			if ($this->config->get('thaipost_ems')) {
				$quote_data['thaipost_ems'] = array(
					'code'         => 'thaipost.thaipost_ems',
					'title'        => '<span class="thaipost"><img src="image/thaipost/ems.png"></span> <span>'.$this->language->get('text_thaipost_ems').'</span>',
					'cost'         => $this->config->get('thaipost_ems_cost'),
					'tax_class_id' => $this->config->get('thaipost_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($this->config->get('thaipost_ems_cost'), $this->config->get('thaipost_tax_class_id'), $this->config->get('config_tax')))
				);
			}

			$method_data = array(
				'code'       => 'thaipost',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('thaipost_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}