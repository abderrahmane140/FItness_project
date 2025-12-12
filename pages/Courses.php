<?php
ob_start();
session_start();


if(!isset($_SESSION['user'])){
  header("Location: ../pages/login.php");
  exit();
}
require __DIR__ . '/../inc/header.php';



    $sql_query = 'SELECT * FROM courses';
    $courses = mysqli_query($conn, $sql_query);
    $results = mysqli_fetch_all($courses, MYSQLI_ASSOC);


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = intval($_POST['id'] ?? 0);
        $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
        $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
        $date = $_POST['date'] ?? '';
        $start_hour = mysqli_real_escape_string($conn, $_POST['start_hour'] ?? '');
        $duration = mysqli_real_escape_string($conn, $_POST['duration'] ?? '');
        $max_participants = intval($_POST['max_participants'] ?? 0);
        $selctedequipments = $_POST['equipments'] ?? [];


        if($title && $category && $date && $start_hour && $duration && $max_participants){
            if($id > 0){
                $sql = "UPDATE courses SET 
                        title='$title', 
                        category='$category', 
                        date='$date', 
                        start_hour='$start_hour', 
                        duration='$duration', 
                        max_participants=$max_participants
                        WHERE id=$id";
                        mysqli_query($conn, $sql);

                        //remove the old equipmenst
                        mysqli_query($conn, "DELETE FROM course_equipments WHERE course_id = $id");


                        foreach($selctedequipments as $eqID){
                          $eqId = intval($eqId);
                          mysqli_query($conn, "INSERT INTO course_equipments (course_id, equipment_id) VALUES ($id , $eqID)");
                        }
            }else {
                $sql = "INSERT INTO courses (title, category, date, start_hour, duration, max_participants) 
                VALUES ('$title', '$category', '$date', '$start_hour', '$duration', $max_participants)";
                mysqli_query($conn, $sql);

                //get the last id insrted 

                $newId = mysqli_insert_id($conn);
                foreach($selctedequipments as $eqID){
                  $eqID = intval($eqID);
                  mysqli_query($conn, "INSERT INTO course_equipments (course_id, equipment_id) VALUES ($newId , $eqID)");
                }
            }


            
            header("location: " .$_SERVER['PHP_SELF']);
            exit;
        }

    }

    //delete fun

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
        $delete_id = intval($_POST['delete_id']);
        
        mysqli_query($conn, "DELETE FROM course_equipments WHERE course_id = $delete_id");
        $sql_delete = "DELETE FROM courses WHERE id = $delete_id ";
        mysqli_query($conn, $sql_delete);
        header('Location: '. $_SERVER['PHP_SELF']);
        exit;
    }
    

    //fetch all the equipments 

    $sql_equipments  = "SELECT * FROM equipments";
    $result = mysqli_query($conn, $sql_equipments);
    $equipments = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>



<section class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50" id="modal">
    <div class="w-full sm:max-w-md modal-card bg-white rounded-2xl p-6 shadow-2xl mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-green-600" id="modal-title">Create Course</h3>
            <button id="closeBtn" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>

        <form class="space-y-3" id="form" method="POST">
            <input type="hidden" name="id" id="course-id" value="0">

            <input class="w-full rounded border px-3 py-2" placeholder="Title" name="title" id="title" type="text" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Category" name="category" id="category" type="text" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Date" type="date" name="date" id="date" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Start hour" type="text" name="start_hour" id="start_hour" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Duration" type="text" name="duration" id="duration" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Max participants" type="number" name="max_participants" id="max_participants" required />
            

            <!-- equipments section -->
            <div class="relative w-full" x-data="{ open: false }">
                <!-- Dropdown button -->
                <button 
                    type="button" 
                    class="w-full bg-white border rounded px-3 py-2 text-left flex justify-between items-center"
                    onclick="document.getElementById('equipment-dropdown').classList.toggle('hidden')"
                >
                    Select Equipments
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div 
                    id="equipment-dropdown"
                    class="hidden absolute mt-1 w-full bg-white border rounded shadow-lg max-h-60 overflow-auto z-50"
                >
                    <?php foreach($equipments as $equ) { ?>
                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="equipments[]" value="<?php echo $equ['id'] ?>" class="mr-2">
                            <?php echo $equ['name'] ?>
                        </label>
                    <?php } ?>
                </div>
            </div>


            <button type="submit" class="w-full bg-sky-600 text-white rounded px-3 py-2" id="submit-btn">Save</button>
        </form>
    </div>
</section>

<div class="w-full bg-neutral-50 p-6 rounded-lg">
  <!-- Header Section -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-neutral-900 mb-1">Courses</h1>
      <p class="text-sm text-neutral-500">Manage scheduled courses — quick glance and actions.</p>
    </div>

    <div class="flex items-center gap-3">
      <!-- lightweight search (optional visually only) -->

      <button id="btnOpen" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white rounded-md px-4 py-2 text-sm font-medium shadow-sm">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add
      </button>
    </div>
  </div>

  <!-- Table Container -->
  <div class="overflow-x-auto rounded-lg shadow-sm border border-neutral-200 bg-white">
    <table class="w-full text-sm">
      <!-- Table Header (sticky on top) -->
      <thead class="bg-neutral-50">
        <tr>
          <th class="px-4 py-3 text-left font-medium text-neutral-600">ID</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600">Title</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600 hidden sm:table-cell">Category</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600">Date</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600 hidden md:table-cell">Start Time</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600 hidden lg:table-cell">Duration</th>
          <th class="px-4 py-3 text-left font-medium text-neutral-600">Max</th>
        </tr>
      </thead>

      <!-- Table Body -->
      <tbody class="divide-y divide-neutral-100">
        <?php foreach($results as $result) { ?>
          <tr class="bg-white hover:bg-neutral-50 transition-colors">
            <!-- ID Column -->
            <td class="px-4 py-3 align-middle">
              <span class="inline-flex items-center justify-center w-8 h-8 bg-sky-50 text-sky-600 rounded-full text-xs font-semibold">
                <?php echo htmlspecialchars($result['id']); ?>
              </span>
            </td>

            <!-- Title Column -->
            <td class="px-4 py-3 align-middle">
              <p class="font-medium text-neutral-900">
                <?php echo htmlspecialchars($result['title']); ?>
              </p>
              <p class="text-xs text-neutral-400 mt-1 sm:hidden"><?php echo htmlspecialchars($result['category']); ?></p>
            </td>

            <!-- Category Column -->
            <td class="px-4 py-3 align-middle hidden sm:table-cell">
              <?php if (!empty($result['category'])) { ?>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                  <?php echo htmlspecialchars($result['category']); ?>
                </span>
              <?php } else { ?>
                <span class="text-xs text-neutral-400">—</span>
              <?php } ?>
            </td>

            <!-- Date Column -->
            <td class="px-4 py-3 align-middle">
              <p class="text-neutral-800"><?php echo $result['date']; ?></p>
            </td>

            <!-- Start Hour Column -->
            <td class="px-4 py-3 align-middle hidden md:table-cell">
              <p class="text-neutral-800 font-medium"><?php echo $result['start_hour']; ?></p>
            </td>

            <!-- Duration Column -->
            <td class="px-4 py-3 align-middle hidden lg:table-cell">
              <p class="text-neutral-800"><?php echo $result['duration']; ?></p>
            </td>

            <!-- Max Participants Column -->
            <td class="px-4 py-3 align-middle">
              <div class="flex items-center gap-2">
                <span class="px-2 py-1 bg-orange-50 text-orange-700 rounded text-xs font-semibold">
                  <?php echo $result['max_participants']; ?>
                </span>
              </div>
            </td>
            <!-- edit button  -->
            <td>
                <button class="edit-btn bg-emerald-500 text-white px-2 py-1 rounded text-xs" 
                    data-id="<?php echo $result['id']; ?>" 
                    data-title="<?php echo htmlspecialchars($result['title']); ?>"
                    data-category="<?php echo htmlspecialchars($result['category']); ?>"
                    data-date="<?php echo $result['date']; ?>"
                    data-start_hour="<?php echo $result['start_hour']; ?>"
                    data-duration="<?php echo $result['duration']; ?>"
                    data-max_participants="<?php echo $result['max_participants']; ?>"><i class="fas fa-edit"></i></button>
            </td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="delete_id" value="<?php echo $result['id']?>">
                    <button type="submit" class="delete-btn bg-red-500 text-white px-2 py-1 rounded text-xs">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const btnOpen = document.getElementById('btnOpen');
const btnClose = document.getElementById('closeBtn');
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modal-title');
const form = document.getElementById('form');
const courseIdInput = document.getElementById('course-id');

    btnOpen.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modalTitle.innerText = "Create Course";
        courseIdInput.value = 0;
        form.reset();
    });

    btnClose.addEventListener('click', () => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    });

    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalTitle.innerText = "Update Course";

            courseIdInput.value = btn.dataset.id;
            form.title.value = btn.dataset.title;
            form.category.value = btn.dataset.category;
            form.date.value = btn.dataset.date;
            form.start_hour.value = btn.dataset.start_hour;
            form.duration.value = btn.dataset.duration;
            form.max_participants.value = btn.dataset.max_participants;
        });
    });
</script>
