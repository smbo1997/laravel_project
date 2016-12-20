<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use DateTime;
use App\UsersMessages;
class HappyBirthday extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a Happy birthday message to users via SMS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
//        $users = User::where(date('m/d'))->get();
        $newdate = new DateTime();
        $date = $newdate->format('m/d/Y');
        $birthday = DB::table('users')->select('*')->where('birthday', '!=', null)->get();


        foreach ($birthday as $user) {
            if ($user->birthday == $date) {
                $users_new = DB::table('users')->select('*')->where('birthday', '!=', null)->where('id', '<>', $user->id)->get();
                foreach ($users_new as $send_happy) {
                    UsersMessages::create([
                        'from_user' => $send_happy->id,
                        'to_user' => $user->id,
                        'content' => 'Happy birthday friend i wish you all of the best',
                        'delivered' => 0
                    ]);
                }
            }
        }


        $this->info('The happy birthday messages were sent successfully!');
    }

}
