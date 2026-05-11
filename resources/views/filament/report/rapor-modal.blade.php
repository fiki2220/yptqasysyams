<div class="p-4 space-y-6 bg-white border outline outline-1 outline-gray-200 shadow-sm rounded">
    <!-- Header -->
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <div>
            <h2 class="text-xl font-bold uppercase">Rapor Hasil Belajar</h2>
            <p class="text-sm text-gray-400">Rumah Qur'an Asy-Syams</p>
            <p class="text-gray-500">{{ $classGroup->name ?? '-' }} | Semester: {{ $classGroup->semester->name ?? '-' }}</p>
        </div>
        @if(auth()->user()?->hasAccess('reports.download'))
        <div>
            <a href="{{ route('rapor.pdf', ['class_group' => $classGroup->id, 'user' => $student->id]) }}" 
               target="_blank" 
               class="inline-flex items-center justify-center gap-2 rounded-lg py-2 px-4 text-sm font-medium transition-all bg-primary-600 text-white hover:bg-primary-500 shadow-sm focus:ring-2 focus:ring-primary-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print PDF
            </a>
        </div>
        @endif
    </div>

    <!-- Data Santri -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p><strong>Nama:</strong> {{ $student->name }}</p>
            <p><strong>NISN:</strong> {{ $student->nisn ?? '-' }}</p>
        </div>
        <div>
            <p><strong>Kelas/Jenjang:</strong> {{ $student->grade_level ?? '-' }}</p>
        </div>
    </div>

    <hr />

    <!-- Kehadiran -->
    <div>
        <h3 class="font-bold text-lg mb-2">Kehadiran (Absensi)</h3>
        @php
            $hadir = $student->attendances()->where('status', 'hadir')->whereIn('meeting_id', $classGroup->meetings()->pluck('id'))->count();
            $sakit = $student->attendances()->where('status', 'sakit')->whereIn('meeting_id', $classGroup->meetings()->pluck('id'))->count();
            $izin = $student->attendances()->where('status', 'izin')->whereIn('meeting_id', $classGroup->meetings()->pluck('id'))->count();
            $alpha = $student->attendances()->where('status', 'alpha')->whereIn('meeting_id', $classGroup->meetings()->pluck('id'))->count();
        @endphp
        <table class="w-full text-left border-collapse border border-gray-300">
            <tr>
                <td class="border border-gray-300 p-2">Hadir</td>
                <td class="border border-gray-300 p-2">{{ $hadir }}</td>
            </tr>
            <tr>
                <td class="border border-gray-300 p-2">Sakit</td>
                <td class="border border-gray-300 p-2">{{ $sakit }}</td>
            </tr>
            <tr>
                <td class="border border-gray-300 p-2">Izin</td>
                <td class="border border-gray-300 p-2">{{ $izin }}</td>
            </tr>
            <tr>
                <td class="border border-gray-300 p-2">Tanpa Keterangan (Alpha)</td>
                <td class="border border-gray-300 p-2">{{ $alpha }}</td>
            </tr>
        </table>
    </div>

    <!-- Nilai (Grade) -->
    <div>
        <h3 class="font-bold text-lg mb-2">Nilai Akhir (Grades)</h3>
        @php
            // Ambil semua Grade santri ini di semester yang sama dengan classGroup ini
            $grades = $student->grades()->where('semester_id', $classGroup->semester_id)->get();
        @endphp
        @if($grades->count() > 0)
            <table class="w-full text-left border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2">Mata Pelajaran</th>
                        <th class="border border-gray-300 p-2">Nilai</th>
                        <th class="border border-gray-300 p-2">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $grade->subject->name ?? '-' }}</td>
                        <td class="border border-gray-300 p-2 font-bold">{{ $grade->score }}</td>
                        <td class="border border-gray-300 p-2">{{ $grade->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-sm text-gray-500 pb-2">Belum ada data nilai (grades) untuk semester ini.</p>
        @endif
    </div>

    <!-- Penilaian Tambahan (Assessments) -->
    <div>
        <h3 class="font-bold text-lg mb-2">Penilaian Tambahan (Assessments)</h3>
        @php
            $assessments = $student->assessments()->where('class_group_id', $classGroup->id)->get();
        @endphp
        @if($assessments->count() > 0)
            <table class="w-full text-left border-collapse border border-gray-300 mt-2">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2">Tipe Penilaian</th>
                        <th class="border border-gray-300 p-2">Surah</th>
                        <th class="border border-gray-300 p-2">Ayat</th>
                        <th class="border border-gray-300 p-2">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessments as $assessment)
                        @php
                            $data = is_array($assessment->data) ? $assessment->data : [];
                            $isFlat = !empty($data) && isset($data[0]) && is_array($data[0]);
                            $rows = $isFlat ? $data : [$data];
                        @endphp
                        @foreach($rows as $i => $row)
                        <tr>
                            @if($i === 0)
                                <td class="border border-gray-300 p-2 align-top" rowspan="{{ count($rows) }}">
                                    {{ ucfirst($assessment->assessment_type) }}
                                </td>
                            @endif
                            <td class="border border-gray-300 p-2">{{ $row['surah'] ?? '-' }}</td>
                            <td class="border border-gray-300 p-2">{{ $row['ayat'] ?? '-' }}</td>
                            <td class="border border-gray-300 p-2 font-bold">{{ $row['nilai'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-sm text-gray-500 pb-2">Belum ada data assessments untuk kelas ini.</p>
        @endif
    </div>

    <!-- Evaluasi (Evaluations) -->
    <div>
        <h3 class="font-bold text-lg mb-2">Evaluasi</h3>
        @php
            $evaluations = $student->evaluations()->where('class_group_id', $classGroup->id)->get();
        @endphp
        @if($evaluations->count() > 0)
            <div class="space-y-2 mt-2">
                @foreach($evaluations as $evaluation)
                <div class="p-3 border border-gray-300 rounded">
                    <p class="font-semibold">{{ $evaluation->evaluation_type }}</p>
                    <p class="text-sm">{{ $evaluation->notes }}</p>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 pb-2">Belum ada evaluasi dari ustadz.</p>
        @endif
    </div>

</div>
