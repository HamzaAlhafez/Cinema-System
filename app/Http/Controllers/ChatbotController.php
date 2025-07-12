<?php


namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Models\Movie;
use App\Models\Show;
use App\Models\Hall;
use App\Models\Ticket;
use App\Models\SeatReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chatbot requests
     */
    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
    
        $botman = app('botman');
        
        // رد على كلمة "hi" بعرض أسماء الأفلام
        $botman->hears('Available Movies', function($bot) {
            // جلب أسماء الأفلام من قاعدة البيانات
            $movies = Movie::pluck('title')->toArray();
            
            if (empty($movies)) {
                $bot->reply('Sorry, no movies available at the moment.');
                return;
            }
            
            // بناء رسالة بسيطة بأسماء الأفلام
            $message = "🎬 Available Movies:\n";
            $message .= implode("\n", $movies);
            
            $bot->reply($message);
        });
        
        $botman->listen();
    }
    public function iframe()
    {
        return view('botman.iframe');
    }
    
}
