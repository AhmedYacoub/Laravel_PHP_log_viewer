<?php

namespace App\Http\Controllers;

use LimitIterator;
use SplFileObject;
use App\Traits\CustomPaginator;

class PaginatorController extends Controller
{
    use CustomPaginator;

    public function index()
    {
        $page = abs((int) request()->query('page', 0));
        $currentLine = $page <= 1 ? 0 : ($page * 10) - 10;
        $limit = 10;

        $filePath = storage_path('logs/bigFile.txt');

        $fileObject = new SplFileObject($filePath);

        $fileObject->seek($fileObject->getSize());

        $lastLine = $fileObject->key() + 1;

        $fileLines = new LimitIterator(
            new SplFileObject($filePath),
            $currentLine,
            $limit
        );

        $lastPage = ceil($lastLine / 10);

        $myArr = [
            'start_page' => request()->url() . '?page=1',
            'previous_page' => $page <= 1 ? null : request()->url() . '?page=' . $page - 1,
            'next_page' => ($page + 1) >= $lastPage ? null : request()->url() . '?page=' . ($page <= 1 ? 2 : $page + 1),
            'last_page' => request()->url() . '?page=' . $lastPage,
        ];

        $lineNumber = $currentLine;

        foreach ($fileLines as $line) {
            $myArr[] = [
                'line_number' => ++$lineNumber,
                'line' => $line
            ];
        }


        return $myArr;
        // $myArray = [
        //     '1' => 'error #1',
        //     '2' => 'error #2',
        //     '3' => 'error #3',
        //     '4' => 'error #4',
        //     '5' => 'error #5',
        //     '6' => 'error #6',
        //     '7' => 'error #7',
        //     '8' => 'error #8',
        //     '9' => 'error #9',
        //     '10' => 'error #10',
        //     '11' => 'error #11',
        //     '12' => 'error #12',
        //     '13' => 'error #13',
        //     '14' => 'error #14',
        //     '15' => 'error #15',
        // ];

        $myCollection = collect($myArr);

        $paginatedData = $this->paginate($myCollection);

        return $paginatedData;
    }
}
