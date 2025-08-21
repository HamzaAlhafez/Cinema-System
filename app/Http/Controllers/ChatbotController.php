<?php


namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\{Movie, Hall, Show, Ticket, Promocode, PurchasePromocode, SeatReservation, User};
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
    
        $botman = app('botman');
        
        $botman->hears('.*', function(BotMan $bot) {
            $bot->startConversation(new CinemaConversation());
        });
        
        $botman->listen();
    }
    
    public function iframe()
    {
        return view('botman.iframe');
    }
}

class CinemaConversation extends Conversation
{
    protected $user;
    protected $commands = [
        'hello' => ['hello', 'hi', 'hey'],
        'start' => ['start', 'begin'],
        'movies' => ['movies', 'shows'],
        'tickets' => ['tickets', 'my tickets'],
        'promos' => ['promo', 'promocode', 'promos'],
        'info' => ['info', 'cinema', 'معلومات'],
        'help' => ['help', 'support'],
        'thanks' => ['thank you', 'thanks'],
        'bye' => ['bye', 'goodbye'],
        'back' => ['back', 'go back']
    ];

    public function run()
    {
        $message = $this->bot->getMessage()->getText();
        
       
        if ($this->handleTextCommand($message)) {
            return;
        }
        
        $this->showWelcomeMessage();
    }

    private function handleTextCommand($message)
    {
        $message = strtolower(trim($message));
        
        foreach ($this->commands as $command => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $this->executeCommand($command);
                    return true;
                }
            }
        }
        
        return false;
    }
    
    private function executeCommand($command)
    {
        switch ($command) {
            case 'hello':
                $this->say("👋 Hello there! How can I help you today?");
                $this->showWelcomeMessage();
                
                break;
            case 'start':
                $this->showWelcomeMessage();
                break;
            case 'movies':
                $this->showMoviesOptions();
                break;
            case 'tickets':
                $this->showUserTickets();
                break;
            case 'promos':
                $this->showPromoOptions();
                break;
            case 'info':
                $this->showCinemaInfo();
                break;
            case 'help':
                $this->showHelp();
                break;
            case 'thanks':
                $this->say("😊 You're welcome! Let me know if you need anything else.");
                break;
            case 'bye':
                $this->say("🎬 Goodbye! Have a great day!");
                break;
            case 'back':
                $this->showWelcomeMessage();
                break;
            default:
            $this->say("Sorry, I didn't understand that. Please type 'start' to see the main menu.");
        }
    }

    private function showWelcomeMessage()
    {
        $this->say("🎬 Welcome to CineBot! Your personal cinema assistant.");


           $question = Question::create('What would you like to do today?')
            ->fallback('Unable to display options')
            ->callbackId('main_menu')
            ->addButtons([
                Button::create('🎥 Movies & Shows')->value('movies'),
                Button::create('🎟 My Tickets')->value('my_tickets'),
                Button::create('🏆 Promo Codes')->value('promos'),
                Button::create('ℹ️ Cinema Info')->value('info'),
                Button::create('🆘 Help')->value('help'),
            ]);

        $this->ask($question, function(Answer $answer) {
           
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            
            if ($answer->isInteractiveMessageReply()) {
                switch ($answer->getValue()) {
                    case 'movies':
                        $this->showMoviesOptions();
                        break;
                    case 'my_tickets':
                        $this->showUserTickets();
                        break;
                    case 'promos':
                        $this->showPromoOptions();
                        break;
                    case 'info':
                        $this->showCinemaInfo();
                        break;
                    case 'help':
                        $this->showHelp();
                        break;
                    default:
                        $this->repeat('Please select a valid option:');
                }
            }
        });
    }

    private function showMoviesOptions()
    {
        $question = Question::create('🎥 Movies Information')
            ->fallback('Unable to display movie options')
            ->callbackId('movie_options')
            ->addButtons([
                Button::create('Now Showing')->value('now_showing'),
                Button::create('Coming Soon')->value('coming_soon'),
                Button::create('Movie Details')->value('details'),
                Button::create('Show Times')->value('showtimes'),
                Button::create('↩️ Back')->value('back'),
            ]);

        $this->ask($question, function(Answer $answer) {
          
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            
            switch ($answer->getValue()) {
                case 'now_showing':
                    $this->showNowPlaying();
                    break;
                case 'coming_soon':
                    $this->showComingSoon();
                    break;
                case 'details':
                    $this->askForMovieDetails();
                    break;
                case 'showtimes':
                    $this->askForShowTimes();
                    break;
                case 'back':
                    $this->showWelcomeMessage();
                    break;
                default:
                    $this->repeat('Please select a valid option:');
            }
        });
    }
    
    private function showNowPlaying()
    {
        $shows = Show::where('date', '>=', now()->format('Y-m-d'))
               ->with(['movie' => function($query) {
                   $query->select('id', 'title', 'rating', 'language');
               }])
               ->orderBy('date')
               ->orderBy('start_time')
               ->get();

        if ($shows->isEmpty()) {
            $this->say("No shows are currently scheduled.");
            $this->showMoviesOptions();
            return;
        }

       
        $groupedShows = $shows->groupBy('movie_id');

        $message = "🎬 Now Showing\n\n";
        
        foreach ($groupedShows as $movieShows) {
            $movie = $movieShows->first()->movie;


          $message .= "• <b>{$movie->title}</b> (⭐️ {$movie->rating})\n";
            
            foreach ($movieShows as $show) {
                $showDate = Carbon::parse($show->date);
                $showTime = Carbon::parse($show->start_time)->format('g:i A');
                
                if ($showDate->isToday()) {
                    $dateText = "Today at {$showTime}";
                } elseif ($showDate->isTomorrow()) {
                    $dateText = "Tomorrow at {$showTime}";
                } else {
                    $dateText = $showDate->format('M j') . " at {$showTime}";
                }
                
                $message .= "  - {$dateText} (Hall: {$show->hall->hall_name}, 💰 {$show->price} $)\n";
            }
            $message .= "\n";
        }

        $this->say($message, ['parse' => 'HTML']);
        $this->showMoviesOptions();
    }
    private function showComingSoon()
{
    // الحصول على الأفلام التي ليس لها أي عروض مرتبطة بها
    $movies = Movie::whereDoesntHave('shows')
                 ->orderBy('production_date', 'asc')
                 ->get(['id', 'title', 'production_date']);

    if ($movies->isEmpty()) {
        $this->say("No upcoming movies without any scheduled shows found.");
        return $this->showMoviesOptions();
    }

    $message = "🍿 Coming Soon (No shows scheduled yet):\n\n";
    
    foreach ($movies as $movie) {
        $date = date('M d, Y', strtotime($movie->production_date));
        $message .= "• <b>{$movie->title}</b> (Release date: {$date})\n";
    }

    $this->say($message, ['parse' => 'HTML']);
    $this->showMoviesOptions();
}


    private function askForMovieDetails()
    {
        $movies = Movie::pluck('title')->toArray();
        
        if (empty($movies)) {
            $this->say("No movies available to show details.");
            $this->showMoviesOptions();
            return;
        }

        $question = Question::create('Which movie would you like details about?')
            ->fallback('Unable to ask about movie details')
            ->callbackId('movie_details')
            ->addButtons(array_map(function($movie) {
                return Button::create($movie)->value($movie);
            }, $movies));

        $this->ask($question, function(Answer $answer) {
            
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            
            $movie = Movie::where('title', $answer->getValue())->first();
            
            if ($movie) {
                $message = "🎥 <b>{$movie->title}</b>\n\n";
                $message .= "⭐️ Rating: {$movie->rating}\n";
                $message .= "🗣 Language: {$movie->language}\n";
                $message .= "📅 Release Date: ".Carbon::parse($movie->production_date)->format('M d, Y')."\n";
                $message .= "🎬 Director: {$movie->director}\n";
                $message .= "👥 Actors: {$movie->actors}\n\n";
                $message .= "📖 Storyline:\n{$movie->storyline}";
                
                $this->say($message, ['parse' => 'HTML']);
            } else {
                $this->say("Movie not found.");
            }
            
            $this->showMoviesOptions();
        });
    }

    private function askForShowTimes()
    {
        $movies = Movie::has('shows')->pluck('title')->toArray();
        
        if (empty($movies)) {
            $this->say("No showtimes available at the moment.");
            $this->showMoviesOptions();
            return;
        }

        $question = Question::create('Which movie would you like showtimes for?')


            ->fallback('Unable to ask about showtimes')
            ->callbackId('showtimes')
            ->addButtons(array_map(function($movie) {
                return Button::create($movie)->value($movie);
            }, $movies));

        $this->ask($question, function(Answer $answer) {
           
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            
            $movie = Movie::where('title', $answer->getValue())->first();
            
            if ($movie) {
                $shows = Show::where('movie_id', $movie->id)
                             ->where('date', '>=', now()->format('Y-m-d'))
                             ->orderBy('date')
                             ->orderBy('start_time')
                             ->with('hall')
                             ->get();

                if ($shows->isEmpty()) {
                    $this->say("No upcoming shows for {$movie->title}.");
                } else {
                    $message = "⏰ Showtimes for <b>{$movie->title}</b>:\n\n";
                    
                    $groupedShows = $shows->groupBy('date');
                    foreach ($groupedShows as $date => $showsOnDate) {
                        $dateFormatted = Carbon::parse($date)->format('D, M j');
                        $message .= "📅 <b>{$dateFormatted}</b>\n";
                        
                        foreach ($showsOnDate as $show) {
                            $time = Carbon::parse($show->start_time)->format('g:i A');
                            $message .= "• {$time} at {$show->hall->hall_name} (💰 {$show->price} $, 🪑 {$show->remaining_seats} seats left)\n";
                        }
                        $message .= "\n";
                    }
                    
                    $this->say($message, ['parse' => 'HTML']);
                }
            } else {
                $this->say("Movie not found.");
            }
            
            $this->showMoviesOptions();
        });
    }
    
    private function showUserTickets()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->say("🔐 Please login through our website to view your tickets.");
        }

        $tickets = Ticket::with(['show.movie', 'show.hall'])
                ->where('user_id', $user->id)
                ->latest('Booking_date')
                ->get();
   
        if ($tickets->isEmpty()) {
            return $this->say("🎫 No tickets found. Book your first movie today!");
        }
    
        $messages = [];
        foreach ($tickets as $ticket) {
            $show = $ticket->show ?? null;
            if (!$show) continue;

            $messages[] = [
                "🎥 <b>{$show->movie->title}</b>",
                "📅 Date: " . ($show->date ?? 'N/A') . " at " . Carbon::parse($show->start_time)->format('g:i A'),
                "📍 Hall: " . ($show->hall->hall_name ?? 'N/A'),
                "💺 Seats: " . $ticket->Seats_Booked,
                "💰 Price: " . $ticket->tickets_Price . " $",
                "📆 Booked on: " . $ticket->Booking_date->format('Y-m-d'),
                "🔄 Status: " . $ticket->Booking_Status,
                "" 
            ];
        }
   
        $this->say("🎟 Your Tickets Summary:");
        foreach ($messages as $msgParts) {
            $this->say(implode("\n", $msgParts), ['parse' => 'HTML']);
        }

        return $this->showWelcomeMessage();
    }
    private function showPromoOptions()
{
    $question = Question::create('🎟 Promo Code Options')
        ->fallback('Unable to display promo options')
        ->callbackId('promo_options')
        ->addButtons([
            Button::create('View Available Promos')->value('view_promos'),
            Button::create('View Purchased promos')->value('view_purchased_promos'),
            Button::create('↩️ Back')->value('back'),
        ]);

    $this->ask($question, function (Answer $answer) {
      
        if ($answer->isInteractiveMessageReply()) {
            $selectedValue = $answer->getValue(); 
            
            switch ($selectedValue) {
                case 'view_promos':
                    $this->showAvailablePromos();
                    break;
                case 'view_purchased_promos':
                    $this->showpurchasedPromos();
                    break;
                case 'back':
                    $this->showWelcomeMessage();
                    break;
                default:
                    $this->repeat('Please select a valid option:');
            }
        } 
       
        else {
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            $this->repeat('Please use the buttons or enter a valid command.');
        }
    });
}

    

    private function showAvailablePromos()
    {
       
        $user = auth()->user();
        if (!$user) {
            $this->say("🔐 Please login to view your purchased promos.");
            return $this->showPromoOptions();
        }
        
        $purchasedPromoIds = Purchasepromocode::where('user_id', $user->id)
            ->pluck('promocode_id')
            ->toArray();

        $promos = Promocode::where('is_active', true)
            ->where('expiry_date', '>=', now())
            ->whereColumn('max_usage', '>', 'used_count')
            ->whereNotIn('id', $purchasedPromoIds) 
            ->get();
        
        if ($promos->isEmpty()) {
            $this->say("No active promo codes available at the moment.");
            $this->showPromoOptions();
            return;
        }

        $message = "🎟 Available Promo Codes:\n\n";
        foreach ($promos as $promo) {
            $expiry = Carbon::parse($promo->expiry_date)->format('M d, Y');
            $message .= "• <b>{$promo->code}</b> - {$promo->description}\n";
            $message .= "  💰 {$promo->value} ".($promo->type === 'percentage' ? '% off' : 'SAR off')."\n";
            $message .= "  ⏳ Expires: {$expiry}\n";
            $message .= "  🎯 Uses left: ".($promo->max_usage - $promo->used_count)."\n\n";
        }

        $this->say($message, ['parse' => 'HTML']);
        $this->showPromoOptions();
       
    }

    private function showpurchasedPromos()
    {
        $user = auth()->user();
        if (!$user) {
            $this->say("🔐 Please login to view your purchased promos.");
            return $this->showPromoOptions();
        }
    
        $purchased = Purchasepromocode::with('promocode')
                ->where('user_id', $user->id)
                ->whereHas('promocode', function($query) {
                    $query->where('expiry_date', '>=', now())
                          ->where('is_active', true);
                })
                ->latest('purchased_at')
                ->get();
    
        if ($purchased->isEmpty()) {
            $this->say("🛒 You haven't purchased any promo codes yet.");
            return $this->showPromoOptions();
        }
    
        $message = "🛍 Your Purchased Promos:\n\n";
        foreach ($purchased as $purchase) {
            $promo = $purchase->promocode;
            $message .= "• <b>{$promo->code}</b>\n";
            $message .= "  🏷 {$promo->description}\n";
            $message .= "  💰 Value: {$promo->value} ".($promo->type === 'percentage' ? '%' : 'SAR')."\n";
            $message .= "  🕒 Purchased: ".Carbon::parse($purchase->purchased_at)->format('M d, Y')."\n";
            $message .= "  ⏳ Expires: ".Carbon::parse($promo->expiry_date)->format('M d, Y')."\n\n";
        }
    
        $this->say($message, ['parse' => 'HTML']);
        $this->showPromoOptions();
    }

    private function showCinemaInfo()
    {
        $halls = Hall::all();
        $message = "🏢 <b>Our Cinema Information</b>\n\n";
        $message .= "📍 Location: damascus,Syria , Mazzeh\n";
        $message .= "📞 Phone: +963 953248544\n";
        $message .= "🕒 Opening Hours: Daily 10:00 AM - 2:00 AM\n\n";
          if ($halls->isNotEmpty()) {
            $message .= "🎭 Our Halls:\n";
            foreach ($halls as $hall) {
                $message .= "• <b>{$hall->hall_name}</b> - Capacity: {$hall->capacity} seats\n";
            }
        }
        
        $this->say($message, ['parse' => 'HTML']);
        $this->showWelcomeMessage();
    }
        
      


         
        
      
    

    private function showHelp()
    {
        $message = "🆘 Help Center\n\n";
        $message .= "• To book tickets, select 'Book Tickets' from the main menu\n";
        $message .= "• To check showtimes, go to Movies & Shows > Show Times\n";
        $message .= "• For promo codes, select the Promo Codes option\n";
        $message .= "• Need human help? Call us at +963 953248544\n\n";
        $message .= "What else can I help you with?";

        $question = Question::create($message)
            ->fallback('Unable to show help options')
            ->callbackId('help_options')
            ->addButtons([
                Button::create('Booking Help')->value('booking_help'),
                Button::create('Promo Help')->value('promo_help'),
                Button::create('↩️ Main Menu')->value('main_menu'),
            ]);

        $this->ask($question, function(Answer $answer) {
           
            if ($this->handleTextCommand($answer->getText())) {
                return;
            }
            
            if ($answer->getValue() === 'main_menu') {
                $this->showWelcomeMessage();
            } else {
                $this->say("For detailed {$answer->getValue()}, please contact our support team at support@cinema.com");
                $this->showHelp();
            }
        });
    }
}