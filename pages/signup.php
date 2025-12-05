<?php
session_start();
require __DIR__ . '/../config/database.php';

?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-neutral-100">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Fitness</title>
</head>
<body class="h-full">
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-white">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm text-center">
    <h2 class="mt-10 text-2xl font-bold tracking-tight ">Create your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="../auth/signup_process.php" method="POST" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium">Full Name</label>
        <div class="mt-2">
          <input id="name" type="text" name="username" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 placeholder:text-gray-500 focus:outline-indigo-500"/>
        </div>
      </div>

      <div>
        <label for="email" class="block text-sm font-medium ">Email address</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required class="block w-full rounded-md bg-white/5 px-3 py-1.5placeholder:text-gray-500 focus:outline-indigo-500"/>
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium">Password</label>
        <div class="mt-2">
          <input id="password" type="password" name="password" required class="block w-full rounded-md bg-white/5 px-3 py-1.5placeholder:text-gray-500 focus:outline-indigo-500"/>
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full text-white justify-center rounded-md bg-sky-500 px-3 py-1.5 hover:bg-sky-400">Sign Up</button>
      </div>
    </form>

    <p class="mt-6 text-center text-sm">
      Already have an account?
      <a href="login.php" class="font-semibold text-sky-400 hover:text-sky-300">Login</a>
    </p>
  </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>