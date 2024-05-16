<?php

namespace Elnooronline\Notifications\Console;

use Elnooronline\Notifications\Entities\FcmToken;
use Illuminate\Console\Command;

class DeleteExpiredFcmTokensCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fcm-tokens:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean expired FCM tokens.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        FcmToken::expiredOnly()
            ->each(function (FcmToken $token) {
                $token->delete();
            });

        $this->info(
            "\nThe FCM tokens has been cleaned successfully. "
            .now()->toDateTimeString()
        );
    }
}
