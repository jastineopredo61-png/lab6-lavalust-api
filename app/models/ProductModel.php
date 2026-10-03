<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_products()
    {
        return $this->db->table($this->table)->order_by('id', 'DESC')->get_all();
    }

    public function get_by_id($id)
    {
        $row = $this->db->table($this->table)->where('id', $id)->get();
        return $row ? $row : null;
    }

    public function create_product($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_product($id, $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete_product($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}