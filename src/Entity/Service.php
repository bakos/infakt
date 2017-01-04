<?php
namespace kiczek\infakt\Entity;

class Service extends Entity
{
    protected $object = null;

    public $name;
    public $tax_symbol;
    public $unit;
    public $quantity;
    public $unit_net_price;
    public $net_price;
    public $gross_price;
    public $tax_price;
    public $symbol;
    public $flat_rate_tax_symbol;
    public $discount;
    public $unit_net_price_before_discount;
}