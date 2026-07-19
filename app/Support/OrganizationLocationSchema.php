<?php

namespace App\Support;

class OrganizationLocationSchema
{
    public static function fields(): array
    {
        $schema = config('frontend.schema');

        return [
            'priceRange' => $schema['price_range'],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $schema['geo']['latitude'],
                'longitude' => (float) $schema['geo']['longitude'],
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => $schema['opening_hours_specification']['dayOfWeek'],
                    'opens' => $schema['opening_hours_specification']['opens'],
                    'closes' => $schema['opening_hours_specification']['closes'],
                ],
            ],
        ];
    }
}
