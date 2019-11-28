<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SebastianBergmann\CodeCoverage\Report\PHP;

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
        if (!file_exists($filepath)) {
            $this->error('file not found!');
            exit;
        }
        $file = file($filepath);
        $years = [];
        foreach ($file as $line) {
            if (!empty($line)) {
                $year = str_getcsv($line);
                list($born, $die) = $year;
                for ($i = $born; $i <= $die; $i++) {
                    if (!isset($years[$i])) $years[$i] = 0;
                    $years[$i]++;
                }
            }
        }
        $maxYear = max($years);
        $year = array_search($maxYear, $years);
        echo $year . PHP_EOL;
    }
}
