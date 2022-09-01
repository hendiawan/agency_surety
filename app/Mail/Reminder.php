<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
class Reminder extends Mailable
{
    use Queueable, SerializesModels;
    public $input;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->input = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
   
//     dd($this->input['status']);
        if($this->input['status']=='P'||$this->input['status']=='I'||$this->input['status']=='K'){
            return $this->view('mail.reminder')
                    ->subject('Notifikasi Pengajuan Surety Bond !!')
                    ->with('data',$this->input);
        }else   if($this->input['status']=='C'){
//               dd($this->input['status']);
           return $this->view('mail.reminderDireksi')
                    ->subject('Notifikasi Penerbitan Sertifikat Nomor : '.$this->input['no_jaminan'].' Oleh '.Auth::user()->name)
                    ->with('data',$this->input);  
        } else{            
            return $this->view('mail.reminderstaff')
                    ->subject('Notifikasi Pengajuan Surety Bond !!!')
                    ->with('data',$this->input);
        }
    }
    
    
}
