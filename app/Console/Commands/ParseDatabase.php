<?php

namespace App\Console\Commands;

use App\Models\CarBrand;
use App\Models\Catalog;
use App\Models\Files;
use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ParseDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parseDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Using this command you\'ll have a chance to parse your csv to sql';


    /* configs */
    public string $images_path           = 'Images/Images/'; // путь к папке картинок откуда парсим
    public string $report                = '/reports/report.csv'; // путь и файл для создания отчета о кзаписях без картинок
    public string $reportUnUsed          = '/reports/reportImages.csv'; // путь и файл для создания отчета о кзаписях без картинок
    public string $pathToParseFile       = 'import-file.csv'; // файл из которого будем парсить
    public string $pathDestinationImages = '/catalog/';
    /* end configs */

    /*don't touch! */
    public int   $i   = 0; //success
    public int   $j   = 0; //without images
    public int   $img = 0; // unused
    public array $arr = array();

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
     * @return void
     */
    public function handle(): void
    {
        try {
            /*  $file = file(public_path($this->pathToParseFile)); //getting file
              $this->info('Parse file');
              $this->checkImg($file); // проверяем соотвествие
              $this->newLine(2); //add two empty lines
              $this->findUnusedImages(); // проверяем неиспользованные картинки
              $this->newLine(2); //add two empty lines
              $this->info('With Images : ' . $this->i);
              $this->newLine(2);//add two empty lines
              $this->error('Without images : ' . $this->j);
              $this->newLine(2);//add two empty lines
              $this->error('Unused Images : ' . $this->img);*/
            $file = file(public_path($this->pathToParseFile)); //getting file
            $this->info('Start parsing ...');
            Catalog::truncate();
            Files::truncate();
            CarBrand::truncate();
            DB::beginTransaction();

            Storage::deleteDirectory('/catalog/');
            $successful = $this->parseToDatabase($file);
            DB::commit();
            $this->newLine(2);//add two empty lines
            $this->info('Successful : '.$successful);
        } catch (Exception $exception) {
            $this->error($exception);
        } catch (\Throwable $e) {
            $this->error($e);
        }
    }

    public function parseToDatabase($file)
    {
        $bar = $this->output->createProgressBar(count($file)); //add total to status bar
        $bar->start(); // start bar
        $i = 0;
        foreach ($file as $item) {
            if ($i === 0) {
                $i++;
                continue; //пропускаем первую запись (названия столбиков)
            }
            $string        = explode(';', $item);
            $name          = $string['0'];
            $car_brand     = $string['1'];
            $weight        = $string['2'];
            $pt            = $string['3'];
            $pd            = $string['4'];
            $rh            = $string['5'];
            $serial_number = $string['6'];
            $PRECIO        = $string['7']; // поа без понятия,куда его лепить,надо уточнить.
            if (empty($car_brand)) {
                $car_brand = 'N/A';
            }
            $car_brand_id = $this->checkBrand($car_brand);

            $newCatalogRow                = new Catalog();
            $newCatalogRow->name          = $name;
            $newCatalogRow->car_brand     = $car_brand_id;
            $newCatalogRow->weight        = (float) $weight;
            $newCatalogRow->pt            = (float) $pt;
            $newCatalogRow->pd            = (float) $pd;
            $newCatalogRow->rh            = (float) $rh;
            $newCatalogRow->space_id      = 1;
            $newCatalogRow->serial_number = $serial_number;
            $newCatalogRow->save();

            $name = strtolower($name); //because in file we have uppercase

            $image = $this->checkImgByIdAndBrand($name, $car_brand);
            if (is_numeric($name)) {
                if ($car_brand === 'Mercedes' || $car_brand === 'Mercedes SMART' || $car_brand === 'Mercedes-SMART' || $car_brand === 'Mercrdes' || $car_brand === 'Mersedes') { // такое условие, ибо при принте ненайденных картинок - всплывали такие варианты
                    $name = str_pad($name, 4, "0", STR_PAD_LEFT); // для Mercedes'а
                } else {
                    $name = str_pad($name, 3, "0", STR_PAD_LEFT); // это для остальных картинок, категория N/a
                }
            }
            if ($image) {
                $newFilePath = 'catalog/'.$newCatalogRow->id.'';
                // File::isDirectory(storage_path($newFilePath)) or File::makeDirectory(storage_path($newFilePath), 0777, true, true);
                //  File::copy($image, storage_path($newFile));
                $path     = Storage::putFile($newFilePath, new File($image));
                $infoFile = pathinfo(Storage::url($path));
                //Storage::copy($image,$newFile);
                $newFileAdd             = new Files();
                $newFileAdd->name       = $name.'.'.$infoFile["extension"];
                $newFileAdd->file       = $path;
                $newFileAdd->size       = filesize($image);
                $newFileAdd->ext        = $infoFile["extension"];
                $newFileAdd->model_type = 'App\Models\Catalog';
                $newFileAdd->model_id   = $newCatalogRow->id;
                $newFileAdd->space_id   = 1;
                $newFileAdd->save();


                $images = $this->findMoreThanOneImage($name, $car_brand);
                if (!empty($images)) {
                    $j = 1;
                    foreach ($images as $image_item) {
                        $path     = Storage::putFile($newFilePath, new File($image_item));
                        $infoFile = pathinfo(Storage::url($path));
                        $name_new = $name.'_'.$j.'.'.$infoFile["extension"];
                        // File::copy($image_item, storage_path($newFile));
                        $newFileAdd             = new Files();
                        $newFileAdd->name       = $name_new;
                        $newFileAdd->file       = $path;
                        $newFileAdd->size       = filesize($image);
                        $newFileAdd->ext        = $infoFile["extension"];
                        $newFileAdd->model_type = 'App\Models\Catalog';
                        $newFileAdd->model_id   = $newCatalogRow->id;
                        $newFileAdd->space_id   = 1;
                        $newFileAdd->save();
                        $j++;
                    }
                }
            }
            $i++;
            $bar->advance();
        }
        $bar->finish();
        return $i;
    }

    public function findMoreThanOneImage($name, $car_brand)
    {
        if (is_numeric($name)) {
            if ($car_brand === 'Mercedes' || $car_brand === 'Mercedes SMART' || $car_brand === 'Mercedes-SMART' || $car_brand === 'Mercrdes' || $car_brand === 'Mersedes') { // такое условие, ибо при принте ненайденных картинок - всплывали такие варианты
                $name = str_pad($name, 4, "0", STR_PAD_LEFT); // для Mercedes'а
            } else {
                $name = str_pad($name, 3, "0", STR_PAD_LEFT); // это для остальных картинок, категория N/a
            }
        }
        return glob(public_path($this->images_path).$name.'_*.jpg');
    }

    public function checkBrand($name): int
    {
        $carBrand = CarBrand::where('name', $name);
        if ($carBrand->count() === 0) {
            $newCarBrand       = new CarBrand();
            $newCarBrand->name = $name;
            $newCarBrand->space_id = 1;
            $newCarBrand->save();
            return $newCarBrand->id;
        }

        return $carBrand->first()->id;
    }

    public function findUnusedImages(): void
    {
        $this->info('Check Images');
        $files = File::files(public_path($this->images_path)); // Все файлы и подкаталоги
        $bar   = $this->output->createProgressBar(count($files)); //add total to status bar
        $bar->start(); // start bar
        $reportImages = fopen(public_path($this->reportUnUsed), 'wb'); //create new file to add logs there
        foreach ($files as $file) {
            $name     = strtoupper($file->getFilenameWithoutExtension()); //because in file we have uppercase
            $filename = $name.'.'.$file->getExtension();
            if (!in_array($filename, $this->arr, true)) { //check , if file used in array
                fwrite($reportImages, $filename."\r\n");
                $this->img++;
            }
            $bar->advance();
        }
        fclose($reportImages); // close file
        $bar->finish();
    }

    public function checkImgByIdAndBrand($id, $brand)
    {
        if (is_numeric($id)) {
            if ($brand === 'Mercedes' || $brand === 'Mercedes SMART' || $brand === 'Mercedes-SMART' || $brand === 'Mercrdes' || $brand === 'Mersedes') { // такое условие, ибо при принте ненайденных картинок - всплывали такие варианты
                $id = str_pad($id, 4, "0", STR_PAD_LEFT); // для Mercedes'а
            } else {
                $id = str_pad($id, 3, "0", STR_PAD_LEFT); // это для остальных картинок, категория N/a
            }
        }
        $filename = $id.'.jpg';
        $path     = $this->images_path;
        $fullPath = public_path($path.$filename);
        if (file_exists($fullPath)) {
            return $fullPath;
        }

        return false;
    }

    public function checkImg($file)
    {
        $bar = $this->output->createProgressBar(count($file)); //add total to status bar
        $bar->start(); // start bar
        $report = fopen(public_path($this->report), 'wb'); //create new file to add logs there
        foreach ($file as $item) {
            $string = explode(';', $item);
            $id     = $string[0];
            $name   = $string[1] ?? 0;
            if (is_numeric($id)) {
                if ($name === 'Mercedes' || $name === 'Mercedes SMART' || $name === 'Mercedes-SMART' || $name === 'Mercrdes' || $name === 'Mersedes') { // такое условие, ибо при принте ненайденных картинок - всплывали такие варианты
                    $id = str_pad($id, 4, "0", STR_PAD_LEFT); // для Mercedes'а
                } else {
                    $id = str_pad($id, 3, "0", STR_PAD_LEFT); // это для остальных картинок, категория N/a
                }
            }
            $filename = $id.'.jpg';
            $path     = $this->images_path;
            if (file_exists(public_path($path.$filename))) {
                $this->i++;
                $this->arr[] = $filename; // добавляем каждую картинку,которая использована и найдена
            } else {
                fwrite($report, $item);
                $this->j++;
            }
            $bar->advance();
        }
        fclose($report); // close file
        $bar->finish(); //finish bar
    }
}
