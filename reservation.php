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

    <section id="reservation" class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-[750px]">
            <div class="bg-gray-50 shadow-xl rounded-3xl p-6 md:p-12">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Reservation Form</h2>

                <div class="flex justify-center mb-6">
                    <div id="stepIndicator" class="flex gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-600 transition-colors duration-300"></span>
                        <span class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300"></span>
                        <span class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300"></span>
                        <span class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300"></span>
                        <span class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300"></span>
                        <span class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300"></span>
                    </div>
                </div>

                <form id="reservationForm" action="controllers/ReservationController.php" method="post" novalidate>
                    <div class="step active">
                        <p class="font-semibold mb-2">Reservation Type</p>
                        <div class="flex gap-4 mb-6">
                            <input type="radio" name="reservationType" id="venue" class="hidden peer/venue"
                                value="place">
                            <label for="venue"
                                class="flex-1 cursor-pointer border-2 border-gray-200 rounded-lg px-6 py-4 text-center font-medium transition-colors duration-200 peer-checked/venue:bg-blue-600 peer-checked/venue:text-white peer-checked/venue:border-blue-600 hover:border-blue-400">Venue</label>

                            <input type="radio" name="reservationType" id="vehicle" class="hidden peer/vehicle"
                                value="vehicle">
                            <label for="vehicle"
                                class="flex-1 cursor-pointer border-2 border-gray-200 rounded-lg px-6 py-4 text-center font-medium transition-colors duration-200 peer-checked/vehicle:bg-blue-600 peer-checked/vehicle:text-white peer-checked/vehicle:border-blue-600 hover:border-blue-400">Vehicle</label>
                        </div>
                        <p class="font-semibold mb-2">Type of Government</p>
                        <div class="flex gap-4">
                            <input type="radio" name="govType" id="capitol" class="hidden peer/capitol" value="capitol">
                            <label for="capitol"
                                class="flex-1 cursor-pointer border-2 border-gray-200 rounded-lg px-6 py-4 text-center font-medium transition-colors duration-200 peer-checked/capitol:bg-blue-600 peer-checked/capitol:text-white peer-checked/capitol:border-blue-600 hover:border-blue-400">Capitol
                                Offices</label>

                            <input type="radio" name="govType" id="private" class="hidden peer/private" value="private">
                            <label for="private"
                                class="flex-1 cursor-pointer border-2 border-gray-200 rounded-lg px-6 py-4 text-center font-medium transition-colors duration-200 peer-checked/private:bg-blue-600 peer-checked/private:text-white peer-checked/private:border-blue-600 hover:border-blue-400">Private</label>
                        </div>
                    </div>

                    <div class="step">
                        <p class="font-semibold mb-3">Personal Information</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block mb-1 font-medium">Email Address</label>
                                <input type="email" name="email"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="name@example.com" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">First Name</label>
                                <input type="text" name="first_name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="John" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Last Name</label>
                                <input type="text" name="last_name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Doe" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Title/Position</label>
                                <input type="text" name="title"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Position" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Organization Name</label>
                                <input type="text" name="org_name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Organization Name" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Phone Number</label>
                                <input type="tel" name="phone_number"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="+63 900 000 0000" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Address</label>
                                <input type="text" name="address"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="123 Main St" required>
                            </div>
                        </div>
                    </div>

                    <div class="step">
                        <div id="venue-details">
                            <p class="font-semibold mb-3">Venue Reservation Details</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block mb-1 font-medium">Name of Event</label>
                                    <input type="text" name="event_name"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Event Name">
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium">Reservation Place</label>
                                    <select name="res_place"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Choose...</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium">Number of Persons</label>
                                    <input type="number" name="num_person"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="e.g. 50">
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium">Number of Chairs</label>
                                    <input type="number" name="num_chairs"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="e.g. 50">
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium">Sound System</label>
                                    <select name="sound_system"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Choose...</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div id="vehicle-details" class="hidden">
                            <p class="font-semibold mb-3">Vehicle Reservation Details</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-1 font-medium">Vehicle Type</label>
                                    <select name="vehicle_type"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Choose...</option>
                                        <option>Car</option>
                                        <option>Van</option>
                                        <option>Bus</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium">Number of Passengers</label>
                                    <input type="number" name="num_passengers"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="e.g. 10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step">
                        <section id="calendar" class="py-20 bg-gray-100">
                            <div class="container mx-auto px-4 max-w-6xl">
                                <h2 class="text-4xl font-bold text-gray-900 text-center mb-10">Check Availability</h2>
                                <div class="bg-white shadow-xl rounded-2xl p-6 md:p-10">
                                    <div class="flex items-center justify-between gap-3 mb-4">
                                        <div class="flex items-center gap-4">
                                            <h5 id="calendar-title"
                                                class="text-xl leading-8 font-semibold text-gray-900"></h5>
                                            <div class="flex items-center gap-2">
                                                <button id="prev-month-btn" type="button"
                                                    class="text-gray-500 rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-300 hover:bg-gray-100 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 16 16" fill="none">
                                                        <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719"
                                                            stroke="currentcolor" stroke-width="1.3"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </button>
                                                <button id="next-month-btn" type="button"
                                                    class="text-gray-500 rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-300 hover:bg-gray-100 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 16 16" fill="none">
                                                        <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998"
                                                            stroke="currentcolor" stroke-width="1.3"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="grid grid-cols-7 border-t border-b border-gray-200 divide-x divide-gray-200">
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Sun</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Mon</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Tue</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Wed</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Thu</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Fri</span></div>
                                        <div class="p-3.5 text-center"><span
                                                class="text-sm font-medium text-gray-500">Sat</span></div>
                                    </div>
                                    <div id="calendar-grid"
                                        class="grid grid-cols-7 divide-x divide-gray-200 border-b border-gray-200">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div>
                            <label class="block mb-1 font-medium">Start Date</label>
                            <input type="date" name="start_date"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Start Time</label>
                            <input type="time" name="start_time"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">End Date</label>
                            <input type="date" name="end_date"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">End Time</label>
                            <input type="time" name="end_time"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>

                    <div class="step">
                        <div class="md:col-span-2">
                            <label class="block mb-1 font-medium">Purpose of the Event</label>
                            <textarea name="purpose" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-1 font-medium">Additional Notes</label>
                            <textarea name="additional_notes" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="step">
                        <p class="font-semibold mb-3">Review & Submit</p>
                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <p class="text-gray-600 mb-4">Please double-check your details before submitting your
                                reservation.</p>
                            <div id="review-details" class="space-y-3 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" id="prevBtn"
                            class="hidden bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-medium transition hover:bg-gray-300">Previous</button>
                        <button type="button" id="nextBtn"
                            class="bg-blue-600 text-white px-6 py-3 rounded-full font-medium transition hover:bg-blue-700">Next</button>
                        <button type="submit" id="submitBtn" name="reserve"
                            class="hidden bg-green-600 text-white px-6 py-3 rounded-full font-medium transition hover:bg-green-700">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Form & Calendar Script
        const steps = document.querySelectorAll(".step");
        const stepIndicators = document.querySelectorAll("#stepIndicator span");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");
        const venueRadio = document.getElementById("venue");
        const vehicleRadio = document.getElementById("vehicle");
        const venueDetails = document.getElementById("venue-details");
        const vehicleDetails = document.getElementById("vehicle-details");
        const reviewDetails = document.getElementById("review-details");
        const reservationForm = document.getElementById("reservationForm");
        const calendarTitle = document.getElementById("calendar-title");
        const calendarGrid = document.getElementById("calendar-grid");
        const prevMonthBtn = document.getElementById("prev-month-btn");
        const nextMonthBtn = document.getElementById("next-month-btn");

        let currentStep = 0;
        let currentMonth = new Date();
        let reservedDates = []; // Initialize as an empty array

        function showStep(step) {
            steps.forEach((s, i) => s.classList.toggle("active", i === step));
            stepIndicators.forEach((dot, i) => {
                dot.classList.toggle("bg-blue-600", i === step);
                dot.classList.toggle("bg-gray-300", i !== step);
            });
            prevBtn.classList.toggle("hidden", step === 0);
            nextBtn.classList.toggle("hidden", step === steps.length - 1);
            submitBtn.classList.toggle("hidden", step !== steps.length - 1);

            if (step === 3) {
                generateReviewSummary();
            }
        }

        function validateCurrentStep() {
            const currentStepForm = steps[currentStep];
            const inputs = currentStepForm.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            inputs.forEach(input => {
                if (!input.value) {
                    input.style.borderColor = 'red';
                    isValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });
            return isValid;
        }

        nextBtn.addEventListener("click", () => {
            if (validateCurrentStep() && currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        venueRadio.addEventListener("change", () => {
            venueDetails.classList.remove("hidden");
            vehicleDetails.classList.add("hidden");
        });

        vehicleRadio.addEventListener("change", () => {
            vehicleDetails.classList.remove("hidden");
            venueDetails.classList.add("hidden");
        });

        function generateReviewSummary() {
            reviewDetails.innerHTML = '';
            const formData = new FormData(reservationForm);
            for (const [key, value] of formData.entries()) {
                if (value) {
                    const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const detail = document.createElement('p');
                    detail.innerHTML = `<strong class="text-gray-900">${label}:</strong> <span class="text-gray-600">${value}</span>`;
                    reviewDetails.appendChild(detail);
                }
            }
        }

        // Function to fetch reserved dates from the PHP script
        async function fetchReservedDates() {
            try {
                const response = await fetch('fetch_data.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const dates = await response.json();
                reservedDates = dates; // The PHP script now sends back an array of strings
                updateCalendar(); // Call updateCalendar after the data is fetched
            } catch (error) {
                console.error('Error fetching reserved dates:', error);
                // In case of an error, still show the calendar without reserved dates
                updateCalendar();
            }
        }

        function updateCalendar() {
            calendarGrid.innerHTML = '';
            calendarTitle.textContent = currentMonth.toLocaleString('default', { month: 'long', year: 'numeric' });

            const firstDayOfMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 1);
            const lastDayOfMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 0);
            const startDay = firstDayOfMonth.getDay();
            const endDate = lastDayOfMonth.getDate();

            // Previous month's days
            const prevMonthLastDay = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 0).getDate();
            for (let i = startDay - 1; i >= 0; i--) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day-cell bg-gray-50 border-b transition-all duration-300';
                dayEl.innerHTML = `<span class="text-xs font-semibold text-gray-400 w-7 h-7 rounded-full">${prevMonthLastDay - i}</span>`;
                calendarGrid.appendChild(dayEl);
            }

            // Current month's days
            for (let i = 1; i <= endDate; i++) {
                const dayEl = document.createElement('div');
                const date = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), i);
                const isToday = date.toDateString() === new Date().toDateString();

                const dateString = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                const isReserved = reservedDates.includes(dateString);

                dayEl.className = `calendar-day-cell border-b transition-all duration-300`;
                dayEl.innerHTML = `<span class="text-xs font-semibold text-gray-900 w-7 h-7 flex items-center justify-center rounded-full transition-colors duration-200 ${isToday ? 'bg-blue-600 text-white' : ''}">${i}</span>`;

                if (isReserved) {
                    dayEl.classList.add('bg-red-200', 'hover:bg-red-300', 'cursor-not-allowed');
                    dayEl.innerHTML += `<div class="mt-2 text-red-700 text-xs font-medium text-center">Reserved</div>`;
                } else {
                    dayEl.classList.add('bg-white', 'hover:bg-gray-100', 'cursor-pointer');
                    dayEl.innerHTML += `<div class="mt-2 text-green-700 text-xs font-medium text-center">Available</div>`;
                }

                calendarGrid.appendChild(dayEl);
            }
        }

        prevMonthBtn.addEventListener("click", () => {
            currentMonth.setMonth(currentMonth.getMonth() - 1);
            updateCalendar();
        });

        nextMonthBtn.addEventListener("click", () => {
            currentMonth.setMonth(currentMonth.getMonth() + 1);
            updateCalendar();
        });

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);
            fetchReservedDates(); // Start the fetch process on page load
        });
    </script>
</body>

</html>