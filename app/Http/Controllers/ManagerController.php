<?php

namespace App\Http\Controllers;

use App\Models\ApproveForm;
use App\Models\Form;
use App\Notifications\FormAssignedNotification;
use App\Notifications\FormStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    /**
     * Hiển thị danh sách các phiếu gửi đến manager đang đăng nhập.
     */
    public function index()
    {
        $managerId = Auth::id(); // Lấy ID của manager đang đăng nhập

        // Lọc các form mà manager này có trong bảng approve_forms
        $forms = Form::whereHas('approveForms', function ($q) use ($managerId) {
                        $q->where('manager_id', $managerId);
                    })
                    // Ưu tiên hiển thị phiếu chưa duyệt ở trên
                    ->orderByRaw("FIELD(status, 'pending', 'denied', 'approved')")
                    ->orderBy('date_created', 'desc') // Mới nhất trước
                    ->get();

        return view('manager.index', compact('forms'));
    }

    /**
     * Xử lý hành động duyệt phiếu (approve)
     */
    public function approve(Request $request, Form $form)
    {
        //  Kiểm tra xem manager này có quyền duyệt form không
        $approve = $form->approveForms()
                        ->where('manager_id', Auth::id())
                        ->where('role','manager')
                        ->firstOrFail();

        // Nếu không có quyền hoặc form không còn ở trạng thái chờ
        if (!$approve || $form->status !== 'pending') {
            abort(403, 'Access Denied.');
        }

        //  Cập nhật trạng thái phiếu chính thành "approved"
        $form->update(['status' => 'approved']);

        //  Cập nhật tất cả bản ghi approve_forms liên quan thành "approved"
        ApproveForm::where('form_id', $form->id)
            ->update([
                'status' => 'approved',
                'note' => $request->note ?? null, // nếu có note thì lưu
            ]);

        // 🔍 Kiểm tra xem tất cả các manager đã duyệt chưa
        $allManagersApproved = $form->approveForms()
            ->where('role', 'manager')
            ->where('status', '!=', 'approved')
            ->doesntExist();

        if ($allManagersApproved) {
            // 👉 Nếu tất cả manager đã duyệt, bật trạng thái "pending" cho director
            $form->approveForms()
                ->where('role', 'director')
                ->update(['status' => 'pending']);

            // Cập nhật trạng thái form là approved để tiếp tục quy trình
            $form->status = 'approved';
            $form->save();
        }

        // 📩 Gửi mail thông báo cho tất cả director khi đến lượt duyệt
        $directors = $form->approveForms()
            ->where('role', 'director')
            ->get();

        foreach ($directors as $approve) {
            $approve->manager->notify(new FormAssignedNotification($form, $approve->manager));
        }



        return back()->with('success', 'Form approved.');
    }

    /**
     * Xử lý hành động từ chối phiếu (deny)
     */
    public function deny(Request $request, Form $form)
    {
        // 🔒 Kiểm tra quyền của manager trước khi từ chối
        $approve = $form->approveForms()
                        ->where('manager_id', Auth::id())
                        ->where('role', 'manager')
                        ->firstOrFail();

        if (!$approve || $form->status !== 'pending') {
            abort(403, 'Access Denied.');
        }

        //  Cập nhật form và approve_forms thành trạng thái "denied"
        $form->update(['status' => 'denied']);

        ApproveForm::where('form_id', $form->id)
            ->update([
                'status' => 'denied',
                'note' => $request->note, // bắt buộc có lý do khi từ chối
            ]);

        $form->status = 'denied';
        $form->save();




        return back()->with('error', 'Form denied.');
    }

    /**
     * Hiển thị chi tiết phiếu cho manager xem
     */
    public function show(Form $form)
    {
        //  Chỉ cho phép xem nếu manager cùng phòng ban với người tạo phiếu
        if($form->department !== Auth::user()->department){
            abort(403, 'Access Denied.');
        }

        // Đánh dấu thông báo là đã đọc
        foreach (Auth::user()->unreadNotifications as $notification) {
            if ($notification->data['form_id'] == $form->id) {
                $notification->markAsRead(); // đánh dấu là đã đọc
            }
        }

        return view('manager.show', compact('form'));
    }

    /**
     * Hàm phụ để xác thực quyền truy cập dựa trên phòng ban (dùng lại được nhiều lần)
     */
    protected function authorizeAction(Form $form)
    {
        if ($form->department !== Auth::user()->department) {
            abort(403, 'Access Denied.');
        }
    }
}
