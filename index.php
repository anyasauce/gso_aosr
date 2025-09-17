<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>GSO AOSR</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            background: url('assets/images/bg.jpg') center/cover no-repeat;
            height: 500px;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .calendar-day-cell {
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            border-right: 1px solid #e5e7eb;
        }

        .calendar-day-cell:last-child {
            border-right: none;
        }

        @media (min-width: 1024px) {
            .calendar-day-cell {
                min-height: 112px;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">
            <a href="#" class="text-2xl font-bold text-gray-900">GSO AOSR</a>
            <div class="flex items-center space-x-4">
                <a href="#about" class="text-gray-600 hover:text-blue-600 transition font-medium">About</a>
                <a href="#calendar" class="text-gray-600 hover:text-blue-600 transition font-medium">Availability</a>
                <a href="#reservation" class="text-gray-600 hover:text-blue-600 transition font-medium">Reserve</a>
                <a href="views/auth/login.php"
                    class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition font-medium">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero flex items-center justify-center text-center text-white relative">
        <div class="relative z-10 p-4">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-4">Streamline Your Reservations</h1>
            <p class="text-lg md:text-xl font-light max-w-2xl mx-auto mb-8">
                Effortlessly book venues and vehicles for your next event or travel. Our simple, secure platform makes
                it easy to manage your needs.
            </p>
            <a href="reservation.php"
                class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-200 transition duration-300 transform hover:scale-105">
                Start Your Reservation
            </a>
        </div>
    </section>

    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">About Our Service</h2>
            <p class="text-lg text-gray-600 mb-8">
                We provide a hassle-free online booking system for various government assets. Whether you need a space
                for a large conference or a vehicle for an official trip, our platform ensures a smooth and transparent
                process from start to finish.
            </p>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="p-6 rounded-lg bg-gray-50 shadow-md">
                    <h3 class="text-2xl font-semibold text-blue-600 mb-2">Venue Booking</h3>
                    <p class="text-gray-700">Reserve auditoriums, conference rooms, and event halls for official
                        functions and public gatherings. Check real-time availability and manage your events with ease.
                    </p>
                </div>
                <div class="p-6 rounded-lg bg-gray-50 shadow-md">
                    <h3 class="text-2xl font-semibold text-blue-600 mb-2">Vehicle Reservations</h3>
                    <p class="text-gray-700">Secure official vehicles, from sedans to buses, for your transportation
                        needs. Our system ensures you have the right vehicle at the right time.</p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>