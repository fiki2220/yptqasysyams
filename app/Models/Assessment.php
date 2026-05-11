<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id',
        'user_id',
        'assessment_type', // 'ziyadah', 'murojaah', 'tahsin', 'tilawah'
        'data', // JSON untuk menyimpan surah, ayat, dan nilai L/C/TL
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // Penilaian milik kelas apa?
    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }

    // Penilaian untuk santri siapa?
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
