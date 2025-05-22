<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupperAdminPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('event.masterpro2024@gmail.com')
            ->subject('Your Password Has Been Reset')
            ->view('emails.Sadmin_password_reset')
            ->with([
                'name' => $this->name,
                'password' => $this->password,
            ]);
    }
}
