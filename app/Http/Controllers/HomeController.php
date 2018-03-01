<?php

namespace App\Http\Controllers;

use function array_filter;
use function array_map;
use function collect;
use function compact;
use function config;
use function dd;
use function explode;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use function str_replace;
use function substr;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = $this->getFile('file.txt');

        $measurements = $this->parseContent($content);

        return view('home', compact('measurements'));
    }

    protected function getFile($name)
    {
        return Storage::get($name);
    }

    protected function parseContent($content)
    {
        $content = $this->cleanRawData($content);

        $measurements = $this->getMeasurements();

        return $this->combineMeasurements($content, $measurements);
    }

    protected function cleanRawData($content)
    {
        $content = str_replace("\r", "\n", $content);
        $content = explode("\n", $content);

        return collect(array_filter($content));
    }

    protected function getMeasurements()
    {
        $config = collect(config('parameters.measurements'));

        return $config->mapWithKeys(function ($item) {
            return [$item['code'] => $item];
        });
    }

    protected function combineMeasurements(Collection $collection, $measurements)
    {
        return $collection->map(
            function ($raw) use ($measurements) {
                $code = substr($raw, 3);
                $value = substr($raw, 0, 3);

                return [
                    'code' => $code,
                    'value' => $value,
                    'name' => $measurements[$code]['name'],
                    'unit' => $measurements[$code]['unit'],
                ];
            }
        )->values();
    }

}
