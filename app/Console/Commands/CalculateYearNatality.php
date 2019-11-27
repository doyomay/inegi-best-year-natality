<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateYearNatality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'YearNatality:Calculate {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculate the minimum best year natality';

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
     * @return mixed
     */
    public function handle()
    {
        $filepath = $this->argument('filepath');
        if(!file_exists($filepath)) {
            $this->error('file not found!');
            exit;
        }
        $file = file($filepath);
        $data = [];
        foreach ($file as $line) {
            if (!empty($line)) {
                $data[] = str_getcsv($line);
            }
        }
        $maxRepeatedYear = 0;
        $year = 99999;
        $total = sizeof($data);
        for ($i = 0; $i < $total; $i++) {
            $currentRepeatedYear = 0;
            list($yearOne,) = $data[$i];
            for ($j = 0; $j < $total; $j++) {
                list($born, $die) = $data[$j];
                if ($yearOne >= $born && $yearOne <= $die) {
                    $currentRepeatedYear++;
                }
            }
            if ($currentRepeatedYear > 1 && $currentRepeatedYear >= $maxRepeatedYear) {
                $maxRepeatedYear = $currentRepeatedYear;
                if ($yearOne < $year) {
                    $year = $yearOne;
                }
            }
        }
        echo $year . PHP_EOL;
    }
}
