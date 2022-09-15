<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersIndex extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        $users = User::where('name', 'Like', '%' . $this->search . '%')
                            ->orwhere('email', 'Like', '%' . $this->search . '%')
                            ->paginate(10);
        
        return view('livewire.admin.users-index', compact('users'));
    }
}
