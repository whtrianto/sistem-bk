<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CounselingSchedule;
use App\Services\WhatsAppService;

class SendScheduleReminder extends Command
{
    protected $signature = 'counseling:send-reminder';
    protected $description = 'Send WhatsApp reminder to students/parents H-1 before counseling sessions';

    public function handle()
    {
        $tomorrow = today()->addDay();
        $schedules = CounselingSchedule::whereDate('date', $tomorrow)
            ->where('status', 'approved')
            ->get();

        $this->info("Found {$schedules->count()} schedules for tomorrow.");

        $waService = new WhatsAppService();
        foreach ($schedules as $schedule) {
            $waService->sendScheduleReminder($schedule);
        }

        $this->info('Reminders sent successfully.');
    }
}
