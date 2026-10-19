<?php

namespace App\Http\Controllers;

use App\Actions\Localization\SwitchLocaleAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function __construct(
        private readonly SwitchLocaleAction $switchLocaleAction
    ) {}

    /**
     * تغيير لغة الموقع والتحويل إلى الصفحة السابقة باللغة الجديدة
     */
    public function switch(string $locale, Request $request): RedirectResponse
    {
        // تنفيذ أكشن التبديل والحصول على الرابط المناسب
        $targetUrl = $this->switchLocaleAction->execute($locale, url()->previous());

        return redirect()->to($targetUrl);
    }
}
