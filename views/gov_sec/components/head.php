<?php include '../../config/init.php'?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
        }
    </style>

     <style>
        /* ✅ Custom styles to make DataTables match the new design */
        .dataTables_wrapper {
            padding: 1.5rem;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .dataTables_filter input {
            width: 100%;
            max-width: 300px;
            padding: 0.6rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .dataTables_filter input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgb(79 70 229 / 0.2);
            outline: none;
        }

        .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
        }

        .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            margin: 0 2px;
            border-radius: 0.375rem;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #4f46e5;
            color: white !important;
            border: 1px solid #4f46e5;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #e0e7ff;
            border-color: #c7d2fe;
        }
    </style>
</head>