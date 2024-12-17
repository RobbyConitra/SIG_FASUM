<?php

    include 'config.php';

    $total_bc_query = "SELECT COUNT(*) AS total_bc FROM list_fasum WHERE lokasi = 'Batam Kota'";
    $total_bc_result = mysqli_query($conn, $total_bc_query);
    $total_bc_data = mysqli_fetch_assoc($total_bc_result)['total_bc'];

    $total_lb_query = "SELECT COUNT(*) AS total_lb FROM list_fasum WHERE lokasi = 'Sagulung'";
    $total_lb_result = mysqli_query($conn, $total_lb_query);
    $total_lb_data = mysqli_fetch_assoc($total_lb_result)['total_lb'];

    $total_fasum_query = "SELECT COUNT(*) AS total_fasum FROM list_fasum";
    $total_fasum_result = mysqli_query($conn, $total_fasum_query);
    $total_fasum_data = mysqli_fetch_assoc($total_fasum_result)['total_fasum'];
?>

<div class="py-4 px-2 flex justify-between">
    <p class="text-3xl text-gray-800 px-2">Dashboard</p>
    <p class="text-gray-600 px-2"><span class="text-blue-500">Home</span> / Dashboard</p>
</div>

<div class="px-4 flex gap-4 text-black">
    <div class="flex flex-1 items-center justify-center">
        <div class="mySlides fade flex flex-1 items-center justify-center">
            <img src="image/Sagulung 1.png" class="h-[550px] w-[100%] rounded-md">
            <div class="text-lg flex items-center justify-center mb-7">Lapangan Voli - Sagulung</div>
        </div>

        <div class="mySlides fade flex flex-1 items-center justify-center">
            <img src="image/batcen 3.png" class="h-[550px] w-[100%] rounded-md">
            <div class="text-lg flex items-center justify-center mb-7">Lapangan Badminton dan Voli - Batam Kota</div>
        </div>

        <div class="mySlides fade flex flex-1 items-center justify-center">
            <img src="image/batcen 4.png" class="h-[550px] w-[100%] rounded-md">
            <div class="text-lg flex items-center justify-center mb-7">Lapangan Badminton dan Voli - Batam Kota</div>
        </div>
    </div>
    <script>
        let slideIndex = 0;
        showSlides();
        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}    
            for (i = 0; i < slides.length; i++) {
                slides[i].className = slides[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            slides[slideIndex-1].className += " active";
            setTimeout(showSlides, 3000);
        }
    </script>
</div>

<div class="px-4 flex gap-4 text-white mb-4">
    <div class="bg-gray-500 flex-1 rounded-md h-[325px] flex justify-start relative">
        <div class="px-3 h-full flex flex-col justify-center items-center">
            <p class="text-4xl font-bold mb-2 mr-4 ml-2">
                <img src="image\Robby.jpg" class="h-[200px] rounded-md">
            </p>
            <p class="text-lg ">Robby Conitra</p>
            <p class="text-lg mb-2 ">Developer</p>
        </div>
        <div class="px-3 h-full flex flex-col justify-center items-center">
            <p class="text-4xl font-bold mb-2 mr-2 ml-2">
                <img src="image\jordan.jpg" class="h-[200px] rounded-md">
            </p>
            <p class="text-lg ">Jordan Hue</p>
            <p class="text-lg mb-2 ">Designer</p>
        </div>
        <div class="px-3 h-full flex flex-col justify-center items-center">
            <p class="text-4xl font-bold mb-2 mr-2 ml-2">
                <img src="image\milson.jpg" class="h-[200px] rounded-md">
            </p>
            <p class="text-lg ">Milson Nestelrody</p>
            <p class="text-lg mb-2 ">Surveyor</p>
        </div>
        <div class="flex-1 flex justify-end items-center text-white-600 text-9xl mr-32">
            <i class="fa-solid fa-users"></i>
        </div>     
        <div class="absolute bottom-0 w-full h-7 bg-gray-600 rounded-bl-md rounded-br-md"></div>
    </div>
</div>

<div class="px-4 flex gap-4 text-white mb-4">

    <div class="bg-blue-500 flex-1 rounded-md h-36 flex justify-between relative">
        <div class="px-3 h-full flex flex-col justify-center ">
            <p class="text-4xl font-bold mb-2"><?=  $total_bc_data ?></p>
            <p class="text-lg mb-7">Jumlah Batam Kota</p>
        </div>
        <div class="px-3 h-full flex items-center text-blue-600 text-7xl">
            <i class="fa-solid fa-building mb-7"></i>
        </div>
        <div class="absolute bottom-0 w-full h-7 bg-blue-600 rounded-bl-md rounded-br-md"></div>
    </div>
    <div class="bg-green-500 flex-1 rounded-md h-36 flex justify-between relative">
        <div class="px-3 h-full flex flex-col justify-center ">
            <p class="text-4xl font-bold mb-2"><?= $total_lb_data ?></p>
            <p class="text-lg mb-7">Jumlah Sagulung</p>
        </div>
        <div class="px-3 h-full flex items-center text-green-600 text-7xl">
            <i class="fa-solid fa-building mb-7"></i>
        </div>
        <div class="absolute bottom-0 w-full h-7 bg-green-600 rounded-bl-md rounded-br-md"></div>
    </div>
    <div class="bg-red-500 flex-1 rounded-md h-36 flex justify-between relative">
        <div class="px-3 h-full flex flex-col justify-center ">
            <p class="text-4xl font-bold mb-2"><?= $total_fasum_data ?></p>
            <p class="text-lg mb-7">Jumlah Fasum</p>
        </div>
        <div class="px-3 h-full flex items-center text-red-600 text-7xl">
            <i class="fa-solid fa-building mb-7"></i>
        </div>
        <div class="absolute bottom-0 w-full h-7 bg-red-600 rounded-bl-md rounded-br-md"></div>
    </div>
</div>