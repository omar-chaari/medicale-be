<?php
  
namespace App\Notifications;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class SignalerPatient extends Mailable
{
    use Queueable, SerializesModels;
  
    public $details;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       // $details=$this->details;
       //,compact('details')
        return $this->subject('Rappel de Rendez-vous')
                    ->from('omar.chaari.2021@gmail.com', 'Plateforme médicale')
                    ->view('emails.rappel-rdv');
    }
}
