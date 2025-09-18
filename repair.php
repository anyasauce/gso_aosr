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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>GSO AOSR | Repair Request</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

  <?php include 'header.php'; ?>

  <section id="repair" class="py-12 md:py-20">
    <div class="container mx-auto px-4 max-w-2xl">
      <div class="bg-white border border-slate-200/80 shadow-2xl shadow-slate-300/30 rounded-3xl p-6 md:p-10">

        <h2 class="text-3xl font-bold text-slate-900 text-center mb-2">Repair Request</h2>
        <p class="text-center text-slate-500 mb-8">Fill out the form to request a repair.</p>

        <form action="controllers/RepairController.php" method="post">
          
          <div class="mb-8">
            <h3 class="text-xl font-semibold mb-2 text-slate-800">Email</h3>
            <input type="email" name="email" required
              class="w-full bg-slate-50 border border-slate-300 rounde  d-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Department Dropdown -->
          <div class="mb-8">
            <h3 class="text-xl font-semibold mb-2 text-slate-800">Select Department</h3>
            <p class="text-slate-500 mb-4">Choose which department is requesting the repair.</p>
            <select name="dept_name" required
              class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500">
              <option disabled selected>-- Select Department --</option>
              <option value="Department 1">Department 1</option>
              <option value="Department 2">Department 2</option>
              <option value="Department 3">Department 3</option>
              <option value="Department 4">Department 4</option>
            </select>
          </div>

          <!-- Problem Description -->
          <div class="mb-8">
            <h3 class="text-xl font-semibold mb-2 text-slate-800">Problem Description</h3>
            <p class="text-slate-500 mb-4">Describe the issue that needs repair.</p>
            <textarea name="concern" rows="6" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Broken projector in conference room" required></textarea>
          </div>

          <!-- Submit -->
          <div class="flex justify-end">
            <button type="button" name="repair" id = "submit"class="bg-indigo-600 text-white px-8 py-3 rounded-full font-semibold transition hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">
              Submit Repair Request
            </button>
          </div>

        </form>
      </div>
    </div>
  </section>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  document.getElementById('submit').addEventListener('click', function(e){
    e.preventDefault();


    var form = document.querySelector('form');
    var formData = new FormData(form);
    formData.append('add_repair', true);

    $.ajax({
      url : 'controllers/RepairController.php',
      type : 'POST',
      dataType : 'json',
      processData : false,
      contentType : false,
      data : formData,
      success  : function(response) {
        console.log(response);
        document.getElementById('form-message').innerText = "Reported";
        document.getElementById('form-message').classList.add('text-success');

        form.reset();
      }, error : function(xhr, status, err){
        console.log(xhr.responseText);
        document.getElementById('form-message').innerText = "An Error Occured";
        document.getElementById('form-message').classList.add('text-danger');

      }
    });
  });
</script>
</html>
