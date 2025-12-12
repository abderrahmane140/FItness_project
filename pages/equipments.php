<?php
ob_start();
session_start();


if(!isset($_SESSION['user'])){
    header("Location: ../pages/login.php");
    exit();
}


require __DIR__ . '/../inc/header.php';

$sql_query = 'SELECT * FROM equipments';
$equipments = mysqli_query($conn, $sql_query);
$results = mysqli_fetch_all($equipments, MYSQLI_ASSOC);

//add new equipment

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $type = mysqli_real_escape_string($conn, $_POST['type'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);
    $state = mysqli_real_escape_string($conn,$_POST['state'] ?? 'bon');
    $id = intval($_POST['id'] ?? 0);
    $selectedCourses = $_POST['courses'] ?? [];



    if($name && $type && $quantity && $state) {
        if( $id > 0){
            $sql = "UPDATE equipments SET 
            name = '$name',
            type = '$type',
            quantity = $quantity,
            state = '$state'
            WHERE id = $id";
            mysqli_query($conn, $sql);

            //clear the courses_equipments before updating
            if(count($selectedCourses) > 0 ){
                mysqli_query($conn, "DELETE FROM course_equipments WHERE id = $id");

                foreach($selectedCourses as $courId){
                $courId = intval($courId);
                mysqli_query($conn, "INSERT INTO course_equipments (course_id, equipment_id) VALUES ('$courId', '$id')");
            }

            }
        }else{
            $sql = "INSERT INTO equipments (name, type, quantity , state) 
            VALUES ('$name', '$type', '$quantity','$state')";
            mysqli_query($conn, $sql);

            $newId = mysqli_insert_id($conn);
            foreach($selectedCourses as $courId){
                $courId = intval($courId);
                mysqli_query($conn, "INSERT INTO course_equipments (course_id, equipment_id) VALUES ('$courId', '$newId')");
            }
            
        }



        
        header("location: " . $_SERVER['PHP_SELF']);
        exit();
    }


    //delete a equipment

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
        $id = $_POST['delete_id'];

        mysqli_query($conn, "DELETE FROM course_equipments WHERE  equipment_id = $id");
        $sql = "DELETE FROM equipments WHERE id = $id";
        mysqli_query($conn, $sql);
        header("location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    
    
    
}
//get all the course

$sql = "SELECT * FROM courses";
$res = mysqli_query($conn,$sql);
$courses = mysqli_fetch_all($res, MYSQLI_ASSOC);

// var_dump($courses);

?>

<section class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50" id="modal">
    <div class="w-full sm:max-w-md modal-card bg-white rounded-2xl p-6 shadow-2xl mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-green-600" id="modal-title">Create Equipments</h3>
            <button id="closeBtn" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        </div>

        <form class="space-y-3" id="form" method="POST">
            <input type="hidden" name="id" id="equipment-id" value="0">

            <input class="w-full rounded border px-3 py-2" placeholder="name" name="name" id="name" type="text" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Type" name="type" id="type" type="text" required />
            <input class="w-full rounded border px-3 py-2" placeholder="Quantity" type="number" name="quantity" id="quantity" required />
            <select class="w-full rounded border px-3 py-2" name="state" id="state">
                <option value="bon">Bon</option>
                <option value="moyen">moyen</option>
                <option value="remplace">remplace</option>
            </select>

            <div class="relative w-full">

                <button
                type="button"
                class="w-full bg-white border rounded px-3 py-2 text-left flex justify-between items-center"
                onclick="document.getElementById('courses-dropdown').classList.toggle('hidden')"
                >
                Select Courses
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                </button>

                <div id="courses-dropdown"
                class="hidden absolute mt-1 w-full bg-white border rounded shadow-lg max-h-60 overflow-auto z-50"
                >
                <?php foreach($courses as $cour ) {?>
                    <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="courses[]" value="<?= $cour['id'] ?>?>" class="mr-2">
                        <?=  $cour['title']; ?>
                    </label>
                <?php }?>

                </div>

            </div>


            <button type="submit" class="w-full bg-sky-600 text-white rounded px-3 py-2" id="submit-btn">Save</button>
        </form>
    </div>
</section>

<div class="min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Equipments</h1>
            <button id="btnOpen" class="px-4 py-2 bg-emerald-500 text-white rounded-lg shadow hover:bg-emerald-600 transition">
                + Add
            </button>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl shadow-lg bg-white border border-gray-200">
            <table class="w-full text-sm divide-y divide-gray-200">
                <!-- Table Header -->
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Quantity</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">State</th>

                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    <?php foreach($results as $result) { ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- ID -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    <?php echo htmlspecialchars($result['id']); ?>
                                </span>
                            </td>

                            <!-- Name -->
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">
                                    <?php echo htmlspecialchars($result['name']); ?>
                                </p>
                            </td>

                            <!-- Type -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <?php echo htmlspecialchars($result['type']); ?>
                                </span>
                            </td>

                            <!-- Quantity -->
                            <td class="px-6 py-4">
                                <p class="text-gray-700 font-medium">
                                    <?php echo htmlspecialchars($result['quantity']); ?>
                                </p>
                            </td>

                            <!-- State -->
                            <td class="px-6 py-4">
                                <p class="text-gray-700 font-medium">
                                    <?php echo htmlspecialchars($result['state']); ?>
                                </p>
                            </td>


                            <td >
                                <button class="edit-btn bg-emerald-500 text-white px-2 py-1 rounded text-xs"
                                data-id="<?php echo $result['id']?>"
                                data-name= "<?php echo $result['name'] ?>"
                                data-type = "<?php echo $result['type']?>"
                                data-quantity = "<?php echo $result['quantity']?>"
                                data-state = "<?php echo $result['state']?>"
                                >
                                <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td>
                            <form action="" method="POST">
                                <input type="hidden" name="delete_id" value="<?php echo $result['id']?>">
                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded text-xs" type="submit" ><i class="fas fa-trash"></i></button>
                            </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(count($results) === 0) { ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No equipments found.
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("modal");
    const closeBtn = document.getElementById('closeBtn')
    const btnOpen = document.getElementById("btnOpen")
    const form = document.getElementById('form')
    const modal_title = document.getElementById("modal-title")
    const equipment_id = document.getElementById('equipment-id')

    function closeModel(){
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function openModel(){
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal_title.textContent = 'Create a Equipment'
        equipment_id.value = 0;
        form.reset();

    }

    closeBtn.addEventListener('click',closeModel);
    btnOpen.addEventListener('click',openModel);

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click' , ()=>{
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal_title.textContent = 'Update a Equipment'

            form.id.value = btn.dataset.id;

            form.name.value = btn.dataset.name;
            form.type.value = btn.dataset.type;
            form.quantity.value = btn.dataset.quantity;
            form.state.value = btn.dataset.state;
        })
    })

</script>
