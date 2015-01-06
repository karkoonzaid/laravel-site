<?php namespace Acme\Payment\Methods;

// Wrapper methods for all PayPal integration

use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class Paypal {

    /**
     * Create a payment using the buyer's paypal
     * account as the funding instrument. Your app
     * will have to redirect the buyer to the paypal
     * website, obtain their consent to the payment
     * and subsequently execute the payment using
     * the execute API call.
     *
     * @param string $total payment amount in DDD.DD format
     * @param string $currency 3 letter ISO currency code such as 'USD'
     * @param string $paymentDesc A description about the payment
     * @param string $returnUrl The url to which the buyer must be redirected
     *                to on successful completion of payment
     * @param string $cancelUrl The url to which the buyer must be redirected
     *                to if the payment is cancelled
     * @return \PayPal\Api\Payment
     */

    private function getApiContext()
    {
        $apiContext = new ApiContext(new OAuthTokenCredential(
            '',
            ''
        ));

        $apiContext->setConfig(array(
            'http.ConnectionTimeOut' => 30,
            'http.Retry'             => 1,
            'mode'                   => 'live',
            'log.LogEnabled'         => false,
            'log.FileName'           => '../PayPal.log',
            'log.LogLevel'           => 'INFO'
        ));

        return $apiContext;
    }


    public function makePayment($total, $currency, $paymentDesc, $returnUrl, $cancelUrl, $options = [])
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Specify the payment amount.
        $amount = new Amount();
        $amount->setCurrency($currency);
        $amount->setTotal($total);

        // ###Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $item = new Item();
        $item->setDescription($paymentDesc);
        $item->setName($options['title']);
        $item->setPrice($total);
        $item->setCurrency($currency);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($paymentDesc);
//        $transaction->setItemList($itemList);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl);
        $redirectUrls->setCancelUrl($cancelUrl);

        $payment = new Payment();
        $payment->setRedirectUrls($redirectUrls);
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        $payment->create($this->getApiContext());

        return $payment;
    }

    /**
     * Completes the payment once buyer approval has been
     * obtained. Used only when the payment method is 'paypal'
     *
     * @param string $paymentId id of a previously created
     *        payment that has its payment method set to 'paypal'
     *        and has been approved by the buyer.
     *
     * @param string $payerId PayerId as returned by PayPal post
     *        buyer approval.
     */
    public function executePayment($paymentId, $payerId)
    {
        $payment          = Payment::get($paymentId, $this->getApiContext());
        $paymentExecution = new PaymentExecution();
        $paymentExecution->setPayerId($payerId);
        $payment = $payment->execute($paymentExecution, $this->getApiContext());

        return $payment;
    }

}