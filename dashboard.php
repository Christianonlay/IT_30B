<?php 
$host = 'localhost';
$db   = 'it30b_lab_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ---------- 1. KPI COUNTS ----------
$studentCount  = $pdo->query("SELECT COUNT(*) FROM student")->fetchColumn();
$bookCount     = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$totalBorrows  = $pdo->query("SELECT COUNT(*) FROM borrow")->fetchColumn();
$activeBorrows = $pdo->query("SELECT COUNT(*) FROM borrow WHERE borrow_return_date IS NULL")->fetchColumn();

// ---------- 2. BOOKS BY CATEGORY ----------
$catStmt = $pdo->query("
    SELECT book_category, COUNT(*) AS cnt
    FROM books
    GROUP BY book_category
    ORDER BY cnt DESC
");
$categories = [];
$categoryCounts = [];
while ($row = $catStmt->fetch()) {
    $categories[]     = $row['book_category'];
    $categoryCounts[] = (int) $row['cnt'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            font-family: Roboto, Arial, sans-serif;
            color: #212121;
        }

        /* MAIN DASHBOARD CONTAINER */
        .dashboard {
            width: 100%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        /* STATISTICS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            width: 100%;
            margin: 20px auto 25px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            min-height: 100px;
            border-top: 3px solid #1976d2;
            border-radius: 2px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: 0.3s;
        }

        .stat-card:nth-child(2) {
            border-top-color: #4caf50;
        }

        .stat-card:nth-child(3) {
            border-top-color: #ff9800;
        }

        .stat-card:nth-child(4) {
            border-top-color: #f44336;
        }

        .stat-card:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: #757575;
            text-transform: uppercase;
        }

        .stat-header .material-icons {
            font-size: 20px;
            color: #bdbdbd;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 400;
            line-height: 1.3;
        }

        .stat-sub {
            font-size: 12px;
            color: #9e9e9e;
        }

        /* CHART CENTER */
        .charts-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 20px auto;
        }

        .chart-card {
            background: white;
            width: 360px;
            max-width: 100%;
            padding: 15px;
            border-radius: 2px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .chart-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .chart-title span {
            color: #1976d2;
            font-size: 10px;
            text-transform: uppercase;
        }

        canvas {
            width: 100% !important;
            max-height: 180px;
        }

        /* RESPONSIVE */
        @media (max-width: 760px) {
            .dashboard {
                padding: 10px;
                margin: 15px auto;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 400px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="dashboard">

    <!-- STATISTICS -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Students</span>
                <span class="material-icons">school</span>
            </div>
            <div class="stat-number"><?= $studentCount ?></div>
            <div class="stat-sub">enrolled</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Books</span>
                <span class="material-icons">auto_stories</span>
            </div>
            <div class="stat-number"><?= $bookCount ?></div>
            <div class="stat-sub">in collection</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Borrow Records</span>
                <span class="material-icons">history</span>
            </div>
            <div class="stat-number"><?= $totalBorrows ?></div>
            <div class="stat-sub">all time</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Active Loans</span>
                <span class="material-icons">pending_actions</span>
            </div>
            <div class="stat-number"><?= $activeBorrows ?></div>
            <div class="stat-sub">not returned</div>
        </div>

    </div>

    <!-- BOOKS BY CATEGORY CHART -->
    <div class="charts-grid">

        <div class="chart-card">

            <div class="chart-title">
                <h4>Books by category</h4>
                <span>Category Collection</span>
            </div>

            <canvas id="categoryChart"></canvas>

        </div>

    </div>

</div>

<script>
    const colors = {
        blue: '#1976d2',
        green: '#4caf50',
        orange: '#ff9800',
        red: '#f44336',
        purple: '#9c27b0',
        grey: '#9e9e9e'
    };

    const catCtx = document
        .getElementById('categoryChart')
        .getContext('2d');

    new Chart(catCtx, {
        type: 'doughnut',

        data: {
            labels: <?= json_encode($categories) ?>,

            datasets: [{
                data: <?= json_encode($categoryCounts) ?>,

                backgroundColor: [
                    colors.blue,
                    colors.green,
                    colors.orange,
                    colors.red,
                    colors.purple,
                    colors.grey
                ],

                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',

            plugins: {
                legend: {
                    position: 'bottom',

                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        padding: 12,
                        font: {
                            size: 10
                        },
                        color: '#616161'
                    }
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;

                            const total = context.dataset.data.reduce(
                                (a, b) => a + b, 0
                            );

                            const pct = total > 0
                                ? ((value / total) * 100).toFixed(0)
                                : 0;

                            return `${label}: ${value} (${pct}%)`;
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
