<?php
namespace kiczek\infakt\Entity;

class Client extends Entity
{
    protected $object = 'client';

    public $id;
    public $company_name;
    public $street;
    public $city;
    public $country;
    public $postal_code;
    public $nip;
    public $clean_nip;
    public $phone_number;
    public $same_forward_address;
    public $web_site;
    public $email;
    public $note;
    public $receiver;
    public $mailing_company_name;
    public $mailing_street;
    public $mailing_city;
    public $mailing_postal_code;
    public $days_to_payment;
    public $invoice_note;
    public $payment_method;
}