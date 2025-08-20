<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Memo - {{ $memo->nomor }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #000;
            margin: 0;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            box-sizing: border-box;
            font-size: 12px;
        }
        
        .header { 
            text-align: left; 
            margin-bottom: 20px; 
            border-bottom: 1px solid #000;
            padding-bottom: 15px;
        }
        
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .content { 
            margin: 0 auto; 
            width: 100%; 
            box-sizing: border-box;
        }
        
        .memo-details table {
            width: 100%;
            margin-bottom: 20px;
            table-layout: fixed;
            border-collapse: collapse;
        }
        
        .memo-details td {
            padding: 2px 0;
            vertical-align: top;
            word-wrap: break-word;
            font-size: 12px;
        }
        
        .memo-details .label {
            width: 80px;
            font-weight: normal;
        }
        
        .memo-details .colon {
            width: 15px;
        }
        
        .memo-body {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.6;
            width: 100%;
            word-wrap: break-word;
            font-size: 12px;
        }
        
        .memo-body ol, .memo-body ul {
            padding-left: 20px;
            margin: 10px 0;
        }
        
        .memo-body ol li, .memo-body ul li {
            margin-bottom: 5px;
            line-height: 1.4;
        }
        
        .closing-text {
            margin: 20px 0;
            font-size: 12px;
            line-height: 1.6;
            font-style: italic;
        }
        
        /* Signature Container dengan posisi yang benar */
        .signature-container { 
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            gap: 30px;
            min-height: 150px;
        }
        
        .signature-box { 
            text-align: left;
            width: 250px;
            margin-bottom: 30px;
            flex: 1;
        }
        
        .signature-header {
            text-align: left;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .signature-position-text {
            text-align: left;
            margin-bottom: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .signature-img { 
            height: 60px;
            margin: 15px 0; 
            display: block;
            max-width: 200px;
        }
        
        .signature-name { 
            font-weight: bold; 
            text-decoration: underline;
            font-size: 12px;
            text-align: left;
            margin-top: 10px;
        }
        
        .signature-position { 
            font-size: 12px; 
            margin-top: 3px;
            text-align: left;
        }
        
        /* Posisi signature kiri dan kanan */
        .signature-left {
            order: 1;
        }
        
        .signature-right {
            order: 2;
        }
        
        .tembusan {
            margin-top: 40px;
            font-size: 12px;
            page-break-inside: avoid;
        }
        
        .tembusan h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            font-weight: bold;
        }
        
        .tembusan ul {
            padding-left: 20px;
            margin: 5px 0;
        }
        
        .tembusan li {
            margin-bottom: 3px;
            list-style-type: disc;
        }

        @media print {
            .signature-container {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                page-break-inside: avoid;
                margin-top: 40px;
            }
            
            .signature-box {
                width: 48%;
                margin-bottom: 20px;
            }
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        @media print {
            body {
                width: 100%;
                max-width: 100%;
                padding: 0;
                font-size: 11px;
            }
            .content {
                padding: 0;
            }
            .memo-body {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    @php
    $safeDateFormat = function($date) {
        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('d M Y');
            }
            if (is_string($date)) {
                return \Carbon\Carbon::parse($date)->format('d M Y');
            }
            return '.........................';
        } catch (\Exception $e) {
            return '.........................';
        }
    };

    // Default values
    $leftSignerName = null;
    $leftSignerPosition = null;
    $leftSignerDivision = $memo->dari;
    $leftSignaturePath = null;

    $rightSignerName = null;
    $rightSignerPosition = null;
    $rightSignerDivision = null;
    $rightSignaturePath = null;

    // Cari asisten manager dari divisi asal (sama dengan pembuat memo)
    $originalDivisionAssistant = null;
    
    // Cek di logs untuk mencari siapa asisten manager yang approve dari divisi asal
    $approvalLogs = $memo->logs()->where('aksi', 'disetujui')
                                 ->where('divisi', $memo->dari) // divisi asal memo
                                 ->with('user')
                                 ->get();
    
    foreach ($approvalLogs as $log) {
        if ($log->user && $log->user->role === 'asisten_manager' && $log->user->divisi->nama === $memo->dari) {
            $originalDivisionAssistant = $log->user;
            break;
        }
    }
    
    // Jika tidak ditemukan di logs, cari berdasarkan approved_by yang divisinya sama dengan asal memo
    if (!$originalDivisionAssistant && $memo->approved_by) {
        $approver = \App\Models\User::find($memo->approved_by);
        if ($approver && $approver->divisi->nama === $memo->dari && $approver->role === 'asisten_manager') {
            $originalDivisionAssistant = $approver;
        }
    }

    // Jika masih tidak ada, fallback ke signed_by yang divisinya sama
    if (!$originalDivisionAssistant && $memo->signed_by) {
        $signer = \App\Models\User::find($memo->signed_by);
        if ($signer && $signer->divisi->nama === $memo->dari && $signer->role === 'asisten_manager') {
            $originalDivisionAssistant = $signer;
        }
    }

    // Set signature berdasarkan asisten manager dari divisi asal
    if ($originalDivisionAssistant) {
        $leftSignerName = $originalDivisionAssistant->name;
        $leftSignerPosition = 'Asisten Manager';
        $leftSignerDivision = $originalDivisionAssistant->divisi->nama;
        
        // Cari signature yang tepat
        if ($memo->signature_path) {
            $leftSignaturePath = $memo->signature_path;
        } elseif ($originalDivisionAssistant->signature) {
            $leftSignaturePath = $originalDivisionAssistant->signature;
        }
    } else {
        // Fallback ke pembuat memo jika tidak ada asisten manager yang approve
        if ($memo->dibuatOleh) {
            $leftSignerName = $memo->dibuatOleh->name;
            $leftSignerPosition = $memo->dibuatOleh->role === 'asisten_manager' ? 'Asisten Manager' : 'Staff';
            $leftSignerDivision = $memo->dibuatOleh->divisi->nama ?? $memo->dari;
            
            if ($memo->dibuatOleh->signature) {
                $leftSignaturePath = $memo->dibuatOleh->signature;
            }
        }
    }
    
    // Manager signature (jika ada)
    if ($memo->manager_signature_path && $memo->manager_signed) {
        $managerUser = null;
        if ($memo->forwarded_by) {
            $managerUser = \App\Models\User::find($memo->forwarded_by);
        } elseif ($memo->signed_by) {
            $managerUser = \App\Models\User::find($memo->signed_by);
            // Pastikan ini manager, bukan asisten manager
            if ($managerUser && $managerUser->role !== 'manager') {
                $managerUser = null;
            }
        }

        if ($managerUser && $managerUser->role === 'manager') {
            $rightSignerName = $managerUser->name;
            $rightSignerPosition = 'Manager';
            $rightSignerDivision = 'Manager';
            $rightSignaturePath = $memo->manager_signature_path;
        }
    }
    @endphp

    <div class="header">
        <h2>MEMO INTERNAL</h2>
    </div>
    
    <div class="content">
        <div class="memo-details">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->nomor }}</td>
                </tr>
                <tr>
                    <td class="label">Kepada</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->kepada }}</td>
                </tr>
                <tr>
                    <td class="label">Dari</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->dari }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->perihal }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="colon">:</td>
                    <td>{{ $safeDateFormat($memo->tanggal) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="memo-body">
            {!! $memo->isi !!}
        </div>
        
        <div class="closing-text">
            Demikian disampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.
        </div>
        
        <div class="signature-container">
            <!-- Signature Utama (Kiri) - Asisten Manager yang menandatangani -->
            @if($leftSignerName)
            <div class="signature-box signature-left">
                <div class="signature-header">Hormat kami,</div>
                <div class="signature-position-text">{{ $leftSignerDivision }}</div>
                
                @if($leftSignaturePath)
                    <img src="{{ public_path('storage/'.$leftSignaturePath) }}" 
                        class="signature-img" 
                        alt="Tanda Tangan">
                @else
                    <div class="signature-placeholder" style="height:60px;"></div>
                @endif
                
                <div class="signature-name">{{ $leftSignerName }}</div>
                <div class="signature-position">{{ $leftSignerPosition }}</div>
            </div>
            @endif

            <!-- Signature Manager (Kanan) - Jika ada manager yang juga menandatangani -->
            @if($rightSignerName)
            <div class="signature-box signature-right">
                <div class="signature-header">Disetujui oleh,</div>
                <div class="signature-position-text">{{ $rightSignerDivision }}</div>
                
                @if($rightSignaturePath)
                    <img src="{{ public_path('storage/'.$rightSignaturePath) }}" 
                        class="signature-img" 
                        alt="Tanda Tangan Manager">
                @else
                    <div class="signature-placeholder" style="height:60px;"></div>
                @endif
                
                <div class="signature-name">{{ $rightSignerName }}</div>
                <div class="signature-position">{{ $rightSignerPosition }}</div>
            </div>
            @endif
        </div>
        
        @if(isset($memo->tembusan) && $memo->tembusan)
        <div class="tembusan">
            <h4>Tembusan :</h4>
            <ul>
                @if(is_array($memo->tembusan))
                    @foreach($memo->tembusan as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                @else
                    <li>Manager</li>
                    <li>Asisten Manager terkait</li>
                    <li>Arsip</li>
                @endif
            </ul>
        </div>
        @endif
    </div>
</body>
</html>