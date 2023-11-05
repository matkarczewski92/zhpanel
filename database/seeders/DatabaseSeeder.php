<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Livewire\Finances\FinanceCategories;
use App\Models\AnimalCategory;
use App\Models\AnimalGenotypeCategory;
use App\Models\AnimalType;
use App\Models\Feed;
use App\Models\FinancesCategory;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        AnimalCategory::create(array(
            'id' => 0,
            'name' => 'Usunięte',
        ));
        $query = AnimalCategory::find(1);
        $query->id = 0;
        $query->save();

        $animalCat = [
            [
                'id' => 1,
                'name' => 'W hodowli',
            ],
            [
                'id' => 2,
                'name' => 'Na sprzedaz',
            ],
            [
                'id' => 3,
                'name' => 'Sprzedane',
            ]
        ];
        AnimalCategory::insert($animalCat);

        AnimalType::create(array(
            'id' => 1,
            'name' => 'Wąż zbożowy',
        ));

        Feed::create(array(
            'id' => 1,
            'name' => 'Odmowa przyjęcia pokarmu',
            'feeding_interval' => 0,
            'amount' => 99999,
            'last_price' => 0,
        ));
        $query = Feed::find(1);
        $query->id = 0;
        $query->save();

        User::create(array(
            'name' => 'admin',
            'email' => 'admin@admin.pl',
            'password' => '$2y$10$.wcLIDqDabq8nC8hzX8Ot.jpq4XxkSaHOpAh79IuriFUBkt6ZnHY6', //qwerty1234
        ));

        $financesCategory = [
            [
                'id' => 1,
                'name' => 'Karma',
            ],
            [
                'id' => 2,
                'name' => 'Akcesoria terrarystyczne',
            ],
            [
                'id' => 3,
                'name' => 'Zakup/Sprzedaż węża',
            ],
            [
                'id' => 4,
                'name' => 'Inne',
            ],
            [
                'id' => 5,
                'name' => 'Utrzymanie',
            ],
        ];
        FinancesCategory::insert($financesCategory);

        $feed = [
            [
                'id' => 1,
                'name' => 'Osesek 1-2g',
                'feeding_interval' => 5,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Osesek 3-4g',
                'feeding_interval' => 6,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 3,
                'name' => 'Osesek 5-6g',
                'feeding_interval' => 7,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 4,
                'name' => 'Mysz 10-16g',
                'feeding_interval' => 8,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 5,
                'name' => 'Mysz 16-22g',
                'feeding_interval' => 8,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 6,
                'name' => 'Mysz 23-29g',
                'feeding_interval' => 10,
                'amount' => 0,
                'last_price' => 0,
            ],
            [
                'id' => 7,
                'name' => 'Szczur mrożony 30/40g',
                'feeding_interval' => 28,
                'amount' => 0,
                'last_price' => 0,
            ],
        ];
        Feed::insert($feed);

        $sysConfig = [
            [
                'key' => 'feedLeadTime',
                'name' => 'Czas dostawy karmy',
                'value' => 10
            ],
            [
                'key' => 'layingDuration',
                'name' => 'Czas zniesienie jajek',
                'value' => 45
            ],
            [
                'key' => 'hatchlingDuration',
                'name' => 'Czas inkubacji',
                'value' => 65
            ],
        ];
        SystemConfig::insert($sysConfig);

        $genotype = [
            [
                'id' => '2',
                'name' => 'Amel',
            ],
            [
                'id' => '3',
                'name' => 'Anery',
            ],
            [
                'id' => '4',
                'name' => 'Scaleless',
            ],
            [
                'id' => '5',
                'name' => 'Stripe',
            ],
            [
                'id' => '7',
                'name' => 'Motley',
            ],
            [
                'id' => '8',
                'name' => 'Motley/Stripe',
            ],
            [
                'id' => '9',
                'name' => 'Ultra',
            ],
            [
                'id' => '10',
                'name' => 'Amel/Ultra',
            ],
            [
                'id' => '11',
                'name' => 'Caramel',
            ],
            [
                'id' => '12',
                'name' => 'Bloodred',
            ],
            [
                'id' => '13',
                'name' => 'Sunkissed',
            ],
            [
                'id' => '14',
                'name' => 'Hypo',
            ],
            [
                'id' => '15',
                'name' => 'Lava',
            ],
            [
                'id' => '16',
                'name' => 'Cinder',
            ],
            [
                'id' => '17',
                'name' => 'Diffused',
            ],
            [
                'id' => '18',
                'name' => 'Charcoal',
            ],
            [
                'id' => '19',
                'name' => 'Okeetee',
            ],
            [
                'id' => '21',
                'name' => 'Extreme Okeetee',
            ],
            [
                'id' => '22',
                'name' => 'Tessera',
            ],
            [
                'id' => '23',
                'name' => 'Palmetto',
            ],
            [
                'id' => '35',
                'name' => 'Lavender',
            ],
            [
                'id' => '36',
                'name' => 'Redfactor',
            ],
            [
                'id' => '37',
                'name' => 'Masque',
            ]
        ];
        AnimalGenotypeCategory::insert($genotype);
    }
}
