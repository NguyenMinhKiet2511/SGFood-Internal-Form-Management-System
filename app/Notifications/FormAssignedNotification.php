<?php

namespace App\Notifications;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class FormAssignedNotification extends Notification
{
    use Queueable;

    protected $form;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Form $form, $user)
    {
        $this->form = $form;
        $this->user = $user;
    }

    /**
     * Determine which channels the notification is sent on.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'form_id' => $this->form->id,
            'form_number' => $this->form->form_number,
            'assigned_by' => Auth::user()->name,
            'message' => 'You have been assigned a new form to approve.',
            'url' => $this->generateFormUrl($this->user->role),
        ];
    }

    /**
     * Define the mail notification content.
     */
    public function toMail($notifiable)
    {
        $role = $this->user->role;
        $url = url("/{$role}/forms/" . $this->form->id);

        return (new MailMessage)
            ->subject('🔔 New Form Assigned: ' . $this->form->form_number)
            ->view('mail.mail', [
                'form' => $this->form,
                'user' => $this->user,
                'url' => $url
            ]);
    }

    /**
     * Generate URL based on user's role.
     */
    protected function generateFormUrl($role)
    {
        switch ($role) {
            case 'manager':
                return route('manager.forms.show', $this->form->id);
            case 'director':
                return route('director.forms.show', $this->form->id);
            default:
                return route('home.index');
        }
    }

    /**
     * Optionally define array representation (for database).
     */
    public function toArray($notifiable)
    {
        return [
            'form_id' => $this->form->id,
            'form_number' => $this->form->form_number,
            'message' => 'You have been assigned a new form.'
        ];
    }

    
}