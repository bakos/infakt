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
     * List invoices.
     *
     * @param $id
     * @return Invoice[]
     */
    public function list($from = null, $to = null)
    {
        $invoices = [];
        $params = ['offset' => 0, 'limit' => 100, 'q' => []];

        if (strtotime($from) > 0) {
            $params['q']['invoice_date_gteq'] = $from;
        }

        if (strtotime($to) > 0) {
            $params['q']['invoice_date_lteq'] = $to;
        }

        do {
            $result = $this->api->curl("/invoices", Infakt::REQUEST_GET, $params);
            foreach ($result['entities'] as $entity) {
                $invoices[] = new Invoice($entity);
            }
            $params['offset'] += 100;
        } while (!empty($result['metainfo']) && $result['metainfo']['total_count'] > $params['offset']);

        return $invoices;
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
     * Mark invoice paid
     *
     * @param $id
     * @param $paidDate
     * @return Invoice
     */
    public function paid($id, $paidDate) {
        $this->api->curl("/invoices/" . $id . "/paid", Infakt::REQUEST_POST, [
            'paid_date' => $paidDate
        ]);
        return true;
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