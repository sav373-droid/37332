<?php
class ControllerExtensionShippingCodexNovaposhta extends Controller {
    private $error = array();

    public function install() {
        $this->load->model('extension/shipping/codex_novaposhta');
        $this->model_extension_shipping_codex_novaposhta->install();
    }

    public function uninstall() {
        $this->load->model('extension/shipping/codex_novaposhta');
        $this->model_extension_shipping_codex_novaposhta->uninstall();
    }

    public function index() {
        $this->load->language('extension/shipping/codex_novaposhta');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('localisation/geo_zone');
        $this->load->model('extension/shipping/codex_novaposhta');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['save_settings']) && $this->validate()) {
            $this->model_setting_setting->editSetting('codex_novaposhta', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/shipping/codex_novaposhta', 'token=' . $this->session->data['token'], true));
        }

        $data = $this->buildViewData();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['test_api']) && $this->validateApiAccess()) {
            $model_name = trim($this->request->post['api_model']);
            $method_name = trim($this->request->post['api_method']);
            $props = $this->decodeProps($this->request->post['api_properties']);

            if ($props === false) {
                $data['api_error'] = $this->language->get('error_json');
            } else {
                $api_result = $this->model_extension_shipping_codex_novaposhta->request($model_name, $method_name, $props, true);
                if ($api_result['error']) {
                    $data['api_error'] = $api_result['error'];
                } else {
                    $data['api_response'] = json_encode($api_result['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            }
        }

        $data['action_logs'] = $this->model_extension_shipping_codex_novaposhta->getActionLogs(100);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/codex_novaposhta', $data));
    }

    protected function buildViewData() {
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_settings'] = $this->language->get('text_settings');
        $data['text_api_console'] = $this->language->get('text_api_console');
        $data['text_action_log'] = $this->language->get('text_action_log');

        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_default_cost'] = $this->language->get('entry_default_cost');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_api_model'] = $this->language->get('entry_api_model');
        $data['entry_api_method'] = $this->language->get('entry_api_method');
        $data['entry_api_properties'] = $this->language->get('entry_api_properties');

        $data['help_api_console'] = $this->language->get('help_api_console');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_test_api'] = $this->language->get('button_test_api');

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['breadcrumbs'] = array(
            array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
            ),
            array(
                'text' => $this->language->get('text_shipping'),
                'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true)
            ),
            array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/shipping/codex_novaposhta', 'token=' . $this->session->data['token'], true)
            )
        );

        $data['action'] = $this->url->link('extension/shipping/codex_novaposhta', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], true);

        $fields = array(
            'codex_novaposhta_api_key' => '',
            'codex_novaposhta_default_cost' => '0',
            'codex_novaposhta_geo_zone_id' => 0,
            'codex_novaposhta_status' => 1,
            'codex_novaposhta_sort_order' => 0,
            'api_model' => 'TrackingDocument',
            'api_method' => 'getStatusDocuments',
            'api_properties' => "{\n  \"Documents\": [\n    {\"DocumentNumber\": \"20400048799000\", \"Phone\": \"\"}\n  ]\n}"
        );

        foreach ($fields as $field => $default) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } else {
                $data[$field] = $this->config->get($field) !== null ? $this->config->get($field) : $default;
            }
        }

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        $data['api_error'] = '';
        $data['api_response'] = '';

        return $data;
    }

    private function decodeProps($json) {
        $json = trim($json);
        if ($json === '') {
            return array();
        }

        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            return false;
        }

        return $decoded;
    }

    protected function validateApiAccess() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/codex_novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }

        if (!$this->config->get('codex_novaposhta_api_key') && empty($this->request->post['codex_novaposhta_api_key'])) {
            $this->error['warning'] = $this->language->get('error_api_key');
            return false;
        }

        return true;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/codex_novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['codex_novaposhta_api_key'])) {
            $this->error['warning'] = $this->language->get('error_api_key');
        }

        return !$this->error;
    }
}
