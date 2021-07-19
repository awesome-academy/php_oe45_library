<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\UncheckedBorrowNotification;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use App\Repositories\RepositoryInterface\BorrowRepositoryInterface;
use Pusher\Pusher;

class NotiToAdminCommand extends Command
{
    private $userRepository;
    private $borrowRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for admin everyday at 16:00';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        BorrowRepositoryInterface $borrowRepository
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->borrowRepository = $borrowRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = $this->userRepository->getAdmin();
        $count = $this->borrowRepository->getUncheckedBorrow();

        $data = [
            'content' => 'You have '.$count.' requests have NOT CHECKED yet',
            'time' => date("d-m-Y H:i:s"),
            'title' => 'DAILY NOTIFICATION',
            'link' => 'http://localhost:8000/admin/requests/approved=0',
        ];

        foreach ($users as $user) {
            $user->notify(new UncheckedBorrowNotification($data));
        }

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true,
        );
    
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options,
        );
    
        $pusher->trigger('NotificationEvent', 'send-message', $data);
    }
}
