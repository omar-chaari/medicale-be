<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
class rappelRdv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:rappel-rdv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command pour envoi email aux patients pour notification de rendez-vous à venir';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
     $this->signaler();
        return 0;
    }
    public function signaler()
    {
        

        $tomorrowStart = date("Y-m-d 00:00:00", strtotime('tomorrow'));

        $tomorrowEnd = date("Y-m-d 23:59:59", strtotime('tomorrow'));


        $list_appointement=$this->getTableListAppointement($tomorrowStart, $tomorrowEnd);
       
        $this->email($list_appointement);
    }
    function getTableListAppointement($tomorrowStart, $tomorrowEnd)
    {

        $users = DB::table('appointements')
            ->select(
                'date_debut',
                'users.first_name as pro_first_name',
                'users.last_name as pro_last_name',
                'users.address as  pro_address',
                'patients.address as  patient_address',
                'patients.first_name as patient_first_name',
                'patients.last_name as patient_last_name',
                'patients.email as patient_email',
               

            )
            ->leftJoin('users', 'users.id', '=', 'appointements.professional')

            ->leftJoin('patients', 'patients.id', '=', 'appointements.patient')

            ->where(function ($q) use ($tomorrowStart, $tomorrowEnd) {
                $q->where('appointements.state', '=', 1)
                    ->where('appointements.date_debut', '>=', $tomorrowStart)
                    ->where('appointements.date_debut', '<=', $tomorrowEnd);
            })
            ->get();

        return $users;
    }

   
    public function email($list_appointement)
    {


        foreach ($list_appointement as $data)
        {

            $details = [
                'date_debut' => date("d-m-Y H:i",strtotime($data->date_debut)),
                'pro_first_name' => $data->pro_first_name,
                'pro_last_name' => $data->pro_last_name,
                'pro_address' => $data->pro_address,
                'patient_address' => $data->patient_address,
                'patient_first_name' => $data->patient_first_name,
                'patient_last_name' => $data->patient_last_name,
            ];
    
            Mail::to($data->patient_email)->send(new \App\Notifications\SignalerPatient($details));

        }

        
    }
}
