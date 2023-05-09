<?php
  
namespace App\Notifications;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class RdvPatient extends Mailable
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
        return $this->subject('Rendez-vous patient')
                    ->from('omar.chaari.2021@gmail.com', 'Plateforme médicale')
                    ->view('emails.rdv-patient');
    }
}
