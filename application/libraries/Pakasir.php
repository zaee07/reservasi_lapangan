<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pakasir
{
    protected $CI;
    protected $config;
    public function __construct()
    {
        $this->CI = &get_instance();
        // $this->CI->config->load('pakasir');
        $this->config['api_key'] = $this->CI->config->item('pakasir_api_key');
        $this->config['project'] = $this->CI->config->item('pakasir_project');
        $this->config['pakasir_url'] = $this->CI->config->item('pakasir_base_url');
        $this->config['timeout'] = 30;
    }
    private function payload($order_id, $amount)
    {
        return [
            'project' => $this->config['project'],
            'order_id' => (string) $order_id,
            'amount' => (int)  $amount,
            'api_key' => $this->config['api_key']
        ];
    }

    /**
     * Request POST
     */
    private function post($endpoint, $payload)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL => $this->config['pakasir_url'] . $endpoint,

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],

            CURLOPT_POSTFIELDS => json_encode($payload),

            CURLOPT_TIMEOUT => $this->config['timeout']

        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'http_code' => 0,
                'response' => null,
                'error' => $error
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = curl_error($ch);

        curl_close($ch);

        return [

            'success' => ($httpCode >= 200 && $httpCode < 300),

            'http_code' => $httpCode,

            'response' => $response ? json_decode($response, true) : null,

            'error' => $error

        ];
    }

    /**
     * Request GET
     */
    private function get($endpoint)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->config['pakasir_url'] . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_TIMEOUT => $this->config['timeout']
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'http_code' => 0,
                'response' => null,
                'error' => $error
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = curl_error($ch);

        curl_close($ch);

        return [

            'success' => ($httpCode >= 200 && $httpCode < 300),

            'http_code' => $httpCode,

            'response' => $response ? json_decode($response, true) : null,

            'error' => $error

        ];
    }

    /**
     * Membuat transaksi QRIS
     */
    public function create_transaction($order_id, $amount)
    {
        $result = $this->post(
            'transactioncreate/qris',
            $this->payload($order_id, $amount)
        );
        log_message(
            'info',
            'Pakasir Create : ' . json_encode($result)
        );
        // echo "<pre>";
        // print_r($result);
        // die();
        return $result;
    }

    /**
     * Detail transaksi
     */
    public function detail_transaction($order_id, $amount)
    {
        $query = http_build_query([
            'project' => $this->config['project'],
            'amount' => $amount,
            'order_id' => $order_id,
            'api_key' => $this->config['api_key']
        ]);

        $result = $this->get(
            'transactiondetail?' . $query
        );
        log_message(
            'info',
            'Pakasir detail : ' . json_encode($result)
        );
        // echo "<pre>";
        // print_r($result);
        // die();
        return $result;
    }

    /**
     * Cancel transaksi
     */
    public function cancel_transaction($order_id, $amount)
    {
        $result = $this->post(
            'transactioncancel',
            $this->payload($order_id, $amount)
        );
        log_message(
            'info',
            'Pakasir cancel : ' . json_encode($result)
        );
        return $result;
    }
}
