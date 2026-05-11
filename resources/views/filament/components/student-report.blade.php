<div class="space-y-8">
    <!-- Header Rapor -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-lg">
        <h1 class="text-2xl font-bold mb-2">RAPOR PENILAIAN</h1>
        <p class="text-blue-100">Kelas: <span class="font-semibold">{{ $classGroup->name }}</span></p>
        <p class="text-blue-100">Mapel: <span class="font-semibold">{{ $classGroup->subject->name }}</span></p>
    </div>

    <!-- Data Santri -->
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <h2 class="font-bold text-lg mb-4">Data Santri</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Nama</p>
                <p class="font-semibold">{{ $student->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">NISN</p>
                <p class="font-semibold">{{ $student->nisn ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Jenis Kelamin</p>
                <p class="font-semibold">{{ $student->gender ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Penilaian (Ziyadah, Murojaah, Tahsin, Tilawah) -->
    @php
        $assessmentTypes = ['ziyadah' => 'Ziyadah', 'murojaah' => 'Murojaah', 'tahsin' => 'Tahsin', 'tilawah' => 'Tilawah'];
    @endphp

    <div class="space-y-4">
        @foreach ($assessmentTypes as $type => $label)
            @php
                $assessment = $student->assessments()
                    ->where('class_group_id', $classGroup->id)
                    ->where('assessment_type', $type)
                    ->first();
            @endphp

            <div class="bg-white p-6 rounded-lg border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-blue-600">{{ $label }}</h3>

                @if ($assessment && $assessment->data)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Surah</th>
                                    <th class="px-4 py-2 text-left">Ayat</th>
                                    <th class="px-4 py-2 text-left">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessment->data as $item)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $item['surah'] }}</td>
                                        <td class="px-4 py-2">{{ $item['ayat'] }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-3 py-1 rounded-full text-white font-semibold
                                                @if ($item['nilai'] == 'L')
                                                    bg-green-500
                                                @elseif ($item['nilai'] == 'C')
                                                    bg-yellow-500
                                                @else
                                                    bg-red-500
                                                @endif
                                            ">
                                                {{ $item['nilai'] == 'L' ? 'Lancar' : ($item['nilai'] == 'C' ? 'Cukup' : 'Tidak Lancar') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada data penilaian</p>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Evaluasi 1-4 -->
    <div class="space-y-4">
        @for ($i = 1; $i <= 4; $i++)
            @php
                $evaluation = $student->evaluations()
                    ->where('class_group_id', $classGroup->id)
                    ->where('evaluation_number', $i)
                    ->first();
            @endphp

            <div class="bg-white p-6 rounded-lg border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-purple-600">Evaluasi {{ $i }}</h3>

                @if ($evaluation && $evaluation->items)
                    <div class="space-y-3">
                        @foreach ($evaluation->items as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" {{ $item['checked'] ? 'checked' : '' }} disabled class="w-5 h-5">
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded font-semibold">
                                    {{ $item['score'] ?? 0 }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada data evaluasi</p>
                @endif
            </div>
        @endfor
    </div>
</div>
