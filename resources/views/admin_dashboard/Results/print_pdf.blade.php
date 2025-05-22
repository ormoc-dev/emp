<!DOCTYPE html>
<html>
<head>
    <title>Print PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-bottom: 2px solid #ddd;
            background-color: #ffffff;
        }
        .header .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 10px;
        }
        .header .title {
            text-align: center;
            flex: 1;
            margin: 0 20px;
        }
        .header h1 {
            margin: 5px 0 0 0;
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #555;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #777;
            font-style: italic;
        }
        .table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
        }
        .table thead th {
            background-color: #dfe2e4;
            color: #030202;
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table .highlight {
            color: #050505;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .title-section, .signature {
            text-align: center;
            width: 90%;
            margin: 20px auto;
        }
        .signature .line {
            width: 300px;
            border-bottom: 1px solid #000;
            margin: 20px auto;
        }
        .signature-label {
            font-weight: bold;
        }
        .right{
            float: right;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <img src="./img/emp.jpg" alt="Left Logo" class="logo">
        <img src="./img/ict.jpg" alt="Right Logo" class="logo right">
        <div class="title">
            <h1>WESTERN LEYTE COLLEGE OF ORMOC</h1>
            <h3>A. Bonifacio St. Ormoc City</h3>
            <p><i>College of ICT and Engineering</i></p>
        </div>
    </div>

    @if($tableType === 'criteria_winner')
        <!-- Criteria Winner Table -->
        <div class="title-section">
            <h3 class="title">Criteria Winner</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Criteria</th>
                    <th>Winner</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($round->criteria as $criteria)
                    @php
                        $winnerData = $criteriaWinners[$criteria->id] ?? null;
                    @endphp
                    @if ($winnerData)
                        @php
                            $winner = $contestants->find($winnerData['contestant_id']);
                        @endphp
                        @if ($winner)
                            <tr class="highlight">
                                <td>{{ $criteria->criteria_description }}</td>
                                <td>{{ $winner->name }}</td>
                                <td>{{ $winnerData['score'] }}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3">No winner for this criteria.</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan="3">No winner for this criteria.</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @elseif($tableType === 'all_criteria_results')
        <!-- All Criteria Results Table -->
        <div class="title-section">
            <h3 class="title">All Criteria Results</h3>
        </div>
        @foreach ($round->criteria as $criteria)
            <h4>{{ $criteria->criteria_description }}</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Contestant</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($scores[$criteria->id]))
                        @foreach ($scores[$criteria->id] as $contestantId => $contestantScores)
                            @php
                                $contestant = $contestants->find($contestantId);
                                $totalScore = $contestantScores->sum('rate');
                            @endphp
                            <tr>
                                <td>{{ $contestant->name }}</td>
                                <td>{{ $totalScore }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">No scores available for this criteria.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
    @elseif($tableType === 'overall_scores')
        <!-- Overall Scores Table -->
        <div class="title-section">
            <h3 class="title">Overall Scores</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Contestant</th>
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($totalScores))
                    @php
                        $contestantData = [];
                        foreach ($totalScores as $contestantId => $totalScore) {
                            $contestant = $contestants->find($contestantId);
                            $contestantData[] = ['name' => $contestant->name, 'totalScore' => $totalScore];
                        }
                        usort($contestantData, function($a, $b) {
                            return $b['totalScore'] <=> $a['totalScore'];
                        });
                    @endphp
                    @foreach ($contestantData as $data)
                        <tr>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['totalScore'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">No total scores available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif

    <!-- Signature Section -->
    <div class="signature">
        <div class="line"></div>
        <span class="signature-label">Chairman</span>
    </div>
</body>
</html>
