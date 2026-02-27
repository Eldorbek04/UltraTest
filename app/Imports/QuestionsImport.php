<?php
namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;

// WithHeadingRow interfeysini olib tashlang! 
class QuestionsImport implements ToModel
{
    private $quiz_id;
    private $isFirstRow = true;

    public function __construct($quiz_id) {
        $this->quiz_id = $quiz_id;
    }

    public function model(array $row)
    {
        if ($this->isFirstRow) {
            $this->isFirstRow = false;
            return null;
        }
    
        if (empty($row[0])) return null;
    
        return new Question([
            'quiz_id'        => $this->quiz_id,
            // e() funksiyasi <bodyNode> ni &lt;bodyNode&gt; ga aylantiradi
            'question_text'  => e((string)$row[0]), 
            'option_a'       => e((string)($row[1] ?? '')),
            'option_b'       => e((string)($row[2] ?? '')),
            'option_c'       => e((string)($row[3] ?? '')),
            'option_d'       => e((string)($row[4] ?? '')),
            'correct_answer' => strtolower(trim((string)($row[5] ?? ''))),
        ]);
    }
}