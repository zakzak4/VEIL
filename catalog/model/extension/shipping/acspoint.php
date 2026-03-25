<?php

class ModelExtensionShippingAcsPoint extends Model
{
    public function getQuote($address)
    {
        $method_data = [];
        $status = $this->config->get('shipping_acspoint_status');
        if (! $status) {
            return $method_data;
        }

        if ($this->cart->getWeight() > $this->config->get('shipping_acspoint_weight_limit')) {
            return $method_data;
        }

        if ($this->cart->getTotal() > $this->config->get('shipping_acspoint_total')) {
            $cost = 0;
        } else {
            $pricing = $this->config->get('shipping_acspoint_pricing');
            $type = $this->calculate(
                $this->config->get('shipping_acspoint_senderCountry'),
                $this->config->get('shipping_acspoint_senderZipcode'),
                $this->config->get('shipping_acspoint_acsClientId'),
                $address['iso_code_2'],
                $address['postcode']
            );

            if (! $type) {
                return $method_data;
            }

            $cost = $pricing[$type]['baseCost'];
            if ($this->cart->getWeight() > $pricing[$type]['baseCostKgLimit']) {
                $cost += $pricing[$type]['costPerKg'] * ($this->cart->getWeight() - $pricing[$type]['baseCostKgLimit']);
            }
        }

        return [
            'code' => 'acspoint',
            'title' => $this->config->get('shipping_acspoint_title'),
            'quote' => [
                'acspoint' => [
                    'code' => 'acspoint.acspoint',
                    'title' => $this->config->get('shipping_acspoint_title'),
                    'cost' => $cost,
                    'tax_class_id' => 0,
                    'text' => $this->currency->format($cost, $this->session->data['currency']),
                ],
            ],
            'sort_order' => $this->config->get('shipping_acspoint_sort_order'),
            'error' => false,
        ];
    }

    public function calculate(
        $sender_country,
        $sender_zipcode,
        $sender_billing_code,
        $recipient_country,
        $recipient_zipcode
    ) {
        preg_match('/\d([^\d]{2})\d+/u', $sender_billing_code, $matches);
        $sender_store = $matches[1] ?? null;
        $sender_zipcode_data = $this->getDataFromZipcode($sender_zipcode);
        $recipient_zipcode_data = $this->getDataFromZipcode($recipient_zipcode);

        if (! in_array($recipient_country, ['GR', 'CY']) || ! in_array($sender_country, ['GR', 'CY'])) {
            return false;
        }

        if ($sender_country === 'CY' && $recipient_country === 'CY') {
            return 'internal_cyprus';
        }

        if ($sender_country === 'CY' || $recipient_country === 'CY') {
            return 'cyprus';
        }

        if ($sender_store == $recipient_zipcode_data['store']) {
            return 'same_city';
        }

        if ($recipient_zipcode_data['category'] == 'ΝΗΣΙΩΤΙΚΟΣ') {
            return 'island';
        }

        if (
            $recipient_zipcode_data['region'] != ''
            && $sender_zipcode_data['region'] != ''
            && $recipient_zipcode_data['region'] == $sender_zipcode_data['region']
        ) {
            return 'region';
        }

        return 'overland';
    }

    private function getDataFromZipcode($recipient_zipcode)
    {
        $json = file_get_contents(DIR_SYSTEM.'library/acs-points-api/js/mapper.json');
        $data = json_decode($json, true);

        return [
            'store' => $data[$recipient_zipcode]['store'] ?? null,
            'category' => $data[$recipient_zipcode]['category'] ?? null,
            'region' => $data[$recipient_zipcode]['region'] ?? null,
        ];
    }
}
