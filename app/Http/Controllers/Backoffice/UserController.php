<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\UserRequest;
use App\Models\Backoffice\Group;
use App\Models\Sso\User as UserSSo;
use App\Models\Backoffice\User;
use Illuminate\Http\Request;
use DataTables;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserSso::with(['groups', 'groupsBackoffice', 'employeeBiodata', 'studentBiodata', 'applicationUserRoles'])
                ->whereHas('groups', function ($query) {
                    $query->whereIn('grup_id', ['971fe72d-3597-45d3-ae58-a47bc21ab3f3', 'd957fd6c-6d2a-4127-9fde-81073b758aa5']);
                })
                ->whereHas('applicationUserRoles', function ($query) {
                    $query->where('aplikasi_peran_nama', '=', 'Backoffice');
                    $query->whereRelation('application', 'aplikasi_tautan', '=', request()->root());
                })
                ->when($request->pengguna_identitas, fn ($query, $search) => $query->where('pengguna_identitas', '=', $search))
                ->when($request->pengguna_nama, fn ($query, $search) => $query->where('pengguna_nama', 'ilike', '%' . $search . '%'))
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = "<div class='text-center'>";
                    if (PermissionAction(route('pengguna.show', $data->pengguna_id))) $btn .= "<a class='btn btn-sm btn-info text-white w-100 mb-1 waitme' href='" . route('pengguna.show', $data->pengguna_id) . "'><i class='fas fa-eye'></i></a>";
                    if (PermissionMenu()[0]->groups->filter(function ($item) {
                        return $item->grup_id == Auth::user()->groups[0]->grup_id;
                    })->flatten()[0]->pivot->grup_menu_item_ubah == 'ya') $btn .= "<a class='btn btn-sm btn-primary w-100 mb-1 waitme' href='" . route('pengguna.edit', $data->pengguna_id) . "'><i class='fas fa-edit'></i></a>";
                    if (PermissionMenu()[0]->groups->filter(function ($item) {
                        return $item->grup_id == Auth::user()->groups[0]->grup_id;
                    })->flatten()[0]->pivot->grup_menu_item_hapus == 'ya') $btn .= "<button type='submit' class='btn btn-sm btn-danger w-100 mb-1 destroy' id='" . route('pengguna.destroy', $data->pengguna_id) . "'><i class='fa fa-trash destroy' id='" . route('pengguna.destroy', $data->pengguna_id) . "'></i></button>";

                    if ($btn == "<div class='text-center'>") $btn .= '-';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $data = [
            'menus' => Menus::where('menu_nama', 'Sidebar')->first()->items()->whereRelation('groups', 'grup_menu_item_grup_id', '=', Auth::user()->groups[0]->grup_id)->get(),
            'groups' => Group::where('grup_id', '<>', 'a6d315d6-c86d-44c6-bc60-2f6f83c8ce2f')->pluck('grup_nama', 'grup_id'),
        ];

        return view('backoffice.user.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserSso $user)
    {
        $data = [
            'menus' => Menus::where('menu_nama', 'Sidebar')->first()->items()->whereRelation('groups', 'grup_menu_item_grup_id', '=', Auth::user()->groups[0]->grup_id)->get(),
            'user' => $user,
        ];

        return view('backoffice.user.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'menus' => Menus::where('menu_nama', 'Sidebar')->first()->items()->whereRelation('groups', 'grup_menu_item_grup_id', '=', Auth::user()->groups[0]->grup_id)->get(),
            'groups' => Group::where('grup_id', '<>', 'a6d315d6-c86d-44c6-bc60-2f6f83c8ce2f')->pluck('grup_nama', 'grup_id'),
            'user' => User::find($id),
            'id' => $id,
        ];

        return view('backoffice.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, UserSso $user)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $user = User::updateOrCreate(['pengguna_id' => $user->pengguna_id]);
            $user->groups()->sync([$data['grup_id'] => ['pengguna_grup_id' => Str::uuid()]]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        LogActivy(Auth::user()->pengguna_id, 'Mengubah data pengguna', json_encode($data), json_encode($user));
        return redirect()->route('pengguna.index')->with('success', 'Data berhasil ditambahkan!');
    }
}
