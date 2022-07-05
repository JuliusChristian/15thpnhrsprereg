<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ConfirmRegistration;
use \App\Visitor;
use \App\Event;
use Validator;
use Auth;
use Session;
use Input;
use Mail;

class emailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Registration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(\App\VWVisitor $visitor, \App\Event $event)
    {
        parent::__construct();

        $this->visitor = $visitor;
        $this->event = $event;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $visitors = Visitor::whereIn('email', [0])->get(); 

        $event = Event::where('event_active', 1)->first();

        if (!$event){
            $msg = 'No active events are taking place.';
            Session::put('errmsg', $msg);
            return view('prereg.noevent')->with(['msg' => $msg]);
        }

        foreach($visitors as $visitor){

            $barcode = $visitor->vis_code;

            try{

                Mail::to($visitor->vis_email)->bcc('jrcambonga@pchrd.dost.gov.ph')->send(new ConfirmRegistration($visitor, $event));

                 // Mail::send('prereg.registrationmail', compact('visitor', 'event', 'barcode'), function($message){
                 //    $message->to('jrcambonga@pchrd.dost.gov.ph');
                 // });

                $visitor->update(['email' => 1]);

            } catch(Exception $e){

            }
        }

       
    }
}
