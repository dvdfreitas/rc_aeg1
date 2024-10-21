<?php

namespace App\Console\Commands;

use App\Models\SchoolClass;
use App\Models\SchoolClassStudent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCSV extends Command
{
    /**
     * 
     */
    public $validation = [
        'projects' => [
            'mandatory' => ['name', 'slug'],
            'optional' => ['image'],
        ],
        'teachers' => [
            'mandatory' => ['name', 'email']
        ],
        'school_classes' => [
            'mandatory' => ['name', 'year', 'class_year'],
        ],
        'school_class_teacher' => [
            'mandatory' => ['year', 'name', 'email'],
        ],
        'subjects' => [
            'mandatory' => ['name'],
        ],
        'students' => [
            'mandatory' => ['id', 'name'],
        ],
    ];


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importCSV {file} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('file');                
        $file = fopen($filename, "r");

        if ($this->option('model'))
            $model = $this->option('model');
        else
            $model = pathinfo($filename, PATHINFO_FILENAME);
            
        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        
        if (array_key_exists($model, $this->validation)) {
            $validHeader = $this->validateHeader($model, $header);
            if ($validHeader) {
                $this->info("Header is valid");                
            }
            else {
                $this->error("Header is not valid");
                return Command::FAILURE;
            }            
            $this->processFile($file, $model, $header);
        }
        else
            return Command::FAILURE;        
        
        fclose($file);


        return Command::SUCCESS;
    }

    public function processFile($file, $model, $header) {
        while(($line_csv = fgets($file)) !== false)  {
            
            $record = [];

            $line = str_getcsv($line_csv, ";");
            
            foreach ($header as $key => $column) {         
                $record[$header[$key]] = $line[$key];
                if ($record[$header[$key]] == "")
                    $record[$header[$key]] = null;
            }
            
            if ($model == "teachers")
                $this->insertTeacher($record);
            elseif ($model == "school_classes")
                $this->insertSchoolClass($record);
            elseif ($model == "school_class_teacher") 
                $this->insertSchoolClassTeacher($record);
            elseif ($model == "students")
                $this->insertStudent($record);
            else {
                if (!DB::table($model)->insertOrIgnore($record))
                    $this->info("Insert in $model failed");
            }
                
        }    
    }
    
    function insertStudent($record) {
        
        $student_id = $record['id'];
        $record['email'] = "a" . $student_id . "@aeg1.pt";
                
        $student_inserted = DB::table('students')->insertOrIgnore([
            'id' => $student_id,
            'name' => $record['name'],
            'email' => $record['email']
        ]);

        if (!$student_inserted)
            $this->info("Student " . $record['name'] . " already exists.");

        if (array_key_exists("school_class_name", $record) && array_key_exists("year", $record)) {
                        
            $school_class = SchoolClass::where('name', $record['school_class_name'])->where('year', $record['year'])->get();
            if ($school_class->isEmpty()) {
                $this->error($record['school_class_name'] . " (" . $record['year'] . ") doesn't exist.");
                return;
            }

            $student = Student::find($student_id);
         
            if (!$student_inserted) {
                $old_school_class = $student->schoolClass($record['year']);                
                
                if ($old_school_class != null) {               
                    DB::table('school_class_student')->where('student_id', $student_id)->where('school_class_id', $old_school_class->id)->delete();
                    $this->info("Student " . $record['name'] . " removed from " . $old_school_class->name . " (" . $old_school_class->year . ")");
                }
            }
        
            DB::table('school_class_student')->insertGetId([
                'school_class_id' => $school_class->first()->id,
                'student_id' => $student_id
            ]);        
        }        
    }

    function insertSchoolClassTeacher($record) { 
        $user = User::where('email', $record['email'])->get();        
        if ($user->isEmpty()) 
            $this->error($record['email'] . " is not an user.");
        else {            
            $teacher = DB::table('teachers')->where('user_id', $user->first()->id)->get();
            if ($teacher->isEmpty())
                $this->error($record['email'] . " is not a teacher.");
            else {                
                $school_class = SchoolClass::where('name', $record['name'])->where('year', $record['year'])->get();
                if ($school_class->isEmpty()) {
                    $this->error($record['name'] . " (" . $record['year'] . ") doesn't exist.");
                } else {
                    $school_class_id = $school_class->first()->id;
                    $teacher_id = $user->first()->id;
                    $school_class_teacher = DB::table('school_class_teacher')->where('school_class_id', $school_class_id)->where('teacher_id', $teacher_id)->get();
                    if ($school_class_teacher->isEmpty())
                        DB::table('school_class_teacher')->insert([
                            'school_class_id' => $school_class_id,
                            'teacher_id' => $teacher_id
                        ]);
                    else {
                        $this->error($record['name'] . " (" . $record['year'] . ") already has " . $record['email'] . " as a teacher.");
                    }
                }
            }
        }
    }

    function insertTeacher($record) {        
        $user = User::where('email', $record['email'])->get();
        $user_id = null;
        if ($user->isEmpty()) 
            $user_id = DB::table('users')->insertGetId([
                'name' => $record['name'],
                'email' => $record['email'],
            ]);
        else {            
            $user_id = $user->first()->id;            
        }

        $teacher = DB::table('teachers')->where('user_id', $user_id)->get();

        if ($teacher->isEmpty())
            DB::table('teachers')->insert([
                'user_id' => $user_id,
                'code' => $record['code']
            ]);
    }

    function insertSchoolClass($record) {
        $school_class = DB::table('school_classes')->where('name', $record['name'])->where('year', $record['year'])->where('class_year', $record['class_year'])->get();
        if ($school_class->isEmpty())
            DB::table('school_classes')->insert([
                'name' => $record['name'],
                'year' => $record['year'],
                'class_year' => $record['class_year'],                
            ]);
    }

    /**
     * 
     */
    public function verifyExistence($mandatory, $header) {
        $result = true;        
        foreach ($mandatory as $field) {
            if (!in_array($field, $header)) {
                $result = false;
                $this->error($field . " is a required field and is missing in the CSV file.");
            }
        }
        return $result;
    }

    public function validTable($table) {
        if (!array_key_exists($table, $this->validation)) {
            $this->error("Table " . $table . " doesn't exist.");
            return false;
        }
        return true;
    }


    public function validateHeader($table, $header)
    {                
        $validHeader = true;
        $mandatory = $this->validation[$table]['mandatory'];
        $validHeader = $this->verifyExistence($mandatory, $header);
                             
        return $validHeader;
    }    
}
