<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background-color: #f8f9fa; }
        .form-container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; margin-bottom: 10px;}
        .btn-submit:hover { background-color: #218838; }
        .btn-back { display: block; text-align: center; background-color: #6c757d; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; font-size: 16px; }
        .btn-back:hover { background-color: #5a6268; }
        .error-list { color: red; background: #f8d7da; padding: 10px 20px; border-radius: 4px; margin-bottom: 15px; font-size: 14px;}
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Student</h2>
    <br>
    
    @if ($errors->any())
        <div class="error-list">
            <ul style="padding-left: 5px; list-style:none;">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.store') }}" method="POST">
        @csrf 

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" value="{{ old('age') }}" required>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="">Select Gender</option>
                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="score">Score</label>
            <input type="number" step="0.01" name="score" id="score" value="{{ old('score') }}" required>
        </div>

        <button type="submit" class="btn-submit">Save Student</button>
        <a href="{{ route('student.index') }}" class="btn-back">Back to List</a>
    </form>
</div>

</body>
</html>