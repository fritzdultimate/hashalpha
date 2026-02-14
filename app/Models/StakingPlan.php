<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StakingPlan extends Model {
    use HasFactory;
    protected $guarded = [];

    public function setMinAmountAttribute($value) {
        $this->attributes['min_amount'] = (int) round($value * 100);
    }

    public function getMinAmountAttribute($value) {
        return $value / 100;
    }

    public function setMaxAmountAttribute($value) {
        $this->attributes['max_amount'] = (int) round($value * 100);
    }

    public function getMaxAmountAttribute($value) {
        return $value / 100;
    }

    public function setMinRoiAttribute($value) {
        if (is_null($value) || $value === '') {
            $this->attributes['min_roi'] = '0.00000000';
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
            $this->attributes['min_roi'] = $fraction;
            return;
        }

        $num = (string) floatval($value);

        $fraction = bcdiv($num, '100', 8);
        $this->attributes['min_roi'] = $fraction;

    }

    public function setMaxRoiAttribute($value) {
        if (is_null($value) || $value === '') {
            $this->attributes['max_roi'] = '0.00000000';
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
            $this->attributes['max_roi'] = $fraction;
            return;
        }

        $num = (string) floatval($value);

        $fraction = bcdiv($num, '100', 8);
        $this->attributes['max_roi'] = $fraction;

    }

    public function getMinRoiAttribute($value) {
        return $value * 100;
    }

    public function getMaxRoiAttribute($value) {
        return $value * 100;
    }

    public function stakes() {
        return $this->hasMany(Stake::class, 'plan_id');
    }
}
