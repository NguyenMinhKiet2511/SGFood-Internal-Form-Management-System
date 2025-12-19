<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessingForm;
use App\Notifications\FormStatusUpdatedNotification;

class UserController extends Controller
{   
    // My Form Page
    public function index(){
        $forms = Form::where('user_id', Auth::id())->orderBy('form_number', 'ASC')->paginate(50);
        return view('user.index', compact('forms'));
        
    }
    // Login Page
    public function login(){
        return view('user.login');
    }

    //Check user login
    public function check_login(Request $request){
        request()->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $data= $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.index');

                case 'manager':
                    return redirect()->route('manager.index');
                case 'director':
                    return redirect()->route('director.index');

                case 'user':
                default:
                    return redirect()->route('user.assigned.forms');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }


    // Handle Assigned Form 
    public function assignedForms() {
        $forms = ProcessingForm::with('form')->where('user_id', Auth::id())->get();
        return view('user.assigned_form', compact('forms'));
    }

    public function acceptForm(Request $request, $id) {
        $pf = ProcessingForm::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Cập nhật tất cả processing form có cùng form_id
        ProcessingForm::where('form_id', $pf->form_id)->update(['status' => 'accepted']);

        $pf->form->update(['status' => 'accepted']);
        $pf->form->status = 'accepted';
        $pf->form->save();


        return back();
    }

    public function rejectForm(Request $request, $id) {
        $pf = ProcessingForm::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Cập nhật tất cả processing form
        ProcessingForm::where('form_id', $pf->form_id)->update([
            'status' => 'rejected',
            'note' => $request->note
        ]);
        $pf->form->update(['status' => 'rejected_byhandler']);
        $pf->form->status = 'rejected_byhandler';
        $pf->form->save();
        

        return back();
    }

    public function markDone($id) {
        $pf = ProcessingForm::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Cập nhật tất cả processing form
        ProcessingForm::where('form_id', $pf->form_id)->update(['status' => 'done']);
        $pf->form->update(['status' => 'done']);
        $pf->form->status = 'done';
        $pf->form->save();
    
        return back();
    }


    public function showAssigned(Form $form)
    {
        $userId = Auth::id();

        // Kiểm tra xem user này có phải là người được giao xử lý form đó không
        $isAssigned = ProcessingForm::where('form_id', $form->id)
                        ->where('user_id', $userId)
                        ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not authorized to view this form.');
        }

        $form->load('approveForms.manager'); // nạp cả người duyệt
        
        // Đánh dấu thông báo là đã đọc
        foreach (Auth::user()->unreadNotifications as $notification) {
            if ($notification->data['form_id'] == $form->id) {
                $notification->markAsRead(); // đánh dấu là đã đọc
            }
        }

        return view('user.assigned_form_show', compact('form'));
    }

    
}
