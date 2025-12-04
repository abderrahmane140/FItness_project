<?php include 'config/database.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Fitness Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        .sidebar-active {
            background-color: rgba(239, 68, 68, 0.1);

        }
    </style>
    
</head>
<body class="bg-neutral-100">

<div class="flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white   overflow-y-auto shadow-sm">
        
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-sky-200 bg-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center shadow">
                    <span class="text-xl font-bold text-white">💪</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-sky-700">FitPulse</h1>
                    <p class="text-xs text-sky-500">Fitness Tracker</p>
                </div>
            </div>
        </div>


        <!-- Navigation -->
        <nav class="p-4">
            <div class="mb-8">

               <a href="index.php" class="hover:bg-sky-50 rounded-md font-bold flex items-center gap-3 px-4 py-3 mb-2 text-black">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4"></path>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>
                
                <a href="/Courses.php" class="rounded-md hover:bg-sky-50 font-bold flex items-center gap-3 px-4 py-3 mb-2 text-black">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4"></path>
                    </svg>
                    <span class="text-sm">Courses</span>
                </a>

                <a href="/equipments.php" class="flex items-center gap-3 px-4 py-3 rounded-md font-bold  mb-2 hover:bg-sky-50 text-black">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-sm">Equipements</span>
                </a>

        
            </div>

 

        </nav>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto p-6">
