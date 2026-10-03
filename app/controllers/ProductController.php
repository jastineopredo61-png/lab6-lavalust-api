<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('database');
        $this->call->library('api');
        $this->call->model('ProductModel', 'productmodel');

        // every product route requires a valid access token
        $this->api->require_jwt();
    }

    // GET /products
    public function index()
    {
        return $this->api->respond($this->productmodel->get_all_products() ?: [], 200);
    }

    // GET /products/{id}
    public function show($id)
    {
        $product = $this->productmodel->get_by_id($id);
        if (!$product) {
            return $this->api->respond_error('Product not found', 404);
        }
        return $this->api->respond($product, 200);
    }

    // POST /products
    public function store()
    {
        $body = $this->api->body();

        if (empty($body['product_name']) || !isset($body['price']) || !isset($body['quantity'])) {
            return $this->api->respond_error('product_name, price, and quantity are required', 422);
        }

        $this->productmodel->create_product([
            'product_name' => $body['product_name'],
            'description'  => $body['description'] ?? '',
            'price'        => $body['price'],
            'quantity'     => $body['quantity'],
        ]);

        return $this->api->respond(['message' => 'Product created'], 201);
    }

    // PUT/PATCH /products/{id}
    public function update($id)
    {
        if (!$this->productmodel->get_by_id($id)) {
            return $this->api->respond_error('Product not found', 404);
        }

        $body = $this->api->body();
        $data = [];
        foreach (['product_name', 'description', 'price', 'quantity'] as $field) {
            if (isset($body[$field])) {
                $data[$field] = $body[$field];
            }
        }

        if (empty($data)) {
            return $this->api->respond_error('Nothing to update', 422);
        }

        $this->productmodel->update_product($id, $data);
        return $this->api->respond(['message' => 'Product updated'], 200);
    }

    // DELETE /products/{id}
    public function destroy($id)
    {
        if (!$this->productmodel->get_by_id($id)) {
            return $this->api->respond_error('Product not found', 404);
        }

        $this->productmodel->delete_product($id);
        return $this->api->respond(['message' => 'Product deleted'], 200);
    }
}
