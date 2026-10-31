<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    /** @var list<string> */
    protected $fillable = ['content'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    /** @return array<string, string> */
    public static function defaults(): array
    {
        return [
            'hero_label' => 'WEALTH MANAGEMENT · NAIROBI, KENYA',
            'hero_title' => "Scaling up your\nfinancial altitude.",
            'hero_copy' => 'Creating gains on your wealth through fixed short-term note investments.',
            'intro_eyebrow' => 'A STEADY HAND IN A CHANGING WORLD',
            'intro_title' => "Everyone has access to the markets.\nWe know how to analyse them better.",
            'intro_lead' => 'We are a wealth management company based in Nairobi, Kenya, dealing in short-term note investments designed to provide a predetermined regular income stream for high-net-worth institutions and investors.',
            'intro_body' => 'Our multi-asset strategy uses a long/short trading model, with the primary objective of realizing capital growth and returns for investors. We bring years of experience trading financial instruments and make prudent investment decisions, supported by relationships with international trading desks, brokerages and investment banks.',
            'strategy_title' => "Designed for\nmore than one\nmarket.",
            'strategy_body' => 'Our diversified fund applies a long/short trading model to pursue capital growth in rising and falling markets. With access to more than 200 asset classes, we use research and risk controls intended to manage exposure to adverse movements and volatility.',
            'statement_title' => "Wealth is a journey.\nWe help you see further.",
            'statement_body' => 'Established synergies and partnerships connect us to international trading desks, brokerages and investment banks, bringing flexibility to investment decisions.',
            'benefits_title' => "Built around\nyour perspective.",
            'benefits_body' => 'A wealth management experience shaped by access, flexibility and a clear view of the long term.',
            'account_title' => "Designed around\nregular income.",
            'account_body' => 'Quarterly interest disbursements provide an option to withdraw interest every three months during the year. Capital is subject to a 12-month lock-in period. Contact Tazan Global for full product terms before investing.',
            'quote_title' => "Let your next chapter\nbegin with perspective.",
            'contact_title' => "Let’s talk\nabout what’s next.",
            'contact_body' => 'Connect with our team to learn more about Tazan Global and the account opening process.',
        ];
    }

    /** @return array<string, string> */
    public static function currentCopy(): array
    {
        $stored = self::query()->find(1)?->content ?? [];

        return array_replace(self::defaults(), $stored);
    }

    /** @param array<string, string> $copy */
    public static function saveCopy(array $copy): void
    {
        self::query()->updateOrCreate(['id' => 1], ['content' => array_replace(self::defaults(), $copy)]);
    }
}
