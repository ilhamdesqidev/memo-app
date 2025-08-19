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
        
        /* Dual Signature Container */
        .signature-container { 
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            gap: 30px;
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

        /* Responsive untuk signature pada print */
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

    $firstSignerName = 'Pejabat Berwenang';
    $firstSignerPosition = 'Asisten Manager';
    $firstSignerDivision = $memo->dari;
    $firstSignaturePath = null;

    $secondSignerName = null;
    $secondSignerPosition = null;
    $secondSignerDivision = null;
    $secondSignaturePath = null;

    if ($memo->signature_path) {
        if ($memo->dibuatOleh) {
            $firstSignerName = $memo->dibuatOleh->name;
            $firstSignerPosition = $memo->dibuatOleh->role === 'asisten_manager' ? 'Asisten Manager' : 'Staff';
            $firstSignerDivision = $memo->dibuatOleh->divisi->nama ?? $memo->dari;
        }
        $firstSignaturePath = $memo->signature_path;
    } elseif ($memo->dibuat_oleh_user_id) {
        $creator = \App\Models\User::find($memo->dibuat_oleh_user_id);
        if ($creator) {
            $firstSignerName = $creator->name;
            $firstSignerPosition = $creator->role === 'asisten_manager' ? 'Asisten Manager' : 'Staff';
            $firstSignerDivision = $creator->divisi->nama ?? $memo->dari;
            if ($creator->signature && (!$memo->manager_signed || !$memo->manager_signature_path)) {
                $firstSignaturePath = $creator->signature;
            }
        }
    }

    if ($memo->manager_signature_path && $memo->manager_signed) {
        $managerUser = null;
        if ($memo->forwarded_by) {
            $managerUser = \App\Models\User::find($memo->forwarded_by);
        } elseif ($memo->signed_by) {
            $managerUser = \App\Models\User::find($memo->signed_by);
        }

        if ($managerUser && $managerUser->role === 'manager') {
            $secondSignerName = $managerUser->name;
            $secondSignerPosition = 'Manager';
            $secondSignerDivision = 'Manager';
            $secondSignaturePath = $memo->manager_signature_path;
        }
    } elseif ($memo->signature_path && $memo->manager_signed && $memo->signed_by) {
        $managerSigner = \App\Models\User::find($memo->signed_by);
        if ($managerSigner && $managerSigner->role === 'manager') {
            $secondSignerName = $managerSigner->name;
            $secondSignerPosition = 'Manager';
            $secondSignerDivision = 'Manager';
            $secondSignaturePath = $memo->signature_path;
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
        
        <div class="signature-box">
            <div class="signature-header">Hormat kami,</div>
            <div class="signature-position-text">{{ $memo->dari }}</div>
            
            @if($memo->signature_path)
                <img src="{{ public_path('storage/'.$memo->signature_path) }}" 
                    class="signature-img" 
                    alt="Tanda Tangan Pembuat">
            @elseif($memo->dibuatOleh && $memo->dibuatOleh->signature)
                <img src="{{ public_path('storage/'.$memo->dibuatOleh->signature) }}" 
                    class="signature-img" 
                    alt="Tanda Tangan Pembuat">
            @else
                <div class="signature-placeholder" style="height:60px;"></div>
            @endif
            
            <div class="signature-name">{{ $memo->dibuatOleh->name ?? 'Pembuat Memo' }}</div>
        </div>

        <!-- Tanda tangan Manager (jika ada) -->
        @if($memo->manager_signature_path || ($memo->forwarded_by && $memo->forwardedBy->signature))
        <div class="signature-box">
            <div class="signature-header">Disetujui oleh,</div>
            <div class="signature-position-text">Manager</div>
            
            @if($memo->manager_signature_path)
                <img src="{{ public_path('storage/'.$memo->manager_signature_path) }}" 
                    class="signature-img" 
                    alt="Tanda Tangan Manager">
            @elseif($memo->forwarded_by && $memo->forwardedBy->signature)
                <img src="{{ public_path('storage/'.$memo->forwardedBy->signature) }}" 
                    class="signature-img" 
                    alt="Tanda Tangan Manager">
            @else
                <div class="signature-placeholder" style="height:60px;"></div>
            @endif
            
            <div class="signature-name">{{ $memo->forwardedBy->name ?? 'Manager' }}</div>
        </div>
        @endif
        
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