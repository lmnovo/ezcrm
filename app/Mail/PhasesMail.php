<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PhasesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $phase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($phase)
    {
        $this->phase = $phase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        dd($this->phase);

        return $this->view('email.template', [
            'mensaje' => $this->phase,
        ]);
    }
}
