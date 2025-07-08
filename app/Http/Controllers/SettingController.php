<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
     $settings = Setting::first(); // ou encontrar pelo ID, se só houver um registro
     return view('admin.pages.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|size:3',
            'payout_minimum' => 'required|numeric|min:0',
            'payout_delay_days' => 'required|integer|min:0',
            'support_email' => 'nullable|email',
            'site_name' => 'required|string|max:255',
        ]);

        $setting = Setting::create($data);
        return redirect()->back()->with('success', 'Configurações cadastradas com sucesso');
    }

    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'commission_rate' => 'numeric|min:0|max:100',
            'currency' => 'string|size:3',
            'payout_minimum' => 'numeric|min:0',
            'payout_delay_days' => 'integer|min:0',
            'support_email' => 'nullable|email',
            'site_name' => 'string|max:255',
        ]);

        $setting->update($data);
        return redirect()->back()->with('success', 'Configurações alterada com sucesso');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->back()->with('success', 'Configurações eliminada com sucesso');
    }
}
