<?php
class ControllerExtensionModuleCodexOpencart extends Controller {
    public function index($setting) {
        if (!$this->config->get('module_codex_opencart_status')) {
            return;
        }

        $this->load->language('extension/module/codex_opencart');

        $data['title'] = $this->config->get('module_codex_opencart_title');
        $data['text'] = html_entity_decode($this->config->get('module_codex_opencart_text'), ENT_QUOTES, 'UTF-8');

        if (!$data['title']) {
            $data['title'] = $this->language->get('text_default_title');
        }

        if (!$data['text']) {
            $data['text'] = $this->language->get('text_default_body');
        }

        return $this->load->view('extension/module/codex_opencart', $data);
    }
}
