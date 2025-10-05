<?php

namespace App\PaymentGateways\Myfatoorah;

use App\Models\PaymentMethod;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use Illuminate\Support\Facades\Log;

class MyFatoorahGateway
{
    protected $mf;
    protected $gateway;

    public function __construct()
    {
        require_once app_path('PaymentGateways/Myfatoorah/autoload.php');
        // جلب بيانات البوابة من قاعدة البيانات
        $this->gateway = \App\Models\PaymentMethod::where('code', 'myfatoorah')->where('is_active', 1)->first();
        if (!$this->gateway) {
            throw new \Exception('بوابة ماي فاتورة غير مفعلة أو غير موجودة');
        }
        $config = $this->gateway->config;
        // ربط العملة بكود الدولة تلقائياً
        $settings = $this->gateway->settings;
        $settings = is_string($settings) ? json_decode($settings, true) : (array)$settings;
        $currency = $settings['currency'] ?? '';
        $currencyCountryMap = [
            'SAR' => 'SAU',
            'KWD' => 'KWT',
            'BHD' => 'BHR',
            'AED' => 'ARE',
            'QAR' => 'QAT',
            'OMR' => 'OMN',
            'JOD' => 'JOR',
            'EGP' => 'EGY',
        ];
        $countryCode = $currencyCountryMap[$currency] ?? '';
        $this->mf = new \MyFatoorah\Library\API\Payment\MyFatoorahPayment([
            'apiKey' => $config['apiKey'] ?? '',
            'isTest' => $this->gateway->mode === 'test',
            'vcCode' => $config['vcCode'] ?? $countryCode,
        ]);
    }

    /**
     * إنشاء عملية دفع جديدة
     * @param array $customer [name, email, mobile]
     * @param float $amount
     * @param string $successUrl
     * @param string $errorUrl
     * @param string $currency
     * @return string رابط الدفع
     * @throws \Exception
     */
    public function createPayment(array $customer, $amount, $successUrl, $errorUrl, $currency = 'SAR')
    {
        // معالجة رقم الجوال ليبدأ بـ 5 فقط (بدون 966 أو 0) وأقصى طول 9 أرقام
        $mobile = $customer['mobile'] ?? '';
        $mobile = preg_replace('/[^0-9]/', '', $mobile); // إزالة أي رموز غير رقمية
        // إذا كان الرقم يبدأ بـ 9665، نحذف 966
        if (preg_match('/^9665[0-9]{8}$/', $mobile)) {
            $mobile = substr($mobile, 3); // تصبح 5XXXXXXXX
        }
        // إذا كان الرقم يبدأ بـ 05، نحذف الصفر
        if (preg_match('/^05[0-9]{8}$/', $mobile)) {
            $mobile = substr($mobile, 1); // تصبح 5XXXXXXXX
        }
        // إذا كان الرقم يبدأ بـ 5 وأطول من 9 أرقام، نأخذ أول 9 فقط
        if (preg_match('/^5[0-9]{8,}$/', $mobile)) {
            $mobile = substr($mobile, 0, 9);
        }

        $postFields = [
            'CustomerName'       => $customer['name'] ?? '',
            'CustomerEmail'      => $customer['email'] ?? '',
            'CustomerMobile'     => $mobile,
            'InvoiceValue'       => $amount,
            'DisplayCurrencyIso' => $currency,
            'CallBackUrl'        => $successUrl,
            'ErrorUrl'           => $errorUrl,
        ];
        try {
            $paymentData = $this->mf->getInvoiceURL($postFields);
            return $paymentData['invoiceURL'] ?? null;
        } catch (\Exception $e) {
            \Log::error('MyFatoorah Payment Error: ' . $e->getMessage(), [
                'mfConfig' => isset($this->mf) ? (array)($this->mf) : null,
                'postFields' => $postFields,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * معالجة الدفع (للتوافق مع باقي البوابات)
     * @param \App\Models\Order $order
     * @return array
     */
    public function processPayment($order)
    {
        $customer = [
            'name'   => $order->user->name ?? 'عميل',
            'email'  => $order->user->email ?? 'test@test.com',
            'mobile' => $order->user->phone ?? '',
        ];
        $amount = $order->total;
        $successUrl = route('payment.myfatoorah.success', ['order_id' => $order->id, 'token' => $order->order_token]);
        $errorUrl   = route('payment.myfatoorah.cancel', ['order_id' => $order->id, 'token' => $order->order_token]);

        // جلب العملة من إعدادات البوابة فقط
        $settings = $this->gateway->settings;
        $settings = is_string($settings) ? json_decode($settings, true) : (array)$settings;
        $currency = $settings['currency'] ?? 'SAR';

        $paymentUrl = $this->createPayment($customer, $amount, $successUrl, $errorUrl, $currency);

        return [
            'success' => true,
            'redirect_url' => $paymentUrl,
            'payment_url' => $paymentUrl,
        ];
    }

    /**
     * التحقق من حالة الدفع عبر ماي فاتورة
     * @param string $paymentId
     * @return array
     */
    public function verifyPayment($paymentId)
    {
        try {
            $config = $this->gateway->config;
            $mfConfig = [
                'apiKey' => $config['apiKey'] ?? '',
                'isTest' => $this->gateway->mode === 'test',
                'vcCode' => $config['vcCode'] ?? ($config['countryCode'] ?? ''),
            ];
            $mfObj = new \MyFatoorah\Library\MyFatoorah($mfConfig);
            $apiURL = $mfObj->getApiURL();
            $postFields = [
                'Key' => $paymentId,
                'KeyType' => 'PaymentId',
            ];
            $result = $mfObj->callAPI("$apiURL/v2/GetPaymentStatus", $postFields);
            $resultArr = json_decode(json_encode($result), true);
            if (isset($resultArr['Data']['InvoiceStatus']) && $resultArr['Data']['InvoiceStatus'] === 'Paid') {
                return [
                    'success' => true,
                    'status' => 'Paid',
                    'data' => $resultArr['Data']
                ];
            } else {
                return [
                    'success' => false,
                    'status' => $resultArr['Data']['InvoiceStatus'] ?? 'Unknown',
                    'data' => $resultArr['Data'] ?? $resultArr
                ];
            }
        } catch (\Exception $e) {
            \Log::error('MyFatoorah verifyPayment error: ' . $e->getMessage(), [
                'paymentId' => $paymentId,
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'status' => 'Error',
                'data' => [],
                'message' => $e->getMessage()
            ];
        }
    }
} 