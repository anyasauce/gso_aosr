<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <title>GSO AOSR | Reservation</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom styles for better form UI */
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        /* Ensure map tiles don't get distorted */
        .leaflet-container {
            background: #f9fafb;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <header class="py-4 border-b border-slate-200">
        <div class="container mx-auto px-4">
            <h1 class="text-xl font-bold text-slate-900">GSO AOSR</h1>
        </div>
    </header>


    <section id="reservation" class="py-12 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white border border-slate-200/80 shadow-2xl shadow-slate-300/30 rounded-3xl p-6 md:p-10">

                <h2 class="text-3xl font-bold text-slate-900 text-center mb-2">Create a Reservation</h2>
                <p class="text-center text-slate-500 mb-8">Follow the steps to complete your booking.</p>

                <div id="stepIndicator" class="flex items-center justify-between mb-10 text-sm font-medium text-slate-500">
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">1</div>
                        <span class="step-label hidden md:block">Government Type</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">2</div>
                        <span class="step-label hidden md:block">Reservation Type</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">3</div>
                        <span class="step-label hidden md:block">Information</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">4</div>
                        <span class="step-label hidden md:block">Schedule</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">5</div>
                        <span class="step-label hidden md:block">Purpose</span>
                    </div>

                     <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">6</div>
                        <span class="step-label hidden md:block">Review</span>
                    </div>
                </div>

                <form id="reservationForm" action="controllers/ReservationController.php" method="post" novalidate>
                    
                 <div class="step active">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">1. Select Government Type</h3>
                        <p class="text-slate-500 mb-6">What is your Government Type?</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label for="capitol" class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-500/10 hover:border-indigo-400">
                            <input type="radio" name="govType" id="capitol" class="absolute opacity-0" value="capitol" required>
                            <!-- Icon: Office Building -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4 3h16M5 3v18m14-18v18M9 7h6m-6 4h6m-6 4h6" />
                            </svg>
                            <p class="text-lg font-semibold text-slate-800">Capitol Offices</p>
                            <p class="text-sm text-slate-500">Government and administrative offices</p>
                        </label>

                        <label for="private" class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-500/10 hover:border-indigo-400">
                            <input type="radio" name="govType" id="private" class="absolute opacity-0" value="private" required>
                            <!-- Icon: Briefcase / Private Office -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m4 0H4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7h16z" />
                            </svg>
                            <p class="text-lg font-semibold text-slate-800">Private Offices</p>
                            <p class="text-sm text-slate-500">Business, corporate, and private workspaces</p>
                        </label>

                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">2. Select Reservation Type</h3>
                        <p class="text-slate-500 mb-6">What would you like to book?</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label for="venue" class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-500/10 hover:border-indigo-400">
                                <input type="radio" name="reservationType" id="venue" class="absolute opacity-0" value="place" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 12h6.75m-6.75 5.25h6.75M5.25 21v-18" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Book a Venue</p>
                                <p class="text-sm text-slate-500">Conference rooms, halls, etc.</p>
                            </label>

                            <label for="vehicle" class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-500/10 hover:border-indigo-400">
                                <input type="radio" name="reservationType" id="vehicle" class="absolute opacity-0" value="vehicle" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875m0-16.5v-1.5a1.125 1.125 0 00-1.125-1.125h-1.5a1.125 1.125 0 00-1.125 1.125v1.5m17.25-3.375v1.5c0 .621-.504 1.125-1.125 1.125h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125h1.5c.621 0 1.125.504 1.125 1.125z" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Request a Vehicle</p>
                                <p class="text-sm text-slate-500">Cars, vans, buses, etc.</p>
                            </label>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">3. Your Information</h3>
                        <p class="text-slate-500 mb-6">Please provide your contact details.</p>
<<<<<<< HEAD
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Email Address</label>
                                <input type="email" name="email" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="name@example.com" required>
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">First Name</label>
                                <input type="text" name="first_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Juan" required>
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Last Name</label>
                                <input type="text" name="last_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Dela Cruz" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Organization Name</label>
                                <input type="text" name="org_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Provincial Government of Iloilo" required>
                            </div>
                        </div>
                    </div>
=======
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                             <div class="md:col-span-2">
                                 <label class="block mb-1.5 text-sm font-medium text-slate-600">Email Address</label>
                                 <input type="email" name="email" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="name@example.com" required>
                             </div>
                             <div>
                                 <label class="block mb-1.5 text-sm font-medium text-slate-600">First Name</label>
                                 <input type="text" name="first_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Juan" required>
                             </div>
                             <div>
                                 <label class="block mb-1.5 text-sm font-medium text-slate-600">Last Name</label>
                                 <input type="text" name="last_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Dela Cruz" required>
                             </div>
                             <div>
                                 <label class="block mb-1.5 text-sm font-medium text-slate-600">Title</label>
                                 <input type="text" name="title" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Title" required>
                             </div>
                             <div class="">
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Organization Name</label>
                                <input type="text" name="org_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Provincial Government of Iloilo" required>
                            </div>
                            <div class="">
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Phone Number</label>
                                <input type="text" name="phone_number" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Provincial Government of Iloilo" required>
                            </div>
                            <div class="">
                                <label class="block mb-1.5 text-sm font-medium text-slate-600">Address</label>
                                <input type="text" name="address" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Provincial Government of Iloilo" required>
                            </div>

                         </div>
                    </div>
                    
                    <div class="step">
                         <h3 class="text-xl font-semibold mb-2 text-slate-800">4. Schedule & Details</h3>
                         <p class="text-slate-500 mb-6">When do you need the reservation?</p>
>>>>>>> e5207dfed3fcc87428d2968f9a992ff53e44f86a

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">3. Schedule & Details</h3>
                        <p class="text-slate-500 mb-6">When do you need the reservation?</p>

                        <div id="venue-details" class="hidden space-y-5">
                            <h4 class="text-md font-semibold text-slate-700 border-b pb-2">Venue Details</h4>
                            <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Name of Event</label>
                                     <input type="text" name="event_name" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Social Party">
                                 </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">Select Venue</label>
                                    <select name="res_place" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option disabled selected>Choose a place...</option>
                                        <option>Iloilo Convention Center</option>
                                        <option>Freedom Grandstand</option>
                                        <option>Casa Real de Iloilo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">Number of Persons</label>
                                    <input type="number" name="num_person" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 50">
                                </div>
                            </div>
                            <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Sound Systems</label>
                                     <select name="sound_system" id="" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="No" selected> No</option>
                                        <option value="Yes">Yes</option>
                                     </select>
                                 </div>
                            <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Number of Chairs</label>
                                     <input type="number" name="num_chairs" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 50">
                                 </div>
                            <div id="calendar-wrapper">
                                <h4 class="text-md font-semibold text-slate-700 pt-4 border-b pb-2">Check Availability</h4>
                                <div class="bg-slate-50/80 rounded-lg p-4 mt-2 border">
                                    <p class="text-sm text-center text-slate-600">Calendar logic here...</p>
                                </div>
                            </div>
                        </div>

                        <div id="vehicle-details" class="hidden space-y-5">
                            <h4 class="text-md font-semibold text-slate-700 border-b pb-2">Vehicle Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
<<<<<<< HEAD
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">Vehicle Type</label>
                                    <select name="vehicle_type" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option disabled selected>Choose a vehicle...</option>
                                        <option>Sedan</option>
                                        <option>SUV / Pickup</option>
                                        <option>Van</option>
                                        <option>Bus</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">Number of Passengers</label>
                                    <input type="number" name="num_passengers" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 4">
                                </div>
                            </div>
                            <div id="map-wrapper">
                                <h4 class="text-md font-semibold text-slate-700 pt-4 border-b pb-2">Set Destination</h4>
                                <p class="text-sm text-slate-500 mt-2">Click on the map to drop a pin on your destination.</p>
                                <div id="map" class="w-full h-80 rounded-xl shadow-md mt-3 border z-0"></div>
                                <input type="hidden" name="destination_latitude" id="dest-lat">
                                <input type="hidden" name="destination_longitude" id="dest-lng">
                            </div>
=======
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Vehicle Type</label>
                                     <select name="v_type" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                         <option disabled selected>Choose a vehicle...</option>
                                         <option>Sedan</option>
                                         <option>SUV / Pickup</option>
                                         <option>Van</option>
                                         <option>Bus</option>
                                     </select>
                                 </div>
                                 <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Number of Passengers</label>
                                     <input type="number" name="num_pass" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 4">
                                 </div>
                            </div>
                            <div id="map-wrapper">
                               <h4 class="text-md font-semibold text-slate-700 pt-4 border-b pb-2">Set Destination</h4>
                               <p class="text-sm text-slate-500 mt-2">Click on the map to drop a pin on your destination.</p>
                               <div id="map" class="w-full h-80 rounded-xl shadow-md mt-3 border z-0"></div>
                               <input type="text" name="latitude" id="dest-lat">
                               <input type="text" name="longitude" id="dest-lng">
                           </div>
>>>>>>> e5207dfed3fcc87428d2968f9a992ff53e44f86a
                        </div>

                        <div class="space-y-5 mt-5 pt-5 border-t">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">Start Date & Time</label>
                                    <input type="datetime-local" name="start_datetime" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">End Date & Time</label>
                                    <input type="datetime-local" name="end_datetime" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">5. Purpose of Reservation</h3>
                        <p class="text-slate-500 mb-6">Let us know why you are making this reservation.</p>
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-slate-600">Purpose / Name of Event</label>
                            <textarea name="purpose" rows="5" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Official Business Trip to Passi City" required></textarea>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">6. Review & Submit</h3>
                        <p class="text-slate-500 mb-6">Please double-check your details before submitting.</p>
                        <div class="bg-slate-50/80 rounded-lg p-6 border space-y-3">
                            <div id="review-details">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-10">
                        <button type="button" id="prevBtn" class="hidden bg-slate-200 text-slate-800 px-6 py-3 rounded-full font-semibold transition hover:bg-slate-300">Previous</button>
                        <button type="button" id="nextBtn" class="ml-auto bg-indigo-600 text-white px-8 py-3 rounded-full font-semibold transition hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">Next Step</button>
                        <button type="button" id="submitBtn" name="reserve" class="hidden bg-emerald-600 text-white px-8 py-3 rounded-full font-semibold transition hover:bg-emerald-700 shadow-lg shadow-emerald-500/30">Submit Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="py-4 border-t border-slate-200">
        <div class="container mx-auto px-4 text-center text-slate-500 text-sm">
            &copy; 2024 GSO AOSR. All Rights Reserved.
        </div>
    </footer>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const steps = document.querySelectorAll(".step");
            const stepItems = document.querySelectorAll(".step-item");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const submitBtn = document.getElementById("submitBtn");
            const form = document.getElementById("reservationForm");

            const venueDetails = document.getElementById("venue-details");
            const vehicleDetails = document.getElementById("vehicle-details");
            const reviewDetails = document.getElementById("review-details");

            let currentStep = 0;
            let map = null;
            let destinationMarker = null;

            function updateStepIndicator() {
                stepItems.forEach((item, index) => {
                    const number = item.querySelector('.step-number');
                    const label = item.querySelector('.step-label');

                    // Reset all classes
                    number.classList.remove('bg-emerald-500', 'border-emerald-500', 'text-white', 'bg-indigo-600', 'border-indigo-600');
                    label.classList.remove('text-indigo-600');

                    if (index < currentStep) {
                        number.classList.add('bg-emerald-500', 'border-emerald-500', 'text-white');
                        number.innerHTML = `&#10003;`; // Checkmark
                    } else if (index === currentStep) {
                        number.classList.add('bg-indigo-600', 'border-indigo-600', 'text-white');
                        label.classList.add('text-indigo-600');
                        number.innerHTML = index + 1;
                    } else {
                        number.classList.add('border-slate-200');
                        number.innerHTML = index + 1;
                    }
                });
            }

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle("active", index === stepIndex);
                });
                prevBtn.classList.toggle("hidden", stepIndex === 0);
                nextBtn.classList.toggle("hidden", stepIndex === steps.length - 1);
                submitBtn.classList.toggle("hidden", stepIndex !== steps.length - 1);
                updateStepIndicator();
            }

            function initMap() {
                if (map) {
                    map.invalidateSize();
                    return;
                }
                map = L.map('map').setView([10.7202, 122.5621], 13); // Iloilo City
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add click listener to the map
                map.on('click', function(e) {
                    const { lat, lng } = e.latlng;
                    // Update hidden input fields
                    document.getElementById('dest-lat').value = lat.toFixed(6);
                    document.getElementById('dest-lng').value = lng.toFixed(6);

                    // Remove old marker if it exists
                    if (destinationMarker) {
                        map.removeLayer(destinationMarker);
                    }

                    // Add new marker
                    destinationMarker = L.marker([lat, lng]).addTo(map)
                        .bindPopup(`<b>Destination Pinned</b><br>Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`)
                        .openPopup();
                });
            }

            function generateReviewSummary() {
                reviewDetails.innerHTML = '';
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                const friendlyLabels = {
                    reservationType: "Reservation Type",
                    email: "Email Address",
                    first_name: "First Name",
                    last_name: "Last Name",
                    org_name: "Organization",
                    res_place: "Venue",
                    num_person: "Number of Persons",
                    vehicle_type: "Vehicle Type",
                    num_passengers: "Number of Passengers",
                    start_datetime: "Start Date & Time",
                    end_datetime: "End Date & Time",
                    purpose: "Purpose",
                    destination_latitude: "Destination Latitude",
                    destination_longitude: "Destination Longitude"
                };

                for (const key in data) {
                    if (data[key] && friendlyLabels[key]) {
                        // Skip details for the type not selected
                        if (data.reservationType === 'place' && (key === 'vehicle_type' || key === 'num_passengers' || key.startsWith('destination'))) continue;
                        if (data.reservationType === 'vehicle' && (key === 'res_place' || key === 'num_person')) continue;

                        const p = document.createElement('p');
                        p.innerHTML = `<strong class="font-semibold text-slate-900">${friendlyLabels[key]}:</strong> <span class="text-slate-600">${data[key].replace('T', ' ')}</span>`;
                        reviewDetails.appendChild(p);
                    }
                }
            }

            form.addEventListener('change', (e) => {
                if (e.target.name === 'reservationType') {
                    const isVehicle = e.target.value === 'vehicle';
                    vehicleDetails.classList.toggle('hidden', !isVehicle);
                    venueDetails.classList.toggle('hidden', isVehicle);
                    if (isVehicle) {
                        // Use timeout to ensure the map container is visible before initializing
                        setTimeout(() => {
                            initMap();
                        }, 10);
                    }
                }
            });

            nextBtn.addEventListener("click", () => {
                const currentStepFields = steps[currentStep].querySelectorAll('[required]');
                let isValid = true;
                currentStepFields.forEach(field => {
                    const isRadioGroup = field.type === 'radio';
                    const isSelected = isRadioGroup ? form.querySelector(`[name="${field.name}"]:checked`) : field.value;

                    if (!isSelected) {
                        isValid = false;
                        field.closest('label')?.classList.add('border-red-500');
                        field.classList.add('border-red-500');
                    } else {
                        field.closest('label')?.classList.remove('border-red-500');
                        field.classList.remove('border-red-500');
                    }
                });

                if (isValid && currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                    if (currentStep === steps.length - 1) {
                        generateReviewSummary();
                    }
                }
            });

            prevBtn.addEventListener("click", () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Initial setup
            showStep(currentStep);
        });

       document.getElementById('submitBtn').addEventListener('click', function(e) {
    e.preventDefault();

    const form = document.querySelector('form');
    var formData = new FormData(form);

    formData.append('reserve', true);

    $.ajax({
        url: 'controllers/ReservationController.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function() {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we reserve your booking.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            console.log(response);

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Reservation Confirmed!',
                    text: 'Your reservation has been successfully made.'
                }).then(()=>{
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Reservation Failed',
                    text: response.message || 'Something went wrong.'
                });
            }
        },
        error: function(xhr, status, err) {
            Swal.close();
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Please try again later.'
            });
        }
    });
});

    </script>
</body>

</html>