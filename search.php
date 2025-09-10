<?php
session_start();
require "connect.php";

$query = $_GET['query'] ?? '';
$search_results = [];

if (!empty($query)) {
    try {
        $sql = "SELECT d.specialization, d.years_of_experience, a.name AS doctor_name, a.email
                FROM doctor AS d
                JOIN account AS a ON d.user_id = a.user_id
                WHERE d.specialization LIKE ? OR a.name LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_term = "%" . $query . "%";
        $stmt->execute([$search_term, $search_term]);
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-amber-200">
    <nav class="shadow-lg navbar bg-sky-500">
        <div class="flex-1">
            <a class="text-xl btn btn-ghost">Search Results</a>
        </div>
        <div class="flex gap-2">
            <a href="patient_dashboard.php" class="btn btn-ghost">Back to Dashboard</a>
        </div>
    </nav>
    <main class="max-w-6xl p-4 mx-auto">
        <section class="mt-10">
            <h1 class="mb-5 text-2xl font-bold">Search results for "<?= htmlspecialchars($query) ?>"</h1>
            <?php if (!empty($search_results)): ?>
            <div class="overflow-x-auto">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr class="text-gray-700 bg-zinc-400">
                            <th>Doctor Name</th>
                            <th>Specialization</th>
                            <th>Years of Experience</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($search_results as $doctor): ?>
                        <tr>
                            <td><?= htmlspecialchars($doctor['doctor_name']) ?></td>
                            <td><?= htmlspecialchars($doctor['specialization']) ?></td>
                            <td><?= htmlspecialchars($doctor['years_of_experience']) ?></td>
                            <td><?= htmlspecialchars($doctor['email']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-lg text-gray-700">No doctors found matching your search. Try a different query.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
