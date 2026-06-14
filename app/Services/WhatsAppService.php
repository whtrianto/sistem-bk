<?php

namespace App\Services;

use App\Models\WaLog;
use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $apiToken;

    public function __construct()
    {
        $this->apiUrl = SchoolSetting::getValue('wa_api_url', config('services.fonnte.url', 'https://api.fonnte.com/send'));
        $this->apiToken = SchoolSetting::getValue('wa_api_token', config('services.fonnte.token', ''));
    }

    public function sendMessage(string $phone, string $message, string $type = 'other', ?int $referenceId = null, ?string $referenceType = null): bool
    {
        if (empty($this->apiToken)) {
            Log::warning('WhatsApp API token not configured');
            WaLog::create([
                'recipient_phone' => $phone,
                'message' => $message,
                'type' => $type,
                'status' => 'failed',
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
                'response' => 'API token not configured',
            ]);
            return false;
        }

        try {
            $response = Http::asForm()->withoutVerifying()->withHeaders([
                'Authorization' => $this->apiToken,
            ])->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
            ]);

            $success = $response->successful() && ($response->json('status') === true);

            WaLog::create([
                'recipient_phone' => $phone,
                'message' => $message,
                'type' => $type,
                'status' => $success ? 'sent' : 'failed',
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
                'response' => $response->body(),
            ]);

            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());
            WaLog::create([
                'recipient_phone' => $phone,
                'message' => $message,
                'type' => $type,
                'status' => 'failed',
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
                'response' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendViolationNotification($student, $violation): bool
    {
        $schoolName = SchoolSetting::getValue('school_name', 'Sekolah');
        $message = "⚠️ *NOTIFIKASI PELANGGARAN*\n\n";
        $message .= "Yth. {$student->parent_name},\n\n";
        $message .= "Dengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n";
        $message .= "👤 Nama: *{$student->user->name}*\n";
        $message .= "📋 NIS: {$student->nis}\n";
        $message .= "🏫 Kelas: {$student->schoolClass->full_name}\n\n";
        $message .= "Telah melakukan pelanggaran:\n";
        $message .= "❌ *{$violation->violationType->name}*\n";
        $message .= "📅 Tanggal: {$violation->date->format('d/m/Y')}\n";
        $message .= "📉 Poin dikurangi: {$violation->points_deducted}\n";
        $message .= "📊 Sisa poin: *{$student->current_points}*\n\n";
        $message .= "Mohon perhatian dan kerjasamanya.\n\n";
        $message .= "Hormat kami,\n_{$schoolName}_";

        return $this->sendMessage(
            $student->parent_phone,
            $message,
            'violation',
            $violation->id,
            'violation'
        );
    }

    public function sendInvitationNotification($student, $letter): bool
    {
        $schoolName = SchoolSetting::getValue('school_name', 'Sekolah');
        $schoolAddress = SchoolSetting::getValue('school_address', '');
        $message = "📩 *SURAT PANGGILAN ORANG TUA*\n\n";
        $message .= "Yth. {$student->parent_name},\n\n";
        $message .= "Dengan hormat, kami mengundang Bapak/Ibu untuk hadir di sekolah:\n\n";
        $message .= "📅 Tanggal: *{$letter->meeting_date->format('d/m/Y')}*\n";
        $message .= "🕐 Pukul: *{$letter->meeting_time}*\n";
        $message .= "📍 Tempat: {$schoolAddress}\n\n";
        $message .= "Terkait: {$letter->reason}\n\n";
        $message .= "Kehadiran Bapak/Ibu sangat kami harapkan.\n\n";
        $message .= "Hormat kami,\n_{$schoolName}_";

        return $this->sendMessage(
            $student->parent_phone,
            $message,
            'invitation',
            $letter->id,
            'parent_letter'
        );
    }

    public function sendScheduleReminder($schedule): bool
    {
        $schoolName = SchoolSetting::getValue('school_name', 'Sekolah');
        $student = $schedule->student;
        $message = "🔔 *PENGINGAT JADWAL KONSELING*\n\n";
        $message .= "Hai *{$student->user->name}*,\n\n";
        $message .= "Mengingatkan bahwa kamu memiliki jadwal konseling:\n\n";
        $message .= "📅 Tanggal: *{$schedule->date->format('d/m/Y')}*\n";
        $message .= "🕐 Pukul: *{$schedule->time_start} - {$schedule->time_end}*\n";
        $message .= "👨‍🏫 Konselor: {$schedule->counselor->name}\n\n";
        $message .= "Harap hadir tepat waktu ya! 😊\n\n";
        $message .= "_{$schoolName}_";

        // Send to student's parent
        if ($student->parent_phone) {
            $this->sendMessage($student->parent_phone, $message, 'reminder', $schedule->id, 'schedule');
        }

        return true;
    }
}
