<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitLog;

class LogsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(): void
  {
    $visitLogs = [
      [
        'visitor_id' => '1',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'check_in' => '2024-03-02 01:14:00 PM',
        'check_out' => '2024-03-02 02:25:00 PM',
        'log_date' => '2024-03-02',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '2',
        'visit_purpose' => 'Services',
        'resident_name' => 'Inquiry For Rent House',
        'check_in' => '2024-03-02 01:22:00 PM',
        'check_out' => '2024-03-02 06:39:00 PM',
        'log_date' => '2024-03-02',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '5',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'check_in' => '2024-03-03 01:19:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '6',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Andre Cruz',
        'check_in' => '2024-03-03 01:25:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '7',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jasper Serrano',
        'check_in' => '2024-03-03 01:31:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '8',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Josiah Martinez',
        'check_in' => '2024-03-03 01:38:00 PM',
        'check_out' => '2024-03-03 01:53:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '9',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Jacob Sampang',
        'check_in' => '2024-03-03 01:43:00 PM',
        'check_out' => '2024-03-03 01:53:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '10',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jomar Escoto',
        'check_in' => '2024-03-03 01:56:00 PM',
        'check_out' => '2024-03-03 02:24:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '11',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Ronnel Gutierrez',
        'check_in' => '2024-03-03 02:04:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '12',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Mervin Canlas',
        'check_in' => '2024-03-03 02:16:00 PM',
        'check_out' => '2024-03-03 02:16:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '13',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Rafael Mortiz',
        'check_in' => '2024-03-03 02:24:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '15',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Jamaila David',
        'check_in' => '2024-03-03 03:48:00 PM',
        'check_out' => '2024-03-03 05:37:00 PM',
        'log_date' => '2024-03-03',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '16',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Irah Ignacio',
        'check_in' => '2024-03-04 01:53:00 PM',
        'check_out' => '2024-03-04 02:59:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '17',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Maynard Sanchez',
        'check_in' => '2024-03-04 01:58:00 PM',
        'check_out' => '2024-03-04 02:39:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '18',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Polo David',
        'check_in' => '2024-03-04 02:05:00 PM',
        'check_out' => '2024-03-04 03:13:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '20',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'check_in' => '2024-03-04 02:21:00 PM',
        'check_out' => '2024-03-04 03:06:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '19',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Harvy Serrano',
        'check_in' => '2024-03-04 02:25:00 PM',
        'check_out' => '2024-03-04 02:39:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '22',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Francis Salvador',
        'check_in' => '2024-03-04 02:27:00 PM',
        'check_out' => '2024-03-04 02:40:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '21',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Joevin Hernandez',
        'check_in' => '2024-03-04 02:30:00 PM',
        'check_out' => '2024-03-04 03:41:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '23',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Iris Camaya',
        'check_in' => '2024-03-04 02:32:00 PM',
        'check_out' => '2024-03-04 03:38:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '24',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Marvin Serrano',
        'check_in' => '2024-03-04 03:03:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '25',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Jeanette Isip',
        'check_in' => '2024-03-04 03:04:00 PM',
        'check_out' => '2024-03-04 03:40:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '26',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Robert Enriquez',
        'check_in' => '2024-03-04 03:12:00 PM',
        'check_out' => '2024-03-04 04:57:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '27',
        'visit_purpose' => 'Amenities',
        'resident_name' => 'Clubhouse',
        'check_in' => '2024-03-04 03:20:00 PM',
        'check_out' => '2024-03-04 04:12:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '29',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Trixie Reyes',
        'check_in' => '2024-03-04 03:23:00 PM',
        'check_out' => '2024-03-04 03:40:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '30',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Bryan Duque',
        'check_in' => '2024-03-04 03:26:00 PM',
        'check_out' => '2024-03-04 04:56:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '28',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Patrick Cabacungan',
        'check_in' => '2024-03-04 03:26:00 PM',
        'check_out' => '2024-03-04 03:49:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '32',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Cath Divina',
        'check_in' => '2024-03-04 03:28:00 PM',
        'check_out' => '2024-03-04 04:58:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '31',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Marvin Margallo',
        'check_in' => '2024-03-04 03:30:00 PM',
        'check_out' => '2024-03-04 03:43:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '33',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Leo Rivera',
        'check_in' => '2024-03-04 03:34:00 PM',
        'check_out' => '2024-03-04 04:57:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '34',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Lemuel Castro',
        'check_in' => '2024-03-04 03:45:00 PM',
        'check_out' => '2024-03-04 04:58:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '31',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Marvin Margallo',
        'check_in' => '2024-03-04 03:46:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'IN'
      ],
      [
        'visitor_id' => '21',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Joevin Hernandez',
        'check_in' => '2024-03-04 03:52:00 PM',
        'check_out' => '2024-03-04 04:57:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '35',
        'visit_purpose' => 'Delivery',
        'resident_name' => 'Alma Arcilla',
        'check_in' => '2024-03-04 04:59:00 PM',
        'check_out' => '2024-03-04 05:58:00 PM',
        'log_date' => '2024-03-04',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '37',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Hheka Test',
        'check_in' => '2024-03-07 02:01:00 AM',
        'check_out' => '2024-03-07 02:02:00 AM',
        'log_date' => '2024-03-07',
        'status' => 'OUT'
      ],
      [
        'visitor_id' => '37',
        'visit_purpose' => 'Visiting',
        'resident_name' => 'Hheka Test',
        'check_in' => '2024-03-07 02:02:00 AM',
        'check_out' => '2024-03-07 02:02:00 AM',
        'log_date' => '2024-03-07',
        'status' => 'OUT'
      ],
    ];

    foreach ($visitLogs as $key => $visitLog) {
      VisitLog::create($visitLog);
    }
  }
}
