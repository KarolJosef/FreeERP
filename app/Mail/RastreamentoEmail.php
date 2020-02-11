<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RastreamentoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tabela;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dado)
    {
        $this->tabela = $dado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('karoljozef123@hotmail.com')
                ->subject('Rastreamento de objeto atualizado')
                ->view('email.rastreio');
    }
}
