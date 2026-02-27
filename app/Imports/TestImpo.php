<?php
namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TestImpo implements ToModel, WithStartRow
{
    private $test_id;

    public function __construct($test_id)
    {
        $this->test_id = $test_id;
    }

    // Ma'lumotlarni 2-qatordan o'qish (1-qator sarlavha bo'lsa)
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if (empty($row[0])) return null;
    
        return new Question([
            'test_id'  => $this->test_id,
            'question' => $row[0],
            'a'        => $row[1], // Bazadagi 'a' ustuniga Exceldagi 2-ustun
            'b'        => $row[2],
            'c'        => $row[3],
            'd'        => $row[4],
            'answer'   => $row[5],
        ]);
    }
}