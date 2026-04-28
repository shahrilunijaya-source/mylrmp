<?php

namespace App\Enums;

enum MalaysianState: string
{
    case Johor          = 'johor';
    case Kedah          = 'kedah';
    case Kelantan       = 'kelantan';
    case MelakaMelaka   = 'melaka';
    case NegeriSembilan = 'negeri_sembilan';
    case Pahang         = 'pahang';
    case Perak          = 'perak';
    case Perlis         = 'perlis';
    case PulauPinang    = 'pulau_pinang';
    case Sabah          = 'sabah';
    case Sarawak        = 'sarawak';
    case Selangor       = 'selangor';
    case Terengganu     = 'terengganu';
    case WPKualaLumpur  = 'wp_kuala_lumpur';
    case WPLabuan       = 'wp_labuan';
    case WPPutrajaya    = 'wp_putrajaya';

    public function label(): string
    {
        return match($this) {
            self::Johor          => 'Johor',
            self::Kedah          => 'Kedah',
            self::Kelantan       => 'Kelantan',
            self::MelakaMelaka   => 'Melaka',
            self::NegeriSembilan => 'Negeri Sembilan',
            self::Pahang         => 'Pahang',
            self::Perak          => 'Perak',
            self::Perlis         => 'Perlis',
            self::PulauPinang    => 'Pulau Pinang',
            self::Sabah          => 'Sabah',
            self::Sarawak        => 'Sarawak',
            self::Selangor       => 'Selangor',
            self::Terengganu     => 'Terengganu',
            self::WPKualaLumpur  => 'W.P. Kuala Lumpur',
            self::WPLabuan       => 'W.P. Labuan',
            self::WPPutrajaya    => 'W.P. Putrajaya',
        };
    }
}
