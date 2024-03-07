<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visitor;

class VisitorsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(): void
  {
    $visitors = [
      [
        'visitor_first_name' => 'Allena',
        'visitor_last_name' => 'Sto. Domingo',
        'license_plate' => 'CDZ 6634',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'visit_date' => '2024-03-02',
        'visitor_qrcode' => 'VMS_4b94de55c51bf7b05db1365f44fe333c',
        'registered_date' => '2024-03-02'
      ],
      [
        'visitor_first_name' => 'Stephanie',
        'visitor_last_name' => 'Mercado',
        'license_plate' => 'CAX 3204',
        'visit_purpose' => 'Services',
        'resident_name' => 'Inquiry For Rent House',
        'visit_date' => '2024-03-02',
        'visitor_qrcode' => 'VMS_05ef734c0ebd5a93490f6ff52e9cc661',
        'registered_date' => '2024-03-02',
      ],
      [
        'visitor_first_name' => 'Kray',
        'visitor_last_name' => 'Dimasacat',
        'license_plate' => 'QUO 9989',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Friday Dimasacat',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_63a2da92100b57fd8c14e820a9d5fafd',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Aiah',
        'visitor_last_name' => 'Arceta',
        'license_plate' => 'MQA123',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jhoanna Robles',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_c9dbfbab1167c06a70383ad410fcc725',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Elaine',
        'visitor_last_name' => 'Guzman',
        'license_plate' => 'ADX4664',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_535fce50cef1d4727f9a687fe2553c94',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Paolo',
        'visitor_last_name' => 'Canlas',
        'license_plate' => 'DBA210',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Andre Cruz',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_8d2fdfcf56b56d307d4e3a7b5136259e',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Albert',
        'visitor_last_name' => 'Balagtas',
        'license_plate' => 'AKA1328',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jasper Serrano',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_035c7178709d2434978892d59c0ec626',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Joshua',
        'visitor_last_name' => 'Mayrina',
        'license_plate' => 'SBG5373',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Josiah Martinez',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_305b08fcd16343f39ffdbc0bc823bccc',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Jeren',
        'visitor_last_name' => 'Salazar',
        'license_plate' => 'WCN140',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Jacob Sampang',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_9d7871b8a9fbbf03dcfb26369a250ff6',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Gerine',
        'visitor_last_name' => 'Gonzales',
        'license_plate' => 'RBO349',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jomar Escoto',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_f22083d932244eaad830493255fec79e',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Magnolia',
        'visitor_last_name' => 'Gutierrez',
        'license_plate' => 'UUY145',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Ronnel Gutierrez',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_dedb6cac1e1bfc52e4f680f41d498eef',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Aiko',
        'visitor_last_name' => 'Reyes',
        'license_plate' => 'CNA143',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Mervin Canlas',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_927dc6ffa7042c91740f0997d3a5ab39',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Aaron',
        'visitor_last_name' => 'Suarez',
        'license_plate' => 'TRJ4213',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Rafael Mortiz',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_f56fa104f23a51d259d28a2033dcbf2c',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Jomar',
        'visitor_last_name' => 'Santos',
        'license_plate' => 'RBF7955',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jamaila David',
        'visit_date' => '2024-03-03',
        'visitor_qrcode' => 'VMS_6a45f6c492050cf5f0eb5dc13157dec9',
        'registered_date' => '2024-03-03',
      ],
      [
        'visitor_first_name' => 'Angela',
        'visitor_last_name' => 'Ignacio',
        'license_plate' => 'PAQ325',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Irah Ignacio',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_a667a2175588e21bbcc0703c1e8f0252',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Harold',
        'visitor_last_name' => 'Sanchez',
        'license_plate' => 'RFG3397',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Maynard Sanchez',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_63e5bca8901b36deb828b4a8111887fb',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Jonel',
        'visitor_last_name' => 'Lansangan',
        'license_plate' => 'CAX427',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Polo David',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_115183e1eee31eb2685733a92ce5e77b',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Paul',
        'visitor_last_name' => 'Nucum',
        'license_plate' => 'RHF7214',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Harvy Serrano',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_0b2ebdf360d0daf62f57009a9e03678d',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Mae',
        'visitor_last_name' => 'Gopez',
        'license_plate' => 'CAW3337',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_6098a5e9746672a31caf038cbe2b7b44',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Pauline',
        'visitor_last_name' => 'Baltazar',
        'license_plate' => 'CMB7356',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Joevin Hernandez',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_02e8f4c840b4fdca34cea1157955e847',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Jonald',
        'visitor_last_name' => 'Roque',
        'license_plate' => '9922RE',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Francis Salvador',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_b69f6771e6eac17b8a5b2d6ffac5c51d',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Maria',
        'visitor_last_name' => 'Camaya',
        'license_plate' => 'AIA4302',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Iris Camaya',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_75d5328cdcb88388f59b60baf52489ab',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Mikaela',
        'visitor_last_name' => 'Pangilinan',
        'license_plate' => 'CAM1409',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Marvin Serrano',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_4a0d8859e07ec971d8ad804ba6589366',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Levin',
        'visitor_last_name' => 'Salalila',
        'license_plate' => '680CSO',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Jeanette Isip',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_2448bb464aae772b55c7632bb4bfbc62',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Sherlyn',
        'visitor_last_name' => 'Umanos',
        'license_plate' => 'CMP169',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Robert Enriquez',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_f33358c95cd2dc9077be005b0d3bfd81',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Ann',
        'visitor_last_name' => 'Guiao',
        'license_plate' => 'CAX9063',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_a6e7e6902a757e9f307d4539d4f9260d',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Jefferson',
        'visitor_last_name' => 'Angeles',
        'license_plate' => 'UQA6803',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Patrick Cabacungan',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_3460d55bc670d74602fede0325f399a9',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Mharvin',
        'visitor_last_name' => 'Paras',
        'license_plate' => '136RVE',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Trixie Reyes',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_12d64ebf5a936ebebd2503b2bac93039',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Kyla',
        'visitor_last_name' => 'Duque',
        'license_plate' => 'DAT7022',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Bryan Duque',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_0380364c9a2e0f755d51ae249d4ab2bd',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Arnie',
        'visitor_last_name' => 'Margallo',
        'license_plate' => 'NCF7988',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Marvin Margallo',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_abee4e7f1250995bc4f5fc1c625d750b',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Mariel',
        'visitor_last_name' => 'Salas',
        'license_plate' => 'CTV328',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Cath Divina',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_4acf3495fde43e21cc8226c39fe9a481',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Raven',
        'visitor_last_name' => 'Torres',
        'license_plate' => 'ABJ7383',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Leo Rivera',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_1a0f22fc7f96c1050cd9dc0fabe1ad8c',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Kyle',
        'visitor_last_name' => 'Angeles',
        'license_plate' => 'NGU6209',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Lemuel Castro',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_70ab84445ff137c6df1e35571940f55b',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Regor',
        'visitor_last_name' => 'Silvosa',
        'license_plate' => '818CMJ',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Alma Arcilla',
        'visit_date' => '2024-03-04',
        'visitor_qrcode' => 'VMS_2ed4c8f8553294da6362fea29f2c7555',
        'registered_date' => '2024-03-04',
      ],
      [
        'visitor_first_name' => 'Hanneka',
        'visitor_last_name' => 'Test',
        'license_plate' => 'HEH123',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Ed Test',
        'visit_date' => '2024-03-08',
        'visitor_qrcode' => 'VMS_6eb9c910f5ae1e1ff971d253f868e94a',
        'registered_date' => '2024-03-06',
      ],
      [
        'visitor_first_name' => 'Akehh',
        'visitor_last_name' => 'Test',
        'license_plate' => 'ABCD123',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Hheka Test',
        'visit_date' => '2024-03-07',
        'visitor_qrcode' => 'VMS_369582e3c07d9c64b1d21603dee09375',
        'registered_date' => '2024-03-07',
      ],
      [
        'visitor_first_name' => 'Akeh',
        'visitor_last_name' => 'Test',
        'license_plate' => 'ABC123',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Heka',
        'visit_date' => '2024-03-08',
        'visitor_qrcode' => 'VMS_59dee7326b80dcc8a4a18940bdca3d55',
        'registered_date' => '2024-03-07',
      ],
    ];

    foreach ($visitors as $key => $visitor) {
      Visitor::create($visitor);
    }
  }
}