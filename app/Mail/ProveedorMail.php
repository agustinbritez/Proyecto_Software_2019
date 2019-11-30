<?php

namespace App\Mail;

use App\Proveedor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProveedorMail extends Mailable
{
    use Queueable, SerializesModels;
    //asunto del MAIL
    public $subject = 'Orden de Compra';
    public  $proveedor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proveedor)
    {
        $this->proveedor = Proveedor::find($proveedor->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.proveedor');
    }
}
