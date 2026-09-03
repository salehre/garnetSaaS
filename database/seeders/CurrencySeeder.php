<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Map of TabanGohar provider codes => Persian display labels.
     * Add new rows here whenever the provider starts returning a new code
     * (the fetch command will still auto-create unknown codes with a raw label,
     * this seeder just fixes up the friendly Persian name).
     */
    private const CODE_LABELS = [
        'SekehRob' => 'ربع سکه',
        'SekehNim' => 'نیم سکه',
        'SekehTamam' => 'سکه تمام',
        'SekehEmam' => 'سکه امامی',
        'SekehGerami' => 'سکه گرمی',
        'YekGram18' => 'طلای ۱۸ عیار (هر گرم)',
        'YekGram20' => 'طلای ۲۰ عیار (هر گرم)',
        'YekGram21' => 'طلای ۲۱ عیار (هر گرم)',
        'YekGram24' => 'طلای ۲۴ عیار (هر گرم)',
        'KharidMotefaregheh18' => 'خرید متفرقه طلای ۱۸ عیار',
        'TavizMotefaregheh18' => 'تعویض متفرقه طلای ۱۸ عیار',
        'Dollar' => 'دلار آمریکا',
        'Euro' => 'یورو',
        'Derham' => 'درهم امارات',
        'OunceTala' => 'اونس طلا',
    ];

    public function run(): void
    {
        foreach (self::CODE_LABELS as $code => $label) {
            Currency::updateOrCreate(
                ['code' => $code],
                ['label' => $label, 'is_active' => true]
            );
        }
    }
}
