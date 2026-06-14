<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use App\Models\WaLog;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SchoolSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'school_name', 'school_address', 'school_phone', 'school_email',
            'principal_name', 'principal_nip', 'wa_api_token', 'wa_api_url',
            'initial_student_points', 'warning_point_threshold', 'critical_point_threshold',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SchoolSetting::setValue($field, $request->input($field));
            }
        }

        if ($request->hasFile('school_logo')) {
            $request->validate([
                'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('school_logo');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure public/uploads directory exists
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $file->move(public_path('uploads'), $fileName);

            // Delete old logo if it exists
            $oldLogo = SchoolSetting::getValue('school_logo');
            if ($oldLogo && file_exists(public_path($oldLogo))) {
                @unlink(public_path($oldLogo));
            }

            SchoolSetting::setValue('school_logo', 'uploads/' . $fileName);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function waLogs()
    {
        $logs = WaLog::latest()->paginate(20);
        return view('admin.settings.wa-logs', compact('logs'));
    }

    public function waTest(Request $request)
    {
        $request->validate(['phone' => 'required', 'message' => 'required']);
        $waService = new WhatsAppService();
        $result = $waService->sendMessage($request->phone, $request->message, 'other');
        return back()->with($result ? 'success' : 'error',
            $result ? 'Pesan berhasil dikirim!' : 'Gagal mengirim pesan. Periksa konfigurasi API.');
    }
}
