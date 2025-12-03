<?php
    include 'inc/header.php';

    $sql_query = 'SELECT * FROM equipments';
    $equipments = mysqli_query($conn, $sql_query);
    $results = mysqli_fetch_all($equipments, MYSQLI_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>equipments</title>
</head>
<body>
<div class="w-full">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Equipments</h1>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-lg shadow-lg bg-neutral-100">
        <table class="w-full text-sm">
            <!-- Table Header -->
            <thead>
                <tr class="">
                    <th class="px-6 py-4 text-left font-semibold">ID</th>
                    <th class="px-6 py-4 text-left font-semibold">name</th>
                    <th class="px-6 py-4 text-left font-semibold">type</th>
                    <th class="px-6 py-4 text-left font-semibold">Quantity</th>
                    <th class="px-6 py-4 text-left font-semibold">State</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-200">
                <?php foreach($results as $result) { ?>
                    <tr class="bg-white  transition-colors duration-150 ease-in-out">

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                <?php echo htmlspecialchars($result['id']); ?>
                            </span>
                        </td>


                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900 ">
                                <?php echo htmlspecialchars($result['name']); ?>
                            </p>
                        </td>


                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300">
                                <?php echo htmlspecialchars($result['type']); ?>
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <p class="text-gray-700 ">
                                <?php echo htmlspecialchars($result['quantity']); ?>
                            </p>
                        </td>


                        <td class="px-6 py-4">
                            <p class="text-gray-700  font-medium">
                                <?php echo htmlspecialchars($result['state']); ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>