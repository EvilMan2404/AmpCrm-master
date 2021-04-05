<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use DB;
use Illuminate\Console\Command;

class ParseCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will parse all countries';
    /**
     * @var string
     */
    public string $parseCountryLink = 'https://raw.githubusercontent.com/russ666/all-countries-and-cities-json/6ee538beca8914133259b401ba47a550313e8984/countries.json';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \JsonException
     */
    public function handle() : void
    {
        try {
            $content = file_get_contents($this->parseCountryLink, false);
            $content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            DB::beginTransaction();
            foreach ($content as $key=>$cities){
                $newCountry = new Country();
                $newCountry->title = $key;
                $newCountry->save();
                foreach ($cities as $city) {
                    $newCity = new City();
                    $newCity->title = $city;
                    $newCity->country_id = $newCountry->id;
                    $newCity->save();
                }
            }
            DB::commit();
            $this->info('Finished successfully!');
        }catch (\Exception $exception){
            $this->error($exception);
        } catch (\Throwable $e) {
            $this->error($e);
        }
    }
}
