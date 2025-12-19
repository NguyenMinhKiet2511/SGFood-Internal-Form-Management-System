<?php

namespace App\Http\Controllers;

use App\Events\NewFormCreated;
use App\Models\ApproveForm;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\FormAssignedNotification;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Lấy manager thuộc cùng phòng ban
        $managers = User::where('role', 'manager')
            ->where('department', $user->department)
            ->get();

        $directors = User::where('role', 'director')
            ->where('department', $user->department)
            ->get();

        

        return view('user.form.create', compact('managers','directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate Input
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required',
            'factory' => 'required',
            'content' => 'required',
            'priority_level' =>'required',  
            'processing_department' => 'required',
            'completion_date' => 'required|date',
            'manager_id' => 'required|exists:users,id',
            'director_id' => 'required|exists:users,id',
        ]);

        //Create Form
        $form = Form::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'department' => $request->department,
            'factory' => $request->factory,
            'content' => $request->content,
            'damage_description' => $request->damage_description,
            'priority_level' => $request->priority_level,
            'processing_department' => $request->processing_department,
            'completion_date' => $request->completion_date,
            'date_created' => now(),
        ]);
        
        //Create Form Number
        $form->form_number = 'FM-' . now()->format('Ymd') . '-' . str_pad($form->id, 4, '0', STR_PAD_LEFT);
        $form->save();

        //Send to selected manager
        $manager = User::find($request->manager_id);
        ApproveForm::create([
            'form_id' => $form->id,
            'manager_id' => $manager->id,
            'role' => 'manager',
            'status' => 'pending',
        ]);



        


        $director = User::find($request->director_id);
        ApproveForm::create([
            'form_id' => $form->id,
            'manager_id' => $director->id,
            'role' => 'director',
            'status' => 'waiting',
        ]);


        
        $manager = User::where('department', Auth::user()->department)
                    ->where('role', 'manager')
                    ->first();


        //  Load lại quan hệ trước khi gửi event
        $form->load('approveForms');

        //  Gửi thông báo
        $manager->notify(new FormAssignedNotification($form, $manager));

        

        return redirect()->route('user.index')->with('success', 'Form created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        if ($form->user_id !== Auth::id()) {
            abort(403, 'Access Denied');
        }

        $form->load('approveForms.manager');

        // Nếu chưa có approveForms → tránh lỗi
        if ($form->approveForms->isEmpty()) {
            return redirect()->route('user.index')->with('error', 'Form data is still loading. Please try again.');
        }

        // Đánh dấu thông báo là đã đọc
        foreach (Auth::user()->unreadNotifications as $notification) {
            if ($notification->data['form_id'] == $form->id) {
                $notification->markAsRead(); // đánh dấu là đã đọc
            }
        }

        return view('user.form.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('user.index');
    }
}
