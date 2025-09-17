
<?php
                                require_once 'config/db.php';

                                $venues = [];
                                $sql = "SELECT id, venue_name FROM venue ORDER BY venue_name ASC";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $venues[] = $row;
                                    }
                                }
                                $conn->close();
                                ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <title>GSO AOSR | Reservation</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .leaflet-container {
            background: #f9fafb;
        }

        /* Custom style for calendar cells from your original code */
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

<body class="bg-slate-100 text-slate-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-200">
        <div class="container mx-auto flex items-center justify-between px-6 py-4">
            <a href="#" class="text-2xl font-bold text-slate-900">GSO AOSR</a>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-slate-600 hover:text-indigo-600 transition font-medium">About</a>
                <a href="#" class="text-slate-600 hover:text-indigo-600 transition font-medium">Availability</a>
                <a href="views/auth/login.php"
                    class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition font-medium shadow-lg shadow-indigo-500/30">Login</a>
            </div>
        </div>
    </nav>

    <section id="reservation" class="py-12 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white border border-slate-200/80 shadow-2xl shadow-slate-300/30 rounded-3xl p-6 md:p-10">

                <h2 class="text-3xl font-bold text-slate-900 text-center mb-2">Create a Reservation</h2>
                <p class="text-center text-slate-500 mb-8">Follow the steps to complete your booking.</p>

                <div id="stepIndicator"
                    class="flex items-center justify-between mb-10 text-sm font-medium text-slate-500">
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            1</div><span class="step-label hidden md:block">Gov Type</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            2</div><span class="step-label hidden md:block">Res Type</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            3</div><span class="step-label hidden md:block">Info</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            4</div><span class="step-label hidden md:block">Schedule</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            5</div><span class="step-label hidden md:block">Purpose</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <div class="step-item text-center flex-1">
                        <div
                            class="step-number mx-auto w-10 h-10 flex items-center justify-center rounded-full border-2 mb-2">
                            6</div><span class="step-label hidden md:block">Review</span>
                    </div>
                </div>

                <form id="reservationForm" action="controllers/ReservationController.php" method="post" novalidate>

                    <div class="step active">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">1. Select Government Type</h3>
                        <p class="text-slate-500 mb-6">What is your Government Type?</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label for="capitol"
                                class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 hover:border-indigo-400">
                                <input type="radio" name="govType" id="capitol" class="absolute opacity-0"
                                    value="capitol" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 21h18M4 3h16M5 3v18m14-18v18M9 7h6m-6 4h6m-6 4h6" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Capitol Offices</p>
                            </label>
                            <label for="private"
                                class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 hover:border-indigo-400">
                                <input type="radio" name="govType" id="private" class="absolute opacity-0"
                                    value="private" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m4 0H4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7h16z" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Private Offices</p>
                            </label>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">2. Select Reservation Type</h3>
                        <p class="text-slate-500 mb-6">What would you like to book?</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label for="venue"
                                class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 hover:border-indigo-400">
                                <input type="radio" name="reservationType" id="venue" class="absolute opacity-0"
                                    value="place" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 12h6.75m-6.75 5.25h6.75M5.25 21v-18" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Book a Venue</p>
                            </label>
                            <label for="vehicle"
                                class="relative cursor-pointer border-2 border-slate-200 rounded-xl p-6 text-center transition-all duration-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 hover:border-indigo-400">
                                <input type="radio" name="reservationType" id="vehicle" class="absolute opacity-0"
                                    value="vehicle" required>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875m0-16.5v-1.5a1.125 1.125 0 00-1.125-1.125h-1.5a1.125 1.125 0 00-1.125 1.125v1.5m17.25-3.375v1.5c0 .621-.504 1.125-1.125 1.125h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125h1.5c.621 0 1.125.504 1.125 1.125z" />
                                </svg>
                                <p class="text-lg font-semibold text-slate-800">Request a Vehicle</p>
                            </label>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">3. Your Information</h3>
                        <p class="text-slate-500 mb-6">Please provide your contact details.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div class="md:col-span-2"><label
                                    class="block mb-1.5 text-sm font-medium text-slate-600">Email Address</label><input
                                    type="email" name="email"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="name@example.com" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">First Name</label><input
                                    type="text" name="first_name"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Juan" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Last Name</label><input
                                    type="text" name="last_name"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Dela Cruz" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Title</label><input
                                    type="text" name="title"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Title" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Organization
                                    Name</label><input type="text" name="org_name"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="e.g., Provincial Government of Iloilo" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Phone
                                    Number</label><input type="text" name="phone_number"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="+63 900 000 0000" required></div>
                            <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Address</label><input
                                    type="text" name="address"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="123 Main St, Iloilo City" required></div>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">4. Schedule & Details</h3>
                        <p class="text-slate-500 mb-6">When do you need the reservation?</p>

                        <div id="venue-details" class="hidden space-y-5">
                            <h4 class="text-md font-semibold text-slate-700 border-b pb-2">Venue Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Name of
                                        Event</label><input type="text" name="event_name"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="e.g., Social Party"></div>
                                
                                <div>
                                    <label class="block mb-1.5 text-sm font-medium text-slate-600">
                                        Select Venue
                                    </label>
                                    <select name="res_place" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option disabled selected>Choose a place...</option>
                                        
                                        <?php
                                        foreach ($venues as $venue) {
                                            $id = htmlspecialchars($venue['id']);
                                            $name = htmlspecialchars($venue['venue_name']);
                                            echo "<option value=\"{$id}\">{$name}</option>";
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                                <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Number of
                                        Persons</label><input type="number" name="num_person"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="e.g., 50"></div>
                                <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Number of
                                        Chairs</label><input type="number" name="num_chairs"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="e.g., 50"></div>
                                <div class="md:col-span-2"><label
                                        class="block mb-1.5 text-sm font-medium text-slate-600">Sound
                                        Systems</label><select name="sound_system"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="No" selected> No</option>
                                        <option value="Yes">Yes</option>
                                    </select></div>
                            </div>

                            <div id="calendar-wrapper" class="pt-4">
                                <h4 class="text-md font-semibold text-slate-700 border-b pb-2 mb-4">Check Availability
                                </h4>
                                <div class="bg-white rounded-lg border">
                                    <div class="flex items-center justify-between gap-3 mb-4 p-4">
                                        <div class="flex items-center gap-4">
                                            <h5 id="calendar-title" class="text-lg font-semibold text-slate-900"></h5>
                                            <div class="flex items-center gap-2">
                                                <button id="prev-month-btn" type="button"
                                                    class="text-slate-500 rounded-full w-8 h-8 flex items-center justify-center transition-colors hover:bg-slate-100"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 16 16" fill="none">
                                                        <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719"
                                                            stroke="currentcolor" stroke-width="1.3"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></button>
                                                <button id="next-month-btn" type="button"
                                                    class="text-slate-500 rounded-full w-8 h-8 flex items-center justify-center transition-colors hover:bg-slate-100"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 16 16" fill="none">
                                                        <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998"
                                                            stroke="currentcolor" stroke-width="1.3"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="grid grid-cols-7 border-t border-b border-slate-200 divide-x divide-slate-200">
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Sun</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Mon</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Tue</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Wed</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Thu</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Fri</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-slate-500">Sat</span></div>
                                    </div>
                                    <div id="calendar-grid"
                                        class="grid grid-cols-7 divide-x divide-slate-200 border-b border-slate-200">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="vehicle-details" class="hidden space-y-5">
                            <h4 class="text-md font-semibold text-slate-700 border-b pb-2">Vehicle Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Vehicle Type</label>
                                     <select name="v_type" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                         <option disabled selected>Choose a vehicle...</option>
                                         <option value= "Sedan">Sedan</option>
                                         <option value= "SUV / Pickup">SUV / Pickup</option>
                                         <option value= "Van">Van</option>
                                         <option value= "Bus">Bus</option>
                                     </select>
                                 </div>
                                 <div>
                                     <label class="block mb-1.5 text-sm font-medium text-slate-600">Number of Passengers</label>
                                     <input type="number" name="num_pass" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 4">
                                 </div>
                            </div>
                            <div id="map-wrapper">
                                <h4 class="text-md font-semibold text-slate-700 pt-4 border-b pb-2">Set Destination</h4>
                                <p class="text-sm text-slate-500 mt-2">Click on the map to drop a pin on your
                                    destination.</p>
                                <div id="map" class="w-full h-80 rounded-xl shadow-md mt-3 border z-0"></div>
                                <input type="hidden" name="latitude" id="dest-lat"><input type="hidden" name="longitude"
                                    id="dest-lng">
                            </div>
                        </div>

                        <div class="space-y-5 mt-5 pt-5 border-t">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Start Date &
                                        Time</label><input type="datetime-local" name="start_datetime"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        required></div>
                                <div><label class="block mb-1.5 text-sm font-medium text-slate-600">End Date &
                                        Time</label><input type="datetime-local" name="end_datetime"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        required></div>
                            </div>
                        </div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">5. Purpose of Reservation</h3>
                        <p class="text-slate-500 mb-6">Let us know why you are making this reservation.</p>
                        <div><label class="block mb-1.5 text-sm font-medium text-slate-600">Purpose / Name of
                                Event</label><textarea name="purpose" rows="5"
                                class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g., Official Business Trip to Passi City" required></textarea></div>
                    </div>

                    <div class="step">
                        <h3 class="text-xl font-semibold mb-2 text-slate-800">6. Review & Submit</h3>
                        <p class="text-slate-500 mb-6">Please double-check your details before submitting.</p>
                        <div class="bg-slate-50/80 rounded-lg p-6 border space-y-3">
                            <div id="review-details"></div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-10">
                        <button type="button" id="prevBtn"
                            class="hidden bg-slate-200 text-slate-800 px-6 py-3 rounded-full font-semibold transition hover:bg-slate-300">Previous</button>
                        <button type="button" id="nextBtn"
                            class="ml-auto bg-indigo-600 text-white px-8 py-3 rounded-full font-semibold transition hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">Next
                            Step</button>
                        <button type="button" id="submitBtn" name="reserve"
                            class="hidden bg-emerald-600 text-white px-8 py-3 rounded-full font-semibold transition hover:bg-emerald-700 shadow-lg shadow-emerald-500/30">Submit
                            Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Form Navigation Variables ---
        const steps = document.querySelectorAll(".step");
        const stepItems = document.querySelectorAll(".step-item");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");
        const form = document.getElementById("reservationForm");
        const venueDetails = document.getElementById("venue-details");
        const vehicleDetails = document.getElementById("vehicle-details");
        const reviewDetails = document.getElementById("review-details");

        // --- Map Variables ---
        const mapWrapper = document.getElementById('map-wrapper');
        let map = null;
        let destinationMarker = null;

        // --- Calendar Variables ---
        const calendarTitle = document.getElementById("calendar-title");
        const calendarGrid = document.getElementById("calendar-grid");
        const prevMonthBtn = document.getElementById("prev-month-btn");
        const nextMonthBtn = document.getElementById("next-month-btn");
        let currentMonth = new Date();
        let reservedDates = []; // Fetched from server

        // --- State ---
        let currentStep = 0;

        // --- FORM NAVIGATION LOGIC ---
        function updateStepIndicator() {
            stepItems.forEach((item, index) => {
                const number = item.querySelector('.step-number');
                const label = item.querySelector('.step-label');
                if (index < currentStep) {
                    number.classList.add('bg-emerald-500', 'border-emerald-500', 'text-white');
                    number.classList.remove('bg-indigo-600', 'border-indigo-600');
                    number.innerHTML = `&#10003;`;
                } else if (index === currentStep) {
                    number.classList.add('bg-indigo-600', 'border-indigo-600', 'text-white');
                    label.classList.add('text-indigo-600');
                    number.innerHTML = index + 1;
                } else {
                    number.classList.remove('bg-indigo-600', 'border-indigo-600', 'text-white', 'bg-emerald-500', 'border-emerald-500');
                    label.classList.remove('text-indigo-600');
                    number.innerHTML = index + 1;
                }
            });
        }

        function showStep(stepIndex) {
            steps.forEach((step, index) => step.classList.toggle("active", index === stepIndex));
            prevBtn.classList.toggle("hidden", stepIndex === 0);
            nextBtn.classList.toggle("hidden", stepIndex === steps.length - 1);
            submitBtn.classList.toggle("hidden", stepIndex !== steps.length - 1);
            updateStepIndicator();
        }

        nextBtn.addEventListener("click", () => {
            const currentStepFields = steps[currentStep].querySelectorAll('[required]');
            let isValid = true;
            currentStepFields.forEach(field => {
                if (!field.value || (field.type === 'radio' && !form.querySelector(`[name="${field.name}"]:checked`))) {
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

        form.addEventListener('change', (e) => {
            if (e.target.name === 'reservationType') {
                const isVehicle = e.target.value === 'vehicle';
                vehicleDetails.classList.toggle('hidden', !isVehicle);
                venueDetails.classList.toggle('hidden', isVehicle);
                if (isVehicle) {
                    setTimeout(() => {
                        initMap();
                        map.invalidateSize();
                    }, 10);
                }
            }
        });

        // --- MAP LOGIC ---
        function initMap() {
            if (map) return;
            map = L.map('map').setView([10.7202, 122.5621], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function (e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                document.getElementById('dest-lat').value = lat.toFixed(6);
                document.getElementById('dest-lng').value = lng.toFixed(6);
                if (destinationMarker) map.removeLayer(destinationMarker);
                destinationMarker = L.marker([lat, lng]).addTo(map).bindPopup(`<b>Destination Pinned</b>`).openPopup();
            });
        }

        // --- CALENDAR LOGIC ---
        async function fetchReservedDates() {
            try {
                // Replace 'fetch_data.php' with your actual endpoint if needed
                const response = await fetch('fetch_data.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const dates = await response.json();
                reservedDates = dates;
                updateCalendar();
            } catch (error) {
                console.error('Error fetching reserved dates:', error);
                // For demonstration, using dummy data if fetch fails
                reservedDates = ['2025-09-25', '2025-09-26'];
                updateCalendar();
            }
        }

        function updateCalendar() {
            if (!calendarGrid || !calendarTitle) return;

            calendarGrid.innerHTML = '';
            calendarTitle.textContent = currentMonth.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });

            const firstDay = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 1);
            const lastDay = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 0);
            const startDayIndex = firstDay.getDay();
            const lastDate = lastDay.getDate();
            const prevLastDate = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 0).getDate();

            // Previous month's days
            for (let i = startDayIndex; i > 0; i--) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day-cell bg-slate-50/50 border-b';
                dayEl.innerHTML = `<span class="text-xs font-semibold text-slate-400 w-7 h-7 rounded-full">${prevLastDate - i + 1}</span>`;
                calendarGrid.appendChild(dayEl);
            }

            // --- THIS ENTIRE LOOP WAS MISSING ---
            // Current month's days
            for (let i = 1; i <= lastDate; i++) {
                const dayEl = document.createElement('div');
                const date = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), i);
                const isToday = date.toDateString() === new Date().toDateString();
                const dateString = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const isReserved = reservedDates.includes(dateString);

                dayEl.className = 'calendar-day-cell border-b transition-all duration-300';
                dayEl.innerHTML = `<span class="text-sm font-semibold text-slate-800 w-8 h-8 flex items-center justify-center rounded-full transition-colors ${isToday ? 'bg-indigo-600 text-white' : ''}">${i}</span>`;

                if (isReserved) {
                    dayEl.classList.add('bg-rose-100/60', 'cursor-not-allowed');
                    dayEl.innerHTML += `<div class="mt-2 text-rose-700 text-xs font-semibold text-center">Reserved</div>`;
                } else {
                    dayEl.classList.add('bg-white', 'hover:bg-slate-50', 'cursor-pointer');
                    dayEl.innerHTML += `<div class="mt-2 text-emerald-700 text-xs font-semibold text-center">Available</div>`;
                }
                calendarGrid.appendChild(dayEl);
            }
            // --- END OF MISSING CODE ---
        }

        prevMonthBtn.addEventListener("click", () => {
            currentMonth.setMonth(currentMonth.getMonth() - 1);
            updateCalendar();
        });

        nextMonthBtn.addEventListener("click", () => {
            currentMonth.setMonth(currentMonth.getMonth() + 1);
            updateCalendar();
        });

        // --- REVIEW & SUBMIT LOGIC ---
        function generateReviewSummary() {
            reviewDetails.innerHTML = '';
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const friendlyLabels = {
                govType: "Government Type", reservationType: "Reservation Type", email: "Email", first_name: "First Name", last_name: "Last Name", title: "Title", org_name: "Organization", phone_number: "Phone", address: "Address", event_name: "Event Name", res_place: "Venue", num_person: "Persons", num_chairs: "Chairs", sound_system: "Sound System", v_type: "Vehicle Type", num_pass: "Passengers", start_datetime: "Start Time", end_datetime: "End Time", purpose: "Purpose", latitude: "Destination Latitude", longitude: "Destination Longitude"
            };
            for (const key in data) {
                if (data[key] && friendlyLabels[key]) {
                    if (data.reservationType === 'place' && (key.startsWith('v_') || key === 'num_pass' || key.startsWith('lat') || key.startsWith('lon'))) continue;
                    if (data.reservationType === 'vehicle' && (['event_name', 'res_place', 'num_person', 'num_chairs', 'sound_system'].includes(key))) continue;
                    const p = document.createElement('p');
                    p.innerHTML = `<strong class="font-semibold text-slate-900">${friendlyLabels[key]}:</strong> <span class="text-slate-600">${data[key].replace('T', ' ')}</span>`;
                    reviewDetails.appendChild(p);
                }
            }
        }

        submitBtn.addEventListener('click', function(e) {
             e.preventDefault();
             const formData = new FormData(form);
             formData.append('reserve', true);
             $.ajax({
                 url: 'controllers/ReservationController.php', type: 'POST', dataType: 'json', processData: false, contentType: false, data: formData,
                 beforeSend: () => Swal.fire({ title: 'Processing...', text: 'Please wait...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }),
                 success: (response) => {
                    console.log(response)
                     if (response.success) {
                         Swal.fire({ icon: 'success', title: 'Reservation Confirmed!', text: 'Your reservation has been made.' }).then(() => location.reload());
                     } else {
                         Swal.fire({ icon: 'error', title: 'Reservation Failed', text: response.message || 'Something went wrong.' });
                     }
                 },
                 error: (xhr, status, err) => {
                    console.log(xhr.responseText);
                    Swal.fire({ icon: 'error', title: 'Server Error', text: 'Please try again later.' });
             }
        });

        // --- INITIALIZATION ---
        showStep(currentStep);
        fetchReservedDates();
        
    }); // <-- THIS WAS IN THE WRONG PLACE. It now correctly wraps the entire script.
});
</script>
</body>

</html>