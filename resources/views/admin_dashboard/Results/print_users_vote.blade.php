<!-- resources/views/admin_dashboard/Results/print_scores.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Combined Scores - Print View</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            padding: 40px;
            color: #1f2937;
            line-height: 1.5;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th {
            background: #1e40af;
            color: white;
            font-weight: 600;
            padding: 12px;
            text-align: center;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }
        
        tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .contestant-name {
            font-weight: 600;
            text-align: left;
        }
        
        .total-score {
            font-weight: 700;
            color: #1e40af;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }
        
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $eventTitle }}</h1>
        <p>Generated on {{ now()->format('F j, Y, g:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Contestant Name</th>
                <th>Number</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scores as $index => $score)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="contestant-name">{{ $score['name'] }}</td>
                    <td>{{ $score['number'] }}</td>
                    <td class="total-score">{{ $score['total_score'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Official Results - {{ $eventTitle }}</p>
    </div>

    <button class="no-print" onclick="window.print()" style="
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        background: #1e40af;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    ">
        Print Report
    </button>
</body>
</html>