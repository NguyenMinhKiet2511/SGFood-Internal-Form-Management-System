<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessingForm;
use App\Models\User;
use App\Notifications\FormAssignedNotification;
use App\Notifications\FormProcessingNotification;
use App\Notifications\FormStatusUpdatedNotification;

class DirectorController extends Controller
{
    /**
     * Hiển thị danh sách các phiếu đã được gửi đến director.
     * Chỉ hiển thị khi:
     * - Phiếu đó có bản ghi trong bảng approve_forms dành cho director
     * - Tất cả manager đã duyệt (không còn ai pending hoặc denied)
     */
    public function index()
    {
        $directorId = Auth::id(); // ID của director đang đăng nhập

        $forms = Form::whereHas('approveForms', function ($q) use ($directorId) {
                // Kiểm tra nếu phiếu được gán cho director hiện tại
                $q->where('manager_id', $directorId)
                  ->where('role', 'director');
            })
            // Chỉ lấy các form mà tất cả manager đã duyệt (loại bỏ form còn pending/denied)
            ->whereDoesntHave('approveForms', function ($q) {
                $q->where('role', 'manager')
                  ->where(function ($subQ) {
                      $subQ->where('status', 'pending')
                           ->orWhere('status', 'denied');
                  });
            })
            // Ưu tiên phiếu chưa duyệt lên đầu
            ->orderByRaw("FIELD(status, 'pending', 'denied', 'approved', 'done')")
            ->orderBy('date_created', 'desc')
            ->get();

        return view('director.index', compact('forms'));
    }

    /**
     * Director duyệt phiếu
     */
    public function approve(Form $form)
    {
        // Lấy bản ghi approve_forms tương ứng với director hiện tại
        $approval = $form->approveForms()
            ->where('manager_id', Auth::id())
            ->where('role', 'director')
            ->firstOrFail();

        // Cập nhật trạng thái của approve_forms thành "approved"
        $approval->update([
            'status' => 'approved',
        ]);

        // Kiểm tra nếu tất cả director đã duyệt
        $allApproved = $form->approveForms()
            ->where('role', 'director')
            ->where('status', '!=', 'approved')
            ->doesntExist();

        if ($allApproved) {
            // ✅ Nếu tất cả director đã duyệt, cập nhật form thành "approved"
            $form->update(['status' => 'approved']);
            $form->status = 'approved';
            $form->save();
        }


        // 👉 Gửi form cho các user thuộc phòng ban xử lý
        $processingUsers = User::where('department', $form->processing_department)
                            ->where('role', 'user')
                            ->get();

        foreach ($processingUsers as $user) {
        ProcessingForm::create([
            'form_id' => $form->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
        }

        return back()->with('success', 'Form approved by director.');
    }

    /**
     * Director từ chối phiếu
     */
    public function deny(Request $request, Form $form)
    {
        // Bắt buộc nhập lý do từ chối
        $request->validate([
            'note' => 'required|string'
        ]);

        // Lấy bản ghi tương ứng trong bảng approve_forms
        $approval = $form->approveForms()
            ->where('manager_id', Auth::id())
            ->where('role', 'director')
            ->firstOrFail();

        // Cập nhật trạng thái và lý do từ chối
        $approval->update([
            'status' => 'denied',
            'note' => $request->note
        ]);

        // Nếu director từ chối thì form cũng bị từ chối
        $form->update(['status' => 'denied']);
        $form->status = 'denied';
        $form->save();

        return back()->with('error', 'Form denied by director.');
    }

    /**
     * Xem chi tiết form mà director có quyền duyệt
     */
    public function show(Form $form)
    {
        $authId = Auth::id();

        // Kiểm tra nếu director hiện tại thực sự được gán form này
        $hasAccess = $form->approveForms()
                        ->where('manager_id', $authId)
                        ->where('role', 'director')
                        ->exists();

        if (!$hasAccess) {
            abort(403, 'You are not allowed to view this form.');
        }

        // Đánh dấu thông báo là đã đọc
        foreach (Auth::user()->unreadNotifications as $notification) {
            if ($notification->data['form_id'] == $form->id) {
                $notification->markAsRead(); // đánh dấu là đã đọc
            }
        }

        return view('director.show', compact('form'));
    }
}

