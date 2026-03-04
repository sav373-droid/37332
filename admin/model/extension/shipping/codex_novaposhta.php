<?php
class ModelExtensionShippingCodexNovaposhta extends Model {
    public function install() {
        $this->ensureLogTable();
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "codex_novaposhta_action`");
    }

    public function request($model_name, $method_name, $method_properties = array(), $log = true) {
        $api_key = $this->config->get('codex_novaposhta_api_key');
        $endpoint = 'https://api.novaposhta.ua/v2.0/json/';

        $payload = array(
            'apiKey' => $api_key,
            'modelName' => $model_name,
            'calledMethod' => $method_name,
            'methodProperties' => (array)$method_properties
        );

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);

        $raw = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            if ($log) {
                $this->addActionLog('outgoing', $model_name, $method_name, $payload, array('error' => $curl_error), 1);
            }

            return array('error' => 'cURL: ' . $curl_error, 'response' => array());
        }

        $response = json_decode($raw, true);

        if (!is_array($response)) {
            if ($log) {
                $this->addActionLog('outgoing', $model_name, $method_name, $payload, array('raw' => $raw), 1);
            }

            return array('error' => 'Invalid JSON response from Nova Poshta API', 'response' => array());
        }

        $is_error = (!empty($response['success']) && $response['success'] === false) || !empty($response['errors']);
        $error_message = '';

        if (!empty($response['errors']) && is_array($response['errors'])) {
            $error_message = implode('; ', $response['errors']);
        }

        if ($log) {
            $this->addActionLog('outgoing', $model_name, $method_name, $payload, $response, $is_error ? 1 : 0);
        }

        return array('error' => $error_message, 'response' => $response);
    }

    public function addActionLog($direction, $model_name, $method_name, $request, $response, $is_error = 0) {
        $this->ensureLogTable();

        $this->db->query("INSERT INTO `" . DB_PREFIX . "codex_novaposhta_action` SET
            date_added = NOW(),
            direction = '" . $this->db->escape($direction) . "',
            model = '" . $this->db->escape($model_name) . "',
            method = '" . $this->db->escape($method_name) . "',
            request_json = '" . $this->db->escape(json_encode($request, JSON_UNESCAPED_UNICODE)) . "',
            response_json = '" . $this->db->escape(json_encode($response, JSON_UNESCAPED_UNICODE)) . "',
            is_error = '" . (int)$is_error . "'");
    }

    public function getActionLogs($limit = 100) {
        if (!$this->tableExists(DB_PREFIX . 'codex_novaposhta_action')) {
            return array();
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "codex_novaposhta_action` ORDER BY codex_novaposhta_action_id DESC LIMIT " . (int)$limit);

        return $query->rows;
    }

    private function ensureLogTable() {
        if ($this->tableExists(DB_PREFIX . 'codex_novaposhta_action')) {
            return;
        }

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "codex_novaposhta_action` (
            `codex_novaposhta_action_id` INT(11) NOT NULL AUTO_INCREMENT,
            `date_added` DATETIME NOT NULL,
            `direction` VARCHAR(32) NOT NULL,
            `model` VARCHAR(64) NOT NULL,
            `method` VARCHAR(64) NOT NULL,
            `request_json` MEDIUMTEXT NOT NULL,
            `response_json` MEDIUMTEXT NOT NULL,
            `is_error` TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (`codex_novaposhta_action_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
    }

    private function tableExists($table_name) {
        $query = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($table_name) . "'");

        return $query->num_rows > 0;
    }
}
