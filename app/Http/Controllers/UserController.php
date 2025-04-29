<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($search = $request->input('search')){
            $users=User::where('name','like','%'.$search.'%')
                ->orWhere('email','like','%'.$search.'%')
                ->orWhere('phone','like','%'.$search.'%')
                ->orderBy('id','desc')->get();
        }else{
            $users=User::orderBy('id','desc')->get();
        }
        return view('users.index',[
            'users'=>$users,
            'search'=>$search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $agents=Agent::where("is_affected_to_agency",null)->get();
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        $roles=Role::all();
        return view('users.create',[
            'agents'=>$agents,
            'roles'=>$roles,
            'provinces'=>$provinces,
        ]);
    }

    public function profile(){
        $user=User::where('id',auth()->user()->id)->first();
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        $countClient=auth()->user()->clients()->count();
        return view('users.profile',[
            'user'=>$user,
            'provinces'=>$provinces,
            'countClient'=>$countClient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=User::create([
            'name' => $request->name,
            'agent_id' => $request->agent_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'province' => $request->province,
            'commune' => $request->commune,
            'colline' => $request->colline,
            'zone' => $request->zone,
            'password' => $request->password,
            'address' => $request->address,
        ]);
        Agent::where('id',$request->agent_id)->update([
            'is_affected_to_agency' => $user->id,
        ]);
        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $request->role,
        ]);
         return view('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agents=Agent::where("is_affected_to_agency",null)->get();
        $selectAgent=User::where('id',$id)->first() != null ? User::where('id',$id)->first()->agent_id : new stdClass();
        $provinces = DB::select("SELECT distinct region from burundizipcodes");
        $roles=Role::all();
        $userRole=RoleUser::where("user_id",$id)->first()->role_id;
        return view('users.edit',[
            'agents'=>$agents,
            'roles'=>$roles,
            'user'=>User::where('id',$id)->first()->id,
            'role_user'=>$userRole,
            'selectAgent'=> !empty($selectAgent) ? $selectAgent : 0,
            'provinces'=>$provinces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=User::find($id);
        if ($user) {
            if( $request->password != null){
                $user->update([
                    'name' => $request->name,
                    'agent_id' => $request->agent_id,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'province' => $request->province,
                    'commune' => $request->commune,
                    'colline' => $request->colline,
                    'zone' => $request->zone,
                    'password' => Hash::make($request->password),
                    'address' => $request->address,
                ]);
            }else{
                $user->update([
                    'name' => $request->name,
                    'agent_id' => $request->agent_id,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'province' => $request->province,
                    'commune' => $request->commune,
                    'colline' => $request->colline,
                    'zone' => $request->zone,
                    'password' => $user->password,
                    'address' => $request->address,
                ]);
            }
            RoleUser::where('user_id', $id)->update([
                'role_id' => $request->role,
            ]);
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find($id);
        if ($user) {
            $user->delete();
            RoleUser::where('user_id', $id)->delete(); // Delete associated roles
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }
}
