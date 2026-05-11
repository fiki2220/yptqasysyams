<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

// --- 1. TAMBAHAN IMPORT FILAMENT ---
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// --- 2. TAMBAHKAN implements FilamentUser DI SINI ---
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',         // superadmin, guru, student
        'nisn',         // Khusus siswa
        'phone',
        'address',
        'is_active',    // Status aktif/tidak
        'gender',

        // --- TAMBAHAN DATA PPDB (WAJIB ADA DISINI) ---
        'grade_level',   // Jenjang (SD/SMP/SMA)
        'birth_date',    // Tanggal Lahir
        'mother_name',   // Nama Ibu
        'school_origin', // Asal Sekolah
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'birth_date' => 'date', // Agar otomatis jadi object Date (bukan string)
        ];
    }

    // --- RELASI UNTUK SISWA ---

    // Siswa punya banyak nilai
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // Siswa punya banyak pembayaran
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Siswa punya banyak absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // --- RELASI UNTUK GURU ---

    // Ustad membuat banyak pertemuan
    public function teachingMeetings()
    {
        return $this->hasMany(Meeting::class, 'user_id');
    }

    // Ustad mengajar banyak kelas
    public function classGroupsAsTeacher()
    {
        return $this->hasMany(ClassGroup::class, 'teacher_id');
    }

    // --- RELASI UNTUK SANTRI ---

    // Santri berada di banyak kelas
    public function classGroups()
    {
        return $this->belongsToMany(ClassGroup::class, 'class_group_student', 'user_id', 'class_group_id')
            ->wherePivot('deleted_at', null)
            ->withPivot('joined_at', 'deleted_at')
            ->withTimestamps();
    }

    // Santri punya banyak penilaian
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    // Santri punya banyak evaluasi
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function hasAccess(string $permission): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        if (! in_array($this->role, ['guru', 'student'], true)) {
            return false;
        }

        return Cache::remember(
            "role_permission:{$this->role}:{$permission}",
            now()->addMinutes(10),
            fn (): bool => RolePermission::query()
                ->where('role', $this->role)
                ->where('permission', $permission)
                ->where('is_allowed', true)
                ->exists()
        );
    }

    // --- 3. FUNGSI WAJIB FILAMENT UNTUK IZIN MASUK ---
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        return $this->role === 'guru'
            && ($this->hasAccess('dashboard.view') || $this->hasAccess('panel.access'));
    }
}
