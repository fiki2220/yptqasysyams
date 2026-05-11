@extends('root.app')

@section('title', 'Transkrip Nilai')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Transkrip Akademik</h1>
            <a href="{{ route('dashboard') }}" class="text-green-600 hover:underline">← Kembali ke Dashboard</a>
        </div>

        @forelse($gradesGrouped as $semesterName => $grades)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8 fade-in-section">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Semester: {{ $semesterName }}
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-white px-4 py-3 grid grid-cols-12 gap-4 text-sm font-bold text-gray-500 border-b">
                            <div class="col-span-6">Mata Pelajaran</div>
                            <div class="col-span-2 text-center">Nilai</div>
                            <div class="col-span-4">Catatan</div>
                        </div>
                        
                        @foreach($grades as $grade)
                            <div class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} px-4 py-4 grid grid-cols-12 gap-4 text-sm items-center">
                                <dt class="col-span-6 font-medium text-gray-900">{{ $grade->subject->name }}</dt>
                                <dd class="col-span-2 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $grade->score >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $grade->score }}
                                    </span>
                                </dd>
                                <dd class="col-span-4 text-gray-500 italic">
                                    {{ $grade->notes ?? '-' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg p-10 text-center">
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada nilai</h3>
                <p class="mt-1 text-sm text-gray-500">Nilai akan muncul setelah Ustad melakukan input.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection