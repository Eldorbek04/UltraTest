<?php

namespace App\Imports;

use App\Models\LinkQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LinkQuestionsImport implements ToModel, WithStartRow
{
    private $quiz_id;

    // Controllerdan yuborilgan quiz_id ni qabul qilib olish
    public function __construct($quiz_id)
    {
        $this->quiz_id = $quiz_id;
    }

    /**
    * Har bir qatorni bazaga yozish
    */
    public function model(array $row)
    {
        // Agar qatorda savol matni bo'lmasa, uni o'tkazib yuboramiz
        if (!isset($row[0]) || empty($row[0])) {
            return null;
        }

        return new LinkQuestion([
            'link_quiz_id' => $this->quiz_id,
            'text'    => $row[0], // Excel 1-ustun: Savol matni
            'a'       => $row[1], // 2-ustun: A variant
            'b'       => $row[2], // 3-ustun: B variant
            'c'       => $row[3], // 4-ustun: C variant
            'd'       => $row[4], // 5-ustun: D variant
            'correct' => strtolower(trim($row[5])), // 6-ustun: To'g'ri javob (a, b, c, d)
        ]);
    }

    /**
     * Excelning nechanchi qatoridan o'qishni boshlash (masalan, 2-qator sarlavha bo'lmasa)
     */
    public function startRow(): int
    {
        return 2;
    }
}
