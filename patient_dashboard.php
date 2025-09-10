<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body class="bg-amber-200">
    <nav class="">
        <div class="shadow-lg navbar bg-sky-500">
            <div class="flex-1">
                <a class="text-xl btn btn-ghost">Patient dashboard</a>
            </div>
            <div class="flex gap-2">
                <div class="dropdown dropdown-end">
                    <button class="px-4 py-2 text-blue-800 rounded-lg bg-gray-50 hover:bg-slate-800">
                        <p name="appointment_form">Book Appointment</p>   <!-- can be change -->
                    </button>
                    
                </div>
                <form action="search.php" method="GET" class="flex items-center gap-2">
                    <input type="text" name="query" placeholder="Search" class="w-24 input input-bordered md:w-auto" />
                    <button type="submit" class="btn btn-ghost btn-circle">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div class="dropdown dropdown-end">
                    <button tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="Tailwind CSS Navbar component" src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                        </div>
                    </button>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-6xl p-4 mx-auto">
        <section class="mt-10">
            <h1 class="mb-10 text-2xl"> Previouse Appointments history</h1>
            
            <div class="overflow-x-auto bg-gray-400">
                <table class="table w-full table-zebra">
                <thead>
                    <tr class="text-gray-700 bg-zinc-400">
                        <th>ID</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>2025-09-12</td>
                    <td> 11:00:00</td>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </section>

        <div class="flex justify-end m-10">
            <calendar-date class="border shadow-lg cally bg-base-100 border-base-300 rounded-box">
                <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
            </calendar-date>
        </div>
        
    </main>

</body>
</html>
