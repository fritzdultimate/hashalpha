<?php
namespace App\Services;

use InvalidArgumentException;

/**
 * Uses BC Math for decimal-safe calculations.
 * All inputs are string or numeric. Returns string decimal with scale = 8
 */
class RewardCalculator {
    private const SCALE = 8;

    /**
     * Calculate reward for interval (in days) from APY and principal.
     *
     * @param string|float|int $principal  e.g. '100.00'
     * @param string|float|int $apyPercent e.g. '12.5' (means 12.5% APY)
     * @param float|int $days Number of days to calculate (can be fractional)
     * @param int $scale precision (optional)
     * @return string reward (decimal string)
     */
    public static function rewardForDays($principal, $apyPercent, $days, $scale = self::SCALE): string
    {
        if (!extension_loaded('bcmath')) {
            throw new InvalidArgumentException('BCMath required');
        }

        $scale = (int) $scale;

        // Convert to strings
        $P = (string) $principal;
        $r = (string) $apyPercent;
        $d = (string) $days;

        // daily_rate = (apyPercent / 100) / 365
        $rate = bcdiv(bcdiv($r, '100', $scale + 4), '365', $scale + 4); // more internal precision

        // reward = P * daily_rate * days
        $tmp = bcmul($P, $rate, $scale + 4);
        $reward = bcmul($tmp, $d, $scale + 4);

        // return normalized to $scale
        return self::normalize($reward, $scale);
    }

    /**
     * Normalize decimal string to fixed scale, trimming trailing zeros
     */
    private static function normalize(string $val, int $scale): string
    {
        if (strpos($val, '.') === false) {
            return bcadd($val, '0', $scale);
        }
        // round/truncate to scale
        // using bcadd to force scale
        $norm = bcadd($val, '0', $scale);
        // Optional: trim trailing zeros but keep at least one decimal place if scale>0
        $norm = rtrim(rtrim($norm, '0'), '.');
        return $norm === '' ? '0' : $norm;
    }
}
