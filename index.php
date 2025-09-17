<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>GSO AOSR | Modern Reservation System</title>
    <style>
        /* Use Poppins as the default font */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom Hero Section Styling */
        .hero {
            background: url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2069&auto=format&fit=crop') center/cover no-repeat;
            position: relative;
        }

        /* Gradient Overlay for better text readability */
        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.2));
        }
        
        /* Simple fade-in animation for hero content */
        .fade-in {
            animation: fadeInAnimation 1s ease-in-out;
        }

        @keyframes fadeInAnimation {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="container mx-auto flex items-center justify-between px-6 py-4">
            <a href="#" class="text-2xl font-bold text-gray-900">GSO AOSR</a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#about" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300 font-medium">About</a>
                <a href="#features" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300 font-medium">Features</a>
                <a href="#reservation" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300 font-medium">Reserve</a>
            </div>
            <a href="views/auth/login.php" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition-all duration-300 font-medium shadow-lg hover:shadow-indigo-500/50 transform hover:-translate-y-0.5">
                Login
            </a>
        </div>
    </nav>

    <section class="hero flex items-center justify-center min-h-[60vh] md:justify-start text-white">
        <div class="relative z-10 p-6 md:p-12 lg:p-24 max-w-3xl text-center md:text-left">
            <div class="fade-in">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-4 text-shadow">Streamline Your Reservations</h1>
                <p class="text-lg md:text-xl font-light text-gray-200 max-w-2xl mb-8">
                    Effortlessly book venues and vehicles for your next event or official travel. Our simple, secure platform makes it easy to manage your needs.
                </p>
                <a href="#reservation" class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-full hover:bg-gray-200 transition duration-300 transform hover:scale-105 inline-block shadow-2xl">
                    Start Your Reservation
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-white">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">About Our Service</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                We provide a hassle-free online booking system for various government assets. Whether you need a space for a large conference or a vehicle for an official trip, our platform ensures a smooth and transparent process from start to finish.
            </p>
        </div>
    </section>

    <section id="features" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="grid md:grid-cols-2 gap-10 text-left">
                <div class="p-8 rounded-xl bg-white shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-center bg-indigo-100 rounded-full w-16 h-16 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Venue Booking</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Reserve auditoriums, conference rooms, and event halls for official functions and public gatherings. Check real-time availability and manage your events with ease.
                    </p>
                </div>
                <div class="p-8 rounded-xl bg-white shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                     <div class="flex items-center justify-center bg-indigo-100 rounded-full w-16 h-16 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Vehicle Reservations</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Secure official vehicles, from sedans to buses, for your transportation needs. Our system ensures you have the right vehicle at the right time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2025 GSO AOSR. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>