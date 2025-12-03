<?php include 'inc/header.php'?>
<?php
    $sql_courses = 'SELECT * FROM courses';    
    $result_courses = mysqli_query($conn, $sql_courses);        
    $courses = mysqli_fetch_all($result_courses, MYSQLI_ASSOC);
    
    $sql_equipments = 'SELECT * FROM equipments';    
    $result_equipments = mysqli_query($conn, $sql_equipments);    
    $equipments = mysqli_fetch_all($result_equipments, MYSQLI_ASSOC);
?>

<!-- Main Container -->
<div class="min-h-screen p-8">
  <div class="max-w-7xl mx-auto">
    
    <!-- Header Section -->
    <div class="mb-12">
      <h1 class="text-4xl font-bold  mb-2">Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
      <!-- Courses Card -->
      <div class="group bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-blue-100 text-sm font-medium mb-2">Total Courses</p>
            <p class="text-5xl font-bold text-white"><?php echo count($courses); ?></p>
          </div>
          <div class="bg-blue-500 bg-opacity-30 p-4 rounded-lg">
                <i class="fas fa-running text-white text-xl"></i>
          </div>
        </div>
      </div>

      <!-- Equipment Card -->
      <div class="group bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-emerald-100 text-sm font-medium mb-2">Total Equipment</p>
            <p class="text-5xl font-bold text-white"><?php echo count($equipments); ?></p>
          </div>
          <div class="bg-emerald-500 bg-opacity-30 p-4 rounded-lg">
            <i class="fas fa-basketball-ball text-white text-xl"></i>

          </div>
        </div>
      </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      
      <!-- Courses Section -->
      <div class="bg-neutral-100 rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4">
          <h2 class="text-xl font-bold">Available Courses</h2>
        </div>
        <div class="divide-y divide-slate-700 max-h-96 overflow-y-auto">
          <?php foreach($courses as $course) { ?>
            <div class="p-6 hover:bg-neutral-200 transition-colors duration-200">
              <h3 class="text-lg font-semibold  mb-2"><?php echo htmlspecialchars($course['title']); ?></h3>
              <div class="flex items-center  text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?php echo htmlspecialchars($course['duration']); ?></span>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <!-- Equipment Section -->
      <div class="bg-neutral-100 rounded-lg shadow-lg overflow-hidden">
        <div class="text-black px-6 py-4">
          <h2 class="text-xl font-bold">Available Equipment</h2>
        </div>
        <div class="divide-y divide-slate-700 max-h-96 overflow-y-auto">
          <?php foreach($equipments as $equipment) { ?>
            <div class="p-6 hover:bg-neutral-200 transition-colors duration-200">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($equipment['name']); ?></h3>
                <span class="bg-emerald-500 bg-opacity-20 text-emerald-500 px-3 py-1 rounded-full text-sm font-medium">
                  <?php echo htmlspecialchars($equipment['quantity']); ?> in stock
                </span>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?php include 'inc/footer.php'?>