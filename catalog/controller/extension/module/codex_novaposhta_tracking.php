<?php
class ControllerExtensionModuleCodexNovaposhtaTracking extends Controller {
    public function index() {
        $this->load->language('extension/module/codex_novaposhta_tracking');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_description'] = $this->language->get('text_description');
        $data['entry_ttn'] = $this->language->get('entry_ttn');
        $data['button_track'] = $this->language->get('button_track');

        $data['text_result_ttn'] = $this->language->get('text_result_ttn');
        $data['text_result_status'] = $this->language->get('text_result_status');
        $data['text_result_sender_city'] = $this->language->get('text_result_sender_city');
        $data['text_result_recipient_city'] = $this->language->get('text_result_recipient_city');
        $data['text_result_recipient'] = $this->language->get('text_result_recipient');
        $data['text_result_updated_at'] = $this->language->get('text_result_updated_at');

        $data['ttn'] = '';
        $data['tracking'] = array();
        $data['error_warning'] = '';

        if (isset($this->request->post['ttn'])) {
            $data['ttn'] = trim($this->request->post['ttn']);

            if (!$data['ttn']) {
                $data['error_warning'] = $this->language->get('error_ttn_required');
            } else {
                $result = $this->requestTracking($data['ttn']);
                if ($result['error']) {
                    $data['error_warning'] = $result['error'];
                } else {
                    $data['tracking'] = $result['data'];
                }
            }
        }

        return $this->load->view('extension/module/codex_novaposhta_tracking', $data);
    }

    private function requestTracking($ttn) {
        $api_url = rtrim($this->config->get('codex_novaposhta_api_url'), '/');
        $api_key = $this->config->get('codex_novaposhta_api_key');

        if (!$api_url) {
            return array('error' => $this->language->get('error_api_not_configured'), 'data' => array());
        }

        $endpoint = $api_url . '/nova-poshta/track';

        $payload = array('ttn' => $ttn);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json'
        );

        if ($api_key) {
            $headers[] = 'Authorization: Bearer ' . $api_key;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        $http_code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curl_error) {
            return array('error' => $this->language->get('error_connection') . ' ' . $curl_error, 'data' => array());
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return array('error' => $this->language->get('error_bad_response'), 'data' => array());
        }

        if ($http_code >= 400) {
            $message = !empty($decoded['message']) ? $decoded['message'] : $this->language->get('error_http');
            return array('error' => $message, 'data' => array());
        }

        $data = isset($decoded['data']) && is_array($decoded['data']) ? $decoded['data'] : $decoded;

        return array('error' => '', 'data' => array(
            'ttn' => isset($data['ttn']) ? $data['ttn'] : $ttn,
            'status' => isset($data['status']) ? $data['status'] : (isset($data['current_status']) ? $data['current_status'] : ''),
            'city_sender' => isset($data['city_sender']) ? $data['city_sender'] : '',
            'city_recipient' => isset($data['city_recipient']) ? $data['city_recipient'] : '',
            'recipient' => isset($data['recipient']) ? $data['recipient'] : '',
            'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : ''
        ));
    }
}
