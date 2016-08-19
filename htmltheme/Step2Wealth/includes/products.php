<?php

/**
 * Description of Products
 *
 * @author ASIF
 */
class Products extends isdk {

    public $contact_id;
    public $product_id;
    public $invoice_id;

    public function getContact_id() {
        return $this->contact_id;
    }

    public function getProduct_id() {
        return $this->product_id;
    }

    public function getInvoice_id() {
        return $this->invoice_id;
    }

    public function setContact_id($contact_id) {
        $this->contact_id = $contact_id;
    }

    public function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    public function setInvoice_id($invoice_id) {
        $this->invoice_id = $invoice_id;
    }

//------------------------------------------------------------------
    public function __construct() {
        if ($this->cfgCon("sv287")) {
            true;
        } else {
            false;
        }
    }

//end of __construct

    public function isDsQuery($tbl, array $query, array $returnFields) {
        $result_set = array();
        $results = array();
        $page = 0;
        while (true) {
            $results = $this->dsQuery($tbl, 1000, $page, $query, $returnFields);
            $result_set = array_merge($result_set, $results);
            if (count($results) < 1000) {
                break;
            }
            $page++;
        }
        return $result_set;
    }

    public function isDsQueryOrderBy($tbl, array $query, array $returnFields, $orderBy, $ascending) {
        $result_set = array();
        $results = array();
        $page = 0;
        while (true) {
            $results = $this->dsQueryOrderBy($tbl, 1000, $page, $query, $returnFields, $orderBy, $ascending);
            $result_set = array_merge($result_set, $results);
            if (count($results) < 1000) {
                break;
            }
            $page++;
        }
        return $result_set;
    }

    public function get_invoice() {
        $returnGroupFields = array('Id', 'InvoiceTotal', 'ProductSold');
        $query = array('ContactId' => $this->getContact_id());
        $Invoice = $this->isDsQuery('Invoice', $query, $returnGroupFields);
        return $Invoice;
    }

    public function SubscriptionPlan($productId) {
        $returnGroupFields = array('ProductId', 'Frequency', 'Cycle', 'PlanPrice', 'PreAuthorizeAmount');
        $query = array('ProductId' => $productId);
        $SubscriptionPlan = $this->isDsQuery('SubscriptionPlan', $query, $returnGroupFields);
        return $SubscriptionPlan;
    }

    public function get_product_detail() {
        $returnGroupFields = array('Id', 'ProductName', 'Sku', 'ProductPrice', 'Description');
        $query = array('Id' => '%', 'Sku' => '%#');
        $Product = $this->isDsQuery('Product', $query, $returnGroupFields);
        return $Product;
    }

    public function is_standard_license() {
        $query = array('ContactId' => $this->getContact_id(), 'ProductSold' => 7); //Affiliate Fee (Standard)
        $Invoice = $this->dsCount('Invoice', $query);
        return $Invoice;
    }

    public function is_premium_license() {
        $query = array('ContactId' => $this->getContact_id(), 'ProductSold' => 23); //Full License Rights (Premium)
        $Invoice = $this->dsCount('Invoice', $query);
        return $Invoice;
    }

    

}

//end of class
