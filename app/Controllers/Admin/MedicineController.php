<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Medicine;

class MedicineController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'QuanTri') {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $medicineModel = new Medicine();
        $medicines = $medicineModel->findAll('TenThuoc');

        $this->render('admin/medicines/index', [
            'title' => 'Quản lý Thuốc',
            'medicines' => $medicines
        ], 'admin');
    }

    public function create()
    {
        $this->render('admin/medicines/create', ['title' => 'Thêm Thuốc mới'], 'admin');
    }

    public function store()
    {
        $medicineModel = new Medicine();
        $medicineModel->create([
            'TenThuoc' => $_POST['TenThuoc'],
            'HoatChat' => $_POST['HoatChat'],
            'DonViTinh' => $_POST['DonViTinh']
        ]);

        $_SESSION['success_message'] = 'Thêm thuốc thành công!';
        $this->redirect('/admin/medicines');
    }

    public function edit(int $id)
    {
        $medicineModel = new Medicine();
        $medicine = $medicineModel->find($id);

        if (!$medicine) {
            die('Không tìm thấy thuốc.');
        }

        $this->render('admin/medicines/edit', [
            'title' => 'Chỉnh sửa Thuốc',
            'medicine' => $medicine
        ], 'admin');
    }

    public function update(int $id)
    {
        $medicineModel = new Medicine();
        $medicineModel->update($id, [
            'TenThuoc' => $_POST['TenThuoc'],
            'HoatChat' => $_POST['HoatChat'],
            'DonViTinh' => $_POST['DonViTinh']
        ]);

        $_SESSION['success_message'] = 'Cập nhật thuốc thành công!';
        $this->redirect('/admin/medicines');
    }

    public function destroy(int $id)
    {
        $medicineModel = new Medicine();
        $medicineModel->delete($id);

        $_SESSION['success_message'] = 'Xóa thuốc thành công!';
        $this->redirect('/admin/medicines');
    }
}