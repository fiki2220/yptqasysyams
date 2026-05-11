<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor - {{ $student->name }}</title>
    <style>
        @page { margin: 0.5cm; }
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 11px; 
            color: #333; 
            margin: 20px; 
            line-height: 1.4;
        }
        
        /* Header Section */
        .header-container { width: 100%; margin-bottom: 20px; }
        .logo { width: 80px; float: left; }
        .title-box { float: left; margin-left: 20px; width: 50%; }
        .title-box h1 { color: #1a3c34; font-size: 24px; margin: 0; font-weight: bold; }
        .title-box h2 { color: #1a3c34; font-size: 20px; margin: 0; font-weight: normal; }
        .rapor-badge { 
            float: right; 
            background-color: #1a3c34; 
            color: white; 
            padding: 10px 30px; 
            font-size: 20px; 
            font-weight: bold; 
            letter-spacing: 5px;
            border-radius: 3px;
        }
        .clearfix { clear: both; }

        /* Student Info Section */
        .info-table { width: 100%; margin-bottom: 20px; font-weight: bold; border: none; }
        .info-table td { border: none; padding: 2px 0; }

        /* Tables Style */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background-color: #1a3c34; color: white; padding: 8px; border: 1px solid #1a3c34; text-align: center; }
        td { border: 1px solid #ccc; padding: 6px 10px; }
        
        .bg-light-green { background-color: #e8f3f0; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .star { color: #f39c12; font-size: 12px; }

        /* Bottom Section Grid */
        .bottom-container { width: 100%; }
        .left-col { width: 48%; float: left; }
        .right-col { width: 48%; float: right; }

        /* Footer / Signatures */
        .footer-sign { width: 100%; margin-top: 30px; border: none; }
        .footer-sign td { border: none; text-align: center; vertical-align: top; padding-top: 10px; }
    </style>
</head>
<body>

    @php
        // Mengubah logo ke Base64 agar pasti muncul di PDF
        $logoUrl = 'https://yptqasysyams.id/images/logo.PNG';
        try {
            $logoData = file_get_contents($logoUrl);
            $base64Logo = 'data:image/png;base64,' . base64_encode($logoData);
        } catch (\Exception $e) {
            $base64Logo = ''; // Fallback jika gagal load
        }
    @endphp

    <div class="header-container">
        @if($base64Logo)
            <img src="{{ $base64Logo }}" class="logo">
        @endif
        <div class="title-box">
            <h1>RUMAH QUR'AN</h1>
            <h2>ASY-SYAMS</h2>
        </div>
        <div class="rapor-badge">RAPOR</div>
        <div class="clearfix"></div>
    </div>

    <table class="info-table">
        <tr>
            <td width="12%">Nama</td><td width="2%">:</td><td width="36%">{{ $student->name }}</td>
            <td width="15%">Semester</td><td width="2%">:</td><td>{{ $classGroup->semester->name ?? 'Ganjil' }}</td>
        </tr>
        <tr>
            <td>Kelas</td><td>:</td><td>{{ $classGroup->name ?? '-' }}</td>
            <td>Tahun Ajaran</td><td>:</td><td>2025/2026</td>
        </tr>
        <tr>
            <td>NISM</td><td>:</td><td>{{ $student->nisn ?? '-' }}</td>
            <td colspan="3"></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="50%">Mata Pelajaran</th>
                <th width="15%">KKM</th>
                <th width="15%">Nilai</th>
                <th width="20%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grades = $student->grades()->where('semester_id', $classGroup->semester_id)->get();
                $totalScore = 0;
            @endphp
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->subject->name }}</td>
                <td class="text-center bg-light-green">80</td>
                <td class="text-center">{{ $grade->score }}</td>
                <td class="text-center bg-light-green font-bold">
                    @if($grade->score >= 91) A @elseif($grade->score >= 81) B @else C @endif
                </td>
            </tr>
            @php $totalScore += $grade->score; @endphp
            @endforeach
            <tr class="font-bold" style="background-color: #1a3c34; color: white;">
                <td colspan="2" class="text-center">Nilai Rata - Rata</td>
                <td colspan="2" class="text-center">
                    {{ count($grades) > 0 ? number_format($totalScore / count($grades), 2) : '0' }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="bottom-container">
        <div class="left-col">
            <table>
                <thead>
                    <tr>
                        <th width="40%">Aspek Karakter</th>
                        <th width="20%">Nilai</th>
                        <th width="40%">Bintang</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Contoh data aspek karakter (Bisa disesuaikan dengan database jika ada)
                        $karakter = [
                            ['Adab Islam', 95, 5],
                            ['Kerjasama', 91, 5],
                            ['Tanggung Jawab', 98, 5],
                            ['Kedisiplinan', 90, 5],
                            ['Kejujuran', 87, 4]
                        ];
                    @endphp
                    @foreach($karakter as $k)
                    <tr>
                        <td>{{ $k[0] }}</td>
                        <td class="text-center bg-light-green">{{ $k[1] }}</td>
                        <td class="text-center">
                            @for($i=0; $i<$k[2]; $i++)
                                <span class="star">&#9733;</span>
                            @endfor
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="right-col">
            <table>
                <thead><tr><th colspan="2">Sistem Bintang</th></tr></thead>
                <tbody>
                    <tr><td class="text-center">Sangat Baik</td><td class="text-center bg-light-green"><span class="star">&#9733;&#9733;&#9733;&#9733;&#9733;</span></td></tr>
                    <tr><td class="text-center">Baik</td><td class="text-center bg-light-green"><span class="star">&#9733;&#9733;&#9733;&#9733;</span></td></tr>
                    <tr><td class="text-center">Cukup Baik</td><td class="text-center bg-light-green"><span class="star">&#9733;&#9733;&#9733;</span></td></tr>
                </tbody>
            </table>

            <table>
                <thead><tr><th colspan="2">Sistem Penilaian</th></tr></thead>
                <tbody>
                    <tr><td class="text-center">91 - 100</td><td class="text-center bg-light-green font-bold">A</td></tr>
                    <tr><td class="text-center">81 - 90</td><td class="text-center bg-light-green font-bold">B</td></tr>
                    <tr><td class="text-center">71 - 80</td><td class="text-center bg-light-green font-bold">C</td></tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>

    <table class="footer-sign">
        <tr>
            <td colspan="2" style="text-align: right; padding-right: 20px; padding-bottom: 20px;">
                Pekanbaru, {{ date('d F Y') }}
            </td>
        </tr>
        <tr>
            <td width="50%">
                Guru Pembimbing<br/><br/><br/><br/>
                <strong>{{ $classGroup->teacher->name ?? '_______________________' }}</strong>
            </td>
            <td width="50%">
                Kepala RQ Asy-Syams<br/><br/><br/><br/>
                <strong>Erwin Syamsudin, SQ. M.Pd</strong>
            </td>
        </tr>
    </table>

</body>
</html>