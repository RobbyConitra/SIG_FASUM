<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

?>
<aside class="fixed left-0 h-full w-[250px] bg-[#343a40] flex flex-col text-white">
    <a href="" class="block h-14 px-2 py-3 border-b border-gray-500 flex-none hover:text-gray-300">
        <span class="text-xl font-thin px-3">FASUM</span>
    </a>

    <div class="flex-1 px-2 mt-3">
        <li class="px-3 mb-3 text-gray-300">Menu</li>
        <a href="/dashboard" class="px-3 cursor-pointer rounded-md flex items-center gap-2 py-2 <?php echo ($path == "/dashboard") ? "bg-gray-600" : "hover:text-gray-300"; ?>">
            <i class="fa-solid fa-gauge"></i>
            <p>Dashboard</p>
        </a>
        <a href="/data" class="px-3 cursor-pointer rounded-md flex items-center gap-2 py-2 <?php echo ($path == "/data") ? "bg-gray-600" : "hover:text-gray-300"; ?>">
            <i class="fa-solid fa-database"></i>
            <p>Data</p>
        </a>
    </div>

    <div class="flex-none px-2 py-3 border-t border-gray-500">
        <form action="../controller/logout.php" method="POST">
            <button type="submit" class="px-3 hover:bg-gray-600 cursor-pointer rounded-md flex items-center gap-2 py-2 w-full">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Log Out</p>
            </button>
        </form>
        </a>
    </div>
</aside>