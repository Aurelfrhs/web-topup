<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // ==================== PAYMENTS MANAGEMENT ====================
    public function payments()
    {
        // Sementara return view kosong atau redirect
        return view('admin.payments.index');
    }

    public function createPayment()
    {
        return view('admin.payments.create');
    }

    public function storePayment(Request $request)
    {
        // Implementation nanti
        return back()->with('success', 'Payment method berhasil ditambahkan');
    }

    public function editPayment($id)
    {
        return view('admin.payments.edit');
    }

    public function updatePayment(Request $request, $id)
    {
        return back()->with('success', 'Payment method berhasil diupdate');
    }

    public function deletePayment($id)
    {
        return back()->with('success', 'Payment method berhasil dihapus');
    }
}
