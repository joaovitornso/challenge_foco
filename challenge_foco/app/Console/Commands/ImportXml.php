<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Reserve;
use SimpleXMLElement;

class ImportXml extends Command
{

    protected $signature = 'app:import-xml {type?}';
    protected $description = 'Import XML data to database';

    public function handle()
    {

        $type = $this->argument('type');

        if (is_null($type)) {
            $this->info('Importing all data...');
            $this->importHotels();
            $this->importRooms();
            $this->importReserves();
        } else {
            switch ($type) {
                case 'hotels':
                    $this->importHotels();
                    break;
                case 'rooms':
                    $this->importRooms();
                    break;
                case 'reserves':
                    $this->importReserves();
                    break;
                default:
                    $this->info('Please specify a valid type: hotels, rooms, or reserves.');
                    break;
            }
        }

    }

    protected function importHotels()
    {
        $filePath = storage_path('app/xml/hotels.xml');
        if (!file_exists($filePath)) {
            $this->error('File not found.');
            return;
        }
        $xml = simplexml_load_file($filePath);
        Log::info('Importing hotels from: ' . $filePath);

        foreach ($xml->Hotel as $hotel) {
            $hotelData = [
                'id' => (integer) $hotel['id'],
                'name' => (string) $hotel->Name
            ];
            $this->line('Hotel Data: ' . print_r($hotelData, true));
        }

        foreach ($xml->Hotel as $hotel) {
            Hotel::updateOrCreate(
                ['id' => (integer) $hotel['id']],
                ['name' => (string) $hotel->Name]
            );
        }

        Log::info('Import of hotels completed successfully!');
        $this->info('Import completed successfully!');

    }

    protected function importRooms()
    {
        $filePath = storage_path('app/xml/rooms.xml');
        if (!file_exists($filePath)) {
            $this->error('File not found.');
            return;
        }
        $xml = simplexml_load_file($filePath);
        Log::info('Importing rooms from: ' . $filePath);

        foreach ($xml->Room as $room) {
            $roomData = [
                'id' => (integer) $room['id'],
                'hotelCode' => (integer) $room['hotelCode'],
                'name' => (string) $room->Name
            ];

            $this->line('Room Data: ' . print_r($roomData, true));
        }

        foreach ($xml->Room as $room) {
            Room::updateOrCreate(
                ['id' => (integer) $room['id']],
                [
                    'hotelCode' => (integer) $room['hotelCode'],
                    'name' => (string) $room->Name
                ]
            );
        }

        Log::info('Import of rooms completed successfully!');
        $this->info('Import completed successfully!');

    }

    protected function importReserves()
    {
        $filePath = storage_path('app/xml/reserves.xml');
        if (!file_exists($filePath)) {
            $this->error('File not found.');
            return;
        }
        $xml = simplexml_load_file($filePath);
        Log::info('Importing reserves from: ' . $filePath);

        foreach ($xml->Reserve as $reserve) {
            // Processamento dos dados da reserva
            $reserveData = [
                'id' => (integer) $reserve['id'],
                'hotelCode' => (integer) $reserve['hotelCode'],
                'roomCode' => (integer) $reserve['roomCode'],
                'checkIn' => (string) $reserve->CheckIn,
                'checkOut' => (string) $reserve->CheckOut,
                'total' => (float) $reserve->Total,
            ];

            // Exibir dados da reserva no terminal
            $this->line('Reserve Data: ' . print_r($reserveData, true));
        }

        // foreach ($xml->Reserve as $reserve) {
        //     Reserve::updateOrCreate(
        //         ['id' => (integer) $reserve['id']],
        //         [
        //             'hotelCode' => (integer) $reserve['hotelCode'],
        //             'roomCode' => (integer) $reserve['roomCode'],
        //             'checkIn' => (string) $reserve->CheckIn,
        //             'checkOut' => (string) $reserve->CheckOut,
        //             'total' => (float) $reserve->Total,
        //         ]
        //     );
        // }

        // Log::info('Import of reserves completed successfully!');
        // $this->info('Import completed successfully!');

    }





}
