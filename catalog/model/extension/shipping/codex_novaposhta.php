<?php
class ModelExtensionShippingCodexNovaposhta extends Model {
    public function getQuote($address) {
        $this->load->language('extension/shipping/codex_novaposhta');

        if (!$this->config->get('codex_novaposhta_status')) {
            return array();
        }

        $status = true;

        $geo_zone_id = (int)$this->config->get('codex_novaposhta_geo_zone_id');
        if ($geo_zone_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . $geo_zone_id . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
            $status = $query->num_rows > 0;
        }

        if (!$status) {
            return array();
        }

        $cost = (float)$this->config->get('codex_novaposhta_default_cost');

        $quote_data = array();

        $quote_data['codex_novaposhta'] = array(
            'code' => 'codex_novaposhta.codex_novaposhta',
            'title' => $this->language->get('text_description') . ' (' . $this->language->get('text_eta') . ')',
            'cost' => $cost,
            'tax_class_id' => 0,
            'text' => $this->currency->format($this->tax->calculate($cost, 0, $this->config->get('config_tax')))
        );

        return array(
            'code' => 'codex_novaposhta',
            'title' => $this->language->get('text_title'),
            'quote' => $quote_data,
            'sort_order' => $this->config->get('codex_novaposhta_sort_order'),
            'error' => false
        );
    }
}
