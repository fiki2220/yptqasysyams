<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id',
        'user_id',
        'evaluation_number', // 1, 2, 3, 4
        'items', // JSON untuk menyimpan checkbox dan nilai
    ];

    protected $casts = [
        'items' => 'array',
    ];

    // Evaluasi milik kelas apa?
    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }

    // Evaluasi untuk santri siapa?
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
