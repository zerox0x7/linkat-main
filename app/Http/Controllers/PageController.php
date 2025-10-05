<?php

namespace App\Http\Controllers;

use App\Facades\Theme;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * عرض صفحة ثابتة
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        // البحث عن الصفحة في قاعدة البيانات أولاً
        $page = \App\Models\Page::where('slug', $slug)
                ->where('is_active', true)
                ->first();
                
        if ($page) {
            return view(Theme::getThemeView('pages.dynamic'), [
                'title' => $page->title,
                'page' => $page
            ]);
        }
        
        // التحقق من وجود الصفحة الثابتة المطلوبة
        $validPages = ['terms', 'privacy', 'refund', 'faq', 'about', 'contact'];
        
        if (!in_array($slug, $validPages)) {
            abort(404);
        }
        
        $pageTitle = [
            'terms' => 'شروط الاستخدام',
            'privacy' => 'سياسة الخصوصية',
            'refund' => 'سياسة الاسترجاع',
            'faq' => 'الأسئلة الشائعة',
            'about' => 'من نحن',
            'contact' => 'اتصل بنا',
        ][$slug];
        
        return view(Theme::getThemeView('pages.static.' . $slug), [
            'title' => $pageTitle
        ]);
    }
} 