<?php
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>GSO AOSR | Repair Request</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .form-message.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-200 text-slate-800 antialiased">

    <?php include 'header.php'; ?>

    <section id="repair" class="py-12 md:py-20">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white border border-slate-200/60 shadow-xl shadow-slate-300/20 rounded-3xl p-6 md:p-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Submit a Repair Request</h2>
                    <p class="text-slate-500">Please provide the details below and we'll get right on it.</p>
                </div>
                
                <form id="repair-form">
                    <div id="success-message" class="hidden form-message opacity-0 -translate-y-2 transition-all duration-300 flex items-start space-x-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg p-4 mb-6">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <div>
                            <h4 class="font-semibold">Success!</h4>
                            <p class="text-sm">Your repair request has been submitted successfully.</p>
                        </div>
                    </div>
                    <div id="error-message" class="hidden form-message opacity-0 -translate-y-2 transition-all duration-300 flex items-start space-x-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg p-4 mb-6">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <div>
                            <h4 class="font-semibold">Error!</h4>
                            <p class="text-sm" id="error-text">Something went wrong. Please try again.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-semibold text-slate-700">Your Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                </div>
                                <input type="email" name="email" id="email" required class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-4 py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                            </div>
                        </div>

                        <div>
                            <label for="dept_name" class="block mb-2 text-sm font-semibold text-slate-700">Requesting Department</label>
                            <div class="relative">
                                 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <select name="dept_name" id="dept_name" required class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-4 py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition appearance-none">
                                    <option value="" disabled selected>-- Select a Department --</option>
                                    <option value="Department 1">Department 1</option>
                                    <option value="Department 2">Department 2</option>
                                    <option value="Department 3">Department 3</option>
                                    <option value="Department 4">Department 4</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="concern" class="block mb-2 text-sm font-semibold text-slate-700">Problem Description</label>
                            <textarea name="concern" id="concern" rows="5" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" placeholder="e.g., The air conditioning unit in the main hall is leaking water." required></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" id="submit-btn" class="w-full sm:w-auto flex items-center justify-center bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold transition hover:bg-indigo-700 active:scale-95 shadow-lg shadow-indigo-500/30 disabled:bg-indigo-400 disabled:cursor-not-allowed">
                            <span id="button-text">Submit Request</span>
                            <svg id="button-spinner" class="hidden animate-spin ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    const repairForm = $('#repair-form');
    const submitBtn = $('#submit-btn');
    const buttonText = $('#button-text');
    const buttonSpinner = $('#button-spinner');
    const successMessage = $('#success-message');
    const errorMessage = $('#error-message');
    const errorText = $('#error-text');

    repairForm.on('submit', function(e) {
        e.preventDefault();

        // Hide previous messages
        successMessage.addClass('hidden');
        errorMessage.addClass('hidden');
        
        // Basic validation
        if ($('#email').val() === '' || $('#dept_name').val() === null || $('#concern').val() === '') {
            errorText.text('Please fill out all required fields.');
            errorMessage.removeClass('hidden').addClass('show');
            return;
        }

        // ✅ UX UPGRADE: Set loading state
        submitBtn.prop('disabled', true);
        buttonText.text('Submitting...');
        buttonSpinner.removeClass('hidden');

        var formData = new FormData(this);
        formData.append('add_repair', true);

        $.ajax({
            url: 'controllers/RepairController.php',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function(response) {
                console.log(response);

                repairForm[0].reset(); // Reset the form
                successMessage.removeClass('hidden').addClass('show');
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMessage.removeClass('show').addClass('hidden');
                }, 5000);
            },
            error: function(xhr, status, err) {
                console.log(xhr.responseText);
                errorText.text('An unexpected error occurred. Please try again.');
                errorMessage.removeClass('hidden').addClass('show');
            },
            complete: function() {
                // ✅ UX UPGRADE: Reset button state
                submitBtn.prop('disabled', false);
                buttonText.text('Submit Request');
                buttonSpinner.addClass('hidden');
            }
        });
    });
});
</script>
</html>