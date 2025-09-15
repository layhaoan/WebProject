<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "store_db";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    function getSingleValue($conn, $query) {
        $res = $conn->query($query);
        if (!$res) {
            die("SQL error: " . $conn->error . " in query: " . $query);
        }
        return $res->fetch_assoc()['total'] ?? 0;
    }

    // Get totals
    $totalCustomers = getSingleValue($conn, "SELECT COUNT(*) AS total FROM orders");
    $totalOrders    = getSingleValue($conn, "SELECT COUNT(*) AS total FROM orders");
    $totalSales     = getSingleValue($conn, "SELECT SUM(total) AS total FROM orders");

    // Get sales by month
    $salesData = [];
    $sql = "SELECT MONTH(order_date) AS month, SUM(total_amount) AS total 
            FROM orders 
            GROUP BY MONTH(order_date)";
    $res = $conn->query($sql);
    if (!$res) {
        die("SQL error: " . $conn->error . " in query: " . $sql);
    }
    while ($row = $res->fetch_assoc()) {
        $salesData[] = $row;
    }

    $conn->close();
?>

<?php
    $conn = new mysqli("localhost","root","","store_db");
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $profit = $conn->query("SELECT SUM((price - cost_price) * quantity) AS profit FROM order_items")->fetch_assoc()['profit'] ?? 0;
    $profitPercent = ($totalSales > 0) ? round(($profit / $totalSales) * 100, 2) : 0;

    $salesData = [];
    $res = $conn->query("SELECT MONTH(order_date) AS month, SUM(total_amount) AS total FROM orders GROUP BY MONTH(order_date)");
    while ($row = $res->fetch_assoc()) { $salesData[] = $row; }

    $conn->close();
?>


<?php
    $mysqli = new mysqli("localhost", "root", "", "store_db");

    // Fetch monthly totals
    $query = "
        SELECT 
            MONTH(o.order_date) AS month,
            SUM(oi.quantity * oi.price) AS total
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        GROUP BY MONTH(o.order_date)
        ORDER BY month
    ";
    $result = $mysqli->query($query);

    $months = [];
    $totals = [];
    while ($row = $result->fetch_assoc()) {
        $months[] = date("M", mktime(0, 0, 0, $row['month'], 1));
        $totals[] = $row['total'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preload" href="KHKSHSub2.woff2" as="font" type="font/woff2" crossorigin>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="stylesheet" href="css/analytics_items_dashbaords.css">
</head>
<body>
    <div class="header-contain">
        <div class="left-menu">
            <a href="index.php">
                <div class="logo">
                    <i class="fa-solid fa-shop"></i>
                    <h2>SHOES</h2>
                </div>
            </a>
            <div class="menu">
                <li><i class="fa-solid fa-chart-simple"></i><a href="Dashbaord.php">Analytics</a></li>
                <li><i class="fa-solid fa-bag-shopping"></i><a href="stock-products.php">Product</a></li>
                <li><i class="fa-solid fa-users"></i><a href="customer.php">Customer List</a></li>
                <li><i class="fa-solid fa-table-list"></i><a href="categories_list.php">Categories</a></li>
                <li><i class="fa-solid fa-gear"></i><a href="#">Setting</a></li>
            </div>
        </div>

        <div class="right-menu">
            <h1><i class="fa-solid fa-chart-gantt"></i> Analytics Dashboard</h1>
            <div class="dashboard">
                <div class="cart_item">
                    <span>Total Customers</span>
                    <h2><?php echo $totalCustomers; ?></h2>
                    <button><i class="fa-solid fa-users"></i></button>
                </div>

                <!--
                    <div class="cart_item">
                        <span>Total Orders</span>
                        <h2><?php echo $totalOrders; ?></h2>
                        <button><i class="fa-solid fa-chart-line"></i></button>
                    </div>
                -->

                <div class="cart_item">
                    <span>Total Sales ($)</span>
                    <h2>$<?php echo number_format($totalSales,2); ?></h2>
                    <button><i class="fa-solid fa-money-bills"></i></button>
                </div>

                <div class="cart_item">
                    <span>Profit</span>
                    <h2><?= number_format($profit,2)?>%</h2>
                    <p>(<?= $profitPercent ?>%)</p>
                    <button><i class="fa-solid fa-chart-pie"></i></button>
                </div>
                
                <div class="chart-container">
                    <h2 style="text-align:center; color:#333;">Monthly Sales Analytics</h2>
                    <canvas id="salesChart"></canvas>
                </div>
                
            </div>

            
            
        </div>

    </div>

        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',  // change to 'line' for line chart
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                        label: 'Sales',
                        data: <?php echo json_encode($totals); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: '#36a2eb',
                        borderWidth: 3,
                        hoverBackgroundColor: 'rgba(54, 162, 235, 0.8)',
                        hoverBorderColor: '#1d7ed6',
                        fill: true
                    }]
                },
                options: {
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#333' }
                        },
                        tooltip: {
                            backgroundColor: '#36a2eb',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        },
                        datalabels: {
                            color: '#333',
                            anchor: 'end',
                            align: 'top',
                            font: { weight: 'bold' },
                            formatter: (value) => '$' + value
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: '#ececec' },
                            ticks: { color: '#333' }
                        },
                        y: {
                            grid: { color: '#ececec' },
                            ticks: { color: '#333' }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        </script>

</body>
</html>