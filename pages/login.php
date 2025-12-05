<?php 
session_start();
require __DIR__ . '/../config/database.php';
?>


<!DOCTYPE html>
<html lang="en" class="h-full bg-neutral-100">
<head>
    <meta charset="UTF-8">
    <title>Login - Fitness</title>
</head>
<body class="h-full">
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm text-center">
    <h2 class="mt-10 text-2xl font-bold tracking-tight">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="../auth/login_process.php" method="POST" class="space-y-6">
      <div>
        <label for="email" class="block text-sm font-medium ">Email address</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 focus:outline-indigo-500"/>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium">Password</label>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 focus:outline-indigo-500"/>
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full text-white justify-center rounded-md bg-sky-300 px-3 py-1.5 hover:bg-sky-400">Sign in</button>
      </div>
    </form>

    <p class="mt-6 text-center text-sm ">
      Not a member?
      <a href="signup.php" class="font-semibold text-indigo-400 hover:text-sky-400">Sign Up</a>
    </p>
  </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>