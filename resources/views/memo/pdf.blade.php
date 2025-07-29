<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Memo - {{ $memo->nomor }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 0 auto; width: 90%; }
        .footer { margin-top: 50px; }
        .signature-container { margin-top: 50px; display: flex; justify-content: flex-end; }
        .signature-box { width: 300px; text-align: center; }
        .signature-img { height: 80px; margin-bottom: 10px; }
        .signature-line { border-top: 1px solid #000; width: 200px; margin: 0 auto; }
        .signature-name { margin-top: 5px; font-weight: bold; }
        .signature-position { font-size: 0.9em; }
        .signature-date { font-size: 0.9em; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>MEMO INTERNAL</h2>
        <h3>Nomor: {{ $memo->nomor }}</h3>
    </div>
    
    <div class="content">
        <table width="100%" cellspacing="0" cellpadding="5">
            <tr>
                <td width="20%">Dari</td>
                <td width="80%">: {{ $memo->dari }}</td>
            </tr>
            <tr>
                <td>Kepada</td>
                <td>: {{ $memo->kepada }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $memo->tanggal->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: {{ $memo->perihal }}</td>
            </tr>
        </table>
        
        <div style="margin-top: 30px;">
            {!! nl2br(e($memo->isi)) !!}
        </div>
        
        @if($memo->lampiran > 0)
        <div style="margin-top: 20px;">
            <strong>Lampiran:</strong> {{ $memo->lampiran }} lembar
        </div>
        @endif
        
        <!-- Bagian Tanda Tangan -->
        @if($memo->include_signature && $memo->signature_path && $memo->disetujuiOleh)
        <div class="signature-container">
            <div class="signature-box">
                <div>
                    @php
                        $signaturePath = storage_path('app/public/' . $memo->signature_path);
                        if (file_exists($signaturePath)) {
                            $imageData = base64_encode(file_get_contents($signaturePath));
                            $imageInfo = getimagesize($signaturePath);
                            $mimeType = $imageInfo['mime'];
                        }
                    @endphp
                    
                    @if(isset($imageData))
                        <img src="data:{{ $mimeType }};base64,{{ $imageData }}" 
                            class="signature-img" alt="Tanda Tangan" style="width: 150px; height: auto;">
                    @else
                        <div style="color: red; border: 1px dashed #ccc; padding: 5px;">
                            Tanda tangan tidak ditemukan atau tidak dapat dibaca
                        </div>
                    @endif
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $memo->disetujuiOleh->name }}</div>
                <div class="signature-position">{{ $memo->disetujuiOleh->jabatan }}</div>
                <div class="signature-date">
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>