<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StakingPlan extends Model {
    use HasFactory;
    protected $guarded = [];

    public function setDailyRoiAttribute($value) {
        if (is_null($value) || $value === '') {
            $this->attributes['daily_roi'] = '0.00000000';
            return;
        }

        if (is_string($value)) {
            $value = trim($value);
            $value = str_replace(',', '.', $value);
        }

        if ((string)$value !== '' && Str::endsWith((string)$value, '%')) {
            $num = rtrim((string)$value, '%');
            $num = (string) floatval($num);
            $fraction = bcdiv($num, '100', 8);
            $this->attributes['daily_roi'] = $fraction;
            return;
        }

        $num = (string) floatval($value);

        $fraction = bcdiv($num, '100', 8);
        $this->attributes['daily_roi'] = $fraction;

    }

    public function getDailyRoiAttribute($value) {
        return $value * 100;
    }
}
