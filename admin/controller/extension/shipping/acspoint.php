<?php

class ControllerExtensionShippingACSPoint extends Controller
{
    private $error = [];

    public function index()
    {
        $this->load->language('extension/shipping/acspoint');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $acs_filename = DIR_IMAGE.'catalog/acs-points-api/data.json';

            if (file_exists($acs_filename)) {
                unlink($acs_filename);
            }

            $this->model_setting_setting->editSetting('shipping_acspoint', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=shipping', true));
        }

        $data['error_warning'] = '';
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token='.$this->session->data['user_token'], true),
        ];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=shipping', true),
        ];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/acspoint', 'user_token='.$this->session->data['user_token'], true),
        ];

        $data['action'] = $this->url->link('extension/shipping/acspoint', 'user_token='.$this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=shipping', true);

        $fields = [
            'status', 'title', 'sort_order',
            'countries_availability', 'api_key', 'weight_limit', 'total', 'senderCountry', 'senderZipcode',
            'acsCompanyID', 'acsCompanyPassword', 'acsUserID', 'acsUserPassword', 'acsApiKey', 'acsClientId',
        ];

        foreach ($fields as $field) {
            $key = "shipping_acspoint_{$field}";
            $data[$key] = $this->request->post[$key] ?? $this->config->get($key) ?? '';
        }

        $data['shipping_acspoint_pricing'] = $this->config->get('shipping_acspoint_pricing');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/acspoint', $data));
    }

    protected function validate()
    {
        if (! $this->user->hasPermission('modify', 'extension/shipping/acspoint')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return ! $this->error;
    }

    public function install()
    {
        $index_exists = $this->db->query('SHOW COLUMNS FROM `'.DB_PREFIX."order` like 'acs_point'")->num_rows > 0;
        if (! $index_exists) {
            $this->db->query('ALTER TABLE '.DB_PREFIX.'order ADD COLUMN acs_point text NULL;');
        }
        $index_exists = $this->db->query('SHOW COLUMNS FROM `'.DB_PREFIX."order` like 'acs_point_slug'")->num_rows > 0;
        if (! $index_exists) {
            $this->db->query('ALTER TABLE '.DB_PREFIX.'order ADD COLUMN acs_point_slug text NULL;');
        }
    }

    public function uninstall()
    {
        // Do not remove existing columns as important data is stored here.
    }
}
