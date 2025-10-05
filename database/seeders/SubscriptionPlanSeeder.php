<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'الخطة الشهرية',
                'slug' => 'monthly-plan',
                'description' => 'خطة مثالية للمتاجر الصغيرة والمتوسطة مع جميع المميزات الأساسية',
                'price' => 99.00,
                'duration_days' => 30,
                'duration_type' => 'monthly',
                'features' => [
                    'لوحة تحكم متكاملة',
                    'دعم فني على مدار الساعة',
                    'إحصائيات مفصلة',
                    'تخصيص الألوان والشعار',
                    'حتى 5 طرق دفع',
                    'نسخ احتياطي يومي'
                ],
                'max_products' => 100,
                'max_orders' => 500,
                'commission_rate' => 2.5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'خطة 6 أشهر',
                'slug' => 'semi-annual-plan', 
                'description' => 'خطة اقتصادية للمتاجر الطموحة مع خصم 15% وميزات إضافية',
                'price' => 499.00,
                'duration_days' => 180,
                'duration_type' => 'semi_annual',
                'features' => [
                    'جميع مميزات الخطة الشهرية',
                    'خصم 15% على السعر الإجمالي',
                    'تطبيق جوال مخصص',
                    'تقارير متقدمة',
                    'دعم عبر واتساب',
                    'تدريب مجاني على النظام',
                    'طرق دفع غير محدودة',
                    'دومين فرعي مجاني'
                ],
                'max_products' => 500,
                'max_orders' => 2000,
                'commission_rate' => 2.0,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'الخطة السنوية',
                'slug' => 'annual-plan',
                'description' => 'الخيار الأمثل للمتاجر الكبيرة مع خصم 25% وجميع المميزات المتقدمة',
                'price' => 899.00,
                'duration_days' => 365,
                'duration_type' => 'annual',
                'features' => [
                    'جميع مميزات الخطط السابقة',
                    'خصم 25% على السعر الإجمالي',
                    'دومين مخصص مجاني',
                    'مدير حساب مخصص',
                    'تصميم متجر مخصص',
                    'تكامل مع أنظمة المحاسبة',
                    'API متقدم للتكامل',
                    'أولوية في الدعم الفني',
                    'استشارة تسويقية مجانية'
                ],
                'max_products' => null, // غير محدود
                'max_orders' => null,   // غير محدود
                'commission_rate' => 1.5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3
            ]
        ];

        foreach ($plans as $planData) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }
    }
}
