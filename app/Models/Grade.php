<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'semester_id',
        'score',
        'notes',
    ];

    // Nilai milik siswa siapa?
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Nilai untuk mapel apa?
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Nilai di semester berapa?
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    protected function casts(): array
    {
        return [
            'score' => 'float',
        ];
    }
}