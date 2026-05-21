<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
       public function index(Request $request)
    {
        $query = Student::query();

        
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $exactTerm = trim($request->search);

            $query->where(function ($q) use ($searchTerm, $exactTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                  ->orWhere('email', 'LIKE', $searchTerm);

                if (is_numeric($exactTerm)) {
                    $q->orWhere('age', $exactTerm)
                      ->orWhere('score', $exactTerm);
                }

                $lowerTerm = strtolower($exactTerm);
                if ($lowerTerm === 'm' || $lowerTerm === 'male') {
                    $q->orWhere('gender', 'M');
                } elseif ($lowerTerm === 'f' || $lowerTerm === 'female') {
                    $q->orWhere('gender', 'F');
                }
            });
        }

       
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

       
        if ($request->has('age') && $request->age != '') {
            $query->where('age', $request->age);
        }

     
        if ($request->has('min_score') && $request->min_score != '') {
            $query->where('score', '=', $request->min_score);
        }

        $students = $query->orderBy('id', 'desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('students.table_rows', compact('students'))->render(),
                'pagination' => (string) $students->withQueryString()->links()
            ]);
        }

        return view('students.index', compact('students'));
    }

      public function create()
    {
        return view('students.create');
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email',
            'age'           => 'required|numeric',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:M,F',
            'score'         => 'required|numeric',
        ]);

        $validated['user_id'] = auth()->id() ?? 1; 

        $student = Student::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Student added successfully!', 'student' => $student]);
        }

        return redirect()->route('student.index')->with('success', 'Student added successfully!');
    }

    public function edit(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        if ($request->ajax() || $request->has('ajax') || $request->wantsJson()) {
            return response()->json($student);
        }

        return view('students.edit', compact('student'));
    }

   
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email,' . $id,
            'age'           => 'required|numeric',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:M,F',
            'score'         => 'required|numeric',
        ]);

        if (!isset($student->user_id)) {
            $validated['user_id'] = auth()->id() ?? 1;
        }

        $student->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Student updated successfully!']);
        }

        return redirect()->route('student.index')->with('success', 'Student updated successfully!');
    }

    // Delete Student via AJAX
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['success' => 'Student deleted successfully!']);
    }

    // Quick Update Function via AJAX Modal
    public function quickUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'age'   => 'required|integer|min:1',
        ]);

        $student = Student::findOrFail($id);
        
        $student->update([
            'name'  => $request->name,
            'email' => $request->email,
            'age'   => $request->age,
        ]);

        return response()->json(['success' => 'Student basic info updated successfully!']);
    }
}
    /*public function adddata()
    {
       $item = new Student();
       $item->name = 'John Doe';
         $item->email = 'towfiq@example.com';
         $item->age = 25;
         $item->date_of_birth = '1998-01-01';
         $item->gender = 'm';
         $item->save();

    
    
    
    
    
    
    
    
    /* DB::table('students')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'age' => 25,
            'date_of_birth' => '1998-01-01',
            'gender' => 'm'
        ]);*/

     //   return 'Data added successfully';
    //}

    /*public function getData()
    {
      
      $items = Student::select('id', 'name')
      ->find(12);
        return $items; 
    }

public function updateData()
    {
        $items = DB::table('students')->get();  
    }


    public function deleteData()
    {
        $items = DB::table('students')->get();
         DB::table('students')->where('id', 1)->delete();
         return 'Data deleted successfully';
    }
    
    public function whereCondition()
    {
    /*$item = Student::where('score', '>=', 50)
       ->where(function($query) {
               $query->where('age', '<', 10)
                     ->orWhere('age', '>', 20); // এখানে 'w' বড় হাতের (W) করুন
          })
          ->get();
*/
//$items=Student::whereBetween('age', [18, 25])->get();    


  //   return $items;
   // }

//}

/*class StudentController extends Controller
{
    //
    protected $name;
    protected $email;
    protected $id;

    public function __construct()
    {
        $this->name = "md Towfiq Bin Hasan";
    }
    public function index()
    {
        return 'Hello from controller';
    }
    public function aboutus()
    {
        return 'code  with Towfiq bin hasan';
    }
public function aboutus($id, $name)
    {
        return  view ('aboutus')->with('id', $id)->with('name', $name);
    }
    public function aboutus2($id, $name)
    {
        return  'hello ';
    }


}
*/
