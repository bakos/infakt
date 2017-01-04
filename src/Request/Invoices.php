<?php
namespace kiczek\infakt\Request;

use kiczek\infakt\Entity\Invoice;
use kiczek\infakt\Infakt;

class Invoices {
    const INVOICE_KIND_PROFORMA = "proforma";
    const INVOICE_KIND_VAT = "vat";

    const INVOICE_PRINT_TYPE_ORIGINAL_COPY = "original_copy";
    const INVOICE_PRINT_TYPE_ORIGINAL = "original";
    const INVOICE_PRINT_TYPE_COPY = "copy";
    const INVOICE_PRINT_TYPE_ORIGINAL_DUPLICATE = "original_duplicate";
    const INVOICE_PRINT_TYPE_COPY_DUPLICATE = "copy_duplicate";
    const INVOICE_PRINT_TYPE_DUPLICATE = "duplicate";
    const INVOICE_PRINT_TYPE_REGULAR = "regular";
    const INVOICE_PRINT_TYPE_DOUBLE_REGULAR = "double_regular";

    const INVOICE_LOCALE_PL = "pl";
    const INVOICE_LOCALE_EN = "en";
    const INVOICE_LOCALE_PL_EN = "pe";
    
    protected $api;

    public function __construct(Infakt $api)
    {
        $this->api = $api;
    }

    /**
     * Get invoice details.
     *
     * @param $id
     * @return Invoice
     */
    public function get($id)
    {
        return new Invoice($this->api->curl("/invoices/" . $id));
    }

    /**
     * Create new invoice.
     *
     * @param Invoice $client
     * @return Invoice
     */
    public function create(Invoice $invoice)
    {
        return new Invoice($this->api->curl("/invoices", Infakt::REQUEST_POST, $invoice->toArray()));
    }

    /**
     * Edit invoice.
     *
     * @param Invoice $client
     * @return Invoice
     */
    public function update(Invoice $invoice) {
        return new Invoice($this->api->curl("/invoices/" . $invoice->id, Infakt::REQUEST_PUT, $invoice->toArray()));
    }

    /**
     * Delete invoice.
     *
     * @param $id
     * @return bool
     */
    public function delete($id) {
        $this->api->curl("/invoices/" . $id, Infakt::REQUEST_DELETE);
        return true;
    }

    /**
     * Get invoice PDF.
     */
    public function getPDF($id, $documentType = self::INVOICE_PRINT_TYPE_ORIGINAL, $locale = self::INVOICE_LOCALE_PL) {
        $result = $this->api->curl("/invoices/" . $id . "/pdf", Infakt::REQUEST_GET, [], [
            "document_type" => $documentType,
            "locale" => $locale
        ]);

        return $result;
    }
}