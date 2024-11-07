<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\RESTful\ResourceController;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('categories/index', $data);
    }

    public function new()
    {
        return view('categories/create');
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            if ($this->categoryModel->save($this->request->getPost())) {
                return redirect()->to('/categories')->with('message', 'Categoría creada exitosamente');
            } else {
                return redirect()->back()
                    ->with('errors', $this->categoryModel->errors())
                    ->withInput();
            }
        }
    }

    public function edit($id = null)
    {
        $data = [
            'category' => $this->categoryModel->find($id)
        ];
        
        if (empty($data['category'])) {
            return redirect()->to('/categories')->with('error', 'Categoría no encontrada');
        }

        return view('categories/edit', $data);
    }

    public function update($id = null)
    {
        if ($this->request->getMethod() === 'POST') {
            if ($this->categoryModel->update($id, $this->request->getPost())) {
                return redirect()->to('/categories')->with('message', 'Categoría actualizada exitosamente');
            } else {
                return redirect()->back()
                    ->with('errors', $this->categoryModel->errors())
                    ->withInput();
            }
        }
    }

    public function delete($id = null)
    {
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/categories')->with('message', 'Categoría eliminada exitosamente');
        }
        
        return redirect()->to('/categories')->with('error', 'No se pudo eliminar la categoría');
    }
}