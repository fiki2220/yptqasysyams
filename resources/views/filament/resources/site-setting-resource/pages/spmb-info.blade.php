<div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <h4 class="font-semibold text-blue-900 mb-2">📊 Informasi Countdown</h4>
    <ul class="space-y-2 text-sm text-blue-800">
        <li>
            <strong>Waktu Berakhir:</strong> 
            {{ $deadline->translatedFormat('l, d F Y') }} pukul {{ $deadline->format('H:i') }} WIB
        </li>
        <li>
            <strong>Sisa Waktu:</strong> 
            @php
                $now = \Carbon\Carbon::now();
                if ($deadline > $now) {
                    $diff = $now->diffInDays($deadline);
                    echo $diff . ' hari dari sekarang';
                } else {
                    echo '❌ Deadline sudah terlewat';
                }
            @endphp
        </li>
        <li>
            <strong>Zona Waktu:</strong> WIB (Waktu Indonesia Barat)
        </li>
        <li class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded">
            💡 <strong>Tip:</strong> Countdown akan ditampilkan otomatis di halaman depan website. 
            Pastikan waktu yang dipilih adalah waktu untuk zona WIB.
        </li>
    </ul>
</div>
