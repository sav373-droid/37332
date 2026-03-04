<?php
class ControllerExtensionShippingCodexNovaposhta extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/codex_novaposhta');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('localisation/geo_zone');
        $this->load->model('localisation/order_status');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('codex_novaposhta', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_api_url'] = $this->language->get('entry_api_url');
        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_default_cost'] = $this->language->get('entry_default_cost');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_tracking_order_status'] = $this->language->get('entry_tracking_order_status');

        $data['help_api_url'] = $this->language->get('help_api_url');
        $data['help_tracking_order_status'] = $this->language->get('help_tracking_order_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $data['error_api_url'] = isset($this->error['api_url']) ? $this->error['api_url'] : '';

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/codex_novaposhta', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/codex_novaposhta', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true);

        $setting_fields = array(
            'codex_novaposhta_api_url' => 'https://crm.sitniks.com/open-api',
            'codex_novaposhta_api_key' => '',
            'codex_novaposhta_default_cost' => '0',
            'codex_novaposhta_geo_zone_id' => 0,
            'codex_novaposhta_status' => 1,
            'codex_novaposhta_sort_order' => 0,
            'codex_novaposhta_tracking_order_status_id' => 0
        );

        foreach ($setting_fields as $field => $default) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } else {
                $data[$field] = $this->config->get($field) !== null ? $this->config->get($field) : $default;
            }
        }

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/codex_novaposhta', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/codex_novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['codex_novaposhta_api_url'])) {
            $this->error['api_url'] = $this->language->get('error_api_url');
        }

        return !$this->error;
    }
}
