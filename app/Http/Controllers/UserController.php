<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    //View Login Page
    public function loginPage() {
        return view('login');
    }

    //Log Out and return to home
    public function logOut(Request $request){
        auth()->logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/')->with('message', 'You have been logged out!');
    }

    //View register page
    public function registerPage(){
        return view('register');
    }

    //store user in db, login and return to home
    public function store(Request $request){
        $formFields = $request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required', 'email', Rule::unique('users', 'email')],
            'password'=>'required|confirmed|min:6',
            'phone'=>'required|numeric'
        ]);
    
        $formFields['password']= bcrypt($formFields['password']);

        $formFields['isAdmin']=false;
    
        $user = User::create($formFields);
    
        auth()->login($user);
    
        return redirect('/')->with('message', 'User created and logged in');
        
    }

    

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'=>['required', 'email'],
            'password'=>'required'
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
    
            return redirect('/')->with('message', 'Jste přihlášeni');
        }
        return back()->withErrors(['email'=>'Neplatné Přihlášení'])->onlyInput('email');
    }

    public function get(Request $request){
        return view('admin.employees', ['employees' => User::latest()->filter(request([ 'search']))->where('isAdmin','like', true)->get()]);
    }

    public function createEmployee(Request $request){
        return view('register', ['isAdmin'=>true]);
    }

    public function saveEmployee(Request $request, User $employee){
        //dd('bitch');
        $formFields = $request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required', 'email'],
            'phone'=>'required|numeric',
            'products'=>[],
            'orders'=>[],
            'finance'=>[],
            'employees'=>[]
        ]);
        
        //$formFields['password']= bcrypt($formFields['password']);

        //$formFields['isAdmin']= true;

        $array=['products', 'orders', 'finance', 'employees'];

        $isAllowed=[];

        foreach($array as $tab){
            if(!isset($formFields[$tab])){
                $isAllowed[$tab]=false;
                
            }
            else{$isAllowed[$tab]=true;
                unset($formFields[$tab]);}
        }

        
       
        $formFields['isAllowed']=json_encode($isAllowed);

        $employee->update($formFields);
    
        return redirect('/admin/employees/'.$employee->id)->with('message', 'employee updated');
    }

    public function storeEmployee(Request $request){
        $formFields = $request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required', 'email', Rule::unique('users', 'email')],
            'password'=>'required|confirmed|min:6',
            'phone'=>'required|numeric'
        ]);
    
        $formFields['password']= bcrypt($formFields['password']);

        $formFields['isAdmin']= true;
    
        $formFields['isAllowed']=json_encode([
            'products'=>false,
            'orders'=>false,
            'finance'=>false,
            'employees'=>true
        ]);

        $user = User::create($formFields);
    
        auth()->login($user);
    
        return redirect('/')->with('message', 'User created and logged in');
    }

    public function editEmployee($id){
        $user=User::find($id);
        if($user->isAdmin==true){
        return view('admin.employee', ['employee'=>$user]);}
        else {return redirect('/admin/employees');}
    }
}
