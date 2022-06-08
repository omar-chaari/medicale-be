<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    DB::table('speciality')->delete();
    DB::table('speciality')->insert(array(
      array('id' => 13, 'speciality' => 'Cardiologue'),
      array('id' => 24, 'speciality' => 'Chirurgien Esthétique'),
      array('id' => 20, 'speciality' => 'Chirurgien Orthopédiste Traumatologue'),

    ));

    DB::table('governorate')->delete();
    DB::table('governorate')->insert(array(
      array('id' => 1, 'governorate' => 'Ariana'),
      array('id' => 2, 'governorate' => 'Beja'),
      array('id' => 3, 'governorate' => 'Ben arous'),
      array('id' => 4, 'governorate' => 'Bizerte'),
      array('id' => 5, 'governorate' => 'Gabes'),
      array('id' => 6, 'governorate' => 'Gafsa'),
      array('id' => 7, 'governorate' => 'Jendouba'),
      array('id' => 8, 'governorate' => 'Kairouan'),
      array('id' => 9, 'governorate' => 'Kasserine'),
      array('id' => 10, 'governorate' => 'Kebili'),
      array('id' => 11, 'governorate' => 'Le Kef'),
      array('id' => 12, 'governorate' => 'Mahdia'),
      array('id' => 13, 'governorate' => 'Mannouba'),
      array('id' => 14, 'governorate' => 'Medenine'),
      array('id' => 15, 'governorate' => 'Monastir'),
      array('id' => 16, 'governorate' => 'Nabeul'),
      array('id' => 17, 'governorate' => 'Sfax'),
      array('id' => 18, 'governorate' => 'Sidi bouzid'),
      array('id' => 19, 'governorate' => 'Siliana'),
      array('id' => 20, 'governorate' => 'Sousse'),
      array('id' => 21, 'governorate' => 'Tataouine'),
      array('id' => 22, 'governorate' => 'Tozeur'),
      array('id' => 23, 'governorate' => 'Tunis'),
      array('id' => 24, 'governorate' => 'Zaghouan'),
    ));
  }
}
