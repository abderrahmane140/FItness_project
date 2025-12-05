

<?php
require __DIR__ . '/inc/header.php';

session_start();
if(!isset($_SESSION['user'])){
  header('Location: pages/login.php');
  exit();
}

function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

// Fetch courses
$sql_courses = 'SELECT * FROM courses';
$result_courses = mysqli_query($conn, $sql_courses);
$courses = mysqli_fetch_all($result_courses, MYSQLI_ASSOC);

// Fetch equipments
$sql_equipments = 'SELECT * FROM equipments';
$result_equipments = mysqli_query($conn, $sql_equipments);
$equipments = mysqli_fetch_all($result_equipments, MYSQLI_ASSOC);
?>

<!-- Main Container -->
<div class="min-h-screen ">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Top bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
      <div>
        <h1 class="text-3xl font-extrabold text-neutral-900 leading-tight">Dashboard</h1>
        <p class="text-sm text-neutral-500 mt-1">Welcome back <strong><?php echo $_SESSION['user']; ?></strong>— here's a quick snapshot of your gym data.</p>
      </div>

      <div class="flex items-center gap-3">
        <div class="relative">
          <input type="text" id="search" placeholder="Search courses or equipment..." class="w-64 pl-10 pr-3 py-2 rounded-lg border border-neutral-200 bg-white text-sm placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-sky-300" />
          <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"></path>
          </svg>
        </div>

        <input type="date" class="px-3 py-2 rounded-lg border border-neutral-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-300" />

        <button class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md text-sm text-neutral-700">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Add
        </button>

        <div class="flex items-center gap-3">
          <img src="https://ui-avatars.com/api/?name=JD&background=2dd4bf&color=fff&rounded=true" alt="avatar" class="w-9 h-9 rounded-full shadow-sm" />
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <div class="bg-white rounded-xl p-5 border border-neutral-100 shadow-sm">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-sky-50">
            <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path></svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-neutral-400">Courses</p>
            <p class="text-2xl font-bold text-neutral-900"><?php echo count($courses); ?></p>
            <p class="text-xs text-neutral-500 mt-1">Total available</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-neutral-100 shadow-sm">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-emerald-50">
            <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h3l3-4h6a2 2 0 002-2V7"></path></svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-neutral-400">Equipment</p>
            <p class="text-2xl font-bold text-neutral-900"><?php echo count($equipments); ?></p>
            <p class="text-xs text-neutral-500 mt-1">Different items</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-neutral-100 shadow-sm">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-orange-50">
            <svg class="w-6 h-6 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 3.134-7 7"></path></svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-neutral-400">Active Members</p>
            <p class="text-2xl font-bold text-neutral-900">—</p>
            <p class="text-xs text-neutral-500 mt-1">Connect member data</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 border border-neutral-100 shadow-sm">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-sky-50">
            <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
          </div>
          <div class="flex-1">
            <p class="text-xs text-neutral-400">Open Tasks</p>
            <p class="text-2xl font-bold text-neutral-900">—</p>
            <p class="text-xs text-neutral-500 mt-1">No pending tasks</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      <!-- Courses list -->
      <div class="lg:col-span-2 bg-white rounded-xl border border-neutral-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100">
          <div>
            <h2 class="text-lg font-bold text-neutral-900">Available Courses</h2>
            <p class="text-sm text-neutral-500 mt-1"><?php echo count($courses); ?> total</p>
          </div>
        </div>

        <div id="coursesList" class="divide-y divide-neutral-100 max-h-[580px] overflow-y-auto">
          <?php foreach($courses as $course) { ?>
            <div class="p-5 hover:bg-neutral-50 transition-colors flex items-start gap-4">
              <div class="flex-none">
                <div class="w-12 h-12 rounded-lg bg-sky-50 flex items-center justify-center">
                  <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path></svg>
                </div>
              </div>

              <div class="flex-1">
                <h3 class="text-base font-semibold text-neutral-900"><?php echo e($course['title']); ?></h3>
                <p class="text-sm text-neutral-500 mt-1"><?php echo e($course['duration']); ?> • <?php echo e($course['created_at'] ?? ''); ?></p>
                <?php if(!empty($course['category'])) { ?>
                  <span class="inline-block text-xs bg-sky-50 text-sky-600 px-2 py-1 rounded-full mt-2"><?php echo e($course['category']); ?></span>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <!-- Equipment panel -->
      <div class="bg-white rounded-xl border border-neutral-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-neutral-100">
          <h2 class="text-lg font-bold text-neutral-900">Equipment</h2>
          <p class="text-sm text-neutral-500 mt-1"><?php echo count($equipments); ?> items</p>
        </div>

        <div id="equipmentsList" class="divide-y divide-neutral-100 max-h-[580px] overflow-y-auto">
          <?php foreach($equipments as $equipment) { ?>
            <div class="p-5 hover:bg-neutral-50 transition-colors flex items-center justify-between gap-4">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center">
                  <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 3.134-7 7"></path></svg>
                </div>
                <div>
                  <h3 class="text-base font-semibold text-neutral-900"><?php echo e($equipment['name']); ?></h3>
                  <p class="text-sm text-neutral-500 mt-1"><?php echo e($equipment['type'] ?? ''); ?></p>
                </div>
              </div>

              <div class="text-right">
                <div class="text-sm font-semibold text-neutral-900"><?php echo intval($equipment['quantity']); ?> in stock</div>
                <div class="text-xs text-neutral-500 mt-1"><?php echo e($equipment['state'] ?? ''); ?></div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

    </div>

  </div>
</div>

<?php require __DIR__ . '/inc/footer.php';?>
