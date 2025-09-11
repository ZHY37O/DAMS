<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-amber-200">
    <nav>
        <div class="shadow-sm navbar bg-sky-500">
            <div class="flex-1">
                <a class="text-xl btn btn-ghost">Admin dashboard</a>
            </div>
            <div class="flex gap-2">
                <!-- Search Form -->
                <form action="/search.php" method="GET" class="flex gap-2">
                    <input type="text" name="query" placeholder="Search doctors..." class="w-24 input input-bordered md:w-auto" />
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>
                
                <div class="dropdown dropdown-end">
                    <button class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-red-700" onclick="location.href = '/logout.php';">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                    
                </div>
            </div>
        </div>
    </nav>
    <main class="">
        <header class="mb-8 rounded-lg bg-lime-500 h-[150px]">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard </h1>
            <p class="text-zinc-800">Welcome to your deshboard</p>
        </header>

        
        <section class="flex items-center justify-between p-20">
            <div class="bg-green-300 shadow-sm w-80 card">
                <div class="card-body">
                    <table>
                    <tr><td>
                    <h2 class="card-title">Doctors</h2>
                    <p>6</p>   <!-- update by DATAbASE -->
                    </td>
                    <td>
                    <button class="button bg-green-600 item-end hover:bg-red-600 h-[20px] w-[40px]" onclick='location.href = "/doctor_registration.php/"'> <i class="fa-solid fa-user-plus"></i>  </button>
                    </td></tr></table>
                    </div>
                </div>
            </div>
            <div class="shadow-sm w-80 card bg-sky-300">
                <div class="card-body">
                    <h2 class="card-title">Patients</h2>
                    <p>20</p>   <!-- update by DATAbASE -->
                    </div>
                </div>
            </div>
            <div class="bg-indigo-500 shadow-sm w-80 card">
                <div class="card-body">
                    <h2 class="card-title">Appointments</h2>
                    <p>3</p>   <!-- update by DATAbASE -->
                    </div>
                </div>
            </div>
        </section>

        <section class="shadow-2xl">
            <h1 class="mb-10 text-4xl">Appointments</h1>
            
            <div class="overflow-x-auto bg-gray-400">
                <table class="table w-full table-zebra">
                <thead>
                    <tr class="text-gray-700 bg-zinc-400">
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Serial No.</th>
                    <th>Change Status / Serial</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>2025-09-12</td>
                    <td> 11:00:00</td>
                    <td>
                        <span class="font-semibold text-yellow-600">Pending</span>
                    </td>
                    <td>-</td>
                    <td>
                        <div class="flex items-center gap-2">
                        <select class="select select-bordered select-sm">
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Completed</option>
                            <option>Cancelled</option>
                        </select>
                        <input
                            type="text"
                            placeholder="Serial"
                            class="w-24 input input-bordered input-sm"
                        />
                        <button class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </section>
        
    </main>
</body>
</html>