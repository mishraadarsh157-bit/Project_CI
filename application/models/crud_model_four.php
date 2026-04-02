<?php

class crud_model_four extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function getAll($table1, $table2, $table3, $search, $field, $order, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, 'ClientAbn=client_id ', 'inner');
        $this->db->group_start();
        $this->db->like('client_name', $search);
        $this->db->or_like('client_email', $search);
        $this->db->or_like('phone', $search);
        $this->db->group_end();
        $this->db->order_by($field, $order);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        if ($query) {

            return $query->result();
        } else {
            return 0;
        }
    }

    public function data($table, $field, $value)
    {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->like($field, $value);
        $query = $this->db->get();
        if ($query) {

            return $query->result();
        } else {
            return 0;
        }
    }
    public function itemName($value)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->like('item_name', $value);
        // $this->db->limit(10); // good for autocomplete

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // return $query;
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function itemData($name)
    {
        return $this->db->where('item_name', $name)
            ->get('items')
            ->row();
    }

    public function generateNo()
    {

        $this->db->select('InvoiceNo');
        $this->db->order_by('InvoiceNo', 'Desc');
        $this->db->limit(1);
        $this->db->from('invoice');
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function insertInvoice($invoiceData, $items, $quantity)
    {

        $this->db->trans_begin();

        $this->db->insert('invoice', $invoiceData);

        $invoice_id = $this->db->insert_id();
        for ($i = 0; $i < count($items); $i++) {

            $itemData = [
                'InvoiceNo' => $invoice_id,
                'ItemNo'    => $items[$i],
                'Quantity'   => $quantity[$i]
            ];

            $this->db->insert('invoiceitem', $itemData);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }



    public function updForm($id)
    {
        $this->db->where('invoice.InvoiceNo', $id);
        $this->db->from('client');
        $this->db->join('invoice', 'ClientAbn=client_id', 'left');
        $this->db->join('invoiceitem', 'InvoiceNo', 'left');
        $this->db->join('items', 'ItemNo=item_id', 'left');
        $query = $this->db->get();
        if ($query) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    ////////////////////////////
    public function UpdateInvoice($id, $items, $quantity)
    {

        $this->db->trans_begin();
        $this->db->where("InvoiceNo", $id);
        $upd = $this->db->delete("invoiceitem");
        if ($upd) {

            for ($i = 0; $i < count($items); $i++) {

                $itemData = [
                    'InvoiceNo' => $id,
                    'ItemNo'    => $items[$i],
                    'Quantity'   => $quantity[$i]
                ];

                $this->db->insert('invoiceitem', $itemData);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    public function mailForm($id)
    {
        $this->db->where('InvoiceNo', $id);
        $this->db->from('invoice');
        $this->db->join('client', 'client_id=ClientAbn', 'left');
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return 0;
        }
    }
}
