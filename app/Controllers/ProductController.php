<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{

    public function __construct()
    {
        helper('form');
        $this->session = \Config\Services::session();
    }


    public function product()
    {
        $data = [];
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        $productModel = new ProductModel();

        $data['title'] = "Product";
        $data['product'] = $productModel
            ->join('category', 'category.id = product.category_id', 'left')
            ->select('product.*, category.name as category') // You can select specific columns
            ->findAll();
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'date' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $image = $this->request->getFile('image');

                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move('uploads', $newName);
                } else {
                    // Handle the case where the file upload failed
                    // You can log an error, display an error message, etc.
                }
                $newData = array(
                    'category_id' => $this->request->getVar('category_id'),
                    'name' => $this->request->getVar('name'),
                    'image' => $newName,
                    'date' => $this->request->getVar('date'),
                );

                if ($productModel->insert($newData)) {
                    $message = ['class' => 'primary mt-3', 'message' => 'Product insert successfully'];
                    $this->session->setFlashdata('Flash_message', $message);
                    return redirect()->to('/product');
                } else {
                    $message = ['class' => 'danger mt-3', 'message' => 'Product not inserted'];
                    $this->session->setFlashdata('Flash_message', $message);
                    return redirect()->to('/product');
                }
            }
        }

        return view('product', $data);
    }

    public function deleteproduct($id)
    {
        $model = new ProductModel();
        if ($model->where('id', $id)->delete()) {
            $message = ['class' => 'primary mt-3', 'message' => 'Product deleted successfully'];
            $this->session->setFlashdata('Flash_message', $message);
            return redirect()->to('/product');
        } else {
            $message = ['class' => 'danger mt-3', 'message' => 'Product not deleted '];
            $this->session->setFlashdata('Flash_message', $message);
            return redirect()->to('/product');
        }
    }


    public function editproduct($id)
    {
        $data = array();
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        $productModel = new ProductModel();
        $data['title'] = " Edit Product";
        $data['product'] = $productModel
            ->join('category', 'category.id = product.category_id', 'left')
            ->select('product.*, category.name as category') // You can select specific columns
            ->findAll();
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'date' => 'required'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $image = $this->request->getFile('image');

                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move('uploads', $newName);

                    $newData = array(
                        'category_id' => $this->request->getVar('category_id'),
                        'name' => $this->request->getVar('name'),
                        'image' => $newName,
                        'date' => $this->request->getVar('date'),

                    );
                } else {
                    $newData = array(
                        'category_id' => $this->request->getVar('category_id'),
                        'name' => $this->request->getVar('name'),
                        'date' => $this->request->getVar('date'),
                    );
                }



                if ($productModel->update($id, $newData)) {
                    $message = ['class' => 'primary mt-3', 'message' => 'Product updated successfully'];
                    $this->session->setFlashdata('Flash_message', $message);
                    return redirect()->to('/product');
                } else {
                    $message = ['class' => 'danger mt-3', 'message' => 'Product not updated'];
                    $this->session->setFlashdata('Flash_message', $message);
                    return redirect()->to('/product');
                }
            }
        }

        $data['editproduct'] = $productModel->where('id', $id)->first();

        return view('product', $data);
    }
    public function report()
    {
        $data = array();
        $data['title'] = " Report";

        return view('report', $data);

    }

    public function getlist()
    {
        $db = \Config\Database::connect();

        $request = service('request');
        $draw = $request->getPost('draw');
        $start = $request->getPost('start');
        $rowperpage = $request->getPost('length');
        // Searching coding
        $columnIndex = $request->getPost('order')[0]['column']; // Column index
        $searchValue = $request->getPost('search')['value']; // Search value
        $status_id = $request->getPost('filterstatus');
        $todate = $request->getPost('todate');
        $fromdate = $request->getPost('fromdate');

        # Search
        $searchQuery = "";
        if (!empty($searchValue)) {
            $searchQuery = " (category.name like '%" . $searchValue . "%'  or product.name like '%" . $searchValue . "%'   or image like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $query = $db->table('product')
            ->selectCount('* as allcount');
        $totalRecords = $query->get()->getRow()->allcount;

        ## Total number of records with filtering
        $query = $db->table('product')
            ->select('product.*, category.name as category')
            ->join('category', 'category.id = product.category_id', 'left');

        if (!empty($searchQuery)) {
            $query->where($searchQuery);
        }
        if (!empty($status_id)) {
            $query->where('product.status', $status_id);
        }
        if (!empty($fromdate)) {
            $query->where('DATE(product.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $query->where('DATE(product.date) <=', $todate);
        }

        $records = $query->get();
        $totalRecordwithFilter = $records->getNumRows();

        ## Fetch records
        $query = $db->table('product')
            ->select('product.*, category.name as category')
            ->join('category', 'category.id = product.category_id', 'left');

        if (!empty($searchQuery)) {
            $query->where($searchQuery);
        }
        if (!empty($status_id)) {
            $query->where('product.status', $status_id);
        }
        if (!empty($fromdate)) {
            $query->where('DATE(product.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $query->where('DATE(product.date) <=', $todate);
        }

        $query->limit($rowperpage, $start)
            ->orderBy('id', 'desc');

        $records = $query->get()->getResult();

        $data = array();
        $i = $start + 1;
        foreach ($records as $record) {
            $action = '
            <a href="' . base_url() . '/editproduct/' . $record->id . '" class="btn btn-primary">
                <!-- Your SVG code here -->
            </a>
            <a href="' . base_url() . '/deleteproduct/' . $record->id . '" class="btn btn-danger" id="delete">
                <!-- Your SVG code here -->
            </a>
        ';

            $data[] = array(
                'id' => $i,
                'action' => $action,
                'date' => $record->date,
                'category' => $record->category,
                'name' => $record->name,
                'image' => $record->image,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
            );
            $i = $i + 1;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
        );
        // print_r($response);
        // exit;
        echo json_encode($response);
        exit();
    }




}
