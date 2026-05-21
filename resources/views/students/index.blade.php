<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Management Dashboard</title>
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Toastr CSS & JS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; flex-direction: column; min-height: 100vh; background-color: #ffffff; }
        .navbar { background-color: #0056b3; padding: 15px 0; text-align: center; }
        .navbar a { color: white; text-decoration: none; margin: 0 20px; font-size: 16px; font-weight: bold; }
        .navbar a:hover { text-decoration: underline; }
        .main-container { display: flex; flex: 1; }
        .sidebar { width: 250px; background-color: #f8f9fa; padding: 40px 20px; border-right: 1px solid #e9ecef; }
        .sidebar h2 { color: #0056b3; margin-bottom: 20px; font-size: 24px; }
        .sidebar ul { list-style-type: square; padding-left: 20px; }
        .sidebar ul li { margin-bottom: 12px; }
        .sidebar ul li a { color: #0056b3; text-decoration: underline; font-size: 16px; cursor: pointer; }
        .content { flex: 1; padding: 40px; text-align: center; }
        .content h1 { color: #0056b3; margin-bottom: 25px; font-size: 28px; }
        
        .filter-card { background: #f8f9fa; padding: 20px; border: 1px solid #e9ecef; border-radius: 8px; margin-bottom: 30px; max-width: 900px; margin-left: auto; margin-right: auto; }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 15px; text-align: left; }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label { font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px; }
        .filter-group input, .filter-group select { padding: 10px; font-size: 14px; border: 1px solid #cccccc; border-radius: 4px; outline: none; width: 100%; }
        .filter-actions { display: flex; justify-content: flex-end; gap: 10px; }
        
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; font-size: 14px; margin-right: 5px; cursor: pointer; border: none; display: inline-block; }
        .btn-search { background-color: #0056b3; padding: 10px 25px; font-size: 16px; font-weight: bold; }
        .btn-search:hover { background-color: #004085; }
        .btn-reset { background-color: #6c757d; padding: 10px 25px; font-size: 16px; font-weight: bold; color: white; }
        .btn-reset:hover { background-color: #5a6268; }
        .btn-add { background-color: #28a745; margin-bottom: 20px; padding: 10px 20px; font-size: 16px;}
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-quick-edit { background-color: #17a2b8; color: white; } 
        .btn-delete { background-color: #dc3545; }
        
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #0056b3; color: white; padding: 12px; font-weight: bold; text-align: left; border: 1px solid #004085; }
        td { padding: 12px; border: 1px solid #dddddd; text-align: left; }
        
        footer { background-color: #004085; color: white; text-align: center; padding: 15px 0; font-size: 14px; margin-top: auto; }
        .pagination-links { margin-top: 20px; display: flex; justify-content: center; flex-direction: column; align-items: center; }
        .pagination-links svg { width: 20px; height: 20px; }
        .pagination-links nav p { margin-top: 10px; font-size: 14px; color: #555; }
        .pagination-links flex, .pagination-links .flex { display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 400px; }

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center; }
        .modal-container { background: white; padding: 30px; border-radius: 8px; max-width: 500px; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-align: left; position: relative; }
        .modal-container h2 { margin-bottom: 15px; color: #0056b3; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select { padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .error-list { color: red; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; display: none; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="{{ route('student.index') }}">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
    </div>

    <div class="main-container">
        <div class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="{{ route('student.index') }}">Students List</a></li>
                <!-- রিলোড বন্ধ করার জন্য এখানে আইডি এবং প্রিভেন্ট যুক্ত করা হয়েছে -->
                <li><a id="sidebar-add-student-btn">Add Student</a></li>
            </ul>
        </div>

        <div class="content">
            <h1>Students List</h1>

            <!-- Advanced Filter & Search Form -->
            <div class="filter-card">
                <form id="filter-form" action="{{ route('student.index') }}" method="GET">
                    <div class="filter-grid">
                        <div class="filter-group" style="grid-column: span 2;">
                            <label for="search">Search</label>
                            <input type="text" placeholder="Search by Name, Email, Age, Score, Gender..." id="search" name="search" value="{{ request('search') }}">
                        </div>

                        <div class="filter-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option value="">All Genders</option>
                                <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Male</option>
                                <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="age">Age</label>
                            <input type="number" placeholder="Exact Age" id="age" name="age" value="{{ request('age') }}">
                        </div>

                        <div class="filter-group">
                            <label for="min_score">Exact Score</label>
                            <input type="number" step="0.01" placeholder="Exact Score" id="min_score" name="min_score" value="{{ request('min_score') }}">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <a href="{{ route('student.index') }}" class="btn btn-reset">Reset</a>
                        <button type="submit" class="btn btn-search">Apply Filters</button>
                    </div>
                </form>
            </div>

            <div style="text-align: right;">
                <!-- রিলোড ছাড়া ওপেন হওয়ার জন্য বাটন করা হলো -->
                <button type="button" id="add-student-m-btn" class="btn btn-add">Add New Student</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="student-table-body">
                        @include('students.table_rows')
                    </tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            <div class="pagination-links" id="pagination-container">
                {{ $students->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- ১. ADD NEW STUDENT MODAL -->
    <div class="modal-overlay" id="add-student-modal">
        <div class="modal-container">
            <h2>Add New Student</h2>
            <div class="error-list" id="add-modal-errors"></div>
            <form id="add-student-form">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Score</label>
                    <input type="number" step="0.01" name="score" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-reset close-add-modal">Cancel</button>
                    <button type="submit" class="btn btn-add" style="margin-right:0;">Save Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ২. FULL EDIT STUDENT MODAL -->
    <div class="modal-overlay" id="full-edit-modal">
        <div class="modal-container">
            <h2>Edit Student Information</h2>
            <div class="error-list" id="full-edit-modal-errors"></div>
            <form id="full-edit-form">
                <input type="hidden" id="full-student-id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="f-name" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="f-email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" id="f-age" name="age" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" id="f-dob" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select id="f-gender" name="gender" required>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Score</label>
                    <input type="number" step="0.01" id="f-score" name="score" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-reset" id="close-full-modal">Cancel</button>
                    <button type="submit" class="btn btn-edit" style="margin-right:0; background-color:#ffc107; color:black;">Update Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ৩. QUICK EDIT MODAL -->
    <div class="modal-overlay" id="quick-edit-modal">
        <div class="modal-container">
            <h2>Quick Edit Student</h2>
            <div class="error-list" id="quick-modal-errors"></div>

            <form id="quick-edit-form">
                <input type="hidden" id="quick-student-id" name="id">

                <div class="form-group">
                    <label for="q-name">Name</label>
                    <input type="text" id="q-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="q-email">Email</label>
                    <input type="email" id="q-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="q-age">Age</label>
                    <input type="number" id="q-age" name="age" required>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-reset" id="close-quick-modal">Cancel</button>
                    <button type="submit" class="btn btn-quick-edit">Update Info</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2026 My Website. All rights reserved.
    </footer>

    <!-- AJAX CRUD SCRIPT -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };

            function fetchStudents(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#student-table-body').html(response.html);
                        $('#pagination-container').html(response.pagination);
                    },
                    error: function() {
                        toastr.error("Something went wrong while fetching data.");
                    }
                });
            }

            // Filter Form Submit
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action') + '?' + $(this).serialize();
                fetchStudents(url);
            });

            // Pagination Controls
            $(document).on('click', '.pagination-links a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                fetchStudents(url);
            });

            // --- ADD STUDENT AJAX ---
            $('#add-student-m-btn, #sidebar-add-student-btn').on('click', function(e) {
                e.preventDefault();
                $('#add-modal-errors').hide().empty();
                $('#add-student-form')[0].reset();
                $('#add-student-modal').css('display', 'flex');
            });

            $('.close-add-modal, #add-student-modal').on('click', function(e) {
                if (e.target === this) { $('#add-student-modal').hide(); }
            });

            $('#add-student-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('student.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#add-student-modal').hide();
                        toastr.success("Student added successfully!");
                        fetchStudents("{{ route('student.index') }}");
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul style="list-style:none; padding-left:0;">';
                            $.each(errors, function(key, val) { errorHtml += `<li>⚠️ ${val[0]}</li>`; });
                            errorHtml += '</ul>';
                            $('#add-modal-errors').html(errorHtml).show();
                        } else {
                            toastr.error("Something went wrong.");
                        }
                    }
                });
            });

            // --- FULL EDIT AJAX ---
            $(document).on('click', '.full-edit-student-btn', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#full-edit-modal-errors').hide().empty();

                $.ajax({
                    url: `/student/${id}/edit`,
                    type: 'GET',
                    data: { ajax: true },
                    success: function(data) {
                        $('#full-student-id').val(data.id);
                        $('#f-name').val(data.name);
                        $('#f-email').val(data.email);
                        $('#f-age').val(data.age);
                        $('#f-dob').val(data.date_of_birth);
                        $('#f-gender').val(data.gender);
                        $('#f-score').val(data.score);

                        $('#full-edit-modal').css('display', 'flex');
                    },
                    error: function() { toastr.error("Failed to fetch data."); }
                });
            });

            $('#close-full-modal, #full-edit-modal').on('click', function(e) {
                if (e.target === this) { $('#full-edit-modal').hide(); }
            });

            $('#full-edit-form').on('submit', function(e) {
                e.preventDefault();
                let id = $('#full-student-id').val();
                $.ajax({
                    url: `/student/${id}`,
                    type: 'POST',
                    data: $(this).serialize() + '&_method=PUT',
                    success: function(response) {
                        $('#full-edit-modal').hide();
                        toastr.success("Student updated successfully!");
                        let currentUrl = $('#filter-form').attr('action') + '?' + $('#filter-form').serialize();
                        fetchStudents(currentUrl);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul style="list-style:none; padding-left:0;">';
                            $.each(errors, function(key, val) { errorHtml += `<li>⚠️ ${val[0]}</li>`; });
                            errorHtml += '</ul>';
                            $('#full-edit-modal-errors').html(errorHtml).show();
                        } else {
                            toastr.error("Update failed.");
                        }
                    }
                });
            });

            // --- QUICK EDIT AJAX ---
            $(document).on('click', '.quick-edit-student-btn', function() {
                let id = $(this).data('id');
                $('#quick-modal-errors').hide().empty();

                $.ajax({
                    url: `/student/${id}/edit`, 
                    type: 'GET',
                    data: { ajax: true },
                    success: function(data) {
                        $('#quick-student-id').val(data.id);
                        $('#q-name').val(data.name);
                        $('#q-email').val(data.email);
                        $('#q-age').val(data.age);

                        $('#quick-edit-modal').css('display', 'flex');
                    },
                    error: function() { toastr.error("Failed to fetch data."); }
                });
            });

            $('#close-quick-modal, #quick-edit-modal').on('click', function(e) {
                if (e.target === this) { $('#quick-edit-modal').hide(); }
            });

            $('#quick-edit-form').on('submit', function(e) {
                e.preventDefault();
                let id = $('#quick-student-id').val();

                $.ajax({
                    url: `/student/${id}/quick-update`, 
                    type: 'PUT', 
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#quick-edit-modal').hide();
                        toastr.success(response.success);
                        let currentUrl = $('#filter-form').attr('action') + '?' + $('#filter-form').serialize();
                        fetchStudents(currentUrl);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul style="list-style:none; padding-left:0;">';
                            $.each(errors, function(key, val) { errorHtml += `<li>⚠️ ${val[0]}</li>`; });
                            errorHtml += '</ul>';
                            $('#quick-modal-errors').html(errorHtml).show();
                        } else {
                            toastr.error("An error occurred.");
                        }
                    }
                });
            });

            // --- DELETE AJAX ---
            $(document).on('click', '.delete-student-btn', function() {
                if (confirm('Are you sure you want to delete this student?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/student/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            toastr.warning(response.success);
                            let currentUrl = $('#filter-form').attr('action') + '?' + $('#filter-form').serialize();
                            fetchStudents(currentUrl);
                        },
                        error: function() { toastr.error("Could not delete student."); }
                    });
                }
            });
        });
    </script>
</body>
</html>