<?php

namespace App\Console\Commands;

use App\Models\Daily;
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

        try{
            foreach ($xml->Hotel as $hotel) {
                Hotel::updateOrCreate(
                    ['id' => (integer) $hotel['id']],
                    ['name' => (string) $hotel->Name]
                );
            }

            Log::info('\nImport of hotels completed successfully!');
            $this->info('\nImport completed successfully!');
        } catch (\Exception $e) {
            Log::error('Erro ao importar hotéis: ' . $e->getMessage());
        }



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

        try{
            foreach ($xml->Room as $room) {
                Room::updateOrCreate(
                    ['id' => (integer) $room['id']],
                    [
                        'hotel_id' => (integer) $room['hotelCode'],
                        'name' => (string) $room->Name
                    ]
                );
            }
            Log::info('\nImport of rooms completed successfully!');
            $this->info('\nImport completed successfully!');
        } catch (\Exception $e) {
            Log::error('Erro ao importar quartos: ' . $e->getMessage());
        }
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

        try{
            foreach ($xml->Reserve as $reserve) {
               $reserveObj = Reserve::updateOrCreate(
                    ['id' => (integer) $reserve['id']],
                    [
                        'hotel_id' => (integer) $reserve['hotelCode'],
                        'room_id' => (integer) $reserve['roomCode'],
                        'check_in' => (string) $reserve->CheckIn,
                        'check_out' => (string) $reserve->CheckOut,
                        'total' => (float) $reserve->Total,
                    ]
                );
                if (isset($reserve->Dailies)) {
                    foreach ($reserve->Dailies->Daily as $dailyXml) {
                        Daily::create([
                            'reserve_id' => $reserveObj->id,
                            'date' => (string)$dailyXml->Date,
                            'value' => (float)$dailyXml->Value,
                        ]);
                    }
                }
            }


            Log::info('\nImport of reserves completed successfully!');
            $this->info('\nImport completed successfully!\n');
        } catch (\Exception $e) {
            Log::error('Erro ao importar reservas: ' . $e->getMessage());
        }



    }





}
