<?php
class ControllerExtensionModuleCodexNovaposhtaTracking extends Controller {
    public function index() {
        $this->load->language('extension/module/codex_novaposhta_tracking');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_description'] = $this->language->get('text_description');
        $data['entry_ttn'] = $this->language->get('entry_ttn');
        $data['entry_phone'] = $this->language->get('entry_phone');
        $data['button_track'] = $this->language->get('button_track');

        $data['text_result_ttn'] = $this->language->get('text_result_ttn');
        $data['text_result_status'] = $this->language->get('text_result_status');
        $data['text_result_sender_city'] = $this->language->get('text_result_sender_city');
        $data['text_result_recipient_city'] = $this->language->get('text_result_recipient_city');
        $data['text_result_updated_at'] = $this->language->get('text_result_updated_at');

        $data['ttn'] = '';
        $data['phone'] = '';
        $data['tracking'] = array();
        $data['error_warning'] = '';

        if (isset($this->request->post['ttn'])) {
            $data['ttn'] = trim($this->request->post['ttn']);
            $data['phone'] = trim($this->request->post['phone']);

            if (!$data['ttn']) {
                $data['error_warning'] = $this->language->get('error_ttn_required');
            } else {
                $result = $this->requestTracking($data['ttn'], $data['phone']);
                if ($result['error']) {
                    $data['error_warning'] = $result['error'];
                } else {
                    $data['tracking'] = $result['data'];
                }
            }
        }

        return $this->load->view('extension/module/codex_novaposhta_tracking', $data);
    }

    private function requestTracking($ttn, $phone = '') {
        $api_key = $this->config->get('codex_novaposhta_api_key');

        if (!$api_key) {
            return array('error' => $this->language->get('error_api_not_configured'), 'data' => array());
        }

        $payload = array(
            'apiKey' => $api_key,
            'modelName' => 'TrackingDocument',
            'calledMethod' => 'getStatusDocuments',
            'methodProperties' => array(
                'Documents' => array(
                    array(
                        'DocumentNumber' => $ttn,
                        'Phone' => $phone
                    )
                )
            )
        );

        $ch = curl_init('https://api.novaposhta.ua/v2.0/json/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            return array('error' => $this->language->get('error_connection') . ' ' . $curl_error, 'data' => array());
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return array('error' => $this->language->get('error_bad_response'), 'data' => array());
        }

        if (!empty($decoded['success']) && !empty($decoded['data'][0])) {
            $item = $decoded['data'][0];
            return array('error' => '', 'data' => array(
                'ttn' => isset($item['Number']) ? $item['Number'] : $ttn,
                'status' => isset($item['Status']) ? $item['Status'] : '',
                'city_sender' => isset($item['CitySender']) ? $item['CitySender'] : '',
                'city_recipient' => isset($item['CityRecipient']) ? $item['CityRecipient'] : '',
                'updated_at' => isset($item['DateCurrentStatus']) ? $item['DateCurrentStatus'] : ''
            ));
        }

        $errors = !empty($decoded['errors']) && is_array($decoded['errors']) ? implode('; ', $decoded['errors']) : $this->language->get('error_http');
        return array('error' => $errors, 'data' => array());
    }
}
