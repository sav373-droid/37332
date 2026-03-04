<?php
class ControllerExtensionModuleCodexOpencart extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/codex_opencart');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_codex_opencart', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_text'] = $this->language->get('entry_text');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/codex_opencart', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/codex_opencart', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        if (isset($this->request->post['module_codex_opencart_status'])) {
            $data['module_codex_opencart_status'] = $this->request->post['module_codex_opencart_status'];
        } else {
            $data['module_codex_opencart_status'] = $this->config->get('module_codex_opencart_status');
        }

        if (isset($this->request->post['module_codex_opencart_title'])) {
            $data['module_codex_opencart_title'] = $this->request->post['module_codex_opencart_title'];
        } else {
            $data['module_codex_opencart_title'] = $this->config->get('module_codex_opencart_title');
        }

        if (isset($this->request->post['module_codex_opencart_text'])) {
            $data['module_codex_opencart_text'] = $this->request->post['module_codex_opencart_text'];
        } else {
            $data['module_codex_opencart_text'] = $this->config->get('module_codex_opencart_text');
        }

        if (!$data['module_codex_opencart_title']) {
            $data['module_codex_opencart_title'] = $this->language->get('text_default_title');
        }

        if (!$data['module_codex_opencart_text']) {
            $data['module_codex_opencart_text'] = $this->language->get('text_default_body');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/codex_opencart', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/codex_opencart')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
