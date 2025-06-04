<?php

namespace App\Mail;

use App\Models\Jadwal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;

    public function __construct(Jadwal $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function build()
    {
        return $this->markdown('emails.jadwal-notification')
                    ->subject('Pengingat Jadwal - ' . $this->jadwal->keterangan);
    }
}