<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_username($username)
    {
        $row = $this->db->table($this->table)
                        ->where('username', $username)
                        ->get();

        return $row ? (object) $row : null;
    }

    public function get_by_id($id)
    {
        $row = $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();

        return $row ? (object) $row : null;
    }

    public function create($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
}