<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {

            if ($message == 'hi') {
                $this->askName($botman);
            }

            else{
                $botman->reply("Mulai chat dengan hi.");
            }

        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hallo! siapa nama mu?', function(Answer $answer, $conversation) {

            $name = $answer->getText();

            $this->say('Hallo '.$name);

            $conversation->ask('apakah anda bisa menuliskan email anda', function(Answer $answer, $conversation){
                $email =$answer->getText();
                $this->say('Email : '.$email);
                $conversation->ask('Konfirmasi apakah ini benar email anda. balas pesan ini dengan iya atau tidak' ,function(Answer$answer, $conversation){
                    $confirmEmail = $answer->getText();
                    if ($answer == 'iya' || $answer == 'Iya'){
                        $this->say("Terimakasih sudah mengkonfirmasi Email anda.");
                    }
                });
            });

        });
    }
}
