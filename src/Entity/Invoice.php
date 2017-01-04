<?php
namespace kiczek\infakt\Entity;

class Invoice extends Entity
{
    protected $object = 'invoice';

    public $id;
    public $number;
    public $currency;
    public $paid_price;
    public $notes;
    public $kind;
    public $payment_method;
    public $recipient_signature;
    public $seller_signature;
    public $invoice_date;
    public $sale_date;
    public $status;
    public $payment_date;
    public $net_price;
    public $tax_price;
    public $gross_price;
    public $client_id;
    public $client_company_name;
    public $client_street;
    public $client_city;
    public $client_post_code;
    public $client_tax_code;
    public $clean_client_nip;
    public $client_country;
    public $check_duplicate_number;
    public $bank_name;
    public $bank_account;
    public $swift;
    public $sale_type;
    public $invoice_date_kind;
    public $services;
    public $vat_exemption_reason;
}